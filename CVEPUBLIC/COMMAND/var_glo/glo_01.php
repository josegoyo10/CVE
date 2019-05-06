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
	    general::writeevent('No puede administrar Variables Globales, tiene local asignado'); 
		header( "Location: ../start/sin_perm_01.php");	
		exit();
	}

/**********************************************************************************************/

function listado_grupos($bd) {
    global $ses_usr_id;
   	$MiTemplate = new template;
	$MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("USR_NOMBRE", general::get_nombre_usr( $ses_usr_id ));
    // Agregamos el header
	$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");

    // Agregamos la barra de herramientas
    // Agregamos la barra de herramientas
    if( general::se_puede( 'i', PERMISOS_MOD ) )
        $barra_her = general::kid_href( 'glo_01.php', "action=ins",'<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >', 'Agregar', '' );

    $barra_her = general::kid_href( 'glo_01.php', "action=ins",'<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >', 'Agregar', '' );
          
    $MiTemplate->set_var("BARRA_HERRAMIENTAS",$barra_her);
    $MiTemplate->set_file("barra_her",TEMPLATE."presentacion/barra.html");
    $MiTemplate->parse("OUT_BARRA","barra_her");

    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."var_glo/list_grupos.html");

    $MiTemplate->set_block("main", "Grupos", "PBLGrupos");
    $query = "select glo_id, glo_titulo, glo_descripcion from glo_grupos where GLO_ORDEN <>2 order by glo_titulo";
	$res = $bd->query($query);
 	$CONFIRM_ELIMINAR_GRUPO='&#191; Est&#225 seguro que desea eliminar el grupo&#63;';
	while ($row = $res->fetch_assoc()){
    $arr_k = array_keys ($row);		
		for( $i = 0; $i < sizeof( $arr_k ); $i++ ) {
			$MiTemplate->set_var($arr_k[$i], $row[$arr_k[$i]] );
		}        
		$MiTemplate->set_var("glo_id",$row['glo_id']);			
		$MiTemplate->set_var("glo_titulo",$row['glo_titulo']);			
		$MiTemplate->set_var("glo_descripcion",$row['glo_descripcion']);			
        $msg_aux = general::kid_href( 'glo_01.php', 'action=lisvar&glo_id='.$row['glo_id'],  '<IMG SRC="../../IMAGES/lista1.jpg" BORDER=0 >', 'Variables del grupo', '' );
        if( general::se_puede( 'u', PERMISOS_MOD ) )
            $msg_aux .= " " .general::kid_href( 'glo_01.php', 'action=updgru&glo_id='.$row['glo_id'],  '<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >',  'Modificar grupo', '' );
            $msg_aux .= " " .general::kid_href( 'glo_01.php', 'action=updgru&glo_id='.$row['glo_id'],  '<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >',  'Modificar grupo', '' );            
        if( general::se_puede( 'd', PERMISOS_MOD ) )
            $msg_aux .= " " . general::kid_href( 'javascript:validar_eliminar( "'.$CONFIRM_ELIMINAR_GRUPO.'", "glo_01.php?action=delgru&glo_id='.$row['glo_id'].'" ); //', '', '<IMG SRC="../../IMAGES/trash.png" BORDER=0 >' ,'Eliminar grupo', '' );
            $msg_aux .= " " . general::kid_href( 'javascript:validar_eliminar( "'.$CONFIRM_ELIMINAR_GRUPO.'", "glo_01.php?action=delgru&glo_id='.$row['glo_id'].'" ); //', '', '<IMG SRC="../../IMAGES/trash.png" BORDER=0 >' ,'Eliminar grupo', '' );            

        $MiTemplate->set_var('ACCIONES',$msg_aux);
        $MiTemplate->parse("PBLGrupos", "Grupos", true);
    }

    // Agregamos el footer
    $MiTemplate->parse("OUT_M", array("header","main"), true);
    $MiTemplate->p("OUT_M");

}

function form_grupo( $bd,$action, $glo_id ) {
	$MiTemplate = new template;
	$MiTemplate->set_var("TITULO", TITULO);
	
    $MiTemplate->set_var("USR_NOMBRE",general::get_nombre_usr( $ses_usr_id ));

    // Recuperamos los datos del grupo
    if( $action == 'updgru' ) {
        $query = "select glo_titulo, glo_descripcion from glo_grupos where glo_id = $glo_id";
       	$res = $bd->query($query);
       	while ($row = $res->fetch_assoc()){       	
			$MiTemplate->set_var("glo_titulo",$row['glo_titulo']);
			$MiTemplate->set_var("glo_descripcion",$row['glo_descripcion']);		
       		}
        $MiTemplate->set_var("TEXT_TITULO_SUB",'Modificar grupo');
        $MiTemplate->set_var("BOTON",'Modificar');
        $MiTemplate->set_var("GLO_ID",$glo_id);
        $MiTemplate->set_var("ACTION",'updgru1');
    }
    else {
        $MiTemplate->set_var("TEXT_TITULO_SUB",'Agregar grupo');
        $MiTemplate->set_var("BOTON",'Agregar');
        $MiTemplate->set_var("ACTION",'insgru');
    }

    // Agregamos el header
    $MiTemplate->set_file("header",TEMPLATE."presentacion/header.htm");

    // Agregamos la barra de herramientas
    $barra_her = general:: kid_href( 'glo_01.php', "",'<IMG SRC="../../IMAGES/back.png" HEIGHT="22" BORDER=0 >', 'Volver ', '' );
    if( general:: se_puede( 'i', PERMISOS_MOD ) )
        $barra_her .= ' ' . kid_href( 'glo_01.php', "action=ins", '<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >', 'Agregar grupo', '' );
    $barra_her .= ' ' . general:: kid_href( 'glo_01.php', "action=ins", '<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >', 'Agregar grupo', '' );        
    $MiTemplate->set_var("BARRA_HERRAMIENTAS",$barra_her);
    $MiTemplate->set_file("barra_her",TEMPLATE."presentacion/barra.html");
    $MiTemplate->parse("OUT_BARRA","barra_her");

    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."var_glo/form_grupo.html");

	///////////////////////// ZONA PIE DE PAGINA /////////////////////////	
	$MiTemplate->parse("OUT_M", array("header", "main"), true);
	$MiTemplate->p("OUT_M");

}

function insert_grupo( $bd,$c_1,$c_2 ) {

    global $ses_usr_id;
    $usr_nombre =general::get_nombre_usr( $ses_usr_id );

    if(!bizcve::verificacionDePermisos($ses_usr_id,24, 'INSERT')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }
    
    bizcve::setevento(31, 'Modulo Administracion Variables Globales', $_SERVER['REMOTE_ADDR'], 'ABM Sistemas',
                    'Se ha Creado la Variable Global '.$c_1.'','','Variable Global Creada', $usr_nombre );  


    $usr_nombre = general::get_nombre_usr( $ses_usr_id );
    $query = "insert into glo_grupos( glo_titulo, glo_descripcion, glo_orden, glo_usr_crea, glo_fec_crea ) values( '$c_1', '$c_2', 0, '$usr_nombre', now() )";
    $res = $bd->query($query);
    header( "Location: glo_01.php" );
    exit();
}

function delete_grupo( $bd,$glo_id ) {

    global $ses_usr_id;

    if(!bizcve::verificacionDePermisos($ses_usr_id,24, 'DELETE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }

    $usr_nombre =general::get_nombre_usr( $ses_usr_id );

        bizcve::setevento(33, 'Modulo Administracion Variables Globales', $_SERVER['REMOTE_ADDR'], 'ABM Sistemas',
                    ' Se ha Eliminado la Variable Global '.$glo_id.'','','Variable Global Eliminada', $usr_nombre );

    $query = "delete from glo_grupos where glo_id = $glo_id";
    $res = $bd->query($query);
    general::writeevent('Se ha eliminado un grupo de variables globales'); 
    header( "Location: glo_01.php" );
    exit();
}

function update_grupo( $bd,$glo_id,$c_1,$c_2 ) {
    global $ses_usr_id;

    if(!bizcve::verificacionDePermisos($ses_usr_id,24, 'UPDATE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }

    $usr_nombre =general::get_nombre_usr( $ses_usr_id );

        bizcve::setevento(32, 'Modulo Administracion Variables Globales', $_SERVER['REMOTE_ADDR'], 'ABM Sistemas',
                    'Se ha modificado la Variable Global '.$c_1.' ','','Variable Global modificada', $usr_nombre );

    $usr_nombre = general::get_nombre_usr( $ses_usr_id );
    $query = "update glo_grupos set glo_titulo = '$c_1', glo_descripcion = '$c_2', glo_usr_mod = '$usr_nombre', glo_fec_mod = now() where glo_id = $glo_id";
    $res = $bd->query($query);
    general::writeevent('Se ha modificado un grupo de variables globales');
    header( "Location: glo_01.php" );
    exit();
}

function listado_variables( $bd,$glo_id ) {
    global $ses_usr_id;
	$MiTemplate = new template;
	$MiTemplate->set_var('error_app', $mensaje_error);
	$MiTemplate->set_var("TITULO", TITULO);

    $MiTemplate->set_var("USR_NOMBRE",general::get_nombre_usr( $ses_usr_id ));
    
    // Agregamos el header
	$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");

	// Agregamos la barra de herramientas
	    // Agregamos la barra de herramientas
    $barra_her = general::kid_href( 'glo_01.php', "", '<IMG SRC="../../IMAGES/back.png" HEIGHT="22" BORDER=0 >', 'Volver', '' );
    if(  general::se_puede( 'i', PERMISOS_MOD ) )
        $barra_her .= ' ' .general::kid_href( 'glo_01.php', "action=insvar&glo_id=$glo_id", '<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >', 'Agregar variable', '' );

        $barra_her .= ' ' .general::kid_href( 'glo_01.php', "action=insvar&glo_id=$glo_id", '<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >', 'Agregar variable', '' );
               
    $MiTemplate->set_var("BARRA_HERRAMIENTAS",$barra_her);
    $MiTemplate->set_file("barra_her",TEMPLATE."presentacion/barra.html");
    $MiTemplate->parse("OUT_BARRA","barra_her");
    
    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."var_glo/list_variables.html");
	$CONFIRM_ELIMINAR_VARIABLE='&#191; Est&#225 seguro que desea eliminar ls variable&#63;';
    // agregamos el bloque para las variables al main
    $MiTemplate->set_block("main", "Variables", "PBLVariables");
    $query = "select var_id, var_titulo, var_llave, var_valor, var_descripcion from glo_variables where var_glo_id = $glo_id order by var_titulo";
	$res = $bd->query($query);
    $num1=$bd->num_rows($query);
   	    
    if( $num1 > 0 ) {
		$row = $res->fetch_assoc();
        $arr_k = array_keys ($row);

		$res = $bd->query($query);
	    while ($row = $res->fetch_assoc()){
	        for( $i = 0; $i < sizeof( $arr_k ); $i++ ) {
	            $MiTemplate->set_var($arr_k[$i],$row[$arr_k[$i]]);
	        }	
			$MiTemplate->set_var("var_id",$row['var_id']);	        
			$MiTemplate->set_var("var_titulo",$row['var_titulo']);	  
			$MiTemplate->set_var("var_llave",$row['var_llave']);	  
			$MiTemplate->set_var("var_valor",$row['var_valor']);	  									
			$MiTemplate->set_var("var_descripcion",$row['var_descripcion']);	
            $msg_aux = '';
            if( general::se_puede( 'u', PERMISOS_MOD ) )
                $msg_aux .= ' ' . general::kid_href( 'glo_01.php', "action=updvar&glo_id=$glo_id&var_id=".$row['var_id'], '<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >', 'Modificar', '' );
                $msg_aux .= ' ' . general::kid_href( 'glo_01.php', "action=updvar&glo_id=$glo_id&var_id=".$row['var_id'], '<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >', 'Modificar', '' );                
            if( general::se_puede( 'd', PERMISOS_MOD ) )
                $msg_aux .= ' ' . general::kid_href( 'javascript:validar_eliminar( "'.$CONFIRM_ELIMINAR_VARIABLE.'", "glo_01.php?action=delvar&glo_id='.$glo_id.'&var_id='.$row['var_id'].'" ); //', '', '<IMG SRC="../../IMAGES/trash.png" BORDER=0 >', 'Eliminar', '' );
                $msg_aux .= ' ' . general::kid_href( 'javascript:validar_eliminar( "'.$CONFIRM_ELIMINAR_VARIABLE.'", "glo_01.php?action=delvar&glo_id='.$glo_id.'&var_id='.$row['var_id'].'" ); //', '', '<IMG SRC="../../IMAGES/trash.png" BORDER=0 >', 'Eliminar', '' );
            $MiTemplate->set_var('ACCIONES',$msg_aux);
            $MiTemplate->parse("PBLVariables", "Variables", true);
        }
    }

	///////////////////////// ZONA PIE DE PAGINA /////////////////////////
	$MiTemplate->parse("OUT_M", array("header", "main"), true);
	$MiTemplate->p("OUT_M");
}

function form_variable( $bd,$action, $glo_id, $var_id ) {
	$MiTemplate = new template();
	$MiTemplate->set_var("TITULO", TITULO);
	
    $MiTemplate->set_var("SUBTITULO1",TEXT_2);
    $MiTemplate->set_var("USR_NOMBRE",general::get_nombre_usr( $ses_usr_id ));

    $MiTemplate->set_var("TEXT_CAMPO_1",TEXT_CAMPO_1);
    $MiTemplate->set_var("TEXT_CAMPO_2",TEXT_CAMPO_2);

    // Recuperamos los datos del grupo
    if( $action == 'updvar' ) {
        $query = "select var_titulo, var_descripcion, var_llave, var_valor from glo_variables where var_id = $var_id";
       	$res = $bd->query($query);
	   	while ($row = $res->fetch_assoc()){
			$MiTemplate->set_var("var_titulo",$row['var_titulo']);
			$MiTemplate->set_var("var_descripcion",$row['var_descripcion']);		
			$MiTemplate->set_var("var_llave",$row['var_llave']);		
			$MiTemplate->set_var("var_valor",$row['var_valor']);		
		}
        $MiTemplate->set_var("TEXT_TITULO_SUB",'Modificar variable');
        $MiTemplate->set_var("BOTON",'Modificar');
        $MiTemplate->set_var("GLO_ID",$glo_id);
        $MiTemplate->set_var("VAR_ID",$var_id);
        $MiTemplate->set_var("ACTION",'updvar1');
    }
    else {
        $MiTemplate->set_var("TEXT_TITULO_SUB",'Agregar variable');
        $MiTemplate->set_var("BOTON",'Agregar');
        $MiTemplate->set_var("GLO_ID",$glo_id);
        $MiTemplate->set_var("ACTION",'insvar1');
    }

    // Agregamos el header
    $MiTemplate->set_file("header",TEMPLATE ."presentacion/header.htm");
    // Agregamos la barra de herramientas
    $barra_her =general::kid_href( 'glo_01.php', "action=lisvar&glo_id=$glo_id", '<IMG SRC="../../IMAGES/back.png" HEIGHT="22" BORDER=0 >', 'Volver', '' );
    if( general::se_puede( 'i', PERMISOS_MOD ) )
        $barra_her .= ' ' . general::kid_href( 'glo_01.php', "action=insvar&glo_id=$glo_id", '<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >', 'Agregar variable', '' );

        $barra_her .= ' ' . general::kid_href( 'glo_01.php', "action=insvar&glo_id=$glo_id", '<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >', 'Agregar variable', '' );        
    $MiTemplate->set_var("BARRA_HERRAMIENTAS",$barra_her);
    $MiTemplate->set_file("barra_her",TEMPLATE ."presentacion/barra.html");
    $MiTemplate->parse("OUT_BARRA","barra_her");

    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."var_glo/form_variable.html");

	///////////////////////// ZONA PIE DE PAGINA /////////////////////////
	$MiTemplate->parse("OUT_M", array("header", "main"), true);
	$MiTemplate->p("OUT_M");

}

function insert_variable( $bd,$glo_id, $c_1, $c_2, $c_3, $c_4 ) {
    global $ses_usr_id;
    $max_orden = 0;
    $query = "insert into glo_variables( var_glo_id, var_titulo, var_descripcion, var_llave, var_valor, var_orden, var_usr_crea, var_fec_crea ) values( $glo_id, '$c_1', '$c_2', '$c_3', '$c_4', $max_orden, '$usr_nombre', now() )";
    $res = $bd->query($query);
    header( "Location: glo_01.php?action=lisvar&glo_id=$glo_id" );
    exit();
}

function delete_variable(  $bd,$glo_id, $var_id ) {
    $query = "delete from glo_variables where var_id = $var_id";
    $res = $bd->query($query);
    general::writeevent('Se ha eliminado una variable global'); 
    header( "Location: glo_01.php?action=lisvar&glo_id=$glo_id" );
    exit();
}

function update_variable(  $bd,$c_1, $c_2, $c_3, $c_4, $var_id, $glo_id ) {
    global $ses_usr_id;
    if(!bizcve::verificacionDePermisos($ses_usr_id,24, 'UPDATE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }
    $usr_nombre = general::get_nombre_usr( $ses_usr_id );
    $query = "update glo_variables set var_titulo = '$c_1', var_descripcion = '$c_2', var_llave = '$c_3', var_valor = '$c_4', var_usr_mod = '$usr_nombre', var_fec_mod = now() where var_id = $var_id";
    $res = $bd->query($query);
    general::writeevent('Se ha modificado una variable global');

    global $ses_usr_id;
    $usr_nombre =general::get_nombre_usr( $ses_usr_id );

        bizcve::setevento(32, 'Modulo Administración Variables Globales', $_SERVER['REMOTE_ADDR'], 'ABM Sistemas',
                    'Se ha modificado la Variable Global '.$c_1.'','','Variable Global modificada', $usr_nombre );

    header( "Location: glo_01.php?action=lisvar&glo_id=$glo_id" );
    exit();
}

/**********************************************************************************************/

if($action == 'ins')
    form_grupo($bd,$action, $glo_id );
else if($action == 'insgru')
    insert_grupo( $bd,$c_1,$c_2 );
else if($action == 'delgru')
    delete_grupo( $bd,$glo_id );
else if( $action == 'updgru' )
    form_grupo( $bd,$action, $glo_id );
else if( $action == 'updgru1' )
    update_grupo( $bd,$glo_id,$glo_titulo,$glo_descripcion );
else if( $action == 'lisvar' )
    listado_variables($bd, $glo_id );
else if( $action == 'insvar' )
    form_variable( $bd,$action, $glo_id, $var_id );
else if( $action == 'insvar1' )
    insert_variable( $bd,$glo_id, $var_titulo, $var_descripcion, $var_llave, $var_valor );
else if( $action == 'delvar' )
    delete_variable( $bd,$glo_id, $var_id );
else if( $action == 'updvar' )
    form_variable( $bd,$action, $glo_id, $var_id );
else if( $action == 'updvar1' )
    update_variable( $bd,$var_titulo, $var_descripcion, $var_llave, $var_valor, $var_id, $glo_id );
else
    listado_grupos($bd);

   	include '../menu/menu.php';
	include '../menu/footer.php';  
/**********************************************************************************************/
?>
