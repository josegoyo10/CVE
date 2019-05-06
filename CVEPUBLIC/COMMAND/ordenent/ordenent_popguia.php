<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../ordenent/ordenent_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////
	//general::alert('recien empezando esto es lo que recupero: '.$_REQUEST['dir_guardada']);
if ($_REQUEST['accion']=='savefolio'){
	$ultimo= $_REQUEST['ultimo'];
	//general::alert('fecha: '.$ultimo); 
	$fechadoc = $_REQUEST['fechadoc'];
	$numorigen = $_REQUEST['id_ordenent'];
	$folionum = $_REQUEST['folionum'];
	$id_direccion = $_REQUEST['id_direccion'];
	//general::alert('fecha: '.$_REQUEST['folionum']);
	$List  = new connlist;
	$mRegistro=new dtolocal;
	//$mRegistro->cod_local=$_REQUEST['select_suministro'];
	$mRegistro->cod_local=$ses_usr_codlocal;
	
	$List->addlast($mRegistro);
	bizcve::getultimofolio($List);
	$List->gofirst();
	$folioprint = $List->getelem()->numfolio_gde;
	if($folionum != $List->getelem()->numfolio_gde){
		general::alertexit('No es posible imprimir el documento, puesto que otro usuario esta utilizando el folio '.$folionum.', por favor intente nuevamente.');
	}

	for ($i=1; $i<$ultimo; $i++)  {
		$strl = "\$env=&\$idlinea_".$i.";";
		eval($strl);
		if( $env != "" ){
			$arr_env = split('-',$env);
			$idfolio[] = $arr_env[0];
		
			$str2 = "\$doc=&\$idfolio_".$i.";";
			eval($str2);
			$numdoc[] = $doc;

			$str3 = "\$fecha=&\$fechadoc_".$i.";";
			eval($str3);
			$fechadoc[] = $fecha;
			
			$str4 = "\$dirguardar=&\$id_direccion_".$i.";";
			eval($str4);
			$id_direccion[] = $dirguardar;
		}
	}

	for($i=0;$i<=sizeof($idfolio);$i++){

		//bizcve::verificafoliogde($List = new connlist(new dtodocumento(array('id_documento'=>$idfolio[$i],'numdocumento'=>$numdoc[$i],'codlocalventa'=>$_REQUEST['select_suministro']))),null );
		//RGM. 25-08-2007. El folio es único para TODA la cadena Easy
		bizcve::verificafoliogde($List = new connlist(new dtodocumento(array('numdocumento'=>$numdoc[$i]))),null );
		$List->gofirst();
		if($List->getelem()->numdocumento==$numdoc[$i] && $List->getelem()->id_documento != $idfolio[$i]){
			general::alertexit('El folio '.$numdoc[$i].' que esta tratando de imprimir ya ha sido utilizado anteriormente en la OE '.$List->getelem()->id_ordenent.' (con el id de doc. interno '.$List->getelem()->id_documento.'). Solicite un nuevo folio.');
		}

		/*DIRECCION DE DESPACHO*/
		bizcve::getdirdesp($List = new connlist(new dtodireccion(array('id_direccion'=>$id_direccion[$i]))));
		$List->gofirst();
		if($List->numelem()==0){
			$Lista = new connlist;
			$Registra = new dtoinfocliente;
			$Registra->rut	= $_REQUEST['rutcliente'];
			$Lista->addlast($Registra);
			bizcve::getCliente($Lista);
			$nomdireccion[$i] = $Lista->getelem()->direccion;
			$nomcomuna[$i] = $Lista->getelem()->nomcomuna;			
		}else{
			$nomdireccion[$i] = $List->getelem()->direccion;
			$nomcomuna[$i] = $List->getelem()->nomcomuna;			
		}
		
		//general::alert($nomdireccion);
	}
	

	//Grabamos la ruta de la impresora	
	bizcve::grabaimpresorausuario(null,$_REQUEST['impresora']);
	
	for($i=0;$i<sizeof($idfolio);$i++) {
		
		//general::alert('id direccion a grabar: '.$id_direccion[$i]);
		//general::alert('fecha a grabar: '.$fechadoc[$i]);
		//general::alert('voy a grabar esto: '.$nomdireccion[$i]);	
		bizcve::putdocumento($ListEnc = new connlist(new dtodocumento(array('id_documento'=>$idfolio[$i],'numdocumento'=>$numdoc[$i],'direccion'=>$nomdireccion[$i],'comuna'=>$nomcomuna[$i],'fechadocumento'=>general::formato_fecha_FORM2DB($fechadoc[$i])))),null );	
		general::inserta_tracking(null, $_REQUEST['id_ordenent'], null, $idfolio[$i], 'Se ha asignado número de folio ' . $numdoc[$i] . ' y fecha ' . $fechadoc[$i] . ' al documento');
		bizcve::incrementagde($Listfolio = new connlist(new dtodocumento(array('cod_local'=>$ses_usr_codlocal))));
		if($i > 0)
			$id_documento.= "-".$idfolio[$i];
		else
			$id_documento.= $idfolio[$i];
	}

	header( "Location: ordenent_popguia.php?id_ordenent=".$_REQUEST['id_ordenent'].'&accion=prnt&id_documento='.$id_documento);			
	exit();		
}

/*if ($_REQUEST['accion']=='prnt'){
	
	$MiTemplate = new template;
	$MiTemplate->set_var("TITULO", TITULO);
	$MiTemplate->set_file("main", TEMPLATE . "ordenent/ordenent_popguiaprint.htm");	
	
	bizcve::GetUsers($List=new connlist(new dtousuario(array('usr_id'=>$ses_usr_id))));
	$List->gofirst();
	

		$ListEnc  = new connlist;
		$ListDet  = new connlist;	
		$Registro = new dtoencordenent;
	   	$mRegistro->id_ordenent=$_REQUEST['id_ordenent'];
		$ListEnc->addlast($mRegistro);
		
		bizcve::getordenent($ListEnc, $ListDet);
		$ListEnc->gofirst();
		if (!$ListEnc->isvoid()) {
			do {
					bizcve::gettipoflujo($Listz=new connlist(new dtotipo(array('id'=>$ListEnc->getelem()->id_tipoflujo))));
					$Listz->gofirst();
					$MiTemplate->set_var('nomtipoentregas', $Listz->getelem()->nombre);
				    $codlocalventa=$ListEnc->getelem()->codlocalventa;
					$MiTemplate->set_var('nomestadorent', $ListEnc->getelem()->nomestadorent);
					if($ListEnc->getelem()->fecha_retira_cliente != '0000-00-00')
						$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_cliente) );
					if($ListEnc->getelem()->fecha_retira_inmediato != '0000-00-00')
						$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_inmediato) );
					if($ListEnc->getelem()->fecha_despacho_programado != '0000-00-00')
						$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_despacho_programado) );
					$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);	
					$MiTemplate->set_var('giro', $ListEnc->getelem()->giro);
					$rut=$ListEnc->getelem()->rutcliente;
					$dir = $ListEnc->getelem()->id_direccion;
			}while ($ListEnc->gonext());
		}
		$Listlo = new connlist;
		$Registro = new dtolocal;
		$Registro->cod_local	=  $codlocalventa;
		$Listlo->addlast($Registro);
		bizcve::getlocales($Listlo);
		$Listlo->gofirst();
		$MiTemplate->set_var('nom_local', $Listlo->getelem()->nom_local);
		
	   	$MiTemplate->set_var('id_ordenent', $_REQUEST['id_ordenent']);	
		$MiTemplate->set_var('impresora', $List->getelem()->impresorag);
		$MiTemplate->set_var('id_documento', $_REQUEST['id_documento']);

		$Listcl = new connlist;
		$Listcs = new connlist;
		$Registro = new dtoinfocliente;
		$Registro->rut	= $rut;
		$Listcl->addlast($Registro);
		$Listcs->addlast($Registro);
	    
		//bizcve::getdirdesp($Listcs);
		
		bizcve::getCliente($Listcl);
		$Listcl->gofirst();
		if (!$Listcl->isvoid()) {
			$Listcl->gofirst();
			$MiTemplate->set_var('rutcliente', $Listcl->getelem()->rut.'-'.general::digiVer($Listcl->getelem()->rut));			
			$MiTemplate->set_var('contacto', $Listcl->getelem()->contacto);					
			$MiTemplate->set_var('fonocontacto', $Listcl->getelem()->fonocontacto);
			$MiTemplate->set_var('fonoservicio', $Listcl->getelem()->fonoservicio);		
			$MiTemplate->set_var('email', $Listcl->getelem()->email);
			$MiTemplate->set_var('direccionservicio', $Listcl->getelem()->direccionservicio);				
		
		}

		
			
		bizcve::getdirdesp($List = new connlist(new dtodireccion(array('rut'=>$rut,
		'id_direccion'=>$dir))));
		$List->gofirst();	
		$MiTemplate->set_var('ciudadser', $List->getelem()->nomciudad);
		$MiTemplate->set_var('comunaser', $List->getelem()->nomcomuna);
		
		$ListDetDoc = new connlist;
		$Registrodoc = new dtodetdocumento;
		$Registrodoc->id_documento = $_REQUEST['id_documento'];
		$ListDetDoc->addlast($Registrodoc);
		
		bizcve::getdocumentogud($ListDetDoc);
		$ListDetDoc->gofirst();
			
		$MiTemplate->set_var('codprod', $ListDetDoc->getelem()->codprod);
		$MiTemplate->set_var('descr', $ListDetDoc->getelem()->descripcion);
		$MiTemplate->set_var('cantidad', $ListDetDoc->getelem()->cantidad);
		  
		
		$MiTemplate->set_var('URL_CVE', URL_CVE);			
	
		$tmpdoc = split('-',$_REQUEST['id_documento']);
		if (!count($tmpdoc))
			general::alertexit('ERROR: No vienen documentos para imprimir');
			
		bizcve::getdocumento($Listdocu = new connlist(new dtodocumento(array('id_documento'=>join(',', $tmpdoc)))), $ListDetDoc = new connlist);
	
		$Listdocu->gofirst();
		$MiTemplate->set_block('main' , "listadocprn" , "BLO_listadocprn");
		if ($Listdocu->numelem()) {
			$contador = 1;
			do {
				$MiTemplate->set_var('item', $contador);
				$MiTemplate->set_var('numdocumento', $Listdocu->getelem()->numdocumento);
				if ($Listdocu->getelem()->fechadocumento>0){
					$MiTemplate->set_var('fechadoc',general::formato_fecha($Listdocu->getelem()->fechadocumento));			
				}else{
					$hoy=DATE('d/m/Y');
					$MiTemplate->set_var('fechadoc',$hoy);				
				}			
				$MiTemplate->set_var('pagina', $Listdocu->getelem()->pagina);
				$MiTemplate->set_var('sigla', $Listdocu->getelem()->sigtipodoc);
				$MiTemplate->set_var('total', number_format(round($Listdocu->getelem()->totalnumiva)));
				$MiTemplate->set_var('id_documentou', $Listdocu->getelem()->id_documento);
				$contador++;
				$MiTemplate->parse("BLO_listadocprn", "listadocprn", true);	
				
				//Marcar la página como impresa para que no se pueda reimprimir
				bizcve::marcardocimpreso($ListDoc = new connlist(new dtodocumento(array('id_documento'=>$Listdocu->getelem()->id_documento))));
		
			} while ($Listdocu->gonext());
		}
		
		$MiTemplate->parse("OUT_M", array("main"), true);
		$MiTemplate->p("OUT_M");
		exit();	
	}*/
if ($_REQUEST['accion']=='save'){
	


	$aiddoc=$_REQUEST['id_doc'];	
	$anumdocumento=$_REQUEST['numdoc'];
	$afechadocumento=$_REQUEST['fechadoc'];	
	$adirid = $_REQUEST['id_direccion'];
	foreach ($anumdocumento as $key=>$value) {

	/* OBTENEMOS LAS DIRECCIONES DE DESPACHO */
	/*
	bizcve::getdirdesp($List = new connlist(new dtodireccion(array('id_direccion'=>$_REQUEST['id_direccion']))));
	$List->gofirst();
	$nomdireccion = $List->getelem()->direccion;
	//general::alert($nomdireccion);*/
	$nomcomuna = $List->getelem()->nomcomuna;
		
		$fecha=general::formato_fecha_FORM2DB($afechadocumento[$key]);
		bizcve::putdocumento($ListEnc = new connlist(new dtodocumento(array('id_documento'=>$aiddoc[$key],'numdocumento'=>$anumdocumento[$key],'direccion'=>$adirid[$key],'comuna'=>$nomcomuna[$key],'fechadocumento'=>$fecha))),null );	
        general::inserta_tracking(null, null, null, $aiddoc[$key], 'Se ha asignado numero de folio ' . $anumdocumento[$key] . ' y fecha ' . $fecha . ' al documento');
	}		
	general::close();
}
///////////////////////// FIN ZONA DE ACCIONES /////////////////////////
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

//Si no hay número de documento, lo sacamos de la página
if (!$_REQUEST['id_ordenent']) {
	general::alertexit('No viene id de Orden de Entrega');
}
$num_recibido = $_REQUEST['numinterno'];
$ListEnc  = new connlist;
$ListDet  = new connlist;	
$Registro = new dtoencordenent;
$mRegistro->id_ordenent=$_REQUEST['id_ordenent'];
$ListEnc->addlast($mRegistro);
bizcve::getordenent($ListEnc, $ListDet);

$ListEnc->gofirst();
if($ListEnc->getelem()->id_tipoentrega == 2){
	bizcve::getdocumento($Listdocu = new connlist(new dtodocumento(array('numorigen'=>$_REQUEST['id_ordenent']))), $ListDetDoc = new connlist);
}else{
	bizcve::getdocumento($Listdocu = new connlist(new dtodocumento(array('numorigen'=>$_REQUEST['id_ordenent'],'id_tipodocumento'=>2,'sigtipodoc'=>'GDE'))), $ListDetDoc = new connlist);	
}	
 
if((!$ListEnc->getelem()->puedever)||(!isset($_REQUEST['id_ordenent']))){
	general::alertexit('No puede ver esta cotizacion');
	header( "Location: ../start/start_01.php");					
}
	
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);
/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "ordenent/ordenent_popguia.htm");

/**/
/*para las ordenes de entrega*/
$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
	bizcve::gettipoflujo($Listf=new connlist(new dtotipo(array('id'=>$ListEnc->getelem()->id_tipoflujo))));	
	$Listf->gofirst();	
	$MiTemplate->set_var('oe', $ListEnc->getelem()->id_ordenent);
	$MiTemplate->set_var('id_ordenent', $ListEnc->getelem()->id_ordenent);	
	$id_ordenent=$ListEnc->getelem()->id_ordenent;
	$MiTemplate->set_var('id_cotizacion', $ListEnc->getelem()->id_cotizacion);
	$id_cotizacion=$ListEnc->getelem()->id_cotizacion;
	$MiTemplate->set_var('nomtipoflujo', $ListEnc->getelem()->nomtipoflujo);	
	$id_tipoflujo=$ListEnc->getelem()->id_tipoflujo;
	$MiTemplate->set_var('codigovendedor', $ListEnc->getelem()->codigovendedor);	
	$MiTemplate->set_var('nomtipoentrega',$Listf->getelem()->nombre);
	/*Validacion de Fecha de Entrega*/
	if($ListEnc->getelem()->fecha_retira_cliente != '0000-00-00')
			$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_cliente) );
		if($ListEnc->getelem()->fecha_retira_inmediato != '0000-00-00')
			$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_inmediato) );
		if($ListEnc->getelem()->fecha_despacho_programado != '0000-00-00')
			$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_despacho_programado) );
	/*Fin Validacion de Fecha de Entrega*/		
	$codigovendedor=$ListEnc->getelem()->codigovendedor;
	$MiTemplate->set_var('nomestadorent', $ListEnc->getelem()->nomestadorent);	
	$MiTemplate->set_var('codlocalvent', $ListEnc->getelem()->codlocalcsum);
	$MiTemplate->set_var('nom_localcsum', $ListEnc->getelem()->nom_localcsum);
	$MiTemplate->set_var('iva', $ListEnc->getelem()->iva);		
	$MiTemplate->set_var('usuariocrea', $ListEnc->getelem()->usrcrea);
	$MiTemplate->set_var('observaciones', $ListEnc->getelem()->observaciones);			
	$MiTemplate->set_var('nota', $ListEnc->getelem()->nota);		
	$codlocalventa=$ListEnc->getelem()->codlocalventa;	
	$MiTemplate->set_var('nomtipoflujo', $ListEnc->getelem()->nomtipoflujo);			
	$rut=$ListEnc->getelem()->rutcliente;
	$id_estado=$ListEnc->getelem()->id_estado;
	$iva=$ListEnc->getelem()->iva;		
}

	//general::alert('id direccion: '.$_REQUEST['id_direccion']);
	//general::alert('no viene marca');

	/*para la direccion de despacho*/
	if($ListEnc->getelem()->id_direccion){
		bizcve::getdirdesp($List = new connlist(new dtodireccion(array('rut'=>$rut,
		'id_direccion'=>$ListEnc->getelem()->id_direccion))));
		$List->gofirst();
		$MiTemplate->set_var('nomdired', 'Direccion Despacho');
		$MiTemplate->set_var('direcciond', $List->getelem()->descripcion." - ".$List->getelem()->direccion);		
		$MiTemplate->set_var('comunad', 'Comuna');
		$MiTemplate->set_var('nomcomunad', $List->getelem()->nomcomuna);
	}else{
			$MiTemplate->set_var('nomdired', 'No posee direccion de despacho');
	}
	

//Si el tipo de flujo no es 1 o 2, no puede imprimir guía
if ($id_tipoflujo!=1 && $id_tipoflujo!=2 && $id_tipoflujo!=3 ) {
	general::alertexit('Este tipo de Orden de Entrega no tiene impresion de Guias de Despacho');
}
else {
	// Si no se ha impreso factura con folio, no puede imprimir guía
	bizcve::getdocumento($listadoc = new connlist(new dtodocumento(array('numorigen'=>($_REQUEST['id_ordenent']+0),
																		 'id_tipodocumento'=>1))), null);
	if (!$listadoc->numelem())
		general::alertexit('No existen Facturas en el documento');
	if ($listadoc->numelem()>50)
		general::alertexit('Demasiados documentos recuperados. La rutina ha sido invocada de forma incorrecta');

	$sinnumero = false;
	$listadoc->gofirst();
	do {
		if (!$listadoc->getelem()->numdocumento)
		$sinnumero = true;
	} while ($listadoc->gonext()); 

	if ($sinnumero)
		general::alertexit('Antes de imprimir Guia de Despacho debe imprimir y asignar numero de folio a la(s) factura(s)');	
}

bizcve::GetUsers($List=new connlist(new dtousuario(array('usr_id'=>$ses_usr_id))));
$List->gofirst();
$MiTemplate->set_var('impresora', (($List->getelem()->impresorag)?$List->getelem()->impresorag:IMPRESORA));

/*Codigo que genera el consecutivo del folio*/
$Lista  = new connlist;
$mfolio= new dtodocumento;
$mfolio->cod_local=$ses_usr_codlocal;
$Lista->addlast($mfolio);
if(bizcve::getultimofolio($Lista)){
	$Lista->gofirst();
	$MiTemplate->set_var('numdocumento', $Lista->getelem()->numfolio_gde);
	$MiTemplate->set_var('folionum', $Lista->getelem()->numfolio_gde);
	$MiTemplate->set_var('codigo_local', $Lista->getelem()->codlocalventa);
}
/*Fin Codigo que genera el consecutivo del folio*/

$List = new connlist;
$Registro = new dtolocal;
$Registro->cod_local = $codlocalventa;
$List->addlast($Registro);
bizcve::getlocales($List);
$List->gofirst();
$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);

$counter = 1;
$Listdocu->gofirst();
if($_REQUEST['dir_guardada']!=''){
	//general::alert($_REQUEST['dir_guardada']);
	$dir_g = $_REQUEST['dir_guardada'];	
}else{
	$MiTemplate->set_var('dir_guardada', 0);
}
$n = 0;
$opi = array();
$MiTemplate->set_block('main' , "detalleDocumentos" , "BLO_detalleDOC");
if (!$Listdocu->isvoid()) {
	
	do {
	   if($Listdocu->getelem()->sigtipodoc != 'FCT'){
		$MiTemplate->set_var('item', $counter);
		$MiTemplate->set_var('numint', $Listdocu->getelem()->id_documento);	
		//$numinterno= $Listdocu->getelem()->id_documento;
		
		/* OBTENEMOS LAS DIRECCIONES DE DESPACHO */
			if($Listdocu->getelem()->id_documento==$_REQUEST['numinterno']){
				bizcve::getdirdesp($List = new connlist(new dtodireccion(array('rut'=>$rut,'id_direccion'=>$_REQUEST['id_direccion']))));
				$dir_elegida = $_REQUEST['id_direccion'];
				$List->gofirst();
				if($List->numelem()==0){
					general::alertexit('La Direccion ha sido eliminada. Imprima Guia de Despacho nuevamente.');
					$Lista = new connlist;
					$Registra = new dtoinfocliente;
					$Registra->rut	= $rut;
					$Lista->addlast($Registra);
					bizcve::getCliente($Lista);
					$MiTemplate->set_var('nombre_direccion', $Lista->getelem()->direccion.", ".$Lista->getelem()->comuna);	
				}
					$MiTemplate->set_var('id_direccion', $List->getelem()->id_direccion);
					$MiTemplate->set_var('dir_guardada', $_REQUEST['id_direccion']);
					//general::alert('esto se va a dirguardada: '.$_REQUEST['id_direccion']);
					//general::alert($List->getelem()->id_direccion);
					$MiTemplate->set_var('nombre_direccion', $List->getelem()->descripcion." - ".$List->getelem()->direccion.", ".$List->getelem()->nomcomuna);
					$MiTemplate->parse("BLO_dirdesp", "dirdesp", true);	
			}else{
				
				if($ListEnc->getelem()->id_dirdespacho == 0){
	    			/*Datos de Direccion del Cliente*/
					$Listc = new connlist;
					$Registro = new dtoinfocliente;
					$Registro->rut	= $rut;
					//general::writelog('rut'.$rut);
					$Listc->addlast($Registro);

					bizcve::getCliente($Listc);
					$Listc->gofirst();
					$dirc=$Listc->getelem()->direccion;
					$Listlocalizacion  = new connlist;
					$registrolocalizacion = new dtolocalizacion;
					$registrolocalizacion->id_localizacion = $Listc->getelem()->id_comuna;
					//general::writelog('localizacion'.$Listc->getelem()->id_comuna);
					$Listlocalizacion->addlast($registrolocalizacion);
					bizcve::getlocalizacion($Listlocalizacion);
					$Listlocalizacion->gofirst();

				}else{
	
					bizcve::getdirdesp($List = new connlist(new dtodireccion(array('rut'=>$rut,'id_direccion'=>$dir_g))));
					$MiTemplate->set_var('id_direccion', $List->getelem()->id_direccion);
					$MiTemplate->set_var('dir_guardada2', $List->getelem()->id_direccion);
					$MiTemplate->set_var('nombre_direccion', $List->getelem()->descripcion." - ".$List->getelem()->direccion.", ".$List->getelem()->nomcomuna);
					$MiTemplate->parse("BLO_dirdesp", "dirdesp", true);					
	
				}	/*Fin Datos de Direccion del Cliente*/
				
				
				
				
				/*if($ListEnc->getelem()->id_dirdespacho == 0){
				bizcve::getdirdesp($List = new connlist(new dtodireccion(array('rut'=>$rut,'id_direccion'=>$dir_g))));
				$List->gofirst();
				if($List->numelem()==0){
                     general::alert('Debe ingresar una direccion de despacho para la Guia de Despacho.');
                     $MiTemplate->set_var('print_nodir','1');
					//general::alert('Debe Ingresar una direccion valida para la Guia de Despacho.');
					/*$Lista = new connlist;
					$Registra = new dtoinfocliente;
					$Registra->rut	= $rut;
					$Lista->addlast($Registra);
					bizcve::getCliente($Lista);
					$Lista->gofirst();*/
                                        //$MiTemplate->set_var('id_direccion', $Lista->getelem()->id_direccion);
					//$MiTemplate->set_var('nombre_direccion', $Lista->getelem()->direccion.", ".$Lista->getelem()->nomcomuna);
				//	$MiTemplate->parse("BLO_dirdesp", "dirdesp", true);	
				/*}else{
					//general::alert('esto recupere de dirguardada: '.$dir_g);
					$MiTemplate->set_var('id_direccion', $List->getelem()->id_direccion);
					$MiTemplate->set_var('dir_guardada2', $List->getelem()->id_direccion);
					$MiTemplate->set_var('nombre_direccion', $List->getelem()->descripcion." - ".$List->getelem()->direccion.", ".$List->getelem()->nomcomuna);
					$MiTemplate->parse("BLO_dirdesp", "dirdesp", true);					
				}*/
	
			}

		
		$MiTemplate->set_var('numinterno', $Listdocu->getelem()->id_documento);
		$MiTemplate->set_var('id_documento', $Listdocu->getelem()->id_documento);		
		
		$MiTemplate->set_var('sigtipodoc', $Listdocu->getelem()->sigtipodoc);

		if($Listdocu->getelem()->fechadocumento) {
			$MiTemplate->set_var('fechadoc', general::formato_fecha($Listdocu->getelem()->fechadocumento));			
		}
		else {
			$hoy=DATE('d/m/Y');
			$MiTemplate->set_var('fechadoc',$hoy);				
		}
			
	/*	if($Listdocu->getelem()->numdocumento)
			$MiTemplate->set_var('numdocumento', $Listdocu->getelem()->numdocumento);
		else
			$MiTemplate->set_var('numdocumento','0');	*/			
		$opi[$n] = 	$Listdocu->getelem()->numdocrefop;
		$n++;
		$MiTemplate->set_var('pagina', $Listdocu->getelem()->pagina);				
		$MiTemplate->set_var('op', $Listdocu->getelem()->numdocrefop);	
		$MiTemplate->set_var('totalnumiva', number_format($Listdocu->getelem()->totalnumiva));			
		$MiTemplate->set_var('lockprintfct', $Listdocu->getelem()->lockprintfct);
		
		$MiTemplate->parse("BLO_detalleDOC", "detalleDocumentos", true);	
		$counter++;
	  }
	} while ($Listdocu->gonext());
	
	$opi2 = implode(",",$opi);
	$MiTemplate->set_var('p2',$opi2);
	$MiTemplate->set_var('ultimo', $counter--);
}

$List = new connlist;
$Registro = new dtoinfocliente;
$Registro->rut	= $rut;
$List->addlast($Registro);

bizcve::getCliente($List);
$List->gofirst();
$Listlocalizacion  = new connlist;
$registrolocalizacion = new dtolocalizacion;
$registrolocalizacion->id_localizacion = $List->getelem()->id_comuna;

$Listlocalizacion->addlast($registrolocalizacion);
bizcve::getlocalizacion($Listlocalizacion);
$Listlocalizacion->gofirst();
if (!$Listlocalizacion->isvoid()) {
	do {
		$MiTemplate->set_var('ciudad', $Listlocalizacion->getelem()->ciudad);
		$MiTemplate->set_var('barrio', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
	    $MiTemplate->set_var('departamento', $Listlocalizacion->getelem()->departamento);
	} while ($Listlocalizacion->gonext());

}

if (!$List->isvoid()) {
	$List->gofirst();
	$MiTemplate->set_var('rut', $List->getelem()->rut);
	$MiTemplate->set_var('rutcliente', (($List->getelem()->id_contribuyente == 2)?$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut) : $List->getelem()->rut ));	
	$MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente);			
	$MiTemplate->set_var('contacto', $List->getelem()->contacto);					
	$MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);		
	$MiTemplate->set_var('email', $List->getelem()->email);
	
}

$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
	$MiTemplate->set_var('id_ordenent', $id_ordenent);		
	$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);	
	$MiTemplate->set_var('giro', $ListEnc->getelem()->giro);
	$MiTemplate->set_var('direccion', $ListEnc->getelem()->direccion);				
}

bizcve::getdocumento($List = new connlist(new dtodocumento(array('tipoorigen'=>'OE', 'id_tipodocumento'=>'2', 'numorigen'=>$_REQUEST['id_ordenent']))), $ListDet = new connlist); 

$MiTemplate->set_var('BLOQUEO_IMPRESION_GDE', BLOQUEO_IMPRESION_GDE);

$MiTemplate->set_block('main' , "doclocklist" , "BLO_doclocklist");
if ($List->numelem()) {
	$List->gofirst();
	do {
		
		$MiTemplate->set_var('id_documento', $List->getelem()->id_documento);
		$MiTemplate->set_var('lockprintgde', $List->getelem()->lockprintgde);
		
		//Busco la OP si existe y veo que esté cerrada en PD
		$lockprintop = false;
		if ($List->getelem()->numdocrefop) {
			
			bizcve::getordenpick($Listop = new connlist(new dtoencordenpicking(array('id_ordenpicking'=>$List->getelem()->numdocrefop))), null);
			$Listop->gofirst();
			if ($Listop->getelem() && $Listop->getelem()->id_estado != 'PD' && $Listop->getelem()->id_estado != 'PF'){
			
				$lockprintop = $List->getelem()->numdocrefop;
			}
		}
		$MiTemplate->set_var('lockprintop', $lockprintop);
		//$MiTemplate->set_var('indmsgsap', $List->getelem()->indmsgsap);		
		
		$MiTemplate->parse("BLO_doclocklist", "doclocklist", true);	
	} while ($List->gonext());
}

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
?>
