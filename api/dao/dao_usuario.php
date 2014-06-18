<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

class usuario {
    
    private $dbc,$uid,$time,$passHash;
    
    function __construct() {
        
        require_once '../db../db_conexion.php';
        require_once '../sos../sos_helper.php';
              
        $this->dbc = new conexion();       
    }
    
    public function registrar($mail,$sex,$nom,$feh,$app,$apm,$pass) {
        $aux = new funciones();  
        $this->time = $aux->genDataTime();
        $this->uid = $aux->genApiKey();
        $this->passHash= $aux->setHash($pass);
        $conexion = $this->dbc->getConexion();
        
            $sql= "INSERT INTO tb_usuario 
               (usu_mail,usu_sex,usu_nom,usu_fec_nac,usu_ap1,usu_ap2,usu_rate,ran_id,usu_uid,usu_fec_ing,usu_pass)
               VALUES(?,?,?,?,?,?,?,?,?,?,?)";  

             $rate = 0;
             $ranid= 1;

             $stmt = mysqli_prepare($conexion, $sql);
          
             mysqli_stmt_bind_param($stmt,"ssssssiisss",
             $mail,$sex,$nom,$feh,$app,$apm,$rate,$ranid,$this->uid,$this->time,$this->passHash);
             $res = mysqli_stmt_execute($stmt);  //True - False
             
             if ($res) {
                   return "ok!";
             }  else{               
                 switch (mysqli_errno($conexion)) {
                     case 1062:
                        $arData['error_cod']=11.1;
                        $arData['message']='Error SQL - Entrada duplicada';
                        $arData['info']= 'El correo: '.$mail. " ya fue registrado!";
                        return $arData;
                     break;

                     case 1022:
                        $arData['error_cod']=11.2;
                        $arData['message']='Error SQL - No puede escribir';
                        $arData['info']=mysqli_error($conexion);  
                        return $arData;
                     break;
                     default:
                        $arData['error_cod']=11.3;
                        $arData['message']='Error SQL - Desconocido';
                        $arData['info']=mysqli_error($conexion);  
                        return $arData;
                     break;
                 }
             }
             
             mysqli_stmt_close();
             mysqli_close($conexion);                     
 
                  
    }#End registrar
    
    public function listarByIdApiKey($email,$pass) {
       
        $conexion = $this->dbc->getConexion();
        
        if (!is_array($conexion)) {
            
                $query= " SELECT * FROM db_apprade.tb_usuario u
                INNER JOIN tb_ranking r ON u.ran_id=r.ran_id
                WHERE(usu_mail = '$email' AND usu_pass = '$pass')";

                $result = $conexion->query($query);

                $c = 0;
                while ($row = $result->fetch_assoc()){
                    $c++;
                    $aData[] = array('User'.$c=>$row); }
                    
                $conexion->close();

                if ($aData == NULL)                                        
                    return NULL;
                else
                    return $aData;
               
        }else            
            return $conexion;
            

 
    } #End Listar_By_ID-API

    
}

?>
