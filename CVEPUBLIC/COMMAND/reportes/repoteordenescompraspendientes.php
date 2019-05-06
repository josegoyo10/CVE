<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../reportes/repoteordenescompraspendientes.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////
if ($_POST['accionexport'] == 'exportar') {
header('Location: excelordenescompra.php?feini='.$_POST["feini"].'&fefin='.$_POST["fefin"].'&proveedor='.$_POST["proveedor"].'&select_tipoentrega='.$_POST['select_tipoentrega'].'&select_suministro='.$_POST['select_suministro'].'&select_estado='.$_POST['select_estado'].'&tipobus='.$_POST['tipobus']);
}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE . "reportes/repoteordenescompraspendientes.htm");
$MiTemplate->set_var('first','checked');

$MiTemplate->set_var("fechaucofini", ($_POST["feini"]?$_POST["feini"]:$_REQUEST["feini"]));
$MiTemplate->set_var("fechaucoffin", ($_POST["fefin"]?$_POST["fefin"]:$_REQUEST["fefin"]));
$MiTemplate->set_var("idprov", $_POST["proveedor"]);
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

/*Despliegue para el radio*/
if($_POST['tipobus']=='radiope' || $_REQUEST['tipobus']=='radiope'){
$MiTemplate->set_var('radiope','checked');	
$MiTemplate->set_var('radiotpe','');
}
else{
$MiTemplate->set_var('radiotpe','checked');
$MiTemplate->set_var('radiope','');
}
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
		if($List->getelem()->id_estado=='OG' or $List->getelem()->id_estado=='OF'){
		($_POST['select_estado'] == $List->getelem()->id_estado || $_REQUEST['select_estado'] == $List->getelem()->id_estado)?$selectedestado=$selectedestado.'<option value="'.$List->getelem()->id_estado.'" selected>'.$List->getelem()->descripcion.'</option>':$selectedestado=$selectedestado.'<option value="'.$List->getelem()->id_estado.'">'.$List->getelem()->descripcion.'</option>';
		}
			
		$MiTemplate->parse("BLO_estado", "estado", true);
	} while ($List->gonext());
$MiTemplate->set_var('selectestado',$selectedestado);	
}

$ListEnc  = new connlist;
$ListDet = new connlist;
$mRegistro = new dtoencordenent;

/*listado de locales*/
 
 	$List  = new connlist;
	bizcve::getlocales($List);
	$List->gofirst();
	$MiTemplate->set_block('main' , "suministro" , "BLO_suministro");
	if (!$List->isvoid()) {
		do {
			$MiTemplate->set_var('codigo_local', $List->getelem()->cod_local);
			$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
			if($ses_usr_codlocal){
			$MiTemplate->set_var('select_suministro', ($ses_usr_codlocal == $List->getelem()->cod_local)?'selected':'');
			$MiTemplate->set_var('deshabilitar_select','disabled');
			}
			else{
	        $MiTemplate->set_var('select_suministro', ($_POST['select_suministro'] == $List->getelem()->cod_local || $_REQUEST['select_suministro'] == $List->getelem()->cod_local)?'selected':'');
			}
			$MiTemplate->parse("BLO_suministro", "suministro", true);
		} while ($List->gonext());
	}
	
if ($ses_usr_codlocal){
	$mRegistro->codlocalcsum = $ses_usr_codlocal;
}
else {
	$mRegistro->codlocalcsum=$_POST['select_suministro'];
}

$mRegistro->fechaucofini = ($_POST['feini'])?general::formato_fecha_FORM2DB($_POST['feini']):"";
$mRegistro->fechaucoffin = ($_POST['fefin'])?general::formato_fecha_FORM2DB($_POST['fefin']):"";
$mRegistro->id_estado=$_POST['select_estado'];
$ListEnc->addlast($mRegistro);
$id_estado=$_POST['select_estado'];
if($_POST['feini'] && $_POST['fefin']){
if($_POST['tipobus']=='buscartpe'){
bizcve::reportecompraspendientespe($ListEnc, $ListDet);
}
else{
bizcve::reportecompraspendientes($ListEnc, $ListDet);	
}
$MiTemplate->set_var('filtro','feini='.$_POST["feini"].'-fefin='.$_POST["fefin"].'-proveedor='.$_POST["proveedor"].'-select_tipoentrega='.$_POST['select_tipoentrega'].'-select_suministro='.$_POST['select_suministro'].'-select_estado='.$_POST['select_estado'].'-tipobus='.$_POST['tipobus']);
$ListEnc->gofirst();
$MiTemplate->set_block('main' , "infocotizacion" , "BLO_infocotizacion");
	if (!$ListEnc->isvoid()) {
		do {
			
			$mRegistrodet = new dtoencordenent;
			$mRegistrodet->id_ordenent = $ListEnc->getelem()->id_ordenent;
			$ListDet->addlast($mRegistrodet);
			bizcve::getdetordenentpespecial($ListDet);
			$ListDet->gofirst();
			$conteope=$ListDet->getelem()->numlinea;
			$conteon_compra=$ListDet->getelem()->totallinea;
			$conteope_estadoES=$ListDet->getelem()->cantidadp;
			$ListDet->clearlist();
			
			if($conteope > 0){
				
				$ListDetD = new connlist;
				$mRegistrope = new dtodetordenent;
				$mRegistrope->id_ordenent = $ListEnc->getelem()->id_ordenent;
				$ListDetD->addlast($mRegistrope);
				bizcve::getdetordenent($ListDetD);
				$ListDetD->gofirst();
				
			if($_POST['proveedor']){
				if(!$ListDetD->isvoid()) {
					do{
						
						$Listproducto = new connlist;
						$detproducto = new dtoproducto;
						$detproducto->cod_prod1 	= $ListDetD->getelem()->codprod;
						$detproducto->idprov	 	= $_POST['proveedor'];
						$Listproducto->addlast($detproducto);
						bizcve::getproductoxproveedor($Listproducto);
						$Listproducto->gofirst();
						
						if(!$Listproducto->isvoid()) {
									$totalpro_prov += $Listproducto->getelem()->id_producto;
																					
						}
						
					}while ($ListDetD->gonext()); 
					
				}
			}	
			else{
			$totalpro_prov=1;
			}	
			}
			if($totalpro_prov > 0){
					
					
					$MiTemplate->set_var('excel','<input type="button" name="expor" value="Exportar Excel" class="Textonormal" onClick="exportar()">');
					$MiTemplate->set_var('tienda',($ListEnc->getelem()->nom_local)? $ListEnc->getelem()->nom_local : '&nbsp;');
					$MiTemplate->set_var('OE',($ListEnc->getelem()->id_ordenent)? $ListEnc->getelem()->id_ordenent : '&nbsp;');
					$MiTemplate->set_var('id_estado',($ListEnc->getelem()->id_estado)? $ListEnc->getelem()->id_estado : '&nbsp;');
					$MiTemplate->set_var('fechacompra',($ListEnc->getelem()->fechacompra)? general::formato_fecha($ListEnc->getelem()->fechacompra) : '&nbsp;');
					$MiTemplate->set_var('razonsoc',($ListEnc->getelem()->razonsoc)? $ListEnc->getelem()->razonsoc : '&nbsp;');
					$MiTemplate->set_var('telefono',($ListEnc->getelem()->fonocontacto)? $ListEnc->getelem()->fonocontacto : '&nbsp;');
					$MiTemplate->set_var('valortotal',($ListEnc->getelem()->valortotal)? number_format($ListEnc->getelem()->valortotal) : '&nbsp;');
					$MiTemplate->set_var('accver','<a href="#"><img src="../../IMAGES/{imagen}" alt="{mensajeimagen}" border="0" id="'.$ListEnc->getelem()->id_ordenent.'" rut="'.$ListEnc->getelem()->rutcliente.'" onClick="verorden(this, rut)"></a>');
					if($conteon_compra == $conteope && $conteope_estadoES ==0){
						$MiTemplate->set_var('mensajeimagen','Ver Orden De Compra');
						$MiTemplate->set_var('imagen','info.gif');
						$MiTemplate->set_var('n_compra','<img src="../../IMAGES/tick.png" alt="Numero de factura registrado" border="0">&nbsp;');
					}
					if($conteon_compra == $conteope && $conteope_estadoES > 0){
						$MiTemplate->set_var('mensajeimagen','Recibir Orden De Compra');
						$MiTemplate->set_var('imagen','mail.gif');
						$MiTemplate->set_var('n_compra','<img src="../../IMAGES/tickorange.PNG" alt="Numero de factura registrado" border="0">&nbsp;');
					}
					if($conteon_compra != $conteope){
						$MiTemplate->set_var('mensajeimagen','Editar Orden De Compra');
						$MiTemplate->set_var('imagen','editicon.gif');
						$MiTemplate->set_var('n_compra','<img src="../../IMAGES/tickred.PNG" alt="Falta numero de factura" border="0">&nbsp;');
					}
//localizacion	
					if($ListEnc->getelem()->id_direccion > 0){
					$Listdirdes  = new connlist;
					$id_dirdes->id_direccion=$ListEnc->getelem()->id_direccion;
					$Listdirdes->addlast($id_dirdes);
					bizcve::getdirdesp($Listdirdes);
					$Listdirdes->gofirst();
					$idcomuna=$Listdirdes->getelem()->id_comuna;
					$Listdirdes->clearlist();
					}
//localizacion//
					else {
					//echo $rut;
					
					$ListCli  = new connlist;
					$mRegistroCli->rut=$ListEnc->getelem()->rutcliente;
					$ListCli->addlast($mRegistroCli);
					bizcve::getcliente($ListCli);
					$ListCli->gofirst();
					$idcomuna=$ListCli->getelem()->id_comuna;
					//echo 'rut'.$ListCli->getelem()->rut.'rutcliente'.$ListEnc->getelem()->rutcliente; $ListCli->clearlist();//echo $ListCli->getelem()->id_comuna;
					
					}	
					
			$Listlocalizacion  = new connlist;
			//echo $idcomuna;
			$registrolocalizacion->id_localizacion=$idcomuna;
			$Listlocalizacion->addlast($registrolocalizacion);
			bizcve::getlocalizacion($Listlocalizacion);
			$Listlocalizacion->gofirst();
			if (!$Listlocalizacion->isvoid()) {
			do {
				
				$MiTemplate->set_var('ciudad', $Listlocalizacion->getelem()->ciudad);
				$MiTemplate->set_var('barrio', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
				
				} while ($Listlocalizacion->gonext());
			}
			$Listlocalizacion->clearlist();
				if($ListEnc->getelem()->fecha_retira_cliente != '0000-00-00')
					$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_cliente) );
				if($ListEnc->getelem()->fecha_retira_inmediato != '0000-00-00')
					$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_inmediato) );
				if($ListEnc->getelem()->fecha_despacho_programado != '0000-00-00')
					$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_despacho_programado) );
		//echo "total".$totalpro_prov."oe".$ListEnc->getelem()->id_ordenent;
					$MiTemplate->parse("BLO_infocotizacion", "infocotizacion", true);
			}
			else{
					//general::alert('no existen datos para esta consulta');
			}	
					$totalpro_prov= 0;
							
			
			//$MiTemplate->parse("BLO_infocotizacion", "infocotizacion", true);

			
		} while ($ListEnc->gonext());
		
}
else{				
$MiTemplate->set_var('mensajeconsulta','<table width="800" border="1" cellpadding="2"  class="tabla2">
<tr>
<th width="100%" align="center">No existen datos para esta consulta</th>
</tr>
</table>');
}
}	


$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>
