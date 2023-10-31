<?php
$host = "postgres"; // Reemplaza con el nombre del host de tu base de datos PostgreSQL
$database = "postgres"; // Reemplaza con el nombre de tu base de datos
$username = "postgres"; // Reemplaza con el nombre de usuario de la base de datos
$password = "admin"; // Reemplaza con la contraseña de la base de datos

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$database", $username, $password);
    // Resto de tu código
    echo 'exito';
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}