<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitoroeblo/monitor_oe_blo.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

/*ANULAR ORDEN DE ENTREGA*/

if ($_POST['accion'] == 'anular') {
	$listoe = new connlist;
	$ianular = new dtoencordenent;
	$ianular->id_estado   = 'OB';
	$ianular->obsdesb 	  = $_POST['razon_rechazo'];
	$ianular->id_ordenent = $_POST['id_ordenent'];
	$listoe->addlast($ianular);
	$ianular->id_estado   = 'OM';
	$ianular->obsdesb 	  = $_POST['razon_rechazo'];
	$ianular->id_ordenent = $_POST['id_ordenent'];	
	$listoe->addlast($ianular);
	bizcve::getMonitorordenent($listoe, $Listdet = new connlist());
	if (bizcve::anularoe($listoe)){
		/*Insercin de tracking*/

		global $ses_usr_id;

		if(!bizcve::verificacionDePermisos($ses_usr_id,84, 'UPDATE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }

		
		$usr_nombre =general::get_nombre_usr( $ses_usr_id );

		 bizcve::setevento(21, 'Anulación de OE bloqueadas', $_SERVER['REMOTE_ADDR'], 'ABM cotizacion',
                    'El bloqueo de la OE '.$_POST['id_ordenent'].' ha sido anulado','','Bloqueo de la OE ha sido anulado', $usr_nombre );

		general::inserta_tracking(null, $_POST['id_ordenent'], null, null, "Se ha anulado la Orden de Entrega");	
		bizcve::ActualizaCantNVEOE($Listdet, '-');
		general::writeevent('La orden de entrega numero '.$_POST['id_ordenent'].' ha sido anulada');
		header("Location: monitor_oe_blo.php");
		exit();
	}
}

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE . "monitoroeblo/monitor_oe_blo.htm");
$MiTemplate->set_var('first','checked');

$MiTemplate->set_var("fechaucofini", $_POST["feini"]);
$MiTemplate->set_var("fechaucoffin", $_POST["fefin"]);

/* Obtencion del nombre del perfil del usuairo para determinar si puede realizar desbloqueo */
$List  = new connlist;
bizcve::infousuarioper($List, $ses_usr_id);
$List->gofirst();
$poseePerfil = "N";
do {
	if ($List->getelem()->per_nombre == 'Admin') {
		$poseePerfil = "S";
	}
} while ($List->gonext());
/* Obtencion del nombre del perfil del usuairo para determinar si puede realizar desbloqueo */

if ( bizcve::tienepermisodefuncionalidad('desbloquear_oe_bloqueada_manualmente') )
{
    $permiso_desbloquear_oe_bloqueada_manualmente=true;
    $permiso_ver_oe_bloqueada_manualmente=true;
}
else
{
    $permiso_desbloquear_oe_bloqueada_manualmente=false; 
    $permiso_ver_oe_bloqueada_manualmente=false; 
}
 
if ( bizcve::tienepermisodefuncionalidad('desbloquear_oe_bloqueada_automaticamente') )
{
    $permiso_desbloquear_oe_bloqueada_automaticamente=true;
    $permiso_ver_oe_bloqueada_automaticamente=true;
}
else
{
    $permiso_desbloquear_oe_bloqueada_automaticamente=false; 
    $permiso_ver_oe_bloqueada_automaticamente=false; 
}

if ( bizcve::tienepermisodefuncionalidad('ver_oe_bloqueada_manualmente') )
{
    $permiso_ver_oe_bloqueada_manualmente=true;
}

if ( bizcve::tienepermisodefuncionalidad('ver_oe_bloqueada_automaticamente') )
{
    $permiso_ver_oe_bloqueada_automaticamente=true; 
}

/**/
/*Despliegue informacion de Tipo Entrega*/
$List  = new connlist;
bizcve::gettipoentrega($List);
$List->gofirst();
$MiTemplate->set_block('main' , "tipoentrega" , "BLO_tipoentrega");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('identrega', $List->getelem()->id);
		$MiTemplate->set_var('nomtipoentrega', $List->getelem()->nombre);
		$MiTemplate->set_var('selected', ($_POST['select_tipoentrega'] == $List->getelem()->id)?'selected':'');
		
        $MiTemplate->parse("BLO_tipoentrega", "tipoentrega", true);
	} while ($List->gonext());
}
/*Fin Despliegue informacion de Tipo Entrega*/

/**/
/*Despliegue informacion de Facturacion*/
	$ListEnc  = new connlist;
	bizcve::getFlujo($ListEnc, $ListDet);
	$ListEnc->gofirst();
	$MiTemplate->set_block('main' , "tipofacturacion" , "BLO_tipofacturacion");
	if (!$ListEnc->isvoid()) {

			$MiTemplate->set_var('nom_facturacion2',$ListEnc->getelem()->nomtipoflujo);		
	        
	        if($_POST['select_facturacion']=="1,2,3"){
	        	
	        	$MiTemplate->set_var('selected_fact1','selected');
	        }
	        else
	        if($_POST['select_facturacion']=="4,5"){
	        	$MiTemplate->set_var('selected_fact2','selected');
	        }
	        $MiTemplate->parse("BLO_tipofacturacion", "tipofacturacion", true);
	}

/*Fin Despliegue informacion de Facturaci?n*/

// desbloquear_oe_bloqueada_manualmente 
// desbloquear_oe_bloqueada_automaticamente 
// ver_oe_bloqueadas_manualmente 
// ver_oe_bloqueadas_automaticamente 

/*Despliegue informacion de Bloqueo*/
$ListEnc  = new connlist;
bizcve::getFlujo($ListEnc, $ListDet);
$ListEnc->gofirst();
$MiTemplate->set_block('main' , "tipobloqueo" , "BLO_tipobloqueo");
if (!$ListEnc->isvoid()) 
{  
  if( $permiso_ver_oe_bloqueada_manualmente && $permiso_ver_oe_bloqueada_automaticamente )
  {
    // TODAS
    $MiTemplate->set_var('selected',$_POST['select_bloqueo']=="0"?'selected':'');
    $MiTemplate->set_var('value','0');
    $MiTemplate->set_var('nom_bloqueo','TODAS');
    $MiTemplate->parse("BLO_tipobloqueo", "tipobloqueo", true);
  }
  if(  $permiso_ver_oe_bloqueada_automaticamente )
  {
    // Manuales
    $MiTemplate->set_var('selected',$_POST['select_bloqueo']=="1"?'selected':'');
    $MiTemplate->set_var('value','1');
    $MiTemplate->set_var('nom_bloqueo','Automatico');
    $MiTemplate->parse("BLO_tipobloqueo", "tipobloqueo", true);
  }
  if( $permiso_ver_oe_bloqueada_manualmente )
  {  
    // Automaticas
    $MiTemplate->set_var('selected',$_POST['select_bloqueo']=="2"?'selected':'');
    $MiTemplate->set_var('value','2');
    $MiTemplate->set_var('nom_bloqueo','Manual');
    $MiTemplate->parse("BLO_tipobloqueo", "tipobloqueo", true);
  }
}
/*Fin Despliegue informacion de Bloqueo*/

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
/*Fin Despliegue informacion de Centro Suministro*/


/*DESPLIEGUE*/

$MiTemplate->set_var('buscar',($_POST['buscar'] && $_POST['filtro']==1)?$_POST['buscar']:$_POST['buscar']);
if (!$_POST['filtro'])
	$MiTemplate->set_var('checkr4', 'checked');
else
	$MiTemplate->set_var('checkr'.$_POST['filtro'], 'checked');

$ListEnc  = new connlist;
$ListDet = new connlist;
$mRegistro = new dtoencordenent;

if ($ses_usr_codlocal) {
	$MiTemplate->set_var('deshabilitar_select','disabled');
	//$mRegistro->codlocalcsum = $ses_usr_codlocal;
	$mRegistro->codlocalventa = $ses_usr_codlocal;
}
else {
	//$mRegistro->codlocalcsum=$_POST['select_suministro'];
	$mRegistro->codlocalventa=$_POST['select_suministro'];
}
$mRegistro->id_tipoentrega=$_POST['select_tipoentrega'];

// desbloquear_oe_bloqueada_manualmente 
// desbloquear_oe_bloqueada_automaticamente 
// ver_oe_bloqueadas_manualmente 
// ver_oe_bloqueadas_automaticamente 
if ((!($_POST['select_bloqueo'])) || ($_POST['select_bloqueo']=="0")) 
{
  if( $permiso_ver_oe_bloqueada_manualmente && $permiso_ver_oe_bloqueada_automaticamente )
  {
      $mRegistro->id_estado="OB','OM";
  }
  else
  {
      if( $permiso_ver_oe_bloqueada_manualmente )
      {
          $mRegistro->id_estado='OM';
      }elseif( $permiso_ver_oe_bloqueada_automaticamente )
      {
          $mRegistro->id_estado='OB';
      }else
      {
          $mRegistro->id_estado='DUMMY';
      }            
  }
} else if ($_POST['select_bloqueo']=="2") {
	$mRegistro->id_estado='OM';
} else {
	$mRegistro->id_estado='OB';
}

$id_estado=$mRegistro->id_estado;
$origen=$mRegistro->id_estado;

$mRegistro->fechaucofini = ($_POST['feini'])?general::formato_fecha_FORM2DB($_POST['feini']) . ' 00:00:00':null;
$mRegistro->fechaucoffin = ($_POST['fefin'])?general::formato_fecha_FORM2DB($_POST['fefin']) . ' 23:59:59':null;
$mRegistro->id_tipoflujo=$_POST['select_facturacion'];




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
		case 4:
			$mRegistro->id_ordenent = $_POST['buscar'];
			break;
	}
}
$mRegistro->limite=LIMITE_DESPLIEGUE_ORDENENT_BLO;
$ListEnc->addlast($mRegistro);
bizcve::getMonitorordenent($ListEnc, $ListDet);
$ListEnc->gofirst();
if($ListEnc->getelem()->total_orden > LIMITE_DESPLIEGUE_ORDENENT_BLO){
	$MiTemplate->set_var('text_maximo','Se muestran los ultimos '.LIMITE_DESPLIEGUE_ORDENENT_BLO.' elementos de un total de '.$ListEnc->getelem()->total_orden.'.');
}if($ListEnc->getelem()->total_orden < LIMITE_DESPLIEGUE_ORDENENT_BLO){
	$MiTemplate->set_var('text_maximo','Se muestran los ultimos '.$ListEnc->getelem()->total_orden.' elementos de un total de '.$ListEnc->getelem()->total_orden.'.');
}if(!$ListEnc->getelem()->total_orden||$ListEnc->getelem()->total_orden==0||$ListEnc->getelem()->total_orden==null){
	$MiTemplate->set_var('text_maximo','Ningun elemento ha sido encontrado.');	
}
$MiTemplate->set_block('main' , "infocotizacion" , "BLO_infocotizacion");
	if (!$ListEnc->isvoid()) {
		do {
			$id_ordenent=$ListEnc->getelem()->id_ordenent;
			$rut=$ListEnc->getelem()->rutcliente;
			$MiTemplate->set_var('numerocot',$ListEnc->getelem()->id_cotizacion);
			$MiTemplate->set_var('rut',$ListEnc->getelem()->rutcliente);
			$MiTemplate->set_var('razonsoc',$ListEnc->getelem()->razonsoc);
			
			if ($ListEnc->getelem()->id_estado=='OM') {
				$tipo='Manual';
			} else {
				$tipo='Autom&aacute;tico';
			}
			$MiTemplate->set_var('tipoBloq',$tipo);
			
			$MiTemplate->set_var('nomtipoentrega',$ListEnc->getelem()->nomtipoentrega);
			$MiTemplate->set_var('OE',$ListEnc->getelem()->id_ordenent);
			$MiTemplate->set_var('nomestadocot',$ListEnc->getelem()->nomestadorent);
			$MiTemplate->set_var('fecha_blo',general::formato_fecha($ListEnc->getelem()->feccrea));
			$MiTemplate->set_var('nomtipofactura',$ListEnc->getelem()->nomtipoflujo);
			$MiTemplate->set_var('nom_localcsum',$ListEnc->getelem()->nom_localcsum);
			$Listj = new connlist;
			bizcve::gettipojur($rut,$Listj);
			$Listj->gofirst();
			$MiTemplate->set_var('rutdv', (($Listj->getelem()->id_contribuyente == 2)?$ListEnc->getelem()->rutcliente.'-'.general::digiVer($ListEnc->getelem()->rutcliente):$ListEnc->getelem()->rutcliente));
			$MiTemplate->set_var('accver',($ListEnc->getelem()->puedever)?"<a href=\"#\"><img src=\"../../IMAGES/info.gif\" alt=\"Ver Orden de Entrega\" border=\"0\" id=\"".$ListEnc->getelem()->id_ordenent."\" onClick=\"vercoti(this)\"></a>":"");
			
			/*Vista de OE*/
			if (($ListEnc->getelem()->id_estado=='OB') || ($ListEnc->getelem()->id_estado=='OM')) {
				$ver="<a href=\"#\"><img src=\"../../IMAGES/info.gif\" alt=\"Ver Orden de Entrega\" border=\"0\" onClick=\"verorden('$origen',$rut,$id_ordenent)\"></a>";
				$MiTemplate->set_var('accver', $ver);			
			} else {
				$MiTemplate->set_var('accver', '');
			}
			
			/*Anulacin de OE*/
			if (($ListEnc->getelem()->id_estado=='OB') || ((($poseePerfil == "S") && ($ListEnc->getelem()->id_estado=='OM')) && ((!($usr_local_nombre)) || ($ListEnc->getelem()->nom_localventa == $usr_local_nombre)))) {
				$anular="<a href=\"#\"><img src=\"../../IMAGES/anular.gif\" alt=\"Anular Orden de Entrega\" border=\"0\" onClick=\"anularorden($id_ordenent)\"></a>";
				$MiTemplate->set_var('accanular', $anular);			
			} else {
				$MiTemplate->set_var('accanular', '');
			}

			/*Desbloqueo de Orden de Entrega*/
			if (($ListEnc->getelem()->id_estado=='OB' && $permiso_desbloquear_oe_bloqueada_automaticamente) || ((($permiso_desbloquear_oe_bloqueada_manualmente) && ($ListEnc->getelem()->id_estado=='OM')) && ((!($usr_local_nombre)) || ($ListEnc->getelem()->nom_localventa == $usr_local_nombre)))) {
				$desbloquear="<a href=\"#\"><img src=\"../../IMAGES/unlock.gif\" alt=\"Autorizacion Orden de Entrega\" border=\"0\" onClick=\"desbloquearorden($id_ordenent,$rut)\"></a>";
				$MiTemplate->set_var('accdesbloquear', $desbloquear);			
			} else {
				$MiTemplate->set_var('accdesbloquear', '');
			}

			$MiTemplate->parse("BLO_infocotizacion", "infocotizacion", true);
		} while ($ListEnc->gonext());

}

/*FIN DESPLIEGUE*/
$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>
