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
$MiTemplate->set_file("main", TEMPLATE ."reportes/reporte_desbloqueos_cotizaciones.htm");

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
	$codlocalemi = ($_POST['local'])?$_POST['local']:" ";
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
	$codlocalcsum = ($_POST['localcsum'])?$_POST['localcsum']:" ";
	if($codlocalcsum==" "||$codlocalcsum==-3){
	$codlocalcsum=0;
	}
/*** Fecha Inicio creacion ***/
	$MiTemplate->set_var("fec_valid",$_REQUEST['fec_valid']);	
	$feccreacion = ($_REQUEST['fec_valid'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid']) . ' 00:00:00':null;
/*** Fecha Termino creacion ***/
	$MiTemplate->set_var("fec_valid2",$_REQUEST['fec_valid2']);	
	$feccreacion2 = ($_REQUEST['fec_valid2'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid2']) . ' 00:00:00':null;
/*** Tipo Venta ***/
	$MiTemplate->set_var("cotizacion",$_REQUEST['cotizacion']);	
	$cotizacion = $_REQUEST['cotizacion'];
/*** CC/NIT/RUT ***/
	$MiTemplate->set_var("rutcliente",$_REQUEST['rutcliente']);	
	$rutcliente= $_REQUEST['rutcliente'];
/*** Razon Social ***/
	$MiTemplate->set_var("razonsoc",$_REQUEST['razonsoc']);	
	$razonsoc = $_REQUEST['razonsoc'];
	 						
	 $MiTemplate->set_var("pagina",$pagina);
	 $paginareq = $_REQUEST['page'];
/*** Estado ***/

$List  = new connlist;
$mRegistro=new dtoestado;
$mRegistro->tipo = 'CO';
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
$estado = $_POST['select_estado'];




$motivoblo = $_POST['motivoblo'];

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
/*** Fecha de Inicio vencimiento***/
	$MiTemplate->set_var("fec_valid3",$_REQUEST['fec_valid3']);	
	$fechadesbloqueo1 = ($_REQUEST['fec_valid3'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid3']) . ' 00:00:00':null;
/*** Fecha de Termino vencimiento***/
	$MiTemplate->set_var("fec_valid4",$_REQUEST['fec_valid4']);	
	$fechadesbloqueo2 = ($_REQUEST['fec_valid4'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid4']) . ' 00:00:00':null;
//Mostramos el detalle del reporte
if ($_REQUEST['accion'] == 'ver') {
	//Ejecutamos la consulta

	$Listado  = new connlist;
	$mRegistro = new dtoreporte;
	
	//$mRegistro->codlocalcsum = $codlocalcsum;
	$mRegistro->fecinicio = $feccreacion;
	$mRegistro->fectermino = $feccreacion2;
	$mRegistro->fechadesbloqueo1 = $fechadesbloqueo1;
	$mRegistro->fechadesbloqueo2 = $fechadesbloqueo2;
		
	$mRegistro->tipo_venta = $tipo_venta;
	$mRegistro->estado = $estado;
	$mRegistro->razonsoc = $razonsoc;	
	$mRegistro->rutcliente = $rutcliente;	
	$mRegistro->cotizacion = $cotizacion;
	

	if($motivoblo == 9999){
	$motivoblo="";
	}else{
		if(strpos ($motivoblo, "tiendas")){    		
		$MiTemplate->set_var("selectedt2", "selected");	
		}elseif(strpos ($motivoblo, "especiales")){		
		$MiTemplate->set_var("selectedt3", "selected");	
		}elseif(strpos ($motivoblo, "autorizados")){	
		$MiTemplate->set_var("selectedt4", "selected");	
		}elseif(strpos ($motivoblo, "Portafolios")){	
		$MiTemplate->set_var("selectedt5", "selected"); 
		}elseif(strpos ($motivoblo, "precios")){		
		$MiTemplate->set_var("selectedt6", "selected");	
		}
	}
	
	
	
	$mRegistro->motivodesbloqueo = $motivoblo;
	
	
	if($codlocalemi!=''){
		$mRegistro->codlocalemi = $codlocalemi;	
	}
	if($codlocalcsum!=''){
		$mRegistro->codlocalcsum = $codlocalcsum;	
	}
		
	$Listado->addlast($mRegistro);

	bizcve::getreportedesbloqueoscotizacion($Listado);

	$Listado->gofirst();
	
	//Cuerpo del reporte
	$MiTemplate->set_file("reportedetalle", TEMPLATE ."reportes/reporte_desbloqueos_cotizacion_detalle.htm");
	$MiTemplate->set_block("reportedetalle", "reportedetalle_NOM", "reportedetalle_BLO");
	$arr_docpago = Array();
	$contadorr = 1; 
	if (!$Listado->isvoid()) {
	
						$cantReg=0;
						do {
							$cantReg++;
						} while ($Listado->gonext());
						$Listado->gofirst();
						
						$cantPag = $cantReg / 30;
						if ($cantPag > (int)$cantPag) { 
							$cantPag = (int)$cantPag + 1;
						}
						$pagina = $_REQUEST['page'];
						if ((!($pagina)) || ($pagina == '0')) {
							$pagina = 1;
						}else{
							$pagina = $paginareq;
						} 

						$MiTemplate->set_block("reportedetalle", "paginador_NOM", "paginador_BLO");
						for ($x=1;$x<=$cantPag;$x++) {
							$MiTemplate->set_var('codigo_pagina', $x);
							if ($pagina == $x) {
								$MiTemplate->set_var('selectedPag', 'selected');
							} else {
								$MiTemplate->set_var('selectedPag', '');
							}
							$MiTemplate->parse("paginador_BLO", "paginador_NOM", true);
						}
		do {			
		 	if ($contadorr >= (($pagina-1)*30) && $contadorr <= ((($pagina-1)*30)+30)) { 
				$MiTemplate->set_var("valor1", (($Listado->getelem()->cotizacion)?$Listado->getelem()->cotizacion:'&nbsp;'));
				$MiTemplate->set_var("valor2", (($Listado->getelem()->fecinicio)?$Listado->getelem()->fecinicio:'&nbsp;'));
				$MiTemplate->set_var("valor3", (($Listado->getelem()->estado)?$Listado->getelem()->estado:'&nbsp;'));
				$MiTemplate->set_var("valor4", (($Listado->getelem()->id_contribuyente == 2)?$Listado->getelem()->rutcliente.'-'.general::digiVer($Listado->getelem()->rutcliente) : $Listado->getelem()->rutcliente ));
				$MiTemplate->set_var("valor5", (($Listado->getelem()->razonsoc)?$Listado->getelem()->razonsoc:'&nbsp;'));
				$MiTemplate->set_var("valor6", (($Listado->getelem()->nomlocemi)?$Listado->getelem()->nomlocemi:'&nbsp;'));
				$MiTemplate->set_var("valor7", $Listado->getelem()->apellidoynombre); 
				$MiTemplate->set_var("valor8", $Listado->getelem()->codigovendedor);
				$MiTemplate->set_var("valor9",  '$' . general::formato_precio($Listado->getelem()->total_neto));
				$MiTemplate->set_var("valor10", $Listado->getelem()->margenpromedio+0);			
				$MiTemplate->set_var("valor11", $Listado->getelem()->fechadesbloqueo);
				$MiTemplate->set_var("valor12", $Listado->getelem()->motivodesbloqueo);	
                                $MiTemplate->set_var("valor13", (($Listado->getelem()->comentariodesbloqueo)?$Listado->getelem()->comentariodesbloqueo:'&nbsp;'));
                                $MiTemplate->set_var("valor14",(($Listado->getelem()->Usuario)?$Listado->getelem()->Usuario:'&nbsp;'));//Mantis 27363
                                
				$MiTemplate->parse("reportedetalle_BLO", "reportedetalle_NOM", true);		
			} $contadorr++;
		
		} while ($Listado->gonext());
	}
	if ($contadorstat) {
		$MiTemplate->set_var("mensajelimite", "S&oacute;lo se muestran los primeros $contadorstat registros de un total de $contadorr");
	}
	if (!$contadorr) {
		$MiTemplate->set_var("mensajelimite", "No se han encontrado registros para la consulta");
	}
	

}

if ($_REQUEST['accion'] == 'Excel') {
        //Ejecutamos la consulta
        $Listado  = new connlist;
        $mRegistro = new dtoreporte;
        //$mRegistro->codlocalcsum = $codlocalcsum;
       $mRegistro->fecinicio = $feccreacion;
	$mRegistro->fectermino = $feccreacion2;
	$mRegistro->fechadesbloqueo1 = $fechadesbloqueo1;
	$mRegistro->fechadesbloqueo2 = $fechadesbloqueo2;
		
	$mRegistro->tipo_venta = $tipo_venta;
	$mRegistro->estado = $estado;
	$mRegistro->razonsoc = $razonsoc;	
	$mRegistro->rutcliente = $rutcliente;	
	$mRegistro->cotizacion = $cotizacion;
	
	
	if($motivoblo == 9999){
	$motivoblo="";
	}
	$mRegistro->motivodesbloqueo = $motivoblo;
	

	if($codlocalemi!=''){
			$mRegistro->codlocalemi = $codlocalemi;	
	}
	if($codlocalcsum!=''){
			$mRegistro->codlocalcsum = $codlocalcsum;	
	}
	
	$Listado->addlast($mRegistro);
                        
	bizcve::reportedesbloqueocotizacionesEX($Listado);
		
}

/*FIN DESPLIEGUE*/
$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>