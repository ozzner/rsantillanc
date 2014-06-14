<?php
class funciones {
    
    Private static $inicio = '$r.d.s.';
    Private static $final = '$j.m.n.';
    
    
    public function setHash($pass) {
    
        $codificado = base64_decode($pass);
        return sha1(self::$inicio."$codificado".self::$final);
    }
    
    public function generateApiKey() {
        return md5(uniqid(rand(), true));
    }
    

    
}

?>
