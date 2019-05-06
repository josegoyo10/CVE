<?php

function xml2array($contents, $get_attributes=1, $priority = 'tag') { 
    if(!$contents) return array(); 

    if(!function_exists('xml_parser_create')) { 
        //print "'xml_parser_create()' function not found!"; 
        return array(); 
    } 

    //Get the XML parser of PHP - PHP must have this module for the parser to work 
    $parser = xml_parser_create(''); 
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "ISO-8859-1"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss 
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
    xml_parse_into_struct($parser, trim($contents), $xml_values); 
    xml_parser_free($parser); 

    if(!$xml_values) return;//Hmm... 

    //Initializations 
    $xml_array = array(); 
    $parents = array(); 
    $opened_tags = array(); 
    $arr = array(); 

    $current = &$xml_array; //Refference 

    //Go through the tags. 
    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array 
    foreach($xml_values as $data) { 
        unset($attributes,$value);//Remove existing values, or there will be trouble 

        //This command will extract these variables into the foreach scope 
        // tag(string), type(string), level(int), attributes(array). 
        extract($data);//We could use the array by itself, but this cooler. 

        $result = array(); 
        $attributes_data = array(); 
         
        if(isset($value)) { 
            if($priority == 'tag') $result = $value; 
            else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode 
        } 

        //Set the attributes too. 
        if(isset($attributes) and $get_attributes) { 
            foreach($attributes as $attr => $val) { 
                if($priority == 'tag') $attributes_data[$attr] = $val; 
                else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr' 
            } 
        } 

        //See tag status and do the needed. 
        if($type == "open") {//The starting of the tag '<tag>' 
            $parent[$level-1] = &$current; 
            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag 
                $current[$tag] = $result; 
                if($attributes_data) $current[$tag. '_attr'] = $attributes_data; 
                $repeated_tag_index[$tag.'_'.$level] = 1; 

                $current = &$current[$tag]; 

            } else { //There was another element with the same tag name 

                if(isset($current[$tag][0])) {//If there is a 0th element it is already an array 
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result; 
                    $repeated_tag_index[$tag.'_'.$level]++; 
                } else {//This section will make the value an array if multiple tags with the same name appear together 
                    $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array 
                    $repeated_tag_index[$tag.'_'.$level] = 2; 
                     
                    if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well 
                        $current[$tag]['0_attr'] = $current[$tag.'_attr']; 
                        unset($current[$tag.'_attr']); 
                    } 

                } 
                $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1; 
                $current = &$current[$tag][$last_item_index]; 
            } 

        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />' 
            //See if the key is already taken. 
            if(!isset($current[$tag])) { //New Key 
                $current[$tag] = $result; 
                $repeated_tag_index[$tag.'_'.$level] = 1; 
                if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data; 

            } else { //If taken, put all things inside a list(array) 
                if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array... 

                    // ...push the new element into that array. 
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result; 
                     
                    if($priority == 'tag' and $get_attributes and $attributes_data) { 
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data; 
                    } 
                    $repeated_tag_index[$tag.'_'.$level]++; 

                } else { //If it is not an array... 
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value 
                    $repeated_tag_index[$tag.'_'.$level] = 1; 
                    if($priority == 'tag' and $get_attributes) { 
                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well 
                             
                            $current[$tag]['0_attr'] = $current[$tag.'_attr']; 
                            unset($current[$tag.'_attr']); 
                        } 
                         
                        if($attributes_data) { 
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data; 
                        } 
                    } 
                    $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken 
                } 
            } 

        } elseif($type == 'close') { //End of tag '</tag>' 
            $current = &$parent[$level-1]; 
        } 
    } 
     
    return($xml_array); 
}



class WebserviceOracleSAPOnline
{
	function ObtenerStockProducto($productos_input, $centro_id, $almacen_id, $productos_input_unimed)
  	{
	    $xmlProductos = '';
	    for( $j = 0; $j < count($productos_input); $j++)
	    {
	    	$xmlProductos .= '
	    	<stoc:ItemStockReference>
	    		<stoc1:SellersItemIdentificationReference>
	    			<urn:ID>'.$productos_input[$j].'</urn:ID>
	    			<urn1:MeasurementDimension>
	    				<urn:Measure unitCode="'.$productos_input_unimed[$j].'"></urn:Measure>
    				</urn1:MeasurementDimension>
	    		</stoc1:SellersItemIdentificationReference>
	    	</stoc:ItemStockReference>
	    	';
	    }
	    
	    // hacer una consulta de stock de producto
	    $xml = '<soapenv:Envelope
				xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
				xmlns:stoc="http://xmlns.cencosud.corp/Core/EBM/StockInquiry"
				xmlns:ebm="http://xmlns.cencosud.corp/Core/EBM/Common/EBM"
				xmlns:sap="http://xmlns.cencosud.corp/Core/EBM/Common/SapControlData"
				xmlns:urn="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
				xmlns:stoc1="http://xmlns.cencosud.corp/Core/EBO/Cencosud/StockInquiry"
				xmlns:urn1="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
	    <soapenv:Header/>
	    <soapenv:Body>
	    	<stoc:QueryStockEBM>
	    		<ebm:EBMHeader>
					<ebm:EBMID>id</ebm:EBMID>
					<ebm:Sender>
						<ebm:Application>CVE</ebm:Application>
						<ebm:Country>CO</ebm:Country>
						<ebm:ApplicationModule>desc</ebm:ApplicationModule>
						<ebm:CallingServiceName>desc</ebm:CallingServiceName>
						<ebm:BusinessUnit>HC</ebm:BusinessUnit>
					</ebm:Sender>
				</ebm:EBMHeader>
	    		<stoc:DataArea>
	    			<stoc:QueryStock>
	    				<stoc:PlantPartyId>
	    					<urn:ID>'.$centro_id.'</urn:ID>
	    				</stoc:PlantPartyId>
	    				<stoc:StorageLocationPartyId>
	    					<urn:ID>'.$almacen_id.'</urn:ID>
	    				</stoc:StorageLocationPartyId>
	    				'.$xmlProductos.'
	    			</stoc:QueryStock>
	    		</stoc:DataArea>
	    	</stoc:QueryStockEBM>
	    </soapenv:Body>
	    </soapenv:Envelope>';
	    
	    $soap_do = curl_init();
	    curl_setopt($soap_do, CURLOPT_URL,            $_SESSION["CONFIG"]->getValue('WEBSERVICES', 'CONSULTA_STOCK_PRODUCTO') );
	    curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
	    curl_setopt($soap_do, CURLOPT_TIMEOUT,        10);
	    curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
	    curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
	    curl_setopt($soap_do, CURLOPT_POST,           true );
	    curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $xml);
	    $headers = array(
	    "Content-type: text/xml;charset=\"utf-8\"",
	    "Accept: text/xml",
	    "Cache-Control: no-cache",
	    "Pragma: no-cache",
	    "SOAPAction: \"run\"",
	    "Content-length: ".strlen($xml),
		);
		
		curl_setopt($soap_do, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($soap_do);
		if( $response === false)
		{
			curl_close($soap_do);
			return false;
		}
		else
		{
			curl_close($soap_do);
		}
		
		$responseArray = xml2array($response);
		
		// Me fijo si se consultaron multiples productos o uno solo
		if( array_key_exists('0', $responseArray['soapenv:Envelope']['soapenv:Body']['stoc:QueryStockResponseEBM']['stoc:DataArea']['stoc:QueryStockResponse']['stoc1:ItemStockReference']) )
		{
			// Multiples productos
			for($i = 0; $i < count($responseArray['soapenv:Envelope']['soapenv:Body']['stoc:QueryStockResponseEBM']['stoc:DataArea']['stoc:QueryStockResponse']['stoc1:ItemStockReference']); $i++)
			{
				$productos[$i]['unidad'] = $responseArray['soapenv:Envelope']['soapenv:Body']['stoc:QueryStockResponseEBM']['stoc:DataArea']['stoc:QueryStockResponse']['stoc1:ItemStockReference'][$i]['stoc1:ItemStockQuantity']['stoc1:Quantity_attr']['unitCode'];
				$productos[$i]['stock'] = (integer)$responseArray['soapenv:Envelope']['soapenv:Body']['stoc:QueryStockResponseEBM']['stoc:DataArea']['stoc:QueryStockResponse']['stoc1:ItemStockReference'][$i]['stoc1:ItemStockQuantity']['stoc1:Quantity'];
				$productos[$i]['producto_sap_id'] = (integer)$responseArray['soapenv:Envelope']['soapenv:Body']['stoc:QueryStockResponseEBM']['stoc:DataArea']['stoc:QueryStockResponse']['stoc1:ItemStockReference'][$i]['stoc1:SellersItemIdentificationReference']['ID'];
			}
		}
		else
		{
			// Un producto
			$productos[0]['unidad'] = $responseArray['soapenv:Envelope']['soapenv:Body']['stoc:QueryStockResponseEBM']['stoc:DataArea']['stoc:QueryStockResponse']['stoc1:ItemStockReference']['stoc1:ItemStockQuantity']['stoc1:Quantity_attr']['unitCode'];
			$productos[0]['stock'] = (integer)$responseArray['soapenv:Envelope']['soapenv:Body']['stoc:QueryStockResponseEBM']['stoc:DataArea']['stoc:QueryStockResponse']['stoc1:ItemStockReference']['stoc1:ItemStockQuantity']['stoc1:Quantity'];
			$productos[0]['producto_sap_id'] = (integer)$responseArray['soapenv:Envelope']['soapenv:Body']['stoc:QueryStockResponseEBM']['stoc:DataArea']['stoc:QueryStockResponse']['stoc1:ItemStockReference']['stoc1:SellersItemIdentificationReference']['ID'];
		}
		
		// Guardo el mensaje devuelto por sap 
		if ($responseArray['soapenv:Envelope']['soapenv:Body']['stoc:QueryStockResponseEBM']['ebm:ReturnCode'] != 0) {
			$productos['error'] = $responseArray['soapenv:Envelope']['soapenv:Body']['stoc:QueryStockResponseEBM']['ebm:ErrorDetail']['ebm:SourceErrorMessage'];
		}
		else {
			$productos['error'] = $responseArray['soapenv:Envelope']['soapenv:Body']['stoc:QueryStockResponseEBM']['ebm:ReturnMessage'];
		}
		
		return $productos;
	}
	
	
	function ObtenerCreditoCliente($rut, $sociedad = 'CO03') {
		$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cred="http://xmlns.cencosud.corp/Core/EBM/CreditLimit" xmlns:ebm="http://xmlns.cencosud.corp/Core/EBM/Common/EBM" xmlns:sap="http://xmlns.cencosud.corp/Core/EBM/Common/SapControlData">
		<soapenv:Header/>
		<soapenv:Body>
			<cred:QueryCreditLimitEBM>
				<ebm:EBMHeader>
					<ebm:EBMID>?</ebm:EBMID>
				</ebm:EBMHeader>
				<cred:DataArea>
					<cred:QueryCreditLimit>
						<cred:PartyIdNumber idType="'.$rut.'"></cred:PartyIdNumber>
						<cred:PartyCompanyId>'.$sociedad.'</cred:PartyCompanyId>
						<cred:CreditLimitCurrencyId></cred:CreditLimitCurrencyId>
					</cred:QueryCreditLimit>
				</cred:DataArea>
			</cred:QueryCreditLimitEBM>
		</soapenv:Body>
		</soapenv:Envelope>';
		
		$soap_do = curl_init();
		curl_setopt($soap_do, CURLOPT_URL,            $_SESSION["CONFIG"]->getValue('WEBSERVICES', 'CONSULTA_CREDITO_CLIENTE'));
		curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($soap_do, CURLOPT_TIMEOUT,        10);
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($soap_do, CURLOPT_POST,           true );            
		curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $xml);     
		$headers = array(             
			"Content-type: text/xml; charset=\"utf-8\"", 
			"Accept: text/xml", 
			"Cache-Control: no-cache", 
			"Pragma: no-cache", 
			"SOAPAction: \"run\"", 
			"Content-length: ".strlen($xml),
		);         
		curl_setopt($soap_do, CURLOPT_HTTPHEADER, $headers); 
	    
		$response = curl_exec($soap_do);
		$err = curl_error($soap_do);
		if ($response === false) {                
			curl_close($soap_do);
			return false;
		}
		else {
			curl_close($soap_do); 
		}
		
		$responseArray = xml2array($response);
		
		$credito['fecha_vencimiento'] = $responseArray['soapenv:Envelope']['soap-env:Body']['cred:QueryCreditLimitResponseEBM']['cred:DataArea']['cred:QueryCreditLimitResponse']['cred1:CreditLimitDueDate'];
		$credito['limite_credito'] = $responseArray['soapenv:Envelope']['soap-env:Body']['cred:QueryCreditLimitResponseEBM']['cred:DataArea']['cred:QueryCreditLimitResponse']['cred1:CreditLimitAmountInCompanyCurrency_attr']['currencyID'];
		//$credito['limite_disponible'] = $responseArray['soapenv:Envelope']['soap-env:Body']['cred:QueryCreditLimitResponseEBM']['cred:DataArea']['cred:QueryCreditLimitResponse']['cred1:RemainingCreditLimitInCompanyCurrency_attr']['currencyID'];
		$credito['limite_disponible'] = $responseArray['soapenv:Envelope']['soap-env:Body']['cred:QueryCreditLimitResponseEBM']['cred:DataArea']['cred:QueryCreditLimitResponse']['cred1:CreditLimitAmountInCompanyCurrency_attr']['currencyID'];
		$credito['numero_dias_morosidad'] = $responseArray['soapenv:Envelope']['soap-env:Body']['cred:QueryCreditLimitResponseEBM']['cred:DataArea']['cred:QueryCreditLimitResponse']['cred1:AgingDelinquencyDays'];
		$credito['error'] = $responseArray['soapenv:Envelope']['soap-env:Body']['cred:QueryCreditLimitResponseEBM']['ebm:ReturnMessage'];
		
		if (isset($responseArray['soapenv:Envelope']['soap-env:Body']['cred:QueryCreditLimitResponseEBM']['cred:DataArea']['cred:QueryCreditLimitResponse']['cred1:LockedCreditLimtitFlag']) ) {   
			if (is_array($responseArray['soapenv:Envelope']['soap-env:Body']['cred:QueryCreditLimitResponseEBM']['cred:DataArea']['cred:QueryCreditLimitResponse']['cred1:LockedCreditLimtitFlag'])) {    
				$credito['bloqueo_sap'] = 0;
			}
			else {
				$credito['bloqueo_sap'] = 1;
			}
		}
		else {     
			$credito['bloqueo_sap'] = 0;
		}
		 
		if (isset($responseArray['soapenv:Envelope']['soap-env:Body']['cred:QueryCreditLimitResponseEBM']['cred:DataArea']['cred:QueryCreditLimitResponse']['cred1:DelinquencyFlag'])) { 
			if (is_array($responseArray['soapenv:Envelope']['soap-env:Body']['cred:QueryCreditLimitResponseEBM']['cred:DataArea']['cred:QueryCreditLimitResponse']['cred1:DelinquencyFlag'])) {   
				$credito['bloqueo_moroso'] = 0;
			}
			else {
				$credito['bloqueo_moroso'] = 1;
			}
		}
		else {
			$credito['bloqueo_moroso'] = 0;
		}
		        
		return $credito;
	}
}

?>