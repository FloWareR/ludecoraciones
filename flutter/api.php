<?php
header("Content-Type: application/json");

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "u170629521_ReferedFlutter";
$password = "Refered1234";
$dbname = "u170629521_flutter";

// Conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error en la conexión: " . $e->getMessage()]);
    exit();
}

// Verificar si el método es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Método no permitido"]);
    exit();
}

// Decodificar el JSON recibido
$data = json_decode(file_get_contents("php://input"), true);
if ($data === null) {
    echo json_encode(["error" => "Error al decodificar JSON"]);
    exit();
}

// Verificar que se haya definido la acción
if (!isset($data['action'])) {
    echo json_encode(["error" => "Acción no definida"]);
    exit();
}

// Ejecutar la acción correspondiente
$action = $data['action'];

switch ($action) {
    case 'register':
        if (isset($data['usuario'], $data['correo'], $data['contrasena'], $data['telefono'], $data['edad'])) {
            $hashedPassword = password_hash($data['contrasena'], PASSWORD_BCRYPT);
            $sql = "INSERT INTO usuarios (usuario, correo, contrasena, telefono, edad) 
                    VALUES (:usuario, :correo, :contrasena, :telefono, :edad)";
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([
                    ':usuario' => $data['usuario'],
                    ':correo' => $data['correo'],
                    ':contrasena' => $hashedPassword,
                    ':telefono' => $data['telefono'],
                    ':edad' => $data['edad']
                ]);
                echo json_encode(["success" => true, "message" => "Usuario registrado correctamente."]);
            } catch (PDOException $e) {
                echo json_encode(["success" => false, "error" => "Error al registrar usuario: " . $e->getMessage()]);
            }
        } else {
            echo json_encode(["error" => "Faltan datos obligatorios para el registro"]);
        }
        break;

    case 'login':
        if (isset($data['correo'], $data['contrasena'])) {
            $sql = "SELECT usuario, contrasena FROM usuarios WHERE correo = :correo";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':correo' => $data['correo']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($data['contrasena'], $user['contrasena'])) {
                echo json_encode(["success" => true, "usuario" => $user['usuario'], "message" => "Inicio de sesión exitoso"]);
            } else {
                echo json_encode(["success" => false, "error" => "Credenciales incorrectas"]);
            }
        } else {
            echo json_encode(["error" => "Faltan datos para el inicio de sesión"]);
        }
        break;

    case 'payment':
        if (isset($data['usuario'], $data['correo'], $data['tarjeta'], $data['vencimiento'], $data['cvv'], $data['product_id'], $data['date_time'])) {
            $sql = "INSERT INTO payments (usuario, correo, tarjeta, vencimiento, cvv, product_id, date_time) 
                    VALUES (:usuario, :correo, :tarjeta, :vencimiento, :cvv, :product_id, :date_time)";
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([
                    ':usuario' => $data['usuario'],
                    ':correo' => $data['correo'],
                    ':tarjeta' => $data['tarjeta'],
                    ':vencimiento' => $data['vencimiento'],
                    ':cvv' => $data['cvv'],
                    ':product_id' => $data['product_id'],
                    ':date_time' => $data['date_time']
                ]);
                echo json_encode(["success" => true, "message" => "Pago registrado correctamente."]);
            } catch (PDOException $e) {
                echo json_encode(["success" => false, "error" => "Error al registrar el pago: " . $e->getMessage()]);
            }
        } else {
            echo json_encode(["error" => "Faltan datos para el pago"]);
        }
        break;

    case 'update_profile':
        if (isset($data['current_email'], $data['new_email'], $data['new_password'], $data['new_phone'], $data['new_age'], $data['new_usuario'])) {
            $hashedPassword = password_hash($data['new_password'], PASSWORD_BCRYPT);
            $sql = "UPDATE usuarios SET usuario = :new_usuario, correo = :new_email, contrasena = :new_password, telefono = :new_phone, edad = :new_age WHERE correo = :current_email";
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([
                    ':new_usuario' => $data['new_usuario'],
                    ':new_email' => $data['new_email'],
                    ':new_password' => $hashedPassword,
                    ':new_phone' => $data['new_phone'],
                    ':new_age' => $data['new_age'],
                    ':current_email' => $data['current_email']
                ]);
                echo json_encode(["success" => true, "message" => "Perfil actualizado correctamente."]);
            } catch (PDOException $e) {
                echo json_encode(["success" => false, "error" => "Error al actualizar el perfil: " . $e->getMessage()]);
            }
        } else {
            echo json_encode(["error" => "Faltan datos para la actualización del perfil"]);
        }
        break;

    default:
        echo json_encode(["error" => "Acción no válida"]);
}
?>
