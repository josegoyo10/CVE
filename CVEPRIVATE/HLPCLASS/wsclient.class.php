<?php
// Pull in the NuSOAP code
include_once("../../INCLUDE/nusoap/nusoap.php");
include_once("../../INCLUDE/nusoap/simplexml.php");
// Create the client instance
$client = new soapclient(DIR_WEBSERVICES.'wsdespacho_ps.php?wsdl', true);


class wsclient {
///////////////////////// ZONA DE INCLUSION /////////////////////////

function envia_nueva_gd($xml,&$msgerror){
	// Create the client instance
	$client = new soapclient(DIR_WEBSERVICES.'wsdespacho_ps.php?wsdl', true);
	// Check for an error
	$err = $client->getError();
	if ($err) {
		// Display the error
		echo '<p><b>Constructor error: ' . $err . '</b></p>';
		}
	
	// Call the SOAP method
	$result = $client->call('nueva_gd', array('cons' => $xml));

	// chequea error del client
	if ($client->fault) {
		echo '<p><b>Fault: ';
		//print_r($result);
		echo '</b></p>';
		return 0;
		} 

	// error desde el server
	$err = $client->getError();
	if ($err) {
		// Display the error
		echo '<p><b>Error: ' . $err . '</b></p>';
		return 0;
		} 

	//ok despliega resultado
//	print_r($result);
	$xmlObj = new SimpleXMLParser;
	$msgerror = $xmlObj->Parse($result, "camposql");
	if (($xml = $xmlObj->Parse($result, "id_despacho"))==""){return 0;	}	
	general::writeevent("nueva_gd : parsea id_despacho : $xml");
	return $xml;

	}//function envia_nueva_gd

//Display the request and response 
/*echo '<h2>Request</h2>';
echo '<pre>' . $client->request, ENT_QUOTES . '</pre>';
echo '<h2>Response</h2>';
echo '<pre>' . $client->response, ENT_QUOTES . '</pre>';
// Display the debug messages
echo '<h2>Debug</h2>';
echo '<pre>' . $client->debug_str, ENT_QUOTES . '</pre>';*/
}
?>
