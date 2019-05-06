<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
	

///////////////////////// ZONA DE ACCIONES /////////////////////////
if( $_REQUEST['accion']=='grabar'){
	$listaEnc = new connlist;
	$listaDet = new connlist;	
	$encCotizacion = new dtocotizacion;
	$encCotizacion ->id_cotizacion  =$_REQUEST['id_cotizacion'];
	$encCotizacion ->nvevaliddesde 	=general::formato_fecha_FORM2DB($_REQUEST['validdesde']);
	$encCotizacion ->nvevalidhasta 	=general::formato_fecha_FORM2DB($_REQUEST['validhasta']);
	$listaEnc->addlast($encCotizacion);	
	//exit();
	bizcve::gennve($listaEnc);
	/*para insertar el tracking*/
	//general::inserta_tracking( $id_cotizacion, null, null, null, "La cotizacion ha cambiado a estado Cotizacion");	
    ?>
    <script language="JavaScript">
        window.returnValue = 'refresh';
        window.close();
 	   </script>
    <?	
}	

/*para ver si tiene errorees*/
if($_REQUEST['accion']=='envia'){
	$ListDet  = new connlist;
	$ListEncco  = new connlist;
	$mRegistro  = new dtocotizacion;
	$mRegistro->id_cotizacion=$_REQUEST['id_cotizacion'];
	$ListEncco->addlast($mRegistro);
	bizcve::getcotizacion($ListEncco, $ListDet);
	$ListEncco->gofirst();
	$fechavalida=general::formato_fecha($ListEncco->getelem()->validhasta);			
	$hoy=DATE('d/m/Y');
	if (general::fecha_MYSQL2PHP($ListEncco->getelem()->validhasta) < general::fecha_MYSQL2PHP() ){	
		$msg_fechavalida="Cotizacion numero ".$_REQUEST['id_cotizacion']." esta vencida";
	}
	$rutcliente=$ListEncco->getelem()->rutcliente;	

	$valortotal=$ListEncco->getelem()->valortotal;			
	$List 		= new connlist;	
	$cliente 	= new dtoinfocliente;
	$cliente->rut	=  $rutcliente;	
	$List->addlast($cliente);
	bizcve::getcliente($List);
	$List->gofirst();
	if(	$List->getelem()->rut && $List->getelem()->razonsoc && $List->getelem()->direccion && $List->getelem()->id_comuna){
		$datosIncompletos=false;		 			
	}else{
		$datosIncompletos=true;					
	}
	$id_tipocliente = $List->getelem()->id_tipocliente;

	$List->gofirst();
	$locksap     = $List->getelem()->locksap;
	$lockmoro    = $List->getelem()->lockmoro;
	$lockcve     = $List->getelem()->lockcve;
	$lockfecha   = $List->getelem()->lockfecha;					
	$msg_bloqueo = $locksap.$lockmoro.$lockcve.$lockfecha;	
	/*verifica disponible*/
	$List  = new connlist;
	$mRegistro = new dtoinfocliente;
	$mRegistro->rut=$rutcliente;
	$List->addlast($mRegistro);			
	$disponible=bizcve::getdisponible($List);		
	if($disponible<0)
		$msg_disneg=" Existe una Cotizacion bloqueada para el cliente";

	//0.- COTIZACION EN ESTADO CV
	if ($_REQUEST['estadoorigen'] != 'CE'){
		general::alertexit('La Orden de Entrega ya se ha generado');
		exit();
	}
	//1 
	if($datosIncompletos){
		general::confirmexit('No se han ingresado todos los datos del cliente. Desea completarlos en este momento?', 'returnValue=\'completar\'', '');
		exit();				
	}
	//1.- CLIENTE  BLOQUEADO (4 CRITERIOS)
	if ($locksap || $lockmoro || $lockcve || $lockfecha){
		//general::alertexit('No se puede generar NVE debido a que el cliente se encuentra bloqueado');
		//general::confirm('El cliente se encuentra bloqueado para venta crédito. Si continúa, sólo se podrá hacer venta CONTADO.\nDesea continuar de todas maneras?', '', 'window.close()');
		general::confirm('El cliente se encuentra bloqueado. Puede efectuar venta al CONTADO y CREDITO.\nSi efectua una venta a CREDITO, la Orden de Entrega quedara bloqueada.\nDesea continuar de todas maneras?', '', 'window.close()');		
		//exit();
	}
	//2.- DISPONIBLE MENOR A CERO
	if ($disponible<0){
		//general::alertexit('No se puede generar NVE debido a que el cliente no tiene saldo disponible o tiene una OE previa bloqueada');
		general::confirm('El cliente NO tiene saldo disponible. Puede efectuar venta al CONTADO y CREDITO.\nSi efectua una venta a CREDITO, la Orden de Entrega quedara bloqueada.\nDesea continuar de todas maneras?', '', 'window.close()');
		//exit();
	}
	//3 - NVE VENCIDA
	if ($msg_fechavalida){
		general::alertexit('No se puede generar NVE debido a que la Cotizacion esta vencida');
		exit();
	}
	//4NO LE ALCANZA LA PLATA (SOLO SI ES SAP)
/*	if($valortotal>$disponible){
		general::alertexit('No se puede generar NVE debido a que el disponible del cliente no es suficiente');
		exit();	
	}*/

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
	$MiTemplate = new template;
	$MiTemplate->set_var("TITULO", TITULO);
	/* Inclusion de main*/
	$MiTemplate->set_file("main", TEMPLATE . "nuevacotizacion/nueva_cotizacion_04_popnotadeventa.htm");	
	$ListEnc = new connlist;
	$ListDet = new connlist;
	$Registro = new dtocotizacion;
	$Registro->id_cotizacion	=  $_REQUEST['id_cotizacion'];
	$ListEnc->addlast($Registro);
	bizcve::getcotizacion($ListEnc, $ListDet);
	$ListEnc->gofirst();

//    if ( $ListEnc->getelem()->codlocalcsum != $ses_usr_codlocal) 
//		general::alertexit("La cotizacion no puede generar NVE debido a que pertenece a un centro de suministro distinto. Primero debe editar la Cotización para actualizar los precios al centro de suministro actual");
	
	if (!$ListEnc->isvoid()) {
		$id_cotizacion=$ListEnc->getelem()->id_cotizacion;		
		$MiTemplate->set_var('DIAS_VALID_NVE_MAX', DIAS_VALID_NVE_MAX);
		$MiTemplate->set_var('id_cotizacion', $ListEnc->getelem()->id_cotizacion);
		$MiTemplate->set_var('nomtipoventa', $ListEnc->getelem()->nomtipoventa);
		$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);
		$MiTemplate->set_var('titulo', 'Titulo');
		$titulo_pagina=$ListEnc->getelem()->nomtipoventa;			
		$MiTemplate->set_var('codigovendedor', $ListEnc->getelem()->codigovendedor);
		$codigovendedor=$ListEnc->getelem()->codigovendedor;
		$rut=$ListEnc->getelem()->rutcliente;
		$MiTemplate->set_var('rutcliente', $ListEnc->getelem()->rutcliente.'-'.general::digiVer($ListEnc->getelem()->rutcliente));			
		$localcsum= $ListEnc->getelem()->codlocalcsum;		
		$MiTemplate->set_var('codlocalventa', $ListEnc->getelem()->codlocalventa);
		$MiTemplate->set_var('nom_local', $ListEnc->getelem()->nom_local);		
		$MiTemplate->set_var('condicion', $ListEnc->getelem()->condicion);
		$MiTemplate->set_var('direccion', $ListEnc->getelem()->direccion);			
		$margentotal =$ListEnc->getelem()->margentotal;		
		$MiTemplate->set_var('validdesde', DATE('d/m/Y'));
		$MiTemplate->set_var('validhasta', date("d/m/Y", mktime(0, 0, 0, date("m"),date("d")+DIAS_VALID_NVE ,date("Y")) ) );
		$encCotizacion ->nvevaliddesde 	=DATE('d/m/Y');
		$hasta=date("d/m/Y", mktime(0, 0, 0, date("m"),date("d")+DIAS_VALID_NVE ,date("Y")));
		$encCotizacion ->nvevalidhasta 	=$hasta;		
		$MiTemplate->set_var('usuariocrea', $ListEnc->getelem()->usuariocrea);			
	}

	$List = new connlist;
	$Registro = new dtolocal;
	$Registro->cod_local	=  $localcsum;
	$List->addlast($Registro);
	bizcve::getlocales($List);
	$List->gofirst();
	$MiTemplate->set_var('nom_local_csum', $List->getelem()->nom_local);
	$List = new connlist;
	$Registro = new dtousuario;
	$Registro->codigovendedor	=  $codigovendedor;
	$List->addlast($Registro);
	bizcve::GetUsers($List);
	$List->gofirst();
	$usr_nombre=$List->getelem()->usr_nombres;
	$usr_apellidos=$List->getelem()->usr_apellidos;	
	$MiTemplate->set_var('nombrevendedor', $usr_nombre.' '.$usr_apellidos);	
	$MiTemplate->set_var('titulo_pagina', $titulo_pagina);
	$MiTemplate->parse("OUT_M", array("main"), true);
	$MiTemplate->p("OUT_M");
}
///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>