<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
$bd = $_SESSION["DBACESS"];	
/*si tiene local asignado no puede administrar usuarios*/
if ($_SESSION["ses_usr_codlocal"]){
	header( "Location: ../start/sin_perm_01.php");	
	exit();
}

function listado_modulos($bd) {
	$MiTemplate = new template;
	$MiTemplate->set_var('error_app', $mensaje_error);
	$MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("TEXT_TITULO","Administracion de Modulos ");
    $MiTemplate->set_var("SUBTITULO1","Modulos en el sistema");

    $MiTemplate->set_var("TEXT_1","Seleccione la accion a realizar desde la barra de herramientas o desde los modulos.");
    $MiTemplate->set_var("TEXT_SUB_MODULOS","Modulos del sistema");
    $MiTemplate->set_var("TEXT_BUSCAR_CAMPO_1","Modulo a Buscar");
    $MiTemplate->set_var("BOTON_BUSCAR_MODULO","Buscar");
	$MiTemplate->set_var("BOTON_MODIFICAR_IMG", '<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >');    
    $MiTemplate->set_var("BOTON_ELIMINAR_IMG", '<IMG SRC="../../IMAGES/trash.png" BORDER=0 >');
	$MiTemplate->set_var("BOTON_AGREGAR_IMG", '<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >');    

    /*para los botones*/
    $BOTON_MODIFICAR_IMG='<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >';
    $BOTON_ELIMINAR_IMG ='<IMG SRC="../../IMAGES/trash.png" BORDER=0 >';    
	$BOTON_AGREGAR_IMG	='<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >';    
	$BOTON_LISTAR_IMG   ='<IMG SRC="../../IMAGES/lista.png" HEIGHT="22" BORDER=0 >';
	$BOTON_VOLVER_IMG	='<IMG SRC="../../IMAGES/back.png" HEIGHT="22" BORDER=0 >';  
    $BOTON_UP_IMG 		='<IMG SRC="../../IMAGES/uparrow.png"  BORDER=0 >'; 
	
	$CONFIRM_ELIMINAR_MOD='&#191; Est&#225 seguro que desea eliminar el modulo&#63;';
    
    // Agregamos el header
	$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");

    // Agregamos la barra de herramientas
    if( general::se_puede( 'i', PERMISOS_MOD ) )
          $barra_her .= " " . general::kid_href( 'adm_mod_01.php', 'action=ins', $BOTON_AGREGAR_IMG, 'Agregar', '' );

    $barra_her .= " " . general::kid_href( 'adm_mod_01.php', 'action=ins', $BOTON_AGREGAR_IMG, 'Agregar', '' );          
          
    $MiTemplate->set_var("BARRA_HERRAMIENTAS",$barra_her);
    $MiTemplate->set_file("barra_her",TEMPLATE."presentacion/barra.html");
    $MiTemplate->parse("OUT_BARRA","barra_her");

    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_mod/listado.html");

    // Recuperamos los modulos de la base
    $MiTemplate->set_block("main", "Modulos", "PBLModulos");
    $query ="select m1.mod_id, m1.mod_nombre, m1.mod_orden, m1.mod_padre_id, ifnull(m2.mod_nombre,'') as padre from modulos m1 left join modulos as m2 on m2.mod_id = m1.mod_padre_id order by m1.mod_orden";
	$primero = 1;
    $res = $bd->query($query);
		while ($row = $res->fetch_assoc()){	
			for( $i = 0; $i < sizeof( $arr_k ); $i++ ) {
				$MiTemplate->set_var($arr_k[$i], $row[$arr_k[$i]] );
			} 			
			$MiTemplate->set_var("mod_nombre",$row['mod_nombre']);
			$MiTemplate->set_var("mod_orden",$row['mod_orden']);			
			$MiTemplate->set_var("padre",$row['padre']);
	        $msg_aux = '';
	        if( $primero == 0 )
	            $msg_aux = general::kid_href( 'adm_mod_01.php', 'action=up&mod_id='.$row['mod_id'].'&orden='.$row['mod_orden']."&mod_id_ant=$mod_id_2&orden_ant=$orden_2", $BOTON_UP_IMG, '', '' ) . ' ';
	        else
            	$primero = 0;
	        $mod_id_2 = $row['mod_id'];
	        $orden_2 = $row['mod_orden'];

	        if( general::se_puede( 'u', PERMISOS_MOD ) ) 
	            $msg_aux .= general::kid_href( 'adm_mod_01.php', "action=upd&mod_id=".$row['mod_id'], $BOTON_MODIFICAR_IMG, 'Modificar', '' ) . " ";

	            $msg_aux .= general::kid_href( 'adm_mod_01.php', "action=upd&mod_id=".$row['mod_id'], $BOTON_MODIFICAR_IMG, 'Modificar', '' ) . " ";
	            
	        if( general::se_puede( 'd', PERMISOS_MOD ) ) 
	            $msg_aux .= general::kid_href( 'javascript:validar_eliminar( "'.$CONFIRM_ELIMINAR_MOD.'", "adm_mod_01.php?action=del&mod_id='.$row['mod_id'].'" ); //', '', $BOTON_ELIMINAR_IMG, 'Eliminar', '' );
	
				$msg_aux .= general::kid_href( 'javascript:validar_eliminar( "'.$CONFIRM_ELIMINAR_MOD.'", "adm_mod_01.php?action=del&mod_id='.$row['mod_id'].'" ); //', '', $BOTON_ELIMINAR_IMG, 'Eliminar', '' );	            
	
	        $MiTemplate->set_var('ACCIONES',$msg_aux);
	        $MiTemplate->parse("PBLModulos", "Modulos", true);
		}    

	///////////////////////// ZONA PIE DE PAGINA /////////////////////////		
	$MiTemplate->parse("OUT_M", array("header", "main"), true);
	$MiTemplate->p("OUT_M");
}

function formulario_modulo( $bd,$mod_id, $action ) {
	$MiTemplate = new template;
	$MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("TEXT_TITULO","Administracion de Modulos");
    $MiTemplate->set_var("TEXT_1","Seleccione la accion a realizar desde la barra de herramientas o desde los modulos.");
    $MiTemplate->set_var("TEXT_SUB_MODULOS","Modulos del sistema");
    $MiTemplate->set_var("TEXT_BUSCAR_CAMPO_1","Modulo a Buscar");
    $MiTemplate->set_var("BOTON_BUSCAR_MODULO","Buscar");
	$MiTemplate->set_var("BOTON_MODIFICAR_IMG", '<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >');    
    $MiTemplate->set_var("BOTON_ELIMINAR_IMG", '<IMG SRC="../../IMAGES/trash.png" BORDER=0 >');
	$MiTemplate->set_var("BOTON_AGREGAR_IMG", '<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >');    

    /*para los botones*/
    $BOTON_MODIFICAR_IMG='<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >';
    $BOTON_ELIMINAR_IMG ='<IMG SRC="../../IMAGES/trash.png" BORDER=0 >';    
	$BOTON_AGREGAR_IMG	='<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >';    
	$BOTON_LISTAR_IMG   ='<IMG SRC="../../IMAGES/lista.png" HEIGHT="22" BORDER=0 >';
	$BOTON_VOLVER_IMG	='<IMG SRC="../../IMAGES/back.png" HEIGHT="22" BORDER=0 >';   
	$CONFIRM_ELIMINAR_USR='&#191; Est&#225 seguro que desea eliminar el perfil&#63;';
    
    // Agregamos el header
	$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
    
    if( $action == "upd" ) {
        $MiTemplate->set_var("SUBTITULO1","Modificar modulo en el sistema");
        $MiTemplate->set_var("ACTION",'upd1');
        $MiTemplate->set_var("act_mod_id",$mod_id);
        $MiTemplate->set_var("BOTON",BOTON_MODIFICAR);
    }
    else {
        $MiTemplate->set_var("SUBTITULO1","Ingresar modulo en el sistema");
        $MiTemplate->set_var("ACTION",'ins1');
        $MiTemplate->set_var("act_mod_id",'');
        $MiTemplate->set_var("BOTON",BOTON_AGREGAR);
    }

    // Agregamos la barra de herramientas
    $barra_her = general::kid_href( 'adm_mod_01.php', '', $BOTON_VOLVER_IMG, $BOTON_VOLVER, '' );
    if( general::se_puede( 'i', PERMISOS_MOD ) )
		$msg_aux = general::kid_href( 'adm_mod_01.php', "action=upd&usr_id=".$_SESSION["ses_usr_id"], $BOTON_MODIFICAR_IMG, 'Modificar', '' ) . " ";
    $MiTemplate->set_var("BARRA_HERRAMIENTAS",$barra_her);
    $MiTemplate->set_file("barra_her",TEMPLATE."presentacion/barra.html");
    $MiTemplate->parse("OUT_BARRA","barra_her");

    $mod_padre_id = 0;
    if( $action == 'upd' ) {
		$MiTemplate->parse("altboton","Modificar");    	
        // Recuperamos los datos del modulo
        $query = "select mod_padre_id, mod_nombre, mod_descripcion, mod_url, mod_orden, mod_estado from modulos where mod_id = $mod_id";
		$res = $bd->query($query);
		while ($row = $res->fetch_assoc()){
		for( $i = 0; $i < sizeof( $arr_k ); $i++ ) {
			$MiTemplate->set_var($arr_k[$i], $row[$arr_k[$i]] );
		}        	
		$MiTemplate->set_var("mod_nombre",$row['mod_nombre']);
		$MiTemplate->set_var("mod_descripcion",$row['mod_descripcion']);		
		$MiTemplate->set_var("mod_url",$row['mod_url']);		
		$MiTemplate->set_var("mod_orden",$row['mod_orden']);			
            if( $row['mod_estado'] == 2 ) {
                $MiTemplate->set_var('chec1','');
                $MiTemplate->set_var('chec2','checked');
            }
            else {
                $MiTemplate->set_var('chec1','checked');
                $MiTemplate->set_var('chec2','');
            }
            if( $row['mod_padre_id'] != '' )
                $mod_padre_id = $row['mod_padre_id'];
        }
    }
    
    else {
		$MiTemplate->parse("altboton","Insertar");    	    	
        $MiTemplate->set_var('chec1','checked');
        $MiTemplate->set_var('chec2','');
        $MiTemplate->set_var('mod_nombre','');
        $MiTemplate->set_var('mod_descripcion','');
        $MiTemplate->set_var('mod_url','');

        $query_1 = "select max( mod_orden ) as max from modulos";
		$res = $bd->query($query_1);
		$row = $res->fetch_assoc();
        $MiTemplate->set_var('mod_orden',$row['max']+10);
	}
    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_mod/form_mod.html");

    // Lista para los padres
    $MiTemplate->set_block("main", "Padres", "PBLPadres");
    $query = "select mod_id as padre_mod_id, mod_nombre as padre_mod_nombre,if( mod_id = $mod_padre_id, 'selected', '' ) as selected from modulos where mod_padre_id is NULL order by mod_nombre";
    $res = $bd->query($query);
	while ($row = $res->fetch_assoc()){
		$MiTemplate->set_var("padre_mod_id",$row['padre_mod_id']);
		$MiTemplate->set_var("padre_mod_nombre",$row['padre_mod_nombre']);
		$MiTemplate->set_var("selected",$row['selected']);		
		$MiTemplate->parse("PBLPadres", "Padres", true);
	}

	///////////////////////// ZONA PIE DE PAGINA /////////////////////////
	$MiTemplate->parse("OUT_M", array("header", "main"), true);
	$MiTemplate->p("OUT_M");

}

function up_modulo($bd, $orden_ant, $mod_id, $orden, $mod_id_ant ) {

	$query_1 = "update modulos set mod_orden = $orden_ant where mod_id = $mod_id";
 	$res = $bd->query($query_1);
    $query_1 = "update modulos set mod_orden = $orden where mod_id = $mod_id_ant";
 	$res = $bd->query($query_1);
    general::writeevent('El orden de los modulos ha sido modificado');

    header( "Location: adm_mod_01.php" );
    exit();
}

function delete_modulo( $bd,$mod_id ) {

    global $ses_usr_id;

    if(!bizcve::verificacionDePermisos($ses_usr_id,2, 'DELETE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }

    $usr_nombre = general::get_nombre_usr( $ses_usr_id );

    bizcve::setevento(36, 'Modulo Administracion Modulos', $_SERVER['REMOTE_ADDR'], 'ABM Sistemas',
                    'Se ha Eliminado el modulo '.$mod_id.'','','Modulo eliminado', $usr_nombre );


    $query_1 = "delete from modulos where mod_id = $mod_id";
 	$res = $bd->query($query_1);
    general::writeevent('El modulo '.$mod_id.' ha sido eliminado'); 	 	
    // borramos las referencias en la tabla permisosxmodulo
    $query_1 = "delete from permisosxmodulo where pemo_mod_id = $mod_id";
 	$res = $bd->query($query_1);
    general::writeevent('Se han eliminado los permisos del modulo '.$mod_id);  	
    header( "Location: adm_mod_01.php" );
    exit();
}

function form_modulo( $bd,$usr_id, $error ) {
	$MiTemplate = new template;
	$MiTemplate->set_var('error_app', $mensaje_error);
	$MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("TEXT_TITULO","Administracion de usuarios ");
    $MiTemplate->set_var("SUBTITULO1",TEXT_2);

    $MiTemplate->set_var("TEXT_1","Ingrese la infoemacion en los campos y luego presione agregar usuario.");
    $MiTemplate->set_var("TEXT_SUB_MODULOS","Agregar Usuario");

    /*para los botones*/
    $BOTON_MODIFICAR_IMG='<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >';
    $BOTON_ELIMINAR_IMG ='<IMG SRC="../../IMAGES/trash.png" BORDER=0 >';    
	$BOTON_AGREGAR_IMG	='<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >';    
	$BOTON_LISTAR_IMG   ='<IMG SRC="../../IMAGES/lista.png" HEIGHT="22" BORDER=0 >';
	$BOTON_VOLVER_IMG	='<IMG SRC="../../IMAGES/back.png" HEIGHT="22" BORDER=0 >';
	
	$CONFIRM_ELIMINAR_USR='&#191; Est&#225 seguro que desea eliminar el perfil&#63;';
    if( $error == 1 )
        $MiTemplate->set_var("TEXT_ERROR",TEXT_CAMPO_EXISTE);

    // Agregamos el header
    $MiTemplate->set_file("header",TEMPLATE."presentacion/header.htm");

    // Agregamos la barra de herramientas
    $barra_her = general::kid_href( 'adm_mod_01.php', '', $BOTON_VOLVER_IMG, $BOTON_VOLVER, '' );
    if( general::se_puede( 'i', PERMISOS_MOD ) )
        $barra_her .= " " . general::kid_href( 'adm_mod_01.php', 'action=ins',$BOTON_AGREGAR_IMG, $TEXT_TAG_AGREGAR, '' );
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
	
	$MiTemplate->parse("OUT_M", array("header", "main"), true);
	$MiTemplate->p("OUT_M");
}

function form_mod_modulos( $bd,$usr_id, $error ) {
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
    $MiTemplate->set_var("TEXT_CAMPO_CLAVES_DISTINTAS",TEXT_CAMPO_CLAVES_DISTINTAS);
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
    $barra_her = general::kid_href( 'adm_mod_01.php', '', $BOTON_VOLVER_IMG, $BOTON_VOLVER, '' );
    if( general::se_puede( 'i', PERMISOS_MOD ) )
        $barra_her .= " " . general::kid_href( 'adm_mod_01.php', 'action=ins', $BOTON_AGREGAR_IMG, 'Agregar', '' );
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
    $MiTemplate->set_var("BOTON_ASOCIAR_ADD",BOTON_ASOCIAR_ADD);
    $MiTemplate->set_var("BOTON_ASOCIAR_MOD",BOTON_ASOCIAR_MOD);
    $MiTemplate->set_var("BOTON_ELIMINAR",BOTON_ELIMINAR);

    $MiTemplate->set_block("main", "Modulos_a", "PBLModulos_a");
    if( sizeof( $arr_pemo ) > 0 ) {
        for( $i = 0; $i < sizeof( $arr_pemo ); $i++ ) {
            $MiTemplate->set_var('pemo_mod_id',$arr_pemo[$i][0]);
            $MiTemplate->set_var('mod_nombre',$arr_pemo[$i][1]);
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

function insert_modulo($bd) {
    global $ses_usr_id,$mod_nombre,$mod_descripcion,$mod_estado,$mod_url,$modulo_padre_id,$mod_orden;

    if(!bizcve::verificacionDePermisos($ses_usr_id,2, 'INSERT')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }

    $usr_nombre =general::get_nombre_usr( $ses_usr_id );

            bizcve::setevento(34, 'Modulo Administracion Modulos', $_SERVER['REMOTE_ADDR'], 'ABM Sistemas',
                    'Se ha insertado el modulo '.$mod_nombre.'','','Modulo  modificado', $usr_nombre );

	$usr_nombre =general::get_nombre_usr( $ses_usr_id );
    if( $mod_descripcion == '' ) $mod_descripcion = 'NULL'; else $mod_descripcion = "'$mod_descripcion'";
    if( $mod_url == '' ) $mod_url = 'NULL'; else $mod_url = "'$mod_url'";
    if( $modulo_padre_id == '---' ) $modulo_padre_id = 'NULL';

    $query_1 = "insert into modulos( mod_estado, mod_nombre, mod_descripcion, mod_url, mod_orden, mod_padre_id, mod_usr_crea, mod_fec_crea ) values ( $mod_estado, '$mod_nombre', $mod_descripcion, $mod_url, $mod_orden, $modulo_padre_id, '$usr_nombre', now() )";
    $res = $bd->query($query_1);
    header( "Location: adm_mod_01.php" );
    exit();
}

function update_modulo( $bd,$usr_id ) {
    global $mod_id,$ses_usr_id,$mod_nombre,$mod_descripcion,$mod_estado,$mod_url,$modulo_padre_id,$mod_orden;

    if(!bizcve::verificacionDePermisos($ses_usr_id,2, 'UPDATE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }

	$usr_nombre =general::get_nombre_usr( $ses_usr_id );

            bizcve::setevento(35, 'Modulo Administracion Modulos', $_SERVER['REMOTE_ADDR'], 'ABM Sistemas',
                    'Se ha modificado el modulo '.$mod_nombre.'','','Modulo  modificado', $usr_nombre );


    if( $modulo_padre_id == '---' )
        $modulo_padre_id = 'NULL';

    $query_1 = "update modulos set mod_estado = $mod_estado, mod_nombre = '$mod_nombre', mod_descripcion = '$mod_descripcion', mod_url = '$mod_url', mod_orden = $mod_orden, mod_padre_id = $modulo_padre_id, mod_usr_mod = '$usr_nombre', mod_fec_mod = now() where mod_id = $mod_id";
    $res = $bd->query($query_1);
    general::writeevent('El modulo '.$mod_id.' ha sido modificado');     
    header( "Location: adm_mod_01.php" );
    exit();
}

/**********************************************************************************************/
if( $action == 'del' )
    delete_modulo( $bd,$mod_id );
else if( $action == 'up' )
    up_modulo( $bd,$orden_ant, $mod_id, $orden, $mod_id_ant );
else if( $action == 'upd' )
	formulario_modulo( $bd,$mod_id, $action );
else if( $action == 'upd1' )
    update_modulo( $bd,$mod_id );
else if( $action == 'ins' )
    formulario_modulo( $bd,$mod_id, $action );
else if( $action == 'ins1' )
    insert_modulo($bd);
else
    listado_modulos($bd);
include '../menu/menu.php';
include '../menu/footer.php';

/**********************************************************************************************/

//include "../../includes/application_bottom.php";

?>
