
<?php
//header("Content-Type: application/json; charset=utf-8");
class funciones {
    
    Private static $inicio = '$r.d.s.';
    Private static $final = '$j.m.n.';
    
    #SET
    static function setHash($pass) {    
        $base64 = base64_encode($pass);
        return sha1(self::$inicio.$base64.self::$final);
    }
      function setJsonResponse($array,$httpCode,$status) {
        
        $arrJson = array();       
        $arrJson['httpCode']=$httpCode;
        $arrJson['error_status']=$status;
        $arrJson['data']=$array;

        echo json_encode($arrJson);
    }
    
    #GEN
    public function genApiKey() {
        return md5(uniqid(rand(), true));
    }
    
    public function genDataTime($format) {        
        date_default_timezone_set('America/Bogota');
        $time = new DateTime();
        $date= $time->format($format);
        
        return $date;
    }
    
    #CHK
    public function chkParmeters($array) {  
        $arrJson = array();

        foreach ($array as $clave=>$valor) {
            if($valor==NULL || empty($valor)){
              $error = TRUE;
              $campos .= $clave .", ";
            }
         }
         
         if ($error) {
              $arrJson['error_cod']   = 10;
              $arrJson['message'] = "Campo(s) requeridos!";
              $arrJson['info']  = substr($campos, 0, strlen($campos)-2);
              return $arrJson;
         }else{
             return 'ok';
         }
    }

    
}//End Class

?>
