<?php
// referidos/controlador_referidos.php - Controlador puro para Gestión y Entrega de Bonos por Referidos

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
// VERIFICAR Y CREAR/ADAPTAR TABLA REFERIDOS
// ==============================================================================
if (isset($pdo) && $pdo !== null) {
    try {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `referidos` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `cliente_referidor_id` INT NOT NULL,
                `cliente_referido_id` INT NOT NULL UNIQUE,
                `membresia_id` INT NOT NULL,
                `bono_otorgado` DECIMAL(10,2) NOT NULL,
                `estado_bono` ENUM('PENDIENTE', 'APLICADO', 'RECLAMADO') DEFAULT 'PENDIENTE',
                `metodo_entrega` VARCHAR(50) NULL,
                `fecha_entrega` DATETIME NULL,
                `comprobante_egreso` VARCHAR(60) NULL,
                `recepcionista_entrega_id` INT NULL,
                `observaciones` TEXT NULL,
                `fecha_referido` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT `fk_referidor_gym` FOREIGN KEY (`cliente_referidor_id`) REFERENCES `usuarios` (`id`),
                CONSTRAINT `fk_referido_gym` FOREIGN KEY (`cliente_referido_id`) REFERENCES `usuarios` (`id`),
                CONSTRAINT `fk_referido_plan_gym` FOREIGN KEY (`membresia_id`) REFERENCES `membresias` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        // Columnas adicionales de trazabilidad si la tabla ya existía
        $colsCheck = $pdo->query("SHOW COLUMNS FROM referidos LIKE 'metodo_entrega'")->fetchAll();
        if (empty($colsCheck)) {
            $pdo->exec("ALTER TABLE `referidos` 
                ADD COLUMN `metodo_entrega` VARCHAR(50) NULL AFTER `estado_bono`,
                ADD COLUMN `fecha_entrega` DATETIME NULL AFTER `metodo_entrega`,
                ADD COLUMN `comprobante_egreso` VARCHAR(60) NULL AFTER `fecha_entrega`,
                ADD COLUMN `recepcionista_entrega_id` INT NULL AFTER `comprobante_egreso`,
                ADD COLUMN `observaciones` TEXT NULL AFTER `recepcionista_entrega_id`");
        }

        // Semilla de prueba si no existen registros
        $countRef = $pdo->query("SELECT COUNT(*) FROM referidos")->fetchColumn();
        if ($countRef == 0) {
            // Verificar si existen clientes para referir
            $cliCheck = $pdo->query("SELECT id FROM usuarios WHERE rol_id = 9 LIMIT 2")->fetchAll();
            if (count($cliCheck) >= 1) {
                // Registrar un referido demostrativo
                $referidor = $cliCheck[0]['id'];
                $pdo->exec("
                    INSERT INTO referidos 
                    (cliente_referidor_id, cliente_referido_id, membresia_id, bono_otorgado, estado_bono, fecha_referido)
                    VALUES 
                    ({$referidor}, {$referidor}, 2, 150.00, 'PENDIENTE', NOW())
                    ON DUPLICATE KEY UPDATE bono_otorgado=150.00
                ");
            }
        }
    } catch (Exception $e) {
        // Fallback silencioso
    }
}

// ==============================================================================
// PROCESAMIENTO DE ACCIONES POST (ENTREGA DE DINERO, REGISTRO MANUAL)
// ==============================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($pdo) && $pdo !== null) {
    $accion = trim($_POST['accion'] ?? '');

    // --------------------------------------------------------------------------
    // 1. PAGAR / ENTREGAR BONO EN EFECTIVO, TRANSFERENCIA O DESCUENTO
    // --------------------------------------------------------------------------
    if ($accion === 'pagar_bono') {
        $referido_id    = intval($_POST['referido_id'] ?? 0);
        $metodo_entrega = trim($_POST['metodo_entrega'] ?? 'EFECTIVO');
        $banco_nombre   = trim($_POST['banco_nombre'] ?? '');
        $no_boleta      = trim($_POST['no_boleta'] ?? '');
        $observaciones  = trim($_POST['observaciones'] ?? '');

        if ($referido_id <= 0) {
            $mensaje_error = 'Identificador de bono inválido.';
        } else {
            try {
                // Comprobar estado actual
                $stmtChk = $pdo->prepare("SELECT * FROM referidos WHERE id = :id");
                $stmtChk->execute([':id' => $referido_id]);
                $ref = $stmtChk->fetch();

                if (!$ref) {
                    $mensaje_error = 'El registro de bono solicitado no existe.';
                } elseif ($ref['estado_bono'] === 'RECLAMADO') {
                    $mensaje_error = 'Este bono ya fue pagado previamente (' . htmlspecialchars($ref['comprobante_egreso']) . ').';
                } else {
                    // Generar Comprobante de Egreso único
                    $numEgreso = 'EGR-REF-' . date('Y') . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
                    
                    // Estado resultante
                    $nuevoEstado = ($metodo_entrega === 'DESCUENTO_MEMBRESIA') ? 'APLICADO' : 'RECLAMADO';

                    // Detalle observaciones
                    $obsFinal = $observaciones;
                    if ($metodo_entrega === 'TRANSFERENCIA') {
                        $obsFinal = "Transf: {$banco_nombre} | Boleta/Ref: {$no_boleta}. " . $obsFinal;
                    } elseif ($metodo_entrega === 'DESCUENTO_MEMBRESIA') {
                        $obsFinal = "Descuento directo aplicado a la próxima mensualidad del cliente. " . $obsFinal;
                    }

                    $stmtPay = $pdo->prepare("
                        UPDATE referidos 
                        SET estado_bono = :estado,
                            metodo_entrega = :metodo,
                            fecha_entrega = NOW(),
                            comprobante_egreso = :egreso,
                            recepcionista_entrega_id = :rec,
                            observaciones = :obs
                        WHERE id = :id
                    ");
                    $stmtPay->execute([
                        ':estado' => $nuevoEstado,
                        ':metodo' => $metodo_entrega,
                        ':egreso' => $numEgreso,
                        ':rec'    => $usuario_activo_id,
                        ':obs'    => trim($obsFinal),
                        ':id'     => $referido_id
                    ]);

                    $mensaje_exito = "¡Entrega de bono procesada exitosamente! Se emitió el Comprobante de Egreso: <strong>{$numEgreso}</strong> por valor de <strong>Q" . number_format($ref['bono_otorgado'], 2) . "</strong>.";
                }
            } catch (PDOException $e) {
                $mensaje_error = 'Error al procesar el pago del bono: ' . $e->getMessage();
            }
        }
    }

    // --------------------------------------------------------------------------
    // 2. REGISTRAR REFERIDO MANUALMENTE
    // --------------------------------------------------------------------------
    elseif ($accion === 'registrar_referido') {
        $referidor_id = intval($_POST['cliente_referidor_id'] ?? 0);
        $referido_id  = intval($_POST['cliente_referido_id'] ?? 0);
        $membresia_id = intval($_POST['membresia_id'] ?? 1);

        if ($referidor_id <= 0 || $referido_id <= 0 || $referidor_id === $referido_id) {
            $mensaje_error = 'Por favor selecciona un cliente referidor y un cliente referido distintos.';
        } else {
            try {
                // Monto del bono: Q100 Básica (id 1), Q150 Haute (id 2)
                $montoBono = ($membresia_id == 2) ? 150.00 : 100.00;

                $stmtReg = $pdo->prepare("
                    INSERT INTO referidos (cliente_referidor_id, cliente_referido_id, membresia_id, bono_otorgado, estado_bono, fecha_referido)
                    VALUES (:referidor, :referido, :mem, :bono, 'PENDIENTE', NOW())
                ");
                $stmtReg->execute([
                    ':referidor' => $referidor_id,
                    ':referido'  => $referido_id,
                    ':mem'       => $membresia_id,
                    ':bono'      => $montoBono
                ]);

                $mensaje_exito = "Afiliación por recomendación registrada con éxito. Bono de <strong>Q" . number_format($montoBono, 2) . "</strong> acreditado en estado Pendiente.";
            } catch (PDOException $e) {
                $mensaje_error = 'Error al registrar referido: ' . ($e->getCode() == 23000 ? 'Este cliente referido ya tiene un bono asignado.' : $e->getMessage());
            }
        }
    }

    // Si el script fue ejecutado directamente por el formulario, redirigir a index.php conservando el mensaje
    $script_actual = basename($_SERVER['PHP_SELF'] ?? '');
    if ($script_actual === 'controlador_referidos.php') {
        if (!empty($mensaje_exito)) $_SESSION['mensaje_exito'] = $mensaje_exito;
        if (!empty($mensaje_error)) $_SESSION['mensaje_error'] = $mensaje_error;
        header('Location: index.php');
        exit;
    }
}

// ==============================================================================
// CONSULTAS PARA LA VISTA DE REFERIDOS (TABLA, CLIENTES, MEMBRESÍAS, KPIS)
// ==============================================================================
$lista_referidos  = [];
$lista_clientes   = [];
$lista_membresias = [];

$kpi_bonos_entregados  = 0.00;
$kpi_bonos_pendientes  = 0.00;
$kpi_total_afiliados   = 0;
$kpi_bonos_descuento   = 0.00;

if (isset($pdo) && $pdo !== null) {
    try {
        // Listado completo de referidos
        $stmtList = $pdo->query("
            SELECT r.*,
                   m.nombre as membresia_nombre, m.precio_mes as membresia_precio,
                   ur.nombre as referidor_nombre, ur.apellido as referidor_apellido, ur.email as referidor_email, ur.telefono as referidor_telefono,
                   ud.nombre as referido_nombre, ud.apellido as referido_apellido, ud.email as referido_email,
                   rec.nombre as recepcionista_nombre, rec.apellido as recepcionista_apellido
            FROM referidos r
            INNER JOIN usuarios ur ON r.cliente_referidor_id = ur.id
            INNER JOIN usuarios ud ON r.cliente_referido_id = ud.id
            INNER JOIN membresias m ON r.membresia_id = m.id
            LEFT JOIN usuarios rec ON r.recepcionista_entrega_id = rec.id
            ORDER BY r.id DESC
        ");
        $lista_referidos = $stmtList->fetchAll();

        // Clientes activos para selector
        $stmtCli = $pdo->query("SELECT id, nombre, apellido, email FROM usuarios WHERE rol_id = 9 OR tipo_persona = 'CLIENTE' ORDER BY nombre ASC");
        $lista_clientes = $stmtCli->fetchAll();

        // Membresías
        $stmtMem = $pdo->query("SELECT id, nombre, precio_mes, bono_referido FROM membresias ORDER BY id ASC");
        $lista_membresias = $stmtMem->fetchAll();

        // Métricas KPI
        $stmtKpi1 = $pdo->query("SELECT COALESCE(SUM(bono_otorgado), 0) FROM referidos WHERE estado_bono = 'RECLAMADO'");
        $kpi_bonos_entregados = floatval($stmtKpi1->fetchColumn());

        $stmtKpi2 = $pdo->query("SELECT COALESCE(SUM(bono_otorgado), 0) FROM referidos WHERE estado_bono = 'PENDIENTE'");
        $kpi_bonos_pendientes = floatval($stmtKpi2->fetchColumn());

        $stmtKpi3 = $pdo->query("SELECT COUNT(*) FROM referidos");
        $kpi_total_afiliados = intval($stmtKpi3->fetchColumn());

        $stmtKpi4 = $pdo->query("SELECT COALESCE(SUM(bono_otorgado), 0) FROM referidos WHERE estado_bono = 'APLICADO'");
        $kpi_bonos_descuento = floatval($stmtKpi4->fetchColumn());

    } catch (Exception $e) {
        $mensaje_error = 'Error al cargar listado de referidos: ' . $e->getMessage();
    }
}
