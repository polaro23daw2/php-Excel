
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    // Si no es administrador o gestor, redirigir a la página de inicio de sesión o a una página de error
    header("Location: index.php");
    exit();
}
require 'vendor/autoload.php';
////libreria para hacer el mail
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
///libraria para hacer excel
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$archivo = 'usuarios.xlsx';
// <input type="number" name="telefono" placeholder="Telefono" required><br>
// <input type="text" name="direccion" placeholder="Direccion" required><br>
// <input type="text" name="ciudad" placeholder="Ciudad" required><br>
// <input type="number" name="codigo_postal" placeholder="Codigo_Postal" required><br>
if (isset($_POST['nombre_Completo']) && isset($_POST['correo']) && isset($_POST['telefono']) && isset($_POST['direccion']) && isset($_POST['ciudad']) && isset($_POST['codigo_postal'])) {
    $nombre_Completo = $_POST['nombre_Completo'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $codigo_postal = $_POST['codigo_postal'];


    // aqui se verifica su existencia 
    if (file_exists($archivo)) {
        // aqui abre el archvio
        $spreadsheet = IOFactory::load($archivo);
    } else {
        // si no existe lo crea
        $spreadsheet = new Spreadsheet();
        // establecer nombres columnas
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'id');
        $spreadsheet->getActiveSheet()->setCellValue('B1', 'nombre_Completo');
        $spreadsheet->getActiveSheet()->setCellValue('C1', 'correo');
        $spreadsheet->getActiveSheet()->setCellValue('D1', 'telefono');
        $spreadsheet->getActiveSheet()->setCellValue('E1', 'direccion');
        $spreadsheet->getActiveSheet()->setCellValue('F1', 'ciudad');
        $spreadsheet->getActiveSheet()->setCellValue('G1', 'codigo_postal');
    }

    $sheet = $spreadsheet->getActiveSheet();
    // hacer el id autoincrementable
    $row = $sheet->getHighestRow() + 1; // 
    $id = $row - 1; 

    // añadir datos en la fila que le corresponda
    $sheet->setCellValue('A' . $row, $id);
    $sheet->setCellValue('B' . $row, $nombre_Completo);
    $sheet->setCellValue('C' . $row, $correo);
    $sheet->setCellValue('D' . $row, $telefono);
    $sheet->setCellValue('E' . $row, $direccion);
    $sheet->setCellValue('F' . $row, $ciudad);
    $sheet->setCellValue('G' . $row, $codigo_postal);

    // escribir en el xlsx
    $writer = new Xlsx($spreadsheet);
    $writer->save($archivo);

    echo "Datos almacenados en el archivo de Excel" . "<br>";
} else {
    echo "De momento no se han enviado datos.<br>";
}

//ahora vamos a enviar un mail al destinatario

///////////destinatario///////////////
// m07clientphp@gmail.com

if (isset($_POST['nombre_Completo']) && isset($_POST['correo']) && isset($_POST['telefono']) && isset($_POST['direccion']) && isset($_POST['ciudad']) && isset($_POST['codigo_postal'])) {
    $nombre_Completo = $_POST['nombre_Completo'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $codigo_postal = $_POST['codigo_postal'];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'm07gestphp@gmail.com';
        $mail->Password = 'wkff jdeo fcfj pkrn';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Configurar el remitente y el destinatario
        $mail->setFrom('m07gestphp@gmail.com', 'gest2');
        $mail->addAddress('m07clientphp@gmail.com', 'gest1');

        // Configurar el contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Mail informacio de dades';
        $mail->addCC('m07admphp@gmail.com', 'admin');
        $mail->Body = "
            Este es el nombre_Completo del cliente: $nombre_Completo . <br>
            Este es el correo del cliente: $correo . <br>
            Este es el telefono del cliente: $telefono . <br>
            Este es la direccion del cliente: $direccion . <br>
            Este es la ciudad del cliente: $ciudad . <br>
            Este es el codigo_postal del cliente: $codigo_postal . <br>
            ";

        // Enviar el correo
        $mail->send();

        echo 'El correo ha sido enviado correctamente. <br>';
    } catch (Exception $e) {
        echo 'Error al enviar el correo: ' . $mail->ErrorInfo;
    }
} else {
    echo "De momento no se han enviado datos.";
}

// Datos de conexión a la base de datos
$host = 'localhost'; // o la IP del servidor de bases de datos
$usuario = 'root'; // tu usuario de la base de datos
$contrasena = ''; // tu contraseña de la base de datos
$nombre_base_datos = 'formulario'; // el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $nombre_base_datos);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Recoger los datos del formulario
if (isset($_POST['nombre_Completo']) && isset($_POST['correo']) && isset($_POST['telefono']) && isset($_POST['direccion']) && isset($_POST['ciudad']) && isset($_POST['codigo_postal'])) {
    $nombre_Completo = $_POST['nombre_Completo'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $codigo_postal = $_POST['codigo_postal'];

    // Preparar la sentencia SQL
    $stmt = $conn->prepare("INSERT INTO formulario (nombre_Completo, correo, telefono, direccion, ciudad, codigo_postal) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre_Completo, $correo, $telefono, $direccion, $ciudad, $codigo_postal);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        echo "Datos almacenados correctamente en la base de datos.<br>";
        $_SESSION['formulario_enviado'] = true;

        header("Location: formulario.php");
        exit();
    } else {
        echo "Error al almacenar los datos: " . $stmt->error;
    }

    // Cerrar la sentencia y la conexión
    $stmt->close();
    $conn->close();
}

?>