<?php
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $nuevoUsuario = $_POST['usuario'];
    $nuevoTelefono = $_POST['telefono'];
    $nuevaEdad = $_POST['edad'];

    $stmt = $conn->prepare("UPDATE usuarios SET usuario = ?, telefono = ?, edad = ? WHERE correo = ?");
    $stmt->bind_param("ssis", $nuevoUsuario, $nuevoTelefono, $nuevaEdad, $correo);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Actualización exitosa"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar"]);
    }

    $stmt->close();
    $conn->close();
}
?>
