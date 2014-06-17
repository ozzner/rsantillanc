<?php
class funciones {
    
    Private static $inicio = '$r.d.s.';
    Private static $final = '$j.m.n.';
    
    
    public function setHash($pass) {    
        $codificado = base64_decode($pass);
        return sha1(self::$inicio."$codificado".self::$final);
    }
    
    public function genApiKey() {
        return md5(uniqid(rand(), true));
    }
    
    public function chkParmeters($array) {  
        $arrJson = array();
        foreach ($array as $value) {
            if(isset($value)){
              $error = TRUE;
              $campos .= $value .", ";
            }
         }
         if ($error) {
              $arrJson['error']   = TRUE;
              $arrJson['message'] = "Campo(s) requeridos!";
              $arrJson['campos'] = $campos;
              jsonMessage($arrJson,404);
         }
    }
    
    public function jsonMessage($array,$httpCode) {
        header('Content-Type: application/json'); 
        $arrJson = array();
        
        $arrJson['httpCode']=$httpCode;
        $arrJson['data']=$arrJson;
        
        echo (json_encode($arrJson));

    }
    
}

?>
