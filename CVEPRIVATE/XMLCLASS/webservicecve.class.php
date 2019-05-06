<?php

class webservicecve{

	public function ws_Inventory_Real($List){

		$XML_Inventory=wsxmlcve::wsXMLRealInventory($List);
		$Response_Inventory_Real=RealInventory::searchInventoryById($XML_Inventory);
		return $Response_Inventory_Real;
	}
}
?>