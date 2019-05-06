<?php

///////////////////////// ZONA DE INCLUSION /////////////////////////
//$pag_ini = '../reporteseguridad/reporte_seguridad.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_file("main", TEMPLATE . "reportemodulos/reporte_modulos.htm");
switch(strtolower(trim($_POST['enviarvalor']))){
    case 'exportar':
        $ListEnc = new connlist;

        $ListEnc->gofirst();
        bizcve::getModulos($ListEnc);
        $ListEnc->gofirst();

        require_once '../../INCLUDE/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        general::configureExcel($objPHPExcel, 'Centro Venta Empresa Colombia', 'Reporte de modulos');

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'ID')
                ->setCellValue('B1', 'Padre')
                ->setCellValue('C1', 'Estado')
                ->setCellValue('D1', 'Nombre')
                ->setCellValue('E1', utf8_encode('Descripción'))
                ->setCellValue('F1', 'URL')
                ->setCellValue('G1', 'Orden')
                ->setCellValue('H1', 'USR Crea')
                ->setCellValue('I1', 'Fecha Crea')
                ->setCellValue('J1', 'USR Mod')
                ->setCellValue('K1', 'Fecha MOD');
        $i = 2;
        do{
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("A$i", utf8_encode($ListEnc->getelem()->MOD_ID))
                    ->setCellValue("B$i", utf8_encode($ListEnc->getelem()->MOD_PADRE_ID))
                    ->setCellValue("C$i", utf8_encode($ListEnc->getelem()->MOD_ESTADO))
                    ->setCellValue("D$i", utf8_encode($ListEnc->getelem()->MOD_NOMBRE))
                    ->setCellValue("E$i", utf8_encode($ListEnc->getelem()->MOD_DESCRIPCION))
                    ->setCellValue("F$i", utf8_encode($ListEnc->getelem()->MOD_URL))
                    ->setCellValue("G$i", utf8_encode($ListEnc->getelem()->MOD_ORDEN))
                    ->setCellValue("H$i", utf8_encode($ListEnc->getelem()->MOD_USR_CREA))
                    ->setCellValue("I$i", utf8_encode($ListEnc->getelem()->MOD_FEC_CREA))
                    ->setCellValue("J$i", utf8_encode($ListEnc->getelem()->MOD_USR_MOD))
                    ->setCellValue("K$i", utf8_encode($ListEnc->getelem()->MOD_FEC_MOD))
                    ->getStyle("E$i")->getAlignment()->setWrapText(true);
        }while($ListEnc->gonext() && $i++);


        general::formatExcel($objPHPExcel, 'K', $i);
        general::downloadExcel($objPHPExcel, 'modulos' . date('Ymd'));


        break;
    case 'buscar':
        $ListEnc = new connlist;

        $ListEnc->gofirst();
        bizcve::getModulos($ListEnc);

        $ListEnc->gofirst();

        //a partir de ac?: template.
        $MiTemplate->set_block('main', "reporteS", "BLO_reporteS");


        if(!$ListEnc->isvoid()){

            do{         //ver ?ste bloque.
                $MiTemplate->set_var('ID', $ListEnc->getelem()->MOD_ID);
                $MiTemplate->set_var('padre', $ListEnc->getelem()->MOD_PADRE_ID);
                $MiTemplate->set_var('estado', $ListEnc->getelem()->MOD_ESTADO);
                $MiTemplate->set_var('nombre', $ListEnc->getelem()->MOD_NOMBRE);
                $MiTemplate->set_var('descr', $ListEnc->getelem()->MOD_DESCRIPCION);
                $MiTemplate->set_var('url', $ListEnc->getelem()->MOD_URL);
                $MiTemplate->set_var('orden', $ListEnc->getelem()->MOD_ORDEN);
                $MiTemplate->set_var('ucrea', $ListEnc->getelem()->MOD_USR_CREA);
                $MiTemplate->set_var('fcrea', $ListEnc->getelem()->MOD_FEC_CREA);
                $MiTemplate->set_var('umod', $ListEnc->getelem()->MOD_USR_MOD);
                $MiTemplate->set_var('fmod', $ListEnc->getelem()->MOD_FEC_MOD);
                $MiTemplate->parse("BLO_reporteS", "reporteS", true);
            }while($ListEnc->gonext());
            $MiTemplate->parse("BLO_completar", "completar", true);
        }



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


