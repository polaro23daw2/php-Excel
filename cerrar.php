<?php
session_start();
session_unset(); // Eliminar todas las variables de sesión
session_destroy(); // Destruir la sesión

header("Location: login.php"); // Redireccionar a la página de inicio de sesión
exit;
?>
