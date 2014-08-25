<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);


class comentario {
    
    private $dbc,$time;
    
    function __construct() {
        
        require_once '../db../db_conexion.php';
        require_once '../sos../sos_helper.php';
              
        $this->dbc = new conexion(); //General connection      
    }
    
    public function insertarComentario($mensaje,$userID,$estID) {
        $aux = new funciones();  
        $this->time = $aux->genDataTime('Y.m.d H:i:s');
        $conexion = $this->dbc->getConexion();
        
            $sql= "INSERT INTO tb_comentario (com_sms,com_fec,usu_id,est_id)
                   VALUES(?,?,?,?)";  

             $stmt = mysqli_prepare($conexion, $sql);             
             mysqli_stmt_bind_param($stmt,"ssii",$mensaje,$this->time,$userID,$estID);
             $res = mysqli_stmt_execute($stmt);  //True - False
             
             if ($res) {
                   return "ok!";
             }  else{               
                 switch (mysqli_errno($conexion)) {
                     case 1452:
                        $arData['error_cod']=13.1;
                        $arData['message']='No se pudo enviar';
                        $arData['info']='Hay problemas con el usuario o el establecimiento';  
                        return $arData;
                         break;
                     default:
                        $arData['error_cod']=13.2;
                        $arData['message']='Error de conexion';
                        $arData['info']=mysqli_error($conexion);  
                        return $arData;
                     break;
                 }
             }
             
             mysqli_stmt_close();
             mysqli_close($conexion);                     
                  
    }#End registrar
    
    public function listarComentariosByID($establecimientoID) {
        $aData = array();
        $conexion = $this->dbc->getConexion();
        
        if (!is_array($conexion)) {
              $query = "SELECT com_id,com_fec,com_sms,usu_mail,usu_nom,est_nom
                        FROM db_apprade.tb_comentario e
                        INNER JOIN tb_usuario u
                        ON e.usu_id=u.usu_id
                        INNER JOIN tb_establecimiento s 
                        ON e.est_id=s.est_id
                        WHERE  e.est_id='$establecimientoID' ORDER BY com_fec DESC";
              
                $result = $conexion->query($query);
                
                if ($result) {
                    $c = 0;
                    while ($row = $result->fetch_assoc()){
                        $c++;
                        $aData["comment".$c]["commentID"]=$row['com_id'];
                        $aData["comment".$c]["message"]  =$row['com_sms'];
                        $aData["comment".$c]["date_at"]  =$row['com_fec'];
                        $aData["comment".$c]["user"]["name"]    =$row['usu_nom'];
                        $aData["comment".$c]["user"]["usu_mail"]=$row['usu_mail']; 
                        $aData["comment".$c]["establishment"]["name"] =$row['est_nom'];                      
                    }                    
                        $conexion->close();

                    if ($aData == NULL)  
                        return $aData = array(
                        "error_cod"=>15.1,
                        "message"=>"Error de consulta",
                        "info"=>"Error con el parámetro ingresado") ;
                    else
                        return $aData; 
                }else
                    return $aData = array(
                        "error_cod"=>15.2,
                        "message"=>"Error desconocido",
                        "info"=>"Error con el servicio.") ;
                              
        }else            
            return $conexion;
            
    } #End Listar_By_ID

    
}

?>
