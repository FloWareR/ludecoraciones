API
<?php
// Configuración de cabeceras para JSON
header("Content-Type: application/json");

// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "u170629521_ReferedFlutter";
$password = "Refered1234";
$dbname = "u170629521_flutter";

// Conexión a la base de datos con PDO
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error en la conexión: " . $e->getMessage()]);
    exit();
}

// Verifica si la solicitud es POST y si los datos están en formato JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    // Validación de datos recibidos
    if (isset($input['usuario'], $input['correo'], $input['contrasena'])) {
        // Prepara la sentencia SQL para insertar el usuario
        $sql = "INSERT INTO usuarios (usuario, correo, contrasena, telefono, edad) 
                VALUES (:usuario, :correo, :contrasena, :telefono, :edad)";

        // Hash de la contraseña
        $hashedPassword = password_hash($input['contrasena'], PASSWORD_BCRYPT);

        // Prepara la inserción
        $stmt = $pdo->prepare($sql);
        
        try {
            // Ejecuta la inserción
            $stmt->execute([
                ':usuario' => $input['usuario'],
                ':correo' => $input['correo'],
                ':contrasena' => $hashedPassword,
                ':telefono' => $input['telefono'] ?? null,
                ':edad' => $input['edad'] ?? null
            ]);

            // Respuesta de éxito
            echo json_encode(["success" => true, "message" => "Usuario registrado correctamente."]);
        } catch (PDOException $e) {
            // Error en caso de correo duplicado o problema en la inserción
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => "Faltan datos obligatorios: usuario, correo y contrasena"]);
    }
} else {
    echo json_encode(["error" => "Método no permitido"]);
}
?>
