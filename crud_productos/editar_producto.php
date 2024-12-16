<?php
include('../php/database.php');

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $imagen = $_POST['imagen'];

    $stmt = $conn->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, imagen = ? WHERE id = ?");
    $stmt->bind_param("ssdisi", $nombre, $descripcion, $precio, $stock, $imagen, $id);

    if ($stmt->execute()) {
        header('Location: ../admin/administrar_productos.php');
        exit();
    } else {
        $error = "Error al actualizar el producto";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../css/crud_productos.css">
</head>
<body>
    <div class="container">
        <h2>Editar Producto</h2>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
            </div>
            <div class="form-group">
                <textarea name="descripcion" required><?php echo $producto['descripcion']; ?></textarea>
            </div>
            <div class="form-group">
                <input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>" required>
            </div>
            <div class="form-group">
                <input type="number" name="stock" value="<?php echo $producto['stock']; ?>" required>
            </div>
            <div class="form-group">
                <input type="text" name="imagen" value="<?php echo $producto['imagen']; ?>">
            </div>
            <button type="submit">Actualizar Producto</button>
        </form>
    </div>
</body>
</html>
