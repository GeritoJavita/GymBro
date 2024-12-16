<?php

$host = 'localhost';
$username = 'root'; 
$password = '';
$dbname = 'crud_db';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Error en la conexión: ' . $conn->connect_error);
}

?>

