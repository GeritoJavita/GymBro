<?php
session_start();
include("../php/database.php");

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    header('Location: ../login/login.php');
    exit();
}

// Verificar que se han enviado los datos necesarios
if (!isset($_POST['pedido_id']) || !isset($_POST['metodo_pago'])) {
    echo "Error: Datos incompletos.";
    exit();
}

$pedido_id = $_POST['pedido_id'];
$metodo_pago = $_POST['metodo_pago'];

// Confirmar el pago e insertar en la tabla de pagos
try {
    $query = "INSERT INTO pagos (pedido_id, metodo_pago, estado_pago) VALUES (?, ?, 'Completado')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $pedido_id, $metodo_pago); // 'i' para entero y 's' para string
    $stmt->execute();
    
    echo "Pago confirmado con éxito.";
    header('Location: ../user/pedidos.php');
} catch (Exception $e) {
    echo "Error al procesar el pago: " . $e->getMessage();
}
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

