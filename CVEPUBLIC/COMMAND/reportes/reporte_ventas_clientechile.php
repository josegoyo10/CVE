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
$MiTemplate->set_file("main", TEMPLATE ."reportes/reporte_ventas_clientes.htm");

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
	$codlocalemi = ($_POST['local'])?$_POST['local']:$ses_usr_codlocal;
	if($codlocalemi==" "||$codlocalemi==-2){
	$codlocalemi=0;
	}
/*** Local centro suministro ***/
	$List  = new connlist;
	bizcve::getlocales($List);
	$List->gofirst();
	$MiTemplate->set_block('main' , "localcsum" , "BLO_localcsum");
	if (!$List->isvoid()) {
		do {
			$MiTemplate->set_var('codigo_localcsum', $List->getelem()->cod_local);
			$MiTemplate->set_var('nombre_localcsum', $List->getelem()->nom_local);		
			if ($_POST['localcsum'])
	        	$MiTemplate->set_var('selecteda', ($_POST['localcsum'] == $List->getelem()->cod_local)?'selected':'');
			else
				$MiTemplate->set_var('selecteda', ($ses_usr_codlocal == $List->getelem()->cod_local)?'selected':'');
			$MiTemplate->parse("BLO_localcsum", "localcsum", true);
		} while ($List->gonext());
	}
	$codlocalcsum = ($_POST['localcsum'])?$_POST['localcsum']:'';
	if($codlocalcsum==" "||$codlocalcsum==-3){
	$codlocalcsum=0;
	}
/*** Fecha de Inicio ***/
	$MiTemplate->set_var("fec_valid",$_REQUEST['fec_valid']);	
	$fecinicio = ($_REQUEST['fec_valid'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid']) . ' 00:00:00':null;
/*** Fecha de Termino ***/
	$MiTemplate->set_var("fec_valid2",$_REQUEST['fec_valid2']);	
	$fectermino = ($_REQUEST['fec_valid2'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid2']) . ' 00:00:00':null;
/*** Nombre ***/
	$MiTemplate->set_var("nomcliente",$_REQUEST['nomcliente']);	
	$nomcliente = $_REQUEST['nomcliente'];
/*** Rut Cliente ***/
	$MiTemplate->set_var("rut",$_REQUEST['rut']);	
	$rut = $_REQUEST['rut'];
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
	$mRegistro->fecinicio = $fecinicio;
	$mRegistro->fectermino = $fectermino;
	$mRegistro->tipo_cliente = $tipo_cliente;	
	$mRegistro->rutcliente = $rut;		
	$mRegistro->razonsoc = $nomcliente;		
	if($codlocalemi!=''){
		$mRegistro->codlocalemi = $codlocalemi;	
	}
	if($codlocalcsum!=''){
		$mRegistro->codlocalcsum = $codlocalcsum;	
	}
	$Listado->addlast($mRegistro);
	bizcve::getventascliente($Listado);
	$Listado->gofirst();
	
	//Cuerpo del reporte
	$MiTemplate->set_file("reportedetalle", TEMPLATE ."reportes/reporte_ventas_cliente_detalle.htm");
	$MiTemplate->set_block("reportedetalle", "reportedetalle_NOM", "reportedetalle_BLO");
	$contadorr = 0; 
	if (!$Listado->isvoid()) {
		do {
			++$contadorr;
			if ($contadorr > LIMITE_REPORTE_VENTASCLIENTES && !$contadorstat) {
				$contadorstat = $contadorr - 1; //No sigo parseando más datos
			}
			if (!$contadorstat) {
				$MiTemplate->set_var("valor1", (($Listado->getelem()->nomlocemi)?$Listado->getelem()->nomlocemi:'&nbsp;'));
				$MiTemplate->set_var("valor2", (($Listado->getelem()->nomloccsum)?$Listado->getelem()->nomloccsum:'&nbsp;'));
				$MiTemplate->set_var("valor111", (($Listado->getelem()->idcliente)?$Listado->getelem()->idcliente:'&nbsp;'));			
				$MiTemplate->set_var("valor112", (($Listado->getelem()->id_contribuyente == 2)?$Listado->getelem()->rutcliente.'-'.general::digiVer($Listado->getelem()->rutcliente) : $Listado->getelem()->rutcliente ));
				$MiTemplate->set_var("valor3", number_format($Listado->getelem()->total_neto));
				$MiTemplate->set_var("valor4", number_format($Listado->getelem()->totaliva));
				$MiTemplate->set_var("valor5", number_format($Listado->getelem()->totalnumiva));
				$totalvalor11 += $Listado->getelem()->total_neto;
				$totalvalor12 += $Listado->getelem()->totaliva;
				$totalvalor13 += $Listado->getelem()->totalnumiva;
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
	
}

/*FIN DESPLIEGUE*/
$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>