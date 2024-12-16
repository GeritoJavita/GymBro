<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['role'] == 'admin') {
    header('Location: ../admin/admin_dashboard.php');
    exit();
} elseif ($_SESSION['role'] == 'user') {
    header('Location: ../user/user_dashboard.php');
    exit();
} else {
    echo "Rol de usuario no reconocido.";
    exit();
}
?>
