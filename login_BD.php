<!-- 
@author = Pol Aroca isart 
date =21/12/2023 
-->
<?php
session_start(); // Inicia una nueva sesión o reanuda la existente

$host = 'localhost'; 
$usuario_db = 'root'; 
$contrasena_db = '';
$nombre_base_datos = 'formulario'; 

$conn = new mysqli($host, $usuario_db, $contrasena_db, $nombre_base_datos);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

if (isset($_POST['usuario']) && isset($_POST['contrasenya'])) {
    $usuario = $_POST['usuario'];
    $contrasenya = $_POST['contrasenya'];

    $stmt = $conn->prepare("SELECT contrasenya FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($contrasenya, $row['contrasenya'])) {
            //si la contraseña es correcta que el nombre de session sea usuario y ese usuario este ligado a ese nombre
            $_SESSION['usuario'] = $usuario; 
            header("Location: index.php"); 
            exit; 
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
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
