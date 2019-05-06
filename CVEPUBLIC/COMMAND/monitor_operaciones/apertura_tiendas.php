<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../controlfolio/control_folio.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
$cod_local=$_REQUEST['cod_local'];
$nom_local=$_REQUEST['nom_local'];
$dir_local=$_REQUEST['dir_local'];
$ip_local=$_REQUEST['ip_local'];
$id_sap=$_REQUEST['id_sap'];
$cod_local_original=$_REQUEST['select_suministro'];
//general::alert($cod_local_original);
$folio_fct='1';
$folio_gde='1';

/*GRABAR NUEVO LOCAL*/
if($_REQUEST['accion']=='crear_local')
	if(bizcve::savelocal($List = new connlist(new dtolocal(array('cod_local'=>$cod_local, 'nom_local'=>$nom_local, 'dir_local'=>$dir_local,'ip_local'=>$ip_local,'id_sap'=>$id_sap,'foliofct'=>$folio_fct,'foliogde'=>$folio_gde))))){

		general::writeevent('Se ha creado un nuevo local con la siguiente informacion: Codigo local: '.$cod_local.'. Nombre de local: '.$nom_local.' Direccion Local:'.$dir_local.' IP Local: '.$ip_local. 'ID SAP: '.$id_sap. 'Folio Factura: '.$folio_fct.' Folio GDE: '.$folio_gde);
		general::writelog('Se ha creado un nuevo local con la siguiente informacion: Codigo local: '.$cod_local.'. Nombre de local: '.$nom_local.' Direccion Local:'.$dir_local.' IP Local: '.$ip_local. 'ID SAP: '.$id_sap. 'Folio Factura: '.$folio_fct.' Folio GDE: '.$folio_gde);
		general::alert('La tienda '.$nom_local.', ha sido creada correctamente.');
		$_REQUEST['select_suministro']=-1;
	}else{
		general::alert('La tienda '.$nom_local.', no ha sido creada correctamente. Contacte un administrador.');
		general::writeevent('No fue posible crear la nueva tienda. Por favor contacte a su adminsitrador');
		general::writelog('No fue posible crear la nueva tienda. Por favor contacte a su adminsitrador');
		general::alert('No fue posible crear la nueva tienda. Por favor contacte a su adminsitrador');
	}

	if($_REQUEST['accion']=='update_local')
	if(bizcve::updatelocal($List = new connlist(new dtolocal(array('cod_local'=>$cod_local, 'nom_local'=>$nom_local, 'dir_local'=>$dir_local,'ip_local'=>$ip_local,'id_sap'=>$id_sap,'foliofct'=>$folio_fct,'foliogde'=>$folio_gde, 'cod_local_selected'=>$cod_local_original))))){

		general::writeevent('Se ha actualizado un local con la siguiente informacion: Codigo local: '.$cod_local.'. Nombre de local: '.$nom_local.' Direccion Local:'.$dir_local.' IP Local: '.$ip_local. 'ID SAP: '.$id_sap. 'Folio Factura: '.$folio_fct.' Folio GDE: '.$folio_gde);
		general::writelog('Se ha actualizado un local con la siguiente informacion: Codigo local: '.$cod_local.'. Nombre de local: '.$nom_local.' Direccion Local:'.$dir_local.' IP Local: '.$ip_local. 'ID SAP: '.$id_sap. 'Folio Factura: '.$folio_fct.' Folio GDE: '.$folio_gde);
		general::alert('La tienda '.$nom_local.', ha sido actualizada correctamente.');
		$_REQUEST['select_suministro']=-1;
		
	}else{
		general::alert('La tienda '.$nom_local.', no ha sido actualizada correctamente. Contacte un administrador.');
		general::writeevent('No fue posible actualizar la tienda. Por favor contacte a su adminsitrador');
		general::writelog('No fue posible actualizar la tienda. Por favor contacte a su adminsitrador');
		general::alert('No fue posible actualizar la tienda. Por favor contacte a su adminsitrador');
	}


///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE . "monitor_operaciones/apertura_tiendas.htm");

/*DESPLIEGUE*/

/*Despliegue informacion de Centro Suministro*/
$List  = new connlist;
if ($ses_usr_codlocal){
	bizcve::getlocales($List);
	$List->gofirst();
	$MiTemplate->set_block('main' , "suministro" , "BLO_suministro");
	if (!$List->isvoid()) {
		do {
			
			if($ses_usr_codlocal==$List->getelem()->cod_local){
				$MiTemplate->set_var('codigo_local', $ses_usr_codlocal);
				$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
				$MiTemplate->set_var('selected','selected');
				
		        $MiTemplate->parse("BLO_suministro", "suministro", true);
			}  	
		} while ($List->gonext());
	}
	
}
else{
	$List  = new connlist;
	bizcve::getlocales($List);
	$List->gofirst();
	$MiTemplate->set_block('main' , "suministro" , "BLO_suministro");
	if (!$List->isvoid()) {
		do {
			$MiTemplate->set_var('codigo_local', $List->getelem()->cod_local);
			$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
			//$MiTemplate->set_var('selected', ($ses_usr_codlocal == $List->getelem()->cod_local)?'selected':'');
	        $MiTemplate->set_var('selected', ($_REQUEST['select_suministro'] == $List->getelem()->cod_local)?'selected':'');
	        $MiTemplate->parse("BLO_suministro", "suministro", true);
		} while ($List->gonext());
	}
}
/*Fin Despliegue informacion de Centro Suministro*/

	/*Despliegue informacion a modificar*/

	$Lista  = new connlist;
	$mRegistro=new dtolocal;
	if(($_REQUEST['select_suministro'])&&($_REQUEST['select_suministro']!=-1)){
		$mRegistro->cod_local=$_REQUEST['select_suministro'];
		$MiTemplate->set_var('accion', 'update_local');
		$MiTemplate->set_var('mensaje_creacion', '*Los folios de Factura y Guias de despacho se mantendran con los valores actuales.');
		$MiTemplate->set_var('valor_boton', 'Actualizar tienda EASY');
		
	}else{
		$mRegistro->cod_local=-1;
		$MiTemplate->set_var('accion', 'crear_local');
		$MiTemplate->set_var('mensaje_creacion', '*Los folios de Factura y Guias de despacho seran inicializados en 1.');
		$MiTemplate->set_var('valor_boton', 'Crear nueva tienda EASY');
	}

	$Lista->addlast($mRegistro);
	bizcve::getlocales($Lista);
	$Lista->gofirst();
	$MiTemplate->set_var('cod_local', $Lista->getelem()->cod_local);
	$MiTemplate->set_var('nom_local', $Lista->getelem()->nom_local);
	$MiTemplate->set_var('dir_local', $Lista->getelem()->dir_local);
	$MiTemplate->set_var('ip_local', $Lista->getelem()->ip_local);
	$MiTemplate->set_var('id_sap', $Lista->getelem()->ofventa);
	/*Fin despliegue informacion a modificar*/

/*FIN DESPLIEGUE*/
$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>
