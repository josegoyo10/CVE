<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
	

///////////////////////// ZONA DE ACCIONES /////////////////////////
	
/*Funcion Agrega los ceros a la izquierda de la fucion EAN*/
function calcula_num_os($os){
	
	$long_numero = strlen($os);
	
	if($long_numero == 7)
	    $id_os = $os;
	
	if($long_numero == 6)
	    $id_os = "0".$os;
	
	if($long_numero == 5)
	    $id_os = "00".$os;   
	
	if($long_numero == 4)
	    $id_os = "000".$os;
	    
	if($long_numero == 3)
	    $id_os = "0000".$os;
	    
	if($long_numero == 2)
	    $id_os = "00000".$os;
	    
	if($long_numero == 1)
	    $id_os = "000000".$os;    
	
	return $id_os;
}
/*Fin funcion*/
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
global $rut,$id_cotizacion,$id_estado;
/*Inclusi?n de header*/
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_file("main", TEMPLATE . "reportes/compraspendienteprovpop.htm");
$MiTemplate->set_var('idrut','1');
$MiTemplate->set_var('idnom','2');
$MiTemplate->set_var('idrc','3');
//echo $_POST['iddusqueda'];
if($_POST['textoin']){
$List = new connlist;
$Registro = new dtoproducto;
($_POST['iddusqueda']==1?$Registro->rutproveedor=$_POST['textoin']:$Registro->rutproveedor='');
($_POST['iddusqueda']==2?$Registro->nomprov=$_POST['textoin']:$Registro->nomprov='');
($_POST['iddusqueda']==3?$Registro->razonsocprov=$_POST['textoin']:$Registro->razonsocprov='');
$List->addlast($Registro);
bizcve::getproveedores($List);
$List->gofirst();

$MiTemplate->set_block('main' , "infoproveedor" , "BLO_infoproveedor");
	if (!$List->isvoid()) {
		
		do {
			$MiTemplate->set_var('imagen','<a href="#"><img src="../../IMAGES/person1.png" id="{idprov}" onClick="codprov(this)" border="0"></a>');
			$MiTemplate->set_var('rutprov',($List->getelem()->rutproveedor?$List->getelem()->rutproveedor:'&nbsp;'));
			$MiTemplate->set_var('nomprov',($List->getelem()->nomprov?$List->getelem()->nomprov:'&nbsp;'));
			$MiTemplate->set_var('idprov',($List->getelem()->codtipo?$List->getelem()->codtipo:'0'));
			$MiTemplate->set_var('razonsocprov',($List->getelem()->razonsocprov?$List->getelem()->razonsocprov:'&nbsp;'));
			$MiTemplate->parse("BLO_infoproveedor", "infoproveedor", true);
		} while ($List->gonext());
}

}
$MiTemplate->set_var('titulo_pagina', $titulo_pagina);

/*Fin de Orden de Pedido*/
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>