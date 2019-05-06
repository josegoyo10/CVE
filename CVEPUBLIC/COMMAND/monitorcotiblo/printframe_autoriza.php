<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitorcotiblo/monitor_co_bloqueadas.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
	

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
global $rut,$id_cotizacion,$origen;

$MiTemplate->set_var("id_cotizacion",$id_cotizacion);
$MiTemplate->set_var("rut",$rut);
$MiTemplate->set_var("origen",$origen);


// Agregamos el main
$MiTemplate->set_file("main", TEMPLATE . "monitorcotiblo/printframe_autoriza.htm");

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>