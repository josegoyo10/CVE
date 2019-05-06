<?php
$pag_ini = '../monitororpick/monitor_orpick_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
$ListDoc = new connlist;
$mregistro= new dtodocumento;
$mregistro->id_documento = $_REQUEST['id_documento'];
$ListDoc->addlast($mregistro);
bizcve::marcatodosdocimpreso($ListDoc);

$tupla =$_REQUEST['id_documento'];
$contador = count(split(',',$tupla));
$tuparray=split(',',$tupla);
foreach($tuparray as $key=>$value){

$ListDetDoc2 = new connlist;
$ListDete  = new connlist;
$Registrodoc = new dtodocumento;
$Registrodoc->id_documento = $value; 
$ListDetDoc2->addlast($Registrodoc);
bizcve::getdocumento($ListDetDoc2, $ListDete);
$ListDetDoc2->gofirst();

$ListEnc  = new connlist;
$mRegis=new dtoencordenpicking;
$mRegis->id_ordenpicking =$ListDetDoc2->getelem()->numdocrefop;
$mRegis->id_estado ='PF';
$ListEnc->addlast($mRegis);
bizcve::putordenpicking($ListEnc,$ListDet);
}
if($contador >1){
$respuesta='con los numeros de documentos ';
}
else{
$respuesta='con el numero de documento';
}
echo 'las ordenenes de picking relacionadas '.$respuesta.''.$_REQUEST['id_documento'].' an cambiado a estado FINALIZADO';
?>