<?php

// Importar la conexion
require 'includes/config/database.php';
$db = conectarDB();

// Crear email y pass
$email = 'giogio@correo.com';
$password = '123456';

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

// Query para crear el usuario

$query = "INSERT INTO usuarios (nombre, contrasena, rol) VALUES ('$email','$passwordHash',1);";
echo $query;
exit;

// Agregarlo a la BD
mysqli_query($db, $query);

?>