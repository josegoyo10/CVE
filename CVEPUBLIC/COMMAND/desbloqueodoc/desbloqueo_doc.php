<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../desbloqueodoc/desbloqueo_doc.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
/*DESBLOQUEAR DOCUMENTO*/
if ($_POST['accion'] == 'desbloquear') {
	if(bizcve::desbloqueadocprint($Listdoc = new connlist(new dtodocumento(array('numorigen'=>$_REQUEST['ordenent'], 'pagina' => $_REQUEST['pagina'], 'id_tipodocumento'=>$_REQUEST['filtro'], 'codlocalcsum'=>$_REQUEST['select_suministro']))))){
		general::alert('El Desbloqueo se ha realizado correctamente');
		if($_REQUEST['filtro']==1){
			$_REQUEST['filtro']='Factura';
			if($_REQUEST['pagina']!=null)
				general::writeevent('El desbloqueo de la '.$_REQUEST['filtro'].' en la página '.$_REQUEST['pagina'].', de la Orden de Entrega '.$_REQUEST['ordenent'].', que se encuentra en el local '.$_REQUEST['select_suministro'].', ha sido efectuado y realizado correctamente.');
	
			if($_REQUEST['pagina']=='')
				general::writeevent('Los desbloqueos de las '.$_REQUEST['filtro'].' en todas las páginas de la Orden de Entrega '.$_REQUEST['ordenent'].', encontradas en el local '.$_REQUEST['select_suministro'].', han sido efectuados y realizados correctamente.');
		}
		if($_REQUEST['filtro']==2){
			$_REQUEST['filtro']='Gu�a de Despacho';
			if($_REQUEST['pagina']!=null)
				general::writeevent('El desbloqueo de la '.$_REQUEST['filtro'].' en la página '.$_REQUEST['pagina'].', de la Orden de Entrega '.$_REQUEST['ordenent'].', que se encuentra en el local '.$_REQUEST['select_suministro'].', ha sido efectuado y realizado correctamente.');
	
			if($_REQUEST['pagina']=='')
				general::writeevent('Los desbloqueos de las '.$_REQUEST['filtro'].' en todas las páginas de la Orden de Entrega '.$_REQUEST['ordenent'].', encontradas en el local '.$_REQUEST['select_suministro'].', han sido efectuados y realizados correctamente.');
		}
	}
	
	else{
		$pagina=$_REQUEST['pagina'];
		$oe=$_REQUEST['ordenent'];
		$local=$_REQUEST['select_suministro'];
		if($_REQUEST['filtro']==1){
			$documento='Factura';
			if($_REQUEST['pagina']!=null)
				general::alert('No fue posible realizar el desbloqueo. La '.$documento.' en la pagina '.$pagina.', de la Orden de Entrega '.$oe.', no se encuentra en el local '.$local.'.');
			if($_REQUEST['pagina']=='')
				general::alert('No fue posible realizar el desbloqueo. La '.$documento.' buscada en todas las paginas de la Orden de Entrega '.$oe.', no fue encontrada en el local '.$local.'. Es posible que el documento haya sido impreso desde otro local');
		}
		if($_REQUEST['filtro']==2){
				$documento='Gu�a de Despacho';
				if($_REQUEST['pagina']!=null)
					general::alert('No fue posible realizar el desbloqueo. La '.$documento.' en la pagina '.$pagina.', de la Orden de Entrega '.$oe.', no se encuentra en el local '.$local.'.');
				if($_REQUEST['pagina']=='')
					general::alert('No fue posible realizar el desbloqueo. La '.$documento.' buscada en todas las paginas de la Orden de Entrega '.$oe.', no fue encontrada en el local '.$local.'. Es posible que el documento haya sido impreso desde otro local');			
		}
	}
}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE . "desbloqueodoc/desbloqueo_doc.htm");
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
			$MiTemplate->set_var('selected', ($ses_usr_codlocal == $List->getelem()->cod_local)?'selected':'');
	        $MiTemplate->set_var('selected', ($_POST['select_suministro'] == $List->getelem()->cod_local)?'selected':'');
	        $MiTemplate->parse("BLO_suministro", "suministro", true);
		} while ($List->gonext());
	}
}
/*Fin Despliegue informacion de Centro Suministro*/


/*DESPLIEGUE*/

$MiTemplate->set_var('ordenent',($_POST['ordenent'] && $_POST['filtro']==2)?$_POST['ordenent']."-".general::digiVer($_POST['ordenent']):$_POST['ordenent']);
if (!$_POST['filtro'])
	$MiTemplate->set_var('checkr1', 'checked');
else
	$MiTemplate->set_var('checkr'.$_POST['filtro'], 'checked');

$ListEnc  = new connlist;
$ListDet = new connlist;
$mRegistro = new dtoencordenent;

if ($ses_usr_codlocal) {
	$MiTemplate->set_var('deshabilitar_select','disabled');
	$mRegistro->codlocalcsum = $ses_usr_codlocal;
}
else {
	$mRegistro->codlocalcsum=$_POST['select_suministro'];
}

$MiTemplate->set_var('id_ordenent',$_POST['ordenent']);
$MiTemplate->set_var('pagina',$_POST['pagina']);

/*FIN DESPLIEGUE*/
$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>
