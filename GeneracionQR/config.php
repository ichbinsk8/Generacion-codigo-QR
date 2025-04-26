<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";  // Cambia este valor con tu usuario de MySQL
$password = "";      // Cambia este valor con tu contraseña de MySQL
$dbname = "qr";  // Nombre de tu base de datos

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
