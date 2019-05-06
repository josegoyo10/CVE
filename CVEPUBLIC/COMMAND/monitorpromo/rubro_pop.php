<?

///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitorpromo/monitor_promo.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

if ($_POST['accion'] == 'selecciona_rubro') {
		general::returnvalue($_REQUEST['select_subrubro']);
		general::close();
		exit();
}
	
/*Fin Seleccion subrubro*/


///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
/*Inicializaci?n de Templates*/
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_file("main", TEMPLATE . "monitorpromo/rubro_pop.htm");

if ($_POST['accion'] == 'select_subrubro') {

	/*Despliegue SubRubro*/
	$List  = new connlist;
	$mRegistro=new dtopromocion;
	$mRegistro->descripcion = $_REQUEST['rubro'];
	$List->addlast($mRegistro);
	bizcve::getrubrosubrubro($List);
	$List->gofirst(); 
	$MiTemplate->set_block('main' , "subrubro" , "BLO_subrubro");
	if (!$List->isvoid()) {
		do {
			$MiTemplate->set_var('id_subrubro', $List->getelem()->id_promo);
			$MiTemplate->set_var('nom_subrubro', $List->getelem()->descripcion);			
			$MiTemplate->parse("BLO_subrubro", "subrubro", true);
		}while ($List->gonext());
	}
}else{
	$MiTemplate->set_var('id_subrubro', ' -----');
	$MiTemplate->set_var('nom_subrubro', ' ');
}

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>