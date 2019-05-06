<?php
$pag_ini='../nuevacotizacion/nueva_cotizacion_00.php';
include_once ("../../INCLUDE/ini.php");
include_once ("../../INCLUDE/autoload.php");
include_once ("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////
$confimp = new getidcontribuyente("CONTRIBUYENTE");
$opcioncon=$confimp->JURIDICO;
$opcioncon1=$confimp->EMPRESARIAL;
$opcioncon2=$confimp->SOCIOE;


	file_put_contents('grabar.txt', $accion);
if ($accion == 'grabar') {
	if(!bizcve::verificacionDePermisos($ses_usr_id,44, 'INSERT')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }
	
	$List = new connlist;
	$iClientes = new dtoinfocliente;
	$iClientes->rut =$_POST['rut'];
	$iClientes->razonsoc =$_POST['razonsoc'];
	$iClientes->fonocontacto =$_POST['fonocontactoe'];
	$iClientes->contacto =$_POST['contactoe'];
	$iClientes->email =$_POST['emaile'];
	($_POST['crearxmlcrearcliente']==1?$iClientes->codigovendedor =$ses_usr_codvendedor:'');
	$iClientes->direccion =$_POST['direccione'];
	$iClientes->id_comuna =$_POST['barrioajax'];
	$iClientes->id_clientepref =$List->getelem()->id_clientepref;		
    $iClientes->id_giro =$_POST['giro'];
    $iClientes->id_documento_identidad =$_POST['documentoid'];
    $iClientes->id_clasificacion_cli =$_POST['id_clasificacion_cli'];
    $iClientes->apellido =$_POST['apellido'];
    $iClientes->apellido1 =$_POST['apellido1'];
    $iClientes->celcontactoe =$_POST['celcontactoe'];
    $iClientes->fax =$_POST['fax'];
    if($_POST['crearxmlcrearcliente']){


    $iClientes->id_contribuyente =($_POST['crearxmlcrearcliente']==0?'':$_POST['id_contribuyente']);
    }
    else{

       
        $iClientes->id_contribuyente =$_POST['id_contribuyente'];	
    }
    $iClientes->id_regimencontri =$_POST['id_regimencontri'];
    $iClientes->rete_iva =$_POST['reteiva'];
    $iClientes->rete_ica =$_POST['reteica'];
    $iClientes->rete_renta =$_POST['retefuente'];
    $iClientes->genero =$_POST['genero'];
    $iClientes->id_profesion =$_POST['profesionid'];
    
	if($_POST['id_contribuyente'] == $opcioncon1){
	$iClientes->codlocaluco=TIENDA_VIRTUAL_ID;
	}
	else{


	$ListUsrSesion = new connlist;
	$DUser = new dtousuario;
	$DUser->usr_id =$ses_usr_id;
	$ListUsrSesion->addlast($DUser); 
	bizcve::GetUsers($ListUsrSesion);
	$ListUsrSesion->gofirst();
	$iClientes->codlocaluco=$ListUsrSesion->getelem()->cod_local;
	}
	
	$List->addlast($iClientes);
	$Listcrearxml=$iClientes;
	if (!bizcve::putcliente($List))
		$mensaje_error = 'Problemas al grabar el cliente. Cont&aacute;ctese con el administrador';

	general::writeevent('Se han modificado los siguientes datos del cliente desde el paso 2 de nueva cotizacion:  Razon Social: '.
	$_POST['razonsoc'].' Actividad Económica: '.$_POST['giro'].' Fono contacto: '.$_POST['fonocontactoe'].
	'contacto: '.$_POST['contactoe'].'email: '.$_POST['emaile'].'direccion: '.$_POST['direccione'].
	'comuna: '.$_POST['comunae'].'comentario: '.$_POST['comentarios'].'rubro: '.$_POST['select_rubro'].
	'Bloqueo CVE: '.$_POST['valorbox1']);
	
	$arr_dir = split(',', $_POST['tupla_dir_mod']);
	foreach($arr_dir as $key=>$value){
		//Grabamos cada direcciÃ³n
		if($value) {
			$List = new connlist;
			$iDireccion = new dtodireccion;
			$iDireccion->id_direccion = $value;			
			/*if($_POST['select_comunasd_'.$value]=='0'){
				general::alert('Debe ingresar comuna array');
				//exit();
				
				//header("Location: nueva_cotizacion_02.php?rut=" . $_POST['rut']);
				//exit();
			}
			else{
				$iDireccion->id_comuna = $_POST['select_comunasd_'.$value];		
			}*/
			$iDireccion->id_comuna = $_POST['barrioarray_'.$value];
			$iDireccion->rut = $_POST['rut_'.$value];
			$iDireccion->descripcion = $_POST['descripcion_'.$value];
			$iDireccion->direccion = $_POST['direccion_'.$value];
			$iDireccion->contacto = $_POST['contacto_'.$value];
			$iDireccion->fonocontacto = $_POST['fonocontacto_'.$value];
			$iDireccion->email = $_POST['email_'.$value];
			$iDireccion->comentario = $_POST['comentario_'.$value];
			$tipo_dir=($_POST['tipoobr_'.$value]?$_POST['tipoobr_'.$value]:($_POST['tiposoc_'.$value]?$_POST['tiposoc_'.$value]:'1'));
			$iDireccion->tipo_dir=$tipo_dir;
			$List->addlast($iDireccion);
			general::writeevent('Se han modificado los siguientes datos en la direccion de despacho del cliente desde el paso 2 de nueva cotizacion:  Numero direccion: '.
			$value.' descripcion: '.$_POST['descripcion_'.$value].' direccion: '.$_POST['direccion_'.$value].
			'contacto: '.$_POST['contacto_'.$value].'Teléfono1: '.$_POST['fonocontacto_'.$value].
			'email: '.$_POST['email_'.$value].'comentario: '.$_POST['comentario_'.$value].' Nuevo Campo soc'.$_POST['tiposoc_'.$value].' Nuevo Campo ob '.$_POST['tipoobr_'.$value].'respuesta para insert'.$tipo_dir);
			
			if (!bizcve::putdirdesp($List)) 
				$mensaje_error = 'Problemas al modificar la direcci&oacute;n. Cont&aacute;ctese con el administrador';			
		}
	}
	
$nombreSession = general::get_nombre_usr($ses_usr_id);

	bizcve::setevento(16, 'Direcciones de despacho', $_SERVER['REMOTE_ADDR'], 'ABM de cotizacion',
                    'Se ha Modificado la dirección de despacho para el cliente con el rut: '.$_POST['rut'].' ','','Se ha modificado la dirección de despacho', $nombreSession);



	
if((($_POST['crearxmlcrearcliente']==1) && ($_POST['camposdesabilitados']==1))||($_POST['camposdesabilitados']==1)){

	file_put_contents('crearXmL.txt', "entro a update");
	
//llamada al metodo update para actualizar los datos en cliente unico
	$ListCliCVE = new connlist;
	$ClientesCVE = new dtoinfocliente;
	$ClientesCVE->rut=$_GET['rut'];
	$ListCliCVE->addlast($ClientesCVE);
	bizcve::getCliente($ListCliCVE);
	$ListCliCVE->gofirst();
	
	
	$ListCliWS = new connlist;
	$ClienteWS = new dtoinfocliente;
	$ClienteWS->rut =$ListCliCVE->getelem()->rut;
	$ClienteWS->razonsoc =$ListCliCVE->getelem()->razonsoc;
	$ClienteWS->fonocontacto =$ListCliCVE->getelem()->fonocontacto;
	$ClienteWS->contacto =$ListCliCVE->getelem()->contacto;
	$ClienteWS->email =$ListCliCVE->getelem()->email;
	$ClienteWS->direccion =$ListCliCVE->getelem()->direccion;
	$ClienteWS->id_comuna =$ListCliCVE->getelem()->id_comuna;
	$ClienteWS->id_clientepref =$ListCliCVE->getelem()->id_clientepref;		
    $ClienteWS->id_giro =$ListCliCVE->getelem()->id_giro;
    $ClienteWS->id_documento_identidad =$ListCliCVE->getelem()->id_documento_identidad;
    $ClienteWS->id_clasificacion_cli =$ListCliCVE->getelem()->id_clasificacion_cli;
    $ClienteWS->apellido =$ListCliCVE->getelem()->apellido;
    $ClienteWS->apellido1 =$ListCliCVE->getelem()->apellido1;
    $ClienteWS->celcontactoe =$ListCliCVE->getelem()->celcontactoe;
    $ClienteWS->fax =$ListCliCVE->getelem()->fax;
    $ClienteWS->id_contribuyente =$ListCliCVE->getelem()->id_contribuyente;
    $ClienteWS->id_regimencontri =$ListCliCVE->getelem()->id_regimencontri;
    $ClienteWS->rete_iva =$ListCliCVE->getelem()->rete_iva;
    $ClienteWS->rete_ica =$ListCliCVE->getelem()->rete_ica;
    $ClienteWS->rete_renta =$ListCliCVE->getelem()->rete_renta;
    $ClienteWS->genero =$ListCliCVE->getelem()->genero;
    $ClienteWS->id_profesion =$ListCliCVE->getelem()->id_profesion;
	$ClienteWS->codlocaluco=$ses_usr_codlocal;
	$ListCliWS->addlast($ClienteWS);
	if(($_POST['camposdesabilitados']==1) &&($_POST['crearxmlcrearcliente']!=1)){

 
	   file_put_contents('crearUpdateWs.txt', print_r($ListCliWS,true));
	    bizcve::wsupdatecliente($ListCliWS);
	}
	else
	{	
	  file_put_contents('crearClienteWs.txt', print_r($ListCliWS,true));	
  	bizcve::wscrearcliente($ListCliWS);
	}
		
//grabar el cliente por medio de ws
}
else{

	  	file_put_contents('crearWS.txt', "medio WS");
		$Listxml = new connlist;
  		$Listxml->addlast($Listcrearxml);
		if(($_POST['crearxmlcrearcliente']==0)){
  			bizcve::wsupdatecliente($Listxml);
		}
		else{
			bizcve::wscrearcliente($Listxml);
		}
}

	
	header("Location: nueva_cotizacion_02.php?rut=" .$_POST['rut']);
	
}	

if ($accion == 'elidir') {
if(!bizcve::verificacionDePermisos($ses_usr_id,44, 'INSERT')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }
	$List = new connlist;
	$iDireccion = new dtodireccion;
	$iDireccion->rut =$_GET['rut'];
	$iDireccion->id_direccion =$_POST['id_direccion_elim'];
	$List->addlast($iDireccion);
	
	if (!bizcve::deldirdesp($List)) 
		$mensaje_error = 'Problemas al eliminar la direcci &oacute;n. ContÃ¡ctese con el administrador';
	general::writeevent('Se ha eliminado la direccion N: '.$_POST['id_direccion_elim'].' del cliente con el rut: '.$_GET['rut'].' desde el paso 2 de nueva cotizacion.');
	$nombreSession = general::get_nombre_usr($ses_usr_id);

	bizcve::setevento(17, 'Direcciones de despacho', $_SERVER['REMOTE_ADDR'], 'ABM de cotizacion',
                    'Se ha Eliminado la dirección de despacho para el cliente con el rut: '.$_POST['rut'].' ','','Se ha eliminado la dirección de despacho', $nombreSession);

	$List = new connlist;
	$iClientes = new dtoinfocliente;
	$iClientes->rut =$_POST['rut'];
	$iClientes->razonsoc =$_POST['razonsoc'];
	$iClientes->fonocontacto =$_POST['fonocontactoe'];
	$iClientes->contacto =$_POST['contactoe'];
	$iClientes->email =$_POST['emaile'];
	$iClientes->direccion =$_POST['direccione'];
	$iClientes->id_comuna =$_POST['id_barrio'];
	$iClientes->id_giro =$_POST['giro'];
	
	$iClientes->codlocaluco=$ses_usr_codlocal;
	$List->addlast($iClientes);
	if (!bizcve::putcliente($List))
		$mensaje_error = 'Problemas al grabar el cliente. Cont&aacute;ctese con el administrador';

	general::writeevent('Se han modificado los siguientes datos del cliente desde el paso 2 de nueva cotizacion:  Razon Social: '.
	$_POST['razonsoc'].' Actividad Económica: '.$_POST['giro'].' Fono contacto: '.$_POST['fonocontactoe'].
	'contacto: '.$_POST['contactoe'].'email: '.$_POST['emaile'].'direccion: '.$_POST['direccione'].
	'comuna: '.$_POST['comunae'].'comentario: '.$_POST['comentarios'].'rubro: '.$_POST['select_rubro'].
	'Bloqueo CVE: '.$_POST['valorbox1']);

}

if ($accion == 'adddir') {
	if(!bizcve::verificacionDePermisos($ses_usr_id,44, 'INSERT')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }
	$List = new connlist;
	$iDireccion = new dtodireccion;
	$iDireccion->rut =$_GET['rut'];
	$List->addlast($iDireccion);
	
	general::writeevent('Se han modificado los siguientes datos en la direccion de despacho del cliente desde el monitor de vendedores:  Numero direccion: '.
			$value.' descripcion: '.$_POST['descripcion_'.$value].' direccion: '.$_POST['direccion_'.$value].
			'contacto: '.$_POST['contacto_'.$value].'fono contacto: '.$_POST['fonocontacto_'.$value].
			'email: '.$_POST['email_'.$value].'comentario: '.$_POST['comentario_'.$value]);
	
	if (!bizcve::putdirdesp($List)) 
		$mensaje_error = 'Problemas al agregar la nueva direccion. Contactese con el administrador';
	
	$List = new connlist;
	$iClientes = new dtoinfocliente;
	$iClientes->rut =$_POST['rut'];
	$iClientes->razonsoc =$_POST['razonsoc'];
	$iClientes->fonocontacto =$_POST['fonocontactoe'];
	$iClientes->contacto =$_POST['contactoe'];
	($_POST['crearxmlcrearcliente']==1?$iClientes->codigovendedor =$ses_usr_codvendedor:'');
	$iClientes->email =$_POST['emaile'];
	$iClientes->direccion =$_POST['direccione'];
	$iClientes->id_comuna =$_POST['barrioajax'];
	$iClientes->id_clientepref =$List->getelem()->id_clientepref;		
    $iClientes->id_giro =$_POST['giro'];
    $iClientes->id_documento_identidad =$_POST['documentoid'];
    $iClientes->id_clasificacion_cli =$_POST['id_clasificacion_cli'];
    $iClientes->apellido =$_POST['apellido'];
    $iClientes->apellido1 =$_POST['apellido1'];
    $iClientes->celcontactoe =$_POST['celcontactoe'];
    $iClientes->fax =$_POST['fax'];
	if($_POST['crearxmlcrearcliente']){
    $iClientes->id_contribuyente =($_POST['crearxmlcrearcliente']==0?'':$_POST['id_contribuyente']);
    }
    else{
    $iClientes->id_contribuyente =$_POST['id_contribuyente'];	
    }
    $iClientes->id_regimencontri =$_POST['id_regimencontri'];
    $iClientes->rete_iva =$_POST['reteiva'];
    $iClientes->rete_ica =$_POST['reteica'];
    $iClientes->rete_renta =$_POST['retefuente'];
    $iClientes->genero =$_POST['genero'];
	$iClientes->codlocaluco=$ses_usr_codlocal;
	$List->addlast($iClientes);
	if (!bizcve::putcliente($List))
		$mensaje_error = 'Problemas al grabar el cliente. Cont?ctese con el administrador';
	$nombreSession = general::get_nombre_usr($ses_usr_id);

	bizcve::setevento(15, 'Direcciones de despacho', $_SERVER['REMOTE_ADDR'], 'ABM de cotizacion',
                    'Se ha Eliminado la dirección de despacho para el cliente con el rut: '.$_POST['rut'].' ','','Se ha eliminado la dirección de despacho', $nombreSession);

	general::writeevent('Se han modificado los siguientes datos del cliente desde el paso 2 de nueva cotizacion:  Razon Social: '.
	$_POST['razonsoc'].' Actividad Económica: '.$_POST['giro'].' Fono contacto: '.$_POST['fonocontactoe'].
	'contacto: '.$_POST['contactoe'].'email: '.$_POST['emaile'].'direccion: '.$_POST['direccione'].
	'comuna: '.$_POST['comunae'].'comentario: '.$_POST['comentarios'].'rubro: '.$_POST['select_rubro'].
	'Bloqueo CVE: '.$_POST['valorbox1']);


}


//Obtengo el credito del cliente mediante el webservice
$credito = ConsultarClienteOnline($_GET['rut']);

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////


$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);
//file_put_contents('grabar.txt', TEMPLATE . "presentacion/header.htm");
/*Inclusi?n de header*/
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
/**/

/* Inclusi?n de main*/
/* */
$MiTemplate->set_file("main", TEMPLATE . "nuevacotizacion/nueva_cotizacion_01.htm");
$MiTemplate->set_file("bloque_comunad", TEMPLATE . "nuevacotizacion/nueva_cotizacion_011.htm");

if(isset($_REQUEST['faldat']))
{
	$MiTemplate->set_var('exclama',"<img src=\"../../IMAGES/icon4.gif\" />");
}

/**/

$MiTemplate->set_var('crearxmlcrearcliente',$_GET['crearxmlcrearcliente']);
/*$confimp = new getidcontribuyente("CONTRIBUYENTE");
$opcioncon=$confimp->JURIDICO;
$opcioncon1=$confimp->EMPRESARIAL;*/
/*Despliegue de Datos de Cliente*/
$List  = new connlist;
$rut=$_GET['rut'];
$id_contribuyente=$_GET['tipocliente'];
$mRegistro->rut=$rut;
$List->addlast($mRegistro);
bizcve::getCliente($List);
$List->gofirst();
	
	$MiTemplate->set_var('rut',$rut);
	$MiTemplate->set_var('noaplica', '<option value="N" >NO APLICA</option>');
	$MiTemplate->set_var('masculino', '<option value="M" >MASCULINO</option>');
	$MiTemplate->set_var('femenino','<option value="F" >FEMENINO</option>');
	$MiTemplate->set_var('id_contribuyente',$id_contribuyente);
if (!$List->isvoid()) {
	/*if($List->getelem()->id_contribuyente != $id_contribuyente){
		header("Location: nueva_cotizacion_00.php?error=4");
		exit;
	}*/
	$id_clientepref=$List->getelem()->id_clientepref;	
	$MiTemplate->set_var('razonsoc',$List->getelem()->razonsoc);
	$MiTemplate->set_var('fonocontactoe', $List->getelem()->fonocontacto);
	$MiTemplate->set_var('contactoe', trim($List->getelem()->contacto));
	$MiTemplate->set_var('nomciudad', $List->getelem()->nomciudad);
	$MiTemplate->set_var('emaile', $List->getelem()->email);
	$MiTemplate->set_var('direccione', $List->getelem()->direccion);
	//$MiTemplate->set_var('id_comuna', $List->getelem()->id_comuna);
	//$id_comunainter = $List->getelem()->id_comuna;
	//$comuna=$List->getelem()->id_comuna;
	((strlen($List->getelem()->id_comuna)<14)?$localizacioncli='0'.$List->getelem()->id_comuna : $localizacioncli=$List->getelem()->id_comuna);
	$localizaciondepto=substr($localizacioncli, 0, -12);
	$localizacionprovin=substr($localizacioncli, 2, -9);
	$localizacionciudad=substr($localizacioncli, 5, -6);
	$localizacionbarrio=substr($localizacioncli, 11);
	$MiTemplate->set_var('nomcomuna', $List->getelem()->nomcomuna);
	$MiTemplate->set_var('id_comuna2', $List->getelem()->id_comuna);
	$MiTemplate->set_var('id_ciudad', $List->getelem()->id_ciudad);
	$MiTemplate->set_var('nomrubro', $List->getelem()->nomrubro);
	$MiTemplate->set_var('descripcion', $List->getelem()->giro);
	$MiTemplate->set_var('id_giro', $List->getelem()->id_giro);
	$MiTemplate->set_var('apellido', trim($List->getelem()->apellido));
	$MiTemplate->set_var('apellido1', trim($List->getelem()->apellido1));
	$MiTemplate->set_var('celcontactoe', $List->getelem()->celcontactoe);
	$MiTemplate->set_var('fax', $List->getelem()->fax);
	//$MiTemplate->set_var('id_giro2', $List->getelem()->id_giro);
	//$girotexto = trim($List->getelem()->giro);
	//$giro= trim($List->getelem()->id_giro);
	$razonsoc = trim($List->getelem()->razonsoc);
	$contacto = trim($List->getelem()->contacto);
	$fonocontacto =	trim($List->getelem()->fonocontacto);
	$correo = trim($List->getelem()->email);
	$direccion = trim($List->getelem()->direccion);
	$id_documento_iden = trim($List->getelem()->id_documento_identidad);
	$id_clasifica = trim($List->getelem()->id_clasificacion_cli);
	$id_contri = trim($List->getelem()->id_regimencontri);
	$id_contribu = trim($List->getelem()->id_contribuyente);
	$id_giroselect = trim($List->getelem()->id_giro);
	$id_profesion = trim($List->getelem()->id_profesion);
	if($id_contribu){
		if($id_contribu==$opcioncon1){
		$MiTemplate->set_var('rutdv',$rut.'-'.general::digiVer($rut));
		}
		else{
		$MiTemplate->set_var('rutdv',$rut);
		}
	}
	else{
		if($id_contribuyente==$opcioncon1){
		$MiTemplate->set_var('rutdv',$rut.'-'.general::digiVer($rut));
		}
		else{
		$MiTemplate->set_var('rutdv',$rut);
		}
	}
	$MiTemplate->set_var('checkiva', (($List->getelem()->rete_iva==1)?'checked="checked"':''));
	$MiTemplate->set_var('checkica', (($List->getelem()->rete_ica==1)?'checked="checked"':''));
	$MiTemplate->set_var('checkrenta', (($List->getelem()->rete_renta==1)?'checked="checked"':''));
	$MiTemplate->set_var('noaplica', (($List->getelem()->genero=="N")?'<option value="N" selected>NO APLICA</option>':'<option value="NA">NO APLICA</option>'));
	$MiTemplate->set_var('masculino', (($List->getelem()->genero=="M")?'<option value="M" selected>MASCULINO</option>':'<option value="M">MASCULINO</option>'));
	$MiTemplate->set_var('femenino', (($List->getelem()->genero=="F")?'<option value="F" selected>FEMENINO</option>':'<option value="F">FEMENINO</option>'));	
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
	
	if($List->getelem()->id_tipocliente==1||$List->getelem()->razonsoc) {
			$MiTemplate->set_var('camposdesabilitados','1');
			// Comienzo dehabilitacion de campos 20-12-2011
			$MiTemplate->set_var('deshabilitadorazonsoc','disabled');
			$MiTemplate->set_var('deshabilitadocontactoe','disabled');
			$MiTemplate->set_var('deshabilitadoapellido','disabled');
			$MiTemplate->set_var('deshabilitadoapellido1','disabled');
			$MiTemplate->set_var('deshabilitadoemaile','disabled');
			$MiTemplate->set_var('deshabilitadodocumentoid','disabled');
			$MiTemplate->set_var('deshabilitadoid_clasificacion_cli','disabled');
			$MiTemplate->set_var('deshabilitadogenero','disabled');
			$MiTemplate->set_var('deshabilitadofax','disabled');
			$MiTemplate->set_var('deshabilitadocelcontactoe','disabled');
			$MiTemplate->set_var('deshabilitadofonocontactoe','disabled');
			$MiTemplate->set_var('deshabilitadoprofesionid','disabled');
			$MiTemplate->set_var('deshabilitadodireccione','disabled');
			$MiTemplate->set_var('deshabilitadolocalizacion','disabled');
			$MiTemplate->set_var('deshabilitadogiro','disabled');
			$MiTemplate->set_var('deshabilitadolocalizacion','disabled');
			$MiTemplate->set_var('deshabilitadolocalizacion','disabled');
			
/*			
		if(!$List->getelem()->razonsoc||empty($razonsoc)||($List->getelem()->razonsoc=='')){
			$MiTemplate->set_var('deshabilitadorazonsoc','');		
		}else{
			$MiTemplate->set_var('deshabilitadorazonsoc','disabled');
		}

		if(!$List->getelem()->contacto||empty($contacto)||(trim($List->getelem()->contacto)=='')){
	    		$MiTemplate->set_var('deshabilitadocontactoe','');
    	}else{
			$MiTemplate->set_var('deshabilitadocontactoe','disabled');
        }
		
		if(trim($List->getelem()->apellido)==''){
	    		$MiTemplate->set_var('deshabilitadoapellido','');
    	}else{
			$MiTemplate->set_var('deshabilitadoapellido','disabled');
        }
        
		if(trim($List->getelem()->apellido1)==''){
	    		$MiTemplate->set_var('deshabilitadoapellido1','');
    	}else{
			$MiTemplate->set_var('deshabilitadoapellido1','disabled');
        }
        if(!$List->getelem()->fonocontacto||empty($fonocontacto)||($List->getelem()->fonocontacto=='')){
                $MiTemplate->set_var('deshabilitadofonocontactoe','');
        }else{
            $MiTemplate->set_var('deshabilitadofonocontactoe','disabled');
        }

        if(empty($correo)){
			$MiTemplate->set_var('deshabilitadoemaile','');
    	}else{
			$MiTemplate->set_var('deshabilitadoemaile','disabled');
		}
		
		if($List->getelem()->id_documento_identidad==0){
	    		$MiTemplate->set_var('deshabilitadodocumentoid','');
    	}else{
			$MiTemplate->set_var('deshabilitadodocumentoid','disabled');
        }
		if($List->getelem()->id_clasificacion_cli==0){
	    		$MiTemplate->set_var('deshabilitadoid_clasificacion_cli','');
    	}else{
			$MiTemplate->set_var('deshabilitadoid_clasificacion_cli','disabled');
        }
		if($List->getelem()->genero==''){
	    		$MiTemplate->set_var('deshabilitadogenero','');
    	}else{
			$MiTemplate->set_var('deshabilitadogenero','disabled');
        }
		/*if($List->getelem()->celcontactoe==''){
	    		$MiTemplate->set_var('deshabilitadocelcontactoe','');
    	}else{
			$MiTemplate->set_var('deshabilitadocelcontactoe','disabled');
        }
		if($List->getelem()->fax==''){
	    		$MiTemplate->set_var('deshabilitadofax','');
    	}else{
			$MiTemplate->set_var('deshabilitadofax','disabled');
        }*/
		if($List->getelem()->id_regimencontri=='' || $List->getelem()->id_regimencontri==0){
	    		$MiTemplate->set_var('deshabilitadoid_regimencontri','');
    	}else{
			$MiTemplate->set_var('deshabilitadoid_regimencontri','disabled');
        }
		
        if($List->getelem()->id_giro==''){
	    	$MiTemplate->set_var('deshabilitadogiro','');
    	}else{
			$MiTemplate->set_var('deshabilitadogiro','disabled');
        }
        if(($comuna===' ')||($comuna==null)||(empty($comuna))){
			$MiTemplate->set_var('deshabilitadocomunae','');
		}else{
			$MiTemplate->set_var('deshabilitadocomunae','disabled');
		}
		
		$MiTemplate->set_var('deshabilitadoprofesionid','disabled');
		$MiTemplate->set_var('deshabilitadoimpuesto','disabled');

	}
	
	$MiTemplate->set_var('id_tipocliente', $List->getelem()->id_tipocliente);
	//$MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente); 
    $MiTemplate->set_var('nomtipcliente', ($_GET['crearxmlcrearcliente']==0?$List->getelem()->direccionservicio:'Creando El Cliente'));
	$MiTemplate->set_var('vendedor', $List->getelem()->vendedor);
	
	//Intento consultar los datos online del webservice
	$marca_bloqueos = 0;
	if ($credito != false) {
		$disponible = $credito['limite_disponible'];
		
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
		$disponible = bizcve::getdisponible($List);
		
		if ($List->getelem()->locksap) {
			$MiTemplate->set_var('locksap', '<li>Cliente Bloqueado en SAP</li>');
			$marca_bloqueos = 1;
		}
		if ($List->getelem()->lockmoro) {
			$MiTemplate->set_var('lockmoro', '<li>Cliente Bloqueado por Morosidad</li>');
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
}
else {
		
}
/*FinDespliegue de Datos de Cliente*/

/*Despliegue SelecciÃ³n Giro*/
$Listc  = new connlist;
bizcve::getgiro($Listc);
$Listc->gofirst();

if (!$Listc->isvoid()) {
$MiTemplate->set_block('main' , "giro" , "BLO_giro");	
       do {
             $MiTemplate->set_var('id_giro', $Listc->getelem()->id);
             $MiTemplate->set_var('descripcion', $Listc->getelem()->nombre);
             $MiTemplate->set_var('selectedgiro', ($List->getelem()->id_giro == $Listc->getelem()->id)?'selected':'');
             $MiTemplate->parse("BLO_giro", "giro", true);     
       } while ($Listc->gonext());

}
/*Fin Despliegue SelecciÃ³n Giro*/
/* despilegue de los diferentes tipod de documentos de identidad*/
$Listdocu  = new connlist;
bizcve::gettipodocumentoidentidad($Listdocu);
$Listdocu->gofirst();
if (!$Listdocu->isvoid()) {
$MiTemplate->set_block('main' , "tipodoc" , "BLO_tipodoc");
	do {
		$MiTemplate->set_var('id_documento_identidad', $Listdocu->getelem()->id_documento_identidad);
		$MiTemplate->set_var('siglas_documento', $Listdocu->getelem()->siglas_documento);
		$MiTemplate->set_var('descripcion_documento', $Listdocu->getelem()->descripcion_documento);
		$MiTemplate->set_var('selected', (($id_documento_iden == $Listdocu->getelem()->id_documento_identidad)?'selected':''));
		$MiTemplate->parse("BLO_tipodoc", "tipodoc", true);	
	} while ($Listdocu->gonext());
}
/* fin despliegue*/
/* despilegue de los diferentes categorias para un cliente*/
$Listdocu  = new connlist;
bizcve::getclasificacioncliente($Listdocu);
$Listdocu->gofirst();
if (!$Listdocu->isvoid()) {
$MiTemplate->set_block('main' , "categoriacli" , "BLO_categoriacli");
	do {
		$MiTemplate->set_var('id_clasificacion_cli', $Listdocu->getelem()->id_clasificacion_cli);
		$MiTemplate->set_var('descripcion_clasificacion', $Listdocu->getelem()->descripcion_clasificacion);
		$MiTemplate->set_var('selectedcla', (($id_clasifica == $Listdocu->getelem()->id_clasificacion_cli)?'selected':''));
		$MiTemplate->parse("BLO_categoriacli", "categoriacli", true);	
	} while ($Listdocu->gonext());
}
 /* despliegue del tipo de contribuyente*/
$Listdocu  = new connlist;
bizcve::getcontribuyente($Listdocu);
$Listdocu->gofirst();
if (!$Listdocu->isvoid()) {
$MiTemplate->set_block('main' , "contribuyente" , "BLO_contribuyente");
	do {
		$MiTemplate->set_var('id_regimencontri', $Listdocu->getelem()->id_regimencontri);
		$MiTemplate->set_var('descripcionregimen', $Listdocu->getelem()->descripcionregimen);
		$MiTemplate->set_var('selectedcontri', (($id_contri == $Listdocu->getelem()->id_regimencontri)?'selected':''));
		$MiTemplate->parse("BLO_contribuyente", "contribuyente", true);	
	} while ($Listdocu->gonext());
}

$Listprofesion  = new connlist;
bizcve::getprofesion($Listprofesion);
$Listprofesion->gofirst();
if (!$Listprofesion->isvoid()) {
$MiTemplate->set_block('main' , "tipoprofesion" , "BLO_tipoprofesion");
	do {
		$MiTemplate->set_var('id_profesion_cli', $Listprofesion->getelem()->id_profesion);
		$MiTemplate->set_var('descripcion_profesion', $Listprofesion->getelem()->descripcion);
		$MiTemplate->set_var('selectedprofesion', (($id_profesion == $Listprofesion->getelem()->id_profesion)?'selected':''));
		$MiTemplate->parse("BLO_tipoprofesion", "tipoprofesion", true);	
	} while ($Listprofesion->gonext());
}

$ListCi = new connlist;
bizcve::getciudad($ListCi);
$ListCi->gofirst();

if(!$ListCi->isvoid()){
	$MiTemplate->set_block('main', "ciudades", "BLO_ciudades");
	do{
		
		$MiTemplate->set_var('id_ciudad', $ListCi->getelem()->id_ciudad);
		$MiTemplate->set_var('nomciudad', $ListCi->getelem()->nomciudad);
		
		$MiTemplate->parse("BLO_ciudades", "ciudades", true);	
	    
	}while($ListCi->gonext());
}
/*FIN DE OPTENCION DE CIUDADES*/
/*lista los departamentos*/
$ListCiu = new connlist;
bizcve::getdepartamentos($ListCiu);
$ListCiu->gofirst();

if(!$ListCiu->isvoid()){
	$MiTemplate->set_block('main', "departamentoms", "BLO_departamentoms");
	do{
		
		$MiTemplate->set_var('id_depto', $ListCiu->getelem()->id_ciudad);
		$MiTemplate->set_var('nomdepto', $ListCiu->getelem()->nomciudad);
		$MiTemplate->set_var('selecteddepto', (($localizaciondepto+0 == $ListCiu->getelem()->id_ciudad)?'selected':''));
		$MiTemplate->parse("BLO_departamentoms", "departamentoms", true);	
	    
	}while($ListCiu->gonext());
}
/*lista de las ciudades*/
if($localizaciondepto!='')
{
	$List = new connlist;
	bizcve::getciudades($List, $localizaciondepto);  
	$List->gofirst();
	
if (!$List->isvoid()){
		$MiTemplate->set_block('main', "ciudadesms", "BLO_ciudadesms");
		do {
		
			 $contador=strlen($List->getelem()->id_region);
			 $contador=3-$contador;
			 $adicioncadena=str_repeat("0", $contador);
			 $List->getelem()->id_region=''.$adicioncadena.''.$List->getelem()->id_region;
			 $contador='';
			 $contador=strlen($List->getelem()->id_ciudad);
			 $contador=3-$contador;
			 $adicioncadena=str_repeat("0", $contador);
			 $List->getelem()->id_ciudad=''.$adicioncadena.''.$List->getelem()->id_ciudad; 
			 
        $MiTemplate->set_var('id_ciudadajax', $List->getelem()->id_region.''.$List->getelem()->id_ciudad);
		$MiTemplate->set_var('nomciudadajax', $List->getelem()->nomciudad);
		$MiTemplate->set_var('selectedciudadajax', (($localizacionprovin.''.$localizacionciudad == $List->getelem()->id_region.''.$List->getelem()->id_ciudad)?'selected':''));
		$MiTemplate->parse("BLO_ciudadesms", "ciudadesms", true);				
		} while ($List->gonext());
	}
}
else{
}

if($localizaciondepto!='' and $localizacionprovin!='' and $localizacionciudad!=''){
$List = new connlist;
	bizcve::getbarrios($List, $localizaciondepto,$localizacionciudad,$localizacionprovin);  
	$List->gofirst();
   
	if (!$List->isvoid()){
		$MiTemplate->set_block('main', "barrioms", "BLO_barrioms");
		do {
			
            $MiTemplate->set_var('id_barriojax', $List->getelem()->id_comuna);
			$MiTemplate->set_var('nombarrioajax', $List->getelem()->nomcomuna.' - '.$List->getelem()->nomcomunad);
			$MiTemplate->set_var('selectedbarrioajax', (($localizacioncli == $List->getelem()->id_comuna)?'selected':''));
			$MiTemplate->parse("BLO_barrioms", "barrioms", true);				
		} while ($List->gonext());
		echo $imprime.'</select>';
		}
}
else{
}
/*Despliegue direcciones despacho*/
$List  = new connlist;
$rut=$_GET['rut'];
$mRegistro->rut=$rut;
$List->addlast($mRegistro);

bizcve::getdirdesp($List); 
$List->gofirst();   
$MiTemplate->set_block('main' , "direcciones" , "BLO_direcciones");
if (!$List->isvoid()) {
	do {
		$contadorarreglo=$contadorarreglo+1;
		$MiTemplate->set_var('conteolinea', $contadorarreglo);
		$localizacioncli='';
		$MiTemplate->set_var('id_direccion', $List->getelem()->id_direccion);
		$MiTemplate->set_var('descripcion', $List->getelem()->descripcion);
		$MiTemplate->set_var('direccion', $List->getelem()->direccion);
		$MiTemplate->set_var('contacto', $List->getelem()->contacto);
		$MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);
		$MiTemplate->set_var('email', $List->getelem()->email);
		$MiTemplate->set_var('comentario', $List->getelem()->comentario);
		$MiTemplate->set_var('tobrchec', ($List->getelem()->tipo_dir==2?'checked="checked"':''));
		$MiTemplate->set_var('tsocchec', ($List->getelem()->tipo_dir==3?'checked="checked"':''));
		$localizacioncli=  $List->getelem()->id_comuna;
		((strlen($List->getelem()->id_comuna)<14)?$localizacioncli='0'.$List->getelem()->id_comuna : $localizacioncli=$List->getelem()->id_comuna);
		$localizaciondepto='';$localizacionprovin='';$localizacionciudad='';$localizacionbarrio='';
		$localizaciondepto=substr($localizacioncli, 0, -12);
		$localizacionprovin=substr($localizacioncli, 2, -9);
		$localizacionciudad=substr($localizacioncli, 5, -6);
		$localizacionbarrio=substr($localizacioncli, 11);
		$localizacioncli+0;
		

$ListCiu = new connlist;
bizcve::getdepartamentos($ListCiu);
$ListCiu->gofirst();
if(!$ListCiu->isvoid()){
	
	do{
		 (($localizaciondepto == $ListCiu->getelem()->id_ciudad)?$selecdeparray=$selecdeparray.'<option value="'.$ListCiu->getelem()->id_ciudad.'" selected>'.$ListCiu->getelem()->nomciudad.'</option>':$selecdeparray=$selecdeparray.'<option value="'.$ListCiu->getelem()->id_ciudad.'">'.$ListCiu->getelem()->nomciudad.'</option>');
	
	}while($ListCiu->gonext());
	$MiTemplate->set_var('bloque_deptoarray_'.$List->getelem()->id_direccion.'', $selecdeparray);
	$selecdeparray='';
}


	if($localizaciondepto!='' and $localizacioncli >0)
{
	
	$ListCiudad = new connlist;
	bizcve::getciudades($ListCiudad, $localizaciondepto);  
	$ListCiudad->gofirst();
	
if (!$ListCiudad->isvoid()){
		
		do {
		
			 $contador=strlen($ListCiudad->getelem()->id_region);
			 $contador=3-$contador;
			 $adicioncadena=str_repeat("0", $contador);
			 $ListCiudad->getelem()->id_region=''.$adicioncadena.''.$ListCiudad->getelem()->id_region;
			 $contador='';
			 $contador=strlen($ListCiudad->getelem()->id_ciudad);
			 $contador=3-$contador;
			 $adicioncadena=str_repeat("0", $contador);
			 $ListCiudad->getelem()->id_ciudad=''.$adicioncadena.''.$ListCiudad->getelem()->id_ciudad; 
        	(($localizacionprovin.''.$localizacionciudad == $ListCiudad->getelem()->id_region.''.$ListCiudad->getelem()->id_ciudad)?$selecdeparray=$selecdeparray.'<option value="'.$ListCiudad->getelem()->id_region.''.$ListCiudad->getelem()->id_ciudad.'" selected>'.$ListCiudad->getelem()->nomciudad.'</option>' : $selecdeparray=$selecdeparray.'<option value="'.$ListCiudad->getelem()->id_region.''.$ListCiudad->getelem()->id_ciudad.'">'.$ListCiudad->getelem()->nomciudad.'</option>');
					
		} while ($ListCiudad->gonext());

		$MiTemplate->set_var('bloque_ciudadarray_'.$List->getelem()->id_direccion.'', $selecdeparray);
		$selecdeparray='';
	}
}
else{
}

if($localizaciondepto!='' and $localizacionprovin!='' and $localizacionciudad!='' and $localizacioncli >0){
$ListBarrio = new connlist;
	bizcve::getbarrios($ListBarrio, $localizaciondepto,$localizacionciudad,$localizacionprovin);  
	$ListBarrio->gofirst();
   
	if (!$ListBarrio->isvoid()){
		
		do {
			
			(($localizacioncli == $ListBarrio->getelem()->id_comuna)?$selecdeparray=$selecdeparray.'<option value="'.$ListBarrio->getelem()->id_comuna.'" selected>'.$ListBarrio->getelem()->nomcomuna.' - '.$ListBarrio->getelem()->nomcomunad.'</option>':$selecdeparray=$selecdeparray.'<option value="'.$ListBarrio->getelem()->id_comuna.'">'.$ListBarrio->getelem()->nomcomuna.' - '.$ListBarrio->getelem()->nomcomunad.'</option>');				
		
		} while ($ListBarrio->gonext());
		$MiTemplate->set_var('bloque_barrioarray_'.$List->getelem()->id_direccion.'', $selecdeparray);
		$selecdeparray='';
		}
}
else{
}
	

		$comunad=  $List->getelem()->id_comuna;
		
		/*VERIFICO COTIZACIONES ASOCIADAS A ID_DIRECCION*/
		$ListEnc  = new connlist;
		$ListDet = new connlist;
		$mRegistroc = new dtocotizacion;
		$id_direccion=$List->getelem()->id_direccion;
		$mRegistroc->id_dirdespacho=$id_direccion;
		
		$ListEnc->addlast($mRegistroc);
		bizcve::getcountcotizacion($ListEnc);
		$nelemcot=$ListEnc->numelem();
		$MiTemplate->set_var('num_elem_cot', $nelemcot);
		
		/*VERIFICO OE ASOCIADAS A ID_DIRECCION*/
		$ListEnc  = new connlist;
		$ListDet = new connlist;
		$mRegistroa = new dtoencordenent;
		$id_direccion=$List->getelem()->id_direccion;
		$mRegistroa->id_direccion=$id_direccion;
		
		$ListEnc->addlast($mRegistroa);
		bizcve::getordenent($ListEnc, $ListDet);
		$numa=$ListEnc->numelem();
		$MiTemplate->set_var('num_elem_oe', $numa);
		
		/*VERIFICO OP ASOCIADAS A ID_DIRECCION*/		
		$ListEnc  = new connlist;
		$ListDet = new connlist;
		$mRegistrob = new dtoencordenpicking;
		$id_direccion=$List->getelem()->id_direccion;
		$mRegistrob->id_direccion=$id_direccion;
		
		$ListEnc->addlast($mRegistrob);
		bizcve::getordenpick($ListEnc, $ListDet);
		$numb=$ListEnc->numelem();
		$MiTemplate->set_var('num_elem_op', $numb);		

			$Lista= new connlist;
		
		bizcve::getcomunad($Lista);
		
			$Lista->gofirst();
			$MiTemplate->unset_var("bloque_comunad");
			$MiTemplate->unset_var("BLO_comunasd");
			$MiTemplate->set_block('bloque_comunad' , "comunasd" , "BLO_comunasd");
		
			if (!$Lista->isvoid()) {
		       do {
					$MiTemplate->set_var('id_comunad', $Lista->getelem()->id_comunad);
		            $MiTemplate->set_var('nomcomunad', $Lista->getelem()->nomcomunad);
		            $MiTemplate->set_var('selected_comunad', ($comunad == ($Lista->getelem()->id_comunad)+0)?'selected':'');
		
		      		$MiTemplate->parse("BLO_comunasd", "comunasd", true);     
				  } while ($Lista->gonext());
		
			}
			$MiTemplate->parse("BLO_direcciones", "direcciones", true);	
			 
		} while ($List->gonext());
		$MiTemplate->set_var('prueba', $contadorarreglo);	
}


/*Fin despliegue direcciones de despacho*/
$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");


///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';

?>
