<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_file("main", TEMPLATE ."reportes/reporte_detalle_ventas.htm");

//Recuperamos y asignamos los parámetros de consulta
/*** Local ***/
	$List  = new connlist;
	bizcve::getlocales($List);
	$List->gofirst();
	$MiTemplate->set_block('main' , "local" , "BLO_local");
	if (!$List->isvoid()) {
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
	$codlocalemi = ($_POST['local'])?$_POST['local']:'';
	if($codlocalemi==" "||$codlocalemi==-3){
	$codlocalemi=0;
	}
/*** Fecha de Inicio ***/
	$MiTemplate->set_var("fec_valid",$_REQUEST['fec_valid']);	
	$fecinicio = ($_REQUEST['fec_valid'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid']) . ' 00:00:00':null;
/*** Fecha de Término ***/
	$MiTemplate->set_var("fec_valid2",$_REQUEST['fec_valid2']);	
	$fectermino = ($_REQUEST['fec_valid2'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid2']) . ' 00:00:00':null;
/*** Tipo Cliente ***/
$List  = new connlist;
bizcve::gettipocliente($List);
$List->gofirst();
$MiTemplate->set_block('main' , "tipo_cliente" , "BLO_tipo_cliente");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nombre', $List->getelem()->nombre);
		$MiTemplate->set_var('selecteda', ($_POST['select_tipo_cliente'] == $List->getelem()->id)?'selected':'');
		
        $MiTemplate->parse("BLO_tipo_cliente", "tipo_cliente", true);  	
	} while ($List->gonext());
}
$tipo_cliente = $_POST['select_tipo_cliente'];

//Mostramos el detalle del reporte
if ($_REQUEST['accion'] == 'ver') {
	//Ejecutamos la consulta
	$Listado  = new connlist;
	$mRegistro = new dtoreporte;
	if($codlocalemi!=''){
		$mRegistro->codlocalemi = $codlocalemi;	
	}
	$mRegistro->fecinicio = $fecinicio;
	$mRegistro->fectermino = $fectermino;
	$mRegistro->tipo_cliente = $tipo_cliente;
	$Listado->addlast($mRegistro);
	bizcve::getreportedetalleventas($Listado);
	$Listado->gofirst();
	
	//Cuerpo del reporte
	$MiTemplate->set_file("reportedetalle", TEMPLATE ."reportes/reporte_detalle_ventas_detalle.htm");
	$MiTemplate->set_block("reportedetalle", "reportedetalle_NOM", "reportedetalle_BLO");
	$contadorr = 0; 
	if (!$Listado->isvoid()) {
		do {
			++$contadorr;
			if ($contadorr > LIMITE_REPORTE_DETALLEVENTAS && !$contadorstat) {
				$contadorstat = $contadorr - 1; //No sigo parseando más datos
			}
			if (!$contadorstat) {
				$MiTemplate->set_var("valor1", $Listado->getelem()->nomlocemi);
				$MiTemplate->set_var("valor2", number_format($Listado->getelem()->totalfacturas));
				$MiTemplate->set_var("valor3", number_format($Listado->getelem()->neto_fct));
				$MiTemplate->set_var("valor4", number_format($Listado->getelem()->total_ncr));
				$MiTemplate->set_var("valor5", number_format($Listado->getelem()->neto_ncr));
				$MiTemplate->set_var("valor6", number_format($Listado->getelem()->total_neto));
				$MiTemplate->set_var("valor7", number_format($Listado->getelem()->totaliva));
				$MiTemplate->set_var("valor8", number_format($Listado->getelem()->total_venta));
				$MiTemplate->set_var("valor11", number_format($Listado->getelem()->totalfacturas+0));
				$totalvalor11 += $Listado->getelem()->totalfacturas;
				$MiTemplate->set_var("valor12", number_format($Listado->getelem()->neto_fct+0));
				$totalvalor12 += $Listado->getelem()->neto_fct;
				$MiTemplate->set_var("valor13", number_format($Listado->getelem()->total_ncr+0));
				$totalvalor13 += $Listado->getelem()->total_ncr;
				$MiTemplate->set_var("valor14", number_format($Listado->getelem()->neto_ncr+0));
				$totalvalor14 += $Listado->getelem()->neto_ncr;			
				$MiTemplate->set_var("valor15", number_format($Listado->getelem()->total_neto+0));
				$totalvalor15 += $Listado->getelem()->total_neto;			
				$MiTemplate->set_var("valor16", number_format($Listado->getelem()->totaliva+0));
				$totalvalor16 += $Listado->getelem()->totaliva;			
				$MiTemplate->set_var("valor17", number_format($Listado->getelem()->total_venta+0));
				$totalvalor17 += $Listado->getelem()->total_venta;												
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
	
	//Pie de página del reporte
	$MiTemplate->set_var("totalvalor11",number_format($totalvalor11));
	$MiTemplate->set_var("totalvalor12",number_format($totalvalor12));
	$MiTemplate->set_var("totalvalor13",number_format($totalvalor13));
	$MiTemplate->set_var("totalvalor14",number_format($totalvalor14));	
	$MiTemplate->set_var("totalvalor15",number_format($totalvalor15));
	$MiTemplate->set_var("totalvalor16",number_format($totalvalor16));
	$MiTemplate->set_var("totalvalor17",number_format($totalvalor17));		
	$MiTemplate->set_var("numdocumentos",$contadorr);
}

/*FIN DESPLIEGUE*/
$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>