<?php

///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../ordenent/ordenent_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////
if ($_POST['accion'] == 'pagar' && $_POST['id_ordenent']) {
	global $ses_usr_id;
	
	if(!bizcve::verificacionDePermisos($ses_usr_id,81, 'INSERT')){
     	general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  }

	//Armo la lista de la orden ent
	//general::alert('pague: '.$_REQUEST['id_direccion']);
	$listaoe = new connlist($eldto = new dtopagooe(array('id_ordenent' => $_POST['id_ordenent'], 
													'id_tipodocpago' => $_POST['id_tipodocpago'],
													'numdocpago' => $_POST['numdocpago'], 
													'id_tipoflujo' => $_POST['id_tipofacturacion'],
													'id_direccion' => $_REQUEST['id_direccion'],
													'prioridadpick' => $_POST['id_priorpick']
													)));
	if (bizcve::putPagoOE($listaoe, $listaop =  new connlist))
	    general::inserta_tracking(null, $_POST['id_ordenent'], null, null, 'Se ha dado curso (pago) a la Orden de Entrega');

		global $ses_usr_id;
        $usr_nombre =general::get_nombre_usr( $ses_usr_id );
        bizcve::setevento(21, 'Ordenes de entrega', $_SERVER['REMOTE_ADDR'], 'Ordenes de entrega',
            'POS N° ”NUMERO_POS” pago orden de entrega '.$_POST['id_ordenent'].'','','Orden de entrega '.$_POST['id_ordenent'].' pagada', $usr_nombre );
	if ($listaop) 
		$listaop->gofirst();
		
	if ($listaop->numelem()==1) {
		general::returnvalue('reload');
		general::alertexit('Se ha generado la Orden de Picking Num. ' . $listaop->getelem()->id_ordenpicking);
	}
	elseif ($listaop->numelem()>1) {
		$coma = ''; 
		do {
			$msglop .= $coma . $listaop->getelem()->id_ordenpicking;
			$coma = ', '; 
		} while ($listaop->gonext()); 
		general::returnvalue('reload');
		general::alertexit("Se han generado las ordenes de Picking Num. $msglop");
	}
	else {
		general::returnvalue('reload');
		general::close();
	}
	exit();
}
//general::writeevent('sdgfsgdf');
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

/*$MiTemplate = new template;
/*Inclusion de header
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_var("TITULO", TITULO);
/* Inclusi?n de main
$MiTemplate->set_file("main", TEMPLATE . "ordenent/ordenent_01.htm");


if (!$_REQUEST['oe']) {
	general::alertexit('No viene id de Orden de Entrega. No puede continuar');
	exit();
}

/* OBTENEMOS DATOS DE LA ORDEN DE ENTREGA 
bizcve::getordenent($ListEnc = new connlist(new dtoencordenent(array('id_ordenent'=>$_REQUEST['oe']))), $ListDet = new connlist);
if (!$ListEnc->numelem()) {
	general::alertexit('No existe la Orden de Entrega. No puede continuar');
	exit();
}
$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
	bizcve::gettipopagoid($Listp = new connlist(new dtotipo(array('id_tipopago'=>$ListEnc->getelem()->id_tipopago))));
	$Listp->gofirst();
	$MiTemplate->set_var('tipopago',$Listp->getelem()->nombre);
		
	$MiTemplate->set_var('id_cotizacion', $ListEnc->getelem()->id_cotizacion);
	$MiTemplate->set_var('id_ordenent', $ListEnc->getelem()->id_ordenent);
	//$MiTemplate->set_var('nom_local', $ListEnc->getelem()->nom_local);		
	$MiTemplate->set_var('nota', $ListEnc->getelem()->nota);
	$MiTemplate->set_var('iva',$ListEnc->getelem()->iva);	
	$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);	
	$MiTemplate->set_var('giro', $ListEnc->getelem()->giro);
	$MiTemplate->set_var('direccion', $ListEnc->getelem()->direccion);
	$MiTemplate->set_var('nomcomuna', $ListEnc->getelem()->comuna);
	$MiTemplate->set_var('id_tipoentrega', $ListEnc->getelem()->id_tipoentrega);
	$MiTemplate->set_var('nomtipoentrega', $ListEnc->getelem()->nomtipoentrega);
	$MiTemplate->set_var('nota', $ListEnc->getelem()->nota);
	$MiTemplate->set_var('condicion', $ListEnc->getelem()->condicion);	
	$MiTemplate->set_var('despachodd', (($ListEnc->getelem()->id_tipoentrega==2||$ListEnc->getelem()->id_tipoentrega==3)?'true':'false'));
	$MiTemplate->set_var('disableddd', (($ListEnc->getelem()->id_tipoentrega==2||$ListEnc->getelem()->id_tipoentrega==3)?'':'disabled'));
	$MiTemplate->set_var('disablednp', (($ListEnc->getelem()->id_tipoflujo==2 || $ListEnc->getelem()->id_tipoflujo==3 || $ListEnc->getelem()->id_tipoflujo==4 )?'':'disabled'));
	$MiTemplate->set_var('id_tipopago', $ListEnc->getelem()->id_tipopago);
	
	$rut = $ListEnc->getelem()->rutcliente;
	$codigovendedor = $ListEnc->getelem()->codigovendedor;
	$localcsum = $ListEnc->getelem()->codlocalcsum;
	$estado = $ListEnc->getelem()->id_estado;
	$tipoentrega = $ListEnc->getelem()->id_tipoentrega;
	$tipopago = $ListEnc->getelem()->id_tipopago;
	
	if ($tipoentrega == 1) {
		$MiTemplate->set_var('disabledant', '');
		$MiTemplate->set_var('disabledpos', 'disabled');
		$MiTemplate->set_var('checkedant', 'checked');
		$MiTemplate->set_var('checkedpos', '');
		$MiTemplate->set_var('valtfant', '');	//Este valor ya viene seteado en la creacion de la OE
		$MiTemplate->set_var('valtfpos', '');	//Este valor ya viene seteado en la creacion de la OE
	}
	if ($tipoentrega == 2) {
		$MiTemplate->set_var('disabledant', '');
		$MiTemplate->set_var('disabledpos', ''); //VOLVER A HABILITAR CUANDO ESTE LISTA VENTA CALZADA
		//$MiTemplate->set_var('disabledpos', 'disabled'); //QUITAR CUANDO ESTE LISTA VENTA CALZADA
		$MiTemplate->set_var('checkedant', 'checked');
		$MiTemplate->set_var('checkedpos', '');
		$MiTemplate->set_var('valtfant', '3');
		$MiTemplate->set_var('valtfpos', '4');
	}
	if ($tipoentrega == 3) {
		$MiTemplate->set_var('disabledant', 'disabled');
		$MiTemplate->set_var('disabledpos', ''); //VOLVER A HABILITAR CUANDO ESTE LISTA VENTA CALZADA
		//$MiTemplate->set_var('disabledpos', 'disabled'); //QUITAR CUANDO ESTE LISTA VENTA CALZADA
		$MiTemplate->set_var('checkedant', '');
		$MiTemplate->set_var('checkedpos', 'checked');
		$MiTemplate->set_var('valtfant', '');	//Este valor ya viene seteado en la creacion de la OE
		$MiTemplate->set_var('valtfpos', '');	//Este valor ya viene seteado en la creacion de la OE
	}
	
}

/* OBTENEMOS DATOS DEL VENDEDOR 
bizcve::GetUsers($List = new connlist(new dtousuario(array('codigovendedor'=>$codigovendedor))));
$List->gofirst();
$MiTemplate->set_var('nombrevendedor', $List->getelem()->usr_nombres.' '.$List->getelem()->usr_apellidos);	

/* OBTENEMOS DATOS DEL CENTRO DE SUMINISTRO 
bizcve::getlocales($List = new connlist(new dtolocal(array('cod_local'=>$localcsum))));
$List->gofirst();
$MiTemplate->set_var('nom_local_csum', $List->getelem()->nom_local);		

/* OBTENEMOS LAS DIRECCIONES DE DESPACHO 
bizcve::getdirdesp($List = new connlist(new dtodireccion(array('rut'=>$rut))));
$List->gofirst();
$MiTemplate->set_block('main' , "dirdesp" , "BLO_dirdesp");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('id_direccion', $List->getelem()->id_direccion);
		$MiTemplate->set_var('nombre', $List->getelem()->descripcion." - ".$List->getelem()->direccion.", ".$List->getelem()->nomcomuna);
		$MiTemplate->set_var('selected', (($_REQUEST['dir'] == $List->getelem()->id_direccion)?'selected':''));
		$MiTemplate->parse("BLO_dirdesp", "dirdesp", true);	
	} while ($List->gonext());
}

/* OBTENEMOS DATOS DEL DETALLE DE LA ORDEN DE ENTREGA 
$ListDet->gofirst();
$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detalleproductos");
if (!$ListDet->isvoid()) {
	do {
		if($ListDet->getelem()->marcaflete==1){
			$MiTemplate->set_var('prioridad','class="fondoprioridad"');				
		}else{
			$MiTemplate->set_var('prioridad','');				
		}			
		$MiTemplate->set_var('id_linea', $ListDet->getelem()->id_linea);
		$MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
		$MiTemplate->set_var('id_tiporetiro', $ListDet->getelem()->id_tiporetiro);
		$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
		$MiTemplate->set_var('pventaneto', round($ListDet->getelem()->pventaneto));
		$MiTemplate->set_var('totallinea',$ListDet->getelem()->totallinea);
		$MiTemplate->set_var('pventanetof', number_format($ListDet->getelem()->pventaneto,2));
		$MiTemplate->set_var('totallineaf', number_format($ListDet->getelem()->totallinea));
		$MiTemplate->set_var('cantidad', number_format($ListDet->getelem()->cantidade, 2, '.', ''));
		$MiTemplate->set_var('unimed', $ListDet->getelem()->unimed);
		$MiTemplate->parse("BLO_detalleproductos", "detalleproductos", true);	
	} while ($ListDet->gonext());
}

/* OBTENEMOS INFORMACION DEL CLIENTE 
bizcve::getCliente($List = new connlist(new dtoinfocliente(array('rut'=>$rut))));
$List->gofirst();
if (!$List->isvoid()) {
    $MiTemplate->set_var('rut', $List->getelem()->rut);
    $MiTemplate->set_var('rutcliente', $List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut));	
    $MiTemplate->set_var('id_tipocliente', $List->getelem()->id_tipocliente);					
    $MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente);			
    $MiTemplate->set_var('contacto', $List->getelem()->contacto);					
    $MiTemplate->set_var('nomtipdocpago', $List->getelem()->nomtipdocpago);    
    $MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);		
    $MiTemplate->set_var('email', $List->getelem()->email);	
    $locksap = $List->getelem()->locksap;
    $lockmoro = $List->getelem()->lockmoro;
    $lockcve = $List->getelem()->lockcve;
    $lockfecha = $List->getelem()->lockfecha;
    $id_tipodocpago = $List->getelem()->id_tipodocpago;
    if($List->getelem()->locksap){
        $MiTemplate->set_var('locksap', '<li>Cliente bloqueado en SAP</li>');
    }
    if($List->getelem()->lockmoro){
        $MiTemplate->set_var('lockmoro', '<li>Cliente bloqueado por Morosidad</li>');
    }
    if($List->getelem()->lockcve){
        $MiTemplate->set_var('lockcve', '<li>Cliente Bloqueado en CVE</li>');
    }
    if($List->getelem()->lockfecha){
        $MiTemplate->set_var('lockfecha', '<li>Cliente Bloqueado por vencimiento de Disponible</li>');
    }
    if($List->getelem()->comentario){
        $MiTemplate->set_var('comentario', '<li>'.$List->getelem()->comentario.'</li>');
    }
}

/* OBTENEMOS LOS TIPOS DE DOCUMENTO DE PAGO 
bizcve::gettipodocpago($List = new connlist(new dtotipo(array('valor2'=>$tipopago))));
$List->gofirst();
$MiTemplate->set_block('main' , "detallepagos" , "BLO_detallepagos");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nombre', $List->getelem()->nombre);
		$MiTemplate->set_var('reqnumdoc', $List->getelem()->valor);
		$MiTemplate->set_var('selected', (($List->getelem()->id == $id_tipodocpago)?'selected':''));
		$MiTemplate->parse("BLO_detallepagos", "detallepagos", true);	
	} while ($List->gonext());
}

/* VALIDAMOS LAS CONDICIONES INVALIDANTES 
	//0.- OE EN ESTADO OA
		if ($estado != 'OA'){
			general::alertexit('La Orden de Entrega no posee estado adecuado');
			exit();
		}
	//1.- CLIENTE  BLOQUEADO (4 CRITERIOS)
		//if ($locksap || $lockmoro || $lockcve || $lockfecha){
			//general::alertexit('No se puede cursar la OE debido a que el cliente se encuentra bloqueado');
			//general::confirm('El cliente se encuentra bloqueado para venta crédito. Si continúa, sólo se podrá hacer venta CONTADO.\nDesea continuar de todas maneras?', '', 'window.close()');
			//exit();
		//}*/
	
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>