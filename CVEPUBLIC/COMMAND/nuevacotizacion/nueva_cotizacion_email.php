<?php 
//$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);  
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
require_once('../../INCLUDE/tcpdf/config/lang/eng.php');
require_once('../../INCLUDE/tcpdf/tcpdf.php');
/////////////////////////////////////////////////////////////////////////////
//$_REQUEST['id_cotizacion']=396;
global $rut,$id_cotizacion,$id_estado;

//busco la cotización para ver la fecha. mantis 4146
$ListEnc1 = new connlist;
$ListDet1 = new connlist;
$Registro1 = new dtocotizacion;
$Registro1->id_cotizacion	=  $_REQUEST['id_cotizacion'];
$ListEnc1->addlast($Registro1);
bizcve::getcotizacion($ListEnc1, $ListDet1);
//busco la fecha de la cotización
$cotizDate=$ListEnc1->getelem()->feccrea;
list($year, $month, $day, $hour, $minute, $sec) = split('[- :]', $cotizDate); 
//the variables should be arranged acording to your date format and so the separators
$cotizTimestamp=mktime($hour, $minute,$sec, $month, $day, $year);
///////////////////////////////////////////////////////////////////////////////////////////////

$Listasunto  = new connlist;
$Registroasunto = new dtooperaciones;
$Registroasunto->area	= 7;
$Listasunto->addlast($Registroasunto);
bizcve::getmensajeeditor($Listasunto);
$Listasunto->gofirst();
$contadortexto=0;
if (!$Listasunto->isvoid()) {
    do {
        $contadortexto ++;
        if($contadortexto < 2){
            if($cotizTimestamp < FECHACAMBIORAZSOC){
                $asunto = str_replace("Cencosud Colombia S.A", "Easy Colombia S.A", $Listasunto->getelem()->texto);
            }else{
                $asunto = $Listasunto->getelem()->texto;
            }
        }else{
            if($cotizTimestamp < FECHACAMBIORAZSOC){
                $contenidoemailsincoti = str_replace("Cencosud Colombia S.A", "Easy Colombia S.A", $Listasunto->getelem()->texto);
            }else{
                $contenidoemailsincoti = $Listasunto->getelem()->texto;
            }
        }
    }while ($Listasunto->gonext());
}
if($_REQUEST['modotexto']=='activo'){
	$contenidoemail='<table width="800" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td><fieldset>ASUNTO:'.$asunto.'</fieldset></td></tr></table><br>'.$contenidoemail;
}
$contenidoemail=$contenidoemail.'
<br><br><br>
<html>
<head>
<STYLE>
H1.SaltoDePagina
{
PAGE-BREAK-AFTER: always
}
</STYLE>
<SCRIPT LANGUAGE="JavaScript">
function imprimir() {
this.focus();
this.print();
}
</SCRIPT>
<style type="text/css">
<!--
.negrita{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:10px;
	font-weight:bold;
}
.titulo{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
	
}
.titulonormal {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-style: normal;
	font-weight: bold;
	color: #E20A16;
}
.textonormal {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
.tabla2
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
	border: 0px #FFFFFF;
	border-spacing: 0px;
}
.tabla3 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #000000;
	background-color: #DEDEDE;
}
-->
</style>
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<table width="300" height="403" border="0" bordercolor="black" cellpadding="0" cellspacing="0" style="border: 2px solid #ffffff;">
	<tr>
		<td height="69" valign="top">
			<table width="95%"  border="0" cellspacing="2" cellpadding="2">
			<tr>
				<td width="15%" height="49"><img src="'.($_REQUEST['modotexto']=='activo'?'../../IMAGES/':'').'logotipo_negro.gif"></td>
				<td width="79%" class="titulonormal">';
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
	$contenidoemail=$contenidoemail.'Cotizaci&#243;n&nbsp;-&nbsp;'.$ListEnc->getelem()->nomtipoventa.'&nbsp;N&ordm;&nbsp;'.$ListEnc->getelem()->id_cotizacion.'</td>
    <td width="6%"></td
	</tr>
			<tr>
				<td height="11" colspan="3">';
			for($rimagen=0;$rimagen<30;$rimagen++){
				if($_REQUEST['modotexto']=='activo'){
				$contenidoemail=$contenidoemail.'<img src="../../IMAGES/barra.gif">';	
				}
				else{
				$contenidoemail=$contenidoemail.'<img src="barra.gif">';	
				}
			}
	$contenidoemail=$contenidoemail.'</td>
			</tr>   
			</table>
		</td>
	</tr>  
	<tr>
	<td valign="top">
	<table width="100%"  border="0" cellspacing="2" cellpadding="2" class="textonormal">
	<tr>
	<td width="31%" valign="top">
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="textonormal">
		<tr>
			<td><fieldset>
			<legend><strong>Datos Cotizaci&#243;n</strong></legend>
			<table width="600" border="0" align="center" cellpadding="2" cellspacing="1" class="textonormal">
				<tr>
					<td width="26%">Nº&nbsp;Cotizaci&#243;n</td>
					<td width="24%">'.$ListEnc->getelem()->id_cotizacion.'</td>
					<td width="25%">Fecha Cotizaci&oacute;n </td>
					<td width="25%">'.general::formato_fecha($ListEnc->getelem()->validdesde).'</td>   
				</tr>
				<tr>
					<td>Estado</td>
					<td>&nbsp;'.$ListEnc->getelem()->nomestado.'</td>
					<td>Tienda</td>
					<td>'.$ListEnc->getelem()->nom_localcsum.'</td>   
				</tr>
				<tr>
				<tr>
					<!-- td>Margen</td>
					<td>%</td!-->
					<td>Vendedor</td>
					<td>';
	$obra=explode("||",$ListEnc->getelem()->direccion);
	$contenidoemaila='</td>					
					</tr>
				<tr>
					<td class="negrita">Válido Desde</td>
					<td>'.general::formato_fecha($ListEnc->getelem()->validdesde).'</td>	
					<td><strong class="negrita">Válido Hasta</strong></td>
					<td>'.general::formato_fecha($ListEnc->getelem()->validhasta).'</td>
				</tr>
				<tr>
					<td class="negrita">Observaciones</td>
					<td colspan="3">'.$ListEnc->getelem()->nota.'</td>		
				</tr>'.	
				($obra[1]!=''?'<tr>
					<td class="negrita">Obra</strong></td>
					<td colspan="3" align="left">'.$obra[1].'</td></tr>':'').'				
			</table>
			</fieldset></td>
		</tr>
		<tr>
			<td><fieldset>
			<legend>Datos Cliente</legend>
				<table width="600" border="0"   align="center" cellpadding="2" cellspacing="1" class="textonormal">
					<tr>
						<td width="151">Raz&#243;n Social</td>
						<td width="138">';
	
	$id_cotizacion=$ListEnc->getelem()->id_cotizacion;		
	$estado=$ListEnc->getelem()->id_estado;	
	$id_estado=$ListEnc->getelem()->id_estado;			
	$codigovendedor=$ListEnc->getelem()->codigovendedor;
	$rut=$ListEnc->getelem()->rutcliente;
	$emailviva=number_format($ListEnc->getelem()->cot_iva);
	$emailrete_renta=number_format($ListEnc->getelem()->rete_renta);
	$emailrete_iva=number_format($ListEnc->getelem()->rete_iva);
	$emailrete_ica=number_format($ListEnc->getelem()->rete_ica);	
	$valortotal  =round($ListEnc->getelem()->valortotal + $ListEnc->getelem()->rete_renta + $ListEnc->getelem()->rete_iva + $ListEnc->getelem()->rete_ica+0);
	$sumtotal    =($valortotal - $ListEnc->getelem()->rete_renta - $ListEnc->getelem()->rete_iva - $ListEnc->getelem()->rete_ica);
	$margentotal =$ListEnc->getelem()->margentotal;			
		
}
$List = new connlist;
$Registro = new dtousuario;
$Registro->codigovendedor	=  $codigovendedor;
$List->addlast($Registro);
bizcve::GetUsers($List);
$List->gofirst();
$usr_mail=$List->getelem()->usr_email;
$usr_nombre=$List->getelem()->usr_nombres;
$usr_apellidos=$List->getelem()->usr_apellidos;		
$contenidoemail=$contenidoemail.''.$usr_nombre.' '.$usr_apellidos;

/* para el detalle de las cotizaciones*/
$contadorlineas=0;
$ListDet->gofirst();
if (!$ListDet->isvoid()) {

	do {

		$ListDet->getelem()->id_cotizacion;
		if ( $ListDet->getelem()->id_tipoentrega==1 and $ListDet->getelem()->id_tiporetiro==2){
	    			$emaildesp= 'Retira Cliente';		    
					}
		if ( $ListDet->getelem()->id_tipoentrega==2 and $ListDet->getelem()->id_tiporetiro==1){
					$emaildesp= 'D. Programado';
					}
		if ( $ListDet->getelem()->id_tipoentrega==1 and $ListDet->getelem()->id_tiporetiro==1){
			        $emaildesp='Retira Inmediato';
					}

		$precio=($ListDet->getelem()->pventaneto+$ListDet->getelem()->cargoflete);		
		$contadorlineas=$contadorlineas+1;
		$descuentot=$descuentot+$ListDet->getelem()->descuento;
		$contenidoemailc=$contenidoemailc.'
			<tr>
			<td align="center" width="8%">'.$ListDet->getelem()->codprod.'&nbsp;</td>
			<td align="center" width="4%">'.$ListDet->getelem()->codsubtipo.'&nbsp;</td>
			<td align="left" width="18%">&nbsp;'.$ListDet->getelem()->descripcion.'&nbsp;</td>
			<td align="center" width="8%">'.$emaildesp.'&nbsp;</td>
			<td align="center" width="6%">&nbsp;'.$ListDet->getelem()->unimed.'&nbsp;</td>
			<td align="center" width="8%">'.$ListDet->getelem()->instalacion.'&nbsp;</td>
			<td align="center" width="8%">'.$ListDet->getelem()->peso.'&nbsp;</td>  
			<td align="center" width="8%">'.$ListDet->getelem()->cantidad.'&nbsp;</td>
			<td align="center" width="8%">'.number_format($precio,2).'&nbsp;</td> 
			<td align="center" width="8%">'.$ListDet->getelem()->descuento.'&nbsp;</td>
			<td align="center" width="8%">'.number_format(((($ListDet->getelem()->descuento/$ListDet->getelem()->cantidad)*100)/($precio+($ListDet->getelem()->descuento/$ListDet->getelem()->cantidad))),1).'&nbsp;</td>              
			<td align="center" width="8%">'.number_format(round($ListDet->getelem()->totallinea)).'&nbsp;</td>
		</tr>';
		if($ListDet->getelem()->codsubtipo=='DE' && $ListDet->getelem()->codtipo=='SV'){
			$valorfletet=$valorfletet+$ListDet->getelem()->totallinea;	
			}
			else{
				$valorfletet=$valorfletet+0;
			}
		//$MiTemplate->parse("BLO_detallecotizacion", "detalleproductos", true);	
	} while ($ListDet->gonext());
		if($valorfletet >0){
		$valorfletetabla='<tr>
				<td width="40" ></td>
				<td width="80" ></td>
				<td width="200" ></td>                
				<td width="100" align="left">Valor Fletes</td>
				<td width="50"  ></td>								
				<td width="90"  align="right">'.number_format($valorfletet).'&nbsp;</td>  
			</tr>';
	
	//$MiTemplate->set_var('valorfletet', number_format($valorfletet));
		}
		else{
		$valorfletetabla='';	
		}
	$contenidoemailc=$contenidoemailc.'</table>
	</td>
	</tr>
	<tr>
	<td>		
		<table width="800" border="0" align="left" cellpadding="0" cellspacing="0" class="textonormal">	
			<tr>
				<td width="40" ></td>
				<td width="80" ></td>
				<td width="200" ></td>                
				<td width="100" align="left">Sub-Total</td>
				<td width="50"  ></td>								
				<td width="90"  align="right">'.number_format($valortotal).'&nbsp;</td>  
			</tr>
			<tr>
				<td width="40" ></td>
				<td width="80" ></td>
				<td width="200" ></td>                
				<td width="100" align="left">Descuentos</td>
				<td width="50"  ></td>								
				<td width="90"  align="right">'.number_format($descuentot).'&nbsp;</td>  
			</tr>
			<tr>
				<td width="40" ></td>
				<td width="80" ></td>
				<td width="200" ></td>                
				<td width="100" align="left">Valor IVA</td>
				<td width="50"  ></td>								
				<td width="90"  align="right">'.$emailviva.'&nbsp;</td>  
			</tr>
			'.$valorfletetabla.'
			<tr>
				<td width="40" ></td>
				<td width="80" ></td>
				<td width="200" ></td>                
				<td width="100" align="left">Retención IVA</td>
				<td width="50"  ></td>								
				<td width="90"  align="right">'.$emailrete_iva.'&nbsp;</td>  
			</tr>
			<tr>
				<td width="40" ></td>
				<td width="80" ></td>
				<td width="200" ></td>                
				<td width="100" align="left">Retención Renta</td>
				<td width="50"  ></td>								
				<td width="90"  align="right">'.$emailrete_renta.'&nbsp;</td>  
			</tr>
			<tr>
				<td width="40" ></td>
				<td width="80" ></td>
				<td width="200" ></td>                
				<td width="100" align="left">Retención ICA</td>
				<td width="50"  ></td>								
				<td width="90"  align="right">'.$emailrete_ica.'&nbsp;</td>  
			</tr>
				<tr>
				<td width="40" ></td>
				<td width="80" ></td>
				<td width="200" ></td> 
				<td align="left"  width="100">Total</td>
				<td width="50"></td>						
				<td align="right" width="90">'.number_format($sumtotal+0).'&nbsp;</td>
			</tr>				
		</table>
	</td>
	</tr>

<tr><td><br></tr>			
		<tr>
		<td>
<table width="550" border="0" align="center" cellpadding="0" cellspacing="0" class="titulo">
<tr><td align="center">DETALLE DE IVA INCLUIDO EN LA COTIZACION</td></tr></table>
<tr>
		<td><fieldset>

<table width="550" border="0" align="left" cellpadding="0" cellspacing="0" class="tabla2" >

			<tr>
				<td width="16%" align="center"></td>
				<td width="16%" align="center">Descripción</td>
				<td width="16%" align="center" ></td>                
				<td width="20%" align="center">Base IVA</td>
				<td width="16%" align="center"></td>								
				<td width="16%"  align="center">Vlr IVA</td>  
			</tr>	
	
			<tr>
				<td width="16%" ></td>
				<td width="16%" align="right">';
	if($estado=='CB'){
		//$MiTemplate->set_var('margentotal', "<td>Margen</td><td><span class='textomargen'>".$margentotal."%</span></td>");		
	}			
}
/*para los datos del cliente*/
$List = new connlist;
$Registro = new dtoinfocliente;
$Registro->rut	= $rut;
$List->addlast($Registro);

bizcve::getCliente($List);
$List->gofirst();
$destinoemail=$List->getelem()->email;
$configclitipo = new getidcontribuyente("CONTRIBUYENTE");
$opcion=$configclitipo->JURIDICO;
$opcion1=$configclitipo->EMPRESARIAL;
if (!$List->isvoid()) {

	$contenidoemailrut=(($List->getelem()->id_contribuyente == $opcion1)?$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut) : $List->getelem()->rut );	
	$emailcomentario= $List->getelem()->comentario;			
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

if (!$List->isvoid()) {
	$contenidoemailb=$List->getelem()->razonsoc.'</td>
						<td width="145">CC/NIT/RUT</td>
						<td width="145">'.$contenidoemailrut.'</td>
					</tr>
					<tr>
						<td width="151">Actividad Economica </td>
						<td width="138">'.$List->getelem()->giro.'</td>
						<td width="145">&nbsp;</td>
						<td width="145">&nbsp;</td>
					</tr>
					<tr>
						<td>Direcci&oacute;n</td>
						<td>'.$List->getelem()->direccion.'</td>
						<td>Tel&eacute;fono Contacto</td>
						<td>'.$List->getelem()->fonocontacto.'</td>
					</tr>
					<tr>
						<td>Departamento</td>
						<td>';
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
		$contenidoemailb=$contenidoemailb.''.$Listlocalizacion->getelem()->departamento.'</td>
						<td>Ciudad</td>
						<td>'.$Listlocalizacion->getelem()->ciudad.'</td>
					</tr>
					<tr>
						<td width="151">Barrio</td>
						<td width="138">'.$Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad.'</td>
						<!--  td width="25%">Comentario</td>
						<td width="25%">'.$emailcomentario.'</td>-->  						
					</tr>
				</table>
			</fieldset></td>
		</tr>
		<tr>
			<td><fieldset>
			<legend>Direcci&oacute;n de Servicio   (Despachos e Instalaciones)</legend>
				<table width="600" border="0"   align="center" cellpadding="2" cellspacing="1" class="textonormal">
					<tr>
						<td width="25%">Telefono</td>
						<td width="25%">';
		
	} while ($Listlocalizacion->gonext());
}
	
}
/*FinDespliegue de Datos de Cliente*/
/*Despliegue de Datos Direccion de despachos*/
$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {

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
		//<td width="25%">&nbsp;'.$ListEnc->getelem()->direccion.'</td>
		$contenidoemailb=$contenidoemailb.''.$Listdirdes->getelem()->fonocontacto.'</td>
						<td width="25%">&nbsp;Direcci&oacute;n</td>
						<td width="25%">&nbsp;'.$obra[0].'</td>
					</tr>
					<tr>
						<td width="25%">Departamento</td>
						<td width="25%">'.$Listlocalizacion->getelem()->departamento.'</td>
						<td width="25%">Ciudad</td>
						<td width="25%">'.$Listlocalizacion->getelem()->ciudad.'</td>
					</tr>
					<tr>
						<td>Barrio</td>
						<td>'.$Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad.'</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					</table>
				<table width="800" border="0"   align="center" cellpadding="2" cellspacing="1" class="textonormal">
					
					<tr>
						<td width="25%">Indicaciones</td>
						<td align="lefth"></td>
					</tr>
				</table>
			</fieldset></td>
		</tr>
	</table>';
		
	} while ($Listlocalizacion->gonext());
}
	
	
			
}

else {
	$contenidoemailb=$contenidoemailb.''.$List->getelem()->fonocontacto.'</td>
						<td width="25%">&nbsp;Direcci&oacute;n</td>
						<td width="25%">&nbsp;'.$obra[0].'</td>
					</tr>
					<tr>
						<td width="25%">Departamento</td>
						<td width="25%">'.$localidep.'</td>
						<td width="25%">Ciudad</td>
						<td width="25%">'.$localiciu.'</td>
					</tr>
					<tr>
						<td>Barrio</td>
						<td>'.$localibar.'</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="800" border="0" align="center" cellpadding="2" cellspacing="1" class="textonormal">
					
					<tr>
						<td width="25%">Indicaciones</td>
						<td align="lefth">'.$List->getelem()->comentario.'</td>
					</tr>
				</table>
			</fieldset></td>
		</tr>
	</table>';
	
}
}
$contenidoemailb=$contenidoemailb.'
	<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="textonormal">
	<tr>
		<td>
			<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla3">	
				<tr>
				<th align="center" width="8%">Codigo</th>
				<th align="center" width="4%">Tipo</th>
				<th align="center" width="18%">Descripci&oacute;n</th>
				<th align="center" width="8%">Tipo Despacho</th>
				<th align="center" width="6%">Unimed</th>
				<th align="center" width="8%">Instalación</th>
				<th align="center" width="8%">Peso</th> 
				<th align="center" width="8%">Cantidad</th>               
				<th align="center" width="8%">Precio</th>
				<th align="center" width="8%">Descuento</th>
				<th align="center" width="8%">Descuento %</th>
				<th align="center" width="8%">Total</th>
				</tr>
			</table>
		
	<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" class="textonormal">';
////detalle impuestos////	
$Listimp = new connlist;
$Registrop = new dtocotizacion;
$id_coti   =  $_REQUEST['id_cotizacion'];
$grupoimp='cot_iva'; 
bizcve::getdetalleimpuesto($Listimp, $id_coti,$grupoimp);
$Listimp->gofirst();


if (!$Listimp->isvoid()) {
	
	//$MiTemplate->set_block('main' , "prueba" , "BLO_prueba");
	do {
		$contenidoemailc=$contenidoemailc.'<tr>
				<td width="16%" ></td>
				<td width="16%" align="right">'.$Listimp->getelem()->cot_iva.'%</td>
				<td width="16%" ></td>                
				<td width="20%" align="right">'.number_format($Listimp->getelem()->sumtotaliva).'</td>
				<td width="16%"  ></td>								
				<td width="16%"  align="right">'.number_format($Listimp->getelem()->sumiva).'</td>  
			</tr>';
			

	} while ($Listimp->gonext());
$contenidoemailc=$contenidoemailc.'</table>
<tr><td><br></tr>
</fieldset></td>
<tr>
<td>';
}
if($validacobrorenta >= 1){

$contenidoemailc=$contenidoemailc.'	
<table width="550" border="0" align="center" cellpadding="0" cellspacing="0" class="titulo" >
<tr><td align="center">DETALLE DE RENTA INCLUIDO EN LA COTIZACION</td></tr></table>
<tr>
<td>
<fieldset>
<table width="550" border="0" align="left" cellpadding="0" cellspacing="0" class="tabla2" >
			<tr>
				<td width="16%" align="center"></td>
				<td width="16%" align="center">Descripción</td>
				<td width="16%" align="center"></td>                
				<td width="20%" align="center">Base Rete Fuente</td>
				<td width="16%" align="center"></td>								
				<td width="16%"  align="center">Vlr Rete Fuente</td>  
			</tr>';

$Listimp = new connlist;
$Registrop = new dtocotizacion;
$id_coti   =  $_REQUEST['id_cotizacion'];
$grupoimp='rete_renta'; 
bizcve::getdetalleimpuesto($Listimp, $id_coti,$grupoimp);	
$Listimp->gofirst();
if (!$Listimp->isvoid()) {
	
	do  {
$contenidoemailc=$contenidoemailc.'<tr>
				<td width="16%" ></td>
				<td width="16%" align="right">'.$Listimp->getelem()->rete_renta.'%</td>
				<td width="16%" ></td>                
				<td width="20%" align="right">'.number_format($Listimp->getelem()->sumtotaliva).'</td>
				<td width="16%"  ></td>								
				<td width="16%" align="right">'.number_format($Listimp->getelem()->sumiva).'</td>  
			</tr>';
		
	} while ($Listimp->gonext());
}
$contenidoemailc=$contenidoemailc.'</fieldset></table>
</td>
<tr><td><br></tr>
<tr>
<td>';
}
if($validacobroica >= 1){			
$contenidoemailc=$contenidoemailc.'
<table width="550" border="0" align="center" cellpadding="0" cellspacing="0" class="titulo" >
<tr><td align="center">DETALLE DE ICA INCLUIDO EN LA COTIZACION</td></tr></table>
<tr>
<td>
<fieldset>
<table width="550" border="0" align="left" cellpadding="0" cellspacing="0" class="tabla2" >
			<tr>
				<td width="16%" align="center"></td>
				<td width="16%" align="center">Descripción</td>
				<td width="16%" align="center"></td>                
				<td width="20%" align="center">Base Rete ICA</td>
				<td width="16%" align="center"></td>								
				<td width="16%"  align="center">Vlr Rete ICA</td>  
			</tr>';

$Listimp = new connlist;
$Registrop = new dtocotizacion;
$id_coti   =  $_REQUEST['id_cotizacion'];
$grupoimp='rete_ica'; 
bizcve::getdetalleimpuesto($Listimp, $id_coti,$grupoimp);		
$Listimp->gofirst();
if (!$Listimp->isvoid()) {
	
	do {
$contenidoemailc=$contenidoemailc.'<tr>
				<td width="16%"></td>
				<td width="16%" align="right">'.$Listimp->getelem()->rete_ica.'%</td>
				<td width="16%"></td>                
				<td width="20%" align="right">'.number_format($Listimp->getelem()->sumtotaliva).'</td>
				<td width="16%"  ></td>								
				<td width="16%" align="right">'.number_format($Listimp->getelem()->sumiva).'</td>  
			</tr>';
		} while ($Listimp->gonext());
	}
}
////detalle impuestos////
$contenidoemaild='</fieldset></table>
<tr><td><br></tr>
<tr><td><br></tr>
<tr>
<td>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla2" >';
$Listce  = new connlist;
$Registroce = new dtooperaciones;
$Registroce->area	= 6;
$Listce->addlast($Registroce);
bizcve::getmensajeeditor($Listce);
$Listce->gofirst();
if(!$Listce->isvoid()){
    do{
        if($cotizTimestamp < FECHACAMBIORAZSOC){
            $contenidoemaild = $contenidoemaild.'<tr><td><fieldset>'.str_replace("CENCOSUD COLOMBIA S.A", "EASY COLOMBIA S.A", $Listce->getelem()->texto).'</fieldset></td></tr>';
        }else{
            $contenidoemaild = $contenidoemaild.'<tr><td><fieldset>'.$Listce->getelem()->texto.'</fieldset></td></tr>';
        }
    }while($Listce->gonext());
}
$contenidoemaild=$contenidoemaild.'
</table>		
		</table> 
      </tr>
	 </table>
	</td>
  </tr>
</table>
</body>
</html>';

if($_REQUEST['modotexto']=='activo'){
//echo $contenidoemailsincoti."".$contenidoemail."".$contenidoemaila."".$contenidoemailb."".$contenidoemailc."".$contenidoemaild;
echo "Asunto:".$asunto."Contenido EMAIL:".$contenidoemailsincoti;
}
else{
$ListEnc = new connlist;
$registro = new dtoemail;
$registro->SMTPAuten  ="true";
$registro->Usuarioemail  ="centroventaempresa@easy.com.co";
$registro->Passwordemail  ="1234";
$registro->From  ="centroventaempresa@easy.com.co"; 
$registro->FromName  =$usr_apellidos." ".$usr_nombre;
$registro->AddAddress  =$destinoemail;
$registro->AddCC  =$usr_mail;
$registro->Asunto  =$asunto;
$registro->Contenido  =(!$_REQUEST['addAttachment']?$contenidoemailsincoti:$contenidoemailsincoti."".$contenidoemail."".$contenidoemaila."".$contenidoemailb."".$contenidoemailc."".$contenidoemaild);
$registro->AltBody  ="Cotizacion CVE";
$registro->Tipoemail  ="CO";
$registro->id_cot  =$_REQUEST['id_cotizacion']; 
$registro->AddAttachment  =(!$_REQUEST['addAttachment']?'YES':'NO'); 
$ListEnc->addlast($registro);
if($_REQUEST['addAttachment']){
	bizcve::envioemail($ListEnc);
	$ListEnc->gofirst();
	echo $ListEnc->getelem()->Respuesta;	
}
else{
	try{
		pdf::crearpdf($ListEnc);
	}
	catch (Exception $e){
	//$e->getMessage();	
	}

	if(file_exists("../../../CVEPRIVATE/CREATEPDF/archivos_pdf/CotizacionCVE_".$_REQUEST['id_cotizacion'].".pdf")){ 
		bizcve::envioemail($ListEnc);
		unlink('../../../CVEPRIVATE/CREATEPDF/archivos_pdf/CotizacionCVE_'.$_REQUEST['id_cotizacion'].'.pdf');	
		$ListEnc->gofirst();
		echo $ListEnc->getelem()->Respuesta; 
	}else{ 
		//echo 1; se comentario esta linea puesto que el formato html para el envio de la cotizacion esta con el formato antiguo 
		echo "problemas al adjuntar la cotizacion en formato PDF al correo ";
		general::writeevent('problemas al adjuntar la cotizacion en formato PDF al correo, Cotizacion '.$_REQUEST['id_cotizacion']);
		general::writelog('problemas al adjuntar la cotizacion en formato PDF al correo, Cotizacion '.$_REQUEST['id_cotizacion'].'ERROR: el archivo CotizacionCVE_'.$_REQUEST['id_cotizacion'].'.pdf no existe');
	}
} 
}
?>