<?php    
    ini_set('display_errors', 'On');
	require("/var/www/html/cvecolombia/CVEPUBLIC/INCLUDE/ini.php");
    ini_set('display_errors','On');
//print_r($variablesProcesos);
    $hostname  = $variablesProcesos['DATABASE']['DBSERVER'];
    $username  = $variablesProcesos['DATABASE']['DBUSER'];
    $password  = $variablesProcesos['DATABASE']['DBPASS'];
    $database  = $variablesProcesos['DATABASE']['DBDATABASE'];
    $conexion = mysqli_connect($hostname, $username, $password,  $database);

//print('clave: '.$username);   
/*
$conexion->query('drop temporary table if exists temporal_evento');
echo $conexion->error;
$conexion->query('create temporary table temporal_evento (idEvento INT)');
echo $conexion->error;
$conexion->query('INSERT INTO temporal_evento(idEvento) SELECT idEvento from evento WHERE DATE(fecha) <= CURDATE()');
echo $conexion->error;
$conexion->query('INSERT INTO evento_historico(SELECT * FROM evento WHERE idEvento IN (SELECT idEvento FROM temporal_evento))');
echo $conexion->error;
$conexion->query('DELETE FROM evento WHERE idEvento IN (SELECT idEvento FROM temporal_evento)');
echo $conexion->error;
$conexion->query('DROP TABLE temporal_evento');
echo $conexion->error;
*/

 
$configuration_query = mysqli_multi_query($conexion, 'DROP TEMPORARY TABLE IF EXISTS temporal_evento;
													CREATE TEMPORARY TABLE temporal_evento( idEvento INT);
													INSERT INTO temporal_evento(idEvento) SELECT idEvento from evento WHERE DATE(fecha) <= CURDATE();
													INSERT INTO evento_historico(SELECT * FROM evento WHERE idEvento IN (SELECT idEvento FROM temporal_evento));
													DELETE FROM evento WHERE idEvento IN (SELECT idEvento FROM temporal_evento);
													DROP TABLE temporal_evento;');
echo $conexion->error;
//if ($configuration_query) { echo "bien\n";}else{ echo "mal\n";};


  // print($hostname.$username.$password.$database."\n"); 
//	print(system('echo $HOSTNAME'));

?>
