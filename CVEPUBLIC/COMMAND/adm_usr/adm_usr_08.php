<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
$bd = $_SESSION["DBACESS"];


function form_eliminar($bd, $usr_id, $perfil ) {
	global $ses_usr_id;
	$MiTemplate = new template;
	$MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("PER_O",$perfil);
    $MiTemplate->set_var("USR_ID",$usr_id);
    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_usr/adm_usr_08_1.html");

    $MiTemplate->parse("OUT_M", array("main"), true);
    $MiTemplate->p("OUT_M");

}

function delete_usuario( $bd,$usr_id, $per_o ) {

    global $ses_usr_id;

    $usr_eliminado =general::get_nombre_usr( $usr_id );
    $userNombre = general::get_nombre_usr( $ses_usr_id );

    if(!bizcve::verificacionDePermisos($ses_usr_id,1, 'DELETE')){
        general::alertexit('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }    

    bizcve::setevento(13, 'Modulo Perfiles', $_SERVER['REMOTE_ADDR'], 'ABM perfil',
                    'Se elimina usuario '.$usr_eliminado.'','','Usuario eliminado de Perfil', $userNombre );


    $query_1 = "delete from perfilesxusuario where peus_usr_id = $usr_id and peus_per_id = $per_o";
	$res = $bd->query($query_1);
    general::writeevent('Se ha eliminado un perfil de la tabla perfilesxusuario '); 		
	$MiTemplate = new template;
    $MiTemplate->set_var("ID_PADRE",$per_o);

    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_usr/adm_usr_03_2.html");

    $MiTemplate->parse("OUT_M", array("main"), true);
    $MiTemplate->p("OUT_M");

}

/**********************************************************************************************/

if( $action == 'delusr' )
    delete_usuario( $bd,$usr_id, $per_o );
else
    form_eliminar($bd, $usr_id, $per_o );

/**********************************************************************************************/

?>