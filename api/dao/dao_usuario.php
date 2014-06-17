<?php

class usuario{
    
    private $link,$uid;
    
    function __construct() {
        
        require_once '../db../db_conexion.php';
        require_once '../sos../sos_helper.php';
              
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
            return "Success!";
        else  
        return mysqli_error($this->link); 
        
        }else{
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
    
    public function listarByIdApiKey($email,$Api_key) {
        $sql= "SELECT * FROM tb_usuario WHERE(usu_mail = $email AND usu_uid = $Api_key)";  
         
        $stmt = mysqli_prepare($this->link, $sql);
        
        if ($stmt) {
         mysqli_stmt_bind_param($stmt,"ss",$email,$Api_key);
         $rpta = mysqli_stmt_execute($stmt);
                                      
        if($rpta) {
            mysqli_stmt_bind_result($stmt,$var1,$var2,$var3,$var4,$var5,$var6,$var7,$var8,$var9);
            while (mysqli_stmt_fetch($stmt)) {
                $arData[] = array('usu_mail'=>$var1,
                                  'usu_sex' =>$var2,
                                  'usu_nom' =>$var3,    
                                  'usu_fec_nac' =>$var4,
                                  'usu_ap1' =>$var5,
                                  'usu_ap2' =>$var6,
                                  'usu_rate'=>$var7,
                                  'ran_id' =>$var8,
                                  'usu_uid'=>$var9); 
            }
        }
        }else  
        return mysqli_error($this->link); 
        
        mysqli_stmt_close();
        mysqli_close($this->link);
    }

    
}

?>
