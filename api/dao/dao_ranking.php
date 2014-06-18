<?php

class usuario{
    
    private $link,$uid;
    
    function __construct() {
        
        require_once '../db../db_conexion.php';
        require_once '/dao_auxiliar.php';
        $aux = new funciones();         
        $db = new conexion();
        $this->link = $db->getConexion();        
    }
    


}

?>