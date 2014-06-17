<?php
class funciones {
    
    Private static $inicio = '$r.d.s.';
    Private static $final = '$j.m.n.';
    
    
    public function setHash($pass) {    
        $codificado = base64_decode($pass);
        return sha1(self::$inicio.$codificado.self::$final);
    }
    
    public function genApiKey() {
        return md5(uniqid(rand(), true));
    }
    
    public function chkParmeters($array) {  
        $arrJson = array();

        foreach ($array as $clave=>$valor) {
            if($valor==NULL || empty($valor)){
              $error = TRUE;
              $campos .= $clave .", ";
            }
         }
         if ($error) {
              $arrJson['error']   = 1;
              $arrJson['message'] = "Campo(s) requeridos!";
              $arrJson['values']  = substr($campos, 0, strlen($campos)-2);
              return $arrJson;
         }else{
             return 'ok';
         }
    }
    
  function setJsonResponse($array,$httpCode,$status) {
        header('Content-Type: application/json'); 
        $arrJson = array();

        $arrJson['httpCode']=$httpCode;
        $arrJson['error_status']=$status;
        $arrJson['data']=$array;
        
        echo (json_encode($arrJson));

    }
    
}

?>
