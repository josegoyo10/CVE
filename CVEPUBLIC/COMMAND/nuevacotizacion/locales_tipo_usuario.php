<?php
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

$id_tienda_factu=$_GET['id_tienda_factu'];
$tienda_usuario=$_GET['tienda_usuario'];
$tipo_usuario_reg=$_GET['tipo_usuario_reg'];
$error=false;
$imprime='<b>Suministro : </b><select name="centrosuministro"><option value="" class="Textonormal">Seleccione</option>';

if($id_tienda_factu){

	$Listlocalsum  = new connlist;
	$mRegistrolocalsum = new dtolocal;
	$mRegistrolocalsum->cod_local_fac=$id_tienda_factu;
	$Listlocalsum->addlast($mRegistrolocalsum);
	bizcve::local_sum_asociado($Listlocalsum);
	$Listlocalsum->gofirst();
	
	$List  = new connlist;
	$mRegistrolocal = new dtolocal;
	$mRegistrolocal->cod_local=(trim($Listlocalsum->getelem()->cod_local_sum)==""?"N/A":$Listlocalsum->getelem()->cod_local_sum);
	$List->addlast($mRegistrolocal);
	bizcve::getlocales($List);
	$List->gofirst();

	if (!$List->isvoid()) {
		do {
				$imprime_datos=$imprime_datos.'<option value="'.$List->getelem()->cod_local.'" selected="selected">'.$List->getelem()->nom_local.'</option>';
		} while ($List->gonext());
	}
	else{
		$error = true;
	}
}

echo $imprime.$imprime_datos.'|'.$error.'|'.$mensaje;
?>