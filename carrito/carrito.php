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
    <!-- Fuentes y Estilos -->
    <link rel="stylesheet" href="../css/carrito.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Encabezado -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="../index.php">GYM | BRO</a>
            </div>
            <ul class="nav-links">
                <li><a href="../user/productos.php">Productos</a></li>
                <li><a href="carrito.php">Carrito</a></li>
                <li><a href="../user/perfil.php">Perfil</a></li>
                <li><a href="../logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <!-- Contenido Principal -->
    <main class="main-content">
        <h1>Tu Carrito de Compras</h1>

        <?php if (!empty($carrito)): ?>
            <!-- Lista de Productos en el Carrito -->
            <div class="carrito-container">
                <?php foreach ($carrito as $item): ?>
                    <div class="carrito-item">
                        <img src="<?php echo $item['imagen']; ?>" alt="<?php echo $item['nombre']; ?>" class="carrito-imagen">
                        <div class="carrito-detalles">
                            <h3><?php echo $item['nombre']; ?></h3>
                            <p>Cantidad: <?php echo $item['cantidad']; ?></p>
                            <p>Precio: $<?php echo $item['precio']; ?></p>
                            <p>Total: $<?php echo $item['precio'] * $item['cantidad']; ?></p>
                            <!-- Botón para eliminar producto -->
                            <form action="eliminar_carrito.php" method="POST">
                                <input type="hidden" name="producto_id" value="<?php echo $item['producto_id']; ?>">
                                <button type="submit" class="btn-eliminar">Eliminar</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Acciones del Carrito -->
            <div class="carrito-acciones">
                <form action="../pasarela/metodos_pago.php" method="POST">
                    <?php foreach ($carrito as $producto): ?>
                        <input type="hidden" name="producto_id[]" value="<?php echo $producto['producto_id']; ?>">
                        <input type="hidden" name="cantidad[]" value="<?php echo $producto['cantidad']; ?>">
                    <?php endforeach; ?>
                    <button type="submit" class="cta-btn">Confirmar Pedido</button>
                </form>
                <a href="../pasarela/metodos_pago.php" class="cta-btn">Proceder al Pago</a>
            </div>
        <?php else: ?>
            <!-- Mensaje si el carrito está vacío -->
            <p>Tu carrito está vacío.</p>
        <?php endif; ?>
    </main>

    <!-- Pie de Página -->
    <footer class="footer">
        <p>&copy; 2024 GYM | BRO. Todos los derechos reservados.</p>
        <div class="social-media">
            <a href="#"><img src="../img/facebook_icon.png" alt="Facebook"></a>
            <a href="#"><img src="../img/instagram_icon.png" alt="Instagram"></a>
            <a href="#"><img src="../img/twitter_icon.png" alt="Twitter"></a>
        </div>
    </footer>
</body>
</html>

