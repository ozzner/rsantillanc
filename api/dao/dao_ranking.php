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
    
    public function registrar($mail,$sex,$nom,$feh,$app,$apm) {
        
        $this->uid = $aux->generateApiKey();  
              
        $sql= "INSERT INTO tb_usuario 
        (usu_mail,usu_sex,usu_nom,usu_fec_nac,usu_ap1,usu_ap2,usu_rate,ran_id,usu_uid)
         VALUES(?,?,?,?,?,?,?,?)";    
        
        #$pre = mysqli_affected_rows($link);
        $stmt = mysqli_prepare($this->link, $sql);
        mysqli_stmt_bind_param($stmt,"ssssssiis",$mail,$sex,$nom,$feh,$app,$apm,1,1,$this->uid);
        mysqli_stmt_execute($stmt);
                
        if (mysqli_stmt_affected_rows() > 0) 
            return "Succsess!";
        else 
            return "Error!";
        
        mysqli_stmt_close();
        mysqli_close($this->link);
    }

}

?>