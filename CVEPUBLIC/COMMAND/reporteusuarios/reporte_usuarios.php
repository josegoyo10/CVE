<?php

///////////////////////// ZONA DE INCLUSION /////////////////////////
//$pag_ini = '../reporteseguridad/reporte_seguridad.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_file("main", TEMPLATE . "reporteusuarios/reporte_usuarios.htm");
switch(strtolower(trim($_POST['enviarvalor']))){
    case 'exportar':
        $ListEnc = new connlist;

        $ListEnc->gofirst();
        bizcve::getTablaUsuarios($ListEnc);
        $ListEnc->gofirst();

        require_once '../../INCLUDE/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        general::configureExcel($objPHPExcel, 'Centro Venta Empresa Colombia', 'Reporte de Usuarios');
        
        $elem = $ListEnc->getelem();
        $e = 'A';
        $keys = array();
        foreach($elem as $key => $value){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($e.'1', $key);
            $keys[$key] = $e;
            $ultima = $e;
            ++$e;
        }

        $i = 2;
        do{
            $elem = $ListEnc->getelem();
            foreach($elem as $key => $value){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($keys[$key].$i, utf8_encode($value));
            }
        }while($ListEnc->gonext() && $i++);

        
        general::formatExcel($objPHPExcel, $ultima, $i);
        general::downloadExcel($objPHPExcel, 'usuarios' . date('Ymd'));


        break;


    default:

        $MiTemplate->set_var("TITULO", TITULO);

        $MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
        //$MiTemplate->set_var('error_app', $mensaje_error);



        /* FIN DESPLIEGUE */
        $MiTemplate->pparse("OUT_H", array("header"), false);

        $MiTemplate->parse("OUT_M", array("main"), true);
        $MiTemplate->p("OUT_M");

        ///////////////////////// ZONA PIE DE PAGINA /////////////////////////
        include '../menu/menu.php';
        include '../menu/footer.php';
        break;
}


