<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
class usuario {
    
    private $link,$uid,$time,$passHash;
    
    function __construct() {
        
        require_once '../db../db_conexion.php';
        require_once '../sos../sos_helper.php';
              
        $db = new conexion();
        $this->link = $db->getConexion(); 
     
    }
    
    public function registrar($mail,$sex,$nom,$feh,$app,$apm,$pass) {
        $aux = new funciones();  
        $this->time = $aux->genDataTime();
        $this->uid = $aux->genApiKey();
        $this->passHash= $aux->setHash($pass);
        
            $sql= "INSERT INTO tb_usuario 
               (usu_mail,usu_sex,usu_nom,usu_fec_nac,usu_ap1,usu_ap2,usu_rate,ran_id,usu_uid,usu_fec_ing,usu_pass)
               VALUES(?,?,?,?,?,?,?,?,?,?,?)";  

             $rate = 0;
             $ranid= 1;

             $stmt = mysqli_prepare($this->link, $sql);
          
             mysqli_stmt_bind_param($stmt,"ssssssiisss",
             $mail,$sex,$nom,$feh,$app,$apm,$rate,$ranid,$this->uid,$this->time,$this->passHash);
             $res = mysqli_stmt_execute($stmt);  //True - False
             
             if ($res) {
                   return "ok!";
             }  else{               
                 switch (mysqli_errno($this->link)) {
                     case 1062:
                        $arData['error_cod']=11.1;
                        $arData['message']='Error SQL - Entrada duplicada';
                        $arData['info']= 'El correo: '.$mail. " ya fue registrado!";
                        return $arData;
                     break;

                     case 1022:
                        $arData['error_cod']=11.2;
                        $arData['message']='Error SQL - No puede escribir';
                        $arData['info']=mysqli_error($this->link);  
                        return $arData;
                     break;
                     default:
                        $arData['error_cod']=11.3;
                        $arData['message']='Error SQL - Desconocido';
                        $arData['info']=mysqli_error($this->link);  
                        return $arData;
                     break;
                 }
             }
             
             mysqli_stmt_close();
             mysqli_close($this->link);                     
    
        /*  $pre = mysqli_affected_rows($link)
         *  mysqli_stmt_affected_rows().
         *  Asimismo, si la consulta produce un conjunto de resultados se usa la 
         *  función mysqli_stmt_fetch().
         */
                  
    }#End registrar
    
    public function listarByIdApiKey($email,$pass) {
         $arData[] = array();
         
       
            $sql= "SELECT * FROM tb_usuario WHERE(usu_mail = ? AND usu_pass = ?)";  

            $stmt = mysqli_prepare($this->link, $sql);

            mysqli_stmt_bind_param($stmt,"ss",$email,$pass);
            $rpta = mysqli_stmt_execute($stmt);
            
            if ($rpta) {
                
                 mysqli_stmt_bind_result($stmt, $mail,$pwd,$nom);            
                 while (mysqli_stmt_fetch($stmt)) {
                 $arData = array('email'=>$mail,'pass'=>$pwd,'nombre'=>$nom); 
                 return $arData;         }                 
            }else{                                
                switch (mysqli_errno($this->link)) {      
                     default:
                        $arData['error_cod']=12.1;
                        $arData['message']='Error SQL - Desconocido';
                        $arData['info']=mysqli_error($this->link);  
                        return $arData;
                     break;
                 }
            }
  
            mysqli_close($this->link);
 
    } #End Listar_By_ID-API

    
}

?>
