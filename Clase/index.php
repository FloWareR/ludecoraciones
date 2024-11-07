<?php
  // if(DEV_ENV === true){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
  // }

  include("config/config.php");
  include("config/autoload.php");
  session_start();
  $core = new \System\Core();
  $router = \System\Router::getInstance("index",SUBDIR);
  \Utilities\Utilities::print($router);


  $noFound = true;
  $controllerName = $router->getController();
  if($controllerName)
  {
    $controller = $core->load->controller($controllerName);
    if (is_object($controller)) 
    {
      $method = $router->getMethod();
      $params = $router->getParams();
      if ($method == "") 
      {
        $method = "main";
      }
      if (method_exists($controller,$method)) 
      {
        $noFound = false;
        call_user_func_array([$controller,$method],$params);
      }
    }
  }
  if ($noFound) 
  {
    echo '404';
  }
?>