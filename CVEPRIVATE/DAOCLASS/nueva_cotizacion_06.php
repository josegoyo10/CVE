<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
require_once('../../../CVEPRIVATE/HLPCLASS/Fletes.class.php');
///////////////////////// ZONA DE ACCIONES /////////////////////////

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_var('error_app', $mensaje_error);
/**/
$MiTemplate->set_var("TITULO", TITULO);
/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "nuevacotizacion/nueva_cotizacion_06.htm");
/**/


$rut = $_REQUEST['rut'];
$idcotizacion = $_REQUEST['id_cotizacion'];
$fechaent=general::formato_fecha_FORM2DB($_REQUEST['validdesde']);

if (!$idcotizacion) {
	general::alertexit('No viene id de cotizaci&oacute;n. No puede liquidar transporte');
	exit();
}


/* OBTENEMOS DATOS DE LA COTIZACION */
bizcve::getcotizacion($ListEnc = new connlist(new dtocotizacion(array('id_cotizacion'=>$idcotizacion))), $ListDet = new connlist);
if (!$ListEnc->numelem()) {
	general::alertexit('No existe la cotizaci&oacute;n. No puede liquidar transporte');
	exit();
}
$ListEnc->gofirst();
/* FIN OBTENEMOS DATOS DE LA COTIZACION */

/* OBTENEMOS DATOS DEL CLIENTE */
if($ListEnc->getelem()->id_dirdespacho == 0){
	    /*Datos de Direccion del Cliente*/
		$Listc = new connlist;
		$Registro = new dtoinfocliente;
		$Registro->rut	= $rut;
		$Listc->addlast($Registro);

		bizcve::getCliente($Listc);
		$Listc->gofirst();
		$dirc=$Listc->getelem()->direccion;
		$Listlocalizacion  = new connlist;
		$registrolocalizacion = new dtolocalizacion;
		$registrolocalizacion->id_localizacion = $Listc->getelem()->id_comuna;
		//general::writelog('localizacion'.$Listc->getelem()->id_comuna);
		$Listlocalizacion->addlast($registrolocalizacion);
		bizcve::getlocalizacion($Listlocalizacion);
		$Listlocalizacion->gofirst();

}else{
	
		$Listdirdes  = new connlist;
		$id_dirdes = new dtodireccion;
		$id_dirdes->id_direccion = $ListEnc->getelem()->id_dirdespacho;
		$Listdirdes->addlast($id_dirdes);
		bizcve::getdirdesp($Listdirdes);
		$Listdirdes->gofirst();
        $dirc=$Listdirdes->getelem()->direccion;
		$Listlocalizacion  = new connlist;
		$registrolocalizacion = new dtolocalizacion;
		$registrolocalizacion->id_localizacion = $Listdirdes->getelem()->id_comuna;   
		$Listlocalizacion->addlast($registrolocalizacion);
		bizcve::getlocalizacion($Listlocalizacion);
		$Listlocalizacion->gofirst();
	
}	/*Fin Datos de Direccion del Cliente*/
/* FIN OBTENEMOS DATOS DEL CLIENTE */

/* CONSTRUCCION DTO DE FLETE, VALIDACION */
bizcve::getDatosFlete($Listf = new connlist(new dtoflete(array('rut'=>$rut,
															   'ciudad'=>$Listlocalizacion->getelem()->ciudad,
															   'comuna'=>$Listlocalizacion->getelem()->barrio,
															   'departamento'=>$Listlocalizacion->getelem()->departamento,
                                                               'fechad'=>$fechaent,
															   'codlocalventa'=>$ListEnc->getelem()->codlocalventa
																))));
$Listf->gofirst();														
bizcve::getlocales($Listl = new connlist(new dtolocal(array('cod_local'=>$ListEnc->getelem()->codlocalventa))));																
$Listl->gofirst();

/*CALCULO DE LOCALIZACION PARA CENTRO SUMINISTRO*/
	$Listlocal  = new connlist;
	$registrolocal = new dtolocalizacion;
	$registrolocal->id_localizacion = $Listl->getelem()->id_localizacion;
	general::writelog('local2'.$Listl->getelem()->id_localizacion);   
	$Listlocal->addlast($registrolocal);
	bizcve::getlocalizacion($Listlocal);
	$Listlocal->gofirst();
	
/* FIN CALCULO DE LOCALIZACION PARA CENTRO SUMINISTRO*/



if(!$Listf->isvoid()){
	$ListDet->gofirst();
	$tipoent = $ListDet->getelem()->id_tipoentrega;
   	do{
   		if($tipoent == 2){
			
   			$sumapeso += $ListDet->getelem()->peso * $ListDet->getelem()->cantidad;
   		}	
	}while($ListDet->gonext());
	$xml = "<despacho>
				<direccion>$dirc</direccion>
				<idDepartamento>".$Listlocalizacion->getelem()->id_departamento."</idDepartamento>
				<idMunicipio>".$Listlocalizacion->getelem()->id_provincia."</idMunicipio>
				<idCentroPoblado>".$Listlocalizacion->getelem()->id_ciudad."</idCentroPoblado>
				<idLocalidad>".$Listlocalizacion->getelem()->id_localidad."</idLocalidad>
				<idBarrio>".$Listlocalizacion->getelem()->id_barrio."</idBarrio>
			</despacho>
			<centroSuministro>
				<idLocal>".$Listl->getelem()->cod_local_pos."</idLocal>
				<idDepartamento>".$Listlocal->getelem()->id_departamento."</idDepartamento>
				<idMunicipio>".$Listlocalizacion->getelem()->id_provincia."</idMunicipio>
				<idCentroPoblado>".$Listlocal->getelem()->id_ciudad."</idCentroPoblado>
				<idLocalidad>".$Listlocal->getelem()->id_localidad."</idLocalidad>
				<idBarrio>".$Listlocal->getelem()->id_barrio."</idBarrio>
			</centroSuministro>
			<entregaProductos>
				<lstTipoDespacho>
					<codigoTipo>$tipoent</codigoTipo>
					<peso>$sumapeso</peso>
				</lstTipoDespacho>
			</entregaProductos>
			<codEmpresaTransportadora>0</codEmpresaTransportadora>";
	echo $xml;
	general::writeevent($xml);
		/*$xml = 	 " <despacho>$Listl->getelem()->cod_local_pos
			  		<direccion>Cra 27 N° 35 -21 </direccion>
			  		<idDepartamento>11</idDepartamento> 
			  		<idMunicipio>001</idMunicipio> 
			  		<idCentroPoblado>000</idCentroPoblado> 
			  		<idLocalidad>011</idLocalidad> 
			  		<idBarrio>00</idBarrio> 
			  	  </despacho>     
			  	  <centroSuministro>
			         <idLocal>1</idLocal> 
			  		 <idDepartamento>11</idDepartamento> 
			  		 <idMunicipio>001</idMunicipio> 
			  	     <idCentroPoblado>000</idCentroPoblado> 
			  		 <idLocalidad>11</idLocalidad> 
			  		 <idBarrio>00</idBarrio> 
			  	   </centroSuministro>
			  	   <entregaProductos>
			  		<lstTipoDespacho>
			  			<codigoTipo>2</codigoTipo> 
			  			<peso>56</peso> 
			  		</lstTipoDespacho>
			  	   </entregaProductos>
			  <codEmpresaTransportadora>0</codEmpresaTransportadora>";*/
$i= 0;
$service = new Fletes;
$response = $service->calcular($xml);
	if ($response) {
		print_r ($response);
		$count = sizeof($response);
		if($count != 3){
			$tipoflete = $response['data']['lstValorFlete']['tipoFlete'];
			$tipodesp = $response['data']['lstValorFlete']['tipoDespacho'];
			$tipoenv = $response['data']['lstValorFlete']['tipoEnvio'];
			$valorflet = $response['data']['lstValorFlete']['valorFlete'];
			$cantidad = $response['data']['lstValorFlete']['cantidad'];
			$codsap = $response['data']['lstValorFlete']['codSAP'];
			$zona = $response['data']['zone'];
		}else{
			general::alert("Viene con  Adicional");
			
		}
		
		$msg2 = $response['exception']['state'];
		$msg = $response ['exception']['message'];
				
		if($msg2 == 0){
			
			general::confirmf(''.$msg.' \n¿Desea Ajustar Flete Manualmente?',true,false,$idcotizacion);
			
					
		}
		    
		
			echo "tipoflete",$tipoflete;
				
			echo "tipodesp",$tipodesp;	
				
			echo "tipoenvio",$tipoenv;	
				
			echo "valor flete",$valorflet;	
				
			echo "cantidad",$cantidad;	
					
			echo "codsap",$codsap;	
				
			echo "zona",$zona;	
				
		/* FIN EXTRACCION DE DATOS RESPUESTA WS */
		
		/*EXTRACCION DE DETALLE DEL PRODUCTO*/
		bizcve::getproducto($Listp = new connlist(new dtoproducto(array('sap'=>$codsap))));
		$Listp->gofirst();
		/*FIN EXTRACCION DE DETALLE DEL PRODUCTO*/
		/*INSERCION DE FLETE A LA COTIZACION*/
		$Dao = new daocotizacion;
		$Dao->savedetcotizacion($ListEnc, $ListDetf = new connlist(new dtodetcotizacion(array('id_cotizacion'=>$idcotizacion,
																							  'codprod'=>$codsap,
																							  'descripcion'=>$Listp->getelem()->descripcionc,
																							  'unimed'=>$Listp->getelem()->unimed,
																							  'cantidad'=>$cantidad,
                     																		  'totallinea'=>$valorflet
		                                                            ))));
		
		

		
		
		
		echo "<script type='text/javascript'>";
		echo " window.open('nueva_cotizacion_05.php?popup=1&aci=1&id_cotizacion=$idcotizacion','','top=100, left=100 ,width=800,height=720');";
		echo " window.close();"; 
		echo "</script>";	
	}
	else{
		
		//general::writelog("Web Service Fuera de Serivicio");
		
		
	}	                                                            
	
	
	
}else{
/*CALCULA EL TOTAL DE LOS PESOS EN COTI */
	$ListDet->gofirst();
	$tipoent = $ListDet->getelem()->id_tipoentrega;
   	do{
   		if($tipoent == 2){
			
   			$sumapeso += $ListDet->getelem()->peso * $ListDet->getelem()->cantidad;
   		}	
	}while($ListDet->gonext());
	
/* FIN CALCULA EL TOTAL DE LOS PESOS EN COTI */
	
	$xml = "<despacho>
				<direccion>$dirc</direccion>
				<idDepartamento>".$Listlocalizacion->getelem()->id_departamento."</idDepartamento>
				<idMunicipio>".$Listlocalizacion->getelem()->id_provincia."</idMunicipio>
				<idCentroPoblado>".$Listlocalizacion->getelem()->id_ciudad."</idCentroPoblado>
				<idLocalidad>".$Listlocalizacion->getelem()->id_localidad."</idLocalidad>
				<idBarrio>".$Listlocalizacion->getelem()->id_barrio."</idBarrio>
			</despacho>
			<centroSuministro>
				<idLocal>".$Listl->getelem()->cod_local_pos."</idLocal>
				<idDepartamento>".$Listlocal->getelem()->id_departamento."</idDepartamento>
				<idMunicipio>".$Listlocalizacion->getelem()->id_provincia."</idMunicipio>
				<idCentroPoblado>".$Listlocal->getelem()->id_ciudad."</idCentroPoblado>
				<idLocalidad>".$Listlocal->getelem()->id_localidad."</idLocalidad>
				<idBarrio>".$Listlocal->getelem()->id_barrio."</idBarrio>
			</centroSuministro>
			<entregaProductos>
				<lstTipoDespacho>
					<codigoTipo>$tipoent</codigoTipo>
					<peso>$sumapeso</peso>
				</lstTipoDespacho>
			</entregaProductos>
			<codEmpresaTransportadora>0</codEmpresaTransportadora>";
	
		
$i= 0;
$service = new Fletes;
$response = $service->calcular($xml);
	if ($response) {
		print_r ($response);
		$count = sizeof($response);
		if($count != 3){
			$tipoflete = $response['data']['lstValorFlete']['tipoFlete'];
			$tipodesp = $response['data']['lstValorFlete']['tipoDespacho'];
			$tipoenv = $response['data']['lstValorFlete']['tipoEnvio'];
			$valorflet = $response['data']['lstValorFlete']['valorFlete'];
			$cantidad = $response['data']['lstValorFlete']['cantidad'];
			$codsap = $response['data']['lstValorFlete']['codSAP'];
			$zona = $response['data']['zone'];
		}else{
			general::alert("Viene con  Adicional");
			
		}
		
		$msg2 = $response['exception']['state'];
		$msg = $response ['exception']['message'];
				
		if($msg2 != ''){
			
			general::confirmf(''.$msg.' \n¿Desea Ajustar Flete Manualmente?',true,false,$idcotizacion);
			
					
		}		
		
		   echo $xml; 
		
			echo "tipoflete",$tipoflete;
				
			echo "tipodesp",$tipodesp;	
				
			echo "tipoenvio",$tipoenv;	
				
			echo "valor flete",$valorflet;	
				
			echo "cantidad",$cantidad;	
					
			echo "codsap",$codsap;	
				
			echo "zona",$zona;	
				
															
		
		
		/* FIN EXTRACCION DE DATOS RESPUESTA WS */
		
		/*EXTRACCION DE DETALLE DEL PRODUCTO*/
		bizcve::getproducto($Listp = new connlist(new dtoproducto(array('sap'=>$codsap))));
		$Listp->gofirst();
		
		echo"c",$idcotizacion;
		echo"s",$codsap;
		echo"d",$Listp->getelem()->descripcionc;
		echo"u",$Listp->getelem()->unimed;
		echo"c",$cantidad;
		echo"f",$valorflet;
		/*FIN EXTRACCION DE DETALLE DEL PRODUCTO*/
		/*INSERCION DE FLETE A LA COTIZACION*/
		$Dao = new daocotizacion;
		$Dao->savedetcotizacion($ListEnc, $ListDetf = new connlist(new dtodetcotizacion(array('id_cotizacion'=>$idcotizacion,
																							  'codprod'=>$codsap,
																							  'descripcion'=>$Listp->getelem()->descripcionc,
																							  'unimed'=>$Listp->getelem()->unimed,
																							  'cantidad'=>$cantidad,
                     																		  'totallinea'=>$valorflet
		                                                            ))));
		
		

		                                                            
		echo "<script type='text/javascript'>";
		echo " window.open('nueva_cotizacion_05.php?popup=1&aci=1&id_cotizacion=$idcotizacion','','top=100, left=100 ,width=800,height=720');";
		echo " window.close();"; 
		echo "</script>";		                                                            
		                                                            
		/*popUpWindowModal('nueva_cotizacion_05.php?popup=1&id_cotizacion='*/

		
		                                                                                    
		/* FIN INSERCION DE FLETE A LA COTIZACION*/
		
		
	}
	else{
		
		//general::writelog("Web Service Fuera de Serivicio");
		
		
	}

}






	
		
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>
