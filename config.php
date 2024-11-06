<?php
$host = 'localhost'; // Cambia esto si tu servidor está en otra dirección
$db = 'calzados_bc'; // Nombre de la base de datos
$user = 'root'; // Cambia esto con tu usuario de base de datos
$pass = ''; // Cambia esto con tu contraseña de base de datos

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
