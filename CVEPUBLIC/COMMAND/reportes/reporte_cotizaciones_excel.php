<?php
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
ini_set('memory_limit','10240M');
set_time_limit(0);

// http://stackoverflow.com/questions/6064535/excel-export-problem-in-ie

ini_set('zlib.output_compression','Off');
header('Pragma: public');
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");                  
header('Cache-Control: no-store, no-cache, must-revalidate');     // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0');    // HTTP/1.1
header ("Pragma: no-cache");
header("Expires: 0");
header('Content-Transfer-Encoding: none');


header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=reporte_clientes.xls");


$exportarexcel='<table border=1>
	<tr>
		<th>N° Cotización </th>
		<th>Usuario</th>
		<th>F. Creación </th>
		<th width="100">F. Vencimiento </th>
		<th width="100">Estado</th>
		<th width="60">CC/NIT/RUT </th>
		<th>Razón Social </th>
		<th>Tipo Venta </th>
		<th>Local Emisor </th>
		<th>Tienda</th>	
		<th>Codigo Vendedor</th>	
		<th>Nombre y Apellido</th>
		<th>Total Neto </th>
		<th>Margen Total </th>
	</tr>';	

$ListEnc  = new connlist;
bizcve::reportecotizacionesEX($ListEnc);
$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
	do {	
		$exportarexcel.='<td>'.$ListEnc->getelem()->cotizacion.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->codvendedor.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->fecinicio.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->fectermino.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->estado.'</td><td>';
		$exportarexcel.=(($ListEnc->getelem()->id_contribuyente == 2)?$ListEnc->getelem()->rutcliente.'-'.general::digiVer($ListEnc->getelem()->rutcliente) : $ListEnc->getelem()->rutcliente ).'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->razonsoc.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->tipo_venta.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->nomlocemi.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->nomloccsum.'</td><td>';	
		$exportarexcel.=$ListEnc->getelem()->codigovendedor.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->apellidoynombre.'</td><td>';
		$exportarexcel.=number_format($ListEnc->getelem()->total_neto+0).'</td><td>';
		$exportarexcel.=($ListEnc->getelem()->margenpromedio+0).'</td></tr>'; 
	} while ($ListEnc->gonext());	
}
echo $exportarexcel;
?>