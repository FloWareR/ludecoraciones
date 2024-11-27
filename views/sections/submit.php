<?php
include('../../config/config.php'); 
include_once('../../libraries/Database.php'); 

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['nombre']);
    $email = trim($_POST['email']); 
    $message = trim($_POST['mensaje']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $sql = "INSERT INTO contacto (nombre, correo, mensaje) VALUES (:nombre, :correo, :mensaje)";
        
        $params = [
            ':nombre' => $name,
            ':correo' => $email,  
            ':mensaje' => $message
        ];
        
        $result = $db->InsertSql($sql, $params);
        
        if ($result['success']) {
            echo "<p style='color: green;'>¡Gracias por tu envío " . $name . "!</p>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = '/Proyecto';
                    }, 3000); // 3000 ms = 3 segundos
                  </script>";
        } else {
            echo "<p style='color: red;'>Error al procesar la solicitud: " . $result['error'] . "</p>";
        }
    } 
}
?>
