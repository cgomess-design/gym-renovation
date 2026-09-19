<?php
// ordenes_compra/controlador_ordenes.php - Lógica PHP para Órdenes de Compra y Proveedores

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

// Variables de sesión
$usuario_activo_id     = $_SESSION['usuario_id'] ?? 1;
$usuario_activo_nombre = $_SESSION['nombre_completo'] ?? 'Usuario';
$usuario_activo_rol    = $_SESSION['rol'] ?? 'ADMINISTRADOR';
$usuario_activo_suc    = $_SESSION['sucursal'] ?? 'Central';
$iniciales_activo      = strtoupper(substr($usuario_activo_nombre, 0, 1));

// Auto-sembrado de proveedores si la tabla está vacía
if (isset($pdo) && $pdo !== null) {
    try {
        $countProv = $pdo->query("SELECT COUNT(*) FROM proveedores")->fetchColumn();
        if ($countProv == 0) {
            $pdo->exec("
                INSERT INTO proveedores (nombre, contacto, telefono, email, calificacion_calidad, indice_precio) VALUES
                ('LifeFitness Pro Equipments', 'Lic. Roberto Valle', '2331-4400', 'ventas@lifefitness.gt', 4.9, 'PREMIUM'),
                ('Matrix Sport Centroamérica', 'Ing. Pamela Estrada', '2254-8899', 'corporativo@matrixgt.com', 4.6, 'MEDIO'),
                ('Everlast Fight Gear', 'Carlos Batres', '2440-1122', 'distribuidor@everlast.com.gt', 4.8, 'ALTO'),
                ('AquaPro Piscinas & Hidromasajes', 'Arq. Gabriel Soto', '2360-7733', 'proyectos@aquapro.gt', 4.7, 'MEDIO');
            ");
        }

        // Auto-sembrado de órdenes de compra iniciales si está vacía
        $countOC = $pdo->query("SELECT COUNT(*) FROM ordenes_compra")->fetchColumn();
        if ($countOC == 0) {
            $pdo->exec("
                INSERT INTO ordenes_compra (numero_orden, proveedor_id, sucursal_id, solicitado_por_usuario_id, total_orden, estado, fecha_orden) VALUES
                ('OC-2026-001', 1, 1, {$usuario_activo_id}, 45000.00, 'RECIBIDA', DATE_SUB(NOW(), INTERVAL 10 DAY)),
                ('OC-2026-002', 3, 1, {$usuario_activo_id}, 18500.00, 'APROBADA', DATE_SUB(NOW(), INTERVAL 3 DAY)),
                ('OC-2026-003', 2, 2, {$usuario_activo_id}, 32000.00, 'SOLICITADA', NOW());
            ");
        }
    } catch (Exception $e) {
        // Silencioso si ya existen
    }
}

// Procesamiento de acciones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($pdo) && $pdo !== null) {
    $accion = trim($_POST['accion'] ?? '');

    // 1. CREAR ORDEN DE COMPRA
    if ($accion === 'crear') {
        $proveedor_id = intval($_POST['proveedor_id'] ?? 0);
        $sucursal_id  = intval($_POST['sucursal_id'] ?? 1);
        $total_orden  = floatval($_POST['total_orden'] ?? 0);
        $estado       = trim($_POST['estado'] ?? 'SOLICITADA');
        $numero_orden = 'OC-' . date('Y') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

        if ($proveedor_id <= 0 || $sucursal_id <= 0 || $total_orden <= 0) {
            $mensaje_error = 'Por favor selecciona el proveedor, la sucursal y un monto total válido.';
        } else {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO ordenes_compra 
                    (numero_orden, proveedor_id, sucursal_id, solicitado_por_usuario_id, total_orden, estado, fecha_orden)
                    VALUES 
                    (:num, :prov, :suc, :sol, :tot, :est, NOW())
                ");
                $stmt->execute([
                    ':num'  => $numero_orden,
                    ':prov' => $proveedor_id,
                    ':suc'  => $sucursal_id,
                    ':sol'  => $usuario_activo_id,
                    ':tot'  => $total_orden,
                    ':est'  => $estado
                ]);
                $mensaje_exito = "Orden de compra <strong>{$numero_orden}</strong> generada con éxito por Q" . number_format($total_orden, 2);
            } catch (PDOException $e) {
                $mensaje_error = 'Error al generar la orden de compra: ' . $e->getMessage();
            }
        }
    }

    // 2. EDITAR ORDEN DE COMPRA
    elseif ($accion === 'editar') {
        $id          = intval($_POST['id'] ?? 0);
        $sucursal_id = intval($_POST['sucursal_id'] ?? 1);
        $total_orden = floatval($_POST['total_orden'] ?? 0);
        $estado      = trim($_POST['estado'] ?? 'SOLICITADA');

        if ($id <= 0 || $total_orden <= 0) {
            $mensaje_error = 'Datos inválidos para actualizar la orden de compra.';
        } else {
            try {
                $stmt = $pdo->prepare("
                    UPDATE ordenes_compra 
                    SET sucursal_id = :suc, total_orden = :tot, estado = :est
                    WHERE id = :id
                ");
                $stmt->execute([
                    ':suc' => $sucursal_id,
                    ':tot' => $total_orden,
                    ':est' => $estado,
                    ':id'  => $id
                ]);
                $mensaje_exito = 'Orden de compra actualizada correctamente.';
            } catch (PDOException $e) {
                $mensaje_error = 'Error al actualizar orden de compra: ' . $e->getMessage();
            }
        }
    }

    // 3. CANCELAR / ELIMINAR ORDEN
    elseif ($accion === 'eliminar') {
        $id = intval($_POST['id'] ?? 0);
        if ($id > 0) {
            try {
                $stmt = $pdo->prepare("UPDATE ordenes_compra SET estado = 'CANCELADA' WHERE id = :id");
                $stmt->execute([':id' => $id]);
                $mensaje_exito = 'La orden de compra ha sido cancelada.';
            } catch (PDOException $e) {
                $mensaje_error = 'Error al cancelar la orden: ' . $e->getMessage();
            }
        }
    }
}

// ------------------------------------------------------------------------------
// CONSULTAS PARA LA VISTA
// ------------------------------------------------------------------------------
$ordenes = [];
$proveedores = [];
$sucursales = [];

if (isset($pdo) && $pdo !== null) {
    try {
        $query = "
            SELECT 
                oc.id,
                oc.numero_orden,
                oc.proveedor_id,
                oc.sucursal_id,
                oc.solicitado_por_usuario_id,
                oc.total_orden,
                oc.estado,
                oc.fecha_orden,
                p.nombre AS proveedor_nombre,
                p.contacto AS proveedor_contacto,
                p.telefono AS proveedor_telefono,
                p.email AS proveedor_email,
                p.calificacion_calidad,
                p.indice_precio,
                s.nombre AS sucursal_nombre,
                u.nombre AS solicitante_nombre,
                u.apellido AS solicitante_apellido
            FROM ordenes_compra oc
            INNER JOIN proveedores p ON oc.proveedor_id = p.id
            INNER JOIN sucursales s ON oc.sucursal_id = s.id
            LEFT JOIN usuarios u ON oc.solicitado_por_usuario_id = u.id
            ORDER BY oc.id DESC
        ";
        $ordenes = $pdo->query($query)->fetchAll();
        $proveedores = $pdo->query("SELECT * FROM proveedores ORDER BY calificacion_calidad DESC")->fetchAll();
        $sucursales = $pdo->query("SELECT id, nombre FROM sucursales WHERE estado = 'ACTIVA' ORDER BY id ASC")->fetchAll();
    } catch (PDOException $e) {
        $mensaje_error = 'Error al consultar datos de compras: ' . $e->getMessage();
    }
}
