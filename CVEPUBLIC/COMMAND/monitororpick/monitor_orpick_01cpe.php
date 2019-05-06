<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitororpick/monitor_orpick_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
if ($_POST['accion'] == 'cerrar' && $_POST['id_ordenpicking']) {

	//Env?o la orden de Picking
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
		general::location('monitor_orpick_01cpe.php?id_ordenpicking=' . $listopgen->getelem()->id_ordenpicking);
	}
	else {
		general::location('monitor_orpick_01cpe.php?id_ordenpicking=' . $_POST['id_ordenpicking']);
	}
	exit();
}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header_sc.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "monitororpick/monitor_orpick_01cpe.htm");

/* OBTENEMOS DATOS DE PICKING PARA ENCABEZADO */
$ListEnc  = new connlist;
$ListDet  = new connlist;
$mRegistro=new dtoencordenpicking;
$mRegistro->id_ordenpicking =$_REQUEST['id_ordenpicking'];
$ListEnc->addlast($mRegistro);
bizcve::getordenpick($ListEnc,$ListDet);
$ListEnc->gofirst();	
$MiTemplate->set_var('id_ordenpicking', $ListEnc->getelem()->id_ordenpicking);
$direccion=$ListEnc->getelem()->id_direccion;
$MiTemplate->set_var('id_ordenent', $ListEnc->getelem()->id_ordenent);
$id_ordenent = $ListEnc->getelem()->id_ordenent; 
$MiTemplate->set_var('nomtipoentrega', $ListEnc->getelem()->nomtipoentrega);
$MiTemplate->set_var('nom_local_csum', $ListEnc->getelem()->nom_local);
$MiTemplate->set_var('notaventa', $ListEnc->getelem()->id_cotizacion);
$MiTemplate->set_var('nota', $ListEnc->getelem()->nota);	
$MiTemplate->set_var('nomestadop', $ListEnc->getelem()->nomestado);
if($ListEnc->getelem()->id_estado!='PC'){
	$MiTemplate->set_var('disabled','disabled');
	$MiTemplate->set_var('inicio','<!--');
	$MiTemplate->set_var('final','-->');	
}
$MiTemplate->set_var('id_estado	', $ListEnc->getelem()->id_estado);
$MiTemplate->set_var('id_tipoentrega', $ListEnc->getelem()->id_tipoentrega);


/* OBTENEMOS DIRECCION DE DESPACHO */
$List  = new connlist;
$mRegistrod=new dtodireccion;
$mRegistrod->id_direccion =$direccion;
$List->addlast($mRegistrod);
bizcve::getdirdesp($List);
$List->gofirst();	
$rut=$List->getelem()->rut;
$MiTemplate->set_var('direcciond', $List->getelem()->direccion);
$MiTemplate->set_var('contactod', $List->getelem()->contacto);
$MiTemplate->set_var('comentariod', $List->getelem()->comentario);
$MiTemplate->set_var('nomcomunad', $List->getelem()->nomcomuna);
$MiTemplate->set_var('fonocontactod', $List->getelem()->fonocontacto);
$MiTemplate->set_var('nomciudadd', $List->getelem()->nomciudad);	

/* OBTENEMOS DATOS DEL DETALLE DE PICKING */
$ListDet->gofirst();
$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detalleproductos");
if ($ListDet->numelem()) { 
	do{
		$MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
		$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
		$MiTemplate->set_var('cantidad', number_format(($ListDet->getelem()->cantidad), 2, '.', ''));
		$MiTemplate->set_var('id_linea', $ListDet->getelem()->id_linea);
		$MiTemplate->set_var('unimed', $ListDet->getelem()->unimed);
		$MiTemplate->set_var('cantidadp', number_format(($ListDet->getelem()->cantidadp), 2, '.', ''));

		$MiTemplate->parse("BLO_detalleproductos", "detalleproductos", true);
	} while ($ListDet->gonext());
}

/* OBTENEMOS INFORMACION DEL CLIENTE */
bizcve::getCliente($List = new connlist(new dtoinfocliente(array('rut'=>$rut))));
$List->gofirst();
if (!$List->isvoid()) {
    $MiTemplate->set_var('rut', $List->getelem()->rut);
    $MiTemplate->set_var('rutcliente', $List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut));	
    $MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente);			
    $MiTemplate->set_var('contacto', $List->getelem()->contacto);					
    $MiTemplate->set_var('razonsoc', $List->getelem()->razonsoc);
    $MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);
    $MiTemplate->set_var('direccion', $List->getelem()->direccion);
    $MiTemplate->set_var('nomcomuna', $List->getelem()->nomcomuna);
    $MiTemplate->set_var('nomciudad', $List->getelem()->nomciudad);
    $MiTemplate->set_var('giro', $List->getelem()->giro);		
}	

/*OBTENEMOS EL TIPO DE FLUJO DESDE LA OE*/
bizcve::getordenent($listoe = new connlist(new dtoencordenent(array('id_ordenent'=>$id_ordenent))), $listoedet = new connlist());
$listoe->gofirst();
$MiTemplate->set_var('flujo', $listoe->getelem()->id_tipoflujo);

/*FIN DESPLIEGUE*/

$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
?>