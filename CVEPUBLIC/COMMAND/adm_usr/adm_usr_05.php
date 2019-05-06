<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
$bd = $_SESSION["DBACESS"];
/*si tiene local asignado no puede administrar perfiles*/
if ($ses_usr_codlocal){
    general::writeevent('No puede administrar perfiles, tiene local asignado'); 
	header( "Location: ../start/sin_perm_01.php");	
	exit();
}
function form_1( $bd,$id_perfil ) {
	global $ses_usr_id;
	$MiTemplate = new template;
	$MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("TEXT_TITULO","Administracion de perfiles y usuarios  ");
    $MiTemplate->set_var("SUBTITULO1","Modulos en el sistema");
    $MiTemplate->set_var("ID_PERFIL",$id_perfil);    
    $query = "select per_nombre, per_descripcion from perfiles where per_id = $id_perfil";
	$res = $bd->query($query);
	while ($row = $res->fetch_assoc()){
		$MiTemplate->set_var("per_nombre",$row['per_nombre']);
		$MiTemplate->set_var("per_descripcion",$row['per_descripcion']);
	}


      //Agrego la validacion de solo lectura para el perfil a modificar  
      $query = "select solo_lectura from perfiles where per_id = $id_perfil";
      $res = $bd->query($query);
      $row = $res->fetch_assoc();
      if ($row['solo_lectura'] == 1){
           $MiTemplate->set_var("solo_lectura",'checked'); 
      }else{
          $MiTemplate->set_var("solo_lectura",''); 
      }

    // Revisamos si se puede eliminar el perfil
    $query_1 = "select count(*) as cont from perfiles where per_padre = $id_perfil";
	$res = $bd->query($query_1);
	while ($row = $res->fetch_assoc()){	
		$items =$row['cont'];
	}	

    $query_1 = "select count(*) as cont from perfilesxusuario where peus_per_id = $id_perfil";
   	$res = $bd->query($query_1);
	while ($row = $res->fetch_assoc()){	   	
	    $items += $row['cont'];
	}    

    if( $items >0 ) {
        $msg = "No se permite eliminar este perfil, debido a que tiene perfiles o usuarios asociados.";
    }
    else {
        // recuperamos el perfil anterior al que vamos a eliminar
        $query_1 = "select per_padre from perfiles where per_id = $id_perfil";
		$res = $bd->query($query_1);
		while ($row = $res->fetch_assoc()){	
			$padre=$row['per_padre'];
		}	
		$msg = general::kid_href( 'javascript:validar_eliminar( "&#191;Esta seguro que desea eliminar el perfil&#63;", "adm_usr_05.php?action=delper&id_perfil='.$id_perfil.'&per_o='.$row['per_padre'].'" ); //', '', "Eliminar perfil.", "Eliminar perfil.", '' );
    }
    $MiTemplate->set_var("msg",$msg);
    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_usr/adm_usr_05_1.html");

    $MiTemplate->set_block("main", "Modulos", "PBLModulos");
    $query = "select pemo_mod_id, mod_nombre, if( mod_padre_id is null, '', '&nbsp;&nbsp;&nbsp;&nbsp;' ) as espacios from permisosxmodulo, modulos where pemo_tipo = 1 and pemo_mod_id = mod_id and pemo_per_id = $id_perfil order by mod_orden";
	$res = $bd->query($query);
    $num1=$bd->num_rows($query);
   	    
	$res = $bd->query($query);
    if( $num1 > 0 ) {
		$row = $res->fetch_assoc();
        $arr_k = array_keys ($row);
        $i = 0;
        $not_in = "";
        $tag = "";
	  	$res = $bd->query($query);
        
	    while ($row = $res->fetch_assoc()){
	        for( $i = 0; $i < sizeof( $arr_k ); $i++ ) {
	            $MiTemplate->set_var($arr_k[$i],$row[$arr_k[$i]]);
	        }	
            $MiTemplate->parse("PBLModulos", "Modulos", true);
            $not_in .= $tag . $row['pemo_mod_id'];
            if( $tag == "" )
                $tag = ", ";
            $i++;
        }
    }
    $not_in .= $tag . "-1";
    
    $query = "select mod_id as pemo_mod_id, mod_nombre, if( mod_padre_id is null, '', '&nbsp;&nbsp;&nbsp;&nbsp;' ) as espacios from modulos where mod_id not in ( $not_in ) order by mod_orden";
	$res = $bd->query($query);
    $MiTemplate->set_block("main", "Modulos_na", "PBLModulos_na");
    while ($row = $res->fetch_assoc()){
		$MiTemplate->set_var("pemo_mod_id",$row['pemo_mod_id']);
		$MiTemplate->set_var("mod_nombre",$row['mod_nombre']);		
		$MiTemplate->set_var("espacios",$row['espacios']);			
   	   	$MiTemplate->parse("PBLModulos_na", "Modulos_na", true);
  	}

    ///////////////////// ZONA PIE DE PAGINA /////////////////////////	
	$MiTemplate->parse("OUT_M", array("main"), true);
	$MiTemplate->p("OUT_M");
}

function update_perfil( $bd,$nombre_in, $descripcion_in, $id_perfil, $lectura_in ) {
    global $ses_usr_id;

    if(!bizcve::verificacionDePermisos($ses_usr_id,1, 'UPDATE')){
        general::alertexit('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }

	$usr_nombre =general::get_nombre_usr( $ses_usr_id );
    $query_1 = "update perfiles set per_nombre = '$nombre_in', per_descripcion = '$descripcion_in', per_usr_mod = '$usr_nombre', per_fec_mod = now() where per_id = $id_perfil";

    bizcve::setevento(8, 'Modulo Perfiles', $_SERVER['REMOTE_ADDR'], 'ABM perfil',
                    ' Modificacion del perfil : '.$nombre_in.'','','Modificacion de Perfil', $usr_nombre );

    general::writeevent('Se ha modificado la tabla perfiles');
    if(!$lectura_in)$lectura_in = 0;
    $query_1 = "update perfiles set per_nombre = '$nombre_in', per_descripcion = '$descripcion_in', per_usr_mod = '$usr_nombre', per_fec_mod = now(), solo_lectura = '$lectura_in' where per_id = $id_perfil";
    $res = $bd->query($query_1);
	$MiTemplate = new template;
	$MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("ID_PADRE",$id_perfil);

    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_usr/adm_usr_03_2.html");

    $MiTemplate->parse("OUT_M", array("main"), true);
    $MiTemplate->p("OUT_M");

}

function update_permisos($id_perfil){
    $query_1="UPDATE permisosxmodulo
                set 
                    PEMO_INSERT = 0,
                    PEMO_DELETE = 0,
                    PEMO_UPDATE = 0
                where
                    PEMO_PER_ID = '$id_perfil';"; 
    $res = $bd->query($query_1);
}
function delete_perfil( $bd,$id_perfil, $per_o ) {
    global $ses_usr_id;

    if(!bizcve::verificacionDePermisos($ses_usr_id,1, 'DELETE')){
        general::alertexit('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }
    $usr_nombre =general::get_nombre_usr( $ses_usr_id );
    $query_1 = "delete from perfiles where per_id = $id_perfil";
   	$res = $bd->query($query_1);;
    general::writeevent('Se ha eliminado un perfil de la tabla perfil'); 		
    $query_1 = "delete from permisosxmodulo where pemo_tipo = 1 & pemo_per_id = $id_perfil";
   	$res = $bd->query($query_1);

    bizcve::setevento(11, 'Modulo Perfiles', $_SERVER['REMOTE_ADDR'], 'ABM perfil',
                    'Eliminacion del perfil : '.$id_perfil.'','','Baja de Perfil', $usr_nombre );

    general::writeevent('Se ha eliminado un modulo y un permiso de la tabla permisosxmodulo'); 		
    
	$MiTemplate = new template;
    $MiTemplate->set_var("ID_PADRE",$per_o);
    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_usr/adm_usr_03_2.html");
    $MiTemplate->parse("OUT_M", array("main"), true);
    $MiTemplate->p("OUT_M");

}

function desasociar_modulo( $bd,$id_perfil, $pemo_mod_id ) {

    global $ses_usr_id;

    $usr_nombre = general::get_nombre_usr( $ses_usr_id );

    if(!bizcve::verificacionDePermisos($ses_usr_id,1, 'DELETE')){
        general::alertexit('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }    

    bizcve::setevento(10, 'Modulo Perfiles', $_SERVER['REMOTE_ADDR'], 'ABM perfil',
                    'Se eliminan modulos al perfil '.$id_perfil.'','','Perfil '.$id_perfil.' modificado', $usr_nombre );


    $query_1 = "delete from permisosxmodulo where pemo_tipo = 1 and pemo_per_id = $id_perfil and pemo_mod_id = $pemo_mod_id";
    $res = $bd->query($query_1);
    general::writeevent('Se ha desasociado  un modulo de la tabla permisosxmodulo'); 		
    header( "Location: adm_usr_05.php?id_perfil=$id_perfil" );
    exit();
}

function form_asociar_modulo( $bd,$id_perfil, $pemo_mod_id, $action ) {
	$MiTemplate = new template;
	$MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("TEXT_TITULO","Administracion de usuarios");
    $MiTemplate->set_var("ID_PERFIL",$id_perfil);
    $MiTemplate->set_var("PEMO_MOD_ID",$pemo_mod_id);
    if( $action == "f_asociar" ) {
        $MiTemplate->set_var("BOTON","Asociar");
        $MiTemplate->set_var("ACTION",'asociar_mod');
             //Valido que el perfil no sea de solo lectura, sino no permito el ABM
      $query = "select solo_lectura from perfiles where per_id = $id_perfil";
      $res = $bd->query($query);
      $row = $res->fetch_assoc();
      if($row['solo_lectura']==1)
    {
        $MiTemplate->set_var("ch1",' disabled');
        $MiTemplate->set_var("ch2",' disabled');
        $MiTemplate->set_var("ch3",' disabled');
    }
  
    }

    else {
        $MiTemplate->set_var("BOTON","Modificar");
        $MiTemplate->set_var("ACTION",'mod_asociar_mod');

             //Valido que el perfil no sea de solo lectura, sino no permito el ABM
      $query = "select solo_lectura from perfiles where per_id = $id_perfil";
      $res = $bd->query($query);
      $row = $res->fetch_assoc();
      if($row['solo_lectura']==1)
    {
        $MiTemplate->set_var("ch1",' disabled');
        $MiTemplate->set_var("ch2",' disabled');
        $MiTemplate->set_var("ch3",' disabled');
    }
    else
    { 
   
        $query = "select pemo_insert, pemo_update, pemo_delete, pemo_select from permisosxmodulo where pemo_tipo = 1 and pemo_mod_id = $pemo_mod_id and pemo_per_id = $id_perfil";
        $res = $bd->query($query);
        while ($row = $res->fetch_assoc()){
            if( $row['pemo_insert'] == 1 ) $MiTemplate->set_var("ch1",'checked');
            if( $row['pemo_delete'] == 1 ) $MiTemplate->set_var("ch2",'checked');
            if( $row['pemo_update'] == 1 ) $MiTemplate->set_var("ch3",'checked');	
        }
    }
    
    }
    $query = "select per_nombre from perfiles where per_id = $id_perfil";
		$res = $bd->query($query);
		while ($row = $res->fetch_assoc()){
			$MiTemplate->set_var("per_nombre",$row['per_nombre']);	
		}

    $query = "select mod_nombre from modulos where mod_id = $pemo_mod_id";
		$res = $bd->query($query);
		while ($row = $res->fetch_assoc()){
			$MiTemplate->set_var("mod_nombre",$row['mod_nombre']);	
		}

    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_usr/adm_usr_05_2.html");

    $MiTemplate->parse("OUT_M", array("main"), true);
    $MiTemplate->p("OUT_M");
}

function asociar_modulo($bd, $id_perfil, $pemo_mod_id ) {
    global $ses_usr_id;
    global $insert_in, $delete_in, $update_in, $select_in;
    $usr_nombre = general::get_nombre_usr( $ses_usr_id );

    if(!bizcve::verificacionDePermisos($ses_usr_id,1, 'DELETE')){
        general::alertexit('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }    

    bizcve::setevento(9, 'Modulo Perfiles', $_SERVER['REMOTE_ADDR'], 'ABM perfil',
                    'Se asignan modulos al perfil '.$id_perfil.'','','Perfil '.$id_perfil.' modificado', $usr_nombre );

    if( $insert_in == '' )
        $insert_in = 0;
    if( $delete_in == '' )
        $delete_in = 0;
    if( $update_in == '' )
        $update_in = 0;
    if( $select_in == '' )
        $select_in = 0;

    $query_1 = "insert into permisosxmodulo( pemo_per_id, pemo_mod_id, pemo_tipo, pemo_insert, pemo_delete, pemo_update, pemo_select, pemo_usr_crea, pemo_fec_crea ) values ( $id_perfil, $pemo_mod_id, 1, $insert_in, $delete_in, $update_in, $select_in, '$usr_nombre', now() )";
	$res = $bd->query($query_1);
    header( "Location: adm_usr_05.php?id_perfil=$id_perfil" );
    exit();
}

function mod_asociar_modulo( $bd,$id_perfil, $pemo_mod_id ) {
    global $ses_usr_id;
    global $insert_in, $delete_in, $update_in, $select_in;
	$usr_nombre =general::get_nombre_usr( $ses_usr_id );
    if( $insert_in == '' )
        $insert_in = 0;
    if( $delete_in == '' )
        $delete_in = 0;
    if( $update_in == '' )
        $update_in = 0;
    if( $select_in == '' )
        $select_in = 0;

    $query_1 = "update permisosxmodulo set pemo_insert = $insert_in, pemo_update = $update_in, pemo_delete = $delete_in, pemo_select = $select_in, pemo_usr_mod = '$usr_nombre', pemo_fec_mod = now() where pemo_per_id = $id_perfil and pemo_mod_id = $pemo_mod_id and pemo_tipo = 1";
  	$res = $bd->query($query_1);
    general::writeevent('Se ha modificado la tabla  permisosxmodulo');
  	header( "Location: adm_usr_05.php?id_perfil=$id_perfil" );
    exit();
}

/**********************************************************************************************/

if( $action == 'updper' )
    if(!bizcve::verificacionDePermisos($ses_usr_id,1, 'UPDATE')){
        general::alert('No tiene permisos para ejecutar la funcionalidad solicitada');     
    }else{
    update_perfil( $bd,$nombre_in, $descripcion_in, $id_perfil, $lectura_in );
    }
else if( $action == 'delper' )
    if(!bizcve::verificacionDePermisos($ses_usr_id,1, 'DELETE')){
        general::alert('No tiene permisos para ejecutar la funcionalidad solicitada');     
    }else{
    delete_perfil( $bd,$id_perfil, $per_o );
    }
else if( $action == 'f_asociar' )
    form_asociar_modulo( $bd,$id_perfil, $pemo_mod_id, $action );
else if( $action == 'f_mod_asociar' )
    form_asociar_modulo($bd, $id_perfil, $pemo_mod_id, $action );
else if( $action == 'asociar_mod' )
    if(!bizcve::verificacionDePermisos($ses_usr_id,1, 'UPDATE')){
        general::alert('No tiene permisos para ejecutar la funcionalidad solicitada');     
    }else{
    asociar_modulo( $bd,$id_perfil, $pemo_mod_id );
	}
else if( $action == 'mod_asociar_mod' )
    if(!bizcve::verificacionDePermisos($ses_usr_id,1, 'UPDATE')){
        general::alert('No tiene permisos para ejecutar la funcionalidad solicitada');     
    }else{
        mod_asociar_modulo( $bd,$id_perfil, $pemo_mod_id );
        }
else if( $action == 'desasociar' )
    if(!bizcve::verificacionDePermisos($ses_usr_id,1, 'UPDATE')){
        general::alert('No tiene permisos para ejecutar la funcionalidad solicitada');     
    }else{
        desasociar_modulo( $bd,$id_perfil, $pemo_mod_id );
        }
else
    form_1( $bd,$id_perfil );

/**********************************************************************************************/


?>