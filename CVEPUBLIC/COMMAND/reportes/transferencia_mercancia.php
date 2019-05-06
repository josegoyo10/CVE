<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../reportes/transferencia_mercancia.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE ."reportes/transferecia_mercancia.html");
$MiTemplate->set_var('first','checked');

$MiTemplate->set_var("fechaucofini", $_POST["feini"]);
$MiTemplate->set_var("fechaucoffin", $_POST["fefin"]);

/**/
///filtro usuarios///
$List = new connlist;
$mRegistro= new dtousuario;
$mRegistro->usr_tipo='VE';
$mRegistro->usr_estado=" 0";
//$mRegistro->id_tipousuario='1,2,3,4';
$mRegistro->id_tipousuario='1,2';
//if ($_POST['local'])

//else
//	$mRegistro->cod_local = $ses_usr_codlocal;

$List->addlast($mRegistro);
bizcve::GetUsers($List);
$List->gofirst();
$MiTemplate->set_block('main' , "usuario" , "BLO_usuario");
if (!$List->isvoid()) {
	do {
		if($List->getelem()->codigovendedor){
			$MiTemplate->set_var('codigousuario',$List->getelem()->codigovendedor);
			$MiTemplate->set_var('nomusuario',$List->getelem()->usr_nombres." ".$List->getelem()->usr_apellidos." (".($List->getelem()->cod_local?$List->getelem()->cod_local:'LOCAL NO ASIGNADO').")");
			$MiTemplate->set_var('selecteda', ($_POST['select_usuario']==$List->getelem()->codigovendedor)?'selected':'-1');
			$MiTemplate->parse("BLO_usuario", "usuario", true);
		}
	} while ($List->gonext());
}
///fin filtro usuarios///

/*Despliegue informacion de Centro Suministro*/
	$List  = new connlist;
	bizcve::getlocales($List);
	$List->gofirst();
	$MiTemplate->set_block('main' , "suministro" , "BLO_suministro");
	if (!$List->isvoid()) {
		do {
			$MiTemplate->set_var('codigo_local', $List->getelem()->cod_local);
			$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
	        $MiTemplate->set_var('selected', ($_POST['select_suministro'] == $List->getelem()->cod_local)?'selected':'');
	        $MiTemplate->parse("BLO_suministro", "suministro", true);
		} while ($List->gonext());
	}
/*Fin Despliegue informacion de Centro Suministro*/

/*Despliegue informacion de Centro Facturación*/
	$List  = new connlist;
	bizcve::getlocales($List);
	$List->gofirst();
	$MiTemplate->set_block('main' , "factura" , "BLO_factura");
	if (!$List->isvoid()) {
		do {
			$MiTemplate->set_var('codigo_localf', $List->getelem()->cod_local);
			$MiTemplate->set_var('nom_localf', $List->getelem()->nom_local);
	        $MiTemplate->set_var('selectedf', ($_POST['select_factu'] == $List->getelem()->cod_local)?'selected':'');
	        $MiTemplate->parse("BLO_factura", "factura", true);
		} while ($List->gonext());
	}
/*Fin Despliegue informacion de Centro Facturación*/

/*Despliegue Estado Orden Entrega*/
$List  = new connlist;
$mRegistro=new dtoestado;
$mRegistro->tipo = 'OE';
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
/*Fin Despliegue Orden Entrega*/

/*DESPLIEGUE*/
$lfiltro = ($_GET['filtro']?$_GET['filtro']:$_POST['filtro']);
$lbuscar = ($_GET['buscar']?$_GET['buscar']:$_POST['buscar']);

$MiTemplate->set_var('buscar',($lbuscar && $lfiltro==1)?$lbuscar:$lbuscar);
if (!$lfiltro)
	$MiTemplate->set_var('checkr4', 'checked');
else
	$MiTemplate->set_var('checkr'.$lfiltro, 'checked');

$ListEnc  = new connlist;
$ListDet = new connlist;

$mRegistro = new dtotransferenciamercancia;
$mRegistro->codigovendedor=$_POST['select_usuario'];
$mRegistro->codlocalsuministro=$_POST['select_suministro'];
$mRegistro->fecha_ini = ($_POST['feini'])?general::formato_fecha_FORM2DB($_POST['feini']) . ' 00:00:00':null;
$mRegistro->fecha_fin = ($_POST['fefin'])?general::formato_fecha_FORM2DB($_POST['fefin']) . ' 23:59:59':null;
$mRegistro->id_tipoentrega=$_POST['select_tipoentrega'];
$mRegistro->id_estado=$_POST['select_estado'];
$mRegistro->codlocalfactura=$_POST['select_factu'];

if ($lbuscar) {
	switch ($lfiltro){
		case 1:
			$mRegistro->rutcliente = $lbuscar;
			break;
		case 2:
			$mRegistro->razonsoc = $lbuscar;
			break;
		case 3:
			$mRegistro->id_cotizacion = $lbuscar;
			break;
		case 4:
			$mRegistro->id_ordenent = $lbuscar;
			break;
	}
}

$mRegistro->limite = LIMITE_DESPLIEGUE_ORDENENT;
$ListEnc->addlast($mRegistro);
$id_estado=$_POST['select_estado'];

if($_POST['accion']){
	bizcvereportes::getReporteTransferenciaMercancia($ListEnc);
	$ListEnc->gofirst();
	$rut=$ListEnc->getelem()->rutcliente;
	
	$MiTemplate->set_block('main' , "infocotizacion" , "BLO_infocotizacion");
		if (!$ListEnc->isvoid()) {
			do {
				$MiTemplate->set_var('numerocot',$ListEnc->getelem()->id_cotizacion);
				$MiTemplate->set_var('OE',$ListEnc->getelem()->id_ordenent);
				$MiTemplate->set_var('nomestadocot',$ListEnc->getelem()->estado);
				$MiTemplate->set_var('nomtipoentrega',$ListEnc->getelem()->tipoentrega);
				$MiTemplate->set_var('nom_localfact',$ListEnc->getelem()->localfactura);	
				$MiTemplate->set_var('nom_localcsum',$ListEnc->getelem()->localsuministro);
				$MiTemplate->set_var('rutdv',$ListEnc->getelem()->rutcliente);
				$MiTemplate->set_var('razonsoc',$ListEnc->getelem()->razonsoc);
				$MiTemplate->set_var('totaloe',"$".number_format($ListEnc->getelem()->totaloe));
				$MiTemplate->parse("BLO_infocotizacion", "infocotizacion", true);
	
			} while ($ListEnc->gonext());
	}
}	
$MiTemplate->set_var('BLOQUEO_IMPRESION_GDE', BLOQUEO_IMPRESION_GDE);
$MiTemplate->set_block('main' , "doclocklist" , "BLO_doclocklist");
$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>