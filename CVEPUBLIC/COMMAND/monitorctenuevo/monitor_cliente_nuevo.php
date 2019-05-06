<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitorctenuevo/monitor_cliente_nuevo.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

/*Despliegue de informacion de cliente*/
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE . "monitorctenuevo/monitor_cliente_nuevo.htm");

$MiTemplate->set_var("fechaucofini", $_POST["feini"]);
$MiTemplate->set_var("fechaucoffin", $_POST["fefin"]);


$confimp = new getidcontribuyente("CONTRIBUYENTE");
$opcioncon1=$confimp->EMPRESARIAL;
/*filtro tipo de cliente*/
$Listcontri  = new connlist;
bizcve::gettipocontribuyente($Listcontri);
$Listcontri->gofirst();
if (!$Listcontri->isvoid()) {
$MiTemplate->set_block('main' , "contri" , "BLO_contri");
	do {
		$MiTemplate->set_var('nombrecontri', $Listcontri->getelem()->nombre);
		$MiTemplate->set_var('id', $Listcontri->getelem()->id);
		$MiTemplate->set_var('selectedcontri', ($_POST['tipo_cliente'] == $Listcontri->getelem()->id)?'selected':'');
		$MiTemplate->parse("BLO_contri", "contri", true);	
	} while ($Listcontri->gonext());
}
/*Filtro Vendedor*/  
$List = new connlist;
$mRegistro= new dtousuario;
$mRegistro->usr_tipo='000';
$mRegistro->id_tipousuario='2';
$List->addlast($mRegistro);
bizcve::GetUsers($List);
$List->gofirst();
$MiTemplate->set_block('main' , "vendedores" , "BLO_vendedores");
if (!$List->isvoid()) {
	
	do {
		$MiTemplate->set_var('codigovendedor',$List->getelem()->codigovendedor);
		$MiTemplate->set_var('nomvendedor',$List->getelem()->usr_nombres." ".$List->getelem()->usr_apellidos." (".($List->getelem()->cod_local?$List->getelem()->cod_local:'LOCAL NO ASIGNADO').")");
		$MiTemplate->set_var('selected', ($_POST['select_vendedores'] == $List->getelem()->codigovendedor)?'selected':'');		
		$MiTemplate->parse("BLO_vendedores", "vendedores", true);
	} while ($List->gonext());
}
///*Fin Filtro Vendedor*/
$MiTemplate->set_var('nombreing',($_POST['nombre']?$_POST['nombre']:''));
$MiTemplate->set_var('ruting',($_POST['rutingresado']?$_POST['rutingresado']:'')); 

if($_POST['accion']=='sendrut'){

$ListCliCVE = new connlist;
$ClientesCVE = new dtoinfocliente;
$ClientesCVE->razonsoc=($_POST['nombre']?$_POST['nombre']:'');
$ClientesCVE->rut=($_POST['rutingresado']?$_POST['rutingresado']:'');
$ClientesCVE->id_contribuyente=($_POST['tipo_cliente']?$_POST['tipo_cliente']:'');
($_POST['select_vendedores']?$ClientesCVE->codigovendedor=$_POST['select_vendedores']:'');
$ClientesCVE->limite = LIMITE_DESPLIEGUE_CLIENTE_NUEVO;
$ClientesCVE->orderby = 'razonsoc';
	
$ListCliCVE->addlast($ClientesCVE);
bizcve::getClienteRepor($ListCliCVE);
$ListCliCVE->gofirst();
$MiTemplate->set_block('main' , "infocliente" , "BLO_infocliente");
if (!$ListCliCVE->isvoid()) {
	do {
		$MiTemplate->set_var('acciones','<a href="#"><img src="../../IMAGES/person1.png" alt="Modificar Vendedor" title="Modificar Vendedor" width="19" height="17" border="0" align="middle" id="{rut}" onClick="editar_vendedor(this);" id2="{codigovendedor}"></a>
		<a href="#"><img src="../../IMAGES/editicon.gif" alt="Modificar Registro"  title="Modificar Registro" width="19" height="17" border="0" align="middle" id="{rut}" onClick="editar_registro(this);" ></a>&nbsp;');
		$MiTemplate->set_var('rut',$ListCliCVE->getelem()->rut);
		$MiTemplate->set_var('rutdv',(($ListCliCVE->getelem()->id_contribuyente == $opcioncon1)?$ListCliCVE->getelem()->rut.'-'.general::digiVer($ListCliCVE->getelem()->rut):$ListCliCVE->getelem()->rut));
		$MiTemplate->set_var('tipocliente',$ListCliCVE->getelem()->direccionservicio);
		$MiTemplate->set_var('razonsoc',$ListCliCVE->getelem()->razonsoc);
		$MiTemplate->set_var('vendedor',($ListCliCVE->getelem()->vendedor?$ListCliCVE->getelem()->vendedor:'&nbsp;'));
		$MiTemplate->parse("BLO_infocliente", "infocliente", true);
	} while ($ListCliCVE->gonext());
}
/*Fin Despliegue General*/

}

$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>
