<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitororpick/monitor_orpick_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");

//Esto es exclusivo para la invocación desde el exterior (ej: CPE)
if ($_GET['user'] && $_GET['pass']) {
	if (!isset($ses_usr_login)) {
		//Redireccionamos al login
		header('Location: ../start/index.php?user=' . $_GET['user'] . '&pass=' . $_GET['pass'] . '&action=login' . '&source=' . $_SERVER['PHP_SELF']); 
		exit();
	}
	else {
		header('Location: ' . $_SERVER['PHP_SELF']); 
		exit();
	}
}

include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header_sc.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE . "monitororpick/monitor_orpick_00cpe.htm");
$MiTemplate->set_var('first','checked');
/**/
/*Despliegue informacion de Tipo Entrega*/
$List  = new connlist;
bizcve::gettipoentrega($List);
$List->gofirst();
$MiTemplate->set_block('main' , "tipoentrega" , "BLO_tipoentrega");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('identrega', $List->getelem()->id);
		$MiTemplate->set_var('nomtipoentrega', $List->getelem()->nombre);
		$MiTemplate->set_var('selected', ($_POST['select_tipoentrega'] == $List->getelem()->id)?'selected':'');
		
        $MiTemplate->parse("BLO_tipoentrega", "tipoentrega", true);
	} while ($List->gonext());
}
/*Fin Despliegue informacion de Tipo Entrega*/

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

/**/
/*Despliegue Estado Orden Entrega*/

$List  = new connlist;
$mRegistro=new dtoestado;
$mRegistro->tipo = 'OP';
$List->addlast($mRegistro);
bizcve::getestados($List);
$List->gofirst();
$MiTemplate->set_block('main' , "estado" , "BLO_estado");
	
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('id_estado', $List->getelem()->id_estado);			
		$MiTemplate->set_var('descripcion', $List->getelem()->descripcion);
		$MiTemplate->set_var('selected', ($_POST['select_estado'] == $List->getelem()->id_estado)?'selected':'');
		
		$MiTemplate->parse("BLO_estado", "estado", true);
	} while ($List->gonext());
}
/*Fin Despliegue Orden Entrega*/

/*DESPLIEGUE*/

$MiTemplate->set_var('buscar',($_POST['buscar'] && $_POST['filtro']==1)?$_POST['buscar']."-".general::digiVer($_POST['buscar']):$_POST['buscar']);
if (!$_POST['filtro'])
	$MiTemplate->set_var('checkr4', 'checked');
else
	$MiTemplate->set_var('checkr'.$_POST['filtro'], 'checked');

$ListEnc  = new connlist;
$ListDet = new connlist;
$mRegistro = new dtoencordenpicking;

if ($ses_usr_codlocal) {
	$MiTemplate->set_var('deshabilitar_select','disabled');
	$mRegistro->cod_local = $ses_usr_codlocal;
}
else {
	$mRegistro->cod_local=$_POST['select_suministro'];
}
$mRegistro->id_tipoentrega=$_POST['select_tipoentrega'];
$mRegistro->id_estado=$_POST['select_estado'];

if ($_POST['buscar']) {
	switch ($_POST['filtro']){
		case 1:
			$mRegistro->rutcliente = $_POST['buscar'];
			break;
		case 2:
			$mRegistro->razonsoc = $_POST['buscar'];
			break;
		case 3:
			$mRegistro->id_ordenent = $_POST['buscar'];
			break;
		case 4:
			$mRegistro->id_ordenpicking = $_POST['buscar'];
			break;
	}
}

$ListEnc->addlast($mRegistro);

bizcve::getordenpick($ListEnc, $ListDet=null);
$ListEnc->gofirst();
$MiTemplate->set_block('main' , "infopicking" , "BLO_infopicking");
	if (!$ListEnc->isvoid()) {
		do {
			$MiTemplate->set_var('{id_ordenpicking}',$ListEnc->getelem()->id_ordenpicking);
			$MiTemplate->set_var('{id_direccion',$ListEnc->getelem()->id_direccion);
			$MiTemplate->set_var('OP',$ListEnc->getelem()->id_ordenpicking);
			$MiTemplate->set_var('OE',$ListEnc->getelem()->id_ordenent);
			$MiTemplate->set_var('rut',$ListEnc->getelem()->rutcliente);
			$MiTemplate->set_var('razonsoc',$ListEnc->getelem()->razonsoc);
			$MiTemplate->set_var('nomtipoentrega',$ListEnc->getelem()->nomtipoentrega);
			$MiTemplate->set_var('nomestadopick',$ListEnc->getelem()->nomestado);
			$MiTemplate->set_var('nom_localcsum',$ListEnc->getelem()->nom_local);
			$MiTemplate->set_var('rutdv',$ListEnc->getelem()->rutcliente.'-'.general::digiVer($ListEnc->getelem()->rutcliente));
			$MiTemplate->set_var('accver',($ListEnc->getelem()->puedever)?"<a href=\"#\"><img src=\"../../IMAGES/info.gif\" alt=\"Ver Orden de Picking \" border=\"0\" id=\"".$ListEnc->getelem()->id_ordenpicking."\" onClick=\"verorpick(this)\"></a>":"");
			$MiTemplate->set_var('accmodificar',($ListEnc->getelem()->puedemodificar)?"<a href=\"#\"><img src=\"../../IMAGES/editicon.gif\" alt=\"Modificar Orden de Picking \" border=\"0\" id=\"".$ListEnc->getelem()->id_ordenpicking."\" onClick=\"editar_orpick(this)\"></a>":"");
						
			$MiTemplate->parse("BLO_infopicking", "infopicking", true);
		} while ($ListEnc->gonext());

}

/*FIN DESPLIEGUE*/
$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
?>
