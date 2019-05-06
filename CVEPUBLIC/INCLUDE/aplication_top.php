<?
//Gestor de Excepciones no capturadas
function not_catched_exceptions($e) {
	general::dspsyserr($msgerr . "Excepcion NO capturada [" . $e->getMessage() . "]");
}
set_exception_handler('not_catched_exceptions');

//Obtenemos las variables globales
$List = new connlist;
bizcve::getglobals($List);
$List->gofirst();
if (!$List->isvoid()) {
	do {
    	define($List->getelem()->nombre, $List->getelem()->valor);
	} while ($List->gonext());
}
define('TEMPLATE', $_SESSION["CONFIG"]->getValue('APPLICATION','PATH_TPL'));
define('TITULO', $_SESSION["CONFIG"]->getValue('APPLICATION','APP_TITLE'));

//Redireccionamos a la página de inicio si no hay login
//if( $pag_ini && !$ses_usr_id ) {


//die("usr_aplication:".$_SESSION["ses_usr_id"]);
//$ses_usr_id = 'admin';
//die("ses_usr_nomlocal".$ses_usr_nomlocal);

if( !$ses_usr_id ) {
 //if(!$_SESSION["ses_usr_id"]) {
	general::writeevent('Intento de acceso a página TOP '. $_SERVER['PHP_SELF'] .' sin sesión');
	if ($_REQUEST['popup']) {
		general::returnvalue('nologin');
		general::close();
	}
	else {
		header( "Location: ../start/logout_01.php" );
	}
	exit();
}

if( !session_is_registered('ses_ult_carga') ) {
    session_register('ses_ult_carga');
}
else {
    general::desconectar_usuario( $ses_ult_carga );
}
$ses_ult_carga = time();

//Si la página tiene control de acceso.
if( $pag_ini && !bizcve::existemodulouser($ses_usr_login, $pag_ini)) {
//if( $pag_ini && !bizcve::existemodulouser($_SESSION["ses_usr_login"], $pag_ini)) {
	general::writeevent('Intento de acceso a página '. $_SERVER['PHP_SELF'] .' sin autorización');
	header( "Location: ../start/logout_01.php" );
	exit();
}

//Completamos las variables de sesion faltantes
//$ses_usr_nomlocal = 'E801';

if( !$ses_usr_nomlocal ) {
	$List = new connlist;
	bizcve::infousuarioper($List,$ses_usr_id);
	$List->gofirst();
	if (!$List->isvoid()) {
		$ses_usr_codlocal = $List->getelem()->cod_local;
		$ses_usr_nomlocal = $List->getelem()->nom_local;
		$ses_usr_codvendedor = $List->getelem()->codigovendedor;
		$ses_usr_fecha = date("d/m/Y", time());
	}
}



?>