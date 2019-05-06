<?php

///////////////////////// ZONA DE INCLUSION /////////////////////////
//$pag_ini = '../reporteseguridad/reporte_seguridad.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_file("main", TEMPLATE . "reporteperfiles/reporte_perfiles.htm");
switch(strtolower(trim($_POST['enviarvalor']))){
    case 'exportar':
        $ListEnc = new connlist;

        $ListEnc->gofirst();
        bizcve::getPerfiles($ListEnc, true);
        $ListEnc->gofirst();

        require_once '../../INCLUDE/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        general::configureExcel($objPHPExcel, 'Centro Venta Empresa Colombia', 'Reporte de perfiles');

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'ID')
                ->setCellValue('B1', 'Nombre')
                ->setCellValue('C1', utf8_encode('Descripción'))
                ->setCellValue('D1', 'Padre')
                ->setCellValue('E1', 'USR Crea')
                ->setCellValue('F1', 'Fecha Crea')
                ->setCellValue('G1', 'USR MOD')
                ->setCellValue('H1', 'Fecha MOD')
                ->setCellValue('I1', utf8_encode('Sólo lectura'));
        $i = 2;
        do{
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("A$i", utf8_encode($ListEnc->getelem()->id))
                    ->setCellValue("B$i", utf8_encode($ListEnc->getelem()->nombre))
                    ->setCellValue("C$i", utf8_encode($ListEnc->getelem()->descripcion))
                    ->setCellValue("D$i", utf8_encode($ListEnc->getelem()->padre_id))
                    ->setCellValue("E$i", utf8_encode($ListEnc->getelem()->usr_crea))
                    ->setCellValue("F$i", utf8_encode($ListEnc->getelem()->fec_crea))
                    ->setCellValue("G$i", utf8_encode($ListEnc->getelem()->usr_mod))
                    ->setCellValue("H$i", utf8_encode($ListEnc->getelem()->fec_mod))
                    ->setCellValue("I$i", utf8_encode($ListEnc->getelem()->solo_lectura))
                    ->getStyle("C$i")->getAlignment()->setWrapText(true);
        }while($ListEnc->gonext() && $i++);


        general::formatExcel($objPHPExcel, 'I', $i);
        general::downloadExcel($objPHPExcel, 'perfiles' . date('Ymd'));


        break;
    case 'buscar':
        $ListEnc = new connlist;

        $ListEnc->gofirst();
        bizcve::getPerfiles($ListEnc, true);

        $ListEnc->gofirst();

        //a partir de ac?: template.
        $MiTemplate->set_block('main', "reporteS", "BLO_reporteS");


        if(!$ListEnc->isvoid()){

            do{         //ver ?ste bloque.
                $MiTemplate->set_var('ID', $ListEnc->getelem()->id);
                $MiTemplate->set_var('nombre', $ListEnc->getelem()->nombre);
                $MiTemplate->set_var('descripcion', $ListEnc->getelem()->descripcion);
                $MiTemplate->set_var('padre_id', $ListEnc->getelem()->padre_id);
                $MiTemplate->set_var('usr_crea', $ListEnc->getelem()->usr_crea);
                $MiTemplate->set_var('fec_crea', $ListEnc->getelem()->fec_crea);
                $MiTemplate->set_var('usr_mod', $ListEnc->getelem()->usr_mod);
                $MiTemplate->set_var('fec_mod', $ListEnc->getelem()->fec_mod);
                $MiTemplate->set_var('solo_lectura', $ListEnc->getelem()->solo_lectura);
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


