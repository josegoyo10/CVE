<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
//$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
//////////////////////////ACCCIONES///////////////////////////////////


///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_file("main", TEMPLATE ."reportes/reporte_ventas_clientes.htm");

/*** Local ***/
$List  = new connlist;
bizcve::getlocales($List);
$List->gofirst();
$MiTemplate->set_block('main' , "local" , "BLO_local");
if (!$List->isvoid()) {
	do {
			$MiTemplate->set_var('codigo_local', $List->getelem()->cod_local);
			$MiTemplate->set_var('nombre_local', $List->getelem()->nom_local);
			$MiTemplate->set_var('selectedlocal', ($_REQUEST['local'] == $List->getelem()->cod_local)?'selected':'');
			$MiTemplate->parse("BLO_local", "local", true);
		} while ($List->gonext());
	}
$codlocalemi = $_REQUEST['local'];
	
/*** Fecha de Inicio ***/
	$MiTemplate->set_var("fec_valid",$_REQUEST['fec_valid']);	
	$fecinicio = ($_REQUEST['fec_valid'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid']):'';
/*** Fecha de Termino ***/
	$MiTemplate->set_var("fec_valid2",$_REQUEST['fec_valid2']);	
	$fectermino = ($_REQUEST['fec_valid2'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid2']):'';
	

//////////////////usuarios//////////////////////
$Listusuario  = new connlist;
$mRegistrousu= new dtousuario;
$mRegistrousu->id_tipousuario='2';
$mRegistrousu->usr_tipo='VE';
$Listusuario->addlast($mRegistrousu);
bizcve::GetUsers($Listusuario);
$Listusuario->gofirst();
if (!$Listusuario->isvoid()) {
$MiTemplate->set_block('main' , "datosusr" , "BLO_datosusr");
	do {
		$MiTemplate->set_var('nombre_vendedor', $Listusuario->getelem()->usr_nombres.' '.$Listusuario->getelem()->usr_apellidos);
		$MiTemplate->set_var('codigo_vendedor', $Listusuario->getelem()->codigovendedor);
		$MiTemplate->set_var('selectedvendedor', ($_REQUEST['vendedor'] == $Listusuario->getelem()->codigovendedor)?'selected':'');
		$MiTemplate->parse("BLO_datosusr", "datosusr", true);	
	} while ($Listusuario->gonext());
}
$codvenusr = $_REQUEST['vendedor'];


/*** Nombre ***/
	$MiTemplate->set_var("nomcliente",$_REQUEST['nomcliente']);	
	$nomcliente = $_REQUEST['nomcliente'];
	
/*** Rut Cliente ***/
	$MiTemplate->set_var("rut",$_REQUEST['rut']);	
	$rut = $_REQUEST['rut'];

//////////////////contribuyente//////////////////////
$Listcontri  = new connlist;
bizcve::gettipocontribuyente($Listcontri);
$Listcontri->gofirst();
if (!$Listcontri->isvoid()) {
$MiTemplate->set_block('main' , "contri" , "BLO_contri");
	do {
		$MiTemplate->set_var('nombrecontri', $Listcontri->getelem()->nombre);
		$MiTemplate->set_var('id', $Listcontri->getelem()->id);
		$MiTemplate->parse("BLO_contri", "contri", true);	
	} while ($Listcontri->gonext());
}
$tipo_cliente = $_REQUEST['tipo_cliente'];

//Mostramos el detalle del reporte
if ($_REQUEST['accion'] == 'ver') {
	
	$fecterminosiste=date('Y-m-d', strtotime($fecinicio."+31 days"));
	 
	$Listado  = new connlist;
	$mRegistro = new dtoreporte;	
	
if($fecinicio=='' && $fectermino==''){
	$fectermino=date('Y-m-d');
	$fecinicio=date('Y-m-d', strtotime($fectermino."-31 days"));
}
if($fectermino=='' && $fecinicio!=''){

$fectermino=$fecterminosiste;

}
else{
	$fectermino1=explode("-",$fectermino);
	$anov=$fectermino1[0];
	$mesv=$fectermino1[1];
	$diav=$fectermino1[2];
	
	$fecterminosiste1=explode("-",$fecterminosiste);
	$ano=$fecterminosiste1[0];
	$mes=$fecterminosiste1[1];
	$dia=$fecterminosiste1[2];
	
	//general::writeevent('La cotización número fecha termino  dia'.$diav.'mes'.$mesv.' año'.$anov.' fecha calculada sistema dia'.$dia.'mes'.$mes.' año'.$ano);
	if($anov >=$ano  && $mesv >= $mes && $diav > $dia){
	
		$fectermino=$fecterminosiste;
		$MiTemplate->set_var("fec_valid2",$dia.'/'.$mes.'/'.$ano);
		general::alert('El reporte se genera con un maximo de 31 dias, nueva fecha fin '.$dia.'/'.$mes.'/'.$ano);
		
	}
	
}
	$mRegistro->fecinicio = $fecinicio;
	$mRegistro->fectermino = $fectermino;
	$mRegistro->tipo_cliente = $tipo_cliente;	
	$mRegistro->rutcliente = $rut;		
	$mRegistro->razonsoc = $nomcliente;		
	$mRegistro->codlocalemi = $codlocalemi;
	$mRegistro->codigovendedor = $codvenusr;		
	$Listado->addlast($mRegistro);
	bizcve::getventascliente($Listado);
	$Listado->gofirst();
	
if ($_REQUEST['accionexport'] == 'exportar') {

header('Location: archivoexcel.php?fecinicio='.$fecinicio.'&fectermino='.$fectermino.'&tipo_cliente='.$tipo_cliente.'&rut='.$rut.'&nomcliente='.$nomcliente.'&codvenusr='.$codvenusr.'&codlocalemi='.$codlocalemi);

}
///cantidad de usuarios con codigo 000///
$listusuadm  = new connlist;
$mRegistro3  = new dtousuario;
$mRegistro3->id='000';
$listusuadm->addlast($mRegistro3);
bizcve::getcountuser($listusuadm);
$listusuadm->gofirst();

$configclitipo = new getidcontribuyente("CONTRIBUYENTE");
$opcion=$configclitipo->JURIDICO;
$opcion1=$configclitipo->EMPRESARIAL;	
	//Cuerpo del reporte
	$MiTemplate->set_file("reportedetalle", TEMPLATE ."reportes/reporte_ventas_cliente_detalle.htm");
	$MiTemplate->set_block("reportedetalle", "reportedetalle_NOM", "reportedetalle_BLO");
	$contadorr = 0;
	
	if (!$Listado->isvoid()) {
		do {
			
			++$contadorr;
			if ($contadorr > LIMITE_REPORTE_VENTASCLIENTES) {
				$contadorstat = 'MAXLIMIT';
				 //No sigo parseando mÃ¡s datos
			}
			else{
				
				$MiTemplate->set_var("fechapago",general::formato_fecha($Listado->getelem()->fecinicio));
				$MiTemplate->set_var("tienda",$Listado->getelem()->nomlocemi);
				$MiTemplate->set_var("rut",(($Listado->getelem()->tipo_cliente == $opcion1)?$Listado->getelem()->rutcliente.'-'.general::digiVer($Listado->getelem()->rutcliente) : $Listado->getelem()->rutcliente ));			
				$MiTemplate->set_var("nomcli",$Listado->getelem()->idcliente);
				$MiTemplate->set_var("oentrega",$Listado->getelem()->numdocpago);
				$MiTemplate->set_var("nfactura",(!$Listado->getelem()->numdocumento?'&nbsp;':$Listado->getelem()->numdocumento));
				$MiTemplate->set_var("vendedor",($Listado->getelem()->nomvendedor==' '?'VENTA NO ASIGNADA':$Listado->getelem()->nomvendedor));
				$MiTemplate->set_var("margen",number_format($Listado->getelem()->totalmargen,2));
				$MiTemplate->set_var("tentrega",$Listado->getelem()->tipo_entrega);
				$MiTemplate->set_var("estado" ,$Listado->getelem()->estado);
				//$MiTemplate->set_var("descuento", ($Listado->getelem()->codvendedor=='000'?number_format($Listado->getelem()->neto_fct/$listusuadm->getelem()->id):number_format($Listado->getelem()->neto_fct)));
				$MiTemplate->set_var("descuento", number_format($Listado->getelem()->neto_fct));
				$MiTemplate->set_var("total", number_format($Listado->getelem()->total_venta));
				$totalvalor11 += $Listado->getelem()->total_venta;
				//$totalvalor12 += ($Listado->getelem()->codvendedor=='000'?($Listado->getelem()->neto_fct/$listusuadm->getelem()->id):$Listado->getelem()->neto_fct);
				$totalvalor12 += $Listado->getelem()->neto_fct;
				$MiTemplate->parse("reportedetalle_BLO", "reportedetalle_NOM", true);
			}
		} while ($Listado->gonext());
	}
	if ($contadorstat == 'MAXLIMIT') {
		$MiTemplate->set_var("mensajelimite", "S&oacute;lo se muestran los primeros ".LIMITE_REPORTE_VENTASCLIENTES." registros de un total de $contadorr");
	}
	if ($contadorr==0) {
		$MiTemplate->set_var("mensajelimite", "No se han encontrado registros para la consulta");
	}
	else
	{$MiTemplate->set_var("botonexportar",'<input type="button" name="expor" value="Exportar Excel" class="Textonormal" onClick="exportar()">');}
	
	//Pie de pÃ¡gina del reporte
	$MiTemplate->set_var("exportarajax",$exportarexcel);
	$MiTemplate->set_var("totalvalor11",number_format($totalvalor11));
	$MiTemplate->set_var("totalvalor12",number_format($totalvalor12));
	

	
}

/*FIN DESPLIEGUE*/
$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>