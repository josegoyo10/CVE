<?php
require_once('ServiciosWeb/customsoap.php');
require_once('ServiciosWeb/SimpleXMLParser.php');

class Fletes {

//	var $endpoint = "http://172.20.5.73/CalculoFleteMMWeb/sca/CalculoFleteMediationIFExport1";
//	var $ns = "http://CalculoFleteMediation/intefaces/CalculoFleteMediationIF";
	//var $endpoint = "http://172.20.4.64:9080/CalculoFleteMMWeb/sca/CalculoFleteMediationIFExport1";

	var $endpoint = "http://172.20.5.73/CalculoFleteMMWeb/sca/CalculoFleteMediationIFExport1";
	var $ns = "http://CalculoFleteMediation/intefaces/CalculoFleteMediationIF";	
	
	public function calcular($xmlFlete){
		
		$client = new CustomSoapSender($this->endpoint, $this->ns);
                file_put_contents('calcular_xmlFlete_cve_co.txt', $xmlFlete);
		$response = $client->send("CalcularFlete", 
			'<request>' . 
				$xmlFlete. 
			'</request>');
                
                                
		if (isset($response['response'])) {
			return $response['response'];
		}
		else {
			return false;
		}
		
	}

}
?>