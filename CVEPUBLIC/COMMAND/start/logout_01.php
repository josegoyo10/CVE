<?
session_start();

$_SESSION["DBACESS"] = null;
$_SESSION = array();

session_destroy();

header('Location: ../../../' );

?>
