<?php

///////////////////////// ZONA DE INCLUSION /////////////////////////

$pag_ini = '../monitorctevendedor/monitor_vendedor.php';

include_once("../../INCLUDE/ini.php");

include_once("../../INCLUDE/autoload.php");

include_once("../../INCLUDE/aplication_top.php");

       

///////////////////////// ZONA DE ACCIONES /////////////////////////

 

//Consultamos si el cliente existe previamente

$List  = new connlist;

$mRegistro->rut=$_GET['rut'];

$List->addlast($mRegistro);

bizcve::getdatosbasicos($List);

if (!$List->numelem()){

       //Creamos el nuevo cliente antes de continuar

       $iClientes = new dtoinfocliente;

       $iClientes->rut =$_GET['rut'];

       $List->addlast($iClientes);

       if (!bizcve::putCliente($List))

             $mensaje_error = 'Problemas al grabar el cliente. Contactese con el administrador';

       

       general::writeevent('Se ha creado un nuevo cliente desde el monitor de vendedores con el siguiente rut: '.$_GET['rut']);

}

if ($accion == 'grabar') {

       $List = new connlist;

       $iClientes = new dtoinfocliente;

       $iClientes->rut =$_POST['rut'];

       $iClientes->razonsoc =$_POST['razonsoc'];

       $iClientes->fonocontacto =$_POST['fonocontactoe'];

       $iClientes->contacto =$_POST['contactoe'];

       $iClientes->email =$_POST['emaile'];

       $iClientes->direccion =$_POST['direccione'];

       $iClientes->id_comuna =$_POST['comunae'];
       
		if($_POST['select_giro']!='0'){
			$iClientes->giro =$_POST['nom_giro'];
			$iClientes->id_giro =$_POST['select_giro'];
		}
		else{
			$iClientes->giro =$List->getelem()->id_giro;		
		}

       $iClientes->comentario =$_POST['comentarios'];

       $iClientes->id_rubro =$_POST['select_rubro'];

       $iClientes->lockcve = (($_POST['valorbox1'])?1:0);

 

       $List->addlast($iClientes);

       if (!bizcve::putCliente($List))

             $mensaje_error = 'Problemas al grabar el cliente. Cont?ctese con el administrador';

 

       general::writeevent('Se han modificado los siguientes datos del cliente desde el monitor de vendedores:  Razon Social: '.

       $_POST['razonsoc'].' Actividad Econ&oacute;mica: '.$_POST['nom_giro'].' Tel&eacute;fono contacto: '.$_POST['fonocontactoe'].

       'contacto: '.$_POST['contactoe'].'email: '.$_POST['emaile'].'direccion: '.$_POST['direccione'].

       'comuna: '.$_POST['comunae'].'comentario: '.$_POST['comentarios'].'rubro: '.$_POST['select_rubro'].

       'Bloqueo CVE: '.$_POST['valorbox1']);

       

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

                    general::writeevent('Se han modificado los siguientes datos en la direccion de despacho del cliente desde el monitor de vendedores:  Numero direccion: '.

                    $value.' descripcion: '.$_POST['descripcion_'.$value].' direccion: '.$_POST['direccion_'.$value].

                    'contacto: '.$_POST['contacto_'.$value].'Tel&eacute;fono contacto: '.$_POST['fonocontacto_'.$value].

                    'email: '.$_POST['email_'.$value].'comentario: '.$_POST['comentario_'.$value]);

 

                    if (!bizcve::putdirdesp($List)) 

                           $mensaje_error = 'Problemas al modificar la dirección. Contáctese con el administrador';                   

             }

       }

       header("Location: monitor_vendedor.php");

}      

if ($accion == 'elidir') {

       $List = new connlist;

       $iDireccion = new dtodireccion;

       $iDireccion->rut =$_GET['rut'];

       $iDireccion->id_direccion =$_POST['id_direccion_elim'];

       $List->addlast($iDireccion);

       

       if (!bizcve::deldirdesp($List)) 

             $mensaje_error = 'Problemas al eliminar la dirección. Contáctese con el administrador';

       

       general::writeevent('Se ha eliminado la direccion N: '.$_POST['id_direccion_elim'].' del cliente con el rut: '.$_GET['rut']);

        $List = new connlist;

       $iClientes = new dtoinfocliente;

       $iClientes->rut =$_POST['rut'];

       $iClientes->razonsoc =$_POST['razonsoc'];

       $iClientes->fonocontacto =$_POST['fonocontactoe'];

       $iClientes->contacto =$_POST['contactoe'];

       $iClientes->email =$_POST['emaile'];

       $iClientes->direccion =$_POST['direccione'];

       $iClientes->id_comuna =$_POST['comunae'];
       
		if($_POST['select_giro']!='0'){
			$iClientes->giro =$_POST['nom_giro'];
			$iClientes->id_giro =$_POST['select_giro'];
		}
		else{
			$iClientes->giro =$List->getelem()->id_giro;		
		}

       $iClientes->comentario =$_POST['comentarios'];

       $iClientes->id_rubro =$_POST['select_rubro'];

       $iClientes->lockcve = (($_POST['valorbox1'])?1:0);

 

       $List->addlast($iClientes);

       if (!bizcve::putCliente($List))

             $mensaje_error = 'Problemas al grabar el cliente. Cont?ctese con el administrador';

 

       general::writeevent('Se han modificado los siguientes datos del cliente desde el monitor de vendedores:  Razon Social: '.

       $_POST['razonsoc'].' Actividad Econ&oacute;mica: '.$_POST['nom_giro'].' Tel&eacute;fono contacto: '.$_POST['fonocontactoe'].

       'contacto: '.$_POST['contactoe'].'email: '.$_POST['emaile'].'direccion: '.$_POST['direccione'].

       'comuna: '.$_POST['comunae'].'comentario: '.$_POST['comentarios'].'rubro: '.$_POST['select_rubro'].

       'Bloqueo CVE: '.$_POST['valorbox1']);
       
       header("Location: monitor_vendedor_01.php?rut=".$_POST['rut']);
}

if ($accion == 'adddir') {

       $List = new connlist;

       $iDireccion = new dtodireccion;

       $iDireccion->rut =$_GET['rut'];

       $List->addlast($iDireccion);

       if (!bizcve::putdirdesp($List)) 

             $mensaje_error = 'Problemas al agregar la nueva dirección. Contáctese con el administrador';

 

       general::writeevent('Se ha agregado una nueva direccin al rut: '.$_GET['rut']);

        $List = new connlist;

       $iClientes = new dtoinfocliente;

       $iClientes->rut =$_POST['rut'];

       $iClientes->razonsoc =$_POST['razonsoc'];

       $iClientes->fonocontacto =$_POST['fonocontactoe'];

       $iClientes->contacto =$_POST['contactoe'];

       $iClientes->email =$_POST['emaile'];

       $iClientes->direccion =$_POST['direccione'];

       $iClientes->id_comuna =$_POST['comunae'];
       
		if($_POST['select_giro']!='0'){
			$iClientes->giro =$_POST['nom_giro'];
			$iClientes->id_giro =$_POST['select_giro'];
		}
		else{
			$iClientes->giro =$List->getelem()->id_giro;		
		}

       $iClientes->comentario =$_POST['comentarios'];

       $iClientes->id_rubro =$_POST['select_rubro'];
       
       
       $iClientes->lockcve = (($_POST['valorbox1'])?1:0);

       $List->addlast($iClientes);

       if (!bizcve::putCliente($List))

             $mensaje_error = 'Problemas al grabar el cliente. Cont?ctese con el administrador';

 

       general::writeevent('Se han modificado los siguientes datos del cliente desde el monitor de vendedores:  Razon Social: '.

       $_POST['razonsoc'].' giro: '.$_POST['descripcion_giro'].' Tel&eacute;fono contacto: '.$_POST['fonocontactoe'].

       'contacto: '.$_POST['contactoe'].'email: '.$_POST['emaile'].'direccion: '.$_POST['direccione'].

       'comuna: '.$_POST['comunae'].'comentario: '.$_POST['comentarios'].'rubro: '.$_POST['select_rubro'].

       'Bloqueo CVE: '.$_POST['valorbox1']);
       
       header("Location: monitor_vendedor_01.php?rut=".$_POST['rut']);
}

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

 

$MiTemplate = new template;

$MiTemplate->set_var("TITULO", TITULO);

 

/*Inclusi?n de header*/

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");

$MiTemplate->set_var('error_app', $mensaje_error);

 

/* Inclusi?n de main*/

$MiTemplate->set_file("main", TEMPLATE . "monitorctevendedor/monitor_vendedor_01.htm");
$MiTemplate->set_file("bloque_comunad", TEMPLATE . "monitorctevendedor/monitor_vendedor_011.htm");
 

/*Despliegue de Datos de Cliente*/

$List  = new connlist;

$rut=$_GET['rut'];

 

$mRegistro->rut=$rut;

$List->addlast($mRegistro);

//$idrubro=$_GET['id_rubro'];

/*cuando no tiene codigo de vendedor  asignado, problema si es tipousuario 1*/
if ($ses_usr_codvendedor)
	$mRegistro->codigovendedor=$ses_usr_codvendedor;
else
	$mRegistro->codigovendedor=0;

$List->addlast($mRegistro);

 

bizcve::getCliente($List);

$List->gofirst();

 

$rutcteencontrado = -1; 

 

if (!$List->isvoid()) {

       $MiTemplate->set_var('rut',$List->getelem()->rut);

       $rutcteencontrado = $List->getelem()->rut;

       $MiTemplate->set_var('rutdv',(($List->getelem()->id_contribuyente == 2)?$rut.'-'.general::digiVer($rut) : $rut ));

       $MiTemplate->set_var('razonsoc', $List->getelem()->razonsoc);

       $MiTemplate->set_var('nom_giro', $List->getelem()->giro);

       $MiTemplate->set_var('fonocontactoe', $List->getelem()->fonocontacto);
       $fonocontacto=$List->getelem()->fonocontacto;

       $MiTemplate->set_var('contactoe', $List->getelem()->contacto);
       $contacto=$List->getelem()->contacto;

       $MiTemplate->set_var('nomciudade', $List->getelem()->nomciudad);

       $MiTemplate->set_var('emaile', $List->getelem()->email);
	   $emaile=$List->getelem()->email;
	   
       $MiTemplate->set_var('direccione', $List->getelem()->direccion);

       $MiTemplate->set_var('id_comuna', $List->getelem()->id_comuna);
       
       $MiTemplate->set_var('id_comuna2', $List->getelem()->id_comuna);

	   $comuna=$List->getelem()->id_comuna;

       $id_comunainter = $List->getelem()->id_comuna;

       $MiTemplate->set_var('nomcomuna', $List->getelem()->nomcomuna);

       $MiTemplate->set_var('id_ciudad', $List->getelem()->id_ciudad);

       $MiTemplate->set_var('nomrubro', $List->getelem()->nomrubro);

       $MiTemplate->set_var('id_rubro', $List->getelem()->id_rubro);
       
		$rubroencontrado=$List->getelem()->id_rubro;
      	$MiTemplate->set_var('id_giro2', $List->getelem()->id_giro);       
		$giro= $List->getelem()->id_giro;
       
       $MiTemplate->set_var('comentarios',$List->getelem()->comentario);

       $MiTemplate->set_var('disponible', number_format(bizcve::getdisponible($List)));

	   if ($List->getelem()->id_rubro='')
	   	$MiTemplate->set_var('selectedt','selected');

	if($List->getelem()->id_tipocliente==1){
		if($List->getelem()->razonsoc===' '||$List->getelem()->razonsoc!=null){
			$MiTemplate->set_var('deshabilitadorazonsoc','');
		}
		else{
			$MiTemplate->set_var('deshabilitado','disabled');
			$MiTemplate->set_var('deshabilitadorazonsoc','disabled');
		}
	if($List->getelem()->direccion===' '||$List->getelem()->direccion!=null){
			$MiTemplate->set_var('deshabilitadodireccione','');
		}
		else{
			$MiTemplate->set_var('deshabilitado','disabled');
			$MiTemplate->set_var('deshabilitadodireccione','disabled');
		}
	if(($comuna===' ')||($comuna==null)){
			$MiTemplate->set_var('deshabilitadocomunae','');
		}
		else{
			$MiTemplate->set_var('deshabilitado','disabled');
			$MiTemplate->set_var('deshabilitadocomunae','disabled');
		}
	if($List->getelem()->giro==null||$List->getelem()->giro===' '){
			$MiTemplate->set_var('deshabilitadogiroe','');
		}
		else{
			$MiTemplate->set_var('deshabilitado','disabled');
			$MiTemplate->set_var('deshabilitadogiroe','disabled');
		}
	if(($giro===' ')||($giro==null)){
			$MiTemplate->set_var('deshabilitadoselectgiroe','');
		}
		else{
			$MiTemplate->set_var('deshabilitado','disabled');
			$MiTemplate->set_var('deshabilitadoselectgiroe','disabled');
		}
    if((!$List->getelem()->fonocontacto)||($List->getelem()->fonocontacto!==' ')){
                $MiTemplate->set_var('deshabilitadofonocontactoe','');
        }else{
            $MiTemplate->set_var('deshabilitado','disabled');
            $MiTemplate->set_var('deshabilitadofonocontactoe','disabled');
        }
		if($contacto === ' '||$contacto==null){
			$MiTemplate->set_var('deshabilitadocontactoe','');
	}
		else{
			$MiTemplate->set_var('deshabilitado','disabled');
			$MiTemplate->set_var('deshabilitadocontactoe','disabled');
		}
	if((!$List->getelem()->email)||($List->getelem()->email!==' ')){
			$MiTemplate->set_var('deshabilitadoemaile','');
    }else{
			$MiTemplate->set_var('deshabilitado','disabled');
			$MiTemplate->set_var('deshabilitadoemaile','disabled');
		}
		
	}

       $MiTemplate->set_var('id_tipocliente', $List->getelem()->id_tipocliente);

       $MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente);

       $MiTemplate->set_var('vendedor', $List->getelem()->vendedor);

       if($List->getelem()->locksap){

       $MiTemplate->set_var('locksap', '<li>Cliente bloqueado en SAP</li>');

       }

       if($List->getelem()->lockmoro){

       $MiTemplate->set_var('lockmoro', '<li>Cliente bloqueado por Morosidad</li>');

       }

       if($List->getelem()->lockcve){

       $MiTemplate->set_var('lockcve', '<li>Cliente Bloqueado en CVE</li>');

       $MiTemplate->set_var('checked2', 'checked');

       }

       if($List->getelem()->lockfecha){

       $MiTemplate->set_var('lockfecha', '<li>Cliente Bloqueado por vencimiento de Disponible</li>');

       }

}

else {

       general::alert('El cliente no existe o no esta asignado a su cartera');

       general::location('monitor_vendedor.php');

       exit();

}

/*FinDespliegue de Datos de Cliente*/

/*Despliegue Selección Giro*/

$List  = new connlist;

bizcve::getgiro($List);

$List->gofirst();

$MiTemplate->set_block('main' , "giro" , "BLO_giro");

if (!$List->isvoid()) {

       do {

             $MiTemplate->set_var('id_giro', $List->getelem()->id);

             $MiTemplate->set_var('descripcion_giro', $List->getelem()->nombre);

             $MiTemplate->set_var('selected', ($_POST['descripcion_giro'] == $List->getelem()->id)?'selected':'');

             if($List->getelem()->id==$giro)

	$MiTemplate->set_var('selected','selected');

        $MiTemplate->parse("BLO_giro", "giro", true);     

       } while ($List->gonext());

}


/*Fin Despliegue Selección Giro*/

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

/*Despliegue Filtro Rubro*/

$List  = new connlist;

bizcve::getrubro($List);

$List->gofirst();

$MiTemplate->set_block('main' , "rubro" , "BLO_rubro");

if (!$List->isvoid()) {

	do {

		$MiTemplate->set_var('id', $List->getelem()->id);

		$MiTemplate->set_var('nombre', $List->getelem()->nombre);

		
		$MiTemplate->set_var('selected_rubro', ($rubroencontrado == $List->getelem()->id)?'selected':'');

		$MiTemplate->parse("BLO_rubro", "rubro", true);     

       } while ($List->gonext());

}


$List  = new connlist;

$rut=$_GET['rut'];

$mRegistro->rut=$rutcteencontrado;

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

		$ListCo->gofirst();   
		if (!$ListCo->isvoid()) {
			do {
				$selected = ($List->getelem()->id_comuna == $ListCo->getelem()->id_comuna)?"selected":"";
				$comunaselect .= "<option value=".$ListCo->getelem()->id_comuna." $selected>".$ListCo->getelem()->nomcomuna."</option>";
			} while ($ListCo->gonext());
		}
		
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

include '../menu/menu.php';

include '../menu/footer.php';

 

?>

