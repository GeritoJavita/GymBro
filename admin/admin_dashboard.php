<?php
include('../php/database.php');

// Consulta para obtener el número de usuarios
$queryUsuarios = "SELECT COUNT(*) AS total_usuarios FROM usuarios";
$resultUsuarios = $conn->query($queryUsuarios);
$rowUsuarios = $resultUsuarios->fetch_assoc();
$totalUsuarios = $rowUsuarios['total_usuarios'];

// Consulta para obtener el número de pedidos pendientes
$queryPedidosPendientes = "SELECT COUNT(*) AS total_pedidos_pendientes FROM pedidos WHERE estado_entrega = 'pendiente'";
$resultPedidosPendientes = $conn->query($queryPedidosPendientes);
$rowPedidosPendientes = $resultPedidosPendientes->fetch_assoc();
$totalPedidosPendientes = $rowPedidosPendientes['total_pedidos_pendientes'];

// Consulta para obtener el número de productos en inventario
$queryProductosInventario = "SELECT COUNT(*) AS total_productos_inventario FROM productos WHERE stock > 0";
$resultProductosInventario = $conn->query($queryProductosInventario);
$rowProductosInventario = $resultProductosInventario->fetch_assoc();
$totalProductosInventario = $rowProductosInventario['total_productos_inventario'];

// Consulta para obtener todos los productos
$queryProductos = "SELECT * FROM productos";
$resultProductos = $conn->query($queryProductos);
$productos = [];

if ($resultProductos->num_rows > 0) {
    while ($row = $resultProductos->fetch_assoc()) {
        $productos[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style_admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Encabezado -->
    <header>
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1 class="mb-0">GYM Dashboard</h1>
            <a href="../logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
        </div>
    </header>

    <!-- Mensaje de bienvenida -->
    <section class="welcome-section py-4">
        <div class="container">
            <div class="alert alert-primary text-center" role="alert">
                <h3>¡Hola, Administrador <strong>Administrador</strong>! 👋</h3>
                <p>Esperamos que tengas un excelente día gestionando tu gimnasio.</p>
            </div>
        </div>
    </section>

    <!-- Opciones de administración -->
    <main class="container my-5">
        <div class="row text-center">
        <div class="col-md-4 mb-4">
                <a href="administrar_usuarios.php" class="admin-card">
                    <i class="fas fa-users"></i>
                    <h2>Usuarios</h2>
                </a>
            </div>
            
           
            <div class="col-md-4 mb-4">
                <a href="administrar_pedidos.php" class="admin-card">
                    <i class="fas fa-box"></i>
                    <h2>Pedidos</h2>
                </a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="administrar_productos.php" class="admin-card">
                    <i class="fas fa-dumbbell"></i>
                    <h2>Productos</h2>
                </a>
            </div>
        </div>

        <!-- Estadísticas rápidas -->
        <section class="statistics-section py-4">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-4 mb-4">
                        <div class="stats-card">
                            <i class="fas fa-user-check stats-icon"></i>
                            <h3><?php echo $totalUsuarios; ?></h3>
                            <p>Usuarios Activos</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="stats-card">
                            <i class="fas fa-cart-plus stats-icon"></i>
                            <h3><?php echo $totalPedidosPendientes; ?></h3>
                            <p>Pedidos Pendientes</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="stats-card">
                            <i class="fas fa-boxes stats-icon"></i>
                            <h3><?php echo $totalProductosInventario; ?></h3>
                            <p>Productos en Inventario</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Pie de página -->
    <footer>
        <p>&copy; 2024 GYM | BRO. Todos los derechos reservados.</p>
        <div class="social-media">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
