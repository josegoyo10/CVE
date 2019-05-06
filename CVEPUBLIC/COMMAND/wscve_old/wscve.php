<?
/********************************
WEBSERVICES
Proyecto : Centro Venta Empresa
Cliente : EASY
Autor : Gisela Estay Jeldes
BBR-i ecommerce &  retail
*********************************/
///////////////////////// ZONA DE INCLUSION /////////////////////////
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
$ses_usr_id=47;
include_once("../../INCLUDE/aplication_top.php");
include_once("lib/database.class.php");
/////////////////////////////////////////////////////////////////////
//
// Module    : SimpleXMLParser.php
// DateTime  : 26/07/2005 11:32
// Author    : Phillip J. Whillier
// Purpose  : Very lightwieght "simple" XML parser does not support attributes.
//
/////////////////////////////////////////////////////////////////////
class SimpleXMLParser {

   // Find the max number of specific nodes in the XML
   function MaxElements($XMLSource, $XMLName) {
           $MaxElements = 0;
           $XMLTag = "<" . $XMLName . ">";
           $Y = $this->instr($XMLSource, $XMLTag);
           while($Y>=0) {
                   $MaxElements = $MaxElements + 1;
                   $Y = $this->instr($XMLSource, $XMLTag, $Y + strlen($XMLTag));
           }
       return $MaxElements;
   }
  
   // Parse xml to retrieve a specific element
   // Instance number is a zero based index.
   function Parse($XMLSource, $XMLName, $aInstance = 0, $Default = "") {
           $XMLLength = strlen($XMLSource);
           $XMLTag = "<" . $XMLName . ">";
           $XMLTagEnd = "</" . $XMLName . ">";
           $Instance = $aInstance + 1;
      
       /* Find the start of the requested instance... */
           $XMLStart = 0;
  
           for($x = 1; $x < $Instance + 1; $x++) {
                   $Y = $this->instr($XMLSource, $XMLTag, $XMLStart);
  
                   if ($Y >= $XMLStart) {
                           $XMLStart = $Y + strlen($XMLTag);
                   }
                   else {
                           return $Default;
                   }
           }
      
       /* Find the end of the instance... */
           $XMLEnd = $XMLStart;
           $XMLMatch = 1;
  
           while($XMLMatch) {
                   $c = substr($XMLSource, $XMLEnd, strlen($XMLTagEnd));
                   if($c == $XMLTagEnd) {
                           $XMLMatch = $XMLMatch - 1;
                   }
                   else {
                       if (substr(c, 0, 1) == $XMLTag) {
                           $XMLMatch = $XMLMatch + 1;
                       }
                   }
                   $XMLEnd = $XMLEnd + 1;
                   if ($XMLEnd == $XMLLength) {
                           return $Dufault;
                   }
           }
           return substr($XMLSource, $XMLStart, $XMLEnd - $XMLStart - 1);
   }
  
   // Helper function for finding substrings
   function instr($haystack, $needle, $pos = 0) {
       $thispos = strpos($haystack, $needle, $pos);
       if ($thispos===false)
           $thispos = -1;
       return $thispos;
   }
}


/*********************************************************/
function func_error($cod, $error_msg,$header,$camposql){

$XMLerror = '<main><header>'.chr(13).$header.chr(13).'</header>
<respuesta>'.chr(13).'
<status>ERROR</status>
<camposErr>'.$error_msg.'</camposErr>
<glosastatus>'.$error_msg.'</glosastatus>'.chr(13).'
</respuesta>'.chr(13).'</main>';
general::writeevent("ERROR($cod) : $error_msg");

return $XMLerror; 
}
/*********************************************************
 * FUNCIONES : Llena_Enc llena los datos del encabezado de un documento
*********************************************************/
function Llena_Enc($enc,&$L_gde_enc,&$L_fac_enc,$Listop){
	//general::writeevent('REVISA_DATOS => ididespacho '.$enc[0].' numguia '.$enc[1].' fechaguia '.$enc[2].' idordenpick '.$enc[3].' enc 4 '.$enc[4] .' enc 5 '.$enc[5]);
	$Listop->gofirst();
	$id_ordenent=$Listop->getelem()->id_ordenent;	
	if ($enc[5]){
		bizcve::putordenpicking($newop = new connlist(new dtoencordenpicking(
													  array('id_ordenpicking'=>$enc[3],
													  		'id_ordenent'=>$id_ordenent,
													  		'id_estado'=>'PF'))), null);		
	}
	/*Para obtener datos del cliente consultamos la OE*/
	bizcve::getordenent($ListEncOe = new connlist(new dtoencordenent(array('id_ordenent'=>$id_ordenent))), $ListDetOe = new connlist);
	$ListEncOe->gofirst();
	$id_cotizacion=$ListEncOe->getelem()->id_cotizacion;	
	$idtipopago   =$ListEncOe->getelem()->id_tipopago;

	$flujo=$ListEncOe->getelem()->id_tipoflujo;	
	$hoy=DATE('d/m/Y');
	if ($flujo==3 || $flujo==4){
	/*Para generar los documentos de Guia de despacho*/			
		$ListEnc = new connlist(new dtodocumento(array('id_tipodocumento'=> 2,
													 'id_tipoorigen'=> 3,
													 'tipoorigen'=> 'OE',		
													 'sigtipodoc'=>'GDE',
													 'numorigen'=>$id_ordenent,
													 'numdocumento'=>$enc[1],
													 'numdocrefop'=>$enc[3],		
													 'fechadocumento'=>$enc[2],		
													 'codigovendedor'=>$ListEncOe->getelem()->codigovendedor,
													 'rutcliente'=>$ListEncOe->getelem()->rutcliente,
													 'razonsoc'=>$ListEncOe->getelem()->razonsoc,
													 'giro'=>$ListEncOe->getelem()->giro,
													 'direccion'=>$ListEncOe->getelem()->direccion,
													 'comuna'=>$ListEncOe->getelem()->comuna,
													 'iva'=>$ListEncOe->getelem()->iva,
													 'condicion'=>$ListEncOe->getelem()->condicion,
													 'diascondicion'=>$ListEncOe->getelem()->diascondicion,
													 'fonocontacto'=>$ListEncOe->getelem()->fonocontacto,
													 'observaciones'=>$ListEncOe->getelem()->observaciones,
													 'nota'=>$ListEncOe->getelem()->nota,
													 'codlocalventa'=>$ListEncOe->getelem()->codlocalventa,
													 'codlocalcsum'=>$ListEncOe->getelem()->codlocalcsum,
													 'feccrea'=>general::formato_fecha_FORM2DB($hoy),		
													 'usrcrea'=>'Despacho')
	 											));	
	}

	$L_gde_enc=$ListEnc;
	$ListDetOe->gofirst();	
	/*Para generar el encabezado de la Factura*/
	if ($flujo==4){
		$ListEncFct = new connlist(new dtodocumento(array('id_tipodocumento'=>1,
													'id_tipoorigen'=> 3,
													 'tipoorigen'=> 'OE',				
													 'sigtipodoc'=>'FCT',
													 'numorigen'=>$id_ordenent,
													 'numdocumento'=>$enc[1],
													 'numdocrefop'=>$enc[3],		
													 'fechadocumento'=>$enc[2],		
													 'codigovendedor'=>$ListEncOe->getelem()->codigovendedor,
													 'rutcliente'=>$ListEncOe->getelem()->rutcliente,
													 'razonsoc'=>$ListEncOe->getelem()->razonsoc,
													 'giro'=>$ListEncOe->getelem()->giro,
													 'direccion'=>$ListEncOe->getelem()->direccion,
													 'comuna'=>$ListEncOe->getelem()->comuna,
													 'iva'=>$ListEncOe->getelem()->iva,
													 'condicion'=>$ListEncOe->getelem()->condicion,
													 'diascondicion'=>$ListEncOe->getelem()->diascondicion,
													 'fonocontacto'=>$ListEncOe->getelem()->fonocontacto,
													 'observaciones'=>$ListEncOe->getelem()->observaciones,
													 'nota'=>$ListEncOe->getelem()->nota,
													 'codlocalventa'=>$ListEncOe->getelem()->codlocalventa,
													 'codlocalcsum'=>$ListEncOe->getelem()->codlocalcsum,
													 'feccrea'=>general::formato_fecha_FORM2DB($hoy),		
													 'usrcrea'=>'Despacho')
	 											));		
	}	
	$L_fac_enc=$ListEncFct;
	return true;
}

/*****************************************************************
 * FUNCIONES : Llena_Det llena el detalle de un documento GDE o FCT
******************************************************************/
function Llena_Det($fecguia,$numguia,$codsap,$descriprod,$unimed,$cantidad,$linea,$Listop){
	$Listop->gofirst();
	$id_ordenent=$Listop->getelem()->id_ordenent;
	/*buscar con la linea y la orden el id_lineadoc */
	/*bizcve::getdetordenpick($Listdetpick = new connlist(new dtodetordenpicking(
									  array('id_linea'=>$linea,'id_ordenpicking'=>$idordenpick))));	
	$Listdetpick->gofirst();*/
	//general::writeevent('linea doc OE '.$linea);/
	$idlineaoe=$linea;
	/*para obtener el detalle de la OE*/
	bizcve::getdetordenent($ListDet = new connlist(new dtodetordenent(array('id_ordenent'=>$id_ordenent,'id_linea'=>$idlineaoe))));		

	//bizcve::getordenent($ListEncOe = new connlist(new dtoencordenent(array('id_ordenent'=>$id_ordenent))), $ListDet = new connlist);	
	$ListDet->gofirst();
		if (!$ListDet->isvoid()) {
			do {
			    $arreglo[$ListDet->getelem()->codprod]=$ListDet->getelem();
			} while ($ListDet->gonext());
		}
	$listdetlocal = new connlist;
	$prodcant = new dtodetordenent();
	$listdetlocal->addlast($arreglo[$codsap]);
	$listdetlocal->gofirst();
	$hoy=DATE('d/m/Y');
	$list    = new connlist;	
	$det_doc = new dtodetdocumento(array('descripcion'=>$descriprod,
												'codprod'=>$codsap,
												'cantidad'=>$cantidad,
												'pcosto'=>$listdetlocal->getelem()->pcosto,
												'pventaneto'=>$listdetlocal->getelem()->pventaneto,
												'pventaiva'=>$listdetlocal->getelem()->pventaiva,
												'totallinea'=>($cantidad*($listdetlocal->getelem()->pventaneto)),
												'unimed'=>$listdetlocal->getelem()->unimed,
												'usrcrea'=>'Despacho',
												'feccrea'=>general::formato_fecha_FORM2DB($hoy)
												));		
	$list->addlast($det_doc);
    return $list;
}
/*********************************/


/*********************************************************
Crea la instancia nueva para el server
*********************************************************/

// nos conectamos a la base de datos
$conect = new database();
$conect->tep_db_connect();

//invoca libreria nusoap
require_once('lib/nusoap.php');
//general::writeevent("carga libreria NUSOAP ...");

// Crea la instancia nueva para el server
$server = new soap_server;

//general::writeevent("crea instancia soap_server ...");
$server->configureWSDL('wscve', 'urn:wscve');

// Register the method to expose
$server->register('EnviaOd_cve',      // method name
    array('cons' => 'xsd:string'),    // input parameters
    array('resp' => 'xsd:string'),    // output parameters
    'urn:wscve',                      // namespace
    'urn:wscve#EnviaOd_cve',          // soapaction
    'rpc',                            // style
    'encoded',                        // use
    'Vea el manual'        // documentation
);

//general::writeevent("registra funcion NUEVA_COTIZACION para instancia WDSL ...");

/*********************************************************
/*MES REGISTRADOS como WEBSERVICEs*/
/*********************************************************/

function EnviaOd_cve($cons,&$msg) {
    $enc = array() ;
	//libxml_use_internal_errors(true);
	$xmlObj = new SimpleXMLParser;
	
	if (($xml = $xmlObj->Parse($cons, "main"))==""){
		return func_error("C00","tag MAIN vacio","");	
	}	
	//HEADER
	if (($xmlheader = $xmlObj->Parse($xml, "header"))==""){
		return func_error("CH0","tag HEADER vacio",$xmlheader);
	}
	if (($fecha = $xmlObj->Parse($xmlheader, "fecha"))==""){
		return func_error("CH1","tag FECHA en el header, vacio",$xmlheader);
	}
	if (($hora = $xmlObj->Parse($xmlheader, "hora"))==""){
		return func_error("CH2","tag HORA en el header, vacio",$xmlheader);	
	}
	if (($operador = $xmlObj->Parse($xmlheader, "operador"))==""){
		return func_error("CH3","tag OPERADOR en el header, vacio",$xmlheader);	
	}
	if (($sistema = $xmlObj->Parse($xmlheader, "sistema"))==""){
		return func_error("CH4","tag SISTEMA en el header, vacio",$xmlheader);	
	}
	if ($sistema!="Centro Despacho"){
		return func_error('CHX', "tag SISTEMA:[$sistema] no es el sistema esperado [centro proy]", $xmlheader);
	}
	//	$xmlheader = ereg_replace("req" ,"resp",$xmlheader);

	//DATA
	if (($xmldata = $xmlObj->Parse($xml, "data"))==""){
		return func_error("CD0","tag DATA vacio",$xmlheader);
	}
	// ENCABEZADO
	if (($xmlencabezado = $xmlObj->Parse($xmldata, "encabezado"))==""){
		return func_error("CD1","tag ENCABEZADO vacio",$xmlheader);
	}
	if (($enc[0] = $xmlObj->Parse($xmlencabezado, "idDespacho"))==""){
		return func_error("CE1","tag IDDESPACHO en el header, vacio",$xmlheader);	
	}
	if (($enc[0] = $xmlObj->Parse($xmlencabezado, "idDespacho"))!=""){
		$idDespacho=$enc[0];
	}
	if (($enc[1] = $xmlObj->Parse($xmlencabezado, "enumguia"))==""){
		return func_error("CE2","tag enumguia en el header, vacio",$xmlheader);	
	}
	if (($enc[1] = $xmlObj->Parse($xmlencabezado, "enumguia"))!=""){
		$numguia=$enc[1];
	}	
	if (($enc[2] = $xmlObj->Parse($xmlencabezado, "efecguia"))==""){
		return func_error("CE3","tag efecguia en el header, vacio",$xmlheader);	
	}	
	if (($enc[3] = $xmlObj->Parse($xmlencabezado, "op_id"))==""){
		return func_error("CE4","tag OP_ID en el header, vacio",$xmlheader);	
	}
	if (($enc[3] = $xmlObj->Parse($xmlencabezado, "op_id"))!=""){
		$idordenpick=$enc[3];
	}
	if (($enc[4] = $xmlObj->Parse($xmlencabezado, "usrcrea"))==""){
		return func_error("CE5","tag USRCREA en el header, vacio",$xmlheader);	
	}
	if (($enc[5] = $xmlObj->Parse($xmlencabezado, "msgod"))==""){
		return func_error("CE6","tag MSGOD en el header, vacio",$xmlheader);	
	}
	$msgcerrar=$enc[5];
	//ITEMS
	if (($xmlitems = $xmlObj->Parse($xml, "items"))==""){
		return func_error("CD2","tag DATA vacio",$xmlheader);
	}
	//Revisa numero de productos
	if (($maxProduct = $xmlObj->MaxElements($xmlitems, "producto"))==0){
		return func_error("CD3","XML sin productos",$xmlheader);   
	}
	$i=0;
	while($i<$maxProduct){
		if (($xmlProduct = $xmlObj->Parse($xmldata, "producto",$i))==""){
			return func_error("CP0","tag PRODUCT[$i] en la data, vacio",$xmlheader);
		}
		/*if (($prd[$i]['id_linea'] = $xmlObj->Parse($xmlProduct, "id_linea"))==""){
			return func_error("CP1","<id_linea> de producto[$i] en el data, vacio",$xmlheader);	
		}*/
		if (($prd[$i]['fecguia'] = $xmlObj->Parse($xmlProduct, "fecguia"))==""){
			return func_error("CP1","<fecguia> de producto[$i] en el data, vacio",$xmlheader);	
		}
		if (($prd[$i]['numguia'] = $xmlObj->Parse($xmlProduct, "numguia"))==""){
			return func_error("CP2","<numguia> de producto[$i] en el data, vacio",$xmlheader);
		}
		if (($prd[$i]['codsap'] = $xmlObj->Parse($xmlProduct, "codsap"))==""){
			return func_error("CP3","<codsap> de producto[$i] en el data, vacio",$xmlheader);
		}
		if (($prd[$i]['descriprod'] = $xmlObj->Parse($xmlProduct, "descriprod"))==""){
			return func_error("CP4","<descriprod> de producto[$i] en el data, vacio",$xmlheader);
		}
		if (($prd[$i]['cantidad'] = $xmlObj->Parse($xmlProduct, "cantidad"))==""){
			return func_error("CP5","<CANTIDAD> de producto[$i] en el data, vacio",$xmlheader);
		}
		if (($prd[$i]['estrecepcion'] = $xmlObj->Parse($xmlProduct, "estrecepcion"))==""){
			return func_error("CP6","<estrecepcion> de producto[$i] en el data, vacio",$xmlheader);
		}
		if (($prd[$i]['id_lineaop'] = $xmlObj->Parse($xmlProduct, "id_lineaop"))==""){
			return func_error("CP7","<id_lineaop> de producto[$i] en el data, vacio",$xmlheader);
		}		
		$lineas[$i]=$prd[$i]['id_lineaop'];
		//el producto no se verifica en este sistema
		//general::writeevent("EnviaOd_cve :linea $i :  id_lineaop= ".$lineas[$i]);
		//general::writeevent("EnviaOd_cve :PRODUCTO $i :  id_lineaop= ".$prd[$i]['id_lineaop']."numguia= ".$prd[$i]['numguia']." fecguia= ".$prd[$i]['fecguia']."- codsap= ".$prd[$i]['codsap']."- descriprod=".$prd[$i]['descriprod']." - cantidad=".$prd[$i]['cantidad']." - estrecepcion=".$prd[$i]['estrecepcion']);
		$i++;
	}
	
	/*para obtener datos faltantes*/
	bizcve::getordenpick($Listop = new connlist(new dtoencordenpicking(array('id_ordenpicking'=>$idordenpick))), null);
	$Listop->gofirst();
	$id_ordenent=$Listop->getelem()->id_ordenent;
	/*para obtener el tipo de pago*/	
	bizcve::getordenent($ListEOe = new connlist(new dtoencordenent(array('id_ordenent'=>$id_ordenent))),$ListDOe= new connlist);
	$ListEOe->gofirst();
	$idtipopago   =$ListEOe->getelem()->id_tipopago;
	$idflujo      =$ListEOe->getelem()->id_tipoflujo;	
	//$ListDOe->gofirst();
	//$id_documentof=$ListDOe->getelem()->id_documentof;

	bizcve::getdetordenpick($ListEp = new connlist(new dtodetordenpicking(array('id_ordenpicking'=>$idordenpick))));		
	$ListEp->gofirst();
	$id_lineadoc   =$ListEp->getelem()->id_lineadoc;	
	//general::writeevent('idlineadoc' . $id_lineadoc.' orden ent '. $id_ordenent.' OP '.$idordenpick.' pago '.$idtipopago .' fluj '.$idflujo.' docfac '.$id_documentof);
	
	/***************************************************/
	//GENERA ENCABEZADO DOCUMENTO
	Llena_Enc($enc,&$L_gde_enc,&$L_fac_enc,$Listop);
	if(!$L_gde_enc){
    	return func_error("CD4","No es posible llenar el encabezado del documento GDE",$xmlheader,$msg);
	}
	if($L_fac_enc){
		$L_fac_enc->gofirst();
	}
	
  //autocommit = 0;
  //tep_db_query("set autocommit=0");
  //GENERA DETALLE DE RETORNO X CADA PRODUCTO 
	$i=0;
	$listdetdoc = new connlist();
				
	while($i<$maxProduct){
		$obj=new dtodetdocumento();
		$List_det_doc=Llena_Det(						
							$prd[$i]['fecguia'],
							$prd[$i]['numguia'],
							$prd[$i]['codsap'],
							$prd[$i]['descriprod'],
							$prd[$i]['unimed'], 
							$prd[$i]['cantidad'],
							$prd[$i]['id_lineaop'],$Listop);
		$i++;
    	$List_det_doc->gofirst();		
		if (!$List_det_doc->isvoid()) {
			do {
			  $obj->descripcion = $List_det_doc->getelem()->descripcion;	
			  $obj->codprod     = $List_det_doc->getelem()->codprod;				  
			  $obj->cantidad    = $List_det_doc->getelem()->cantidad;
			  $obj->pcosto      = $List_det_doc->getelem()->pcosto;			  
			  $obj->pventaneto  = $List_det_doc->getelem()->pventaneto;
			  $obj->pventaiva   = $List_det_doc->getelem()->pventaiva;
			  $obj->totallinea  = $List_det_doc->getelem()->totallinea;			  			  			  			  
			  $obj->unimed      = $List_det_doc->getelem()->unimed;	
			  $obj->usrcrea     = $List_det_doc->getelem()->usrcrea;				  
			  $listdetdoc->addlast($obj);
			} while ($List_det_doc->gonext());
		}		
	  }
	if($L_gde_enc){
    	$L_gde_enc->gofirst();		
		if ($idflujo==3){
			//general::writeevent('idlineadoc' . $id_lineadoc.' orden ent '. $id_ordenent.' OP '.$idordenpick.' pago '.$idtipopago .' fluj '.$idflujo.' docfac '.$id_documentof);
			/*busco el detalle de la orden de entrega*/
			bizcve::getdetordenent($ListDet = new connlist(new dtodetordenent(array('id_ordenent'=>$id_ordenent,'id_linea'=>$id_lineadoc))));				
	    	$ListDet->gofirst();	
			$ListDet->getelem()->id_documentof;
			//general::writeevent('documento' .$ListDet->getelem()->id_documentof);
			$L_gde_enc->getelem()->numdocref=$ListDet->getelem()->id_documentof;			
		}
		$valor=bizcve::putdocumento($L_gde_enc ,$listdetdoc );		
		$id_documentogde=$L_gde_enc->getelem()->id_documento;
		$numdocumento=$L_gde_enc->getelem()->numdocumento;		
		general::inserta_tracking( null,$id_ordenent,$idordenpick, $id_documentogde, "La Orden de picking $idordenpick genero la OD $idDespacho en el sistema de Despacho a Domicilio y se ha generado la Guia de despacho $id_documentogde (numero de folio $numdocumento) en el sistema CVE",'SYS', 'Despacho');			
		if (!$valor){ 
			 return func_error("CD4","No fue posible insertar la GDE",$xmlheader,$msg);		
		}
	}
	/* Si viene el encabezado para la factura */
	if($L_fac_enc){
    	$L_fac_enc->gofirst();
	    $L_fac_enc->getelem()->numdocumento=0;
	    $L_fac_enc->getelem()->numdocref=$id_documentogde;
		$valorfac=bizcve::putdocumento($L_fac_enc ,$listdetdoc );
    	$L_fac_enc->gofirst();
		$id_documentofct=$L_fac_enc->getelem()->id_documento;

		/*entra si el tipo de pago es crédito, si es contado no reserva disponible*/
		if ($idtipopago!=2){
			/*Para reservar el disponible*/
			$CtrlOe = new ctrlordenent;
			$CtrlOe->reservadisponible($listres =new connlist(
			new dtoencordenent(array('rutcliente'=> $L_fac_enc->getelem()->rutcliente,
									'monto'=> $L_fac_enc->getelem()->totalnumiva, 
									'id_ordenent'=> $L_fac_enc->getelem()->numorigen, 
			  						'id_documento'=> $L_fac_enc->getelem()->id_documento
									))));		
			/*llama a la funcion que hace la rebaja del disponible*/						
			$Ctrl = new ctrlinfocliente;
			$Ctrl->updisponible(new connlist(
			new dtoinfocliente(array('rutcliente'=> $L_fac_enc->getelem()->rutcliente,
									'id_ordenent'=> $L_fac_enc->getelem()->numorigen, 
									'monto'=> $L_fac_enc->getelem()->totalnumiva, 
			  						'id_documento'=> $L_fac_enc->getelem()->id_documento
									))));				
		}				
		general::inserta_tracking( null,$id_ordenent,$idordenpick,$id_documentofct, "La Orden de picking $idordenpick genero la OD $idDespacho en el sistema de Despacho a Domicilio y se ha generado la Factura $id_documentofct en el sistema CVE");					
		if (!$valorfac){
			 return func_error("CD4","No fue posible insertar la FCT ",$xmlheader,$msg);		
		}
	}		

	//commit ok;
	//tep_db_query("commit");
	//tep_db_query("set autocommit=1");
	
	$xmlresp='<?xml version="1.0"?>
	<main>
	<header>'.$xmlheader.'</header>
	<respuesta>
		<status>OK</status>
		<glosastatus>ok</glosastatus>
		<despachoOD>'.$enc[0].'</despachoOD>
		<id_ordenpicking>'.$enc[3].'</id_ordenpicking>
		<msgod>'.$enc[5].'</msgod>
	</respuesta>
	</main>';
	// general::writeevent("EnviaOd_cve : Finaliza con $xmlresp");
	return $xmlresp;
}//EnviaOd_cve

//general::writeevent("Entrega el resultado ...");
// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
//tep_db_close();

?>

