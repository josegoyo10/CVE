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
$MiTemplate->set_file("main", TEMPLATE ."reportes/reporte_cuadratura.htm");

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
/*** Fecha de Inicio ***/
	$MiTemplate->set_var("fec_valid",$_REQUEST['fec_valid']);	
	$fecinicio = ($_REQUEST['fec_valid'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid']) . ' 00:00:00':null;
/*** Fecha de Término ***/
	$MiTemplate->set_var("fec_valid2",$_REQUEST['fec_valid2']);	
	$fectermino = ($_REQUEST['fec_valid2'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid2']) . ' 00:00:00':null;
/*** Folio Desde ***/
	$MiTemplate->set_var("foliodesde",$_REQUEST['foliodesde']);
	if($_REQUEST['foliodesde']=='0'){
		$foliodesde = '0';		
	}else{
		$foliodesde = $_REQUEST['foliodesde'];	
	}
	
/*** Folio Hasta ***/
	$MiTemplate->set_var("foliohasta",$_REQUEST['foliohasta']);	
	if($_REQUEST['foliohasta']=='0'){
		$foliohasta='0';
	}else{
		$foliohasta = $_REQUEST['foliohasta'];	
	}
	

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
	bizcve::getreportecuadratura($Listado);
	$Listado->gofirst();
	
	//Cuerpo del reporte
	$MiTemplate->set_file("reportedetalle", TEMPLATE ."reportes/reporte_cuadratura_detalle.htm");
	$MiTemplate->set_block("reportedetalle", "reportedetalle_NOM", "reportedetalle_BLO");
	$arr_docpago = Array();
	$contadorr = 0; 
	if (!$Listado->isvoid()) {
		do {
			++$contadorr;
			if ($contadorr > LIMITE_REPORTE_CUADRATURA && !$contadorstat) {
				$contadorstat = $contadorr - 1; //No sigo parseando más datos
			}
			if (!$contadorstat) {
				$MiTemplate->set_var("valor1", $Listado->getelem()->numdocumento);
				$MiTemplate->set_var("valor2", $Listado->getelem()->sigtipodoc);
				$MiTemplate->set_var("valor3", (($Listado->getelem()->fechadocumento)?$Listado->getelem()->fechadocumento:'&nbsp;'));
				$MiTemplate->set_var("valor4", (($Listado->getelem()->nomlocemi)?$Listado->getelem()->nomlocemi:'&nbsp;'));
				$MiTemplate->set_var("valor5", (($Listado->getelem()->nomloccsum)?$Listado->getelem()->nomloccsum:'&nbsp;'));
				$MiTemplate->set_var("valor6", (($Listado->getelem()->id_contribuyente == 2)?$Listado->getelem()->rutcliente.'-'.general::digiVer($Listado->getelem()->rutcliente) : $Listado->getelem()->rutcliente ));
				$MiTemplate->set_var("valor7", $Listado->getelem()->razonsoc);
				$MiTemplate->set_var("valor77", $Listado->getelem()->tipopago);
				switch($Listado->getelem()->tipopago){
					case 1:
					$MiTemplate->set_var("valor77", 'Efectivo Deudor');
					break;
					case 2:
					$MiTemplate->set_var("valor77", 'Cheque al dia Deudor');
					break;
					case 3:
					$MiTemplate->set_var("valor77", 'Cheque a fecha Deudor');
					break;
					case 4:
					$MiTemplate->set_var("valor77", 'Tarjeta de credito Deudor');
					break;
					case 5:
					$MiTemplate->set_var("valor77", 'Factura - O.C. Deudor');
					break;
					case 6:
					$MiTemplate->set_var("valor77", 'Mixta(Ch.Cartera+Fact) Deudor');
					break;
					case 9:
					$MiTemplate->set_var("valor77", 'Nota Credito Saldo Favor');
					break;
				}





				$MiTemplate->set_var("valor8", (($Listado->getelem()->nommedpag)?$Listado->getelem()->nommedpag:'&nbsp;'));
				$arr_docpago[(($Listado->getelem()->nommedpag)?$Listado->getelem()->nommedpag:'-Sin Asignar-')] += $Listado->getelem()->totalnumiva;
				$MiTemplate->set_var("valor9", (($Listado->getelem()->numdocpago)?$Listado->getelem()->numdocpago:'&nbsp;'));
				$MiTemplate->set_var("valor10", (($Listado->getelem()->condicion_pago)?$Listado->getelem()->condicion_pago:'Al d&iacute;a'));
				$MiTemplate->set_var("valor11", number_format($Listado->getelem()->totalnum+0));
				$totalvalor11 += $Listado->getelem()->totalnum;
				$MiTemplate->set_var("valor12", number_format($Listado->getelem()->totaliva+0));
				$totalvalor12 += $Listado->getelem()->totaliva;
				$MiTemplate->set_var("valor13", number_format($Listado->getelem()->totalnumiva+0));
				$totalvalor13 += $Listado->getelem()->totalnumiva;
				$MiTemplate->set_var("valor133", $Listado->getelem()->codigovendedor);
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
	$MiTemplate->set_var("numdocumentos",(($contadorstat)?$contadorstat:$contadorr));
	
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