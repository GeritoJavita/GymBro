<?php
session_start();
include("../php/database.php");

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
    exit();
}

// Obtener el ID del producto del formulario
if (isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];

    // Obtener información del producto desde la base de datos
    $query = "SELECT * FROM productos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $producto_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    if ($producto) {
        // Si el carrito no existe, lo creamos como un array
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Verificamos si el producto ya está en el carrito
        $producto_encontrado = false;
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['id'] == $producto['id']) {
                $item['cantidad']++;
                $producto_encontrado = true;
                break;
            }
        }

        // Si el producto no está en el carrito, lo agregamos
        if (!$producto_encontrado) {
            $producto['cantidad'] = 1; // Añadimos el campo cantidad
            $_SESSION['carrito'][] = $producto;
        }
    }

    // Redirigir de nuevo a la página de productos
    header('Location: ../user/productos.php');
    exit();
} else {
    // Si no se recibe un ID de producto, redirigimos al usuario de vuelta
    header('Location: ../user/productos.php');
    exit();
}
