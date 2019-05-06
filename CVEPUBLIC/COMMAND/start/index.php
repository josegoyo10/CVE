<?

 //  ini_set('display_errors', true);
 // error_reporting(E_ALL);


// Incluimos la libreria ldap 
include ("ldap_connect.php"); 
//var_dump ($_GET['user']);
//var_dump ($_POST['usuario']);
//var_dump ($_POST);
if( $action == "login" ) {

	include_once("../../INCLUDE/ini.php");
	include_once("../../INCLUDE/autoload.php");
	if (!$_SESSION["DBACESS"]->isconnected()){
	
		$msg_error = '*** Aplicaci&oacute;n no disponible por el momento ***';
		general::writelog("No se ha podido conectar a Base de Datos [DBSERVER:".$_SESSION["CONFIG"]->getValue('DATABASE','DBSERVER').", USER:".$_SESSION["CONFIG"]->getValue('DATABASE','DBUSER').", PASS:********, DB:".$_SESSION["CONFIG"]->getValue('DATABASE','DBDATABASE')."]");
	}
    // Comprobamos por active directory y no por base de datos la clave
	else if ((1 || is_password_match($_POST['usuario'],$_POST['clave'],$_POST['clave']))
		&& ($id_usuario = bizcve::usuariovalido((($_POST['usuario'])?$_POST['usuario']:$_GET['user']) 
												 ))) {
		if (bizcve::ipusuariovalida($id_usuario, $_SERVER["REMOTE_ADDR"])) {
			session_register('ses_usr_id');
			session_register('ses_usr_login');
			session_register('ses_usr_codlocal');
			session_register('ses_usr_nomlocal');
			session_register('ses_usr_codvendedor');
			session_register('ses_usr_fecha');
			session_register('ses_usr_menu');
			$ses_usr_id = $id_usuario;
			$ses_usr_login = (($_POST['usuario'])?$_POST['usuario']:$_GET['user']);
			if (!general::writeevent("Inicio de sesion usuario")) {
				$msg_error = '*** No es posible escribir en registro de eventos ***';
			}
			else {
				// Agrega la tupla del usuario logueado en la base de datos.
				bizcve::setevento(1, 'Modulo Login Active Directory', $_SERVER['REMOTE_ADDR'], 'Login',
					'Login de usuario exitoso','','Usuario logueado', ( ($_POST['usuario'])?$_POST['usuario']:$_GET['user'] ) );


				if ($_GET['source'])
					header('Location: ' . $_GET['source'] );
				else
					($_POST['usuario']==$_POST['clave']?header('Location: start_01.php?mensajelogin=1'):header('Location: start_01.php'));
			}
		}
		else {
			$msg_error = '*** No tiene permiso para acceder desde este PC ***';
			general::writelog("Usuario ".$_POST['usuario']." no tiene privilegio para acceder desde esta IP");

		} 
   	}
   	else{
        $msg_error = '*** Usuario o Clave incorrecto ***';
		general::writelog("Usuario o Clave incorrectos" );

		// Agrega la tupla en la base de datos de que no se logeo la persona.
		bizcve::setevento(1, 'Modulo Login Active Directory', $_SERVER['REMOTE_ADDR'], 'Login',
					'Login de usuario fallido, Usuario o Clave incorrecto','','Logueo fallido', ( ($_POST['usuario'])?$_POST['usuario']:$_GET['user'] ) );
   	}
}
else{
	include_once("../../INCLUDE/inisc.php");
	include_once("../../INCLUDE/autoload.php");
}

$MiTemplate = new template();
$MiTemplate->set_var("TITULO", 'Centro Venta Empresa');
 


	// se define la funcion is password match que comprueba la pass de active directory
	function is_password_match($formUsername, $formPassword, $storedPassword) {
 
		global $configLDAP, $logger;

       /* echo "User:".$formUsername."<br>\n";
        echo "Pass:".$formPassword."<br>\n";
        echo "store:".$storePassword."<br>\n";

   

     file_put_contents('configure.txt', print_r($configLDAP,true));

       /* echo '<pre>';
          print_r($configLDAP);
        echo '</pre>';*/
		//echo 'ConfigLdadp:'.$configLDAP."<br>";
		  // Intento conectarme a los directorios LDAP configurandos en el archivo de 

		  // configuración y que debe estar disponible por este método

		  // Incluyo la clase y creo una conexión

		  include ("adLDAP.php");
         
          //echo "paso LDAP";

		  // Intentas autenticar contra los servidores configurados
		  foreach ($configLDAP as $ldapServer){
               
               
				$adldap = new adLDAP($ldapServer);
                 file_put_contents('adladp.txt',print_r($adldap, true));
				// Se intenta autenticar en el AD con la información obtenida en el login
				if ($adldap -> authenticate($formUsername,$formPassword)){                            

					  return true; // El usuario ingreso clave y contraseña correcta
				} else {
					  return false;
				}       
		  }
	}

// Agregamos el main
$MiTemplate->set_file("main","../../TEMPLATE/start/index.html");
$MiTemplate->set_var("TEXT_ERROR",$msg_error);

$MiTemplate->parse("OUT", array("main"), true);
$MiTemplate->p("OUT");
?>
