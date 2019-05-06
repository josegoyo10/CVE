<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitor_operaciones/monitor_operaciones.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

/*ACCIONES DE BOTONES*/
if($_REQUEST['accion']=='reinicio_servidor'){
	shell_exec("/sbin/init 6");
}
if($_REQUEST['accion']=='reiniciar_apache'){
	shell_exec("/sbin/service httpd stop");
}
if($_REQUEST['accion']=='reiniciar_ftp'){
	shell_exec("/sbin/service ftp stop");
}
if($_REQUEST['accion']=='reiniciar_cups'){
	shell_exec("/sbin/service cups stop");
}
if($_REQUEST['accion']=='reinicio_mysql'){
	shell_exec("/sbin/service mysqld restart");
}
/*CHEQUEO TABLAS*/
if($_REQUEST['accion']=='check_table'){
	$error_tabla = 1;
	$List  = new connlist;
	bizcve::checktablas($List);
	$List->gofirst();
		$List->gofirst();
		if (!$List->isvoid()) {
			do {
				if($List->getelem()->texto=='error'){
					$error_tabla = 2;
					$tabla_mala = $List->getelem()->nomtabla_error;
				}
				
			} while ($List->gonext());
		}
}


///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE . "monitor_operaciones/monitor_operaciones.htm");
$MiTemplate->set_var('first','checked');

$MiTemplate->set_var('var_tiempo', RELOAD_OP);


/******************************************DESPLIEGUE HARDWARE******************************************/

/*CPU*/
$List  = new connlist;
bizcve::getcpu($List);
$List->golast();
		
	$MiTemplate->set_var('carga_cpu', $List->getelem()->valor);
	if($List->getelem()->valor < /*UMBRAL_NORMAL*/ 4){
		$MiTemplate->set_var('barra_cpu', '| | | | | | | | | | | | | | | | |');
		$MiTemplate->set_var('estilo_cpu', 'verde');
		$MiTemplate->set_var('estilo_recomendaciones_cpu', 'tabla1');
		$MiTemplate->set_var('recomendaciones_cpu', RECOMENDACIONES_CPU_BAJA);
	}
	if($List->getelem()->valor > /*UMBRAL_MEDIO_1*/ 4 && $List->getelem()->valor <8/*UMBRAL_MEDIO_2*/){
		$MiTemplate->set_var('barra_cpu', '| | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | |');
		$MiTemplate->set_var('estilo_cpu', 'naranjo');
		$MiTemplate->set_var('estilo_recomendaciones_cpu', 'tabla1');
		$MiTemplate->set_var('recomendaciones_cpu', RECOMENDACIONES_CPU_MEDIA);
	}
	if($List->getelem()->valor > /*UMBRAL_ALTO_1*/ 8 && $List->getelem()->valor <12/*UMBRAL_ALTO_2*/){
		general::alert('CPU en riesgo critico!. Considere las recomendaciones propuestas.');
		$MiTemplate->set_var('barra_cpu', '| | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | |');
		$MiTemplate->set_var('estilo_cpu', 'rojo');
		$MiTemplate->set_var('estilo_boton_servidor', 'fondoprioridad');
		$MiTemplate->set_var('estilo_recomendaciones_cpu', 'fondoprioridad');
		$MiTemplate->set_var('recomendaciones_cpu', RECOMENDACIONES_CPU_ALTA);
	}

/*DISCO DURO (LOG)*/
$List  = new connlist;
bizcve::getdiscolog($List);
$List->golast();
		
	$MiTemplate->set_var('carga_disco_log', $List->getelem()->valor);
	if($List->getelem()->valor < /*UMBRAL_NORMAL*/ 49){
		$MiTemplate->set_var('barra_disco_log', '| | | | | | | | | | | | | | | | |');
		$MiTemplate->set_var('estilo_barra_disco_log', 'verde');
		$MiTemplate->set_var('estilo_recomendaciones_disco_log', 'tabla1');
		$MiTemplate->set_var('recomendaciones_disco_log', RECOMENDACIONES_DISCO_LOG_BAJA);
	}
	if($List->getelem()->valor > /*UMBRAL_MEDIO_1*/ 50 && $List->getelem()->valor <89/*UMBRAL_MEDIO_2*/){
		$MiTemplate->set_var('barra_disco_log', '| | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | |');
		$MiTemplate->set_var('estilo_barra_disco_log', 'naranjo');
		$MiTemplate->set_var('estilo_recomendaciones_disco_log', 'tabla1');
		$MiTemplate->set_var('recomendaciones_disco_log', RECOMENDACIONES_DISCO_LOG_MEDIA);
	}
	if($List->getelem()->valor > /*UMBRAL_ALTO_1*/ 90 && $List->getelem()->valor <100/*UMBRAL_ALTO_2*/){
		general::alert('Disco duro en riesgo critico!. Considere las recomendaciones propuestas.');
		$MiTemplate->set_var('barra_disco_log', '| | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | |');
		$MiTemplate->set_var('estilo_barra_disco_log', 'rojo');
		$MiTemplate->set_var('estilo_recomendaciones_disco_log', 'fondoprioridad');
		$MiTemplate->set_var('recomendaciones_disco_log', RECOMENDACIONES_DISCO_LOG_ALTA);
	}


/*DISCO DURO (BASE DE DATOS)*/
$List  = new connlist;
bizcve::getdiscobd($List);
$List->golast();

	$MiTemplate->set_var('carga_disco_bd', $List->getelem()->valor);
	if($List->getelem()->valor < /*UMBRAL_NORMAL*/ 49){
		$MiTemplate->set_var('barra_disco_bd', '| | | | | | | | | | | | | | | | |');
		$MiTemplate->set_var('estilo_barra_disco_bd', 'verde');
		$MiTemplate->set_var('estilo_recomendaciones_disco_bd', 'tabla1');
		$MiTemplate->set_var('recomendaciones_disco_bd', RECOMENDACIONES_DISCO_BD_BAJA);
	}
	if($List->getelem()->valor > /*UMBRAL_MEDIO_1*/ 50 && $List->getelem()->valor <89/*UMBRAL_MEDIO_2*/){
		$MiTemplate->set_var('barra_disco_bd', '| | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | |');
		$MiTemplate->set_var('estilo_barra_disco_bd', 'naranjo');
		$MiTemplate->set_var('estilo_recomendaciones_disco_bd', 'tabla1');
		$MiTemplate->set_var('recomendaciones_disco_bd', RECOMENDACIONES_DISCO_BD_MEDIA);
	}
	if($List->getelem()->valor > /*UMBRAL_ALTO_1*/ 90 && $List->getelem()->valor <100/*UMBRAL_ALTO_2*/){
		general::alert('Disco duro en riesgo critico!. Considere las recomendaciones propuestas.');
		$MiTemplate->set_var('barra_disco_bd', '| | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | |');
		$MiTemplate->set_var('estilo_barra_disco_bd', 'rojo');
		$MiTemplate->set_var('estilo_recomendaciones_disco_bd', 'fondoprioridad');
		$MiTemplate->set_var('recomendaciones_disco_bd', RECOMENDACIONES_DISCO_BD_ALTA);
	}


/*MEMORIA*/
$List  = new connlist;
bizcve::getmemoria($List);
$List->golast();
	$MiTemplate->set_var('carga_memoria', $List->getelem()->valor);
	if($List->getelem()->valor < /*UMBRAL_NORMAL*/ 4){
		$MiTemplate->set_var('barra_memoria', '| | | | | | | | | | | | | | | | |');
		$MiTemplate->set_var('estilo_memoria', 'verde');
		$MiTemplate->set_var('estilo_recomendaciones_memoria', 'tabla1');
		$MiTemplate->set_var('recomendaciones_memoria', RECOMENDACIONES_MEMORIA_BAJA);
	}
	if($List->getelem()->valor > /*UMBRAL_MEDIO_1*/ 4 && $List->getelem()->valor <8/*UMBRAL_MEDIO_2*/){
		$MiTemplate->set_var('barra_memoria', '| | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | |');
		$MiTemplate->set_var('estilo_memoria', 'naranjo');
		$MiTemplate->set_var('estilo_recomendaciones_memoria', 'tabla1');
		$MiTemplate->set_var('recomendaciones_memoria', RECOMENDACIONES_MEMORIA_MEDIA);
	}
	if($List->getelem()->valor > /*UMBRAL_ALTO_1*/ 8 && $List->getelem()->valor <12/*UMBRAL_ALTO_2*/){
		general::alert('Memoria RAM al limite!. Considere las recomendaciones propuestas.');
		$MiTemplate->set_var('barra_swap', '| | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | |');
		$MiTemplate->set_var('estilo_memoria', 'rojo');
		$MiTemplate->set_var('estilo_boton_apache', 'fondoprioridad');
		$MiTemplate->set_var('estilo_recomendaciones_memoria', 'fondoprioridad');
		$MiTemplate->set_var('recomendaciones_memoria', RECOMENDACIONES_MEMORIA_ALTA);
	}

/******************************************FIN DESPLIEGUE HARDWARE******************************************/

/******************************************DESPLIEGUE SERVICIOS******************************************/

/*SERVICIO APACHE*/
$List  = new connlist;
bizcve::getapache($List);
$List->golast();
if($List->getelem()->valor==1){
	$MiTemplate->set_var('status_apache', 'Operativo');
	$MiTemplate->set_var('estilo_apache', 'verde');
	$MiTemplate->set_var('estilo_boton_apache', 'tabla1');
	$MiTemplate->set_var('estilo_recomendacion_apache', 'tabla1');
	$MiTemplate->set_var('recomendaciones_apache', RECOMENDACIONES_APACHE);
	
}else{
	$MiTemplate->set_var('status_apache', 'Inoperativo');
	$MiTemplate->set_var('estilo_apache', 'rojo');
	$MiTemplate->set_var('estilo_boton_apache', 'fondoprioridad');
	$MiTemplate->set_var('recomendaciones_apache', RECOMENDACIONES_APACHE_ALTA);
	$MiTemplate->set_var('estilo_recomendacion_apache', 'fondoprioridad');
}

/*SERVICIO MYSQL*/
$List  = new connlist;
bizcve::getmysql($List);
$List->golast();
if($List->getelem()->valor==1){
	$MiTemplate->set_var('status_mysql', 'Operativo');
	$MiTemplate->set_var('estilo_mysql', 'verde');
	$MiTemplate->set_var('estilo_boton_mysql', 'tabla1');
	$MiTemplate->set_var('estilo_recomendacion_mysql', 'tabla1');
	$MiTemplate->set_var('recomendaciones_mysql', RECOMENDACIONES_MYSQL);
	
}else{
	$MiTemplate->set_var('status_mysql', 'Inoperativo');
	$MiTemplate->set_var('estilo_mysql', 'rojo');
	$MiTemplate->set_var('estilo_boton_mysql', 'fondoprioridad');
	$MiTemplate->set_var('recomendaciones_mysql', RECOMENDACIONES_MYSQL_ALTA);
	$MiTemplate->set_var('estilo_recomendacion_mysql', 'fondoprioridad');
}
/*CHECK TABLE*/
if($error_tabla==1){
	$MiTemplate->set_var('status_tablas', 'Correcto');
	$MiTemplate->set_var('estilo_tablas', 'verde');
	$MiTemplate->set_var('recomendaciones_tablas', RECOMENDACIONES_TABLAS_OP);
 
}
if($error_tabla==2){
	$MiTemplate->set_var('status_tablas', 'Inconvenientes en tablas');
	$MiTemplate->set_var('estilo_tablas', 'fondoprioridad');
	$MiTemplate->set_var('estilo_recomendacion_tablas', 'fondoprioridad');
	$MiTemplate->set_var('recomendaciones_tablas', RECOMENDACIONES_TABLAS_INO.' Revise la Tabla: '.$tabla_mala);
}

/*SERVICIO FTP*/
$List  = new connlist;
bizcve::getftp($List);
$List->golast();
if($List->getelem()->valor==1){
	$MiTemplate->set_var('status_ftp', 'Operativo');
	$MiTemplate->set_var('estilo_ftp', 'verde');
	$MiTemplate->set_var('estilo_recomendacion_ftp', 'tabla1');
	$MiTemplate->set_var('recomendaciones_ftp', RECOMENDACIONES_FTP);
	
}else{
	$MiTemplate->set_var('status_ftp', 'Inoperativo');
	$MiTemplate->set_var('estilo_ftp', 'rojo');
	$MiTemplate->set_var('recomendaciones_ftp', RECOMENDACIONES_FTP_ALTA);
	$MiTemplate->set_var('estilo_recomendacion_ftp', 'fondoprioridad');
}

/*SERVICIO CUPS*/
$List  = new connlist;
bizcve::getcups($List);
$List->golast();
if($List->getelem()->valor==1){
	$MiTemplate->set_var('status_cups', 'Operativo');
	$MiTemplate->set_var('estilo_cups', 'verde');
	$MiTemplate->set_var('estilo_recomendacion_cups', 'tabla1');
	$MiTemplate->set_var('recomendaciones_cups', RECOMENDACIONES_CUPS);
	
}else{
	$MiTemplate->set_var('status_cups', 'Inoperativo');
	$MiTemplate->set_var('estilo_cups', 'rojo');
	$MiTemplate->set_var('recomendaciones_cups', RECOMENDACIONES_CUPS_ALTA);
	$MiTemplate->set_var('estilo_recomendacion_cups', 'fondoprioridad');
}
/******************************************FIN DESPLIEGUE SERVICIOS******************************************/

/*******************************************INTERFASES*******************************************/

/*FACTURAS EN B.D.*/
$List  = new connlist;
bizcve::getfct_bd($List);
$List->golast();
	$MiTemplate->set_var('fct_bd', $List->getelem()->valor);
	$FCT_BD=$List->getelem()->valor;

/*FACTURAS EN F.S.*/
$List  = new connlist;
bizcve::getfct_fs($List);
$List->golast();
	$MiTemplate->set_var('fct_fs', $List->getelem()->valor);
	$FCT_FS=$List->getelem()->valor;

/*FACTURAS EN F.T.P.*/
$List  = new connlist;
bizcve::getfct_ftp($List);
$List->golast();
	$MiTemplate->set_var('fct_ftp', $List->getelem()->valor);
	$FCT_FTP=$List->getelem()->valor;

/*GUIAS DE DESPACHO EN B.D.*/
$List  = new connlist;
bizcve::getgde_bd($List);
$List->golast();
	$MiTemplate->set_var('gde_bd', $List->getelem()->valor);
	$GDE_BD=$List->getelem()->valor;

/*GUIAS DE DESPACHO EN F.S.*/
$List  = new connlist;
bizcve::getgde_fs($List);
$List->golast();
	$MiTemplate->set_var('gde_fs', $List->getelem()->valor);
	$GDE_FS=$List->getelem()->valor;

/*GUIAS DE DESPACHO EN F.T.P.*/
$List  = new connlist;
bizcve::getfct_ftp($List);
$List->golast();
	$MiTemplate->set_var('gde_ftp', $List->getelem()->valor);
	$GDE_FTP=$List->getelem()->valor;

/*NOTAS DE CREDITO EN B.D.*/
$List  = new connlist;
bizcve::getncr_bd($List);
$List->golast();
	$MiTemplate->set_var('ncr_bd', $List->getelem()->valor);
	$NCR_BD=$List->getelem()->valor;

/*NOTAS DE CREDITO EN F.S.*/
$List  = new connlist;
bizcve::getncr_fs($List);
$List->golast();
	$MiTemplate->set_var('ncr_fs', $List->getelem()->valor);
	$NCR_FS=$List->getelem()->valor;

/*NOTAS DE CREDITO EN F.T.P.*/
$List  = new connlist;
bizcve::getncr_ftp($List);
$List->golast();
	$MiTemplate->set_var('ncr_ftp', $List->getelem()->valor);
	$NCR_FTP=$List->getelem()->valor;

/***************PROGRAMACION ADVERTENCIA EN MENSAJERIA***************/

/*PARA FACTURA*/
/*general::alert($FCT_BD);
general::alert($FCT_FS);
general::alert($FCT_FTP);*/
if(($FCT_BD!=$FCT_FS)||($FCT_BD!=$FCT_FTP)){
	$MiTemplate->set_var('indicador_fct', 'publish_x.png');
	$MiTemplate->set_var('estilo_sap_fct', 'fondoprioridad');
	$MiTemplate->set_var('falla_fct', FALLA_FCT);
	
}else{
	$MiTemplate->set_var('indicador_fct', 'tick.png');
	$MiTemplate->set_var('estilo_sap_fct', 'tabla1');
}

/*PARA GDE*/
if(($GDE_BD!=$GDE_FS)||($GDE_BD!=$GDE_FTP)){
	$MiTemplate->set_var('indicador_gde', 'publish_x.png');
	$MiTemplate->set_var('estilo_sap_gde', 'fondoprioridad');
	$MiTemplate->set_var('falla_gde', FALLA_GDE);
	
}else{
	$MiTemplate->set_var('indicador_gde', 'tick.png');
	$MiTemplate->set_var('estilo_sap_gde', 'tabla1');
}

/*PARA NCR*/
if(($NCR_BD!=$NCR_FS)||($NCR_BD!=$NCR_FTP)){
	$MiTemplate->set_var('indicador_ncr', 'publish_x.png');
	$MiTemplate->set_var('estilo_sap_ncr', 'fondoprioridad');
	$MiTemplate->set_var('falla_ncr', FALLA_NCR);
	
}else{
	$MiTemplate->set_var('indicador_ncr', 'tick.png');
	$MiTemplate->set_var('estilo_sap_ncr', 'tabla1');
}

/***************FIN PROGRAMACION ADVERTENCIA EN MENSAJERIA***************/

/*******************************************FIN INTERFASES*******************************************/


/*FIN DESPLIEGUE*/
$MiTemplate->pparse("OUT_H", array("header"), false);

$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer_operaciones.php';
?>
