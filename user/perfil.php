<?php
session_start();
include("../php/database.php");

// Verificar si el usuario ha iniciado sesión y tiene un ID en la sesión
if (!isset($_SESSION['id'])) {
    header("Location: ../login/login.php");
    exit();
}

$user_id = $_SESSION['id'];  // Obtener el ID del usuario logueado

// Consulta para obtener el nombre de usuario actual
$query = "SELECT username FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

// Verificar si se encontró el usuario
if (!$usuario) {
    echo "Error: Usuario no encontrado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validar que el campo del nombre de usuario no esté vacío y no exceda los 50 caracteres
    if (!empty($username) && strlen($username) <= 50) {
        // Validar contraseña (si se ingresó una)
        if (!empty($password)) {
            if ($password === $confirm_password) {
                if (strlen($password) >= 8 && preg_match("/[A-Z]/", $password) && preg_match("/[a-z]/", $password) && preg_match("/[0-9]/", $password) && preg_match("/[\W]/", $password)) {
                    // Hashear la nueva contraseña
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Actualizar nombre de usuario y contraseña
                    $update_query = "UPDATE usuarios SET username = ?, password = ? WHERE id = ?";
                    $update_stmt = $conn->prepare($update_query);
                    $update_stmt->bind_param("ssi", $username, $hashed_password, $user_id);
                    $update_stmt->execute();

                    $_SESSION['success_message'] = "Nombre de usuario y contraseña actualizados correctamente.";
                    header("Location: ../user/user_dashboard.php");
                    exit();
                } else {
                    $error_message = "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.";
                }
            } else {
                $error_message = "Las contraseñas no coinciden.";
            }
        } else {
            // Si no se ingresa contraseña, solo actualizar el nombre de usuario
            $update_query = "UPDATE usuarios SET username = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("si", $username, $user_id);
            $update_stmt->execute();

            $_SESSION['success_message'] = "Nombre de usuario actualizado correctamente.";
            header("Location: perfil.php");
            exit();
        }
    } else {
        $error_message = "El nombre de usuario no puede estar vacío y debe tener un máximo de 50 caracteres.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../css/perfil.css">
</head>
<body>
<section class="perfil-usuario">
    <h2>Editar Perfil</h2>

    <!-- Mostrar mensaje de éxito si hay uno -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <p class="success"><?= $_SESSION['success_message'] ?></p>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <!-- Mostrar mensaje de error si hay uno -->
    <?php if (isset($error_message)): ?>
        <p class="error"><?= $error_message ?></p>
    <?php endif; ?>

    <form action="perfil.php" method="POST">
        <label for="username">Nombre de Usuario:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($usuario['username']); ?>" required>

        <label for="password">Nueva Contraseña (opcional):</label>
        <input type="password" id="password" name="password">

        <label for="confirm_password">Confirmar Nueva Contraseña:</label>
        <input type="password" id="confirm_password" name="confirm_password">

        <button type="submit">Guardar Cambios</button>
        <button class="back-btn"><a href="../user/user_dashboard.php">Volver al Inicio</a></button>
    </form>
</section>
</body>
</html>
