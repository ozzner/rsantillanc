<?php

class usuario{
    
    private $cnx;
    
    function __construct() {
        
        require_once dirname(__FILE__).'/db_conexion.php';
        $db = new conexion();
        $this->cnx = $db->getConexion();
        
    }
    
    public function registrar($param) {
        
    }

}

?>
