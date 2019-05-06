<?php 
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE INCLUSION /////////////////////////
///////////////////////// ZONA DE ACCIONES /////////////////////////
if($_POST['accion']== 'save'){ 
$ContenidoEditor = str_replace("\n", "", $_POST['content']);
$ContenidoEditor = str_replace("\r", "", $ContenidoEditor);
$ContenidoEditor = stripslashes($ContenidoEditor);
$opcion=$_POST['id_mensaje'];
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
$MiTemplate->set_file("main", TEMPLATE . "editor_contenido/editor_contenido_01.html");

$opcion=$_POST['id_mensaje'];
$Listiop = new connlist;
bizcve::getinfoop($Listiop, $opcion);
$Listiop->gofirst();
if(!$Listiop->isvoid()){
	$MiTemplate->set_var('mensaje_guardado',$Listiop->getelem()->var_descripcion);
	$MiTemplate->set_var('tipomensaje',$Listiop->getelem()->tipo_mensaje);
	$MiTemplate->set_var('url',($Listiop->getelem()->tipo_mensaje==6?'../../COMMAND/nuevacotizacion/nueva_cotizacion_04_pop.php?id_cotizacion=3924':'../../COMMAND/nuevacotizacion/nueva_cotizacion_email.php?id_cotizacion=3924&modotexto=activo'));
	//$MiTemplate->set_var('separador',($opcion==106?' ':'|'));
	//$MiTemplate->set_var('quitarboton',($opcion==106?'newdocument,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,bullist,numlist,outdent,indent,anchor,image,cleanup,help,forecolor,backcolor,tablecontrols,hr,visualaid,charmap,emotions,iespell,media,advhr,print,ltr,rtl,insertlayer,moveforward,movebackward,absolute,styleprops,cite,abbr,acronym,del,ins,attribs,nonbreaking,template,pagebreak':' '));
}
$MiTemplate->set_var('id_mensaje_seleccionado',$opcion);
$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>