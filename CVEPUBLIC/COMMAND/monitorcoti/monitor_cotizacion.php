<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitorcoti/monitor_cotizacion.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

if ($_POST['accion'] == 'eli' && $_POST['ideli']) {
	$List = new connlist;
	$ieditar = new dtocotizacion;
	$ieditar->id_cotizacion = $_POST['ideli'];
	$id_cotizacion=$_POST['ideli'];
	$List->addlast($ieditar);
	if (bizcve::delcotizacionall($List)){
		general::writeevent('La cotizacion '.$id_cotizacion.' ha sido eliminada.');
		general::inserta_tracking( $id_cotizacion, null, null, null, "Se ha eliminado la cotizaci�n");	
		header("Location: monitor_cotizacion.php?rut=" . $_POST['rut']);	
		exit();
	}
}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE . "monitorcoti/monitor_cotizacion.htm");

$MiTemplate->set_var("fechaucofini", $_POST["feini"]);
$MiTemplate->set_var("fechaucoffin", $_POST["fefin"]);

/**/
/*Despliegue informacion de tipo venta*/
$List  = new connlist;
bizcve::gettipoventa($List);
$List->gofirst();
$MiTemplate->set_block('main' , "tipoventa" , "BLO_tipoventa");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('idventa', $List->getelem()->id);
		$MiTemplate->set_var('nomtipoventa', $List->getelem()->nombre);
		$MiTemplate->set_var('selected_venta', ($_POST['select_tipoventa'] == $List->getelem()->id)?'selected':'');
		
        $MiTemplate->parse("BLO_tipoventa", "tipoventa", true);
	} while ($List->gonext());
}
/*Fin Despliegue informacion de tipo venta*/

/**/
/*Despliegue informacion de Centro Suministro*/
$List  = new connlist;
if ($ses_usr_codlocal){
	bizcve::getlocales($List);
	$List->gofirst();
	$MiTemplate->set_block('main' , "suministro" , "BLO_suministro");
	if (!$List->isvoid()) {
		do {
			
			if($ses_usr_codlocal==$List->getelem()->cod_local){
				$MiTemplate->set_var('codigo_local', $ses_usr_codlocal);
				$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
				$MiTemplate->set_var('selected','selected');
				
		        $MiTemplate->parse("BLO_suministro", "suministro", true);
			}  	
		} while ($List->gonext());
	}
	
}
else{
	$List  = new connlist;
	bizcve::getlocales($List);
	$List->gofirst();
	$MiTemplate->set_block('main' , "suministro" , "BLO_suministro");
	if (!$List->isvoid()) {
		do {
			$MiTemplate->set_var('codigo_local', $List->getelem()->cod_local);
			$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
			$MiTemplate->set_var('selected', ($ses_usr_codlocal == $List->getelem()->cod_local)?'selected':'');
	        $MiTemplate->set_var('selected', ($_POST['select_suministro'] == $List->getelem()->cod_local)?'selected':'');
	        $MiTemplate->parse("BLO_suministro", "suministro", true);
		} while ($List->gonext());
	}
}
/*Fin Despliegue informacion de Centro Suministro*/

/**/
/*Despliegue Estado Cotizacion*/

$List  = new connlist;
$mRegistro=new dtoestado;
$mRegistro->tipo = 'CO';
$List->addlast($mRegistro);
bizcve::getestados($List);
$List->gofirst();
$MiTemplate->set_block('main' , "estado" , "BLO_estado");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('id_estado', $List->getelem()->id_estado);			
		$MiTemplate->set_var('descripcion', $List->getelem()->descripcion);
		$MiTemplate->set_var('selected', ($_POST['select_estado'] == $List->getelem()->id_estado)?'selected':'');
		
		$MiTemplate->parse("BLO_estado", "estado", true);
	} while ($List->gonext());
}
/*Fin Despliegue Estado Cotizacion*/

/*DESPLIEGUE*/   

$MiTemplate->set_var('buscar',($_POST['buscar'] && $_POST['filtro']==1)?$_POST['buscar']:$_POST['buscar']);
if (!$_POST['filtro'])
	$MiTemplate->set_var('checkr3', 'checked');
else
	$MiTemplate->set_var('checkr'.$_POST['filtro'], 'checked');

$ListEnc  = new connlist;
$mRegistro = new dtocotizacion;

if ($ses_usr_codlocal){
	$MiTemplate->set_var('deshabilitar_select','disabled');
	//$mRegistro->codlocalcsum=$ses_usr_codlocal;
	$mRegistro->codlocalventa=$ses_usr_codlocal;
}
else{
	//$mRegistro->codlocalcsum=$_POST['select_suministro'];
	$mRegistro->codlocalventa=$_POST['select_suministro'];
}

$mRegistro->fechaucofini = ($_POST['feini'])?general::formato_fecha_FORM2DB($_POST['feini']) . ' 00:00:00':null;
$mRegistro->fechaucoffin = ($_POST['fefin'])?general::formato_fecha_FORM2DB($_POST['fefin']) . ' 23:59:59':null;
$mRegistro->id_tipoventa=$_POST['select_tipoventa'];
$mRegistro->id_estado=$_POST['select_estado'];
if ($_POST['buscar']) {
	switch ($_POST['filtro']){
		case 1:
			$mRegistro->rutcliente = $_POST['buscar'];
			break;
		case 2:
			$mRegistro->razonsoc = $_POST['buscar'];
			break;
		case 3:
			$mRegistro->id_cotizacion = $_POST['buscar'];
			break;
		
	}
}
	
$mRegistro->limite=LIMITE_DESPLIEGUE_COTI;
$ListEnc->addlast($mRegistro);
bizcve::getMonitorcotizacion($ListEnc, $ListDet);
$ListEnc->gofirst();
$rut=$ListEnc->getelem()->rutcliente;
$MiTemplate->set_block('main' , "infocotizacion" , "BLO_infocotizacion");
if (!$ListEnc->isvoid()) {
	do {
		$MiTemplate->set_var('numerocot',$ListEnc->getelem()->id_cotizacion);
		$MiTemplate->set_var('rut',$ListEnc->getelem()->rutcliente);
		$MiTemplate->set_var('usuariocrea',$ListEnc->getelem()->usuariocrea);		
		$MiTemplate->set_var('nomestadocot',$ListEnc->getelem()->nomestado);
		$MiTemplate->set_var('nomtipoventacot',$ListEnc->getelem()->nomtipoventa);
		$MiTemplate->set_var('nom_localcsum',$ListEnc->getelem()->nom_localcsum);
		$Listj = new connlist;
		bizcve::gettipojur($rut,$Listj);
		$Listj->gofirst();	
		$MiTemplate->set_var('rutdv', (($Listj->getelem()->id_contribuyente == 2)?$ListEnc->getelem()->rutcliente.'-'.general::digiVer($ListEnc->getelem()->rutcliente):$ListEnc->getelem()->rutcliente));
		$MiTemplate->set_var('feccrea',general::formato_fecha($ListEnc->getelem()->feccrea));
		$MiTemplate->set_var('razonsoc',$ListEnc->getelem()->razonsoc);
		$MiTemplate->set_var('accver',($ListEnc->getelem()->puedever)?"<a href=\"#\"><img src=\"../../IMAGES/info.gif\" alt=\"Ver\" border=\"0\" id=\"".$ListEnc->getelem()->id_cotizacion."\" onClick=\"vercoti(this)\"></a>":"");
		$ListEncCountGE = new connlist;
		$mRegistroGE = new dtodetcotizacion;
		$mRegistroGE->id_cotizacion=$ListEnc->getelem()->id_cotizacion;
		$ListEncCountGE->addlast($mRegistroGE);
		bizcve::getdetcotizacioncountpegenerico($ListEncCountGE);
		$ListEncCountGE->gofirst();
		if($ListEncCountGE->getelem()->cantidad >0){
		$MiTemplate->set_var('accmodificar',($ListEnc->getelem()->puedemodificar)?"<a href=\"#\"><img src=\"../../IMAGES/editicon.gif\" alt=\"Modificar\" border=\"0\" id=\"".$ListEnc->getelem()->id_cotizacion."\" onClick=\"editarcotipege(this)\"></a>":"");	
		}
		else{
		$MiTemplate->set_var('accmodificar',($ListEnc->getelem()->puedemodificar)?"<a href=\"#\"><img src=\"../../IMAGES/editicon.gif\" alt=\"Modificar\" border=\"0\" id=\"".$ListEnc->getelem()->id_cotizacion."\" onClick=\"editarcoti(this)\"></a>":"");
		}
		//$MiTemplate->set_var('accmodificar',($ListEnc->getelem()->puedemodificar)?"<a href=\"#\"><img src=\"../../IMAGES/editicon.gif\" alt=\"Modificar\" border=\"0\" id=\"".$ListEnc->getelem()->id_cotizacion."\" onClick=\"editarcoti(this)\"></a>":"");
		$MiTemplate->set_var('acceliminar',($ListEnc->getelem()->puedeeliminar)?"<a href=\"#\"><img src=\"../../IMAGES/trash.gif\" alt=\"Eliminar\" border=\"0\" id=\"".$ListEnc->getelem()->id_cotizacion."\" onClick=\"eliminarcoti(this)\"></a>":"");
		$MiTemplate->parse("BLO_infocotizacion", "infocotizacion", true);
	} while ($ListEnc->gonext());
}

/*Fin Despliegue Estado Cotizacion*/

/*FIN DESPLIEGUE*/
$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>
