<?php
include('../php/database.php');

$result = $conn->query("SELECT * FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Productos</title>
    <link rel="stylesheet" href="../css/admin_producto.css">
</head>
<body>
    <div class="container">
        <h2>Listado de Productos</h2>
      
       
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($producto = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $producto['id']; ?></td>
                    <td><?php echo $producto['nombre']; ?></td>
                    <td><?php echo $producto['descripcion']; ?></td>
                    <td><?php echo $producto['precio']; ?></td>
                    <td><?php echo $producto['stock']; ?></td>
                    <td>
                        <a href="../crud_productos/editar_producto.php?id=<?php echo $producto['id']; ?>">Editar</a> |
                        <a href="../crud_productos/eliminar_producto.php?id=<?php echo $producto['id']; ?>"  class="delete-btn" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="../admin/admin_dashboard.php" class="add-btn"> Volver Inicio</a>

        <a href="../crud_productos/agregar_producto.php">Agregar Nuevo Producto</a>
    </div>
</body>
</html>
