<?php
include('../php/database.php');

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: ../admin/administrar_productos.php');
    exit();
} else {
    echo "Error al eliminar el producto";
}
?>
