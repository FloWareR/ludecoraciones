<?php

function printArray($data){
	echo '<pre'.print_r($data,true).'</pre>';
}

	ini_set("display_errors",1);
	ini_set("display_startup_errors",1);
	include("config/config.php");
	include("config/autoload.php");

	$uri = $_SERVER["REQUEST_URI"];
	if ($uri == "/"){
		$uri = "";
	}
	$uritmp = explode("/",$uri);
	array_shift($uritmp);
	$uritmp = array_values($uritmp);
	//printArray($uritmp);
	$uri = str_replace("/Practica","",$uri);
	if($uritmp[0] == ""){
		$section = "index";
	}else{
		$section = $uritmp[0];
	}
	$filename = "views/sections/index.php";
	if(file_exists($filename) and is_file($filename)){
		include("views/general/top.php");
		include($filename);
		include("views/general/bottom.php");

	}else{echo 'error';}
?>

