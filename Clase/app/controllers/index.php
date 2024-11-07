<?php 
    class index extends \System\Core
    {
        function __construct()
        {
            parent::__construct();
        }
        function main() : void 
        {
            $data = [];
            $data["hello"] = "mm";
            $home = $this->load->model("home");
            $data["sliders"] = $home->getSliders();
            $this->load->view("general/top");
            $this->load->view("sections/index", $data);
            $this->load->view("general/bottom");
        }
        function hola() : void 
        {
            echo '<h1>No es un hola</h1>';
        }
        function suma($a,$b = 0) : void {
            echo $a+$b;
        }
    }

?>