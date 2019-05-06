<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitororent/monitor_orden_entrega.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

//Agregado Bloqueo Manual
if ($_POST['accion'] == 'bloqManual') {
  
  // Chequeo que tenga el permiso bloquear_oe_manualmente
  if ( !bizcve::tienepermisodefuncionalidad('bloquear_oe_manualmente') )
  {
      general::alert("No tiene la funcionalidad bloquear_oe_manualmente asignada para poder bloquear manualmente esta OE.");   
  }
  else
  {
  	$listoe = new connlist;
  	$oeBloqManual = new dtoencordenent;
  	$oeBloqManual->id_estado  ='OM';
  	$oeBloqManual->id_ordenent=$_POST['id_ordenent'];
  	$listoe->addlast($oeBloqManual);
  	bizcve::bloquearoemanual($listoe);
  	general::inserta_tracking(null, $_POST['id_ordenent'], null, null, "Se ha bloqueado manualmente la Orden de Entrega");
  	general::writeevent('La orden de entrega numero '.$_POST['id_ordenent'].' ha sido bloqueada');
  }
}
//Agregado Bloqueo Manual

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE . "monitororent/monitor_orden_entrega.htm");
$MiTemplate->set_var('first','checked');

$MiTemplate->set_var("fechaucofini", $_POST["feini"]);
$MiTemplate->set_var("fechaucoffin", $_POST["fefin"]);

/* Obtencion del nombre del perfil del usuairo para determinar si puede realizar acciones */
$List  = new connlist;
bizcve::infousuarioper($List, $ses_usr_id);
$List->gofirst();
$poseePerfil = "N";
if ( bizcve::tienepermisodefuncionalidad('bloquear_oe_manualmente') )
{ 
  $poseePerfil = "S";
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
				$usr_local_nombre = $List->getelem()->nom_local;
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

/**/
/*Despliegue Estado Orden Entrega*/
$List  = new connlist;
$mRegistro=new dtoestado;
$mRegistro->tipo = 'OE';
$List->addlast($mRegistro);
bizcve::getestados($List);
$List->gofirst();
$MiTemplate->set_block('main' , "estado" , "BLO_estado");
		
if (!$List->isvoid()) {
	do {
	
		if (($List->getelem()->id_estado != 'FG') && ($List->getelem()->id_estado != 'FN') && ($List->getelem()->id_estado != 'GG') && ($List->getelem()->id_estado != 'GN')) {
			$MiTemplate->set_var('id_estado', $List->getelem()->id_estado);			
			$MiTemplate->set_var('descripcion', $List->getelem()->descripcion);
			$MiTemplate->set_var('selected', ($_POST['select_estado'] == $List->getelem()->id_estado)?'selected':'');
			$MiTemplate->parse("BLO_estado", "estado", true);
		}
	} while ($List->gonext());
}
/*Fin Despliegue Orden Entrega*/

/*DESPLIEGUE*/
$lfiltro = ($_GET['filtro']?$_GET['filtro']:$_POST['filtro']);
$lbuscar = ($_GET['buscar']?$_GET['buscar']:$_POST['buscar']);

$MiTemplate->set_var('buscar',($lbuscar && $lfiltro==1)?$lbuscar:$lbuscar);
if (!$lfiltro)
	$MiTemplate->set_var('checkr4', 'checked');
else
	$MiTemplate->set_var('checkr'.$lfiltro, 'checked');

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
	$mRegistro->codlocalventa =$_POST['select_suministro'];
}
$mRegistro->fechaucofini = ($_POST['feini'])?general::formato_fecha_FORM2DB($_POST['feini']) . ' 00:00:00':null;
$mRegistro->fechaucoffin = ($_POST['fefin'])?general::formato_fecha_FORM2DB($_POST['fefin']) . ' 23:59:59':null;
$mRegistro->id_tipoentrega=$_POST['select_tipoentrega'];
$mRegistro->id_estado=$_POST['select_estado'];
$mRegistro->id_tipoflujo=$_POST['select_facturacion'];

if ($lbuscar) {
	switch ($lfiltro){
		case 1:
			$mRegistro->rutcliente = $lbuscar;
			break;
		case 2:
			$mRegistro->razonsoc = $lbuscar;
			break;
		case 3:
			$mRegistro->id_cotizacion = $lbuscar;
			break;
		case 4:
			$mRegistro->id_ordenent = $lbuscar;
			break;
	}
}

$mRegistro->limite = LIMITE_DESPLIEGUE_ORDENENT;
$ListEnc->addlast($mRegistro);
$id_estado=$_POST['select_estado'];
bizcve::getMonitorordenent($ListEnc, $ListDet);
$ListEnc->gofirst();
$rut=$ListEnc->getelem()->rutcliente;

$MiTemplate->set_block('main' , "infocotizacion" , "BLO_infocotizacion");
	if (!$ListEnc->isvoid()) {
		do {
			bizcve::gettipoflujo($Listf=new connlist(new dtotipo(array('id'=>$ListEnc->getelem()->id_tipoflujo))));
			$Listf->gofirst();	
			$MiTemplate->set_var('chek1', (($id_estado == 'OG')?'<td width="25"  align="left"><input name="check"  id="ALL" alt="Seleccionar Todas las Guias de Despacho" type="checkbox" onClick="chequea(document.accionesc.check_op)" value="CheckAll">&nbsp;</td>':''));
			$MiTemplate->set_var('chek2', (($id_estado == 'OG')?'<td width="25"  align="left" ><input type="checkbox" id2="{numinterno}" desc="{numorigen}" id="'.$ListEnc->getelem()->id_ordenent.'" name="check_op" value="checkbox">&nbsp;</td>':''));		
			$MiTemplate->set_var('numerocot',$ListEnc->getelem()->id_cotizacion);
			$MiTemplate->set_var('rut',$ListEnc->getelem()->rutcliente);
			$MiTemplate->set_var('razonsoc',$ListEnc->getelem()->razonsoc);
			$MiTemplate->set_var('numdocpago',$ListEnc->getelem()->numdocpago);
			$MiTemplate->set_var('nomtipoentrega',$Listf->getelem()->nombre);			
			$MiTemplate->set_var('OE',$ListEnc->getelem()->id_ordenent);
			$MiTemplate->set_var('nomestadocot',$ListEnc->getelem()->nomestadorent);
			$MiTemplate->set_var('fecha_crea',general::formato_fecha($ListEnc->getelem()->feccrea));
			$MiTemplate->set_var('nomtipofactura',$ListEnc->getelem()->nomtipoflujo);
			$MiTemplate->set_var('nom_localcsum',$ListEnc->getelem()->nom_localcsum);
			$Listj = new connlist;
			bizcve::gettipojur($rut,$Listj);
			$Listj->gofirst();
			
			/*$configclitipo = new getidcontribuyente("CONTRIBUYENTE");
			$opcion=$configclitipo->JURIDICO;
			$opcion1=$configclitipo->EMPRESARIAL;*/
			
			$MiTemplate->set_var('rutdv',(($Listj->getelem()->id_contribuyente == 2)?$ListEnc->getelem()->rutcliente.'-'.general::digiVer($ListEnc->getelem()->rutcliente):$ListEnc->getelem()->rutcliente));
			$MiTemplate->set_var('accver',($ListEnc->getelem()->puedever)?"<a href=\"#\"><img src=\"../../IMAGES/info.gif\" alt=\"Ver Orden de Entrega\" border=\"0\" id=\"".$ListEnc->getelem()->id_ordenent."\" onClick=\"veroe(this)\"></a>":"");
			
			if (($poseePerfil == "S") && (((!($usr_local_nombre)) || ($ListEnc->getelem()->nom_localventa == $usr_local_nombre)) && ($ListEnc->getelem()->id_estado == 'OA'))) {
				$MiTemplate->set_var('accbloq',($ListEnc->getelem()->puedever)?"<a href=\"#\"><img src=\"../../IMAGES/lock.gif\" alt=\"Bloquear Orden de Entrega\" border=\"0\" id=\"".$ListEnc->getelem()->id_ordenent."\" onClick=\"bloquearOE('".$ListEnc->getelem()->id_ordenent."')\"></a>":"");
			} else {
				$MiTemplate->set_var('accbloq','');
			}
			/*$MiTemplate->set_var('icoimp',(($id_estado == 'OG')?
			    '<table width="376" border="0" align="center" cellpadding="0" cellspacing="0" class="subtitulonormal">
                  <tr>
                    <td colspan=8>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="131" align="right"><a href="#"><img src="../../IMAGES/print2.gif" alt="Imprimir Guia de Despachos" width="23" height="23" name="Imprimir Guia de Despachos" onClick="verifica()" " border="0"></a></td>
                    <td width="245" align="left">Imprimir Guias de Despacho</td>
                  </tr>
                </table>
			':''));*/
			$MiTemplate->parse("BLO_infocotizacion", "infocotizacion", true);
			bizcve::getdocumento($List = new connlist(new dtodocumento(array('tipoorigen'=>'OE', 'id_tipodocumento'=>'2', 'numorigen'=>$ListEnc->getelem()->id_ordenent))), $ListDet = new connlist);
			$List->gofirst();
			//echo "este es el valor de la variable",$List->getelem()->id_documento;
			$MiTemplate->set_var('numinterno', $List->getelem()->id_documento);
			$MiTemplate->set_var('numorigen', $List->getelem()->numorigen);
		} while ($ListEnc->gonext());
}

/*Validacion para la impresion*/
 

$MiTemplate->set_var('BLOQUEO_IMPRESION_GDE', BLOQUEO_IMPRESION_GDE);

$MiTemplate->set_block('main' , "doclocklist" , "BLO_doclocklist");
if ($List->numelem()) {
	
	do {
		
		$MiTemplate->set_var('id_documento', $List->getelem()->id_documento);
		$MiTemplate->set_var('lockprintgde', $List->getelem()->lockprintgde);
		
		//Busco la OP si existe y veo que esté cerrada en PD
		$lockprintop = false;
		if ($List->getelem()->numdocrefop) {
			bizcve::getordenpick($Listop = new connlist(new dtoencordenpicking(array('id_ordenpicking'=>$List->getelem()->numdocrefop))), null);
			$Listop->gofirst();
			if ($Listop->getelem() && $Listop->getelem()->id_estado != 'PD'){
				$lockprintop = $List->getelem()->numdocrefop;
			}
		}
		$MiTemplate->set_var('lockprintop', $lockprintop);
		$MiTemplate->set_var('indmsgsap', $List->getelem()->indmsgsap);		
		
		$MiTemplate->parse("BLO_doclocklist", "doclocklist", true);	
	} while ($List->gonext());
	
	
}

/*Fin Validacion para la impresion*/
/*FIN DESPLIEGUE*/
$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>
