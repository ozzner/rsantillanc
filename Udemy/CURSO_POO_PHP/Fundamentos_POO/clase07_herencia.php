<?php
/**
 * @author Renzo Santillan <rsantillanc@gmail.com>
 * @name Fundamentos php, herencia de clases.
 */
header('Content-Type: text/html; charset=UTF-8');

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

class GatosVoladores extends Gatos{ /*Hereda de Gatos*/
    
}


$cucho =  new Gatos("Cuchos", "pelo negro");
$benito = new GatosVoladores("Benito", "tengo pelo amarillo");

unset($benito);
unset($cucho);

echo 'El pariente de la clase GatosVoladores es_'.  get_parent_class("GatosVoladores")."<br>";
echo 'El pariente de la clase Gatos es_'.  get_parent_class("Gatos")."<br>";

print "<br>";
print is_subclass_of("Gatos", "GatosVoladores")?"Si":"No";
print "<br>";
print is_subclass_of("GatosVoladores", "Gatos")?"Si":"No";
?>
