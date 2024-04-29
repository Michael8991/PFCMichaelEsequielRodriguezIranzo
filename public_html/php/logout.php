<?php
session_start();
session_destroy(); // Destruir todas las variables de sesión
header("Location: views/login.php"); // Redirigir al usuario a la página de inicio de sesión
exit();
?>
