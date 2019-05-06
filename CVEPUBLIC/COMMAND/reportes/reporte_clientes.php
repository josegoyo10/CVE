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
$MiTemplate->set_file("main", TEMPLATE ."reportes/reporte_clientes.htm");

//Recuperamos y asignamos los parámetros de consulta
/*** Local ***/
	$List  = new connlist;
	bizcve::getlocales($List);
	$List->gofirst();
	//general::alert($_POST['local']);
	$MiTemplate->set_block('main' , "local" , "BLO_local");
	if (!$List->isvoid()) {
		do {
			$MiTemplate->set_var('codigo_local', $List->getelem()->cod_local);
			$MiTemplate->set_var('nombre_local', $List->getelem()->nom_local);		

			if($_POST['local']=='-1'){
			//general::alert('es: '.$_POST['local']);
				$MiTemplate->set_var('selected_1', 'selected');
			}
			elseif($_POST['local']=='-2'){
			//general::alert('es: '.$_POST['local']);
				$MiTemplate->set_var('selected_2', 'selected');
			}
			if($_POST['local']!='-1'&&$_POST['local']!='-2'){
	        	$MiTemplate->set_var('selected', ($_POST['local'] == $List->getelem()->cod_local)?'selected':'');
			}
			if(!$_POST['local']){
				$MiTemplate->set_var('selected', ($ses_usr_codlocal == $List->getelem()->cod_local)?'selected':'');
			}
			$MiTemplate->parse("BLO_local", "local", true);
		} while ($List->gonext());
	}
	//general::alert($_POST['local']);
	if(($_POST['local'])==-2){
		$codlocalemi=-2;	
	}
	if($_POST['local']==-1){
		$codlocalemi=-1;
	}else{
		$codlocalemi = ($_POST['local'])?$_POST['local']:$ses_usr_codlocal;
	}
	//$codlocalemi = ($_POST['local'])?$_POST['local']:'';

/*** Fecha de Inicio ***/
	$MiTemplate->set_var("fec_valid",$_REQUEST['fec_valid']);	
	$fecinicio = ($_REQUEST['fec_valid'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid']) . ' 00:00:00':null;
/*** Fecha de Término ***/
	$MiTemplate->set_var("fec_valid2",$_REQUEST['fec_valid2']);	
	$fectermino = ($_REQUEST['fec_valid2'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid2']) . ' 00:00:00':null;
/*** Nombre Cliente ***/
	$MiTemplate->set_var("nombrecliente",$_REQUEST['nombrecliente']);	
	$nombrecliente = $_REQUEST['nombrecliente'];
/*** Rut Cliente ***/
	$MiTemplate->set_var("rut",$_REQUEST['rut']);	
	$rut = $_REQUEST['rut'];
/*** Bloqueos ***/
	$bloqueo1 = $_REQUEST['check1'];
	$bloqueo2 = $_REQUEST['check2'];
	$bloqueo3 = $_REQUEST['check3'];
	if($bloqueo1 =='on'){
		$bloqueo1 = 1;
		$MiTemplate->set_var("checked1",'checked');			
	}
	if($bloqueo2 =='on'){
		$bloqueo2 = 1;	
		$MiTemplate->set_var("checked2",'checked');					
	}
	if($bloqueo3 =='on'){
		$bloqueo3 = 1;
		$MiTemplate->set_var("checked3",'checked');					
	}
/*** Rubro ***/
$List  = new connlist;
bizcve::getrubro($List);
$List->gofirst();

$MiTemplate->set_block('main' , "rubro" , "BLO_rubro");
if (!$List->isvoid()) {

	do {
		$MiTemplate->set_var('id_rubro', $List->getelem()->id);
		$MiTemplate->set_var('nombre_rubro', $List->getelem()->nombre);	
		$MiTemplate->set_var('selected_rubro', ($_POST['select_rubro'] == $List->getelem()->id)?'selected':'');
		$MiTemplate->parse("BLO_rubro", "rubro", true);     
       } while ($List->gonext());
}
$rubro = $_POST['select_rubro'];

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
/*** Estado ***/
$List  = new connlist;
$mRegistro=new dtoestado;
$mRegistro->tipo = 'OE';
$List->addlast($mRegistro);
bizcve::getestados($List);
$List->gofirst();
$MiTemplate->set_block('main' , "estado" , "BLO_estado");
		
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('id_estado', $List->getelem()->id_estado);			
		$MiTemplate->set_var('descripcion', $List->getelem()->descripcion);
		$MiTemplate->set_var('selectedb', ($_POST['select_estado'] == $List->getelem()->id_estado)?'selected':'');
		
		$MiTemplate->parse("BLO_estado", "estado", true);
	} while ($List->gonext());
}
$estado = $_POST['select_estado'];
	
//Mostramos el detalle del reporte
if ($_REQUEST['accion'] == 'ver') {
	//Ejecutamos la consulta
	$Listado  = new connlist;
	$mRegistro = new dtoreporte;
	if($codlocalemi!="-1"&&$codlocalemi!="-2"){
		$mRegistro->codlocalemi = $codlocalemi;
	}
	if($codlocalemi=="-2"){
		$mRegistro->codlocalemi = " ";
	}
	$mRegistro->fecinicio = $fecinicio;
	$mRegistro->fectermino = $fectermino;	
	$mRegistro->nombrecliente = $nombrecliente ;	
	$mRegistro->rutcliente = $rut;
	$mRegistro->tipo_cliente = $tipo_cliente;
	$mRegistro->estado = $estado;
	$mRegistro->bloqueo1 = $bloqueo1;
	$mRegistro->bloqueo2 = $bloqueo2;	
	$mRegistro->bloqueo3 = $bloqueo3;	
	$mRegistro->rubro = $rubro;		
	$Listado->addlast($mRegistro);
	bizcve::getreportecliente($Listado);
	$Listado->gofirst();
	
	//Cuerpo del reporte
	$MiTemplate->set_file("reportedetalle", TEMPLATE ."reportes/reporte_clientes_detalle.htm");
	$MiTemplate->set_block("reportedetalle", "reportedetalle_NOM", "reportedetalle_BLO");
	$arr_docpago = Array();
	$contadorr = 0;
	if (!$Listado->isvoid()) {
		do {
			//Obtengo el credito del cliente mediante el webservice
			$credito = ConsultarClienteOnline($Listado->getelem()->rutcliente);
			
			++$contadorr;
			if ($contadorr > LIMITE_REPORTE_CLIENTES && !$contadorstat) {
				$contadorstat = $contadorr - 1; //No sigo parseando más datos
			}
			if (!$contadorstat) {
				
				//Intento consultar los datos online del webservice
				$estado_bloqueo = '';
				$vencdisp = '&nbsp;';
				if ($credito != false) {
					$disponible = number_format($credito['limite_disponible']);
					$linea_credito = number_format($credito['limite_credito']);
					
			  		if ($credito['bloqueo_sap']) {
			    		if ($estado_bloqueo != '') $estado_bloqueo .= ', ';
			  			$estado_bloqueo .= 'Bloqueado en SAP';
			  		}
			  		if ($credito['bloqueo_moroso']) {
			    		if ($estado_bloqueo != '') $estado_bloqueo .= ', ';
			    		$estado_bloqueo .= 'Bloqueado por morosidad';
			  		}
					if ($Listado->getelem()->bloqueo3) {
						if ($estado_bloqueo != '') $estado_bloqueo .= ', ';
						$estado_bloqueo .= $Listado->getelem()->bloqueo3;
					}
			  		if ($Listado->getelem()->tipo_cliente == 'Cliente SAP' && strtotime($credito['fecha_vencimiento']) < time() ) {
			  			if ($estado_bloqueo != '') $estado_bloqueo .= ', ';
			  			$estado_bloqueo .= 'Bloqueado por disponible vencido';
			  		}
			  		$aux = explode('-', $credito['fecha_vencimiento']);
			  		$vencdisp = $aux[2].'-'.$aux[1].'-'.$aux[0];
				}
				else {
					//Traigo por defecto los datos de la db 
					$disponible = ($Listado->getelem()->disponible!==null) ? number_format($Listado->getelem()->disponible) : '&nbsp;';
					$linea_credito = (($Listado->getelem()->total_linea)?$Listado->getelem()->total_linea:'&nbsp;');
					
					if ($Listado->getelem()->bloqueo1) {
						if ($estado_bloqueo != '') $estado_bloqueo .= ', ';
						$estado_bloqueo .= $Listado->getelem()->bloqueo1;
					}					
					if ($Listado->getelem()->bloqueo2) {
						if ($estado_bloqueo != '') $estado_bloqueo .= ', ';
						$estado_bloqueo .= $Listado->getelem()->bloqueo2;
					}					
					if ($Listado->getelem()->bloqueo3) {
						if ($estado_bloqueo != '') $estado_bloqueo .= ', ';
						$estado_bloqueo .= $Listado->getelem()->bloqueo3;
					}					
					if ($Listado->getelem()->bloqueodisp) {
						if ($estado_bloqueo != '') $estado_bloqueo .= ', ';
						$estado_bloqueo .= $Listado->getelem()->bloqueodisp;
					}
					if($Listado->getelem()->fecinicio) {
						$vencdisp = $Listado->getelem()->fecinicio;
					}
				}
				if ($estado_bloqueo == '') {
					$estado_bloqueo .= 'Saldo Disponible';
				}
				
				$MiTemplate->set_var("valor2", (($Listado->getelem()->id_contribuyente == 2)?$Listado->getelem()->rutcliente.'-'.general::digiVer($Listado->getelem()->rutcliente) : $Listado->getelem()->rutcliente ));
				$MiTemplate->set_var("valor3", (($Listado->getelem()->nombrecliente)?$Listado->getelem()->nombrecliente:'&nbsp;'));
				$MiTemplate->set_var("valor4", (($Listado->getelem()->tipo_cliente)?$Listado->getelem()->tipo_cliente:'&nbsp;'));
				$MiTemplate->set_var("valor5", $estado_bloqueo);
				$MiTemplate->set_var("valor5_6", $linea_credito);				
				$MiTemplate->set_var("valor6", $disponible);
				$MiTemplate->set_var("valor7", $vencdisp);
				$MiTemplate->set_var("valor8", (($Listado->getelem()->nomvendedor)?$Listado->getelem()->nomvendedor:'&nbsp;'));
				$MiTemplate->set_var("valor9", (($Listado->getelem()->condicion_pago)?$Listado->getelem()->condicion_pago:'&nbsp;'));
				$MiTemplate->set_var("valor10", (($Listado->getelem()->rubro)?$Listado->getelem()->rubro:'&nbsp;'));
				$MiTemplate->set_var("valor11", (($Listado->getelem()->nomlocemi)?$Listado->getelem()->nomlocemi:'&nbsp;'));
				
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