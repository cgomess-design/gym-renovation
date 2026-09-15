<?php
// menu/controlador_dashboard.php - Lógica PHP pura del Dashboard (protección y datos de sesión)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Protección de ruta: Si no hay sesión activa, redirigir al login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit;
}

// 2. Extracción de los datos del usuario conectado desde la sesión
$usuario_id      = $_SESSION['usuario_id'];
$usuario_login   = $_SESSION['usuario'] ?? 'usuario';
$nombre_completo = $_SESSION['nombre_completo'] ?? 'Usuario del Sistema';
$email           = $_SESSION['email'] ?? 'correo@gym.com';
$rol             = $_SESSION['rol'] ?? 'ADMINISTRADOR';
$tipo_persona    = $_SESSION['tipo_persona'] ?? 'INTERNO';
$sucursal        = $_SESSION['sucursal'] ?? 'Améliorant - Central Zona 10';
$ultimo_login    = $_SESSION['ultimo_login'] ?? date('Y-m-d H:i:s');

// 3. Generación de iniciales para el avatar del perfil
$partes_nombre = explode(' ', trim($nombre_completo));
$iniciales = strtoupper(
    substr($partes_nombre[0], 0, 1) . 
    (isset($partes_nombre[1]) ? substr($partes_nombre[1], 0, 1) : '')
);

// 4. Determinación de la clase visual para el badge según el rol
$badge_class = 'badge-role-admin';
if (stripos($rol, 'GERENTE') !== false) {
    $badge_class = 'badge-role-gerente';
} elseif (stripos($rol, 'RECEPCION') !== false) {
    $badge_class = 'badge-role-recepcion';
} elseif (stripos($rol, 'COACH') !== false) {
    $badge_class = 'badge-role-coach';
} elseif (stripos($rol, 'PARTNER') !== false) {
    $badge_class = 'badge-role-partner';
} elseif (stripos($rol, 'CLIENTE') !== false) {
    $badge_class = 'badge-role-cliente';
}

// 5. Fecha actual formateada
$fecha_actual = date('d/m/Y');
