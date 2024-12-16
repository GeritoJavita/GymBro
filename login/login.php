<?php
session_start();
include('../php/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['id'] = $user['id'];
       

        if ($user['role'] == 'admin') {
            header('Location: ../admin/admin_dashboard.php');
        } else {
            header('Location: ../user/user_dashboard.php');
        }
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}

// Cargar el carrito solo si el usuario está autenticado
if (isset($_SESSION['id'])) {
    // Recupera el carrito de la base de datos para este usuario
    $user_id = $_SESSION['id'];
    $sql = "SELECT * FROM carrito WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['carrito'] = [];
        while ($producto = mysqli_fetch_assoc($result)) {
            $_SESSION['carrito'][] = $producto;
        }
    } else {
        echo "No se encontraron productos en el carrito.";
    }
    
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GYM | BRO</title>
        
    <link rel="stylesheet" href="../css/style_login.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Iniciar Sesión</h2>
            <form method="POST" class="login-form">
                <div class="form-group">
                    <input type="text" name="username" placeholder="Usuario" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Contraseña" required>
                </div>
                <button type="submit" class="login-btn">Ingresar</button>
            </form>
            <?php if (isset($error)) echo "<p class='error-msg'>$error</p>"; ?>
            <p class="register-link">¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
        </div>
    </div>
</body>
</html>
