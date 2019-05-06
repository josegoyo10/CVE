<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../controlfolio/control_folio.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
$fct=$_REQUEST['fct'];
$gde=$_REQUEST['gde'];

/*DESBLOQUEAR FOLIO*/
if($_REQUEST['accion']=='cambiarfct'){
	global $ses_usr_id;
	if(!bizcve::verificacionDePermisos($ses_usr_id,89, 'UPDATE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }
	if($ses_usr_codlocal){
		bizcve::savefolio($List = new connlist(new dtolocal(array('cod_local'=>$ses_usr_codlocal, 'numfolio_fct'=>$fct, 'numfolio_gde'=>$gde))));
		general::writeevent('Se han modificado los folios con la siguiente información: Codigo local: '.$ses_usr_codlocal.'. Nuevo folio Factura: '.$fct.'. Nuevo folio Guia despacho: El mismo');
	}else{
		bizcve::savefolio($List = new connlist(new dtolocal(array('cod_local'=>$_REQUEST['select_suministro'], 'numfolio_fct'=>$fct, 'numfolio_gde'=>$gde))));
		general::writeevent('Se han modificado losl folios con la siguiente información: Codigo local: '.$_REQUEST['select_suministro'].'. Nuevo folio Factura: '.$fct.'. Nuevo folio Guia despacho: El mismo');
	}
	global $ses_usr_id;
    $usr_nombre =general::get_nombre_usr( $ses_usr_id );
        bizcve::setevento(28, 'Modulo Control Folio', $_SERVER['REMOTE_ADDR'], 'ABM de folios',
                    ' Se ha modificado el folio inicial con la siguiente informacion: folio Factura: '.$fct.'. Nuevo folio Guia despacho: '.$gde.'','','Folio de factura modificado / Folio de guia de despacho modificado', $usr_nombre );
}

if($_REQUEST['accion']=='cambiargde'){
	global $ses_usr_id;
	if(!bizcve::verificacionDePermisos($ses_usr_id,89, 'UPDATE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }
	if($ses_usr_codlocal){
		bizcve::savefolio($List = new connlist(new dtolocal(array('cod_local'=>$ses_usr_codlocal, 'numfolio_fct'=>$fct, 'numfolio_gde'=>$gde))));
		general::writeevent('Se han modificado los folios con la siguiente información: Codigo local: '.$ses_usr_codlocal.'. Nuevo folio Factura: El mismo. Nuevo folio Guia despacho: '.$gde);
	}else{
		bizcve::savefolio($List = new connlist(new dtolocal(array('cod_local'=>$_REQUEST['select_suministro'], 'numfolio_fct'=>$fct, 'numfolio_gde'=>$gde))));
		general::writeevent('Se han modificado los folios con la siguiente información: Codigo local: '.$_REQUEST['select_suministro'].'. Nuevo folio Factura: El mismo. Nuevo folio Guia despacho: '.$gde);
	}

	global $ses_usr_id;
    $usr_nombre =general::get_nombre_usr( $ses_usr_id );
        bizcve::setevento(28, 'Modulo Control Folio', $_SERVER['REMOTE_ADDR'], 'ABM de folios',
                    ' Se ha modificado el folio inicial con la siguiente información: folio Factura: '.$fct.'. Nuevo folio Guia despacho: '.$gde.'','','Folio de factura modificado / Folio de guia de despacho modificado', $usr_nombre );
}


///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE . "controlfolio/control_folio.htm");
$MiTemplate->set_var('first','checked');

/**/
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


/*DESPLIEGUE*/

$ListEnc  = new connlist;
$ListDet = new connlist;
$mRegistro = new dtoencordenent;



if ($ses_usr_codlocal) {
	$MiTemplate->set_var('deshabilitar_select','disabled');
	$mRegistro->codlocalcsum = $ses_usr_codlocal;

}
else {
	$mRegistro->codlocalcsum=$_REQUEST['select_suministro'];

	$List  = new connlist;
	$mRegistro=new dtolocal;

	$mRegistro->cod_local=$_REQUEST['select_suministro'];
	
	$List->addlast($mRegistro);
	bizcve::getultimofolio($List);
	$List->gofirst();
	if(($_REQUEST['select_suministro']==null)){
		$MiTemplate->set_var('numfolio_fct', '');
		$MiTemplate->set_var('numfolio_gde', '');		
	}else{
		$MiTemplate->set_var('numfolio_fct', $List->getelem()->numfolio_fct);
		$MiTemplate->set_var('numfolio_gde', $List->getelem()->numfolio_gde);		
	}


}

if($ses_usr_codlocal){
	$List  = new connlist;
	$mRegistro=new dtolocal;
	
	$mRegistro->cod_local=$ses_usr_codlocal;
	
	$List->addlast($mRegistro);
	bizcve::getultimofolio($List);
	$List->gofirst();
	
	$MiTemplate->set_var('numfolio_fct', $List->getelem()->numfolio_fct);
	$MiTemplate->set_var('numfolio_gde', $List->getelem()->numfolio_gde);
}

/*FIN DESPLIEGUE*/
$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>
