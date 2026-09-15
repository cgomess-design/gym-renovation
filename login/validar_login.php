<?php
// login/validar_login.php - Lógica de autenticación y control de sesión

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir conexión a la base de datos (ubicada en la carpeta DB)
require_once dirname(__DIR__) . '/DB/conexion.php';

// Variables de estado accesibles en la vista
$mensaje_error = '';
$mensaje_exito = '';

// Procesamiento del formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_input = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($login_input) || empty($password)) {
        $mensaje_error = 'Por favor, completa todos los campos.';
    } else {
        // 1. Verificación contra la base de datos MySQL
        if (isset($pdo) && $pdo !== null) {
            try {
                $sql = "SELECT u.*, r.nombre_rol, s.nombre AS sucursal_nombre 
                        FROM usuarios u
                        INNER JOIN roles r ON u.rol_id = r.id
                        LEFT JOIN sucursales s ON u.sucursal_id = s.id
                        WHERE (u.usuario = :login_user OR u.email = :login_email)
                        LIMIT 1";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':login_user'  => $login_input,
                    ':login_email' => $login_input
                ]);
                $usuario = $stmt->fetch();

                if ($usuario) {
                    // Validar estado de la cuenta
                    if ($usuario['estado'] !== 'ACTIVO') {
                        $mensaje_error = 'Tu cuenta se encuentra en estado: ' . htmlspecialchars($usuario['estado']);
                    } else {
                        // Diccionario de contraseñas de prueba iniciales
                        $claves_iniciales = [
                            'admin'     => 'admin123',
                            'gerente'   => 'gerente123',
                            'recepcion' => 'recep123',
                            'coach1'    => 'coach123',
                            'nutri'     => 'partner123',
                            'cliente1'  => 'cliente123'
                        ];

                        $login_key = strtolower($usuario['usuario']);
                        $clave_valida = false;

                        // Verificación segura con password_verify
                        if (password_verify($password, $usuario['password'])) {
                            $clave_valida = true;
                        } 
                        // Verificación en texto plano (durante pruebas iniciales)
                        elseif ($password === $usuario['password']) {
                            $clave_valida = true;
                        } 
                        // Verificación con clave semilla por defecto
                        elseif (isset($claves_iniciales[$login_key]) && $password === $claves_iniciales[$login_key]) {
                            $clave_valida = true;
                        }

                        if ($clave_valida) {
                            // Si la contraseña no cuenta con un hash nativo válido, se genera y actualiza en la BD
                            if (!password_verify($password, $usuario['password'])) {
                                try {
                                    $nuevoHash = password_hash($password, PASSWORD_DEFAULT);
                                    $updPass = $pdo->prepare("UPDATE usuarios SET password = :pwd WHERE id = :id");
                                    $updPass->execute([':pwd' => $nuevoHash, ':id' => $usuario['id']]);
                                } catch (Exception $e) {
                                    // Ignorar si no permite actualizar
                                }
                            }

                            // Almacenar información completa en la sesión
                            $_SESSION['usuario_id']      = $usuario['id'];
                            $_SESSION['usuario']         = $usuario['usuario'];
                            $_SESSION['nombre_completo'] = $usuario['nombre'] . ' ' . $usuario['apellido'];
                            $_SESSION['email']           = $usuario['email'];
                            $_SESSION['rol']             = $usuario['nombre_rol'];
                            $_SESSION['tipo_persona']    = $usuario['tipo_persona'];
                            $_SESSION['sucursal']        = $usuario['sucursal_nombre'] ?? 'Sin asignar';
                            $_SESSION['ultimo_login']    = $usuario['ultimo_login'] ?? date('Y-m-d H:i:s');

                            // Registrar marca de tiempo del último login en la base de datos
                            $updateStmt = $pdo->prepare("UPDATE usuarios SET ultimo_login = NOW() WHERE id = :id");
                            $updateStmt->execute([':id' => $usuario['id']]);

                            // Redirigir al dashboard dentro de la carpeta menu
                            header('Location: menu/dashboard.php');
                            exit;
                        } else {
                            $mensaje_error = 'Contraseña incorrecta.';
                        }
                    }
                } else {
                    $mensaje_error = 'Usuario o correo no encontrado.';
                }
            } catch (PDOException $e) {
                $mensaje_error = 'Error de consulta en la base de datos: ' . $e->getMessage();
            }
        } 
        // 2. Modo demostración si la base de datos aún no ha sido conectada
        else {
            if ($login_input === 'admin' && $password === 'admin123') {
                $_SESSION['usuario_id']      = 1;
                $_SESSION['usuario']         = 'admin';
                $_SESSION['nombre_completo'] = 'Carlos Mendoza (Demo)';
                $_SESSION['email']           = 'admin@gym.com';
                $_SESSION['rol']             = 'ADMINISTRADOR';
                $_SESSION['tipo_persona']    = 'INTERNO';
                $_SESSION['sucursal']        = 'Améliorant - Central Zona 10';
                $_SESSION['ultimo_login']    = date('Y-m-d H:i:s');

                header('Location: menu/dashboard.php');
                exit;
            } else {
                $mensaje_error = 'Base de datos no conectada. Importa database.sql en phpMyAdmin o usa usuario demo "admin" y contraseña "admin123".';
            }
        }
    }
}
