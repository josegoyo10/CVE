<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitororpick/monitor_orpick_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////
if ($_POST['accion'] == 'cerrar' && $_POST['id_ordenpicking']) {
		foreach ($_POST['linea'] as $value)
		if ($_POST['cantact_'.$value]>0){
		bizcve::savedetordenescomprapendientes($value,$_POST['cantact_'.$value],$_POST['id_ordenpicking']);		
		general::alert('El numero de orden de compra '.$_POST['cantact_'.$value].', Se ha guardo con éxito');
		}	
}
if ($_POST['accion'] == 'recibir' && $_POST['id_ordenpicking']){
	//echo 'terimina el flujo'.$_POST['id_ordenpicking'];
	$ListEncR = new connlist;
	$ListEncC = new connlist;
	$mRegistroReci = new dtoencordenpicking;
	$mRegistroReci->id_ordenent =$_POST['id_ordenpicking'];
	$mRegistroReci->id_estado ='PD';
	$ListEncR->addlast($mRegistroReci);
	$ListEncC->addlast($mRegistroReci);
	bizcve::getcountenespera($ListEncC);
	$ListEncC->gofirst();
	
	if (!$ListEncC->isvoid()) {
		do {
			$idpicking=$idpicking.'  '.$ListEncC->getelem()->id_ordenpicking;
		} while ($ListEncC->gonext());
	}
	
	if(bizcve::setOpestadopegenerico($ListEncR)){	
		general::alert('Cambio de estado de OP '.$idpicking.' exitoso.');
	}
	else{
		general::alert('No es posible realizar la operación en el momento,Intente mas tarde');
	}
}
/////////////////////////ZONA DE DESPLIEGUE/////////////////////////
$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "reportes/reporte_detcompraspendientes.htm");
$MiTemplate->set_var('filtro',str_replace('-','&',$_REQUEST['filtro']));
/* OBTENEMOS DATOS DE PICKING PARA ENCABEZADO */
$ListEnc  = new connlist;
$ListDet  = new connlist;
$mRegistro= new dtoencordenent;
$mRegistro->id_ordenent =$_REQUEST['id_ordenpicking'];
$ListEnc->addlast($mRegistro);
bizcve::getordenent($ListEnc,$ListDet);
$ListEnc->gofirst();	
$MiTemplate->set_var('id_ordenent', $ListEnc->getelem()->id_ordenent);
$direccion=$ListEnc->getelem()->id_direccion;
$MiTemplate->set_var('fechacompra', general::formato_fecha($ListEnc->getelem()->fechacompra));
$id_ordenent = $ListEnc->getelem()->id_ordenent; 
$MiTemplate->set_var('nom_local_csum', $ListEnc->getelem()->nom_localcsum);
$MiTemplate->set_var('nomestadop', $ListEnc->getelem()->nomestadorent);
$MiTemplate->set_var('id_estado	', $ListEnc->getelem()->id_estado);
				if($ListEnc->getelem()->fecha_retira_cliente != '0000-00-00')
					$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_cliente) );
				if($ListEnc->getelem()->fecha_retira_inmediato != '0000-00-00')
					$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_inmediato) );
				if($ListEnc->getelem()->fecha_despacho_programado != '0000-00-00')
					$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_despacho_programado) );
$direccion=$ListEnc->getelem()->id_direccion;
/* OBTENEMOS INFORMACION DEL CLIENTE */
bizcve::getCliente($List = new connlist(new dtoinfocliente(array('rut'=>$rut))));
$List->gofirst();
if (!$List->isvoid()) {
    $MiTemplate->set_var('rut', $List->getelem()->rut);
    $MiTemplate->set_var('rutcliente', $List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut));	
    $MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente);			
    $MiTemplate->set_var('contacto', $List->getelem()->contacto.' '.$List->getelem()->apellido);					
    $MiTemplate->set_var('razonsoc', $List->getelem()->razonsoc);
    $MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);
    $MiTemplate->set_var('direccion', $List->getelem()->direccion);
    $MiTemplate->set_var('giro', $List->getelem()->giro);
$Listlocalizacion  = new connlist;
$registrolocalizacion->id_localizacion=$List->getelem()->id_comuna;
$Listlocalizacion->addlast($registrolocalizacion);
bizcve::getlocalizacion($Listlocalizacion);
$Listlocalizacion->gofirst();
if (!$Listlocalizacion->isvoid()) {
	do {
		$localiciu=$Listlocalizacion->getelem()->ciudad;
		$localibar=$Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad;
		$localidep=$Listlocalizacion->getelem()->departamento;
		$MiTemplate->set_var('nomciudad', $Listlocalizacion->getelem()->ciudad);
		$MiTemplate->set_var('nomcomuna', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
		$MiTemplate->set_var('nomdepartamento', $Listlocalizacion->getelem()->departamento);
		
	} while ($Listlocalizacion->gonext());
}		
}
/* OBTENEMOS DIRECCION DE DESPACHO */
 
if($direccion > 0)
{
$Listdirdes  = new connlist;
$id_dirdes->id_direccion=$direccion;
$Listdirdes->addlast($id_dirdes);
bizcve::getdirdesp($Listdirdes);
$Listdirdes->gofirst();
$Listlocalizacion  = new connlist;
$registrolocalizacion->id_localizacion=$Listdirdes->getelem()->id_comuna;
$Listlocalizacion->addlast($registrolocalizacion);
bizcve::getlocalizacion($Listlocalizacion);
$Listlocalizacion->gofirst();
if (!$Listlocalizacion->isvoid()) {
	do {
		$MiTemplate->set_var('direcciond', $Listdirdes->getelem()->direccion);
		$MiTemplate->set_var('contactod', $Listdirdes->getelem()->contacto);
		$MiTemplate->set_var('comentariod', $Listdirdes->getelem()->comentario);
		$MiTemplate->set_var('fonocontactod', $Listdirdes->getelem()->fonocontacto);
		$MiTemplate->set_var('ciudadd', $Listlocalizacion->getelem()->ciudad);
		$MiTemplate->set_var('comunad', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
		$MiTemplate->set_var('departamentod', $Listlocalizacion->getelem()->departamento);
	} while ($Listlocalizacion->gonext());
}	
}
else
{
		$MiTemplate->set_var('direcciond', $List->getelem()->direccion);
		$MiTemplate->set_var('contactod', $List->getelem()->contacto.' '.$List->getelem()->apellido);
		$MiTemplate->set_var('comentariod', $List->getelem()->comentario);
		$MiTemplate->set_var('fonocontactod', $List->getelem()->fonocontacto);
		$MiTemplate->set_var('ciudadd', $localiciu);
		$MiTemplate->set_var('comunad', $localibar);
		$MiTemplate->set_var('departamentod', $localidep);
	
}

			$mRegistrodet = new dtoencordenent;
			$ListDeteo = new connlist;
			$mRegistrodet->id_ordenent = $_REQUEST['id_ordenpicking'];
			$ListDeteo->addlast($mRegistrodet);
			bizcve::getdetordenentpespecial($ListDeteo);
			$ListDeteo->gofirst();
			$conteope=$ListDeteo->getelem()->numlinea;
			$conteon_compra=$ListDeteo->getelem()->totallinea;
			$conteope_estadoES=$ListDeteo->getelem()->cantidadp;
			$ListDeteo->clearlist();
					
					//$MiTemplate->set_var('botonsubmit',"<input type='button' value='{boton}' onClick='valida('{id_linea}')'>");
					if($conteon_compra == $conteope && $conteope_estadoES ==0){
						//$MiTemplate->set_var('botonsubmit',' ');
						$MiTemplate->set_var('boton','No Existen Acciones Disponibles');
						$MiTemplate->set_var('accionb',' ');
						$MiTemplate->set_var('dis','disabled="disabled"');
					}
					if($conteon_compra == $conteope && $conteope_estadoES > 0){
						$MiTemplate->set_var('boton','Recibir Todos Los Productos');
						$MiTemplate->set_var('accionb','recibir');
						$MiTemplate->set_var('dis',' ');
						$MiTemplate->set_var('mensajecon','generara el recibido de todos los productos, las OP generadas quedaran en estado CERRADO');
					}
					if($conteon_compra != $conteope){
						$MiTemplate->set_var('boton','Guardar Numero De Compra');
						$MiTemplate->set_var('accionb','cerrar');
						$MiTemplate->set_var('dis',' ');
						$MiTemplate->set_var('mensajecon','guardara el numero de compra ingresado');
					}

/*OBTENEMOS DATOS DEL DETALLE */
$ListDet = new connlist;
$mRegistroDet= new dtodetordenent;
$mRegistroDet->codtipo ='PE';
$mRegistroDet->id_ordenent =$_REQUEST['id_ordenpicking'];
$ListDet->addlast($mRegistroDet);
bizcve::getdetordenent($ListDet);
$ListDet->gofirst();
$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detalleproductos");
if (!$ListDet->isvoid()) { 
       do{
       		     $MiTemplate->set_var('cantidadp', 0);
                 $MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
                 $MiTemplate->set_var('id_linea', $ListDet->getelem()->id_linea);
                 $MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
                 $MiTemplate->set_var('cantidad', number_format($ListDet->getelem()->cantidade,0));
                 $MiTemplate->set_var('precioc', number_format($ListDet->getelem()->pcosto));
                 $MiTemplate->set_var('preciou', number_format(($ListDet->getelem()->totallinea/$ListDet->getelem()->cantidade)));
                 $MiTemplate->set_var('total', number_format($ListDet->getelem()->totallinea));
                 
                 $Listproducto = new connlist;
				 $detproducto = new dtoproducto;
				 $detproducto->cod_prod1 	= $ListDet->getelem()->codprod;
				 $Listproducto->addlast($detproducto);
				 bizcve::getproductoxdatosproveedor($Listproducto);
				 		
				 $Listproducto->gofirst();
				 $MiTemplate->set_var('nitprov', $Listproducto->getelem()->rutproveedor);
				 $MiTemplate->set_var('razonprov', $Listproducto->getelem()->razonsocprov);
				 $MiTemplate->set_var('monprov', '('.$Listproducto->getelem()->nomprov.')');
				 $Listproducto->clearlist();
				 ///////////////////////////getdetcomprapendiente////////////////////////
				 $Listocomprapen = new connlist;
				 $detcomprapen = new dtodetordenent;
				 $detcomprapen->id_linea 	= $ListDet->getelem()->id_linea;
				 $Listocomprapen->addlast($detcomprapen);
				 bizcve::getdetcomprapendiente($Listocomprapen);
				 	
				 $Listocomprapen->gofirst();
				 if($Listocomprapen->getelem()->codprod >0){
				 $MiTemplate->set_var('cantidadp', $Listocomprapen->getelem()->codprod);
				 $MiTemplate->set_var('readnumsap', 'readonly');
				 }
				 else{
				 $MiTemplate->set_var('cantidadp', '0');
				 $MiTemplate->set_var('readnumsap', '');
				 }
				 $Listocomprapen->clearlist();
				 
                  
          	$MiTemplate->parse("BLO_detalleproductos", "detalleproductos", true);
          	
	} while ($ListDet->gonext());
}
			
/*OBTENEMOS EL TIPO DE FLUJO DESDE LA OE*/
$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>