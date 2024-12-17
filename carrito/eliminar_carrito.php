<?php
session_start();
include("../php/database.php");

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
    exit();
}

// Verificar si se recibió el ID del producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];
    $user_id = $_SESSION['id'];

    // Eliminar el producto del carrito
    $query = "DELETE FROM carrito WHERE producto_id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $producto_id, $user_id);

    if ($stmt->execute()) {
        // Redirigir al carrito con un mensaje de éxito
        $_SESSION['success_message'] = "Producto eliminado del carrito.";
    } else {
        // Redirigir al carrito con un mensaje de error
        $_SESSION['error_message'] = "No se pudo eliminar el producto del carrito.";
    }

    $stmt->close();
    $conn->close();
    header('Location: carrito.php');
    exit();
} else {
    // Redirigir al carrito si no hay datos válidos
    header('Location: carrito.php');
    exit();
}
