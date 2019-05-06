<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
////////////////////////////////////////////////////////////////////
$visibleIMP = new getidvisibleimpuestos("VISIBLE_IMPUESTOS");
$visible_fletes=$visibleIMP->FLETES;
$visible_renta=$visibleIMP->IMPUESTO_RENTA;
$visible_ica=$visibleIMP->IMPUESTO_ICA;
$visible_reteiva=$visibleIMP->IMPUESTO_RETEIVA;
$margen_value = ($_GET['margentotal'] == '' ? $_GET['margenOrden_ent'] : $_GET['margentotal']);
//$margen_value = ($_POST['margen_OE'] == '' ? $_GET['margenOrden_ent'] : $_POST['margen_OE']);
//$margen_OE = $_POST['margen_OE'];
if ($margen_value == '') {
    $margen_value = $_POST['margen_OE'];

} 



// file_put_contents("margenNuevoOE", $margen_value);

function calculos_oe($cadena_id_oe){

    $id_oeC=split(',',$cadena_id_oe);
    foreach($id_oeC as $key=>$value){
        
        $ListEnc  = new connlist;
        $ListDet  = new connlist;   
        $Registro = new dtoencordenent;
        $mRegistro->id_ordenent=$value;
        $ListEnc->addlast($mRegistro);
        bizcve::getordenent($ListEnc, $ListDet);
        $ListEnc->gofirst();
        
        $grupoimp='rete_renta';
        $Daoer = new daoordenent; 
        $Daoer->getdetalleimpuestoe($Listimpr = new connlist, $value,$grupoimp);
        $Listimpr->gofirst();
    //$totalica = 0;
        if(!$Listimpr->isvoid()){
            do{
                $totalrenta += $Listimpr->getelem()->sumiva;
                
            }while($Listimpr->gonext());
        }
        /*Fin Calculo de Impuestos rete_renta*/
        
        
        
        /*Calculo de Impuetos rete_ica*/
        $grupoimp='rete_ica';
        $Daoei = new daoordenent; 
        $Daoei->getdetalleimpuestoe($Listimpi = new connlist, $value,$grupoimp);
        $Listimpi->gofirst();
    //$totalica = 0;
        if(!$Listimpi->isvoid()){
            do{
                $totalica += $Listimpi->getelem()->sumiva;
                
            }while($Listimpi->gonext());
        }
        
        $grupoimp='iva';
        $Daoe = new daoordenent; 
        $Daoe->getdetalleimpuestoe($Listimp = new connlist, $value,$grupoimp);
        $Listimp->gofirst();
    //$totalica = 0;
        if(!$Listimp->isvoid()){
            do{
                $totaliva += $Listimp->getelem()->sumiva;
                
            }while($Listimp->gonext());
        }
        $riva = ($totaliva / 2);
        
        $ListDet->gofirst();
        if (!$ListDet->isvoid()) {
            do {
                $totallinea += $ListDet->getelem()->totallinea;                 
            }while($ListDet->gonext());
        }
        
        
        $ListEncCot = new connlist;
        $ListDetCot = new connlist;
        $RegistroEncCot = new dtocotizacion;
        $RegistroEncCot->id_cotizacion  =  $ListEnc->getelem()->id_cotizacion;   
        $ListEncCot->addlast($RegistroEncCot);
        bizcve::getcotizacion($ListEncCot, $ListDetCot);
        $ListEncCot->gofirst();
        $rete_iva2 = (($ListEncCot->getelem()->rete_iva > 0)? round($riva) : $riva = 0);
        
        
        $sumtotal = $totallinea - round($totalrenta) - $rete_iva2 - round($totalica);
        /*Actualizacion OE Total*/
        $dao = new daoordenent;
        $dao->updateoe($value,$sumtotal,"'".$rete_iva2."'","'".$totaliva."'");
        $riva=0;$rete_iva2=0;$totalrenta=0;$totalica=0;$totaliva=0;$totallinea=0;
        /*Fin Actualizacion OE Total*/
    }
    return true;
    
}

///////////////////////// ZONA DE ACCIONES /////////////////////////
if ($_POST['accion'] == 'genera' && $_POST['id_cotizacion']) {
    if(!bizcve::verificacionDePermisos($ses_usr_id,44, 'INSERT')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }
    //Armo la lista de la cotizacion
    /*$var1 = bizcve::getPagoOE($cadenv);
    general::alert(''.$var1.'');*/
    
  // echo "Margen Total:".$_REQUEST['margentotal']."<br>";
  // echo "Margen Total:".$margen_value."<br>";
    
  //  file_put_contents('margenTotal.txt',$margen_value);

   $valor_margen = $margen_value;

    $listanve = new connlist(new dtocotizacion(array('id_cotizacion'=>$_POST['id_cotizacion'],
        'id_dirdespacho'=>$_POST['id_dirdespacho'], 
        'nota'=>$_REQUEST['nota'],
        'barra'=>$_REQUEST['barra'], 
        'nomproveedor'=>$_REQUEST['nomproveedor'],   
        'rutproveedor'=>$_REQUEST['rutproveedor'],   
        'id_tipoventa'=>$_REQUEST['tipoventa'],  
        'condicion'=>(($_REQUEST['condpago'] == 1)?$_REQUEST['condpagot']:'Contado'), 
        'diascondicion'=>(($_REQUEST['condpago'] == 1)?$_REQUEST['condpagon']:'0'), 
        'id_tipopago'      =>$_REQUEST['condpago'],
        'observaciones_pos'=>$_REQUEST['observaciones_pos']

      ))); 
    //Armo la lista de los productos seleccionados
    $listaprod = new connlist;
    /*Captura e inserta fechas en OE*/
    $fecha_rc = (($_REQUEST['fecha_retira_cliente'] != 0)?general::formato_fecha_FORM2DB($_REQUEST['fecha_retira_cliente']):'0000-00-00');
    $fecha_ei = (($_REQUEST['fecha_entrega_inmediato']!= 0)?general::formato_fecha_FORM2DB($_REQUEST['fecha_entrega_inmediato']):'0000-00-00');
    $fecha_dp = (($_REQUEST['fecha_domicilio_programado']!= 0)?general::formato_fecha_FORM2DB($_REQUEST['fecha_domicilio_programado']):'0000-00-00');
    
    /*Fin Captura e inserta fechas en OE*/ 
    foreach ($_POST['linea'] as $value){
        if (($_POST['cantact_'.$value]>0)&&($_POST['marcaflete_'.$value]>0)){
            $listaprod->addlast(new dtodetcotizacion(array('id_linea' => $value ,'cantidad' => $_POST['cantact_'.$value],'marcaflete' => $_POST['marcaflete_'.$value] )));
        }
        if(($_POST['cantact_'.$value]>0)&&($_POST['marcaflete_'.$value]==0)){
            $listaprod->addlast(new dtodetcotizacion(array('id_linea' => $value ,'cantidad' => $_POST['cantact_'.$value])));            
        }
    }

    // file_put_contents("bizcvevalorMargen.txt", $valor_margen);
    if (bizcve::generaordenent($listanve, $listaprod, $listaoe =  new connlist, $fecha_rc, $fecha_ei, $fecha_dp, $valor_margen)) 

      {
        if ($listaoe)
            $contadorposi=1;
        $listaoe->gofirst();
        while ( $contadorposi <= $listaoe->numelem()) {
            $cadena_id_ordenent=$listaoe->getelem()->id_ordenent.",".$cadena_id_ordenent;
            $listaoe->gonext();
            $contadorposi++;

            global $ses_usr_id;
            $nombreSession = general::get_nombre_usr($ses_usr_id);

            bizcve::setevento(19, 'Modulo Cotizaciones', $_SERVER['REMOTE_ADDR'], 'ABM cotizacion',
                'Se ha generado la Orden de Entrega '.$listaoe->getelem()->id_ordenent.'','','Orden de entrega generada', $nombreSession);

        }
        if($listaoe->numelem() > 1?general::returnvalue('monitor'):general::returnvalue($listaoe->getelem()->id_ordenent));
        /*CAMBIAR DE ESTADO COTIZACION*/
        $Listc = new connlist;
        $Registro = new dtocotizacion;
        $Registro->id_cotizacion = $_POST['id_cotizacion'];
        $Registro->id_estado='CF';
        $Listc->addlast($Registro);
        bizcve::cambioestadocotizacion($Listc);
        general::writeevent('La cotizaciÛn  '.$_POST['id_cotizacion'].'cambio a estado CotizaciÛn finalizada');
        /*FIN CAMBIAR DE ESTADO COTIZACION*/
        $cadena_id_ordenent=substr($cadena_id_ordenent, 0, -1);
        if(calculos_oe($cadena_id_ordenent) == true && bizcve::oe_divi_producospos($cadena_id_ordenent)== true)
        {
            general::alertexit('Se ha generado la Orden de Entrega ' . $cadena_id_ordenent);
        }
        else{
            general::writelog('no se realizaron los calculos correspondientes para la oe'.$cadena_id_ordenent);
        }   
    }
    else {
        general::alertexit('Problemas al generar la Orden de Entrega. Contactese con el Administrador del sistema');
    }
    exit();
}

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_var('error_app', $mensaje_error);
/**/
$MiTemplate->set_var("TITULO", TITULO);
/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "nuevacotizacion/nueva_cotizacion_05.htm");
/**/

$ajuste = $_REQUEST['aci'];
$nac = $_REQUEST['nac'];
$fch = $_REQUEST['fch'];
$fchr = $_REQUEST['fchr'];
$oecruzada = $_REQUEST['oe'];
$fechaent = general::formato_fecha_FORM2DB($_REQUEST['fechi']);

if (!$_REQUEST['id_cotizacion']) {
    general::alertexit('No viene id de cotizaciÛn. No puede generar OE');
    exit();
}


/* OBTENEMOS DATOS DE LA COTIZACION */
bizcve::getcotizacion($ListEnc = new connlist(new dtocotizacion(array('id_cotizacion'=>$_REQUEST['id_cotizacion']))), $ListDet = new connlist);
if (!$ListEnc->numelem()) {
    general::alertexit('No existe la cotizaciÛn. No puede generar OE');
    exit();
}
$ListEnc->gofirst();

//if ( $ListEnc->getelem()->codlocalcsum != $ses_usr_codlocal) 
//  general::alertexit("La Nota de Venta pertenece a un centro de suministro distinto al actual. No puede generar OE");

if (!$ListEnc->isvoid()) {
    $idcotizacion = $ListEnc->getelem()->id_cotizacion;
    $MiTemplate->set_var('id_cotizacion', $ListEnc->getelem()->id_cotizacion);
    $MiTemplate->set_var('nomestado', $ListEnc->getelem()->nomestado);
    $MiTemplate->set_var('nomtipoventa', $ListEnc->getelem()->nomtipoventa);    
    $rut=$ListEnc->getelem()->rutcliente;
    $MiTemplate->set_var('rutcliented',$rut);
    $codigovendedor=$ListEnc->getelem()->codigovendedor;
    $localcsum= $ListEnc->getelem()->codlocalcsum;
    $estado=$ListEnc->getelem()->id_estado;
    $id_tipoventa = $ListEnc->getelem()->id_tipoventa;
    $MiTemplate->set_var('nom_local', $ListEnc->getelem()->nom_local);      
    $MiTemplate->set_var('nota', $ListEnc->getelem()->nota);
    $MiTemplate->set_var('iva',$ListEnc->getelem()->iva);
    $MiTemplate->set_var('oecruzadas',$oecruzada);
    $MiTemplate->set_var('observaciones_pos', $ListEnc->getelem()->observaciones_pos);  
    $MiTemplate->set_var('margen_orden',  $margen_value);
    // file_put_contents('rutOE.txt',$ListEnc->getelem()->observaciones_pos);


    /*Sub total de OE*/
    
    /*Calculo de Impuestos por separado*/
    $grupoimp='cot_iva';
    $Daoc = new daocotizacion; 
    $Daoc->getdetalleimpuesto($Listimp = new connlist, $idcotizacion,$grupoimp);
    $Listimp->gofirst();
    //$totalica = 0;
    if(!$Listimp->isvoid()){
        do{
            $totaliva += $Listimp->getelem()->sumiva;
            
        }while($Listimp->gonext());
    }
    $riva = ($totaliva / 2);
    /*Fin Calculo de Impuestos por separado*/
    
    /*Calculo de Impuestos rete_renta*/
    $grupoimp='rete_renta';
    $Daoerc = new daocotizacion; 
    $Daoerc->getdetalleimpuesto($Listimpr = new connlist, $idcotizacion,$grupoimp);
    $Listimpr->gofirst();
    //$totalica = 0;
    if(!$Listimpr->isvoid()){
        do{
            $totalrenta += $Listimpr->getelem()->sumiva;
            
        }while($Listimpr->gonext());
    }
    /*Fin Calculo de Impuestos rete_renta*/
    
    /*Calculo de Impuetos rete_ica*/
    $grupoimp='rete_ica';
    $Daoeic = new daocotizacion; 
    $Daoeic->getdetalleimpuesto($Listimpi = new connlist, $idcotizacion,$grupoimp);
    $Listimpi->gofirst();
    //$totalica = 0;
    if(!$Listimpi->isvoid()){
        do{
            $totalica += $Listimpi->getelem()->sumiva;
            
        }while($Listimpi->gonext());
    }
    /*Fin calculo de Impuestos rete_ica*/
    
    $rete_renta = $totalrenta;
    $rete_iva = ($ListEnc->getelem()->rete_iva > 0?$riva:0);
    $rete_ica = $totalica;
    
    /*$valortotaliva = round($ListEnc->getelem()->cot_iva)+0;
    $valortotalrenta = round($ListEnc->getelem()->rete_renta)+0;
    $valortotalriva = round($ListEnc->getelem()->rete_iva)+0;
    $valortotalrica = round($ListEnc->getelem()->rete_ica)+0;
    $sumtotal    = round($valortotal - $valortotalrenta - $valortotalriva - $valortotalrica);*/
    /*Fin de Sub total oe*/ 
    $MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);    
    $MiTemplate->set_var('giro', $ListEnc->getelem()->giro);
    
    $obra=explode("||",$ListEnc->getelem()->direccion);
    $MiTemplate->set_var('direccion', $obra[0]);
    $MiTemplate ->set_var("titulo_nom_dir",($obra[1]!=''?'<tr><th align="left">Nombre Obra:</th>
        <td colspan=3>'.$obra[1].'</td></tr>':''));
    /*ID Direccion para Generar la OE*/
    $MiTemplate->set_var('idireccion', $ListEnc->getelem()->id_dirdespacho);
    /*ID Direccion para Generar la OE*/
    
    /*Insercion de Ciudad Comuna Departamento*/
    if($ListEnc->getelem()->id_dirdespacho == 0){
        /*Datos de Direccion del Cliente*/
        $Listc = new connlist;
        $Registro = new dtoinfocliente;
        $Registro->rut  = $rut;
        $Listc->addlast($Registro);

        bizcve::getCliente($Listc);
        $Listc->gofirst();
        $Listlocalizacion  = new connlist;
        $registrolocalizacion = new dtolocalizacion;
        $registrolocalizacion->id_localizacion = $Listc->getelem()->id_comuna;

        $Listlocalizacion->addlast($registrolocalizacion);
        bizcve::getlocalizacion($Listlocalizacion);
        $Listlocalizacion->gofirst();
        if (!$Listlocalizacion->isvoid()) {
            do {
                $MiTemplate->set_var('ciudad', $Listlocalizacion->getelem()->ciudad);
                $MiTemplate->set_var('comuna', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
                $MiTemplate->set_var('departamento', $Listlocalizacion->getelem()->departamento);
            } while ($Listlocalizacion->gonext());

        }
    }   /*Fin Datos de Direccion del Cliente*/
    else{
        
        $Listdirdes  = new connlist;
        $id_dirdes = new dtodireccion;
        $id_dirdes->id_direccion = $ListEnc->getelem()->id_dirdespacho;
        $Listdirdes->addlast($id_dirdes);
        bizcve::getdirdesp($Listdirdes);
        $Listdirdes->gofirst();
        
        $Listlocalizacion  = new connlist;
        $registrolocalizacion = new dtolocalizacion;
        $registrolocalizacion->id_localizacion = $Listdirdes->getelem()->id_comuna;

        $Listlocalizacion->addlast($registrolocalizacion);
        bizcve::getlocalizacion($Listlocalizacion);
        $Listlocalizacion->gofirst();
        if (!$Listlocalizacion->isvoid()) {
            do {
                $MiTemplate->set_var('ciudad', $Listlocalizacion->getelem()->ciudad);
                $MiTemplate->set_var('comuna', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
                $MiTemplate->set_var('departamento', $Listlocalizacion->getelem()->departamento);

            } while ($Listlocalizacion->gonext());

        }
    }
    /* FIN Insercion de Ciudad Comuna Departamento*/
    //$MiTemplate->set_var('nomcomuna', $ListEnc->getelem()->comuna);   
    $nvevalidhasta = $ListEnc->getelem()->nvevalidhasta;
    $MiTemplate->set_var("validdesde",date('d/m/Y'));
    //Para Flete
    $MiTemplate->set_var("validdes",$ListEnc->getelem()->validdesde);
}

/* OBTENEMOS DATOS DEL VENDEDOR */
bizcve::GetUsers($List = new connlist(new dtousuario(array('codigovendedor'=>$codigovendedor))));
$List->gofirst();
$MiTemplate->set_var('nombrevendedor', $List->getelem()->usr_nombres.' '.$List->getelem()->usr_apellidos);



// file_put_contents('idcotizacion05.txt',  $idcotizacion);

/***Obtener Datos de la observacion del POS*******/

$showObsPos = bizcve::showObservacionPos( $idcotizacion);
$MiTemplate->set_var('observaciones_pos', $showObsPos);



/* OBTENEMOS DATOS DEL CENTRO DE SUMINISTRO */
bizcve::getlocales($List = new connlist(new dtolocal(array('cod_local'=>$localcsum))));
$List->gofirst();
$MiTemplate->set_var('nom_local_csum', $List->getelem()->nom_local);        

/* OBTENEMOS EL CREDITO ONLINE DEL CLIENTE MEDIANTE EL WEBSERVICE */
if (!$credito = ConsultarClienteOnline($rut)) {
    $disponible = bizcve::getdisponible(new connlist(new dtoinfocliente(array('rut'=>$rut))));
}
else {
    $disponible = $credito['limite_disponible'];
}

$MiTemplate->set_var('disponible', $disponible);        
$MiTemplate->set_var('disponiblef', number_format($disponible));        

/* OBTENEMOS DATOS DEL DETALLE DE COTIZACION */
$ListDet->gofirst();
$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detallecotizacion");
if (!$ListDet->isvoid()) {
    $prodparagenerar = 0;
    $MiTemplate->set_var('val1','hidden');
    $MiTemplate->set_var('vala','hidden');
    $MiTemplate->set_var('vale','hidden');
    $MiTemplate->set_var('valc','hidden');
    $MiTemplate->set_var('vali1','0');
    $MiTemplate->set_var('val2','hidden');
    $MiTemplate->set_var('vali2','0');
    $MiTemplate->set_var('val3', 'hidden');
    $MiTemplate->set_var('vali3','0');
    $MiTemplate->set_var('val4','hidden');
    $MiTemplate->set_var('val5','hidden');
    $MiTemplate->set_var('val6','hidden');
    $MiTemplate->set_var('disabledd', '');
    $MiTemplate->set_var('fechaent', '');
    $MiTemplate->set_var('td', '');
    $MiTemplate->set_var('disable', 'disabled');
    do {
        if($ListDet->getelem()->marcaflete==1){
            $MiTemplate->set_var('prioridad','class="fondoprioridad"');             
        }else{
            $MiTemplate->set_var('prioridad','');               
        }       
        $MiTemplate->set_var('calcula_todo', '"<body onload="calculatotallinea('.$ListDet->getelem()->id_linea.');calculatotal();">"'); 
        $MiTemplate->set_var('marcaflete',$ListDet->getelem()->marcaflete);
        $MiTemplate->set_var('id_linea', $ListDet->getelem()->id_linea);
        $MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
        $MiTemplate->set_var('id_tipoentrega', $ListDet->getelem()->id_tipoentrega);
        if($ListDet->getelem()->id_tipoentrega==3){
            $MiTemplate->set_var('tipoventa', '1');
            //$MiTemplate->set_var('flujo', '<input type="hidden" name="flujo" value="5">');
        }
        if($ListDet->getelem()->codtipo == 'SV' && $ListDet->getelem()->codsubtipo == 'DE'){
            $varcodtipo = 1;
        }
        $MiTemplate->set_var('codtipo', $ListDet->getelem()->codtipo);// Tipo Producto Stock 
        $MiTemplate->set_var('rutproveedor', $ListDet->getelem()->rutproveedor);
        $MiTemplate->set_var('desp', (($ListDet->getelem()->id_tipoentrega==2)?'<img src="../../IMAGES/tick.png">':''));
        $MiTemplate->set_var('ret', (($ListDet->getelem()->id_tiporetiro==2)?'<img src="../../IMAGES/tick.png">':''));
        
        /*Bloquear Fecha de Despacho para Domicilio*/
        $validfp = 0;
        if($fch != ''){
            $MiTemplate->set_var('disabledd', 'disabled');
            $MiTemplate->set_var('val5','');
            $MiTemplate->set_var('val4','hidden');
            $validfp = 1;
            $MiTemplate->set_var('validfp',$validfp);
            $MiTemplate->set_var('fch', $fch);
            $MiTemplate->set_var('vali1','1');
            
        }
        
        if($fchr != ''){
            $MiTemplate->set_var('disabledd', 'disabled');
            $MiTemplate->set_var('val6','');
            $MiTemplate->set_var('val2','hidden');
            $MiTemplate->set_var('fchr', $fchr);
            $MiTemplate->set_var('vali2','1');
        }
        /*Fin Bloquear Fecha de Despacho para Domicilio*/
        
        
        //Validacion de campos de fechas segun el tippo de Entrega
        
        if($ListDet->getelem()->id_tipoentrega==2 && $validfp == 0){
            $MiTemplate->set_var('val1','');
            $MiTemplate->set_var('vala','');
            $MiTemplate->set_var('tda', '<td width="200" align="left">');
            $MiTemplate->set_var('tdcerra', '</td>');
            $MiTemplate->set_var('nac', 1);
            $MiTemplate->set_var('val4','');
            $MiTemplate->set_var('td', '<td width="200" align="left">');
            $MiTemplate->set_var('tdcerr', '</td>');
            $MiTemplate->set_var('vali1','1');
            $validarope = 1;
        }
        if($varcodtipo == 1){
            $MiTemplate->set_var('val1','hidden');
            $MiTemplate->set_var('td', '');
            $ajuste = 1;
            $validarope = 0;        
        }
        if($ListDet->getelem()->id_tiporetiro==2 && $validfp == 0){
            $MiTemplate->set_var('val2','');
            $MiTemplate->set_var('vali2','1');
        }
        if($ListDet->getelem()->id_tipoentrega!=2 && $ListDet->getelem()->id_tiporetiro !=2){
            $MiTemplate->set_var('val3', '');
            $MiTemplate->set_var('vali3','1');
        }
        if($ajuste == 1){
            $MiTemplate->set_var('vala','');
            $MiTemplate->set_var('tda', '<td width="200" align="left">');
            $MiTemplate->set_var('tdcerra', '</td>');
            $MiTemplate->set_var('valc','');
            $MiTemplate->set_var('disable', '');
            $MiTemplate->set_var('tdc','<td width="200" align="left">');
            $MiTemplate->set_var('tdcerrc', '</td>');
            $MiTemplate->set_var('nac',$nac);
        }
        if($validarope == 1){
            $MiTemplate->set_var('valc','hidden');
            $MiTemplate->set_var('disable', 'disabled');
            $MiTemplate->set_var('tdc', '');
        }
        if($ListDet->getelem()->id_tiporetiro==2 && ($ListDet->getelem()->id_tipoentrega!=2 && $ListDet->getelem()->id_tiporetiro !=2)){
            $MiTemplate->set_var('valc','');
            $MiTemplate->set_var('disable', '');
            $MiTemplate->set_var('tdc','<td width="200" align="left">');
            $MiTemplate->set_var('tdcerrc', '</td>');
        }else{
            
            if($ListDet->getelem()->id_tipoentrega ==2  && $ListDet->getelem()->id_tiporetiro ==2 && $validarope !=1){
                $MiTemplate->set_var('valc','');
                $MiTemplate->set_var('disable', '');
                $MiTemplate->set_var('tdc','<td width="200" align="left">');
                $MiTemplate->set_var('tdcerrc', '</td>');   
            }
            if($ListDet->getelem()->id_tipoentrega ==1  && $ListDet->getelem()->id_tiporetiro ==2 && $validarope !=1){
                $MiTemplate->set_var('valc','');
                $MiTemplate->set_var('disable', '');
                $MiTemplate->set_var('tdc','<td width="200" align="left">');
                $MiTemplate->set_var('tdcerrc', '</td>');   
            }
            if($ListDet->getelem()->id_tipoentrega ==1  && $ListDet->getelem()->id_tiporetiro ==1 && $validarope !=1){
                $MiTemplate->set_var('valc','');
                $MiTemplate->set_var('disable', '');
                $MiTemplate->set_var('tdc','<td width="200" align="left">');
                $MiTemplate->set_var('tdcerrc', '</td>');   
            }
            
        }
        
        
        
        //Fin de Validacion
        
        $MiTemplate->set_var('id_tiporetiro', $ListDet->getelem()->id_tiporetiro);
        $MiTemplate->set_var('barra', $ListDet->getelem()->barra);
        $MiTemplate->set_var('descuento', $ListDet->getelem()->descuento);      
        $MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
        $MiTemplate->set_var('grupocat', $ListDet->getelem()->grupocat);
        $MiTemplate->set_var('pventaneto',round($ListDet->getelem()->pventaneto) + round($ListDet->getelem()->cargoflete));     
        $MiTemplate->set_var('fpventaneto',$fventaneto = number_format($ListDet->getelem()->pventaneto));   
        $MiTemplate->set_var('cantidad', $cantidad = number_format(($ListDet->getelem()->cantidad - $ListDet->getelem()->cantidade), 0, '.', ''));
        $valortotal  += $ListDet->getelem()->totallinea;
//                Mantis 30047: Realizar cambios en cotizacion Inicio
//      $sumtotal    = round($valortotal - $valortotalrenta - $valortotalriva - $valortotalrica);
        $sumtotal    = round(($valortotal - $valortotaldescu)+$totaliva);
//                Mantis 30047: Realizar cambios en cotizacion Fin                
        $MiTemplate->set_var('totallinea',number_format(round( $ListDet->getelem()->totallinea)));
        $prodparagenerar += ($ListDet->getelem()->cantidad - $ListDet->getelem()->cantidade);
        $MiTemplate->set_var('cantactdis', (($ListDet->getelem()->cantidad - $ListDet->getelem()->cantidade <= 0)?'disabled':''));
        $MiTemplate->set_var('nomproveedor', $ListDet->getelem()->nomprov);
        $MiTemplate->set_var('unimed', $ListDet->getelem()->unimed);
        $MiTemplate->set_var('instalacion', $ListDet->getelem()->instalacion);
        $MiTemplate->set_var('peso', $ListDet->getelem()->peso);
        $valortotaldescu  +=round($ListDet->getelem()->descuento)+0;
        if($ListDet->getelem()->codsubtipo=='DE' && $ListDet->getelem()->codtipo=='SV'){
            $valorfletet+=$ListDet->getelem()->totallinea;  
        }
        else{
            $valorfletet=$valorfletet+0;
        }
        
        $MiTemplate->parse("BLO_detallecotizacion", "detalleproductos", true);  
    } while ($ListDet->gonext());
    if($valorfletet >0 && $visible_fletes==true){
        $MiTemplate->set_var('valorfletetabla', '<tr>
         <th width="100" align="left">Valor Fletes</th>

         <th width="100" align="right">

         {valoflete}

         </th>

         <th width="30" align="left">&nbsp;</th>
         
         </tr>
         ');
    }
    $MiTemplate->set_var('valoflete', number_format($valorfletet));
    $MiTemplate->set_var('valortotal', number_format($valortotal));
    $MiTemplate->set_var('descuentot', ((number_format($valortotaldescu) == 0)?'-':number_format($valortotaldescu)));
    $MiTemplate->set_var('valortotaliva', number_format($valortotaliva)); 
    $MiTemplate->set_var('valortotalrenta', number_format($valortotalrenta)); 
    $MiTemplate->set_var('valortotalriva', number_format($valortotalriva));
    $MiTemplate->set_var('valortotalrica', number_format($valortotalrica));
    $MiTemplate->set_var('sumtotal', number_format($sumtotal));
}
if($id_tipoventa==1){
    $MiTemplate->set_var('ocultaboxini', '<!--');
    $MiTemplate->set_var('ocultaboxfin', '-->');
    $MiTemplate->set_var('larprovfin', '70');
}else{
    $MiTemplate->set_var('ocultaprovini', '<!--');
    $MiTemplate->set_var('ocultaprovfin', '-->');   
    $MiTemplate->set_var('larprovfin', '60');

}

/* OBTENEMOS INFORMACION DEL CLIENTE */
bizcve::getCliente($List = new connlist(new dtoinfocliente(array('rut'=>$rut))));
$List->gofirst();
if (!$List->isvoid()) {
    $MiTemplate->set_var('rut', $List->getelem()->rut);
    $tipocliente=$List->getelem()->id_tipocliente;   
    if ($List->getelem()->id_tipoconpago){
        $diascondicioncliente=$List->getelem()->numdiaspago;        
    }  
    
    $configclitipo = new getidcontribuyente("CONTRIBUYENTE");
    $opcion=$configclitipo->JURIDICO;
    $opcion1=$configclitipo->EMPRESARIAL;
    
    $MiTemplate->set_var('rutcliente',(($List->getelem()->id_contribuyente == $opcion1)?$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut) : $List->getelem()->rut ));   
    $MiTemplate->set_var('id_tipocliente', $List->getelem()->id_tipocliente);           
    $MiTemplate->set_var('dias_condicion_pago', DIAS_CONDICION_PAGO);    
    $MiTemplate->set_var('id_tipoconpago', $List->getelem()->numdiaspago);      
    $id_tipoconpago=$List->getelem()->numdiaspago;
    $MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente);             
    $MiTemplate->set_var('contacto', $List->getelem()->contacto);                   
    $MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);       
    $MiTemplate->set_var('email', $List->getelem()->email); 
    $MiTemplate->set_var('nomtipdocpago', $List->getelem()->nomtipdocpago);
    $MiTemplate->set_var('disabledcre', (($List->getelem()->id_contribuyente != 5)?'disabled':''));     
    
    //Intento consultar los datos online del webservice
    $marca_bloqueos = 0;
    if ($credito != false) {
        if ($credito['bloqueo_sap']) {
            $MiTemplate->set_var('locksap', '<li>Cliente Bloqueado en SAP</li>');
            $locksap = 1;
            $marca_bloqueos = 1;
        }
        if ($credito['bloqueo_moroso']) {
            $MiTemplate->set_var('lockmoro', '<li>Cliente Bloqueado por Morosidad</li>');
            $lockmoro = 1;
            $marca_bloqueos = 1;
        }
        if ($List->getelem()->id_tipocliente == 1 && strtotime($credito['fecha_vencimiento']) < time() ) {
            $MiTemplate->set_var('lockfecha', '<li>Cliente Bloqueado por vencimiento de Disponible</li>');
            $lockfecha = 1;
            $marca_bloqueos = 1;
        }
    }
    else {
        //Traigo por defecto los datos de la db 
        if ($List->getelem()->locksap) {
            $MiTemplate->set_var('locksap', '<li>Cliente Bloqueado en SAP</li>');
            $locksap = 1;
            $marca_bloqueos = 1;
        }
        if ($List->getelem()->lockmoro) {
            $MiTemplate->set_var('lockmoro', '<li>Cliente Bloqueado por Morosidad</li>');
            $lockmoro = 1;
            $marca_bloqueos = 1;
        }
        if ($List->getelem()->lockfecha) {
            $MiTemplate->set_var('lockfecha', '<li>Cliente Bloqueado por vencimiento de Disponible</li>');
            $lockfecha = 1;
            $marca_bloqueos = 1;
        }
    }
    if ($List->getelem()->lockcve) {
        $MiTemplate->set_var('lockcve', '<li>Cliente Bloqueado en CVE</li>');
        $lockcve = 1;
        $marca_bloqueos = 1;
    }
    if ($List->getelem()->comentario) {
        $MiTemplate->set_var('comentarioe', '<li>'.$List->getelem()->comentario.'</li>');
    }
    if (!$marca_bloqueos) {
        $MiTemplate->set_var('saldodisp', '<li>Saldo Disponible</li>');
    }

//    if ($List->getelem()->id_tipodocpago == 1 || $locksap || $lockmoro || $lockcve || $lockfecha) {
//        $MiTemplate->set_var('disabledcre', 'disabled');
//        $MiTemplate->set_var('checkedcon', 'checked');
//    }

    $validacobroriva = $List->getelem()->rete_iva;
    $validacobrorenta=$List->getelem()->rete_renta;
    $validacobroica=$List->getelem()->rete_ica;
    
    
}

//$rete_iva2 = (($validacobroriva == 1)? round($rete_iva) : $rete_iva = 0);
/*$rete_ica2 = (($validacobroica == 1)? round($rete_ica) : $rete_ica = 0);
$rete_renta2 = (($validacobrorenta == 1)? round($rete_renta) : $rete_renta = 0);
$sumtotal = $valortotal - $rete_renta2 - $rete_iva2 - $rete_ica2;
general::writelog('t'.$totallinea.'r'.$rete_renta.'i'.$rete_iva2.'c'.$rete_ica.'st'.$sumtotal);
$MiTemplate->set_var('valortotaliva', number_format($totaliva));
$MiTemplate->set_var('valortotalrica',(($validacobroica == 1)? number_format($totalica): $totalica = 0 ));
$MiTemplate->set_var('valortotalrenta', (($validacobrorenta == 1)? number_format($totalrenta) : $totalrenta = 0 ));
$MiTemplate->set_var('valortotalriva',number_format($rete_iva2));
$MiTemplate->set_var('sumtotal', number_format($sumtotal));*/
$rete_iva2 = (($rete_iva > 0)? round($rete_iva) : $rete_iva = 0);
$rete_ica2 = round($rete_ica);
$rete_renta2 = round($rete_renta);
//Mantis 30047: Realizar cambios en cotizacion Inicio
//$sumtotal = $valortotal - $rete_renta2 - $rete_iva2 - $rete_ica2;
$sumtotal    = round(($valortotal - $valortotaldescu)+$totaliva);
//Mantis 30047: Realizar cambios en cotizacion Fin
if($visible_renta == true){
    $MiTemplate->set_var('visible_renta','<tr>
     <th width="100" align="left">Valor Retencion<br>Renta</th>
     <th width="100" align="right">{valortotalrenta}</th>
     <th width="30" align="left">&nbsp;</th></tr>');
}
else{
    $MiTemplate->set_var('visible_renta','');
}

if($visible_reteiva == true){
    $MiTemplate->set_var('visible_reteiva','<tr>
     <th width="100" align="left">Valor Retencion Iva</th>
     <th width="100" align="right">{valortotalriva}</th>
     <th width="30" align="left">&nbsp;</th></tr>');
}
else{
    $MiTemplate->set_var('visible_reteiva','');
}

if($visible_ica == true){
    $MiTemplate->set_var('visible_ica','<tr>
     <th width="100" align="left">Valor Retencion Ica</th>
     <th width="100" align="right">{valortotalrica}</th>
     <th width="30" align="left">&nbsp;</th></tr>');
}
else{
    $MiTemplate->set_var('visible_ica','');
}

$MiTemplate->set_var('valortotaliva', number_format($totaliva));
$MiTemplate->set_var('valortotalrica',number_format($totalica));
$MiTemplate->set_var('valortotalrenta',number_format($totalrenta));
$MiTemplate->set_var('valortotalriva',number_format($rete_iva2));
$MiTemplate->set_var('sumtotal', number_format($sumtotal));
/*Actualizacion Encabezado Cotizacion*/

$dao = new daocotizacion;
$dao->updatecoti($idcotizacion,$sumtotal,$totaliva,$totalica,$totalrenta,$rete_iva2);

/*Fin Actualizacion Encabezado Cotizacion*/


/* OBTENEMOS INFORMACION DE LAS CONDICIONES DE PAGO PERMITIDAS */ 
bizcve::gettipoconpago($ListTc = new connlist);
$ListTc->gofirst();
$MiTemplate->set_block('main' , "condpagod" , "BLO_condpagod");
if (!$ListTc->isvoid()) {
    do {
        if (!$diascondicioncliente){
            if ($id_tipoconpago < 360 && $id_tipoconpago > 0){
                $Ctrl = new ctrltipos;
                $Ctrl->getconpagoaprox($lista=new connlist(new dtotipo(array('id_tipoconpago'=>$id_tipoconpago))));     
                $lista->gofirst();
                $diascond=$lista->getelem()->id;
            }else{
                $diascond="dentro de los 360 dÌas sin DPP";
            //general::inserta_tracking(null, null, null, null, "El cliente ".$rut.'-'.general::digiVer($rut)." tiene condicion de pago mayor a la permitida");         
            }
        }else{
            $diascond=$id_tipoconpago;
        }  
/*      //condicion de pago existe y tiene id
        if( $diascondicioncliente && $id_tipoconpago){
            $MiTemplate->set_var('deshabilitado', 'disabled');  
        }           
        //condicion de pago NO existe y tiene id        
        if(!$diascondicioncliente && $id_tipoconpago){
            $MiTemplate->set_var('deshabilitado', 'disabled');  
        }       
        //condicion de pago existe y NO tiene id                
        if(!$diascondicioncliente && !$id_tipoconpago){
            $MiTemplate->set_var('deshabilitado', 'enabled');   
        }           
*/      
        $MiTemplate->set_var('id', $ListTc->getelem()->id); 
        $MiTemplate->set_var('nombre', $ListTc->getelem()->nombre);
        $MiTemplate->set_var('selected', ($diascond == $ListTc->getelem()->id)?'selected':'');      
        if ($diascond == $ListTc->getelem()->id)
            $mdiascondcli = $ListTc->getelem()->id;
        $MiTemplate->parse("BLO_condpagod", "condpagod", true); 
    } while ($ListTc->gonext());

    $MiTemplate->set_var('conddefaultcli', $mdiascondcli);
}


/* VALIDAMOS LAS CONDICIONES INVALIDANTES */
    //0.- COTIZACION EN ESTADO CV
if ($estado != 'CV'){
    general::alertexit('La Orden de Entrega ya se ha generado');
    exit();
}
    //1.- CLIENTE  BLOQUEADO (4 CRITERIOS)
//      if ($locksap || $lockmoro || $lockcve || $lockfecha){
//          //general::alertexit('No se puede generar OE debido a que el cliente se encuentra bloqueado');
//          general::confirm('El cliente se encuentra bloqueado para venta cr√©dito. Si contin√∫a, s√≥lo se podr√° hacer venta CONTADO.\nDesea continuar de todas maneras?', '', 'window.close()');
//          //exit();
//      }
    //2.- DISPONIBLE MENOR A CERO
//      if ($disponible<0){
//          general::alertexit('No se puede generar OE debido a que el cliente no tiene saldo disponible o tiene una OE previa bloqueada');
//          exit();
//      }
    //3.1 - NO VIENE FECHA DE TERMINO DE LA NVE
if (!$nvevalidhasta){
    general::alertexit('No se puede generar OE debido a que la CotizaciÛn no tiene fecha de vigencia');
    exit();
}
    //3.2 - NVE VENCIDA
$nvevalidhastaphp = mktime(0, 0, 0, substr($nvevalidhasta, 5, 2), substr($nvevalidhasta, 8, 2), substr($nvevalidhasta, 0, 4));
$ahoraphp         = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
if ($nvevalidhastaphp<$ahoraphp){
    general::alertexit('No se puede generar OE debido a que la CotizaciÛn esta vencida');
    exit();
}
    //4.- LA NVE NO TIENE PRODUCTOS PARA GENERAR OE
if (!$prodparagenerar) {
    general::alertexit('No quedan productos en la CotizaciÛn para generar OE');
    exit();
}


$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
/////////////////////////ZONA PIE DE PAGINA/////////////////////////
?>
