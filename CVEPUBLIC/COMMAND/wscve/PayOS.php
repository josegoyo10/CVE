<?php
include_once("../../../CVEPUBLIC/INCLUDE/ini.php");
include_once("../../../CVEPUBLIC/INCLUDE/autoload.php");
include_once("../wsClientUnique/SimpleXMLParser.php");

$input = $_GET['xmlinput'];
$xml="<input>
    <encabezado>
    <os>227000000093</os>
    <id>900186400</id>
    <numfactura>177</numfactura>
    </encabezado>
    <mediopago>
      <idmedio>11</idmedio>
    </mediopago>
    <mediopago>
      <idmedio>41</idmedio>
    </mediopago>
    <productos><precio>17.0</precio><cantidad>20600</cantidad><ean>209000007150</ean></productos>
    <productos><precio>18000.0</precio><cantidad>100</cantidad><ean>209000007106</ean></productos>
    <productos><precio>22350.0</precio><cantidad>2100</cantidad><ean>770732382060</ean></productos>
    <productos><precio>244900.0</precio><cantidad>200</cantidad><ean>770704810019</ean></productos>
    <productos><precio>9550.0</precio><cantidad>1600</cantidad><ean>770727811038</ean></productos>
    <productos><precio>29100.0</precio><cantidad>900</cantidad><ean>770732382323</ean></productos>
    <productos><precio>25800.0</precio><cantidad>900</cantidad><ean>770732382425</ean></productos>
    <productos><precio>35898.0</precio><cantidad>400</cantidad><ean>770115425095</ean></productos>
    <productos><precio>17300.0</precio><cantidad>1100</cantidad><ean>770723984087</ean></productos>
    <productos><precio>18500.0</precio><cantidad>100</cantidad><ean>770723984128</ean></productos>
    <productos><precio>7600.0</precio><cantidad>300</cantidad><ean>770734304038</ean></productos>
    <total><iva>276242.0</iva><reteiva>138121.0</reteiva><reteica>572501.0</reteica> </total>
     </input>";
//$input="<input></input>";
if(isset($input)){
	if($input=="<input></input>" || $input=="<input>"){
		$xmlresponse = "<response><os>0</os><estado>Procesada</estado><desc>Mensaje no Valido</desc></response>";
	}else{
		$arr = SimpleXMLParser::parsePayOS($input);
		ob_start();
		try {
			$return = bizcve::getPagoOE($arr);
		}catch (Exception $e){
			//general::writelog("Error CATCH : " + $e->getMessage());	
		}
		$cont = ob_get_clean();
		//print $encabezado;
		$xmlresponse = "<response><os>".$arr['encabezado']['os']."</os><estado>Procesada</estado><desc>".$return."</desc></response>";	
	}
}else{
	return 0;
}




print $xmlresponse;

?>