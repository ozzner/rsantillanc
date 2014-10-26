<?php
/**
 * @author Renzo Santillan <rsantillanc@gmail.com>
 * @name Fundamentos, modificadores de acceso (public, private, protected)
 */
header('Content-Type: text/html; charset=UTF-8');

class Gatos {
    /* Protected = Accedida desde la misma clase y subclases.
     * Privada = Solamente desde la clase.
     * Public = Desde cualquier lugar.
     */
    protected $nombre;
    private  $colorPelo;
    private $corbata = "Si";   

    
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

class GatosVoladores extends Gatos{ /*Hereda de Gatos*/
    function nombre(){
       print "El nombre del gato volador es: ".$this->nombre."<br>";
    }
}


$cucho =  new Gatos("Cuchos", "pelo negro");
$benito = new GatosVoladores("Benito", "tengo pelo amarillo");

$benito->nombre();


//unset($benito);
//unset($cucho);
//echo 'El pariente de la clase GatosVoladores es_'.  get_parent_class("GatosVoladores")."<br>";
//echo 'El pariente de la clase Gatos es_'.  get_parent_class("Gatos")."<br>";


?>
