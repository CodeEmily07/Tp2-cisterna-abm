<?php
// Ajustar estos datos si MySQL fue configurado con otro usuario o contraseña.
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$base_datos = 'escuela';

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conexion->connect_error) {
    die('No se pudo conectar con la base de datos: ' . htmlspecialchars($conexion->connect_error));
}

$conexion->set_charset('utf8mb4');
?>
