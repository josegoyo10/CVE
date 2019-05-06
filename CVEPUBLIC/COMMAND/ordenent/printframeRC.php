<?php


include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

$MiTemplate = new template;



$ListEnc  = new connlist;
$ListDet  = new connlist;	
$Registro = new dtoencordenent;
$mRegistro->id_ordenent=$_REQUEST['id_od'];
$ListEnc->addlast($mRegistro);
bizcve::getordenent($ListEnc, $ListDet);
$ListEnc->gofirst();  


 	$List1 = new connlist;
    $mRegistro1= new dtoinfocliente;
    $mRegistro1->rut = $ListEnc->getelem()->rutcliente;
//   var_dump($mRegistro1); 
//die();
    $List1->addlast($mRegistro1);
    bizcve::getCliente($List1);

    $Listlocalizacion  = new connlist;
   $registrolocalizacion = new dtolocalizacion;
   $registrolocalizacion->id_localizacion = $List1->getelem()->id_comuna; 

   $Listlocalizacion->addlast($registrolocalizacion);
   bizcve::getlocalizacion($Listlocalizacion);
   $Listlocalizacion->gofirst();
  

//  	 print("<pre>".htmlentities(print_r(  $List1, true))."</pre>");
//die();

// Agregamos el main
$MiTemplate->set_file("main", TEMPLATE . "ordenent/printRC.htm");


$MiTemplate->set_var("creacion",$ListEnc->getelem()->fechacompra);
$MiTemplate->set_var("retiro",$ListEnc->getelem()->fecha_retira_cliente);
$MiTemplate->set_var("id_os",$ListEnc->getelem()->id_ordenent);
$MiTemplate->set_var("localventa",$ListEnc->getelem()->nom_localventa);
 $MiTemplate->set_var("cliente", $List1->getelem()->razonsoc);     	
$MiTemplate->set_var("direccion",$List1->getelem()->direccion);
$MiTemplate->set_var("telefono",$ListEnc->getelem()->fonocontacto);
$MiTemplate->set_var("nit",$ListEnc->getelem()->rutcliente);
$MiTemplate->set_var("mail",$List1->getelem()->email);
$MiTemplate->set_var("ciudad",$Listlocalizacion->getelem()->ciudad);



$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////


?>