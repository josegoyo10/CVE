<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitororent/monitor_orden_entrega.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
/*Inclusion de header*/
$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_var('error_app', $mensaje_error);
/**/
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_var("TITULO", TITULO);
/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "ordenent/orden_entrega_prov_gde.htm");
/**/
$ListEnc = new connlist;
$ListDet = new connlist;
$Registro = new dtodocumento;
$Registro->id_documento = $_REQUEST['id_documento'];
//$Registro->sigtipodoc = 'FCT';
$ListEnc->addlast($Registro);
$ListDet->addlast($Registro);
bizcve::getdocumento($ListEnc, $ListDet);
$ListEnc->gofirst();
$ListDet->gofirst();
$MiTemplate->set_var('id_ordenenta', $ListEnc->getelem()->numorigen);
if (!$ListEnc->isvoid()) {
	do {
		$MiTemplate->set_var('rutcliente', $ListEnc->getelem()->rutcliente.'-'.general::digiVer($ListEnc->getelem()->rutcliente));
		$MiTemplate->set_var('oe', $ListEnc->getelem()->numorigen);
		$MiTemplate->set_var('nomtipoflujo', 'Facturacion Proveedor');
			$codigovendedor= $ListEnc->getelem()->codigovendedor;	
			$List = new connlist;
			$Registro = new dtousuario;
			$Registro->codigovendedor	=  $codigovendedor;
			$List->addlast($Registro);
			bizcve::GetUsers($List);
			$List->gofirst();
			$usr_nombre=$List->getelem()->usr_nombres;
			$usr_apellidos=$List->getelem()->usr_apellidos;	
			$MiTemplate->set_var('nombrevendedor', $usr_nombre.' '.$usr_apellidos);
		$MiTemplate->set_var('nom_localventa', $ListEnc->getelem()->codlocalventa);
		$MiTemplate->set_var('usuariocrea', $ListEnc->getelem()->usrcrea);
		$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);
		$MiTemplate->set_var('direccion', $ListEnc->getelem()->direccion);
		$MiTemplate->set_var('comunad', 'Comuna');
		$MiTemplate->set_var('nomcomunad', $ListEnc->getelem()->comuna);
	} while ($ListEnc->gonext());
}

if (!$ListDet->isvoid()) {
	$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detalleproductos");
	do {
		$MiTemplate->set_var('id_linea', $ListDet->getelem()->id_linea);
		$MiTemplate->set_var('id_documento', $ListDet->getelem()->id_documento);
		$MiTemplate->set_var('numlinea', $ListDet->getelem()->numlinea);
		$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
		$MiTemplate->set_var('cantidad', $ListDet->getelem()->cantidad);
		$MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
		$MiTemplate->set_var('nomproveedor', $ListDet->getelem()->nomproveedor);
		$MiTemplate->set_var('pventanetof', $ListDet->getelem()->pventaneto);
		$MiTemplate->set_var('precio', $ListDet->getelem()->pventaiva);
		$MiTemplate->set_var('totallinea', $ListDet->getelem()->totallinea);
		$MiTemplate->set_var('unimed', $ListDet->getelem()->unimed);
		$MiTemplate->parse("BLO_detalleproductos", "detalleproductos", true);	
	} while ($ListDet->gonext());
}

/*FIN DESPLIEGUE*/
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

?>
