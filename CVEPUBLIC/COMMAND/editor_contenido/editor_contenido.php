<?php
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE INCLUSION /////////////////////////
///////////////////////// ZONA DE ACCIONES /////////////////////////
if($_POST['id_mensaje']){
header("Location: editor_contenido_00.php?id_mensaje=".$_POST['id_mensaje']);
}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_file("main", TEMPLATE . "editor_contenido/editor_contenido.html");

/*Despliegue Selección Giro*/
$Listc  = new connlist;
bizcve::getclasificacionmensaje($Listc);
$Listc->gofirst();

if (!$Listc->isvoid()) {
$MiTemplate->set_block('main' , "mensaje_editor" , "BLO_mensaje_editor");	
       do {
             $MiTemplate->set_var('id_giro', $Listc->getelem()->area);
             $MiTemplate->set_var('descripcion', $Listc->getelem()->evento);
             $MiTemplate->parse("BLO_mensaje_editor", "mensaje_editor", true);     
       } while ($Listc->gonext());

}
/*Fin Despliegue Selección Giro*/
$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>