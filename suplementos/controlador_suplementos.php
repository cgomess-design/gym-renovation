<?php
// suplementos/controlador_suplementos.php - Controlador puro para Facturación de Suplementos (POS) y Servicios Tercerizados

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Protección de acceso
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit;
}

// Conexión a la base de datos
require_once dirname(__DIR__) . '/DB/conexion.php';

// Variables de estado
$mensaje_exito = '';
$mensaje_error = '';

if (!empty($_SESSION['mensaje_exito'])) {
    $mensaje_exito = $_SESSION['mensaje_exito'];
    unset($_SESSION['mensaje_exito']);
}
if (!empty($_SESSION['mensaje_error'])) {
    $mensaje_error = $_SESSION['mensaje_error'];
    unset($_SESSION['mensaje_error']);
}

// Variables de sesión del usuario logueado
$usuario_activo_id     = $_SESSION['usuario_id'] ?? 1;
$usuario_activo_nombre = $_SESSION['nombre_completo'] ?? 'Usuario';
$usuario_activo_rol    = $_SESSION['rol'] ?? 'ADMINISTRADOR';
$usuario_activo_suc    = $_SESSION['sucursal'] ?? 'Central';
$iniciales_activo      = strtoupper(substr($usuario_activo_nombre, 0, 1));

// ==============================================================================
// INICIALIZACIÓN AUTOMÁTICA DE TABLAS DE SUPLEMENTOS Y COLUMNAS DE REFERIDOS
// ==============================================================================
if (isset($pdo) && $pdo !== null) {
    try {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `suplementos_catalogo` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `codigo` VARCHAR(50) NOT NULL UNIQUE,
                `nombre` VARCHAR(150) NOT NULL,
                `categoria` ENUM('PROTEINAS', 'CREATINAS', 'AMINOACIDOS', 'PRE_WORKOUT', 'BEBIDAS', 'ACCESORIOS') NOT NULL,
                `precio` DECIMAL(10,2) NOT NULL,
                `stock` INT NOT NULL DEFAULT 0,
                `descripcion` VARCHAR(255) NULL,
                `estado` ENUM('ACTIVO', 'INACTIVO') DEFAULT 'ACTIVO',
                `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `suplementos_ventas` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `numero_factura` VARCHAR(50) NOT NULL UNIQUE,
                `cliente_id` INT NULL,
                `sucursal_id` INT NOT NULL,
                `vendedor_id` INT NOT NULL,
                `subtotal` DECIMAL(10,2) NOT NULL,
                `monto_bono_usado` DECIMAL(10,2) DEFAULT 0.00,
                `total_venta` DECIMAL(10,2) NOT NULL,
                `metodo_pago` ENUM('EFECTIVO', 'TARJETA', 'TRANSFERENCIA', 'BONO_REFERIDO') DEFAULT 'EFECTIVO',
                `fecha_venta` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `suplementos_ventas_detalle` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `venta_id` INT NOT NULL,
                `producto_id` INT NOT NULL,
                `cantidad` INT NOT NULL,
                `precio_unitario` DECIMAL(10,2) NOT NULL,
                `subtotal` DECIMAL(10,2) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        // Columnas extendidas en referidos para trazabilidad de pagos y canjes
        $colsCheck = $pdo->query("SHOW COLUMNS FROM referidos LIKE 'metodo_entrega'")->fetchAll();
        if (empty($colsCheck)) {
            $pdo->exec("ALTER TABLE `referidos` 
                ADD COLUMN `metodo_entrega` VARCHAR(50) NULL AFTER `estado_bono`,
                ADD COLUMN `fecha_entrega` DATETIME NULL AFTER `metodo_entrega`,
                ADD COLUMN `comprobante_egreso` VARCHAR(60) NULL AFTER `fecha_entrega`,
                ADD COLUMN `recepcionista_entrega_id` INT NULL AFTER `comprobante_egreso`,
                ADD COLUMN `observaciones` TEXT NULL AFTER `recepcionista_entrega_id`");
        }

        // Semilla de productos en el catálogo si la tabla está vacía
        $countProd = $pdo->query("SELECT COUNT(*) FROM suplementos_catalogo")->fetchColumn();
        if ($countProd == 0) {
            $stmtSeed = $pdo->prepare("
                INSERT INTO suplementos_catalogo (codigo, nombre, categoria, precio, stock, descripcion) VALUES
                ('PROT-ISO-01', 'Proteína Iso Whey 5 lbs (Vainilla Francesa)', 'PROTEINAS', 450.00, 25, 'Proteína aislada de suero 25g de proteína pura por servicio.'),
                ('PROT-WHE-02', 'Gold Standard 100% Whey 5 lbs (Doble Chocolate)', 'PROTEINAS', 420.00, 30, 'La proteína de suero más reconocida a nivel mundial.'),
                ('CREA-PUR-01', 'Creatina Monohidratada Creapure 300g (Sin Sabor)', 'CREATINAS', 280.00, 40, '100% pureza alemana para fuerza explosiva y recuperación.'),
                ('PRE-C4-01',   'Pre-Workout C4 Original Explosive Energy (Blue Raz)', 'PRE_WORKOUT', 320.00, 20, 'Fórmula pre-entrenamiento con beta-alanina y cafeína.'),
                ('BCAA-XT-01',  'BCAA 2:1:1 Aminoácidos Esenciales 400g (Sandía)', 'AMINOACIDOS', 220.00, 18, 'Recuperación muscular intra y post-entreno.'),
                ('BEB-GAT-01',  'Bebida Isotónica Gatorade Frutas 600ml', 'BEBIDAS', 15.00, 100, 'Rehidratación inmediata y reposición de electrolitos.'),
                ('BEB-RED-02',  'Bebida Energizante Red Bull Energy Drink 250ml', 'BEBIDAS', 22.00, 60, 'Revitaliza cuerpo y mente antes del entrenamiento.'),
                ('ACC-SHK-01',  'Shaker Pro Mezclador 700ml con Filtro Renovation', 'ACCESORIOS', 65.00, 50, 'Vaso batidor a prueba de fugas libre de BPA.'),
                ('ACC-STR-02',  'Correas Straps Levantamiento Pesas Gym Heavy Duty', 'ACCESORIOS', 85.00, 35, 'Agarre reforzado para peso muerto y jalones pesados.')
            ");
            $stmtSeed->execute();
        }
    } catch (Exception $e) {
        // Fallback silencioso
    }
}

// ==============================================================================
// PROCESAMIENTO DE ACCIONES POST (VENTAS POS, NUEVO PRODUCTO, ACTUALIZACIÓN)
// ==============================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($pdo) && $pdo !== null) {
    $accion = trim($_POST['accion'] ?? '');

    // --------------------------------------------------------------------------
    // 1. REGISTRAR VENTA EN PUNTO DE VENTA (POS)
    // --------------------------------------------------------------------------
    if ($accion === 'vender_pos') {
        $cliente_id       = !empty($_POST['cliente_id']) ? intval($_POST['cliente_id']) : null;
        $sucursal_id      = intval($_POST['sucursal_id'] ?? 1);
        $metodo_pago      = trim($_POST['metodo_pago'] ?? 'EFECTIVO');
        $monto_bono_usado = floatval($_POST['monto_bono_usado'] ?? 0);
        $productos_json   = trim($_POST['productos_json'] ?? '');

        $items = json_decode($productos_json, true);

        if (empty($items) || !is_array($items)) {
            $mensaje_error = 'El carrito de compras está vacío. Agrega al menos un suplemento para facturar.';
        } else {
            try {
                $pdo->beginTransaction();

                // Calcular subtotal real y verificar stock
                $subtotal_calculado = 0;
                foreach ($items as $item) {
                    $prod_id  = intval($item['id']);
                    $cantidad = intval($item['cantidad']);

                    $stmtCheck = $pdo->prepare("SELECT stock, precio, nombre FROM suplementos_catalogo WHERE id = :id FOR UPDATE");
                    $stmtCheck->execute([':id' => $prod_id]);
                    $prodData = $stmtCheck->fetch();

                    if (!$prodData) {
                        throw new Exception("Producto no encontrado (ID: {$prod_id}).");
                    }
                    if ($prodData['stock'] < $cantidad) {
                        throw new Exception("Stock insuficiente para '{$prodData['nombre']}'. Disponibles: {$prodData['stock']}, Solicitados: {$cantidad}.");
                    }

                    $subtotal_calculado += ($prodData['precio'] * $cantidad);
                }

                // Ajustar bono si aplica
                $bono_aplicable = 0;
                if ($monto_bono_usado > 0 && $cliente_id > 0) {
                    $stmtBono = $pdo->prepare("
                        SELECT SUM(bono_otorgado) as total_bono 
                        FROM referidos 
                        WHERE cliente_referidor_id = :cid AND estado_bono = 'PENDIENTE'
                    ");
                    $stmtBono->execute([':cid' => $cliente_id]);
                    $bonoDisponible = floatval($stmtBono->fetchColumn() ?: 0);

                    $bono_aplicable = min($bonoDisponible, $monto_bono_usado, $subtotal_calculado);
                }

                $total_venta = max(0, $subtotal_calculado - $bono_aplicable);

                // Determinar método de pago si fue cubierto 100% por bono
                if ($total_venta == 0 && $bono_aplicable > 0) {
                    $metodo_pago = 'BONO_REFERIDO';
                }

                // Generar factura única para suplementos
                $numFactura = 'FAC-SUP-' . date('Y') . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

                // Insertar cabecera de venta
                $stmtVenta = $pdo->prepare("
                    INSERT INTO suplementos_ventas 
                    (numero_factura, cliente_id, sucursal_id, vendedor_id, subtotal, monto_bono_usado, total_venta, metodo_pago, fecha_venta)
                    VALUES 
                    (:num, :cli, :suc, :ven, :sub, :bono, :tot, :metodo, NOW())
                ");
                $stmtVenta->execute([
                    ':num'    => $numFactura,
                    ':cli'    => $cliente_id,
                    ':suc'    => $sucursal_id,
                    ':ven'    => $usuario_activo_id,
                    ':sub'    => $subtotal_calculado,
                    ':bono'   => $bono_aplicable,
                    ':tot'    => $total_venta,
                    ':metodo' => $metodo_pago
                ]);
                $venta_id = $pdo->lastInsertId();

                // Insertar detalles y descontar stock
                $stmtDet = $pdo->prepare("
                    INSERT INTO suplementos_ventas_detalle (venta_id, producto_id, cantidad, precio_unitario, subtotal)
                    VALUES (:vid, :pid, :cant, :precio, :sub)
                ");
                $stmtStock = $pdo->prepare("
                    UPDATE suplementos_catalogo SET stock = stock - :cant WHERE id = :pid
                ");

                foreach ($items as $item) {
                    $prod_id  = intval($item['id']);
                    $cantidad = intval($item['cantidad']);
                    $precio   = floatval($item['precio']);
                    $subLinea = $precio * $cantidad;

                    $stmtDet->execute([
                        ':vid'    => $venta_id,
                        ':pid'    => $prod_id,
                        ':cant'   => $cantidad,
                        ':precio' => $precio,
                        ':sub'    => $subLinea
                    ]);

                    $stmtStock->execute([
                        ':cant' => $cantidad,
                        ':pid'  => $prod_id
                    ]);
                }

                // Si se usó bono de referidos, actualizar registros en referidos
                if ($bono_aplicable > 0 && $cliente_id > 0) {
                    $stmtBonoRows = $pdo->prepare("
                        SELECT id, bono_otorgado 
                        FROM referidos 
                        WHERE cliente_referidor_id = :cid AND estado_bono = 'PENDIENTE'
                        ORDER BY id ASC
                    ");
                    $stmtBonoRows->execute([':cid' => $cliente_id]);
                    $bonosCliente = $stmtBonoRows->fetchAll();

                    $restantePorCubrir = $bono_aplicable;
                    foreach ($bonosCliente as $bRow) {
                        if ($restantePorCubrir <= 0) break;

                        $stmtUpdBono = $pdo->prepare("
                            UPDATE referidos 
                            SET estado_bono = 'RECLAMADO',
                                metodo_entrega = 'CANJE_SUPLEMENTOS',
                                fecha_entrega = NOW(),
                                comprobante_egreso = :fac,
                                recepcionista_entrega_id = :rec,
                                observaciones = 'Canjeado en tienda de suplementos mediante factura de suplementos'
                            WHERE id = :bid
                        ");
                        $stmtUpdBono->execute([
                            ':fac' => $numFactura,
                            ':rec' => $usuario_activo_id,
                            ':bid' => $bRow['id']
                        ]);

                        $restantePorCubrir -= floatval($bRow['bono_otorgado']);
                    }
                }

                $pdo->commit();
                $mensaje_exito = "Factura de Suplementos emitida con éxito: <strong>{$numFactura}</strong>. Total cobrado: <strong>Q" . number_format($total_venta, 2) . "</strong>" . ($bono_aplicable > 0 ? " (Bono aplicado: Q" . number_format($bono_aplicable, 2) . ")" : "");
            } catch (Exception $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                $mensaje_error = 'Error al procesar la venta en el POS: ' . $e->getMessage();
            }
        }
    }

    // --------------------------------------------------------------------------
    // 2. CREAR NUEVO PRODUCTO EN CATÁLOGO
    // --------------------------------------------------------------------------
    elseif ($accion === 'crear_producto') {
        $codigo      = trim($_POST['codigo'] ?? '');
        $nombre      = trim($_POST['nombre'] ?? '');
        $categoria   = trim($_POST['categoria'] ?? 'PROTEINAS');
        $precio      = floatval($_POST['precio'] ?? 0);
        $stock       = intval($_POST['stock'] ?? 0);
        $descripcion = trim($_POST['descripcion'] ?? '');

        if (empty($codigo) || empty($nombre) || $precio <= 0) {
            $mensaje_error = 'Por favor completa el código, nombre y un precio válido mayor a 0.';
        } else {
            try {
                $stmtIns = $pdo->prepare("
                    INSERT INTO suplementos_catalogo (codigo, nombre, categoria, precio, stock, descripcion, estado)
                    VALUES (:cod, :nom, :cat, :pre, :stk, :des, 'ACTIVO')
                ");
                $stmtIns->execute([
                    ':cod' => $codigo,
                    ':nom' => $nombre,
                    ':cat' => $categoria,
                    ':pre' => $precio,
                    ':stk' => $stock,
                    ':des' => $descripcion
                ]);
                $mensaje_exito = "Producto <strong>{$nombre}</strong> registrado con éxito en el catálogo.";
            } catch (PDOException $e) {
                $mensaje_error = 'Error al guardar el producto: ' . ($e->getCode() == 23000 ? 'El código ya existe.' : $e->getMessage());
            }
        }
    }

    // --------------------------------------------------------------------------
    // 3. EDITAR PRODUCTO / AJUSTAR STOCK
    // --------------------------------------------------------------------------
    elseif ($accion === 'editar_producto') {
        $id          = intval($_POST['id'] ?? 0);
        $nombre      = trim($_POST['nombre'] ?? '');
        $categoria   = trim($_POST['categoria'] ?? 'PROTEINAS');
        $precio      = floatval($_POST['precio'] ?? 0);
        $stock       = intval($_POST['stock'] ?? 0);
        $estado      = trim($_POST['estado'] ?? 'ACTIVO');
        $descripcion = trim($_POST['descripcion'] ?? '');

        if ($id <= 0 || empty($nombre) || $precio <= 0) {
            $mensaje_error = 'Datos inválidos para actualizar el producto.';
        } else {
            try {
                $stmtUpd = $pdo->prepare("
                    UPDATE suplementos_catalogo 
                    SET nombre = :nom, categoria = :cat, precio = :pre, stock = :stk, estado = :est, descripcion = :des
                    WHERE id = :id
                ");
                $stmtUpd->execute([
                    ':nom' => $nombre,
                    ':cat' => $categoria,
                    ':pre' => $precio,
                    ':stk' => $stock,
                    ':est' => $estado,
                    ':des' => $descripcion,
                    ':id'  => $id
                ]);
                $mensaje_exito = 'Producto actualizado exitosamente.';
            } catch (PDOException $e) {
                $mensaje_error = 'Error al actualizar el producto: ' . $e->getMessage();
            }
        }
    }

    // Si el script fue ejecutado directamente por el formulario, redirigir a index.php conservando el mensaje
    $script_actual = basename($_SERVER['PHP_SELF'] ?? '');
    if ($script_actual === 'controlador_suplementos.php') {
        if (!empty($mensaje_exito)) $_SESSION['mensaje_exito'] = $mensaje_exito;
        if (!empty($mensaje_error)) $_SESSION['mensaje_error'] = $mensaje_error;
        header('Location: index.php');
        exit;
    }
}

// ==============================================================================
// CONSULTAS PARA LA VISTA (CATÁLOGO, CLIENTES CON BONO, FACTURAS, KPIS)
// ==============================================================================
$catalogo_productos = [];
$clientes_pos       = [];
$sucursales_pos     = [];
$ventas_historial   = [];

$kpi_ventas_hoy     = 0.00;
$kpi_facturas_hoy   = 0;
$kpi_stock_bajo     = 0;
$kpi_bonos_canjeados= 0.00;

if (isset($pdo) && $pdo !== null) {
    try {
        // Catálogo de productos activos
        $stmtCat = $pdo->query("SELECT * FROM suplementos_catalogo WHERE estado = 'ACTIVO' ORDER BY categoria ASC, nombre ASC");
        $catalogo_productos = $stmtCat->fetchAll();

        // Clientes con cálculo de bonos por referidos pendientes
        $stmtCli = $pdo->query("
            SELECT u.id, u.nombre, u.apellido, u.email,
                   COALESCE(SUM(CASE WHEN r.estado_bono = 'PENDIENTE' THEN r.bono_otorgado ELSE 0 END), 0) as bono_disponible
            FROM usuarios u
            LEFT JOIN referidos r ON u.id = r.cliente_referidor_id AND r.estado_bono = 'PENDIENTE'
            WHERE u.rol_id = 9 OR u.tipo_persona = 'CLIENTE'
            GROUP BY u.id, u.nombre, u.apellido, u.email
            ORDER BY u.nombre ASC, u.apellido ASC
        ");
        $clientes_pos = $stmtCli->fetchAll();

        // Sucursales
        $stmtSuc = $pdo->query("SELECT id, nombre FROM sucursales ORDER BY id ASC");
        $sucursales_pos = $stmtSuc->fetchAll();

        // Historial de ventas / facturas de suplementos
        $stmtVentas = $pdo->query("
            SELECT sv.*, 
                   s.nombre as sucursal_nombre,
                   uc.nombre as cliente_nombre, uc.apellido as cliente_apellido,
                   uv.nombre as vendedor_nombre, uv.apellido as vendedor_apellido
            FROM suplementos_ventas sv
            LEFT JOIN sucursales s ON sv.sucursal_id = s.id
            LEFT JOIN usuarios uc ON sv.cliente_id = uc.id
            LEFT JOIN usuarios uv ON sv.vendedor_id = uv.id
            ORDER BY sv.id DESC
            LIMIT 50
        ");
        $ventas_historial = $stmtVentas->fetchAll();

        // Métricas KPI
        $stmtKpi1 = $pdo->query("SELECT COALESCE(SUM(total_venta), 0) FROM suplementos_ventas WHERE DATE(fecha_venta) = CURDATE()");
        $kpi_ventas_hoy = floatval($stmtKpi1->fetchColumn());

        $stmtKpi2 = $pdo->query("SELECT COUNT(*) FROM suplementos_ventas WHERE DATE(fecha_venta) = CURDATE()");
        $kpi_facturas_hoy = intval($stmtKpi2->fetchColumn());

        $stmtKpi3 = $pdo->query("SELECT COUNT(*) FROM suplementos_catalogo WHERE stock <= 5 AND estado = 'ACTIVO'");
        $kpi_stock_bajo = intval($stmtKpi3->fetchColumn());

        $stmtKpi4 = $pdo->query("SELECT COALESCE(SUM(monto_bono_usado), 0) FROM suplementos_ventas");
        $kpi_bonos_canjeados = floatval($stmtKpi4->fetchColumn());

    } catch (Exception $e) {
        $mensaje_error = 'Error al cargar datos del módulo: ' . $e->getMessage();
    }
}
