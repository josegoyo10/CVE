<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

 ///////////////////////// ZONA DE ACCIONES /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);
// Agregamos el header
$MiTemplate->set_file("header", TEMPLATE."presentacion/header.htm");

$MiTemplate->set_file("main", TEMPLATE."start/sin_perm.htm");

$MiTemplate->parse("OUT_M", array("header", "main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';

?>