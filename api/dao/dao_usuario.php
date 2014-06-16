<?php

class usuario{
    
    private $link,$uid;
    
    function __construct() {
        
        require_once '../db../db_conexion.php';
        require_once '/dao_auxiliar.php';
              
        $db = new conexion();
        $this->link = $db->getConexion();        
    }
    
    public function registrar($mail,$sex,$nom,$feh,$app,$apm) {
        $aux = new funciones();  
        
        $this->uid = $aux->genApiKey();
              
        $sql= "INSERT INTO tb_usuario 
               (usu_mail,usu_sex,usu_nom,usu_fec_nac,usu_ap1,usu_ap2,usu_rate,ran_id,usu_uid)
               VALUES(?,?,?,?,?,?,?,?,?)";  
        
         $rate = 10;
         $ranid= 1;
             
        $stmt = mysqli_prepare($this->link, $sql);
        
        if ($stmt) {
         mysqli_stmt_bind_param($stmt,"ssssssiis",$mail,$sex,$nom,$feh,$app,$apm,$rate,$ranid,$this->uid);
         $rpta = mysqli_stmt_execute($stmt);
            
        if($rpta) 
            return "Succsess!";
        else 
            return "Error!";
        }else {
            die(mysqli_error($this->link));
        }
               
        mysqli_stmt_close();
        mysqli_close($this->link);
        
        
        /*  $pre = mysqli_affected_rows($link)
         *  mysqli_stmt_affected_rows().
         *  Asimismo, si la consulta produce un conjunto de resultados se usa la 
         *  función mysqli_stmt_fetch().
         */
                  
    }#End registrar

    
}

?>
