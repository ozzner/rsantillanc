<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

class establecimiento{
        
        function __construct() {
        
        require_once '../db../db_conexion.php';
        require_once '../sos../sos_helper.php';
              
        $this->dbc = new conexion(); //General connection      
    }
    
        public function listarEstablecimientoALL() {
        $aData = array();
        $conexion = $this->dbc->getConexion();
        
        if (!is_array($conexion)) {
                $query= " SELECT * FROM tb_establecimiento ORDER BY est_nom ASC";
                $result = $conexion->query($query);

                $c = 0;
                while ($row = $result->fetch_assoc()){
                    $c++;
                    $aData["establishment".$c]["establishmentID"]=$row['est_id'];
                    $aData["establishment".$c]["address"]        =$row['est_nom'];                                    
                    $aData["establishment".$c]["name"]           =$row['est_name'];  
                    $aData["establishment".$c]["ruc"]            =$row['est_ruc'];
                    $aData["establishment".$c]["categoryID"]     =$row['cat_id'];                                    
                    $aData["establishment".$c]["districtID"]     =$row['dis_id']; 
                    $aData["establishment".$c]["coordinatesID"]  =$row['coo_id']; 
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
