<?
/* load NuSOAP library */
require_once('lib/nusoap.php');


// create server
$SoapServer = new soap_server();

// wsdl generation
$SoapServer->configureWSDL('Echo', 'http://www.revelex.com/soap', false, 'document');
$SoapServer->wsdl->schemaTargetNamespace = 'http://www.revelex.com/soap';
$SoapServer->wsdl->addComplexType('telephoneNumber',
                                  'complexType',
                                  'struct',
                                  'all',
                                  '',
                                  array('area'     => array('name' => 'area','type' => 'xsd:string'),
                                        'exchange' => array('name' => 'exchange','type' => 'xsd:string'),
                                        'number'   => array('name' => 'number','type' => 'xsd:string')
                                        )
);

$SoapServer->wsdl->addComplexType('telephoneNumbers',
                                  'complexType',
                                  'struct',
                                  'sequence',
                                  '',
                                  array ('telephoneNumber' => array ('name' => 'telephoneNumber','type' => 'tns:telephoneNumber')
                                  ));

// register method
$SoapServer->register('doEcho',
                      array('name'      => 'xsd:string',
                            'age'       => 'xsd:int',
                            'telephones'=> 'tns:telephoneNumbers'
                            ),
                      array('name'      => 'xsd:string',
                            'age'       => 'xsd:int',
                            'telephone' => 'tns:telephoneNumber'
                            ),
                      'http://www.revelex.com/soap',
                      false,
                      'document',
                      'literal',
                      'Echos back the data given to it, not very useful!'
                      );

// method code (get DB result)
function doEcho ($name, $age, $telephones) {
    if (is_string($name) and is_numeric($age)) {
//        // return data
//        //return new soap_fault('Server', '', "{$telephoneNumber[0]['area']}");
        return array ('name' => $name, 'age' => $age, 'telephone' => $telephones['telephoneNumber']);
    }
    // we accept only a string and a int.
    else {
      return new soap_fault('Client', '', 'Service requires the parameters name (string), age (integer).');
    }
  }

// pass incoming (posted) data
$SoapServer->service($HTTP_RAW_POST_DATA)
?>
