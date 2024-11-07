<?php 
/** 
 * depends of config.php
 * @author Carlos Alberto de la cruz belmonte
*/
namespace System;

class Load
{
  private static $instance;
	private $contextParams = array();

  public function __construct()
	{
		# code...
	}

  public static function getInstance(){
		try {
			if (!isset(self::$instance)) {
				$miclase = __CLASS__;
				self::$instance = new $miclase();
			}
			return self::$instance;
			
		} catch (Exception $ex) {
			// crearLog($ex,ERROR_NO,DEV_ENV);
		}
	}

  public function sourceExist($source)
	{
		// $data = str_replace("_", "/", $source);
		$data = $source; 
    $file = SOURCE."/".$data.".php";
    return (is_file($file) && file_exists($file));
	}

	public function controller($controllerName,$params = "")
	{
			return $this->loadClass("controllers/$controllerName",$params);
	}

	public function model($modelName,$params = "")
	{
			return $this->loadClass("models/$modelName",$params);
	}

	public function view($viewName,$params = array(), $toVar = false)
	{
			if($this->sourceExist("views/$viewName")){
				if(is_array($params))
					extract($params);
				$this->setContextParams($params);
				$file =  SOURCE.'/views/'.$viewName.'.php';
				if($toVar === true){
					ob_start();
						include($file);
						$response = ob_get_contents();
					if (ob_get_contents()) 
						@ob_end_clean();
				}else{
					$response = true;
					include($file);
				}
			}else{
				$response = false;
				$message = "no se encontro la vista \"$viewName\"";
				echo $message;
			}
			return $response;
	}

	public function moduleView($viewName,$dirModelView,$params = "", $toVar = false)
	{
		
		if($this->sourceExist("views/$dirModelView/$viewName")){
			$dirview = $dirModelView.'/'.$viewName;
		}else{
			$dirview = 'backoffice/modules/'.$viewName;
		}
		return $this->view($dirview,$params,$toVar);
	}

  private function loadClass($sourceClass, $params = "")
	{
		try {
			$response = false;
			if($this->sourceExist($sourceClass)){
				
				require_once SOURCE.'/'.$sourceClass.'.php';
				$className = $this->getClassName($sourceClass);
				if($params != ""){
					$response = new $className($params);
				}else{
					$response = new $className();
				}
			}
			return $response;
		} catch (Exception $ex) {
			// crearLog($ex,ERROR_NO,DEV_ENV);
		}
	}

	private function getClassName($data)
	{
		if(substr_count($data, "/") > 0){
			$tmp = explode("/", $data);
			$name = $tmp[(count($tmp)-1)];
		}else{
			$name = $data;
		}
		return ucfirst($name);
  }
	public function setContextParams($params)
	{
		if(is_array($params))
			$this->contextParams = array_merge($this->contextParams,$params);
	}

	public function getContextParams()
	{
		return $this->contextParams;
	}
}

?>