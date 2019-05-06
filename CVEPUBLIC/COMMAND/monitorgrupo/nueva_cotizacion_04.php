<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

$visibleIMP = new getidvisibleimpuestos("VISIBLE_IMPUESTOS");
$visible_fletes=$visibleIMP->FLETES;
$visible_renta=$visibleIMP->IMPUESTO_RENTA;
$visible_ica=$visibleIMP->IMPUESTO_ICA;
$visible_reteiva=$visibleIMP->IMPUESTO_RETEIVA;

///////////////////////// ZONA DE ACCIONES /////////////////////////
/*si puede ver las cotizaciones*/
	$ListEncco  = new connlist;
	$ListDet    = new connlist;	
	$mRegistro  = new dtocotizacion;
   	$mRegistro->id_cotizacion=$_REQUEST['id_cotizacion'];
	$ListEncco->addlast($mRegistro);
	bizcve::getcotizacion($ListEncco, $ListDet);
	$ListEncco->gofirst();	
	$id_estado_inicial=$ListEncco->getelem()->id_estado;
	
	//$ListEncco->getelem()->validhasta;
	//echo $fechavencimiento;
	if(!isset($_REQUEST['id_cotizacion'])){
		general::alertexit('No puede ver esta cotizacion');
		header( "Location: ../start/start_01.php");					
	}
	if(!$ListEncco->getelem()->puedever){
		$noacciones=true;
	}else{
		$noacciones=false;		
	}

if ($accion == 'AgrTr') {
	$List = new connlist;
	$itracking = new dtotracking;
	$itracking->id_cotizacion =$_POST['id_cotizacion'];	
	$itracking->descripcion   =$_POST['descripcion'];		
	$itracking->tipo =$_POST['tipo'];		
	$List->addlast($itracking);
	bizcve::puttracking($List);  
	
}

if ($accion == 'Eliminar') {
	$List = new connlist;
	$cotizacion = new dtocotizacion;
	$cotizacion->id_cotizacion =$_REQUEST['id_cotizacion'];	
	$id_cotizacion=$_REQUEST['id_cotizacion'];	
	$List->addlast($cotizacion);
	bizcve::delcotizacionall($List);  	
	/*para insertar el tracking*/
	general::inserta_tracking( $id_cotizacion, null, null, null, "Se ha eliminado la cotizacion");	
	header( "Location: ../monitorcoti/monitor_cotizacion.php");
}

if ($accion == 'Duplicar') {
	$ListEnccodu  = new connlist;
	$mRegistrodu  = new dtocotizacion;
   	$mRegistrodu->id_cotizacion=$_REQUEST['id_cotizacion'];
	$ListEnccodu->addlast($mRegistrodu);
	bizcve::getcotizacion($ListEnccodu, $ListDet);
	$ListEnccodu->gofirst();	
	
	$fechavenci=explode("/", general::formato_fecha($ListEnccodu->getelem()->validhasta));
	$diav=$fechavenci[0];
	$mesv=$fechavenci[1];
	$anov=$fechavenci[2];
	
	$dte = getdate();
	$dia = $dte[mday];
	$mes = $dte[mon];
	$ano = $dte[year];

	if($ano >= $anov && $mes >= $mesv && $dia > $diav){
	
	$listaEncCD = new connlist;
	$CotizacionCD = new dtocotizacion;
	$CotizacionCD ->id_cotizacion  =$_POST['id_cotizacion'];
	$CotizacionCD ->id_estado 	='CD';
	$listaEncCD->addlast($CotizacionCD);
	
	   			if (!bizcve::cambioestadocotizacion($listaEncCD)) 
				{
				$mensaje_error = 'Problemas al cambiar el estado de la Cotización. Contactese con el administrador';
				}
				else
				{
				general::inserta_tracking( $id_cotizacion, null, null, null, "La cotizacion ha cambiado a estado Caducada");
				}
	header( "Location: nueva_cotizacion_04.php?id_cotizacion=".$_REQUEST['id_cotizacion']."&duplicarcot=no");
	general::writeevent('La cotización número '.$_REQUEST['id_cotizacion'].' no puede ser duplicada se encuentra vancida');
	}
	else {
	$List=new connlist(new dtocotizacion(array('id_cotizacion' =>$_REQUEST['id_cotizacion'])));
	if (!bizcve::dupcotizacion($List)){
		?><script>
			history.back();
    	</script><?
    	exit();
	}
		$List->gofirst();
		$ultimo_id_cotizacion=$List->getelem()->id_cotizacion;
		general::inserta_tracking( $_REQUEST['id_cotizacion'], null, null, null, "Se ha duplicado la cotizacion ".$_REQUEST['id_cotizacion']." generando la cotizacion ".$ultimo_id_cotizacion." en estado En Trabajo");
		general::inserta_tracking( $ultimo_id_cotizacion, null, null, null, "Cotizacion ha sido creada como duplicado de cotizacion " . $_REQUEST['id_cotizacion']);
		//$Listf = new connlist;
		////bizcve::delcotizacionf($_GET['id_cotizacion'];
		$Listf  = new connlist;
		$registrof = new dtocotizacion;
		$registrof->id_cotizacion=$ultimo_id_cotizacion;
		$Listf->addlast($registrof);
		bizcve::cuontcotizacionf($Listf);
		$Listf->gofirst();
		//$counterf=1;
		//general::writeevent('sdfgsdf'.$Listf->getelem()->numlinea1);
		if($Listf->getelem()->numlinea1 > 0){
		header( "Location: nueva_cotizacion_03.php?editar=Edit&id_cotizacion=".$ultimo_id_cotizacion);
		exit();
		}
		else{
		header( "Location: nueva_cotizacion_04.php?id_cotizacion=".$ultimo_id_cotizacion);
		exit();
		}
	}
		
}

if ($accion == 'DuplicarCaducada') {
	$ListEnccodu  = new connlist;
	$mRegistrodu  = new dtocotizacion;
   	$mRegistrodu->id_cotizacion=$_REQUEST['id_cotizacion'];
	$ListEnccodu->addlast($mRegistrodu);
	bizcve::getcotizacion($ListEnccodu, $ListDet);
	$ListEnccodu->gofirst();	
	
	$List=new connlist(new dtocotizacion(array('id_cotizacion' =>$_REQUEST['id_cotizacion'])));
	if (!bizcve::dupcotizacioncaducada($List)){
		?><script>
			history.back();
    	</script><?
    	exit();
	}
		$List->gofirst();
		
		$ultimo_id_cotizacion=$List->getelem()->id_cotizacion;
		general::inserta_tracking( $_REQUEST['id_cotizacion'], null, null, null, "Se ha duplicado la cotizacion caducada ".$_REQUEST['id_cotizacion']." generando la cotizacion ".$ultimo_id_cotizacion." en estado En Trabajo");
		general::inserta_tracking( $ultimo_id_cotizacion, null, null, null, "Cotizacion ha sido creada como duplicado de cotizacion caducada" . $_REQUEST['id_cotizacion']);
		/*
		$Listf  = new connlist;
		$registrof = new dtocotizacion;
		$registrof->id_cotizacion=$ultimo_id_cotizacion;
		$Listf->addlast($registrof);
		bizcve::cuontcotizacionf($Listf);
		$Listf->gofirst();
		
		if($Listf->getelem()->numlinea1 > 0){*/
		//header( "Location: nueva_cotizacion_03.php?editar=Edit&id_cotizacion=".$ultimo_id_cotizacion);
		header( "Location: nueva_cotizacion_04.php?id_cotizacion=".$ultimo_id_cotizacion);
		exit();
		/*}
		else{
		
		exit();
		}
			*/
}

if ($accion == 'GenSaldo') {
	bizcve::getcotizacion($ListEnc = new connlist(new dtocotizacion(array('id_cotizacion'=>$_REQUEST['id_cotizacion']))), $ListDet = new connlist);
	/*Para verificar si tiene o no productos*/
	$ListDet->gofirst();
	if (!$ListDet->isvoid()) {
		$prodparagenerar = 0;
		do {
			$prodparagenerar += ($ListDet->getelem()->cantidad - $ListDet->getelem()->cantidade);
		} while ($ListDet->gonext());
	}
	if (!$prodparagenerar) {
		?><script>
			alert('No quedan productos en la NVE para generar el saldo de OE');
    	</script><?
	}else{
		$List=new connlist(new dtocotizacion(array('id_cotizacion' =>$_REQUEST['id_cotizacion'])));
		bizcve::gencotizacionremnve($List);	
		$List->gofirst();
		$ultimo_id_cotizacion=$List->getelem()->id_cotizacion;
		general::inserta_tracking( $_REQUEST['id_cotizacion'], null, null, null, "Se ha generado la cotizacion ".$ultimo_id_cotizacion." en estado En Trabajo como saldo de la actual cotizacion");
		general::inserta_tracking( $ultimo_id_cotizacion, null, null, null, "Cotizacion ha sido creada como saldo de cotizacion " . $_REQUEST['id_cotizacion']);
		header( "Location: nueva_cotizacion_04.php?id_cotizacion=".$ultimo_id_cotizacion);
		$MiTemplate->set_var('accion', '');	
	}
}

if ($accion == 'CambEst') {
	$ListEnc = new connlist;
	$cambioEst = new dtocambiosestado;
	$cambioEst->id_cotizacion 	  =$_POST['id_cotizacion'];	
	$cambioEst->id_estado_origen  =$_POST['origen'];	
	$cambioEst->id_estado_destino =$_POST['destino'];	
	$ListEnc->addlast($cambioEst);	
	/* De En Trabajo a Editar (CT)*/
	if(($_POST['destino']=='CT')&&($_POST['origen']=='CT')){
	    header( "Location: nueva_cotizacion_03.php?id_cotizacion=".$_POST['id_cotizacion']);
    	exit();
	}
	/* De Terminada CE a Editar (CT)*/
	if(($_POST['destino']=='CT')&&($_POST['origen']=='CE')){
		general::inserta_tracking( $_REQUEST['id_cotizacion'], null, null, null, "Cotizacion ha cambiado a estado En trabajo");	
		bizcve::cambiosestado($ListEnc); 	
		//Si se edita una CO que fue hecha en este local para otro CSUM, NO se debe actualizar los precios
		if ($_REQUEST['nomsgactprec'])
			header( "Location: nueva_cotizacion_03.php?id_cotizacion=".$_POST['id_cotizacion']."&np=0");
		else
		header( "Location: nueva_cotizacion_03.php?id_cotizacion=".$_POST['id_cotizacion']);
    	exit();
	}	
	/* De nota de venta CV a Terminada CE,volver a co*/
	if(($_POST['destino']=='CE')&&($_POST['origen']=='CV')){
		$ListEncoe = new connlist;
		$ListDetoe = new connlist;
		$Registro = new dtoencordenent;
		$Registro->id_cotizacion = $_POST['id_cotizacion'];
		$ListEncoe->addlast($Registro);
		bizcve::getordenent($ListEncoe, $ListDetoe);
		$ListEncoe->gofirst();
		if ($ListEncoe->numelem()>0){
			$numoe=$ListEncoe->numelem();
			?><script>
			alert('No puede Volver a Cotizacion dado que la Nota de Venta '+<?=$_REQUEST['id_cotizacion']?>+' tiene '+<?=$numoe?>+' ordenes de entrega generadas');
    		</script><?
		}else{
			$numoe=$ListEncoe->numelem();
			bizcve::cambiosestado($ListEnc); 	
		    general::inserta_tracking( $_REQUEST['id_cotizacion'], null, null, null, "La Nota de Venta ha cambiado a estado Entregada");	
			header( "Location: nueva_cotizacion_04.php?id_cotizacion=".$_POST['id_cotizacion']);
			exit();  					
		}
	}/* fin volver a CO*/
    if( (($_POST['origen']=='CV')&&($_POST['destino']=='CE'))|| (($_POST['origen']=='CE')&&($_POST['destino']=='CV')) )	{

    }
	if( (($_POST['origen']=='CV')&&($_POST['destino']=='CV'))|| (($_POST['origen']=='CE')&&($_POST['destino']=='CV')) )	{
		$ListEncn = new connlist;
        $cambioEst = new dtocambiosestado;
        $cambioEst->id_cotizacion 	  =$_POST['id_cotizacion'];	
        $cambioEst->id_estado_destino ='CN';	
        $ListEncn->addlast($cambioEst);	
        bizcve::cambiosestadocot($ListEncn);
	    general::inserta_tracking( $_REQUEST['id_cotizacion'], null, null, null, "La cotizacion ha cambiado a estado ".$nombredestino);
	    header( "Location: nueva_cotizacion_04.php?id_cotizacion=".$_POST['id_cotizacion']);
		exit();  					
	    
    }else{
        $ListEncn = new connlist;
        $cambioEst = new dtocambiosestado;
        $cambioEst->id_cotizacion 	  =$_POST['id_cotizacion'];	
        $cambioEst->id_estado_origen  =$_POST['origen'];	
        $cambioEst->id_estado_destino =$_POST['destino'];	
        $ListEncn->addlast($cambioEst);	
        bizcve::cambiosestado($ListEncn);
        $nombredestino= general::nombre_estado($_POST['destino']);
	    general::inserta_tracking( $_REQUEST['id_cotizacion'], null, null, null, "La cotizacion ha cambiado a estado ".$nombredestino);	
        header( "Location: nueva_cotizacion_04.php?id_cotizacion=".$_POST['id_cotizacion']);	
        exit();
    }
}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var("TITULO", TITULO);
/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "nuevacotizacion/nueva_cotizacion_04.htm");

if(!$ses_usr_codlocal){
	$local=Z1; 	
	$MiTemplate->set_var('usr_login_edit', $ses_usr_login);				
	$MiTemplate->set_var('local', $local);	
}else{
	$MiTemplate->set_var('local', $ses_usr_codlocal);	
}

if($_REQUEST['duplicarcot']=='no'){
general::alert('La Cotización número '.$_REQUEST['id_cotizacion'].' no puede ser duplicada puesto que se encuentra vencida');
}
else{
	
}
$ListEnc = new connlist;
$ListEnc=$ListEncco;
$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
    $MiTemplate->set_var('documento', 'CO');
    $MiTemplate->set_var('titulo', 'Cotizaci&#243;n');	
    $MiTemplate->set_var('validdesde',general::formato_fecha($ListEnc->getelem()->validdesde) );
	$MiTemplate->set_var('validhasta',general::formato_fecha($ListEnc->getelem()->validhasta) );
	$MiTemplate->set_var('id_cotizacion', $ListEnc->getelem()->id_cotizacion);
	$MiTemplate->set_var('id_estado', $ListEnc->getelem()->id_estado);
	$estado=$ListEnc->getelem()->id_estado; 	
	$id_estado=$ListEnc->getelem()->id_estado;			
	$MiTemplate->set_var('nomestado', $ListEnc->getelem()->nomestado);
	$MiTemplate->set_var('id_tipoventa', $ListEnc->getelem()->id_tipoventa);
	$id_tipoventa = $ListEnc->getelem()->id_tipoventa;
	$MiTemplate->set_var('nomtipoventa', $ListEnc->getelem()->nomtipoventa);	
	$MiTemplate->set_var('codigovendedor', $ListEnc->getelem()->codigovendedor);
	$rut=$ListEnc->getelem()->rutcliente;
	$codigovendedor=$ListEnc->getelem()->codigovendedor;
	$MiTemplate->set_var('codlocalventa', $ListEnc->getelem()->codlocalventa);
	$localventa= $ListEnc->getelem()->codlocalventa;
	$localcsum= $ListEnc->getelem()->codlocalcsum;
	$MiTemplate->set_var('nom_local', $ListEnc->getelem()->nom_local);		
	$MiTemplate->set_var('validdesde',general::formato_fecha($ListEnc->getelem()->validdesde) );
	$MiTemplate->set_var('validhasta',general::formato_fecha($ListEnc->getelem()->validhasta) );
	$MiTemplate->set_var('condicion', $ListEnc->getelem()->condicion);
	$MiTemplate->set_var('nota', $ListEnc->getelem()->nota);		
	$MiTemplate->set_var('iva',$ListEnc->getelem()->iva);	
	
	if($visible_renta == true){
	$MiTemplate->set_var('visible_renta','<tr>
								<td width="40"></td><td width="80"></td>
								<td width="200"></td><td width="100" align="left">Retención Renta</td>
								<td width="50"></td><td width="90" align="right">{rete_renta}</td></tr>');	
	}else{
		$MiTemplate->set_var('visible_renta','');
	}
	
	if($visible_reteiva == true){
		$MiTemplate->set_var('visible_reteiva','<tr>
								<td width="40" ></td><td width="80" ></td><td width="200" ></td>                
								<td width="100" align="left">Retención IVA</td>
								<td width="50"></td><td width="90" align="right">{rete_iva}</td></tr>');
	}
	else{
		$MiTemplate->set_var('visible_reteiva','');
	}
	
	if($visible_ica == true){
		$MiTemplate->set_var('visible_ica','<tr>
								<td width="40"></td><td width="80"></td><td width="200" ></td>
								<td width="100" align="left" >Retención ICA</td><td width="50" ></td>                
								<td width="90"align="right">{rete_ica}</td></tr>');
	}
	else{
		$MiTemplate->set_var('visible_ica','');
	}
	$MiTemplate->set_var('rete_renta', number_format($ListEnc->getelem()->rete_renta));
	$MiTemplate->set_var('rete_iva', number_format($ListEnc->getelem()->rete_iva));
	$MiTemplate->set_var('rete_ica', number_format($ListEnc->getelem()->rete_ica));
	$MiTemplate->set_var('cot_iva', number_format($ListEnc->getelem()->cot_iva));
	$valortotal  =round($ListEnc->getelem()->valortotal + $ListEnc->getelem()->rete_renta + $ListEnc->getelem()->rete_iva + $ListEnc->getelem()->rete_ica)+0;
	$valoriva    =round(($ListEnc->getelem()->valortotal*$ListEnc->getelem()->iva)/100);
	//$sumtotal    =$valoriva+round($ListEnc->getelem()->valortotal);
	$sumtotal    = $valortotal - $ListEnc->getelem()->rete_renta - $ListEnc->getelem()->rete_iva -$ListEnc->getelem()->rete_ica;
	
	//$valortotal  =($ListEnc->getelem()->valortotal)+0;
	//$valoriva    =(($ListEnc->getelem()->valortotal*$ListEnc->getelem()->iva)/100);
	//$sumtotal    =$valoriva+($ListEnc->getelem()->valortotal);
	
	
	
	$margentotal =$ListEnc->getelem()->margentotal;
	$MiTemplate->set_var('margentotal', round($margentotal*100)/100+0);
	$MiTemplate->set_var('usuariocrea', $ListEnc->getelem()->usuariocrea);	
	if ( $ListEnc->getelem()->id_estado=='CV'){
	    $MiTemplate->set_var('documento', 'CO');
	    $MiTemplate->set_var('titulo', 'Cotizacion');		    
		$MiTemplate->set_var('validdesde',general::formato_fecha($ListEnc->getelem()->validdesde) );
		$MiTemplate->set_var('validhasta',general::formato_fecha($ListEnc->getelem()->validhasta) );
				    
	}					
}

$List = new connlist;
$Registro = new dtousuario;
$Registro->codigovendedor	=  $codigovendedor;
$List->addlast($Registro);
bizcve::GetUsers($List);
$List->gofirst();
$usr_nombre=$List->getelem()->usr_nombres;
$usr_apellidos=$List->getelem()->usr_apellidos;
if(!$codigovendedor){
	$MiTemplate->set_var('nombrevendedor', 'Venta No Asignada');	
}
else{
	$MiTemplate->set_var('nombrevendedor', $usr_nombre.' '.$usr_apellidos);
}	
//$MiTemplate->set_var('nombrevendedor', $usr_nombre.' '.$usr_apellidos);	

$List = new connlist;
$Registro = new dtolocal;
$Registro->cod_local	=  $localcsum;
$List->addlast($Registro);
bizcve::getlocales($List);
$List->gofirst();
$MiTemplate->set_var('nom_local_csum', $List->getelem()->nom_local);		

$List->clearlist();
$contadorgenerico=0;
/* para el detalle de las cotizaciones*/
$ListDet->gofirst();
$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detallecotizacion");
if($id_tipoventa==1){
	if (!$ListDet->isvoid()) {
		do {
			//class="fondoprioridad"
			$MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
			$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
			$precio=($ListDet->getelem()->pventaneto)+round($ListDet->getelem()->cargoflete);
			//$precio=($ListDet->getelem()->pventaneto)+($ListDet->getelem()->cargoflete);
			$MiTemplate->set_var('tamanotitulodesc', '<th width="260" align="center">Descripci&oacute;n</th>');
			$MiTemplate->set_var('cantidad', $ListDet->getelem()->cantidad);
			$MiTemplate->set_var('tamanodesc', '260');
			$MiTemplate->set_var('tamcantidad', '10');
			//$MiTemplate->set_var('tamanoprecio', '150');
			//$MiTemplate->set_var('tamanopventaiva', '60');
			$MiTemplate->set_var('espacio', '20');
			$MiTemplate->set_var('marcadespacho', '');									
			$MiTemplate->set_var('marcaretira', '');									
			$MiTemplate->set_var('tamanoprov', '100');
			$MiTemplate->set_var('tamcantidad', '10');
			$MiTemplate->set_var('tamdesp', '1');
			$MiTemplate->set_var('tamret', '1');
			$MiTemplate->set_var('alinunimed', 'center');
			$MiTemplate->set_var('tamunimed', '50');
			$MiTemplate->set_var('tamtituloprecio', '60');
			$MiTemplate->set_var('tamtitulopventaiva', '70');			
			$MiTemplate->set_var('unimed', $ListDet->getelem()->unimed);
			//$MiTemplate->set_var('desp', (($ListDet->getelem()->id_tipoentrega==2)?'<img src="../../IMAGES/tick.png">':''));
			//$MiTemplate->set_var('ret', (($ListDet->getelem()->id_tiporetiro==2)?'<img src="../../IMAGES/tick.png">':''));				
			$MiTemplate->set_var('totallinea',number_format(round( $ListDet->getelem()->totallinea)));
			//$MiTemplate->set_var('totallinea',number_format( $ListDet->getelem()->totallinea,2));
			$MiTemplate->set_var('precio', number_format(round($precio)));
			$MiTemplate->set_var('pventaiva',  number_format(round($ListDet->getelem()->pventaiva)));
			//$MiTemplate->set_var('pventaiva',  number_format($ListDet->getelem()->pventaiva,2));
			$MiTemplate->set_var('proveedor', '<th width="200" align="center">Proveedor</th>');
			$MiTemplate->set_var('nomproveedor', $ListDet->getelem()->nomprov);
			$MiTemplate->set_var('rutproveedor', $ListDet->getelem()->rutproveedor);
			$MiTemplate->parse("BLO_detallecotizacion", "detalleproductos", true);	
		} while ($ListDet->gonext());
		$MiTemplate->set_var('valortotal', number_format($valortotal));
		$MiTemplate->set_var('valoriva', number_format($valoriva+0));
		$MiTemplate->set_var('sumtotal', number_format($sumtotal+0));
	
	}	
}elseif($id_tipoventa==2){
	if (!$ListDet->isvoid()) {
		do {
			$MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
			if($ListDet->getelem()->marcaflete==1){
				$MiTemplate->set_var('prioridad','class="fondoprioridad"');				
			}else{
				$MiTemplate->set_var('prioridad','');				
			}
			$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
			$MiTemplate->set_var('peso', $ListDet->getelem()->peso);
			$MiTemplate->set_var('instalacion', $ListDet->getelem()->instalacion);
			$MiTemplate->set_var('prod_tipo', $ListDet->getelem()->codsubtipo);
			if($ListDet->getelem()->codsubtipo=='GE'){
			$contadorgenerico ++ ;	
			}
			$precio=($ListDet->getelem()->pventaneto)+round($ListDet->getelem()->cargoflete);
			//$precio=($ListDet->getelem()->pventaneto)+($ListDet->getelem()->cargoflete);
			$MiTemplate->set_var('cantidad', $ListDet->getelem()->cantidad);
			$MiTemplate->set_var('tamdesp', '100');
			$MiTemplate->set_var('tamret', '40');			
			$MiTemplate->set_var('tamanopventaiva', '120');
			$MiTemplate->set_var('tamtituloprecio', '110');
			$MiTemplate->set_var('tamtitulopventaiva', '110');													
			//$MiTemplate->set_var('marcaretira', '<th width="30" align="left">R</th>');									
			$MiTemplate->set_var('unimed', $ListDet->getelem()->unimed);
			//$MiTemplate->set_var('desp', (($ListDet->getelem()->id_tipoentrega==2)?'<img src="../../IMAGES/tick.png">':''));
			//$MiTemplate->set_var('ret', (($ListDet->getelem()->id_tiporetiro==2)?'<img src="../../IMAGES/tick.png">':''));
		if ( $ListDet->getelem()->id_tipoentrega==1 and $ListDet->getelem()->id_tiporetiro==2){
	    			$MiTemplate->set_var('desp', 'Retira Cliente');		    
					}
		if ( $ListDet->getelem()->id_tipoentrega==2 and $ListDet->getelem()->id_tiporetiro==1)
					{
					$MiTemplate->set_var('desp', 'D. Programado');
					}
		if ( $ListDet->getelem()->id_tipoentrega==1 and $ListDet->getelem()->id_tiporetiro==1)
		{       $MiTemplate->set_var('desp', 'Retira Inmediato');}
			$MiTemplate->set_var('totallinea',number_format(round( $ListDet->getelem()->totallinea)));
			//$MiTemplate->set_var('totallinea',number_format( $ListDet->getelem()->totallinea,2));
			$MiTemplate->set_var('precio', number_format($precio));
			$MiTemplate->set_var('pventaiva', number_format(round($ListDet->getelem()->pventaiva)));
			//$MiTemplate->set_var('pventaiva', number_format($ListDet->getelem()->pventaiva,2));
			$MiTemplate->set_var('tamanoprov', '0');
			$MiTemplate->set_var('descuento', number_format($ListDet->getelem()->descuento));
			$MiTemplate->set_var('descuento%',number_format(((($ListDet->getelem()->descuento/$ListDet->getelem()->cantidad)*100)/($precio+($ListDet->getelem()->descuento/$ListDet->getelem()->cantidad))),1));
			$descuentot=$descuentot+$ListDet->getelem()->descuento;
			if($ListDet->getelem()->codsubtipo=='DE' && $ListDet->getelem()->codtipo=='SV'){
			$valorfletet=$valorfletet+$ListDet->getelem()->totallinea;	
			}
			else{
				$valorfletet=$valorfletet+0;
			}
			
			$cadena_productos_estado= $ListDet->getelem()->codprod."-".$cadena_productos_estado;			
			$MiTemplate->parse("BLO_detallecotizacion", "detalleproductos", true);	
		} while ($ListDet->gonext());
		//totales cotizacion
		if($valorfletet >0 && $visible_fletes==true){
		$MiTemplate->set_var('valorfletetabla', '<tr>

								<td width="40" ></td>

								<td width="80" ></td>

								<td width="200" ></td>                

								<td width="100" align="left">Valor Fletes</td>

								<td width="50"  ></td>								

								<td width="90"  align="right">{valorfletet}</td>               

							</tr>');
		$MiTemplate->set_var('valorfletet', number_format($valorfletet));}
		$MiTemplate->set_var('descuentot', number_format($descuentot));
		$MiTemplate->set_var('valortotal', number_format($valortotal));
		$MiTemplate->set_var('valoriva', number_format($valoriva+0));
		$MiTemplate->set_var('sumtotal', number_format($sumtotal+0));
	
	}
}
//consulta para verificar la existencia de productos marcados como borrados
//$MiTemplate->set_var('cadenapro', substr($cadena_productos_estado, 0, -1));
//fin verificar existencia p marcados
$MiTemplate->set_var('contadorgenerico', $contadorgenerico);
/*para los datos del cliente*/
$List = new connlist;
$Registro = new dtoinfocliente;
$Registro->rut	= $rut;
$List->addlast($Registro);

bizcve::getCliente($List);
$List->gofirst();
if (!$List->isvoid()) {
	if($List->getelem()->locksap)
		$locksap='<li>Cliente Bloqueado en SAP</li>';
	if($List->getelem()->lockmoro)
		 $lockmoro='<li> Cliente Bloqueado por Morosidad</li>';
	if($List->getelem()->lockcve)
		$lockcve ='<li> Cliente Bloqueado en CVE </li>';
	if($List->getelem()->lockfecha)
		$lockfecha ='<li>Cliente Bloqueado por vencimiento de Disponible</li>';			
	if($List->getelem()->comentario)
		$comentario ='<li>'.$List->getelem()->comentario.'</li>';
$configclitipo = new getidcontribuyente("CONTRIBUYENTE");
$opcion=$configclitipo->JURIDICO;
$opcion1=$configclitipo->EMPRESARIAL;
	$MiTemplate->set_var('observacionescl', $locksap.$lockmoro.$lockcve.$lockfecha.$comentario);
	$MiTemplate->set_var('rut', $rut);
	$id_contribuyente_cambiocliente_unico=$List->getelem()->id_contribuyente;
	$MiTemplate->set_var('nomtipdocpago', $List->getelem()->nomtipdocpago);
	$MiTemplate->set_var('rutcliented', (($List->getelem()->id_contribuyente == $opcion1)?$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut) : $List->getelem()->rut ));	
	$MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente);			
	$MiTemplate->set_var('contacto', $List->getelem()->apellido.' '.$List->getelem()->apellido1.' '.$List->getelem()->contacto);					
	$MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);		
	$MiTemplate->set_var('email', $List->getelem()->email);
	$MiTemplate->set_var('direccion', $List->getelem()->direccion);	

$Listlocalizacion  = new connlist;
$registrolocalizacion->id_localizacion=$List->getelem()->id_comuna;
$Listlocalizacion->addlast($registrolocalizacion);
bizcve::getlocalizacion($Listlocalizacion);
$Listlocalizacion->gofirst();
if (!$Listlocalizacion->isvoid()) {
	do {
		$MiTemplate->set_var('ciudadcli', $Listlocalizacion->getelem()->ciudad);
		$MiTemplate->set_var('nomcomuna', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
		$MiTemplate->set_var('departamentocli', $Listlocalizacion->getelem()->departamento);
		
	} while ($Listlocalizacion->gonext());
}
}

$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
	$MiTemplate->set_var('id_cotizacion', $ListEnc->getelem()->id_cotizacion);		
	$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);	
	$MiTemplate->set_var('giro', $ListEnc->getelem()->giro);
	//$MiTemplate->set_var('direccion', $ListEnc->getelem()->direccion);				
	//$MiTemplate->set_var('nomcomuna', $ListEnc->getelem()->comuna);
		
}


/*Recuperar tracking*/
$List = new connlist;
$Registro = new dtotracking;
$Registro->id_cotizacion	=  $_REQUEST['id_cotizacion'];
$List->addlast($Registro);

bizcve::gettracking($List);
$List->gofirst();
$MiTemplate->set_block('main' , "listatracking" , "BLO_listatracking");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('tipo', $List->getelem()->tipo);
		$MiTemplate->set_var('descripcion_track', $List->getelem()->descripcion);						
		$MiTemplate->set_var('usuario_track', $List->getelem()->usrcrea);			
		$MiTemplate->set_var('fecha_track', $List->getelem()->feccrea);			
		$MiTemplate->parse("BLO_listatracking", "listatracking", true);	
	} while ($List->gonext());
}


/*Recuperar las acciones*/
$List = new connlist;
$Registro = new dtocambiosestado;
$Registro->id_estado_origen = $id_estado;
//general::alert('el primer llamado '.$id_estado);
$Registro->id_cotizacion	=  $_REQUEST['id_cotizacion'];
$Registro->tipo = 'CV';
$List->addlast($Registro);
bizcve::getcambiosestado($List);
$List->gofirst();
$MiTemplate->set_block('main' , "Botones" , "BLO_Botones");
if(!$noacciones){
	if (!$List->isvoid()) {
		do {
			$id_estado=$List->getelem()->id_estado_origen;
			$MiTemplate->set_var('id_estado_origen', $List->getelem()->id_estado_origen);
			$origen=$List->getelem()->id_estado_origen;	
			$MiTemplate->set_var('id_cotizacion', $id_cotizacion);	
			$MiTemplate->set_var('origen', $List->getelem()->id_estado_origen);			
			$MiTemplate->set_var('estadoterminal', $List->getelem()->estadoterminal);			
			$MiTemplate->set_var('id_estado_destino', $List->getelem()->id_estado_destino);						
			$MiTemplate->set_var('nomaccion', $List->getelem()->nomaccion);	
			if ($List->getelem()->color=='red'){
				$MiTemplate->set_var('color', ';color:#FF0000');					
			}else{
				$MiTemplate->set_var('color', '');				
			}		
			$MiTemplate->parse("BLO_Botones", "Botones", true);	
		} while ($List->gonext());
			$MiTemplate->set_var('rutcliente', $rut);
	}
	else {
		$MiTemplate->set_block('main' , "Botones" , "BLO_Botones");	
		$MiTemplate->set_var('nomaccionsin', 'Sin Accion');	
		$MiTemplate->set_var('inicio', '<!--');				
		$MiTemplate->set_var('fin', '-->');	
		$MiTemplate->parse("BLO_Botones", "Botones", true);		
	}
	/*para el caso que no tenga acciones en cambiosestado*/	
	if ($id_estado_inicial){
			$id_estado=$id_estado_inicial;

				/*para eliminar*/
			if ($id_estado=='CT'){
				$eliminar="<input type='button' class='Textonormal' style='width:200' name='Button' value='Eliminar Cotizaci&oacute;n' onClick=Eliminar($id_cotizacion)>";
				$MiTemplate->set_var('eliminar', $eliminar);
				$editar="<input type='button' class='Textonormal' style='width:200' name='Button' value='Editar' onClick=Editar($id_cotizacion)>";
				$MiTemplate->set_var('editar', $editar);			
			}
			/*para imprimir*/
			if ($id_estado=='CE'||$id_estado=='CV'){
				$imprimir="<input type='button' class='Textonormal' style='width:200' name='Button' value='Imprimir Cotizaci&oacute;n' onClick=Imprime('$origen',$rut)>";
				$MiTemplate->set_var('imprimir', $imprimir);			
				if ($id_estado=='CV'){
					$MiTemplate->set_var('origen', 'CV');	
					$imprimir="<input type='button' class='Textonormal' style='width:200;color:#FF0000' name='Button' value='Imprimir Cotizacion' onClick=Imprime('CV',$rut)>";			
					$MiTemplate->set_var('nombre_doc', 'NDV');			
					$MiTemplate->set_var('imprimir', $imprimir);						
				}
			}
			/*para duplicar*/
			if ($id_estado=='CE'||$id_estado=='CN'||$id_estado=='CD'||$id_estado=='CV'||$id_estado=='CF'){
				$duplicar="<input type='button' class='Textonormal' style='width:200' name='Button' value='Duplicar' onClick=Duplicar($id_cotizacion)>";
				$MiTemplate->set_var('duplicar', $duplicar);			
			}
			/*para generar saldo NVE*/
			if ($id_estado=='CV'){
				$generasaldo="<input type='button' class='Textonormal' style='width:200' name='Button' value='Genera Saldo Nota de Venta' onClick=GenSaldo($id_cotizacion)>";
				$MiTemplate->set_var('generasaldo', $generasaldo);			
				$generaoe="<input type='button' class='Textonormal' style='width:200;color:#FF0000' name='Button' value='Generar Orden Entrega' onClick=GeneraOe($id_cotizacion)>";
				$MiTemplate->set_var('generaoe', $generaoe);
				$generaoe="<input type='button' class='Textonormal' style='width:200;color:#FF0000' name='Button' value='Generar Orden Entrega' onClick=GeneraOe($id_cotizacion)>";
				$MiTemplate->set_var('financia', "<input type='button' class='Textonormal' style='width:200' name='Button' value='Financiación' onClick=financia($id_cotizacion)>");	
				$editar="<input type='button' class='Textonormal' style='width:200' name='Button' value='Editar' onClick=Editar($id_cotizacion)>";
				$MiTemplate->set_var('editar', $editar);
			}		
		}
		/*para duplicar en el caso de que sea nula u caduca*/
		if ($id_estado=='CN'||$id_estado=='CD'){

			$duplicar="<input type='button' class='Textonormal' style='width:200' name='Button' value='Duplicar' onClick=Duplicar($id_cotizacion)>";
			$MiTemplate->set_var('duplicar', $duplicar);			
		}	
}elseif($id_estado=='CB'){
	//$duplicar="<input type='button' class='Textonormal' style='width:200' name='Button' value='Duplicar' onClick=Duplicar($id_cotizacion)>";
	//$editar="<input type='button' class='Textonormal' style='width:200' name='Button' value='Editar' onClick=Editar($id_cotizacion)>";
	$MiTemplate->set_var('duplicar', $duplicar);			
	$MiTemplate->set_var('editar', $editar);
}
elseif($id_estado=='CN'){
	$duplicar="<input type='button' class='Textonormal' style='width:200' name='Button' value='Duplicar' onClick=Duplicar($id_cotizacion)>";
	$MiTemplate->set_var('duplicar', $duplicar);			
	
}
elseif($id_estado=='CD'){
	$duplicarcotizaciocaducada="<input type='button' class='Textonormal' style='width:200' name='Button' value='Duplicar Cotización Caducada' onClick=DuplicarCaducada($id_cotizacion)>";
	$MiTemplate->set_var('duplicarcaducada', $duplicarcotizaciocaducada);			
	
}
/*recuperar documentos relacionados*/
/*obtiene las ordenes de entrega encabezados, dcumentos relacionados*/
$ListEnc = new connlist;
$ListDet = new connlist;
$Registro = new dtoencordenent;
$Registro->id_cotizacion	=  $_REQUEST['id_cotizacion'];
$ListEnc->addlast($Registro);
bizcve::getordenent($ListEnc, $ListDet);

$ListEnc->gofirst();
$MiTemplate->set_block('main' , "ordenent" , "BLO_listaordenent");
if (!$ListEnc->isvoid()) {
	do {
 		$MiTemplate->set_var('tipo_doc', $ListEnc->getelem()->tipo);		
 		$MiTemplate->set_var('id_ordenent', $ListEnc->getelem()->id_ordenent);
		$MiTemplate->set_var('nomestadorent', $ListEnc->getelem()->nomestadorent);
		$MiTemplate->set_var('feccrea', general::formato_fecha($ListEnc->getelem()->feccrea));				
		$MiTemplate->set_var('usrcrea', $ListEnc->getelem()->usrcrea);
		$MiTemplate->parse("BLO_listaordenent", "ordenent", true);	
	} while ($ListEnc->gonext());
}
else {
 	$MiTemplate->set_var('sindocumentos','No existen documentos relacionados a esta Cotizacion');
}


//Variable para indicar que es otro centro de suministro
$MiTemplate->set_var('nolocalasignado', (($ses_usr_codlocal)?0:1));
$MiTemplate->set_var('centrosumdis', (($ses_usr_codlocal == $localcsum)?0:1));
$MiTemplate->set_var('nomsgactprec', (($ses_usr_codlocal == $localventa && $localventa != $localcsum)?1:0));

if($id_contribuyente_cambiocliente_unico==$opcion1){
	$MiTemplate->set_var('boton_nueva_cotizacion','<input type="button" class="Textonormal" style="width:200" value="Genera Nueva Cotización" onClick="NuevaCot({rut__cot} )">');
	$MiTemplate->set_var('rut__cot', $rut);
}
else{
	$MiTemplate->set_var('boton_nueva_cotizacion','');
}
$MiTemplate->parse("OUT_M", array("header", "main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';

?>