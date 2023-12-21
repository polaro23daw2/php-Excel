<!-- 
@author = Pol Aroca isart 
date =21/12/2023 
-->
// @author = Pol Aroca isart 
// date =21/12/2023
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
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
    <link rel="stylesheet" href="css/formulario.css">
</head>
<body>
    <?php
    if (!isset($_SESSION['formulario_enviado'])) {
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
        echo "<p>Gracias por la información.</p>";
        unset($_SESSION['formulario_enviado']); 
    }
    ?>
</body>
</html>
