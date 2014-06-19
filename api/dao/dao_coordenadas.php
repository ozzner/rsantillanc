<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

class coordenadas{
        
        function __construct() {
        
        require_once '../db../db_conexion.php';
        require_once '../sos../sos_helper.php';
              
        $this->dbc = new conexion(); //General connection      
    }
    
        public function listarcoordendasByID($coordenadaID) {
        $aData = array();
        $conexion = $this->dbc->getConexion();
        
        if (!is_array($conexion)) {
                $query= " SELECT * FROM tb_coordenadas WHERE coo_id = '$coordenadaID' ORDER BY coo_id DESC";
                $result = $conexion->query($query);

                $c = 0;
                while ($row = $result->fetch_assoc()){
                    $c++;
                    $aData["coordinates".$c]["coordinatesID"]=$row['coo_id'];
                    $aData["coordinates".$c]["latitude"]     =$row['coo_lat'];                                    
                    $aData["coordinates".$c]["longitude"]    =$row['coo_lon'];   
                    $aData["coordinates".$c]["reference"]    =$row['coo_ref']; 
                }                                    
                    $conexion->close();
                    
                if ($aData == NULL)  
                    return $aData;
                else
                    return $aData;               
        }else            
            return $conexion;
            
    } #End Listar_By_ID
}

?>
