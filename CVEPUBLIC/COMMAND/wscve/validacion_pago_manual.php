<?php
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
include_once("../wsClientUnique/SimpleXMLParser.php");
///////////////////////// ZONA DE INCLUSION /////////////////////////
if($_POST['respuestapago']=="ok"){
	header( "Location: ../wscve/PayOS_Manual.php");
}
if($_POST['usuario']){
	$confimp = new getidmodulos("ID_MODULO");
	$idmodulo=$confimp->ID_MODULO_PAGOM;
	
	$Listusuariovalidoimp  = new connlist;
	$mRegistro=new dtousuario;
	$usuariolis =$_POST['usuario'];
	$clavelist =$_POST['clave'];
	bizcve::usuariomodulovalido($Listusuariovalidoimp,$usuariolis,$clavelist,$idmodulo);
	$Listusuariovalidoimp->gofirst();
	if ($Listusuariovalidoimp->getelem()->id!=''){
	//session_register("ses_validacion_pago");
	//$ses_validacion_pago='VOK';
		//header( "Location: ../wscve/PayOS_Manual.php?usuarioact=".$Listusuariovalidoimp->getelem()->id);
	$codbar_id_oe=substr($_POST['cod_bar'], 5);

	$ListEnc  = new connlist;
	$ListDet  = new connlist;		
	$mRegistro = new dtoencordenent;
	$mRegistro->id_ordenent=$codbar_id_oe;
	$ListEnc->addlast($mRegistro);
	bizcve::getordenent($ListEnc, $ListDet);
	$ListEnc->gofirst();
	$ini_estado_oe=$ListEnc->getelem()->id_estado;

	$input="<input>
	   <encabezado>
     	<os>".$_POST['cod_bar']."</os> 
     	<id>".$_POST['rutclientep']."</id> 
     	<numfactura>".$_POST['numfactu']."</numfactura> 
   </encabezado>
   <mediopago>
   	  <idmedio>01</idmedio> 
   </mediopago>
   <productos>
   		<precio></precio> 
	     	<cantidad></cantidad> 
	     	<ean></ean> 
	    </productos>
    <total>
     <iva></iva> 
     <reteiva></reteiva> 
     <retefuente></retefuente> 
     <reteica></reteica> 
     </total>
     </input>";

	if(isset($input)){
	if($input=="<input></input>" || $input=="<input>"){
		$xmlresponse = "<response><os>0</os><estado>Procesada</estado><desc>Mensaje no Valido</desc></response>";
	}else{
		$arr = SimpleXMLParser::parsePayOS($input);
		ob_start();
		try {
			$return = bizcve::getPagoOE($arr);
		}catch (Exception $e){
			//general::writelog("Error CATCH : " + $e->getMessage());	
		}
		$cont = ob_get_clean();
		//print $encabezado;
		$xmlresponse = "<response><os>".$arr['encabezado']['os']."</os><estado>Procesada</estado><desc>".$return."</desc></response>";	
		}
	}else{
	return 0;
	}

	$ListEnc  = new connlist;
	$ListDet  = new connlist;		
	$mRegistro = new dtoencordenent;
	$mRegistro->id_ordenent=$codbar_id_oe;
	$ListEnc->addlast($mRegistro);
	bizcve::getordenent($ListEnc, $ListDet);
	$ListEnc->gofirst();
	if($ini_estado_oe != $ListEnc->getelem()->id_estado){

	$Lista = new connlist;
	$mLista = new dtousuario;
    bizcve::infousuarioper($Lista,$Listusuariovalidoimp->getelem()->id);
   	$Lista->gofirst();
	general::inserta_tracking(null,$codbar_id_oe,null,null,"Orden de Entrega pagada, metodo pago manual autorizado por el usuario ".$Lista->getelem()->login);
	}
	//general::alert($ListEnc->getelem()->id_estado);

	$mensaje=split('<desc>',$xmlresponse);
	$mensaje=split('</desc>',$mensaje[1]);
	general::alert($mensaje[0]);
	}
	else{
	general::alert('Datos incorrectos por favor intente de nuevo');
	}
	$respuestapago="ok";
}
///////////////////////// ZONA DE ACCIONES /////////////////////////
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_file("main", TEMPLATE . "pago_manual/validacion_pago_manual.html");
$MiTemplate->set_var('cod_bar', $_GET[cod_bar]);
$MiTemplate->set_var('rutclientep', $_GET[rutclientep]);
$MiTemplate->set_var('numfactu', $_GET[numfactu]);
$MiTemplate->set_var('respuestapago',($respuestapago=="ok"?"ok":" "));
$MiTemplate->set_var('ejecutar',($respuestapago=="ok"?"window.document.pago.submit();":" "));


$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>