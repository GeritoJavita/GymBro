<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros | GYM | BRO</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style_index.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<?php
include('php/database.php');
?>

<header class="bg-dark text-white">
    <nav class="navbar navbar-expand-lg navbar-dark container">
        <a class="navbar-brand" href="index.php">GYM | BRO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="./login/login.php">Iniciar Sesión</a></li>
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Contacto</a></li>
                <li class="nav-item"><a class="nav-link" href="./login/register.php">Registrarse</a></li>
            </ul>
        </div>
    </nav>
</header>

<main class="main-content py-5">
    <section class="sobre-nosotros container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <img src="png.png" alt="Sobre Nosotros" class="img-fluid">
            </div>
            <div class="col-lg-6">
                <h2>Sobre Nosotros</h2>
                <p>GYM | BRO es una empresa dedicada a ofrecer los mejores productos deportivos para ayudarte a mantenerte en forma y llevar una vida saludable. Nos enorgullecemos de nuestra amplia gama de productos diseñados para cubrir todas tus necesidades de entrenamiento, desde suplementos nutricionales hasta equipamiento de gimnasio.</p>
                <p>En GYM | BRO, creemos que la salud y el bienestar son fundamentales para una vida plena. Nuestra misión es proporcionarte los recursos y productos necesarios para alcanzar tus metas de fitness, ya sea que estés comenzando tu viaje de bienestar o buscando llevar tu rendimiento al siguiente nivel.</p>
                <p>Nuestro equipo está compuesto por expertos en nutrición y fitness que están comprometidos a ofrecerte productos de la más alta calidad. Nos esforzamos por mantenernos actualizados con las últimas tendencias y avances en el campo del fitness para asegurarnos de que siempre recibas lo mejor.</p>
                <p>Únete a la comunidad de GYM | BRO y descubre cómo podemos ayudarte a alcanzar tus objetivos de salud y fitness. ¡Gracias por confiar en nosotros!</p>
            </div>
        </div>
    </section>
</main>

<footer class="footer bg-dark text-white py-4">
    <div class="container text-center">
        <p>&copy; 2024 GYM | BRO. Todos los derechos reservados.</p>
        <div class="social-media">
            <a href="#"><img src="img/facebook_icon.png" alt="Facebook"></a>
            <a href="#"><img src="img/instagram_icon.png" alt="Instagram"></a>
            <a href="#"><img src="img/twitter_icon.png" alt="Twitter"></a>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
