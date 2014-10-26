<?php

class Gatos {
	function maullar(){
		print "miau miau<br>";	
	}
}

//Instanciamos objetos
$cucho = new Gatos();
$benito = new Gatos();
$espanto = new Gatos();

//detecta la clase del objeto
print "Espanto pertenece a la clase ".get_class($espanto)."<br>";

//Verifica que un objeto pertenezca a una clase
if(is_a($matute, "Gatos")){
	print "Si pertenece a la clase Gatos<br>";
} else {
	print "NO es un gato<br>";
}

//Llamamos a los metodos
print "Cucho dice: ";
$cucho->maullar();
print "Espanto dice: ";
$espanto->maullar();
?>