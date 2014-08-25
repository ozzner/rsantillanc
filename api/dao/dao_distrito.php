<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

class distrito{
        
        function __construct() {
        
        require_once '../db../db_conexion.php';
        require_once '../sos../sos_helper.php';
              
        $this->dbc = new conexion(); //General connection      
    }
    
        public function listarDistritoByID($distritoID) {
        $aData = array();
        $conexion = $this->dbc->getConexion();
        
        if (!is_array($conexion)) {
                $query= " SELECT * FROM tb_distrito WHERE dis_id = '$distritoID' ORDER BY dis_id DESC";
                $result = $conexion->query($query);

                $c = 0;
                while ($row = $result->fetch_assoc()){
                    $c++;
                    $aData["district".$c]["districtID"]=$row['dis_id'];
                    $aData["district".$c]["name"]      = utf8_encode ($row['dis_nom']);                                    
                    $aData["district".$c]["zipcode"]   =$row['dis_cod'];   
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
