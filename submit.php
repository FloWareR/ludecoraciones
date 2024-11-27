<?php
include_once(__DIR__ . '/config/config.php');
include_once(__DIR__ . '/config/autoload.php');

// Conexión a la base de datos
$db = new Database();

// Verificar si los datos fueron enviados por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $fecha_hora = $_POST['fecha_hora'];
    $tipo_evento = $_POST['tipo_evento'];
    $detalles = isset($_POST['detalles']) ? $_POST['detalles'] : 'No especificado';

    // Guardar en la base de datos
    $sql = "INSERT INTO cotizaciones (nombre, direccion, fecha_hora, tipo_evento, detalles) 
            VALUES (:nombre, :direccion, :fecha_hora, :tipo_evento, :detalles)";
    $params = [
        ':nombre' => $nombre, 
        ':direccion' => $direccion,
        ':fecha_hora' => $fecha_hora,
        ':tipo_evento' => $tipo_evento,
        ':detalles' => $detalles,
    ];

    $result = $db->InsertSql($sql, $params);

    if ($result['success']) {
        // Redirigir a WhatsApp
        $telefono = '9931602365';
        $mensaje = "Hola, me gustaría solicitar una cotización. Aquí están los detalles:
        \nNombre: $nombre
        \nDirección del evento: $direccion
        \nDía y hora del evento: $fecha_hora
        \nTipo de evento: $tipo_evento
        \nDetalles de la decoración: $detalles";

        $url = "https://api.whatsapp.com/send?phone=$telefono&text=" . urlencode($mensaje);
        header("Location: $url");
        exit;
    } else {
        echo "Hubo un error al guardar los datos. Por favor, inténtalo de nuevo.";
    }
} else {
    echo "Método no permitido.";
}
?>
