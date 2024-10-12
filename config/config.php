<?php


define("SUBDIR","");
define("URL",'https://'.$_SERVER["SERVER_NAME"].SUBDIR);

define("DOCUMENT_ROOT",$_SERVER["DOCUMENT_ROOT"].SUBDIR);
define("APPLICATION",DOCUMENT_ROOT.'/Practica1');
define("SOURCE",APPLICATION);

$dbconfig = array();
  $dbconfig["default"]["DB_TYPE"] = "mysql";
  $dbconfig["default"]["DB_HOST"] = "ludecoraciones.com";
  $dbconfig["default"]["DB_NAME"] = "u170629521_LuDecoraciones";
  $dbconfig["default"]["DB_USER"] = "u170629521_Refered";
  $dbconfig["default"]["DB_PASS"] = "";

  define("DB_CONFIG", $dbconfig);
  define("CHARSET","utf8");

?>