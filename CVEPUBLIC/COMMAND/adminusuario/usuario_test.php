<?php
/*
 * Created on 18/08/2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
include_once("../../INCLUDES/autoload.php");
include_once("../../BIZCLASS/bizcve.class.php");
include_once("../../../CVEPRIVATE/DTOCLASS/dtousuario.class.php");
include_once("../../../CVEPRIVATE/DAOCLASS/daousuario.class.php");
include_once("../../../CVEPRIVATE/HLPCLASS/template.class.php");

$usr = new bizcve;
$dto = new dtousuario;
$valor=1;
$usr->getuserid($dto,$valor);

$variable='123456';
$MiTemplate = new template;

// Agregamos el header
$MiTemplate->set_file("header","../../TEMPLATES/presentacion/encabezado_pagina.htm");

$MiTemplate->set_file("main","../../TEMPLATES/adminusuario/usuario_test.htm");
$MiTemplate->set_var('variable',$variable);
$MiTemplate->set_var('USR_ID',$dto->USR_ID);
$MiTemplate->set_var('USR_NOMBRES',$dto->USR_NOMBRES);
$MiTemplate->set_var('USR_APELLIDOS',$dto->USR_APELLIDOS);
$MiTemplate->set_var('USR_FONO',$dto->USR_FONO);
$MiTemplate->set_var('USR_CALLE',$dto->USR_CALLE);
$MiTemplate->set_var('USR_CIUDAD',$dto->USR_CIUDAD);
$MiTemplate->set_var('USR_EMAIL',$dto->USR_EMAIL);

// Agregamos el pie
$MiTemplate->set_file("footer","../../TEMPLATES/presentacion/pie_pagina.htm");
$MiTemplate->parse("OUT_M", array("header","main","footer"), true);
$MiTemplate->p("OUT_M");
 
?>
