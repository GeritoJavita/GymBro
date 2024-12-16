<?php
session_start();
include("../php/database.php");

// Verificación de sesión y rol
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'user') {
    header('Location: ../login/login.php');
    exit();
}

// Obtener datos del usuario
$user_id = $_SESSION['id']; // Asumiendo que guardas el ID de usuario en la sesión
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

// Añadir producto al carrito
if (isset($_POST['add_to_cart'])) {
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];

    // Verificar si el producto ya está en el carrito
    $check_cart = $conn->prepare("SELECT * FROM carrito WHERE usuario_id = ? AND producto_id = ?");
    $check_cart->bind_param("ii", $user_id, $producto_id);
    $check_cart->execute();
    $cart_result = $check_cart->get_result();

    // Si el producto ya está en el carrito, actualizar la cantidad
    if ($cart_result->num_rows > 0) {
        // Actualizar la cantidad en la base de datos
        $update_cart = $conn->prepare("UPDATE carrito SET cantidad = cantidad + ? WHERE usuario_id = ? AND producto_id = ?");
        $update_cart->bind_param("iii", $cantidad, $user_id, $producto_id);
        $update_cart->execute();
    } else {
        // Si el producto no está en el carrito, insertarlo
        $add_cart = $conn->prepare("INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)");
        $add_cart->bind_param("iii", $user_id, $producto_id, $cantidad);
        $add_cart->execute();
    }

    // Ahora, añadir el producto al carrito de la sesión
    // Si el producto ya está en la sesión, actualizamos la cantidad
    if (isset($_SESSION['carrito'][$producto_id])) {
        $_SESSION['carrito'][$producto_id]['cantidad'] += $cantidad;
    } else {
        // Si no está, lo añadimos
        $_SESSION['carrito'][$producto_id] = [
            'nombre' => $_POST['nombre'], // Obtenido de la base de datos
            'cantidad' => $cantidad,
            'precio' => $_POST['precio'], // Obtenido de la base de datos
        ];
    }

    // Redirigir para evitar reenvíos del formulario
    header('Location: productos.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - GYM | BRO</title>
    <link rel="stylesheet" href="../css/style_gym.css">
    <link rel="stylesheet" href="../css/style_index.css">
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
                <li><a href="../carrito/carrito.php">Carrito</a></li>
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

    <main>
        <section class="productos-section">
            <h2>Lista de Productos</h2>
            <div class="grid-productos">
                <?php foreach ($productos as $producto): ?>
                    <div class="producto">
                        <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>">
                        <h3><?php echo $producto['nombre']; ?></h3>
                        <p>Descripción: <?php echo $producto['descripcion']; ?></p>
                        <p>Precio: $<?php echo $producto['precio']; ?></p>
                        <form method="POST" action="productos.php">
                            <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                            <input type="hidden" name="nombre" value="<?php echo $producto['nombre']; ?>">
                            <input type="hidden" name="precio" value="<?php echo $producto['precio']; ?>">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad" value="1" min="1">
                            <button type="submit" name="add_to_cart">Añadir al Carrito</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2024 GYM | BRO. Todos los derechos reservados.</p>
        <div class="social-media">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
        </div>
    </footer>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
