<!-- 
@author = Pol Aroca isart 
date =21/12/2023 
-->
<?php
session_start();

function leerCredenciales() {
    $archivo = 'usuari.txt';
    $credenciales = file_get_contents($archivo);
    list($usuario, $contrasena) = explode(',', trim($credenciales));
    return array('usuario' => $usuario, 'contrasena' => $contrasena);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $credenciales = leerCredenciales();

    // Verificar las credenciales
    if ($username == $credenciales['usuario'] && $password == $credenciales['contrasena']) {
        $_SESSION['usuario'] = $username;
        echo 'Autenticación exitosa. Bienvenido, ' . $username . '!';
        header("Location: index.php");
    } else {
        echo 'Error: Usuario o contraseña incorrectos.';
    }
} else {
    echo 'Por favor, ingrese sus credenciales.';
}
?>

<!-- Formulario HTML para el login -->
<form method="post">
    Usuario: <input type="text" name="username"><br>
    Contraseña: <input type="password" name="password"><br>
    <input type="submit" value="Iniciar sesión">
</form>