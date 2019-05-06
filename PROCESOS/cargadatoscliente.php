<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
include_once("/var/www/html/cve/INCLUDE/ini.php");
include_once("/var/www/html/cve/INCLUDE/autoload.php");
//include_once("../CVEPUBLIC/INCLUDE/aplication_top.php");

/////////////////////// ZONA DE ACCIONES /////////////////////////
if ($argc != 2) {
       
        echo "ERROR: uso no valido de cargaDatosCliente.php\n";
        exit();
}

if ($argv[1] == 'SYSTEM') {
	
	cargar();
}
else {
	echo "ERROR: usuario ".$argv[1]." incorrecto para cargaDatosCliente.php\n";
}

function cargar2(){
	
	$r=bbrq::buscaarchivosmalos($_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_IN'),'TRG');
	foreach ($r as $value) {
    	echo "Value: $value\n";
	}


}

function cargar(){
	$command = 'whoami';
	$user = shell_exec($command);
	//$user = 'LINUX';
	
	general::writeevent("                                                                                                             ");
	general::writeevent("                                                                                                             "); 
	general::writeevent("*************************************************************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("                                                                                                             ");
	general::writeevent("                                                                                                             "); 
	general::writeevent('Incio de Proceso INGRESO CLIENTES SAP. Usuario '.$user.' a las  '.date( "h:i:s" , time () ));
	if (!is_dir($_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_IN'))){
		general::writeevent('El directorio especidicado no es valido '.$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_IN'));
		general::writeevent('No se procesaron Archivos');
		general::writeevent('Termino de Proceso INGRESO CLIENTES SAP. Usuario '.$user.' a las  '.date( "h:i:s" , time () ));
		exit();
	}
	if($r=bbrq::buscaarchivosmalos($_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_IN'),'TRG')){
		general::writeevent('Los siguientes Archivos no presentan Archivo de comprobacion');
		foreach ($r as $value) {
	    	general::writeevent($value);
		}
	}
	
	if ($ordenados = bbrq::leedirectorio($_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_IN'),'CVDCLIE',7,22,'TRG')){
		if (!chdir($_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_IN'))){
			general::writeevent('El directorio especidicado no es valido '.$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_IN'));
			general::writeevent('No se procesaron Archivos');
			general::writeevent('Termino de Proceso INGRESO CLIENTES SAP. Usuario '.$user.' a las  '.date( "h:i:s" , time () ));
			exit();
		}
		
		for($x=0;$x< count($ordenados);$x++){
			$clientes =  file($ordenados[$x]);
			if (!$clientes){
				general::writeevent('Problemas al intentar leer el archivo '.$ordenados[$x]);
			}else{
				$tamarr = count($clientes);
				for($p=0;$p<$tamarr;$p++){
					$errmessage = ''; 
					$valido = true;
					$dtoCliente = new dtoinfocliente();
																					 //Componente	Tipo  Long.Dec.	Desctipci?n Breve	Formato	Valores
					$dtoCliente -> codclisap	  = trim(substr($clientes[$p], 0, 10));		//KUNNR		CHAR	10	0	C?digo de cliente
					if (!$dtoCliente -> codclisap) {
						$dtoCliente -> codclisap = null;
						//$valido = false;
						$errmessage .= 'Codigo de cliente, ';
					}

					$dtoCliente -> razonsoc  	  = trim(substr($clientes[$p], 10, 35)); 		//NAME1		CHAR	35	0	Nombre de cliente	
					if (!($dtoCliente -> razonsoc) || $dtoCliente -> razonsoc == "") {
						$dtoCliente -> razonsoc = null;
						//$valido = false;
						$errmessage .= 'Nombre de cliente, ';
					}

					$dtoCliente -> direccion	  = trim(substr($clientes[$p], 45, 35));		//STRAS		CHAR	35	0	Direcci?n (Calle y n?mero)	
					if (!($dtoCliente -> direccion) || $dtoCliente -> direccion == "") {
						$dtoCliente -> direccion = null;
						//$valido = false;
						$errmessage .= 'Direccion (Calle y numero), ';
					}
					
					$dtoCliente -> nomcomuna 	  = str_replace("/", "", trim(substr($clientes[$p], 80, 35)));		//ORT02		CHAR	35	0	Comuna	
					if (!($dtoCliente -> nomcomuna) || $dtoCliente -> nomcomuna == "") {
						$dtoCliente -> nomcomuna = null;
						//$valido = false;
						$errmessage .= 'Comuna, ';
					}

					$dtoCliente -> nomciudad      = trim(substr($clientes[$p], 115, 35));		//ORT01		CHAR	35	0	Ciudad	
					if (!$dtoCliente -> nomciudad || $dtoCliente -> nomciudad == "") {
						$dtoCliente -> nomciudad = null;
						//$valido = false;
						$errmessage .= 'Ciudad, ';
					}

					$dtoCliente -> id_region	  = ((is_numeric(trim(substr($clientes[$p], 150, 3))))? (substr($clientes[$p], 150, 3)+0) : null);		//REGIO		CHAR	3	0	Regi?n	
					if (!$dtoCliente -> id_region) {
						//$valido = false;
						$errmessage .= 'Region, ';
					}
					$dtoCliente -> nomregion 	  = trim(substr($clientes[$p], 153, 20));		//REGIO_TEXTCHAR	20	0	Nombre de regi?n
					if (!$dtoCliente -> nomregion) {
						$dtoCliente -> nomregion= null;
						//$valido = false;
						$errmessage .= 'Nombre de region, ';
					}
					$dtoCliente -> fonocontacto	  = substr($clientes[$p], 173, 15);		//TELF1		CHAR	15	0	Fono	
					$dtoCliente -> email  		  = substr($clientes[$p], 188, 30);		//MAIL		CHAR	30	0	Email	
					
					if (strtoupper(trim(substr($clientes[$p], 218, 3))) != 'CL') {		//LAND1		CHAR	3	0	Pa?s
						//$valido = false;
						$errmessage .= 'Pais, ';
					}
					
					$rutt= trim(substr($clientes[$p], 221, 16));
					if ($rutt == ""){
						$valido = false;
						$errmessage .= 'Id. Fiscal (RUT), ';
					}
					$rut = split( "-",$rutt );
					/*BORRO RUT DE LA BASE DE DATOS SI YA ESTABA ANTES*/
					$Listarut = new connlist;
					$dtoCliente = new dtoinfocliente();
					$dtoCliente -> rut = $rut;
					$Listarut->addlast($dtoCliente);
					if(bizcve::delrutsap($Listarut)){
					  general::writeevent('Se eliminaron los datos antiguos del cliente rut: '.$rut);
					}else{
					  general::writeevent('No se pudo eliminar los datos antiguos del cliente rut: '.$rut);
					}

					if (!$rut){
						$valido = false;
						$errmessage .= 'Id. Fiscal (RUT), ';
					}else{
						$dv=general::digiVer($rut[0]+0);
						if (!(($rut[1]+0) == $dv)){
							$valido = false;
							$errmessage .= 'Id. Fiscal (RUT), ';
						}
					}
					 
					 
					$dtoCliente -> rut 			  = $rut[0]+0;							//STCD1		CHAR	16	0	Id. Fiscal (RUT)
												  // substr($clientes[$p], 237, 4);	    //VKBUR		CHAR	4	0	Oficina de ventas		Local	
					
				    
				    $dtoCliente -> codigovendedor = (trim(substr($clientes[$p], 241, 3)))? trim(substr($clientes[$p], 241, 3)):null;		//VKGRP		CHAR	3	0	Vendedor asignado	
					if (!($dtoCliente -> id_giro) || $dtoCliente -> id_giro == "") {
						//$valido = false;
						$errmessage .= 'codigovendedor, ';
					}
					$dtoCliente -> id_giro		  = (trim(substr($clientes[$p], 244, 4)))? trim(substr($clientes[$p], 244, 4)):null;		//BRSCH		CHAR	4	0	Giro comercial	
					if (!($dtoCliente -> id_giro) || $dtoCliente -> id_giro == "") {
						//$valido = false;
						$errmessage .= 'id_Giro, ';
					}
					$dtoCliente -> giro 		  = (trim(substr($clientes[$p], 248, 35)))? trim(substr($clientes[$p], 248, 35)):null;		//BRSCH_TEXTCHAR	20	0	Descripci?n del giro	
					if (!($dtoCliente -> giro) || $dtoCliente -> giro == "") {
						$dtoCliente -> giro = null;//pasa
						//$valido = false;
						$errmessage .= 'Giro comercial, ';
					}
					
					if (is_numeric(substr($clientes[$p], 283, 10)+0)){
						$via=substr($clientes[$p], 283, 10)+0;
						
						if(!bizcve::gettipodocpagosap($listatipos = new connlist(new dtotipo(array('valor3'=>$via))))){
							general::writeevent('Problemas al obtener Via de pago en Cliente '.substr($clientes[$p], 221, 16).' Archivo '.$ordenados[$x]);
						}
					
						if ($listatipos->numelem() == 1){
							$dtoCliente -> id_tipodocpago = $via+0;						//ZWELS		CHAR	10	2	Via de Pago
						}else{
							$dtoCliente -> id_tipodocpago = 1;//pasa
							//$valido = false;
							$errmessage .= 'Via de Pago, ';
						}
					}else{
						$dtoCliente -> id_tipodocpago = 1;//pasa
						//$valido = false;
						$errmessage .= 'Via de Pago, ';
					}					
						
					
					if (substr($clientes[$p], 307, 1)== '-' || substr($clientes[$p], 307, 1)== ' '){//nunca vendra +
						$signo = substr($clientes[$p], 307, 1);
					}else{
						//$valido = false;
						$signo = 0;
						$errmessage .= 'Signo de Disponible, ';
					}	
					
					$dtoCliente -> disponible	  = ((is_numeric(substr($clientes[$p], 293, 14)+0))? $signo.(substr($clientes[$p], 293, 14)+0) : null);   //KLIMK		DEC		15	2	Disponible	
					
					if (!$dtoCliente -> disponible) {
						$dtoCliente -> disponible =0;//pasa
						//$valido = false;
						$errmessage .= 'Disponible, ';
					}
					
					
					if (substr($clientes[$p], 308, 1) == 'X' || substr($clientes[$p], 308, 1) == 'x' ){
						 $dtoCliente -> locksap = 1;	//CRBLB		CHAR	1	0	Indicador de bloqueo
					}else{
						if (substr($clientes[$p], 308, 1) == ' '){
							$dtoCliente -> locksap = 0; //CRBLB		CHAR	1	0	Indicador de bloqueo
						}else{
							$dtoCliente -> locksap = 0;//pasa
							//$valido = false;
							$errmessage .= 'Indicador de bloqueo, ';
							
							
						}
					}
								
					$dtoCliente -> valdisp = ((is_numeric(substr($clientes[$p], 309, 8)+0))? (substr($clientes[$p], 309, 8)+0) : null);		//HORDA		CHAR	8	0	Fecha de validez del cr?dito
					if ($dtoCliente -> valdisp === null ||$dtoCliente -> valdisp == 0) {
						$dtoCliente -> valdisp = null;
						//$valido = false;
						$errmessage .= 'Fecha de validez del credito, ';
					}
					
					if (substr($clientes[$p], 317, 1) == 'X' || substr($clientes[$p], 317, 1) == 'x' ){
						 $dtoCliente -> lockmoro = 1;	//MOROSIDAD	CHAR	1	0	Indicador de morosidad	
					}else{
						if (substr($clientes[$p], 317, 1)== ' '){
							$dtoCliente -> lockmoro = 0; //MOROSIDAD	CHAR	1	0	Indicador de morosidad	
						}else{
							//$valido = false;
							$dtoCliente -> lockmoro = 0; //pasa
							$errmessage .= 'Indicador de morosidad, ';	
							
						}
					}
					$dtoCliente -> diascondicion =((is_numeric(substr($clientes[$p], 318, 4)+0))? (substr($clientes[$p], 318, 4)+0) : null);//ZTERM	CHAR	4	0	Condición de pago		
					if ($dtoCliente -> diascondicion === null) {
						$dtoCliente -> diascondicion = 0;
						//$valido = false;
						$errmessage .= 'Condicion de pago, ';
					}
					
					
					$dtoCliente -> id_tipocliente = 1;
					$dtoCliente -> usrcrea = $user;
				
					
				
				
/********************************************************** fin de carga dtoCliente****************************************************/
					
					if ($valido){
						
						if (!bizcve::putclientesap($lista = new connlist ($dtoCliente))){
							escribeReg($clientes[$p],$ordenados[$x]);
							//unset($lista);
							//unset($dtoCliente);
							//unset($listatipos);
							$lista = null;
							$dtoCliente = null;
							$listatipos = null;
							
							general::writeevent('El cliente rut '.(substr($clientes[$p], 221, 16)+0).' tiene problemas al insertarlo');
						}else{
							if ($errmessage != ''){
								general::writeevent('El cliente rut '.(substr($clientes[$p], 221, 16)+0).' fue insertado con los siguientes problemas: '.$errmessage);
							}
							
						}
					}else{
						//unset($lista);
						//unset($dtoCliente);
						//unset($listatipos);
						$lista = null;
						$dtoCliente = null;
						$listatipos = null;
						
						escribeReg($clientes[$p],$ordenados[$x]);
						general::writeevent('El cliente rut '.(substr($clientes[$p], 221, 16)+0).' tiene problemas en su consistencia en: '.$errmessage);
					}
					
					
				}//fin del for

				try{
					if (!is_dir($_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_PROC'))){
						general::writeevent('El directorio especidicado no existe '.$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_PROC'));
					}else{
						if (!rename($ordenados[$x] , $_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_PROC').$ordenados[$x])){
							general::writeevent('No se pudo mover el Archivo '. $ordenados[$x].' Al directorio '.$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_PROC').'listos/');
						}
					}
					
					if (file_exists($ordenados[$x].".TRG") && !unlink($ordenados[$x].".TRG")){
							general::writeevent('No se pudo Eliminar el Archivo '. $ordenados[$x].".TRG");
						}
					if (file_exists($ordenados[$x].".trg") && !unlink($ordenados[$x].".trg")){
						general::writeevent('No se pudo Eliminar el Archivo '. $ordenados[$x].".trg");
					}
					
				}
				catch (Exception 	$e){
					general::writeevent('Ocurrio el siguiente error al eliminar o mover archivos'.$e->getMessage());
					continue;					
				}
			}// fin del else		
		}//fin del for
		general::writeevent('Se procesaron '.count($ordenados).' archivos');
		general::writeevent('Termino de Proceso INGRESO CLIENTES SAP. Usuario '.$user.' a las  '.date( "h:i:s" , time () ));
	}else{
		general::writeevent('Se procesaron '.count($ordenados).' archivos');
		general::writeevent('Termino de Proceso INGRESO CLIENTES SAP. Usuario '.$user.' a las  '.date( "h:i:s" , time () ));
	}
}


function escribeReg($strCliente,$nomArch){
	try {
		$ArchivoError = fopen("ERROR".$nomArch, 'a');
		fputs($ArchivoError,$strCliente);
		fclose;
	}
	catch (Exception 	$e){
		general::writeevent('Ocurrio el siguiente error al escribir registros en archivo de error'.$e->getMessage());
		continue;
	}				
}
?>
