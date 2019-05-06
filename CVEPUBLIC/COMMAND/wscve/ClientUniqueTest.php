<?php
require_once('lib/nusoap.php');

	// Create the client instance
	$client = new soapclient(DIR_WEBSERVICES.'wsdespacho_ps.php?wsdl', true);
	// Check for an error
	$err = $client->getError();
	if ($err) {
		// Display the error
		echo '<p><b>Constructor error: ' . $err . '</b></p>';
		}
	
// Call the SOAP method
//	$result = $client->call('nueva_gd', array('cons' => $xml));
//
//	// chequea error del client
//	if ($client->fault) {
//		echo '<p><b>Fault: ';
//		//print_r($result);
//		echo '</b></p>';
//		return 0;
//		} 
//
//	// error desde el server
//	$err = $client->getError();
//	if ($err) {
//		// Display the error
//		echo '<p><b>Error: ' . $err . '</b></p>';
//		return 0;
//		} 
//
//	//ok despliega resultado
////	print_r($result);
//	$xmlObj = new SimpleXMLParser;
//	$msgerror = $xmlObj->Parse($result, "camposql");
//	
//	if ($msgerror){
//		//writelog('CAMPO SQL ->'.$msgerror);
//		return $msgerror;
//	}
//
//	if (($xml = $xmlObj->Parse($result, "id_despacho"))==""){return 0;	}	
//	writelog("nueva_gd : parsea id_despacho : $xml");
//	return $xml;
//
//	}//function envia_nueva_gd
//
//
//function SearchClient($xml){
//	
//}



?>