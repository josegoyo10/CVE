<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////
if($_POST['accion'] == 'insertarfl'){

/*$ListDetcot = new connlist;
$ListEnccot = new connlist;
$Registrocot = new dtocotizacion;
$Registrocot->id_cotizacion	=  $_REQUEST['id_cotizacion'];   
$ListEnccot->addlast($Registrocot);
bizcve::getcotizacion($ListEnccot, $ListDetcot);
$ListEnccot->gofirst();*/
////////////info cliente para el cobro de impuestos/////////////
$Listclien = new connlist;
$Registroclien = new dtodetcotizacion;
$Registroclien->id_cotizacion	=  $_REQUEST['id_cotizacion'];
$Listclien->addlast($Registroclien);
bizcve::getdetcotizacionsumimp($Listclien);
$Listclien->gofirst();
//general::writeevent($rut);
//general::alert('rete ica'.$Listclien->getelem()->rete_ica.'rete renta'.$Listclien->getelem()->rete_renta);

$id_cotizacion = $_REQUEST['id_cotizacion'];
$cantidad_cien = $_REQUEST['cien'];
$cantidad_mil =  $_REQUEST['mil'];
$cantidad_dies = $_REQUEST['dies'];
$cantidad_cienm = $_REQUEST['cienm'];

$cantidad_cienr = $_REQUEST['cienc'];
$cantidad_milr =  $_REQUEST['milc'];
$cantidad_diesr = $_REQUEST['diesc'];
$cantidad_cienmr = $_REQUEST['cienmc'];

$fchdp = $_REQUEST['fchp'];

$fchdr = $_REQUEST['fchpr'];

$codsap = $_REQUEST['codprod_1']. $_REQUEST['codprod_2'].$_REQUEST['codprod_3'].$_REQUEST['codprod_4'];
$contador = count(split(',',$codsap));
$tuparray=split(',',$codsap);


//añadido por J.G 30-01-2019
$margenOrden_ent = $_REQUEST['margen_Orden'];

if($cantidad_cienr != 0){
	
	bizcve::getcotizacion($ListEnc = new connlist(new dtocotizacion(array('id_cotizacion'=>$id_cotizacion))), $ListDet = new connlist);
	$ListEnc->gofirst();
	/*Costo de Cotizacion Actual*/
	$costocoti = round($ListEnc->getelem()->valortotal);
	/*Fin Costo de Cotizacion Actual*/
	
	bizcve::getproductof($Listp = new connlist(new dtoproducto(array('sap'=>'9539'))));
	$Listp->gofirst();
	$costocotit = $costocoti + $cantidad_cienr;
		//general::writelog('costo de flete cien'.$costocotit); 
	$Daoenc = new daocotizacion;
	$Daoenc->saveenccotizacionf($Listetf = new connlist(new dtocotizacion(array('id_cotizacion'=>$id_cotizacion,
		'valortotal'=>$costocotit
	))));
	$Dao = new daocotizacion;
	$Dao->savedetcotizacion($ListEnc = new connlist(new dtocotizacion(array('id_cotizacion'=>$id_cotizacion))), $ListDetf = new connlist(new dtodetcotizacion(array('id_cotizacion'=>$id_cotizacion,
		'codprod'=>'9539',
		'descripcion'=>$Listp->getelem()->descripcion,
		'barra'=>$Listp->getelem()->barra,
		'cantidad'=>$cantidad_cien,
		'nomprov'=>$Listp->getelem()->nomprov,
		'unimed'=>$Listp->getelem()->unidmed,
		'codtipo'=>$Listp->getelem()->prod_tipo,
		'codsubtipo'=>$Listp->getelem()->prod_subtipo,
		'instalacion'=>'',
		'pventaneto'=>($cantidad_cienr/$cantidad_cien)/*$Listp->getelem()->pventa*/,
		'id_tiporetiro'=>'1',
		'id_tipoentrega'=>'2',
		'totallinea'=>$cantidad_cienr,
		'pcosto'=>$cantidad_cienr,
		'cot_iva'=>$Listp->getelem()->ivap,
		'rete_ica'=>($Listclien->getelem()->rete_ica==0?'0':$Listp->getelem()->ica),
		'rete_renta'=>($Listclien->getelem()->rete_renta==0?'0':$Listp->getelem()->renta)
	))));
	
}		                                        
if($cantidad_milr != 0){
	
	
	bizcve::getcotizacion($ListEnc1 = new connlist(new dtocotizacion(array('id_cotizacion'=>$id_cotizacion))), $ListDet1 = new connlist);
	$ListEnc1->gofirst();
	/*Costo de Cotizacion Actual*/
	$costocoti1 = round($ListEnc1->getelem()->valortotal);
	/*Fin Costo de Cotizacion Actual*/	
	
	bizcve::getproductof($Listp = new connlist(new dtoproducto(array('sap'=>'9540'))));
	$Listp->gofirst();
	$costocotit1 = $costocoti1 + $cantidad_milr;
	
	$Daoenc1 = new daocotizacion;
	$Daoenc1->saveenccotizacionf($Listetf1 = new connlist(new dtocotizacion(array('id_cotizacion'=>$id_cotizacion,
		'valortotal'=>$costocotit1
	))));
	$Dao = new daocotizacion;
	$Dao->savedetcotizacion($ListEnc = new connlist(new dtocotizacion(array('id_cotizacion'=>$id_cotizacion))), $ListDetf = new connlist(new dtodetcotizacion(array('id_cotizacion'=>$id_cotizacion,
		'codprod'=>'9540',
		'descripcion'=>$Listp->getelem()->descripcion,
		'barra'=>$Listp->getelem()->barra,
		'cantidad'=>$cantidad_mil,
		'nomprov'=>$Listp->getelem()->nomprov,
		'unimed'=>$Listp->getelem()->unidmed,
		'codtipo'=>$Listp->getelem()->prod_tipo,
		'codsubtipo'=>$Listp->getelem()->prod_subtipo,
		'instalacion'=>'',
		'pventaneto'=>($cantidad_milr/$cantidad_mil)/*$Listp->getelem()->pventa*/,
		'id_tiporetiro'=>'1',
		'id_tipoentrega'=>'2',
		'totallinea'=>$cantidad_milr,
		'pcosto'=>$cantidad_milr,
		'cot_iva'=>$Listp->getelem()->ivap,
		'rete_ica'=>($Listclien->getelem()->rete_ica==0?'0':$Listp->getelem()->ica),
		'rete_renta'=>($Listclien->getelem()->rete_renta==0?'0':$Listp->getelem()->renta)
	))));
	
	
}

if($cantidad_diesr != 0){
	
	bizcve::getcotizacion($ListEnc2 = new connlist(new dtocotizacion(array('id_cotizacion'=>$id_cotizacion))), $ListDet2 = new connlist);
	$ListEnc2->gofirst();
	/*Costo de Cotizacion Actual*/
	$costocoti2 = round($ListEnc2->getelem()->valortotal);
	/*Fin Costo de Cotizacion Actual*/
	bizcve::getproductof($Listp = new connlist(new dtoproducto(array('sap'=>'9541'))));
	$Listp->gofirst();
	$costocotit2 = $costocoti2 + $cantidad_diesr; 
	
	$Daoenc2 = new daocotizacion;
	$Daoenc2->saveenccotizacionf($Listetf2 = new connlist(new dtocotizacion(array('id_cotizacion'=>$id_cotizacion,
		'valortotal'=>$costocotit2
	))));
	$Dao = new daocotizacion;
	$Dao->savedetcotizacion($ListEnc = new connlist(new dtocotizacion(array('id_cotizacion'=>$id_cotizacion))), $ListDetf = new connlist(new dtodetcotizacion(array('id_cotizacion'=>$id_cotizacion,
		'codprod'=>'9541',
		'descripcion'=>$Listp->getelem()->descripcion,
		'barra'=>$Listp->getelem()->barra,
		'cantidad'=>$cantidad_dies,
		'nomprov'=>$Listp->getelem()->nomprov,
		'unimed'=>$Listp->getelem()->unidmed,
		'codtipo'=>$Listp->getelem()->prod_tipo,
		'codsubtipo'=>$Listp->getelem()->prod_subtipo,
		'instalacion'=>'',
		'pventaneto'=>($cantidad_diesr/$cantidad_dies)/*$Listp->getelem()->pventa*/,
		'id_tiporetiro'=>'1',
		'id_tipoentrega'=>'2',
		'totallinea'=>$cantidad_diesr,
		'pcosto'=>$cantidad_diesr,
		'cot_iva'=>$Listp->getelem()->ivap,
		'rete_ica'=>($Listclien->getelem()->rete_ica==0?'0':$Listp->getelem()->ica),
		'rete_renta'=>($Listclien->getelem()->rete_renta==0?'0':$Listp->getelem()->renta)
	))));
	
	
}

if($cantidad_cienmr != 0){
	
	bizcve::getcotizacion($ListEnc3 = new connlist(new dtocotizacion(array('id_cotizacion'=>$id_cotizacion))), $ListDet3 = new connlist);
	$ListEnc3->gofirst();
	/*Costo de Cotizacion Actual*/
	$costocoti3 = round($ListEnc3->getelem()->valortotal);
	/*Fin Costo de Cotizacion Actual*/
	
	bizcve::getproductof($Listp = new connlist(new dtoproducto(array('sap'=>'9542'))));
	$Listp->gofirst();
	$costocotit3 = $costocoti3 + $cantidad_cienmr;
			//general::writelog('costo de flete cinemil'.$costocotit3);
	$Daoenc3 = new daocotizacion;
	$Daoenc3->saveenccotizacionf($Listetf3 = new connlist(new dtocotizacion(array('id_cotizacion'=>$id_cotizacion,
		'valortotal'=>$costocotit3
	))));
	$Dao = new daocotizacion;
	$Dao->savedetcotizacion($ListEnc = new connlist(new dtocotizacion(array('id_cotizacion'=>$id_cotizacion))), $ListDetf = new connlist(new dtodetcotizacion(array('id_cotizacion'=>$id_cotizacion,
		'codprod'=>'9542',
		'descripcion'=>$Listp->getelem()->descripcion,
		'barra'=>$Listp->getelem()->barra,
		'cantidad'=>$cantidad_cienm,
		'nomprov'=>$Listp->getelem()->nomprov,
		'unimed'=>$Listp->getelem()->unidmed,
		'codtipo'=>$Listp->getelem()->prod_tipo,
		'codsubtipo'=>$Listp->getelem()->prod_subtipo,
		'instalacion'=>'',
		'pventaneto'=>($cantidad_cienmr/$cantidad_cienm)/*$Listp->getelem()->pventa*/,
		'id_tiporetiro'=>'1',
		'id_tipoentrega'=>'2',
		'totallinea'=>$cantidad_cienmr,
		'pcosto'=>$cantidad_cienmr,
		'cot_iva'=>$Listp->getelem()->ivap,
		'rete_ica'=>($Listclien->getelem()->rete_ica==0?'0':$Listp->getelem()->ica),
		'rete_renta'=>($Listclien->getelem()->rete_renta==0?'0':$Listp->getelem()->renta)						
	))));
	
	
}
//añadido J.G el parametro margen orden 30-01-2019

echo "<script type='text/javascript'>";
echo " window.open('nueva_cotizacion_05.php?popup=1&aci=1&fchr=$fchdr&fch=$fchdp&id_cotizacion=$id_cotizacion','', &margenOrden_ent=$margenOrden_ent',  'top=1, left=100 ,width=800,height=810');";
echo " window.close();"; 
echo "</script>";






}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
/*Inclusion de header*/
/**/
$MiTemplate->set_var("TITULO", TITULO);
/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "nuevacotizacion/nueva_cotizacion_07.htm");
/**/


$rut = $_REQUEST['rut'];

$idcotizacion = $_REQUEST['id_cotizacion'];
//$MiTemplate->set_var('rut', $_REQUEST['rut']);
$fechaent=general::formato_fecha_FORM2DB($_REQUEST['validdesde']);
$nacional = $_REQUEST['nac'];
$MiTemplate->set_var('id_cotizacion',$idcotizacion);
$i = 0;
if($nacional == 1){
	/*Extraccion de Flete Productos SAP*/
	//$codsap = '4111,4112,4113,4114';
	$codsap = '9539,9540,9541,9542';
	$contador = count(split(',',$codsap));
	$tuparray=split(',',$codsap);
	$totallinea = 0;
	$MiTemplate->set_var('totallinea', $totallinea);
	/*Flete por Defecto*/
	$MiTemplate->set_var('codtipo', 'SV');
	$MiTemplate->set_var('descripcion', 'Flete Adicional X');
	/*Fin Flete por Defecto*/
	$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detallecotizacion");
	foreach($tuparray as $key=>$value){
		bizcve::getproductof($Listp = new connlist(new dtoproducto(array('sap'=>$value))));
		$Listp->gofirst();
		
		$i++;
		$MiTemplate->set_var('codprods', $value);
		$MiTemplate->set_var('codtipos', $Listp->getelem()->prod_tipo);
		$MiTemplate->set_var('descripcions', $Listp->getelem()->descripcion);
		$MiTemplate->set_var('textb',$i);
		$MiTemplate->parse("BLO_detallecotizacion", "detalleproductos", true);	
		
		
	}
	/*FIN Extraccion de Flete Productos SAP*/

}else{
	
	bizcve::getcotizacion($ListEnc = new connlist(new dtocotizacion(array('id_cotizacion'=>$idcotizacion))), $ListDet = new connlist);
	$ListDet->gofirst();
	
	if(!$ListDet->isvoid()){
		do{
			if($ListDet->getelem()->codtipo == 'SV'){
				
				$MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
				$MiTemplate->set_var('codtipo', $ListDet->getelem()->codtipo);
				$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
				$MiTemplate->set_var('totallinea', $ListDet->getelem()->totallinea);
			}
			
		}while($ListDet->gonext());
	}
	/*Extraccion de Flete Productos SAP*/
    //$codsap = '4111,4112,4113,4114';
	$codsap = '9539,9540,9541,9542';
	$contador = count(split(',',$codsap));
	$tuparray=split(',',$codsap);
	$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detallecotizacion");
	foreach($tuparray as $key=>$value){
		bizcve::getproductof($Listp = new connlist(new dtoproducto(array('sap'=>$value))));
		$Listp->gofirst();
		
		$i++;
		$MiTemplate->set_var('codprods', $value);
		$MiTemplate->set_var('codtipos', $Listp->getelem()->prod_tipo);
		$MiTemplate->set_var('descripcions', $Listp->getelem()->descripcion);
		$MiTemplate->set_var('textb',$i);
		$MiTemplate->parse("BLO_detallecotizacion", "detalleproductos", true);	
		
		
	}
	/*FIN Extraccion de Flete Productos SAP*/
}




/* FIN CONSTRUCCION DTO DE FLETE, VALIDACION */







$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>

