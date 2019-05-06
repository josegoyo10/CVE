<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
if ($_POST['accion'] == 'eli' && $_POST['ideli']) {
	$List = new connlist;
	$ieditar = new dtocotizacion;
	$ieditar->id_cotizacion = $_POST['ideli'];
	$id_cotizacion=$_POST['ideli'];
	$List->addlast($ieditar);
	if(bizcve::delcotizacionall($List)){
		general::writeevent('La cotizacion '.$id_cotizacion.' ha sido eliminada.');
		general::inserta_tracking( $id_cotizacion, null, null, null, "Se ha eliminado la cotización");	
		header("Location: nueva_cotizacion_02.php?rut=" . $_POST['rut']);	
		exit();
	}
}

//Obtengo el credito del cliente mediante el webservice
$credito = ConsultarClienteOnline($_GET['rut']);

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
/**/
/*Despliegue de informaci?n de cliente*/
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE . "nuevacotizacion/nueva_cotizacion_02.htm");

$List  = new connlist;
$rut=$_GET['rut'];
$mRegistro->rut=$rut;
$List->addlast($mRegistro);
bizcve::getCliente($List);
$List->gofirst();
$configclitipo = new getidcontribuyente("CONTRIBUYENTE");
$opcion=$configclitipo->JURIDICO;
$opcion1=$configclitipo->EMPRESARIAL;
$opcion2=$configclitipo->SOCIOE;
/*if($List->getelem()->id_contribuyente == $opcion1){
	
	session_unregister ('ses_usr_codlocal');
	session_unregister ('ses_usr_nomlocal');
	session_register("ses_usr_codlocal");
	session_register("ses_usr_nomlocal");
	$ses_usr_codlocal=TIENDA_VIRTUAL_ID;
	
	$ListUsrSesionL = new connlist;
	$DUserL = new dtolocal;
	$DUserL->cod_local =TIENDA_VIRTUAL_ID;
	$ListUsrSesionL->addlast($DUserL); 
	bizcve::getlocales($ListUsrSesionL);
	$ListUsrSesionL->gofirst();
	$ses_usr_nomlocal=$ListUsrSesionL->getelem()->nom_local;

}
else{
	session_unregister ('ses_usr_codlocal');
	session_unregister ('ses_usr_nomlocal');
	session_register("ses_usr_codlocal");
	session_register("ses_usr_nomlocal");
	
	$ListUsrSesion = new connlist;
	$DUser = new dtousuario;
	$DUser->usr_id =$ses_usr_id;
	$ListUsrSesion->addlast($DUser); 
	bizcve::GetUsers($ListUsrSesion);
	$ListUsrSesion->gofirst();
	$ses_usr_codlocal=$ListUsrSesion->getelem()->cod_local;
	//echo 'local',$ListUsrSesion->getelem()->cod_local;
	if($ListUsrSesion->getelem()->cod_local){
	$ListUsrSesionL = new connlist;
	$DUserL = new dtolocal;
	$DUserL->cod_local =$ListUsrSesion->getelem()->cod_local;
	$ListUsrSesionL->addlast($DUserL); 
	bizcve::getlocales($ListUsrSesionL);
	$ListUsrSesionL->gofirst();
	$ses_usr_nomlocal=$ListUsrSesionL->getelem()->nom_local;
	}
}*/
$MiTemplate->set_block('main' , "listaclientes" , "BLO_listaclientes");
if (!$List->isvoid()) {
   $MiTemplate->set_var('rut',$List->getelem()->rut);
	$MiTemplate->set_var('rutdv',(($List->getelem()->id_contribuyente == $opcion1)?$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut) : $List->getelem()->rut ));
	$MiTemplate->set_var('razonsoc', $List->getelem()->razonsoc);
	$MiTemplate->set_var('giro', $List->getelem()->giro);
	$MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);
	$MiTemplate->set_var('contacto', $List->getelem()->contacto);
	//$MiTemplate->set_var('nomciudad', $List->getelem()->nomciudad);
	$MiTemplate->set_var('email', $List->getelem()->email);
	$MiTemplate->set_var('direccion', $List->getelem()->direccion);
	$MiTemplate->set_var('id_comuna', $List->getelem()->id_comuna);
	
$Listlocalizacion  = new connlist;
$registrolocalizacion->id_localizacion=$List->getelem()->id_comuna;
$Listlocalizacion->addlast($registrolocalizacion);
bizcve::getlocalizacion($Listlocalizacion);
$Listlocalizacion->gofirst();
if (!$Listlocalizacion->isvoid()) {
	do {
		$MiTemplate->set_var('nomciudad', $Listlocalizacion->getelem()->ciudad);
		$MiTemplate->set_var('nomcomuna', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
		$MiTemplate->set_var('departamento', $Listlocalizacion->getelem()->departamento);
		
	} while ($Listlocalizacion->gonext());
}


	//$MiTemplate->set_var('nomcomuna', $List->getelem()->nomcomuna);
	$MiTemplate->set_var('id_ciudad', $List->getelem()->id_ciudad);
	$MiTemplate->set_var('nomrubro', $List->getelem()->nomrubro);
	$MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente);
	$MiTemplate->set_var('nomtipopago',$List->getelem()->nomtipdocpago);
	//diascondicion viene si el numero ingresado existe en la tabla de condicion de pago
	// si no viene hay que aproximar el numero al siguiente pago 22->25
	if (!$List->getelem()->diascondicion){
		if( ($List->getelem()->numdiaspago<360) && ($List->getelem()->numdiaspago!=0)){
			$Ctrl = new ctrltipos;
			$Ctrl->getconpagoaprox($lista=new connlist(new dtotipo(array('id_tipoconpago'=> $List->getelem()->numdiaspago))));	 	
			$lista->gofirst();
			$diascondicion=$lista->getelem()->nombre;
	 	}
	 }else{
	 	$diascondicion=$List->getelem()->diascondicion;
	 }
	$MiTemplate->set_var('diascondicion',$diascondicion);
	
	//Intento consultar los datos online del webservice
	$marca_bloqueos = 0;
	if($credito != false) {
		$disponible = number_format($credito['limite_disponible']);
		
  		if ($credito['bloqueo_sap']) {
    		$MiTemplate->set_var('locksap', '<li>Cliente Bloqueado en SAP</li>');
    		$marca_bloqueos = 1;
  		}
  		if ($credito['bloqueo_moroso']) {
    		$MiTemplate->set_var('lockmoro', '<li>Cliente Bloqueado por Morosidad</li>');
    		$marca_bloqueos = 1;
  		}
  		if ($List->getelem()->id_tipocliente == 1 && strtotime($credito['fecha_vencimiento']) < time() ) {
  			$MiTemplate->set_var('lockfecha', '<li>Cliente Bloqueado por vencimiento de Disponible</li>');
  			$marca_bloqueos = 1;
  		}
	}
	else {
		//Traigo por defecto los datos de la db 
		$disponible = number_format(bizcve::getdisponible($List));
		
		if ($List->getelem()->locksap) {
			$MiTemplate->set_var('locksap', '<li>Cliente bloqueado en SAP</li>');
			$marca_bloqueos = 1;
		}
		if ($List->getelem()->lockmoro) {
			$MiTemplate->set_var('lockmoro', '<li>Cliente bloqueado por Morosidad</li>');
			$marca_bloqueos = 1;
		}
		if ($List->getelem()->lockfecha) {
			$MiTemplate->set_var('lockfecha', '<li>Cliente Bloqueado por vencimiento de Disponible</li>');
			$marca_bloqueos = 1;
		}
	}
	$MiTemplate->set_var('disponible', $disponible);
	if ($List->getelem()->lockcve) {
		$MiTemplate->set_var('lockcve', '<li>Cliente Bloqueado en CVE</li>');
		$marca_bloqueos = 1;
	}
	if ($List->getelem()->comentario) {
		$MiTemplate->set_var('comentarioe', '<li>'.$List->getelem()->comentario.'</li>');
	}
	if (!$marca_bloqueos) {
		$MiTemplate->set_var('saldodisp', '<li>Saldo Disponible</li>');
	}
	
	$MiTemplate->parse("BLO_listaclientes", "listaclientes", true);	
}

/*Fin Despliegue de informaci?n de cliente*/


/**/
/*Despliegue informacion de tipo venta*/
$List  = new connlist;
bizcve::gettipoventa($List);
$List->gofirst();
$MiTemplate->set_block('main' , "tipoventa" , "BLO_tipoventa");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('idventa', $List->getelem()->id);
		$MiTemplate->set_var('nomtipoventa', $List->getelem()->nombre);
		$MiTemplate->set_var('selected', ($_POST['select_tipoventa'] == $List->getelem()->id)?'selected':'');
		
        $MiTemplate->parse("BLO_tipoventa", "tipoventa", true);
	} while ($List->gonext());
}
/*Fin Despliegue informacion de tipo venta*/


/**/
/*Despliegue informacion de Centro Suministro*/
$List  = new connlist;
bizcve::getlocales($List);
$List->gofirst();
$MiTemplate->set_block('main' , "suministro" , "BLO_suministro");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('codigo_local', $List->getelem()->cod_local);
		$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
		$csumsearch = (isset($_POST['select_suministro']))?$_POST['select_suministro']:$ses_usr_codlocal;
		$MiTemplate->set_var('selected', ($csumsearch == $List->getelem()->cod_local)?'selected':'');
		
        $MiTemplate->parse("BLO_suministro", "suministro", true);  	
	} while ($List->gonext());
}
/*Fin Despliegue informacion de Centro Suministro*/


/**/
/*Despliegue Estado Cotizaci?n*/

$List  = new connlist;
$mRegistro=new dtoestado;
$mRegistro->tipo = 'CO';
$List->addlast($mRegistro);
bizcve::getestados($List);
$List->gofirst();
$MiTemplate->set_block('main' , "estado" , "BLO_estado");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('id_estado', $List->getelem()->id_estado);			
		$MiTemplate->set_var('descripcion', $List->getelem()->descripcion);
		$MiTemplate->set_var('selected', ($_POST['select_estado'] == $List->getelem()->id_estado)?'selected':'');
		
		$MiTemplate->parse("BLO_estado", "estado", true);
	} while ($List->gonext());
}
/*Fin Despliegue Estado Cotizaci?n*/

/*DESPLIEGUE*/   

$ListEnc  = new connlist;
$mRegistro = new dtocotizacion;

if (isset($_POST['select_suministro']))
	$mRegistro->codlocalventa=$_POST['select_suministro'];
	//$mRegistro->codlocalcsum=$_POST['select_suministro'];
else
	$mRegistro->codlocalventa = $ses_usr_codlocal;
	//$mRegistro->codlocalcsum = $ses_usr_codlocal;

$mRegistro->rutcliente=$_GET['rut'];
$mRegistro->id_tipoventa=$_POST['select_tipoventa'];
$mRegistro->id_estado=$_POST['select_estado'];

$ListEnc->addlast($mRegistro);
bizcve::getcotizacion($ListEnc, $ListDet);
$ListEnc->gofirst();
$MiTemplate->set_block('main' , "infocotizacion" , "BLO_infocotizacion");
if (!$ListEnc->isvoid()) {
	do {
		$MiTemplate->set_var('numerocot',$ListEnc->getelem()->id_cotizacion);
		$MiTemplate->set_var('usuariocrea', $ListEnc->getelem()->usuariocrea);	
		$MiTemplate->set_var('nomestadocot',$ListEnc->getelem()->nomestado);
		$MiTemplate->set_var('nomtipoventacot',$ListEnc->getelem()->nomtipoventa);
		$MiTemplate->set_var('condicioncot',$ListEnc->getelem()->condicion);
		$MiTemplate->set_var('nom_localcsum',$ListEnc->getelem()->nom_localcsum);
		$MiTemplate->set_var('id_cotizacion',$ListEnc->getelem()->id_cotizacion);
		$MiTemplate->set_var('fechavalidacot',$ListEnc->getelem()->validhasta);
		$ListEncCountGE = new connlist;
		$mRegistroGE = new dtodetcotizacion;
		$mRegistroGE->id_cotizacion=$ListEnc->getelem()->id_cotizacion;
		$ListEncCountGE->addlast($mRegistroGE);
		bizcve::getdetcotizacioncountpegenerico($ListEncCountGE);
		$ListEncCountGE->gofirst();
		if($ListEncCountGE->getelem()->cantidad >0){
		$MiTemplate->set_var('accmodificar',($ListEnc->getelem()->puedemodificar)?"<a href=\"#\"><img src=\"../../IMAGES/editicon.gif\" alt=\"Modificar\" border=\"0\" id=\"".$ListEnc->getelem()->id_cotizacion."\" onClick=\"editarcotipege(this)\"></a>":"");	
		}
		else{
		$MiTemplate->set_var('accmodificar',($ListEnc->getelem()->puedemodificar)?"<a href=\"#\"><img src=\"../../IMAGES/editicon.gif\" alt=\"Modificar\" border=\"0\" id=\"".$ListEnc->getelem()->id_cotizacion."\" onClick=\"editarcoti(this)\"></a>":"");
		}
		$MiTemplate->set_var('accver',($ListEnc->getelem()->puedever)?"<a href=\"#\"><img src=\"../../IMAGES/info.gif\" alt=\"Ver\" border=\"0\" id=\"".$ListEnc->getelem()->id_cotizacion."\" onClick=\"vercoti(this)\"></a>":"");
		$MiTemplate->set_var('acceliminar',($ListEnc->getelem()->puedeeliminar)?"<a href=\"#\"><img src=\"../../IMAGES/trash.gif\" alt=\"Eliminar\" border=\"0\" id=\"".$ListEnc->getelem()->id_cotizacion."\" onClick=\"eliminarcoti(this)\"></a>":"");
		$MiTemplate->parse("BLO_infocotizacion", "infocotizacion", true);
	} while ($ListEnc->gonext());
}
/*Fin Despliegue Estado Cotizaci?n*/

/*FIN DESPLIEGUE*/


$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>
