<?php
require_once('customsoap.php');
require_once('SimpleXMLParser.php');

class ClientUnique {

	public function searchById($id) {
		$endpoint = "http://172.20.5.73/UniqueClientMMWeb/sca/ClienteUnicoIFExport1";
		$ns="http://ClienteUnicoMediation/intefaces/ClienteUnicoIF";
		
		$client = new CustomSoapSender($endpoint,$ns);
		$response = $client->send("SearchById", 
			'<input1>' . 
				htmlspecialchars("<request><customer><Source>22</Source><IdCustomer>$id</IdCustomer></customer></request>") . 
			'</input1>');
		if (isset($response['output1'])) {
			//print_r "Respuesta ".$response['output1'];
			//general::writeevent("respuesta ws".$response['output1']);
			return SimpleXMLParser::parseSearchXML($response['output1']);
		}
		else {
			return false;
		}
	}
	
	public function createClient($xmlCreate){
		
		$endpoint = "http://172.20.5.73/UniqueClientMMWeb/sca/ClienteUnicoIFExport1";
		$ns="http://ClienteUnicoMediation/intefaces/ClienteUnicoIF";
		
		$client = new CustomSoapSender($endpoint,$ns);
		$response = $client->send("CreateClient", 
			'<input>' . 
				htmlspecialchars($xmlCreate) . 
			'</input>');
		
		if (isset($response['output'])) {
			return $response['output'];
		}
		else {
			return false;
		}
		
	}

			
	public function updateClient($xmlUpdate){
		$endpoint = "http://172.20.5.73/UniqueClientMMWeb/sca/ClienteUnicoIFExport1";
		$ns="http://ClienteUnicoMediation/intefaces/ClienteUnicoIF";
		
		$client = new CustomSoapSender($endpoint,$ns);
		$response = $client->send("UpdateClient", 
			'<input>' . 
				htmlspecialchars($xmlUpdate) . 
			'</input>');
		
		if (isset($response['output'])) {
			//print $response['output'];
			return SimpleXMLParser::parseResponseXML($response['output']);
		}
		else {
			return false;
		}
	}
}
?>