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
$MiTemplate->set_var("logval",$_REQUEST['logval']);
$MiTemplate->set_var("id_usuariore",$_REQUEST['id_usuariore']);
$MiTemplate->set_var("apellidosre",$_REQUEST['apellidosre']);
$MiTemplate->set_var("nombresre",$_REQUEST['nombresre']);
$MiTemplate->set_var("imprimircadena",$_REQUEST['imprimircadena']);
$MiTemplate->set_var("mensaje",$_REQUEST['mensaje']);


// Agregamos el main
$MiTemplate->set_file("main", TEMPLATE . "monitororpick/printframe.htm");

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>