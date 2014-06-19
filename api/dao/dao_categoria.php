<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

class categoria{
    
    
        function __construct() {
        
        require_once '../db../db_conexion.php';
        require_once '../sos../sos_helper.php';
              
        $this->dbc = new conexion(); //General connection      
    }
    
        public function listarCategoriaByID($categoryID) {
        $aData = array();
        $conexion = $this->dbc->getConexion();
        
        if (!is_array($conexion)) {
                $query= " SELECT * FROM tb_categoria WHERE cat_id = '$categoryID' ORDER BY cat_id DESC";
                $result = $conexion->query($query);

                $c = 0;
                while ($row = $result->fetch_assoc()){
                    $c++;
                    $aData["category".$c]["categoryID"]=$row['cat_id'];
                    $aData["category".$c]["name"]  =$row['cat_nom'];                                      
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
