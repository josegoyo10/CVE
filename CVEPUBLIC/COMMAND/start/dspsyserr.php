<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../start/start_01.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////




///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
/*Seteo de variables y querys*/


$MiTemplate->set_file("main", TEMPLATE . "start/dspsyserr.htm");
/*Seteo de variables y querys*/
$MiTemplate->set_var("MSG_ERR_APP", MSG_ERR_APP);


$MiTemplate->parse("OUT_M", array("header", "main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>