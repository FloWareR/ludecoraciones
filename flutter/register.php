<?php
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);  // Encripta la contraseña
    $telefono = $_POST['telefono'];
    $edad = $_POST['edad'];

    $stmt = $conn->prepare("INSERT INTO usuarios (usuario, correo, contrasena, telefono, edad) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $usuario, $correo, $contrasena, $telefono, $edad);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Registro exitoso"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al registrar"]);
    }

    $stmt->close();
    $conn->close();
}
?>
