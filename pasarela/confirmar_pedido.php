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

// Insertar pedido en la tabla 'pedidos'
$query = "INSERT INTO pedidos (usuario_id, fecha) VALUES (?, NOW())";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id); // 'i' es para entero
$stmt->execute();
$pedido_id = $stmt->insert_id;

// Insertar cada producto en 'detalle_pedido'
foreach ($productos as $index => $producto_id) {
    $cantidad = $cantidades[$index];
    $precio_query = $conn->query("SELECT precio FROM productos WHERE id = $producto_id");
    $precio = $precio_query->fetch_assoc()['precio'];

    $stmt = $conn->prepare("INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiii", $pedido_id, $producto_id, $cantidad, $precio); // Usamos 'i' para enteros
    $stmt->execute();
}



?>


<!DOCTYPE html>
<html lang="es">
<head>
    <title>Pago | GYM BRO</title>
    <link rel="stylesheet" href="../css/style_dashboard.css">
</head>
<body>
    <h1>Elige un método de pago</h1>
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
