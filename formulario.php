<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    // Si no es administrador o gestor, redirigir a la página de inicio de sesión o a una página de error
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    if (!isset($_SESSION['formulario_enviado'])) {
        // Mostrar el formulario solo si no se ha enviado anteriormente
    ?>
        <h1>Formulario para enviar datos</h1>
        <form action="datos.php" method="post">
            <input type="text" name="nombre_Completo" placeholder="Nombre Completo" required> <br>
            <input type="email" name="correo" placeholder="Correo Electrónico" required><br>
            <input type="number" name="telefono" placeholder="Teléfono" required><br>
            <input type="text" name="direccion" placeholder="Dirección" required><br>
            <input type="text" name="ciudad" placeholder="Ciudad" required><br>
            <input type="number" name="codigo_postal" placeholder="Código Postal" required><br>
            <input type="submit" value="enviar">
        </form>
    <?php
    } else {
        // Mostrar mensaje de agradecimiento si el formulario ha sido enviado
        echo "<p>Gracias por la información.</p>";
        unset($_SESSION['formulario_enviado']); // Restablecer para futuros envíos
    }
    ?>
</body>
</html>
