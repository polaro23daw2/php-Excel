<!-- 
@author = Pol Aroca isart 
date =21/12/2023 
-->
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
$host = 'localhost'; 
$usuario = 'root'; 
$contrasena = ''; 
$nombre_base_datos = 'formulario'; 
//hacer la conexion
$conn = new mysqli($host, $usuario, $contrasena, $nombre_base_datos);
//verificar la conexion
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Recoger los datos del formulario
if (isset($_POST['usuario']) && isset($_POST['correo']) && isset($_POST['contrasenya']) && isset($_POST['nacimiento'])) {
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $contrasenya = $_POST['contrasenya'];
    $nacimiento = $_POST['nacimiento'];
    // hacer que la contraseña sea hash
    $contrasenya_hash = password_hash($contrasenya, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (usuario, correo, contrasenya, nacimiento) VALUES (?, ?, ?, ?)");

    if ($stmt === false) {
        die("Error al preparar la sentencia: " . $conn->error);
    }

    $stmt->bind_param("ssss", $usuario, $correo, $contrasenya_hash, $nacimiento);

    if ($stmt->execute()) {
        echo "Datos almacenados correctamente en la base de datos.<br>";
    } else {
        echo "Error al almacenar los datos: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>

<body>
    <h1>Formulario para crear Datos</h1>
    <form action="crear_usuario.php" method="post">
        <input type="text" name="usuario" placeholder="usuario" required> <br>
        <input type="email" name="correo" placeholder="correo" required><br>
        <input type="password" name="contrasenya" placeholder="contrasenya" required> <br>
        <input type="date" name="nacimiento" placeholder="nacimiento" required><br>

        <input type="submit" value="enviar">
    </form>
</body>

</html>