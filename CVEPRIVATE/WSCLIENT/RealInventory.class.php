<?php
require_once('wsRealInventory/customsoap.php');
require_once('SimpleXMLParser/SimpleXMLParserRealInventory.php');

class RealInventory {

	public function searchInventoryById($xml) {
		$endpoint = "http://172.20.5.73/StockOnLineWeb/sca/StockOnLineExport1";
		$ns="http://co.com.easy.stockonline.interfaces";
		
		$client = new CustomSoapSenderRI($endpoint,$ns);
		$response = $client->sendMessage("SearchRealInventoryByCode", 
		"<request1>" .
		htmlspecialchars($xml)
		. "</request1>");

		if (isset($response)) {			
			return SimpleXMLParserRI::parseSearchInventoryXML($response['response1']);
		}
		else {
			return false;
		}
		
		return $response;
	}

	
}
?>
