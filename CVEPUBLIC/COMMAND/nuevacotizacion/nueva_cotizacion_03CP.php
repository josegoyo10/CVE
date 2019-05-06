<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
include_once("xajax/xajax.inc.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////
if ($_POST['accion'] == 'grabar') {
	$listaEnc = new connlist;
	$encCotizacion = new dtocotizacion;
	$encCotizacion ->id_cotizacion  =$_POST['id_cotizacion'];
	$encCotizacion ->validdesde 	=general::formato_fecha_FORM2DB($_POST['validdesde']);
	$encCotizacion ->validhasta 	=general::formato_fecha_FORM2DB($_POST['validhasta']);
	$encCotizacion ->valortotal		= $_POST['total_cotizacion'];
	$encCotizacion ->margentotal	= $_POST['margenvalor'];
	$encCotizacion ->direccion		= $_POST['direc'];
	$encCotizacion ->nota			= $_POST['nota'];
	$encCotizacion ->fonocontacto	= $_POST['fono'];
	$encCotizacion ->comuna			= $_POST['comu'];
	//general::alert($_POST['bloqueopormargen']);
	//($_POST['bloqueopormargen']==1?$encCotizacion ->bloqueopormargen='CB':'');
	$encCotizacion ->rete_iva="'".ereg_replace( ",", "", $_POST['reivatotal'])."'";
	$encCotizacion ->rete_ica="'".ereg_replace( ",", "",$_POST['icatotal'])."'";
	$encCotizacion ->rete_renta="'".ereg_replace( ",", "",$_POST['rentatotal'])."'";
	$encCotizacion ->cot_iva=ereg_replace( ",", "", $_POST['iva'])+0;
	$encCotizacion ->id_dirdespacho=$_POST['id_direccion'];	
	$prorrateoflete=$_POST['prorrateoflete'];
	
	$listaEnc->addlast($encCotizacion);
	$arr_celdas = split('#', $_POST['celdas']);

	$listaDet = new connlist;
	foreach($arr_celdas as $key=>$value){
		$cell = explode("|",$arr_celdas[$key]);

		if($value) {
			$detCotizacion = new dtodetcotizacion;
			$detCotizacion ->id_cotizacion  = $_POST['id_cotizacion'];
			$detCotizacion ->numlinea 		= $cell[0];
			$detCotizacion ->codprod 		= $cell[1];
			$detCotizacion ->descripcion 	= $cell[2];
			$detCotizacion ->unimed 		= $cell[3];
			$detCotizacion ->cantidad 		= $cell[4];
			$detCotizacion ->pcosto 		= $cell[5];
			$detCotizacion ->pventaneto 	= $cell[6];
			if($_POST['tipoventa']==1){
				$detCotizacion ->id_tipoentrega = 3;		
			}else{
				$detCotizacion ->id_tipoentrega	= $cell[7];				
			}
			$detCotizacion ->id_tiporetiro	= $cell[8];
			$detCotizacion ->cargoflete		= $cell[9];
			$detCotizacion ->totallinea		= $cell[10];
			$detCotizacion ->margenlinea	= $cell[11];
			$detCotizacion ->codtipo 		= $cell[12];
			$detCotizacion ->codsubtipo		= $cell[13];
			$detCotizacion ->valorfleteh	= $cell[14];
			$detCotizacion ->barra			= $cell[15];
			$detCotizacion ->nomprov		= $cell[16];
			$detCotizacion ->rutproveedor	= $cell[17];
			if(($cell[12]=='SV')&&($cell[13]=='DE')&&($prorrateoflete==1)){
				$detCotizacion ->marcaflete	= 1;				
			}
			if(($cell[12]=='SV')&&($cell[13]=='DE')&&($prorrateoflete==2)){
				$detCotizacion ->marcaflete	= 2;				
			}

/****** MODIFICACION GOA 27-12-2007. Desde ahora el pventa+iva será guardo en la base de datos*****/
			$detCotizacion ->pventaiva		= $cell[18];
			$detCotizacion ->instalacion	= $cell[19];
			$detCotizacion ->descuento	    = $cell[20];
			$detCotizacion ->peso		    = $cell[21];
			($_POST['icatotal']==0?$detCotizacion ->rete_ica=0:$detCotizacion ->rete_ica= $cell[22]);
			($_POST['rentatotal']==0?$detCotizacion ->rete_renta=0:$detCotizacion ->rete_renta= $cell[23]);
			$detCotizacion ->cot_iva	    = $cell[24];
							
			$listaDet->addlast($detCotizacion);
		}
		
	}
	if (!bizcve::putcotizacion($listaEnc,$listaDet)) 
	{
		$mensaje_error = 'Problemas al Grabar Cotización. Contactese con el administrador';
	}
	else
		{
		$listaEnc = new connlist;
		$listaDet = new connlist;	
		$encCotizacion = new dtocotizacion;
		$encCotizacion ->id_cotizacion  =$_REQUEST['id_cotizacion'];
		$encCotizacion ->nvevaliddesde 	=general::formato_fecha_FORM2DB($_REQUEST['validdesde']);
		$encCotizacion ->nvevalidhasta 	=general::formato_fecha_FORM2DB($_REQUEST['validhasta']);
		$listaEnc->addlast($encCotizacion);		
		//exit();
		bizcve::gennve($listaEnc);
		
		/*para insertar el tracking*/
		//general::inserta_tracking( $id_cotizacion, null, null, null, "La cotizacion ha cambiado a estado Nota de Venta");
		$listaEncEstado = new connlist;
		$encCotizacionEstado = new dtocotizacion;
		$encCotizacionEstado ->id_cotizacion  =$_REQUEST['id_cotizacion'];
		$listaEncEstado->addlast($encCotizacionEstado);
		bizcve::getcotizacionestado($listaEncEstado);
		$listaEncEstado->gofirst();
		general::inserta_tracking( $id_cotizacion, null, null, null, "La cotizacion ha cambiado a estado ".$listaEncEstado->getelem()->nomestado);	
	    }
	    
	   if($_POST['bloqueopormargen']==1)
	   {
	   	$listaEncCB = new connlist;
		$CotizacionCB = new dtocotizacion;
		$CotizacionCB ->id_cotizacion  =$_POST['id_cotizacion'];
		$CotizacionCB ->id_estado 	='CB';
		$listaEncCB->addlast($CotizacionCB);
		//echo "paso en es control";
	   			if (!bizcve::cambioestadocotizacion($listaEncCB)) 
				{
				$mensaje_error = 'Problemas al cambiar el estado de la Cotización. Contactese con el administrador';
				}
				else
				{
				general::inserta_tracking( $id_cotizacion, null, null, null, "La cotizacion ha cambiado a estado Bloqueado");
				}
	   }
		
	header("Location: nueva_cotizacion_04.php?id_cotizacion=" . $_POST['id_cotizacion']);
} //FIN DEL IF.	
if($_GET['editar']=='Edit'){
	if(bizcve::delcotizacionf($_GET['id_cotizacion'])){
	general::writeevent('Se verifica la existencia de fletes en la cotización número '.$_GET['id_cotizacion'].' para su posterior eliminación del detalle');
	}
	else{
	$mensaje_error = 'Problemas al verificar que no existan fletes en la Cotización. Contactese con el administrador';
	}
}
$tipoflete = 'SV';
$subtipoflete = 'DE';
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$cotizacion = new dtocotizacion();
$cotizacion->id_cotizacion =$_GET['id_cotizacion'];
$cotizacion->reqdet=true;
//$cotizacion->id_cotizacion = 135;
$listaEnc = new connlist();
$listaDet = new connlist();
$listaEnc -> addfirst($cotizacion);
$resp=bizcve::getcotizacion($listaEnc,$listaDet);
/****** MODIFICACION GOA 11-12-2007. si existe algun problema redirecciona a la página inicial  *****/	
//if (!$resp){
	//header("Location: ../monitorcoti/monitor_cotizacion.php");	
//}
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
// Agregamos el main
$MiTemplate->set_file("main", TEMPLATE."nuevacotizacion/nueva_cotizacion_03.html");
$MiTemplate->set_file("unidades", TEMPLATE."nuevacotizacion/nueva_cotizacion_033.html");
$MiTemplate->set_file("proveedores", TEMPLATE."nuevacotizacion/nueva_cotizacion_0333.html");

$listaEnc -> gofirst();

if ($listaEnc->getelem()->codlocalcsum != $ses_usr_codlocal && !isset($_REQUEST['np'])) {
	?>
	<script type="text/javascript">
	if (confirm('La cotizacion seleccionada pertenece a un centro de suministro distinto al actual.\n Â¿Desea actualizar los precios al centro de suministro actual?')) {
		window.location = window.location + '&np=1';
	}
	else {
		window.location = window.location + '&np=0';
	}
	</script>
	<?
	exit();
}

if ($listaEnc->getelem()->codlocalcsum != $ses_usr_codlocal && $_REQUEST['np']) {
	//Hay que actualizar el centro de suministro de la cotizaciÃ³n
	bizcve::putcotizacion(new connlist(new dtocotizacion(array( 'id_cotizacion' => $listaEnc->getelem()->id_cotizacion,
    	   														'codlocalcsum' => $ses_usr_codlocal ))), null);
	$listaEnc = new connlist();
	$listaDet = new connlist();
	$listaEnc -> addfirst($cotizacion);
	bizcve::getcotizacion($listaEnc,$listaDet);
	$listaEnc -> gofirst();
}
/*if(!$listaEnc->getelem()->puedemodificar || ($listaEnc->numelem() > 1)){
	$MiTemplate ->set_var("redirecciona","document.location = '../start/start_01.php';");
}*/

////////////////Encabezado/////////////////////////////

/* OBTENEMOS LAS DIRECCIONES DE DESPACHO */
            
bizcve::getdirdesp($List = new connlist(new dtodireccion(array('rut'=>$listaEnc->getelem()->rutcliente ))));
$List->gofirst();
$MiTemplate->set_block('main' , "dirdesp" , "BLO_dirdesp");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('id_direccion', $List->getelem()->id_direccion);
		$MiTemplate->set_var('nombre', $List->getelem()->descripcion." - ".$List->getelem()->direccion.", ".$List->getelem()->nomcomuna);
		$MiTemplate->set_var('selected', (($listaEnc->getelem()->id_dirdespacho == $List->getelem()->id_direccion)?'selected':''));
		$MiTemplate->parse("BLO_dirdesp", "dirdesp", true);	
	} while ($List->gonext());
}
if($_GET['editar']!='Edit'){
	$MiTemplate->set_var('codfechadesdein', "cal1.select(document.forms[0].fec_valid,'anchor1','dd/MM/yyyy'); return false;");
	$MiTemplate->set_var('codfechadesdeonclick', "cal1.select(document.forms[0].fec_valid,'anchor1','dd/MM/yyyy'); return false;");
	$MiTemplate->set_var('codfechahastain', "cal2.select(document.forms[0].fec_valid2,'anchor2','dd/MM/yyyy'); return false;");
	$MiTemplate->set_var('codfechahastaonclick', "cal2.select(document.forms[0].fec_valid2,'anchor2','dd/MM/yyyy'); return false;");
	
}

// recupera el tipo de usuario para poder cotizar como Vendedor de Centro de Venta Empresa
if ($tipoUsuariocol = bizcve::getTipoUsuarioCotiza($ses_usr_id)) {
	if($tipoUsuariocol == 2 || $tipoUsuariocol == 3){
		$MiTemplate ->set_var("margenvis",'38');
		$MiTemplate ->set_var("costovis",'50');
		$MiTemplate ->set_var("listavis",'45');
		$MiTemplate ->set_var("editableprecio",'ed');
		$MiTemplate ->set_var("porcentajedesvis",'75');	
		$MiTemplate ->set_var("titulomargen",'Margen');
		$MiTemplate ->set_var("simbolo",'%');
		$MiTemplate ->set_var("valortitulomargen",'<input name="margen" class="textoespecial1" type="text" readonly value="0" size="4">');
		$MiTemplate ->set_var("descuentovis",'65');
		$MiTemplate ->set_var("largo_des",'170');	
	}else{
		$MiTemplate ->set_var("margenvis",'0');
		$MiTemplate ->set_var("costovis",'0');
		$MiTemplate ->set_var("listavis",'0');
		$MiTemplate ->set_var("editableprecio",'ro');
		$MiTemplate ->set_var("porcentajedesvis",'0');
		$MiTemplate ->set_var("titulomargen",'');
		$MiTemplate ->set_var("valortitulomargen",'<INPUT TYPE="hidden" NAME="margen" VALUE="0">');
		$MiTemplate ->set_var("descuentovis",'0');
		$MiTemplate ->set_var("largo_des",'250');
	}
}else{
	$mensaje_error = 'Problemas al Recuperar el Tipo de Usuario. Contactese con el administrador';
}


///cargar direccion de despacho asigno a la cotizacion
$ListEnc = new connlist;
$ListDet = new connlist;
$ListDir = new connlist;
$Registro = new dtocotizacion;
$Registro->id_cotizacion	=  $_GET['id_cotizacion'];
$Registro->prorrateoflete =1;   
$ListEnc->addlast($Registro);
bizcve::getcotizacion($ListEnc, $ListDet);

$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
		

if($ListEnc->getelem()->id_dirdespacho > 0)
{
$Listdirdes  = new connlist;
$id_dirdes->id_direccion=$ListEnc->getelem()->id_dirdespacho;
$Listdirdes->addlast($id_dirdes);
bizcve::getdirdesp($Listdirdes);
$Listdirdes->gofirst();
$parametrolocalizacion=$Listdirdes->getelem()->id_comuna;
$MiTemplate->set_var('nom_direccion',$Listdirdes->getelem()->direccion);
//$MiTemplate->set_var('descripciondir', $ListEnc->getelem()->descripcion);
//$MiTemplate->set_var('nomcomuna', $ListEnc->getelem()->comuna);
$MiTemplate->set_var('contacto', $Listdirdes->getelem()->contacto);
$MiTemplate->set_var('fonocontacto', $Listdirdes->getelem()->fonocontacto);
$MiTemplate->set_var('comentariodir', $Listdirdes->getelem()->comentario);	
}
else{
$parametrolocalizacion=0;
}
}

// Setear variables de direccion de cliente siempre la primera

bizcve::getcliente($listaCliente = new connlist( $dtocliente = new dtoinfocliente(array('rut'=>$listaEnc->getelem()->rutcliente ))));

$disponible=bizcve::getdisponible($listaCliente);

$listaCliente->gofirst();
$configclitipo = new getidcontribuyente("CONTRIBUYENTE");
$opcion=$configclitipo->JURIDICO;
$opcion1=$configclitipo->EMPRESARIAL;
$MiTemplate ->set_var("id_cotizacion",$listaEnc->getelem()->id_cotizacion); 
$MiTemplate ->set_var("rutcliente",(($listaCliente->getelem()->id_contribuyente == $opcion1)?$listaCliente->getelem()->rut.'-'.general::digiVer($listaCliente->getelem()->rut) : $listaCliente->getelem()->rut ));
$MiTemplate ->set_var("rutcliente1",$listaEnc->getelem()->rutcliente);
$MiTemplate ->set_var("razonsoc",$listaEnc->getelem()->razonsoc);
$MiTemplate ->set_var("nota",$listaEnc->getelem()->nota);
$MiTemplate ->set_var("condicion",$listaEnc->getelem()->condicion);
$MiTemplate ->set_var("nom_localcsum",$listaEnc->getelem()->nom_localcsum);
$MiTemplate ->set_var("nomtipoventa",$listaEnc->getelem()->nomtipoventa);
$MiTemplate ->set_var("id_tipoventa",$listaEnc->getelem()->id_tipoventa);
$id_venta = $listaEnc->getelem()->id_tipoventa;
			if($id_venta == 1){
				$MiTemplate ->set_var("costocalzada",'||cellInd == 8');
				$MiTemplate ->set_var("fuentecalzada",'bold');
				$MiTemplate ->set_var("editablecalzada",'ed');
				$MiTemplate ->set_var("lineamayorista",'23');
				
			}else{
				$MiTemplate ->set_var("fuentecalzada",'normal');
				$MiTemplate ->set_var("editablecalzada",'ro');		
				$MiTemplate ->set_var("lineamayorista",'21');
			}
$MiTemplate ->set_var("validhasta",general::formato_fecha($listaEnc->getelem()->validhasta));
$MiTemplate ->set_var("validdesde",general::formato_fecha($listaEnc->getelem()->validdesde));
$MiTemplate ->set_var("URL_CVE",URL_CVE);
$MiTemplate ->set_var("codlocalcsum",$listaEnc->getelem()->codlocalcsum);
$MiTemplate ->set_var("saldof",number_format($disponible));
$MiTemplate ->set_var("saldo",$disponible);
$MiTemplate ->set_var("tipocliente",$listaCliente->getelem()->nomtipcliente);
$MiTemplate ->set_var("rete_ica",$listaCliente->getelem()->rete_ica);
$MiTemplate ->set_var("rete_renta",$listaCliente->getelem()->rete_renta);
$MiTemplate ->set_var("rete_iva",$listaCliente->getelem()->rete_iva);
$MiTemplate ->set_var("direccionf",$listaCliente->getelem()->direccion);
$MiTemplate ->set_var("nomcomunaf",$listaCliente->getelem()->nomcomuna);
if($parametrolocalizacion==0){
	$parametrolocalizacion=$listaCliente->getelem()->id_comuna;
$MiTemplate->set_var('nom_direccion',$listaCliente->getelem()->direccion);
//$MiTemplate->set_var('descripciondir', 'DIRECCION DE FACTURACION');
//$MiTemplate->set_var('nomcomuna', $ListEnc->getelem()->comuna);
$MiTemplate->set_var('contacto', $listaCliente->getelem()->apellido.' '.$listaCliente->getelem()->contacto);
$MiTemplate->set_var('fonocontacto', $listaCliente->getelem()->fonocontacto);
$MiTemplate->set_var('comentariodir', $listaCliente->getelem()->comentario);
}
$Listlocalizacion  = new connlist;
$registrolocalizacion->id_localizacion=$parametrolocalizacion;
$Listlocalizacion->addlast($registrolocalizacion);
bizcve::getlocalizacion($Listlocalizacion);
$Listlocalizacion->gofirst();
if (!$Listlocalizacion->isvoid()) {
	do {
		$MiTemplate->set_var('ciudad', $Listlocalizacion->getelem()->ciudad);
		$MiTemplate->set_var('nomcomuna', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
		$MiTemplate->set_var('departamento', $Listlocalizacion->getelem()->departamento);
		
	} while ($Listlocalizacion->gonext());
}

$MiTemplate ->set_var("id_tipocliente",$listaCliente->getelem()->id_tipocliente);
$MiTemplate ->set_var("iva",$listaEnc->getelem()->iva);

$clientepreferente=$listaCliente->getelem()->id_clientepref;
if ($id_venta == 1){
	$MiTemplate ->set_var("despacho",'0');
	$MiTemplate ->set_var("retira",'0');
	$MiTemplate ->set_var("lstock",'0');
	//$MiTemplate ->set_var("largo_des",'160');
	$MiTemplate ->set_var("mostrar_proveedor",'100');
}else{
	$MiTemplate ->set_var("despacho",'20');
	$MiTemplate ->set_var("retira",'20');
	$MiTemplate ->set_var("lstock",'30');
	//$MiTemplate ->set_var("largo_des",'170');
	$MiTemplate ->set_var("mostrar_proveedor",'0');
}
$MiTemplate ->set_var("maximo",MARGEN_MAXIMO);
$MiTemplate ->set_var("minimo",MARGEN_MINIMO);
$MiTemplate ->set_var("MARGEN_COTIZADOR",MARGEN_COTIZADOR);
$MiTemplate ->set_var("MARGEN_MAX_REBAJA_COTIZADOR",MARGEN_MAX_REBAJA_COTIZADOR);
//MARGEN_MAXIMO_3 =12
/*if (defined('MARGEN_MAXIMO_'.$clientepreferente)){
	eval ("\$maximo = MARGEN_MAXIMO_". $clientepreferente . ";" );
	$MiTemplate ->set_var("maximo",$maximo);	
}else{
	$MiTemplate ->set_var("maximo",MARGEN_MAXIMO);	
}

if (defined('MARGEN_MINIMO_'.$clientepreferente)){
	eval ("\$minimo = MARGEN_MINIMO_". $clientepreferente . ";" );
	$MiTemplate ->set_var("minimo",$minimo);	
}else{
	//echo "MARGEN_MINIMO -> " .MARGEN_MINIMO."<br>";
	$MiTemplate ->set_var("minimo",MARGEN_MINIMO);	
}

//$MiTemplate ->set_var("maximo",MARGEN_MAXIMO);
//$MiTemplate ->set_var("minimo",MARGEN_MINIMO);

if (defined('MARGEN_COTIZADOR_'.$clientepreferente)){
	eval ("\$margencoti = MARGEN_COTIZADOR_". $clientepreferente . ";" );
	$MiTemplate ->set_var("MARGEN_COTIZADOR",$minimo);	
}else{
	//echo "MARGEN_COTIZADOR -> " .MARGEN_COTIZADOR."<br>";
	$MiTemplate ->set_var("MARGEN_COTIZADOR",MARGEN_COTIZADOR);	
}

//$MiTemplate ->set_var("MARGEN_COTIZADOR",MARGEN_COTIZADOR);

*/
$MiTemplate ->set_var("DIAS_VALID_COT_MAX",DIAS_VALID_COT_MAX); 
$MiTemplate ->set_var("hoy",general::fecha_PHP2TPL()); 

if ($listaEnc->getelem()->id_tipoventa ==1){
	$MiTemplate ->set_var("mayorista",'|| cellInd == 7');	
}
//if ($listaEnc->getelem()->codlocalventa == $listaEnc->getelem()->codlocalcsum){
global $ses_usr_codlocal; 
if ($listaEnc->getelem()->codlocalcsum == $ses_usr_codlocal){
	$MiTemplate ->set_var('suministro','true');
}else{
	$MiTemplate ->set_var('suministro','false');
}
/////////////////////Detalle/////////////////////////
$listaDet -> gofirst();
$MiTemplate ->set_var("filas",$listaDet->numelem());
if ($listaDet->numelem()){
	$MiTemplate->set_block('main' , "detalle" , "BLO_detalle");
		$recargo = 0;
		$numerolinea = 0;
		do{
			$listaDet->getelem()->lisdetprod->gofirst();		
			$MiTemplate ->set_var("calcula",'cantidadxpventa({numlinea});');
			$MiTemplate ->set_var("pintar",'pintar({numlinea});');
			//$MiTemplate ->set_var("id_cotizacion_det",$listaDet->getelem()->id_cotizacion);
			$MiTemplate ->set_var("numlinea",$listaDet->getelem()->numlinea);
			$MiTemplate ->set_var("id_tiporetiro",$listaDet->getelem()->id_tiporetiro);
			$MiTemplate ->set_var("codprod",$listaDet->getelem()->codprod);
			$codprod  = $listaDet->getelem()->codprod;
			$barra  = $listaDet->getelem()->barra;
			$descripcion  = $listaDet->getelem()->descripcion;
			$codlocalcsum  = $ses_usr_codlocal;
			$MiTemplate ->set_var("descripcion",$listaDet->getelem()->descripcion);
			$MiTemplate ->set_var("stock",$listaDet->getelem()->lisdetprod->getelem()->stock);
			$MiTemplate ->set_var("peso",$listaDet->getelem()->lisdetprod->getelem()->peso);
			$MiTemplate ->set_var("ivap",$listaDet->getelem()->lisdetprod->getelem()->ivap);
			$MiTemplate ->set_var("renta",$listaDet->getelem()->lisdetprod->getelem()->renta);
			$MiTemplate ->set_var("ica",$listaDet->getelem()->lisdetprod->getelem()->ica);
			$MiTemplate ->set_var("unimed",$listaDet->getelem()->unimed);
			$MiTemplate ->set_var("cantidad",$listaDet->getelem()->cantidad);
			$MiTemplate ->set_var("instalacion",$listaDet->getelem()->instalacion);			
			$MiTemplate ->set_var("pcosto",$listaDet->getelem()->pcosto);
			$MiTemplate ->set_var("pventa",$listaDet->getelem()->pventaneto);
			$plista= (($listaDet->getelem()->descuento / $listaDet->getelem()->cantidad) + $listaDet->getelem()->pventaneto);
			$MiTemplate ->set_var("plista",$plista);		
			//general::alert($listaDet->getelem()->pventaneto);;
			//$MiTemplate ->set_var("preciorebaja",(($listaDet->getelem()->pventaneto-$listaDet->getelem()->pcosto)*100)*(MARGEN_MAX_REBAJA_COTIZADOR/100));			
			$MiTemplate ->set_var("barra",$listaDet->getelem()->barra);	
			$MiTemplate ->set_var("nomprov",$listaDet->getelem()->nomprov);
			$MiTemplate ->set_var("rutproveedor",$listaDet->getelem()->rutproveedor);			
			//$MiTemplate ->set_var("cargoflete",$listaDet->getelem()->cargoflete);
			if($listaDet->getelem()->cargoflete){
				$recargo+=($listaDet->getelem()->cargoflete)*($listaDet->getelem()->cantidad);
			}
			
			$MiTemplate ->set_var("totallinea",$listaDet->getelem()->totallinea);
			if($codprod=='12501'){
				$MiTemplate ->set_var("margenlinea",'0');			
			}else{
				$MiTemplate ->set_var("margenlinea",$listaDet->getelem()->margenlinea);
			}
			
			
			$MiTemplate ->set_var("prod_tipo",$listaDet->getelem()->codtipo);
			$MiTemplate ->set_var("prod_subtipo",$listaDet->getelem()->codsubtipo);
			
			if ($listaDet->getelem()->id_tipoentrega == 2){
				$MiTemplate ->set_var("id_tipoentrega",'true');
			}else{
				$MiTemplate ->set_var("id_tipoentrega",'false');
			}
			
			if ($listaDet->getelem()->id_tiporetiro == 2){
				$MiTemplate ->set_var("id_tiporetiro",'true');
			}else{
				$MiTemplate ->set_var("id_tiporetiro",'false');
			}
			if ($listaDet->getelem()->codtipo == $tipoflete&& $listaDet->getelem()->codsubtipo == $subtipoflete){
				$MiTemplate ->set_var("pventa",$listaDet->getelem()->valorfleteh);
			}

			$MiTemplate->unset_var('proveedores');
			$MiTemplate->unset_var('BLO_prov');
			$MiTemplate->set_block('proveedores' , "prov" , "BLO_prov");			
			bizcve::getprovpreferencial($Listaprov = new connlist($dtopreferencial = new dtoproducto(array('sap'=>$codprod,'barra'=>$barra, 'csum'=>$codlocalcsum))));
						
			$Listaprov -> gofirst();
			$x=0;
			do{
					$MiTemplate ->set_var("nomproveedor1",$Listaprov->getelem()->nomprov);				
					$MiTemplate ->set_var("rutproveedor1",$Listaprov->getelem()->rutproveedor);
					$MiTemplate ->set_var("registro11",$x);
					$MiTemplate ->set_var("numlineaprov",$listaDet->getelem()->numlinea);

					$MiTemplate->parse("BLO_prov", "prov", true);
					$x++;
				
			}while($Listaprov->gonext());
			
			
			$MiTemplate->unset_var('unidades');
			$MiTemplate->unset_var('BLO_unidad');
			$MiTemplate->set_block('unidades' , "unidad" , "BLO_unidad");
			$x=0;
			do{				
				$MiTemplate ->set_var("numlinea1",$listaDet->getelem()->numlinea);
				$MiTemplate ->set_var("sap1",$listaDet->getelem()->lisdetprod->getelem()->sap);
				$MiTemplate ->set_var("barra1",$listaDet->getelem()->lisdetprod->getelem()->barra);
				$MiTemplate ->set_var("descripcion1",$listaDet->getelem()->lisdetprod->getelem()->descripcion);
				$MiTemplate ->set_var("unidmed1",$listaDet->getelem()->lisdetprod->getelem()->unidmed);
				$MiTemplate ->set_var("stock1",$listaDet->getelem()->lisdetprod->getelem()->stock);
				$MiTemplate ->set_var("pventa1",$listaDet->getelem()->lisdetprod->getelem()->pventa);
				$MiTemplate ->set_var("pcosto1",$listaDet->getelem()->lisdetprod->getelem()->pcosto);
				$MiTemplate ->set_var("nomprov1",$listaDet->getelem()->lisdetprod->getelem()->nomprov);
				$MiTemplate ->set_var("prod_tipo1",$listaDet->getelem()->lisdetprod->getelem()->prod_tipo);
				$MiTemplate ->set_var("prod_subtipo1",$listaDet->getelem()->lisdetprod->getelem()->prod_subtipo);
				$MiTemplate ->set_var("registro1",$x);
				$MiTemplate->parse("BLO_unidad", "unidad", true);
				$x++;
			}while($listaDet->getelem()->lisdetprod->gonext());
			
			$MiTemplate->parse("BLO_detalle", "detalle", true);
			$numerolinea++;
		}while ($listaDet -> gonext());
		
		if ($recargo){
				$res = bizcve::getproductogrilla($lista = new connlist(new dtoproducto(array('sap'=>PRODUCTO_FLETE,'csum'=>$listaEnc->getelem()->codlocalcsum,'numretlimit'=>1))));
				if ($lista->numelem()==1){
					
					$lista->gofirst();
					$MiTemplate ->set_var("addline4",'filas = {numlinea2};filass = {numlinea2};');
					$MiTemplate ->set_var("filas",($listaDet->numelem())+1);
					
					$MiTemplate->set_block('main' , "detalle_flete" , "BLO_detalle_flete");
					$numerolinea++;
					$MiTemplate ->set_var("addline",'mygrid.addRow({numlinea2},",,{codprod2},...,{descripcion2},,{stock2},{cantidad2},{pcosto2},{plista2},{pventa2},,,{cargoflete2},{totallinea2},{margenlinea2},{prod_tipo2},{prod_subtipo2},{codprod2},,{barra2},,{rutproveedor2} ",0);');
					$MiTemplate ->set_var("addline2",'mygrid.cells({numlinea2},11).setChecked({id_tipoentrega2});'); 
					$MiTemplate ->set_var("addline3",'mygrid.cells({numlinea2},12).setChecked({id_tiporetiro2});');
					$MiTemplate ->set_var("addline5",'	mygrid.setCellTextStyle({numlinea2},2,"font-weight:bold;");
														mygrid.setCellTextStyle({numlinea2},5,"font-weight:bold;");
														mygrid.setCellTextStyle({numlinea2},7,"font-weight:bold;");
														mygrid.setCellTextStyle({numlinea2},10,"font-weight:bold;");');

					$MiTemplate ->set_var("calcula",'cantidadxpventa({numlinea2});');
					$MiTemplate ->set_var("pintar",'pintar({numlinea2});');
					$MiTemplate ->set_var("numlinea2",$numerolinea++);
					$MiTemplate ->set_var("codprod2",$lista->getelem()->sap);
					$MiTemplate ->set_var("descripcion2",$lista->getelem()->descripcion);
					$MiTemplate ->set_var("barra2",$lista->getelem()->barra);
					$MiTemplate ->set_var("rutproveedor2",1);
					$MiTemplate ->set_var("stock2",$lista->getelem()->stock);
					$MiTemplate ->set_var("unimed2",$lista->getelem()->unidmed);
					$MiTemplate ->set_var("cantidad2",1);
					$MiTemplate ->set_var("pcosto2",$lista->getelem()->pcosto);
					$MiTemplate ->set_var("plista2",$lista->getelem()->pventa);
					$MiTemplate ->set_var("pventa2",round($recargo));
					$MiTemplate ->set_var("prod_tipo2",$lista->getelem()->prod_tipo);
					$MiTemplate ->set_var("prod_subtipo2",$lista->getelem()->prod_subtipo);
					$MiTemplate ->set_var("id_tipoentrega2",'true');
					$MiTemplate ->set_var("id_tiporetiro2",'false');
					$MiTemplate->parse("BLO_detalle_flete", "detalle_flete", true);
				
				}
		}else{
			$MiTemplate ->set_var("filas",$listaDet->numelem());
		}
}else{
	$MiTemplate ->set_var("numlinea","1");
	$MiTemplate ->set_var("id_tipoentrega",'false');
	$MiTemplate ->set_var("id_tiporetiro",'false');
}

$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);

$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>
