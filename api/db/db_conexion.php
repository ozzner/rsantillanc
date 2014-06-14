<?php

class conexion
{
    private $conn;

    public function __construct()
    {
        include_once('/db_server.php');
    }

    public function getConexion() {
     $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME) OR
     die ('Error al establecer conexion db: '.mysqli_connect_error());          
     
     return $this->conn;
    }
    

}



?>
