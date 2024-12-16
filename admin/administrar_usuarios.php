<?php
session_start();
include('../php/database.php');

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Obtener todos los usuarios
$result = $conn->query("SELECT * FROM usuarios");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>
   
    <link rel="stylesheet" href="../css/admin_usuarios.css">
    
    
</head>
<body>
    <div class="container">
        <h2>Administrar Usuarios</h2>
        <head>
        <a href="../admin/admin_dashboard.php" class="add-btn"> Volver Inicio</a>
        </head>
        <a href="../crud_usuarios/agregar_usuario.php" class="add-btn">Agregar Usuario</a>

        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td> <?=$row['password'] ?></td>
                        <td><?= $row['role'] ?></td>
                       
                        <td>
                            <a href="../crud_usuarios/editar_usuario.php?id=<?= $row['id'] ?>" class="edit-btn">Editar</a>
                            <a href="../crud_usuarios/eliminar_usuario.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
