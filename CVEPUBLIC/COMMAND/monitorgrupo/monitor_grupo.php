<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitorgrupo/monitor_grupo.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
if ($_POST['accion'] == 'add' ){

	$List  = new connlist;
	$mRegistro=new dtopromocion;
	$mRegistro->grupo = $_POST['ngrupo'];
	$mRegistro->usuario = $ses_usr_login;
	$List->addlast($mRegistro);
	bizcve::insertgrupo($List);
	$List->gofirst(); 

}

if ($_POST['accion'] == 'eli' && $_REQUEST['ideli'] != ''){
	$List  = new connlist;
	$mRegistro=new dtopromocion;
	$mRegistro->id_grupo = $_REQUEST['ideli'];
	$List->addlast($mRegistro);
	bizcve::deletgrupo($List);
	$List->gofirst(); 	
}

if ($_POST['accion'] == 'modi' && $_REQUEST['ideli'] != ''){
	$List  = new connlist;
	$mRegistro=new dtopromocion;
	$archivo= fopen($_REQUEST['ac'] , "r"); 
	
	if ($archivo){ 
		$a =1;
		while (!feof($archivo)){ 
				$RutCliente[$a] =	fgets($archivo, 255);
				$a++;
			} 
		fclose ($archivo);
		} 
	

	$mRegistro->id_grupo = $_REQUEST['ideli'];
	$mRegistro->usuario = $ses_usr_login;
	
	if ($_POST['filtro']=='1'){//Agregar a tcp con los Ruts pasados
		for ( $i = 1 ; $i < count($RutCliente) ; $i ++) {
			$mRegistro->rut = substr($RutCliente[$i],1,strlen($RutCliente[$i])-3);
			$List->addlast($mRegistro);
			bizcve::insertcp($List);
			$List->gofirst();
		}
	}

	
	if ($_POST['filtro']=='2'){//Eliminar de tcp con los Ruts pasados
		for ( $i = 1 ; $i < count($RutCliente) ; $i ++) {
			$mRegistro->rut = substr($RutCliente[$i],1,strlen($RutCliente[$i])-3);
			$List->addlast($mRegistro);
			bizcve::deletcp($List);
			$List->gofirst();
		}
	}
		
}
	/*	
	
	
	
*/ 	


///////////////////////// ZONA DE DESPLIEGUE /////////////////////////




$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE . "monitorgrupo/monitor_grupo.htm");

//$MiTemplate->set_var("fechaucofini", $_POST["feini"]);
//$MiTemplate->set_var("fechaucoffin", $_POST["fefin"]);


/**/
/*Despliegue informacion de grupo*/
$Lista  = new connlist;
bizcve::getgrupo($Lista);
$Lista->gofirst();
$MiTemplate->set_block('main' , "grupo" , "BLO_grupo");
if (!$Lista->isvoid()) {
	do {
		$MiTemplate->set_var('id_grupo', $Lista->getelem()->id);
		$MiTemplate->set_var('nomgrupo', $Lista->getelem()->nombre);
		$MiTemplate->set_var('selected_grupo', ($_REQUEST['select_grupo'] == $Lista->getelem()->id)?'selected':'');
        $MiTemplate->parse("BLO_grupo", "grupo", true);
	} while ($Lista->gonext());
}
/*Fin Despliegue informacion de grupo*/

/**/
/*DESPLIEGUE*/   

//$MiTemplate->set_var('buscar',($_POST['buscar'] && $_POST['filtro']==1)?$_POST['buscar']."-".general::digiVer($_POST['buscar']):$_POST['buscar']);
/*if (!$_POST['filtro'])
	$MiTemplate->set_var('checkr3', 'checked');
else
	$MiTemplate->set_var('checkr'.$_POST['filtro'], 'checked');
*/
//$mRegistro = new dtopromocion;

//$mRegistro->fechaucofini = ($_POST['feini'])?general::formato_fecha_FORM2DB($_POST['feini']) . ' 00:00:00':null;
//$mRegistro->fechaucoffin = ($_POST['fefin'])?general::formato_fecha_FORM2DB($_POST['fefin']) . ' 23:59:59':null;

//$mRegistro->grupo=$_POST['select_grupo'];
//general::alert($_POS['select_grupo']);

$List  = new connlist;
$mRegistro=new dtopromocion;
$mRegistro->grupo = $_POST['select_grupo'];
//$mRegistro->fechaucofini = ($_POST['feini'])?general::formato_fecha_FORM2DB($_POST['feini']) . ' 00:00:00':null;
$List->addlast($mRegistro);
bizcve::getGrupoDet($List);
$List->gofirst(); 
//general::alert($List->getelem()->id_promo);
$MiTemplate->set_block('main' , "infopromo" , "BLO_infopromo");
if (!$List->isvoid()) {
	do {    
		$MiTemplate->set_var('id_grupo',$List->getelem()->id_grupo);
		$MiTemplate->set_var('nombre',$List->getelem()->grupo);
		$MiTemplate->set_var('usuariocrea',$List->getelem()->usuario);		
		$MiTemplate->set_var('feccrea',$List->getelem()->feccrea);
		$MiTemplate->set_var('cantidad',$List->getelem()->cantidad);
		$MiTemplate->set_var('accver',($List->getelem()->puedever)?"<a href=\"#\"><img src=\"../../IMAGES/info.gif\" alt=\"Ver\" border=\"0\" id=\"".$List->getelem()->id_promo."\" ></a>":"");
		$MiTemplate->set_var('accmodificar',($List->getelem()->puedemodificar)?"<a href=\"#\"><img src=\"../../IMAGES/editicon.gif\" alt=\"Modificar\" border=\"0\" id=\"".$List->getelem()->id_grupo."\" onClick=\"pop1(this)\"></a>":"");
		$MiTemplate->set_var('acceliminar',($List->getelem()->puedeeliminar)?"<a href=\"#\"><img src=\"../../IMAGES/trash.gif\" alt=\"Eliminar\" border=\"0\" id=\"".$List->getelem()->id_grupo."\" onClick=\"eliminargrupo(this)\"></a>":"");    

		$MiTemplate->parse("BLO_infopromo", "infopromo", true); 
	} while ($List->gonext());
}

/*Fin Despliegue promocion*/

/*FIN DESPLIEGUE*/
$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>
