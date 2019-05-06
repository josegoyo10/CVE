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
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_file("main", TEMPLATE . "financiacion/financiacion.html");

$id_cotizacion=$_GET['id_cotizacion'];
$MiTemplate ->set_var("id_cotizacion",$id_cotizacion);
$ListEnc = new connlist;
$ListDet = new connlist;
$ListDir = new connlist;
$Registro = new dtocotizacion;
$Registro->id_cotizacion	=  $id_cotizacion; 
$ListEnc->addlast($Registro);
bizcve::getcotizacion($ListEnc, $ListDet);

$ListEnc->gofirst();
	if (!$ListEnc->isvoid()){	
	$MiTemplate->set_var('id_cotizacion', $ListEnc->getelem()->id_cotizacion);	
	$valortotal  =round($ListEnc->getelem()->valortotal + $ListEnc->getelem()->rete_renta + $ListEnc->getelem()->rete_iva + $ListEnc->getelem()->rete_ica+0);
	$sumtotal    =($valortotal - $ListEnc->getelem()->rete_renta - $ListEnc->getelem()->rete_iva - $ListEnc->getelem()->rete_ica);
	$MiTemplate->set_var('totalcot', $sumtotal);
	$MiTemplate->set_var('max_cheque',CHEQ_POS_MAX_NUM);
	$MiTemplate->set_var('min_c_inicial',round($sumtotal*CHEQ_POS_MIN_INICIAL));	
	$MiTemplate->set_var('total_cotizacion', number_format($sumtotal));	
}
$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>