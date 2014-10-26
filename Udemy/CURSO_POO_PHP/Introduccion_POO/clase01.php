<?php

class Gatos {
	
	
	
}

/*$clases = get_declared_classes();
foreach($clases as $clase){
	print $clase."<br>";
}*/

if(class_exists("FelinusVulgaris")){
	print "Si existe la clase<br>";
} else {
	print "No existe la clase<br>";
}

?>