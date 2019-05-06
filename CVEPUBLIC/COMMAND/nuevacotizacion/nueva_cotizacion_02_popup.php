<?

///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

if ($_POST['accion'] == 'nuevacot') {
	if(!bizcve::verificacionDePermisos($ses_usr_id,44, 'INSERT')){

        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }
	
	if (!$ses_usr_codlocal) {
		$mensaje_error = 'No tiene asignado local. No puede generar cotizaciones';
		general::writeevent($mensaje_error);
		general::alertexit($mensaje_error);
	}
	else {
		if($_POST['valid_codvendedor']==false){
			
		}

		//alert('else');
		session_unregister ('ses_usr_codlocal');
		session_unregister ('ses_usr_nomlocal');
		session_register('ses_usr_codlocal');
		session_register('ses_usr_nomlocal');
		//$_SESSION["ses_usr_codlocal"];
		//$_SESSION["ses_usr_nomlocal"];
		
		$ListUsrSesionL = new connlist;
		$DUserL = new dtolocal;
		$DUserL->cod_local =$_POST['centrofacturacion'];
		$ListUsrSesionL->addlast($DUserL); 
		bizcve::getlocales($ListUsrSesionL);
		$ListUsrSesionL->gofirst();
		$ses_usr_nomlocal=$ListUsrSesionL->getelem()->nom_local;
		$ses_usr_codlocal=$ListUsrSesionL->getelem()->cod_local;
		//$_SESSION["ses_usr_nomlocal"]=$ListUsrSesionL->getelem()->nom_local;
		//$_SESSION["ses_usr_codlocal"]=$ListUsrSesionL->getelem()->cod_local;

		$List = new connlist;
		$iClientes = new dtoinfocliente;
		$iClientes->codlocaluco=$ses_usr_codlocal;
		$iClientes->fechauco =date("Y-d-m");
		$iClientes->rut=$_GET['rut'];
		$List->addlast($iClientes);
		bizcve::putCliente($List);
		

		$List  = new connlist;
		$mCliente->rut=$_GET['rut'];
		$List->addlast($mCliente);
		bizcve::getCliente($List);
		$List->gofirst();	
	
		$ListEnc = new connlist;
		$iCotizacion = new dtocotizacion;
		$iCotizacion->id_tipoventa=$_POST['tipoventa'];
		$iCotizacion->codigovendedor=$_POST['codigovendedor'];
		$iCotizacion->rutcliente=$_GET['rut'];
		$iCotizacion->codlocalventa=$ses_usr_codlocal;
		//Si es venta calzada, El centro de suministro es el mismo local emisor siempre.
		if ($_POST['tipoventa'] == 1) 
			$iCotizacion->codlocalcsum=$ses_usr_codlocal;
		else 
		$iCotizacion->codlocalcsum=$_POST['centrosuministro'];
		$iCotizacion->razonsoc=$List->getelem()->razonsoc;
		$iCotizacion->id_giro=$List->getelem()->id_giro;
		$iCotizacion->giro=$List->getelem()->giro;
		$iCotizacion->direccion=$List->getelem()->direccion;
		$iCotizacion->comuna=$List->getelem()->nomcomuna;
		$iCotizacion->iva=VALOR_IVA;
		$iCotizacion->validdesde=date("Y-m-d");
		$iCotizacion->validhasta=date("Y-m-d", mktime(0,0,0,date("m"),date("d")+DIAS_VALID_COTI,date("Y")));
		$iCotizacion->validdias=DIAS_VALID_COTI;
		$iCotizacion->condicion=$_POST['tipocondicion'];
		$iCotizacion->fonocontacto=$List->getelem()->fonocontacto;
		$ListEnc->addlast($iCotizacion);
		$List->addlast($iClientes);
         
        file_put_contents("putcotizacion.txt", $ListEnc);
        file_put_contents("putcotizacionDet.txt", $ListDet);

		if (bizcve::putcotizacion($ListEnc, $ListDet)){
            $ListEnc->gofirst();

            $nombreSession = general::get_nombre_usr($ses_usr_id);

	bizcve::setevento(18, 'Modulo Cotizacion NVE', $_SERVER['REMOTE_ADDR'], 'ABM de cotizacion',
                    'Nueva cotizacion guardada con N° '.$ListEnc->getelem()->id_cotizacion.'','','Registro de nueva cotizacion', $nombreSession);
            
			if($_POST['valid_codvendedor']==false){
				$Listmod_vendedor = new connlist;
				$iClientmod = new dtoinfocliente;
				$iClientmod->rut =$_POST['rut'];
				$iClientmod->codigovendedor=$_POST['codigovendedor'];
				$Listmod_vendedor->addlast($iClientmod);
				bizcve::putcliente($Listmod_vendedor);
			}
            general::inserta_tracking($ListEnc->getelem()->id_cotizacion, null, null, null, 'Se ha creado la cotizacion');
			general::returnvalue($ListEnc->getelem()->id_cotizacion);
			general::close();
			exit();
		}

	}

}	
/*Fin Grabaci?n de cotizaci?n*/
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
/*Inicializaci?n de Templates*/
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_file("main", TEMPLATE . "nuevacotizacion/nueva_cotizacion_02_popup.htm");
/*Recupera informacion de cliente*/
$List  = new connlist;
$mRegistro =new dtoinfocliente;
//$rut='80143729';
$rut=$_GET['rut'];
$mRegistro->rut=$rut;
$List->addlast($mRegistro);
bizcve::getCliente($List);
$List->gofirst();
//$codvende=$List->getelem()->codigovendedor;
$MiTemplate->set_var('rut',$rut);
$MiTemplate->set_var('tienda_virtual',TIENDA_VIRTUAL_ID);
if ($tipoUsuariocol = bizcve::getTipoUsuarioCotiza($ses_usr_id)){
	$valid_codvendedor=true;
	//if($tipoUsuariocol == 2 || $tipoUsuariocol == 3){
	    $MiTemplate->set_var('tipo_usuario_reg', trim($tipoUsuariocol));
		
	    if(trim($List->getelem()->codigovendedor)== ''){
	    	$valid_codvendedor=false;
	    	$MiTemplate->set_var('notificacion', 'alert("El cliente no tiene un vendedor asociado, se le asignara el código de vendedor que ingrese \n          en la casilla (código), por defecto la aplicación ingresara su código de vendedor.");');
	    }
	    else{
	    	$ListUsrValid = new connlist;
			$DUser = new dtousuario;
			$DUser->codigovendedor=trim($List->getelem()->codigovendedor);
			$ListUsrValid->addlast($DUser); 
			bizcve::GetUsers($ListUsrValid);
			$ListUsrValid->gofirst();
			
			if(($ListUsrValid->getelem()->usr_estado == 0?true:false)){
				$MiTemplate->set_var('notificacion', 'alert("El vendedor asociado al cliente se encuentra inactivo, se le asignara el código de vendedor que ingrese \n                 en la casilla (código), por defecto la aplicación ingresara su código de vendedor.");');
				$valid_codvendedor=false;
			}
	    }
	    
	    ////actualizar vendedor
	    if($valid_codvendedor){
	    	$MiTemplate->set_var('codigovendedor', trim($List->getelem()->codigovendedor));
			$MiTemplate->set_var('disabledcre', 'readonly');
	    }
	    else{
	    	$MiTemplate->set_var('codigovendedor',$ses_usr_codvendedor);
	    	$MiTemplate->set_var('disabledcre', '');
	    }
	    //general::writeevent($valid_codvendedor);
		$MiTemplate->set_var('valid_codvendedor',$valid_codvendedor);
	/*}
	else{
		$confimpv = new idvendedor("VENJUR");
		$cod_vendedor =$confimpv->VENDE;
		$MiTemplate->set_var('codigovendedor', $cod_vendedor);
		$MiTemplate->set_var('disabledcre', 'readonly');	
	}*/
}
else{
	$mensaje_error = 'Problemas al Recuperar el Tipo de Usuario. Contactese con el administrador';
}

$id_tipocliente = $List->getelem()->id_tipocliente;

/*Despliegue Tipo Venta*/
$List  = new connlist;
bizcve::gettipoventa($List);
$List->gofirst();
$MiTemplate->set_block('main' , "tipoventa" , "BLO_tipoventa");
if (!$List->isvoid()) {
	do {
		if ($List->getelem()->id != 1 ){//Elimina de la GUI tipo de venta VENTA CALZADA
		$MiTemplate->set_var('idventa', $List->getelem()->id);
		$MiTemplate->set_var('nomtipoventa', $List->getelem()->nombre);
		$MiTemplate->set_var('checked', ($List->getelem()->id==2)?'checked':'');
		//$MiTemplate->set_var('disabled', ($List->getelem()->id==1)?'disabled':''); //QUITAR PARA HABILITAR VENTA CALZADA
		$MiTemplate->parse("BLO_tipoventa", "tipoventa", true);
		}
	} while ($List->gonext());
}

/*Despliegue Condicion Venta*/
$List  = new connlist;
bizcve::gettipopago($List);
$List->gofirst();
$MiTemplate->set_block('main' , "tipocondicion" , "BLO_tipocondicion");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('idcondicion', $List->getelem()->id);
		$MiTemplate->set_var('nomtipocondicion', $List->getelem()->nombre);
		//$MiTemplate->set_var('checked', ($List->getelem()->id==$id_tipocliente)?'checked':'');
        $MiTemplate->parse("BLO_tipocondicion", "tipocondicion", true);
	} while ($List->gonext());
}

/*Despliegue informacion de Centro Suministro*/
/*$List  = new connlist;
bizcve::getlocales($List);
$List->gofirst();
$MiTemplate->set_block('main' , "centrosuministro" , "BLO_centrosuministro");
if (!$List->isvoid()) {
	do {
		if($ses_usr_codlocal == $List->getelem()->cod_local){
		$MiTemplate->set_var('codigo_local', $List->getelem()->cod_local);
		$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);	
		}
		//$MiTemplate->set_var('selected', ($ses_usr_codlocal == $List->getelem()->cod_local)?'selected':'');
        $MiTemplate->parse("BLO_centrosuministro", "centrosuministro", true);
	} while ($List->gonext());
}
*/
/* locales segun tipo de usuario*/
$Listusuario  = new connlist;
$mRegistrousu= new dtousuario;
$mRegistrousu->usr_id=$ses_usr_id;
$Listusuario->addlast($mRegistrousu);
bizcve::GetUsers($Listusuario);
$Listusuario->gofirst();

$MiTemplate->set_var('tienda_usuario', $Listusuario->getelem()->cod_local);

$List  = new connlist;
$mRegistrolocal = new dtolocal;
if($Listusuario->getelem()->id_tipousuario == 2){
	$List->clearlist();	
}
else{
	if(is_null($Listusuario->getelem()->cod_local) || trim($Listusuario->getelem()->cod_local)==''){
		$mRegistrolocal->cod_local="NoLocal";
		$MiTemplate->set_var('error_usuario',"error_usuario();");
	}
	else{
		$mRegistrolocal->cod_local=$Listusuario->getelem()->cod_local;
	}
	$List->addlast($mRegistrolocal);
}
bizcve::getcambiolocales($List);
$List->gofirst();
$MiTemplate->set_block('main' , "suministro" , "BLO_suministro");
if (!$List->isvoid()) {
	do {
			$MiTemplate->set_var('selectedlocal', ($List->getelem()->cod_local==$ses_usr_codlocal?'selected':''));
			$MiTemplate->set_var('codigo_local', $List->getelem()->cod_local);
			$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
			$MiTemplate->parse("BLO_suministro", "suministro", true);
	} while ($List->gonext());
}

$MiTemplate->set_var('codlocaldef', $ses_usr_codlocal);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>