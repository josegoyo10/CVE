<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_file("main", TEMPLATE ."reportes/reporte_margen_minimo.htm");

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
/*** Codigo SAP ***/
	$MiTemplate->set_var("codsap",$_REQUEST['codsap']);	
	$codsap = $_REQUEST['codsap'];
/*** Cotizacion ***/
	$MiTemplate->set_var("cotizacion",$_REQUEST['cotizacion']);	
	$cotizacion = $_REQUEST['cotizacion'];	
/*** Margen Límite ***/
	$MiTemplate->set_var("margen_limite",$_REQUEST['margen_limite']);	
	$margen_limite = $_REQUEST['margen_limite'];
	
/*** Seleccione usuario ***/
$List = new connlist;
$mRegistro= new dtousuario;
$mRegistro->id_tipousuario='2';
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
		$MiTemplate->set_var('codigousuario',$List->getelem()->login);
		$MiTemplate->set_var('nomusuario',$List->getelem()->usr_nombres." ".$List->getelem()->usr_apellidos);
		$MiTemplate->set_var('selecteda', ($_POST['select_usuario']==$List->getelem()->login)?'selected':'');
		
		$MiTemplate->parse("BLO_usuario", "usuario", true);
	} while ($List->gonext());
}
$codusuario = $_POST['select_usuario'];
/*Fin Seleccion usuario*/


//Mostramos el detalle del reporte
if ($_REQUEST['accion'] == 'ver') {
	//Ejecutamos la consulta
	$Listado  = new connlist;
	$mRegistro = new dtoreporte;
	$mRegistro->codlocalemi = $codlocalemi;
	$mRegistro->usuario = $codusuario;
	$mRegistro->fecinicio = $fecinicio;
	$mRegistro->fectermino = $fectermino;
	$mRegistro->codsap = $codsap;
	$mRegistro->cotizacion = $cotizacion;	
	$mRegistro->margen_limite = $margen_limite;		
	$Listado->addlast($mRegistro);
	bizcve::getreportemargen($Listado);
	$Listado->gofirst();
	
	//Cuerpo del reporte
	$MiTemplate->set_file("reportedetalle", TEMPLATE ."reportes/reporte_margen_minimo_detalle.htm");
	$MiTemplate->set_block("reportedetalle", "reportedetalle_NOM", "reportedetalle_BLO");
	$arr_docpago = Array();
	$contadorr = 0; 
	if (!$Listado->isvoid()) {
		do {
			++$contadorr;
			if ($contadorr > LIMITE_REPORTE_MGMIN && !$contadorstat) {
				$contadorstat = $contadorr - 1; //No sigo parseando más datos
			}
			if (!$contadorstat) {
				$MiTemplate->set_var("valor1", $Listado->getelem()->codlocalemi);
				$MiTemplate->set_var("valor2", $Listado->getelem()->usuario);
				$MiTemplate->set_var("valor3", $Listado->getelem()->fechadocumento);
				$MiTemplate->set_var("valor4", $Listado->getelem()->cotizacion);
				$MiTemplate->set_var("valor5", $Listado->getelem()->tipo_venta);
				$MiTemplate->set_var("valor6", $Listado->getelem()->codsap);
				$MiTemplate->set_var("valor7", $Listado->getelem()->descripcion);
				$MiTemplate->set_var("valor8", $Listado->getelem()->cantidad);
				$MiTemplate->set_var("valor9", $Listado->getelem()->margenpromedio);
				$MiTemplate->set_var("valor10", number_format($Listado->getelem()->costo_unitario));
				$MiTemplate->set_var("valor11", number_format($Listado->getelem()->precioventa_unitario));			
				$MiTemplate->set_var("valor12", number_format($Listado->getelem()->total_venta));
				$MiTemplate->parse("reportedetalle_BLO", "reportedetalle_NOM", true);
			}
		} while ($Listado->gonext());
	}
	if ($contadorr) {
		$MiTemplate->set_var("mensajelimite", "Se muestran los primeros $contadorr registros.");
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