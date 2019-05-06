<?php
require_once('../wsClientUnique/ClientUnique.php'); 
class wsxmlcve{
	/*** atributos ***/
	private $bd = NULL; 


	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }  
    public function __destruct(){
        //$this->bd->close();
    }   
   
	public function wsbuscarcliente($List) {
		
    	
		$List->gofirst();
		$archivoxml='<request>
		<customer>
			<Source></Source>
			<IdCustomer>'.$List->getelem()->rut.'</IdCustomer>
			<CardId></CardId>
			<Bin></Bin>	
			<FirstName></FirstName>	
			<Surname1></Surname1>
			<Surname2></Surname2>
		</customer>
		</request>';
		/*$fch= fopen('C:/AppServ/www/cvecolombia/CVEPRIVATE/XMLCLASS/archivosxmlwsnodisponible/buscar'.date('H_i_s_d_m').'.xml', "a");
		fwrite($fch, $archivoxml);
		fclose($fch);*/ 
		    $response = ClientUnique::searchById($archivoxml);
			
		if ($response) {
			general::writeevent($response [desc]);
		}
		else {
			general::writelog('No se pudo establecer comunicacion con WS ClientUnique,searchById');
		}

	}
    
	public function wscrearcliente($List) {
		
		$confimp = new getidaplicacion("IDENTIFICACION_DE_LA_APLICACION");
		$cod_cve_apli=$confimp->COD_CVE;
		
		$List->gofirst();
		$Listlocalizacion  = new connlist;
		$registrolocalizacion->id_localizacion=$List->getelem()->id_comuna;
		$Listlocalizacion->addlast($registrolocalizacion);
		bizcve::getlocalizacion($Listlocalizacion);
		$Listlocalizacion->gofirst();
		$List->getelem()->id_giro;
		
		if($List->getelem()->rete_iva==1){
			$reteiva='true';
		}
		else{
			$reteiva='false';
		}
		if($List->getelem()->rete_ica==1){
			$reteica='true';
		}
		else{
			$reteica='false';
		}
		if($List->getelem()->rete_renta==1){
			$retefuente='true';
		}
		else{
			$retefuente='false';
		}
		
		
		$archivoxml='<request>
			<customer>
				<Source>'.$cod_cve_apli.'</Source>
				<IdCustomer>'.$List->getelem()->rut.'</IdCustomer>
				<IdCategory>'.(($List->getelem()->id_clasificacion_cli > 0 && $List->getelem()->id_clasificacion_cli < 4)?$List->getelem()->id_clasificacion_cli:'3').'</IdCategory>
				<IdTypeContribuyente>'.$List->getelem()->id_regimencontri.'</IdTypeContribuyente>
				<TypeCustomer>
					<IdTypeCustomer>'.$List->getelem()->id_contribuyente.'</IdTypeCustomer>
				</TypeCustomer>
				<Location>'.$List->getelem()->id_comuna.'</Location>
				<IdDoc>'.$List->getelem()->id_documento_identidad.'</IdDoc>
				<FirstName>'.$List->getelem()->razonsoc.'</FirstName>
				<Surname1> </Surname1>
				<Surname2> </Surname2>
				<Address>'.$List->getelem()->direccion.'</Address>		
				<Phone>'.$List->getelem()->fonocontacto.'</Phone>
				<Phone2>'.$List->getelem()->celcontactoe.'</Phone2>
				<Fax>'.$List->getelem()->fax.'</Fax>
				<Email>'.$List->getelem()->email.'</Email>
				<AgeRange>0</AgeRange>
				<Contact>'.$List->getelem()->apellido.' '.$List->getelem()->apellido1.' '.$List->getelem()->contacto.'</Contact>
				<Gender>'.$List->getelem()->genero.'</Gender>
				<Occupation>'.$List->getelem()->giro.'</Occupation>
				<Profession>'.$List->getelem()->id_profesion.'</Profession>
				<ReteIca>'.$reteica.'</ReteIca>
				<ReteFuente>'.$retefuente.'</ReteFuente>
				<ReteIva>'.$reteiva.'</ReteIva>
				<ExenIva>false</ExenIva>
				<OtrIva>false</OtrIva>
				<State>A</State>
				<CustomerLoyality></CustomerLoyality>
			</customer>	
		</request>';
		
		$response = ClientUnique::createClient($archivoxml);
			
		if ($response) {
			general::writeevent($response [desc]);
		}
		else {
			$fch= fopen('/var/www/html/cvecolombia/CVEPRIVATE/XMLCLASS/archivosxmlwsnodisponible/crear'.date('H_i_s_d_m').'.xml', "a");
			fwrite($fch, $archivoxml);
			fclose($fch);
			general::writelog('No se pudo establecer comunicacion con ClientUnique,createClient');
		}

	}
    
	public function wsupdatecliente($List) {
    	
		$confimp = new getidaplicacion("IDENTIFICACION_DE_LA_APLICACION");
		$cod_cve_apli=$confimp->COD_CVE;
		
		$List->gofirst();
		$Listlocalizacion  = new connlist;
		$registrolocalizacion->id_localizacion=$List->getelem()->id_comuna;
		$Listlocalizacion->addlast($registrolocalizacion);
		bizcve::getlocalizacion($Listlocalizacion);
		$Listlocalizacion->gofirst();
		$List->getelem()->id_giro;
		
		
		if($List->getelem()->rete_iva==1){
			$reteiva='true';
		}
		else{
			$reteiva='false';
		}
		if($List->getelem()->rete_ica==1){
			$reteica='true';
		}
		else{
			$reteica='false';
		}
		if($List->getelem()->rete_renta==1){
			$retefuente='true';
		}
		else{
			$retefuente='false';
		}
		
		
		$archivoxml='<request>
			<customer>
				<Source>'.$cod_cve_apli.'</Source>
				<IdCustomer>'.$List->getelem()->rut.'</IdCustomer>
				<IdCategory>'.(($List->getelem()->id_clasificacion_cli > 0 && $List->getelem()->id_clasificacion_cli < 4)?$List->getelem()->id_clasificacion_cli:'3').'</IdCategory>
				<IdTypeContribuyente>'.$List->getelem()->id_regimencontri.'</IdTypeContribuyente>
				<TypeCustomer>
					<IdTypeCustomer>'.$List->getelem()->id_contribuyente.'</IdTypeCustomer>
				</TypeCustomer>
				<Location>'.$List->getelem()->id_comuna.'</Location>
				<IdDoc>'.$List->getelem()->id_documento_identidad.'</IdDoc>
				<FirstName>'.$List->getelem()->razonsoc.'</FirstName>
				<Surname1> </Surname1>
				<Surname2> </Surname2>
				<Address>'.$List->getelem()->direccion.'</Address>		
				<Phone>'.$List->getelem()->fonocontacto.'</Phone>
				<Phone2>'.$List->getelem()->celcontactoe.'</Phone2>
				<Fax>'.$List->getelem()->fax.'</Fax>
				<Email>'.$List->getelem()->email.'</Email>
				<AgeRange>0</AgeRange>
				<Contact>'.$List->getelem()->apellido.' '.$List->getelem()->apellido1.' '.$List->getelem()->contacto.'</Contact>
				<Gender>'.$List->getelem()->genero.'</Gender>
				<Occupation>'.$List->getelem()->giro.'</Occupation>
				<Profession>'.$List->getelem()->id_profesion.'</Profession>
				<ReteIca>'.$reteica.'</ReteIca>
				<ReteFuente>'.$retefuente.'</ReteFuente>
				<ReteIva>'.$reteiva.'</ReteIva>
				<ExenIva>false</ExenIva>
				<OtrIva>false</OtrIva>
				<State>A</State>
				<CustomerLoyality></CustomerLoyality>
			</customer>	
		</request>';
		
		   file_put_contents('UpdateClientesDirWs.txt', print_r($archivoxml,true));
		    $response = ClientUnique::updateClient($archivoxml);

			
		if ($response) {
			general::writeevent($response [desc]);
		}
		else {
			$fch= fopen('/var/www/html/cvecolombia/CVEPRIVATE/XMLCLASS/archivosxmlwsnodisponible/update'.date('H_i_s_d_m').'.xml', "a");
			fwrite($fch, $archivoxml);
			fclose($fch);
			general::writelog('No se pudo establecer comunicacion con WS ClientUnique,updateClient');
		}
    }
    
    public function wsXMLRealInventory($List){
    	$List->gofirst();
    	$xml = "<request>
					<inventory>
						<ean>".$List->getelem()->barra."</ean>
						<sap>".$List->getelem()->sap."</sap>
						<store>".$List->getelem()->csum."</store>		      
		    		</inventory>
		    	</request>";
    	return $xml;
    }

}
?>