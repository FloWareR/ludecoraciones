<?php


$conectar = mysqli_connect('localhost','u170629521_ReferedFlutter','4VoTO/BMf!');
$databs = mysqli_select_db($conectar, 'u170629521_flutter')

if($conectar){
    echo 'bien';
}
if($databs){
    echo 'bien base';
}
?>