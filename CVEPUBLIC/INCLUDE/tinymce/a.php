<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
//$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
//session_start();
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////
general::writeevent('texto ingresado'.$_POST['content']);
echo 'texto ingresado'.$_POST['content'];

?>