<?php
include('config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['mensaje'];

    $stmt = $pdo->prepare("INSERT INTO submissions (nombre, email, message) VALUES (:nombre, :email, :message)");
    $stmt->bindParam(':nombre', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $mensaje);

    if ($stmt->execute()) {
        echo "¡Gracias por tu envío!";
    } else {
        echo "Error al procesar la solicitud.";
    }
}
?>
