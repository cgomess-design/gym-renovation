<?php
// DB/conexion.php - Conexión a la base de datos MySQL mediante PDO

$host = '127.0.0.1:3307';
$dbname = 'gym_renovation';
$user = 'root';
$pass = '123456';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$opciones = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $opciones);
} catch (PDOException $e) {
    // Si la base de datos aún no ha sido creada o MySQL está apagado
    $pdo = null;
    $error_conexion = $e->getMessage();
}
