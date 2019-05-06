<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
	
/* PARA GENERAR UNA ORDEN DE ENTREGA */
/*$Listnve = new connlist(new dtocotizacion(array('id_cotizacion'=>135)));

$listpcant = new connlist;
$prodcant = new dtodetcotizacion(array('id_linea'=>200, 'cantidad'=>2));
$listpcant->addlast($prodcant);
$prodcant = new dtodetcotizacion(array('id_linea'=>201, 'cantidad'=>5));
$listpcant->addlast($prodcant);
$prodcant = new dtodetcotizacion(array('id_linea'=>202, 'cantidad'=>3));
$listpcant->addlast($prodcant);
$prodcant = new dtodetcotizacion(array('id_linea'=>204, 'cantidad'=>4));
$listpcant->addlast($prodcant);
$prodcant = new dtodetcotizacion(array('id_linea'=>205, 'cantidad'=>1));
$listpcant->addlast($prodcant);

bizcve::generaordenent($Listnve, $listpcant, $listoegen = new connlist);
$Listnve->gofirst();
if (!$Listnve->isvoid()) {
	do {
		echo "NVE: " . $Listnve->getelem()->id_cotizacion . "-" . $Listnve->getelem()->id_estado . "<br>";
	} while ($Listnve->gonext());
}
$listoegen->gofirst();
if (!$listoegen->isvoid()) {
	do {
		echo "OE: " . $listoegen->getelem()->id_ordenent . "-" . $listoegen->getelem()->id_estado . "<br>";
	} while ($listoegen->gonext());
}*/

/* PARA CURSAR UNA ORDEN DE ENTREGA */
/*bizcve::cursaordenent($listoe = new connlist(new dtoencordenent(array('id_ordenent'=>28, 'id_tipopago'=>1, 'id_tipodocpago'=>1, 'id_tipoflujo'=>1, 'id_direccion'=>37))), 
					  $listoegen = new connlist);*/

/* PARA DUPLICAR UNA COTIZACION */
/*bizcve::dupcotizacion(new connlist(new dtocotizacion(array('id_cotizacion' => 135))));*/

/* PARA GENERAR UNA COTIZACION A PARTIR DEL REMANENTE DE UNA NVE*/
/*bizcve::gencotizacionremnve(new connlist(new dtocotizacion(array('id_cotizacion' => 135))));*/

/* PARA RECUPERAR UN DOCUMENTO */
/*bizcve::getdocumentoprn($Listdoc = new connlist(new dtodocumento(array('id_documento'=>2))));
$Listdoc->gofirst();
echo $Listdoc->getelem()->txtprn;*/

/* PARA AUTORIZAR UNA ORDEN DE ENTREGA */
/*bizcve::autorizaroe(new connlist(new dtoencordenent(array('id_ordenent'=>21))));*/

/* PARA RECHAZAR UNA ORDEN DE ENTREGA */
/*bizcve::rechazaroe(new connlist(new dtoencordenent(array('id_ordenent'=>23, 'obsdesb'=>'Este tipo no me cae bien'))));*/

/* PARA ANULAR UNA ORDEN DE ENTREGA */
/*bizcve::anularoe(new connlist(new dtoencordenent(array('id_ordenent'=>18))));*/

/* PARA GENERAR LOS DOCUMENTOS TRIBUTARIOS */
/*$Listoe = new connlist(new dtoencordenent(array('id_ordenent'=>28, 'tipodocgen'=>'FCT')));

$listpcant = new connlist;
$prodcant = new dtodetordenent(array('id_linea'=>4));
$listpcant->addlast($prodcant);
$prodcant = new dtodetordenent(array('id_linea'=>5));
$listpcant->addlast($prodcant);
$prodcant = new dtodetordenent(array('id_linea'=>6));
$listpcant->addlast($prodcant);
$prodcant = new dtodetordenent(array('id_linea'=>7));
$listpcant->addlast($prodcant);
$prodcant = new dtodetordenent(array('id_linea'=>8));
$listpcant->addlast($prodcant);

bizcve::generadocumento($Listoe, $listpcant, $listdocgen = new connlist);
$Listoe->gofirst();
if (!$Listoe->isvoid()) {
	do {
		echo "OE: " . $Listoe->getelem()->id_ordenent . "-" . $Listoe->getelem()->id_estado . "<br>";
	} while ($Listoe->gonext());
}
$listdocgen->gofirst();
if (!$listdocgen->isvoid()) {
	do {
		echo "DOC: " . $listdocgen->getelem()->id_documento . "<br>";
	} while ($listdocgen->gonext());
}*/
					  
/* PARA GENERAR EL PEDIDO DE VENTA SAP */
//bizcve::genpedidoventasap($lista = new connlist(new dtoencordenent(array('id_ordenent'=>28))));
					  
/* PARA GENERAR EL PEDIDO DE VENTA SAP */
//bizcve::genpedidoventasap($lista = new connlist(new dtoencordenent(array('id_ordenent'=>28))));

/* PARA DESBLOQUEAR IMPRESION DE DOCUMENTO */
//echo bizcve::desbloqueadocprint($Listdoc = new connlist(new dtodocumento(array('numorigen'=>32, 'pagina' => 3, 'id_tipodocumento'=>1, 'codlocalcsum'=>'E510'))));


/*bizcve::getDetordenent($ListEncOe = new connlist(new dtoencordenent(array('id_ordenent'=>104))), 
$ListDetOe = new connlist(new dtodetordenent(array('id_linea'=>9))));*/
/*bizcve::getordenent($ListEncOe = new connlist(new dtoencordenent(array('id_ordenent'=>104))), $ListDetOe = new connlist);
$ListEncOe->gofirst();
if (!$ListEncOe->isvoid()) {
	do {

		echo "id_ordenent: " . $ListEncOe->getelem()->id_ordenent . "<br>";
		echo "id_cotizacion: " . $ListEncOe->getelem()->id_cotizacion . "<br>";		
		echo "nomestadorent: " . $ListEncOe->getelem()->nomestadorent . "<br>";			
		echo "tipo: " . $ListEncOe->getelem()->tipo . "<br>";			
		echo "id_tipopago: " . $ListEncOe->getelem()->id_tipopago . "<br>";	
		echo "id_tipodocpago: " . $ListEncOe->getelem()->id_tipodocpago . "<br>";	
		echo "id_tipoentrega: " . $ListEncOe->getelem()->id_tipoentrega . "<br>";	
		echo "nomtipoentrega: " . $ListEncOe->getelem()->nomtipoentrega . "<br>";	
		echo "id_direccion: " . $ListEncOe->getelem()->id_direccion . "<br>";	
		echo "id_tipoflujo: " . $ListEncOe->getelem()->id_tipoflujo . "<br>";	
		echo "nomtipoflujo: " . $ListEncOe->getelem()->nomtipoflujo . "<br>";	
		echo "codigovendedor: " . $ListEncOe->getelem()->codigovendedor . "<br>";	
		echo "rutcliente: " . $ListEncOe->getelem()->rutcliente . "<br>";											
		echo "rutvendedor: " . $ListEncOe->getelem()->rutvendedor . "<br>";	
		echo "codlocalventa: " . $ListEncOe->getelem()->codlocalventa . "<br>";	
		echo "codlocalcsum: " . $ListEncOe->getelem()->codlocalcsum . "<br>";	
		echo "nom_localcsum: " . $ListEncOe->getelem()->nom_localcsum . "<br>";	
		echo "razonsoc: " . $ListEncOe->getelem()->razonsoc . "<br>";	
		echo "giro: " . $ListEncOe->getelem()->giro . "<br>";	
		echo "direccion: " . $ListEncOe->getelem()->direccion . "<br>";	
		echo "comuna: " . $ListEncOe->getelem()->comuna . "<br>";	
		echo "iva: " . $ListEncOe->getelem()->iva . "<br>";	
		echo "condicion: " . $ListEncOe->getelem()->condicion . "<br>";	
		echo "diascondicion: " . $ListEncOe->getelem()->diascondicion . "<br>";	
		echo "fonocontacto: " . $ListEncOe->getelem()->fonocontacto . "<br>";	
		echo "observaciones: " . $ListEncOe->getelem()->observaciones . "<br>";	
		echo "nota: " . $ListEncOe->getelem()->nota . "<br>";	
		echo "numdocpago: " . $ListEncOe->getelem()->numdocpago . "<br>";	
		echo "obsdesb: " . $ListEncOe->getelem()->obsdesb . "<br>";							
	} while ($ListEncOe->gonext());
}


$ListDetOe->gofirst();
if (!$ListDetOe->isvoid()) {
	do {
		echo "id_tiporetiro: " . $ListDetOe->getelem()->id_tiporetiro . "<br>";
		echo "numlinea: " . $ListDetOe->getelem()->numlinea . "<br>";		
		echo "descripcion: " . $ListDetOe->getelem()->descripcion . "<br>";			
		echo "codprod: " . $ListDetOe->getelem()->codprod . "<br>";			
	} while ($ListDetOe->gonext());
}	*/
/*
	$ListEnc = new connlist(new dtodocumento(array('direccion'=>'las petunias 2233','comuna'=>'Providencia','iva'=>'19.00','condicion'=>'Cr?dito','diascondicion'=>0,
'fonocontacto'=>2384957,'observaciones'=>'','nota'=>'','codlocalventa'=>'E510','codlocalcsum'=>'E510',
'feccrea'=>'2006-11-14','usrcrea'=>'Despacho')));

	$listdetdoc = new connlist();
	$obj=new dtodetdocumento();
			  $obj->descripcion = 'LLANA AC. ULTRAFLEX LU300 300X180';	
			  $obj->codprod     = 223317;				  
			  $obj->cantidad    = 41;
			  $obj->pventaneto  = 4221.00;
			  $obj->pventaiva   = 0.00;
			  $obj->totallinea  = 173061;			  			  			  			  
			  $obj->unimed      = 'ST';	
			  $obj->feccrea     = '2006-11-14';				  			  
			  $obj->usrcrea     = 'Despacho';				  
			  $listdetdoc->addlast($obj);
	$obj=new dtodetdocumento();
			  $obj->descripcion = 'LLANA AC. TRAPEZ.GDE. LT340 340X160X120';	
			  $obj->codprod     = 223317;				  
			  $obj->cantidad    = 1;
			  $obj->pventaneto  = 4455.00;
			  $obj->pventaiva   = 0.00;
			  $obj->totallinea  = 4455;			  			  			  			  
			  $obj->unimed      = 'ST';	
			  $obj->feccrea     = '2006-11-14';				  			  
			  $obj->usrcrea     = 'Despacho';				  
			  $listdetdoc->addlast($obj);

		general::writeevent('ANTES putdocumento '.DATE('d/m/Y h-i-s'));	
		bizcve::putdocumento($ListEnc ,$listdetdoc );	

		general::writeevent('DESPUES putdocumento '.DATE('d/m/Y h-i-s'));	
*/
		/*llama a la funcion que hace la rebaja del disponible*/						

	/*	$CtrlOe = new ctrlordenent;
		$CtrlOe->reservadisponible(new connlist(
		new dtoencordenent(array('rutcliente'=> 10697870,
								'monto'=> 188410, 
								'id_ordenent'=> 299, 
		  						'id_documento'=> 914
								))));	*/
		/*$Ctrl = new ctrlinfocliente;
				
		/*llama a la funcion que hace la rebaja del disponible*/						
/*		$Ctrl->updisponible(new connlist(
		new dtoinfocliente(array('rutcliente'=> 10697870,
								'id_ordenent'=> 299, 
								'monto'=> 188410, 
		  						'id_documento'=> 914
								))));	*/

$Ctrl = new ctrltipos;
$Ctrl->getconpagoaprox($lista=new connlist(new dtotipo(array('id_tipoconpago'=> 22))));	 	
general::writeevent(22);				
$lista->gofirst();
general::writeevent('* '.$lista->getelem()->id);
general::writeevent('* '.$lista->getelem()->nombre);












		
?>
