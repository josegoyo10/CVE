<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

 ///////////////////////// ZONA DE ACCIONES /////////////////////////



///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

/*si tiene local asignado no puede administrar usuarios*/
if ($_SESSION["ses_usr_codlocal"]){
    general::writeevent('No puede administrar Ip de locales, tiene local asignado');  
	header( "Location: ../start/sin_perm_01.php");	
	exit();
}
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);
// Agregamos el header
$MiTemplate->set_file("header", TEMPLATE."presentacion/header.htm");

$MiTemplate->set_file("main", TEMPLATE."admingresoiplocal/admlistadoip.htm");
/*si viene local seteado, se deja como selecionado en la lista de locales*/
if( isset($ses_usr_codlocal) ) {
	$local=$ses_usr_codlocal;
}else{
	if ($select_local){
		$local=$select_local;
	}else{
		$local=0;
	}
}

$List = new connlist;
$mLocal = new dtolocal;
$mLocal->cod_local =$local;
$List->addlast($mLocal);
bizcve::getlocaleselect($List); 
$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block("main", "Locales", "PBLModulos");
	do {
		if($ses_usr_codlocal){
			$MiTemplate->set_var('disabledlocal', 'disabled');
		}
		$MiTemplate->set_var('codigo_local', $List->getelem()->cod_local);
		$MiTemplate->set_var('selected', $List->getelem()->cod_local_selected);		
		$MiTemplate->set_var('nombre_local', $List->getelem()->nom_local);
        $MiTemplate->parse("PBLModulos", "Locales", true);  
	} while ($List->gonext());
	$MiTemplate->clear_var('codigo_local');
	$MiTemplate->clear_var('nombre_local');
}

/*para obtener las variables de la pagina, para buscar la ip o local, listado*/
	if( isset($_POST['accion']) ) {
		if($_POST['accion']=='buscar'){
			$List = new connlist;
			$mLocal = new dtolocal;
			$mLocal->ip = $_POST['ip_buscar'];
			$mLocal->cod_local = $local;
			$List->addlast($mLocal);
			bizcve::getiplocal($List);
			$List->gofirst();			
		}
	}else{
		$List = new connlist;
		$mLocal = new dtolocal;
		$mLocal->cod_local = $local;
		$List->addlast($mLocal);
		bizcve::getiplocal($List);
		$List->gofirst();
	}	
	$MiTemplate->set_block("main", "listado_ip", "Modulos");
	if (!$List->isvoid()) {
		do {
			$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
			$MiTemplate->set_var('cod_local', $List->getelem()->cod_local);
			$MiTemplate->set_var('ip_local',  $List->getelem()->ip_local);		
	        $MiTemplate->parse("Modulos", "listado_ip", true);  
		} while ($List->gonext());
		$MiTemplate->clear_var('nom_local');
		$MiTemplate->clear_var('cod_local');
		$MiTemplate->clear_var('ip_local');	
	}

/*Terminado el codigo deben incluir esto*/
$MiTemplate->parse("OUT_M", array("header", "main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>


