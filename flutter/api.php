<?php
header("Content-Type: application/json");

// Configuración de conexión a la base de datos
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

// Verifica que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Método no permitido"]);
    exit();
}

// Decodifica los datos JSON recibidos
$data = json_decode(file_get_contents("php://input"), true);

if ($data === null) {
    echo json_encode(["error" => "Error al decodificar JSON"]);
    exit();
}

// Verifica la acción a realizar: registro o inicio de sesión
if (isset($data['action']) && $data['action'] === 'register') {
    // Lógica para registrar un nuevo usuario
    if (isset($data['usuario'], $data['correo'], $data['contrasena'])) {
        $sql = "INSERT INTO usuarios (usuario, correo, contrasena, telefono, edad) 
                VALUES (:usuario, :correo, :contrasena, :telefono, :edad)";

        // Hashea la contraseña
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
} elseif (isset($data['action']) && $data['action'] === 'login') {
    // Lógica para iniciar sesión de usuario
    if (isset($data['correo'], $data['contrasena'])) {
        $sql = "SELECT contrasena FROM usuarios WHERE correo = :correo";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':correo' => $data['correo']]);
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verifica la contraseña
            if (password_verify($data['contrasena'], $user['contrasena'])) {
                echo json_encode(["success" => true, "message" => "Inicio de sesión exitoso"]);
            } else {
                echo json_encode(["success" => false, "error" => "Contraseña incorrecta"]);
            }
        } else {
            echo json_encode(["success" => false, "error" => "Usuario no encontrado"]);
        }
    } else {
        echo json_encode(["error" => "Faltan datos para el inicio de sesión"]);
    }
} else {
    echo json_encode(["error" => "Acción no válida"]);
}
?>
