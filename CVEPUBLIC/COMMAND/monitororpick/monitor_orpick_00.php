<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitororpick/monitor_orpick_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE . "monitororpick/monitor_orpick_00.htm");
$MiTemplate->set_var('first','checked');

$MiTemplate->set_var("fechaucofini", $_POST["feini"]);
$MiTemplate->set_var("fechaucoffin", $_POST["fefin"]);
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

/*Despliegue informacion de Prioridad*/
$List  = new connlist;
bizcve::getprioridad($List);
$List->gofirst();
$MiTemplate->set_block('main' , "prioridad" , "BLO_prioridad");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('id_prioridad', $List->getelem()->id);
		$MiTemplate->set_var('des_prioridad', $List->getelem()->nombre);
		$MiTemplate->set_var('selected', ($_POST['select_prioridad'] == $List->getelem()->id)?'selected':'');
		
        $MiTemplate->parse("BLO_prioridad", "prioridad", true);
	} while ($List->gonext());
}
/*Fin Despliegue informacion de Prioridad*/


/**/
/*Despliegue Estado Orden Entrega*/

$List  = new connlist;
$mRegistro=new dtoestado;
$mRegistro->tipo = 'OP';
$List->addlast($mRegistro);
bizcve::getestados($List);
$List->gofirst();
$MiTemplate->set_block('main' , "estado" , "BLO_estado");
	
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('id_estado', $List->getelem()->id_estado);			
		$MiTemplate->set_var('descripcion', $List->getelem()->descripcion);
		$MiTemplate->set_var('selected', ($_POST['select_estado'] == $List->getelem()->id_estado)?'selected':'');
		
		$MiTemplate->parse("BLO_estado", "estado", true);
	} while ($List->gonext());
}
/*Fin Despliegue Orden Entrega*/

/*DESPLIEGUE*/

$MiTemplate->set_var('buscar',($_REQUEST['buscar'] && $_REQUEST['filtro']==1)?$_REQUEST['buscar']:$_REQUEST['buscar']);
if (!$_REQUEST['filtro'])
	$MiTemplate->set_var('checkr4', 'checked');
else
	$MiTemplate->set_var('checkr'.$_REQUEST['filtro'], 'checked');

$ListEnc  = new connlist;
$ListDet = new connlist;
$mRegistro = new dtoencordenpicking;

if ($ses_usr_codlocal) {
	$MiTemplate->set_var('deshabilitar_select','disabled');
	$mRegistro->cod_local = $ses_usr_codlocal;
}
else {
	$mRegistro->cod_local=$_POST['select_suministro'];
}
$mRegistro->id_tipoentrega=$_POST['select_tipoentrega'];
$mRegistro->id_estado=$_POST['select_estado'];
$mRegistro->fechaucofini = ($_POST['feini'])?general::formato_fecha_FORM2DB($_POST['feini']) . ' 00:00:00':null;
$mRegistro->fechaucoffin = ($_POST['fefin'])?general::formato_fecha_FORM2DB($_POST['fefin']) . ' 23:59:59':null;
$mRegistro->prioridad=$_POST['select_prioridad'];

if ($_REQUEST['buscar']) {
	switch ($_REQUEST['filtro']){
		case 1:
			$mRegistro->rutcliente = $_REQUEST['buscar'];
			break;
		case 2:
			$mRegistro->razonsoc = $_REQUEST['buscar'];
			break;
		case 3:
			$mRegistro->id_ordenent = $_REQUEST['buscar'];
			break;
		case 4:
			$mRegistro->id_ordenpicking = $_REQUEST['buscar'];
			break;
	}
}
$mRegistro->limite = LIMITE_DESPLIEGUE_ORDENPICKING;
$ListEnc->addlast($mRegistro);

bizcve::getMonitorordenpick($ListEnc, $ListDet=null);
$ListEnc->gofirst();
if($ListEnc->getelem()->total_orden_pick > LIMITE_DESPLIEGUE_ORDENPICKING){
	$MiTemplate->set_var('text_maximo','Se muestran los ultimos '.LIMITE_DESPLIEGUE_ORDENPICKING.' elementos de un total de '.$ListEnc->getelem()->total_orden_pick.'.');
}if($ListEnc->getelem()->total_orden_pick < LIMITE_DESPLIEGUE_ORDENPICKING){
	$MiTemplate->set_var('text_maximo','Se muestran los ultimos '.$ListEnc->getelem()->total_orden_pick.' elementos de un total de '.$ListEnc->getelem()->total_orden_pick.'.');
}if(!$ListEnc->getelem()->total_orden_pick||$ListEnc->getelem()->total_orden_pick==0||$ListEnc->getelem()->total_orden_pick==null){
	$MiTemplate->set_var('text_maximo','Ningun elemento ha sido encontrado.');	
}
$MiTemplate->set_block('main' , "infopicking" , "BLO_infopicking");
	if (!$ListEnc->isvoid()) {
		do {

			$accver=(($ListEnc->getelem()->puedever)?"<a href=\"#\"><img src=\"../../IMAGES/info.gif\" alt=\"Ver Orden de Picking \" border=\"0\" id=\"".$ListEnc->getelem()->id_ordenpicking."\" rut=\"".$ListEnc->getelem()->rutcliente."\" onClick=\"verorpick(this, rut)\"></a>":"");
			$accoe=("<a href=\"#\"><img src=\"../../IMAGES/newicon.gif\" alt=\"Ir a OE relacionada. \" border=\"0\" id=\"".$ListEnc->getelem()->id_ordenent."\" onClick=\"veroe(this)\"></a>");
			$accmodificar=(($ListEnc->getelem()->puedemodificar)?"<a href=\"#\"><img src=\"../../IMAGES/editicon.gif\" alt=\"Modificar Orden de Picking \" border=\"0\" id=\"".$ListEnc->getelem()->id_ordenpicking."\" rut=\"".$ListEnc->getelem()->rutcliente."\" onClick=\"editar_orpick(this, rut)\"></a>":"");
			$Listj = new connlist;
			$rut = $ListEnc->getelem()->rutcliente;
			bizcve::gettipojur($rut,$Listj);
			$Listj->gofirst();
			
			if(($ListEnc->getelem()->prioridad==2)&&($ListEnc->getelem()->id_estado!=PD)&&($ListEnc->getelem()->id_estado!=PF)) {
				
				$MiTemplate->set_var('registro','
					<td width="25"  align="left" class="fondoprioridad"><input type="checkbox" id="'.$ListEnc->getelem()->id_ordenpicking.'" name="check_op" value="checkbox">&nbsp;</td>
					<td width="40"  align="left" class="fondoprioridad">'.$ListEnc->getelem()->id_ordenpicking.'&nbsp;</td>
					<td width="35"  align="left" class="fondoprioridad">'.$ListEnc->getelem()->id_ordenent.'</td>
					<td width="20"  align="left" class="fondoprioridad">'.$ListEnc->getelem()->nomprioridad.'&nbsp;</td>
					<td width="120"  align="left" class="fondoprioridad">'.$ListEnc->getelem()->nomestado.'&nbsp;</td>
					<td width="120" align="left" class="fondoprioridad">'.$ListEnc->getelem()->nomtipoentrega.'&nbsp;</td>
					<td width="140" align="left" class="fondoprioridad">'.$ListEnc->getelem()->nom_local.'&nbsp;</td>
					<td width="40" align="right" class="fondoprioridad">'.general::formato_fecha($ListEnc->getelem()->feccrea).'&nbsp;</td>
					<td width="70" align="right" class="fondoprioridad">'.(($Listj->getelem()->id_contribuyente == 2)?$ListEnc->getelem()->rutcliente.'-'.general::digiVer($ListEnc->getelem()->rutcliente):$ListEnc->getelem()->rutcliente).'&nbsp;</td>
					<td width="20" align="right" class="fondoprioridad">&nbsp;</td>
					<td width="100"  align="left" class="fondoprioridad">'.$ListEnc->getelem()->razonsoc.'&nbsp;</td>
					<td width="80" align="left" class="fondoprioridad">'.$accver.'&nbsp;'.$accmodificar.'&nbsp;'.$accoe.'&nbsp;</td>
			');	
			}
			
			else{
				$MiTemplate->set_var('registro','
				
					<td width="25"  align="left"><input type="checkbox" id="'.$ListEnc->getelem()->id_ordenpicking.'" name="check_op" value="checkbox">&nbsp;</td>
					<td width="40"  align="left">'.$ListEnc->getelem()->id_ordenpicking.'&nbsp;</td>
					<td width="35"  align="left" >'.$ListEnc->getelem()->id_ordenent.'</td>
					<td width="20"  align="left" >'.$ListEnc->getelem()->nomprioridad.'&nbsp;</td>
					<td width="120"  align="left">'.$ListEnc->getelem()->nomestado.'&nbsp;</td>
					<td width="120" align="left" >'.$ListEnc->getelem()->nomtipoentrega.'&nbsp;</td>
					<td width="140" align="left">'.$ListEnc->getelem()->nom_local.'&nbsp;</td>
					<td width="40" align="right">'.general::formato_fecha($ListEnc->getelem()->feccrea).'&nbsp;</td>
					<td width="70" align="right">'.(($Listj->getelem()->id_contribuyente == 2)?$ListEnc->getelem()->rutcliente.'-'.general::digiVer($ListEnc->getelem()->rutcliente):$ListEnc->getelem()->rutcliente).'&nbsp;</td>
					<td width="20" align="right">&nbsp;</td>
					<td width="100"  align="left">'.$ListEnc->getelem()->razonsoc.'&nbsp;</td>
					<td width="80">'.$accver.'&nbsp;'.$accmodificar.'&nbsp;'.$accoe.'&nbsp;</td>

				');
			}
		
			$MiTemplate->parse("BLO_infopicking", "infopicking", true);
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
