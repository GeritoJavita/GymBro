<?php
session_start();
include("../php/database.php");

$pedido_id = $_POST['pedido_id'];
$metodo_pago = $_POST['metodo_pago'];

// Simulación de pago
$estado_pago = "Completado"; // Puedes alternar a "Pendiente" para simular otros casos.

$conn->query("INSERT INTO pagos (pedido_id, metodo_pago, estado_pago) 
              VALUES ($pedido_id, '$metodo_pago', '$estado_pago')");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Resumen de Pago | GYM BRO</title>
    <link rel="stylesheet" href="../css/realizado.css">
</head>
<body>
    <div class="container">
        <h2>Pago Realizado</h2>
        <p>Tu pago fue: <strong><?php echo $estado_pago; ?></strong></p>
        <p>Método de pago: <strong><?php echo htmlspecialchars($metodo_pago); ?></strong></p>
        <a href="../user/productos.php" class="cta-btn">Volver a la Tienda</a>
    </div>
</body>
</html>

