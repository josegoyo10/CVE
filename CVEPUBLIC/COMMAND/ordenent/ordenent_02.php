<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
	

///////////////////////// ZONA DE ACCIONES /////////////////////////
$interno=$_REQUEST['numinterno'];
if ($accion == 'grabar') {
	$arr_dir = split(',', $_POST['tupla_dir_mod']);
	foreach($arr_dir as $key=>$value){
		//Grabamos cada dirección
		if($value) {
			$List = new connlist;
			$iDireccion = new dtodireccion;
			$iDireccion->id_direccion = $value;
			$iDireccion->id_comuna = $_POST['select_comunasd_'.$value];
			$iDireccion->rut = $_POST['rut_'.$value];
			$iDireccion->descripcion = $_POST['descripcion_'.$value];
			$iDireccion->direccion = $_POST['direccion_'.$value];
			$iDireccion->contacto = $_POST['contacto_'.$value];
			$iDireccion->fonocontacto = $_POST['fonocontacto_'.$value];
			$iDireccion->email = $_POST['email_'.$value];
			$iDireccion->comentario = $_POST['comentario_'.$value];
			$List->addlast($iDireccion);
			if (!bizcve::putdirdesp($List)) 
				$mensaje_error = 'Problemas al modificar la direccion. Contactese con el administrador';			
		}
	}
}	

if ($accion == 'elidir') {
	$List = new connlist;
	$iDireccion = new dtodireccion;
	$iDireccion->rut =$_GET['rut'];
	$iDireccion->id_direccion =$_POST['id_direccion_elim'];
	$List->addlast($iDireccion);
	
	if (!bizcve::deldirdesp($List)) 
		$mensaje_error = 'Problemas al eliminar la direccion. Contactese con el administrador';
		
	?>
		<script>
			window.returnValue = '<?=$_POST['id_direccion_elim']._.$_REQUEST['numinterno']?>';
			window.close();
		</script>
	<?
}

if ($accion == 'usardir') {
	$arr_dir = split(',', $_POST['tupla_dir_mod']);
	foreach($arr_dir as $key=>$value){
		//Grabamos cada dirección
		if($value) {
			$List = new connlist;
			$iDireccion = new dtodireccion;
			$iDireccion->id_direccion = $value;
			$iDireccion->id_comuna = $_POST['select_comunasd_'.$value];
			$iDireccion->rut = $_POST['rut_'.$value];
			$iDireccion->descripcion = $_POST['descripcion_'.$value];
			$iDireccion->direccion = $_POST['direccion_'.$value];
			$iDireccion->contacto = $_POST['contacto_'.$value];
			$iDireccion->fonocontacto = $_POST['fonocontacto_'.$value];
			$iDireccion->email = $_POST['email_'.$value];
			$iDireccion->comentario = $_POST['comentario_'.$value];
			$List->addlast($iDireccion);
			if (!bizcve::putdirdesp($List)) 
				$mensaje_error = 'Problemas al modificar la direccion. Contactese con el administrador';			
		}
	}
	?>
		<script>
			window.returnValue = '<?=$_POST['id_direccion_elim']._.$_POST['numinterno']?>';
			window.close();
		</script>
	<?
}

if ($accion == 'adddir') {
	$List = new connlist;
	$iDireccion = new dtodireccion;
	$iDireccion->rut =$_GET['rut'];
	$List->addlast($iDireccion);
	if (!bizcve::putdirdesp($List)) 
		$mensaje_error = 'Problemas al agregar la nueva direccion. Contactese con el administrador';
}


///////////////////////// ZONA DE DESPLIEGUE /////////////////////////


$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

/*Inclusi?n de header*/
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header_sc.htm");
$MiTemplate->set_var('error_app', $mensaje_error);
/**/

/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "ordenent/ordenent_02.htm");
$MiTemplate->set_file("bloque_comunad", TEMPLATE . "ordenent/ordenent_022.htm");
$MiTemplate->set_var('item', $_REQUEST['item']);
$MiTemplate->set_var('numinterno', $numinterno);
/**/
/*Solicitud de Comunas y ciudades*/
$ListCo = new connlist;
bizcve::getcomuna($ListCo);  
$ListCo->gofirst();   
if (!$ListCo->isvoid()) {
	$MiTemplate->set_block('main' , "comunas" , "BLO_comunas");
	do {
		$MiTemplate->set_var('id_comuna', $ListCo->getelem()->id_comuna);
		$MiTemplate->set_var('nomcomuna', $ListCo->getelem()->nomcomuna);
		$MiTemplate->set_var('nomciudadl', $ListCo->getelem()->nomciudad);
		if($id_comunainter == $ListCo->getelem()->id_comuna)
			$MiTemplate->set_var('selected', "selected");
		else
			$MiTemplate->set_var('selected', "");
		
		$MiTemplate->parse("BLO_comunas", "comunas", true);	
	} while ($ListCo->gonext());
}
/*Fin solicitud comunas y ciudades*/

/*Despliegue Solicitud comunas de despacho*/

$List  = new connlist;

bizcve::getcomunad($List);

$List->gofirst();

$MiTemplate->set_block('main' , "comunasd" , "BLO_comunasd");

if (!$List->isvoid()) {

       do {

             $MiTemplate->set_var('id_comunad', $List->getelem()->id_comunad);

             $MiTemplate->set_var('nomcomunad', $List->getelem()->nomcomunad);

             $MiTemplate->set_var('selected', ($_POST['select_comunasd'] == $List->getelem()->id_comunad)?'selected':'');


        $MiTemplate->parse("BLO_comunasd", "comunasd", true);     

       } while ($List->gonext());

}


/*Fin Despliegue Comunas de despacho*/


/*Despliegue direcciones despacho*/
$List  = new connlist;
$rut=$_GET['rut'];
$mRegistro->rut=$rut;
$List->addlast($mRegistro);

bizcve::getdirdesp($List);  
$List->gofirst();   

$MiTemplate->set_block('main' , "direcciones" , "BLO_direcciones");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('id_direccion', $List->getelem()->id_direccion);
		$MiTemplate->set_var('descripcion', $List->getelem()->descripcion);
		$MiTemplate->set_var('direccion', $List->getelem()->direccion);
		$MiTemplate->set_var('contacto', $List->getelem()->contacto);
		$MiTemplate->set_var('fonocontacto', $List->getelem()->fonocontacto);
		$MiTemplate->set_var('email', $List->getelem()->email);
		$MiTemplate->set_var('comentario', $List->getelem()->comentario);
		
		$comunad=  $List->getelem()->id_comuna;
		/*VERIFICO OE ASOCIADAS A ID_DIRECCION*/
		$ListEnc  = new connlist;
		$ListDet = new connlist;
		$mRegistroa = new dtoencordenent;
		$id_direccion=$List->getelem()->id_direccion;
		$mRegistroa->id_direccion=$id_direccion;
		
		$ListEnc->addlast($mRegistroa);
		bizcve::getordenent($ListEnc, $ListDet);
		$numa=$ListEnc->numelem();
		$MiTemplate->set_var('num_elem_oe', $numa);
		
		/*VERIFICO OP ASOCIADAS A ID_DIRECCION*/
		
		$ListEnc  = new connlist;
		$ListDet = new connlist;
		$mRegistrob = new dtoencordenpicking;
		$id_direccion=$List->getelem()->id_direccion;
		$mRegistrob->id_direccion=$id_direccion;
		
		$ListEnc->addlast($mRegistrob);
		bizcve::getordenpick($ListEnc, $ListDet);
		$numb=$ListEnc->numelem();
		$MiTemplate->set_var('num_elem_op', $numb);

		
		$Lista= new connlist;
		
		bizcve::getcomunad($Lista);
		
			$Lista->gofirst();
			$MiTemplate->unset_var("bloque_comunad");
			$MiTemplate->unset_var("BLO_comunasd");
			$MiTemplate->set_block('bloque_comunad' , "comunasd" , "BLO_comunasd");
		
			if (!$Lista->isvoid()) {
		       do {
					$MiTemplate->set_var('id_comunad', $Lista->getelem()->id_comunad);
		            $MiTemplate->set_var('nomcomunad', $Lista->getelem()->nomcomunad);
		            $MiTemplate->set_var('selected_comunad', ($comunad == ($Lista->getelem()->id_comunad)+0)?'selected':'');
		
		      		$MiTemplate->parse("BLO_comunasd", "comunasd", true);     
				  } while ($Lista->gonext());
		
			}

		$MiTemplate->parse("BLO_direcciones", "direcciones", true);	
	} while ($List->gonext());	
}

/*Fin despliegue direcciones de despacho*/

$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");


///////////////////////// ZONA PIE DE PAGINA /////////////////////////
?>
