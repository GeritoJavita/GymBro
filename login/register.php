<?php
session_start();
include('../php/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'user';  // Por defecto, todos los nuevos usuarios son 'user'

    $stmt = $conn->prepare("INSERT INTO usuarios (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        $success = "Usuario registrado correctamente";
    } else {
        $error = "Error al registrar el usuario: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - GYM | BRO</title>
    <link rel="stylesheet" href="css/styles_global.css">
    <link rel="stylesheet" href="../css/style_register.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="register-container">
        <div class="register-box">
            <h2>Registro</h2>
            <form method="POST" class="register-form">
                <div class="form-group">
                    <input type="text" name="username" placeholder="Usuario" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Contraseña" required>
                </div>
                <button type="submit" class="register-btn">Registrarse</button>
                <button type="button" class="back-btn"><a href="../index.php">Volver Inicio</a></button>
            </form>
            <?php
            if (isset($success)) {
                echo "<p class='success-msg'>$success</p>";
            } elseif (isset($error)) {
                echo "<p class='error-msg'>$error</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
