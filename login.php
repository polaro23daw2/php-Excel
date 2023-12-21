<?php
session_start(); // Inicia una nueva sesión o reanuda la existente

$host = 'localhost'; // o la IP del servidor de bases de datos
$usuario_db = 'root'; // tu usuario de la base de datos
$contrasena_db = ''; // tu contraseña de la base de datos
$nombre_base_datos = 'formulario'; // el nombre de tu base de datos

// Conexión a la base de datos
$conn = new mysqli($host, $usuario_db, $contrasena_db, $nombre_base_datos);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

if (isset($_POST['usuario']) && isset($_POST['contrasenya'])) {
    $usuario = $_POST['usuario'];
    $contrasenya = $_POST['contrasenya'];

    // Preparar la sentencia SQL
    $stmt = $conn->prepare("SELECT contrasenya FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($contrasenya, $row['contrasenya'])) {
            // Contraseña correcta
            $_SESSION['usuario'] = $usuario; // Guardar el nombre de usuario en la sesión
            header("Location: index.php"); // Redireccionar a la página de bienvenida
            exit; // Asegúrate de llamar a exit después de header()
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta.";
        }
    } else {
        // Usuario no encontrado
        echo "Usuario no encontrado.";
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
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form action="login.php" method="post">
        <input type="text" name="usuario" placeholder="Nombre de usuario" required> <br>
        <input type="password" name="contrasenya" placeholder="Contraseña" required> <br>
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>
