<?php
   
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("../../../CVEPUBLIC/INCLUDE/ini.php");
include_once("../../../CVEPUBLIC/INCLUDE/autoload.php");
require_once('../../INCLUDE/nusoap/nusoap.php');
 
  file_put_contents('server.txt','xxx');
class cotizarCVE {
 
   	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   



    public function getCotizacion($idCotizacion) {

    //	$data = [];
      file_put_contents('cotizar.txt', $idCotizacion);
      
         $data = bizcve::getObsCotizacion($idCotizacion);
         //file_put_contents('dataResulxxt.txt',$data);

         return $data;
    }
}
 
$server = new soap_server();
$server->configureWSDL("cotizacionservice", "http://10.95.48.80/Trunk/Colombia/CVE/CVE_PPAL/CVEPUBLIC/COMMAND/wscve/cotizacionservice");


 
$server->register("cotizarCVE.getCotizacion",
    array("idCotizacion" => "xsd:string"),
    array("return" => "xsd:string"),
		"http://localhost/Trunk/Colombia/CVE/CVE_PPAL/CVEPUBLIC/COMMAND/wscve/cotizacionservice",
		"http://localhost/Trunk/Colombia/CVE/CVE_PPAL/CVEPUBLIC/COMMAND/wscve/cotizacionservice#getCotizacion",
 		"rpc",
		"encoded",
		"Get Observacion by Id Cotizacion");
 
@$server->service($HTTP_RAW_POST_DATA);
