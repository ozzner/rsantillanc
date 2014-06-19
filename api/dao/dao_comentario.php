<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);


class comentario {
    
    private $dbc,$time;
    
    function __construct() {
        
        require_once '../db../db_conexion.php';
        require_once '../sos../sos_helper.php';
              
        $this->dbc = new conexion(); //General connection      
    }
    
    public function registrarComentario($mensaje,$fecha,$userID,$estID) {
        $aux = new funciones();  
        $this->time = $aux->genDataTime();
        $conexion = $this->dbc->getConexion();
        
            $sql= "INSERT INTO tb_comentario (com_sms,com_fec,usu_id,est_id)
                   VALUES(?,?,?,?)";  

             $stmt = mysqli_prepare($conexion, $sql);             
             mysqli_stmt_bind_param($stmt,"ssii",$mensaje,$fecha,$userID,$estID);
             $res = mysqli_stmt_execute($stmt);  //True - False
             
             if ($res) {
                   return "ok!";
             }  else{               
                 switch (mysqli_errno($conexion)) {
                     default:
                        $arData['error_cod']=13.1;
                        $arData['message']='Error de conexion';
                        $arData['info']=mysqli_error($conexion);  
                        return $arData;
                     break;
                 }
             }
             
             mysqli_stmt_close();
             mysqli_close($conexion);                     
                  
    }#End registrar
    
    
    public function listarUsuarioById($email,$pass) {
//        $aData = array();
//        $conexion = $this->dbc->getConexion();
//        $aux = new funciones(); 
//        
//        if (!is_array($conexion)) {
//                $passHash = $aux->setHash($pass);
//                $query= " SELECT * FROM db_apprade.tb_usuario u
//                INNER JOIN tb_ranking r ON u.ran_id=r.ran_id
//                WHERE(usu_mail = '$email' AND usu_pass = '$passHash')";
//
//                $result = $conexion->query($query);
//
//                $c = 0;
//                while ($row = $result->fetch_assoc()){
//                    $c++;
//                    $aData[] = array('User'.$c=>$row); }
//                    
//                $conexion->close();
//                
//                if ($aData == NULL)  
//                    return $aData;
//                else
//                    return $aData;
//               
//        }else            
//            return $conexion;
            
    } #End Listar_By_ID

    
}

?>
