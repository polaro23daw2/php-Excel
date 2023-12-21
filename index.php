<!-- 
@author = Pol Aroca isart 
date =21/12/2023 
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/incex.css">
</head>
<body>
    <div class="container">
        <?php
        session_start();
        if (isset($_SESSION['usuario'])) {
            echo "<h1>Benvingut a l'Interfície del usuario</h1>";
            echo "<button><a href='crear_usuario.php'>Crear Usuarios</a></button> <br>";
            echo "<button><a href='formulario.php'>Formulario</a></button> <br>";
            echo "<button><a href='cerrar.php'>Cerrar Sesión</a></button> <br>";
        } else {
            echo "<h1>Bienvenido/a al sistema de gestión de biblioteca.</h1>";
            echo "<button><a href='login.php'>Login</a></button> <br>";
        }
        ?>
    </div>
</body>

</html>
