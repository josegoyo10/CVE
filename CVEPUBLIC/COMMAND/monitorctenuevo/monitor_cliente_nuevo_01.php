<?php
$pag_ini='../nuevacotizacion/nueva_cotizacion_00.php';
include_once ("../../INCLUDE/ini.php");
include_once ("../../INCLUDE/autoload.php");
include_once ("../../INCLUDE/aplication_top.php");
require_once('../wsClientUnique/ClientUnique.php');
///////////////////////// ZONA DE ACCIONES /////////////////////////
if ($accion == 'grabar') {
	
	$List = new connlist;
	$iClientes = new dtoinfocliente;
	$iClientes->rut =$_POST['rut'];
	$iClientes->razonsoc =$_POST['razonsoc'];
	$iClientes->fonocontacto =$_POST['fonocontactoe'];
	$iClientes->contacto =$_POST['contactoe'];
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
    $iClientes->id_contribuyente =$_POST['tipo_cliente'];
    $iClientes->accionupdate ='updatecli';
    $iClientes->id_regimencontri =$_POST['id_regimencontri'];
    $iClientes->rete_iva ="'0'";
    $iClientes->rete_ica="'0'";
    $iClientes->rete_renta ="'0'";
    //$iClientes->rete_iva =(($_POST['reteiva']==1)?$_POST['reteiva']:"'0'");
    //$iClientes->rete_ica =(($_POST['reteica']==1)?$_POST['reteica']:"'0'");
    //$iClientes->rete_renta =(($_POST['retefuente']==1)?$_POST['retefuente']:"'0'");
    $iClientes->genero =$_POST['genero'];
	$iClientes->codlocaluco=$ses_usr_codlocal;
	
	$List->addlast($iClientes);

	if (!bizcve::putcliente($List)){
		$mensaje_error = 'Problemas al grabar el cliente. Cont?ctese con el administrador';
	}
	
	$confimp = new getrespuestaws("RESPUESTAWS");
	$configbuscarcunico=$confimp->RESPUESTABUSCARCU;
	$response = ClientUnique::searchById($_POST['rut']);
	if($response){

		if($response [State]==$configbuscarcunico){
		bizcve::wsupdatecliente($List);
		}
		else{
		bizcve::wscrearcliente($List);	
		}
	}
	else
	{
		general::writelog('El WS ClientUnique,searchById no se encuentra disponible para consultar datos del cliente');
		header("Location: monitor_cliente_nuevo_01.php?rut=".$_GET['rut']."&tipocliente=".$_GET['tipocliente']);
		return;
	}
	
	general::writeevent('Se han modificado los siguientes datos del cliente por el modulo monitor cliente:  Razon Social: '.
	$_POST['razonsoc'].' Actividad Econ髆ica: '.$_POST['giro'].' Fono contacto: '.$_POST['fonocontactoe'].
	'contacto: '.$_POST['contactoe'].'email: '.$_POST['emaile'].'direccion: '.$_POST['direccione'].
	'comuna: '.$_POST['comunae'].'comentario: '.$_POST['comentarios'].'rubro: '.$_POST['select_rubro'].
	'Bloqueo CVE: '.$_POST['valorbox1']);
	
	$arr_dir = split(',', $_POST['tupla_dir_mod']);
	foreach($arr_dir as $key=>$value){
		//Grabamos cada direcci贸n
		if($value) {
			$List = new connlist;
			$iDireccion = new dtodireccion;
			$iDireccion->id_direccion = $value;
			$iDireccion->id_comuna = $_POST['barrioarray_'.$value];
			$iDireccion->rut = $_POST['rut_'.$value];
			$iDireccion->descripcion = $_POST['descripcion_'.$value];
			$iDireccion->direccion = $_POST['direccion_'.$value];
			$iDireccion->contacto = $_POST['contacto_'.$value];
			$iDireccion->fonocontacto = $_POST['fonocontacto_'.$value];
			$iDireccion->email = $_POST['email_'.$value];
			$iDireccion->comentario = $_POST['comentario_'.$value];
			$List->addlast($iDireccion);
			
			general::writeevent('Se han modificado los siguientes datos en la direccion de despacho del cliente por el modulo monitor cliente:  Numero direccion: '.
			$value.' descripcion: '.$_POST['descripcion_'.$value].' direccion: '.$_POST['direccion_'.$value].
			'contacto: '.$_POST['contacto_'.$value].'Tel閒ono1: '.$_POST['fonocontacto_'.$value].
			'email: '.$_POST['email_'.$value].'comentario: '.$_POST['comentario_'.$value]);
			
			if (!bizcve::putdirdesp($List)) 
				$mensaje_error = 'Problemas al modificar la direcci贸n. Cont谩ctese con el administrador';			
		}
	}
header("Location: monitor_cliente_nuevo.php?rut=" .$_POST['rut']);
	
}	

if ($accion == 'elidir') {
	$List = new connlist;
	$iDireccion = new dtodireccion;
	$iDireccion->rut =$_GET['rut'];
	$iDireccion->id_direccion =$_POST['id_direccion_elim'];
	$List->addlast($iDireccion);
	
	if (!bizcve::deldirdesp($List)) 
		$mensaje_error = 'Problemas al eliminar la direcci贸n. Cont谩ctese con el administrador';
	general::writeevent('Se ha eliminado la direccion N: '.$_POST['id_direccion_elim'].' del cliente con el rut: '.$_GET['rut'].' desde el paso 2 de nueva cotizacion.');

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
		$mensaje_error = 'Problemas al grabar el cliente. Cont?ctese con el administrador';

	general::writeevent('Se han modificado los siguientes datos del cliente por el modulo monitor cliente por el modulo monitor cliente:  Razon Social: '.
	$_POST['razonsoc'].' Actividad Econ髆ica: '.$_POST['giro'].' Fono contacto: '.$_POST['fonocontactoe'].
	'contacto: '.$_POST['contactoe'].'email: '.$_POST['emaile'].'direccion: '.$_POST['direccione'].
	'comuna: '.$_POST['comunae'].'comentario: '.$_POST['comentarios'].'rubro: '.$_POST['select_rubro'].
	'Bloqueo CVE: '.$_POST['valorbox1']);

}

if ($accion == 'adddir') {
	$List = new connlist;
	$iDireccion = new dtodireccion;
	$iDireccion->rut =$_GET['rut'];
	$List->addlast($iDireccion);
	
	general::writeevent('Se han modificado los siguientes datos en la direccion de despacho del cliente por el modulo monitor cliente:  Numero direccion: '.
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
    $iClientes->id_contribuyente =$_POST['tipo_cliente'];
    $iClientes->id_regimencontri =$_POST['id_regimencontri'];
    $iClientes->rete_iva ="'0'";
    $iClientes->rete_ica ="'0'";
    $iClientes->rete_renta="'0'";
    //$iClientes->rete_iva =(($_POST['reteiva']==1)?$_POST['reteiva']:"'0'");
    //$iClientes->rete_ica =(($_POST['reteica']==1)?$_POST['reteica']:"'0'");
    //$iClientes->rete_renta =(($_POST['retefuente']==1)?$_POST['retefuente']:"'0'");
    $iClientes->genero =$_POST['genero'];
	$iClientes->codlocaluco=$ses_usr_codlocal;
	$List->addlast($iClientes);
	if (!bizcve::putcliente($List))
		$mensaje_error = 'Problemas al grabar el cliente. Cont?ctese con el administrador';

	general::writeevent('Se han modificado los siguientes datos del cliente por el modulo monitor cliente:  Razon Social: '.
	$_POST['razonsoc'].' Actividad Econ髆ica: '.$_POST['giro'].' Fono contacto: '.$_POST['fonocontactoe'].
	'contacto: '.$_POST['contactoe'].'email: '.$_POST['emaile'].'direccion: '.$_POST['direccione'].
	'comuna: '.$_POST['comunae'].'comentario: '.$_POST['comentarios'].'rubro: '.$_POST['select_rubro'].
	'Bloqueo CVE: '.$_POST['valorbox1']);


}


///////////////////////// ZONA DE DESPLIEGUE /////////////////////////


$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

/*Inclusi?n de header*/
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
/**/

/* Inclusi?n de main*/
/* */
$MiTemplate->set_file("main", TEMPLATE . "monitorctenuevo/monitor_cliente_nuevo_01.htm");
$MiTemplate->set_file("bloque_comunad", TEMPLATE . "nuevacotizacion/nueva_cotizacion_011.htm");

if(isset($_REQUEST['faldat']))
{
	$MiTemplate->set_var('exclama',"<img src=\"../../IMAGES/icon4.gif\" />");
}

/**/

$confimp = new getidcontribuyente("CONTRIBUYENTE");
$opcioncon=$confimp->JURIDICO;
$opcioncon1=$confimp->EMPRESARIAL;
/*Despliegue de Datos de Cliente*/
$List  = new connlist;
$rut=$_REQUEST['rut'];
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
	$id_clientepref=$List->getelem()->id_clientepref;	
	$MiTemplate->set_var('razonsoc',$List->getelem()->razonsoc );
	$MiTemplate->set_var('fonocontactoe', $List->getelem()->fonocontacto);
	$MiTemplate->set_var('contactoe', $List->getelem()->contacto);
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
	$MiTemplate->set_var('apellido', $List->getelem()->apellido);
	$MiTemplate->set_var('apellido1', $List->getelem()->apellido1);
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
	if($id_contribu==$opcioncon1){
	$MiTemplate->set_var('rutdv',$rut.'-'.general::digiVer($rut));
	}
	else{
	$MiTemplate->set_var('rutdv',$rut);
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
	
	$MiTemplate->set_var('id_tipocliente', $List->getelem()->id_tipocliente);
	$MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente); 
    
	$MiTemplate->set_var('vendedor', $List->getelem()->vendedor);
	
	//Obtengo el credito del cliente mediante el webservice
	$credito = ConsultarClienteOnline($rut);
	
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

/*FinDespliegue de Datos de Cliente*/

/*Despliegue Selecci贸n Giro*/
$Listc  = new connlist;
bizcve::getgiro($Listc);
$Listc->gofirst();

if (!$Listc->isvoid()) {
$MiTemplate->set_block('main' , "giro" , "BLO_giro");	
       do {
             $MiTemplate->set_var('id_giro', $Listc->getelem()->id);
             $MiTemplate->set_var('descripcion', $Listc->getelem()->nombre);
             $MiTemplate->set_var('selectedgiro', ($id_giroselect == $Listc->getelem()->id)?'selected':'');
             $MiTemplate->parse("BLO_giro", "giro", true);     
       } while ($Listc->gonext());

}

/*Fin Despliegue Selecci贸n Giro*/
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
$Listcontri  = new connlist;
bizcve::gettipocontribuyente($Listcontri);
$Listcontri->gofirst();
if (!$Listcontri->isvoid()) {
$MiTemplate->set_block('main' , "contri" , "BLO_contri");
	do {
		$MiTemplate->set_var('nombrecontri', $Listcontri->getelem()->nombre);
		$MiTemplate->set_var('id', $Listcontri->getelem()->id);
		$MiTemplate->set_var('selectedcontribu', (($id_contribu == $Listcontri->getelem()->id)?'selected':''));
		$MiTemplate->parse("BLO_contri", "contri", true);	
	} while ($Listcontri->gonext());
}
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
$rut=$_REQUEST['rut'];
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
