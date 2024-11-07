<?php
/** depends of routing management
  * @author Carlos Alberto de la cruz belmonte
*/
namespace System;
class Router 
{
  private static $instance;

  public $paramsURI;
  private $controller;
  private $method = false;
  private $params = array();
  private $paginationSlug = "pag";
  private $routes = array();
  private $dirIgnore = "";
  private $baseIgnore = "";
  public $arrayRoute = array();
  private $route;
  private $isIgnore = false;
  private $basedir ;
  private $originalRoute = "";
  private $RouteAlias = [];
  private $defaultController;

  public function __construct($default = "index",  $basedir = "")
  {
		require_once __DIR__.'/../../../config/config.php';
    $this->defaultController = $default;
    /* if not detect the route change this */
    $this->route = $_SERVER["REQUEST_URI"];
    if(is_array(ROUTES) and !empty(ROUTES)){
      $this->routes = ROUTES;   
      $this->setAlias();
    }
    $this->basedir = $basedir;
    
    $this->mappingRoute();
	  // \Utilities\Utilities::printJSON($this->routes,true,true);

  }

  public static function getInstance($default="index",$baseIgnore = "",$dirIgnore = ""){
		try {
			if (!isset(self::$instance)) {
				$miclase = __CLASS__;
				self::$instance = new $miclase($default,$baseIgnore,$dirIgnore);
			}
			return self::$instance;
			
		} catch (Exception $ex) {
			Utilities_utilities::crearLog($ex,ERROR_NO,DEV_ENV);
		}
	}

  public function setRouter()
  {
    // verify if isIgnore active and add directory prefix if it has something
    /*if($this->isIgnore === true and trim($this->dirIgnore) != ""){
      $this->controller = $this->dirIgnore.'/';
    }*/
    if(trim($this->arrayRoute["controller"]) == "" ){
      if(isset($this->routes["default"]) and trim($this->routes["default"]) != "" and $this->isIgnore == false){
        $this->controller .= $this->routes["default"].'/'.$this->defaultController;
      }else{
        $this->controller .= $this->defaultController;
      }
    }	else{
      $this->controller .= $this->arrayRoute["controller"];
    }
    $this->method = $this->arrayRoute["method"];
    $this->params = $this->arrayRoute["params"];
  }

  public function mappingRoute()
  {
    $this->mapRoute()->setRouter();
  }

  public function mapRoute($routeMapping = "")
  {
    $controller = "";
    $method = "";
    $params = array();
    if($routeMapping != ""){
      $this->route = $routeMapping;
    }
    $this->checkRouteForAlias();
    if($this->route != ""){
      if(substr($this->route,-1,1) == "/"){
        $this->route = substr($this->route,0,strlen($this->route)-1);
      }
      if(substr_count($this->route,"?") > 0){
        $this->clearRoute("?");
        // $this->route = substr($this->route,0,strpos($this->route,"?"));
      }
      if(substr_count($this->route,"&") > 0){
        $this->clearRoute("&");
      }
      if(strpos($this->route,'/'.$this->basedir) === 0 and $this->basedir != "" ){
        $this->route = str_replace('/'.$this->basedir,'',$this->route);
        $this->isIgnore = true;
        $this->dirIgnore = $this->basedir;
      }
      $serverRoute = explode("/",$this->route);
      $totalserver = count($serverRoute);
      $i = 0;
      $controllerFound = false;
      $modelFound = false;
      $pagination = false;
      foreach ($serverRoute as $key => $fragment) { 
        if($i == 0 and isset($this->routes[$fragment])){
          $this->dirIgnore = $this->routes[$fragment];
          $this->baseIgnore = $fragment;
          $this->isIgnore = true;
          continue;
        }
        if($fragment == $this->paginationSlug){
          $pagination = true; 
          continue;
        }elseif($pagination == true){
          $_GET["pag"] = $fragment;
          $pagination = false;
          if($controllerFound == false)
            $controllerFound = true;
          if($modelFound == false)
            $modelFound = true;
          
        }
        if($fragment != ""){
          if($i == 0 and $controllerFound === false){
            if(isset($this->routes["default"]) and trim($this->routes["default"]) != "" and $this->isIgnore == false){
              $controller = $this->routes["default"].'/'.$fragment;
            }else{
              $controller = $fragment;
            }
            $controllerFound = true;
          }elseif($i == 1 and $modelFound === false){
            $method = $fragment;
            $modelFound = true;
          }elseif($controllerFound === true and $modelFound === true){
            $params[] = $fragment;
          }
          $i++;
        }
      }
    }
    $this->arrayRoute = array(
      "controller" =>  $controller
    );
    $this->arrayRoute["method"] =  $method;
    $this->arrayRoute["params"] = $params;
    return $this;
  }

  public function setAlias()
  {
    foreach ($this->routes as $key => $route) {
      if(substr_count($key,":any") > 0){
        $keyRoute = '\/'.str_replace([":any","/"],[".*",'\\/'],$key);
        $this->RouteAlias[$keyRoute] = $route;
      }elseif(substr_count($key,'(') > 0){
        $this->RouteAlias['\/'.$key] = $route;
      }
    }
  }
  public function getController()
  {
    return $this->controller;
  }

  public function getMethod()
  {
    return $this->method;
  }

  public function getParams()
  {
    return $this->params;
  }

  public function getBaseDir()
  {
    return $this->dirIgnore;
  }

  public function getBase()
  {
    return $this->baseIgnore;
  }

  public function getRoute()
  {
    return ($this->originalRoute != "") ? $this->originalRoute : $this->route;
  }

  public function cleanFirstSlash(string $route)
  {
    if(substr($route,0,1) == "/"){
      return substr($route,1,strlen($route)-1);
    }else{
      return $route;
    }
  }

  public function clearRoute($char)
  {
    if(substr_count($this->route,$char) > 0){
      $this->route = substr($this->route,0,strpos($this->route,$char));
    }
    return $this;
  }

  public function checkRouteForAlias()
  {
    $splite = [];
    $routetmp = "";
    foreach ($this->RouteAlias as $key => $route) {
      // \Utilities\Utilities::print($this->route. '<-->'.$key . '  '."/^".$key."$/");
      // \Utilities\Utilities::var_dump(preg_match("/^$key$/",$this->route));
      
      if(preg_match("/^".$key."$/",$this->route,$splite)){
        if(isset($splite[1])){
          $total = count($splite);
          $routetmp = $route;
          for ($i=1; $i < $total; $i++) { 
            $string = "$$i";
            // \Utilities\Utilities::print($string);
            $routetmp = str_replace($string,$splite[$i],$routetmp);
          }
        }
        // \Utilities\Utilities::print($routetmp);
        // \Utilities\Utilities::print($splite,true);
        break;
      }
    }
    if($routetmp != ""){
      $this->originalRoute = $this->route;
      $this->route = $routetmp;
    }
  }
}

?>