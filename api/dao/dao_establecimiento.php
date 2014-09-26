<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

class establecimiento {

    function __construct() {

        require_once '/home/appradec/public_html/api/db/db_conexion.php';
        require_once '/home/appradec/public_html/api/sos/sos_helper.php';
//        require_once '../db../db_conexion.php';
//        require_once '../sos../sos_helper.php';             
        $this->dbc = new conexion(); //General connection      
    }

    public function listarEstablecimientoALL() {
        $aData = array();
        $conexion = $this->dbc->getConexion();

        if (!is_array($conexion)) {
            $query = "select  * from (SELECT 	 e.est_id
						,e.est_dir
						,e.est_nom
						,e.dis_id
						,e.cat_id
						,c.cat_nom
						,d.dis_nom
						,d.dis_cod
						,co.coo_id
						,co.coo_lat
						,co.coo_lon
						,co.coo_ref
						,ifnull(cc.cal_cola,'No hay cola') as 'cal_cola'
						,ifnull(cc.cal_create_at,now()) as 'cal_create_at'
					  FROM tb_calificacion cc
					  RIGHT JOIN  tb_establecimiento e ON  cc.est_id = e.est_id 
					  INNER JOIN tb_categoria c ON e.cat_id=c.cat_id
					  INNER JOIN tb_distrito d ON e.dis_id=d.dis_id
					  INNER JOIN tb_coordenadas co ON e.coo_id=co.coo_id 
				order by (cc.cal_create_at) desc ) as tabla
			group by(est_id)
";

            $result = $conexion->query($query);


            if ($result) {
                $c = 0;
                while ($row = $result->fetch_assoc()) {
                    $c++;
                    $aData["establishment" . $c]["establishmentID"] = $row['est_id'];
                    $aData["establishment" . $c]["address"] = utf8_encode($row['est_dir']);
                    $aData["establishment" . $c]["name"] = utf8_decode($row['est_nom']);
                    $aData["establishment" . $c]["ruc"] = $row['est_ruc'];
                    $aData["establishment" . $c]["category"]["categoryID"] = $row['cat_id'];
                    $aData["establishment" . $c]["category"]["name"] = utf8_encode($row['cat_nom']);
                    $aData["establishment" . $c]["district"]["districtID"] = $row['dis_id'];
                    $aData["establishment" . $c]["district"]["name"] = utf8_encode($row['dis_nom']);
                    $aData["establishment" . $c]["district"]["zipcode"] = utf8_encode($row['dis_cod']);
                    $aData["establishment" . $c]["coordinates"]["coordinatesID"] = $row['coo_id'];
                    $aData["establishment" . $c]["coordinates"]["latitude"] = $row['coo_lat'];
                    $aData["establishment" . $c]["coordinates"]["longitude"] = $row['coo_lon'];
                    $aData["establishment" . $c]["coordinates"]["reference"] = utf8_encode($row['coo_ref']);
                    $aData["establishment" . $c]["rating"]["cal_create_at"] = utf8_decode($row['cal_create_at']);
                    $aData["establishment" . $c]["rating"]["cal_cola"] = utf8_decode($row['cal_cola']);
                }
                $conexion->close();

                if ($aData == NULL) {
                    return $aData = array(
                        "error_cod" => 14.1,
                        "message" => "Error de consulta",
                        "info" => "Error con el parámetro ingresado");
                } else {
                    return $aData;
                }
            } else {
                return $aData = array(
                    "error_cod" => 14.2,
                    "message" => "Error desconocido",
                    "info" => "Error con el servicio.");
            }
        } else {
            return $conexion;
        }
    }

#End Listar_ALL

    }
?>
