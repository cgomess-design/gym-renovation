<?php
// login/logout.php - Cierre de sesión seguro

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Limpiar todas las variables de sesión
$_SESSION = [];

// Si se utilizan cookies de sesión, destruirla también
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destruir la sesión por completo
session_destroy();

// Redirigir a la pantalla de login con parámetro informativo
header("Location: ../index.php?logout=1");
exit;
