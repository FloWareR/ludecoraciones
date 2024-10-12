<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function printArray($data){
	echo '<pre'.print_r($data,true).'</pre>';
}

	ini_set("display_errors",1);
	ini_set("display_startup_errors",1);
	include("config/config.php");
	include("config/autoload.php");

	$uri = $_SERVER["REQUEST_URI"];
	$uri = str_replace("/landingpage",'',$uri);
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
	//echo $section;
	if(file_exists($filename) and is_file($filename)){
		include($filename);

	}else{echo 'error';}
?>

