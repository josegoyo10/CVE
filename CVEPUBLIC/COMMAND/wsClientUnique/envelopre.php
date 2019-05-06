<?php
require_once('ClientUnique.php');

/*$xmlarchi='<request>
<customer>
		<Source>22</Source>
		<IdCustomer>80184</IdCustomer>
		<IdCategory>3</IdCategory>
		<IdTypeContribuyente>1</IdTypeContribuyente>
		<TypeCustomer>
			<IdTypeCustomer>5</IdTypeCustomer>
		</TypeCustomer>
		<Location>76100001000000</Location>
		<Department>VALLE DEL CAUCA</Department>
		<Province>BOLIVAR</Province>
		<IdDoc>13</IdDoc>
		<FirstName>M</FirstName>
		<Surname1>MM</Surname1>
		<Surname2>MMS</Surname2>
		<Address>DFGDFGDSFG CLL 1 CLL4</Address>		
		<Phone>22332233</Phone>
		<Phone2>1010101010</Phone2>
		<Fax>90909090</Fax>
		<Email>ASDF@SDF.COM</Email>
		<AgeRange>0</AgeRange>
		<Quota>0</Quota>
		<Contact>MM MMS M</Contact>
		<Gender>M</Gender>
		<Occupation></Occupation>
		<ReteIca>true</ReteIca>
		<ReteFuente>true</ReteFuente>
		<ReteIva>true</ReteIva>
		<ExenIva>false</ExenIva>
		<OtrIva>false</OtrIva>
		<State>A</State>
	</customer>	
</request>';*/
//se valida la existencia del cliente en el Web Service
//$response = ClientUnique::createClient($xmlarchi);

$response = ClientUnique::searchById(78456123);

if ($response) {
	print_r ($response);
}
else {
	print "Error.";
} 

?>