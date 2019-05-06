<?

///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../margenxrubro/adm_margen_01.php';

include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////


$bd = $_SESSION["DBACESS"];

/* si tiene local asignado no puede administrar margenes */
if($ses_usr_codlocal){
    general::writelog('USR Tiene Local ' . $ses_usr_codlocal . ' - ' . $ses_usr_nomlocal);
    //header( "Location: ../start/sin_perm_01.php");	
}else{
    general::writelog('USR No local ' . $ses_usr_codlocal . ' - ' . $_SESSION["ses_usr_codlocal"] . ' - ' . $ses_usr_nomlocal);
}

function listado_margenes($bd, $patron, $patron2){
    $MiTemplate           = new template;
    $MiTemplate->set_var('error_app', $mensaje_error);
    $MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("TEXT_TITULO", "Administracion de margenes ");
    $MiTemplate->set_var("SUBTITULO1", TEXT_2);
    $MiTemplate->set_var("TEXT_1",
                         "Seleccione la accion a realizar desde la barra de herramientas.");
    $MiTemplate->set_var("TEXT_SUB_USUARIOS", "Margenes del sistema");
    $MiTemplate->set_var("TEXT_BUSCAR_CAMPO_SECCION", "Seccion a Buscar");
    $MiTemplate->set_var("TEXT_BUSCAR_CAMPO_RUBRO", "Rubro a Buscar");
    $MiTemplate->set_var("BOTON_BUSCAR_USUARIO", "Buscar");
    $MiTemplate->set_var("BOTON_MODIFICAR_IMG",
                         '<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >');
    $MiTemplate->set_var("BOTON_ELIMINAR_IMG",
                         '<IMG SRC="../../IMAGES/trash.png" BORDER=0 >');
    $MiTemplate->set_var("BOTON_AGREGAR_IMG",
                         '<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >');
    $MiTemplate->set_var("patron", $patron);
    $MiTemplate->set_var("patron2", $patron2);
    /* para los botones */
    $BOTON_MODIFICAR_IMG  = '<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >';
    $BOTON_ELIMINAR_IMG   = '<IMG SRC="../../IMAGES/trash.png" BORDER=0 >';
    $BOTON_AGREGAR_IMG    = '<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >';
    $BOTON_LISTAR_IMG     = '<IMG SRC="../../IMAGES/lista.png" HEIGHT="22" BORDER=0 >';
    $BOTON_VOLVER_IMG     = '<IMG SRC="../../IMAGES/back.png" HEIGHT="22" BORDER=0 >';
    $CONFIRM_ELIMINAR_USR = '&#191; Est&#225 seguro que desea eliminar el Usuario&#63;';

    // Agregamos el header
    $MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");

    // Agregamos la barra de herramientas
    //   if( general::se_puede( 'i', PERMISOS_MOD ) )
    //       $barra_her .= " " . general::kid_href( 'adm_margen_01.php', 'action=ins', $BOTON_AGREGAR_IMG, 'Agregar', '' );
    //$barra_her .= " " . general::kid_href( 'adm_marge_01.php', 'action=ins', $BOTON_AGREGAR_IMG, 'Agregar', '' );          

    $MiTemplate->set_var("BARRA_HERRAMIENTAS", $barra_her);
    $MiTemplate->set_file("barra_her", TEMPLATE . "presentacion/barra.html");
    $MiTemplate->parse("OUT_BARRA", "barra_her");

    // Agregamos el main
    $MiTemplate->set_file("main", TEMPLATE . "margenxrubro/listado.html");

    // Recuperamos los modulos de la base
    $MiTemplate->set_block('main', "listadomargenes", "BLO_listadomargenes");

    if($patron){
        $add_que = " and ( desc_seccion like '%$patron%')";
    }
    if($patron2){
        $add_que1 = " and ( desc_rubro like '%" . $patron2 . "%')";
    }

    $query = "SELECT id_margen, id_seccion, desc_seccion, id_rubro, desc_rubro, margen "
            . "FROM margenxrubro "
            . "WHERE 1 $add_que $add_que1";

    $res = $bd->query($query);

    if($res){
        while($row = $res->fetch_assoc()){
            $MiTemplate->set_var("seccion", $row['desc_seccion']);
            $MiTemplate->set_var("rubro", $row['desc_rubro']);
            $MiTemplate->set_var("margen", $row['margen']);
            $msg_aux = general::kid_href('adm_margen_01.php',
                                         "action=upd&margen_id=" . $row['id_margen'],
                                         $BOTON_MODIFICAR_IMG, 'Modificar', '') . " ";
            $MiTemplate->set_var('ACCIONES', $msg_aux);
            $MiTemplate->parse("BLO_listadomargenes", "listadomargenes", true);
        }
    }

    $MiTemplate->set_var('mgeneral', MARGEN_COTIZADOR);
    $msg_aux = general::kid_href('adm_margen_01.php',
                                 "action=upd&margen_id=general",
                                 $BOTON_MODIFICAR_IMG, 'Modificar', '') . " ";
    $MiTemplate->set_var('mgeneralboton', $msg_aux);
///////////////////////// ZONA PIE DE PAGINA /////////////////////////	
    $MiTemplate->parse("OUT_M", array("header", "main"), true);
    $MiTemplate->p("OUT_M");
}

function form_mod_margen($bd, $margen_id, $error){
    $MiTemplate = new template();
    $MiTemplate->set_var('error_app', $mensaje_error);
    $MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("TEXT_TITULO", "Administracion de margenes ");
    $MiTemplate->set_var("TEXT", 'Modifique el margen mInimo permitido.');
    $MiTemplate->set_var("TEXT_SUB", "Modificar margen ");

    $MiTemplate->set_var("TEXT_ASOCIAR_CAMPO_1", "Listar");
    $MiTemplate->set_var("TEXT_ASOCIAR_CAMPO_2", "Agregar");
    $MiTemplate->set_var("TEXT_ASOCIAR_CAMPO_3", "Eliminar");
    $MiTemplate->set_var("TEXT_ASOCIAR_CAMPO_4", "Modificar");
    $MiTemplate->set_var("usr_id", $usr_id);
    /* para los botones */
    $BOTON_MODIFICAR_IMG = '<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >';
    $BOTON_ELIMINAR_IMG  = '<IMG SRC="../../IMAGES/trash.png" BORDER=0 >';
    $BOTON_AGREGAR_IMG   = '<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >';
    $BOTON_LISTAR_IMG    = '<IMG SRC="../../IMAGES/lista.png" HEIGHT="22" BORDER=0 >';
    $BOTON_VOLVER_IMG    = '<IMG SRC="../../IMAGES/back.png" HEIGHT="22" BORDER=0 >';
    if($error == 1) $MiTemplate->set_var("TEXT_ERROR", TEXT_CAMPO_EXISTE);

    // Agregamos el header
    $MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");

    // Agregamos la barra de herramientas
    if($producto = $_GET['producto']){
        $barra_her = general::kid_href('../margenxproducto/adm_margen_01.php',
                                       'action=upd&margen_id=' . $producto,
                                       $BOTON_VOLVER_IMG, $BOTON_VOLVER, '');
        $MiTemplate->set_var('inputProducto',
                             '<INPUT TYPE="hidden" NAME="producto" VALUE="' . $producto . '">');
    }else{
        $barra_her = general::kid_href('adm_margen_01.php', '',
                                       $BOTON_VOLVER_IMG, $BOTON_VOLVER, '');
    }

    $MiTemplate->set_var("BARRA_HERRAMIENTAS", $barra_her);
    $MiTemplate->set_file("barra_her", TEMPLATE . "presentacion/barra.html");
    $MiTemplate->parse("OUT_BARRA", "barra_her");

    // Recuperamos los datos del margen

    if($margen_id == 'general'){
        $query = "SELECT VAR_VALOR AS margen "
                . "FROM glo_variables "
                . "WHERE VAR_LLAVE = 'MARGEN_COTIZADOR'";
        $res   = $bd->query($query);

        while($row = $res->fetch_assoc()){
            $MiTemplate->set_var("margen_id", 'general');
            $MiTemplate->set_var("desc_rubro", 'MARGEN MINIMO GENERAL');
            $MiTemplate->set_var("desc_seccion", 'MARGEN MINIMO GENERAL');
            $MiTemplate->set_var("margen", $row['margen']);
        }
    }else{
        $query = "SELECT id_margen, desc_seccion, desc_rubro, margen "
                . "FROM margenxrubro "
                . "WHERE id_margen = $margen_id";
        $res   = $bd->query($query);
        while($row   = $res->fetch_assoc()){
            $MiTemplate->set_var("margen_id", $row['id_margen']);
            $MiTemplate->set_var("desc_rubro", $row['desc_rubro']);
            $MiTemplate->set_var("desc_seccion", $row['desc_seccion']);
            $MiTemplate->set_var("margen", $row['margen']);
        }
    }
    // Agregamos el main
    $MiTemplate->set_file("main", TEMPLATE . "margenxrubro/form_mod.html");
    // Agregamos el footer
    $MiTemplate->parse("OUT_M", array("header", "main"), true);
    $MiTemplate->p("OUT_M");
}


function update_margen($bd, $margen_id, $margen){
    global $ses_usr_codlocal,$bd,$local,$ses_usr_id, $usr_nombres, $usr_apellidos,$tipousuario,$usr_email,$local, $usr_login, $usr_clave, $usr_estado,$codigovendedor;


    if(!bizcve::verificacionDePermisos($ses_usr_id,125, 'DELETE')){
        general::alertexitredirect('No tiene permisos para ejecutar la funcionalidad solicitada');  
    }

    // $query_1 = "update margenxrubro set margen = $margen, usr_usr_mod = '$usr_nombre', usr_fec_mod = now() where usr_id = $margen_id";

    if($margen_id == 'general'){
        $query_1 = "UPDATE glo_variables "
                . "SET VAR_VALOR = $margen "
                . "WHERE VAR_LLAVE = 'MARGEN_COTIZADOR'";
    }else{
        $query_1 = "UPDATE margenxrubro "
                . "SET margen = $margen "
                . "WHERE id_margen = $margen_id";
    }
    $res = $bd->query($query_1);
    general::writeevent('El margen ha sido modificado.');

    global $ses_usr_id;
    $usr_nombre =general::get_nombre_usr( $ses_usr_id );

        bizcve::setevento(40, 'Modulo Administracion de Margenes', $_SERVER['REMOTE_ADDR'], 'ABM Sistemas',
                    'Se ha modificado el margen','','Margen  modificado', $usr_nombre );

    if($producto = $_POST['producto']){
        header("Location: ../margenxproducto/adm_margen_01.php?action=upd&margen_id=" . $producto);
    }else{
        header("Location: adm_margen_01.php");
    }
    exit();
}

if($action == 'upd'){
    form_mod_margen($bd, $margen_id, $error);
    include '../menu/menu.php';
    include '../menu/footer.php';
}elseif($action == 'upd1'){
    update_margen($bd, $margen_id, $margen);
}else{
    listado_margenes($bd, $patron, $patron2);
    include '../menu/menu.php';
    include '../menu/footer.php';
}
?>
