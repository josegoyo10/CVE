<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../adm_usr/adm_usr_password.php';
//session_start();
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
include_once("../../INCLUDE/securimage/securimage.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
if($_POST['accion']=='guardar'){

	session_unregister ('ses_usr_codlocal');
	session_unregister ('ses_usr_nomlocal');
	session_register("ses_usr_codlocal");
	session_register("ses_usr_nomlocal");
	$ses_usr_codlocal=$_POST['select_suministro'];
	
	$ListUsrSesionL = new connlist;
	$DUserL = new dtolocal;
	$DUserL->cod_local =$_POST['select_suministro'];
	$ListUsrSesionL->addlast($DUserL); 
	bizcve::getlocales($ListUsrSesionL);
	$ListUsrSesionL->gofirst();
	$ses_usr_nomlocal=$ListUsrSesionL->getelem()->nom_local;

	header("Location: ../start/start_01.php?mensajelogin=2");

}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template();
$MiTemplate->set_var("TITULO", TITULO);


$MiTemplate->set_file("header","../../TEMPLATE/presentacion/header.htm");
$MiTemplate->set_file('main',"../../TEMPLATE/adm_usr/cambiar_local.html");

//////////////////usuarios//////////////////////
$Listusuario  = new connlist;
$mRegistrousu= new dtousuario;
$mRegistrousu->usr_id=$ses_usr_id;
$Listusuario->addlast($mRegistrousu);
bizcve::GetUsers($Listusuario);
$Listusuario->gofirst();

$List  = new connlist;
$mRegistrolocal = new dtolocal;
if($Listusuario->getelem()->id_tipousuario == 2){
	$List->clearlist();
	bizcve::getlocales($List);	
}
else{
	if(is_null($Listusuario->getelem()->cod_local) || trim($Listusuario->getelem()->cod_local)==''){
		$mRegistrolocal->cod_local="NoLocal";
		$MiTemplate->set_var('error_usuario',"error_usuario();");
	}
	else{
		$mRegistrolocal->cod_local=$Listusuario->getelem()->cod_local;
	}
	$List->addlast($mRegistrolocal);
	bizcve::getcambiolocales($List);
}

$List->gofirst();
$MiTemplate->set_block('main' , "suministro" , "BLO_suministro");
if (!$List->isvoid()) {
	do {
			$MiTemplate->set_var('selectedlocal', ($List->getelem()->cod_local==$ses_usr_codlocal?'selected':''));
			$MiTemplate->set_var('codigo_local', $List->getelem()->cod_local);
			$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
			$MiTemplate->parse("BLO_suministro", "suministro", true);
	} while ($List->gonext());
}

$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");


///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>