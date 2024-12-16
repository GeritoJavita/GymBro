<?php
include('../php/database.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $imagen = $_POST['imagen'];  // Debes manejar correctamente la subida de imágenes si la usas

    // Prepara la consulta para insertar un nuevo producto
    $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, imagen) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $nombre, $descripcion, $precio, $stock, $imagen);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        header('Location: ../admin/administrar_productos.php');
        exit();
    } else {
        $error = "Error al agregar el producto";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="../css/crud_productos.css">
</head>
<body>
    <div class="container">
        <h2>Agregar Producto</h2>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="nombre" placeholder="Nombre del Producto" required>
            </div>
            <div class="form-group">
                <textarea name="descripcion" placeholder="Descripción del Producto" required></textarea>
            </div>
            <div class="form-group">
                <input type="number" step="0.01" name="precio" placeholder="Precio" required>
            </div>
            <div class="form-group">
                <input type="number" name="stock" placeholder="Cantidad en Stock" required>
            </div>
            <div class="form-group">
                <input type="text" name="imagen" placeholder="URL de la Imagen del Producto">
            </div>
            <button type="submit">Agregar Producto</button>
        </form>
    </div>
</body>
</html>
