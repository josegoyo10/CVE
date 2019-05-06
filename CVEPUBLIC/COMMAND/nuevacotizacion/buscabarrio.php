<?php
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

$opcionSeleccionada=$_GET['departamentoajax'];
$ciudad=$_GET['buscabarrioajax'];
$indice=$_GET['arrayid'];
$require=$_GET['dirdesarray'];
$province=substr($ciudad, 0, 3);
$ciudad=substr($ciudad, 3, 3);
if($require==0)
{
	$List = new connlist;
	bizcve::getbarrios($List, $opcionSeleccionada,$ciudad,$province);  
	$List->gofirst();
	$imprime= '<select name="barrioajax" class="TextoNormal">';
	$imprime=$imprime.'<option value="">Seleccion Barrio</option>';   
	if (!$List->isvoid()){
		do {
			
             $imprime=$imprime.'<option value="'.$List->getelem()->id_comuna.'"{selected}>'.$List->getelem()->nomcomuna.' - '.$List->getelem()->nomcomunad.'</option>'; 
             				
		} while ($List->gonext());
		echo $imprime.'</select>';
		}
	else{echo $imprime.'</select>';}
	
}
else
{
	$List = new connlist;
	bizcve::getbarrios($List, $opcionSeleccionada,$ciudad,$province);  
	$List->gofirst();
//        Mantis XXXX INICIO
//        SE AGREGA id="id_barrio_despacho_'.$indice.'" 
	$imprime= '<select id="id_barrio_despacho_'.$indice.'" name="barrioarray_'.$indice.'" class="TextoNormal" onChange ="validabarrio('.$indice.');">';
//        Mantis XXXX Fin
	$imprime=$imprime.'<option value="">Seleccion Barrio</option>';   
	if (!$List->isvoid()){
		do {
			
             $imprime=$imprime.'<option value="'.$List->getelem()->id_comuna.'"{selected}>'.$List->getelem()->nomcomuna.' - '.$List->getelem()->nomcomunad.'</option>'; 
             				
		} while ($List->gonext());
//		Mantis XXXX INICIO
		$imprime=$imprime.'</select>';
		$imprime=$imprime.'<br>';
                $imprime=$imprime.'<span id="error_barrio_despacho_'.$indice.'" style="color: red;font-size: 10px; font-weight: bold;font-style:initial"></span>|'.$indice;
//                Mantis XXXX FIN
		echo $imprime;
		}
	else{$imprime=$imprime.'</select>|'.$indice;
		echo $imprime;}
}
?>
