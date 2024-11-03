<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "u170629521_ReferedFlutter";
$password = "Refered1234";
$dbname = "u170629521_flutter";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error en la conexión: " . $e->getMessage()]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Método no permitido"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if ($data === null) {
    echo json_encode(["error" => "Error al decodificar JSON"]);
    exit();
}

if (isset($data['action'])) {
    if ($data['action'] === 'register') {
        if (isset($data['usuario'], $data['correo'], $data['contrasena'])) {
            $sql = "INSERT INTO usuarios (usuario, correo, contrasena, telefono, edad) 
                    VALUES (:usuario, :correo, :contrasena, :telefono, :edad)";
            $hashedPassword = password_hash($data['contrasena'], PASSWORD_BCRYPT);
            $stmt = $pdo->prepare($sql);

            try {
                $stmt->execute([
                    ':usuario' => $data['usuario'],
                    ':correo' => $data['correo'],
                    ':contrasena' => $hashedPassword,
                    ':telefono' => $data['telefono'] ?? null,
                    ':edad' => $data['edad'] ?? null
                ]);
                echo json_encode(["success" => true, "message" => "Usuario registrado correctamente."]);
            } catch (PDOException $e) {
                echo json_encode(["success" => false, "error" => "Error al registrar usuario: " . $e->getMessage()]);
            }
        } else {
            echo json_encode(["error" => "Faltan datos obligatorios para el registro"]);
        }
    } elseif ($data['action'] === 'login') {
        if (isset($data['correo'], $data['contrasena'])) {
            $sql = "SELECT usuario, contrasena FROM usuarios WHERE correo = :correo";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':correo' => $data['correo']]);

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($data['contrasena'], $user['contrasena'])) {
                    echo json_encode(["success" => true, "usuario" => $user['usuario'], "message" => "Inicio de sesión exitoso"]);
                } else {
                    echo json_encode(["success" => false, "error" => "Contraseña incorrecta"]);
                }
            } else {
                echo json_encode(["success" => false, "error" => "Usuario no encontrado"]);
            }
        } else {
            echo json_encode(["error" => "Faltan datos para el inicio de sesión"]);
        }
    } elseif ($data['action'] === 'payment') {
        if (isset($data['usuario'], $data['correo'], $data['tarjeta'], $data['vencimiento'], $data['cvv'])) {
            $sql = "INSERT INTO payments (usuario, correo, tarjeta, vencimiento, cvv) 
                    VALUES (:usuario, :correo, :tarjeta, :vencimiento, :cvv)";
            $stmt = $pdo->prepare($sql);

            try {
                $stmt->execute([
                    ':usuario' => $data['usuario'],
                    ':correo' => $data['correo'],
                    ':tarjeta' => $data['tarjeta'],
                    ':vencimiento' => $data['vencimiento'],
                    ':cvv' => $data['cvv']
                ]);
                echo json_encode(["success" => true, "message" => "Pago registrado correctamente."]);
            } catch (PDOException $e) {
                echo json_encode(["success" => false, "error" => "Error al registrar el pago: " . $e->getMessage()]);
            }
        } else {
