<?php

	if (is_dir('/var/www/html/cveco-testing.cencosud.corp/')) {
		// testing
		chdir("/var/www/html/cveco-testing.cencosud.corp/PROCESOS/anulacion_OE/proceso");
	} elseif (is_dir('/var/www/html/cvecolombia/')) {
		// Produccion
		chdir("/var/www/html/cvecolombia/PROCESOS/anulacion_OE/proceso");
	} else {  
		// No definido
		die("No se detecta si es Test o Produccion el ambiente, favor de agregar el suyo en caso de ser ejecucion local");
	}

	set_time_limit(0);
	error_reporting(0);
	$debug = 1;
	ini_set('memory_limit', '1024M');

	///////////////////////// ZONA DE INCLUSION /////////////////////////
	include_once(dirname(dirname(dirname(dirname(__FILE__))))."/CVEPUBLIC/INCLUDE/ini.php");
	include_once(dirname(dirname(dirname(dirname(__FILE__))))."/CVEPUBLIC/INCLUDE/autoload.php");
	//
	/////////////////////// ZONA DE ACCIONES /////////////////////////
	
	function fAnularEO($OE) {
		$List    = new connlist;
		$ianular = new dtoencordenent;
		$ianular->id_ordenent =$OE;	
		$ianular->id_estado	  ='OG';
		$ianular->obsdesb 	  ='Anulacion';		
		$List->addlast($ianular);
		if (bizcve::anularoe($List)){
			$Lista    = new connlist;
			$Listdet = new connlist;
			$ianulara = new dtoencordenent;
			$ianulara->id_ordenent = $OE;
			$Lista->addlast($ianulara);
			bizcve::getordenent($Lista, $Listdet);
			general::writeevent('Se ha anulado la Orden de Entrega Nº ' . $OE . ' ' .$user );
			echo "    Se ha anulado la Orden de Entrega Nº " . $OE . "\n";
			bizcve::ActualizaCantNVEOE($Listdet, '-');
		} else {
			general::writeevent('Fallo la ejecucion del metodo anularoe, favor de revisar '.$user );
		}
		return;
	}		
	
	function fAnularDocumento($OE, $num, $tipo, $id) {
		$List = new connlist;
		$ieditar = new dtodocumento;
		$ieditar->numdocumento = $num;
		$ieditar->sigtipodoc = $tipo;
		$ieditar->id_documento = $id;
		$List->addlast($ieditar);
		if (bizcve::anuladoc($List)){
			echo "    El documento con el folio ".$num." ha sido anulado. \n";
			general::writeevent('El documento con el folio ' . $num . ' ha sido anulado. ' .$user );
			general::inserta_tracking(null, $OE, null, null, "Se ha anulado el Folio (".$tipo."): ".$num.".");
		}
		return;
	}
	
	$user = 'Proc. Anul.';
	$ses_usr_login = $user;
	global $ses_usr_login;
	
	echo "Usuario: " . $user . "\n";
	general::writeevent("                                                                                                             ");
	general::writeevent("                                                                                                             "); 
	general::writeevent("*************************************************************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("                                                                                                             ");
	general::writeevent("                                                                                                             ");
	general::writeevent('Incio de Proceso Anulacion Cotizacion por Usuario '.$user.' a las  '.date( "h:i:s" , time() ));
	
	$arrayOE = array();
	$arrayDocNum = array();
	$arrayDocSig = array();
	$arrayDocId = array();

	/*Obtencion de las Ordenes de Entrega para anular*/
	if (!bizcve::getordenentan($listaOE = new connlist(new dtoencordenent(array('verif_anul_tiempo'=>'S'))))) {
		general::writeevent('Fallo la ejecucion del metodo getordenentan, favor de revisar '.$user );
	} else {
		$listaOE->gofirst();
		if ($listaOE->getelem()->id_ordenent) {
			echo "Se encontraron Ordenes de entrega para anular\n\n";
			do {
				array_push($arrayOE,$listaOE->getelem()->id_ordenent);
			} while ($listaOE->gonext());
		} else {
			general::writeevent('No se encontraron Ordenes de entrega para anular'.$user );
			echo "No se encontraron Ordenes de entrega para anular\n\n";
		}
		unset ($listaOE);
		/* Obtencion de los documentos para anulacion */
		for ($x=0;$x<count($arrayOE); $x++) {
			$ordenEntrega = $arrayOE[$x];
			#echo "OE: " . $ordenEntrega . "\n";
			if (!bizcve::getdocumento($listaDoc = new connlist(new dtodocumento(array('numorigen'=>$ordenEntrega))))) {
				general::writeevent('Fallo la ejecucion del metodo getdocumento, favor de revisar '.$user );
			} else {
				$listaDoc->gofirst();
				if ($listaDoc->getelem()->numdocumento) {
					do {
						array_push($arrayDocNum,$listaDoc->getelem()->numdocumento);
						array_push($arrayDocSig,$listaDoc->getelem()->sigtipodoc);
						array_push($arrayDocId,$listaDoc->getelem()->id_documento);
					} while ($listaDoc->gonext());
					unset ($listaDoc);
					for ($i=0;$i<count($arrayDocNum); $i++) {
						$numDocu=$arrayDocNum[$i];
						$idTipoDocu=$arrayDocSig[$i];
						$idDocu=$arrayDocId[$i];
						#echo "Numero: " . $numDocu . " --- Sig: " . $idTipoDocu . " --- ID: " . $idDocu ."\n";
						/* Anulacion del documento obtenido */
						fAnularDocumento($ordenEntrega, $numDocu, $idTipoDocu, $idDocu);
						/* Anulacion del documento obtenido */
					}
				} else {
					general::writeevent('No se encontraron Facturas para anluar para la OE ' . $ordenEntrega . ' ' . $user );
					#echo "    No se encontraron Facturas para anluar para la OE " . $ordenEntrega . "\n";
				}
			}
			/* Anulacion de la orden de entrega */
			fAnularEO($ordenEntrega);
			/* Anulacion de la orden de entrega */
		}
	}
	
	general::writeevent('Termino de Proceso Anulacion Cotizacion por Usuario '.$user.' a las  '.date( "h:i:s" , time() ));