<?php
// inventario/controlador_inventario.php - Lógica PHP para el Inventario de Equipos y Certificados

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

// Auto-sembrado de equipos si la tabla está vacía
if (isset($pdo) && $pdo !== null) {
    try {
        $countEq = $pdo->query("SELECT COUNT(*) FROM equipos_inventario")->fetchColumn();
        if ($countEq == 0) {
            $pdo->exec("
                INSERT INTO equipos_inventario 
                (codigo_inventario, sucursal_id, nombre_equipo, categoria, tiene_certificado_calidad, numero_certificado, fecha_adquisicion, estado_operativo) 
                VALUES
                ('EQ-CARD-101', 1, 'Caminadora Profesional Matrix T70 Cardio', 'CARDIO', 1, 'CERT-ISO-9001-MTX-101', '2025-11-15', 'OPERATIVO'),
                ('EQ-PESA-201', 1, 'Set Mancuernas de Uretano 5-50 lbs con Rack', 'PESAS', 1, 'CERT-CALIDAD-100-USA-201', '2025-10-10', 'OPERATIVO'),
                ('EQ-SILL-301', 1, 'Sillón de Masaje 4D Zero Gravity Améliorant', 'SILLON_MASAJE', 1, 'CERT-CE-HEALTH-4D-301', '2026-01-20', 'OPERATIVO'),
                ('EQ-BOXE-401', 1, 'Ring Oficial de Boxeo 6x6 con Suelo Acolchado', 'BOXEO', 1, 'CERT-WBC-STD-2026-401', '2025-12-05', 'OPERATIVO'),
                ('EQ-PISC-501', 1, 'Sistema de Filtrado y Cloración Olímpica', 'PISCINA', 1, 'CERT-AQUA-HYGIENE-100', '2026-02-01', 'OPERATIVO'),
                ('EQ-CARD-102', 2, 'Bicicleta de Spinning Magnética Schwinn', 'CARDIO', 1, 'CERT-ISO-9001-SCHW-102', '2026-01-15', 'EN_MANTENIMIENTO');
            ");
        }
    } catch (Exception $e) {
        // Silencioso
    }
}

// Procesamiento de acciones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($pdo) && $pdo !== null) {
    $accion = trim($_POST['accion'] ?? '');

    // 1. CREAR EQUIPO
    if ($accion === 'crear') {
        $codigo         = trim($_POST['codigo_inventario'] ?? '');
        $nombre         = trim($_POST['nombre_equipo'] ?? '');
        $categoria      = trim($_POST['categoria'] ?? 'PESAS');
        $sucursal_id    = intval($_POST['sucursal_id'] ?? 1);
        $certificado    = trim($_POST['numero_certificado'] ?? '');
        $fecha_adq      = !empty($_POST['fecha_adquisicion']) ? $_POST['fecha_adquisicion'] : date('Y-m-d');
        $estado         = trim($_POST['estado_operativo'] ?? 'OPERATIVO');
        $orden_compra   = !empty($_POST['orden_compra_id']) ? intval($_POST['orden_compra_id']) : null;

        if (empty($codigo)) {
            $codigo = 'EQ-' . strtoupper(substr($categoria, 0, 4)) . '-' . mt_rand(100, 999);
        }
        if (empty($certificado)) {
            $certificado = 'CERT-CALIDAD-100-' . strtoupper(substr(md5(uniqid()), 0, 6));
        }

        if (empty($nombre) || $sucursal_id <= 0) {
            $mensaje_error = 'El nombre del equipo y la sucursal son campos obligatorios.';
        } else {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO equipos_inventario 
                    (codigo_inventario, sucursal_id, orden_compra_id, nombre_equipo, categoria, tiene_certificado_calidad, numero_certificado, fecha_adquisicion, estado_operativo)
                    VALUES 
                    (:cod, :suc, :oc, :nom, :cat, 1, :cert, :fec, :est)
                ");
                $stmt->execute([
                    ':cod'  => $codigo,
                    ':suc'  => $sucursal_id,
                    ':oc'   => $orden_compra,
                    ':nom'  => $nombre,
                    ':cat'  => $categoria,
                    ':cert' => $certificado,
                    ':fec'  => $fecha_adq,
                    ':est'  => $estado
                ]);
                $mensaje_exito = "Equipo <strong>{$nombre}</strong> registrado con código <strong>{$codigo}</strong> y Certificado 100% Calidad.";
            } catch (PDOException $e) {
                $mensaje_error = 'Error al registrar el equipo: ' . $e->getMessage();
            }
        }
    }

    // 2. EDITAR EQUIPO
    elseif ($accion === 'editar') {
        $id          = intval($_POST['id'] ?? 0);
        $codigo      = trim($_POST['codigo_inventario'] ?? '');
        $nombre      = trim($_POST['nombre_equipo'] ?? '');
        $categoria   = trim($_POST['categoria'] ?? 'PESAS');
        $sucursal_id = intval($_POST['sucursal_id'] ?? 1);
        $estado      = trim($_POST['estado_operativo'] ?? 'OPERATIVO');
        $certificado = trim($_POST['numero_certificado'] ?? '');

        if ($id <= 0 || empty($nombre)) {
            $mensaje_error = 'Datos inválidos para actualizar el equipo.';
        } else {
            try {
                $stmt = $pdo->prepare("
                    UPDATE equipos_inventario 
                    SET codigo_inventario = :cod, nombre_equipo = :nom, categoria = :cat, sucursal_id = :suc, estado_operativo = :est, numero_certificado = :cert
                    WHERE id = :id
                ");
                $stmt->execute([
                    ':cod'  => $codigo,
                    ':nom'  => $nombre,
                    ':cat'  => $categoria,
                    ':suc'  => $sucursal_id,
                    ':est'  => $estado,
                    ':cert' => $certificado,
                    ':id'   => $id
                ]);
                $mensaje_exito = 'Ficha del equipo actualizada correctamente.';
            } catch (PDOException $e) {
                $mensaje_error = 'Error al actualizar equipo: ' . $e->getMessage();
            }
        }
    }

    // 3. DAR DE BAJA
    elseif ($accion === 'eliminar') {
        $id = intval($_POST['id'] ?? 0);
        if ($id > 0) {
            try {
                $stmt = $pdo->prepare("UPDATE equipos_inventario SET estado_operativo = 'DE_BAJA' WHERE id = :id");
                $stmt->execute([':id' => $id]);
                $mensaje_exito = 'El equipo ha sido marcado como DE BAJA.';
            } catch (PDOException $e) {
                $mensaje_error = 'Error al cambiar estado del equipo: ' . $e->getMessage();
            }
        }
    }
}

// ------------------------------------------------------------------------------
// CONSULTAS PARA LA VISTA
// ------------------------------------------------------------------------------
$equipos = [];
$sucursales = [];
$ordenes_lista = [];

if (isset($pdo) && $pdo !== null) {
    try {
        $query = "
            SELECT 
                eq.id,
                eq.codigo_inventario,
                eq.sucursal_id,
                eq.orden_compra_id,
                eq.nombre_equipo,
                eq.categoria,
                eq.tiene_certificado_calidad,
                eq.numero_certificado,
                eq.fecha_adquisicion,
                eq.estado_operativo,
                s.nombre AS sucursal_nombre,
                oc.numero_orden
            FROM equipos_inventario eq
            INNER JOIN sucursales s ON eq.sucursal_id = s.id
            LEFT JOIN ordenes_compra oc ON eq.orden_compra_id = oc.id
            ORDER BY eq.id DESC
        ";
        $equipos = $pdo->query($query)->fetchAll();
        $sucursales = $pdo->query("SELECT id, nombre FROM sucursales WHERE estado = 'ACTIVA' ORDER BY id ASC")->fetchAll();
        $ordenes_lista = $pdo->query("SELECT id, numero_orden FROM ordenes_compra ORDER BY id DESC")->fetchAll();
    } catch (PDOException $e) {
        $mensaje_error = 'Error al consultar inventario: ' . $e->getMessage();
    }
}
