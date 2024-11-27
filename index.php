<?php

function printArray($data) {
    echo '<pre>' . print_r($data, true) . '</pre>';
}

// Mostrar errores (solo en desarrollo)
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);

include("config/config.php");
include("config/autoload.php");

// Obtener la URI actual
$uri = $_SERVER["REQUEST_URI"];
$uri = trim($uri, '/'); // Eliminar slashes iniciales y finales

// Separar la URI en partes
$uritmp = explode("/", $uri);
$uritmp = array_filter($uritmp); // Eliminar elementos vacíos
$uritmp = array_values($uritmp); // Reindexar el array

// Determinar la sección
if (empty($uritmp)) {
    $section = "index"; // Página por defecto
} else {
    $section = $uritmp[0]; // Primera parte de la URI
}

// Construir la ruta del archivo
$filename = "views/sections/$section.php";

// Verificar si el archivo existe
if (file_exists($filename) && is_file($filename)) {
    include($filename);
} else {
    include("views/sections/error404.php"); // Archivo de error 404
}
?>
