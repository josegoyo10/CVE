<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
	if ($_SESSION["ses_usr_codlocal"]){
	    general::writeevent('No puede administrar Ip de locales, tiene local asignado'); 
		header( "Location: ../start/sin_perm_01.php");	
		exit();
	}

	global $ses_usr_id;
    $usr_nombre =general::get_nombre_usr( $ses_usr_id );
	
	if(!bizcve::verificacionDePermisos($ses_usr_id,61, 'UPDATE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }

	$List = new connlist;
	$registro = new dtolocal;
	$registro->ip		 	  =$_REQUEST['ip_del'];	
	$registro->cod_local	  =$_REQUEST['cod_localdel'];	
	$List->addlast($registro);	
	$valor=	bizcve::validaiplocal($List); 

	bizcve::setevento(39, 'Modulo Administración IP Tiendas', $_SERVER['REMOTE_ADDR'], 'ABM Sistemas',
                    'Se ha Eliminado la IP de tienda','','IP de tienda Eliminada', $usr_nombre );
	
	if($valor){
		bizcve::deliplocal($List);	
	    header( "Location: admlistadoip.php" );	
	}else{
        ?>
        <script language="JavaScript">
        window.alert("No existe esta Ip <?=$_REQUEST['ip_del']?> o el local <?=$_REQUEST['cod_localdel']?>.\n Ingrese Otra");
        </script>
        <?		
        /*alertar al usuario*/
	    general::writeevent("No existe esta Ip ".$_REQUEST['ip_del']." Para el local ".$_REQUEST['cod_localdel']);	        
		exit();
	}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
?>




