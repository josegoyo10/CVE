<?php
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
include_once("../wsClientUnique/SimpleXMLParser.php");
///////////////////////// ZONA DE INCLUSION /////////////////////////
/*if(!$_GET['usuarioact'] || $ses_validacion_pago!='VOK'){
	//general::alert('Existen errores en la validacion intente de nuevo');
	$_POST['accion']='ERROR';	
	header( "Location: validacion_pago_manual.php?error=1");
	exit;
}*/
if($_POST['accion']=='AUTORIZAR'){
	header( "Location: validacion_pago_manual.php?cod_bar=".$_POST['cod_bar']."&rutclientep=".$_POST['rutclientep']."&numfactu=".$_POST['numfactu']);
	exit;
/*$codbar_id_oe=substr($_POST['cod_bar'], 5);
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
    bizcve::infousuarioper($Lista,$_POST['usuarioact']);
   	$Lista->gofirst();
	general::inserta_tracking(null,$codbar_id_oe,null,null,"Orden de Entrega pagada, metodo pago manual autorizado por el usuario ".$Lista->getelem()->login);
}
//general::alert($ListEnc->getelem()->id_estado);

$mensaje=split('<desc>',$xmlresponse);
$mensaje=split('</desc>',$mensaje[1]);
general::alert($mensaje[0]);*/
}
///////////////////////// ZONA DE ACCIONES /////////////////////////
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "pago_manual/PayOS_Manual.htm");
$MiTemplate->set_var('usuarioact', $_GET['usuarioact']);
if($_POST['accion']=='BUSCAR'){

$ListImpOE = new connlist;
$RegistroImpOE = new dtodetordenent;
$RegistroImpOE->id_ordenent = $_POST['id_ordenent'];
$ListImpOE->addlast($RegistroImpOE);
bizcve::getdetoerdenentregasumimp($ListImpOE);
$ListImpOE->gofirst();

	$ListEnc  = new connlist;
	$ListEnc2  = new connlist;
	$ListDet  = new connlist;	
	$Registro = new dtoencordenent;
   	$mRegistro->id_ordenent=$_POST['id_ordenent'];
	$mRegistro->prorrateoflete =1;  	
	$ListEnc->addlast($mRegistro);
	bizcve::getordenent($ListEnc, $ListDet);
	$ListEnc->gofirst();

function calcula_num_os($os){
	
		$long_numero = strlen($os);
						
		if($long_numero == 7)
			$id_os = $os;

		if($long_numero == 6)
			$id_os = "0" . $os;
			
		if($long_numero == 5)
			$id_os = "00" . $os;
			
	    if($long_numero == 4)
		    $id_os = "000" . $os;
			
		if($long_numero == 3)
			$id_os = "0000" . $os;
	        
		if($long_numero == 2)
	        $id_os = "00000" . $os;
			
	    if($long_numero == 1)
		    $id_os = "000000" . $os;
				
		    return $id_os; 

}/*Fin de Funcion*/	
$ListEnc->gofirst();
if($ListEnc->getelem()->id_ordenent==''){
	$MiTemplate->set_var('valorboton', 'BUSCAR');
	$MiTemplate->set_var('criteriooe', '<input type="text" name="id_ordenent" value="{id_ordenent}" size="6" >');
}
else{
if (!$ListEnc->isvoid()) {
	do {
		
		bizcve::gettipoflujo($Listf=new connlist(new dtotipo(array('id'=>$ListEnc->getelem()->id_tipoflujo))));
		$Listf->gofirst();		
		bizcve::gettipopagoid($Listp = new connlist(new dtotipo(array('id_tipopago'=>$ListEnc->getelem()->id_tipopago))));
		$Listp->gofirst();
		$MiTemplate->set_var('tipopago', $Listp->getelem()->nombre);
		$MiTemplate->set_var('condicion', $ListEnc->getelem()->condicion);		
		$MiTemplate->set_var('oe', $ListEnc->getelem()->id_ordenent);
		if($ListEnc->getelem()->id_estado=='OG'){
		general::alert('La orden de entrega N '.$ListEnc->getelem()->id_ordenent.' se encuentra en estado pagado');
		$MiTemplate->set_var('valorboton', 'BUSCAR');
		$MiTemplate->set_var('criteriooe', '<input type="text" name="id_ordenent" value="{id_ordenent}" size="6" maxlength="12" >');
		}
		else{
		$MiTemplate->set_var('criteriooe', $ListEnc->getelem()->id_ordenent);
		$MiTemplate->set_var('valorboton', 'AUTORIZAR');
		$MiTemplate->set_var('criteriofac', '<br>Factura  Nº <input type="text" name="numfactu" size="15" maxlength="15">');
		}
		$MiTemplate->set_var('id_ordenent', $ListEnc->getelem()->id_ordenent);	
		$id_ordenent=$ListEnc->getelem()->id_ordenent;
		$MiTemplate->set_var('id_cotizacion', $ListEnc->getelem()->id_cotizacion);
		$id_cotizacion=$ListEnc->getelem()->id_cotizacion;
		
		$MiTemplate->set_var('nomtipoflujo', $ListEnc->getelem()->nomtipoflujo);	
		$MiTemplate->set_var('codigovendedor', $ListEnc->getelem()->codigovendedor);
		//dato de fecha
		$MiTemplate->set_var('validdesde',general::formato_fecha($ListEnc->getelem()->validdesde) );
		$MiTemplate->set_var('validhasta',general::formato_fecha($ListEnc->getelem()->validhasta) );
		$MiTemplate->set_var('feccreacoti',general::formato_fecha($ListEnc->getelem()->feccreacoti));
		
		if($ListEnc->getelem()->fecha_retira_cliente != '0000-00-00')
			$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_cliente) );
		if($ListEnc->getelem()->fecha_retira_inmediato != '0000-00-00')
			$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_inmediato) );
		if($ListEnc->getelem()->fecha_despacho_programado != '0000-00-00')
			$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_despacho_programado) );

			
		//dato de fecha	
		//Inclusion codigo para EAN
		/*Codigo EAN*/
		$confimp = new getidaplicacion("IDENTIFICACION_DE_LA_APLICACION");
		$cod_cve_apli=$confimp->COD_CVE;
		$cod_ordenente= $ListEnc->getelem()->id_ordenent;
		$cod_ordenent= calcula_num_os($ListEnc->getelem()->id_ordenent);
		$cod_local_sum = substr($ListEnc->getelem()->codlocalventa,1); 
		$cod_cve_eanc= $cod_cve_apli . $cod_local_sum . $cod_ordenent;
		$cod_verifica=general::dvEAN13($cod_cve_eanc);
		$cod_ean = $cod_cve_eanc . $cod_verifica;
		$MiTemplate->set_var('cod_barra_os', general::gencode_EAN13($cod_ean,150,60));
		$MiTemplate->set_var('cod_bar',$cod_cve_eanc );
		$rut=$ListEnc->getelem()->rutcliente;
		
		/*Inserta el cod EAN en la tabla ordenent_e*/
		bizcve::putean($cod_ean, $cod_ordenente);		
		/*Fin cod EAN en la tabla ordenent_e*/	
		//Fin Codigo EAN
		
		//Direccion de Servicio
		$MiTemplate->set_var('telefonoe', $ListEnc->getelem()->telefono);
		$MiTemplate->set_var('direccione', $ListEnc->getelem()->direccion);
		
		/*Insercion de Ciudad Comuna Departamento*/
		if($ListEnc->getelem()->id_direccion == 0){
	    	/*Datos de Direccion del Cliente*/
			$Listc = new connlist;
			$Registro = new dtoinfocliente;
			$Registro->rut	= $rut;
			$Listc->addlast($Registro);

			bizcve::getCliente($Listc);
			$Listc->gofirst();
			$Listlocalizacion  = new connlist;
			$registrolocalizacion = new dtolocalizacion;
			$registrolocalizacion->id_localizacion = $Listc->getelem()->id_comuna;

			$Listlocalizacion->addlast($registrolocalizacion);
			bizcve::getlocalizacion($Listlocalizacion);
			$Listlocalizacion->gofirst();
			if (!$Listlocalizacion->isvoid()) {
				do {
					$MiTemplate->set_var('ciudadoe', $Listlocalizacion->getelem()->ciudad);
					$MiTemplate->set_var('barriooe', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
					$MiTemplate->set_var('departamentooe', $Listlocalizacion->getelem()->departamento);
				} while ($Listlocalizacion->gonext());

			}
		}	/*Fin Datos de Direccion del Cliente*/
		else{
		
			$Listdirdes  = new connlist;
			$id_dirdes = new dtodireccion;
			$id_dirdes->id_direccion = $ListEnc->getelem()->id_direccion;
			$Listdirdes->addlast($id_dirdes);
			bizcve::getdirdesp($Listdirdes);
			$Listdirdes->gofirst();
  
			$Listlocalizacion  = new connlist;
			$registrolocalizacion = new dtolocalizacion;
			$registrolocalizacion->id_localizacion = $Listdirdes->getelem()->id_comuna;

			$Listlocalizacion->addlast($registrolocalizacion);
			bizcve::getlocalizacion($Listlocalizacion);
			$Listlocalizacion->gofirst();
			if (!$Listlocalizacion->isvoid()) {
				do {
					$MiTemplate->set_var('ciudadoe', $Listlocalizacion->getelem()->ciudad);
					$MiTemplate->set_var('barriooe', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
					$MiTemplate->set_var('departamentooe', $Listlocalizacion->getelem()->departamento);

				} while ($Listlocalizacion->gonext());

			}
		}
		/* FIN Insercion de Ciudad Comuna Departamento*/
		
		
		//$MiTemplate->set_var('barrioe', $ListEnc->getelem()->comuna);
		//Fin de Direccion de Servicio
		$MiTemplate->set_var('nomtipoentrega', $Listf->getelem()->nombre);		
		$codigovendedor		=$ListEnc->getelem()->codigovendedor;
		$MiTemplate->set_var('nomestadorent', $ListEnc->getelem()->nomestadorent);	
		$MiTemplate->set_var('nom_localcsum', $ListEnc->getelem()->nom_localcsum);
		$MiTemplate->set_var('iva', $ListEnc->getelem()->iva);		
		$MiTemplate->set_var('usuariocrea', $ListEnc->getelem()->usrcrea);
		$MiTemplate->set_var('observaciones', $ListEnc->getelem()->observaciones);			
		$MiTemplate->set_var('nota', $ListEnc->getelem()->nota);		
		$codlocalventa=$ListEnc->getelem()->codlocalventa;
		$MiTemplate->set_var('nomtipoflujo', $ListEnc->getelem()->nomtipoflujo);
		/*Valores totales de la orden de entrega*/

		/*Claculo de Impuestos por separado*/
		$grupoimp='iva';
		$Daoe = new daoordenent; 
		$Daoe->getdetalleimpuestoe($Listimp = new connlist, $id_ordenent,$grupoimp);
		$Listimp->gofirst();
		//$totalica = 0;
		if(!$Listimp->isvoid()){
			do{
				$totaliva += $Listimp->getelem()->sumiva;
								
			}while($Listimp->gonext());
		}
		//$riva = ($totaliva / 2);
		$riva =$ListEnc->getelem()->rete_iva_oe;
		/*Fin Calculo de Impuestos por separado*/
	
		/*Calculo de Impuestos rete_renta*/
		
		$grupoimp='rete_renta';
		$Daoer = new daoordenent; 
		$Daoer->getdetalleimpuestoe($Listimpr = new connlist, $id_ordenent,$grupoimp);
		$Listimpr->gofirst();
		//$totalica = 0;
		if(!$Listimpr->isvoid()){
			do{
				$totalrenta += $Listimpr->getelem()->sumiva;
								
			}while($Listimpr->gonext());
		}
		
		/*Fin Calculo de Impuestos rete_renta*/
	
		
	
		/*Calculo de Impuetos rete_ica*/
		$grupoimp='rete_ica';
		$Daoei = new daoordenent; 
		$Daoei->getdetalleimpuestoe($Listimpi = new connlist, $id_ordenent,$grupoimp);
		$Listimpi->gofirst();
		if(!$Listimpi->isvoid()){
			do{
				$totalica += $Listimpi->getelem()->sumiva;
						
			}while($Listimpi->gonext());
		}
		
		/*Fin calculo de Impuestos rete_ica*/
	
		$rete_renta = $totalrenta;
		$rete_iva = ($riva);
		$rete_ica = $totalica;
		/*Fin Valores totales de la orden de entrega*/			
		
		$id_estado=$ListEnc->getelem()->id_estado;
		$iva=$ListEnc->getelem()->iva;		
	} while ($ListEnc->gonext());	
}
$List = new connlist;
$Registro = new dtousuario;
$Registro->codigovendedor	=  $codigovendedor;
$List->addlast($Registro);
bizcve::GetUsers($List);
$List->gofirst();
$usr_nombre=$List->getelem()->usr_nombres;
$usr_apellidos=$List->getelem()->usr_apellidos;
if(!$codigovendedor){
	$MiTemplate->set_var('nombrevendedor', 'Venta No Asignada');	
}
else{
	$MiTemplate->set_var('nombrevendedor', $usr_nombre.' '.$usr_apellidos);
}	
//$MiTemplate->set_var('nombrevendedor', $usr_nombre.' '.$usr_apellidos);	

$cont = 0;
$List = new connlist;
$Registro = new dtolocal;
$Registro->cod_local	=  $codlocalventa;
$List->addlast($Registro);
bizcve::getlocales($List);
$List->gofirst();
$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
$ListDet->gofirst();
$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detalleOE");
if (!$ListDet->isvoid()) {
	do {
		   $cont = $cont + 1;
		   $MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
		   $MiTemplate->set_var('codtipo', $ListDet->getelem()->codtipo);// Tipo Producto Stock 
		   $MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
		   /*Validacion Tipo de Entrega*/
			if ( $ListDet->getelem()->id_tipoentrega==1 and $ListDet->getelem()->id_tiporetiro==2)
	    			$MiTemplate->set_var('retdesp', 'Retira Cliente');		   
			if ( $ListDet->getelem()->id_tipoentrega==2 and $ListDet->getelem()->id_tiporetiro==2)
					$MiTemplate->set_var('retdesp', 'D. Programado');
			if ( $ListDet->getelem()->id_tipoentrega==1 and $ListDet->getelem()->id_tiporetiro==1)
					$MiTemplate->set_var('retdesp', 'Retira Inmediato');
			/*Fin Validacion de Tipo de Entrega*/    
			$precio=($ListDet->getelem()->pventaneto);
			$MiTemplate->set_var('cantidad', round($ListDet->getelem()->cantidade));
			$MiTemplate->set_var('unimed', $ListDet->getelem()->unimed);
			$totallinea += $ListDet->getelem()->totallinea;
			$MiTemplate->set_var('totallinea',number_format(round( $ListDet->getelem()->totallinea)));
			$MiTemplate->set_var('precio', number_format($precio));
			//Instalacion, Peso, descuento
			$MiTemplate->set_var('descuento', number_format($ListDet->getelem()->descuento));
			$MiTemplate->set_var('instalacion', $ListDet->getelem()->instalacion);
			$MiTemplate->set_var('peso', $ListDet->getelem()->peso);
			$valortotaldescu  +=round($ListDet->getelem()->descuento)+0;
			
			$totalneto+=round($ListDet->getelem()->totallinea);
			//$MiTemplate->set_var('salto',(($cont > 11)?'<H1 class=SaltoDePagina> </H1>':''));
			$MiTemplate->parse("BLO_detalleOE", "detalleproductos", true);
			
			if($ListDet->getelem()->codsubtipo=='DE' && $ListDet->getelem()->codtipo=='SV'){
				$valorfletet+=$ListDet->getelem()->totallinea;	
			}
			else{
				$valorfletet=$valorfletet+0;
			}
			
			
	} while ($ListDet->gonext());
	if($valorfletet >0){
		$MiTemplate->set_var('valorfletetabla', '<tr>
				<td width="40" height="20" ></td>
				<td width="80" height="20" ></td>
				<td width="200" height="20" ></td>                
				<td width="100" height="20" align="left">Valor Flete</td>
				<td width="50" height="20"  ></td>								
				<td width="90" height="20" align="right">{valoflete}&nbsp;</td>  
			</tr>
				');
	}
	
	$MiTemplate->set_var('valortotal',number_format($totallinea+0));
	$MiTemplate->set_var('valoflete', number_format($valorfletet));
	$MiTemplate->set_var('descuentot', ((number_format($valortotaldescu) == 0)?'-':number_format($valortotaldescu)));
	$MiTemplate->set_var('valoriva', number_format($valoriva+0));
	$MiTemplate->set_var('sumtotal', number_format($sumtotal));
	
	$MiTemplate->set_var('saltopag',(($cont == 11)?'<H1 class=SaltoDePagina> </H1>':'<H1 class=SaltoDePagina> </H1>'));
	
	
	
}


$List = new connlist;
$Registro = new dtoinfocliente;
$Registro->rut	= $rut;
$List->addlast($Registro);

bizcve::getCliente($List);
$List->gofirst();
if (!$List->isvoid()) {
    $List->gofirst();
    $MiTemplate->set_var('rut', $List->getelem()->rut);
    
    $configclitipo = new getidcontribuyente("CONTRIBUYENTE");
	$opcion=$configclitipo->JURIDICO;
	$opcion1=$configclitipo->EMPRESARIAL;
    
    $MiTemplate->set_var('rutcliente', (($List->getelem()->id_contribuyente == $opcion1)?$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut) : $List->getelem()->rut ));	
    $MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente);			
    $MiTemplate->set_var('contacto', $List->getelem()->contacto);					
    $MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);		
    $MiTemplate->set_var('email', $List->getelem()->email);	
	$MiTemplate->set_var('nomtipdocpago', $List->getelem()->nomtipdocpago);
	$MiTemplate->set_var('direccion', $List->getelem()->direccion);
	/*Insercion de Ciudad Comuna Departamento*/
  
	$Listlocalizacion  = new connlist;
	$registrolocalizacion = new dtolocalizacion;
	$registrolocalizacion->id_localizacion = $List->getelem()->id_comuna;

	$Listlocalizacion->addlast($registrolocalizacion);
	bizcve::getlocalizacion($Listlocalizacion);
	$Listlocalizacion->gofirst();
	if (!$Listlocalizacion->isvoid()) {
		do {
			$MiTemplate->set_var('ciudad', $Listlocalizacion->getelem()->ciudad);
			$MiTemplate->set_var('comuna', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
			$MiTemplate->set_var('departamento', $Listlocalizacion->getelem()->departamento);

		} while ($Listlocalizacion->gonext());

	}
	/* FIN Insercion de Ciudad Comuna Departamento*/
	
	//$MiTemplate->set_var('comuna', $List->getelem()->nomcomuna); 
	$validacobrorenta=$ListImpOE->getelem()->rete_renta;
	$validacobroica=$ListImpOE->getelem()->rete_ica; 
	$validacobroriva = $List->getelem()->rete_iva;  
}

$rete_iva2 = round($rete_iva);
$rete_ica2 = round($rete_ica);
$rete_renta2 = round($rete_renta);
$sumtotal = $totallinea - $rete_renta2 - $rete_iva2 - $rete_ica2;
$MiTemplate->set_var('viva', number_format($totaliva));
$MiTemplate->set_var('rete_ica',number_format($totalica));
$MiTemplate->set_var('rete_renta',number_format($totalrenta));
$MiTemplate->set_var('rete_iva',number_format($rete_iva2));
$MiTemplate->set_var('sumtotal', number_format($sumtotal));

$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
    $MiTemplate->set_var('id_ordenent', $id_ordenent);		
    $MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);	
    $MiTemplate->set_var('giro', $ListEnc->getelem()->giro);				
    		
}
}
}
else{
	$MiTemplate->set_var('valorboton', 'BUSCAR');
	$MiTemplate->set_var('criteriooe', '<input type="text" name="id_ordenent" value="{id_ordenent}" maxlength="12">');
}
$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>