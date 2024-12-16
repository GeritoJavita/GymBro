<?php
include('../php/database.php');
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login/login.php");
    exit();
}

$id = $_GET['id'];

// Obtener datos del usuario
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $role = $_POST['role'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE usuarios SET username = ?, password = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $password, $role, $id);
    } else {
        $stmt = $conn->prepare("UPDATE usuarios SET username = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssi", $username, $role, $id);
    }

    if ($stmt->execute()) {
        header('Location: ../admin/administrar_usuarios.php'); 
        exit();
    } else {
        $error = "Error al actualizar el usuario";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../css/crud_usuarios.css">
</head>
<body>
    <div class="container">
        <h2>Editar Usuario</h2>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Nueva Contraseña (opcional)">
            </div>
            <div class="form-group">
                <label for="role">Rol:</label>
                <select name="role" required>
                    <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>Usuario</option>
                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
                </select>
            </div>
            <button type="submit">Actualizar Usuario</button>
        </form>
    </div>
</body>
</html>
