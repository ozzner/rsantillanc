<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

class ranking{
    
    
        function __construct() {
        
        require_once '../db../db_conexion.php';
        require_once '../sos../sos_helper.php';
              
        $this->dbc = new conexion(); //General connection      
    }
    
        public function listarRankingByID($rankingID) {
        $aData = array();
        $conexion = $this->dbc->getConexion();
        
        if (!is_array($conexion)) {
                $query= " SELECT * FROM tb_ranking WHERE ran_id = '$rankingID' ORDER BY ran_id DESC";
                $result = $conexion->query($query);

                $c = 0;
                while ($row = $result->fetch_assoc()){
                    $c++;
                    $aData["ranking".$c]["rankingID"]=$row['ran_id'];
                    $aData["ranking".$c]["name"]  =$row['ran_nom'];                                      
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