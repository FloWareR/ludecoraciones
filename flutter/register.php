<?php
require('connect.php')

$user = mysqli_real_escape_string($conectar,$_POST['usuario']);
$mail = mysqli_real_escape_string($conectar,$_POST['correo']);
$pass = mysqli_real_escape_string($conectar,$_POST['pass']);
echo $user.'=='.$correo.'=='.$pass;

?>