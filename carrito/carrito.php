<?php
session_start();
include("../php/database.php");

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
    exit();
}

// Obtener el ID del usuario
$user_id = $_SESSION['id'];

// Recuperar los productos del carrito desde la base de datos
$query = "SELECT p.nombre, p.precio, p.imagen, c.cantidad, c.producto_id FROM carrito c INNER JOIN productos p ON c.producto_id = p.id WHERE c.usuario_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$carrito = [];
while ($row = $result->fetch_assoc()) {
    $carrito[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - GYM | BRO</title>
    <link rel="stylesheet" href="../css/style_gym.css">
    <link rel="stylesheet" href="../css/style_index.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../user/productos.php">Productos</a></li>
                <li><a href="carrito.php">Carrito</a></li>
                <li><a href="../user/perfil.php">Perfil</a></li>
                <li><a href="../logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <h1>Tu Carrito de Compras</h1>

        <?php if (!empty($carrito)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carrito as $item): ?>
                        <tr>
                            <td><?php echo $item['nombre']; ?></td>
                            <td><?php echo $item['cantidad']; ?></td>
                            <td>$<?php echo $item['precio']; ?></td>
                            <td>$<?php echo $item['precio'] * $item['cantidad']; ?></td>
                            <td>
                                <form action="eliminar_carrito.php" method="POST">
                                    <input type="hidden" name="producto_id" value="<?php echo $item['producto_id']; ?>">
                                    <button type="submit">Eliminar</button>
                                </form>
                                <form action="../pasarela/metodos_pago.php" method="POST">
                                    <?php foreach ($carrito as $producto): ?>
                                    <input type="hidden" name="producto_id[]" value="<?php echo $producto['producto_id']; ?>">
                                    <input type="hidden" name="cantidad[]" value="<?php echo $producto['cantidad']; ?>">
                                    <?php endforeach; ?>
                                    <button type="submit">Confirmar Pedido</button>
                                    </form>
                                    
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="../pasarela/metodos_pago.php" class="cta-btn">Proceder al Pago</a>
        <?php else: ?>
            <p>Tu carrito está vacío.</p>
        <?php endif; ?>
    </main>

</body>
</html>
