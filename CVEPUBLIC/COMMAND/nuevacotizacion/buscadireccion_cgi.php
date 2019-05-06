<?php
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");


//set_exception_handler('not_catched_exceptions');

//Obtenemos las variables globales
$List = new connlist;
bizcve::getglobals($List);
$List->gofirst();
if (!$List->isvoid()) {
	do {
    	define($List->getelem()->nombre, $List->getelem()->valor);
	} while ($List->gonext());
}
$rut = $_GET["rut"];
$iddireccion = $_GET["iddireccion"];
if($iddireccion!=0)
{
bizcve::getdirdesp($List = new connlist(new dtodireccion(array('rut'=>$rut ))));	
$List->gofirst();
if (!$List->isvoid()) {
	do {
	if ($List->getelem()->id_direccion==$iddireccion)
	{
	$Listlocalizacion  = new connlist;
	$registrolocalizacion->id_localizacion=$List->getelem()->id_comuna;
	$Listlocalizacion->addlast($registrolocalizacion);
	bizcve::getlocalizacion($Listlocalizacion);
	$Listlocalizacion->gofirst();

		echo general::Quitartilde($List->getelem()->descripcion."|".$List->getelem()->fonocontacto."|".$List->getelem()->contacto."|".$List->getelem()->comentario."|".$List->getelem()->direccion."|".$Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad."|".$Listlocalizacion->getelem()->ciudad."|".$Listlocalizacion->getelem()->departamento."|".$List->getelem()->tipo_dir);
	}
	} while ($List->gonext());
}
}
else 
{
$List  = new connlist;
$mRegistro->rut=$rut;
$List->addlast($mRegistro);
bizcve::getCliente($List);
$List->gofirst();
if (!$List->isvoid()) {
	do {
		$Listlocalizacion  = new connlist;
		$registrolocalizacion->id_localizacion=$List->getelem()->id_comuna;
		$Listlocalizacion->addlast($registrolocalizacion);
		bizcve::getlocalizacion($Listlocalizacion);
		$Listlocalizacion->gofirst();
		
		echo general::Quitartilde("DIRECCION DE FACTURACION|".$List->getelem()->fonocontacto."|".$List->getelem()->apellido." ".$List->getelem()->contacto."|".$List->getelem()->comentario."|".$List->getelem()->direccion."|".$Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad."|".$Listlocalizacion->getelem()->ciudad."|".$Listlocalizacion->getelem()->departamento."|");		
		} while ($List->gonext());
	}
}
?>
