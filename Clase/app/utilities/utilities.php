<?php
namespace Utilities;

class Utilities 
{
  
  function __construct() {
    
  }

  public static function print($data,$die = false){
    echo '<pre>'.print_r($data,true).'</pre>';
    if($die === true){
      die();
    }
  }

  public static function var_dump($data,$die = false){
    echo '<pre>';
      var_dump($data);
    echo '</pre>';
    if($die === true){
      die();
    }
  }

  public static function print_JSON($data,$die = false){
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    if($die === true){
      die();
    }
  }
}

?>