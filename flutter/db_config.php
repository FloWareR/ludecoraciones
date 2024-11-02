<?php
$servername = "localhost";
$username = "u170629521_ReferedFlutter";
$password = "Refered1234"; 
$dbname = "u170629521_flutter";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>