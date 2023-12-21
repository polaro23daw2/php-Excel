<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    // Si no es administrador o gestor, redirigir a la página de inicio de sesión o a una página de error
    header("Location: index.php");
    exit();
}
$host = 'localhost'; // o la IP del servidor de bases de datos
$usuario = 'root'; // tu usuario de la base de datos
$contrasena = ''; // tu contrasenya de la base de datos
$nombre_base_datos = 'formulario'; // el nombre de tu base de datos
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

    // Hashear la contraseña
    $contrasenya_hash = password_hash($contrasenya, PASSWORD_DEFAULT);

    // Preparar la sentencia SQL (la misma que ya tienes)
    $stmt = $conn->prepare("INSERT INTO usuarios (usuario, correo, contrasenya, nacimiento) VALUES (?, ?, ?, ?)");

    // Verificar si la preparación fue exitosa
    if ($stmt === false) {
        die("Error al preparar la sentencia: " . $conn->error);
    }

    // Vincular los parámetros a la sentencia (asegúrate de usar $contrasenya_hash en lugar de $contrasenya)
    $stmt->bind_param("ssss", $usuario, $correo, $contrasenya_hash, $nacimiento);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        echo "Datos almacenados correctamente en la base de datos.<br>";
    } else {
        echo "Error al almacenar los datos: " . $stmt->error;
    }

    // Cerrar la sentencia y la conexión
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