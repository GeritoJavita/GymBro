<?php
include('php/database.php');

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: administrar_usuarios.php');
    exit();
} else {
    echo "Error al eliminar el usuario";
}
?>
