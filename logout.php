
/* Archivo que cierra la sesión del usuario
    lo redirige nuevamente al index principal */

<?php
session_start();
session_destroy();
header('Location: index.php');
exit();
?>
