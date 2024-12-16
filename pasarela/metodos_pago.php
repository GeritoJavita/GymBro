<?php
session_start();

// Verificar si el método de pago está definido en la sesión
if (!isset($_SESSION['metodo_pago'])) {
    header('Location: confirmar_pago.php');
    exit();
}

$metodo_pago = $_SESSION['metodo_pago'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simulación del procesamiento del pago
    $_SESSION['pago_exitoso'] = true;
    // Redirigir a una página de confirmación de pago exitoso
    header('Location: pago_exitoso.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar</title>
</head>
<body>

<h1>Información de Pago - <?php echo $metodo_pago; ?></h1>

<form action="" method="POST">
    <?php if ($metodo_pago == 'Tarjeta de Crédito'): ?>
        <label for="numero_tarjeta">Número de Tarjeta:</label>
        <input type="text" name="numero_tarjeta" required><br>

        <label for="fecha_expiracion">Fecha de Expiración:</label>
        <input type="month" name="fecha_expiracion" required><br>

        <label for="cvv">CVV:</label>
        <input type="text" name="cvv" required><br>
    <?php elseif ($metodo_pago == 'PayPal'): ?>
        <label for="email_paypal">Correo Electrónico de PayPal:</label>
        <input type="email" name="email_paypal" required><br>
    <?php else: ?>
        <label for="cuenta_bancaria">Número de Cuenta Bancaria:</label>
        <input type="text" name="cuenta_bancaria" required><br>
    <?php endif; ?>
    
    <button type="submit">Procesar Pago</button>
</form>

</body>
</html>
