<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../anulaciondoc/anulacion_doc.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////
$documento=$_REQUEST['id_documento'];
bizcve::getdocumentoview($Listdoc = new connlist(new dtodocumento(array('id_documento'=>$documento,'prorrateoflete'=>$_REQUEST['flete']))));
$Listdoc->gofirst();
general::dump("<title>Documento $documento</title>");
general::dump("<h5>");
general::dump($Listdoc->getelem()->txtprn);
general::dump("</h5>");

?>