<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
//$pag_ini = '../start/start_01.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////




///////////////////////// ZONA DE DESPLIEGUE /////////////////////////


$MiTemplate = new template;
$MiTemplate->set_file("main","../../TEMPLATE/nuevacotizacion/nueva_cotizacion_03_popup.html");
$MiTemplate->set_var('codlocalcsum',$_GET["codlocal"]);
$MiTemplate->set_var('tipopedido',$_GET["tipopedido"]);
$MiTemplate->set_var('limite',LIMITE_REG);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");


///////////////////////// ZONA PIE DE PAGINA /////////////////////////
?>