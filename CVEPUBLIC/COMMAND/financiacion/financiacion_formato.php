<?
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE INCLUSION /////////////////////////
///////////////////////// ZONA DE ACCIONES /////////////////////////
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_var("TITULO", TITULO);
//$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_file("main", TEMPLATE . "financiacion/financiacion_formato.html");
//echo $_GET['string_financiacion'];
$string_financi=explode('|',$_GET['string_financiacion']);
$MiTemplate ->set_var("vtotal+int",$string_financi[0]);
$MiTemplate ->set_var("cini",$string_financi[1]);
$MiTemplate ->set_var("ncheq",$string_financi[2]);
$MiTemplate ->set_var("vfinan",$string_financi[3]);
$MiTemplate ->set_var("ifinan",$string_financi[4]);
$MiTemplate ->set_var("vxcheq",$string_financi[5]);
$MiTemplate ->set_var("ivaint",$string_financi[8]);
$MiTemplate ->set_var("baint",$string_financi[9]);
$MiTemplate ->set_var("vint",$string_financi[7]);
//echo 'resultado'.$string_financi[10];
$ListEnc = new connlist;
$ListDet = new connlist;
$ListDir = new connlist;
$Registro = new dtocotizacion;
$Registro->id_cotizacion	=  $string_financi[10];
$Registro->prorrateoflete =1;   
$ListEnc->addlast($Registro);
bizcve::getcotizacion($ListEnc, $ListDet);

$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {

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
}
/*Datos de Cliente*/
$List  = new connlist;
$mRegistro->rut=$rut;
$List->addlast($mRegistro);
bizcve::getCliente($List);
$List->gofirst();
	//$MiTemplate->set_var('rutdv',$rut.'-'.general::digiVer($rut));
	$MiTemplate->set_var('rut',$rut);
if (!$List->isvoid()) {
	$MiTemplate->set_var('dcrazonsoc', $List->getelem()->razonsoc);
	$MiTemplate->set_var('dcfonocontacto', $List->getelem()->fonocontacto);
	$MiTemplate->set_var('dcnomciudade', $List->getelem()->nomciudad);
	$MiTemplate->set_var('dcdireccion', $List->getelem()->direccion);
	$MiTemplate->set_var('contacto', $List->getelem()->contacto);
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
/*FinDespliegue de Datos de Cliente*/

$ListDet->gofirst();
if (!$ListDet->isvoid()) {
	$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detallecotizacion");
	do {
		$ListDet->getelem()->id_cotizacion;
		$MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
		$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
		$MiTemplate->set_var('cantidad', $ListDet->getelem()->cantidad);
		$precio=($ListDet->getelem()->pventaneto+$ListDet->getelem()->cargoflete);		
		$MiTemplate->set_var('precio',number_format($precio,2) );		
		$MiTemplate->set_var('totallinea', number_format(round($ListDet->getelem()->totallinea)));
		//$contadorlineas=$contadorlineas+1;
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
	if($estado=='CB'){
		$MiTemplate->set_var('margentotal', "<td>Margen</td><td><span class='textomargen'>".$margentotal."%</span></td>");		
	}			
}
$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

?>