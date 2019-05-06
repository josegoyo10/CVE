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
$MiTemplate->set_file("main", TEMPLATE ."reportes/reporte_guia_despacho.htm");

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
	$codlocalcsum = ($_POST['local'])?$_POST['local']:$ses_usr_codlocal;
/*** Fecha de Inicio ***/
	$MiTemplate->set_var("fec_valid",$_REQUEST['fec_valid']);	
	$fecinicio = ($_REQUEST['fec_valid'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid']) . ' 00:00:00':null;
/*** Fecha de Término ***/
	$MiTemplate->set_var("fec_valid2",$_REQUEST['fec_valid2']);	
	$fectermino = ($_REQUEST['fec_valid2'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid2']) . ' 00:00:00':null;
/*** Razon Social ***/
	$MiTemplate->set_var("razonsoc",$_REQUEST['razonsoc']);	
	$razonsoc = $_REQUEST['razonsoc'];
/*** Rut Cliente ***/
	$MiTemplate->set_var("rut",$_REQUEST['rut']);	
	$rut = $_REQUEST['rut'];	
/*** Tipo Entrega ***/
	$List  = new connlist;
	bizcve::gettipoentrega($List);
	$List->gofirst();
	$MiTemplate->set_block('main' , "tipoentrega" , "BLO_tipoentrega");
	if (!$List->isvoid()) {
		do {
			$MiTemplate->set_var('identrega', $List->getelem()->id);
			$MiTemplate->set_var('nomtipoentrega', $List->getelem()->nombre);
			$MiTemplate->set_var('selected', ($_POST['select_tipoentrega'] == $List->getelem()->id)?'selected':'');
			
	        $MiTemplate->parse("BLO_tipoentrega", "tipoentrega", true);
		} while ($List->gonext());
	}
	$tipo_entrega = $_POST['select_tipoentrega'];
/*** Facturacion ***/
$ListEnc  = new connlist;
bizcve::gettipoventa($ListEnc, $ListDet);
$ListEnc->gofirst();
$MiTemplate->set_block('main' , "tipofacturacion" , "BLO_tipofacturacion");
if (!$ListEnc->isvoid()) {

		$MiTemplate->set_var('nom_facturacion2',$ListEnc->getelem()->nomtipoflujo);		
        
        if($_POST['select_facturacion']=="1,2,3"){
        	
        	$MiTemplate->set_var('selected_fact1','selected');
        }
        else
        if($_POST['select_facturacion']=="4,5"){
        	$MiTemplate->set_var('selected_fact2','selected');
        }
        $MiTemplate->parse("BLO_tipofacturacion", "tipofacturacion", true);
}
$tipo_factura = $_POST['select_facturacion'];
/*** Numero Folio ***/
	$MiTemplate->set_var("num_folio",$_REQUEST['num_folio']);	
	$num_folio = $_REQUEST['num_folio'];
/*** Numero Interno ***/
	$MiTemplate->set_var("oe",$_REQUEST['oe']);	
	$oe = $_REQUEST['oe'];

//Mostramos el detalle del reporte
if ($_REQUEST['accion'] == 'ver') {
	//Ejecutamos la consulta
	$Listado  = new connlist;
	$mRegistro = new dtoreporte;
	$mRegistro->codlocalcsum = $codlocalcsum;
	$mRegistro->fecinicio = $fecinicio;
	$mRegistro->fectermino = $fectermino;
	$mRegistro->tipo_factura = $tipo_factura;
	$mRegistro->tipo_entrega = $tipo_entrega;
	$mRegistro->numdocumento = $num_folio;
	$mRegistro->oe = $oe;
	$mRegistro->tipo_entrega = $tipo_entrega;
	$mRegistro->rutcliente = $rut;
	$mRegistro->razonsoc = $razonsoc;
	$Listado->addlast($mRegistro);
	bizcve::getreportegde($Listado);
	$Listado->gofirst();
	
	//Cuerpo del reporte
	$MiTemplate->set_file("reportedetalle", TEMPLATE ."reportes/reporte_guia_despacho_detalle.htm");
	$MiTemplate->set_block("reportedetalle", "reportedetalle_NOM", "reportedetalle_BLO");
	$arr_docpago = Array();
	$contadorr = 0; 
	if (!$Listado->isvoid()) {
		do {
			++$contadorr;
			if ($contadorr > LIMITE_REPORTE_GDE && !$contadorstat) {
				$contadorstat = $contadorr - 1; //No sigo parseando más datos
			}
			if (!$contadorstat) {
				$MiTemplate->set_var("valor1", (($Listado->getelem()->numdocumento)?$Listado->getelem()->numdocumento:'&nbsp;'));
				$MiTemplate->set_var("valor2", $Listado->getelem()->numinterno);
				$MiTemplate->set_var("valor3", $Listado->getelem()->oe);
				$oe_query = $Listado->getelem()->oe;
				$MiTemplate->set_var("valor4", (($Listado->getelem()->fechadocumento)?$Listado->getelem()->fechadocumento:'&nbsp;'));
				
				/*OBTENGO LA FCT Asociada a cada gu�a*/
				$Lista  = new connlist;
				$mRegistro = new dtodocumento;
				$mRegistro->numorigen = $oe_query;
				//general::alert($oe_query);
				$mRegistro->sigtipodoc = 'FCT';
				$Lista->addlast($mRegistro);
				bizcve::getdocumentoasoc($Lista);
				$Lista->gofirst();
				$MiTemplate->set_var("valor5", $Lista->getelem()->numdocumento);
				
				$MiTemplate->set_var("valor6", $Listado->getelem()->tipo_entrega);
				$MiTemplate->set_var("valor7", $Listado->getelem()->tipo_fct);
				$MiTemplate->set_var("valor8", $Listado->getelem()->codlocalcsum);
				$MiTemplate->set_var("valor9", (($Listado->getelem()->id_contribuyente == 2)?$Listado->getelem()->rutcliente.'-'.general::digiVer($Listado->getelem()->rutcliente) : $Listado->getelem()->rutcliente ));
				$MiTemplate->set_var("valor10", $Listado->getelem()->razonsoc);
				$MiTemplate->set_var("valor11", (($Listado->getelem()->destino)?$Listado->getelem()->destino:'&nbsp;'));
				$MiTemplate->parse("reportedetalle_BLO", "reportedetalle_NOM", true);
			}
		} while ($Listado->gonext());
	}
	if ($contadorstat) {
		$MiTemplate->set_var("mensajelimite", "S&oacute;lo se muestran los primeros $contadorstat registros de un total de $contadorr");
	}
	if (!$contadorr) {
		$MiTemplate->set_var("mensajelimite", "No se han encontrado registros para la consulta");
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