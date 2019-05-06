<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
//linux
include_once("/var/www/html/cve/INCLUDE/ini.php");
include_once("/var/www/html/cve/INCLUDE/autoload.php");

//windows
//include_once("../CVEPUBLIC/INCLUDE/ini.php");
//include_once("../CVEPUBLIC/INCLUDE/autoload.php");



//include_once("../CVEPUBLIC/INCLUDE/aplication_top.php");
//
/////////////////////// ZONA DE ACCIONES /////////////////////////

if ($argc != 2) {
       
        echo "ERROR: uso no valido de generadocumentosap.php\n";
        exit();
}

if ($argv[1] == 'SYSTEM') {
	
	genera();
}
else {
	echo "ERROR: usuario ".$argv[1]." incorrecto para generadocumentosap.php\n";
}

function genera(){
	$command = 'whoami';
	$user = shell_exec($command);
	//$user = 'linux';
	
	general::writeevent("                                                                                                             "); 
	general::writeevent("*************************************************************************************************************");
	general::writeevent("***** PROCESO GENERACION INTERFACES SAP *********************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("                                                                                                             ");
	general::writeevent('Incio de Proceso Genera Documentos para Sap por Usuario '.$user);
	flujo5($user);
	generaCVS();
	general::writeevent('Termino de Proceso Genera Documentos para Sap por Usuario '.$user);
}

function flujo5($user){
	$flujo = 5;	
	$orden = ordenentrega('OG',$flujo,$user);
	
//	if ($orden->numelem()){
//		$orden->gofirst();
//		do{
/****** MODIFICACION GOA 11-12-2007. Cambio de nombre CVGGDES -> CVGGDEC  *****/	
//			$gde = documento($orden->getelem()->id_ordenent,$flujo,2,1,'CVGGDEC','trg',$user);
//			if ($gde->numelem()){
//				$gde->gofirst();
//				do{
//					$factura = documento($gde->getelem()->id_documento,$flujo,1,1,'CVFFCTD','trg',$user);
//				}while($gde->gonext());
//			}		
//		}while ($orden->gonext());
//	}
		
}


function ordenentrega($estado,$tipoflujo,$user){

/****** MODIFICACION GOA 11-12-2007. Cambio de nombre CVPODES -----> CVPODEC solo si es flujo 4 *****/	
	
//	if( $tipoflujo == 5){
		$ode = 'CVPODEC';
//	}else{
//		$ode = 'CVPODES';	
//	}
	
	$suf = 'trg';
	$listaEncode0 = new connlist($ordenentrega = new dtoencordenent(array ('id_estado' => $estado,
															    		   'id_tipoflujo'=> $tipoflujo
															   			  )));
	
	
	if(!bizcve::getordenentsapflujo5($listaEncode0,$listaDetode = new connlist())){
		general::writelog('ERROR al Obtener OE en flujo '.$tipoflujo );
		return;			
	}
	
	$listaEncode0->gofirst();
	if ($listaEncode0->numelem()) {
		do{
			if (!$listaEncode0->getelem()->indmsgsap){
				$listaEncode = new connlist($ordenentrega = new dtoencordenent(array ('id_ordenent' =>$listaEncode0->getelem()->id_ordenent )));
				if (!bizcve::getordenent($listaEncode,$listaDetode = new connlist())){
					general::writelog('ERROR al Obtener OE en flujo '.$tipoflujo);
					return;	
				}
				
				$nom = $listaEncode0->getelem()->codlocalventa.$ode.date("Ymd").general::CompletaCerosI($listaEncode0->getelem()->id_ordenent,8);
				$myMsgOde = creaMsgode($listaEncode,$listaDetode,false);
				if(grabaarchivo($myMsgOde,$nom,$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_5'),false)){
					general::writeevent("Archivo generado: $nom en " . $_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_5'));
					//Generamos el mismo archivo en carpeta de backup
					if (!grabaarchivo($myMsgOde,$nom,$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_BKP'),true))
						general::writelog("ERROR al grabar archivo BACKUP SAP " . $_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_BKP') . $nom . " [MSG: " . $myMsgOde . "]" );
					
					$nom .= '.'.$suf;
					if (grabaarchivo(' ',$nom,$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_5'),false)){
						$listaEncode00 = new connlist($ordenentrega = new dtoencordenent(array ('id_ordenent' => $listaEncode0->getelem()->id_ordenent,
																 		    		 			'indmsgsap' => 1,
																 		    		 			'usrmod'=>$user																 		    		 			
																		   			  		   )));
						
						if(!bizcve::cambioindicadorsap($listaEncode00)){
							general::writelog('ERROR al marcar envio a Sap en OE N'.$listaEncode0->getelem()->id_ordenent.' flujo 3');
						}
					}
				}
				else {
					general::writelog("ERROR al grabar archivo SAP " . $_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_5') . $nom . " [MSG: " . $myMsgOde . "]" );
				}
			}
		}while ($listaEncode0->gonext());
		return $listaEncode0;		
	}else{
		return $lista = new connlist();
	}
	
}





		
function creaMsgode($listaEnc,$listaDet,$odea){
			
			//Obtengo el nombre de la ciudad y la region
			$ctrlcom = new ctrltipos();
			$ctrlcom->getcomuna($ListCom = new connlist(new dtocomuna(array('nomcomuna'=>$listaEnc->getelem()->comuna))));
			$ListCom->gofirst();
			
			//Obtengo datos adicionales del cliente
			$ctrlcte = new ctrlinfocliente();
			$ctrlcte->getCliente($ListCte = new connlist(new dtoinfocliente(array('rut'=>$listaEnc->getelem()->rutcliente))));
			$ListCte->gofirst();
			
			//Obtengo datos de tipos de flujos
			$ctrltipo = new ctrltipos();
			$ctrltipo->gettipoflujo($ListTipo = new connlist(new dtotipo(array('id'=>$listaEnc->getelem()->id_tipoflujo))));
			$ListTipo->gofirst();
			
			//Escribirlos en un stream formateado el encabezado
			$encabezado = general::CompletaEspaciosD('C', 1); 									//TIP_REG		CHAR	1	0	Tipo de Registro
			$encabezado .= general::CompletaCerosI($listaEnc->getelem()->id_ordenent, 10); 		//DOC_NUMBER	CHAR	10	0	Numero de documento
			$encabezado .= general::CompletaEspaciosD($ListTipo->getelem()->valor3, 4); 		//DOC_TYPE		CHAR	4	0	Tipo de venta
			$encabezado .= ($listaEnc->getelem()->numdocumento)? general::CompletaCerosI($listaEnc->getelem()->numdocumento,16):general::CompletaEspaciosD('',16);//REF_NUMBER	CHAR	16	0	Folio Externo Factura Relacionada		

			if (!bizcve::getlocalessap($listalocal = new connlist(new dtolocal(array('cod_local'=>$listaEnc->getelem()->codlocalventa))))){
				general::writelog('ERROR al obtener oficiana de ventas en FCT N'.$listaEnc->getelem()->id_documento.' Creando Mensaje');
				return;		
			}
			$listalocal->gofirst();
			$encabezado .= general::CompletaEspaciosD($listalocal->getelem()->ofventa, 4); 		//VKBUR			CHAR	4	0	Oficina de ventas
			$encabezado .= general::CompletaEspaciosD($listaEnc->getelem()->codigovendedor, 3); //VKGRP			CHAR	3	0	Vendedor
			$encabezado .= general::CompletaCerosI($listaEnc->getelem()->diascondicion, 4); 	//ZTERM			CHAR	4	0	Forma de pago		0000, 0001,....
			$encabezado .= general::CompletaEspaciosD($ListTipo->getelem()->valor2, 3);			//INCO1			CHAR	3	0	Forma de entrega
			if ($ListCte->getelem()->codclisap){
				$rut = $ListCte->getelem()->codclisap;
			}else{
				$rut = $listaEnc->getelem()->rutcliente;
			}
			$encabezado .= general::CompletaEspaciosD($rut, 10);						 		//KUNNR			CHAR	10	0	Codigo de cliente
			$encabezado .= general::CompletaEspaciosD($listaEnc->getelem()->razonsoc, 35); 		//NAME1			CHAR	35	0	Nombre de cliente
			$encabezado .= general::CompletaEspaciosD($listaEnc->getelem()->direccion, 35); 	//STRAS			CHAR	35	0	Direccion (Calle y numero)
			$encabezado .= general::CompletaEspaciosD($listaEnc->getelem()->comuna, 35); 		//ORT02			CHAR	35	0	Comuna
			$encabezado .= general::CompletaEspaciosD($ListCom->getelem()->nomciudad, 35);	 	//ORT01			CHAR	35	0	Ciudad
			$encabezado .= general::CompletaEspaciosD(general::CompletaCerosI($ListCom->getelem()->id_region,2),3);//REGIO			CHAR	3	0	Region
			$encabezado .= general::CompletaEspaciosD($ListCom->getelem()->nomregion, 20); 		//REGIO_TEXT	CHAR	20	0	Nombre Region
			$encabezado .= general::CompletaEspaciosD($listaEnc->getelem()->fonocontacto, 15); 	//TELF1			CHAR	15	0	Fono
			$encabezado .= general::CompletaEspaciosD($ListCte->getelem()->email, 30); 			//EMAIL			CHAR	30	0	Email
			$encabezado .= general::CompletaEspaciosD('CL', 3); 								//LAND1			CHAR	3	0	Pais
			$encabezado .= general::CompletaEspaciosD($listaEnc->getelem()->rutcliente."-".general::digiVer($listaEnc->getelem()->rutcliente), 16); 		//STCD1			CHAR	16	0	Id. Fiscal (RUT)
			$encabezado .= general::CompletaCerosI($listaEnc->getelem()->iva, 5); 				//IND_IVA		DEC		2	2	% IVA
			$encabezado .= general::CompletaCerosI($listaEnc->getelem()->id_giro, 4); 			//BRSCH			CHAR	4	0	Giro comercial
			$encabezado .= general::CompletaEspaciosD($listaEnc->getelem()->giro, 35); 			//BRSCH_TEXT	CHAR	20	0	Descripcion del giro
			$encabezado .= "\n";
			
			//Iterar por el detalle de la OE
			$listaDet->gofirst();
			if ($listaDet->numelem()) {
				do {
					//Imprimir archivo de texto (Utilizar rutina de Shino)
/****************************************** MODIFICACION GOA 19-12-2007. Marca en detalle para producto flete  ************************************************/						
			if ($listaDet->getelem()->codprod == 12501){
				$detalle .= general::CompletaEspaciosD('F', 1);											//TIP_REG		CHAR	1	0	Tipo de Registro
			}else{
				$detalle .= general::CompletaEspaciosD('D', 1);											//TIP_REG		CHAR	1	0	Tipo de Registro
			}					
					$detalle .= general::CompletaEspaciosD('D', 1);												//TIP_REG		CHAR	1	0	Tipo de Registro
					$detalle .= general::CompletaCerosI($listaEnc->getelem()->id_ordenent, 10); 				//DOC_NUMBER	CHAR	10	0	Numero de documento
					$detalle .= general::CompletaCerosI($listaDet->getelem()->numlinea, 6); 					//ITEM			CHAR	6	0	Numero de Item
					$detalle .= general::CompletaCerosI($listaDet->getelem()->codprod, 18); 					//MATERIAL		CHAR	18	0	Articulo
					$detalle .= general::CompletaEspaciosD($listaEnc->getelem()->codlocalcsum, 4); 				//PLANT			CHAR	4	0	Tienda que despacha
						if($odea){
							$cantsd = (int)$listaDet->getelem()->cantidad; 
							$cantde = substr($listaDet->getelem()->cantidad, -2);
						}else{
						$cantsd = (int)$listaDet->getelem()->cantidade; 
						$cantde = substr($listaDet->getelem()->cantidade, -2);
						}
						
						
					$detalle .= general::CompletaCerosI($cantsd, 11).'.'.general::CompletaCerosD($cantde, 3); 	//REQ_QTY	DEC		15	3	Cantidad
					$detalle .= general::CompletaEspaciosD(general::umconvertcvesap($listaDet->getelem()->unimed), 3); 					//SALES_UNIT	CHAR	3	0	Unidad de medida de venta
					$detalle .= general::CompletaCerosI(round($listaDet->getelem()->pventaneto), 12).'.00'; 	//PRECIO_VENTA	DEC	15	2	Precio de venta
					$detalle .= general::CompletaCerosI(round($listaDet->getelem()->pcosto), 12).'.00'; 									//TODO: 2da etapa OE con PCosto //PRECIO_COSTO	DEC	15	2	Precio de costo
					$detalle .= "\n";
				} while ($listaDet->gonext());
			}
				
	return $encabezado.$detalle;
}

function grabaarchivo($msg,$nom,$directorio,$gz){
	try{
			if (bbrq::guardaArchivo($msg,$nom,$directorio,$gz)){
				return true;
			}
	}
	catch (Exception 	$e){
		general::writelog($e->getMessage());
		return;
	}				
}

function generaCVS(){
	$archivoCSV = DOCCVE.date("mdY");
	if($ordenados = bbrq::BuscaArchivos($_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_5'),'trg',4,28)){
		$msgCVS ='';
			 	if (!chdir($_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_5'))){
						general::writeevent('El directorio especificado no es valido '.$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_IN_PREF'));
						general::writeevent('No se procesaron Archivos');
						general::writeevent('Termino de Proceso INGRESO CLIENTES PREFERENTE. Usuario '.$user.' a las  '.date( "h:i:s" , time () ));
						exit();
				}	
		//general::alert(count($ordenados));
		for($x=0;$x< count($ordenados);$x++){
				$nombreArchivo = substr($ordenados[$x],4,27);  
			 	$localArchivo = substr($ordenados[$x], 0,4); 
			 	//general::alert('$localArchivo  '.$localArchivo);
			 	//general::alert('$$nombreArchivo  '.$nombreArchivo);		 
	
			 	//para windows
			 	$msgCVS .=$nombreArchivo.",\"".$localArchivo."\"
	";
			 	
			 	//para texto
			 	//$msgCVS .=$nombreArchivo.",\"".$localArchivo."\"\\n";
			 	
			 	
			 	
			 	//general::alert(substr($ordenados[$x],0,27));
			 	/*me paro en directorio*/
				if (!is_dir($_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_5'))){
					general::writeevent('El directorio especidicado no existe '.$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_5'));
				}else{
					if (!rename($ordenados[$x] , $_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_5').$nombreArchivo)){
						general::writeevent('No se pudo renombrar el Archivo '. $ordenados[$x].' Al directorio '.$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_5'));
					}
				
		    		$command = 'gzip -9 '.$nombreArchivo;
					$cmd = shell_exec($command);
		    	
		    	
					if (!rename($ordenados[$x].".trg" , $_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_5').$nombreArchivo.".trg")){
						general::writeevent('No se pudo renombrar el Archivo '. $ordenados[$x].' Al directorio '.$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_5'));
					}
				}
						
		
		}
		//general::alert($msgCVS);
		if(grabaarchivo($msgCVS,$archivoCSV.".csv",$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_5'),true)){
						general::writeevent("Archivo generado: $archivoCSV .csv en " . $_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_5'));
		}
		
		if(grabaarchivo(' ',$archivoCSV.".trg",$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_5'),false)){
						general::writeevent("Archivo generado: $archivoCSV .trg en " . $_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT_5'));
		}
	}
}
?>
