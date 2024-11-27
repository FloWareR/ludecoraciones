<?php
include_once(__DIR__ . '/config/config.php');
include_once(__DIR__ . '/libraries/Database.php');

// Conexión a la base de datos
$db = new Database();

// Verificar si los datos fueron enviados por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario y limpiar entradas
    $nombre = trim($_POST['nombre']);
    $direccion = trim($_POST['direccion']);
    $fecha_hora = trim($_POST['fecha_hora']);
    $tipo_evento = trim($_POST['tipo_evento']);
    $detalles = isset($_POST['detalles']) && !empty(trim($_POST['detalles'])) 
                ? trim($_POST['detalles']) 
                : 'No especificado';

    // Validar los datos mínimos requeridos
    if (!empty($nombre) && !empty($direccion) && !empty($fecha_hora) && !empty($tipo_evento)) {
        // Preparar la consulta SQL para insertar en la base de datos
        $sql = "INSERT INTO cotizaciones (nombre, direccion, fecha_hora, tipo_evento, detalles) 
                VALUES (:nombre, :direccion, :fecha_hora, :tipo_evento, :detalles)";
        $params = [
            ':nombre' => $nombre,
            ':direccion' => $direccion,
            ':fecha_hora' => $fecha_hora,
            ':tipo_evento' => $tipo_evento,
            ':detalles' => $detalles,
        ];

        // Intentar insertar en la base de datos
        $result = $db->InsertSql($sql, $params);

        if ($result['success']) {
            // Preparar redirección a WhatsApp
            $telefono = '9931602365';
            $mensaje = "Hola, me gustaría solicitar una cotización. Aquí están los detalles:
            \nNombre: $nombre
            \nDirección del evento: $direccion
            \nDía y hora del evento: $fecha_hora
            \nTipo de evento: $tipo_evento
            \nDetalles de la decoración: $detalles";

            // Redirigir a WhatsApp
            $url = "https://api.whatsapp.com/send?phone=$telefono&text=" . urlencode($mensaje);
            header("Location: $url");
            exit;
        } else {
            // Mostrar error al guardar los datos
            echo "<p style='color: red;'>Error al guardar los datos: " . htmlspecialchars($result['error']) . "</p>";
        }
    } else {
        // Mensaje de error si faltan datos
        echo "<p style='color: red;'>Por favor, completa todos los campos requeridos.</p>";
    }
} else {
    // Mensaje si no se envió el formulario por POST
    echo "<p style='color: red;'>Método no permitido.</p>";
}
?>
