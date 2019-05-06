<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
if($action == 'login'){
	
	$usuario = $_REQUEST['usuario'];
	$pass    = $_REQUEST['clave'];
	
			
	if($usuario == '' || $pass == '' ){
		$msg_error = '*** No ha ingresado los datos requeridos intente de nuevo***';	
	}else{
		$Listval = new connlist;
		$confimp = new getidmodulos("ID_MODULO");
		$id_modulo =$confimp->ID_MODULO_GDREIMPRESION;
		bizcve::usuariomodulovalido($Listval, $usuario, $pass, $id_modulo);
		$Listval->gofirst();
		
		if($Listval->getelem()->usr_nombres != ''){
		
			$tupla   = $_REQUEST['id_ordenent'];
			$nombreuser = $Listval->getelem()->usr_nombres;
			$appeuser = $Listval->getelem()->usr_apellidos;
			$reimpresion = 1;
			echo "<script type='text/javascript'>";
			echo " window.open('../../COMMAND/monitororent/printframe.php?cadenapo=".$_REQUEST['cadenapo']."&popup=1&id_ordenent=$tupla&reimp=$reimpresion&nom=$nombreuser&app=$appeuser',100, 100, 309, 189);";
			echo " top.window.close();";
			echo "</script>";

		}
		else{
			$msg_error = '*** Su usuario y/o contrase&ntilde;a son inv&aacute;lidos, <br>por favor verifique e ingrese nuevamente los datos ***';
		}
				
	}
	
}


///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_var('error_app', $mensaje_error);
$reimp = 0;
/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "ordenent/validacion_oe.htm");
$MiTemplate->set_var('idor',$_REQUEST['id_ordenent']);
$MiTemplate->set_var('cadenapo',$_REQUEST['cadenapo']);
$MiTemplate->set_var("TEXT_ERROR",$msg_error);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>