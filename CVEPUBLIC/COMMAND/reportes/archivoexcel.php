<?php

set_time_limit(0);




include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=reporte_ventas_por_cliente$_REQUEST[fectermino].xls");
header("Pragma: no-cache");
header("Expires: 0");

while (@ob_end_flush());

ob_start();

$configclitipo = new getidcontribuyente("CONTRIBUYENTE");
$opcion=$configclitipo->JURIDICO;
$opcion1=$configclitipo->EMPRESARIAL;
	$Listado  = new connlist;
	$mRegistro = new dtoreporte;	
	$mRegistro->fecinicio = $_REQUEST[fecinicio];
	$mRegistro->fectermino = $_REQUEST[fectermino];
	$mRegistro->tipo_cliente = $_REQUEST[tipo_cliente];	
	$mRegistro->rutcliente = $_REQUEST[rut];		
	$mRegistro->razonsoc = $_REQUEST[nomcliente];		
	$mRegistro->codlocalemi = $_REQUEST[codlocalemi];
	$mRegistro->codigovendedor = $_REQUEST[codvenusr];
	$mRegistro->tipofolio = $_REQUEST[tipofolio];
	$Listado->addlast($mRegistro);
	bizcve::getventascliente($Listado);
	$Listado->gofirst();
$exportarexcel='
			<table border=1>
			<tr></tr>
			<tr>
			<th>Fecha De Inicio</th>
			<th>'.$_REQUEST[fecinicio].'</th>
			<th>Fecha Fin</th>
			<th>'.$_REQUEST[fectermino].'</th>
			</tr>
			<tr></tr>
			<tr>
			<th>Fecha De Pago</th>
			<th>Tienda</th>
			<th>CC/NIT/RUT</th>
			<th>Nombre Del Cliente</th>
			<th>No Orden De Entrega</th>
			<th>No Factura</th>
			<th>Vendedor</th>
			<th>Margen%</th>
			<th>Tipo De Entrega</th>
			<th>Estado</th>
			<th>Descuentos</th>
			<th>Rete ICA</th>
			<th>Rete IVA</th>
			<th>Rete Renta</th>
			<th>IVA</th>
			<th>Subtotal</th>
			<th>Total A Pagar</th>
			</tr>'; 

print($exportarexcel);
ob_flush();
//<td>'.number_format($Listado->getelem()->totalmargen,2).'</td>
if (!$Listado->isvoid()) {
		do {

			$valor = number_format($Listado->getelem()->totalmargen,2);
			file_put_contents("valorMargenexcel.txt", $valor); 
			
			$exportarexcel='
			<tr>
			<td>'.$Listado->getelem()->fecinicio.'</td>
			<td>'.$Listado->getelem()->nomlocemi.'</td>
			<td>'.(($Listado->getelem()->tipo_cliente == $opcion1)?$Listado->getelem()->rutcliente.'-'.general::digiVer($Listado->getelem()->rutcliente) : $Listado->getelem()->rutcliente ).'</td>
			<td>'.$Listado->getelem()->idcliente.'</td>
			<td>'.$Listado->getelem()->numdocpago.'</td>
			<td>'.$Listado->getelem()->numdocumento.'</td>
			<td>'.($Listado->getelem()->nomvendedor==' '?'VENTA NO ASIGNADA':$Listado->getelem()->nomvendedor).'</td>
			<td>'.$valor.'</td>
			<td>'.$Listado->getelem()->tipo_entrega.'</td>
			<td>'.$Listado->getelem()->estado.'</td>
			<td>'.$Listado->getelem()->neto_fct.'</td>
			<td>'.$Listado->getelem()->rete_ica.'</td>
			<td>'.$Listado->getelem()->rete_iva.'</td>
			<td>'.$Listado->getelem()->rete_renta.'</td>
			<td>'.$Listado->getelem()->totaliva.'</td>
			<td>'.$Listado->getelem()->total_linea.'</td>
			<td>'.$Listado->getelem()->total_venta.'</td>
			</tr>';
			$totalvalor1excel += $Listado->getelem()->neto_fct;
			$icaexcel += $Listado->getelem()->rete_ica;
			$rivaexcel += $Listado->getelem()->rete_iva;
			$rentaexcel += $Listado->getelem()->rete_renta;
			$ivaexcel += $Listado->getelem()->totaliva;
			$subtotalexcel += $Listado->getelem()->total_linea;
			$totalvalorexcel += $Listado->getelem()->total_venta;
			
			print($exportarexcel);
			ob_flush();
		} while ($Listado->gonext());
	}
$totalretenciones=($icaexcel+$rivaexcel+$rentaexcel);
$ventasnetas=($totalvalorexcel+$totalretenciones)-$ivaexcel;

$exportarexcel='<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<th>Totales</th>
			<th>'.$totalvalor1excel.'</th>
			<th>'.$icaexcel.'</th>
			<th>'.$rivaexcel.'</th>
			<th>'.$rentaexcel.'</th>
			<th>'.$ivaexcel.'</th>
			<th>'.$subtotalexcel.'</th>
			<th>'.$totalvalorexcel.'</th>
			</tr>
			<tr></tr>
			<tr>
			<th align="left">Total IVA</th>
			<th>'.$ivaexcel.'</th>
			</tr>
			<tr>
			<th align="left">Total Retenciones</th>
			<th>'.$totalretenciones.'</th>
			</tr>
			<tr>
			<th align="left">Ventas Netas</th>
			<th>'.$ventasnetas.'</th>
			</tr>
			<tr></tr>
			</table>';
echo $exportarexcel;
ob_end_flush();
?>