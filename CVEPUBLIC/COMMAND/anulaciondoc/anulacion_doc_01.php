<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../anulaciondoc/anulacion_doc.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
if ($_POST['accion'] == 'anu' && $_POST['ideli']) {

	if($_POST['accion2'] == 'anu_oe'){
	global $ses_usr_id;
	if(!bizcve::verificacionDePermisos($ses_usr_id,107, 'DELETE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }
		/*OBTENGO LA FCT O GDE PARA VALIDAR LA ANULACION DEL NEGOCIO*/
		$Listb  = new connlist;
		$mRegistrb = new dtodocumento;
		$mRegistrb->numorigen = $_REQUEST['numorigen'];
		$mRegistrb->sigtipodoc = 'FCT';
		$Listb->addlast($mRegistrb);
		bizcve::getdocumentonulo($Listb);
		$Listb->gofirst();
		//general::alert($Listb->getelem()->numdocumento);
		do{
			//$Listb->getelem()->numdocumento;
			if($Listb->getelem()->numdocumento!=$_REQUEST['ideli'] && $Listb->getelem()->estado =='FG'){
			$no_anular = 1;
			$folio = $Listb->getelem()->numdocumento;
			}
		}while($Listb->gonext());

		if($no_anular){
			general::alert('No es posible anular la orden de entrega, ya que existen mas Facturas asociadas en estado "Emitida". Primero anule todas las Facturas y luego la Orden de Entrega.');
		}else{
			$List    = new connlist;
			$ianular = new dtoencordenent;
			$ianular->id_ordenent	  =$_REQUEST['numorigen'];	
			$ianular->id_estado		  ='OG';
			$ianular->obsdesb 	  	  ='Rechazo';		
			$List->addlast($ianular);
			bizcve::anularoe($List);
			$List->gofirst();

			$Lista    = new connlist;
			$Listdet = new connlist;
			$ianulara = new dtoencordenent;
			$ianulara->id_ordenent	  =$_REQUEST['numorigen'];	
			$Lista->addlast($ianulara);
			bizcve::getordenent($Lista, $Listdet);
			$Lista->gofirst();
			general::inserta_tracking(null, $_REQUEST['numorigen'], null, null, "Se ha anulado la Orden de Entrega");
			general::alert("Se ha anulado la Orden de Entrega Nº ".$_REQUEST['numorigen']);	
			//Se reversan los cargos de productos sobre la NVE original
			bizcve::ActualizaCantNVEOE($Listdet, '-');
		}
	}

	$List = new connlist;
	$ieditar = new dtodocumento;
	$ieditar->numdocumento = $_REQUEST['ideli'];
	$ieditar->sigtipodoc = $_REQUEST['tipodoc'];

	$folio=$_REQUEST['ideli'];
	$List->addlast($ieditar);
	if (bizcve::anuladoc($List)){
		general::writeevent('El documento con el folio '.$folio.' ha sido anulado.');
		general::inserta_tracking(null, $_REQUEST['numorigen'], null, null, "Se ha anulado el Folio (".$_REQUEST['tipodoc']."): ".$folio.".");
		general::alertexit('El documento con el folio '.$folio.' ha sido anulado.');


	global $ses_usr_id;
    $usr_nombre =general::get_nombre_usr( $ses_usr_id );
        bizcve::setevento(29, 'Modulo Anulacion Documentos', $_SERVER['REMOTE_ADDR'], 'ABM OE',
                    'Se ha anulado '.$_REQUEST['tipodoc'].' con el N  '.$folio.'','','Documento ha sido anulado', $usr_nombre );
	}

}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "anulaciondoc/anulacion_doc_01.htm");

/*OBTENGO LA FCT O GDE*/
$Lista  = new connlist;
$mRegistro = new dtodocumento;
$mRegistro->numorigen = $_REQUEST['numorigen'];
$mRegistro->sigtipodoc = $_REQUEST['sigtipodoc'];
$Lista->addlast($mRegistro);
bizcve::getdocumentonulo($Lista);

//$MiTemplate->set_var('id_ordenpicking', $ListEnc->getelem()->id_ordenpicking);

/* OBTENEMOS DATOS DEL DETALLE DE Facturas */
$Lista->gofirst();
if($Lista->getelem()->sigtipodoc == 'FCT'){
	$fct = 1;
	$MiTemplate->set_var('nomtipodoc', 'Facturas (FCT)');
}else{
	$MiTemplate->set_var('nomtipodoc', 'Guias de despacho (GDE)');
}
if($_REQUEST['local']){
	if($_REQUEST['local'] != $Lista->getelem()->codlocalventa){
		if($Lista->getelem()->codlocalventa){
			if($fct == '1'){
				general::alertexit('La OE indicada no corresponde al local desde donde se intenta anular La Factura Folio: '.$Lista->getelem()->numdocumento.'. Segun registros de CVE esta Factura corresponde al Local: '.$Lista->getelem()->codlocalventa);	
			}else{
				general::alertexit('La OE indicada no corresponde al local desde donde se intenta anular La Guia de despacho Folio: '.$Lista->getelem()->numdocumento.'. Segun registros de CVE esta Guia de despacho corresponde al Local: '.$Lista->getelem()->codlocalventa);
			}
		}else{
			if($_REQUEST['sigtipodoc']== 'FCT'){
				general::alertexit('La OE ingresada no tiene Facturas impresas. Verifique que hayan sido emitidas correctamente.');
			}else{
				general::alertexit('La OE ingresada no tiene Guias de Despacho impresas. Verifique que hayan sido emitidas correctamente.');			
			}

		}
	}
}

$MiTemplate->set_block('main' , "documentos" , "BLO_documentos");
$contador = 1;
if ($Lista->numelem()) { 
       do{
					$id_documento = $Lista->getelem()->id_documento;
					/*OBTENGO LA GDE PARA VALIDAR ANULACION FCT*/
					$List1  = new connlist;
					$mRegistr1 = new dtodocumento;
					$mRegistr1->sigtipodoc = 'GDE';
					$mRegistr1->numdocref = $id_documento;
					$List1->addlast($mRegistr1);
					bizcve::getdocumentonulo($List1);
					//general::alert($List1->getelem()->id_documento);
					$List1->gofirst();
					do{
						if($List1->getelem()->numdocref && $List1->getelem()->estado =='GG'){
							$MiTemplate->set_var('folio_gde_asoc', $List1->getelem()->numdocumento);
							$folio_asoc = $List1->getelem()->numdocumento;
						}else{
							$MiTemplate->set_var('folio_gde_asoc', '0');
							$folio_asoc = '0';
						}
					}while($List1->gonext());
					
				  $MiTemplate->set_var('item', $contador);  
                  $MiTemplate->set_var('numorigen', $Lista->getelem()->numorigen);				  
                  $MiTemplate->set_var('numinterno', $Lista->getelem()->id_documento);
					if($Lista->getelem()->indmsgsap == 1){
						$enviado_sap = 1;
					}else{
						$enviado_sap = 0;
					}
				  $id_tipodocumento = $Lista->getelem()->id_tipodocumento;
                  $MiTemplate->set_var('numdocumento', $Lista->getelem()->numdocumento);
                  $MiTemplate->set_var('tipodoc', $Lista->getelem()->sigtipodoc);
				  if($Lista->getelem()->estado == 'FG'){
					  $MiTemplate->set_var('estado', 'FCT Emitida');
					/*OBTENGO LA FECHA DE ULTIMA MODIFICACION PARA VALIDAR HORA DE ANULACION QUE SE DESEA REALIZAR*/
					$List2  = new connlist;
					$mRegistr2 = new dtodocumento;
					$mRegistr2->fecmod = $Lista->getelem()->fechahora;
					$List2->addlast($mRegistr2);
					bizcve::gethoras_doc($List2);
					$List2->gofirst();
					//general::alert($List2->getelem()->timewarning);
					//general::writeevent($List2->getelem()->timewarning > '0'.HORAS_MAX.':0'.MINUTOS_MAX.':0'.SEGUNDOS_MAX);
					if($List2->getelem()->timewarning > '0'.HORAS_MAX.':0'.MINUTOS_MAX.':0'.SEGUNDOS_MAX){
						$MiTemplate->set_var('fondoregistro', 'fondowarning');
					}else{
						$MiTemplate->set_var('fondoregistro', 'fondoregistro');
					}
				  }elseif($Lista->getelem()->estado == 'FN'){
					  $MiTemplate->set_var('estado', 'FCT Nula');
				  }
				  if($Lista->getelem()->estado == 'GG'){
						$MiTemplate->set_var('estado', 'GDE Emitida');
						/*OBTENGO LA FECHA DE ULTIMA MODIFICACION PARA VALIDAR HORA DE ANULACION QUE SE DESEA REALIZAR*/
						$List2  = new connlist;
						$mRegistr2 = new dtodocumento;
						$mRegistr2->fecmod = $Lista->getelem()->fechahora;
						$List2->addlast($mRegistr2);
						bizcve::gethoras_doc($List2);
						$List2->gofirst();
						//general::alert($List2->getelem()->timewarning);
						//general::writeevent($List2->getelem()->timewarning > '0'.HORAS_MAX.':0'.MINUTOS_MAX.':0'.SEGUNDOS_MAX);
						if($List2->getelem()->timewarning > '0'.HORAS_MAX.':0'.MINUTOS_MAX.':0'.SEGUNDOS_MAX){
							$MiTemplate->set_var('fondoregistro', 'fondowarning');
						}else{
							$MiTemplate->set_var('fondoregistro', 'fondoregistro');
						}
				  }elseif($Lista->getelem()->estado == 'GN'){
					$MiTemplate->set_var('estado', 'GDE Nula');
				  }
                  $MiTemplate->set_var('pagina', $Lista->getelem()->pagina);
                  $MiTemplate->set_var('codlocalventa', $Lista->getelem()->codlocalventa);
                  $MiTemplate->set_var('fechadocumento', $Lista->getelem()->fechahora);
                  $rut = $Lista->getelem()->rutcliente;
                  $Listj = new connlist;
				  bizcve::gettipojur($rut,$Listj);
				  $Listj->gofirst();
                  $MiTemplate->set_var('rutcliente', (($Listj->getelem()->id_contribuyente == 2)?$Lista->getelem()->rutcliente.'-'.general::digiVer($Lista->getelem()->rutcliente):$Lista->getelem()->rutcliente));
                  $MiTemplate->set_var('razonsoc', $Lista->getelem()->razonsoc);
				  if($Lista->getelem()->numdocumento){
					  if($Lista->getelem()->estado == 'FG' || $Lista->getelem()->estado == 'GG'){
						$MiTemplate->set_var('acceliminar',"<a href=\"#\"><img src=\"../../IMAGES/publish_x.png\" alt=\"Anular Documento\" border=\"0\" id=\"".$Lista->getelem()->numdocumento."\" onClick=\"anulardoc(this, ".$id_tipodocumento.",".$folio_asoc.",".$enviado_sap.")\"></a>");
					  }else{
						  $MiTemplate->set_var('acceliminar', 'Documento Nulo');
					  }
				  }else{
						$MiTemplate->set_var('acceliminar', 'Documento no emitido.');
				  }
				  $contador++;
          	$MiTemplate->parse("BLO_documentos", "documentos", true);
	} while ($Lista->gonext());
}

/*OBTENGO LA GDE PARA VALIDAR ANULACION FCT*/
	$List1  = new connlist;
	$mRegistr1 = new dtodocumento;
	$mRegistr1->sigtipodoc = 'GDE';
	$mRegistr1->numdocref = $id_documento;
	$List1->addlast($mRegistr1);
	bizcve::getdocumentonulo($List1);
	$List1->gofirst();
		if($List1->getelem()->numdocref && $List1->getelem()->estado =='GG'){
			$MiTemplate->set_var('folio_gde', '1');
		}
/*FIN DESPLIEGUE*/

$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>
