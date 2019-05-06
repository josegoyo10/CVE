<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
$bd = $_SESSION["DBACESS"];

/**********************************************************************************************/

function form_per_usr_1( $bd,$id_padre ) {
	global $ses_usr_id;
	$MiTemplate = new template;
	$MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("TEXT_TITULO","Administracion de perfiles y usuarios  ");
    $MiTemplate->set_var("SUBTITULO1","Modulos en el sistema");
    $MiTemplate->set_var("ID_PADRE",$id_padre);

    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_usr/adm_usr_03.html");

    $MiTemplate->parse("OUT_M", array("main"), true);
    $MiTemplate->p("OUT_M");

}

function form_per_usr_2($bd, $id_padre ) {
	global $ses_usr_id;
	$MiTemplate = new template;
	$MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("ID_PADRE",$id_padre);

    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_usr/adm_usr_03_1.html");

    $MiTemplate->parse("OUT_M", array("main"), true);
    $MiTemplate->p("OUT_M");

}

function insert_perfil( $bd,$nombre_in, $descripcion_in, $id_padre_in ) {
    global $ses_usr_id;

    if(!bizcve::verificacionDePermisos($ses_usr_id,1, 'INSERT')){
        general::alertexit('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }

	$usr_nombre =general::get_nombre_usr( $ses_usr_id );

    if( $id_padre_in == '' )
        $id_padre = "NULL";
    else
        $id_padre = $id_padre_in;

    $query_1 = "insert into perfiles( per_nombre, per_descripcion, per_padre, per_usr_crea, per_fec_crea ) values ( '$nombre_in', '$descripcion_in', $id_padre, '$usr_nombre', now() )";
	$res = $bd->query($query_1);

    bizcve::setevento(7, 'Modulo Perfiles', $_SERVER['REMOTE_ADDR'], 'ABM perfil',
                    ' Alta del perfil : '.$nombre_in.'','','Alta de Perfil', $usr_nombre );

	$MiTemplate = new template;
    $MiTemplate->set_var("ID_PADRE",$id_padre);

    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_usr/adm_usr_03_2.html");

    $MiTemplate->parse("OUT_M", array("main"), true);
    $MiTemplate->p("OUT_M");

}

function form_per_usr_3( $bd,$id_padre ) {
	$MiTemplate = new template;
    $MiTemplate->set_var("ID_PADRE",$id_padre);
    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_usr/adm_usr_03_3.html");

    $MiTemplate->parse("OUT_M", array("main"), true);
    $MiTemplate->p("OUT_M");
}

function search_usuarios( $bd,$id_padre, $c_1 ) {
    $MiTemplate = new template();
	$MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("ID_PADRE",$id_padre);
    $MiTemplate->set_var("c_1",$c_1);
    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_usr/adm_usr_03_3.html");
    if( $id_padre == "" )
        $id_padre = "NULL";
    $not_in = "";
    $tag = "";
    $query_1 = "select peus_usr_id from perfilesxusuario where peus_per_id = $id_padre";
    $res = $bd->query($query_1);
	while ($row = $res->fetch_assoc()){
        $not_in .= $tag . $row['peus_usr_id'];
        if( $tag == "" )
            $tag = ",";
    }

    if( $not_in != "" ) {
        $and_not_in = " and usr_id not in ( $not_in )";
    }
    $MiTemplate->set_block("main", "Usuarios", "PBLUsuarios");
    $query = "select usr_id, usr_login, usr_apellidos, usr_nombres from usuarios where usr_login like '%$c_1%' $and_not_in and usr_estado = 1 order by usr_login";
    $res = $bd->query($query);
	while ($row = $res->fetch_assoc()){
			$MiTemplate->set_var("usr_id",$row['usr_id']);
			$MiTemplate->set_var("usr_login",$row['usr_login']);			
			$MiTemplate->set_var("usr_apellidos",$row['usr_apellidos']);
			$MiTemplate->set_var("usr_nombres",$row['usr_nombres']);
            $MiTemplate->parse("PBLUsuarios", "Usuarios", true);            			
	}
	$MiTemplate->parse("OUT_M", array("main"), true);
    $MiTemplate->p("OUT_M");
}

function asocia_usuario($bd, $id_padre, $usr_id ) {
    global $ses_usr_id;

    if(!bizcve::verificacionDePermisos($ses_usr_id,1, 'UPDATE')){
        general::alertexit('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }
    $userNombre = general::get_nombre_usr( $ses_usr_id );
    $usr_nombre =general::get_nombre_usr( $usr_id );

    bizcve::setevento(12, 'Modulo Perfiles', $_SERVER['REMOTE_ADDR'], 'ABM perfil',
                    'Asignacion de usuario '.$usr_nombre.' a Perfil  '.$id_padre.'','','Usuario asiganado a Perfil', $userNombre );

    if( $id_padre == "" )
        $id_padre = "NULL";

    $query_1 = "insert into perfilesxusuario( peus_usr_id, peus_per_id, peus_usr_crea, peus_fec_crea ) values ( $usr_id, $id_padre, '$usr_nombre', now() )";
	$res = $bd->query($query_1);
	$MiTemplate = new template;
	$MiTemplate->set_var("TITULO", TITULO);
	
    $MiTemplate->set_var("ID_PADRE",$id_padre);

    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_usr/adm_usr_03_2.html");

    $MiTemplate->parse("OUT_M", array("main"), true);
    $MiTemplate->p("OUT_M");

}

/**********************************************************************************************/

if( $action == 'addperusr' && $tipo == 1 )
    form_per_usr_2($bd, $id_padre );
else if( $action == 'addperusr' && $tipo == 2 )
    form_per_usr_3( $bd,$id_padre );
else if( $action == 'addperfil' )
    insert_perfil( $bd,$nombre_in, $descripcion_in, $id_padre );
else if( $action == 'seausr' )
    search_usuarios( $bd,$id_padre, $c_1 );
else if( $action == 'addusr' )
    asocia_usuario( $bd,$id_padre, $usr_id );
else
    form_per_usr_1( $bd,$id_padre );

/**********************************************************************************************/

?>