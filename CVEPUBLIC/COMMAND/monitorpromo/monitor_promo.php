<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitorpromo/monitor_promo.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
if ($_POST['accion'] == 'grabar' ){

$List  = new connlist;
$mRegistro=new dtopromocion;
$mRegistro->cod_local = $_POST['select_suministro'];
$mRegistro->grupo = $_POST['select_grupo'];
$mRegistro->fechaucofini = ($_POST['feini'])?general::formato_fecha_FORM2DB($_POST['feini']) . ' 00:00:00':null;
$mRegistro->fechaucoffin = ($_POST['fefin'])?general::formato_fecha_FORM2DB($_POST['fefin']) . ' 23:59:59':null;
$mRegistro->subrubro = $_POST["id_subrubro"];
$mRegistro->descripcion = $_POST["descripcion"];
$mRegistro->descuento = $_POST["descuento"];
$mRegistro->usuario = $ses_usr_login;
$List->addlast($mRegistro);
bizcve::insertpromo($List); 
header("Location: monitor_promo.php");
}

if ($_POST['accion'] == 'eli' && $_REQUEST['ideli'] != ''){
$List  = new connlist;
$mRegistro=new dtopromocion;
$mRegistro->id_promo = $_REQUEST['ideli'];
$List->addlast($mRegistro);
bizcve::deletpromo($List);
$List->gofirst(); 	
}




///////////////////////// ZONA DE DESPLIEGUE /////////////////////////




$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE . "monitorpromo/monitor_promo.htm");

$MiTemplate->set_var("fechaucofini", $_POST["feini"]);
$MiTemplate->set_var("fechaucoffin", $_POST["fefin"]);


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
/*Despliegue informacion de Centro Suministro*/
$List  = new connlist;
if ($ses_usr_codlocal){
	bizcve::getlocales($List);
	$List->gofirst();
	$MiTemplate->set_block('main' , "suministro" , "BLO_suministro");
	if (!$List->isvoid()) {
		do {
			
			if($ses_usr_codlocal==$List->getelem()->cod_local){
				$MiTemplate->set_var('codigo_local', $ses_usr_codlocal);
				$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
				$MiTemplate->set_var('selected','selected');
				
		        $MiTemplate->parse("BLO_suministro", "suministro", true);
			}  	
		} while ($List->gonext());
	}
	
}
else{
	$List  = new connlist;
	bizcve::getlocales($List);
	$List->gofirst();
	$MiTemplate->set_block('main' , "suministro" , "BLO_suministro");
	if (!$List->isvoid()) {
		do {
			$MiTemplate->set_var('codigo_local', $List->getelem()->cod_local);
			$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
			$MiTemplate->set_var('selected', ($ses_usr_codlocal == $List->getelem()->cod_local)?'selected':'');
	        $MiTemplate->set_var('selected', ($_POST['select_suministro'] == $List->getelem()->cod_local)?'selected':'');
	        $MiTemplate->parse("BLO_suministro", "suministro", true);
		} while ($List->gonext());
	}
}

/*DESPLIEGUE*/   

$List  = new connlist;
$mRegistro=new dtopromocion;
$mRegistro->cod_local = $_POST['select_suministro'];
$mRegistro->grupo = $_POST['select_grupo'];
$mRegistro->fechaucofini = ($_POST['feini'])?general::formato_fecha_FORM2DB($_POST['feini']) . ' 00:00:00':null;
$mRegistro->fechaucoffin = ($_POST['fefin'])?general::formato_fecha_FORM2DB($_POST['fefin']) . ' 23:59:59':null;
$List->addlast($mRegistro);
bizcve::getMonitorpromocion($List);
$List->gofirst(); 
//general::alert($List->getelem()->id_promo);
$MiTemplate->set_block('main' , "infopromo" , "BLO_infopromo");
if (!$List->isvoid()) {
	do {    
		$Listy  = new connlist;
		$mRegistry=new dtopromocion;
		$mRegistry->id_promo =  $List->getelem()->subrubro;
		$Listy->addlast($mRegistry);
		bizcve::getsubrubro($Listy);
		$Listy->gofirst();
		$MiTemplate->set_var('id_subrubro', $Lista->getelem()->id_promo);
		$MiTemplate->set_var('nom_subrubro', $Lista->getelem()->descripcion);
		$MiTemplate->set_var('subrubro', $Listy->getelem()->descripcion);
		$MiTemplate->set_var('numpromo',$List->getelem()->id_promo);
		$MiTemplate->set_var('descripcion',$List->getelem()->descripcion);
		$MiTemplate->set_var('descuento',$List->getelem()->descuento);
		$MiTemplate->set_var('desde',$List->getelem()->fecini);
		$MiTemplate->set_var('hasta',$List->getelem()->fecterm);
		$MiTemplate->set_var('usuariocrea',$List->getelem()->usuario);		
		$MiTemplate->set_var('feccrea',$List->getelem()->feccrea);
		$MiTemplate->set_var('estadopromo',$List->getelem()->nomestado);
		if(!$List->getelem()->cod_local){
			$MiTemplate->set_var('cod_local','Valido para todos los locales.');
		}else{
			$MiTemplate->set_var('cod_local',$List->getelem()->cod_local);
		}
		if(!$List->getelem()->grupo){
			$MiTemplate->set_var('grupo','Valido para todos los grupos de cliente.');
		}else{
			$MiTemplate->set_var('grupo',$List->getelem()->grupo);
		}
		$MiTemplate->set_var('accver',($List->getelem()->puedever)?"<a href=\"#\"><img src=\"../../IMAGES/info.gif\" alt=\"Ver\" border=\"0\" id=\"".$List->getelem()->id_promo."\" onClick=\"vercoti(this)\"></a>":"");
		$MiTemplate->set_var('accmodificar',($List->getelem()->puedemodificar)?"<a href=\"#\"><img src=\"../../IMAGES/editicon.gif\" alt=\"Modificar\" border=\"0\" id=\"".$List->getelem()->id_promo."\" onClick=\"editarcoti(this)\"></a>":"");
		$MiTemplate->set_var('acceliminar',($List->getelem()->puedeeliminar)?"<a href=\"#\"><img src=\"../../IMAGES/trash.gif\" alt=\"Eliminar\" border=\"0\" id=\"".$List->getelem()->id_promo."\" onClick=\"eliminarpromo(this)\"></a>":"");    

		$MiTemplate->parse("BLO_infopromo", "infopromo", true); 
	} while ($List->gonext());
}

/*Fin Despliegue promocion*/

/*Despliegue subrubro*/
if($_REQUEST['id_subrubro']){
	$Listo  = new connlist;
	$mRegistri=new dtopromocion;
	$mRegistri->id_promo =  $_REQUEST['id_subrubro'];
	$Listo->addlast($mRegistri);
	bizcve::getsubrubro($Listo);
	$Listo->gofirst();
	$MiTemplate->set_var('id_subrubro', $Listo->getelem()->id_promo);
	$MiTemplate->set_var('nom_subrubro', $Listo->getelem()->descripcion);
	$MiTemplate->set_var('texto_cambio', '(Si desea cambiar presione el boton).');
	$MiTemplate->set_var('disabled_subrubro', 'readonly');
	$MiTemplate->set_var('clase_texto', 'textomargen');
}
if($List->getelem()->subrubro){
		$Lista  = new connlist;
		$mRegistra=new dtopromocion;
		$mRegistra->id_promo =  $List->getelem()->subrubro;
		$Lista->addlast($mRegistra);
		bizcve::getsubrubro($Lista);
		$Lista->gofirst();
		$MiTemplate->set_var('id_subrubro', $Lista->getelem()->id_promo);
		$MiTemplate->set_var('nom_subrubro', $Lista->getelem()->descripcion);
		$MiTemplate->set_var('texto_cambio', '(Si desea cambiar presione el boton).');
		$MiTemplate->set_var('disabled_subrubro', 'readonly');
		$MiTemplate->set_var('clase_texto', 'textomargen');
}
if(!$List->getelem()->subrubro && !$_REQUEST['id_subrubro']){
		$MiTemplate->set_var('nom_subrubro', 'Seleccionar Subrubro');
		$MiTemplate->set_var('texto_cambio', '');
		$MiTemplate->set_var('clase_texto', 'textonormal');
}

$mRegistro = new dtopromocion;
/*Fin despliegue subrubro*/

/*FIN DESPLIEGUE*/
$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>
