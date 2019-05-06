<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
include_once( "ConvertCharset.class.php" );
///////////////////////// ZONA DE ACCIONES /////////////////////////
	$id_ordenent=$_REQUEST['oe'];	
	$documentos=split('-',$_REQUEST['documentos']);
   	for($i=0;$documentos[$i];$i++) {
   		$id_documento=$documentos[$i];
		bizcve::getdocumentoprn($Listdoc = new connlist(new dtodocumento(array('id_documento'=>$id_documento))));
        general::inserta_tracking(null, $id_ordenent, null, null, 'Se ha impreso Guia para la Orden de Entrega');

		$Listdoc-> gofirst();
		$stringdoc.=$Listdoc->getelem()->txtprn;
   	}
   	/*para la codificacion de los caracteres extraños*/
	$FromCharset = "iso-8859-1";
	$ToCharset   = "cp437";
	$Entities = 0;
	$archivo_gen =$stringdoc;
	$NewEncoding = new ConvertCharset;
	$NewArchivo_gen = $NewEncoding->Convert($archivo_gen, $FromCharset, $ToCharset, $Entities);
	$nombreArchivo='FCT'.$id_ordenent.'_'.DATE('Ymdhis').'.txt';   	
	if ($file = fopen(DIR_IMPRESION.$nombreArchivo, "a")) { 
		fputs ($file, $NewArchivo_gen);
		fclose($file); 
	}   	
  	
   	//Redireccionar al archivo
	header('Location: '.DIR_IMPRESION.$nombreArchivo);
?>