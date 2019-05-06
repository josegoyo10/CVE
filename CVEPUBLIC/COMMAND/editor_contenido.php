<?php
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE INCLUSION /////////////////////////
///////////////////////// ZONA DE ACCIONES /////////////////////////
if($_POST['accion']== 'save'){
//echo 'area ini '.($_POST['content']?$_POST['content']:'SIN NADA');
//echo '  area n 2222 '.($_POST['content']?$_POST['content']:'SIN NADA');
$ContenidoEditor = str_replace("\n", "", $_POST['content']);
$ContenidoEditor = str_replace("\r", "", $ContenidoEditor);
$ContenidoEditor = stripslashes($ContenidoEditor);
$confimp = new getidmensaje("MENSAJES");
$opcion=$confimp->ID_MENSAJE_MA;
$Listiop = new connlist;
try{
	bizcve::updatemensajeglo($Listiop, $opcion ,$ContenidoEditor);					
				}
				catch (Exception 	$e){
					general::alert('Ocurrio el siguiente error al modificar el mensaje'.$e->getMessage());
					general::writeevent('Ocurrio el siguiente error al modificar el mensaje'.$e->getMessage());
					continue;					
				}
}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_file("main", TEMPLATE . "editor_contenido/editor_contenido.html");

$confimp = new getidmensaje("MENSAJES");
$opcion=$confimp->ID_MENSAJE_MA;
$Listiop = new connlist;
bizcve::getinfoop($Listiop, $opcion);
$Listiop->gofirst();
if(!$Listiop->isvoid()){
	$MiTemplate->set_var('mensaje_guardado',$Listiop->getelem()->var_descripcion);
	
}
$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>