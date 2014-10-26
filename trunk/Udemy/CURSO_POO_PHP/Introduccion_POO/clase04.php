<?php

class Gatos {
	var $nombre;
	var $colorPelo;
	var $corbata="Si";
	
	function maullar(){
		print "miau miau<br>";	
	}
	
	function tieneCorbata(){
		return $this->nombre." ".$this->corbata." tiene corbata y el color de pelo es ".$this->colorPelo."<br>";
	}
}

//Instanciamos objetos
$cucho = new Gatos();
$benito = new Gatos();
$espanto = new Gatos();

$cucho->nombre = "Cucho";
$benito->nombre = "Benito";
$espanto->nombre = "Espanto";

$cucho->colorPelo = "rosa";
$benito->colorPelo = "azul";
$espanto->colorPelo = "verde";

$cucho->corbata = "NO";
print $cucho->tieneCorbata();
print $espanto->tieneCorbata();

?>