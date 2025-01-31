<?php
include('../php/database.php');

$id = $_GET['id'];

// Eliminar los registros del carrito asociados al usuario
$stmt_carrito = $conn->prepare("DELETE FROM carrito WHERE usuario_id = ?");
$stmt_carrito->bind_param("i", $id);

if ($stmt_carrito->execute()) {
    // Luego, eliminar el usuario
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: ../admin/administrar_usuarios.php');
        exit();
    } else {
        echo "Error al eliminar el usuario.";
    }
} else {
    echo "Error al eliminar los registros del carrito.";
}

$stmt_carrito->close();
$stmt->close();
$conn->close();
?>
