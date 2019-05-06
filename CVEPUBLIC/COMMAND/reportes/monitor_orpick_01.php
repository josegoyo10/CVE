<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitororpick/monitor_orpick_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
if ($_POST['accion'] == 'cerrar' && $_POST['id_ordenpicking']) {

	//Envio la orden de Picking
	//Armo la lista de los productos pickeados
	$listpcant = new connlist;
	foreach ($_POST['linea'] as $value)
		if ($_POST['cantact_'.$value]>0)
			$listpcant->addlast(new dtodetordenpicking(array('id_linea' => $value ,'cantidadp' => $_POST['cantact_'.$value] )));
        
	bizcve::cerrarpicking($listop = new connlist(new dtoencordenpicking(array('id_ordenpicking'=>$_POST['id_ordenpicking']))), $listpcant, $listopgen =  new connlist);
	general::writeevent('Se ha cerrado la Orden de Picking Numero ' . $_POST['id_ordenpicking']);
	if ($listopgen) 
		$listopgen->gofirst();
		
	if ($listopgen->numelem()) {
		general::alert('Se ha generado la Orden de Picking Numero ' . $listopgen->getelem()->id_ordenpicking);
		general::writeevent('Se ha generado la Orden de Picking Numero ' . $listopgen->getelem()->id_ordenpicking);
		general::location('monitor_orpick_01.php?id_ordenpicking=' . $listopgen->getelem()->id_ordenpicking.'&rut='.$_REQUEST['rut']);
	}
	else {
		general::location('monitor_orpick_01.php?id_ordenpicking=' . $_POST['id_ordenpicking'].'&rut='.$_REQUEST['rut']);
	}
	exit();
}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "reportes/monitor_orpick_01.htm");

/* OBTENEMOS DATOS DE PICKING PARA ENCABEZADO */
$ListEnc  = new connlist;
$ListDet  = new connlist;
$mRegistro= new dtoencordenent;
$mRegistro->id_ordenent =$_REQUEST['id_ordenpicking'];
$ListEnc->addlast($mRegistro);
//bizcve::getordenpick($ListEnc,$ListDet);
bizcve::getordenent($ListEnc,$ListDet);
$ListEnc->gofirst();	
$MiTemplate->set_var('id_ordenent', $ListEnc->getelem()->id_ordenent);
$direccion=$ListEnc->getelem()->id_direccion;
//general::alert($direccion);
$MiTemplate->set_var('fechacompra', $ListEnc->getelem()->fechacompra);
$id_ordenent = $ListEnc->getelem()->id_ordenent; 
//$MiTemplate->set_var('nomtipoentrega', $ListEnc->getelem()->nomtipoentrega);
$MiTemplate->set_var('nom_local_csum', $ListEnc->getelem()->nom_localcsum);
//$MiTemplate->set_var('notaventa', $ListEnc->getelem()->id_cotizacion);
//$MiTemplate->set_var('nota', $ListEnc->getelem()->nota);	
$MiTemplate->set_var('nomestadop', $ListEnc->getelem()->nomestadorent);
//$MiTemplate->set_var('nomprioridad', $ListEnc->getelem()->nomprioridad);
//$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);
/*if($ListEnc->getelem()->id_estado!='PC'){
	$MiTemplate->set_var('disabled','disabled');
	$MiTemplate->set_var('inicio','<!--');
	$MiTemplate->set_var('final','-->');	
}*/
$MiTemplate->set_var('id_estado	', $ListEnc->getelem()->id_estado);
//$MiTemplate->set_var('id_tipoentrega', $ListEnc->getelem()->id_tipoentrega);
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
    //$MiTemplate->set_var('nomcomuna', $List->getelem()->nomcomuna);
    //$MiTemplate->set_var('nomciudad', $List->getelem()->nomciudad);
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
/*OBTENEMOS DATOS DEL DETALLE */
//$mRegistroDet= new dtoencordenent;
$ListDet = new connlist;
$mRegistroDet= new dtodetordenent;
//echo $_REQUEST['id_ordenpicking'];
$mRegistroDet->id_ordenent =$_REQUEST['id_ordenpicking'];
$ListDet->addlast($mRegistroDet);
bizcve::getdetordenent($ListDet);
$ListDet->gofirst();
$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detalleproductos");
if (!$ListDet->isvoid()) { 
       do{
       		      
                 $MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
                 $MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
                 $MiTemplate->set_var('cantidad', number_format($ListDet->getelem()->cantidade,0));
                 $MiTemplate->set_var('preciou', ($ListDet->getelem()->totallinea/$ListDet->getelem()->cantidade));
                 $MiTemplate->set_var('total', $ListDet->getelem()->totallinea);
                  
                 ////////////prueba///////////////////////
                 
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
                  
                 ////////////////////////////////////////////
                  
                  
                  //echo $ListDet->getelem()->barra;
                  /*$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
                  $MiTemplate->set_var('cantidad', number_format($ListDet->getelem()->cantidad));
                  $MiTemplate->set_var('id_linea', $ListDet->getelem()->id_linea);
                  $MiTemplate->set_var('unimed', $ListDet->getelem()->unimed);
                  if($ListDet->getelem()->codprod==12501){
                    $MiTemplate->set_var('cantidadp', number_format($ListDet->getelem()->cantidad)); 
                  }else
                  $MiTemplate->set_var('cantidadp', number_format($ListDet->getelem()->cantidadp));
//                 $MiTemplate->set_var('readonly_12501', 'readonly');
       		*/
          	$MiTemplate->parse("BLO_detalleproductos", "detalleproductos", true);
          	
	} while ($ListDet->gonext());
}
/*OBTENEMOS EL TIPO DE FLUJO DESDE LA OE*/
//bizcve::getordenent($listoe = new connlist(new dtoencordenent(array('id_ordenent'=>$id_ordenent))), $listoedet = new connlist());
//$listoe->gofirst();
//$MiTemplate->set_var('flujo', $listoe->getelem()->id_tipoflujo);

/*FIN DESPLIEGUE*/

$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>