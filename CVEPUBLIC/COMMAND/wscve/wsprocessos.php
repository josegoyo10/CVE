<?php
//include_once("../../BIZCLASS/bizcve.class.php");
//include_once("../../../HLPCLASS/general.class.php");
include_once("../../../CVEPUBLIC/INCLUDE/ini.php");
include_once("../../../CVEPUBLIC/INCLUDE/autoload.php");

//invoca libreria nusoap
require_once('lib/nusoap.php');
//general::writeevent("carga libreria NUSOAP ...");

// Crea la instancia nueva para el server
$server = new soap_server;

//general::writeevent("crea instancia soap_server ...");
$server->configureWSDL('wsprocessos', 'urn:wsprocessos', 'http://192.168.0.145/ProyectosEasy/CVE/cvecolombia/CVEPUBLIC/COMMAND/wscve/wsprocessos.php');

// Registro el tipo de dato para el encabezado
$server->wsdl->addComplexType(
    'encabezado',
    'complexType',
    'struct',
    'all',
    '',
array(
        'os' => array('name' => 'os', 'type' => 'xsd:long'),
        'id' => array('name' => 'id', 'type' => 'xsd:long'),
        'numfactura' => array('name' => 'numfactura', 'type' => 'xsd:string')

)
);

// Registro el tipo de dato para el medio de pago
$server->wsdl->addComplexType(
    'mediopago',
    'complexType',
    'struct',
    'all',
    '',
array(
        'idmedio' => array('name' => 'idmedio', 'type' => 'xsd:string')
)
);

// Registro el tipo de dato para el productos
$server->wsdl->addComplexType(
    'productos',
    'complexType',
    'struct',
    'all',
    '',
array(
        'precio' => array('name' => 'precio', 'type' => 'xsd:double'),
        'cantidad' => array('name' => 'cantidad', 'type' => 'xsd:int'),
        'ean' => array('name' => 'ean', 'type' => 'xsd:long')

)
);


// Registro el tipo de dato para el total
$server->wsdl->addComplexType(
    'total',
    'complexType',
    'struct',
    'all',
    '',
array(
        'iva' => array('name' => 'iva', 'type' => 'xsd:double'),
        'reteiva' => array('name' => 'reteiva', 'type' => 'xsd:double'),
        'retefuente' => array('name' => 'retefuente', 'type' => 'xsd:double'),
        'reteica' => array('name' => 'reteica', 'type' => 'xsd:double'),
)
);


// Registro el tipo de dato completo
$server->wsdl->addComplexType(
    'ordenEntregaPOS',
    'complexType',
    'struct',
    'sequence',
    '',
array(
        'encabezado'=> array('name' => 'encabezado', 'type' => 'tns:encabezado'),
        'mediopago' => array('name' => 'mediopago', 'type' => 'tns:mediopago'),
        'productos' => array('name' => 'productos', 'type' => 'tns:productos'),
        'total' 	=> array('name' => 'total', 'type' => 'tns:total'),
)
);

// Registro el tipo de dato de respuesta
$server->wsdl->addComplexType(
    'resp',
    'complexType',
    'struct',
    'all',
    '',
	array(
        'os' => array('name' => 'os', 'type' => 'xsd:long'),
        'estado' => array('name' => 'estado', 'type' => 'xsd:string'),
        'desc' => array('name' => 'desc', 'type' => 'xsd:string'),
	)
);

//Registra el Metodo a Exponer
$server->register('PayOSCVE',      // method name
array('input' => 'tns:ordenEntregaPOS'),    // input parameters
array('response' => 'tns:resp'),    // output parameters
    'urn:wsprocessos',                      // namespace
    'urn:wsprocessos#PayOSCVE',          // soapaction
    'document',                            // style
    'literal',                        // use
    'Pago de Cotización CVE desde POS'        // documentation
);

// Implementacion del Metodo
function PayOSCVE($ordenEntrega){
	$encabezado = $ordenEntrega['encabezado'];
	$mediopago = $ordenEntrega['mediopago'];
	$productos = $ordenEntrega['productos'];
	$total = $ordenEntrega['total'];
		
	ob_start();
	try {
		$return = bizcve::getPagoOE($encabezado, $mediopago, $productos, $total);
	}catch (Exception $e){
		general::writelog("Error CATCH : " + $e->getMessage());	
	}
	$cont = ob_get_clean();
	general::writelog("Bad output : " . $cont);
	
	general::writelog("Respuesta WS : ".$return);
	
	$respuesta = array('response' => array('os'=> $ordenEntrega['encabezado']['os'],
        			   'estado' => 'Procesada',
       				   'desc' => $return));
	
	general::writelog("Respuesta Enviada TEST..");
	general::writelog($var);
	return $respuesta; 
    
}

// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>