<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitororpick/monitor_orpick_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////	

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
if($_REQUEST['imprimir']==1)
{
$MiTemplate->set_var("imprimir",'<img src="../../IMAGES/bloqueoprint.gif" width="73" height="29" border=0>');
}
else{
$MiTemplate->set_var("imprimir",'<A HREF="#" onClick="bloquearimpresiones ();"><img src="../../IMAGES/print.gif" width="73" height="29" border=0></A>');
}
$MiTemplate->set_file("main", TEMPLATE . "monitororpick/prthdr.htm");

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>