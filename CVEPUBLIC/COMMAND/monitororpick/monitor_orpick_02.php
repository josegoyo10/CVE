<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitororpick/monitor_orpick_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////
if($_REQUEST['grabarimpresiones'] != '')	{
$ListEnc  = new connlist;
$mRegistro=new dtoencordenpicking;
$mRegistro->id_ordenpicking =$grabarimpresiones;
$mRegistro->usuario_impresion =$_REQUEST['id_usuariore'];
//general::writeevent('value'.$grabarimpresiones);
$ListEnc->addlast($mRegistro);
bizcve::addimpresionordenpicking($ListEnc);
	
//guardo registro de impresion
$tupla =$grabarimpresiones;
$tuparray=split(',',$tupla);
	foreach($tuparray as $key=>$value){
		$ListEnc  = new connlist;
		$mRegistro=new dtoencordenpicking;
		$mRegistro->id_ordenpicking =$value;
		$ListEnc->addlast($mRegistro);
		bizcve::getordenpick($ListEnc,$ListDet=new connlist);
		$ListEnc->gofirst();
		$nimp=$ListEnc->getelem()->n_impresiones;

//guardo registro de impresion en historial por orden de picking
		$ListEnc  = new connlist;
		$mRegistro=new dtoencordenpicking;
		$mRegistro->id_ordenpicking =$value;
		$mRegistro->usuario_impresion =$_REQUEST['id_usuariore']; 
		$mRegistro->n_impresiones =$nimp;
		$ListEnc->addlast($mRegistro);
		bizcve::guardarhistoria($ListEnc,$ListDet=new connlist);
	}	
}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_var('error_app', $mensaje_error);
/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "monitororpick/monitor_orpick_02.htm");

/*OBTENEMOS DATOS DE USUARIO PARA ENCABEZADO DE IMPRESION*/
$MiTemplate->set_var('fecha', date("d/m/Y"));
$MiTemplate->set_var('hora', date("H:i:s"));
$MiTemplate->set_var('nom_local_csum', ($ses_usr_nomlocal)?$ses_usr_nomlocal:'- No Asignado -');
$MiTemplate->set_var("usuario", general::get_nombre_usr( $ses_usr_id ));
/*OBTENCION DATOS DE PICKING PARA LLENADO DE LISTA DE IMPRESION*/
$MiTemplate->set_var('cadena',$_REQUEST['id_ordenpicking']);
$conteocadena = explode(",",$_REQUEST['id_ordenpicking']); 
$conteocadena=count($conteocadena);
if($_REQUEST['mensaje']==1){
	$MiTemplate->set_var('mensajeerror',"alert('Datos incorrectos se imprimirán las órdenes de picking que no necesitan autorización');");
}
$tupla =$_REQUEST['id_ordenpicking'];
$tuparray=split(',',$tupla);

$MiTemplate->set_block('main' , "PICKING" , "BLO_PICKING");

foreach($tuparray as $key=>$value){
	$detalle='';
	$ListEnc  = new connlist;
	$mRegistro=new dtoencordenpicking;
	$mRegistro->id_ordenpicking =$value;
	//general::writeevent('value'.$value);
	$ListEnc->addlast($mRegistro);
	bizcve::getordenpick($ListEnc,$ListDet=new connlist);
	$ListEnc->gofirst();
	
	
	if($ListEnc->getelem()->n_impresiones > 0)
				{
				$MiTemplate->set_var('reimprimir','<table width="650"  border="0" cellspacing="0" cellpadding="0"  class="textonormal">
			
			<tr><td align="left"><span class="Estilo9">Reimpresión  Número</td><td><span class="Estilo9" align="center">{n_impresiones}</span></td><td align="right"><span class="Estilo9">Autorizado Por</span></td><td align="right"><span class="Estilo9" align="right">{apellidosre}&nbsp;&nbsp;{nombresre}</span></tr>
				
			</table><br>');
				
				
				}
				else{
				$MiTemplate->set_var('reimprimir','');				
				}
	
	$MiTemplate->set_var('id_usuariore',$_REQUEST['id_usuariore']);
	$MiTemplate->set_var('apellidosre',$_REQUEST['apellidosre']);
	$MiTemplate->set_var('nombresre',$_REQUEST['nombresre']);
	$MiTemplate->set_var('n_impresiones', $ListEnc->getelem()->n_impresiones);
	$MiTemplate->set_var('usuario_impresion',$ListEnc->getelem()->usuario_impresion);
	$MiTemplate->set_var('nom_local', $ListEnc->getelem()->nom_local);
	$MiTemplate->set_var('nomestado', $ListEnc->getelem()->nomestado);
	$MiTemplate->set_var('OP', $ListEnc->getelem()->id_ordenpicking);
	$MiTemplate->set_var('OE', $ListEnc->getelem()->id_ordenent);
	$MiTemplate->set_var('id_ordenpicking', $ListEnc->getelem()->id_ordenpicking);
	$MiTemplate->set_var('fechacreacion',general::formato_fecha($ListEnc->getelem()->feccrea) );
				if($ListEnc->getelem()->fecha_retira_cliente != '0000-00-00'){
					$MiTemplate->set_var('desp', 'Retira Cliente');
					$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_cliente) );}
				if($ListEnc->getelem()->fecha_retira_inmediato != '0000-00-00'){
					$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_inmediato) );
					$MiTemplate->set_var('desp', 'Retira Inmediato');}
				if($ListEnc->getelem()->fecha_despacho_programado != '0000-00-00'){
					$MiTemplate->set_var('desp', 'D. Programado');
					$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_despacho_programado) );}
	
	$MiTemplate->set_var('id_ordenent', $ListEnc->getelem()->id_ordenent);
	$MiTemplate->set_var('notaventa', $ListEnc->getelem()->id_cotizacion);
	$MiTemplate->set_var('factura', $ListEnc->getelem()->factura);
	$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);
	$obra=explode("||",$ListEnc->getelem()->direccion);
	$MiTemplate ->set_var("titulo_nom_dir",($obra[1]!=''?'<tr><td align="right" style="width: 150px">Nombre Obra:</td><td align="left" style="width: 123px">'.$obra[1].'</td></tr>':''));
	
	$Listj = new connlist;
	$rut = $ListEnc->getelem()->rutcliente;
	bizcve::gettipojur($rut,$Listj);
	$Listj->gofirst();
	$MiTemplate->set_var('rutcliente', (($Listj->getelem()->id_contribuyente == 2)?$ListEnc->getelem()->rutcliente.'-'.general::digiVer($ListEnc->getelem()->rutcliente):$ListEnc->getelem()->rutcliente));
	
/*  OBTENEMOS EL ID DE LA DIRECCION DE DESPACHO */
	/*$Listiddes  = new connlist;
	$redistrordenpikin=new dtodireccion;
	$redistrordenpikin->id_direccion =$value;
	$Listiddes->addlast($redistrordenpikin);
	bizcve::getdirdespicking($Listiddes);
	$Listiddes->gofirst();*/
	$id_direccionpick=$ListEnc->getelem()->id_direccion+0;
	//$id_direccionpick=$id_direccionpick+0;

/*OBTENEMOS DATOS DE LA DIRECCION DE DESPACHO*/
	if($id_direccionpick > 0){
	$Listdes  = new connlist;
	$mRegistrod=new dtodireccion;
	$mRegistrod->id_direccion =$id_direccionpick;
	$Listdes->addlast($mRegistrod);
	bizcve::getdirdesp($Listdes);
	$Listdes->gofirst();
	$MiTemplate->set_var('direcciond', $Listdes->getelem()->direccion);
	$MiTemplate->set_var('contactod', $Listdes->getelem()->contacto);
	$MiTemplate->set_var('comentariod', $Listdes->getelem()->comentario);
	//$MiTemplate->set_var('nomcomunad', $id_direccionpick);
	$MiTemplate->set_var('fonocontactod', $Listdes->getelem()->fonocontacto);
	//$MiTemplate->set_var('nomciudadd', $Listdes->getelem()->nomciudad);
$Listlocalizacion  = new connlist;
$registrolocalizacion->id_localizacion=$Listdes->getelem()->id_comuna;
$Listlocalizacion->addlast($registrolocalizacion);
bizcve::getlocalizacion($Listlocalizacion);
$Listlocalizacion->gofirst();
if (!$Listlocalizacion->isvoid()) {
	do {
		$MiTemplate->set_var('nomciudadd', $Listlocalizacion->getelem()->ciudad);
		$MiTemplate->set_var('nomcomunad', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
		$MiTemplate->set_var('departamentod', $Listlocalizacion->getelem()->departamento);
		
	} while ($Listlocalizacion->gonext());
}	
}else{
	bizcve::getCliente($List = new connlist(new dtoinfocliente(array('rut'=>$ListEnc->getelem()->rutcliente))));
	$List->gofirst();
	$MiTemplate->set_var('direcciond', $List->getelem()->direccion);
	$MiTemplate->set_var('contactod', $List->getelem()->contacto.' '.$List->getelem()->apellido);
	$MiTemplate->set_var('comentariod', $List->getelem()->comentario);
	//$MiTemplate->set_var('nomcomunad', $List->getelem()->id_comuna);
	$MiTemplate->set_var('fonocontactod',$List->getelem()->fonocontacto);
	//$MiTemplate->set_var('nomciudadd', '');
$Listlocalizacion  = new connlist;
$registrolocalizacion->id_localizacion=$List->getelem()->id_comuna;
$Listlocalizacion->addlast($registrolocalizacion);
bizcve::getlocalizacion($Listlocalizacion);
$Listlocalizacion->gofirst();
if (!$Listlocalizacion->isvoid()) {
	do {
		$MiTemplate->set_var('nomcomunad', $List->getelem()->id_comuna);
		$MiTemplate->set_var('nomciudadd', $Listlocalizacion->getelem()->ciudad);
		$MiTemplate->set_var('nomcomunad', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
		$MiTemplate->set_var('departamentod', $Listlocalizacion->getelem()->departamento);	
	} while ($Listlocalizacion->gonext());
}
}
	$ListDet->gofirst();
	if ($ListDet->numelem()) { 
		do{
			$pventaneto = $ListDet->getelem()->totallinea / $ListDet->getelem()->cantidad;
			$detalle.='<tr>' .
						'<td width="70" align="center" class="Estilo11" >'.
							$ListDet->getelem()->codprod.
						'</td>'.
						'<td width="261" class="Estilo11" >'.
							$ListDet->getelem()->descripcion.
						'</td>'.
						'<td width="122" align="center" class="Estilo11" >&nbsp;&nbsp;&nbsp;'.
							$ListDet->getelem()->unimed.
						'</td>'.
						'<td width="122" align="right" class="Estilo11" >&nbsp;&nbsp;&nbsp;'.
							$pventaneto.
						'</td>'.
						'<td width="106" align="right" class="Estilo11" >'.
							$ListDet->getelem()->cantidad."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
						'</td>'.
						'<td width="183" class="Estilo11" align="center">____________________&nbsp;</td>' .
						'</tr>';
						$MiTemplate->set_var('nomtipoproduct', $ListDet->getelem()->nomtipoproduct);
						$MiTemplate->set_var('codtipo', $ListDet->getelem()->codtipo);
						/*if ( $ListDet->getelem()->id_tipoentrega==2 and $ListDet->getelem()->id_tiporetiro==1)
						{
						$MiTemplate->set_var('desp', 'D. Programado');
						}
						if ( $ListDet->getelem()->id_tipoentrega==1 and $ListDet->getelem()->id_tiporetiro==2){
	    				$MiTemplate->set_var('desp', 'Retira Cliente');		    
						}
						if ( $ListDet->getelem()->id_tipoentrega==1 and $ListDet->getelem()->id_tiporetiro==1)
						{       $MiTemplate->set_var('desp', 'Retira Inmediato');}*/
						$totalcantidadordpink=$totalcantidadordpink+$ListDet->getelem()->cantidad;
						
						
	
		} while($ListDet->gonext());
	}
	
				$MiTemplate->set_var('totalcantidadordpink','<tr>
					<td width="70" align="center"></td>
					<td width="261" align="center"></td>
					<td width="122" align="center"></td>
					<td width="122" align="right" class="Estilo10">Total</td>
					<td width="106" align="center" class="Estilo11">'.$totalcantidadordpink.'</td>
					<td width="183" align="center"></td>
				</tr>');
	
	$conteoc+=1;
	if((($conteocadena+0)-$conteoc) > 0){		
	$MiTemplate->set_var('salto','<H1 class=SaltoDePagina> </H1>');
	}
	else
	{
	$MiTemplate->set_var('salto','');
	}
	
	$totalcantidadordpink=0;
	$MiTemplate->set_var('detalle',$detalle);
	$MiTemplate->parse("BLO_PICKING", "PICKING", true);
	
}
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
?>