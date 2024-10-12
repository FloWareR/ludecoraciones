<?php
include('config/config.php'); 
include_once('libraries/Database.php'); 

// Instanciar la conexión a la base de datos
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $name = trim($_POST['nombre']);
    $email = trim($_POST['email']);  // Cambiado 'correo' por 'email'
    $message = trim($_POST['mensaje']);

    // Validar que no estén vacíos
    if (!empty($name) && !empty($email) && !empty($message)) {
        $sql = "INSERT INTO contacto (nombre, correo, mensaje) VALUES (:nombre, :correo, :mensaje)";
        
        // Preparar los parámetros
        $params = [
            ':nombre' => $name,
            ':correo' => $email,  // Cambiado el parámetro a 'email'
            ':mensaje' => $message
        ];
        
        // Ejecutar la consulta utilizando el método InsertSql
        $result = $db->InsertSql($sql, $params);
        
        if ($result['success']) {
            echo "<p style='color: green;'>¡Gracias por tu envío! ID del registro: " . $name . "</p>";
        } else {
            echo "<p style='color: red;'>Error al procesar la solicitud: " . $result['error'] . "</p>";
        }
    } 
}
?>
