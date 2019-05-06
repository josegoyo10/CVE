<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../ordenent/ordenent_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");


$visibleIMP = new getidvisibleimpuestos("VISIBLE_IMPUESTOS");
$visible_fletes=$visibleIMP->FLETES;
$visible_renta=$visibleIMP->IMPUESTO_RENTA;
$visible_ica=$visibleIMP->IMPUESTO_ICA;
$visible_reteiva=$visibleIMP->IMPUESTO_RETEIVA;

$confimp1 = new getidaplicacion("IDENTIFICACION_DE_LA_APLICACION");
$OE_Antigua=$confimp1->OE_ID_WILLIAM;
if($_REQUEST['oe'] > $OE_Antigua){

///////////////////////// ZONA DE ACCIONES /////////////////////////
/*si puede ver las cotizaciones*/
	if(!isset($_REQUEST['oe'])){
		general::alertexit('No puede ver esta orden de entrega');
		header( "Location: ../start/start_01.php");					
	}
	$ListEnc  = new connlist;
	$ListDet  = new connlist;
		
	$Registro = new dtoencordenent;
   	$mRegistro->id_ordenent=$_REQUEST['oe'];
	$ListEnc->addlast($mRegistro);
	
	bizcve::getordenent($ListEnc, $ListDet);
	
	$ListEnc->gofirst();
	//$ListEnc2->gofirst();	

if ($accion == 'AgrTr') {
	$List = new connlist;
	$itracking = new dtotracking;
	$itracking->id_ordenent =$_REQUEST['id_ordenent'];	
	$itracking->descripcion =$_REQUEST['descripcion'];		
	$itracking->tipo =$_REQUEST['tipo'];		
	$List->addlast($itracking);
	bizcve::puttracking($List);  	
}
if ($accion == 'CambEst') {
	$List    = new connlist;
	$ianular = new dtoencordenent;
	$ianular->id_ordenent	  =$_POST['id_ordenent'];	
	$ianular->id_estado		  =$_POST['origen'];
	$ianular->obsdesb 	  	  ='Rechazo';		
	$List->addlast($ianular);
	bizcve::getordenent($List, $Listdet = new connlist());
	bizcve::anularoe($List);
	general::inserta_tracking(null, $_POST['id_ordenent'], null, null, "Se ha anulado la Orden de Entrega");	
	//Se reversan los cargos de productos sobre la NVE original
	bizcve::ActualizaCantNVEOE($Listdet, '-');
	header("Location: ../ordenent/ordenent_00.php?oe=".$_POST['id_ordenent']);
	exit();
}

if ($accion == 'cerrar') {
	$List    = new connlist;
	$icerrar = new dtoencordenent;
	$icerrar->id_ordenent	  =$_POST['id_ordenent'];	
	$icerrar->id_estado_destino		  =$_POST['destino'];
	$List->addlast($icerrar);
	if(bizcve::cambioordenent($List, $Listdet = new connlist())){
		general::inserta_tracking(null, $_POST['id_ordenent'], null, null, "La Orden de Entrega ha sido finalizada.");	
		//Se reversan los cargos de productos sobre la NVE original
		header("Location: ../ordenent/ordenent_00.php?oe=".$_POST['id_ordenent']);
		exit();
	}else{
		general::alert('No ha sido posible realizar la finalizacion de la orden de entrega. Contacte a su administrador.');
	}
}

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
/**/
$MiTemplate->set_var("TITULO", TITULO);
/* Inclusion de main*/
$MiTemplate->set_file("main", TEMPLATE . "ordenent/ordenent_00.htm");
/*Valida cion boton de impresion para orden de despacho*/
$MiTemplate->set_var('valimpri', '');
$MiTemplate->set_var('td', '<tr><td>');
$MiTemplate->set_var('tdcerr', '</td></tr>');
/* Fin Valida cion boton de impresion para orden de despacho*/
/*para las ordenes de entrega*/
$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
	bizcve::gettipoflujo($Listf=new connlist(new dtotipo(array('id'=>$ListEnc->getelem()->id_tipoflujo))));
	$Listf->gofirst();
	/*para la direccionde despacho*/
	if($ListEnc->getelem()->id_direccion){
		bizcve::getdirdesp($List = new connlist(new dtodireccion(array('rut'=>$rut,
		'id_direccion'=>$ListEnc->getelem()->id_direccion))));
		$List->gofirst();
		$MiTemplate->set_var('nomdired', 'Direccion Despacho');
		$MiTemplate->set_var('direcciond', $List->getelem()->descripcion." - ".$List->getelem()->direccion);		
		$MiTemplate->set_var('comunad', 'Comuna');
		$MiTemplate->set_var('nomcomunad', $List->getelem()->nomcomuna);
	}else{
			$MiTemplate->set_var('nomdired', 'No posee direccion de despacho');
	}

	//Condicion de pago
	$MiTemplate->set_var('condicion', $ListEnc->getelem()->condicion);	

	//Tipo documento pago
	if ($ListEnc->getelem()->id_tipodocpago) {
		bizcve::getdocpago($Listp = new connlist(new dtotipo(array('id_tipodocpago'=>$ListEnc->getelem()->id_tipodocpago))));
		$Listp->gofirst();
		$MiTemplate->set_var('tipodocpago', $Listp->getelem()->nombre);
	}

	//Tipo pago
	bizcve::gettipopagoid($Listp = new connlist(new dtotipo(array('id_tipopago'=>$ListEnc->getelem()->id_tipopago))));
	$Listp->gofirst();
	$MiTemplate->set_var('tipopago', $Listp->getelem()->nombre);

	//Número documento pago
	if ($ListEnc->getelem()->numdocpago)
		$MiTemplate->set_var('numdocpago', $ListEnc->getelem()->numdocpago);			

	$id_tipodocpago=$ListEnc->getelem()->id_tipodocpago;
	$MiTemplate->set_var('numdocrefpago', $ListEnc->getelem()->numdocpago);
	$MiTemplate->set_var('oe', $ListEnc->getelem()->id_ordenent);
	$MiTemplate->set_var('id_ordenent', $ListEnc->getelem()->id_ordenent);	
	$id_ordenent=$ListEnc->getelem()->id_ordenent;
	$fecha = general::formato_fecha($ListEnc->getelem()->feccrea);
	$MiTemplate->set_var('id_cotizacion', $ListEnc->getelem()->id_cotizacion);
	$id_cotizacion=$ListEnc->getelem()->id_cotizacion;
	$id_tipoflujo = $ListEnc->getelem()->id_tipoflujo;
	$MiTemplate->set_var('nomtipoflujo', $ListEnc->getelem()->nomtipoflujo);	
	$MiTemplate->set_var('codigovendedor', $ListEnc->getelem()->codigovendedor);
	/*Formato Fecha*/
	$MiTemplate->set_var('validdesde',general::formato_fecha($ListEnc->getelem()->validdesde) );
	$MiTemplate->set_var('validhasta',general::formato_fecha($ListEnc->getelem()->validhasta) );
	if($ListEnc->getelem()->fecha_retira_cliente != '0000-00-00')
			$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_cliente) );
		if($ListEnc->getelem()->fecha_retira_inmediato != '0000-00-00')
			$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_inmediato) );
		if($ListEnc->getelem()->fecha_despacho_programado != '0000-00-00')
			$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_despacho_programado) );
		
	/*Fin Formato Fecha*/
	$MiTemplate->set_var('observaciones',$ListEnc->getelem()->observaciones);
	$MiTemplate->set_var('nomtipoentrega', $Listf->getelem()->nombre);		
	$codigovendedor		=$ListEnc->getelem()->codigovendedor;
	$MiTemplate->set_var('nomestadorent', $ListEnc->getelem()->nomestadorent);	
	$codlocalcsum = $ListEnc->getelem()->codlocalcsum;
	$MiTemplate->set_var('nom_localcsum', $ListEnc->getelem()->nom_localcsum);
	$MiTemplate->set_var('nom_localventa', $ListEnc->getelem()->nom_localventa);
	
	/*Calculo de Impuestos por separado*/
	$grupoimp='iva';
	$Daoe = new daoordenent; 
	$Daoe->getdetalleimpuestoe($Listimp = new connlist, $id_ordenent,$grupoimp);
	$Listimp->gofirst();
	//$totalica = 0;
	if(!$Listimp->isvoid()){
		do{
			$totaliva += $Listimp->getelem()->sumiva;
								
		}while($Listimp->gonext());
	}
	//$riva = ($totaliva / 2);
	$riva = $ListEnc->getelem()->rete_iva_oe;
	$sumtotal=$ListEnc->getelem()->totaloe;
	/*Fin Calculo de Impuestos por separado*/
	
	/*Calculo de Impuestos rete_renta*/
	$grupoimp='rete_renta';
	$Daoer = new daoordenent; 
	$Daoer->getdetalleimpuestoe($Listimpr = new connlist, $id_ordenent,$grupoimp);
	$Listimpr->gofirst();
	//$totalica = 0;
	if(!$Listimpr->isvoid()){
		do{
			$totalrenta += $Listimpr->getelem()->sumiva;
								
		}while($Listimpr->gonext());
	}
	/*Fin Calculo de Impuestos rete_renta*/
	
	
	
	/*Calculo de Impuetos rete_ica*/
	$grupoimp='rete_ica';
	$Daoei = new daoordenent; 
	$Daoei->getdetalleimpuestoe($Listimpi = new connlist, $id_ordenent,$grupoimp);
	$Listimpi->gofirst();
	//$totalica = 0;
	if(!$Listimpi->isvoid()){
		do{
			$totalica += $Listimpi->getelem()->sumiva;
								
		}while($Listimpi->gonext());
	}
	/*Fin calculo de Impuestos rete_ica*/
			
	$rete_renta = $totalrenta;
	$rete_iva = $riva;
	$rete_ica = $totalica;		
	$MiTemplate->set_var('usuariocrea', $ListEnc->getelem()->usrcrea);
	$MiTemplate->set_var('observaciones', $ListEnc->getelem()->observaciones);			
	$MiTemplate->set_var('nota', $ListEnc->getelem()->nota);		
	$codlocalventa=$ListEnc->getelem()->codlocalventa;	
	$MiTemplate->set_var('nomtipoflujo', $ListEnc->getelem()->nomtipoflujo);			
	$rut=$ListEnc->getelem()->rutcliente;
	$id_estado=$ListEnc->getelem()->id_estado;
	$iva=$ListEnc->getelem()->iva;
}

$List = new connlist;
$Registro = new dtousuario;
$Registro->codigovendedor	=  $codigovendedor;
$List->addlast($Registro);
bizcve::GetUsers($List);
$List->gofirst();
$usr_nombre=$List->getelem()->usr_nombres;
$usr_apellidos=$List->getelem()->usr_apellidos;	
if(!$codigovendedor){
	$MiTemplate->set_var('nombrevendedor', 'Venta No Asignada');	
}
else{
	$MiTemplate->set_var('nombrevendedor', $usr_nombre.' '.$usr_apellidos);
}
$List = new connlist;
$Registro = new dtolocal;
$Registro->cod_local = $codlocalcsum;
$List->addlast($Registro);
bizcve::getlocales($List);
$List->gofirst();
$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
$validgui= 0;
$ListDet->gofirst();
$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detalleOE");
if (!$ListDet->isvoid()) {
	do {
		if($ListDet->getelem()->marcaflete==1){
			$MiTemplate->set_var('prioridad','class="fondoprioridad"');				
		}else{
			$MiTemplate->set_var('prioridad','');				
		}			
			$MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
			$MiTemplate->set_var('codtipo', $ListDet->getelem()->codtipo);
			$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
			$precio=($ListDet->getelem()->pventaneto);
			$MiTemplate->set_var('cantidad', round($ListDet->getelem()->cantidade));
			
		if ( $ListDet->getelem()->id_tipoentrega==1 and $ListDet->getelem()->id_tiporetiro==2)
	    			$MiTemplate->set_var('desp', 'Retira Cliente');		    
		if ( $ListDet->getelem()->id_tipoentrega==2 and $ListDet->getelem()->id_tiporetiro==2)
					$MiTemplate->set_var('desp', 'Desp. Programado');
		if ( $ListDet->getelem()->id_tipoentrega==1 and $ListDet->getelem()->id_tiporetiro==1)
		{       $MiTemplate->set_var('desp', 'Retira Inmediato');
				$validgui = 1;
		}
			
			
			$MiTemplate->set_var('unimed', $ListDet->getelem()->unimed);
			$MiTemplate->set_var('nomproveedor', $ListDet->getelem()->nomproveedor);
			$MiTemplate->set_var('rutproveedor', $ListDet->getelem()->rutproveedor);
			$totallinea += $ListDet->getelem()->totallinea;
			$MiTemplate->set_var('totallinea',number_format(round( $ListDet->getelem()->totallinea)));
			$MiTemplate->set_var('precio',number_format($precio));
			$totalneto+=round( $ListDet->getelem()->totallinea);
            //Peso, Instalacion, Descuento
			$MiTemplate->set_var('descuento', number_format($ListDet->getelem()->descuento));
			$MiTemplate->set_var('instalacion', $ListDet->getelem()->instalacion);
			$MiTemplate->set_var('peso', $ListDet->getelem()->peso);
			$valortotaldescu  +=round($ListDet->getelem()->descuento)+0;
			
			if($ListDet->getelem()->codsubtipo=='DE' && $ListDet->getelem()->codtipo=='SV'){
				$valorfletet+=$ListDet->getelem()->totallinea;	
			}
			else{
				$valorfletet=$valorfletet+0;
			}
			
			
			$MiTemplate->parse("BLO_detalleOE", "detalleproductos", true);		
	} while ($ListDet->gonext());
	//general::writelog('r'.$rete_renta.',i'.$rete_iva.',c'.$rete_ica);
	if($valorfletet >0 && $visible_fletes== true){
		$MiTemplate->set_var('valorfletetabla', '<tr>

								<td width="40"></td>

								<td width="80"></td>                

								<td width="200" ></td>

								<td width="100" align="left" >Valor Flete</td>

								<td width="50" ></td>                

								<td width="90"align="right">{valoflete}</td>

							</tr>
				');
	}
	
	
	$MiTemplate->set_var('valortotal',number_format($totallinea));
	$MiTemplate->set_var('valoflete', number_format($valorfletet));
	$MiTemplate->set_var('descuentot', ((number_format($valortotaldescu) == 0)?'-':number_format($valortotaldescu)));
	$MiTemplate->set_var('valoriva', number_format($valoriva));
	
	
		
}
if($id_tipoflujo==5){
	$MiTemplate->set_var('larencdescripcion', '230');
	$MiTemplate->set_var('larenccantidad', '20');
	$MiTemplate->set_var('larencunimed', '40');
	$MiTemplate->set_var('larencproveedor', '100');
	$MiTemplate->set_var('larencprecio', '60');
	$MiTemplate->set_var('larenctotal', '60');

	$MiTemplate->set_var('lardetdescripcion', '250');
	$MiTemplate->set_var('lardetcantidad', '40');
	$MiTemplate->set_var('lardetunimed', '50');
	$MiTemplate->set_var('lardetproveedor', '130');
	$MiTemplate->set_var('lardetprecio', '40');
	$MiTemplate->set_var('lardettotal', '70');

}else{
	$MiTemplate->set_var('ocultaprovini', '<!--');
	$MiTemplate->set_var('ocultaprovfin', '-->');
	$MiTemplate->set_var('larencdescripcion', '180');
	$MiTemplate->set_var('larenccantidad', '40');
	$MiTemplate->set_var('larencunimed', '30');
	$MiTemplate->set_var('larencproveedor', '100');
	$MiTemplate->set_var('larencprecio', '80');
	$MiTemplate->set_var('larenctotal', '90');
	$MiTemplate->set_var('larenctipodespacho','40');
	$MiTemplate->set_var('larencunimed','40');
	
	$MiTemplate->set_var('lardetdescripcion', '180');
	$MiTemplate->set_var('lardetcantidad', '40');
	$MiTemplate->set_var('lardetunimed', '60');
	$MiTemplate->set_var('lardetproveedor', '130');
	$MiTemplate->set_var('lardetprecio', '70');
	$MiTemplate->set_var('lardetcantidad', '50');
	$MiTemplate->set_var('lardettotal', '90');
	$MiTemplate->set_var('lardettipodespacho','40');
	$MiTemplate->set_var('lardetunimed','40');
	$MiTemplate->set_var('lardetinstalacion','60');
	$MiTemplate->set_var('lardetpeso','30');
	$MiTemplate->set_var('lardetcodprod','40');
	$MiTemplate->set_var('lardetcodtipo','30');
}

$List = new connlist;
$Registro = new dtoinfocliente;
$Registro->rut	= $rut;
$List->addlast($Registro);

bizcve::getCliente($List);
$List->gofirst();
//Mantis 30518: Deshabilitacion boton de generacion de cotizacion Inicio
if ( $List->getelem()->feccrea < $List->getelem()->fchalimite  ){
    $btn = 'disabled';    
}else{
    $btn = '';    
}
$MiTemplate->set_var('btn',$btn);
//Mantis 30518: Deshabilitacion boton de generacion de cotizacion Fin
//Obtengo el credito del cliente mediante el webservice
$credito = ConsultarClienteOnline($List->getelem()->rut);

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
		$MiTemplate->set_var('locksap', '<li>Cliente bloqueado en SAP</li>');
		$marca_bloqueos = 1;
	}
	if ($List->getelem()->lockmoro) {
		$MiTemplate->set_var('lockmoro', '<li>Cliente bloqueado por Morosidad</li>');
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

if (!$List->isvoid()) {
	$List->gofirst();
	
	$MiTemplate->set_var('rut', $List->getelem()->rut);
	
	$configclitipo = new getidcontribuyente("CONTRIBUYENTE");
	$opcion=$configclitipo->JURIDICO;
	$opcion1=$configclitipo->EMPRESARIAL;
	
	$MiTemplate->set_var('rutcliented', (($List->getelem()->id_contribuyente == $opcion1)?$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut) : $List->getelem()->rut ));	
	$rutcliente=$List->getelem()->rut;	
	$MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente);			
	$MiTemplate->set_var('contacto', $List->getelem()->apellido.' '.$List->getelem()->apellido1.' '.$List->getelem()->contacto);					
	$MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);		
	$MiTemplate->set_var('email', $List->getelem()->email);	
    $MiTemplate->set_var('nomtipdocpago', $List->getelem()->nomtipdocpago);
    $validacobroriva = $List->getelem()->rete_iva;
    $validacobrorenta=$List->getelem()->rete_renta;
	$validacobroica=$List->getelem()->rete_ica;	    	
}

$ListEncCot = new connlist;
$ListDetCot = new connlist;
$RegistroEncCot = new dtocotizacion;
$RegistroEncCot->id_cotizacion	=  $id_cotizacion;   
$ListEncCot->addlast($RegistroEncCot);
bizcve::getcotizacion($ListEncCot, $ListDetCot);
$ListEncCot->gofirst();
//$rete_iva2 = (($ListEncCot->getelem()->rete_iva >= 1)? round($rete_iva) : $rete_iva = 0);
$rete_iva2 = $rete_iva;
$rete_ica2 = round($rete_ica);
$rete_renta2 = round($rete_renta);
//$sumtotal = $totallinea - $rete_renta2 - $rete_iva2 - $rete_ica2;
if($visible_reteiva==true){
	$MiTemplate->set_var('visible_reteiva', '<tr>
								<td width="40"></td><td width="80"></td><td width="200" ></td>
								<td width="100" align="left" >Retenci&oacute;n IVA</td><td width="50" ></td>                
								<td width="90"align="right">{rete_iva}</td></tr>');
}
else{
	$MiTemplate->set_var('visible_reteiva', '');
}

if($visible_renta== true){
	$MiTemplate->set_var('visible_renta', '<tr>
								<td width="40"></td><td width="80"></td><td width="200" ></td>
								<td width="100" align="left" >Retenci&oacute;n Renta</td><td width="50" ></td>                
								<td width="90"align="right">{rete_renta}</td></tr>');
}
else{
	$MiTemplate->set_var('visible_renta', '');
}

if($visible_ica == true){
	$MiTemplate->set_var('visible_ica', '<tr>
								<td width="40"></td><td width="80"></td><td width="200" ></td>
								<td width="100" align="left" >Retenci&oacute;n ICA</td><td width="50" ></td>
								<td width="90"align="right">{rete_ica}</td></tr>');
}
else{
	$MiTemplate->set_var('visible_ica', '');
}

$MiTemplate->set_var('viva', number_format($totaliva));
$MiTemplate->set_var('rete_ica',number_format($totalica));
$MiTemplate->set_var('rete_renta', number_format($totalrenta));
$MiTemplate->set_var('rete_iva',number_format($rete_iva2));
$MiTemplate->set_var('sumtotal', number_format($sumtotal));
/*Actualizacion OE Total*/
//$dao = new daoordenent;
//$dao->updateoe($id_ordenent,$sumtotal,"'".$rete_iva2."'");
/*Fin Actualizacion OE Total*/

$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
	$MiTemplate->set_var('id_ordenent', $id_ordenent);		
	$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);	
	$MiTemplate->set_var('giro', $ListEnc->getelem()->giro);
	$MiTemplate->set_var('direccion', str_replace("||",",",$ListEnc->getelem()->direccion));				
	$MiTemplate->set_var('nomcomuna', $ListEnc->getelem()->comuna);		
}



$List = new connlist;
$Registro = new dtotracking;
$Registro->id_ordenent	=  $id_ordenent;
$List->addlast($Registro);

bizcve::gettracking($List);
$List->gofirst();
$MiTemplate->set_block('main' , "listatracking" , "BLO_listatracking");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('tipo', $List->getelem()->tipo);
		$MiTemplate->set_var('descripcion_track', $List->getelem()->descripcion);						
		$MiTemplate->set_var('usuario_track', $List->getelem()->usrcrea);			
		$MiTemplate->set_var('fecha_track', $List->getelem()->feccrea);			
		$MiTemplate->parse("BLO_listatracking", "listatracking", true);	
	} while ($List->gonext());
}

if ($ses_usr_codlocal == $codlocalcsum || $ses_usr_codlocal == $codlocalventa) {
	$MiTemplate->set_var('rutcliente', $rutcliente);	
	$List = new connlist;
	$Registro = new dtocambiosestado;
	$Registro->id_estado_origen = $id_estado;
	$Registro->id_ordenent	=  $id_ordenent;
	$Registro->tipo = 'OE';
	$List->addlast($Registro);
	bizcve::getcambiosestadooe($List);
	$List->gofirst();
	$MiTemplate->set_block('main' , "Botones" , "BLO_Botones");
	if (!$List->isvoid()) {
		do {
			$id_estado=$List->getelem()->id_estado_origen;
			$MiTemplate->set_var('ordenent', $id_ordenent);			
			$MiTemplate->set_var('id_estado_origen', $List->getelem()->id_estado_origen);
			$origen=$List->getelem()->id_estado_origen;	
			$MiTemplate->set_var('origen', $List->getelem()->id_estado_origen);			
			$MiTemplate->set_var('estadoterminal', $List->getelem()->estadoterminal);			
			$MiTemplate->set_var('id_estado_destino', $List->getelem()->id_estado_destino);						
//DESHABILITO EL ANULAR LA OE A NO SER QUE SEAN CIERTOS PERFILES LOS QUE LO PIDEN
//PERFIL ASIGNADO A PERFIL DE GERENTE MAYORISTA
                        $Lista = new connlist;
                        bizcve::infousuarioper($Lista,$ses_usr_id);
                        $Lista->gofirst();
                        $ID1 = $Lista->getelem()->per_id;
                        //general::alert($ID1);
                    	    if ($ID1!=12 && $ID1!=21 && $ID1!=31) {
								if($List->getelem()->id_estado_destino=='ON'){
									$MiTemplate->set_var('boton', 'disabled');
								}else{
									$MiTemplate->set_var('boton', '');
								}
                        	}else{
                        		if($sap==1){
    	                	    		if($List->getelem()->id_estado_destino=='ON'){
											$MiTemplate->set_var('boton', 'disabled');
		                   	    		}
                    	    	}else{
                    	    		if($List->getelem()->id_estado_destino=='ON'){
    	                	    		if((date("d/m/Y", time())) != ($fecha)){
											$MiTemplate->set_var('boton', 'disabled');
	                    	    		}
	                                }else{
										$MiTemplate->set_var('boton', '');
	                                }
                    	    	}
                        		
                        	}

			$MiTemplate->set_var('nomaccion', $List->getelem()->nomaccion);			
			if ($List->getelem()->color=='red'){
				$MiTemplate->set_var('color', ';color:#FF0000');					
			}else{
				$MiTemplate->set_var('color', '');				
			}				
			$MiTemplate->parse("BLO_Botones", "Botones", true);	
		} while ($List->gonext());

	}
	if($id_estado=='OF'){
		$MiTemplate->set_var('valimpri', 'hidden');
	}
	
	if ($id_estado=='OG'){
		//$genfactura="<input type='button' class='Textonormal' style='width:200;color:#FF0000' name='Button'  value='Imprimir Factura' onClick=GenFactura($id_ordenent)>";
		//$MiTemplate->set_var('genfactura', $genfactura);
		if($validgui == 1){
			$MiTemplate->set_var('imprimirgde', $imprimirgde);
		}else{
			$imprimirgde="<input type='button' class='Textonormal' style='width:200;color:#FF0000' name='Button' value='Imprimir Guia de Despacho' onClick=GenGuiaDespacho($id_ordenent)>";
			$MiTemplate->set_var('imprimirgde', $imprimirgde);
		}
			
		/*Valida el boton de  impresion*/
		$MiTemplate->set_var('valimpri', 'hidden');
		$MiTemplate->set_var('td', '');
		/*Fin Valida el boton de  impresion*/		
	
		if($id_tipoflujo==5){
			//PREGUNTAMOS SI EL USUARIO TIENE PERMISO PARA CERRAR LA OE.
			$List = new connlist;
			bizcve::infousuarioper($List,$ses_usr_id);
			$List->gofirst();
			$ID = $List->getelem()->per_id;
			if ($ID==6||$ID==23||$ID==25||$ID==27||$ID==2||$ID==12||$ID==20||$ID==26) {
				$cerraroe="<input type='button' class='Textonormal' style='width:200' name='Button'  value='Finalizar Orden de Entrega' onClick=CerrarOE('$origen',$id_ordenent)>";
				$MiTemplate->set_var('cerraroe', $cerraroe);					
			}
		}
	}
}
else {
	$MiTemplate->set_block('main' , "Botones" , "BLO_Botones");
	$MiTemplate->set_var('mensajenoboton', '<center>Esta Orden de Entrega no pertenece al centro de suministro actual. No puede ejecutar acciones sobre ella</center>');		
}

$ListEnci = new connlist;
$ListDeti = new connlist;
$Registro = new dtoencordenpicking;
$Registro->id_ordenent	= $id_ordenent;
$ListEnci->addlast($Registro);
bizcve::getordenpick($ListEnci, $ListDeti);

$ListEnci->gofirst();
$MiTemplate->set_block('main' , "ordenpick" , "BLO_listaordenpick");
if (!$ListEnci->isvoid()) {
	do {
 		$MiTemplate->set_var('tipo_doc', 'Orden de Picking');		
 		$MiTemplate->set_var('id_ordenpicking', "<a href=\"../monitororpick/monitor_orpick_00.php?buscar=".$ListEnci->getelem()->id_ordenpicking."&filtro=4\">".$ListEnci->getelem()->id_ordenpicking."</a>");
		$MiTemplate->set_var('nomestado', $ListEnci->getelem()->nomestado);
		$MiTemplate->set_var('feccrea', general::formato_fecha($ListEnci->getelem()->feccrea));				
		$MiTemplate->set_var('usuariocrea', $ListEnci->getelem()->usuariocrea);
		$MiTemplate->parse("BLO_listaordenpick", "ordenpick", true);	
	} while ($ListEnci->gonext());
}
else {
 		$MiTemplate->set_var('sindocumentos','No existen documentos relacionados a esta Orden de Entrega');
}
/*para la cotizacion asociada*/
/*si puede ver las cotizaciones*/
	$ListEnco  = new connlist;
	$ListDeto  = new connlist;	
	$mRegistro = new dtocotizacion;
   	$mRegistro->id_cotizacion=$id_cotizacion;
	$ListEnco->addlast($mRegistro);
	bizcve::getcotizacion($ListEnco, $ListDeto);
	$ListEnco->gofirst();	
if (!$ListEnco->isvoid()) {
	do {
 		$MiTemplate->set_var('tipo_doc', 'Cotizaci&oacute;n');		
 		$MiTemplate->set_var('id_cotizacion', $ListEnco->getelem()->id_cotizacion);
		$MiTemplate->set_var('nomestado', $ListEnco->getelem()->nomestado);
		$MiTemplate->set_var('feccrea', general::formato_fecha($ListEnco->getelem()->feccrea));				
		$MiTemplate->set_var('usuariocrea', $ListEnco->getelem()->usuariocrea);
	} while ($ListEnco->gonext());
}
if($id_tipoflujo==5){
	$ListEnce  = new connlist;
	$ListDete  = new connlist;	
	$mRegistro = new dtodocumento;
   	$mRegistro->numorigen=$id_ordenent;
	$ListEnce->addlast($mRegistro);
	bizcve::getdocumento($ListEnce, $ListDete);
	$ListEnce->gofirst();

	$MiTemplate->set_block('main' , "tabladocfac" , "BLO_tabladocfac");
	if (!$ListEnce->isvoid()) {
		do {
			$id_tipodocumento=$ListEnce->getelem()->id_tipodocumento;
			if($id_tipodocumento==1){
				$nomdoc = 'Factura Proveedor';
				$nomfuncion = 'verdocumentofct';
			}elseif($id_tipodocumento==2){
				$nomdoc = 'Guia de despacho Proveedor';
				$nomfuncion = 'verdocumentogde';
			}
			$MiTemplate->set_var('tabla_fct', "
			<tr valign=top>
			<td width=180 align=left>&nbsp;$nomdoc</td>
			<td width=80 align=center><a href=javascript:$nomfuncion(".$ListEnce->getelem()->id_documento.");>".$ListEnce->getelem()->id_documento."</td>
			<td width=150 align=center>---</td>
			<td width=100 align=center>".general::formato_fecha($ListEnce->getelem()->feccrea)."</td>								
			<td width=100 align=left>&nbsp;".$ListEnce->getelem()->usrcrea."</td>								
			</tr>	");
			$MiTemplate->parse("BLO_tabladocfac", "tabladocfac", true);
		}while ($ListEnce->gonext());
	}
}

// Abrir la ventana da pago de inmediato si la OE está en estado OA
if ($id_estado == 'OA') {
	$MiTemplate->set_var('pago', $_REQUEST['pago']);
}

/**/
$MiTemplate->parse("OUT_M", array("header", "main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
}
else{
/////////////////////////////prueba oe sistema viejo/////////////////////////////////////////////////////////////
///////////////////////// ZONA DE ACCIONES /////////////////////////
/*si puede ver las cotizaciones*/
	if(!isset($_REQUEST['oe'])){
		general::alertexit('No puede ver esta orden de entrega');
		header( "Location: ../start/start_01.php");					
	}
	$ListEnc  = new connlist;
	$ListDet  = new connlist;
		
	$Registro = new dtoencordenent;
   	$mRegistro->id_ordenent=$_REQUEST['oe'];
	$ListEnc->addlast($mRegistro);
	
	bizcve::getordenent($ListEnc, $ListDet);
	
	$ListEnc->gofirst();
	//$ListEnc2->gofirst();	

if ($accion == 'AgrTr') {
	$List = new connlist;
	$itracking = new dtotracking;
	$itracking->id_ordenent =$_REQUEST['id_ordenent'];	
	$itracking->descripcion =$_REQUEST['descripcion'];		
	$itracking->tipo =$_REQUEST['tipo'];		
	$List->addlast($itracking);
	bizcve::puttracking($List);  	
}
if ($accion == 'CambEst') {
	$List    = new connlist;
	$ianular = new dtoencordenent;
	$ianular->id_ordenent	  =$_POST['id_ordenent'];	
	$ianular->id_estado		  =$_POST['origen'];
	$ianular->obsdesb 	  	  ='Rechazo';		
	$List->addlast($ianular);
	bizcve::getordenent($List, $Listdet = new connlist());
	bizcve::anularoe($List);
	general::inserta_tracking(null, $_POST['id_ordenent'], null, null, "Se ha anulado la Orden de Entrega");	
	//Se reversan los cargos de productos sobre la NVE original
	bizcve::ActualizaCantNVEOE($Listdet, '-');
	header("Location: ../ordenent/ordenent_00.php?oe=".$_POST['id_ordenent']);
	exit();
}

if ($accion == 'cerrar') {
	$List    = new connlist;
	$icerrar = new dtoencordenent;
	$icerrar->id_ordenent	  =$_POST['id_ordenent'];	
	$icerrar->id_estado_destino		  =$_POST['destino'];
	$List->addlast($icerrar);
	if(bizcve::cambioordenent($List, $Listdet = new connlist())){
		general::inserta_tracking(null, $_POST['id_ordenent'], null, null, "La Orden de Entrega ha sido finalizada.");	
		//Se reversan los cargos de productos sobre la NVE original
		header("Location: ../ordenent/ordenent_00.php?oe=".$_POST['id_ordenent']);
		exit();
	}else{
		general::alert('No ha sido posible realizar la finalizacion de la orden de entrega. Contacte a su administrador.');
	}
}

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
/**/
$MiTemplate->set_var("TITULO", TITULO);
/* Inclusion de main*/
$MiTemplate->set_file("main", TEMPLATE . "ordenent/ordenent_00.htm");
/*Valida cion boton de impresion para orden de despacho*/
$MiTemplate->set_var('valimpri', '');
$MiTemplate->set_var('td', '<tr><td>');
$MiTemplate->set_var('tdcerr', '</td></tr>');
/* Fin Valida cion boton de impresion para orden de despacho*/
/*para las ordenes de entrega*/
$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
	bizcve::gettipoflujo($Listf=new connlist(new dtotipo(array('id'=>$ListEnc->getelem()->id_tipoflujo))));
	$Listf->gofirst();
	/*para la direccionde despacho*/
	if($ListEnc->getelem()->id_direccion){
		bizcve::getdirdesp($List = new connlist(new dtodireccion(array('rut'=>$rut,
		'id_direccion'=>$ListEnc->getelem()->id_direccion))));
		$List->gofirst();
		$MiTemplate->set_var('nomdired', 'Direccion Despacho');
		$MiTemplate->set_var('direcciond', $List->getelem()->descripcion." - ".$List->getelem()->direccion);		
		$MiTemplate->set_var('comunad', 'Comuna');
		$MiTemplate->set_var('nomcomunad', $List->getelem()->nomcomuna);
	}else{
			$MiTemplate->set_var('nomdired', 'No posee direccion de despacho');
	}

	//Condicion de pago
	$MiTemplate->set_var('condicion', $ListEnc->getelem()->condicion);	

	//Tipo documento pago
	if ($ListEnc->getelem()->id_tipodocpago) {
		bizcve::getdocpago($Listp = new connlist(new dtotipo(array('id_tipodocpago'=>$ListEnc->getelem()->id_tipodocpago))));
		$Listp->gofirst();
		$MiTemplate->set_var('tipodocpago', $Listp->getelem()->nombre);
	}

	//Tipo pago
	bizcve::gettipopagoid($Listp = new connlist(new dtotipo(array('id_tipopago'=>$ListEnc->getelem()->id_tipopago))));
	$Listp->gofirst();
	$MiTemplate->set_var('tipopago', $Listp->getelem()->nombre);

	//Número documento pago
	if ($ListEnc->getelem()->numdocpago)
		$MiTemplate->set_var('numdocpago', $ListEnc->getelem()->numdocpago);			

	$id_tipodocpago=$ListEnc->getelem()->id_tipodocpago;
	$MiTemplate->set_var('numdocrefpago', $ListEnc->getelem()->numdocpago);
	$MiTemplate->set_var('oe', $ListEnc->getelem()->id_ordenent);
	$MiTemplate->set_var('id_ordenent', $ListEnc->getelem()->id_ordenent);	
	$id_ordenent=$ListEnc->getelem()->id_ordenent;
	$fecha = general::formato_fecha($ListEnc->getelem()->feccrea);
	$MiTemplate->set_var('id_cotizacion', $ListEnc->getelem()->id_cotizacion);
	$id_cotizacion=$ListEnc->getelem()->id_cotizacion;
	$id_tipoflujo = $ListEnc->getelem()->id_tipoflujo;
	$MiTemplate->set_var('nomtipoflujo', $ListEnc->getelem()->nomtipoflujo);	
	$MiTemplate->set_var('codigovendedor', $ListEnc->getelem()->codigovendedor);
	/*Formato Fecha*/
	$MiTemplate->set_var('validdesde',general::formato_fecha($ListEnc->getelem()->validdesde) );
	$MiTemplate->set_var('validhasta',general::formato_fecha($ListEnc->getelem()->validhasta) );
	if($ListEnc->getelem()->fecha_retira_cliente != '0000-00-00')
			$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_cliente) );
		if($ListEnc->getelem()->fecha_retira_inmediato != '0000-00-00')
			$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_inmediato) );
		if($ListEnc->getelem()->fecha_despacho_programado != '0000-00-00')
			$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_despacho_programado) );
		
	/*Fin Formato Fecha*/
	$MiTemplate->set_var('observaciones',$ListEnc->getelem()->observaciones);
	$MiTemplate->set_var('nomtipoentrega', $Listf->getelem()->nombre);		
	$codigovendedor		=$ListEnc->getelem()->codigovendedor;
	$MiTemplate->set_var('nomestadorent', $ListEnc->getelem()->nomestadorent);	
	$codlocalcsum = $ListEnc->getelem()->codlocalcsum;
	$MiTemplate->set_var('nom_localcsum', $ListEnc->getelem()->nom_localcsum);
	$MiTemplate->set_var('nom_localventa', $ListEnc->getelem()->nom_localventa);
	
	/*Calculo de Impuestos por separado*/
	$grupoimp='iva';
	$Daoe = new daoordenent; 
	$Daoe->getdetalleimpuestoe($Listimp = new connlist, $id_ordenent,$grupoimp);
	$Listimp->gofirst();
	//$totalica = 0;
	if(!$Listimp->isvoid()){
		do{
			$totaliva += $Listimp->getelem()->sumiva;
								
		}while($Listimp->gonext());
	}
	$riva = ($totaliva / 2);
	/*Fin Calculo de Impuestos por separado*/
	
	/*Calculo de Impuestos rete_renta*/
	$grupoimp='rete_renta';
	$Daoer = new daoordenent; 
	$Daoer->getdetalleimpuestoe($Listimpr = new connlist, $id_ordenent,$grupoimp);
	$Listimpr->gofirst();
	//$totalica = 0;
	if(!$Listimpr->isvoid()){
		do{
			$totalrenta += $Listimpr->getelem()->sumiva;
								
		}while($Listimpr->gonext());
	}
	/*Fin Calculo de Impuestos rete_renta*/
	
	
	
	/*Calculo de Impuetos rete_ica*/
	$grupoimp='rete_ica';
	$Daoei = new daoordenent; 
	$Daoei->getdetalleimpuestoe($Listimpi = new connlist, $id_ordenent,$grupoimp);
	$Listimpi->gofirst();
	//$totalica = 0;
	if(!$Listimpi->isvoid()){
		do{
			$totalica += $Listimpi->getelem()->sumiva;
								
		}while($Listimpi->gonext());
	}
	/*Fin calculo de Impuestos rete_ica*/
			
	$rete_renta = $totalrenta;
	$rete_iva = $riva;
	$rete_ica = $totalica;		
	$MiTemplate->set_var('usuariocrea', $ListEnc->getelem()->usrcrea);
	$MiTemplate->set_var('observaciones', $ListEnc->getelem()->observaciones);			
	$MiTemplate->set_var('nota', $ListEnc->getelem()->nota);		
	$codlocalventa=$ListEnc->getelem()->codlocalventa;	
	$MiTemplate->set_var('nomtipoflujo', $ListEnc->getelem()->nomtipoflujo);			
	$rut=$ListEnc->getelem()->rutcliente;
	$id_estado=$ListEnc->getelem()->id_estado;
	$iva=$ListEnc->getelem()->iva;
}

$List = new connlist;
$Registro = new dtousuario;
$Registro->codigovendedor	=  $codigovendedor;
$List->addlast($Registro);
bizcve::GetUsers($List);
$List->gofirst();
$usr_nombre=$List->getelem()->usr_nombres;
$usr_apellidos=$List->getelem()->usr_apellidos;	
if(!$codigovendedor){
	$MiTemplate->set_var('nombrevendedor', 'Venta No Asignada');	
}
else{
	$MiTemplate->set_var('nombrevendedor', $usr_nombre.' '.$usr_apellidos);
}	

$List = new connlist;
$Registro = new dtolocal;
$Registro->cod_local = $codlocalcsum;
$List->addlast($Registro);
bizcve::getlocales($List);
$List->gofirst();
$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
$validgui= 0;
$ListDet->gofirst();
$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detalleOE");
if (!$ListDet->isvoid()) {
	do {
		if($ListDet->getelem()->marcaflete==1){
			$MiTemplate->set_var('prioridad','class="fondoprioridad"');				
		}else{
			$MiTemplate->set_var('prioridad','');				
		}			
			$MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
			$MiTemplate->set_var('codtipo', $ListDet->getelem()->codtipo);
			$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
			$precio=($ListDet->getelem()->pventaneto);
			$MiTemplate->set_var('cantidad', round($ListDet->getelem()->cantidade));
			
		if ( $ListDet->getelem()->id_tipoentrega==1 and $ListDet->getelem()->id_tiporetiro==2)
	    			$MiTemplate->set_var('desp', 'Retira Cliente');		    
		if ( $ListDet->getelem()->id_tipoentrega==2 and $ListDet->getelem()->id_tiporetiro==2)
					$MiTemplate->set_var('desp', 'Desp. Programado');
		if ( $ListDet->getelem()->id_tipoentrega==1 and $ListDet->getelem()->id_tiporetiro==1)
		{       $MiTemplate->set_var('desp', 'Retira Inmediato');
				$validgui = 1;
		}
			
			
			$MiTemplate->set_var('unimed', $ListDet->getelem()->unimed);
			$MiTemplate->set_var('nomproveedor', $ListDet->getelem()->nomproveedor);
			$MiTemplate->set_var('rutproveedor', $ListDet->getelem()->rutproveedor);
			$totallinea += $ListDet->getelem()->totallinea;
			$MiTemplate->set_var('totallinea',number_format(round( $ListDet->getelem()->totallinea)));
			$MiTemplate->set_var('precio',number_format($precio));
			$totalneto+=round( $ListDet->getelem()->totallinea);
            //Peso, Instalacion, Descuento
			$MiTemplate->set_var('descuento', number_format($ListDet->getelem()->descuento));
			$MiTemplate->set_var('instalacion', $ListDet->getelem()->instalacion);
			$MiTemplate->set_var('peso', $ListDet->getelem()->peso);
			$valortotaldescu  +=round($ListDet->getelem()->descuento)+0;
			
			if($ListDet->getelem()->codsubtipo=='DE' && $ListDet->getelem()->codtipo=='SV'){
				$valorfletet+=$ListDet->getelem()->totallinea;	
			}
			else{
				$valorfletet=$valorfletet+0;
			}
			
			
			$MiTemplate->parse("BLO_detalleOE", "detalleproductos", true);		
	} while ($ListDet->gonext());
	//general::writelog('r'.$rete_renta.',i'.$rete_iva.',c'.$rete_ica);
	if($valorfletet >0){
		$MiTemplate->set_var('valorfletetabla', '<tr>

								<td width="40"></td>

								<td width="80"></td>                

								<td width="200" ></td>

								<td width="100" align="left" >Valor Flete</td>

								<td width="50" ></td>                

								<td width="90"align="right">{valoflete}</td>

							</tr>
				');
	}
	
	
	$MiTemplate->set_var('valortotal',number_format($totallinea));
	$MiTemplate->set_var('valoflete', number_format($valorfletet));
	$MiTemplate->set_var('descuentot', ((number_format($valortotaldescu) == 0)?'-':number_format($valortotaldescu)));
	$MiTemplate->set_var('valoriva', number_format($valoriva));
	
	
		
}
if($id_tipoflujo==5){
	$MiTemplate->set_var('larencdescripcion', '230');
	$MiTemplate->set_var('larenccantidad', '20');
	$MiTemplate->set_var('larencunimed', '40');
	$MiTemplate->set_var('larencproveedor', '100');
	$MiTemplate->set_var('larencprecio', '60');
	$MiTemplate->set_var('larenctotal', '60');

	$MiTemplate->set_var('lardetdescripcion', '250');
	$MiTemplate->set_var('lardetcantidad', '40');
	$MiTemplate->set_var('lardetunimed', '50');
	$MiTemplate->set_var('lardetproveedor', '130');
	$MiTemplate->set_var('lardetprecio', '40');
	$MiTemplate->set_var('lardettotal', '70');

}else{
	$MiTemplate->set_var('ocultaprovini', '<!--');
	$MiTemplate->set_var('ocultaprovfin', '-->');
	$MiTemplate->set_var('larencdescripcion', '180');
	$MiTemplate->set_var('larenccantidad', '40');
	$MiTemplate->set_var('larencunimed', '30');
	$MiTemplate->set_var('larencproveedor', '100');
	$MiTemplate->set_var('larencprecio', '80');
	$MiTemplate->set_var('larenctotal', '90');
	$MiTemplate->set_var('larenctipodespacho','40');
	$MiTemplate->set_var('larencunimed','40');
	
	$MiTemplate->set_var('lardetdescripcion', '180');
	$MiTemplate->set_var('lardetcantidad', '40');
	$MiTemplate->set_var('lardetunimed', '60');
	$MiTemplate->set_var('lardetproveedor', '130');
	$MiTemplate->set_var('lardetprecio', '70');
	$MiTemplate->set_var('lardetcantidad', '50');
	$MiTemplate->set_var('lardettotal', '90');
	$MiTemplate->set_var('lardettipodespacho','40');
	$MiTemplate->set_var('lardetunimed','40');
	$MiTemplate->set_var('lardetinstalacion','60');
	$MiTemplate->set_var('lardetpeso','30');
	$MiTemplate->set_var('lardetcodprod','40');
	$MiTemplate->set_var('lardetcodtipo','30');
}

$List = new connlist;
$Registro = new dtoinfocliente;
$Registro->rut	= $rut;
$List->addlast($Registro);

bizcve::getCliente($List);
$List->gofirst();
//Mantis 30518: Deshabilitacion boton de generacion de cotizacion Inicio
if ( $List->getelem()->feccrea < $List->getelem()->fchalimite  ){
    $btn = 'disabled';
}else{
    $btn = '';    
}
$MiTemplate->set_var('btn',$btn);
//Mantis 30518: Deshabilitacion boton de generacion de cotizacion Fin
if (!$List->isvoid()) {
	$List->gofirst();
	if($List->getelem()->locksap)
		$locksap='<li>Cliente Bloqueado en SAP</li>';
	if($List->getelem()->lockmoro)
		$lockmoro='<li> Cliente Bloqueado por Morosidad</li>';
	if($List->getelem()->lockcve)
		$lockcve ='<li> Cliente Bloqueado en CVE </li>';
	if($List->getelem()->lockfecha)
		$lockfecha ='<li>Cliente Bloqueado por vencimiento de Disponible</li>';			
	if($List->getelem()->comentario)
		$comentario ='<li>'.$List->getelem()->comentario.'</li>';

	$MiTemplate->set_var('observacionescl', $locksap.$lockmoro.$lockcve.$lockfecha.$comentario);
	$MiTemplate->set_var('rut', $List->getelem()->rut);
	
	$configclitipo = new getidcontribuyente("CONTRIBUYENTE");
	$opcion=$configclitipo->JURIDICO;
	$opcion1=$configclitipo->EMPRESARIAL;
	
	$MiTemplate->set_var('rutcliented', (($List->getelem()->id_contribuyente == $opcion1)?$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut) : $List->getelem()->rut ));	
	$rutcliente=$List->getelem()->rut;	
	$MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente);			
	$MiTemplate->set_var('contacto', $List->getelem()->apellido.' '.$List->getelem()->apellido1.' '.$List->getelem()->contacto);					
	$MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);		
	$MiTemplate->set_var('email', $List->getelem()->email);	
    $MiTemplate->set_var('nomtipdocpago', $List->getelem()->nomtipdocpago);
    $validacobroriva = $List->getelem()->rete_iva;
    $validacobrorenta=$List->getelem()->rete_renta;
	$validacobroica=$List->getelem()->rete_ica;	    	
}

$rete_iva2 = (($validacobroriva == 1)? round($rete_iva) : $rete_iva = 0);
$rete_ica2 = (($validacobroica == 1)? round($rete_ica) : $rete_ica = 0);
$rete_renta2 = (($validacobrorenta == 1)? round($rete_renta) : $rete_renta = 0);
$sumtotal = $totallinea - $rete_renta2 - $rete_iva2 - $rete_ica2;
//general::writelog('t'.$totallinea.'r'.$rete_renta.'i'.$rete_iva2.'c'.$rete_ica.'st'.$sumtotal);

if($visible_reteiva==true){
	$MiTemplate->set_var('visible_reteiva', '<tr>
								<td width="40"></td><td width="80"></td><td width="200" ></td>
								<td width="100" align="left" >Retenci&oacute;n IVA</td><td width="50" ></td>                
								<td width="90"align="right">{rete_iva}</td></tr>');
}
else{
	$MiTemplate->set_var('visible_reteiva', '');
}

if($visible_renta== true){
	$MiTemplate->set_var('visible_renta', '<tr>
								<td width="40"></td><td width="80"></td><td width="200" ></td>
								<td width="100" align="left" >Retenci&oacute;n Renta</td><td width="50" ></td>                
								<td width="90"align="right">{rete_renta}</td></tr>');
}
else{
	$MiTemplate->set_var('visible_renta', '');
}

if($visible_ica == true){
	$MiTemplate->set_var('visible_ica', '<tr>
								<td width="40"></td><td width="80"></td><td width="200" ></td>
								<td width="100" align="left" >Retenci&oacute;n ICA</td><td width="50" ></td>
								<td width="90"align="right">{rete_ica}</td></tr>');
}
else{
	$MiTemplate->set_var('visible_ica', '');
}
$MiTemplate->set_var('viva', number_format($totaliva));
$MiTemplate->set_var('rete_ica',(($validacobroica == 1)? number_format($totalica): $totalica = 0 ));
$MiTemplate->set_var('rete_renta', (($validacobrorenta == 1)? number_format($totalrenta) : $totalrenta = 0 ));
$MiTemplate->set_var('rete_iva',number_format($rete_iva2));
$MiTemplate->set_var('sumtotal', number_format($sumtotal));
/*Actualizacion OE Total*/
//$dao = new daoordenent;
//$dao->updateoe($id_ordenent,$sumtotal,0,$totaliva);
/*Fin Actualizacion OE Total*/

$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
	$MiTemplate->set_var('id_ordenent', $id_ordenent);		
	$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);	
	$MiTemplate->set_var('giro', $ListEnc->getelem()->giro);
	$MiTemplate->set_var('direccion', $ListEnc->getelem()->direccion);				
	$MiTemplate->set_var('nomcomuna', $ListEnc->getelem()->comuna);		
}



$List = new connlist;
$Registro = new dtotracking;
$Registro->id_ordenent	=  $id_ordenent;
$List->addlast($Registro);

bizcve::gettracking($List);
$List->gofirst();
$MiTemplate->set_block('main' , "listatracking" , "BLO_listatracking");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('tipo', $List->getelem()->tipo);
		$MiTemplate->set_var('descripcion_track', $List->getelem()->descripcion);						
		$MiTemplate->set_var('usuario_track', $List->getelem()->usrcrea);			
		$MiTemplate->set_var('fecha_track', $List->getelem()->feccrea);			
		$MiTemplate->parse("BLO_listatracking", "listatracking", true);	
	} while ($List->gonext());
}

if ($ses_usr_codlocal == $codlocalcsum || $ses_usr_codlocal == $codlocalventa) {
	$MiTemplate->set_var('rutcliente', $rutcliente);	
	$List = new connlist;
	$Registro = new dtocambiosestado;
	$Registro->id_estado_origen = $id_estado;
	$Registro->id_ordenent	=  $id_ordenent;
	$Registro->tipo = 'OE';
	$List->addlast($Registro);
	bizcve::getcambiosestadooe($List);
	$List->gofirst();
	$MiTemplate->set_block('main' , "Botones" , "BLO_Botones");
	if (!$List->isvoid()) {
		do {
			$id_estado=$List->getelem()->id_estado_origen;
			$MiTemplate->set_var('ordenent', $id_ordenent);			
			$MiTemplate->set_var('id_estado_origen', $List->getelem()->id_estado_origen);
			$origen=$List->getelem()->id_estado_origen;	
			$MiTemplate->set_var('origen', $List->getelem()->id_estado_origen);			
			$MiTemplate->set_var('estadoterminal', $List->getelem()->estadoterminal);			
			$MiTemplate->set_var('id_estado_destino', $List->getelem()->id_estado_destino);						
//DESHABILITO EL ANULAR LA OE A NO SER QUE SEAN CIERTOS PERFILES LOS QUE LO PIDEN
//PERFIL ASIGNADO A PERFIL DE GERENTE MAYORISTA
                        $Lista = new connlist;
                        bizcve::infousuarioper($Lista,$ses_usr_id);
                        $Lista->gofirst();
                        $ID1 = $Lista->getelem()->per_id;
                        //general::alert($ID1);
                    	    if ($ID1!=12 && $ID1!=21 && $ID1!=31) {
								if($List->getelem()->id_estado_destino=='ON'){
									$MiTemplate->set_var('boton', 'disabled');
								}else{
									$MiTemplate->set_var('boton', '');
								}
                        	}else{
                        		if($sap==1){
    	                	    		if($List->getelem()->id_estado_destino=='ON'){
											$MiTemplate->set_var('boton', 'disabled');
		                   	    		}
                    	    	}else{
                    	    		if($List->getelem()->id_estado_destino=='ON'){
    	                	    		if((date("d/m/Y", time())) != ($fecha)){
											$MiTemplate->set_var('boton', 'disabled');
	                    	    		}
	                                }else{
										$MiTemplate->set_var('boton', '');
	                                }
                    	    	}
                        		
                        	}

			$MiTemplate->set_var('nomaccion', $List->getelem()->nomaccion);			
			if ($List->getelem()->color=='red'){
				$MiTemplate->set_var('color', ';color:#FF0000');					
			}else{
				$MiTemplate->set_var('color', '');				
			}				
			$MiTemplate->parse("BLO_Botones", "Botones", true);	
		} while ($List->gonext());

	}
	if($id_estado=='OF'){
		$MiTemplate->set_var('valimpri', 'hidden');
		$MiTemplate->set_var('btn', $btn);
	}
	
	if ($id_estado=='OG'){
		//$genfactura="<input type='button' class='Textonormal' style='width:200;color:#FF0000' name='Button'  value='Imprimir Factura' onClick=GenFactura($id_ordenent)>";
		//$MiTemplate->set_var('genfactura', $genfactura);
		if($validgui == 1){
			$MiTemplate->set_var('imprimirgde', $imprimirgde);
		}else{
			$imprimirgde="<input type='button' class='Textonormal' style='width:200;color:#FF0000' name='Button' value='Imprimir Guia de Despacho' onClick=GenGuiaDespacho($id_ordenent)>";
			$MiTemplate->set_var('imprimirgde', $imprimirgde);
		}
			
		/*Valida el boton de  impresion*/
		$MiTemplate->set_var('valimpri', 'hidden');
                $MiTemplate->set_var('btn', $btn);
		$MiTemplate->set_var('td', '');
		/*Fin Valida el boton de  impresion*/		
	
		if($id_tipoflujo==5){
			//PREGUNTAMOS SI EL USUARIO TIENE PERMISO PARA CERRAR LA OE.
			$List = new connlist;
			bizcve::infousuarioper($List,$ses_usr_id);
			$List->gofirst();
			$ID = $List->getelem()->per_id;
			if ($ID==6||$ID==23||$ID==25||$ID==27||$ID==2||$ID==12||$ID==20||$ID==26) {
				$cerraroe="<input type='button' class='Textonormal' style='width:200' name='Button'  value='Finalizar Orden de Entrega' onClick=CerrarOE('$origen',$id_ordenent)>";
				$MiTemplate->set_var('cerraroe', $cerraroe);					
			}
		}
	}
}
else {
	$MiTemplate->set_block('main' , "Botones" , "BLO_Botones");
	$MiTemplate->set_var('mensajenoboton', '<center>Esta Orden de Entrega no pertenece al centro de suministro actual. No puede ejecutar acciones sobre ella</center>');		
}

$ListEnci = new connlist;
$ListDeti = new connlist;
$Registro = new dtoencordenpicking;
$Registro->id_ordenent	= $id_ordenent;
$ListEnci->addlast($Registro);
bizcve::getordenpick($ListEnci, $ListDeti);

$ListEnci->gofirst();
$MiTemplate->set_block('main' , "ordenpick" , "BLO_listaordenpick");
if (!$ListEnci->isvoid()) {
	do {
 		$MiTemplate->set_var('tipo_doc', 'Orden de Picking');		
 		$MiTemplate->set_var('id_ordenpicking', "<a href=\"../monitororpick/monitor_orpick_00.php?buscar=".$ListEnci->getelem()->id_ordenpicking."&filtro=4\">".$ListEnci->getelem()->id_ordenpicking."</a>");
		$MiTemplate->set_var('nomestado', $ListEnci->getelem()->nomestado);
		$MiTemplate->set_var('feccrea', general::formato_fecha($ListEnci->getelem()->feccrea));				
		$MiTemplate->set_var('usuariocrea', $ListEnci->getelem()->usuariocrea);
		$MiTemplate->parse("BLO_listaordenpick", "ordenpick", true);	
	} while ($ListEnci->gonext());
}
else {
 		$MiTemplate->set_var('sindocumentos','No existen documentos relacionados a esta Orden de Entrega');
}
/*para la cotizacion asociada*/
/*si puede ver las cotizaciones*/
	$ListEnco  = new connlist;
	$ListDeto  = new connlist;	
	$mRegistro = new dtocotizacion;
   	$mRegistro->id_cotizacion=$id_cotizacion;
	$ListEnco->addlast($mRegistro);
	bizcve::getcotizacion($ListEnco, $ListDeto);
	$ListEnco->gofirst();	
if (!$ListEnco->isvoid()) {
	do {
 		$MiTemplate->set_var('tipo_doc', 'Cotizaci&oacute;n');		
 		$MiTemplate->set_var('id_cotizacion', $ListEnco->getelem()->id_cotizacion);
		$MiTemplate->set_var('nomestado', $ListEnco->getelem()->nomestado);
		$MiTemplate->set_var('feccrea', general::formato_fecha($ListEnco->getelem()->feccrea));				
		$MiTemplate->set_var('usuariocrea', $ListEnco->getelem()->usuariocrea);
	} while ($ListEnco->gonext());
}
if($id_tipoflujo==5){
	$ListEnce  = new connlist;
	$ListDete  = new connlist;	
	$mRegistro = new dtodocumento;
   	$mRegistro->numorigen=$id_ordenent;
	$ListEnce->addlast($mRegistro);
	bizcve::getdocumento($ListEnce, $ListDete);
	$ListEnce->gofirst();

	$MiTemplate->set_block('main' , "tabladocfac" , "BLO_tabladocfac");
	if (!$ListEnce->isvoid()) {
		do {
			$id_tipodocumento=$ListEnce->getelem()->id_tipodocumento;
			if($id_tipodocumento==1){
				$nomdoc = 'Factura Proveedor';
				$nomfuncion = 'verdocumentofct';
			}elseif($id_tipodocumento==2){
				$nomdoc = 'Guia de despacho Proveedor';
				$nomfuncion = 'verdocumentogde';
			}
			$MiTemplate->set_var('tabla_fct', "
			<tr valign=top>
			<td width=180 align=left>&nbsp;$nomdoc</td>
			<td width=80 align=center><a href=javascript:$nomfuncion(".$ListEnce->getelem()->id_documento.");>".$ListEnce->getelem()->id_documento."</td>
			<td width=150 align=center>---</td>
			<td width=100 align=center>".general::formato_fecha($ListEnce->getelem()->feccrea)."</td>								
			<td width=100 align=left>&nbsp;".$ListEnce->getelem()->usrcrea."</td>								
			</tr>	");
			$MiTemplate->parse("BLO_tabladocfac", "tabladocfac", true);
		}while ($ListEnce->gonext());
	}
}

// Abrir la ventana da pago de inmediato si la OE está en estado OA
if ($id_estado == 'OA') {
	$MiTemplate->set_var('pago', $_REQUEST['pago']);
}

/**/
$MiTemplate->parse("OUT_M", array("header", "main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
}
?>
