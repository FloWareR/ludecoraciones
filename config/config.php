<?php


define("SUBDIR","/practica1");
define("URL",'http://'.$_SERVER["SERVER_NAME"].SUBDIR);

define("DOCUMENT_ROOT",$_SERVER["DOCUMENT_ROOT"].SUBDIR);
define("APPLICATION",DOCUMENT_ROOT.'');
define("SOURCE",APPLICATION);

$dbconfig = array();
  $dbconfig["default"]["DB_TYPE"] = "mysql";
  $dbconfig["default"]["DB_HOST"] = "localhost";
  $dbconfig["default"]["DB_NAME"] = "test";
  $dbconfig["default"]["DB_USER"] = "root";
  $dbconfig["default"]["DB_PASS"] = "";

  define("DB_CONFIG", $dbconfig);
  define("CHARSET","utf8");

?>