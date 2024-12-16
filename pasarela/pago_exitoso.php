<?php
session_start();

// Verificar si el pago fue exitoso
if (!isset($_SESSION['pago_exitoso']) || !$_SESSION['pago_exitoso']) {
    // Si no se ha realizado el pago, redirigir al inicio o a una página de error
    header('Location: ../user/user_dashboard.php');
    exit();
}

// Limpiar la variable de sesión después de usarla
unset($_SESSION['pago_exitoso']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Exitoso</title>
</head>
<body>

<h1>¡Tu pago ha sido procesado exitosamente!</h1>
<p>Gracias por tu compra. ¡Tu pedido está en proceso!</p>
<a href="index.php">Volver al inicio</a>

</body>
</html>
