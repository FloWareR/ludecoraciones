<?php

function printArray($data){
	echo '<pre'.print_r($data,true).'</pre>';
}

	ini_set("display_errors",1);
	ini_set("display_startup_errors",1);
	include("config/config.php");
	include("config/autoload.php");

	$uri = $_SERVER["REQUEST_URI"];
	$uri = str_replace("/practica1",'',$uri);
	if ($uri == "/"){
		$uri = "";
	}
	$uritmp = explode("/",$uri);
	array_shift($uritmp);
	$uritmp = array_values($uritmp);
	//printArray($uritmp);
	//var_dump(empty($uritmp) or (isset($uritmp[0])and $uritmp[0] == ""));
	if(empty($uritmp) or (isset($uritmp[0])and $uritmp[0] == "")){
		$section = "index";
	}else{
		$section = $uritmp[0];
	}
	$filename = "views/sections/$section.php";
	//echo $filename;
	if(file_exists($filename) and is_file($filename)){
		include("views/general/top.php");
		include($filename);
		include("views/general/bottom.php");

	}else{echo 'error';}
?>

