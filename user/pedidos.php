<?php
session_start();
include("../php/database.php");

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    header('Location: ../login/login.php');
    exit();
}

// Obtener el ID del usuario
$user_id = $_SESSION['id'];

// Consultar los pedidos del usuario
$query = "SELECT id, total, fecha, estado_entrega 
          FROM pedidos 
          WHERE usuario_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$pedidos = [];
while ($row = $result->fetch_assoc()) {
    $pedidos[] = $row;
}

// Consultar los detalles de cada pedido
$detalles_pedidos = [];
foreach ($pedidos as $pedido) {
    $query = "SELECT dp.producto_id, p.nombre, p.imagen 
              FROM detalle_pedido dp 
              INNER JOIN productos p ON dp.producto_id = p.id 
              WHERE dp.pedido_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $pedido['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $detalles_pedidos[$pedido['id']][] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos - GYM | BRO</title>
    <link rel="stylesheet" href="../css/pedidos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="user_dashboard.php">GYM | BRO</a>
            </div>
            <ul class="nav-links">
                <li><a href="productos.php">Productos</a></li>
                <li><a href="carrito.php">Carrito</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="../logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <h1>Mis Pedidos</h1>

        <?php if (!empty($pedidos)): ?>
            <!-- Lista de Pedidos -->
            <div class="pedidos-container">
                <?php foreach ($pedidos as $pedido): ?>
                    <div class="pedido-item">
                        <h3>Pedido #<?php echo $pedido['id']; ?></h3>
                        <p>Fecha: <?php echo $pedido['fecha']; ?></p>
                        <p>Total: $<?php echo $pedido['total']; ?></p>
                        <p>Estado de Entrega: <?php echo $pedido['estado_entrega']; ?></p>
                        <div class="detalle-pedido">
                            <?php if (!empty($detalles_pedidos[$pedido['id']])): ?>
                                <?php foreach ($detalles_pedidos[$pedido['id']] as $detalle): ?>
                                    <div class="detalle-item">
                                        <img src="<?php echo $detalle['imagen']; ?>" alt="<?php echo $detalle['nombre']; ?>" class="producto-imagen">
                                        <p><?php echo $detalle['nombre']; ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <form action="../carrito/eliminar_pedido.php" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas cancelar este pedido?');">
                            <input type="hidden" name="pedido_id" value="<?php echo $pedido['id']; ?>">
                            <button type="submit" class="btn-eliminar">Cancelar Pedido</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Mensaje si no hay pedidos -->
            <p>No tienes pedidos registrados.</p>
        <?php endif; ?>
    </main>

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
