<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../ordenent/ordenent_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////
if ($_REQUEST['accion']=='savefolio'){
	
	$ultimo= $_REQUEST['ultimo'];
	$fechadoc = $_REQUEST['fechadoc'];
	$numorigen = $_REQUEST['id_ordenent'];
	$folionum = $_REQUEST['folionum'];

	$List  = new connlist;
	$mRegistro=new dtolocal;
	//$mRegistro->cod_local=$_REQUEST['select_suministro'];
	$mRegistro->cod_local=$ses_usr_codlocal;

	$List->addlast($mRegistro);
	bizcve::getultimofolio($List);
	$List->gofirst();
	$folioprint = $List->getelem()->numfolio_fct;
	if($folionum != $List->getelem()->numfolio_fct){
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
		}
	}					
	for($i=0;$i<=sizeof($idfolio);$i++){

		//bizcve::verificafoliofct($List = new connlist(new dtodocumento(array('id_documento'=>$idfolio[$i],'numdocumento'=>$numdoc[$i],'codlocalcsum'=>$ses_usr_codlocal))),null );
		//RGM. 25-08-2007. El folio es único para TODA la cadena Easy
		bizcve::verificafoliofct($List = new connlist(new dtodocumento(array('numdocumento'=>$numdoc[$i]))),null );
		$List->gofirst();
		if($List->getelem()->numdocumento==$numdoc[$i] && $List->getelem()->id_documento != $idfolio[$i]){
			general::alertexit('El folio '.$numdoc[$i].' que esta tratando de imprimir ya ha sido utilizado anteriormente en la OE '.$List->getelem()->id_ordenent.' (con el id de doc. interno '.$List->getelem()->id_documento.'). Solicite un nuevo folio.');
		}	
	}
	
	//Grabamos la ruta de la impresora	
	bizcve::grabaimpresorausuario($_REQUEST['impresora'],null);


	for($i=0;$i<sizeof($idfolio);$i++) { 
		bizcve::putdocumento($ListEnc = new connlist(new dtodocumento(array('id_documento'=>$idfolio[$i],'numdocumento'=>$numdoc[$i],'fechadocumento'=>general::formato_fecha_FORM2DB($fechadoc[$i]),'folionum'=>$folionum))),null );	
		bizcve::incrementafct($Listfolio = new connlist(new dtodocumento(array('cod_local'=>$ses_usr_codlocal))));
		general::inserta_tracking(null, $_REQUEST['id_ordenent'], null, $idfolio[$i], 'Se ha asignado número de folio ' . $numdoc[$i] . ' y fecha ' . $fechadoc[$i] . ' al documento');
		
		if($i > 0)
			$id_documento.= "-".$idfolio[$i];
		else
			$id_documento.= $idfolio[$i];
	}

	header( "Location: ordenent_popfac.php?id_ordenent=".$_REQUEST['id_ordenent'].'&accion=prnt&id_documento='.$id_documento);			
	exit();		
}


if ($_REQUEST['accion']=='prnt'){
	bizcve::GetUsers($List=new connlist(new dtousuario(array('usr_id'=>$ses_usr_id))));
	$List->gofirst();

	$MiTemplate = new template;
	$MiTemplate->set_var("TITULO", TITULO);
	$MiTemplate->set_file("main", TEMPLATE . "ordenent/ordenent_popfacprint.htm");		
   	$MiTemplate->set_var('id_ordenent', $_REQUEST['id_ordenent']);	
	$MiTemplate->set_var('impresora', $List->getelem()->usr_dat_extras);			
	$MiTemplate->set_var('id_documento', $_REQUEST['id_documento']);
	$MiTemplate->set_var('URL_CVE', URL_CVE);			

	$tmpdoc = split('-',$_REQUEST['id_documento']);
	if (!count($tmpdoc))
		general::alertexit('ERROR: No vienen documentos para imprimir');
	$prorrateoflete=1;	
	bizcve::getdocumento($Listdocu = new connlist(new dtodocumento(array('id_documento'=>join(',', $tmpdoc),'prorrateoflete'=> $prorrateoflete) ) ), $ListDetDoc = new connlist);

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
}
if ($_REQUEST['accion']=='save'){

	$aiddoc=$_REQUEST['id_doc'];	
	$anumdocumento=$_REQUEST['numdoc'];
	$afechadocumento=$_REQUEST['fechadoc'];	
	foreach ($anumdocumento as $key=>$value) { 
		$fecha=general::formato_fecha_FORM2DB($afechadocumento[$key]);
		bizcve::verificafolio($ListEnc = new connlist(new dtodocumento(array('id_documento'=>$idfolio[$i],'numdocumento'=>$numdoc[$i],'folionum'=>$folionum,'codlocalcsum'=>$ses_usr_codlocal))),null );
		bizcve::putdocumento($ListEnc = new connlist(new dtodocumento(array('id_documento'=>$aiddoc[$key],'numdocumento'=>$anumdocumento[$key],'fechadocumento'=>$fecha))),null );	
        general::inserta_tracking(null, null, null, $aiddoc[$key], 'Se ha asignado numero de folio ' . $anumdocumento[$key] . ' y fecha ' . $fecha . ' al documento');
	}		
	general::close();
}
///////////////////////// FIN ZONA DE ACCIONES /////////////////////////

$ListEnc  = new connlist;
$ListDet  = new connlist;	
$Registro = new dtoencordenent;
$mRegistro->id_ordenent=$_REQUEST['id_ordenent'];
$ListEnc->addlast($mRegistro);
bizcve::getordenent($ListEnc, $ListDet);
bizcve::getdocumento($Listdocu = new connlist(new dtodocumento(array('numorigen'=>$_REQUEST['id_ordenent'],'id_tipodocumento'=>1,'sigtipodoc'=>'FCT'))), $ListDetDoc = new connlist);

$ListEnc->gofirst();	
if((!$ListEnc->getelem()->puedever)||(!isset($_REQUEST['id_ordenent']))){
	general::alertexit('No puede ver esta cotizacion');
	header( "Location: ../start/start_01.php");					
}
	
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);
/* Inclusion de main*/

$MiTemplate->set_file("main", TEMPLATE . "ordenent/ordenent_popfac.htm");
/*para los documentos*/
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
	$MiTemplate->set_var('codigovendedor', $ListEnc->getelem()->codigovendedor);	
	$MiTemplate->set_var('nomtipoentrega', $Listf->getelem()->nombre);		
	$id_tipoflujo=$ListEnc->getelem()->id_tipoflujo;
	$codigovendedor=$ListEnc->getelem()->codigovendedor;
	$MiTemplate->set_var('nomestadorent', $ListEnc->getelem()->nomestadorent);	
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
//Si el tipo de flujo no es 1 o 2, no puede imprimir guía
if ($id_tipoflujo==5) {
	general::alertexit('Este tipo de Orden de Entrega no tiene impresion de Facturas.');
}
bizcve::GetUsers($List=new connlist(new dtousuario(array('usr_id'=>$ses_usr_id))));
$List->gofirst();
$MiTemplate->set_var('impresora', (($List->getelem()->usr_dat_extras)?$List->getelem()->usr_dat_extras:IMPRESORA));

$Lista  = new connlist;
$mfolio= new dtodocumento;
$mfolio->cod_local=$ses_usr_codlocal;

$Lista->addlast($mfolio);
if(bizcve::getultimofolio($Lista)){
	$Lista->gofirst();
	$MiTemplate->set_var('numdocumento', $Lista->getelem()->numfolio_fct);
	$MiTemplate->set_var('folionum', $Lista->getelem()->numfolio_fct);
	$MiTemplate->set_var('codigo_local', $ses_usr_codlocal);
}


$List = new connlist;
$Registro = new dtolocal;
$Registro->cod_local = $codlocalventa;
$List->addlast($Registro);
bizcve::getlocales($List);
if($List->isvoid()){
	$List->gofirst();
	$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
}

$counter = 1;
bizcve::getdocumento($Listdocu = new connlist(new dtodocumento(array('numorigen'=>$_REQUEST['id_ordenent'],'id_tipodocumento'=>1,'sigtipodoc'=>'FCT'))), $ListDetDoc = new connlist);
$Listdocu->gofirst();
$MiTemplate->set_block('main' , "detalleDocumentos" , "BLO_detalleDOC");
if (!$Listdocu->isvoid()) {
	do {
		$MiTemplate->set_var('item', $counter);
		$MiTemplate->set_var('numint', $Listdocu->getelem()->id_documento);		
		$MiTemplate->set_var('numinterno', $Listdocu->getelem()->id_documento);
		$MiTemplate->set_var('id_documento', $Listdocu->getelem()->id_documento);		
		$MiTemplate->set_var('sigtipodoc', $Listdocu->getelem()->sigtipodoc);
		//general::alert('es aqui donde setea fecha');
		if($Listdocu->getelem()->fechadocumento&&$Listdocu->getelem()->numdocumento!=0) {
			$MiTemplate->set_var('fechadoc', general::formato_fecha($Listdocu->getelem()->fechadocumento));			
		}
		else {
			$hoy=DATE('d/m/Y');
			$MiTemplate->set_var('fechadoc',$hoy);				
		}
		$MiTemplate->set_var('pagina', $Listdocu->getelem()->pagina);				
		$MiTemplate->set_var('numimpreso', (($Listdocu->getelem()->numdocumento)?$Listdocu->getelem()->numdocumento:'-No impreso-'));				
		$MiTemplate->set_var('totalnumiva', number_format($Listdocu->getelem()->totalnumiva));			
		$MiTemplate->set_var('lockprintfct', $Listdocu->getelem()->lockprintfct);		
		$MiTemplate->set_var('indmsgsap', $Listdocu->getelem()->indmsgsap);		
		$MiTemplate->parse("BLO_detalleDOC", "detalleDocumentos", true);	
		$counter++;
	} while ($Listdocu->gonext());
	$MiTemplate->set_var('ultimo', $counter--);
}

$List = new connlist;
$Registro = new dtoinfocliente;
$Registro->rut	= $rut;
$List->addlast($Registro);

bizcve::getCliente($List);
$List->gofirst();
if (!$List->isvoid()) {
	$List->gofirst();
	$MiTemplate->set_var('rut', $List->getelem()->rut);
	$MiTemplate->set_var('rutcliente', $List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut));	
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
	$MiTemplate->set_var('comuna', $ListEnc->getelem()->comuna);		
}

bizcve::getdocumento($List = new connlist(new dtodocumento(array('tipoorigen'=>'OE', 'id_tipodocumento'=>'1', 'numorigen'=>$_REQUEST['id_ordenent']))), $ListDet = new connlist); 

$MiTemplate->set_var('BLOQUEO_IMPRESION_FCT', BLOQUEO_IMPRESION_FCT);

$MiTemplate->set_block('main' , "doclocklist" , "BLO_doclocklist");
if ($List->numelem()) {
	$List->gofirst();
	do {
		$MiTemplate->set_var('id_documento', $List->getelem()->id_documento);
		$MiTemplate->set_var('lockprintfct', $List->getelem()->lockprintfct);
		$MiTemplate->set_var('indmsgsap', $List->getelem()->indmsgsap);		
		$MiTemplate->parse("BLO_doclocklist", "doclocklist", true);	
	} while ($List->gonext());
}

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
?>
