<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
/////////////////////////////////////////////////////////////////////
$visibleIMP = new getidvisibleimpuestos("VISIBLE_IMPUESTOS");
$visible_fletes=$visibleIMP->FLETES;
$visible_renta=$visibleIMP->IMPUESTO_RENTA;
$visible_ica=$visibleIMP->IMPUESTO_ICA;
$visible_reteiva=$visibleIMP->IMPUESTO_RETEIVA;

$MiTemplate = new template;
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_file("main", TEMPLATE . "nuevacotizacion/nueva_cotizacion_formato_nuevo_04_pop.html");
//////////////////////////////////////////////////////////////////////
$ListEnc = new connlist;
$ListDet = new connlist;
$Registro = new dtocotizacion;

$Registro->id_cotizacion	=  $_REQUEST['id_cotizacion'];
$Registro->prorrateoflete =1;   
$ListEnc->addlast($Registro);
bizcve::getcotizacion($ListEnc, $ListDet);

$ListEnc->gofirst();
//if (!$ListEnc->isvoid()) {
   	$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);
   	$obra=explode("||",$ListEnc->getelem()->direccion);
	$MiTemplate ->set_var("obra",($obra[1]!=''?'<tr><td align="left" colspan="3"><b class="negrita">OBRA : </b>'.$obra[1].'</td></tr>':''));	
	$MiTemplate->set_var('direccion', $obra[0]);
	$MiTemplate->set_var('validdesde',general::formato_fecha($ListEnc->getelem()->validdesde) );
	$MiTemplate->set_var('validhasta',general::formato_fecha($ListEnc->getelem()->validhasta) );
        switch($tipo){
        case 'proforma':
            $MiTemplate->set_var('tipo_spa', 'PROFORMA');
            break;
        case 'cotizacion':
        default:
            $MiTemplate->set_var('tipo_spa', 'COTIZACI&Oacute;N');
            break;
    }	
	$id_cotizacion=$ListEnc->getelem()->id_cotizacion;		
	$MiTemplate->set_var('id_cotizacion', $ListEnc->getelem()->id_cotizacion);
	$estado=$ListEnc->getelem()->id_estado;	
	$id_estado=$ListEnc->getelem()->id_estado;					
	$codigovendedor=$ListEnc->getelem()->codigovendedor;
	$MiTemplate->set_var('observaciones', $ListEnc->getelem()->nota);
	$rut=$ListEnc->getelem()->rutcliente;
	$MiTemplate->set_var('codlocalventa', $ListEnc->getelem()->codlocalcsum);
	$MiTemplate->set_var('nom_local', $ListEnc->getelem()->nom_localcsum);		
	$MiTemplate->set_var('dir_local', $ListEnc->getelem()->dir_localcsum);			
	$MiTemplate->set_var('iva',$ListEnc->getelem()->iva);
	$MiTemplate->set_var('viva',number_format($ListEnc->getelem()->cot_iva));	
	$valortotal  =round($ListEnc->getelem()->valortotal + $ListEnc->getelem()->rete_renta + $ListEnc->getelem()->rete_iva + $ListEnc->getelem()->rete_ica+0);
	$sumtotal    =($valortotal - $ListEnc->getelem()->rete_renta - $ListEnc->getelem()->rete_iva - $ListEnc->getelem()->rete_ica);
	$margentotal =$ListEnc->getelem()->margentotal;			
	$MiTemplate->set_var('usuariocrea', $ListEnc->getelem()->usuariocrea);			
    
	$MiTemplate->set_var('tabla_reteiva',($visible_reteiva == true?'<tr><td align="left">Retención IVA</td><td></td><td align="right">{rete_iva}&nbsp;</td></tr>':''));
	$MiTemplate->set_var('tabla_ica',($visible_ica == true?'<tr><td align="left">Retención ICA</td><td></td><td align="right">{rete_ica}&nbsp;</td></tr>':''));
	$MiTemplate->set_var('tabla_renta',($visible_renta == true?'<tr><td align="left">Retención Renta</td><td></td><td align="right">{rete_renta}&nbsp;</td></tr>':''));
	$MiTemplate->set_var('rete_renta',number_format($ListEnc->getelem()->rete_renta));
	$MiTemplate->set_var('rete_iva',number_format($ListEnc->getelem()->rete_iva));
	$MiTemplate->set_var('rete_ica',number_format($ListEnc->getelem()->rete_ica));
        
            $date=$ListEnc->getelem()->feccrea;
            list($year, $month, $day, $hour, $minute, $sec) = split('[- :]', $date); 
            //the variables should be arranged acording to your date format and so the separators
            $cotizTimestamp=mktime($hour, $minute,$sec, $month, $day, $year);
            $razonSocCencosud = ($cotizTimestamp < FECHACAMBIORAZSOC) ? "Easy Colombia S.A" : "Cencosud Colombia S.A.";
        $MiTemplate->set_var('razonsoccencosud',$razonSocCencosud);
//}

$ListDet->gofirst();
if (!$ListDet->isvoid()) {
	$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detallecotizacion");
	do {
		$ListDet->getelem()->id_cotizacion;
		$MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
		$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
                $MiTemplate->set_var('grupocat', $ListDet->getelem()->grupocat);
		$MiTemplate->set_var('cantidad', $ListDet->getelem()->cantidad);
		$precio=($ListDet->getelem()->pventaneto+$ListDet->getelem()->cargoflete);		
		$MiTemplate->set_var('precio',number_format(($precio+($ListDet->getelem()->descuento/$ListDet->getelem()->cantidad)),2) );		
		$MiTemplate->set_var('totallinea', number_format(round($ListDet->getelem()->totallinea)));
		$MiTemplate->set_var('descuento%',number_format(((($ListDet->getelem()->descuento/$ListDet->getelem()->cantidad)*100)/($precio+($ListDet->getelem()->descuento/$ListDet->getelem()->cantidad))),1).'%');
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
		
	
	if($valorfletet >0 && $visible_fletes == true){
		$MiTemplate->set_var('valorfletetabla','<tr>
					<td align="left">Valor Fletes</td>
					<td></td>
					<td align="right">{valorfletet}&nbsp;</td>
					</tr>');
		$MiTemplate->set_var('valorfletet', number_format($valorfletet));
	}

	$MiTemplate->set_var('descuentot',number_format($descuentot));
	$MiTemplate->set_var('valortotal',number_format($valortotal));
	$MiTemplate->set_var('valoriva', number_format($valoriva+0));
	$MiTemplate->set_var('sumtotal', number_format($sumtotal+0));			
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
	//$MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);		
	$MiTemplate->set_var('comentario', $List->getelem()->comentario);			
	$MiTemplate->set_var('nomtipdocpago', $List->getelem()->nomtipdocpago);
	$validacobrorenta=$ListEnc->getelem()->rete_renta;
	$validacobroica=$ListEnc->getelem()->rete_ica;
	$rutdcliente=$List->getelem()->rut;	
	
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


$Listdirdes  = new connlist;
$id_dirdes->id_direccion=$ListEnc->getelem()->id_dirdespacho;
$Listdirdes->addlast($id_dirdes);
bizcve::getdirdesp($Listdirdes);
$Listdirdes->gofirst();
if($ListEnc->getelem()->id_dirdespacho > 0)
{
	$Listlocalizacion  = new connlist;
	$registrolocalizacion->id_localizacion=$Listdirdes->getelem()->id_comuna;
	$Listlocalizacion->addlast($registrolocalizacion);
	bizcve::getlocalizacion($Listlocalizacion);
	$Listlocalizacion->gofirst();
	
	if (!$Listlocalizacion->isvoid()) {
		do {
			$MiTemplate->set_var('email', $Listdirdes->getelem()->email);
			$MiTemplate->set_var('contacto', $Listdirdes->getelem()->contacto);
			$MiTemplate->set_var('nota', $Listdirdes->getelem()->comentario);
			$MiTemplate->set_var('fonocontacto', $Listdirdes->getelem()->fonocontacto);
			$MiTemplate->set_var('ciudad', $Listlocalizacion->getelem()->ciudad);
			$MiTemplate->set_var('comuna', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
			$MiTemplate->set_var('departamento', $Listlocalizacion->getelem()->departamento);
		
		} while ($Listlocalizacion->gonext());
	}		
}
else {
	$MiTemplate->set_var('email', $List->getelem()->email);
	$MiTemplate->set_var('contacto', $List->getelem()->contacto.' '.$List->getelem()->apellido.' '.$List->getelem()->apellido1);
	$MiTemplate->set_var('nota', $List->getelem()->comentario);
	$MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);
	$MiTemplate->set_var('ciudad', $localiciu);
	$MiTemplate->set_var('comuna', $localibar);
	$MiTemplate->set_var('departamento', $localidep);
}

////detalle impuestos////	
$Listimp = new connlist;
$Registrop = new dtocotizacion;
$grupoimp='cot_iva'; 
bizcve::getdetalleimpuesto($Listimp, $id_cotizacion,$grupoimp);
$Listimp->gofirst();


if (!$Listimp->isvoid()) {
	
	$MiTemplate->set_block('main' , "prueba" , "BLO_prueba");
	do {
		$MiTemplate->set_var('totalsiniva', number_format($Listimp->getelem()->sumtotaliva));
		$MiTemplate->set_var('ivap', $Listimp->getelem()->cot_iva);
		$MiTemplate->set_var('impivatotal', number_format($Listimp->getelem()->sumiva));
		$MiTemplate->parse("BLO_prueba", "prueba", true);
		$MiTemplate->set_var('signoivap','%');
	} while ($Listimp->gonext());
}

if($validacobrorenta >= 1 && $visible_renta == true){
	
			$MiTemplate->set_var('codigoreterenta','
<td align="center" class="textonormal">DETALLE DE RENTA INCLUIDO EN LA COTIZACION<fieldset>
	<table align="center" border="0" width="640" class="tabla2" >
	<tr>
		<td width="30%" align="center">Descripción</td>
		<td width="3%" align="center" ></td>                
		<td width="30%" align="center">Base Rete Fuente</td>
		<td width="3%" align="center"></td>								
		<td width="30%"  align="center">Vlr Rete Fuente</td>
		<td width="3%" align="center"></td>  
	</tr>');

	$Listimp = new connlist;
	$Registrop = new dtocotizacion;
	$grupoimp='rete_renta'; 
	bizcve::getdetalleimpuesto($Listimp, $id_cotizacion,$grupoimp);	
	$Listimp->gofirst();
	if (!$Listimp->isvoid()) {
	
	$MiTemplate->set_block('main' , "ciclorenta" , "BLO_ciclorenta");
	
		do  {
			$MiTemplate->set_var('imprete_renta', $Listimp->getelem()->rete_renta);
			$MiTemplate->set_var('imprenta', number_format($Listimp->getelem()->sumiva));
			$MiTemplate->set_var('$totalrenta', number_format($Listimp->getelem()->sumtotaliva));
			$MiTemplate->set_var('signorenta','%');
			$MiTemplate->parse("BLO_ciclorenta", "ciclorenta", true);
		} while ($Listimp->gonext());
	}

$MiTemplate->set_var('codigorenta_fin','</table></fieldset></td>');
}

if($validacobroica >= 1 && $visible_ica==true)
		{
			$MiTemplate->set_var('codigoreteica','
<td align="center" class="textonormal">DETALLE DE ICA INCLUIDO EN LA COTIZACION<fieldset>
	<table align="center" border="0" width="640" class="tabla2" >
	<tr>
		<td width="30%" align="center">Descripción</td>
		<td width="3%" align="center" ></td>                
		<td width="30%" align="center">Base Rete ICA</td>
		<td width="3%" align="center"></td>								
		<td width="30%"  align="center">Vlr Rete ICA</td>
		<td width="3%" align="center"></td>  
	</tr>');	

	$Listimp = new connlist;
	$Registrop = new dtocotizacion;
	$grupoimp='rete_ica'; 
	bizcve::getdetalleimpuesto($Listimp, $id_cotizacion,$grupoimp);		
	$Listimp->gofirst();

	if (!$Listimp->isvoid()) {
	
		$MiTemplate->set_block('main' , "cicloica" , "BLO_cicloica");
		do {
			$MiTemplate->set_var('imprete_ica', $Listimp->getelem()->rete_ica);
			$MiTemplate->set_var('impica', number_format($Listimp->getelem()->sumiva));
			$MiTemplate->set_var('totalica', number_format($Listimp->getelem()->sumtotaliva));
			$MiTemplate->set_var('signoica','%');		
			$MiTemplate->parse("BLO_cicloica", "cicloica", true);
		} while ($Listimp->gonext());
	}
$MiTemplate->set_var('codigoica_fin','</table></fieldset></td>');
}

///////////////////////mensajes del editor de contenido///////////////
$confimp = ($tipo == 'proforma') ? new getidmensaje("INFO_PROFORMA", TRUE) : new getidmensaje("MENSAJES");
$opcion=$confimp->ID_MENSAJE_MA;
$Listiop = new connlist;
bizcve::getinfoop($Listiop, $opcion);
$Listiop->gofirst();
if(!$Listiop->isvoid()){
    if($cotizTimestamp < FECHACAMBIORAZSOC){
	$MiTemplate->set_var('infocotioe',str_replace("CENCOSUD COLOMBIA S.A", "EASY COLOMBIA S.A", $Listiop->getelem()->var_descripcion));
    }else{
        $MiTemplate->set_var('infocotioe',$Listiop->getelem()->var_descripcion);
    }
	
}

//$confimp = new getidmensaje("MENSAJES");
$opcion=$confimp->ID_MENSAJE_MB;
$Listiop = new connlist;
bizcve::getinfoop($Listiop, $opcion);
$Listiop->gofirst();
if(!$Listiop->isvoid()){
    if($cotizTimestamp < FECHACAMBIORAZSOC){
	$MiTemplate->set_var('infocotioe2',str_replace("CENCOSUD COLOMBIA S.A", "EASY COLOMBIA S.A", $Listiop->getelem()->var_descripcion));
    }else{
        $MiTemplate->set_var('infocotioe2',$Listiop->getelem()->var_descripcion);
    }
	
}

//$confimp = new getidmensaje("MENSAJES");
$opcion=$confimp->ID_MENSAJE_MC;
bizcve::getinfoop($Listiop, $opcion);
$Listiop->gofirst();
if(!$Listiop->isvoid()){
    if($cotizTimestamp < FECHACAMBIORAZSOC){
	$MiTemplate->set_var('infocotioe3','<table align="center" border="0" width="640" cellpadding="2"><tr>
				<td>'.str_replace("CENCOSUD COLOMBIA S.A", "EASY COLOMBIA S.A", $Listiop->getelem()->var_descripcion.'</td></tr></table>'));
    }else{
        $MiTemplate->set_var('infocotioe3','<table align="center" border="0" width="640" cellpadding="2"><tr>
				<td>'.$Listiop->getelem()->var_descripcion.'</td></tr></table>');
    }
	
}

//$confimp = new getidmensaje("MENSAJES");
$opcion=$confimp->ID_MENSAJE_MD;
bizcve::getinfoop($Listiop, $opcion);
$Listiop->gofirst();
if(!$Listiop->isvoid()){
    if($cotizTimestamp < FECHACAMBIORAZSOC){
	$MiTemplate->set_var('infocotioe4','<table align="center" border="0" width="640" cellpadding="2"><tr>
				<td>'.str_replace("CENCOSUD COLOMBIA S.A", "EASY COLOMBIA S.A", $Listiop->getelem()->var_descripcion.'</td></tr></table>'));
    }else{
        $MiTemplate->set_var('infocotioe4','<table align="center" border="0" width="640" cellpadding="2"><tr>
				<td>'.$Listiop->getelem()->var_descripcion.'</td></tr></table>');
    }
	
}

//$confimp = new getidmensaje("MENSAJES");
$opcion=$confimp->ID_MENSAJE_ME;
bizcve::getinfoop($Listiop, $opcion);
$Listiop->gofirst();
if(!$Listiop->isvoid()){
    if($cotizTimestamp < FECHACAMBIORAZSOC){
	$MiTemplate->set_var('infocotioe5',str_replace("CENCOSUD COLOMBIA S.A", "EASY COLOMBIA S.A", $Listiop->getelem()->var_descripcion));
    }else{
        $MiTemplate->set_var('infocotioe5',$Listiop->getelem()->var_descripcion);
    }
	
}
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
