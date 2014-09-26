<?php

class conexion
{

    public function __construct()
    {
        include_once '/home/appradec/public_html/api/db/db_server.php';
//        include_once '../db../db_server.php';
    }

    public function getConexion() {
        
       $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); 
      
       
       if ($conn->connect_errno) {
           $aJson['message']="Error de conexion";
           $aJson['info'] = 'El servidor no responde, verificar estado o parámetros de conexión' ;
           return $aJson;
       }else{
            return $conn;  
       }

    }
    

}



?>
