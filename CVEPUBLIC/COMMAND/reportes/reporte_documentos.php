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
$MiTemplate->set_file("main", TEMPLATE ."reportes/reporte_documentos.htm");

//Recuperamos y asignamos los parametros de consulta
/*** Tipo Documento ***/
$List = new connlist;
bizcve::gettipodocumento($List);
$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "tipodocumento" , "BLO_tipodocumento");
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nombre', $List->getelem()->nombre);
		$MiTemplate->set_var('selecteda', ($_POST['tipodocumento']==$List->getelem()->id)?'selected':'');		
		$MiTemplate->parse("BLO_tipodocumento", "tipodocumento", true);	
	} while ($List->gonext());
}
$tipo_documento = $_POST['tipodocumento'];
/*NUEVA FUNCIONALIDAD********************************************************************/
/**/
/*Despliegue Estados*/

$List  = new connlist;
$mRegistro=new dtoestado;
$mRegistro->tipo = 'OE';
$mRegistro->id_estado = 'ON'."','".'OG'."','".'OR';
$List->addlast($mRegistro);
bizcve::getestadodocumento($List);
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
$estado = $_POST['select_estado'];
$emitido = $_POST['select_emitido'];
//general::alert($emitido);
/*Despliegue Emitido si o no*/
$val = 1;

$MiTemplate->set_var('selected_emitido', ($_POST['select_emitido'] != $val)?'selected':'');
$emitido = $_POST['select_emitido'];

/*Despliegue Enviado a SAP si o no*/
$val2 = 1;

$MiTemplate->set_var('selected_sap', ($_POST['select_sap'] != $val2)?'selected':'');
$indmsgsap = $_POST['select_sap'];

/* FIN NUEVA FUNCIONALIDAD********************************************************************/

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
/*** Despliegue tipo venta***/
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
$tipo_venta = $_POST['select_tipoventa'];
/*** Fecha de Inicio ***/
	$MiTemplate->set_var("fec_valid",$_REQUEST['fec_valid']);	
	$fecinicio = ($_REQUEST['fec_valid'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid']) . ' 00:00:00':null;
/*** Fecha de Término ***/
	$MiTemplate->set_var("fec_valid2",$_REQUEST['fec_valid2']);	
	$fectermino = ($_REQUEST['fec_valid2'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid2']) . ' 00:00:00':null;
/*** Numero Folio ***/
	$MiTemplate->set_var("numfolio",$_REQUEST['numfolio']);	
	$numfolio = $_REQUEST['numfolio'];
/*** Numero Doc. CVE ***/
	$MiTemplate->set_var("numdoccve",$_REQUEST['numdoccve']);	
	$numdoccve = $_REQUEST['numdoccve'];
/*** Rut Cliente ***/
	$MiTemplate->set_var("rut",$_REQUEST['rut']);	
	$rut = $_REQUEST['rut'];
/*** Usuario ***/
	//$MiTemplate->set_var("razonsoc",$_REQUEST['razonsoc']);	
	$usuario = $ses_usr_login;	
/*** Tipo Facturacion ***/
$List  = new connlist;
bizcve::gettipoflujoreporte($List);
$List->gofirst();
$MiTemplate->set_block('main' , "tipofacturacion" , "BLO_tipofacturacion");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nom_facturacion', $List->getelem()->nombre);
		$MiTemplate->set_var('selected_fact', ($_POST['select_facturacion'] == $List->getelem()->id)?'selected':'');
		
        $MiTemplate->parse("BLO_tipofacturacion", "tipofacturacion", true);
	} while ($List->gonext());
}
$tipo_factura = $_POST['select_facturacion'];

//Mostramos el detalle del reporte
if ($_REQUEST['accion'] == 'ver') {
	//Ejecutamos la consulta
	$Listado  = new connlist;
	$mRegistro = new dtoreporte;
	$mRegistro->codlocalemi = $codlocalemi;
	$mRegistro->tipo_venta = $tipo_venta;
	$mRegistro->fecinicio = $fecinicio;
	$mRegistro->fectermino = $fectermino;
	$mRegistro->numdocumento = $numfolio;	
	$mRegistro->numdoccve = $numdoccve;	
	$mRegistro->rutcliente = $rut;		
	$mRegistro->tipo_factura = $tipo_factura;
	$mRegistro->tipodocumento = $tipo_documento;
	$mRegistro->usuario = $usuario;
	$mRegistro->estado = $estado;	
	$mRegistro->lockprint = $emitido;	
	$mRegistro->indmsgsap = $indmsgsap;	
	$Listado->addlast($mRegistro);
	bizcve::getreportedocumentosall($Listado);
	$Listado->gofirst();
	
	//Cuerpo del reporte
	$MiTemplate->set_file("reportedetalle", TEMPLATE ."reportes/reporte_documentos_detalle.htm");
	$MiTemplate->set_block("reportedetalle", "reportedetalle_NOM", "reportedetalle_BLO");
	$arr_docpago = Array();
	$contadorr = 0; 
	if (!$Listado->isvoid()) {
		do {
			++$contadorr;
			if ($contadorr > LIMITE_REPORTE_DOC && !$contadorstat) {
				$contadorstat = $contadorr - 1; //No sigo parseando más datos
			}
			if (!$contadorstat) {
				$MiTemplate->set_var("valor1", $Listado->getelem()->numdocumento);
				$MiTemplate->set_var("valor2", $Listado->getelem()->sigtipodoc);
				$MiTemplate->set_var("valor3", $Listado->getelem()->oe);
				$MiTemplate->set_var("valor4", (($Listado->getelem()->fechadocumento)?$Listado->getelem()->fechadocumento:'&nbsp;'));
				$MiTemplate->set_var("valor5", $Listado->getelem()->tipo_venta);
				$MiTemplate->set_var("valor7", (($Listado->getelem()->nomloccsum)?$Listado->getelem()->nomloccsum:'&nbsp;'));
				$MiTemplate->set_var("valor6", (($Listado->getelem()->codlocalemi)?$Listado->getelem()->codlocalemi:'&nbsp;'));
				$MiTemplate->set_var("valor8", (($Listado->getelem()->id_contribuyente == 2)?$Listado->getelem()->rutcliente.'-'.general::digiVer($Listado->getelem()->rutcliente) : $Listado->getelem()->rutcliente ));
				$MiTemplate->set_var("valor9", $Listado->getelem()->razonsoc);
				$MiTemplate->set_var("valor100",$Listado->getelem()->tipodocumento);
				$MiTemplate->set_var("valor101",$Listado->getelem()->referencia);
				$MiTemplate->set_var("valor20",$Listado->getelem()->id_estado);
				if($Listado->getelem()->lockprint=='1'){
					$MiTemplate->set_var("valor21", 'Si');	
				}else{
					$MiTemplate->set_var("valor21", 'No');
				}
				if($Listado->getelem()->indmsgsap=='1'){
					$MiTemplate->set_var("valor22", 'Si');	
				}else{
					$MiTemplate->set_var("valor22", 'No');
				}
				$MiTemplate->set_var("valor11", number_format($Listado->getelem()->neto+0));
				$totalvalor11 += $Listado->getelem()->neto;
				$MiTemplate->set_var("valor12", number_format($Listado->getelem()->iva+0));
				$totalvalor12 += $Listado->getelem()->iva;
				$MiTemplate->set_var("valor13", number_format($Listado->getelem()->total_venta+0));
				$totalvalor13 += $Listado->getelem()->total_venta;
				$MiTemplate->parse("reportedetalle_BLO", "reportedetalle_NOM", true);
			}
		} while ($Listado->gonext());
	}
/*	if ($contadorr) {
		//$MiTemplate->set_var("mensajelimite", "Se muestran " .LIMITE_REPORTE_DOC." registros.");
	}
	if (!$contadorr) {
		$MiTemplate->set_var("mensajelimite", "No se han encontrado registros para la consulta");
	}*/
	
	//Pie de página del reporte
	$MiTemplate->set_var("totalvalor11",number_format($totalvalor11));
	$MiTemplate->set_var("totalvalor12",number_format($totalvalor12));
	$MiTemplate->set_var("totalvalor13",number_format($totalvalor13));
	$MiTemplate->set_var("numdocumentos",$contadorr);
	
	$MiTemplate->set_block("reportedetalle", "mediopago", "mediopago_BLO");
	foreach ($arr_docpago as $key => $value) {
		$MiTemplate->set_var("tipomediopago", $key);
		$MiTemplate->set_var("valormediopago", number_format($value));
		$MiTemplate->parse("mediopago_BLO", "mediopago", true);
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