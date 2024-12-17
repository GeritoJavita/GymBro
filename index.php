

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYM | BRO - Venta de Productos Alimenticios</title>
    <link rel="stylesheet" href="css/style_index.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  
</head>
<body>

<?php
include('php/database.php');
/* Consulta para obtener todos los producto 
 los almacena en un arreglo*/
$query = "SELECT * FROM productos";
$result = $conn->query($query);
$productos = [];

/*Se recorre con un ciclo cada uno de los atributos que 
    La tabla en la base de datos maneja
  */
/* El index principal debe ser una pagina web comoda para el usuario de entrada. 
    Debe contener el navegador comun y corriente, secciones esteticas que mantengan la esencia
    de la pagina web. */
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}
?>

<header>
    <nav class="navbar">
        <div class="logo">
            <a href="index.php">GYM | BRO</a>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="./login/login.php">Iniciar Sesión</a></li>
            <li><a href="dashboard.php">Contacto</a></li>
            <li> <a href="about.php">Sobre Nostros</a></li>
            <li><a href="./login/register.php">Registrarse</a></li>
        </ul>
    </nav>
</header>

<main class="main-content">
    
    <section class="hero-section">
        <div class="hero-content">
            <h1>Bienvenidos a GYM | BRO</h1>
            <p>Descubre los mejores productos para mantenerte en forma y llevar una vida saludable.</p>
            <a href="./login/login.php" class="cta-btn">Ver Productos</a>
        </div>
      
    </section>
   

    
    <section class="productos-destacados">
        <h2>Productos Destacados</h2>
        <div class="grid-productos"> <?php $contador = 0; foreach ($productos as $producto): if ($contador >= 12) break; $contador++; ?> <div class="producto"> <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>"> <h3><?php echo $producto['nombre']; ?></h3> <p>Precio: $<?php echo $producto['precio']; ?></p> </div> <?php endforeach; ?>
    </section>

  
</main>

<footer class="footer">
    <p>&copy; 2024 GYM | BRO. Todos los derechos reservados.</p>
    <div class="social-media">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
    </div>
</footer>

</body>
</html>
