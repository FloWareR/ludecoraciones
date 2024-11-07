<?php 
    class contact extends \System\Core
    {
        function __construct()
        {
            parent::__construct();
        }
        function main() : void 
        {
            $this->load->view("general/top");
            echo '<h1>aca estan los contactos pa</h1>';
            $this->load->view("general/bottom");
        }
    }
?>