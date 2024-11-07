<?php 
/**
 * Clase que permite conectarse con el motor de bases de datos a través de PDO
 * @author      Carlos Alberto de la cruz belmonte @btishop
 * @package     pdo.php
 * @access      public
 * @version     1.7.4
 * @framework     btframework
 * bugs fixed
 * clearSelect no detect correctly sub queries in main select 
 * and change position of group appear validation to countRows
 * last update 2023/02/26
 */
namespace Db;
use \PDO;

class Dbpdo
{
	/* Propiedades y Atributos */
	private static $instancia;
	private $dbh;
	public $totalrows;
	public $numPags;
	public $currentPag;
	private $QueryID;
	private $InsertID;
	private $last_query;
	private $query_pag;
	public $error;
	private $dbhost;
	private $dbuser;
	private $dbpass;
	private $dbname;
	private $dbcharset;
	public $Error_no; 
	private $env;
	public $stm;
	private $connectedTo;
	private $settedStatus;
	private $dbtype;
	private $total;

	public function __construct($dbconfig = "default")
	{
		try{
			require_once __DIR__.'/../../../config/config.php';
			$this->Error_no = ERROR_NO;// Errores por los que no se conecta a MySQL
			$this->env = DEV_ENV;
			$setted = $this->setDbConfig($dbconfig);
			if(!$setted){
				$this->setDbConfig("default");
			}
			$this->dbcharset = CHARSET;

			$this->connectPdo();
		}catch (PDOException $ex) {
			// \utilities\Utilities::crearLog($ex, $this->Error_no, $this->env);
		}
	}

	public static function getInstance($dbconfig = "default"){
		try {
			if (!isset(self::$instancia)) {
				$miclase = __CLASS__;
				self::$instancia = new $miclase($dbconfig);
			}
			return self::$instancia;
			
		} catch (Exception $ex) {
			// \utilities\Utilities::crearLog($ex,ERROR_NO,DEV_ENV);
		}
	}

	public function setDbConfig($configName)
	{
		if(isset(DB_CONFIG[$configName])){
			$this->dbtype = DB_CONFIG[$configName]["DB_TYPE"];
			$this->dbuser = DB_CONFIG[$configName]["DB_USER"];
			$this->dbpass = DB_CONFIG[$configName]["DB_PASS"];
			$this->dbhost = DB_CONFIG[$configName]["DB_HOST"];
			$this->dbname = DB_CONFIG[$configName]["DB_NAME"];
			$success = true;
		}else{
			$success = false;
		}
		return $success;
	}

	public function connectPdo(){
		try{
			if(!$this->isConnected()){
				$dns = $this->dbtype.':dbname='.$this->dbname.';host='.$this->dbhost.';charset='.$this->dbcharset;
				$this->dbh = new PDO($dns, $this->dbuser, $this->dbpass);
				$this->dbh->exec("SET CHARACTER SET ".$this->dbcharset);
				$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
		}catch (PDOException $ex) {
			// \utilities\Utilities::crearLog($ex, $this->Error_no, $this->env);
		}
	}

	public function connectTo($dbconfig){
		try{
			if($dbconfig != ""){
				if($this->setDbConfig($dbconfig)){
					$this->dbh = NULL;
					$this->connectPdo();
				}
			}
		}catch (PDOException $ex) {
			// \utilities\Utilities::crearLog($ex, $this->Error_no, $this->env);
		}
	}

	public function isConnected(){
		if($this->dbh != NULL){
			return true;
		}else
		return false; 
	}

	/**
	  * Método para preparar la instrucción a ejecutar
	*/
	public function prepare($sql){
		return $this->dbh->prepare($sql);
	}

	/**
  	* Método para preparar la instrucción SQL a ejecutar y crea el caché de los resultados.
  */
	public function selectSQL($sql, $array, $limit = null,$pag = 0,$onefetch = false){
		$result = NULL;
		$this->total = 0;
		$this->totalrows = 0;
		try {
			if($array == NULL or !is_array($array)){
				$array = array();
			}

			if($limit != NULL){
				$this->totalrows = $this->countRows($sql,$array);
				$sql = $this->paginate($sql,$limit,$this->totalrows,$pag);
			}
			$stm = $this->prepare($sql);
			$this->last_query = $sql;
			$stm->execute($array);
			if($onefetch and $stm->rowCount() == 1){
				$result = $stm->fetch(PDO::FETCH_ASSOC);
			}else{

				$result = $stm->fetchAll(PDO::FETCH_ASSOC);  
			}  

		}catch (Exception $ex) {
			// \utilities\Utilities::crearLog( $ex, $this->Error_no,  $this->env);
		}
		return $result;
	}

  /* Metodo para crear un generador de filas de un SELECT SQL */
  public function fetchAll($sql, $params = [], $limit = null, $page = 0) {
    $this->total = 0;
    $this->totalrows = 0;
    try {
      if (!is_array($params)) {
        $params = [];
      }

      if (is_numeric($limit) && $limit > 0) {
        $this->totalrows = $this->countRows($sql, $params);
        $sql = $this->paginate($sql, $limit, $this->totalrows, $page);
      }

      $stmt = $this->prepare($sql);
      $this->last_query = $sql;
      $stmt->execute($params);

      while ( ($row = $stmt->fetch(PDO::FETCH_ASSOC)) ) {
        yield $row;
      }
    } catch (Exception $ex) {
			// \utilities\Utilities::crearLog( $ex, $this->Error_no, $this->env);
    }
  }

  /**
  * Método para preparar la instrucción SQL a ejecutar y crea el caché de los resultados.
  */
	public function executeSQL($sql, $array){
		$result = array("id"=>0,"total"=>0);
		$this->total = 0;
		try {
			if($array == NULL or !is_array($array)){
				$array = array();
			}
			$this->stm = $this->prepare($sql);
			$this->last_query = $sql;
			$response = $this->stm->execute($array);
			if(!$response){
				$error = $this->stm->errorInfo();
				$this->error = $error[2];
			}else{
				$this->error = "";
			}
			$this->totalrows = $this->stm->rowCount();
			$this->InsertID= $this->dbh->lastInsertId();  
			$result["id"] = $this->InsertID;  
			$result["total"] = $this->totalrows;  
			$result["error"] = $this->error;
		}catch (Exception $ex) {
      $result["error"] = $ex->getMessage();
			// \utilities\Utilities::crearLog( $ex, $this->Error_no, $this->env);
		}
		return $result;
	}

	public function querySQL($sql, $array){
		return $this->executeSQL($sql,$array);
	}
	function setdb($name){
		$this->executeSQL("USE $name",array());
	}

	public function last_insert(){
		return $this->InsertID;
	}

	public function last_query()
	{
		return $this->last_query;
	}

	public function pagination_query()
	{
		return $this->query_pag;
	}

	public function total_rows()
	{
		return $this->totalrows;
	}

	public function num_pags()
	{
		return $this->numPags;
	}

	public function get_current_pag()
	{
		return $this->currentPag;
	}

	public function num_rows($dbh)
	{
		return $dbh->rowCount();
	}

	public function fetch($dbh)
	{
		return $dbh->fetch(PDO::FETCH_ASSOC);
	}
	/**
    * Método contar los registros que arroja una consulta.
    */
    public function countRows($sql,$array = "") {
    	$total = 0;
        // Verificamos que no sea un "DISTINCT"
    	$pos = strpos(strtoupper($sql), "DISTINCT");
    	if($pos !== false){
    		$stm = $this->prepare($sql);
    		$stm->execute($array);
    		$total = $this->stm->rowCount(); 
    	}else{
    		$string = "SELECT";
    		$groupby = "GROUP BY";
    		// $selapear = substr_count(strtoupper($sql), $string);
    		$groupapear = substr_count(strtoupper($sql), $groupby);
    		if($groupapear == 0)
    		{

    			$sqlClear = $this->getClearStmSelect($sql);
					$posselectini = strpos($sqlClear,$string);
				  $posselectfin = $posselectini + strlen($string);
				  $from = "FROM";
					$posfromini = strpos($sqlClear,$from);
					$posfromfin = $posfromini - $posselectfin - 1;
					$substr = substr($sqlClear, $posfromini);
					$posMainFrom = strpos(strtoupper($sql), $substr);
					$body = ($posMainFrom) - $posselectfin ;
					$substr = substr($sql,$posselectfin,$body);

    			$string = ' count(*) as total ';
    			$sql = str_replace($substr, $string, $sql);

    			$pos = strpos(strtoupper($sql), 'ORDER');
    			if($pos !== false){
    				$sql = substr($sql, 0, ($pos-1));
    			}
    			$pos = strpos(strtoupper($sql), 'LIMIT');
    			if($pos !== false){
    				$sql = substr($sql, 0, ($pos-1));
    			}
    		}
    		// \Utilities\Utilities::print($sqlClear);
    		// \Utilities\Utilities::print($sql,true);
    		$stm = $this->prepare($sql);
    		$stm->execute($array);
    		$regs = $stm->fetchAll(PDO::FETCH_ASSOC);
    		$t = count($regs);
    		if($t>0 and isset($regs[0]["total"])  and $groupapear == 0){
    			$total =  $regs[0]["total"];            
    		}
    		elseif(count($regs) > 0)              
    		{
    			$total = $t;
    		}
    	}
    	$this->query_pag = $sql;
    	return $total;
    }

    /**
    * Método paginar los resultados
    */
    public function paginate($sql,$numtotpags,$total,$pag = 0){
    	if(isset($_REQUEST['pag'])){ 
    		$pag = $_REQUEST['pag']; 
    		if($pag == 0 ){ 
    			$pag = 1; 
    		} 
    	}elseif(isset($_REQUEST['iDisplayStart'])){ 
    		$pag = ($_POST["iDisplayStart"]/$numtotpags)+1; 
    		if($pag == 0 ){ 
    			$pag = 1; 
    		} 
    	}elseif(isset($_REQUEST['start'])){ 
    		$pag = ($_POST["start"]/$numtotpags)+1; 
    		if($pag == 0 ){ 
    			$pag = 1; 
    		} 
    	}elseif($pag <= 0){
    		$pag = 1; 
    	}

    	$numPags = ceil($total/$numtotpags);
    	if($pag <= 0){ 
    		$pag = 1; 
    	}
    	if($pag > $numPags and $numPags != 0){ 
    		$pag = $numPags; 
    	} 
    	$this->currentPag = $pag;
    	$pos = strpos(strtoupper($sql), 'LIMIT');
    	if($pos !== false and substr_count($sql, "SELECT") ==  1){
    		print_array("limit exists in query",true);
    	}
    	$restriccion = " LIMIT ".(($pag-1)*$numtotpags).", $numtotpags ";
    	$sql = "$sql $restriccion"; 
    	$this->numPags = $numPags;
    	return $sql;
	}

	public function setTimeZone($timeZone,$setDBTime = false)
	{
		
		date_default_timezone_set($timeZone);
		if($setDBTime === true){
			$this->setDBTime($timeZone);
		}
	}

	private function setDBTime($timeZone){
		$this->executeSQL('SET time_zone = "+00:00"',array());
		$r=$this->selectSQL("SELECT NOW() as time",array());
		$r = $r[0];
		$db_date=date("U",strtotime($r['time']));
		$srv_date=date("U",strtotime(date('Y-m-d H:i:s')));
		$time_now=date('Y-m-d H:i:s');
		
		$dif_date=$srv_date-$db_date;
		$signo="+";
		if($dif_date<1) {
			$signo="-";
			if($dif_date<0)
				$dif_date=$dif_date*(-1);
		}
		$minutos=$dif_date/60;
		$horas=floor($minutos/60);
		$minutos-=$horas*60;
		$tiempo=$signo.(($horas<10)?"0":"").$horas.":".(($minutos<10)?"0":"").$minutos;
		$tiempo=explode(':',trim($tiempo));
		$tiempo[1]=str_pad(trim(number_format($tiempo[1], 0, '','')), 2, "0", STR_PAD_LEFT);
		$tiempo=implode(':',$tiempo);
		$response = $this->executeSQL('SET time_zone = "'.$tiempo.'"',array());
		return $response;
	}

	public function getClearStmSelect($stm)
	{
		$selectString = "SELECT";
		$stm = strtoupper($stm);
		// print_array_debug("select to clear --- \n".$stm. "\n ----- Select to clear");
		$stmlen = strlen($stm);
		$stmOriginal = $stm;
		$posselectini = strpos($stm,$selectString);
    $posselectfin = $posselectini + strlen($selectString);
		$from = "FROM";
		$posfromini = strpos($stm,$from);
		$posfromfin = $posfromini + strlen($from);
		if(strpos($stm,"(",$posselectfin) > $posselectfin and strpos($stm,"(",$posselectfin) < $posfromfin){
			$posSub = strpos($stm,"(",$posselectfin);
			$posfromini = strpos($stm,$from,$posSub);
			$posfromfin = $posfromini + strlen($from);
			$subSelectPosition = strpos($stm,$selectString,$posSub);
			// print_array_debug(strpos($stm,")",$posfromfin) ." >= ". $posfromfin ." and ". $subSelectPosition ." < ". $posfromfin ." and ". $subSelectPosition);
			if(strpos($stm,")",$posfromfin) >= $posfromfin and $subSelectPosition < $posfromfin and $subSelectPosition !== false){
				$positionPrevSelect = strrpos($stm,"(",($subSelectPosition-$stmlen));
				// print_array_debug("posSub  $posSub -- posti$positionPrevSelect  $positionPrevSelect  --- {$stm[$positionPrevSelect-1]}{$stm[$positionPrevSelect]}{$stm[$positionPrevSelect+1]}{$stm[$positionPrevSelect+2]}");
				$posSubFin = strpos($stm,")",$posfromfin) +1 ;
				if($posSub != $positionPrevSelect){
					$posSub = $positionPrevSelect;
				}
				$bodyFrom = $posSubFin -$posSub;
				$substr = substr($stm, $posSub, $bodyFrom);
				// \Utilities\Utilities::print("posSubFin $posSubFin --- bodyFrom $bodyFrom  -- start in --- $posSub");
				// print_array_debug($substr.'  -- from clear');
				$strToReplaceRegEx = str_replace(array("(",")","*",'|'),array("\(","\)","\*",'\|'),$substr);
				// print_array_debug($strToReplaceRegEx.'prev regex');
				$stm = preg_replace('/'. $strToReplaceRegEx.'/',"''",$stm,1);
				$posSubFin = strpos($stm,")",$posSub) +1 ;
				// \Utilities\Utilities::print($stm.'  -- after replace');
				if(isset($stm[$posSubFin]) and strpos($stm,"(",$posSub) > $posSub){
					// \Utilities\Utilities::print($stm.'  -- prev to recall');
					$stmClear = $this->getClearStmSelect($stm);
				}else{
					// \Utilities\Utilities::var_dump(strpos($stm,"(",$posSub));
					if(!isset($stm[$posSubFin])){
						$stm = $stmOriginal;
					}
					$stmClear = $stm;
				}
			}else{
				$stmClear = $stm;
			}
		}else{
			$stmClear = $stm;		
		}
		return $stmClear;
	}

}

?>