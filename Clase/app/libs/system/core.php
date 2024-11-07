<?php 
  namespace System;
  use System\Load;

  class Core 
  {
    public $load;
    
    public function __construct() {
        $this->load = Load::getInstance();
    }

  }

?>