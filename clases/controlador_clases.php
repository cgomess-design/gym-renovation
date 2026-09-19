<?php
// clases/controlador_clases.php - Lógica PHP para Clases Especializadas (Natación y Boxeo) y Control de Aforo

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

// Auto-sembrado de clases si la tabla está vacía
if (isset($pdo) && $pdo !== null) {
    try {
        $countClases = $pdo->query("SELECT COUNT(*) FROM clases_horarios")->fetchColumn();
        if ($countClases == 0) {
            // Buscar un coach existente (ej. id 4 o cualquier usuario disponible)
            $coachId = $pdo->query("SELECT id FROM usuarios WHERE rol_id IN (4, 5) LIMIT 1")->fetchColumn();
            if (!$coachId) {
                $coachId = $pdo->query("SELECT id FROM usuarios LIMIT 1")->fetchColumn() ?: 1;
            }

            $pdo->exec("
                INSERT INTO clases_horarios 
                (sucursal_id, coach_id, disciplina, aforo_maximo, fecha, hora_inicio, hora_fin, cupos_ocupados) 
                VALUES
                (1, {$coachId}, 'NATACION', 10, CURDATE(), '07:00:00', '08:00:00', 8),
                (1, {$coachId}, 'BOXEO', 15, CURDATE(), '18:00:00', '19:00:00', 14),
                (2, {$coachId}, 'NATACION', 10, DATE_ADD(CURDATE(), INTERVAL 1 DAY), '09:00:00', '10:00:00', 5);
            ");
        }
    } catch (Exception $e) {
        // Silencioso
    }
}

// Procesamiento de acciones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($pdo) && $pdo !== null) {
    $accion = trim($_POST['accion'] ?? '');

    // 1. PROGRAMAR NUEVA CLASE
    if ($accion === 'crear') {
        $disciplina  = trim($_POST['disciplina'] ?? 'NATACION');
        $sucursal_id = intval($_POST['sucursal_id'] ?? 1);
        $coach_id    = intval($_POST['coach_id'] ?? 0);
        $fecha       = !empty($_POST['fecha']) ? $_POST['fecha'] : date('Y-m-d');
        $hora_inicio = trim($_POST['hora_inicio'] ?? '07:00');
        $hora_fin    = trim($_POST['hora_fin'] ?? '08:00');

        // Reglas de negocio de aforo: Natación 10, Boxeo 15
        $aforo_max = ($disciplina === 'BOXEO') ? 15 : 10;

        // Formatear horas con segundos
        if (strlen($hora_inicio) === 5) $hora_inicio .= ':00';
        if (strlen($hora_fin) === 5) $hora_fin .= ':00';

        if ($coach_id <= 0 || $sucursal_id <= 0) {
            $mensaje_error = 'Debes seleccionar la sucursal y el coach a cargo de la clase.';
        } else {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO clases_horarios 
                    (sucursal_id, coach_id, disciplina, aforo_maximo, fecha, hora_inicio, hora_fin, cupos_ocupados)
                    VALUES 
                    (:suc, :coach, :disc, :aforo, :fec, :hi, :hf, 0)
                ");
                $stmt->execute([
                    ':suc'   => $sucursal_id,
                    ':coach' => $coach_id,
                    ':disc'  => $disciplina,
                    ':aforo' => $aforo_max,
                    ':fec'   => $fecha,
                    ':hi'    => $hora_inicio,
                    ':hf'    => $hora_fin
                ]);

                $mensaje_exito = "Clase de <strong>{$disciplina}</strong> programada exitosamente (Aforo reglamentario: <strong>{$aforo_max}</strong> usuarios).";
            } catch (PDOException $e) {
                $mensaje_error = 'Error al programar la clase: ' . $e->getMessage();
            }
        }
    }

    // 2. EDITAR CLASE
    elseif ($accion === 'editar') {
        $id             = intval($_POST['id'] ?? 0);
        $disciplina     = trim($_POST['disciplina'] ?? 'NATACION');
        $sucursal_id    = intval($_POST['sucursal_id'] ?? 1);
        $coach_id       = intval($_POST['coach_id'] ?? 0);
        $fecha          = trim($_POST['fecha'] ?? '');
        $hora_inicio    = trim($_POST['hora_inicio'] ?? '');
        $hora_fin       = trim($_POST['hora_fin'] ?? '');
        $cupos_ocupados = intval($_POST['cupos_ocupados'] ?? 0);
        $aforo_max      = ($disciplina === 'BOXEO') ? 15 : 10;

        if (strlen($hora_inicio) === 5) $hora_inicio .= ':00';
        if (strlen($hora_fin) === 5) $hora_fin .= ':00';

        if ($id <= 0 || $coach_id <= 0) {
            $mensaje_error = 'Datos inválidos para actualizar la clase.';
        } else {
            try {
                $stmt = $pdo->prepare("
                    UPDATE clases_horarios 
                    SET disciplina = :disc, sucursal_id = :suc, coach_id = :coach, fecha = :fec, hora_inicio = :hi, hora_fin = :hf, aforo_maximo = :aforo, cupos_ocupados = :cupos
                    WHERE id = :id
                ");
                $stmt->execute([
                    ':disc'  => $disciplina,
                    ':suc'   => $sucursal_id,
                    ':coach' => $coach_id,
                    ':fec'   => $fecha,
                    ':hi'    => $hora_inicio,
                    ':hf'    => $hora_fin,
                    ':aforo' => $aforo_max,
                    ':cupos' => min($cupos_ocupados, $aforo_max),
                    ':id'    => $id
                ]);
                $mensaje_exito = 'Clase actualizada correctamente.';
            } catch (PDOException $e) {
                $mensaje_error = 'Error al actualizar clase: ' . $e->getMessage();
            }
        }
    }

    // 3. CANCELAR / ELIMINAR CLASE
    elseif ($accion === 'eliminar') {
        $id = intval($_POST['id'] ?? 0);
        if ($id > 0) {
            try {
                $pdo->prepare("DELETE FROM clases_asistencias WHERE clase_id = :id")->execute([':id' => $id]);
                $pdo->prepare("DELETE FROM clases_horarios WHERE id = :id")->execute([':id' => $id]);
                $mensaje_exito = 'La clase ha sido cancelada y removida del cronograma.';
            } catch (PDOException $e) {
                $mensaje_error = 'Error al cancelar la clase: ' . $e->getMessage();
            }
        }
    }
}

// ------------------------------------------------------------------------------
// CONSULTAS PARA LA VISTA
// ------------------------------------------------------------------------------
$clases = [];
$coaches = [];
$sucursales = [];

if (isset($pdo) && $pdo !== null) {
    try {
        $query = "
            SELECT 
                ch.id,
                ch.sucursal_id,
                ch.coach_id,
                ch.disciplina,
                ch.aforo_maximo,
                ch.fecha,
                ch.hora_inicio,
                ch.hora_fin,
                ch.cupos_ocupados,
                s.nombre AS sucursal_nombre,
                u.nombre AS coach_nombre,
                u.apellido AS coach_apellido,
                u.email AS coach_email
            FROM clases_horarios ch
            INNER JOIN sucursales s ON ch.sucursal_id = s.id
            INNER JOIN usuarios u ON ch.coach_id = u.id
            ORDER BY ch.fecha DESC, ch.hora_inicio ASC
        ";
        $clases = $pdo->query($query)->fetchAll();

        // Lista de coaches (roles 4 y 5 o todos si no hay específicos)
        $coaches = $pdo->query("
            SELECT id, nombre, apellido, usuario 
            FROM usuarios 
            WHERE rol_id IN (4, 5) OR tipo_persona = 'INTERNO'
            ORDER BY nombre ASC
        ")->fetchAll();

        // Lista de sucursales
        $sucursales = $pdo->query("SELECT id, nombre, tiene_piscina, tiene_boxeo FROM sucursales WHERE estado = 'ACTIVA' ORDER BY id ASC")->fetchAll();
    } catch (PDOException $e) {
        $mensaje_error = 'Error al consultar clases: ' . $e->getMessage();
    }
}
