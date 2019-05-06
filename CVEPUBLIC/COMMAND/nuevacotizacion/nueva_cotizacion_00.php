<?php

///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
//session_start();
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////
$confimp = new getidcontribuyente("CONTRIBUYENTE");
$opcion=$confimp->JURIDICO;
$opcion1=$confimp->EMPRESARIAL;
$opcion2=$confimp->SOCIOE;
	

if ($accion4 == 'sendrut') {

global $ses_usr_id;

	if(!bizcve::verificacionDePermisos($ses_usr_id,43, 'UPDATE')){
           general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }

    //  file_put_contents('opcionNueva.txt', $opcion1);
    //  file_put_contents('tipoCliente.txt', $tipocliente);
	if($tipocliente==$opcion1){

		$nit=$_POST['rut'];
		$nit=strtoupper(ereg_replace('\.|,|-','',$nit));
		$sub_dv=substr($nit,-1);
		$nit=substr($nit,0,strlen($nit)-1);
	
		if ( general::digiVer($nit)==$sub_dv )
		{
		

			header("Location: validaclienteunicows.php?rut=".$nit."&tipocliente=".$tipocliente);
		}
		else
		{
	     	header("Location: nueva_cotizacion_00.php?error=1");
		}
	}
	else
	{
		$nombreSession = general::get_nombre_usr($ses_usr_id);

    bizcve::setevento(14, 'Crear Cotizacion', $_SERVER['REMOTE_ADDR'], 'ABM de cotizacion',
                    'Se ha realizado la consulta de credito online para el cliente: '.$rut.' ','','Consulta de credito online del cliente', $nombreSession);

	// file_put_contents('validarWs.txt', 'WS');

	header("Location: validaclienteunicows.php?rut=".$_POST['rut']."&tipocliente=".$tipocliente);
	}
}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template();
$MiTemplate->set_var("TITULO", TITULO);

$pag_ini = '../nueva_cotizacion/nueva_cotizacion_00.php';

/*Inclusion de header*/
$MiTemplate->set_file("header","../../TEMPLATE/presentacion/header.htm");

/*Inclusion de main*/
$MiTemplate->set_file('main',"../../TEMPLATE/nuevacotizacion/nueva_cotizacion_00.htm");
if ($_GET['error']==1){
	$MiTemplate->set_var('error', 'alert("Número de CC/NIT/Rut ingresado es incorrecto");');
}
if ($_GET['error']==2){
	$MiTemplate->set_var('error', 'alert("El cliente es una persona NATURAL por favor remitalo a Centro De Proyectos");');
}
if ($_GET['error']==3){
	$MiTemplate->set_var('error', 'alert("Remita al cliente a Centro De Proyectos");');
}
if ($_GET['error']=='juridico'){
	$MiTemplate->set_var('error', 'alert("Número de NIT/Rut ingredaso esta asociado al perfil venta especial");');
}
if ($_GET['error']=='ventaespecial'){
	$MiTemplate->set_var('error', 'alert("Número de CC ingresado esta asociado al perfil venta especial");');
}
if ($_GET['error']==5){
	
	if($_GET['msgws']=='Esta solicitud generó un error inesperado.'){
	general::writelog('El WS ClientUnique,searchById no se encuentra disponible para consultar datos del cliente');
	$MiTemplate->set_var('error', 'alert("ClientUnique,searchById no se encuentra disponible para consultar datos del cliente");');
	}
	else{
	$MiTemplate->set_var('error', 'alert("El cliente no existe, por favor ingrese los datos en Cliente Unico");');	
	}
}
if ($_GET['error']==6){
	$MiTemplate->set_var('error', 'alert("ClientUnique,searchById no se encuentra disponible para consultar datos del cliente");');
}

$MiTemplate ->set_var("ejemplo",'Ventas Especiales &nbsp;&nbsp;(Ej :12345678-9)<br>Otro'.str_repeat("&nbsp;",25).'(Ej :87654321)');
$MiTemplate ->set_var("radio",'<td align="right"><div align="left"> &nbsp;</div><input type="radio" name="tipocliente" value="{opcion1}" >Ventas Especiales</td><td><div align="center"> &nbsp;</div><input type="radio" name="tipocliente" value="{opcion2}" >Socio Experto</td>');
$MiTemplate->set_var('opcion',$opcion);
$MiTemplate->set_var('opcion1',$opcion1);
$MiTemplate->set_var('opcion2',$opcion2);
$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';

?>