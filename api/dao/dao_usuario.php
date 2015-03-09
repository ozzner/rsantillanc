<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

class usuario {

    private $dbc, $uid, $time, $passHash;

    function __construct() {
//        include_once dirname(__FILE__) . './Config.php';

        require_once '/home/appradec/public_html/api/db/db_conexion.php';
        require_once '/home/appradec/public_html/api/sos/sos_helper.php';

//         include_once '../db../db_conexion.php';
//        include_once '../sos../sos_helper.php';             
        $this->dbc = new conexion(); //General connection      
    }

    public function registrarUsuario($mail, $sex, $nom, $feh, $app, $apm, $pass) {
        $aux = new funciones();
        $this->time = $aux->genDataTime('Y.m.d H:i:s');
        $this->uid = $aux->genApiKey();
        $this->passHash = $aux->setHash($pass);

        $conexion = $this->dbc->getConexion();

        $sql = "INSERT INTO tb_usuario 
               (usu_mail,usu_sex,usu_nom,usu_fec_nac,usu_rate,ran_id,usu_uid,usu_fec_ing,usu_pass)
               VALUES(?,?,?,?,?,?,?,?,?)";

        $rate = 0;
        $ranid = 1;

        $stmt = mysqli_prepare($conexion, $sql);

        mysqli_stmt_bind_param($stmt, "ssssiisss", $mail, $sex, $nom, $feh, $rate, $ranid, $this->uid, $this->time, $this->passHash);
        $res = mysqli_stmt_execute($stmt);  //True - False

        if ($res) {
            return "ok!";
            $uid = mysql_insert_id(); // last inserted id

            $query = "SELECT * FROM tb_usuario
                WHERE(usu_id = '$uid')";

            $result = $conexion->query($query);
            
        } else {
            switch (mysqli_errno($conexion)) {/* SQL - ERRORS */
                case 1062:
                    $arData['error_cod'] = 11.1;
                    $arData['message'] = 'Entrada duplicada';
                    $arData['info'] = 'El correo: ' . $mail . " ya fue registrado!";
                    return $arData;
                    break;

                case 1022:
                    $arData['error_cod'] = 11.2;
                    $arData['message'] = 'No puede escribir';
                    $arData['info'] = mysqli_error($conexion);
                    return $arData;
                    break;
                default:
                    $arData['error_cod'] = 11.3;
                    $arData['message'] = 'Error de conexion';
                    $arData['info'] = mysqli_error($conexion);
                    return $arData;
                    break;
            }
        }

        mysqli_stmt_close();
        mysqli_close($conexion);
    }

#End registrar

    public function login($email, $pass, $controller) {
        $aData = array();
        $conexion = $this->dbc->getConexion();
        $aux = new funciones();

        if (!is_array($conexion)) {
            $passHash = $aux->setHash($pass);


            if ($controller == 1) {

                $query = "SELECT * FROM tb_usuario u
                   INNER JOIN tb_ranking r ON u.ran_id=r.ran_id
                   WHERE(usu_mail = '$email' AND usu_pass = '$passHash')";
            } else {

                $query = "SELECT * FROM tb_usuario u
                   INNER JOIN tb_ranking r ON u.ran_id=r.ran_id
                   WHERE(usu_mail = '$email')";
            }



            $result = $conexion->query($query);

            if ($result) {
                $c = 0;
                while ($row = $result->fetch_assoc()) {
                    $c++;

                    $aData["user" . $c]["userID"] = $row['usu_id'];
                    $aData["user" . $c]["email"] = utf8_encode($row['usu_mail']);
                    $aData["user" . $c]["sex"] = $row['usu_sex'];
                    $aData["user" . $c]["name"] = utf8_encode($row['usu_nom']);
                    $aData["user" . $c]["date_birth"] = $row['usu_fec_nac'];
                    $aData["user" . $c]["last_name1"] = utf8_encode($row['usu_ap1']);
                    $aData["user" . $c]["last_name2"] = utf8_encode($row['usu_ap2']);
                    $aData["user" . $c]["rate"] = $row['usu_rate'];
                    $aData["user" . $c]["Api_key"] = $row['usu_uid'];
                    $aData["user" . $c]["date_at"] = $row['usu_fec_ing'];
                    $aData["user" . $c]["ranking"]["rankingID"] = $row['ran_id'];
                    $aData["user" . $c]["ranking"]["name"] = utf8_encode($row['ran_nom']);
                }
                $conexion->close();

                if ($aData == NULL){
                     return $aData = array(
                        "error_cod" => 16.1,
                        "message" => "Acceso denegado",
                        "info" => "Verifique sus credenciales");
                }                  
                else{
                    return $aData;
                }
                    
            } else{
                return $aData = array(
                    "error_cod" => 16.2,
                    "message" => "Error desconocido",
                    "info" => "Error con el servicio.");
            }
                
        } else
            return $conexion;
    }

#End Login
}

?>
