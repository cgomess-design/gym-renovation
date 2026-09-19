<?php
// inscripciones/controlador_inscripciones.php - Lógica PHP para el mantenimiento de Inscripciones y Membresías

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

// Variables de sesión del usuario logueado
$usuario_activo_id     = $_SESSION['usuario_id'] ?? 1;
$usuario_activo_nombre = $_SESSION['nombre_completo'] ?? 'Usuario';
$usuario_activo_rol    = $_SESSION['rol'] ?? 'ADMINISTRADOR';
$usuario_activo_suc    = $_SESSION['sucursal'] ?? 'Central';
$iniciales_activo      = strtoupper(substr($usuario_activo_nombre, 0, 1));

// Procesamiento de acciones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($pdo) && $pdo !== null) {
    $accion = trim($_POST['accion'] ?? '');

    // --------------------------------------------------------------------------
    // 1. CREAR NUEVA INSCRIPCIÓN / AFILIACIÓN
    // --------------------------------------------------------------------------
    if ($accion === 'crear') {
        $cliente_id    = intval($_POST['cliente_id'] ?? 0);
        $membresia_id  = intval($_POST['membresia_id'] ?? 1);
        $sucursal_id   = intval($_POST['sucursal_id'] ?? 1);
        $metodo_pago   = trim($_POST['metodo_pago'] ?? 'TARJETA');
        $monto         = floatval($_POST['monto'] ?? 250.00);
        $fecha_inicio  = !empty($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : date('Y-m-d');
        $fecha_fin     = !empty($_POST['fecha_fin']) ? $_POST['fecha_fin'] : date('Y-m-d', strtotime('+1 month', strtotime($fecha_inicio)));
        $renovacion    = isset($_POST['renovacion_automatica']) ? 1 : 0;

        if ($cliente_id <= 0 || $membresia_id <= 0 || $sucursal_id <= 0) {
            $mensaje_error = 'Por favor selecciona el cliente, el plan de membresía y la sucursal.';
        } else {
            try {
                $pdo->beginTransaction();

                // 1. Insertar suscripción en clientes_membresias
                $stmtIns = $pdo->prepare("
                    INSERT INTO clientes_membresias 
                    (usuario_id, membresia_id, sucursal_id, fecha_inicio, fecha_fin, renovacion_automatica, estado)
                    VALUES 
                    (:usuario_id, :membresia_id, :sucursal_id, :fecha_inicio, :fecha_fin, :renovacion, 'VIGENTE')
                ");
                $stmtIns->execute([
                    ':usuario_id'    => $cliente_id,
                    ':membresia_id'  => $membresia_id,
                    ':sucursal_id'   => $sucursal_id,
                    ':fecha_inicio'  => $fecha_inicio,
                    ':fecha_fin'     => $fecha_fin,
                    ':renovacion'    => $renovacion
                ]);

                // 2. Generar factura automática
                $numFactura = 'FAC-' . date('Y') . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
                $stmtFac = $pdo->prepare("
                    INSERT INTO facturas 
                    (numero_factura, cliente_id, membresia_id, sucursal_id, recepcionista_id, monto, metodo_pago, fecha_emision)
                    VALUES 
                    (:num, :cli, :mem, :suc, :rec, :monto, :metodo, NOW())
                ");
                $stmtFac->execute([
                    ':num'    => $numFactura,
                    ':cli'    => $cliente_id,
                    ':mem'    => $membresia_id,
                    ':suc'    => $sucursal_id,
                    ':rec'    => $usuario_activo_id,
                    ':monto'  => $monto,
                    ':metodo' => $metodo_pago
                ]);

                // 3. Registrar bono por recomendación/referido si aplica
                $referidor_id = intval($_POST['referidor_id'] ?? 0);
                $bonoOtorgado = 0;
                if ($referidor_id > 0 && $referidor_id !== $cliente_id) {
                    $bonoOtorgado = ($membresia_id == 2) ? 150.00 : 100.00;
                    $stmtRef = $pdo->prepare("
                        INSERT INTO referidos 
                        (cliente_referidor_id, cliente_referido_id, membresia_id, bono_otorgado, estado_bono, fecha_referido)
                        VALUES 
                        (:ref_id, :cli_id, :mem_id, :bono, 'PENDIENTE', NOW())
                        ON DUPLICATE KEY UPDATE bono_otorgado = :bono
                    ");
                    $stmtRef->execute([
                        ':ref_id' => $referidor_id,
                        ':cli_id' => $cliente_id,
                        ':mem_id' => $membresia_id,
                        ':bono'   => $bonoOtorgado
                    ]);
                }

                $pdo->commit();
                $mensaje_exito = "Inscripción registrada con éxito. Factura emitida: <strong>{$numFactura}</strong> por Q" . number_format($monto, 2);
                if ($bonoOtorgado > 0) {
                    $mensaje_exito .= " ¡Bono de recomendación de <strong>Q" . number_format($bonoOtorgado, 2) . "</strong> acreditado en estado Pendiente al cliente referidor!";
                }
            } catch (Exception $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                $mensaje_error = 'Error al registrar la inscripción: ' . $e->getMessage();
            }
        }
    }

    // --------------------------------------------------------------------------
    // 2. EDITAR INSCRIPCIÓN EXISTENTE
    // --------------------------------------------------------------------------
    elseif ($accion === 'editar') {
        $id           = intval($_POST['id'] ?? 0);
        $membresia_id = intval($_POST['membresia_id'] ?? 1);
        $sucursal_id  = intval($_POST['sucursal_id'] ?? 1);
        $fecha_inicio = trim($_POST['fecha_inicio'] ?? '');
        $fecha_fin    = trim($_POST['fecha_fin'] ?? '');
        $estado       = trim($_POST['estado'] ?? 'VIGENTE');
        $renovacion   = isset($_POST['renovacion_automatica']) ? 1 : 0;

        if ($id <= 0 || empty($fecha_inicio) || empty($fecha_fin)) {
            $mensaje_error = 'Datos inválidos para actualizar la inscripción.';
        } else {
            try {
                $stmtEdit = $pdo->prepare("
                    UPDATE clientes_membresias 
                    SET membresia_id = :mem, sucursal_id = :suc, fecha_inicio = :fi, fecha_fin = :ff, estado = :est, renovacion_automatica = :ren
                    WHERE id = :id
                ");
                $stmtEdit->execute([
                    ':mem' => $membresia_id,
                    ':suc' => $sucursal_id,
                    ':fi'  => $fecha_inicio,
                    ':ff'  => $fecha_fin,
                    ':est' => $estado,
                    ':ren' => $renovacion,
                    ':id'  => $id
                ]);

                $mensaje_exito = 'Inscripción actualizada exitosamente.';
            } catch (PDOException $e) {
                $mensaje_error = 'Error al actualizar inscripción: ' . $e->getMessage();
            }
        }
    }

    // --------------------------------------------------------------------------
    // 3. CANCELAR / DAR DE BAJA INSCRIPCIÓN
    // --------------------------------------------------------------------------
    elseif ($accion === 'eliminar') {
        $id = intval($_POST['id'] ?? 0);
        if ($id > 0) {
            try {
                // Marcar como cancelada para mantener histórico de facturación
                $stmtDel = $pdo->prepare("UPDATE clientes_membresias SET estado = 'CANCELADA', renovacion_automatica = 0 WHERE id = :id");
                $stmtDel->execute([':id' => $id]);
                $mensaje_exito = 'La membresía ha sido cancelada exitosamente.';
            } catch (PDOException $e) {
                $mensaje_error = 'Error al cancelar la membresía: ' . $e->getMessage();
            }
        }
    }
}

// ------------------------------------------------------------------------------
// CONSULTAS PARA LA VISTA
// ------------------------------------------------------------------------------
$inscripciones = [];
$clientes_disponibles = [];
$membresias_catalogo = [];
$sucursales_lista = [];

if (isset($pdo) && $pdo !== null) {
    try {
        // 1. Listado principal de inscripciones
        $query = "
            SELECT 
                cm.id,
                cm.usuario_id,
                cm.membresia_id,
                cm.sucursal_id,
                cm.fecha_inicio,
                cm.fecha_fin,
                cm.renovacion_automatica,
                cm.estado,
                cm.created_at,
                u.nombre AS cliente_nombre,
                u.apellido AS cliente_apellido,
                u.email AS cliente_email,
                u.telefono AS cliente_telefono,
                u.usuario AS cliente_usuario,
                m.nombre AS plan_nombre,
                m.precio_mes,
                m.descuento_parqueo,
                m.coaching_semanal,
                m.dias_prueba_terceros,
                m.bono_referido,
                m.acceso_piscina_boxeo,
                m.usos_sillones_masaje_semana,
                m.descuento_terceros,
                s.nombre AS sucursal_nombre,
                f.numero_factura,
                f.monto AS monto_pagado,
                f.metodo_pago
            FROM clientes_membresias cm
            INNER JOIN usuarios u ON cm.usuario_id = u.id
            INNER JOIN membresias m ON cm.membresia_id = m.id
            INNER JOIN sucursales s ON cm.sucursal_id = s.id
            LEFT JOIN facturas f ON f.cliente_id = cm.usuario_id AND f.membresia_id = cm.membresia_id
            ORDER BY cm.id DESC
        ";
        $inscripciones = $pdo->query($query)->fetchAll();

        // 2. Catálogo de clientes para el select
        $clientes_disponibles = $pdo->query("
            SELECT id, nombre, apellido, email, usuario 
            FROM usuarios 
            WHERE tipo_persona = 'CLIENTE' OR rol_id = 9
            ORDER BY nombre ASC
        ")->fetchAll();

        // Si no hay usuarios de tipo cliente, cargar todos los usuarios como opción
        if (empty($clientes_disponibles)) {
            $clientes_disponibles = $pdo->query("SELECT id, nombre, apellido, email, usuario FROM usuarios ORDER BY nombre ASC")->fetchAll();
        }

        // 3. Catálogo de membresías
        $membresias_catalogo = $pdo->query("SELECT * FROM membresias WHERE estado = 'ACTIVA' ORDER BY precio_mes ASC")->fetchAll();

        // 4. Catálogo de sucursales
        $sucursales_lista = $pdo->query("SELECT id, nombre, codigo_sucursal FROM sucursales WHERE estado = 'ACTIVA' ORDER BY id ASC")->fetchAll();

    } catch (PDOException $e) {
        $mensaje_error = 'Error al cargar los datos de inscripciones: ' . $e->getMessage();
    }
}
