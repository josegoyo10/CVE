<?php
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=reporte_ordenescompra.xls");
header("Pragma: no-cache");
header("Expires: 0");

$exportarexcel='<table border=1>
			<tr>
			<th>Tienda</th>
			<th>N Orden Entrega</th>
			<th>Estado</th>
			<th>Fecha Compra</th>
			<th>Fecha Entrega</th>
			<th>Razon Social</th>
			<th>Telefono</th>
			<th>Ciudad De Despacho</th>
			<th>Barrio</th>
			<th>Valor Total</th>
			</tr><tr>';

$ListEnc  = new connlist;
$ListDet = new connlist;
$mRegistro = new dtoencordenent;
if ($ses_usr_codlocal) {
	$mRegistro->codlocalcsum = $ses_usr_codlocal;
}
else {
	$mRegistro->codlocalcsum=$_REQUEST['select_suministro'];
}
$mRegistro->fechaucofini = ($_REQUEST['feini'])?general::formato_fecha_FORM2DB($_REQUEST['feini']):"";
$mRegistro->fechaucoffin = ($_REQUEST['fefin'])?general::formato_fecha_FORM2DB($_REQUEST['fefin']):"";
$mRegistro->id_estado=$_REQUEST['select_estado'];
$ListEnc->addlast($mRegistro);
$id_estado=$_REQUEST['select_estado'];

if($_REQUEST['tipobus']=='buscartpe'){
bizcve::reportecompraspendientespe($ListEnc, $ListDet);
}
else{
bizcve::reportecompraspendientes($ListEnc, $ListDet);	
}
$ListEnc->gofirst();
	if (!$ListEnc->isvoid()) {
		do {
			$mRegistrodet = new dtoencordenent;
			$mRegistrodet->id_ordenent = $ListEnc->getelem()->id_ordenent;
			$ListDet->addlast($mRegistrodet);
			bizcve::getdetordenentpespecial($ListDet);
			$ListDet->gofirst();
			$conteope=$ListDet->getelem()->numlinea;
			$conteon_compra=$ListDet->getelem()->totallinea;
			$ListDet->clearlist(); 
			if($conteope > 0){
				
				$ListDetD = new connlist;
				$mRegistrope = new dtodetordenent;
				$mRegistrope->id_ordenent = $ListEnc->getelem()->id_ordenent;
				$ListDetD->addlast($mRegistrope);
				bizcve::getdetordenent($ListDetD);
				$ListDetD->gofirst();
				
			if($_REQUEST['proveedor']){
				if(!$ListDetD->isvoid()) {
					do{
						
						$Listproducto = new connlist;
						$detproducto = new dtoproducto;
						$detproducto->cod_prod1 	= $ListDetD->getelem()->codprod;
						$detproducto->idprov	 	= $_REQUEST['proveedor'];
						$Listproducto->addlast($detproducto);
						bizcve::getproductoxproveedor($Listproducto);
						$Listproducto->gofirst();
						
						if(!$Listproducto->isvoid()) {
									$totalpro_prov += $Listproducto->getelem()->id_producto;
																					
						}
						
					}while ($ListDetD->gonext()); 
					
				}
			}	
			else{
			$totalpro_prov=1;
			}	
			}
			if($totalpro_prov > 0){
					
					$exportarexcel=$exportarexcel.'<td>'.$ListEnc->getelem()->nom_local.'</td><td>'.
					$ListEnc->getelem()->id_ordenent.'</td><td>'.
					$ListEnc->getelem()->id_estado.'</td><td>'.
					general::formato_fecha($ListEnc->getelem()->fechacompra).'</td><td>';
					$ndespacho=0;
					if($ListEnc->getelem()->fecha_retira_cliente != '0000-00-00' && $ndespacho==0)
					{
					$exportarexcel=$exportarexcel.''.general::formato_fecha($ListEnc->getelem()->fecha_retira_cliente).'</td><td>';
					$ndespacho=1;
					}
					if($ListEnc->getelem()->fecha_retira_inmediato != '0000-00-00' && $ndespacho==0)
					{
					$exportarexcel=$exportarexcel.''.general::formato_fecha($ListEnc->getelem()->fecha_retira_inmediato).'</td><td>';
					$ndespacho=1;
					}
					if($ListEnc->getelem()->fecha_despacho_programado != '0000-00-00' && $ndespacho==0)
					{
					$exportarexcel=$exportarexcel.''.general::formato_fecha($ListEnc->getelem()->fecha_despacho_programado).'</td><td>';
					$ndespacho=1;
					}
					$exportarexcel=$exportarexcel.''.$ListEnc->getelem()->razonsoc.'</td><td>'.
					$ListEnc->getelem()->fonocontacto.'</td><td>';
					
					if($ListEnc->getelem()->id_direccion > 0)
					{
					$Listdirdes  = new connlist;
					$id_dirdes->id_direccion=$ListEnc->getelem()->id_direccion;
					$Listdirdes->addlast($id_dirdes);
					bizcve::getdirdesp($Listdirdes);
					$Listdirdes->gofirst();
					$idcomuna=$Listdirdes->getelem()->id_comuna;
					$Listdirdes->clearlist();
					}
//localizacion//
					else {
					
					$ListCli  = new connlist;
					$mRegistroCli->rut=$ListEnc->getelem()->rutcliente;
					$ListCli->addlast($mRegistroCli);
					bizcve::getcliente($ListCli);
					$ListCli->gofirst();
					$idcomuna=$ListCli->getelem()->id_comuna;
					
					}	
					
			$Listlocalizacion  = new connlist;
			$registrolocalizacion->id_localizacion=$idcomuna;
			$Listlocalizacion->addlast($registrolocalizacion);
			bizcve::getlocalizacion($Listlocalizacion);
			$Listlocalizacion->gofirst();
			if (!$Listlocalizacion->isvoid()) {
			do {
				$exportarexcel=$exportarexcel.''.$Listlocalizacion->getelem()->ciudad.'</td><td>'.
				$Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad.'</td><td>';
				
				} while ($Listlocalizacion->gonext());
			}
			$Listlocalizacion->clearlist();
			
			$exportarexcel=$exportarexcel.''.number_format($ListEnc->getelem()->valortotal).'</td></tr>';
			//$exportarexcel1='';
				
			}	
			$totalpro_prov= 0;
			
			
		} while ($ListEnc->gonext());
		
}
echo $exportarexcel;
?>