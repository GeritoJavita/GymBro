<?php
session_start();

if (isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];

    // Eliminar el producto del carrito
    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $index => $producto) {
            if ($producto['id'] == $producto_id) {
                unset($_SESSION['carrito'][$index]);
                break;
            }
        }

        // Reindexar el carrito después de eliminar un producto
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }
}

header('Location: carrito.php');
exit();
