<?php 
    class home extends \System\Core{
        function __construct(){
            parent::__construct();
        }

        function getSliders() : array {
            $pdo = \Db\Dbpdo::getInstance();
            $sql = "SELECT * from sliders";
            $params = [];
            $response = $pdo->selectSql($sql, $params);
            return $response;
        }
    }
?>