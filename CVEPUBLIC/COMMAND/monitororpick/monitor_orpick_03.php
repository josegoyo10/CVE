<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitororpick/monitor_orpick_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
?>
<script language="JavaScript">
	window.returnValue='reload';
</script>
<?
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_var('error_app', $mensaje_error);

/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "monitororpick/monitor_orpick_03.htm");

/* OBTENEMOS DATOS DE PICKING PARA ENCABEZADO */
$ListEnc  = new connlist;
$ListDet  = new connlist;
$mRegistro=new dtoencordenpicking;
$mRegistro->id_ordenpicking =$_REQUEST['id_ordenpicking'];
$ListEnc->addlast($mRegistro);
bizcve::getordenpick($ListEnc,$ListDet);
$ListEnc->gofirst();
if($ListEnc->getelem()->id_estado=='PN' || $ListEnc->getelem()->id_estado=='PF'){
	$MiTemplate->set_var('botonanular','');
	$MiTemplate->set_var('titulocolumna','Devta');	
}
else{

	if(!bizcve::verificacionDePermisos($ses_usr_id,85, 'UPDATE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }

    bizcve::setevento(30, 'Modulo Orden de Picking', $_SERVER['REMOTE_ADDR'], 'ABM OE',
					'Se ha Anulado la Orden de Picking N '.$_REQUEST['id_ordenpicking'],'','La Orden de Picking N '.$_REQUEST['id_ordenpicking'].' a Cambiado a estado Nula.',$usr_nombre);

	$MiTemplate->set_var('botonanular','<input type="button" Value="Anular Picking" onclick="anularpicking({id_ordenpicking});">');
	$MiTemplate->set_var('titulocolumna','Pick');
}
$MiTemplate->set_var('id_ordenpicking', $ListEnc->getelem()->id_ordenpicking);
$direccion=$ListEnc->getelem()->id_direccion;
$MiTemplate->set_var('id_ordenent', $ListEnc->getelem()->id_ordenent);
//$MiTemplate->set_var('nomtipoentrega', $ListEnc->getelem()->nomtipoentrega);
//$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);
$MiTemplate->set_var('nom_local_csum', $ListEnc->getelem()->nom_local);
$MiTemplate->set_var('notaventa', $ListEnc->getelem()->id_cotizacion);
$MiTemplate->set_var('nota', $ListEnc->getelem()->nota);
$MiTemplate->set_var('nomestadop', $ListEnc->getelem()->nomestado);	
$MiTemplate->set_var('fechacreacion',general::formato_fecha($ListEnc->getelem()->feccrea) );	
				if($ListEnc->getelem()->fecha_retira_cliente != '0000-00-00'){
					$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_cliente) );
					$MiTemplate->set_var('desp', 'Retira Cliente');}
				if($ListEnc->getelem()->fecha_retira_inmediato != '0000-00-00'){
					$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_inmediato) );
					$MiTemplate->set_var('desp', 'Retira Inmediato');}
				if($ListEnc->getelem()->fecha_despacho_programado != '0000-00-00'){
					$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_despacho_programado) );
					$MiTemplate->set_var('desp', 'D. Programado');}
/* OBTENEMOS DIRECCION DE DESPACHO */

/* OBTENEMOS INFORMACION DEL CLIENTE */
bizcve::getCliente($List = new connlist(new dtoinfocliente(array('rut'=>$rut))));
$List->gofirst();
if (!$List->isvoid()) {
    $MiTemplate->set_var('rut', $List->getelem()->rut);
    $MiTemplate->set_var('rutcliente', (($List->getelem()->id_contribuyente == 2)?$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut) : $List->getelem()->rut ));	
    $MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente);			
    $MiTemplate->set_var('contacto', $List->getelem()->contacto.' '.$List->getelem()->apellido);					
    $MiTemplate->set_var('razonsoc', $List->getelem()->razonsoc);
    $MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);
    $MiTemplate->set_var('direccion', $List->getelem()->direccion);
    $MiTemplate->set_var('nomcomuna', $List->getelem()->nomcomuna);
    $MiTemplate->set_var('nomciudad', $List->getelem()->nomciudad);
    $MiTemplate->set_var('giro', $List->getelem()->giro);
$Listlocalizacion  = new connlist;
$registrolocalizacion->id_localizacion=$List->getelem()->id_comuna;
$Listlocalizacion->addlast($registrolocalizacion);
bizcve::getlocalizacion($Listlocalizacion);
$Listlocalizacion->gofirst();
if (!$Listlocalizacion->isvoid()) {
	do {
		$localiciu=$Listlocalizacion->getelem()->ciudad;
		$localibar=$Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad;
		$localidep=$Listlocalizacion->getelem()->departamento;
		$MiTemplate->set_var('nomciudad', $Listlocalizacion->getelem()->ciudad);
		$MiTemplate->set_var('nomcomuna', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
		$MiTemplate->set_var('nomdepartamento', $Listlocalizacion->getelem()->departamento);
		
	} while ($Listlocalizacion->gonext());
}
    
}

/* OBTENEMOS DIRECCION DE DESPACHO */
 
if($direccion > 0)
{
$Listdirdes  = new connlist;
$id_dirdes->id_direccion=$direccion;
$Listdirdes->addlast($id_dirdes);
bizcve::getdirdesp($Listdirdes);
$Listdirdes->gofirst();
$Listlocalizacion  = new connlist;
$registrolocalizacion->id_localizacion=$Listdirdes->getelem()->id_comuna;
$Listlocalizacion->addlast($registrolocalizacion);
bizcve::getlocalizacion($Listlocalizacion);
$Listlocalizacion->gofirst();
if (!$Listlocalizacion->isvoid()) {
	do {
		$MiTemplate->set_var('direcciond', $Listdirdes->getelem()->direccion);
		$MiTemplate->set_var('contactod', $Listdirdes->getelem()->contacto);
		$MiTemplate->set_var('comentariod', $Listdirdes->getelem()->comentario);
		$MiTemplate->set_var('fonocontactod', $Listdirdes->getelem()->fonocontacto);
		$MiTemplate->set_var('ciudadd', $Listlocalizacion->getelem()->ciudad);
		$MiTemplate->set_var('comunad', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
		$MiTemplate->set_var('departamentod', $Listlocalizacion->getelem()->departamento);
		
	} while ($Listlocalizacion->gonext());
}	
}
else
{
		$MiTemplate->set_var('direcciond', $List->getelem()->direccion);
		$MiTemplate->set_var('contactod', $List->getelem()->contacto.' '.$List->getelem()->apellido);
		$MiTemplate->set_var('comentariod', $List->getelem()->comentario);
		$MiTemplate->set_var('fonocontactod', $List->getelem()->fonocontacto);
		$MiTemplate->set_var('ciudadd', $localiciu);
		$MiTemplate->set_var('comunad', $localibar);
		$MiTemplate->set_var('departamentod', $localidep);
	
}
/* OBTENEMOS DATOS DEL DETALLE DE PICKING */
$ListDet->gofirst();
$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detalleproductos");
if ($ListDet->numelem()) { 
	do{
		
			$MiTemplate->set_var('codprod', $ListDet->getelem()->codprod);
			$MiTemplate->set_var('descripcion', $ListDet->getelem()->descripcion);
			$MiTemplate->set_var('cantidad', number_format(($ListDet->getelem()->cantidad), 2, '.', ''));
			$MiTemplate->set_var('cantidadp',($ListEnc->getelem()->id_estado=='PN'?number_format(($ListDet->getelem()->cantidad), 2, '.', ''):number_format(($ListDet->getelem()->cantidadp), 2, '.', '')));
			//$MiTemplate->set_var('cantidadp', number_format(($ListDet->getelem()->cantidadp), 2, '.', ''));		
			$MiTemplate->set_var('id_linea', $ListDet->getelem()->id_linea);
			$MiTemplate->set_var('unimed', $ListDet->getelem()->unimed);
			$MiTemplate->set_var('codtipo', $ListDet->getelem()->codtipo);
			$MiTemplate->set_var('nomtipoproduct', $ListDet->getelem()->nomtipoproduct);
						/*if ( $ListDet->getelem()->id_tipoentrega==2 and $ListDet->getelem()->id_tiporetiro==1)
						{
						$MiTemplate->set_var('desp', 'D. Programado');
						}
						if ( $ListDet->getelem()->id_tipoentrega==1 and $ListDet->getelem()->id_tiporetiro==2){
	    				$MiTemplate->set_var('desp', 'Retira Cliente');		    
						}
						if ( $ListDet->getelem()->id_tipoentrega==1 and $ListDet->getelem()->id_tiporetiro==1)
						{       $MiTemplate->set_var('desp', 'Retira Inmediato');}*/
		
			$MiTemplate->parse("BLO_detalleproductos", "detalleproductos", true);
			
	} while ($ListDet->gonext());
}

	
/*FIN DESPLIEGUE*/

$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>