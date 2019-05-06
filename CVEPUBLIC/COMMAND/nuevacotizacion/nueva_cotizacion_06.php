<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);  

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
$fechi = $_REQUEST['validdesde'];
$fchdp = $_REQUEST['fchp'];
$fchdr = $_REQUEST['fchpr'];

//añadido por J.G 30-01-2019
$margenOrden_ent = $_REQUEST['margen_gen'];

//echo "Margen pagina Pagina 6 rut:".$margenOrden_ent."<br>";
//file_put_contents("margen06.txt", $margenOrden_ent);


//$fechaent=general::formato_fecha_FORM2DB($_REQUEST['validdesde']);
$fechaent=general::formato_fecha_FORM2DB($_REQUEST['fchp']);

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

$ListEnc = new connlist;
$ListDet = new connlist;
$ListDir = new connlist;
$Registro = new dtocotizacion;
$Registro->id_cotizacion   =  $_REQUEST['id_cotizacion'];
$Registro->prorrateoflete =1;   
$ListEnc->addlast($Registro);
bizcve::getcotizacion($ListEnc,$ListDet);
////////////info cliente para el cobro de impuestos/////////////
/*$Listclien = new connlist;
$Registroclien = new dtoinfocliente;
$Registroclien->rut  = $rut;
$Listclien->addlast($Registroclien);
bizcve::getCliente($Listclien);
$Listclien->gofirst();
general::alert('rete ica'.$Listclien->getelem()->rete_ica.'rete renta'.$Listclien->getelem()->rete_renta);
*/
$Listclien = new connlist;
$Registroclien = new dtodetcotizacion;
$Registroclien->id_cotizacion = $_REQUEST['id_cotizacion'];
$Listclien->addlast($Registroclien);
bizcve::getdetcotizacionsumimp($Listclien);
$Listclien->gofirst();
//general::alert('rete ica'.$Listclien->getelem()->rete_ica.'rete renta'.$Listclien->getelem()->rete_renta);
/*Costo de Cotizacion Actual*/
$costocoti = $ListEnc->getelem()->valortotal;
/*Fin Costo de Cotizacion Actual*/

/* FIN OBTENEMOS DATOS DE LA COTIZACION */

/* OBTENEMOS DATOS DEL CLIENTE */
if($ListEnc->getelem()->id_dirdespacho == 0){
 /*Datos de Direccion del Cliente*/
 $Listc = new connlist;
 $Registro = new dtoinfocliente;
 $Registro->rut = $rut;
      //general::writelog('rut'.$rut);
 $Listc->addlast($Registro);

 bizcve::getCliente($Listc);
 $Listc->gofirst();
 $dirc=$Listc->getelem()->direccion;
 $Listlocalizacion  = new connlist;
 $registrolocalizacion = new dtolocalizacion;
 $registrolocalizacion->id_localizacion = $Listc->getelem()->id_comuna;
      //general::writelog('localizacion'.$Listc->getelem()->id_comuna);
 $Listlocalizacion->addlast($registrolocalizacion);
 //  file_put_contents('archivoListlocalizacion.txt', $Listlocalizacion);
 bizcve::getlocalizacion($Listlocalizacion);
//file_put_contents('archivoListlocalizacionArray.txt', print_r($Listlocalizacion,true));

  //file_put_contents('archivoListlocalizacion01.txt',$Listc->getelem()->id_comuna);

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
  //file_put_contents('archivoListlocalizacion.txt', $Listlocalizacion);
  bizcve::getlocalizacion($Listlocalizacion);
  $Listlocalizacion->gofirst();
  //file_put_contents('archivoListlocalizacion01.txt', $Listlocalizacion->gofirst());
  
}  /*Fin Datos de Direccion del Cliente*/
/* FIN OBTENEMOS DATOS DEL CLIENTE */

/* CONSTRUCCION DTO DE FLETE, VALIDACION */
bizcve::getDatosFlete($Listf = new connlist(new dtoflete(array('rut'=>$rut,
  'ciudad'=>$Listlocalizacion->getelem()->ciudad,
  'comuna'=>$Listlocalizacion->getelem()->barrio,
  'departamento'=>$Listlocalizacion->getelem()->departamento,
  'fechad'=>$fechaent,
  'codlocalcsum'=>$ListEnc->getelem()->codlocalcsum,
  'codlocalventa'=>$ListEnc->getelem()->codlocalventa,
  'dirdesp'=>$dirc
))));
$Listf->gofirst();
$oecruzada = $Listf->getelem()->id_ordenent; 

bizcve::getlocales($Listl = new connlist(new dtolocal(array('cod_local'=>$ListEnc->getelem()->codlocalcsum))));                                                
$Listl->gofirst();

/*CALCULO DE LOCALIZACION PARA CENTRO SUMINISTRO*/
$Listlocal  = new connlist;
$registrolocal = new dtolocalizacion;
$registrolocal->id_localizacion = $Listl->getelem()->id_localizacion;
   //general::writelog('local2'.$Listl->getelem()->id_localizacion);   
$Listlocal->addlast($registrolocal);
bizcve::getlocalizacion($Listlocal);
$Listlocal->gofirst();

/* FIN CALCULO DE LOCALIZACION PARA CENTRO SUMINISTRO*/


if(!$Listf->isvoid()){
 $ListDet->gofirst();
   //general::writeevent('peso'.$ListDet->getelem()->peso.' cantidad'.$ListDet->getelem()->cantidad);
 do{
  $tipoent = $ListDet->getelem()->id_tipoentrega;
  if($tipoent == 2){
    $sumapeso += $ListDet->getelem()->peso * $ListDet->getelem()->cantidad;
  }  
}while($ListDet->gonext());

$tipoentf = 2;


// $xml = "<despacho>
// <direccion>$dirc</direccion>
// <idDepartamento>".$Listlocalizacion->getelem()->id_departamento."</idDepartamento>
// <idMunicipio>".$Listlocalizacion->getelem()->id_provincia."</idMunicipio>
// <idCentroPoblado>".$Listlocalizacion->getelem()->id_ciudad."</idCentroPoblado>
// <idLocalidad>".$Listlocalizacion->getelem()->id_localidad."</idLocalidad>
// <idBarrio>".$Listlocalizacion->getelem()->id_barrio."</idBarrio>
// </despacho>
// <centroSuministro>
// <idLocal>".$Listl->getelem()->cod_local_pos."</idLocal>
// <idDepartamento>".$Listlocal->getelem()->id_departamento."</idDepartamento>
// <idMunicipio>".$Listlocal->getelem()->id_provincia."</idMunicipio>
// <idCentroPoblado>".$Listlocal->getelem()->id_ciudad."</idCentroPoblado>
// <idLocalidad>".$Listlocal->getelem()->id_localidad."</idLocalidad>
// <idBarrio>".$Listlocal->getelem()->id_barrio."</idBarrio>
// </centroSuministro>
// <entregaProductos>
// <lstTipoDespacho>
// <codigoTipo>$tipoentf</codigoTipo>
// <peso>$sumapeso</peso>
// </lstTipoDespacho>
// </entregaProductos>
// <codEmpresaTransportadora>0</codEmpresaTransportadora>";


//Agregado por J.G el 15/04/2019
// file_put_contents("aListlocalizacionID.txt", $Listlocalizacion->getelem()->id_localizacion);
$data_flete = bizcve::getDataFlete($Listlocalizacion->getelem()->id_localizacion,$Listl->getelem()->cod_local_pos,$tipoentf);



$i= 0;
$service = new Fletes;
   //general::writeevent("suma peso : ".$sumapeso);
general::writeevent("Mensaje de Envio WS Fletes : ".$data_flete);
//$response = $service->calcular($xml);
if ($data_flete) {
  general::writeevent("Response WS Fletes : ".$data_flete);
  $count = count($data_flete);
  general::writeevent("Contador1 : ".$count);
  if($count > 2){
         //general::writelog("entro 1");
      $tipoflete = $data_flete['tipoflete'];
      $tipodesp  = $data_flete['tipodesp'];
      $tipoenv   = $data_flete['tipoenv'];
      $valorflet = $data_flete['valorflet'];
      $cantidad  = $data_flete['cantidad'];
      $codsap    = $data_flete['codsap'];
      $zona      = $data_flete['zona'];
 }else{
   do{
    if($Listf->getelem()->cod_tipo == 'SV'){
     
     $varsv = 1;
   }
   
 }while($Listf->gonext());
 
 if($varsv == 1){
  
    $tipoflete2 = $data_flete['tipoflete'];
    $tipodesp2  = $data_flete['tipodesp'];
    $tipoenv2   = $data_flete['tipoenv'];
    $valorflet2 = $data_flete['valorflet'];
    $cantidad2  = $data_flete['cantidad'];
    $codsap2    = $data_flete['codsap'];
    $zona       = $data_flete['zona'];




  
 //  $msg2 = $response['exception']['state'];
 //  $msg = $response['exception']['message'];
  
 //  if($msg2 != ''){
   
 //   general::confirmf(''.$msg.' \n¿Desea Ajustar Flete Manualmente?',true,false,$idcotizacion,$margenOrden_ent);
   
 // }
 
 bizcve::getproductof($Listp2 = new connlist(new dtoproducto(array('sap'=>$codsap2))));
 $Listp2->gofirst();
 
 /*FIN EXTRACCION DE DETALLE DEL PRODUCTO*/
 
 /*INSERCION DE FLETE A LA COTIZACION*/
 $valorflett2 = $valorflet2 * $cantidad2;
 $costocotit2 = $costocoti + $valorflett2; 
 $Daoenc2 = new daocotizacion;
 general::writelog("entro 1");
 $Daoenc2->saveenccotizacionf($ListDetf = new connlist(new dtocotizacion(array(   'id_cotizacion'=>$idcotizacion,
   'valortotal'=>$costocotit2,
   'zona'=>$zona
 ))));
 $Dao2 = new daocotizacion;                                      
 $Dao2->savedetcotizacion($ListEnc, $ListDetf2 = new connlist(new dtodetcotizacion(array('id_cotizacion'=>$idcotizacion,
   'codprod'=>$codsap2,
   'descripcion'=>$Listp2->getelem()->descripcion,
   'barra'=>$Listp2->getelem()->barra,
   'cantidad'=>$cantidad2,
   'nomprov'=>$Listp2->getelem()->nomprov,
   'unimed'=>$Listp2->getelem()->unidmed,
   'codtipo'=>$Listp2->getelem()->prod_tipo,
   'codsubtipo'=>$Listp2->getelem()->prod_subtipo,
   'instalacion'=>'',
   'pventaneto'=>$valorflet2/*$Listp2->getelem()->pventa*/,
   'id_tiporetiro'=>'1',
   'id_tipoentrega'=>'2',
   'totallinea'=>($valorflet2 * $cantidad2),
   'pcosto'=>$valorflet2,
   'cot_iva'=>$Listp2->getelem()->ivap,
   'rete_ica'=>($Listclien->getelem()->rete_ica==0?'0':$Listp2->getelem()->ica),
   'rete_renta'=>($Listclien->getelem()->rete_renta==0?'0':$Listp2->getelem()->renta)
 ))));
 
// echo "<script type='text/javascript'>";
//   echo "alert(1)";
//  echo "</script>";

 echo "<script type='text/javascript'>";
 echo " window.open('nueva_cotizacion_05.php?popup=1&aci=1&fchr=$fchdr&fch=$fchdp&id_cotizacion=$idcotizacion&oe=$oecruzada&margenOrden_ent=$margenOrden_ent','','top=1, left=100 ,width=800,height=810');";
 echo " window.close();"; 
 echo "</script>";

 
}else{
 // general::writelog("entro 3");
      $tipoflete1 = $data_flete['tipoflete'];
      $tipodesp1  = $data_flete['tipodesp'];
      $tipoenv1   = $data_flete['tipoenv'];
      $valorflet1 = $data_flete['valorflet'];
      $cantidad1  = $data_flete['cantidad'];
      $codsap1    = $data_flete['codsap'];
      $zona      = $data_flete['zona'];


 //  $msg2 = $response['exception']['state'];
 //  $msg = $response['exception']['message'];
  
 //  if($msg2 != ''){
   
 //   general::confirmf(''.$msg.' \n¿Desea Ajustar Flete Manualmente?',true,false,$idcotizacion,$margenOrden_ent);
   
 // }
 
 bizcve::getproductof($Listp1 = new connlist(new dtoproducto(array('sap'=>$codsap1))));
 $Listp1->gofirst();
 
 /*FIN EXTRACCION DE DETALLE DEL PRODUCTO*/
 
 /*INSERCION DE FLETE A LA COTIZACION*/
 $valorflett1 = $valorflet1 * $cantidad1;
 $costocotit1 = $costocoti + $valorflett1; 
 $Daoenc1 = new daocotizacion;

 $Daoenc1->saveenccotizacionf($ListDetf = new connlist(new dtocotizacion(array('id_cotizacion'=>$idcotizacion,
   'valortotal'=>$costocotit1,
   'zona'=>$zona
 ))));
 $Dao1 = new daocotizacion;                                      
 $Dao1->savedetcotizacion($ListEnc, $ListDetf1 = new connlist(new dtodetcotizacion(array('id_cotizacion'=>$idcotizacion,
  'codprod'=>$codsap1,
  'descripcion'=>$Listp1->getelem()->descripcion,
  'barra'=>$Listp1->getelem()->barra,
  'cantidad'=>$cantidad1,
  'nomprov'=>$Listp1->getelem()->nomprov,
  'unimed'=>$Listp1->getelem()->unidmed,
  'codtipo'=>$Listp1->getelem()->prod_tipo,
  'codsubtipo'=>$Listp1->getelem()->prod_subtipo,
  'instalacion'=>'',
  'pventaneto'=>$valorflet1/*$Listp1->getelem()->pventa*/,
  'id_tiporetiro'=>'1',
  'id_tipoentrega'=>'2',
  'totallinea'=>($valorflet1 * $cantidad1),
  'pcosto'=>$valorflet1,
  'cot_iva'=>$Listp1->getelem()->ivap,
  'rete_ica'=>($Listclien->getelem()->rete_ica==0?'0':$Listp1->getelem()->ica),
  'rete_renta'=>($Listclien->getelem()->rete_renta==0?'0':$Listp1->getelem()->renta)
))));
 
 
    $tipoflete2 = $data_flete['tipoflete'];
    $tipodesp2  = $data_flete['tipodesp'];
    $tipoenv2   = $data_flete['tipoenv'];
    $valorflet2 = $data_flete['valorflet'];
    $cantidad2  = $data_flete['cantidad'];
    $codsap2    = $data_flete['codsap'];
 
 bizcve::getproductof($Listp2 = new connlist(new dtoproducto(array('sap'=>$codsap2))));
 $Listp2->gofirst();
 
 bizcve::getcotizacion($ListEnc2 = new connlist(new dtocotizacion(array('id_cotizacion'=>$idcotizacion))), $ListDet2 = new connlist);
 $ListEnc2->gofirst();

 /*Costo de Cotizacion Actual*/
 $costocoti2 = $ListEnc2->getelem()->valortotal;
 /*Fin Costo de Cotizacion Actual*/
 
 
 /*FIN EXTRACCION DE DETALLE DEL PRODUCTO*/
 
 /*INSERCION DE FLETE A LA COTIZACION*/
 $valorflett2 = $valorflet2 * $cantidad2;
 $costocotit2 = $costocoti2 + $valorflett2; 
 $Daoenc2 = new daocotizacion;
 general::writelog("entro 3");
 $Daoenc2->saveenccotizacionf($Listetf2 = new connlist(new dtocotizacion(array('id_cotizacion'=>$idcotizacion,
  'valortotal'=>$costocotit2,
  'zona'=>$zona
))));
 $Dao2 = new daocotizacion;                                      
 $Dao2->savedetcotizacion($ListEnc, $ListDetf2 = new connlist(new dtodetcotizacion(array('id_cotizacion'=>$idcotizacion,
  'codprod'=>$codsap2,
  'descripcion'=>$Listp2->getelem()->descripcion,
  'barra'=>$Listp2->getelem()->barra,
  'cantidad'=>$cantidad2,
  'nomprov'=>$Listp2->getelem()->nomprov,
  'unimed'=>$Listp2->getelem()->unidmed,
  'codtipo'=>$Listp2->getelem()->prod_tipo,
  'codsubtipo'=>$Listp2->getelem()->prod_subtipo,
  'instalacion'=>'',
  'pventaneto'=>$valorflet2,
  'id_tiporetiro'=>'1',
  'id_tipoentrega'=>'2',
  'totallinea'=>($valorflet2 * $cantidad2),
  'pcosto'=>$valorflet2,
  'cot_iva'=>$Listp2->getelem()->ivap,
  'rete_ica'=>($Listclien->getelem()->rete_ica==0?'0':$Listp2->getelem()->ica),
  'rete_renta'=>($Listclien->getelem()->rete_renta==0?'0':$Listp2->getelem()->renta)
))));
 

 echo "<script type='text/javascript'>";
 echo " window.open('nueva_cotizacion_05.php?popup=1&aci=1&fchr=$fchdr&fch=$fchdp&id_cotizacion=$idcotizacion&margenOrden_ent=$margenOrden_ent','','top=1, left=100 ,width=800,height=810');";
 echo " window.close();"; 
 echo "</script>";
 


}

}

// $msg2 = $response['data']['exception']['state'];
// $msg = $response['data']['exception']['message'];

// if($msg2 != ''){
 
//  general::confirmf(''.$msg.' \n¿Desea Ajustar Flete Manualmente?',true,false,$idcotizacion,$margenOrden_ent);
 
 
// }


/* FIN EXTRACCION DE DATOS RESPUESTA WS */

/*EXTRACCION DE DETALLE DEL PRODUCTO*/
bizcve::getproductof($Listp = new connlist(new dtoproducto(array('sap'=>$codsap))));
$Listp->gofirst();
/*FIN EXTRACCION DE DETALLE DEL PRODUCTO*/
/*INSERCION DE FLETE A LA COTIZACION*/
$valorflett = $valorflet * $cantidad;
$costocotit3 = $costocoti + $valorflett;
general::writelog("entro 4");
general::writelog('estes el valor1'.$costocoti);
general::writelog('estes el valor2'.$valorflet); 
$Daoenc3 = new daocotizacion;
$Daoenc3->saveenccotizacionf($Listetf3 = new connlist(new dtocotizacion(array('   id_cotizacion'=>$idcotizacion,
  'valortotal'=>$costocotit3,
  'zona'=>$zona
))));
$Dao3 = new daocotizacion;
$Dao3->savedetcotizacion($ListEnc, $ListDetf = new connlist(new dtodetcotizacion(array('id_cotizacion'=>$idcotizacion,
 'codprod'=>$codsap,
 'descripcion'=>$Listp->getelem()->descripcionc,
 'unimed'=>$Listp->getelem()->unidmed,
 'cantidad'=>$cantidad,
 'barra'=>$Listp->getelem()->barra,
 'nomprov'=>$Listp->getelem()->nomprov,
 'codtipo'=>$Listp->getelem()->prod_tipo,
 'codsubtipo'=>$Listp->getelem()->prod_subtipo,
 'instalacion'=>'',
 'pventaneto'=>$valorflet/*$Listp->getelem()->pventa*/,
 'id_tiporetiro'=>'1',
 'id_tipoentrega'=>'2',
 'totallinea'=>($valorflet * $cantidad),
 'pcosto'=>$valorflet,
 'cot_iva'=>$Listp->getelem()->ivap,
 'rete_ica'=>($Listclien->getelem()->rete_ica==0?'0':$Listp->getelem()->ica),
 'rete_renta'=>($Listclien->getelem()->rete_renta==0?'0':$Listp->getelem()->renta)
))));



echo "<script type='text/javascript'>";
echo " window.open('nueva_cotizacion_05.php?popup=1&aci=1&fchr=$fchdr&fch=$fchdp&id_cotizacion=$idcotizacion&margenOrden_ent=$margenOrden_ent','','top=1, left=100 ,width=800,height=810');";
echo " window.close();"; 
echo "</script>"; 


}
else{
  general::writeevent("Response WS Fletes : " . $response);
  general::alert("Problemas de comunicaciónxxxJ con el Servicio Web");
  general::writelog("Web Service Fuera de Serivicio");
}                                                              


///Fin de validacion coti cruzadas
}else{
  /*CALCULA EL TOTAL DE LOS PESOS EN COTI */
  $ListDet->gofirst();
   //general::writeevent('peso'.$ListDet->getelem()->peso.' cantidad'.$ListDet->getelem()->cantidad);
  do{
   $tipoent = $ListDet->getelem()->id_tipoentrega;
   if($tipoent == 2){
     
    $sumapeso += $ListDet->getelem()->peso * $ListDet->getelem()->cantidad;
  }  
}while($ListDet->gonext());

/* FIN CALCULA EL TOTAL DE LOS PESOS EN COTI */

$tipoentf = 2;

     $Listlocalizacion->gofirst();
    //  file_put_contents('localizaciondeptoSub.txt',$Listlocalizacion);

//AGREGADO POR J.G 11-03-2019, ya que los valores provincia, municipio,etc llegaban vacios

    ((strlen($Listc->getelem()->id_comuna)<14)?$localizacioncli='0'.$Listc->getelem()->id_comuna : $localizacioncli=$Listc->getelem()->id_comuna);

    $localizaciondepto=substr($localizacioncli, 0, -12);
   
    $localizacionprovin=substr($localizacioncli, 2, -9);
    $localizacionciudad=substr($localizacioncli, 5, -6);
    $localizacionlocalidad=substr($localizacioncli, 8, -3);
    $localizacionbarrio=substr($localizacioncli, 11);
  
   

 
// $xml = "<despacho>
// <direccion>$dirc</direccion>
// <idDepartamento>".$Listlocalizacion->getelem()->id_departamento."</idDepartamento>
// <idMunicipio>".$Listlocalizacion->getelem()->id_provincia."</idMunicipio>
// <idCentroPoblado>".$Listlocalizacion->getelem()->id_ciudad."</idCentroPoblado>
// <idLocalidad>".$Listlocalizacion->getelem()->id_localidad."</idLocalidad>
// <idBarrio>".$Listlocalizacion->getelem()->id_barrio."</idBarrio>
// </despacho>
// <centroSuministro>
// <idLocal>".$Listl->getelem()->cod_local_pos."</idLocal>
// <idDepartamento>".$localizaciondepto."</idDepartamento>
// <idMunicipio>".$localizacionprovin."</idMunicipio>
// <idCentroPoblado>". $localizacionciudad."</idCentroPoblado>
// <idLocalidad>".$localizacionlocalidad."</idLocalidad>
// <idBarrio>". $localizacionbarrio."</idBarrio>
// </centroSuministro>
// <entregaProductos>
// <lstTipoDespacho>
// <codigoTipo>$tipoentf</codigoTipo>
// <peso>$sumapeso</peso>
// </lstTipoDespacho>
// </entregaProductos>
// <codEmpresaTransportadora>0</codEmpresaTransportadora>";

// file_put_contents("xmlmanual.txt", print_r($xml,true));

$data_flete = bizcve::getDataFlete($localizacioncli,$Listl->getelem()->cod_local_pos,$tipoentf);
file_put_contents('data_flete.txt', print_r($data_flete, true));




$i= 0;
$service = new Fletes;
$sumapeso='A';
      //general::writeevent("suma peso ".$sumapeso);
general::writeevent("Mensaje de Envio Calculo de Fletes : ".$data_flete);

//$response = $service->calcular($xml);

// file_put_contents("responsemanual.txt", print_r($response,true));

if ($data_flete) {
  // print_r ($response);
  general::writeevent("Response Funcion Fletes : ".$data_flete);
  $count = count($data_flete);
      //general::writeevent("Contador2 : ".$count);
  if($count > 2){
    $tipoflete = $data_flete['tipoflete'];
    $tipodesp  = $data_flete['tipodesp'];
    $tipoenv   = $data_flete['tipoenv'];
    $valorflet = $data_flete['valorflet'];
    $cantidad  = $data_flete['cantidad'];
    $codsap    = $data_flete['codsap'];
    $zona      = $data_flete['zona'];
    $band = 0;
 }else{
    $tipoflete1 = $data_flete['tipoflete'];
    $tipodesp1  = $data_flete['tipodesp'];
    $tipoenv1   = $data_flete['tipoenv'];
    $valorflet1 = $data_flete['valorflet'];
    $cantidad1  = $data_flete['cantidad'];
    $codsap1    = $data_flete['codsap'];
    $zona       = $data_flete['data']['zone'];

  
  bizcve::getproductof($Listp1 = new connlist(new dtoproducto(array('sap'=>$codsap1))));
  $Listp1->gofirst();
  
  /*FIN EXTRACCION DE DETALLE DEL PRODUCTO*/
  
  /*INSERCION DE FLETE A LA COTIZACION*/
  $valorflett1 = $valorflet1 * $cantidad1;
  $costocotit1 = $costocoti + $valorflett1; 
         //general::writelog("entro 5");
         //general::writelog('costo coti5'.$costocoti);
         //general::writelog('costo flete5'.$valorflet1);
         //general::writelog('costo total5'.$costocotit1);
  $Daoenc1 = new daocotizacion;
  $Daoenc1->saveenccotizacionf($ListDetf = new connlist(new dtocotizacion(array('id_cotizacion'=>$idcotizacion,
    'valortotal'=>$costocotit1,
    'zona'=>$zona
  ))));
  $Dao1 = new daocotizacion;                                      
  $Dao1->savedetcotizacion($ListEnc, $ListDetf1 = new connlist(new dtodetcotizacion(array('id_cotizacion'=>$idcotizacion,
    'codprod'=>$codsap1,
    'descripcion'=>$Listp1->getelem()->descripcion,
    'barra'=>$Listp1->getelem()->barra,
    'cantidad'=>$cantidad1,
    'nomprov'=>$Listp1->getelem()->nomprov,
    'unimed'=>$Listp1->getelem()->unidmed,
    'codtipo'=>$Listp1->getelem()->prod_tipo,
    'codsubtipo'=>$Listp1->getelem()->prod_subtipo,
    'instalacion'=>'',
    'pventaneto'=>$valorflet1/*$Listp1->getelem()->pventa*/,
    'id_tiporetiro'=>'1',
    'id_tipoentrega'=>'2',
    'totallinea'=>($valorflet1 * $cantidad1),
    'pcosto'=>$valorflet1,
    'cot_iva'=>$Listp1->getelem()->ivap,
    'rete_ica'=>($Listclien->getelem()->rete_ica==0?'0':$Listp1->getelem()->ica),
    'rete_renta'=>($Listclien->getelem()->rete_renta==0?'0':$Listp1->getelem()->renta)
  ))));
  

    $tipoflete2 = $data_flete['tipoflete'];
    $tipodesp2  = $data_flete['tipodesp'];
    $tipoenv2   = $data_flete['tipoenv'];
    $valorflet2 = $data_flete['valorflet'];
    $cantidad2  = $data_flete['cantidad'];
    $codsap2    = $data_flete['codsap'];
  
  bizcve::getproductof($Listp2 = new connlist(new dtoproducto(array('sap'=>$codsap2))));
  $Listp2->gofirst();
  
  bizcve::getcotizacion($ListEnc2 = new connlist(new dtocotizacion(array('id_cotizacion'=>$idcotizacion))), $ListDet2 = new connlist);
  $ListEnc2->gofirst();

  /*Costo de Cotizacion Actual*/
  $costocoti2 = $ListEnc2->getelem()->valortotal;
  /*Fin Costo de Cotizacion Actual*/
  

  /*FIN EXTRACCION DE DETALLE DEL PRODUCTO*/
  
  /*INSERCION DE FLETE A LA COTIZACION*/
  $valorflett2 = $valorflet2 * $cantidad2;
  $costocotit2 = $costocoti2 + $valorflett2;
  // general::writelog("entro 6");
  // general::writelog('costo coti6'.$costocoti2);
  // general::writelog('costo flete6'.$valorflet2);
  // general::writelog('costo total6'.$costocotit2); 
  $Daoenc2 = new daocotizacion;
  $Daoenc2->saveenccotizacionf($Listetf2 = new connlist(new dtocotizacion(array('id_cotizacion'=>$idcotizacion,
    'valortotal'=>$costocotit2,
    'zona'=>$zona
  ))));
  $Dao2 = new daocotizacion;                                      
  $Dao2->savedetcotizacion($ListEnc, $ListDetf2 = new connlist(new dtodetcotizacion(array('id_cotizacion'=>$idcotizacion,
    'codprod'=>$codsap2,
    'descripcion'=>$Listp2->getelem()->descripcion,
    'barra'=>$Listp2->getelem()->barra,
    'cantidad'=>$cantidad2,
    'nomprov'=>$Listp2->getelem()->nomprov,
    'unimed'=>$Listp2->getelem()->unidmed,
    'codtipo'=>$Listp2->getelem()->prod_tipo,
    'codsubtipo'=>$Listp2->getelem()->prod_subtipo,
    'instalacion'=>'',
    'pventaneto'=>$valorflet2/*$Listp2->getelem()->pventa*/,
    'id_tiporetiro'=>'1',
    'id_tipoentrega'=>'2',
    'totallinea'=>($valorflet2 * $cantidad2),
    'pcosto'=>$valorflet2,
    'cot_iva'=>$Listp2->getelem()->ivap,
    'rete_ica'=>($Listclien->getelem()->rete_ica==0?'0':$Listp2->getelem()->ica),
    'rete_renta'=>($Listclien->getelem()->rete_renta==0?'0':$Listp2->getelem()->renta)
  ))));
  $band = 1;    



  echo "<script type='text/javascript'>";
  echo " window.open('nueva_cotizacion_05.php?popup=1&aci=1&fchr=$fchdr&fch=$fchdp&id_cotizacion=$idcotizacion&margenOrden_ent=$margenOrden_ent','','top=1, left=100 ,width=800,height=810');";
  echo " window.close();"; 
  echo "</script>";

  
}

// $msg2 = $response['exception']['state'];
// $msg = $response['exception']['message'];

// if($msg2 != ''){
 
//  general::confirmf(''.$msg.' \n¿Desea Ajustar Flete Manualmente?',true,false,$idcotizacion,$margenOrden_ent);
 
 
// }     

echo $xml; 

echo "tipoflete",$tipoflete;

echo "tipodesp",$tipodesp; 

echo "tipoenvio",$tipoenv; 

echo "valor flete",$valorflet;   

echo "cantidad",$cantidad; 

echo "codsap",$codsap;  

echo "zona",$zona;   




/* FIN EXTRACCION DE DATOS RESPUESTA WS */
if($band == 0){
 /*EXTRACCION DE DETALLE DEL PRODUCTO*/
 bizcve::getproductof($Listp = new connlist(new dtoproducto(array('sap'=>$codsap))));
 $Listp->gofirst();
 
 echo"c",$idcotizacion;
 echo"s",$codsap;
 echo"d",$Listp->getelem()->descripcionc;
 echo"u",$Listp->getelem()->unidmed;
 echo"c",$cantidad;
 echo"f",$valorflet;
 /*FIN EXTRACCION DE DETALLE DEL PRODUCTO*/
 
 /*INSERCION DE FLETE A LA COTIZACION*/
 $valorflett = $valorflet * $cantidad;        
 $costocotit = $costocoti + $valorflett;
         //general::writelog("entro 7"); 
         //general::writelog('costo coti7'.$costocoti);
         //general::writelog('costo flete7'.$valorflet);
 $Daoenc = new daocotizacion;
 $Daoenc->saveenccotizacionf($Listetf = new connlist(new dtocotizacion(array('id_cotizacion'=>$idcotizacion,
   'valortotal'=>$costocotit,
   'zona'=>$zona,   
 ))));                                           
 
 $Dao = new daocotizacion;                                      
 $Dao->savedetcotizacion($ListEnc, $ListDetf = new connlist(new dtodetcotizacion(array('id_cotizacion'=>$idcotizacion,
  'codprod'=>$codsap,
  'descripcion'=>$Listp->getelem()->descripcion,
  'barra'=>$Listp->getelem()->barra,
  'cantidad'=>$cantidad,
  'nomprov'=>$Listp->getelem()->nomprov,
  'unimed'=>$Listp->getelem()->unidmed,
  'codtipo'=>$Listp->getelem()->prod_tipo,
  'codsubtipo'=>$Listp->getelem()->prod_subtipo,
  'instalacion'=>'',
  'pventaneto'=>$valorflet/*$Listp->getelem()->pventa*/,
  'id_tiporetiro'=>'1',
  'id_tipoentrega'=>'2',
  'totallinea'=>($valorflet * $cantidad),
  'pcosto'=>$valorflet,
  'cot_iva'=>$Listp->getelem()->ivap,
  'rete_ica'=>($Listclien->getelem()->rete_ica==0?'0':$Listp->getelem()->ica),
  'rete_renta'=>($Listclien->getelem()->rete_renta==0?'0':$Listp->getelem()->renta) 
))));


 
  echo "<script type='text/javascript'>";
 echo " window.open('nueva_cotizacion_05.php?popup=1&aci=1&fchr=$fchdr&fch=$fchdp&id_cotizacion=$idcotizacion&margenOrden_ent=$margenOrden_ent','','top=1, left=100 ,width=800,height=810');";
 echo " window.close();"; 
 echo "</script>";  
 
                                                                
 
 /*popUpWindowModal('nueva_cotizacion_05.php?popup=1&id_cotizacion='*/

 
 /* FIN INSERCION DE FLETE A LA COTIZACION*/
 
  }
}
else{
  general::writeevent("Response WS Fletes : " . $response);
  general::alert("Problemas de comunicación con el Servicio Web");
  general::writelog("Web Service Fuera de Serivicio");
  
  
}

}


$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>