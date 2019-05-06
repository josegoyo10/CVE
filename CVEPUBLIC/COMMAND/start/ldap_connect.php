<?
$cencosudADServer["server_name"] = "Cencosud AIO";

$cencosudADServer["base_dn"] = "dc=cencosud, dc=corp"; 

$cencosudADServer["domain_controllers"] = Array("cencosud.corp");

$cencosudADServer["ad_username"] = $_POST['usuario']; 

$cencosudADServer["ad_password"] = $_POST['clave'];

$cencosudADServer["account_suffix"] = "@cencosud.corp";

 

$configLDAP[]=($cencosudADServer);

?>