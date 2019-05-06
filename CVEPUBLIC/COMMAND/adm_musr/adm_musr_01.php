<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////


$bd = $_SESSION["DBACESS"];

/*si tiene local asignado no puede administrar usuarios*/
	if($ses_usr_codlocal){
		general::writelog('USR Tiene Local '.$ses_usr_codlocal.' - '.$ses_usr_nomlocal);
		//header( "Location: ../start/sin_perm_01.php");	
	}
	else{
		general::writelog('USR No local '.$ses_usr_codlocal.' - '.$_SESSION["ses_usr_codlocal"].' - '.$ses_usr_nomlocal);
	}


function listado_usuarios( $bd,$patron) {
	$MiTemplate = new template;
	$MiTemplate->set_var('error_app', $mensaje_error);
	$MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("TEXT_TITULO","Administracion de usuarios ");
    $MiTemplate->set_var("SUBTITULO1",TEXT_2);

    $MiTemplate->set_var("TEXT_1","Seleccione la accion a realizar desde la barra de herramientas o desde los usuarios.");
    $MiTemplate->set_var("TEXT_SUB_USUARIOS","Usuarios del sistema");
    $MiTemplate->set_var("TEXT_BUSCAR_CAMPO_1","Usuario a Buscar");
    $MiTemplate->set_var("BOTON_BUSCAR_USUARIO","Buscar");
	$MiTemplate->set_var("BOTON_MODIFICAR_IMG", '<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >');    
    $MiTemplate->set_var("BOTON_ELIMINAR_IMG", '<IMG SRC="../../IMAGES/trash.png" BORDER=0 >');
	$MiTemplate->set_var("BOTON_AGREGAR_IMG", '<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >');    
    $MiTemplate->set_var("patron",$patron);
	/*para los botones*/
    $BOTON_MODIFICAR_IMG='<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >';
    $BOTON_ELIMINAR_IMG ='<IMG SRC="../../IMAGES/trash.png" BORDER=0 >';    
	$BOTON_AGREGAR_IMG	='<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >';    
	$BOTON_LISTAR_IMG   ='<IMG SRC="../../IMAGES/lista.png" HEIGHT="22" BORDER=0 >';
	$BOTON_VOLVER_IMG	='<IMG SRC="../../IMAGES/back.png" HEIGHT="22" BORDER=0 >';   
	$CONFIRM_ELIMINAR_USR='&#191; Est&#225 seguro que desea eliminar el Usuario&#63;';
    
    // Agregamos el header
	$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");

    // Agregamos la barra de herramientas
    if( general::se_puede( 'i', PERMISOS_MOD ) )
          $barra_her .= " " . general::kid_href( 'adm_musr_01.php', 'action=ins', $BOTON_AGREGAR_IMG, 'Agregar', '' );

    $barra_her .= " " . general::kid_href( 'adm_musr_01.php', 'action=ins', $BOTON_AGREGAR_IMG, 'Agregar', '' );          
          
    $MiTemplate->set_var("BARRA_HERRAMIENTAS",$barra_her);
    $MiTemplate->set_file("barra_her",TEMPLATE."presentacion/barra.html");
    $MiTemplate->parse("OUT_BARRA","barra_her");

    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_musr/listado.html");

    // Recuperamos los modulos de la base
	$MiTemplate->set_block('main' , "listadousuarios" , "BLO_listadousuarios");    
    if( $patron )
        $add_que = " and ( usr_login like '%$patron%' or usr_apellidos like '%$patron%' or usr_nombres like '%$patron%' )";
    $query = "	select usr_id, usr_login, case id_tipousuario when 1 then 'Vendedor Especialista' when 2 then concat('Ejecutivo De Venta (', codigovendedor, ')') when 3 then concat('Vendedor Socio Experto (', codigovendedor, ')') end tipousuario, CONCAT( usr_nombres, ' ', usr_apellidos ) as nom_com, cod_local
				from usuarios where usr_estado <> 2 $add_que 
				order by 3, 1, 4";
	$res = $bd->query($query);
	while ($row = $res->fetch_assoc()){
		for( $i = 0; $i < sizeof( $arr_k ); $i++ ) {
			$MiTemplate->set_var($arr_k[$i], $row[$arr_k[$i]] );
		}        	
		$MiTemplate->set_var("usr_login",$row['usr_login']);
		$MiTemplate->set_var("nom_com",$row['nom_com']);
		$MiTemplate->set_var("nom_tipo",$row['tipousuario']);
		$MiTemplate->set_var("cod_local",$row['cod_local']);
		
		if( general::se_puede( 'u', PERMISOS_MOD ) )
		$msg_aux = general::kid_href( 'adm_musr_01.php', "action=upd&usr_id=".$row['usr_id'], $BOTON_MODIFICAR_IMG, 'Modificar', '' ) . " ";
	
		$msg_aux = general::kid_href( 'adm_musr_01.php', "action=upd&usr_id=".$row['usr_id'], $BOTON_MODIFICAR_IMG, 'Modificar', '' ) . " ";
		if( general::se_puede( 'd', PERMISOS_MOD ) )
		$msg_aux .= general::kid_href( 'javascript:validar_eliminar( "'.$CONFIRM_ELIMINAR_USR.'", "adm_musr_01.php?action=del&usr_id='.$row['usr_id'].'" ); //', '', $BOTON_ELIMINAR_IMG, 'Eliminar', '' );
	
		$msg_aux .= general::kid_href( 'javascript:validar_eliminar( "'.$CONFIRM_ELIMINAR_USR.'", "adm_musr_01.php?action=del&usr_id='.$row['usr_id'].'" ); //', '', $BOTON_ELIMINAR_IMG, 'Eliminar', '' );                
	        
		$MiTemplate->set_var('ACCIONES',$msg_aux);
		$MiTemplate->parse("BLO_listadousuarios", "listadousuarios", true);	
	}
///////////////////////// ZONA PIE DE PAGINA /////////////////////////	
$MiTemplate->parse("OUT_M", array("header", "main"), true);
$MiTemplate->p("OUT_M");

}

function delete_usuario($bd, $usr_id ) {

	global $ses_usr_id;

    if(!bizcve::verificacionDePermisos($ses_usr_id,3, 'DELETE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }

	$usr_nombre =general::get_nombre_usr( $ses_usr_id );
	$usr_mod_nombre = general::get_nombre_usr($usr_id );		
    $query_1 = "delete from usuarios where usr_id = $usr_id";
   	$res = $bd->query($query_1);
    general::writeevent('Los datos del usuario '.$usr_id .' han sido Eliminados.');

    bizcve::setevento(7, 'Modulo Usuario', $_SERVER['REMOTE_ADDR'], 'ABM usuario',
                    'Baja del usuario : '.$usr_mod_nombre.' ','','Baja de Usuario', $usr_nombre );

    //general::writeevent('Los datos del usuario han sido Eliminados');  	
    header( "Location: adm_musr_01.php" );
    exit();
}

function form_usuarios($bd, $usr_id, $error ) {
	$MiTemplate = new template;
	$MiTemplate->set_var('error_app', $mensaje_error);
	$MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("TEXT_TITULO","Administracion de usuarios ");
    $MiTemplate->set_var("SUBTITULO1",TEXT_2);

    $MiTemplate->set_var("TEXT_1","Ingrese la informacion en los campos y luego presione agregar usuario.");
    $MiTemplate->set_var("TEXT_SUB_USUARIOS","Agregar Usuario");
    $MiTemplate->set_var("TEXT",TEXT_2);
    $MiTemplate->set_var("TEXT_SUB",TEXT_SUB_AGREGAR);
    $MiTemplate->set_var("BOTON",BOTON_USUARIO_AGREGAR);

    /*para los botones*/
    $BOTON_MODIFICAR_IMG='<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >';
    $BOTON_ELIMINAR_IMG ='<IMG SRC="../../IMAGES/trash.png" BORDER=0 >';    
	$BOTON_AGREGAR_IMG	='<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >';    
	$BOTON_LISTAR_IMG   ='<IMG SRC="../../IMAGES/lista.png" HEIGHT="22" BORDER=0 >';
	$BOTON_VOLVER_IMG	='<IMG SRC="../../IMAGES/back.png" HEIGHT="22" BORDER=0 >';
	
	$CONFIRM_ELIMINAR_USR='&#191; Est&#225 seguro que desea eliminar el perfil&#63;';
    if( $error == 1 )
        $MiTemplate->set_var("TEXT_ERROR","Ya existe este Usuario, ingrese Otro");

    // Agregamos el header
    $MiTemplate->set_file("header",TEMPLATE."presentacion/header.htm");

    // Agregamos la barra de herramientas
    $barra_her = general::kid_href( 'adm_musr_01.php', '', $BOTON_VOLVER_IMG, $BOTON_VOLVER, '' );
    if( general::se_puede( 'i', PERMISOS_MOD ) )
        $barra_her .= " " . general::kid_href( 'adm_musr_01.php', 'action=ins',$BOTON_AGREGAR_IMG, $TEXT_TAG_AGREGAR, '' );
    $MiTemplate->set_var("BARRA_HERRAMIENTAS",$barra_her);
    $MiTemplate->set_file("barra_her",TEMPLATE."presentacion/barra.html");
    $MiTemplate->parse("OUT_BARRA","barra_her");

    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_musr/form.html");

    //Recuperamos los Locales
    $MiTemplate->set_block("main", "Locales", "BLO_Loc");
    $queryL = "select l.cod_local, if(l.cod_local ='".$ses_usr_codlocal."', 'selected', '') as codselected,l.nom_local from locales l"; 
   	$res = $bd->query($queryL);
   	while ($row = $res->fetch_assoc()){
		$MiTemplate->set_var("cod_local",$row['cod_local']);
		$MiTemplate->set_var("codselected",$row['codselected']);		
		$MiTemplate->set_var("nom_local",$row['nom_local']);		
		$MiTemplate->parse("BLO_Loc", "Locales", true);	
	}
    
    //Recuperamos los tipos deusuario
    $MiTemplate->set_block("main", "Tipo_Usuario", "BLO_Tip");
    $queryT = "select id_tipousuario, descripcion from tipousuario "; 
   	$res = $bd->query($queryT);
	while ($row = $res->fetch_assoc()){
		$MiTemplate->set_var("id_tipousuario",$row['id_tipousuario']);
		$MiTemplate->set_var("nomtipousuario",$row['descripcion']);		
		$MiTemplate->parse("BLO_Tip", "Tipo_Usuario", true);	
	}
///////////////////////// ZONA PIE DE PAGINA /////////////////////////	
	$MiTemplate->parse("OUT_M", array("header", "main"), true);
	$MiTemplate->p("OUT_M");
}

function form_mod_usuarios($bd,$usr_id, $error ) {
	global $usr_nombres, $usr_apellidos,$tipousuario,$usr_email,$local, $usr_login, $usr_clave, $usr_estado,$codigovendedor;
	$MiTemplate = new template();
	$MiTemplate->set_var('error_app', $mensaje_error);
	$MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("TEXT_TITULO","Administracion de usuarios ");
    $MiTemplate->set_var("TEXT",'Modifique la informacion en los campos y luego presione Modificar usuario.');
    $MiTemplate->set_var("TEXT_SUB","Modificar usuario ");

    $MiTemplate->set_var("TEXT_ASOCIAR_CAMPO_1","Listar");
    $MiTemplate->set_var("TEXT_ASOCIAR_CAMPO_2","Agregar");
    $MiTemplate->set_var("TEXT_ASOCIAR_CAMPO_3","Eliminar");
    $MiTemplate->set_var("TEXT_ASOCIAR_CAMPO_4","Modificar");
    $MiTemplate->set_var("usr_id",$usr_id);
    /*para los botones*/
    $BOTON_MODIFICAR_IMG='<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >';
    $BOTON_ELIMINAR_IMG ='<IMG SRC="../../IMAGES/trash.png" BORDER=0 >';    
	$BOTON_AGREGAR_IMG	='<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >';    
	$BOTON_LISTAR_IMG   ='<IMG SRC="../../IMAGES/lista.png" HEIGHT="22" BORDER=0 >';
	$BOTON_VOLVER_IMG	='<IMG SRC="../../IMAGES/back.png" HEIGHT="22" BORDER=0 >';      
    if( $error == 1 )
        $MiTemplate->set_var("TEXT_ERROR",TEXT_CAMPO_EXISTE);

    // Agregamos el header
    $MiTemplate->set_file("header",TEMPLATE ."presentacion/header.htm");

    // Agregamos la barra de herramientas
    $barra_her = general::kid_href( 'adm_musr_01.php', '', $BOTON_VOLVER_IMG, $BOTON_VOLVER, '' );
    if( general::se_puede( 'i', PERMISOS_MOD ) )
        $barra_her .= " " . general::kid_href( 'adm_musr_01.php', 'action=ins', $BOTON_AGREGAR_IMG, 'Agregar', '' );
    $MiTemplate->set_var("BARRA_HERRAMIENTAS",$barra_her);
    $MiTemplate->set_file("barra_her",TEMPLATE ."presentacion/barra.html");
    $MiTemplate->parse("OUT_BARRA","barra_her");
	
    // Recuperamos los datos del usuario
    $query = "select usr_id,cod_local, id_tipousuario,codigovendedor,usr_nombres, usr_apellidos,
	 usr_email, usr_login, usr_clave, usr_estado from usuarios where usr_id = $usr_id";
    $res = $bd->query($query);
	while ($row = $res->fetch_assoc()){
        for( $i = 0; $i < sizeof( $arr_k ); $i++ ) {
            $MiTemplate->set_var($arr_k[$i],tohtml( $row[$arr_k[$i]] ));
        }		
		$MiTemplate->set_var("usr_id",$row['usr_id']);
		$MiTemplate->set_var("id_tipousuario",$row['id_tipousuario']);	
		//if($row['id_tipousuario']==1)
			//$MiTemplate->set_var("disabledcodigovendedor",'disabled');					
		$MiTemplate->set_var("codigovendedor",$row['codigovendedor']);			
		$MiTemplate->set_var("usr_nombres",$row['usr_nombres']);		
		$MiTemplate->set_var("usr_apellidos",$row['usr_apellidos']);			
		$MiTemplate->set_var("usr_email",$row['usr_email']);		
		$MiTemplate->set_var("usr_login",$row['usr_login']);	
		$MiTemplate->set_var("usr_estado",$row['usr_estado']);		
        if( $row['usr_estado'] == 0 ) {
            $MiTemplate->set_var('chec1','');
            $MiTemplate->set_var('chec2','checked');
        }
        else {
            $MiTemplate->set_var('chec1','checked');
            $MiTemplate->set_var('chec2','');
        }	
		 $cod_local  =$row['cod_local'];      	
		 $id_tipousuario  =$row['id_tipousuario']; 	
		 if ($id_tipousuario==2) {
			$MiTemplate->set_var("disabled",'false');		 	
		 }else{
				$MiTemplate->set_var("disabled",'true'); 	
		 }
	}
   

    // Obtenemos los datos de los modulos para las excepciones
    $query_1 = "select pemo_mod_id, pemo_insert, pemo_update, pemo_delete, pemo_select, mod_nombre from permisosxmodulo, modulos where pemo_tipo = 2 and pemo_mod_id = mod_id and pemo_per_id = $usr_id order by mod_orden";
    $res_1 = $bd->query($query_1);
    $i = 0;
    $not_in = "";
    $tag = "";
    while ($row = $res_1->fetch_assoc()){
        $arr_pemo[$i][0] = $row['pemo_mod_id'];
        $arr_pemo[$i][1] = $row['mod_nombre'];
        $arr_pemo[$i][2] = $row['pemo_insert'];
        $arr_pemo[$i][3] = $row['pemo_delete'];
        $arr_pemo[$i][4] = $row['pemo_update'];
        $arr_pemo[$i][5] = $row['pemo_select'];
        $not_in .= $tag . $row['pemo_mod_id'];
        if( $tag == "" )
            $tag = ", ";
        $i++;
    }
    $not_in .= $tag . "-1";
    $query_1 = "select mod_id, mod_nombre from modulos where mod_id not in ( $not_in ) order by mod_orden";
    $res_1 = $bd->query($query_1);
    $i = 0;
    while ($row = $res_1->fetch_assoc()){
        $arr_pemo_new[$i][0] =$row['mod_id'];
        $arr_pemo_new[$i][1] = $row['mod_nombre'];
        $i++;
    }
    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE ."adm_musr/form_mod.html");
	$MiTemplate->set_var("TEXT_SUB2",'Modulos asociados al usuario ');
    $MiTemplate->set_var("TEXT_SUB3",'Modulos no asociados al usuario ');

    $MiTemplate->set_block("main", "Modulos_a", "PBLModulos_a");
    if( sizeof( $arr_pemo ) > 0 ) {
        for( $i = 0; $i < sizeof( $arr_pemo ); $i++ ) {
            $MiTemplate->set_var('pemo_mod_id',$arr_pemo[$i][0]);
            $MiTemplate->set_var('mod_nombre',$arr_pemo[$i][1]);
            //general::writelog($arr_pemo[$i][0]." - ".$arr_pemo[$i][1]." CH1 ".$arr_pemo[$i][2]." CH2 ".$arr_pemo[$i][3]." CH3 ".$arr_pemo[$i][4] );
            if( $arr_pemo[$i][2] == 1 ) $MiTemplate->set_var('ch1','checked'); else $MiTemplate->set_var('ch1','');
            if( $arr_pemo[$i][3] == 1 ) $MiTemplate->set_var('ch2','checked'); else $MiTemplate->set_var('ch2','');
            if( $arr_pemo[$i][4] == 1 ) $MiTemplate->set_var('ch3','checked'); else $MiTemplate->set_var('ch3','');
            $MiTemplate->parse("PBLModulos_a", "Modulos_a", true);
        }
    }

    $MiTemplate->set_block("main", "Modulos_b", "PBLModulos_b");
    if( sizeof( $arr_pemo_new ) > 0 ) {
        for( $i = 0; $i < sizeof( $arr_pemo_new ); $i++ ) {
            $MiTemplate->set_var('pemo_mod_id',$arr_pemo_new[$i][0]);
            $MiTemplate->set_var('mod_nombre',$arr_pemo_new[$i][1]);
            $MiTemplate->parse("PBLModulos_b", "Modulos_b", true);
        }
    }

    //Recuperamos los Locales
    $MiTemplate->set_block("main", "Locales", "BLO_Loc");
    $queryL = "select l.cod_local, l.nom_local, if (l.cod_local='$cod_local', 'selected', '') as selected from locales l" ; 
    $res = $bd->query($queryL);
	while ($row = $res->fetch_assoc()){
		$MiTemplate->set_var("cod_local",$row['cod_local']);
		$MiTemplate->set_var("nom_local",$row['nom_local']);	
		$MiTemplate->set_var("selected",$row['selected']);				
		$MiTemplate->parse("BLO_Loc", "Locales", true);	
	} 
    //Recuperamos los tipos deusuario
    $MiTemplate->set_block("main", "Tipo_Usuario", "BLO_Tip");
    $queryT = "select id_tipousuario, descripcion ,if (id_tipousuario=$id_tipousuario, 'selected', '') as selectedtu from tipousuario "; 
    $res = $bd->query($queryT);
	while ($row = $res->fetch_assoc()){
		$MiTemplate->set_var("id_tipousuario",$row['id_tipousuario']);
		$MiTemplate->set_var("nomtipousuario",$row['descripcion']);	
		$MiTemplate->set_var("selectedtu",$row['selectedtu']);		
		$MiTemplate->parse("BLO_Tip", "Tipo_Usuario", true);	
	}
    // Agregamos el footer
	$MiTemplate->parse("OUT_M", array("header", "main"), true);
	$MiTemplate->p("OUT_M");
}

function insert_usuario($bd) {
	global $ses_usr_id, $ses_usr_codlocal,$usr_nombres, $usr_apellidos,$tipousuario,$usr_email,$local, $usr_login, $usr_clave, $usr_estado,$codigovendedor;

     if(!bizcve::verificacionDePermisos($ses_usr_id,3, 'INSERT')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada'); 
    }

    $contador = 0;
    $query_1 = "select count(*) as cont from usuarios where usr_login = '$usr_login' and usr_estado <> 2";
	$res = $bd->query($query_1);
	while ($row = $res->fetch_assoc()){
		    $contador = $row['cont'];
	}    
    if($local!='0'){
    	$ins_local="'".$local."'";
    	$columnas="usr_nombres, codigovendedor,usr_apellidos,id_tipousuario,usr_email,cod_local, usr_login, usr_clave,usr_estado, usr_tipo, usr_usr_crea, usr_fec_crea";
    	$values="'$usr_nombres','$codigovendedor', '$usr_apellidos', $tipousuario, '$usr_email',$ins_local, '$usr_login',md5('$usr_clave'), $usr_estado, $tipousuario+0, '$usr_nombre', now()";
    }else{
		$columnas="usr_nombres, codigovendedor,usr_apellidos,id_tipousuario,usr_email,usr_login, usr_clave,usr_estado, usr_tipo, usr_usr_crea, usr_fec_crea"; 
		$values="'$usr_nombres','$codigovendedor', '$usr_apellidos', $tipousuario, '$usr_email','$usr_login',md5('$usr_clave'), $usr_estado, $tipousuario+0, '$usr_nombre', now()";
    }
    if( $contador == 0 ) {
       $usr_nombre = general::get_nombre_usr( $ses_usr_id );
 	
        /*$query_1 = "insert into usuarios( usr_nombres, codigovendedor,usr_apellidos,id_tipousuario,usr_email,cod_local, usr_login, usr_clave,usr_estado, usr_tipo, usr_usr_crea, usr_fec_crea ) values ( '$usr_nombres','$codigovendedor', '$usr_apellidos', $tipousuario, '$usr_email',$ins_local, '$usr_login',md5('$usr_clave'), $usr_estado, 1, '$usr_nombre', now() )";*/
		$query_1 = "insert into usuarios( ".$columnas." ) values ( ".$values.")";

		bizcve::setevento(5, 'Modulo Usuario', $_SERVER['REMOTE_ADDR'], 'ABM Usuario',
                    'Alta del usuario : '.$usr_nombres.'','','Alta de Usuario', $usr_nombre );

		general::writelog('INSERT USUARIO :::: ' . $query_1);
		$res = $bd->query($query_1);
		header( "Location: adm_musr_01.php" );
    	exit();
    }
    else {
        header( "Location: adm_musr_01.php?action=ins&error=1" );
    	exit();
    }
}

function update_usuario( $bd,$usr_id ) {
    global $ses_usr_codlocal,$bd,$local,$ses_usr_id, $usr_nombres, $usr_apellidos,$tipousuario,$usr_email,$local, $usr_login, $usr_clave, $usr_estado,$codigovendedor;

    if(!bizcve::verificacionDePermisos($ses_usr_id,3, 'UPDATE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada'); 
    }

    if($local=='0'){
		$ins_local='cod_local=null';
    }else{
    	$ins_local="cod_local='".$local."'";
    }
    if(!$codigovendedor){
		$codigovendedor='';
    }
	$usr_nombre =general::get_nombre_usr( $ses_usr_id );
	$usr_mod_nombre = general::get_nombre_usr($usr_id );	

    if( $usr_clave != "" )
    	
        $update_clave = " usr_clave = md5('$usr_clave'), ";
    $query_1 = "update usuarios set $ins_local, id_tipousuario=$tipousuario, codigovendedor='$codigovendedor',usr_nombres = '$usr_nombres', usr_apellidos = '$usr_apellidos', usr_email = '$usr_email', usr_login = '$usr_login', $update_clave usr_estado = $usr_estado, usr_usr_mod = '$usr_nombre', usr_fec_mod = now() where usr_id = $usr_id";
     $res = $bd->query($query_1);
    general::writeevent('Los datos del usuario han sido modificados');

    bizcve::setevento(6, 'Modulo Usuario', $_SERVER['REMOTE_ADDR'], 'ABM Usuario',
                    'Modificacion del usuario : '.$usr_mod_nombre.'','','Modificación de usuario', $usr_nombre );
    
    header( "Location: adm_musr_01.php");
    exit();
}

function asocia_modulo($bd, $usr_id, $insert_in, $delete_in, $update_in, $select_in, $pemo_mod_id ) {
    $usr_nombre =general::get_nombre_usr( $ses_usr_id );

    if( $insert_in == '' )
        $insert_in = 0;
    if( $delete_in == '' )
        $delete_in = 0;
    if( $update_in == '' )
        $update_in = 0;
    if( $select_in == '' )
        $select_in = 0;

    $query_1 = "insert into permisosxmodulo( pemo_per_id, pemo_mod_id, pemo_tipo, pemo_insert, pemo_delete, pemo_update, pemo_select, pemo_usr_crea, pemo_fec_crea ) values ( $usr_id, $pemo_mod_id, 2, $insert_in, $delete_in, $update_in, $select_in, '$usr_nombre', now() )";
  	$res = $bd->query($query_1);

    header( "Location: adm_musr_01.php?action=upd&usr_id=$usr_id" );
    exit();
}

function mod_asocia_modulo( $bd, $usr_id, $insert_in, $delete_in, $update_in, $select_in, $pemo_mod_id ) {
    $usr_nombre = general::get_nombre_usr( $ses_usr_id );
    if( $insert_in == '' )
        $insert_in = 0;
    if( $delete_in == '' )
        $delete_in = 0;
    if( $update_in == '' )
        $update_in = 0;
    if( $select_in == '' )
        $select_in = 0;

    $usr_nombre = general::get_nombre_usr( $ses_usr_id );
    $query_1 = "update permisosxmodulo set pemo_insert = $insert_in, pemo_update = $update_in, pemo_delete = $delete_in, pemo_select = $select_in, pemo_usr_mod = '$usr_nombre', pemo_fec_mod = now() where pemo_per_id = $usr_id and pemo_mod_id = $pemo_mod_id and pemo_tipo = 2";
  	$res = $bd->query($query_1);
    header( "Location: adm_musr_01.php?action=upd&usr_id=$usr_id" );
    exit();
}

function del_asocia_modulo( $bd,$usr_id, $pemo_mod_id ) {
	$query_1 = "delete from permisosxmodulo where pemo_tipo = 2 and pemo_per_id = $usr_id and pemo_mod_id = $pemo_mod_id";
  	$res = $bd->query($query_1);
    header( "Location: adm_musr_01.php?action=upd&usr_id=$usr_id" );
    exit();
}

/**********************************************************************************************/
if( $action == 'del' )
    delete_usuario( $bd,$usr_id );
else if( $action == 'ins' ){
    form_usuarios( $bd,'', $error );
    include '../menu/menu.php';
	include '../menu/footer.php';
	}
    
else if( $action == 'upd' ){
    form_mod_usuarios($bd, $usr_id, $error );
	include '../menu/menu.php';
	include '../menu/footer.php';
	}
else if( $action == 'ins1' )

    insert_usuario($bd);
else if( $action == 'upd1' )
    update_usuario( $bd,$usr_id );
else if( $action == 'addmod' )
    asocia_modulo( $bd,$usr_id, $insert_in, $delete_in, $update_in, $select_in, $pemo_mod_id );
else if( $action == 'updmod' )
    mod_asocia_modulo( $bd,$usr_id, $insert_in, $delete_in, $update_in, $select_in, $pemo_mod_id );
else if( $action == 'delmod' )
    del_asocia_modulo($bd, $usr_id, $pemo_mod_id );
else {
    file_put_contents("admUsrlistado.txt", print_r($bd,true));
    file_put_contents("admUsrlistado01.txt", $patron);
    listado_usuarios($bd, $patron );
	include '../menu/menu.php';
	include '../menu/footer.php';
	}

/**********************************************************************************************/

//include "../../includes/application_bottom.php";

?>
