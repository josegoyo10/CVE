<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
include_once("/var/www/html/cve/INCLUDE/ini.php");
include_once("/var/www/html/cve/INCLUDE/autoload.php");
//include_once("../CVEPUBLIC/INCLUDE/aplication_top.php");
//
/////////////////////// ZONA DE ACCIONES /////////////////////////

if ($argc != 2) {
       
        echo "ERROR: uso no valido de cargadocsap.php\n";
        exit();
}

if ($argv[1] == 'SYSTEM') {
	
	
	$command = 'whoami';
	$user = shell_exec($command);
	//$user = 'linux';
	
	general::writeevent("                                                                                                             ");
	general::writeevent("                                                                                                             "); 
	general::writeevent("*************************************************************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("                                                                                                             ");
	general::writeevent("                                                                                                             ");  
	general::writeevent('Incio de Proceso INGRESO DOCUMENTOS SAP. Usuario '.$user.' a las  '.date( "h:i:s" , time () ));
	cargar($user);
 
	general::writeevent('Termino de Proceso INGRESO DOCUMENTOS SAP. Usuario '.$user.' a las  '.date( "h:i:s" , time () ));
	
}
else {
	echo "ERROR: usuario ".$argv[1]." incorrecto para cargadocsap.php\n";
}

function cargar($user){
	try{	
		if (!is_dir($_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_IN'))){
			general::writeevent('El directorio especidicado no es valido '.$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_IN'));
			general::writeevent('No se procesaron Archivos');
			return;
		}
		$archivos = array('0'=>'CVEFACT','1'=>'CVENCRE','2'=>'CVEGDES');
		for($w=0;$w< count($archivos);$w++){ 
			
			if ($ordenados = bbrq::leedirectorio($_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_IN'),$archivos[$w],7,38,'TRG')){
				
				if (!chdir($_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_IN'))){
					general::writeevent('El directorio especidicado no es valido: '.$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_IN'));
					general::writeevent('No se procesaron Archivos');
					return;
				}
				
				for($x=0;$x< count($ordenados);$x++){
					
					insertado($ordenados[$x],$user);		
				}	
			
				general::writeevent('Se procesaron '.count($ordenados).' archivos '.$archivos[$w]);
			}else{
				
				general::writeevent('Se procesaron '.count($ordenados).' archivos '.$archivos[$w]);
				
			}
		}//fin for $W
	}
	catch (Exception 	$e){
		general::writeevent($e->getMessage());

	}					
}


function insertado($ordenados,$user){
			
	$listaEnc = new connlist();
	$listaDet = new connlist();
	$errormsg = '';
	
    if(!$documentos =  file($ordenados)){
		general::writeevent('Fallo inesperado al Leer Archivo: '.($ordenados));
		return false;
	}

	$valido = true;
	$dtodocumento = new dtodocumento();
																		 //Componente	Tipo  Long.Dec.	Desctipci?n Breve	Formato	Valores
  	if (!((substr($documentos[0], 0, 1) == 'C' )|| (substr($documentos[0], 0, 1) == 'c'))){//TIP_REG		CHAR	1	0	Tipo de Registro				C
  		$valido = false;
  		$errormsg.= 'Tipo de Registro, ';
  	}	
	//$dtodocumento -> numorigen 	  = ((is_numeric(substr($documentos[0], 1, 10)))? (substr($documentos[0], 1, 10)+0) : $valido = false);		//DOC_NUMBER	CHAR	10	0	N?mero de documento		
	$dtodocumento -> tipoorigen   = 'OE';
	$dtodocumento -> id_tipoorigen  = 2;
	
	$doc_type					  = substr($documentos[0], 11, 4);		//DOC_TYPE		CHAR	4	0	Tipo de venta		
	if ($doc_type == 'ZVZC' || $doc_type == 'ZVZS'){
		$dtodocumento -> id_tipodocumento = 1;
		$dtodocumento -> sigtipodoc = 'FCT';
	}else{
		if ($doc_type == 'ZDMA' || $doc_type == 'ZNCC' || $doc_type == 'ZDCZ'){
			$dtodocumento -> id_tipodocumento = 3;
			$dtodocumento -> sigtipodoc ='NCR'; 
		}else{
            if (trim($doc_type) == 'ZLF'){
                $dtodocumento -> id_tipodocumento = 2;
			    $dtodocumento -> sigtipodoc ='GDE';                        
            }else{
			    $valido = false;
			    $errormsg.= 'Tipo de venta, ';
            }
		}						
		
	}
	 
	if ($dtodocumento -> id_tipodocumento == 3){ //Si es NCR BUSCO NUMERO DE OE
				
		$dtodocumento -> numorigen      = ((is_numeric(substr($documentos[0], 15, 35)+0))? (substr($documentos[0], 15, 35)+0) : false);	//REFERENCIA	CHAR	35	0	OE o FOLIO de factura
		if (!$dtodocumento -> numorigen) {
			$valido = false;
			$errormsg .= 'OE o Folio de factura, ';
		}
		
		if (!bizcve::getdocumentosap2($listaexiste2 = new connlist( new dtodocumento(array('numdocumento'=>$dtodocumento -> numorigen,'id_tipodocumento'=>1))),$listadetalle = new connlist)){
			$valido= false;					
			general::writeevent('Problemas al obtener N° sw OE para documento N'.$listaEnc->getelem()->id_documento.' Creando Mensaje');
		}
		
		$listaexiste2 -> gofirst();
		$dtodocumento -> numorigen = $listaexiste2->getelem()->numorigen;
        $dtodocumento -> numdocref = $listaexiste2->getelem()->id_documento;
		
	}else{
        
        
        $dtodocumento -> numorigen      = ((is_numeric(substr($documentos[0], 15, 35)+0))? (substr($documentos[0], 15, 35)+0) : false);	//REFERENCIA	CHAR	35	0	OE o FOLIO de factura	
		
        if (!$dtodocumento -> numorigen && $dtodocumento ->id_tipodocumento == 1) {
			$valido = false;
			$errormsg .= 'OE o Folio de factura, ';
		}
        
    }

	$dtodocumento -> fechadocumento = ((is_numeric(substr($documentos[0], 50, 8)+0))? (substr($documentos[0], 50, 8)+0) : false);		//FECHA			CHAR	8	0	Fecha de factura		
	if (!$dtodocumento -> fechadocumento) {
			$valido = false;
			$errormsg .= 'Fecha de factura, ';
	}
	
	$codlocalventa					= substr($documentos[0], 58, 4);	//VKBUR			CHAR	4	0	Oficina de ventas		Local
	if (!bizcve::getlocalessap($listalocal = new connlist(new dtolocal(array('ofventa'=>$codlocalventa))))){
		general::writeevent('Problemas al obtener oficiana de ventas en documento N'.$listaEnc->getelem()->id_documento.' Creando Mensaje');
		$valido = false;
	}
	$listalocal->gofirst();
	$dtodocumento -> codlocalventa = $listalocal->getelem()->cod_local;
	
	$dtodocumento -> codigovendedor = substr($documentos[0], 62, 3);	//VKGRP			CHAR	3	0	Vendedor	
	//$dtodocumento ->				= substr($documentos[0], 65, 3);	//INCO1			CHAR	3	0	Forma de entrega
	
    
    $dtodocumento -> numdocumento	= ((is_numeric(substr($documentos[0], 70, 14)+0))? (substr($documentos[0], 70, 14)+0) : false);	//FOLIO			CHAR	16	0	Folio Externo
	
    if (!$dtodocumento -> numdocumento) {
		$valido = false;
		$errormsg .= 'Folio Externo, ';
	}
/*
	if (!bizcve::getdocumentosap2($listaexiste = new connlist( new dtodocumento(array('numdocumento'=>$dtodocumento -> numdocumento))),$listadetalle = new connlist)){
		$valido= false;					
		general::writeevent('Problemas al obtener oficiana de ventas en documento N'.$listaEnc->getelem()->id_documento.' Creando Mensaje');
	}
	if ($listaexiste->numelem() == 0 ){
*/
		//$dtodocumento -> codclisap		= substr($documentos[0], 84, 10);//KUNNR			CHAR	10	0	C?digo de cliente
		$dtodocumento -> razonsoc		= substr($documentos[0], 94, 35);	//NAME1			CHAR	35	0	Nombre de cliente
		$dtodocumento -> direccion		= substr($documentos[0], 129, 35);	//STRAS			CHAR	35	0	Direcci?n (Calle y n?mero)
		$dtodocumento -> comuna			= substr($documentos[0], 164, 35);	//ORT02			CHAR	35	0	Comuna
		//$dtodocumento ->				= substr($documentos[0], 199, 35);	//ORT01			CHAR	35	0	Ciudad
		//$dtodocumento ->				= substr($documentos[0], 234, 3);	//REGIO			CHAR	3	0	Regi?n
		//$dtodocumento -> 				= substr($documentos[0], 237, 20);	//REGIO_TEXT	CHAR	20	0	Nombre Regi?n	
		$dtodocumento -> fonocontacto	= substr($documentos[0], 257, 15);	//TELF1			CHAR	15	0	Fono
		//$dtodocumento -> 				= substr($documentos[0], 272, 30);	//EMAIL			CHAR	30	0	Email
		//$dtodocumento -> 				= substr($documentos[0], 302, 3);	//LAND1			CHAR	3	0	Pa?s
		
		$rut = split( "-", substr($documentos[0], 305, 16));				//STCD1			CHAR	16	0	Id. Fiscal (RUT)
		if (!$rut){
			$valido = false;
			$errormsg .= 'Id. Fiscal (RUT), ';
		}else{
			$dv=general::digiVer($rut[0]+0);
			if (!(($rut[1]+0) == $dv)){
				$valido = false;
				$errormsg .= 'Id. Fiscal (RUT), ';
			}
		}
		$dtodocumento -> rutcliente = $rut[0];
		
		$dtodocumento -> iva			= ((is_numeric(substr($documentos[0], 321, 5)))? (substr($documentos[0], 321, 5)+0) : false); //IND_IVA		DEC		2	2	% IVA	
		if (!$dtodocumento -> iva) {
			$valido = false;
			$errormsg .= '% IVA, ';
		}

		$dtodocumento -> id_giro		= substr($documentos[0], 326, 4);	//BRSCH			CHAR	4	0	Giro comercial
		$dtodocumento -> giro 			= trim(substr($documentos[0], 330, 35));//BRSCH_TEXT	CHAR	20	0	Descripci?n del giro
		$dtodocumento -> usrcrea		= $user;
		$dtodocumento -> usrmod			= $user;

		$dtodetdocumento = new dtodetdocumento();			
		if (count($documentos) > 1){
			for($d=1;$d<count($documentos);$d++){
																				    				 	  //Componente	Tipo  Long.Dec.	Desctipci?n Breve	Formato	Valores
				if (!((substr($documentos[$d], 0, 1) == 'D' )|| (substr($documentos[$d], 0, 1) == 'd'))){   //TIP_REG	CHAR	1	0	Tipo de Registro				D
  					$valido = false;
  					$errormsg .= '% IVA, ';
  				}
  				$dtodetdocumento = new dtodetdocumento();
  				//$dtodetdocumento -> 			= substr($documentos[$d], 1, 10);	//DOC_NUMBER	CHAR	10	0	N?mero de documento	
  				$dtodetdocumento -> numlinea	= substr($documentos[$d], 11, 6);	//ITEM			CHAR	6	0	N?mero de Item	
  				$dtodetdocumento -> codprod		= ((is_numeric(substr($documentos[$d], 17, 18)))? (substr($documentos[$d], 17, 18)+0) : false); //MATERIAL		CHAR	18	0	Art?culo	
				if (!$dtodetdocumento -> codprod) {
					$valido = false;
					$errormsg .= 'Artículo, ';
				}
  				$dtodocumento -> codlocalcsum   = substr($documentos[$d], 35, 4);	//PLANT			CHAR	4	0	Tienda que despacha		
  				$dtodetdocumento -> cantidad	= ((is_numeric(substr($documentos[$d], 39, 15)))? (substr($documentos[$d], 39, 15)+0): false);	  //REQ_QTY		DEC		15	3	Cantidad	
				if (!$dtodetdocumento -> cantidad) {
					$valido = false;
					$errormsg .= 'Cantidad, ';
				}
  				$dtodetdocumento -> unimed		= general::umconvertsapcve(substr($documentos[$d], 54, 3));	//SALES_UNIT	CHAR	3	0	Unidad de medida de venta	
  				$dtodetdocumento -> pventaneto	= ((is_numeric(substr($documentos[$d], 58, 15)+0))? (substr($documentos[$d], 58, 15)+0) : false); //PRECIO_VENTA	DEC		15	2	Precio de venta
				if (!$dtodetdocumento -> pventaneto) {
					$valido = false;
					$errormsg .= 'Precio de venta, ';
				}
  				$dtodetdocumento -> pcosto      = ((is_numeric(substr($documentos[$d], 73, 15)+0))? (substr($documentos[$d], 73, 15)+0) : false); //PRECIO_COSTO	DEC		15	2	Precio de costo
				if (!$dtodetdocumento -> pcosto) {
					$valido = false;
					$errormsg .= 'Precio costo, ';
				}

                $dtodetdocumento -> usrcrea = $user;
                $dtodetdocumento -> usrmod = $user;
              						
				
            }
		}
	
        $listaEnc ->addfirst($dtodocumento);
        $listaDet-> addfirst($dtodetdocumento);
/*
	}else{
	 $valido = false;
	}
	*/			
	if ($valido){
	
		if (!bizcve::putdocumentosap($listaEnc,$listaDet)){
			general::writeevent('Problemas al Insertar en BD el Archivo '.$ordenados);
		}else{
			if (!is_dir($_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_PROC'))){
				general::writeevent('El directorio especidicado no existe '.$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_PROC'));
			}else{
				if (!rename($ordenados , $_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_PROC').$ordenados)){
					general::writeevent('No se pudo mover el Archivo '. $ordenados.' Al directorio '.$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_PROC'));
				}
				if (file_exists($ordenados.".TRG") && !unlink($ordenados.".TRG")){
					general::writeevent('No se pudo Eliminar el Archivo '. $ordenados.".TRG");
				}
				if (file_exists($ordenados.".trg") && !unlink($ordenados.".trg")){
					general::writeevent('No se pudo Eliminar el Archivo '. $ordenados.".trg");
				}
			}
		}
	}else{
        general::writeevent('Problemas de consistencia en Archivo '.$ordenados.' en Artributos: '.$errormsg);
		if (!is_dir($_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_PROC'))){
				general::writeevent('El directorio especidicado no existe '.$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_IN '));
		}else{
		    if (!rename($ordenados , $_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_IN').'ERROR'.$ordenados)){
				general::writeevent('No se pudo Renombrar el Archivo '. $ordenados.' Al directorio '.$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_IN'));
			}
			if (file_exists($ordenados.".TRG") && !unlink($ordenados.".TRG")){
					general::writeevent('No se pudo Eliminar el Archivo '. $ordenados.".TRG");
				}
			if (file_exists($ordenados.".trg") && !unlink($ordenados.".trg")){
					general::writeevent('No se pudo Eliminar el Archivo '. $ordenados.".trg");
			}
		}	

    }
		
}


?>
