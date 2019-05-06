<?

///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../margenxproducto/adm_margen_01.php';

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

function listado_margenes($bd, $producto){
    $MiTemplate = new template;
    $MiTemplate->set_var('error_app', $mensaje_error);
    $MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("TEXT_TITULO", "Administracion de margenes ");
    $MiTemplate->set_var("SUBTITULO1", TEXT_2);
    $MiTemplate->set_var("TEXT_1",
                         "Seleccione la accion a realizar desde la barra de herramientas.");
    $MiTemplate->set_var("TEXT_SUB_USUARIOS", "Margenes del sistema");
    $MiTemplate->set_var("TEXT_BUSCAR_CAMPO_SKU", "Buscar");
    $MiTemplate->set_var("TEXT_BUSCAR_CAMPO_", "Tipo de b&uacute;squeda");
    $MiTemplate->set_var("BOTON_BUSCAR_USUARIO", "Buscar");
    $MiTemplate->set_var("BOTON_MODIFICAR_IMG",
                         '<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >');
    $MiTemplate->set_var("BOTON_ELIMINAR_IMG",
                         '<IMG SRC="../../IMAGES/trash.png" BORDER=0 >');
    $MiTemplate->set_var("BOTON_AGREGAR_IMG",
                         '<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >');

    $MiTemplate->set_var("productofield", $producto);
    $MiTemplate->set_var("selectedSKU",
                         (($_GET['tipoB'] != 'descrip') ? 'checked' : '')); //=='sku || carga inicial
    $MiTemplate->set_var("selectedDescrip",
                         (($_GET['tipoB'] == 'descrip') ? 'checked' : ''));

    /* para los botones */
    $BOTON_MODIFICAR_IMG = '<IMG SRC="../../IMAGES/edit_f2.jpg" BORDER=0 >';
    $BOTON_ELIMINAR_IMG  = '<IMG SRC="../../IMAGES/trash.png" BORDER=0 >';
    $BOTON_AGREGAR_IMG   = '<IMG SRC="../../IMAGES/new.png" HEIGHT="22" BORDER=0 >';
    $BOTON_LISTAR_IMG    = '<IMG SRC="../../IMAGES/lista.png" HEIGHT="22" BORDER=0 >';
    $BOTON_VOLVER_IMG    = '<IMG SRC="../../IMAGES/back.png" HEIGHT="22" BORDER=0 >';

    // Agregamos el header
    $MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");


    $MiTemplate->set_var("BARRA_HERRAMIENTAS", $barra_her);
    $MiTemplate->set_file("barra_her", TEMPLATE . "presentacion/barra.html");
    $MiTemplate->parse("OUT_BARRA", "barra_her");

    // Agregamos el main
    $MiTemplate->set_file("main", TEMPLATE . "margenxproducto/listado.html");

    // Recuperamos los modulos de la base
    $MiTemplate->set_block('main', "listadomargenes", "BLO_listadomargenes");

    $hayRes = FALSE;
    if($_GET['tipoB'] == 'sku' && is_numeric($producto)){//busco código
        //obtengo margen
        $query = "SELECT producto, margen "
                . "FROM margenxproducto "
                . "WHERE " . (($producto) ? ("producto = " . $producto) : "1");
        $res   = $bd->query($query);

        while($row = $res->fetch_assoc()){
            $descripciones[$row['producto']] = $row['producto']; //inicializo con basura
            $margenes[$row['producto']]      = $row['margen'];
            $hayRes                          = TRUE;
        }
        //obtengo descripción
        bizcve::getDescrSKU($descripciones);
    }elseif($_GET['tipoB'] == 'descrip'){
        //busco nombre
        $descripciones = bizcve::getSkuDescr($producto);
        @$l2            = array_keys($descripciones);
        $in            = '';
        $i             = 0;
        do{
            $in .= $l2[$i];
            $i++;
        }while($i < count($l2) && $in .= ', ');

        $query = "SELECT producto, margen "
                . "FROM margenxproducto "
                . "WHERE producto IN ($in)";
        $res   = $bd->query($query);

        while($row = $res->fetch_assoc()){
            //$descripciones[$row['producto']] = $row['producto']; //inicializo con basura
            $margenes[$row['producto']] = $row['margen'];
            $hayRes                     = TRUE;
        }
    }elseif($_GET['tipoB'] == 'sku' && !is_numeric($producto)){
        $MiTemplate->set_var('MSGERROR',
                             "El c&oacute;digo debe ser num&eacute;rico");
    }else{//general
        //obtengo margen
        $query = "SELECT producto, margen "
                . "FROM margenxproducto "
                . "WHERE 1 LIMIT 1000";
        $res   = $bd->query($query);

        while($row = $res->fetch_assoc()){
            $descripciones[$row['producto']] = $row['producto']; //inicializo con basura
            $margenes[$row['producto']]      = $row['margen'];
            $hayRes                          = TRUE;
        }
        //obtengo descripción
        bizcve::getDescrSKU($descripciones);
    }

    if($hayRes){
        foreach($margenes as $sku => $margen){
            $MiTemplate->set_var("producto", $sku);
            $MiTemplate->set_var("descripcion", $descripciones[$sku]);
            $MiTemplate->set_var("margen", $margen);
            $msg_aux = general::kid_href('adm_margen_01.php',
                                         "action=upd&margen_id=" . $sku,
                                         $BOTON_MODIFICAR_IMG, 'Modificar', '') . " ";
            $MiTemplate->set_var('ACCIONES', $msg_aux);
            $MiTemplate->parse("BLO_listadomargenes", "listadomargenes", true);
        }
    }
///////////////////////// ZONA PIE DE PAGINA /////////////////////////	
    $MiTemplate->parse("OUT_M", array("header", "main"), true);
    $MiTemplate->p("OUT_M");
}

function form_mod_margen($bd, $producto, $error){
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
    $barra_her = general::kid_href('adm_margen_01.php', '', $BOTON_VOLVER_IMG,
                                   $BOTON_VOLVER, '');

    $MiTemplate->set_var("BARRA_HERRAMIENTAS", $barra_her);
    $MiTemplate->set_file("barra_her", TEMPLATE . "presentacion/barra.html");
    $MiTemplate->parse("OUT_BARRA", "barra_her");

    // Recuperamos los datos del margen

    $query = "SELECT producto, margen "
            . "FROM margenxproducto "
            . "WHERE producto = " . $producto;
    $res   = $bd->query($query);

    $datosProd = null;
    while($row       = $res->fetch_assoc()){
        $MiTemplate->set_var("SKU", $row['producto']);
        $datosProd = bizcve::getDescrSKU($temp      = Array($row['producto'] => $row['producto']));
        $MiTemplate->set_var("descr", $datosProd[$row['producto']]['des']);
        $MiTemplate->set_var("desc_seccion", $row['desc_seccion']);
        $MiTemplate->set_var("margen", $row['margen']);
        $categoria = bizcve::getDatosMargen($datosProd[$producto]['cat']);
        $MiTemplate->set_var('datosCat',
                             $categoria['desc_seccion'] . '/' . $categoria['desc_rubro'] . ' (' . $categoria['margen'] . ')');
    }

    $msg_aux = general::kid_href('../margenxrubro/adm_margen_01.php',
                                 "action=upd&margen_id=" . $categoria['id_margen'] . "&producto=" . $producto,
                                 $BOTON_MODIFICAR_IMG,
                                 'Modificar Categor&iacute;a', '') . " ";

    $MiTemplate->set_var('BOTONCAT', $msg_aux);
    $MiTemplate->set_var('BOTON', 'Aplicar Cambios');

    // Agregamos el main
    $MiTemplate->set_file("main", TEMPLATE . "margenxproducto/form_mod.html");
    // Agregamos el footer
    $MiTemplate->parse("OUT_M", array("header", "main"), true);
    $MiTemplate->p("OUT_M");
}

function update_margen($bd, $margen_id, $margen){
    global $bd;

    $query_1 = "UPDATE margenxproducto "
            . "SET margen = $margen "
            . "WHERE producto = $margen_id";

    $res = $bd->query($query_1);
    general::writeevent('El margen ha sido modificado.');

    header("Location: adm_margen_01.php");
    exit();
}

if($action == 'upd'){
    form_mod_margen($bd, $margen_id, $error);
    include '../menu/menu.php';
    include '../menu/footer.php';
}else if($action == 'upd1'){
    update_margen($bd, $margen_id, $margen);
}else{
    listado_margenes($bd, $producto);
    include '../menu/menu.php';
    include '../menu/footer.php';
}
?>
