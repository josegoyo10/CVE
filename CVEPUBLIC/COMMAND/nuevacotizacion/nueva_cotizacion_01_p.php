<?php
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////


/*DATOS DESDE AJAX BARRIOS*/


$selectDestino=$_GET['select']; $opcionSeleccionada=$_GET['opcion'];

/*OBTENCION DE BARRIOS*/
	$ListCo = new connlist;
	bizcve::getcomuna($ListCo, $opcionSeleccionada);  
	$ListCo->gofirst();
	echo "<select name='".$selectDestino."' id='".$selectDestino."' onChange = optenervalue(this.value);>";
	echo "<option value='0'>Seleccion Barrio</option>";   
	if (!$ListCo->isvoid()){
		do {
			
             echo "<option value='".$ListCo->getelem()->id_comuna."'{selected}>".$ListCo->getelem()->nomcomuna."</option>"; 
             				
		} while ($ListCo->gonext());
		echo "</select>";
	}

/*FIN ONTENCION DE  BARRIOS*/
/*FIN DE OBTENCION DE DATOS AJAX*/


	
?>