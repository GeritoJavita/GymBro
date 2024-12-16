!
<?php
session_start();
include("../php/database.php");

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
    exit();
}

// Verificar si se han enviado productos para confirmar
if (!isset($_POST['producto_id']) || empty($_POST['producto_id'])) {
    die("Error: No se recibieron productos para el pedido.");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Procesar los productos recibidos (por ejemplo, guardarlos en la base de datos)
    // Guardar productos del carrito en la sesión, base de datos o lo que necesites
    $_SESSION['productos_carrito'] = [
        'producto_id' => $_POST['producto_id'],
        'cantidad' => $_POST['cantidad']
    ];

    // Redirigir a la página de selección de métodos de pago
    header('Location: ../pasarela/metodos_pago.php');
    exit();
}
$user_id = $_SESSION['id'];
$producto_ids = $_POST['producto_id'];
$cantidades = $_POST['cantidad'];

// Crear el pedido en la tabla 'pedidos'
$query_pedido = "INSERT INTO pedidos (usuario_id, fecha) VALUES (?, NOW())";
$stmt_pedido = $conn->prepare($query_pedido);
$stmt_pedido->bind_param("i", $user_id);
$stmt_pedido->execute();
$pedido_id = $stmt_pedido->insert_id;  // Obtener el ID del pedido recién creado

// Insertar los productos en 'detalle_pedido'
foreach ($producto_ids as $index => $producto_id) {
    $cantidad = $cantidades[$index];

    // Verificar que el producto exista en la tabla 'productos'
    $query_producto = "SELECT id FROM productos WHERE id = ?";
    $stmt_producto = $conn->prepare($query_producto);
    $stmt_producto->bind_param("i", $producto_id);
    $stmt_producto->execute();
    $result_producto = $stmt_producto->get_result();

    if ($result_producto->num_rows > 0) {
        // Si el producto existe, insertamos en 'detalle_pedido'
        $query_detalle = "INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad) VALUES (?, ?, ?)";
        $stmt_detalle = $conn->prepare($query_detalle);
        $stmt_detalle->bind_param("iii", $pedido_id, $producto_id, $cantidad);
        $stmt_detalle->execute();
    } else {
        // Si el producto no existe, podemos manejar el error (opcional)
        die("Error: El producto con ID $producto_id no existe.");
    }
    
}

// Confirmación exitosa
echo "Pedido confirmado con éxito. ID del pedido: " . $pedido_id;
?>
