<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
	

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
global $rut,$id_cotizacion,$ses_usr_id;

if(!bizcve::verificacionDePermisos($ses_usr_id, 82, 'UPDATE')){
    general::alertexit('No tiene permisos para ejecutar la funcionalidad solicitada');  
}

	$nombreSession = general::get_nombre_usr($ses_usr_id);

	bizcve::setevento(25, 'Modulo Orden de Picking', $_SERVER['REMOTE_ADDR'], 'ABM OE',
        'Se ha impreso Guia para la Orden de Entrega: '.$id_ordenent.'','','Guia impresa', $nombreSession);

$MiTemplate->set_var("id_ordenent",$id_ordenent);

// Agregamos el main
$MiTemplate->set_file("main", TEMPLATE . "ordenent/printframe.htm");

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>