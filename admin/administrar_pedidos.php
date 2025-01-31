<?php
include('../php/database.php');

// Obtener los pedidos con su respectivo estado de entrega y pago
$result = $conn->query("SELECT p.id, p.fecha, u.username AS usuario, SUM(dp.cantidad * dp.precio) AS total,
                               p.estado_entrega, py.metodo_pago, py.estado_pago
                        FROM pedidos p
                        JOIN usuarios u ON p.usuario_id = u.id
                        JOIN detalle_pedido dp ON p.id = dp.pedido_id
                        LEFT JOIN pagos py ON p.id = py.pedido_id
                        GROUP BY p.id, p.fecha, u.username, p.estado_entrega, py.metodo_pago, py.estado_pago");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Pedidos</title>
    <link rel="stylesheet" href="../css/admin_producto.css">
</head>
<body>
    <div class="container">
        <h2>Listado de Pedidos</h2>
      
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Total</th>
                    <th>Estado Entrega</th>
                    <th>Método de Pago</th>
                    <th>Estado Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pedido = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $pedido['id']; ?></td>
                    <td><?php echo $pedido['fecha']; ?></td>
                    <td><?php echo $pedido['usuario']; ?></td>
                    <td><?php echo number_format($pedido['total'], 2, ',', '.'); ?></td>
                    <td><?php echo $pedido['estado_entrega']; ?></td>
                    <td><?php echo $pedido['metodo_pago']; ?></td>
                    <td><?php echo $pedido['estado_pago']; ?></td>
                    <td>
                        <a href="ver_pedido.php?id=<?php echo $pedido['id']; ?>">Ver</a> |
                        <a href="../crud_pedidos/eliminar_pe.php?id=<?php echo $pedido['id']; ?>" class="delete-btn" onclick="return confirm('¿Seguro que deseas eliminar este pedido?')">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="../admin/admin_dashboard.php" class="add-btn">Volver al Inicio</a>
    </div>
</body>
</html>
