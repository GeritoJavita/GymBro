<?php
session_start();
include("../php/database.php");

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    header('Location: ../login/login.php');
    exit();
}

// Obtener el ID del pedido desde el formulario
$pedido_id = $_POST['pedido_id'];

// Eliminar los pagos asociados al pedido de la base de datos
$query = "DELETE FROM pagos WHERE pedido_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $pedido_id);
$stmt->execute();

// Eliminar los detalles del pedido de la base de datos
$query = "DELETE FROM detalle_pedido WHERE pedido_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $pedido_id);
$stmt->execute();

// Eliminar el pedido de la base de datos
$query = "DELETE FROM pedidos WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $pedido_id);
$stmt->execute();

// Redirigir de vuelta a la página de pedidos
header('Location: ../user/pedidos.php');
exit();
?>
