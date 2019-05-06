<?
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE INCLUSION /////////////////////////
///////////////////////// ZONA DE ACCIONES /////////////////////////
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_file("main", TEMPLATE . "editor_contenido/editor_contenido_00.html");

if($_GET['id_mensaje']){
$Listc  = new connlist;
$Registro = new dtooperaciones;
$Registro->area	= $_GET['id_mensaje'];
$Listc->addlast($Registro);
bizcve::getmensajeeditor($Listc);
$Listc->gofirst();
$contadortexto=0;
if (!$Listc->isvoid()) {
$MiTemplate->set_block('main' , "mensaje_editor" , "BLO_mensaje_editor");	
       do {
       		$contadortexto ++;
                //cambiados casos IF por switch. Puede hacer m?s f?cil agregar nuemos casos.
                //OJO: no es lo ideal. Debiera resolverse por base de datos. (fedseckel 20160419)
                switch($_GET['id_mensaje']){
                    case 6:
                    case 9:
                        $MiTemplate->set_var('tabla', '<td align="center">{imagen}</td><td><fieldset>{texto}</fieldset>');
                        $MiTemplate->set_var('imagentema', 'coti.JPG');
                        break;
                    case 7:
                        $MiTemplate->set_var('tabla', '<td align="center">{imagen}</td><td>{cuerpo_email}<fieldset>{texto}</fieldset>'); 
       		 	$MiTemplate->set_var('imagentema', 'textoemail.JPG'); 
       		 	$MiTemplate->set_var('cuerpo_email',($contadortexto==1?'ASUNTO:':($contadortexto==2?'CUERPO DEL MENSAJE':'')));
                        break;
                    default:
                        break;
                }
       		 $MiTemplate->set_var('imagen','<a href="#"><img src="../../IMAGES/editicon.gif" onclick="valida({id_valor})" border="0"></a>');
       		 $MiTemplate->set_var('id_valor', $Listc->getelem()->valor);
             $MiTemplate->set_var('texto', $Listc->getelem()->texto);
             $MiTemplate->parse("BLO_mensaje_editor", "mensaje_editor", true);     
       } while ($Listc->gonext());


}
}
$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>