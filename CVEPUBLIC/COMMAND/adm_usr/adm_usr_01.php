<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
$bd = $_SESSION["DBACESS"];
/*si tiene local asignado no puede administrar usuarios*/
	if ($_SESSION["ses_usr_codlocal"]){
	    general::writeevent('No puede administrar perfiles, tiene local asignado'); 
		header( "Location: ../start/sin_perm_01.php");	
		exit();
	}
	global $ses_usr_id;
	$MiTemplate = new template;
	$MiTemplate->set_var('error_app', $mensaje_error);
	$MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("TEXT_TITULO","Administracion de perfiles y usuarios  ");
    $MiTemplate->set_var("SUBTITULO1","Modulos en el sistema");

    // Agregamos el header
	$MiTemplate->set_file("header", TEMPLATE."presentacion/header.htm");

   // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_usr/adm_usr_01.html");

	///////////////////////// ZONA PIE DE PAGINA /////////////////////////		
	$MiTemplate->parse("OUT_M", array("header", "main"), true);
	$MiTemplate->p("OUT_M");
	include '../menu/menu.php';
	include '../menu/footer.php';
?>