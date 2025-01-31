<?php
session_start();
include("../php/database.php");

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    header('Location: ../login/login.php');
    exit();
}

// Obtener el ID del usuario
$user_id = $_SESSION['id'];

// Datos del pedido
$productos = $_POST['producto_id'];
$cantidades = $_POST['cantidad'];

// Confirmar pedido
$conn->begin_transaction();
try {
    // Insertar el pedido
    $stmt = $conn->prepare("INSERT INTO pedidos (usuario_id, estado_entrega) VALUES (?, 'pendiente')");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $pedido_id = $stmt->insert_id;

    // Insertar los detalles del pedido
    $stmt = $conn->prepare("INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
    foreach ($productos as $index => $producto_id) {
        $cantidad = $cantidades[$index];
        // Obtener el precio del producto
        $stmt_precio = $conn->prepare("SELECT precio FROM productos WHERE id = ?");
        $stmt_precio->bind_param("i", $producto_id);
        $stmt_precio->execute();
        $result_precio = $stmt_precio->get_result();
        $producto = $result_precio->fetch_assoc();
        $precio = $producto['precio'];

        $stmt->bind_param("iiid", $pedido_id, $producto_id, $cantidad, $precio);
        $stmt->execute();
    }

    // Eliminar los productos del carrito
    $stmt = $conn->prepare("DELETE FROM carrito WHERE usuario_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Confirmar la transacción
    $conn->commit();
    header('Location: ../user/pedidos.php');
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conn->rollback();
    echo "Error al confirmar el pedido: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <title>Pago | GYM BRO</title>
    <link rel="stylesheet" href="../css/pago.css">
</head>
<body>

    <form method="POST" action="procesar_pago.php">
        <input type="hidden" name="pedido_id" value="<?php echo $pedido_id; ?>">
        <label for="metodo_pago">Método de Pago:</label>
        <select name="metodo_pago" required>
            <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
            <option value="PayPal">PayPal</option>
            <option value="Transferencia Bancaria">Transferencia Bancaria</option>
        </select>
        <button type="submit" class="cta-btn">Pagar</button>
    </form>
</body>
</html>
