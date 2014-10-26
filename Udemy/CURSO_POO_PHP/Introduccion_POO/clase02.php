<?php

class Gatos {
	function maullar(){
		print "El gato dice miau miau<br>";	
	}
}

$metodos = get_class_methods("Gatos");
foreach($metodos as $metodo){
	print $metodo."<br>";
}

if(method_exists("Gatos","volar")){
	print "El metodo si existe<br>";
} else {
	print "El metodo NO existe<br>";
}

?>