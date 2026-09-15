<?php
// usuarios/controlador_usuarios.php - Lógica PHP para el mantenimiento y CRUD de usuarios

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
$usuario_activo_nombre = $_SESSION['nombre_completo'] ?? 'Usuario';
$usuario_activo_rol    = $_SESSION['rol'] ?? 'ADMINISTRADOR';
$usuario_activo_suc    = $_SESSION['sucursal'] ?? 'Central';
$iniciales_activo      = strtoupper(substr($usuario_activo_nombre, 0, 1));

// Procesamiento de formularios CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($pdo) && $pdo !== null) {
    $accion = trim($_POST['accion'] ?? '');

    // --------------------------------------------------------------------------
    // 1. CREAR NUEVO USUARIO
    // --------------------------------------------------------------------------
    if ($accion === 'crear') {
        $nombre       = trim($_POST['nombre'] ?? '');
        $apellido     = trim($_POST['apellido'] ?? '');
        $email        = trim($_POST['email'] ?? '');
        $usuario      = trim($_POST['usuario'] ?? '');
        $password     = trim($_POST['password'] ?? '');
        $telefono     = trim($_POST['telefono'] ?? '');
        $rol_id       = intval($_POST['rol_id'] ?? 0);
        $sucursal_id  = !empty($_POST['sucursal_id']) ? intval($_POST['sucursal_id']) : null;
        $tipo_persona = trim($_POST['tipo_persona'] ?? 'INTERNO');
        $huella       = trim($_POST['huella_dactilar_hash'] ?? '');

        if (empty($nombre) || empty($apellido) || empty($email) || empty($usuario) || empty($password) || $rol_id <= 0) {
            $mensaje_error = 'Por favor completa todos los campos obligatorios.';
        } else {
            try {
                // Verificar si usuario o email ya existen
                $check = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = :u OR email = :e LIMIT 1");
                $check->execute([':u' => $usuario, ':e' => $email]);
                if ($check->fetch()) {
                    $mensaje_error = 'El nombre de usuario o correo electrónico ya está registrado.';
                } else {
                    // Generar código de huella por defecto si viene vacío
                    if (empty($huella)) {
                        $huella = 'BIO-' . strtoupper(substr(md5(uniqid($usuario, true)), 0, 10));
                    }

                    // Encriptar contraseña con Bcrypt
                    $pass_hash = password_hash($password, PASSWORD_DEFAULT);

                    $insert = $pdo->prepare("
                        INSERT INTO usuarios 
                        (sucursal_id, rol_id, nombre, apellido, email, usuario, password, tipo_persona, huella_dactilar_hash, telefono, estado)
                        VALUES 
                        (:sucursal_id, :rol_id, :nombre, :apellido, :email, :usuario, :password, :tipo_persona, :huella, :telefono, 'ACTIVO')
                    ");

                    $insert->execute([
                        ':sucursal_id'  => $sucursal_id,
                        ':rol_id'       => $rol_id,
                        ':nombre'       => $nombre,
                        ':apellido'     => $apellido,
                        ':email'        => $email,
                        ':usuario'      => $usuario,
                        ':password'     => $pass_hash,
                        ':tipo_persona' => $tipo_persona,
                        ':huella'       => $huella,
                        ':telefono'     => $telefono
                    ]);

                    $mensaje_exito = "Usuario '{$usuario}' creado exitosamente con contraseña protegida.";
                }
            } catch (PDOException $e) {
                $mensaje_error = 'Error al crear usuario: ' . $e->getMessage();
            }
        }
    }

    // --------------------------------------------------------------------------
    // 2. EDITAR USUARIO EXISTENTE
    // --------------------------------------------------------------------------
    elseif ($accion === 'editar') {
        $id           = intval($_POST['id'] ?? 0);
        $nombre       = trim($_POST['nombre'] ?? '');
        $apellido     = trim($_POST['apellido'] ?? '');
        $email        = trim($_POST['email'] ?? '');
        $usuario      = trim($_POST['usuario'] ?? '');
        $password     = trim($_POST['password'] ?? '');
        $telefono     = trim($_POST['telefono'] ?? '');
        $rol_id       = intval($_POST['rol_id'] ?? 0);
        $sucursal_id  = !empty($_POST['sucursal_id']) ? intval($_POST['sucursal_id']) : null;
        $tipo_persona = trim($_POST['tipo_persona'] ?? 'INTERNO');
        $estado       = trim($_POST['estado'] ?? 'ACTIVO');
        $huella       = trim($_POST['huella_dactilar_hash'] ?? '');

        if ($id <= 0 || empty($nombre) || empty($apellido) || empty($email) || empty($usuario) || $rol_id <= 0) {
            $mensaje_error = 'Datos incompletos para actualizar el usuario.';
        } else {
            try {
                // Validar que usuario o email no estén tomados por otro ID
                $check = $pdo->prepare("SELECT id FROM usuarios WHERE (usuario = :u OR email = :e) AND id != :id LIMIT 1");
                $check->execute([':u' => $usuario, ':e' => $email, ':id' => $id]);
                if ($check->fetch()) {
                    $mensaje_error = 'El nombre de usuario o correo ya está en uso por otro registro.';
                } else {
                    if (!empty($password)) {
                        // Si enviaron nueva contraseña, actualizarla con hash
                        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
                        $update = $pdo->prepare("
                            UPDATE usuarios SET 
                                sucursal_id = :sucursal_id,
                                rol_id = :rol_id,
                                nombre = :nombre,
                                apellido = :apellido,
                                email = :email,
                                usuario = :usuario,
                                password = :password,
                                tipo_persona = :tipo_persona,
                                huella_dactilar_hash = :huella,
                                telefono = :telefono,
                                estado = :estado
                            WHERE id = :id
                        ");
                        $update->execute([
                            ':sucursal_id'  => $sucursal_id,
                            ':rol_id'       => $rol_id,
                            ':nombre'       => $nombre,
                            ':apellido'     => $apellido,
                            ':email'        => $email,
                            ':usuario'      => $usuario,
                            ':password'     => $pass_hash,
                            ':tipo_persona' => $tipo_persona,
                            ':huella'       => $huella,
                            ':telefono'     => $telefono,
                            ':estado'       => $estado,
                            ':id'           => $id
                        ]);
                    } else {
                        // Sin modificar la contraseña
                        $update = $pdo->prepare("
                            UPDATE usuarios SET 
                                sucursal_id = :sucursal_id,
                                rol_id = :rol_id,
                                nombre = :nombre,
                                apellido = :apellido,
                                email = :email,
                                usuario = :usuario,
                                tipo_persona = :tipo_persona,
                                huella_dactilar_hash = :huella,
                                telefono = :telefono,
                                estado = :estado
                            WHERE id = :id
                        ");
                        $update->execute([
                            ':sucursal_id'  => $sucursal_id,
                            ':rol_id'       => $rol_id,
                            ':nombre'       => $nombre,
                            ':apellido'     => $apellido,
                            ':email'        => $email,
                            ':usuario'      => $usuario,
                            ':tipo_persona' => $tipo_persona,
                            ':huella'       => $huella,
                            ':telefono'     => $telefono,
                            ':estado'       => $estado,
                            ':id'           => $id
                        ]);
                    }

                    $mensaje_exito = "Usuario '{$usuario}' actualizado correctamente.";
                }
            } catch (PDOException $e) {
                $mensaje_error = 'Error al actualizar usuario: ' . $e->getMessage();
            }
        }
    }

    // --------------------------------------------------------------------------
    // 3. ELIMINAR USUARIO
    // --------------------------------------------------------------------------
    elseif ($accion === 'eliminar') {
        $id = intval($_POST['id'] ?? 0);

        if ($id <= 0) {
            $mensaje_error = 'ID de usuario inválido.';
        } elseif ($id === intval($_SESSION['usuario_id'])) {
            $mensaje_error = 'No puedes eliminar tu propio usuario en sesión.';
        } else {
            try {
                // Intentar borrado físico; si falla por claves foráneas, realizar borrado lógico
                $delete = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
                $delete->execute([':id' => $id]);
                $mensaje_exito = "Usuario eliminado exitosamente.";
            } catch (PDOException $e) {
                // Borrado lógico como respaldo seguro
                try {
                    $softDelete = $pdo->prepare("UPDATE usuarios SET estado = 'INACTIVO' WHERE id = :id");
                    $softDelete->execute([':id' => $id]);
                    $mensaje_exito = "El usuario tiene registros históricos asociados; fue marcado como INACTIVO.";
                } catch (PDOException $ex) {
                    $mensaje_error = 'No fue posible eliminar el usuario: ' . $ex->getMessage();
                }
            }
        }
    }
}

// ------------------------------------------------------------------------------
// CONSULTAS PARA LLENAR LA TABLA Y SELECTS
// ------------------------------------------------------------------------------
$usuarios   = [];
$roles      = [];
$sucursales = [];

if (isset($pdo) && $pdo !== null) {
    try {
        // Listado de usuarios con nombre de rol y nombre de sucursal
        $queryUsuarios = $pdo->query("
            SELECT 
                u.id,
                u.sucursal_id,
                u.rol_id,
                u.nombre,
                u.apellido,
                u.email,
                u.usuario,
                u.tipo_persona,
                u.huella_dactilar_hash,
                u.telefono,
                u.estado,
                u.ultimo_login,
                u.created_at,
                r.nombre_rol,
                s.nombre AS sucursal_nombre,
                s.codigo_sucursal
            FROM usuarios u
            INNER JOIN roles r ON u.rol_id = r.id
            LEFT JOIN sucursales s ON u.sucursal_id = s.id
            ORDER BY u.id ASC
        ");
        $usuarios = $queryUsuarios->fetchAll();

        // Roles para los selects
        $queryRoles = $pdo->query("SELECT id, nombre_rol, descripcion FROM roles ORDER BY id ASC");
        $roles = $queryRoles->fetchAll();

        // Sucursales para los selects
        $querySucursales = $pdo->query("SELECT id, nombre, codigo_sucursal FROM sucursales WHERE estado = 'ACTIVA' ORDER BY id ASC");
        $sucursales = $querySucursales->fetchAll();

    } catch (PDOException $e) {
        $mensaje_error = 'Error al consultar la base de datos: ' . $e->getMessage();
    }
} else {
    $mensaje_error = 'Base de datos no conectada. Revisa la configuración en DB/conexion.php.';
}
