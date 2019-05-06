<?php

///////////////////////// ZONA DE INCLUSION /////////////////////////
//$pag_ini = '../reporteseguridad/reporte_seguridad.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_file("main", TEMPLATE . "reportepermisosxmodulos/reporte_permisosxmodulos.htm");
switch(strtolower(trim($_POST['enviarvalor']))){
    case 'exportar':
        $ListEnc = new connlist;

        $ListEnc->gofirst();
        bizcve::getPermisosXModulo($ListEnc);
        $ListEnc->gofirst();

        require_once '../../INCLUDE/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        general::configureExcel($objPHPExcel, 'Centro Venta Empresa Colombia', 'Reporte de modulos');

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'ID')
                ->setCellValue('B1', 'Tipo')
                ->setCellValue('C1', 'PER_ID')
                ->setCellValue('D1', 'insert')
                ->setCellValue('E1', 'delete')
                ->setCellValue('F1', 'update')
                ->setCellValue('G1', 'select')
                ->setCellValue('H1', 'USR Crea')
                ->setCellValue('I1', 'Fecha Crea')
                ->setCellValue('J1', 'USR Mod')
                ->setCellValue('K1', 'Fecha MOD');
        $i = 2;
        do{
            $elem = $ListEnc->getelem();
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("A$i", utf8_encode($elem['PEMO_MOD_ID']))
                    ->setCellValue("B$i", utf8_encode($elem['PEMO_TIPO']))
                    ->setCellValue("C$i", utf8_encode($elem['PEMO_PER_ID']))
                    ->setCellValue("D$i", utf8_encode($elem['PEMO_INSERT']))
                    ->setCellValue("E$i", utf8_encode($elem['PEMO_DELETE']))
                    ->setCellValue("F$i", utf8_encode($elem['PEMO_UPDATE']))
                    ->setCellValue("G$i", utf8_encode($elem['PEMO_SELECT']))
                    ->setCellValue("H$i", utf8_encode($elem['PEMO_USR_CREA']))
                    ->setCellValue("I$i", utf8_encode($elem['PEMO_FEC_CREA']))
                    ->setCellValue("J$i", utf8_encode($elem['PEMO_USR_MOD']))
                    ->setCellValue("K$i", utf8_encode($elem['PEMO_FEC_MOD']));
        }while($ListEnc->gonext() && $i++);


        general::formatExcel($objPHPExcel, 'K', $i);
        general::downloadExcel($objPHPExcel, 'modulos' . date('Ymd'));


        break;
    case 'buscar':
        $ListEnc = new connlist;

        $ListEnc->gofirst();
        bizcve::getPermisosXModulo($ListEnc);

        $ListEnc->gofirst();

        //a partir de ac?: template.
        $MiTemplate->set_block('main', "reporteS", "BLO_reporteS");


        if(!$ListEnc->isvoid()){

            do{
                $elem = $ListEnc->getelem();
                $MiTemplate->set_var('ID', $elem['PEMO_MOD_ID']);
                $MiTemplate->set_var('tipo', $elem['PEMO_TIPO']);
                $MiTemplate->set_var('IDP', $elem['PEMO_PER_ID']);
                $MiTemplate->set_var('insert', $elem['PEMO_INSERT']);
                $MiTemplate->set_var('delete', $elem['PEMO_DELETE']);
                $MiTemplate->set_var('update', $elem['PEMO_UPDATE']);
                $MiTemplate->set_var('select', $elem['PEMO_SELECT']);
                $MiTemplate->set_var('ucrea', $elem['PEMO_USR_CREA']);
                $MiTemplate->set_var('fcrea', $elem['PEMO_FEC_CREA']);
                $MiTemplate->set_var('umod', $elem['PEMO_USR_MOD']);
                $MiTemplate->set_var('fmod', $elem['PEMO_FEC_MOD']);
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


