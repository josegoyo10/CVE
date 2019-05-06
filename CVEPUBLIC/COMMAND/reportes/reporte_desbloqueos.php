<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
//$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_file("main", TEMPLATE ."reportes/reporte_desbloqueos.htm");

//Recuperamos y asignamos los parámetros de consulta
/*** Local ***/
	$List  = new connlist;
	bizcve::getlocales($List);
	$List->gofirst();
	$MiTemplate->set_block('main' , "local" , "BLO_local");
	if (!$List->isvoid()) {
		if ($ses_usr_codlocal) {
			$MiTemplate->set_var('disabled_local', 'disabled');
		}
		do {
			$MiTemplate->set_var('codigo_local', $List->getelem()->cod_local);
			$MiTemplate->set_var('nombre_local', $List->getelem()->nom_local);		
			if ($_POST['local'])
	        	$MiTemplate->set_var('selected', ($_POST['local'] == $List->getelem()->cod_local)?'selected':'');
			else
				$MiTemplate->set_var('selected', ($ses_usr_codlocal == $List->getelem()->cod_local)?'selected':'');
			$MiTemplate->parse("BLO_local", "local", true);
		} while ($List->gonext());
	}
	$codlocalemi = ($_POST['local'])?$_POST['local']:$ses_usr_codlocal;
/*** Fecha de Inicio Bloqueo***/
	$MiTemplate->set_var("fec_valid",$_REQUEST['fec_valid']);	
	$fecinicio = ($_REQUEST['fec_valid'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid']) . ' 00:00:00':null;
/*** Fecha de Término Bloqueo***/
	$MiTemplate->set_var("fec_valid2",$_REQUEST['fec_valid2']);	
	$fectermino = ($_REQUEST['fec_valid2'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid2']) . ' 00:00:00':null;

/*** Seleccione usuario ***/
$List = new connlist;
$mRegistro= new dtousuario;
$mRegistro->id_tipousuario='1';
if ($_POST['local'])
	$mRegistro->cod_local = $_POST['local'];
else
	$mRegistro->cod_local = $ses_usr_codlocal;

$List->addlast($mRegistro);
bizcve::GetUsers($List);
$List->gofirst();
$MiTemplate->set_block('main' , "usuario" , "BLO_usuario");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('codigousuario',$List->getelem()->codigovendedor);
		$MiTemplate->set_var('nomusuario',$List->getelem()->usr_nombres." ".$List->getelem()->usr_apellidos);
		$MiTemplate->set_var('selecteda', ($_POST['select_usuario']==$List->getelem()->codigovendedor)?'selected':'');
		$MiTemplate->parse("BLO_usuario", "usuario", true);
	} while ($List->gonext());
}
$codusuario = $_POST['select_usuario'];
/*Fin Seleccion usuario*/

/*** Fecha de Inicio Desbloqueo***/
	$MiTemplate->set_var("fec_valid3",$_REQUEST['fec_valid3']);	
	$fecinicio = ($_REQUEST['fec_valid3'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid3']) . ' 00:00:00':null;
/*** Fecha de Término Desbloqueo***/
	$MiTemplate->set_var("fec_valid4",$_REQUEST['fec_valid4']);	
	$fectermino = ($_REQUEST['fec_valid4'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid4']) . ' 00:00:00':null;
/*** Entidad ***/
	$MiTemplate->set_var("entidad",$_REQUEST['entidad']);	
	$margen_limite = $_REQUEST['entidad'];
/*** Numero ***/
	$MiTemplate->set_var("numero",$_REQUEST['numero']);	
	$margen_limite = $_REQUEST['numero'];	
	
	
//Mostramos el detalle del reporte
if ($_REQUEST['accion'] == 'ver') {
	//Ejecutamos la consulta
	$Listado  = new connlist;
	$mRegistro = new dtoreporte;
	$mRegistro->codlocalemi = $codlocalemi;
	$mRegistro->fecinicio = $fecinicio;
	$mRegistro->fectermino = $fectermino;
	$mRegistro->foliodesde = $foliodesde;
	$mRegistro->foliohasta = $foliohasta;
	$Listado->addlast($mRegistro);
	bizcve::getreportedesbloqueos($Listado);
	$Listado->gofirst();
	
	//Cuerpo del reporte
	$MiTemplate->set_file("reportedetalle", TEMPLATE ."reportes/reporte_desbloqueos_detalle.htm");
	$MiTemplate->set_block("reportedetalle", "reportedetalle_NOM", "reportedetalle_BLO");
	$arr_docpago = Array();
	$contadorr = 0; 
	if (!$Listado->isvoid()) {
		do {
			++$contadorr;
			$MiTemplate->set_var("valor1", $Listado->getelem()->codlocalemi);
			$MiTemplate->set_var("valor2", $Listado->getelem()->entidad);
			$MiTemplate->set_var("valor3", $Listado->getelem()->numero_entidad);
			$MiTemplate->set_var("valor4", $Listado->getelem()->referencia);
			$MiTemplate->set_var("valor5", $Listado->getelem()->codvendedor);
			$MiTemplate->set_var("valor6", $Listado->getelem()->fecinicio);
			$MiTemplate->set_var("valor7", $Listado->getelem()->fecha_desbloqueo);
			$MiTemplate->set_var("valor8", $Listado->getelem()->hora);
			$MiTemplate->set_var("valor9", $Listado->getelem()->datos);
			$MiTemplate->set_var("valor10", $Listado->getelem()->resultado);
			$MiTemplate->parse("reportedetalle_BLO", "reportedetalle_NOM", true);
		} while ($Listado->gonext());
	}
}

/*FIN DESPLIEGUE*/
$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>