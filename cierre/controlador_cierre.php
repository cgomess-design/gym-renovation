<?php
// cierre/controlador_cierre.php - Lógica PHP para el Reporte Diario de Cierre de Jornada

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
$usuario_activo_nombre = $_SESSION['nombre_completo'] ?? 'Usuario';
$usuario_activo_rol    = $_SESSION['rol'] ?? 'ADMINISTRADOR';
$usuario_activo_suc    = $_SESSION['sucursal'] ?? 'Central';
$iniciales_activo      = strtoupper(substr($usuario_activo_nombre, 0, 1));

// Auto-sembrado de reportes de cierre si la tabla está vacía
if (isset($pdo) && $pdo !== null) {
    try {
        $countCierre = $pdo->query("SELECT COUNT(*) FROM reportes_cierre_jornada")->fetchColumn();
        if ($countCierre == 0) {
            $pdo->exec("
                INSERT INTO reportes_cierre_jornada 
                (sucursal_id, fecha, cantidad_usuarios_dia, tiempo_promedio_minutos, ventas_servicios_tercerizados, ventas_membresias_total, usuarios_clases_natacion, usuarios_clases_boxeo, generado_en) 
                VALUES
                (1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), 94, 76.5, 1850.00, 7500.00, 18, 28, DATE_SUB(NOW(), INTERVAL 1 DAY)),
                (2, DATE_SUB(CURDATE(), INTERVAL 1 DAY), 82, 68.0, 1200.00, 5250.00, 10, 0,  DATE_SUB(NOW(), INTERVAL 1 DAY)),
                (1, DATE_SUB(CURDATE(), INTERVAL 2 DAY), 89, 74.0, 1400.00, 6800.00, 16, 26, DATE_SUB(NOW(), INTERVAL 2 DAY));
            ");
        }
    } catch (Exception $e) {
        // Silencioso
    }
}

// Procesamiento de acciones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($pdo) && $pdo !== null) {
    $accion = trim($_POST['accion'] ?? '');

    // 1. GENERAR / REGISTRAR CIERRE DE JORNADA
    if ($accion === 'crear') {
        $sucursal_id   = intval($_POST['sucursal_id'] ?? 1);
        $fecha         = !empty($_POST['fecha']) ? $_POST['fecha'] : date('Y-m-d');
        $usuarios_dia  = intval($_POST['cantidad_usuarios_dia'] ?? 0);
        $tiempo_prom   = floatval($_POST['tiempo_promedio_minutos'] ?? 0);
        $ventas_mem    = floatval($_POST['ventas_membresias_total'] ?? 0);
        $ventas_terc   = floatval($_POST['ventas_servicios_tercerizados'] ?? 0);
        $clases_nat    = intval($_POST['usuarios_clases_natacion'] ?? 0);
        $clases_box    = intval($_POST['usuarios_clases_boxeo'] ?? 0);

        if ($sucursal_id <= 0 || empty($fecha)) {
            $mensaje_error = 'Selecciona la sucursal y la fecha para generar el cierre.';
        } else {
            try {
                // Insertar o actualizar cierre del día (ON DUPLICATE KEY UPDATE)
                $stmt = $pdo->prepare("
                    INSERT INTO reportes_cierre_jornada 
                    (sucursal_id, fecha, cantidad_usuarios_dia, tiempo_promedio_minutos, ventas_servicios_tercerizados, ventas_membresias_total, usuarios_clases_natacion, usuarios_clases_boxeo, generado_en)
                    VALUES 
                    (:suc, :fec, :usr, :tmp, :vterc, :vmem, :nat, :box, NOW())
                    ON DUPLICATE KEY UPDATE
                    cantidad_usuarios_dia = VALUES(cantidad_usuarios_dia),
                    tiempo_promedio_minutos = VALUES(tiempo_promedio_minutos),
                    ventas_servicios_tercerizados = VALUES(ventas_servicios_tercerizados),
                    ventas_membresias_total = VALUES(ventas_membresias_total),
                    usuarios_clases_natacion = VALUES(usuarios_clases_natacion),
                    usuarios_clases_boxeo = VALUES(usuarios_clases_boxeo),
                    generado_en = NOW()
                ");
                $stmt->execute([
                    ':suc'   => $sucursal_id,
                    ':fec'   => $fecha,
                    ':usr'   => $usuarios_dia,
                    ':tmp'   => $tiempo_prom,
                    ':vterc' => $ventas_terc,
                    ':vmem'  => $ventas_mem,
                    ':nat'   => $clases_nat,
                    ':box'   => $clases_box
                ]);

                $totalDia = $ventas_mem + $ventas_terc;
                $mensaje_exito = "Cierre de jornada para la fecha <strong>{$fecha}</strong> consolidado exitosamente. Ingresos totales del día: <strong>Q" . number_format($totalDia, 2) . "</strong>.";
            } catch (PDOException $e) {
                $mensaje_error = 'Error al generar el cierre de jornada: ' . $e->getMessage();
            }
        }
    }

    // 2. EDITAR CIERRE
    elseif ($accion === 'editar') {
        $id          = intval($_POST['id'] ?? 0);
        $sucursal_id = intval($_POST['sucursal_id'] ?? 1);
        $fecha       = trim($_POST['fecha'] ?? '');
        $usr_dia     = intval($_POST['cantidad_usuarios_dia'] ?? 0);
        $tmp_prom    = floatval($_POST['tiempo_promedio_minutos'] ?? 0);
        $v_mem       = floatval($_POST['ventas_membresias_total'] ?? 0);
        $v_terc      = floatval($_POST['ventas_servicios_tercerizados'] ?? 0);
        $c_nat       = intval($_POST['usuarios_clases_natacion'] ?? 0);
        $c_box       = intval($_POST['usuarios_clases_boxeo'] ?? 0);

        if ($id <= 0) {
            $mensaje_error = 'ID de reporte inválido.';
        } else {
            try {
                $stmt = $pdo->prepare("
                    UPDATE reportes_cierre_jornada 
                    SET sucursal_id = :suc, fecha = :fec, cantidad_usuarios_dia = :usr, tiempo_promedio_minutos = :tmp, 
                        ventas_membresias_total = :vmem, ventas_servicios_tercerizados = :vterc,
                        usuarios_clases_natacion = :nat, usuarios_clases_boxeo = :box
                    WHERE id = :id
                ");
                $stmt->execute([
                    ':suc'   => $sucursal_id,
                    ':fec'   => $fecha,
                    ':usr'   => $usr_dia,
                    ':tmp'   => $tmp_prom,
                    ':vmem'  => $v_mem,
                    ':vterc' => $v_terc,
                    ':nat'   => $c_nat,
                    ':box'   => $c_box,
                    ':id'    => $id
                ]);
                $mensaje_exito = 'Reporte de cierre actualizado correctamente.';
            } catch (PDOException $e) {
                $mensaje_error = 'Error al actualizar reporte: ' . $e->getMessage();
            }
        }
    }

    // 3. ELIMINAR CIERRE
    elseif ($accion === 'eliminar') {
        $id = intval($_POST['id'] ?? 0);
        if ($id > 0) {
            try {
                $pdo->prepare("DELETE FROM reportes_cierre_jornada WHERE id = :id")->execute([':id' => $id]);
                $mensaje_exito = 'Reporte de cierre eliminado.';
            } catch (PDOException $e) {
                $mensaje_error = 'Error al eliminar reporte: ' . $e->getMessage();
            }
        }
    }
}

// ------------------------------------------------------------------------------
// CONSULTAS PARA LA VISTA
// ------------------------------------------------------------------------------
$reportes = [];
$sucursales = [];
$promedio_aforo = 0;
$promedio_permanencia = 0;
$total_ingresos_historico = 0;

if (isset($pdo) && $pdo !== null) {
    try {
        $query = "
            SELECT 
                rcj.id,
                rcj.sucursal_id,
                rcj.fecha,
                rcj.cantidad_usuarios_dia,
                rcj.tiempo_promedio_minutos,
                rcj.ventas_servicios_tercerizados,
                rcj.ventas_membresias_total,
                rcj.usuarios_clases_natacion,
                rcj.usuarios_clases_boxeo,
                rcj.generado_en,
                s.nombre AS sucursal_nombre
            FROM reportes_cierre_jornada rcj
            INNER JOIN sucursales s ON rcj.sucursal_id = s.id
            ORDER BY rcj.fecha DESC, rcj.id DESC
        ";
        $reportes = $pdo->query($query)->fetchAll();
        $sucursales = $pdo->query("SELECT id, nombre FROM sucursales WHERE estado = 'ACTIVA' ORDER BY id ASC")->fetchAll();

        // Métricas globales
        $promedio_aforo = $pdo->query("SELECT COALESCE(AVG(cantidad_usuarios_dia), 0) FROM reportes_cierre_jornada")->fetchColumn();
        $promedio_permanencia = $pdo->query("SELECT COALESCE(AVG(tiempo_promedio_minutos), 0) FROM reportes_cierre_jornada")->fetchColumn();
        $total_ingresos_historico = $pdo->query("SELECT COALESCE(SUM(ventas_membresias_total + ventas_servicios_tercerizados), 0) FROM reportes_cierre_jornada")->fetchColumn();

        // Ventas de suplementos del día actual (servicios tercerizados)
        $ventas_suplementos_hoy = 0;
        try {
            $stmtSupH = $pdo->query("SELECT COALESCE(SUM(total_venta), 0) FROM suplementos_ventas WHERE DATE(fecha_venta) = CURDATE()");
            $ventas_suplementos_hoy = floatval($stmtSupH->fetchColumn());
        } catch (Exception $e) {
            $ventas_suplementos_hoy = 0;
        }
    } catch (PDOException $e) {
        $mensaje_error = 'Error al consultar reportes de cierre: ' . $e->getMessage();
    }
}
