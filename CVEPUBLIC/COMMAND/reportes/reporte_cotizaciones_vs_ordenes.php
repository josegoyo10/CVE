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
$MiTemplate->set_file("main", TEMPLATE ."reportes/reporte_cotizaciones_vs_ordenes.html");

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
			//if ($_POST['local'])
	        	$MiTemplate->set_var('selected', ($_POST['local'] == $List->getelem()->cod_local)?'selected':' ');
			//else
				//$MiTemplate->set_var('selected', ($ses_usr_codlocal == $List->getelem()->cod_local)?'selected':'');
			$MiTemplate->parse("BLO_local", "local", true);
		} while ($List->gonext());
	}
	$codlocalemi = ($_POST['local'])?$_POST['local']:"";
/*** Fecha de Inicio ***/
	$MiTemplate->set_var("fec_valid",$_REQUEST['fec_valid']);	
	$fecinicio = ($_REQUEST['fec_valid'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid']) . ' 00:00:00':null;
/*** Fecha de Termino ***/
	$MiTemplate->set_var("fec_valid2",$_REQUEST['fec_valid2']);	
	$fectermino = ($_REQUEST['fec_valid2'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid2']) . ' 00:00:00':null;
/*** Codigo Venta ***/
	$MiTemplate->set_var("codventa",$_REQUEST['codventa']);	
	$codventa = $_REQUEST['codventa'];
/*** Seleccione usuario ***/
$List = new connlist;
$mRegistro= new dtousuario;
//$mRegistro->usr_tipo='VE';
//$mRegistro->id_tipousuario='1,2,3,4';
$mRegistro->id_tipousuario='2';
//if ($_POST['local'])
if($_POST['local']==TIENDA_VIRTUAL_ID){
	$mRegistro->cod_local = '';
}
else{
	$mRegistro->cod_local = $_POST['local'];
}
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
$codusuario = $_POST['select_usuario'];
/*Fin Seleccion usuario*/

//Mostramos el detalle del reporte
if ($_REQUEST['accion'] == 'ver') {
	//Ejecutamos la consulta
	$Listado  = new connlist;
	$mRegistro = new dtoreporte;
	if($codlocalemi){
		$mRegistro->codlocalemi = $codlocalemi;	
	}
	$mRegistro->fecinicio = $fecinicio;
	$mRegistro->fectermino = $fectermino;
	$mRegistro->codvendedor = $codusuario;
	$Listado->addlast($mRegistro);
	bizcve::getreportevendedor($Listado);
	$Listado->gofirst();
	
	//Cuerpo del reporte
	$MiTemplate->set_file("reportedetalle", TEMPLATE ."reportes/reporte_cotizaciones_vs_ordenes_detalle.html");
	$MiTemplate->set_block("reportedetalle", "reportedetalle_NOM", "reportedetalle_BLO"); 
	$arr_docpago = Array();
	$contadorr = 0; 
	if (!$Listado->isvoid()) {
		do {
			++$contadorr;
			if ($contadorr > LIMITE_REPORTE_VENTASVENDEDOR && !$contadorstat) {
				$contadorstat = $contadorr - 1; //No sigo parseando más datos
			}
			if (!$contadorstat) {
					$arreglomes[$contadorr - 1]=$Listado->getelem()->codventa;
					if(!$_POST['select_usuario']){
					$MiTemplate->set_var("valor2","TODOS");
					}
					else{
					$MiTemplate->set_var("valor2", (($Listado->getelem()->nomvendedor)?$Listado->getelem()->nomvendedor:'&nbsp;'));
					}
					if(!$_POST['local']){
					$MiTemplate->set_var("valor1","TODOS");
					}
					else{
					$MiTemplate->set_var("valor1", (($Listado->getelem()->nomlocemi)?$Listado->getelem()->nomlocemi:'&nbsp;'));	
					}				
					$MiTemplate->set_var("valor3", (($Listado->getelem()->codventa)?$Listado->getelem()->codventa:'&nbsp;'));
					$MiTemplate->set_var("valor7", number_format($Listado->getelem()->margenpromedio,2));
					$MiTemplate->set_var("valor8", number_format($Listado->getelem()->contribucion));
					$MiTemplate->set_var("valor14", number_format($Listado->getelem()->margenpromedio+0));
					$totalvalor14 += $Listado->getelem()->margenpromedio;			
					$MiTemplate->set_var("valor15", number_format($Listado->getelem()->contribucion+0));
					$totalvalor15 += $Listado->getelem()->contribucion;					
			
				$MiTemplate->parse("reportedetalle_BLO", "reportedetalle_NOM", true);
			}
		} while ($Listado->gonext());
	}
	if ($contadorstat) {
		$MiTemplate->set_var("mensajelimite", "S&oacute;lo se muestran los primeros $contadorstat registros de un total de $contadorr");
	}
	$MiTemplate->set_var("graficar", '<table border="0" cellpadding="0" cellspacing="0" width = "100%">
	<tr><td align="center"><img src="barlinealphaex1.php?localpos={localpos}&codusupos={codusupos}&finipos={finipos}&ffinpos={ffinpos}"><br></td></tr></table>');
	$MiTemplate->set_var('localpos', $codlocalemi); 
	$MiTemplate->set_var('finipos', $fecinicio);
	$MiTemplate->set_var('ffinpos', $fectermino);
	$MiTemplate->set_var('codusupos', $codusuario);
		if (!$contadorr) {
		$MiTemplate->set_var("graficar","");
		$MiTemplate->set_var("mensajelimite", "No se han encontrado registros para la consulta");
	}	
	//Pie de página del reporte
	$arreglomes= urlencode(serialize($arreglomes));
	$MiTemplate->set_var("arreglomes",$arreglomes);
	if($contadorr!=0){
	$MiTemplate->set_var("totalvalor14",number_format(($totalvalor14/$contadorr),2));			
	}else
	$MiTemplate->set_var("totalvalor14",0);	
	$MiTemplate->set_var("totalvalor15",number_format($totalvalor15));	
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