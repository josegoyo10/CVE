<?
class  pdf{
	
function __construct(){
	
	$visibleIMP = new getidvisibleimpuestos("VISIBLE_IMPUESTOS");
	$visible_fletes=$visibleIMP->FLETES;
	$visible_renta=$visibleIMP->IMPUESTO_RENTA;
	$visible_ica=$visibleIMP->IMPUESTO_ICA;
	$visible_reteiva=$visibleIMP->IMPUESTO_RETEIVA;
}
  	
function crearpdf($ListPDF) {

	
$ListPDF->gofirst();
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('CENCOSUD COLOMBIA');
$pdf->SetTitle('COTIZACION VENTA EMPRESA');
$pdf->SetSubject('VENTA EMPRESA');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

//set some language-dependent strings
$pdf->setLanguageArray($l); 

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 8);

// add a page
$pdf->AddPage();

$visibleIMP = new getidvisibleimpuestos("VISIBLE_IMPUESTOS");
$visible_fletes=$visibleIMP->FLETES;
$visible_renta=$visibleIMP->IMPUESTO_RENTA;
$visible_ica=$visibleIMP->IMPUESTO_ICA;
$visible_reteiva=$visibleIMP->IMPUESTO_RETEIVA;

///DATOS OE///
$ListEnc = new connlist;
$ListDet = new connlist;
$ListDir = new connlist;
$Registro = new dtocotizacion;
$Registro->id_cotizacion	=  $ListPDF->getelem()->id_cot;
$Registro->prorrateoflete =1;   
$ListEnc->addlast($Registro);
bizcve::getcotizacion($ListEnc, $ListDet);
$ListEnc->gofirst();

$rut=$ListEnc->getelem()->rutcliente;
$codigovendedor=$ListEnc->getelem()->codigovendedor;
$valortotal  =round($ListEnc->getelem()->valortotal + $ListEnc->getelem()->rete_renta + $ListEnc->getelem()->rete_iva + $ListEnc->getelem()->rete_ica+0);
$viva=number_format($ListEnc->getelem()->cot_iva);
$sumtotal=($valortotal - $ListEnc->getelem()->rete_renta - $ListEnc->getelem()->rete_iva - $ListEnc->getelem()->rete_ica);
general::writeevent('estado cot'.$valortotal.' '.$ListEnc->getelem()->valortotal.' '.$ListEnc->getelem()->rete_renta.' '.$ListEnc->getelem()->rete_iva.' '.$ListEnc->getelem()->rete_ica.' ');
$id_cotizacion=$ListEnc->getelem()->id_cotizacion;
$obra=explode("||",$ListEnc->getelem()->direccion);

$date=$ListEnc->getelem()->feccrea;
list($year, $month, $day, $hour, $minute, $sec) = split('[- :]', $date); 
//the variables should be arranged acording to your date format and so the separators
$cotizTimestamp=mktime($hour, $minute,$sec, $month, $day, $year);
$razonSocCencosud = "Cencosud Colombia S.A.";
if($cotizTimestamp < FECHACAMBIORAZSOC){
    $razonSocCencosud = "Easy Colombia S.A";
    $pdf->SetAuthor('EASY COLOMBIA');
}

///DATOS VENDEDOR///
$List = new connlist;
$Registro = new dtousuario;
$Registro->codigovendedor	=  $codigovendedor;
$List->addlast($Registro);
bizcve::GetUsers($List);
$List->gofirst();
$usr_nombre=$List->getelem()->usr_nombres;
$usr_apellidos=$List->getelem()->usr_apellidos;

if(!$codigovendedor){
	$pdf_vendedor='Venta No Asignada';	
}
else{
	$pdf_vendedor= $usr_nombre.' '.$usr_apellidos;
}

//DATOS CLIENTE///
$List = new connlist;
$Registro = new dtoinfocliente;
$Registro->rut	= $rut;
$List->addlast($Registro);

bizcve::getCliente($List);
$List->gofirst();
$configclitipo = new getidcontribuyente("CONTRIBUYENTE");
$opcion=$configclitipo->JURIDICO;
$opcion1=$configclitipo->EMPRESARIAL;

//if (!$List->isvoid()) {
	//$MiTemplate->set_var('rut', $List->getelem()->rut);
	//$MiTemplate->set_var('rutcliente', (($List->getelem()->id_contribuyente == $opcion1)?$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut) : $List->getelem()->rut ));	
	//$MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente);								
	//$MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);		
	//$MiTemplate->set_var('comentario', $List->getelem()->comentario);			
	//$MiTemplate->set_var('nomtipdocpago', $List->getelem()->nomtipdocpago);
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
			//$MiTemplate->set_var('dcciudad', $Listlocalizacion->getelem()->ciudad);
			//$MiTemplate->set_var('dcnomcomuna', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
			//$MiTemplate->set_var('dcdepartamento', $Listlocalizacion->getelem()->departamento);
		
	} while ($Listlocalizacion->gonext());
}
//}

///DIRECCION DE DESPACHO//
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
			$pdf_email=$Listdirdes->getelem()->email;
			$pdf_contacto= $Listdirdes->getelem()->contacto;
			$pdf_nota=$Listdirdes->getelem()->comentario;
			$pdf_fonocontacto= $Listdirdes->getelem()->fonocontacto;
			$pdf_ciudad=$Listlocalizacion->getelem()->ciudad;
			$pdf_comuna=$Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad;
			$pdf_departamento= $Listlocalizacion->getelem()->departamento;
		
		} while ($Listlocalizacion->gonext());
	}		
}
else {
	$pdf_email= $List->getelem()->email;
	$pdf_contacto=$List->getelem()->contacto.' '.$List->getelem()->apellido.' '.$List->getelem()->apellido1;
	$pdf_nota=$List->getelem()->comentario;
	$pdf_fonocontacto= $List->getelem()->fonocontacto;
	$pdf_ciudad= $localiciu;
	$pdf_comuna=$localibar;
	$pdf_departamento= $localidep;
}


// create some HTML content
//$contenidoima=$contenidoima.'<img src="/var/www/html/cvecolombia/CVEPUBLIC/IMAGES/barralarga.JPG" width="500" height="8" border="0" />';				
$contenidoemaild='<table align="center" border="0" width="500">
	<tr>
	<td align="left" width="130">
	<img src="/cvecolombia/CVEPUBLIC/IMAGES/logotipo_negro.gif" width="95" height="45" border="0" />
	</td>
	<td width="370">
		<table align="left" class="textonormal2" >
		<tr>
		<td>'.$razonSocCencosud.'</td><td></td>
		</tr>
		<tr>
		<td>Nit 900,155,107-1</td><td></td>
		</tr>
		<tr>
		<td><b>Sede Administrativa:</b></td><td align="justify">'.$ListEnc->getelem()->dir_localcsum.' '.$ListEnc->getelem()->nom_localcsum.'</td>
		</tr>
		<tr>
		<td colspan="2"><b>Productos :</b> &nbsp;Art&#237;culos para el Hogar, Materiales de Construcci&#243;n, Ferreter&#237;a, Accesorios de veh&#237;culos, Art&#237;culos Deportivos, Camping, Alquiler de Herramienta, Alimentos para Animales, Comercializaci&#243;n de Insumos, Servicios, vehículos, Maquinaria y Equipo Agr&#237;cola.</td>
		</tr>
		<tr>
		<td colspan="2" align="justify"><b>Grandes Contribuyentes Res.14047 del 23 Dic de 2009  -Autorretenedor Res. 12688 del 23 Nov de 2009 - Agente Retenedor Iva Res.12466 de 13 Nov de 2009</b></td>
		</tr>
		</table>
	</td>
	</tr>
	</table>';

$pdf->writeHTML($contenidoemaild, true, false, false, false, '');

$contenidoemaild='<table align="center" border="0" width="500" class="textonormal2">
	<tr>
	<td align="left" width="370"></td>
	<td align="center" width="130">
		<table align="center" border="1" width="130" class="textonormal2">
			<tr>
			<td><b>COTIZACION No '.$id_cotizacion.'</b></td>
			</td>
		</table>
	</td>
	</tr>
	<tr>
	<td height="11" colspan="2" background="/cvecolombia/CVEPUBLIC/IMAGES/barra.gif"></td>
	</tr>
	</table>';

$pdf->writeHTML($contenidoemaild, true, false, false, false, '');

$pdf->SetFont('helvetica', '', 8);

$contenidoemaild='<table border="1" width="500"  cellpadding="4">
		<tr>
		<td>
		<table class="textonormal" width="500">
		<tr>
		<td align="left" width="200"><b class="negrita">CLIENTE : </b>'.$ListEnc->getelem()->razonsoc.'</td>
		<td align="left" width="150"><b class="negrita">NIT : </b>'.(($List->getelem()->id_contribuyente == $opcion1)?$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut) : $List->getelem()->rut ).'</td>
		<td align="left" width="150"><b class="negrita">CIUDAD : </b>'.$pdf_ciudad.'</td></tr>
		<tr>
		<td align="left" width="200"><b class="negrita">DIRECCION : </b>'.$obra[0].'</td>
		<td align="left" width="150"><b class="negrita">BARRIO : </b>'.$pdf_comuna.'</td>
		<td align="left" width="150"><b class="negrita">TELEFONO : </b>'.$pdf_fonocontacto.'</td></tr>
		<tr>
		<td align="left" width="200"><b class="negrita">CONTACTO : </b>'.$pdf_contacto.'</td>
		<td align="left" width="300" colspan="2"><b class="negrita">EMAIL : </b>'.$pdf_email.'</td></tr>
		<tr>
		<td align="left" width="350" colspan="2"><b class="negrita">EJECUTIVO DE VENTAS : </b>'.$pdf_vendedor.'</td>
		<td align="left"><b class="negrita">FECHA : </b>'.general::formato_fecha($ListEnc->getelem()->validdesde).'</td></tr>';
$contenidoemaild=$contenidoemaild.''.($obra[1]!=''?'<tr><td align="left" colspan="3" width="500"><b class="negrita">OBRA : </b>'.$obra[1].'</td></tr>':'').'</table></td></tr></table>';		

$pdf->writeHTML($contenidoemaild, true, false, false, false, '');

$contenidoemaild='<table width="500" border="0" align="center" cellpadding="0" cellspacing="2" class="tabla3">	
				<tr style="background-color:#DCDCDC;color:#696969; border: 3px; border-color: fuchsia">
				<th align="center" width="50">Codigo</th>
				<th align="center" width="207">Descripci&oacute;n</th>
				<th align="center" width="40">Cantidad</th>               
				<th align="center" width="70">Precio</th>
				<th align="center" width="60">Descuento %</th>
				<th align="center" width="73">Total</th>
				</tr></table>';

$contenidoemaild=$contenidoemaild.'<table width="500" border="0" align="center" cellpadding="0" cellspacing="1">';
$contadorlineas=0;
$ListDet->gofirst();
if (!$ListDet->isvoid()) {

	do {

		$precio=($ListDet->getelem()->pventaneto + $ListDet->getelem()->cargoflete);		
		$contadorlineas=$contadorlineas+1;
		$descuentot=$descuentot+$ListDet->getelem()->descuento;
		$contenidoemaild=$contenidoemaild.'
		<tr>
			<td align="right" width="50">'.$ListDet->getelem()->codprod.'</td>		
			<td align="left" width="207">'.$ListDet->getelem()->descripcion.'</td>	 
			<td align="right" width="40">'.$ListDet->getelem()->cantidad.'</td>
			<td align="right" width="70">'.number_format($precio,2).'</td> 
			<td align="center" width="60">'.number_format(((($ListDet->getelem()->descuento/$ListDet->getelem()->cantidad)*100)/($precio+($ListDet->getelem()->descuento/$ListDet->getelem()->cantidad))),1).'</td>
			<td align="right" width="73">'.number_format(round($ListDet->getelem()->totallinea)).'</td>
		</tr>';
		$contadorlineas=$contadorlineas+1;
		$descuentot=$descuentot+$ListDet->getelem()->descuento;
		if($ListDet->getelem()->codsubtipo=='DE' && $ListDet->getelem()->codtipo=='SV'){
			$valorfletet=$valorfletet+$ListDet->getelem()->totallinea;	
			}
			else{
				$valorfletet=$valorfletet+0;
			}	
	} while ($ListDet->gonext());
}

if($valorfletet >0 && $visible_fletes == true){
		$valorfletetabla='<tr>
					<td width="99" align="left">Valor Fletes</td>
					<td width="99"  align="right">'.number_format($valorfletet).'</td>
					</tr>';
}

$contenidoemaild=$contenidoemaild.'</table><b>
<table border="0" width="500"  cellpadding="0">
<tr>
	<td width="300">
		<table border="0" width="300"  cellpadding="0">
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><b>OBSERVACIONES: </b>'.$ListEnc->getelem()->nota.' '.$pdf_nota.'</td>
		</tr>
		</table>
	</td>
	<td width="200">
		<table border="0" width="200"  cellpadding="0">
			<tr>                
			<td width="99" align="left">Sub-Total</td>								
			<td width="99"  align="right">'.number_format($valortotal).'</td>
			</tr>
			<tr>
			<td width="99" align="left">Descuentos</td>
			<td width="99"  align="right">'.number_format($descuentot).'</td>
			</tr>
			<tr>
			<td width="99" align="left">Valor IVA</td>
			<td width="99"  align="right">'.$viva.'</td>
			</tr>
			'.$valorfletetabla.'
			'.($visible_reteiva == true?'<tr><td width="99" align="left">Retenci&oacute;n IVA</td><td width="99" align="right">'.number_format($ListEnc->getelem()->rete_iva).'</td></tr>':'').'
			'.($visible_renta == true?'<tr><td width="99" align="left">Retenci&oacute;n Renta</td><td width="99" align="right">'.number_format($ListEnc->getelem()->rete_renta).'</td></tr>':'').'
			'.($visible_ica == true?'<tr><td width="99" align="left">Retenci&oacute;n ICA</td><td width="99" align="right">'.number_format($ListEnc->getelem()->rete_ica).'</td></tr>':'').'
			<tr>
			<td width="99" align="left">Total A Pagar</td>
			<td width="99"  align="right">'.number_format($sumtotal).'</td>
			</tr>
		</table>
	</td>
</tr>
</table></b><br />';
$pdf->writeHTML($contenidoemaild, true, false, false, false, '');

$contenidoemaild='<table align="center" border="0" width="500" class="textonormal">
	<tr><td align="left" width="250"><b class="negrita">TIEMPO DE ENTREGA : </b>___________________________</td><td align="left" width="100"><b class="negrita">ACEPTADA POR:</b></td><td width="150" align="center">___________________________<br />Firma y sello autorizado</td></tr>
	<tr><td align="left" width="250"><b class="negrita">VALIDEZ DE LA OFERTA : </b>'.general::formato_fecha($ListEnc->getelem()->validhasta).'</td><td align="left" width="100"><b class="negrita">NOMBRE LEGIBLE : </b></td><td width="150" align="center">___________________________<br /></td></tr>
	<tr><td align="left" width="250"><b class="negrita">ELABORADA POR : </b>'.$pdf_vendedor.'</td><td align="left" width="100"><b class="negrita">CEDULA : </b></td><td width="150" align="center">___________________________ </td></tr>
	</table>';
$pdf->writeHTML($contenidoemaild, true, false, false, false, '');

$pdf->AddPage();
$pdf->writeHTML('<span align="center">DETALLE DE IVA INCLUIDO EN LA COTIZACION</span>', $ln=true, $fill=false, $reseth=false, $cell=false, $align='');

$contenidoemaild='<table width="500" border="1" align="center">
<tr>
<td>	<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla2" >
			<tr>
				<td align="center"></td>
				<td align="center">Descripci&oacute;n</td>
				<td align="center" ></td>                
				<td align="center">Base IVA</td>
				<td align="center"></td>								
				<td align="center">Vlr IVA</td>  
				<td align="center"></td>
			</tr>';	
////detalle impuestos////	
$Listimp = new connlist;
$Registrop = new dtocotizacion;
$id_coti   =  $ListPDF->getelem()->id_cot;
$grupoimp='cot_iva'; 
bizcve::getdetalleimpuesto($Listimp, $id_coti,$grupoimp);
$Listimp->gofirst();


if (!$Listimp->isvoid()) {

	do {
		$contenidoemaild=$contenidoemaild.'<tr>
				<td ></td>
				<td align="right">'.$Listimp->getelem()->cot_iva.'%</td>
				<td ></td>                
				<td align="right">'.number_format($Listimp->getelem()->sumtotaliva).'</td>
				<td ></td>								
				<td align="right">'.number_format($Listimp->getelem()->sumiva).'</td> 
				<td ></td> 
			</tr>';

	} while ($Listimp->gonext());
$contenidoemaild=$contenidoemaild.'</table></td></tr></table>';
}

$pdf->writeHTML($contenidoemaild, true, false, false, false, '');

if($validacobrorenta >= 1 && $visible_renta == true){

$pdf->writeHTML('<span align="center">DETALLE DE RENTA INCLUIDO EN LA COTIZACION</span>', $ln=true, $fill=false, $reseth=false, $cell=false, $align='');

$contenidoemaild='<table width="500" border="1" align="center">
<tr>
<td>	<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla2" >
			<tr>
				<td align="center"></td>
				<td align="center">Descripci&oacute;n</td>
				<td align="center"></td>                
				<td align="center">Base Rete Fuente</td>
				<td align="center"></td>								
				<td align="center">Vlr Rete Fuente</td>
				<td align="center"></td>  
			</tr>';

$Listimp = new connlist;
$Registrop = new dtocotizacion;
$id_coti   =  $ListPDF->getelem()->id_cot;
$grupoimp='rete_renta'; 
bizcve::getdetalleimpuesto($Listimp, $id_coti,$grupoimp);	
$Listimp->gofirst();
if (!$Listimp->isvoid()) {
	
	do  {
$contenidoemaild=$contenidoemaild.'<tr>
				<td ></td>
				<td align="right">'.$Listimp->getelem()->rete_renta.'%</td>
				<td ></td>                
				<td align="right">'.number_format($Listimp->getelem()->sumtotaliva).'</td>
				<td ></td>								
				<td align="right">'.number_format($Listimp->getelem()->sumiva).'</td>  
			</tr>';
		
	} while ($Listimp->gonext());
}
$contenidoemaild=$contenidoemaild.'</table></td></tr></table>';
$pdf->writeHTML($contenidoemaild, true, false, false, false, '');
}

if($validacobroica >= 1 && $visible_ica == true){
$pdf->writeHTML('<span align="center">DETALLE DE ICA INCLUIDO EN LA COTIZACION</span>', $ln=true, $fill=false, $reseth=false, $cell=false, $align='');			
$contenidoemaild='<table width="500" border="1" align="center">
<tr>
<td>	<table width="500" border="0" align="left" cellpadding="0" cellspacing="0" class="tabla2" >
			<tr>
				<td align="center"></td>
				<td align="center">Descripci&oacute;n</td>
				<td align="center"></td>                
				<td align="center">Base Rete ICA</td>
				<td align="center"></td>								
				<td align="center">Vlr Rete ICA</td>
				<td align="center"></td>  
			</tr>';

$Listimp = new connlist;
$Registrop = new dtocotizacion;
$id_coti   =  $ListPDF->getelem()->id_cot;
$grupoimp='rete_ica'; 
bizcve::getdetalleimpuesto($Listimp, $id_coti,$grupoimp);		
$Listimp->gofirst();
if (!$Listimp->isvoid()) {
	
	do {
$contenidoemaild=$contenidoemaild.'<tr>
				<td></td>
				<td align="right">'.$Listimp->getelem()->rete_ica.'%</td>
				<td ></td>                
				<td align="right">'.number_format($Listimp->getelem()->sumtotaliva).'</td>
				<td ></td>								
				<td align="right">'.number_format($Listimp->getelem()->sumiva).'</td>
				<td></td>  
			</tr>';
		} while ($Listimp->gonext());
	}
$contenidoemaild=$contenidoemaild.'</table></td></tr></table>';
$pdf->writeHTML($contenidoemaild, true, false, false, false, '');
}
////fin detalle impuestos////

$contenidoemaild='<table width="500" border="1" align="center" cellpadding="2" cellspacing="2" class="tabla2" >';
$Listce  = new connlist;
$Registroce = new dtooperaciones;
$Registroce->area	= 6;
$Listce->addlast($Registroce);
bizcve::getmensajeeditor($Listce);
$Listce->gofirst();
if (!$Listce->isvoid()) {	
       do {		
       		 $contenidoemaild=$contenidoemaild.'<tr><td>'.$Listce->getelem()->texto.'</td></tr>';    
       } while ($Listce->gonext());
}
$contenidoemaild=$contenidoemaild.'</table>';
$pdf->writeHTML($contenidoemaild, true, false, false, false, '');
- - - - - - - - - - - - - - - - - - - - - - -
// reset pointer to the last page
$pdf->lastPage();
// ---------------------------------------------------------
//Close and output PDF document
try{
$pdf->Output(dirname(__FILE__).'/archivos_pdf/CotizacionCVE_'.$ListPDF->getelem()->id_cot.'.pdf', 'F');
//$pdf->Output('C:/AppServ/www/cvecolombia/CVEPRIVATE/CREATEPDF/archivos_pdf/CotizacionCVE_'.$ListPDF->getelem()->id_cot.'.pdf', 'F');
}
catch (Exception $e){	
}
//============================================================+
// END OF FILE                                                 
//============================================================+

}
  	
function crearpdfviejo($ListPDF) {

	
$ListPDF->gofirst();
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('EASY COLOMBIA');
$pdf->SetTitle('COTIZACION VENTA EMPRESA');
$pdf->SetSubject('VENTA EMPRESA');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

//set some language-dependent strings
$pdf->setLanguageArray($l); 

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 8);

// add a page
$pdf->AddPage();

$ListEnc = new connlist;
$ListDet = new connlist;
$ListDir = new connlist;
$Registro = new dtocotizacion;
$Registro->id_cotizacion	=  $ListPDF->getelem()->id_cot;
$Registro->prorrateoflete =1;   
$ListEnc->addlast($Registro);
bizcve::getcotizacion($ListEnc, $ListDet);
$ListEnc->gofirst();
// create some HTML content
//$contenidoima=$contenidoima.'<img src="/var/www/html/cvecolombia/CVEPUBLIC/IMAGES/barralarga.JPG" width="500" height="8" border="0" />';				

$contenidoemaild='<table width="500"  border="0" cellspacing="2" cellpadding="2">
			<tr>
				<td width="150"><img src="CVEPUBLIC/IMAGES/logotipo_negro.gif" width="95" height="45" border="0" /></td>
				<td class="titulonormal" width="350" align="left"><span style="color:#FF0000;font-size: 12">Cotizaci&#243;n&nbsp;-&nbsp;'.$ListEnc->getelem()->nomtipoventa.'&nbsp;N&ordm;&nbsp;'.$ListEnc->getelem()->id_cotizacion.'</span></td>
			</tr></table>';

$pdf->writeHTML($contenidoemaild, true, false, false, false, '');

$pdf->writeHTML('<span style="color:#4682B4">Datos Cotizaci&#243;n</span>', $ln=true, $fill=false, $reseth=false, $cell=false, $align='');

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

$List = new connlist;
$Registro = new dtousuario;
$Registro->codigovendedor	=  $codigovendedor;
$List->addlast($Registro);
bizcve::GetUsers($List);
$List->gofirst();
$usr_mail=$List->getelem()->usr_email;
$usr_nombre=$List->getelem()->usr_nombres;
$usr_apellidos=$List->getelem()->usr_apellidos;

$contenidoemaild='<table width="500" border="0" align="center" cellpadding="2" cellspacing="1" class="textonormal">
				<tr>
					<td align="left">Nº&nbsp;Cotizaci&#243;n</td>
					<td align="left">'.$ListEnc->getelem()->id_cotizacion.'</td>
					<td align="left">Fecha Cotizaci&oacute;n </td>
					<td align="left">'.general::formato_fecha($ListEnc->getelem()->validdesde).'</td>   
				</tr>
				<tr>
					<td align="left">Estado</td>
					<td align="left">&nbsp;'.$ListEnc->getelem()->nomestado.'</td>
					<td align="left">Tienda</td>
					<td align="left">'.$ListEnc->getelem()->nom_localcsum.'</td>   
				</tr>
				<tr>
					<td align="left">Vendedor</td>
					<td align="left">'.$usr_nombre.' '.$usr_apellidos;
	
$contenidoemaild=$contenidoemaild.'</td>
					<td align="left"></td>
					<td align="left"></td>					
					</tr>
				<tr>
					<td align="left"><strong class="negrita">V&aacute;lido Desde</strong></td>
					<td align="left">'.general::formato_fecha($ListEnc->getelem()->validdesde).'</td>	
					<td align="left"><strong class="negrita">V&aacute;lido Hasta</strong></td>
					<td align="left">'.general::formato_fecha($ListEnc->getelem()->validhasta).'</td>
				</tr>
				<tr>
					<td align="left"><strong class="negrita">Observaciones</strong></td>
					<td colspan="3" align="left">'.$ListEnc->getelem()->nota.'</td>					
				</tr>';
				$obra=explode("||",$ListEnc->getelem()->direccion);
$contenidoemaild=$contenidoemaild.($obra[1]!=''?'<tr>
					<td align="left"><strong class="negrita">Obra</strong></td>
					<td colspan="3" align="left">'.$obra[1].'</td></tr>':'');
$contenidoemaild=$contenidoemaild.'</table>';
	
$pdf->writeHTML($contenidoemaild, true, false, false, false, '');

$pdf->writeHTML('<span style="color:#4682B4">Datos Cliente</span>', $ln=true, $fill=false, $reseth=false, $cell=false, $align='');

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
//$rut=$rutdcliente;
$mRegistro->rut=$rut;
$List->addlast($mRegistro);
bizcve::getCliente($List);
$List->gofirst();

if (!$List->isvoid()) {
	$contenidoemaild='<table width="500" border="0"   align="center" cellpadding="2" cellspacing="1" class="textonormal">
					<tr>
						<td align="left">Raz&#243;n Social</td>
						<td align="left">'.$ListEnc->getelem()->razonsoc.'</td>
						<td align="left">CC/NIT/RUT</td>
						<td align="left">'.$contenidoemailrut.'</td>
					</tr>
					<tr>
						<td align="left">Actividad Economica </td>
						<td align="left">'.$List->getelem()->giro.'</td>
						<td align="left">&nbsp;</td>
						<td align="left">&nbsp;</td>
					</tr>
					<tr>
						<td align="left">Direcci&oacute;n</td>
						<td align="left">'.$List->getelem()->direccion.'</td>
						<td align="left">Tel&eacute;fono Contacto</td>
						<td align="left">'.$List->getelem()->fonocontacto.'</td>
					</tr>
					<tr>
						<td align="left">Departamento</td>
						<td align="left">';
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
		$contenidoemaild=$contenidoemaild.''.$Listlocalizacion->getelem()->departamento.'</td>
						<td align="left">Ciudad</td>
						<td align="left">'.$Listlocalizacion->getelem()->ciudad.'</td>
					</tr>
					<tr>
						<td align="left">Barrio</td>
						<td align="left">'.$Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad.'</td>
						<td align="left"></td>
						<td align="left"></td>  						
					</tr>
				</table>';
		
	} while ($Listlocalizacion->gonext());
}
	
}
/*FinDespliegue de Datos de Cliente*/
$pdf->writeHTML($contenidoemaild, true, false, false, false, '');
/*DIR DESPACHO*/
$pdf->writeHTML('<span style="color:#4682B4">Direcci&oacute;n de Servicio   (Despachos e Instalaciones)</span>', $ln=true, $fill=false, $reseth=false, $cell=false, $align='');

$contenidoemaild='<table width="500" border="0" align="center" cellpadding="2" cellspacing="1" class="textonormal">
					<tr align="left">
						<td >Telefono</td>
						<td >';
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
		//cambio por la obra <td >&nbsp;prueba '.$ListEnc->getelem()->direccion.'</td>
		$contenidoemaild=$contenidoemaild.''.$Listdirdes->getelem()->fonocontacto.'</td>
						<td >&nbsp;Direcci&oacute;n</td>
						<td >&nbsp;'.$obra[0].'</td>
					</tr>
					<tr align="left">
						<td >Departamento</td>
						<td >'.$Listlocalizacion->getelem()->departamento.'</td>
						<td >Ciudad</td>
						<td >'.$Listlocalizacion->getelem()->ciudad.'</td>
					</tr>
					<tr align="left">
						<td>Barrio</td>
						<td>'.$Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad.'</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr align="left">
						<td>Indicaciones</td>
						<td></td>
					</tr>
					</table>';
		
	} while ($Listlocalizacion->gonext());
 }			
}
else {
	//cambio pro obra <td >&nbsp;'.$ListEnc->getelem()->direccion.'</td>
	$contenidoemaild=$contenidoemaild.''.$List->getelem()->fonocontacto.'</td>
						<td >&nbsp;Direcci&oacute;n</td>
						<td >&nbsp;'.$obra[0].'</td>
					</tr>
					<tr align="left">
						<td >Departamento</td>
						<td >'.$localidep.'</td>
						<td >Ciudad</td>
						<td >'.$localiciu.'</td>
					</tr>
					<tr align="left">
						<td>Barrio</td>
						<td>'.$localibar.'</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr align="left">
						<td>Indicaciones</td>
						<td colspan="3">'.$List->getelem()->comentario.'</td>
					</tr>
				</table>';
	}
}
/*FIN DIR DESPACHO*/
$pdf->writeHTML($contenidoemaild, true, false, false, false, '');

/* para el detalle de las cotizaciones*/
$contenidoemaild='<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla3">	
				<tr style="background-color:#DCDCDC;color:#696969; border: 3px; border-color: fuchsia">
				<th align="center" >Codigo</th>
				<th align="center" >Tipo</th>
				<th align="center" >Descripci&oacute;n</th>
				<th align="center" >Tipo Despacho</th>
				<th align="center" >Unimed</th>
				<th align="center" >Instalación</th>
				<th align="center" >Peso</th> 
				<th align="center" >Cantidad</th>               
				<th align="center" >Precio</th>
				<th align="center" >Descuento</th>
				<th align="center" >Descuento %</th>
				<th align="center" >Total</th>
				</tr></table>';

$pdf->writeHTML($contenidoemaild, true, false, false, false, '');
//output the HTML content
$contenidoemaild='<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla3">';
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
		$contenidoemaild=$contenidoemaild.'
		<tr>
			<td align="center">'.$ListDet->getelem()->codprod.'&nbsp;</td>
			<td align="center">'.$ListDet->getelem()->codsubtipo.'&nbsp;</td>
			<td align="left">&nbsp;'.$ListDet->getelem()->descripcion.'&nbsp;</td>
			<td align="center">'.$emaildesp.'&nbsp;</td>
			<td align="center">&nbsp;'.$ListDet->getelem()->unimed.'&nbsp;</td>
			<td align="center">'.$ListDet->getelem()->instalacion.'&nbsp;</td>
			<td align="center">'.$ListDet->getelem()->peso.'&nbsp;</td>  
			<td align="center">'.$ListDet->getelem()->cantidad.'&nbsp;</td>
			<td align="center">'.number_format($precio,2).'&nbsp;</td> 
			<td align="center">'.$ListDet->getelem()->descuento.'&nbsp;</td>
			<td align="center">'.number_format(((($ListDet->getelem()->descuento/$ListDet->getelem()->cantidad)*100)/($precio+($ListDet->getelem()->descuento/$ListDet->getelem()->cantidad))),1).'&nbsp;</td>              
			<td align="center">'.number_format(round($ListDet->getelem()->totallinea)).'&nbsp;</td>
		</tr>';
		if($ListDet->getelem()->codsubtipo=='DE' && $ListDet->getelem()->codtipo=='SV'){
			$valorfletet=$valorfletet+$ListDet->getelem()->totallinea;	
			}
			else{
				$valorfletet=$valorfletet+0;
			}
		//$MiTemplate->parse("BLO_detallecotizacion", "detalleproductos", true);	
	} while ($ListDet->gonext());
	$contenidoemaild=$contenidoemaild.'</table>';
	
$pdf->writeHTML($contenidoemaild, true, false, false, false, '');
		if($valorfletet >0){
		$valorfletetabla='<tr>
				<td></td>
				<td></td>
				<td></td>                
				<td align="left"><strong class="negrita">Valor Fletes</strong></td>
				<td ></td>								
				<td align="right"><strong class="negrita">'.number_format($valorfletet).'&nbsp;</strong></td>  
			</tr>';
		}
		else{
		$valorfletetabla='';	
		}
$contenidoemaild='<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="textonormal">	
			<tr>
				<td ></td>
				<td></td>
				<td></td>                
				<td align="left"><strong class="negrita">Sub-Total</strong></td>
				<td></td>								
				<td align="right"><strong class="negrita">'.number_format($valortotal).'&nbsp;</strong></td>  
			</tr>
			<tr>
				<td ></td>
				<td ></td>
				<td ></td>                
				<td align="left"><strong class="negrita">Descuentos</strong></td>
				<td w></td>								
				<td align="right"><strong class="negrita">'.number_format($descuentot).'&nbsp;</strong></td>  
			</tr>
			<tr>
				<td ></td>
				<td ></td>
				<td ></td>                
				<td align="left"><strong class="negrita">Valor IVA</strong></td>
				<td ></td>								
				<td align="right"><strong class="negrita">'.$emailviva.'&nbsp;</strong></td>  
			</tr>
			'.$valorfletetabla.'
			<tr>
				<td ></td>
				<td ></td>
				<td ></td>                
				<td align="left"><strong class="negrita">Retenci&oacute;n IVA</strong></td>
				<td ></td>								
				<td align="right"><strong class="negrita">'.$emailrete_iva.'&nbsp;</strong></td>  
			</tr>
			<tr>
				<td ></td>
				<td ></td>
				<td ></td>                
				<td align="left"><strong class="negrita">Retenci&oacute;n Renta</strong></td>
				<td ></td>								
				<td align="right"><strong class="negrita">'.$emailrete_renta.'&nbsp;</strong></td>  
			</tr>
			<tr>
				<td ></td>
				<td ></td>
				<td ></td>                
				<td align="left"><strong class="negrita">Retenci&oacute;n ICA</strong></td>
				<td ></td>								
				<td align="right"><strong class="negrita">'.$emailrete_ica.'&nbsp;</strong></td>  
			</tr>
				<tr>
				<td ></td>
				<td ></td>
				<td ></td> 
				<td align="left"><strong class="negrita">Total</strong></td>
				<td ></td>						
				<td align="right"><strong class="negrita">'.number_format($sumtotal+0).'&nbsp;</strong></td>
			</tr>				
		</table>';
$pdf->writeHTML($contenidoemaild, true, false, false, false, '');
$pdf->AddPage();
$pdf->writeHTML('<span align="center">DETALLE DE IVA INCLUIDO EN LA COTIZACION</span>', $ln=true, $fill=false, $reseth=false, $cell=false, $align='');

$contenidoemaild='<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla2" >

			<tr>
				<td align="center"></td>
				<td align="center">Descripci&oacute;n</td>
				<td align="center" ></td>                
				<td align="center">Base IVA</td>
				<td align="center"></td>								
				<td align="center">Vlr IVA</td>  
				<td align="center"></td>
			</tr>';	
}
////detalle impuestos////	
$Listimp = new connlist;
$Registrop = new dtocotizacion;
$id_coti   =  $ListPDF->getelem()->id_cot;
$grupoimp='cot_iva'; 
bizcve::getdetalleimpuesto($Listimp, $id_coti,$grupoimp);
$Listimp->gofirst();


if (!$Listimp->isvoid()) {

	do {
		$contenidoemaild=$contenidoemaild.'<tr>
				<td ></td>
				<td align="right">'.$Listimp->getelem()->cot_iva.'%</td>
				<td ></td>                
				<td align="right">'.number_format($Listimp->getelem()->sumtotaliva).'</td>
				<td ></td>								
				<td align="right">'.number_format($Listimp->getelem()->sumiva).'</td> 
				<td ></td> 
			</tr>';

	} while ($Listimp->gonext());
$contenidoemaild=$contenidoemaild.'</table>';
}

$pdf->writeHTML($contenidoemaild, true, false, false, false, '');

if($validacobrorenta >= 1){

$pdf->writeHTML('<span align="center">DETALLE DE RENTA INCLUIDO EN LA COTIZACION</span>', $ln=true, $fill=false, $reseth=false, $cell=false, $align='');

$contenidoemaild='<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla2" >
			<tr>
				<td align="center"></td>
				<td align="center">Descripci&oacute;n</td>
				<td align="center"></td>                
				<td align="center">Base Rete Fuente</td>
				<td align="center"></td>								
				<td align="center">Vlr Rete Fuente</td>
				<td align="center"></td>  
			</tr>';

$Listimp = new connlist;
$Registrop = new dtocotizacion;
$id_coti   =  $ListPDF->getelem()->id_cot;
$grupoimp='rete_renta'; 
bizcve::getdetalleimpuesto($Listimp, $id_coti,$grupoimp);	
$Listimp->gofirst();
if (!$Listimp->isvoid()) {
	
	do  {
$contenidoemaild=$contenidoemaild.'<tr>
				<td ></td>
				<td align="right">'.$Listimp->getelem()->rete_renta.'%</td>
				<td ></td>                
				<td align="right">'.number_format($Listimp->getelem()->sumtotaliva).'</td>
				<td ></td>								
				<td align="right">'.number_format($Listimp->getelem()->sumiva).'</td>  
			</tr>';
		
	} while ($Listimp->gonext());
}
$contenidoemaild=$contenidoemaild.'</table>';
$pdf->writeHTML($contenidoemaild, true, false, false, false, '');
}

if($validacobroica >= 1){
$pdf->writeHTML('<span align="center">DETALLE DE ICA INCLUIDO EN LA COTIZACION</span>', $ln=true, $fill=false, $reseth=false, $cell=false, $align='');			
$contenidoemaild='<table width="500" border="0" align="left" cellpadding="0" cellspacing="0" class="tabla2" >
			<tr>
				<td align="center"></td>
				<td align="center">Descripci&oacute;n</td>
				<td align="center"></td>                
				<td align="center">Base Rete ICA</td>
				<td align="center"></td>								
				<td align="center">Vlr Rete ICA</td>
				<td align="center"></td>  
			</tr>';

$Listimp = new connlist;
$Registrop = new dtocotizacion;
$id_coti   =  $ListPDF->getelem()->id_cot;
$grupoimp='rete_ica'; 
bizcve::getdetalleimpuesto($Listimp, $id_coti,$grupoimp);		
$Listimp->gofirst();
if (!$Listimp->isvoid()) {
	
	do {
$contenidoemaild=$contenidoemaild.'<tr>
				<td></td>
				<td align="right">'.$Listimp->getelem()->rete_ica.'%</td>
				<td ></td>                
				<td align="right">'.number_format($Listimp->getelem()->sumtotaliva).'</td>
				<td ></td>								
				<td align="right">'.number_format($Listimp->getelem()->sumiva).'</td>
				<td></td>  
			</tr>';
		} while ($Listimp->gonext());
	}
$contenidoemaild=$contenidoemaild.'</table>';
$pdf->writeHTML($contenidoemaild, true, false, false, false, '');
}
////fin detalle impuestos////

$contenidoemaild='<table width="500" border="2" align="center" cellpadding="2" cellspacing="0" class="tabla2" >';
$Listce  = new connlist;
$Registroce = new dtooperaciones;
$Registroce->area	= 6;
$Listce->addlast($Registroce);
bizcve::getmensajeeditor($Listce);
$Listce->gofirst();
if (!$Listce->isvoid()) {	
       do {		
       		 $contenidoemaild=$contenidoemaild.'<tr><td>'.$Listce->getelem()->texto.'</td></tr>';    
       } while ($Listce->gonext());
}
$contenidoemaild=$contenidoemaild.'</table>';
$pdf->writeHTML($contenidoemaild, true, false, false, false, '');
- - - - - - - - - - - - - - - - - - - - - - -
// reset pointer to the last page
$pdf->lastPage();
// ---------------------------------------------------------
//Close and output PDF document
try{
$pdf->Output(dirname(__FILE__).'/archivos_pdf/CotizacionCVE_'.$ListPDF->getelem()->id_cot.'.pdf', 'F');
//$pdf->Output('C:/AppServ/www/cvecolombia/CVEPRIVATE/CREATEPDF/archivos_pdf/CotizacionCVE_'.$ListPDF->getelem()->id_cot.'.pdf', 'F');
}
catch (Exception $e){	
}
//============================================================+
// END OF FILE                                                 
//============================================================+

  }
}
?>