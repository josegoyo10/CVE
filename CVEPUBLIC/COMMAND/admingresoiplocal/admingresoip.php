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
function get_nombre_local($cod_local){
    $List = new connlist;
	$Registro = new dtolocal;
	$Registro->cod_local = $cod_local;
	$List->addlast($Registro);
 	bizcve::getlocales($List);  
	$List->gofirst();
	if (!$List->isvoid()) {
		do {
			$nombreLocal=$List->getelem()->nom_local;			
		} while ($List->gonext()); 	
	}
	return $nombreLocal;	
}

if($_REQUEST['accioning']=='error'){

	global $ses_usr_id;
	$usr_nombre =general::get_nombre_usr( $ses_usr_id );

	$local_nombre = get_nombre_local($_REQUEST['cod_localing']);	
	general::writeevent('La ip '.$_REQUEST['ipin'].' Ya existe para este local '.$local_nombre);
}	


if ( $_REQUEST['accion']=='ingresa'){
	global $ses_usr_id;
	
	if( isset($ses_usr_codlocal) ) {
		$local=$ses_usr_codlocal;
	}else{
		if ($select_local){
			$local=$select_local;
		}else{
			$local=0;
		}
	}

	if(!bizcve::verificacionDePermisos($ses_usr_id,89, 'UPDATE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }
	
	$List = new connlist;
	$registro = new dtolocal;
	$registro->ip_local 	  = $_REQUEST['ip_local'];	
	$registro->cod_local	  = $local;	
	$List->addlast($registro);	
	$valor=	bizcve::validaiplocal($List); 
	if(!$valor){
		bizcve::insertiplocal($List);

		global $ses_usr_id;
    	$usr_nombre =general::get_nombre_usr( $ses_usr_id );

		 bizcve::setevento(37, 'Modulo Administracion IP Tiendas', $_SERVER['REMOTE_ADDR'], 'ABM Sistemas',
                    'Se ha Creado la IP de tienda','','IP de tienda Creada', $usr_nombre );
		
	    header( "Location: admlistadoip.php" );	
	}else{
		$local_nombre = get_nombre_local($local);			
		?>
        <script language="JavaScript">
        window.alert("Ya existe Ip <?=$_REQUEST['ip_local']?> para el local  <?=$local_nombre?>  .\n Ingrese Otra");
        location.href=("admingresoip.php?accion=error&ip_ing=<?=$_REQUEST['ip_local']?>&cod_localing=<?=$local?>");
        </script>
        <?	
        /*Avisar al usuario*/
       general::writeevent("Ya existe esta Ip ".$_REQUEST['ip_local']." Para el local ".$local_nombre);	
	}	
}

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);
// Agregamos el header
$MiTemplate->set_file("header", TEMPLATE."presentacion/header.htm");

$MiTemplate->set_file("main", TEMPLATE."admingresoiplocal/admingresoip.htm");

if( isset($ses_usr_codlocal) ) {
	$local=$ses_usr_codlocal;
}else{
	if ($cod_localing){
		$local=$cod_localing;
	}else{
		$local=0;
	}
}

/*Seteo de variables y querys*/
$List = new connlist;
$mLocal = new dtolocal;
$mLocal->cod_local =$local;
$List->addlast($mLocal);
bizcve::getlocaleselect($List);
$List->gofirst();  

if (!$List->isvoid()) {
	$MiTemplate->set_block("main", "Locales", "PBLModulos");
	do {
		if ($ses_usr_codlocal){
			$MiTemplate->set_var('disabled', 'disabled');					
		}
		$MiTemplate->set_var('ip_local', $_REQUEST['ip_ing']);		
		$MiTemplate->set_var('codigo_local', $List->getelem()->cod_local);
		$MiTemplate->set_var('selected', $List->getelem()->cod_local_selected);		
		$MiTemplate->set_var('nombre_local', $List->getelem()->nom_local);
        $MiTemplate->parse("PBLModulos", "Locales", true);  
	} while ($List->gonext());
	$MiTemplate->clear_var('codigo_local');
	$MiTemplate->clear_var('nombre_local');
}
else {
	echo "Lista vacia de locales. Contacte a su administrador";
}


/*Terminado el codigo deben incluir esto*/
$MiTemplate->parse("OUT_M", array("header", "main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>


