<?php
// metricas/controlador_metricas.php - Lógica PHP para Métricas y Bonos de Desempeño

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

// Auto-sembrado de métricas si la tabla está vacía
if (isset($pdo) && $pdo !== null) {
    try {
        $countMet = $pdo->query("SELECT COUNT(*) FROM metricas_desempeno")->fetchColumn();
        if ($countMet == 0) {
            $coachId = $pdo->query("SELECT id FROM usuarios WHERE rol_id IN (4, 5) LIMIT 1")->fetchColumn() ?: 4;
            $recepId = $pdo->query("SELECT id FROM usuarios WHERE rol_id = 3 LIMIT 1")->fetchColumn() ?: 3;

            $pdo->exec("
                INSERT INTO metricas_desempeno 
                (empleado_id, tipo_equipo, semana_periodo, sesiones_o_ventas_realizadas, porcentaje_csat_o_retencion, porcentaje_bono_aplicado, monto_bono_total) 
                VALUES
                ({$coachId}, 'COACH', '2026-W37', 64, 95.0, 100, 1200.00),
                ({$recepId}, 'RECEPCION', '2026-W37', 28, 96.5, 100, 1200.00),
                ({$coachId}, 'COACH', '2026-W36', 52, 87.0, 75, 900.00);
            ");
        }
    } catch (Exception $e) {
        // Silencioso
    }
}

// Procesamiento de acciones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($pdo) && $pdo !== null) {
    $accion = trim($_POST['accion'] ?? '');

    // 1. REGISTRAR EVALUACIÓN Y BONO
    if ($accion === 'crear') {
        $empleado_id      = intval($_POST['empleado_id'] ?? 0);
        $tipo_equipo      = trim($_POST['tipo_equipo'] ?? 'COACH');
        $semana_periodo   = trim($_POST['semana_periodo'] ?? date('Y-\WW'));
        $sesiones_ventas  = intval($_POST['sesiones_o_ventas_realizadas'] ?? 0);
        $csat_retencion   = floatval($_POST['porcentaje_csat_o_retencion'] ?? 0);
        $pct_bono         = intval($_POST['porcentaje_bono_aplicado'] ?? 0);
        $monto_bono       = floatval($_POST['monto_bono_total'] ?? 0);

        if ($empleado_id <= 0 || empty($semana_periodo)) {
            $mensaje_error = 'Por favor selecciona el empleado e indica el periodo correspondiente.';
        } else {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO metricas_desempeno 
                    (empleado_id, tipo_equipo, semana_periodo, sesiones_o_ventas_realizadas, porcentaje_csat_o_retencion, porcentaje_bono_aplicado, monto_bono_total, fecha_calculo)
                    VALUES 
                    (:emp, :tipo, :sem, :ses, :csat, :pct, :monto, NOW())
                ");
                $stmt->execute([
                    ':emp'   => $empleado_id,
                    ':tipo'  => $tipo_equipo,
                    ':sem'   => $semana_periodo,
                    ':ses'   => $sesiones_ventas,
                    ':csat'  => $csat_retencion,
                    ':pct'   => $pct_bono,
                    ':monto' => $monto_bono
                ]);
                $mensaje_exito = "Métricas registradas exitosamente. Bono liquidado: <strong>Q" . number_format($monto_bono, 2) . "</strong> ({$pct_bono}% cumplimiento).";
            } catch (PDOException $e) {
                $mensaje_error = 'Error al registrar métricas: ' . $e->getMessage();
            }
        }
    }

    // 2. EDITAR MÉTRICA
    elseif ($accion === 'editar') {
        $id              = intval($_POST['id'] ?? 0);
        $semana_periodo  = trim($_POST['semana_periodo'] ?? '');
        $sesiones_ventas = intval($_POST['sesiones_o_ventas_realizadas'] ?? 0);
        $csat_retencion  = floatval($_POST['porcentaje_csat_o_retencion'] ?? 0);
        $pct_bono        = intval($_POST['porcentaje_bono_aplicado'] ?? 0);
        $monto_bono      = floatval($_POST['monto_bono_total'] ?? 0);

        if ($id <= 0) {
            $mensaje_error = 'ID de métrica inválido.';
        } else {
            try {
                $stmt = $pdo->prepare("
                    UPDATE metricas_desempeno 
                    SET semana_periodo = :sem, sesiones_o_ventas_realizadas = :ses, porcentaje_csat_o_retencion = :csat, porcentaje_bono_aplicado = :pct, monto_bono_total = :monto
                    WHERE id = :id
                ");
                $stmt->execute([
                    ':sem'   => $semana_periodo,
                    ':ses'   => $sesiones_ventas,
                    ':csat'  => $csat_retencion,
                    ':pct'   => $pct_bono,
                    ':monto' => $monto_bono,
                    ':id'    => $id
                ]);
                $mensaje_exito = 'Registro de desempeño actualizado.';
            } catch (PDOException $e) {
                $mensaje_error = 'Error al actualizar métrica: ' . $e->getMessage();
            }
        }
    }

    // 3. ELIMINAR MÉTRICA
    elseif ($accion === 'eliminar') {
        $id = intval($_POST['id'] ?? 0);
        if ($id > 0) {
            try {
                $pdo->prepare("DELETE FROM metricas_desempeno WHERE id = :id")->execute([':id' => $id]);
                $mensaje_exito = 'Registro de métrica eliminado correctamente.';
            } catch (PDOException $e) {
                $mensaje_error = 'Error al eliminar métrica: ' . $e->getMessage();
            }
        }
    }
}

// ------------------------------------------------------------------------------
// CONSULTAS PARA LA VISTA
// ------------------------------------------------------------------------------
$metricas = [];
$empleados = [];
$total_bonos_pagados = 0;

if (isset($pdo) && $pdo !== null) {
    try {
        $query = "
            SELECT 
                md.id,
                md.empleado_id,
                md.tipo_equipo,
                md.semana_periodo,
                md.sesiones_o_ventas_realizadas,
                md.porcentaje_csat_o_retencion,
                md.porcentaje_bono_aplicado,
                md.monto_bono_total,
                md.fecha_calculo,
                u.nombre AS empleado_nombre,
                u.apellido AS empleado_apellido,
                u.email AS empleado_email,
                r.nombre_rol
            FROM metricas_desempeno md
            INNER JOIN usuarios u ON md.empleado_id = u.id
            LEFT JOIN roles r ON u.rol_id = r.id
            ORDER BY md.id DESC
        ";
        $metricas = $pdo->query($query)->fetchAll();

        // Empleados evaluables (Coaches y Recepcionistas)
        $empleados = $pdo->query("
            SELECT id, nombre, apellido, rol_id, tipo_persona 
            FROM usuarios 
            WHERE rol_id IN (3, 4, 5) OR tipo_persona = 'INTERNO'
            ORDER BY nombre ASC
        ")->fetchAll();

        // Total bonos acumulados
        $total_bonos_pagados = $pdo->query("SELECT COALESCE(SUM(monto_bono_total), 0) FROM metricas_desempeno")->fetchColumn();
    } catch (PDOException $e) {
        $mensaje_error = 'Error al consultar métricas: ' . $e->getMessage();
    }
}
