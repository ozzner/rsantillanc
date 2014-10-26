<?php

class Gatos {
	var $nombre;
	var $colorPelo;
	var $corbata="Si";
	
	function __construct($n="",$p="negro"){
		$this->nombre = $n;
		$this->colorPelo = $p;
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

?>