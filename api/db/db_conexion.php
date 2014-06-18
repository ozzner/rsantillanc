<?php

class conexion
{

    public function __construct()
    {
        include_once('/db_server.php');
    }

    public function getConexion() {
        
       $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); 
       
       if ($conn->connect_errno) {
           $aJson['message']="Error conexion";
           $aJson['info'] = 'No se establecio conexion con el servidor';
           return $aJson;
       }else{
            return $conn;  
       }

    }
    

}



?>
