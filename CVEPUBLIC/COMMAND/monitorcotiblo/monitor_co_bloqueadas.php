<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitorcotiblo/monitor_co_bloqueadas.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

/*Anulacin de Cotizacion*/
if ($_POST['accion'] == 'eli') {

	$List = new connlist;
	$cambioEst = new dtocambiosestado;
	$cambioEst->id_cotizacion 	  =$_POST['id_cotizacion'];	
	$cambioEst->id_estado_origen  =$_POST['origen'];	
	$cambioEst->id_estado_destino ="CN";
	
	$List->addlast($cambioEst);
	if (bizcve::cambiosestado($List)){
		general::writeevent('La cotizacion '.$_POST['id_cotizacion'].' Ha sido anulada, por el usuario '.$ses_usr_login);
	/*Insercion de tracking*/
		general::inserta_tracking( $_POST['id_cotizacion'], null, null, null, "Se ha anulado la cotización, por el usuario ".$ses_usr_login."");	
		header("Location: monitor_co_bloqueadas.php");	
	exit();
	}
	else
		general::alert('No ha sido posible anular la cotizacion. Contacte a su administrador.');

	header("Location: monitor_co_bloqueadas.php");	
}

/*Desbloqueo de Cotizacion*/
if ($_POST['accion'] == 'modi') {

/* echo $_REQUEST['id_cotizacion']."/cotizacion<br>";
echo $_REQUEST['origen']."/origen<br>";
echo $_REQUEST['id_motivoblo']."/motivobloqueo<br>";
echo $_REQUEST['id_comentarioblo']."/comentariobloqueo<br>";
echo $_REQUESTe['rut']."/rut<br>"; */

  // Chequeo que tenga el permiso desbloquear_cotizaciones
  if ( !bizcve::tienepermisodefuncionalidad('desbloquear_cotizaciones') )
  {
      general::alert("No tiene la funcionalidad desbloquear_cotizaciones asignada para poder desbloquear esta cotización.");   
  }
  else
  {
/* 	print_r($_REQUEST); */
  	$List = new connlist;
  	$ListDet = new connlist;
  	$cambioEst = new dtocambiosestado;
  	$cambioEst->id_cotizacion 	  =$_POST['id_cotizacion'];	
  	$cambioEst->id_estado_origen  =$_POST['origen'];	
  	$cambioEst->id_estado_destino ="CV";
  	$List->addlast($cambioEst);
  	if (bizcve::cambiosestado($List,$ListDet))
    {
	
		$desbloqueo = array();
		$desbloqueo['id_cotizacion'] = $_POST['id_cotizacion'];
		$desbloqueo['usuario'] = $ses_usr_login;
		$desbloqueo['motivo'] = $_REQUEST['motivoblo'];
		$desbloqueo['comentario'] = $_REQUEST['comentarioblo'];
		bizcve::setdesbloqueo($desbloqueo);

  		general::writeevent('La cotizacion '.$_POST['id_cotizacion'].' Ha sido desbloqueada por el usuario '.$ses_usr_login);
  	  /*Insercion de tracking*/
  		general::inserta_tracking( $_POST['id_cotizacion'], null, null, null, "Se ha desbloqueado la cotización, por el usuario ".$ses_usr_login."");	
		general::inserta_tracking( $_POST['id_cotizacion'], null, null, null, "Se ha desbloqueado la cotización, por el motivo : ".$_REQUEST['motivoblo']."");	
		general::inserta_tracking( $_POST['id_cotizacion'], null, null, null, "Se ha desbloqueado la cotización, con el comentario:".$_REQUEST['comentarioblo']."");	
		header("Location: monitor_co_bloqueadas.php");	
  	  exit();
  	}
  	else
    {
  		general::alert('No ha sido posible desbloquear la cotizacion. Contacte a su administrador.');
    }
    
    header("Location: monitor_co_bloqueadas.php");	
  }
}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE . "monitorcotiblo/monitor_co_bloqueadas.htm");

$MiTemplate->set_var("fechaucofini", $_POST["feini"]);
$MiTemplate->set_var("fechaucoffin", $_POST["fefin"]);

/* Obtencion del nombre del perfil del usuairo para determinar si puede realizar desbloqueo */
$List  = new connlist;
bizcve::infousuarioper($List, $ses_usr_id);
$List->gofirst();
$poseePerfil = "N";
if ( bizcve::tienepermisodefuncionalidad('desbloquear_cotizaciones') )
{ 
  $poseePerfil = "S";
}

/**/
/*Despliegue informacion de tipo venta*/
$List  = new connlist;
bizcve::gettipoventa($List);
$List->gofirst();
$MiTemplate->set_block('main' , "tipoventa" , "BLO_tipoventa");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('idventa', $List->getelem()->id);
		$MiTemplate->set_var('nomtipoventa', $List->getelem()->nombre);
		$MiTemplate->set_var('selected_venta', ($_POST['select_tipoventa'] == $List->getelem()->id)?'selected':'');
		
        $MiTemplate->parse("BLO_tipoventa", "tipoventa", true);
	} while ($List->gonext());
}
/*Fin Despliegue informacion de tipo venta*/

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
				$local = $List->getelem()->nom_local;
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
/*Fin Despliegue informacion de Centro Suministro*/

/*DESPLIEGUE*/   
$MiTemplate->set_var('buscar',($_POST['buscar'] && $_POST['filtro']==1)?$_POST['buscar']:$_POST['buscar']);

if (!$_POST['filtro'])
	$MiTemplate->set_var('checkr3', 'checked');
else
	$MiTemplate->set_var('checkr'.$_POST['filtro'], 'checked');


$ListEnc  = new connlist;
$mRegistro = new dtocotizacion;

if ($ses_usr_codlocal) {
	$MiTemplate->set_var('deshabilitar_select','disabled');
	//$mRegistro->codlocalcsum = $ses_usr_codlocal;
	$mRegistro->codlocalventa = $ses_usr_codlocal;
}
else {
	//$mRegistro->codlocalcsum=$_POST['select_suministro'];
	$mRegistro->codlocalventa =$_POST['select_suministro'];
}
$mRegistro->id_tipoventa=$_POST['select_tipoventa'];
$mRegistro->id_estado='CB';
$mRegistro->fechaucofini = ($_POST['feini'])?general::formato_fecha_FORM2DB($_POST['feini']) . ' 00:00:00':null;
$mRegistro->fechaucoffin = ($_POST['fefin'])?general::formato_fecha_FORM2DB($_POST['fefin']) . ' 23:59:59':null;

if ($_POST['buscar']) {
	switch ($_POST['filtro']){
		case 1:
			$mRegistro->rutcliente = $_POST['buscar'];
			break;
		case 2:
			$mRegistro->razonsoc = $_POST['buscar'];
			break;
		case 3:
			$mRegistro->id_cotizacion = $_POST['buscar'];
			break;

	}
}
$mRegistro->limite = LIMITE_DESPLIEGUE_COTI_BLOQUEADAS;     
$ListEnc->addlast($mRegistro);

bizcve::getMonitorcotizacion($ListEnc, $ListDet);
$origen=$ListEnc->getelem()->id_estado;
$id_estado=$ListEnc->getelem()->id_estado;
$rut=$ListEnc->getelem()->rutcliente;
$ListEnc->gofirst();
$MiTemplate->set_block('main' , "infocotizacion" , "BLO_infocotizacion");
	if (!$ListEnc->isvoid()) {
		do {
			$id_cotizacion=$ListEnc->getelem()->id_cotizacion;
			$MiTemplate->set_var('numerocot',$ListEnc->getelem()->id_cotizacion);
			$MiTemplate->set_var('id_impre',$ListEnc->getelem()->id_cotizacion);						
			$MiTemplate->set_var('id_cotizacion',$ListEnc->getelem()->id_cotizacion);
			$MiTemplate->set_var('rut',$ListEnc->getelem()->rutcliente);
			$MiTemplate->set_var('id_estado',$ListEnc->getelem()->id_estado);
			$MiTemplate->set_var('nomestadocot',$ListEnc->getelem()->nomestado);
			$MiTemplate->set_var('nomtipoventacot',$ListEnc->getelem()->nomtipoventa);
			$MiTemplate->set_var('fecha_bloqueo',general::formato_fecha($ListEnc->getelem()->feccrea));
			$MiTemplate->set_var('nom_localcsum',$ListEnc->getelem()->nom_localcsum);
			$Listj = new connlist;
			bizcve::gettipojur($rut,$Listj);
			$Listj->gofirst();
			$MiTemplate->set_var('rutdv', (($Listj->getelem()->id_contribuyente == 2)?$ListEnc->getelem()->rutcliente.'-'.general::digiVer($ListEnc->getelem()->rutcliente):$ListEnc->getelem()->rutcliente));
			$MiTemplate->set_var('razonsoc',$ListEnc->getelem()->razonsoc);
			
		/*Impresin de Cotizacion*/
			if ($id_estado=='CB'){
				$imprimir="<a href=\"#\"><img src=\"../../IMAGES/info.gif\" alt=\"Imprimir Cotizacion\" border=\"0\" onClick=\"Imprime('$origen',$rut,$id_cotizacion)\"></a>";
				$MiTemplate->set_var('accver', $imprimir);	
				$MiTemplate->set_var('accmodificar',"<a href=\"#\"><img src=\"../../IMAGES/editicon.gif\" alt=\"Modificar\" border=\"0\" id=\"".$ListEnc->getelem()->id_cotizacion."\" onClick=\"editarcoti(this)\"></a>");
				//general::alert($ListEnc->getelem()->id_cotizacion);		
			}
		
		/*Anulacin de Cotizacion*/
			if ($id_estado=='CB'){
				$anular="<a href=\"#\"><img src=\"../../IMAGES/anular.gif\" alt=\"Anular Cotizacion\" border=\"0\" onClick=\"anularrcoti('$origen',$id_cotizacion)\"></a>";
				$MiTemplate->set_var('accanular', $anular);
				$MiTemplate->set_var('accmodificar',"<a href=\"#\"><img src=\"../../IMAGES/editicon.gif\" alt=\"Modificar\" border=\"0\" id=\"".$ListEnc->getelem()->id_cotizacion."\" onClick=\"editarcoti(this)\"></a>");			
			}
			
		/*Desbloqueo de Cotizacion*/
			if ((($id_estado=='CB') && ($poseePerfil=='S')) && ((!($local)) || ($ListEnc->getelem()->nom_localventa == $local))){
				$desbloquear="<a href=\"imprimir_coblo_autoriza.php?origen=$origen&rut=$rut&id_cotizacion=$id_cotizacion\"><img src=\"../../IMAGES/unlock.gif\" alt=\"Desbloquear Cotizacion\" border=\"0\"></a>";
				$MiTemplate->set_var('accdesbloquear', $desbloquear);			
				$MiTemplate->set_var('accmodificar',"<a href=\"#\"><img src=\"../../IMAGES/editicon.gif\" alt=\"Modificar\" border=\"0\" id=\"".$ListEnc->getelem()->id_cotizacion."\" onClick=\"editarcoti(this)\"></a>");
			}
			
			$MiTemplate->parse("BLO_infocotizacion", "infocotizacion", true);
		} while ($ListEnc->gonext());
	}
/*Fin Despliegue Estado Cotizacion*/

/*FIN DESPLIEGUE*/

$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>
