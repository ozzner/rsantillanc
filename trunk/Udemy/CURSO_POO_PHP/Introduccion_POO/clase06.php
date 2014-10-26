<?php
/**
 * @author Renzo Santillan <rsantillanc@gmail.com>
 * @name Crear una funcion destruc para los objetos de nuestra clase
 */

class Gatos {
    
    var $nombre;
    var $colorPelo;
    var $corbata = "Si";   

    
    function __construct($nombre, $colorPelo) {
        $this->nombre = $nombre;
        $this->colorPelo = $colorPelo;
    }

    public function __destruct() {
       print $this->nombre." dice: Adiós mundo cruel."."<br>";
    }

    function saludo(){
		print "Hola, soy ".$this->nombre." y tengo el pelo color ".$this->colorPelo."<br>";	
	}
	
	function maullar(){
		print "miau miau<br>";	
	}
	
	function tieneCorbata(){
		return $this->nombre." ".$this->corbata." tiene corbata y el color de pelo es ".$this->colorPelo."<br>";
	}
}


//Instanciamos objetos
$cucho = new Gatos("Cucho","rosa");
$benito = new Gatos("Benito Bodoque","azul");
$espanto = new Gatos("Espanto","verde");

$cucho->saludo();
$benito->saludo();
$espanto->saludo();

unset($cucho); /* Forma para eliminar una variable o un objeto*/
unset($espanto);
unset($benito);

?>
