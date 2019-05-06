<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitororpick/monitor_orpick_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////
$ListEnc  = new connlist;
$mRegistro=new dtoencordenpicking;
$mRegistro->id_ordenpicking =$_GET['id_picking'];
$mRegistro->id_estado ='PN';
$ListEnc->addlast($mRegistro);
if(bizcve::putordenpicking($ListEnc,$ListDet))
{
	if(!bizcve::verificacionDePermisos($ses_usr_id,85, 'UPDATE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }
	echo 'La orden de picking N '.$_REQUEST['id_picking'].' a cambiado a estado NULA';
	global $ses_usr_id;
    $usr_nombre =general::get_nombre_usr( $ses_usr_id );

        bizcve::setevento(30, 'Modulo Orden de Picking', $_SERVER['REMOTE_ADDR'], 'ABM OE',
                    'Se ha Anulado la Orden de Picking N '.$_GET['id_picking'].'','','La Orden de Picking N '.$_GET['id_picking'].' a Cambiado a estado Nula.', $usr_nombre );
}
else{
	echo 'No fue posible realizar el cambio de estado de la orden de picking';
}
?>