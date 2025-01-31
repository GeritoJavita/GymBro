<?php
include('../php/database.php');

$id = $_GET['id'];

// Eliminar los registros de pagos asociados al pedido
$stmt_pagos = $conn->prepare("DELETE FROM pagos WHERE pedido_id = ?");
$stmt_pagos->bind_param("i", $id);

if ($stmt_pagos->execute()) {
    // Eliminar los registros de detalle_pedido asociados al pedido
    $stmt_detalle = $conn->prepare("DELETE FROM detalle_pedido WHERE pedido_id = ?");
    $stmt_detalle->bind_param("i", $id);

    if ($stmt_detalle->execute()) {
        // Luego, eliminar el pedido
        $stmt = $conn->prepare("DELETE FROM pedidos WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header('Location: ../admin/administrar_pedidos.php');
            exit();
        } else {
            echo "Error al eliminar el pedido.";
        }
    } else {
        echo "Error al eliminar los detalles del pedido.";
    }
} else {
    echo "Error al eliminar los pagos asociados al pedido.";
}

$stmt_pagos->close();
$stmt_detalle->close();
$stmt->close();
$conn->close();
?>
