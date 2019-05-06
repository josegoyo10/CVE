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
	
  	$img = new Securimage();
  	$valid = $img->check($_POST['code']);

	if($_POST['ca']==md5($_POST['clave'])){
		if($_POST['nclave']==$_POST['cclave']){
		
		//if($valid == true) {
		$Listusuariop  = new connlist;
		$mRegistrousup= new dtousuario;
		$mRegistrousup->usr_id=$ses_usr_id;
		$mRegistrousup->usr_clave=$_POST['nclave'];
		$Listusuariop->addlast($mRegistrousup);
			if(bizcve::updateusrpassword($Listusuariop)){
			general::alert('Cambio de Password Exitoso');
			}
			else{
			general::alert('No es posible atender la solicitud en el momento');
			}
		//}
		//else {
		//general::alert('El codigo ingresado es incorrecto');
  		//}
		}
		else{
		general::alert('La nueva clave y la confirmacion de esta no son iguales');	
		}		
	}
	else{
	general::alert('Password incorrecto');
	}
}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template();
$MiTemplate->set_var("TITULO", TITULO);


$MiTemplate->set_file("header","../../TEMPLATE/presentacion/header.htm");
$MiTemplate->set_file('main',"../../TEMPLATE/adm_usr/adm_usr_password.html");

//////////////////usuarios//////////////////////
$Listusuario  = new connlist;
$mRegistrousu= new dtousuario;
$mRegistrousu->usr_id=$ses_usr_id;
$Listusuario->addlast($mRegistrousu);
bizcve::GetUsers($Listusuario);
$Listusuario->gofirst();
$MiTemplate->set_var('usuario', $Listusuario->getelem()->login);
$MiTemplate->set_var('nombre', $Listusuario->getelem()->usr_nombres);
$datoscontacto =explode(" ",$Listusuario->getelem()->usr_apellidos);
$MiTemplate->set_var('apellido1', $datoscontacto[0]);
$MiTemplate->set_var('apellido2', $datoscontacto[1]);
$MiTemplate->set_var('ca', $Listusuario->getelem()->usr_clave);
/*$MiTemplate->set_var('capcha','<tr>
<td colspan="4" align="center"><img src="../../INCLUDE/securimage/securimage_show.php?sid={imagen}">
<input type="text" name="code"></td>
</tr>');*/
//$MiTemplate->set_var('imagen',md5(uniqid(time())));
/*$MiTemplate->set_var('capcha','<tr>
<td colspan="4" align="center"><img src="graficatorta.php">
</td>
</tr>');*/
$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';

?>