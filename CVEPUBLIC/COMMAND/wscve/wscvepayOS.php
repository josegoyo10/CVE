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
$ses_usr_id=173;
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

$XMLerror = '<main><header>'.chr(13).$header.chr(13).'</header><respuesta><status>ERROR</status><camposErr>'.$error_msg.'</camposErr><glosastatus>'.$error_msg.'</glosastatus></respuesta></main>';
general::writeevent("Funcion error : ". $XMLerror);

return $XMLerror; 
}
/*********************************************************
 * FUNCIONES : Llena_Enc llena los datos del encabezado de un documento
*********************************************************/
function Llena_Enc($enc,&$L_gde_enc,&$L_fac_enc,$Listop){
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
//Ingreso de despacho sobre CVE.
general::alert('id_estado =');
		$ListEnc = new connlist(new dtodocumento(array('id_tipodocumento'=> 2,
													 'id_tipoorigen'=> 3,
													 'tipoorigen'=> 'OE',
 													 'sigtipodoc'=>$enc[6],
//													 'id_estado'=>$enc[6],
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
$server->register('PayOSCve',      // method name
    array('cons' => 'xsd:string'),    // input parameters
    array('resp' => 'xsd:string'),    // output parameters
    'urn:wscve',                      // namespace
    'urn:wscve#PayOSCve',          // soapaction
    'document',                            // style
    'literal',                        // use
    'Pruebas de Concepto'        // documentation
);

//general::writeevent("registra funcion NUEVA_COTIZACION para instancia WDSL ...");

/*********************************************************
/*MES REGISTRADOS como WEBSERVICEs*/
/*********************************************************/

function EnviaOd_cve($cons,&$msg) {
   	return "TEST OK";

}//EnviaOd_cve

// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
//tep_db_close();

?>

