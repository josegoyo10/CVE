<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitororpick/monitor_orpick_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////	

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
global $rut;

$MiTemplate->set_var("id_ordenpicking",$_REQUEST['id_ordenpicking']);
$MiTemplate->set_var("rut",$_REQUEST['rut']);

// Agregamos el main
$MiTemplate->set_file("main", TEMPLATE . "monitororpick/printframe2.htm");

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>