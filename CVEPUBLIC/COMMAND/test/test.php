<?
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
 
$MiTemplate = new template;
$MiTemplate->set_file('main' ,"../../TEMPLATE/test/test.htm");

/*$List = new connlist;
biztest::gettipousuario($List);  
$List->gofirst();   
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "tipousuario" , "BLO_tipousuario");
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nombre', $List->getelem()->nombre);
		$MiTemplate->parse("BLO_tipousuario", "tipousuario", true);	
	} while ($List->gonext());
	$MiTemplate->clear_var('id');
	$MiTemplate->clear_var('nombre');
}
else {
	echo "Lista vacía gettipousuario";
}*/

/*$List = new connlist;
biztest::gettipoventa($List);
$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "tipoventa" , "BLO_tipoventa");
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nombre', $List->getelem()->nombre);
		$MiTemplate->parse("BLO_tipoventa", "tipoventa", true);	
	} while ($List->gonext());
	$MiTemplate->clear_var('id');
	$MiTemplate->clear_var('nombre');
}
else {
	echo "Lista vacía";
}

$List = new connlist;
biztest::gettiporetiro($List);
$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "tiporetiro" , "BLO_tiporetiro");
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nombre', $List->getelem()->nombre);
		$MiTemplate->parse("BLO_tiporetiro", "tiporetiro", true);	
	} while ($List->gonext());
	$MiTemplate->clear_var('id');
	$MiTemplate->clear_var('nombre');
}
else {
	echo "Lista vacía";
}

$List = new connlist;
biztest::gettipopago($List);
$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "tipopago" , "BLO_tipopago");
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nombre', $List->getelem()->nombre);
		$MiTemplate->parse("BLO_tipopago", "tipopago", true);	
	} while ($List->gonext());
	$MiTemplate->clear_var('id');
	$MiTemplate->clear_var('nombre');
}
else {
	echo "Lista vacía";
}

$List = new connlist;
biztest::gettipomovimiento($List);
$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "tipomovimiento" , "BLO_tipomovimiento");
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nombre', $List->getelem()->nombre);
		$MiTemplate->parse("BLO_tipomovimiento", "tipomovimiento", true);	
	} while ($List->gonext());
	$MiTemplate->clear_var('id');
	$MiTemplate->clear_var('nombre');
}
else {
	echo "Lista vacía";
}

$List = new connlist;
biztest::gettipomensaje($List);
$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "tipomensaje" , "BLO_tipomensaje");
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nombre', $List->getelem()->nombre);
		$MiTemplate->parse("BLO_tipomensaje", "tipomensaje", true);	
	} while ($List->gonext());
	$MiTemplate->clear_var('id');
	$MiTemplate->clear_var('nombre');
}
else {
	echo "Lista vacía";
}

$List = new connlist;
biztest::gettipoflujo($List);
$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "tipoflujo" , "BLO_tipoflujo");
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nombre', $List->getelem()->nombre);
		$MiTemplate->parse("BLO_tipoflujo", "tipoflujo", true);	
	} while ($List->gonext());
	$MiTemplate->clear_var('id');
	$MiTemplate->clear_var('nombre');
}
else {
	echo "Lista vacía";
}

$List = new connlist;
biztest::gettipoentrega($List);
$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "tipoentrega" , "BLO_tipoentrega");
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nombre', $List->getelem()->nombre);
		$MiTemplate->parse("BLO_tipoentrega", "tipoentrega", true);	
	} while ($List->gonext());
	$MiTemplate->clear_var('id');
	$MiTemplate->clear_var('nombre');
}
else {
	echo "Lista vacía";
}

$List = new connlist;
biztest::gettipodocumento($List);
$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "tipodocumento" , "BLO_tipodocumento");
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nombre', $List->getelem()->nombre);
		$MiTemplate->parse("BLO_tipodocumento", "tipodocumento", true);	
	} while ($List->gonext());
	$MiTemplate->clear_var('id');
	$MiTemplate->clear_var('nombre');
}
else {
	echo "Lista vacía";
}

$List = new connlist;
biztest::gettipocliente($List);
$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "tipocliente" , "BLO_tipocliente");
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nombre', $List->getelem()->nombre);
		$MiTemplate->parse("BLO_tipocliente", "tipocliente", true);	
	} while ($List->gonext());
	$MiTemplate->clear_var('id');
	$MiTemplate->clear_var('nombre');
}
else {
	echo "Lista vacía";
}

$List = new connlist;
biztest::getrubro($List);
$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "rubro" , "BLO_rubro");
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nombre', $List->getelem()->nombre);
		$MiTemplate->parse("BLO_rubro", "rubro", true);	
	} while ($List->gonext());
	$MiTemplate->clear_var('id');
	$MiTemplate->clear_var('nombre');
}
else {
	echo "Lista vacía";
}

$List = new connlist;
biztest::getcomuna($List);
$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "comuna" , "BLO_comuna");
	do {
		$MiTemplate->set_var('id_comuna', $List->getelem()->id_comuna);
		$MiTemplate->set_var('nomcomuna', $List->getelem()->nomcomuna);
		$MiTemplate->set_var('id_ciudad', $List->getelem()->id_ciudad);
		$MiTemplate->set_var('nomciudad', $List->getelem()->nomciudad);
		$MiTemplate->parse("BLO_comuna", "comuna", true);	
	} while ($List->gonext());
}
else {
	echo "Lista vacía";
}

$List = new connlist;
$mRegistro = new dtoinfocliente;
$mRegistro->rut = 13028946;
$List->addlast($mRegistro);
biztest::getCliente($List);
$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "listaclientes" , "BLO_listaclientes");
	do {
		$MiTemplate->set_var('rut', $List->getelem()->rut);
		$MiTemplate->set_var('razonsoc', $List->getelem()->razonsoc);
		$MiTemplate->set_var('giro', $List->getelem()->giro);
		$MiTemplate->set_var('nomciudad', $List->getelem()->nomciudad);
		$MiTemplate->parse("BLO_listaclientes", "listaclientes", true);	
	} while ($List->gonext());
}
else {
	echo "Lista vacía";
}*/

/*
$ListEnc = new connlist;
$ListDet = new connlist;
$Registro = new dtodocumento;
$Registro->numdocumento = 9984732;
$Registro->sigtipodoc = 'FCT';
$ListEnc->addlast($Registro);

biztest::getdocumento($ListEnc, $ListDet);

$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
	$MiTemplate->set_block('main' , "listadocumentos" , "BLO_listadocumentos");
	do {
		$MiTemplate->set_var('id_documento', $ListEnc->getelem()->id_documento);
		$MiTemplate->set_var('id_tipodocumento', $ListEnc->getelem()->id_tipodocumento);
		$MiTemplate->set_var('sigtipodoc', $ListEnc->getelem()->sigtipodoc);
		$MiTemplate->set_var('pagina', $ListEnc->getelem()->pagina);
		$MiTemplate->set_var('tipoorigen', $ListEnc->getelem()->tipoorigen);
		$MiTemplate->set_var('numorigen', $ListEnc->getelem()->numorigen);
		$MiTemplate->set_var('numdocumento', $ListEnc->getelem()->numdocumento);
		$MiTemplate->set_var('rutcliente', $ListEnc->getelem()->rutcliente);
		$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);
		$MiTemplate->set_var('giro', $ListEnc->getelem()->giro);
		$MiTemplate->set_var('direccion', $ListEnc->getelem()->direccion);
		$MiTemplate->set_var('comuna', $ListEnc->getelem()->comuna);
		$MiTemplate->set_var('iva', $ListEnc->getelem()->iva);
		$MiTemplate->set_var('totaltexto', $ListEnc->getelem()->totaltexto);
		$MiTemplate->set_var('totalnum', $ListEnc->getelem()->totalnum);
		$MiTemplate->set_var('condicion', $ListEnc->getelem()->condicion);
		$MiTemplate->set_var('diascondicion', $ListEnc->getelem()->diascondicion);
		$MiTemplate->set_var('fonocontacto', $ListEnc->getelem()->fonocontacto);
		$MiTemplate->set_var('observaciones', $ListEnc->getelem()->observaciones);
		$MiTemplate->set_var('nota', $ListEnc->getelem()->nota);
		$MiTemplate->set_var('codlocalventa', $ListEnc->getelem()->codlocalventa);
		$MiTemplate->set_var('codlocalcsum', $ListEnc->getelem()->codlocalcsum);
		$MiTemplate->parse("BLO_listadocumentos", "listadocumentos", true);	
	} while ($ListEnc->gonext());
}
else {
	echo "Lista vacía";
}
$ListDet->gofirst();
if (!$ListDet->isvoid()) {
	$MiTemplate->set_block('main' , "detalledocumento" , "BLO_detalledocumento");
	do {
		$MiTemplate->set_var('id_linea', $ListDet->getelem()->id_linea);
		$MiTemplate->set_var('id_documento', $ListDet->getelem()->id_documento);
		$MiTemplate->set_var('numlinea', $ListDet->getelem()->numlinea);
		$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
		$MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
		$MiTemplate->set_var('barra', $ListDet->getelem()->barra);
		$MiTemplate->set_var('pventaneto', $ListDet->getelem()->pventaneto);
		$MiTemplate->set_var('pventaiva', $ListDet->getelem()->pventaiva);
		$MiTemplate->set_var('cantidad', $ListDet->getelem()->cantidad);
		$MiTemplate->set_var('totallinea', $ListDet->getelem()->totallinea);
		$MiTemplate->set_var('impuesto1', $ListDet->getelem()->impuesto1);
		$MiTemplate->set_var('impuesto2', $ListDet->getelem()->impuesto2);
		$MiTemplate->set_var('unimed', $ListDet->getelem()->unimed);
		$MiTemplate->parse("BLO_detalledocumento", "detalledocumento", true);	
	} while ($ListDet->gonext());
}
else {
	echo "Lista vacía";
}
*/

/*$List = new connlist;
$Registro = new dtoinfocliente;
	$Registro->rut				= 12312312;
	$Registro->razonsoc			= 'Constructora Los Cocodrilos';
$List->addlast($Registro);
if (biztest::putcliente($List)) {
	$MiTemplate->set_var('respuesta', 'Cliente guardado');
}
else {
	$MiTemplate->set_var('respuesta', 'Error en inserción de cliente');
}*/

$List = new connlist;
$Registro = new dtoproducto;
$Registro->sap = '102880';
$Registro->csum = 'E512';
$Registro->numretlimit = '100';

$List->addlast($Registro);
bizcve::getproducto($List);
$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "productos" , "BLO_productos");
	do {
		$MiTemplate->set_var('sap', $List->getelem()->sap);
		$MiTemplate->set_var('barra', $List->getelem()->barra);
		$MiTemplate->set_var('descripcion', $List->getelem()->descripcion);
		$MiTemplate->set_var('nomprov', $List->getelem()->nomprov);
		$MiTemplate->set_var('numretreal', $List->getelem()->numretreal);
		$MiTemplate->parse("BLO_productos", "productos", true);	
	} while ($List->gonext());
}
else {
	echo "Lista vacía";
}

/* para cotizaciones*/
/*
$ListEnc = new connlist;
$ListDet = new connlist;
$Registro = new dtocotizacion;
//$Registro->id_cotizacion	= 4;
$ListEnc->addlast($Registro);

biztest::getcotizacion($ListEnc, $ListDet);

$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
	$MiTemplate->set_block('main' , "listadocotizacion" , "BLO_listadocotizacion");
	do {

		$MiTemplate->set_var('id_cotizacion', $ListEnc->getelem()->id_cotizacion);
		$MiTemplate->set_var('id_estado', $ListEnc->getelem()->id_estado);
		$MiTemplate->set_var('id_tipoventa', $ListEnc->getelem()->id_tipoventa);
		$MiTemplate->set_var('codigovendedor', $ListEnc->getelem()->codigovendedor);
		$MiTemplate->set_var('rutcliente', $ListEnc->getelem()->rutcliente);
		$MiTemplate->set_var('codlocalventa', $ListEnc->getelem()->codlocalventa);
		$MiTemplate->set_var('codlocalcsum', $ListEnc->getelem()->codlocalcsum);
		$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);
		$MiTemplate->set_var('giro', $ListEnc->getelem()->giro);
		$MiTemplate->set_var('direccion', $ListEnc->getelem()->direccion);
		$MiTemplate->set_var('comuna', $ListEnc->getelem()->comuna);
		$MiTemplate->set_var('iva', $ListEnc->getelem()->iva);
		$MiTemplate->set_var('validdesde', $ListEnc->getelem()->validdesde);
		$MiTemplate->set_var('validhasta', $ListEnc->getelem()->validhasta);
		$MiTemplate->set_var('validdias', $ListEnc->getelem()->validdias);
		$MiTemplate->set_var('condicion', $ListEnc->getelem()->condicion);
		$MiTemplate->set_var('diascondicion', $ListEnc->getelem()->diascondicion);
		$MiTemplate->set_var('fonocontacto', $ListEnc->getelem()->fonocontacto);
		$MiTemplate->set_var('observaciones', $ListEnc->getelem()->observaciones);
		$MiTemplate->set_var('nota', $ListEnc->getelem()->nota);
		$MiTemplate->set_var('id_usuario', $ListEnc->getelem()->id_usuario);
		$MiTemplate->set_var('usuariocrea', $ListEnc->getelem()->usuariocrea);
		$MiTemplate->set_var('incluirentotal', $ListEnc->getelem()->incluirentotal);				
		$MiTemplate->set_var('valortotal', $ListEnc->getelem()->valortotal);
		$MiTemplate->set_var('margentotal', $ListEnc->getelem()->margentotal);		
		$MiTemplate->set_var('obsdesb', $ListEnc->getelem()->obsdesb);		
		$MiTemplate->parse("BLO_listadocotizacion", "listadocotizacion", true);	
	} while ($ListEnc->gonext());
}
else {
	echo "Lista vacía listadocotizacion";
}
*/
/* para el detalle de las cotizaciones*/
/*
$ListDet->gofirst();
if (!$ListDet->isvoid()) {
	$MiTemplate->set_block('main' , "detallecotizacion" , "BLO_detallecotizacion");
	do {
		$MiTemplate->set_var('id_linea', $ListDet->getelem()->id_linea);
		$MiTemplate->set_var('id_cotizacion_', $ListDet->getelem()->id_cotizacion);
		$MiTemplate->set_var('id_tiporetiro', $ListDet->getelem()->id_tiporetiro);
		$MiTemplate->set_var('numlinea', $ListDet->getelem()->numlinea);
		$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
		$MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
		$MiTemplate->set_var('barra', $ListDet->getelem()->barra);
		$MiTemplate->set_var('pcosto', $ListDet->getelem()->pcosto);
		$MiTemplate->set_var('pventaneto', $ListDet->getelem()->pventaneto);
		$MiTemplate->set_var('cargoflete', $ListDet->getelem()->cargoflete);
		$MiTemplate->set_var('pventaiva', $ListDet->getelem()->pventaiva);
		$MiTemplate->set_var('totallinea', $ListDet->getelem()->totallinea);
		$MiTemplate->set_var('cantidad', $ListDet->getelem()->cantidad);
		$MiTemplate->set_var('cantidade', $ListDet->getelem()->cantidade);				
		$MiTemplate->set_var('margenlinea', $ListDet->getelem()->margenlinea);			
		$MiTemplate->parse("BLO_detallecotizacion", "detallecotizacion", true);	
	} while ($ListDet->gonext());
}
else {
	echo "Lista vacia detallecotizacion";
}
*/
/*obtiene las ordenes de entrega encabezados*/
/*
$ListEnc = new connlist;
$ListDet = new connlist;
$Registro = new dtoencordenent;
//$Registro->id_ordenent = 3;
$ListEnc->addlast($Registro);

biztest::getordenent($ListEnc, $ListDet);

$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
	$MiTemplate->set_block('main' , "ordenent" , "BLO_listaordenent");
	do {
 		$MiTemplate->set_var('id_ordenent', $ListEnc->getelem()->id_ordenent);
		$MiTemplate->set_var('id_cotizacion', $ListEnc->getelem()->id_cotizacion);
		$MiTemplate->set_var('id_estado', $ListEnc->getelem()->id_estado);
		$MiTemplate->set_var('id_tipopago', $ListEnc->getelem()->id_tipopago);
		$MiTemplate->set_var('id_tipoentrega', $ListEnc->getelem()->id_tipoentrega);
		$MiTemplate->set_var('id_direccion', $ListEnc->getelem()->id_direccion);
		$MiTemplate->set_var('id_tipoflujo', $ListEnc->getelem()->id_tipoflujo);
		$MiTemplate->set_var('codigovendedor', $ListEnc->getelem()->codigovendedor);
		$MiTemplate->set_var('rutcliente', $ListEnc->getelem()->rutcliente);
		$MiTemplate->set_var('rutvendedor', $ListEnc->getelem()->rutvendedor);
		$MiTemplate->set_var('codlocalventa', $ListEnc->getelem()->codlocalventa);
		$MiTemplate->set_var('codlocalcsum', $ListEnc->getelem()->codlocalcsum);
		$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);
		$MiTemplate->set_var('giro', $ListEnc->getelem()->giro);
		$MiTemplate->set_var('direccion', $ListEnc->getelem()->direccion);
		$MiTemplate->set_var('comuna', $ListEnc->getelem()->comuna);
		$MiTemplate->set_var('iva', $ListEnc->getelem()->iva);
		$MiTemplate->set_var('condicion', $ListEnc->getelem()->condicion);
		$MiTemplate->set_var('diascondicion', $ListEnc->getelem()->diascondicion);
		$MiTemplate->set_var('fonocontacto', $ListEnc->getelem()->fonocontacto);
		$MiTemplate->set_var('observaciones', $ListEnc->getelem()->observaciones);
		$MiTemplate->set_var('nota', $ListEnc->getelem()->nota);
		$MiTemplate->set_var('id_usuario', $ListEnc->getelem()->id_usuario);
		$MiTemplate->set_var('numdocpago', $ListEnc->getelem()->numdocpago);				
		$MiTemplate->set_var('obsdesb', $ListEnc->getelem()->obsdesb);
		$MiTemplate->set_var('codtipo', $ListEnc->getelem()->codtipo);
		$MiTemplate->set_var('codsubtipo', $ListEnc->getelem()->codsubtipo);
		$MiTemplate->parse("BLO_listaordenent", "ordenent", true);	
	} while ($ListEnc->gonext());
}
else {
	echo "Lista vacía Orden de entrega Encabezado";
}

$ListDet->gofirst();
if (!$ListDet->isvoid()) {
	$MiTemplate->set_block('main' , "detordenent" , "BLO_detordenent");
	do {
		$MiTemplate->set_var('id_linea', $ListDet->getelem()->id_linea);
		$MiTemplate->set_var('id_ordenent_', $ListDet->getelem()->id_ordenent);
		$MiTemplate->set_var('id_tiporetiro', $ListDet->getelem()->id_tiporetiro);		
		$MiTemplate->set_var('numlinea', $ListDet->getelem()->numlinea);
		$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
		$MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
		$MiTemplate->set_var('barra', $ListDet->getelem()->barra);
		$MiTemplate->set_var('pventaneto', $ListDet->getelem()->pventaneto);
		$MiTemplate->set_var('pventaiva', $ListDet->getelem()->pventaiva);
		$MiTemplate->set_var('totallinea', $ListDet->getelem()->totallinea);
		$MiTemplate->set_var('cantidade', $ListDet->getelem()->cantidade);
		$MiTemplate->set_var('cantidadp', $ListDet->getelem()->cantidadp);
		$MiTemplate->set_var('cantidadd', $ListDet->getelem()->cantidadd);
		$MiTemplate->set_var('id_documento', $ListDet->getelem()->id_documento);
		$MiTemplate->set_var('id_lineadoc', $ListDet->getelem()->id_lineadoc);				
		$MiTemplate->set_var('unimed', $ListDet->getelem()->unimed);				
		$MiTemplate->parse("BLO_detordenent", "detordenent", true);	
	} while ($ListDet->gonext());
}
else {
	echo "Lista vacía Detalle Orden de entrega";
}
*/
/*para las ordenes de picking*/
/*
$ListEnc = new connlist;
$ListDet = new connlist;
$Registro = new dtoencordenpicking;
//$Registro->id_ordenpicking = 2;
$ListEnc->addlast($Registro);


biztest::getordenpick($ListEnc, $ListDet);

$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
	$MiTemplate->set_block('main' , "ordenpick" , "BLO_listaordenpick");
	do {
 		$MiTemplate->set_var('id_ordenpicking', $ListEnc->getelem()->id_ordenpicking);
		$MiTemplate->set_var('id_ordenent', $ListEnc->getelem()->id_ordenent);
		$MiTemplate->set_var('id_estado', $ListEnc->getelem()->id_estado);
		$MiTemplate->set_var('id_direccion', $ListEnc->getelem()->id_direccion);
		$MiTemplate->set_var('rutcliente', $ListEnc->getelem()->rutcliente);
		$MiTemplate->set_var('cod_local', $ListEnc->getelem()->cod_local);
		$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);
		$MiTemplate->set_var('direccion', $ListEnc->getelem()->direccion);
		$MiTemplate->set_var('comuna', $ListEnc->getelem()->comuna);
		$MiTemplate->set_var('fonocontacto', $ListEnc->getelem()->fonocontacto);
		$MiTemplate->set_var('observaciones', $ListEnc->getelem()->observaciones);
		$MiTemplate->set_var('nota', $ListEnc->getelem()->nota);
		$MiTemplate->set_var('id_usuario', $ListEnc->getelem()->id_usuario);
		$MiTemplate->set_var('usuariocrea', $ListEnc->getelem()->usuariocrea);
		$MiTemplate->parse("BLO_listaordenpick", "ordenpick", true);	
	} while ($ListEnc->gonext());
}
else {
	echo "Lista vacía Orden de entrega Encabezado";
}

$ListDet->gofirst();
if (!$ListDet->isvoid()) {
	$MiTemplate->set_block('main' , "detordenpick" , "BLO_detordenpick");
	do {
		$MiTemplate->set_var('id_linea', $ListDet->getelem()->id_linea);
		$MiTemplate->set_var('id_ordenpicking', $ListDet->getelem()->id_ordenpicking);
		$MiTemplate->set_var('numlinea', $ListDet->getelem()->numlinea);
		$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
		$MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
		$MiTemplate->set_var('barra', $ListDet->getelem()->barra);
		$MiTemplate->set_var('cantidad', $ListDet->getelem()->cantidad);
		$MiTemplate->set_var('totallinea', $ListDet->getelem()->totallinea);
		$MiTemplate->set_var('cantidadp', $ListDet->getelem()->cantidadp);
		$MiTemplate->parse("BLO_detordenpick", "detordenpick", true);	
	} while ($ListDet->gonext());
}
else {
	echo "Lista vacía Detalle Orden de entrega";
}
*/

$List = new connlist;
$Registro = new dtoestado;
$Registro->tipo ='CO';
$List->addlast($Registro);
biztest::getestados($List);
$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "estado" , "BLO_estado");
	do {
		$MiTemplate->set_var('id_estado', $List->getelem()->id_estado);
		$MiTemplate->set_var('nomestado', $List->getelem()->descripcion);
		$MiTemplate->parse("BLO_estado", "estado", true);	
	} while ($List->gonext());
}
else {
	echo "Lista vacía";
}


/*borra una cotizacion*/
$List = new connlist;
$Registro = new dtocotizacion;
$Registro->id_cotizacion =6;
$List->addlast($Registro);
$vuelta=biztest::delcotizacionall($List);
echo $vuelta." vuelta"."<br>";

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
?>


