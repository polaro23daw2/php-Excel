<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .container {
            background-color: #ffffff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin: 0 0 20px;
            color: #333;
        }
        p {
            color: #666;
        }
    </style>
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
