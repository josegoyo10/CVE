<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////	

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
global $rut;
$MiTemplate->set_var("cadenapo",$_REQUEST['cadenapo']);
$MiTemplate->set_var("id_ordenent",$_REQUEST['id_ordenent']);
$MiTemplate->set_var("ban",$_REQUEST['ban']);

// Agregamos el main
$MiTemplate->set_file("main", TEMPLATE . "monitororent/printframe2.htm");

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>