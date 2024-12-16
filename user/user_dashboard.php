<?php
session_start();
include("../php/database.php");

// Verificación de sesión y rol
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'user') {
    header('Location: ../login/login.php');
    exit();
}

// Obtener datos del usuario
$user = $_SESSION['user'];

// Consulta para obtener todos los productos
$query = "SELECT * FROM productos";
$result = $conn->query($query);
$productos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Usuario - GYM | BRO</title>
    <link rel="stylesheet" href="../css/style_gym.css">
    <link rel="stylesheet" href="../css/style_index.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <!-- Navbar mejorado -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="index.php">GYM | BRO</a>
            </div>

            <ul class="nav-links">
                <li><a href="productos.php">Productos</a></li>
                <li><a href="carrito.php">Carrito</a></li>
                <li><a href="../user/perfil.php">Perfil</a></li>
                <li><a href="../logout.php">Cerrar Sesión</a></li>
            </ul>

            <!-- Ícono del carrito con contador -->
            <?php
$carrito_count = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
?>
            <div class="navbar-icons">
    <a href="../carrito/carrito.php" class="cart-icon">
        <i class="fas fa-shopping-cart"></i>
        <span class="cart-count"><?php echo $carrito_count; ?></span> <!-- Aquí se actualizará dinámicamente el número de productos -->
    </a>
    <span class="user-welcome">Hola, <?php echo htmlspecialchars($user); ?></span>
</div>

        </nav>
    </header>

    <!-- Sección de bienvenida -->
    <main class="main-content">
        <section class="welcome-section">
            <h1>Bienvenidos a GYM | BRO</h1>
            <p>Descubre los mejores productos para mantenerte en forma y llevar una vida saludable.</p>
            <a href="productos.php" class="cta-btn">Ver Productos</a>
        </section>

        <!-- Sección de productos destacados -->
        <section class="productos-destacados">
    <h2>Productos Destacados</h2>
    <div class="grid-productos">
        <?php foreach ($productos as $producto): ?>
            <div class="producto">
                <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>">
                <h3><?php echo $producto['nombre']; ?></h3>
                <p>Precio: $<?php echo $producto['precio']; ?></p>
                <form action="../carrito/agregar_carrito.php" method="POST">
                    <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                    <button type="submit" class="cta-btn">Agregar al Carrito</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</section>


   
    </main>

    <!-- Footer mejorado -->
    <footer class="footer">
    <p>&copy; 2024 GYM | BRO. Todos los derechos reservados.</p>
    <div class="social-media">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
    </div>
</footer>


</body>
</html>
