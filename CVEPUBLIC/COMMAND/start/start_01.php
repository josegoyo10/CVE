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


$MiTemplate->set_file("main", TEMPLATE . "start/home.htm");
/*Seteo de variables y querys*/
if($_REQUEST['mensajelogin']==1){
	$MiTemplate->set_var('mensajelogin',"alert('Por favor cambie su password');");
}
if($_REQUEST['mensajelogin']==2){
	$MiTemplate->set_var('mensajelogin',"alert('Cambio de local realizado con exito');");
}
// recupera el tipo de usuario para poder cotizar como Vendedor de Centro de Venta Empresa
//$tipoUsuariocol = bizcve::getTipoUsuarioCotiza($ses_usr_id); 
//if($ses_usr_codlocal==TIENDA_VIRTUAL_ID){
$MiTemplate ->set_var("imagenfont",'<p><img src="../../IMAGES/home_01_cert.jpg" width="778" height="400"></p>');	
/*}
else{
$MiTemplate ->set_var("imagenfont",'<p><br><H1><img src="../../IMAGES/socioexperto.jpg"><br><br><br><br><img src="../../IMAGES/socioetexto.JPG"></H1></p>');
}*/
$MiTemplate->parse("OUT_M", array("header", "main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>
