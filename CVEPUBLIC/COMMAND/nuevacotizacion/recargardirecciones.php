<?php
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");


$idDireccion = $_REQUEST['iddireccion'];
echo $idDireccion;
/* OBTENEMOS LAS DIRECCIONES DE DESPACHO */
//if (!$List->isvoid()) {
	
	//	$MiTemplate->set_var('nom_direccion', $List->getelem()->nom_direccion);
//}


bizcve::getdirdesp($List = new connlist(new dtodireccion(array('rut'=>$listaEnc->getelem()->rutcliente ))));
print_r($List->getelem()->descripcion);
/*$List->gofirst();
$MiTemplate->set_block('main' , "dirdesp" , "BLO_dirdesp");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('id_direccion', $List->getelem()->id_direccion);
		$MiTemplate->set_var('nombre', $List->getelem()->descripcion." - ".$List->getelem()->direccion.", ".$List->getelem()->nomcomuna);
		$MiTemplate->set_var('selected', (($_REQUEST['dir'] == $List->getelem()->id_direccion)?'selected':''));
		$MiTemplate->parse("BLO_dirdesp", "dirdesp", true);	
	} while ($List->gonext());
}


*/
?>