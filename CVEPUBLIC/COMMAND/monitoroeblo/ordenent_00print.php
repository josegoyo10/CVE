<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
//$pag_ini = '../monitor_oe_blo.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////

if ($_POST['accion'] == 'rechazar') {

  

	$listoe = new connlist;
	$irechazo = new dtoencordenent;
	$irechazo->obsdesb 	  =$_POST['razon'];
	$irechazo->id_ordenent=$_POST['id_ordenent'];	
	$listoe->addlast($irechazo);
  
  // Chequeo que tenga el permiso desbloquear_oe_bloqueada_manualmente o desbloquear_oe_bloqueada_automaticamente segun el tipo de la OE 
  bizcve::getordenent($listoe, $Listdet = new connlist());  
  if ( $listoe->getelem()->id_estado == 'OM' )
  {
      $strFuncionalidad="desbloquear_oe_bloqueada_manualmente";
  }
  else
  {   
      $strFuncionalidad="desbloquear_oe_bloqueada_automaticamente";
  }  
  if ( !bizcve::tienepermisodefuncionalidad($strFuncionalidad) )
  {
      general::alert("No tiene la funcionalidad ".$strFuncionalidad." asignada para poder rechazar esta OE.");   
  }  
  else
  {
  	if (bizcve::rechazaroe($listoe)){	
  		general::writeevent('La orden de entrega numero '.$_POST['id_ordenent'].' ha sido rechazada por la siguiente razon: '.$_POST['razon']);
  		/*Insercion de tracking*/
  		general::inserta_tracking(null, $_POST['id_ordenent'], null, null, 'Detalle : la orden de entrega numero '.$_POST['id_ordenent'].' ha sido rechazada por la siguiente razon: '.$_POST['razon']);
  		bizcve::ActualizaCantNVEOE($Listdet, '-');
  		?>
  		<script language="JavaScript">
  		window.returnValue='reload';
  		window.close();
  		</script>
  		<?
  	}
  }
}

if ($_POST['accion'] == 'autorizar') {

global $ses_usr_id;

		if(!bizcve::verificacionDePermisos($ses_usr_id,84, 'UPDATE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }
	
	$listoe = new connlist;
	$iautorizo = new dtoencordenent;
	$iautorizo->obsdesb 	  =$_POST['razon'];
	$iautorizo->id_ordenent   =$_POST['id_ordenent'];
	$iautorizo->condicion   =$_REQUEST['condicion'];	
	$iautorizo->diascondicion   =$_REQUEST['condpagodias'];	
	
	$listoe->addlast($iautorizo);
  
  // Chequeo que tenga el permiso desbloquear_oe_bloqueada_manualmente o desbloquear_oe_bloqueada_automaticamente segun el tipo de la OE  
  bizcve::getordenent($listoe, $Listdet = new connlist());  
  if ( $listoe->getelem()->id_estado == 'OM' )
  {
      $strFuncionalidad="desbloquear_oe_bloqueada_manualmente";
  }
  else
  {   
      $strFuncionalidad="desbloquear_oe_bloqueada_automaticamente";
  }  
  if ( !bizcve::tienepermisodefuncionalidad($strFuncionalidad) )
  {
      general::alert("No tiene la funcionalidad ".$strFuncionalidad." asignada para poder autorizar esta OE.");   
  } 
  else
  {       
  	if (bizcve::autorizaroe($listoe)){

  		$usr_nombre =general::get_nombre_usr( $ses_usr_id );

		 bizcve::setevento(20, 'Anulación de OE bloqueadas', $_SERVER['REMOTE_ADDR'], 'ABM cotizacion',
                    'La OE '.$_POST['id_ordenent'].' ha sido desbloqueada','','Orden de entrega ha sido desbloqueada', $usr_nombre );


  		general::writeevent('La orden de entrega numero '.$_POST['id_ordenent'].' ha sido autorizada por la siguiente razon: '.$_POST['razon']);
  		/*Insercion de tracking*/
  		general::inserta_tracking(null, $_POST['id_ordenent'], null, null, 'Detalle : la orden de entrega numero '.$_POST['id_ordenent'].' ha sido autorizada por la siguiente razon: '.$_POST['razon']);
  		?>
  			<script language="JavaScript">
  			window.returnValue='reload';
  			window.close();
  			</script>
  		<?
  	}
  }
}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
global $rut,$id_cotizacion,$id_estado;
$rut=$_REQUEST['rut'];

/*Inclusion de header*/
$MiTemplate->set_var('error_app', $mensaje_error);
/**/
$MiTemplate->set_var("TITULO", TITULO);
/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "monitoroeblo/ordenent_00print.htm");
/**/


/* OBTENEMOS DATOS DE LA ORDEN DE ENTREGA */
bizcve::getordenent($ListEnc = new connlist(new dtoencordenent(array('id_ordenent'=>$_REQUEST['id_ordenent']))), $ListDet = new connlist);
$ListEnc->gofirst();
		$id_ordenent=$ListEnc->getelem()->id_ordenent;
		$MiTemplate->set_var('id_ordenent', $ListEnc->getelem()->id_ordenent);
		$diascondicionoe=$ListEnc->getelem()->diascondicion;		
		$MiTemplate->set_var('nomtipoentrega', $ListEnc->getelem()->nomtipoentrega);	
		$MiTemplate->set_var('monto', number_format($ListEnc->getelem()->monto));	
		$localcsum = $ListEnc->getelem()->codlocalventa;
		$codigovendedor = $ListEnc->getelem()->codigovendedor;
/* OBTENEMOS DATOS DEL VENDEDOR */
bizcve::GetUsers($List = new connlist(new dtousuario(array('codigovendedor'=>$codigovendedor))));
$List->gofirst();
$MiTemplate->set_var('nombrevendedor', $List->getelem()->usr_nombres.' '.$List->getelem()->usr_apellidos);	

/* OBTENEMOS DATOS DEL CENTRO DE SUMINISTRO */
bizcve::getlocales($List = new connlist(new dtolocal(array('cod_local'=>$localcsum))));
$List->gofirst();
$MiTemplate->set_var('nom_local_csum', $List->getelem()->nom_local);		

/* OBTENEMOS DATOS DEL DISPONIBLE Y SUMAMOS EL MONTO */

//Obtengo el credito del cliente mediante el webservice
if (!$credito = ConsultarClienteOnline($rut)) {
	$disponible= bizcve::getdisponible(new connlist(new dtoinfocliente(array('rut'=>$rut))));
}
else {
	$disponible = $credito['limite_disponible'];
}

$monto = $ListEnc->getelem()->monto;
$sumafinal = $disponible + $monto;
$MiTemplate->set_var('disponible', number_format($sumafinal));		

$rut=$ListEnc->getelem()->rutcliente;
$diascondicionOE=$ListEnc->getelem()->diascondicion;

/*FIN ORDEN DE ENTREGA*/


/* OBTENEMOS INFORMACION DEL CLIENTE */

$List = new connlist;
$mRegistro = new dtoinfocliente;
$mRegistro->rut=$_GET['rut'];
$List->addlast($mRegistro);
bizcve::getcliente($List);
$List->gofirst();
$MiTemplate->set_block('main' , "infocliente" , "BLO_infocliente");
if (!$List->isvoid()) {
	$tipocliente=$List->getelem()->id_tipocliente; 	 	
	$MiTemplate->set_var('rut',$List->getelem()->rut);
	$MiTemplate->set_var('rutdv', (($List->getelem()->id_contribuyente == 2)?$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut) : $List->getelem()->rut ));
	$MiTemplate->set_var('razonsoc',$List->getelem()->razonsoc);
	$MiTemplate->set_var('giro',$List->getelem()->giro);
	$MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente);
	
	//Intento consultar los datos online del webservice
	$marca_bloqueos = 0;
	if ($credito != false) {
		if ($credito['bloqueo_sap']) {
    		$MiTemplate->set_var('locksap', '<li>Cliente Bloqueado en SAP</li>');
    		$marca_bloqueos = 1;
  		}
  		if ($credito['bloqueo_moroso']) {
    		$MiTemplate->set_var('lockmoro', '<li>Cliente Bloqueado por Morosidad</li>');
    		$marca_bloqueos = 1;
  		}
  		if ($List->getelem()->id_tipocliente == 1 && strtotime($credito['fecha_vencimiento']) < time() ) {
  			$MiTemplate->set_var('lockfecha', '<li>Cliente Bloqueado por vencimiento de Disponible</li>');
  			$marca_bloqueos = 1;
  		}
	}
	else {
		//Traigo por defecto los datos de la db 
		if ($List->getelem()->locksap) {
			$MiTemplate->set_var('locksap', '<li>Cliente Bloqueado en SAP</li>');
			$marca_bloqueos = 1;
		}
		if ($List->getelem()->lockmoro) {
			$MiTemplate->set_var('lockmoro', '<li>Cliente Bloqueado por Morosidad</li>');
			$marca_bloqueos = 1;
		}
		if ($List->getelem()->lockfecha) {
			$MiTemplate->set_var('lockfecha', '<li>Cliente Bloqueado por vencimiento de Disponible</li>');
			$marca_bloqueos = 1;
		}
	}
	if ($List->getelem()->lockcve) {
		$MiTemplate->set_var('lockcve', '<li>Cliente Bloqueado en CVE</li>');
		$marca_bloqueos = 1;
	}
	if ($List->getelem()->comentario) {
		$MiTemplate->set_var('comentarioe', '<li>'.$List->getelem()->comentario.'</li>');
	}
	if (!$marca_bloqueos) {
		$MiTemplate->set_var('saldodisp', '<li>Saldo Disponible</li>');
	}
	
	if($List->getelem()->diascondicion){
		$MiTemplate->set_var('dias', $List->getelem()->diascondicion);
	}else{
		$MiTemplate->set_var('dias', 'No asignado');
	}
	$numdiaspago=$List->getelem()->numdiaspago;	
	$diascondicion=$List->getelem()->diascondicion;		
	$MiTemplate->parse("BLO_infocliente", "infocliente", true);
}
/*FIN INFORMACION DEL CLIENTE*/
/* OBTENEMOS INFORMACION DE LAS CONDICIONES DE PAGO PERMITIDAS */ 

bizcve::gettipoconpago($ListTc = new connlist);
$ListTc->gofirst();
$MiTemplate->set_block('main' , "condpagod" , "BLO_condpagod");
if (!$ListTc->isvoid()) {
	do {
	if (!$numdiaspago){
		if ($diascondicionOE<360 && $diascondicionOE>0){
			$Ctrl = new ctrltipos;
			$Ctrl->getconpagoaprox($lista=new connlist(new dtotipo(array('id_tipoconpago'=>$diascondicionOE))));	 	
			$lista->gofirst();
			$diascond=$lista->getelem()->id;
	 	}
	 }else{
	 	$diascond=$numdiaspago;
	 }			
	if ($numdiaspago){
		if ($numdiaspago<360 && $numdiaspago>0){
			$Ctrl = new ctrltipos;
			$Ctrl->getconpagoaprox($lista=new connlist(new dtotipo(array('id_tipoconpago'=>$numdiaspago))));	 	
			$lista->gofirst();
			$diascond=$lista->getelem()->id;
	 	}
	 }	
	 

		//condicion de pago del cliente 
		if( $numdiaspago){
			//$MiTemplate->set_var('deshabilitado', 'disabled');	
		}			
		//condicion de pago NO existe y tiene id		
		if(!$numdiaspago){
				$MiTemplate->set_var('deshabilitado', 'enabled');	
		}		
		
		$MiTemplate->set_var('id', $ListTc->getelem()->id);	
		$MiTemplate->set_var('nombre', $ListTc->getelem()->nombre);
        //$MiTemplate->set_var('selected', ($diascond == $ListTc->getelem()->id)?'selected':'');		
        $MiTemplate->set_var('selected', ($diascondicionOE == $ListTc->getelem()->id)?'selected':'');
		$MiTemplate->parse("BLO_condpagod", "condpagod", true);	
	} while ($ListTc->gonext());
}



/*FIN DESPLIEGUE*/

$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>
