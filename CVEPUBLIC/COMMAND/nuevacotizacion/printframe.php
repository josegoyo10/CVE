<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
	

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
global $rut,$id_cotizacion;

$MiTemplate->set_var("id_cotizacion",$id_cotizacion);
$MiTemplate->set_var("rut",$rut);
$MiTemplate->set_var("tipo", $tipo);
switch($tipo){
    case 'proforma':
        $MiTemplate->set_var("tipo_spa", 'Proforma');
        break;
    case 'cotizacion':
    default:
        $MiTemplate->set_var("tipo_spa", 'Cotizaci&#243;n');
        break;
}



// Agregamos el main
$MiTemplate->set_file("main", TEMPLATE . "nuevacotizacion/printframe.htm");

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>