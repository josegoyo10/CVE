<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
	
///////////////////////// ZONA DE ACCIONES /////////////////////////
	
/*Funcion Agrega los ceros a la izquierda de la fucion EAN*/
function calcula_num_os($os){
	
	$long_numero = strlen($os);
	
	if($long_numero == 7)
	    $id_os = $os;
	
	if($long_numero == 6)
	    $id_os = "0".$os;
	
	if($long_numero == 5)
	    $id_os = "00".$os;   
	
	if($long_numero == 4)
	    $id_os = "000".$os;
	    
	if($long_numero == 3)
	    $id_os = "0000".$os;
	    
	if($long_numero == 2)
	    $id_os = "00000".$os;
	    
	if($long_numero == 1)
	    $id_os = "000000".$os;    
	
	return $id_os;
}
/*Fin funcion*/
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
global $rut,$id_cotizacion,$id_estado;
/*Inclusi?n de header*/
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);


/**/
$MiTemplate->set_var("TITULO", TITULO);
/* Inclusi?n de main*/
	$MiTemplate->set_file("main", TEMPLATE . "monitorcotiblo/imprimir_coblo_autoriza.htm");
/**/
/*para las ordenes de picking*/
$ListEnc = new connlist;
$ListDet = new connlist;
$ListDir = new connlist;
$Registro = new dtocotizacion;
$Registro->id_cotizacion	=  $_REQUEST['id_cotizacion'];
$Registro->prorrateoflete =1;   
$ListEnc->addlast($Registro);
bizcve::getcotizacion($ListEnc, $ListDet);

$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
    $MiTemplate->set_var('documento', 'CO');
    $MiTemplate->set_var('titulo', 'Cotizaci&#243;n');	
	$MiTemplate->set_var('validdesde',general::formato_fecha($ListEnc->getelem()->validdesde) );
	$MiTemplate->set_var('validhasta',general::formato_fecha($ListEnc->getelem()->validhasta) );
	$id_cotizacion=$ListEnc->getelem()->id_cotizacion;		
	$MiTemplate->set_var('id_cotizacion', $ListEnc->getelem()->id_cotizacion);
	$MiTemplate->set_var('id_estado', $ListEnc->getelem()->id_estado);
	$estado=$ListEnc->getelem()->id_estado;	
	$id_estado=$ListEnc->getelem()->id_estado;			
	$MiTemplate->set_var('nomestado', $ListEnc->getelem()->nomestado);
	$MiTemplate->set_var('id_tipoventa', $ListEnc->getelem()->id_tipoventa);
	$MiTemplate->set_var('nomtipoventa', $ListEnc->getelem()->nomtipoventa);
	$titulo_pagina=$ListEnc->getelem()->nomtipoventa;			
	$MiTemplate->set_var('codigovendedor', $ListEnc->getelem()->codigovendedor);
	$codigovendedor=$ListEnc->getelem()->codigovendedor;
	
	$MiTemplate->set_var('observaciones', $ListEnc->getelem()->nota);
	$rut=$ListEnc->getelem()->rutcliente;
	$MiTemplate->set_var('codlocalventa', $ListEnc->getelem()->codlocalcsum);
	$MiTemplate->set_var('nom_local', $ListEnc->getelem()->nom_localcsum);		
	$MiTemplate->set_var('dir_local', $ListEnc->getelem()->dir_localcsum);			
	$MiTemplate->set_var('condicion', $ListEnc->getelem()->condicion);
	$MiTemplate->set_var('iva',$ListEnc->getelem()->iva);
	$MiTemplate->set_var('viva',number_format($ListEnc->getelem()->cot_iva));
	$MiTemplate->set_var('rete_renta',number_format($ListEnc->getelem()->rete_renta));
	$MiTemplate->set_var('rete_iva',number_format($ListEnc->getelem()->rete_iva));
	$MiTemplate->set_var('rete_ica',number_format($ListEnc->getelem()->rete_ica));	
	$valortotal  =round($ListEnc->getelem()->valortotal + $ListEnc->getelem()->rete_renta + $ListEnc->getelem()->rete_iva + $ListEnc->getelem()->rete_ica+0);
	$sumtotal    =($valortotal - $ListEnc->getelem()->rete_renta - $ListEnc->getelem()->rete_iva - $ListEnc->getelem()->rete_ica);
	$margentotal =$ListEnc->getelem()->margentotal;			
	$MiTemplate->set_var('usuariocrea', $ListEnc->getelem()->usuariocrea);			
		if ($_REQUEST['id_estado_origen']=='CV'){
	    $MiTemplate->set_var('documento', 'NDV');
	    $MiTemplate->set_var('titulo', 'Nota de Venta');		    
		$MiTemplate->set_var('validdesde',general::formato_fecha($ListEnc->getelem()->nvevaliddesde) );
		$MiTemplate->set_var('validhasta',general::formato_fecha($ListEnc->getelem()->nvevalidhasta) );		    
	}	
		
}

$List = new connlist;
$Registro = new dtousuario;
$Registro->codigovendedor	=  $codigovendedor;

$List->addlast($Registro);
bizcve::GetUsers($List);
$List->gofirst();
$usr_nombre=$List->getelem()->usr_nombres;
$usr_apellidos=$List->getelem()->usr_apellidos;	
$MiTemplate->set_var('nombrevendedor', $usr_nombre.' '.$usr_apellidos);	
/* die(print("<pre>".htmlentities(print_r($List, true))."</pre>")); */
$MiTemplate->set_var('titulo_pagina', $titulo_pagina);

/* para el detalle de las cotizaciones*/
$contadorlineas=0;
$ListDet->gofirst();
if (!$ListDet->isvoid()) {
	$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detallecotizacion");
	do {
		$ListDet->getelem()->id_cotizacion;
		$MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
		//$MiTemplate->set_var('barra', $ListDet->getelem()->barra);
		$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
		$MiTemplate->set_var('cantidad', $ListDet->getelem()->cantidad);
		$MiTemplate->set_var('unimed', $ListDet->getelem()->unimed);
		$MiTemplate->set_var('codsubtipo', $ListDet->getelem()->codsubtipo);
		if ( $ListDet->getelem()->id_tipoentrega==1 and $ListDet->getelem()->id_tiporetiro==2){
	    			$MiTemplate->set_var('desp', 'Retira Cliente');		    
					}
		if ( $ListDet->getelem()->id_tipoentrega==2 and $ListDet->getelem()->id_tiporetiro==1)
					{
					$MiTemplate->set_var('desp', 'D. Programado');
					}
		if ( $ListDet->getelem()->id_tipoentrega==1 and $ListDet->getelem()->id_tiporetiro==1)
		{       $MiTemplate->set_var('desp', 'Retira Inmediato');}
		$MiTemplate->set_var('peso', $ListDet->getelem()->peso);
		$MiTemplate->set_var('descuento', $ListDet->getelem()->descuento);
		$MiTemplate->set_var('instala', $ListDet->getelem()->instalacion);
		$precio=($ListDet->getelem()->pventaneto+$ListDet->getelem()->cargoflete);		
		$MiTemplate->set_var('precio',number_format($precio,2) );		
		$MiTemplate->set_var('totallinea', number_format(round($ListDet->getelem()->totallinea)));
		$MiTemplate->set_var('descuento%',number_format(((($ListDet->getelem()->descuento/$ListDet->getelem()->cantidad)*100)/($precio+($ListDet->getelem()->descuento/$ListDet->getelem()->cantidad))),1));
		$contadorlineas=$contadorlineas+1;
		$descuentot=$descuentot+$ListDet->getelem()->descuento;
		if($ListDet->getelem()->codsubtipo=='DE' && $ListDet->getelem()->codtipo=='SV'){
			$valorfletet=$valorfletet+$ListDet->getelem()->totallinea;	
			}
			else{
				$valorfletet=$valorfletet+0;
			}
		$MiTemplate->parse("BLO_detallecotizacion", "detalleproductos", true);	
	} while ($ListDet->gonext());
	

		if($valorfletet >0){
		$MiTemplate->set_var('valorfletetabla', '<tr>
				<td width="40" ></td>
				<td width="80" ></td>
				<td width="200" ></td>                
				<td width="100" align="left">Valor Fletes</td>
				<td width="50"  ></td>								
				<td width="90"  align="right">{valorfletet}&nbsp;</td>  
			</tr>');
		$MiTemplate->set_var('valorfletet', number_format($valorfletet));}
	//$MiTemplate->set_var('contadorlineas', $contadorlineas);
	$MiTemplate->set_var('descuentot',number_format($descuentot));
	$MiTemplate->set_var('valortotal',number_format($valortotal));
	$MiTemplate->set_var('valoriva', number_format($valoriva+0));
	$MiTemplate->set_var('sumtotal', number_format($sumtotal+0));
	/* die($estado); */
	 if($estado=='CB'){
		$MiTemplate->set_var('margentotal', "<td>Margen</td><td><span class='textomargen'>".$margentotal."%</span></td>");		
	}			
}

/*para los datos del cliente*/
$List = new connlist;
$Registro = new dtoinfocliente;
$Registro->rut	= $rut;
$List->addlast($Registro);

bizcve::getCliente($List);
$List->gofirst();
$configclitipo = new getidcontribuyente("CONTRIBUYENTE");
$opcion=$configclitipo->JURIDICO;
$opcion1=$configclitipo->EMPRESARIAL;
if (!$List->isvoid()) {
	$MiTemplate->set_var('rut', $List->getelem()->rut);
	$MiTemplate->set_var('rutcliente', (($List->getelem()->id_contribuyente == $opcion1)?$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut) : $List->getelem()->rut ));	
	$MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente);			
	//$MiTemplate->set_var('contacto', $List->getelem()->contacto);					
	//$MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);		
	$MiTemplate->set_var('email', $List->getelem()->email);	
	$MiTemplate->set_var('comentario', $List->getelem()->comentario);			
	$MiTemplate->set_var('nomtipdocpago', $List->getelem()->nomtipdocpago);
	$validacobrorenta=$ListEnc->getelem()->rete_renta;
	$validacobroica=$ListEnc->getelem()->rete_ica;
	$rutdcliente=$List->getelem()->rut;	
	
}
/*Despliegue de Datos de Cliente*/
$List  = new connlist;
$rut=$rutdcliente;
$mRegistro->rut=$rut;
$List->addlast($mRegistro);
bizcve::getCliente($List);
$List->gofirst();
	$MiTemplate->set_var('rutdv',$rut.'-'.general::digiVer($rut));
	$MiTemplate->set_var('rut',$rut);
if (!$List->isvoid()) {
	$MiTemplate->set_var('dcrazonsoc', $List->getelem()->razonsoc);
	$MiTemplate->set_var('dcfonocontacto', $List->getelem()->fonocontacto);
	$MiTemplate->set_var('dcnomciudade', $List->getelem()->nomciudad);
	$MiTemplate->set_var('dcdireccion', $List->getelem()->direccion);
	$MiTemplate->set_var('giro', $List->getelem()->giro);
	$MiTemplate->set_var('dcid_ciudad', $List->getelem()->id_ciudad);
	$MiTemplate->set_var('dcnomrubro', $List->getelem()->nomrubro);
	$MiTemplate->set_var('dcdescripcion', $List->getelem()->giro);
$Listlocalizacion  = new connlist;
$registrolocalizacion->id_localizacion=$List->getelem()->id_comuna;
$Listlocalizacion->addlast($registrolocalizacion);
bizcve::getlocalizacion($Listlocalizacion);
$Listlocalizacion->gofirst();
if (!$Listlocalizacion->isvoid()) {
	do {
		$localiciu=$Listlocalizacion->getelem()->ciudad;
		$localibar=$Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad;
		$localidep=$Listlocalizacion->getelem()->departamento;
		$MiTemplate->set_var('dcciudad', $Listlocalizacion->getelem()->ciudad);
		$MiTemplate->set_var('dcnomcomuna', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
		$MiTemplate->set_var('dcdepartamento', $Listlocalizacion->getelem()->departamento);
		
	} while ($Listlocalizacion->gonext());
}
	
}

///////////////////////// ZONA PIE DE PAGINA /////////////////////////

$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>