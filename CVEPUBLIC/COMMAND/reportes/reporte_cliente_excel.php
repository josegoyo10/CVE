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
<th>Razon_Social</th>
<th>RUT</th>
<th>TipoCliente</th>
<th>codigovendedor</th>
<th>Nombre_Vendedor</th>
<th>Contacto</th>
<th>fonocontacto</th>
<th>email</th>
<th>direccion</th>
<th>usuario_creacion</th>
<th>fecha_creacion</th>
<th>usuario_modificacion</th>
<th>fecha_modificacion</th>	
<th>celular_contacto</th>			
<th>fax</th>	
<th>profesion</th>			
<th>Tipo_Contribuyente</th>
<th>Descripcion_Contribuyente</th>
</tr><tr>';

$ListEnc  = new connlist;
bizcve::reporteclientes($ListEnc);
$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
	do {	
		$exportarexcel.='<td>'.$ListEnc->getelem()->razonsoc.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->rut.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->id_tipocliente.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->codigovendedor.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->vendedor.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->contacto.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->fonocontacto.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->email.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->direccion.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->usrcrea.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->feccrea.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->usrmod.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->fecmod.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->celcontactoe.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->fax.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->profesion.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->id_contribuyente.'</td><td>';
		$exportarexcel.=$ListEnc->getelem()->contribuyente.'</td></tr>';
	} while ($ListEnc->gonext());
		
}
echo $exportarexcel;
?>