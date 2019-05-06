<?php
require_once('lib/nusoap.php');
//require_once 'Tools.inc';

/*ini_set('display_errors', '1');
error_reporting(E_ALL);
function my_handler($no, $str) {
  echo "$no: $str <br/>"; 
}

set_error_handler('my_handler');
*/

$client = new soapclient('http://192.168.0.145/ProyectosEasy/CVE/cvecolombia/CVEPUBLIC/COMMAND/wscve/test.php?wsdl', true);
$err = $client->getError();
if ($err) {
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

$number = array('area'     => '954',
                              'exchange' => '578',
                              'number'   => '3220'
                              );

$params = array('name'       => 'Alex',
                'age'        => 23,
                'telephones' => array('telephoneNumber' => $number)
               );

               //Tools::printArray($params);
echo $client->_getProxyClassCode();
$proxy = $client->getProxy();
$result = $proxy->doEcho($params);

//$result = $client->call('doEcho', array('parameters' => $params));

echo '<h2>Debug</h2><pre>' . htmlspecialchars($proxy->debug_str, ENT_QUOTES) . '</pre>';

//Tools::printArray($proxy->request);
//Tools::printArray($proxy->response);

if ($proxy->fault) {
    echo '<h2>Fault (This is expected)</h2><pre>'; print_r($result); echo '</pre>';
} else {
    $err = $proxy->getError();
    if ($err) {
        echo '<h2>Error</h2><pre>' . $err . '</pre>';
    } else {
        echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';
    }
}

?> 