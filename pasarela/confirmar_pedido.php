<?php
session_start();
include("../php/database.php");

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    header('Location: ../login/login.php');
    exit();
}

// Obtener el ID del usuario desde la sesión
$user_id = $_SESSION['id'];

// Obtener los productos y cantidades del formulario
$productos = $_POST['producto_id'] ?? [];
$cantidades = $_POST['cantidad'] ?? [];

$total_pedido = 0;

// Insertar pedido en la tabla 'pedidos'
$query = "INSERT INTO pedidos (usuario_id, fecha, total, estado_entrega) VALUES (?, NOW(), ?, 'Pendiente')";
$stmt = $conn->prepare($query);
$stmt->bind_param("id", $user_id, $total_pedido); // 'i' para entero y 'd' para decimal
$stmt->execute();
$pedido_id = $stmt->insert_id;

// Insertar cada producto en 'detalle_pedido'
foreach ($productos as $index => $producto_id) {
    $cantidad = $cantidades[$index];
    $precio_query = $conn->query("SELECT precio FROM productos WHERE id = $producto_id");
    $precio = $precio_query->fetch_assoc()['precio'];

    $total_pedido += $precio * $cantidad;

    $stmt = $conn->prepare("INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $pedido_id, $producto_id, $cantidad, $precio); // Usamos 'i' para enteros y 'd' para decimal
    $stmt->execute();
}

// Actualizar el total del pedido
$query = "UPDATE pedidos SET total = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("di", $total_pedido, $pedido_id); // 'd' para decimal y 'i' para entero
$stmt->execute();

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
