<?php
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");


//set_exception_handler('not_catched_exceptions');

//Obtenemos las variables globales
$opcionSeleccionada=$_GET['departamentoajax'];
$require=$_GET['dirdesarray'];
$indice=$_GET['arrayid'];
/*OBTENCION DE Ciudades*/
if($require==0)
{
	$List = new connlist;
	bizcve::getciudades($List, $opcionSeleccionada);  
	$List->gofirst();
	$imprime= '<select name="ciudadajax" class="TextoNormal" onChange ="barrio(this.value);" >';
	$imprime=$imprime.'<option value="">Seleccion Ciudad</option>';   
	if (!$List->isvoid()){
		do {
			 $contador=strlen($List->getelem()->id_region);
			 $contador=3-$contador;
			 $adicioncadena=str_repeat("0", $contador);
			 $List->getelem()->id_region=''.$adicioncadena.''.$List->getelem()->id_region;
			 $contador='';
			 $contador=strlen($List->getelem()->id_ciudad);
			 $contador=3-$contador;
			 $adicioncadena=str_repeat("0", $contador);
			 $List->getelem()->id_ciudad=''.$adicioncadena.''.$List->getelem()->id_ciudad; 
			 
             $imprime=$imprime.'<option value="'.$List->getelem()->id_region.''.$List->getelem()->id_ciudad.'"{selected}>'.$List->getelem()->nomciudad.'</option>'; 
             				
		} while ($List->gonext());
                file_put_contents('imprime1.txt', $imprime);
		echo $imprime.'</select>';
	}
	else{echo $imprime.'</select>';}
}
else
{
	$List = new connlist;
	bizcve::getciudades($List, $opcionSeleccionada);  
	$List->gofirst();
//        Mantis XXXX INICIO
//        se agrega id="id_ciudad_direccion_despacho_'.$indice.'"
	$imprime= '<select id="id_ciudad_direccion_despacho_'.$indice.'" name="ciudadarray_'.$indice.'" class="TextoNormal" onChange ="barrioarray(this.value,'.$arrayid.');" >';
//        Mantis XXXX FIN
	$imprime=$imprime.'<option value="">Seleccion Ciudad</option>';   
	if (!$List->isvoid()){
		do {	
			 $contador=strlen($List->getelem()->id_region);
			 $contador=3-$contador;
			 $adicioncadena=str_repeat("0", $contador);
			 $List->getelem()->id_region=''.$adicioncadena.''.$List->getelem()->id_region;
			 $contador='';
			 $contador=strlen($List->getelem()->id_ciudad);
			 $contador=3-$contador;
			 $adicioncadena=str_repeat("0", $contador);
			 $List->getelem()->id_ciudad=''.$adicioncadena.''.$List->getelem()->id_ciudad; 			
             $imprime=$imprime.'<option value="'.$List->getelem()->id_region.''.$List->getelem()->id_ciudad.'"{selected}>'.$List->getelem()->nomciudad.'</option>';  				
		} while ($List->gonext());
                //        Mantis XXXX INICIO
		$imprime=$imprime.'</select>';
		$imprime=$imprime.'<br>';
		$imprime=$imprime.'<span id="error_ciudad_despacho_'.$indice.'" style="color: red;font-size: 10px; font-weight: bold;font-style:initial"></span>|'.$indice;
                
                //        Mantis XXXX FIN
		echo $imprime;
	}
	else{$imprime=$imprime.'</select>|'.$indice;
		echo $imprime;}

}
?>
