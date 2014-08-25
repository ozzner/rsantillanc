<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);


class calificacion {
    
    private $dbc,$fecha,$hora;
    
    function __construct() {
        
        require_once '../db../db_conexion.php';
        require_once '../sos../sos_helper.php';
              
        $this->dbc = new conexion(); //General connection      
    }
    
    public function insertarCalificacion($userID,$estID,$cola) {
        $aux = new funciones();  
        $this->fecha = $aux->genDataTime('Y.m.d');
        $this->hora = $aux->genDataTime('H:i');
        $conexion = $this->dbc->getConexion();
        
            $sql= "INSERT INTO tb_calificacion (usu_id,est_id,cal_cola,cal_hor,cal_fec)
                   VALUES(?,?,?,?,?)";  

             $stmt = mysqli_prepare($conexion, $sql);             
             mysqli_stmt_bind_param($stmt,"iisss",$userID,$estID,$cola,$this->hora,$this->fecha);
             $res = mysqli_stmt_execute($stmt);  //True - False
             
             if ($res) {
                   return "ok!";
             }  else{               
                 switch (mysqli_errno($conexion)) {
                     case 1452:
                        $arData['error_cod']=14.1;
                        $arData['message']='No se pudo calificar';
                        $arData['info']='Hay problemas con el usuario o establecimiento';  
                        return $arData;
                         break;
                     case 1062:
                        $arData['error_cod']=14.2;
                        $arData['message']='Entrada duplicada';
                        $arData['info']= 'Debe esperar que cambie la cola';
                        return $arData;
                     break;
                     default:
                        $arData['error_cod']=14.3;
                        $arData['message']='Error de conexion';
                        $arData['info']=mysqli_error($conexion);  
                        return $arData;
                     break;
                 }
             }
             
             mysqli_stmt_close();
             mysqli_close($conexion);                     
                  
    }#End Insertar
    
    public function listarCalificacionByUserID($userID) {
        $aData = array();
        $conexion = $this->dbc->getConexion();
        
        if (!is_array($conexion)) {
                $query= " SELECT * FROM tb_calificacion WHERE usu_id = '$userID' ORDER BY cal_fec DESC";
                $result = $conexion->query($query);

                $c = 0;
                while ($row = $result->fetch_assoc()){
                    $c++;
                    $aData["rating".$c]["userID"]   =$row['usu_id'];
                    $aData["rating".$c]["estaID"]   =$row['est_id'];
                    $aData["rating".$c]["queue"]    =utf8_encode($row['cal_cola']);
                    $aData["rating".$c]["date_at"]  =$row['cal_fec'];
                    $aData["rating".$c]["hour_at"]  =$row['cal_hor'];
                 }                                    
                    $conexion->close();
                    
                if ($aData == NULL)  
                    return $aData;
                else
                    return $aData;               
        }else            
            return $conexion;
            
    } #End Listar UserID

    
}

?>
