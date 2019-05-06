<?php


///////////////////////// ZONA DE INCLUSION /////////////////////////
//$pag_ini = '../reporteseguridad/reporte_seguridad.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
$MiTemplate->set_file("main", TEMPLATE . "reporteclientestotales/reporte_clientestotales.htm");

switch(strtolower(trim($_POST['enviarvalor']))){
    case 'exportar':
        $ListEnc = new connlist;

        $ListEnc->gofirst();
        $array = Array();
        bizcve::getClientesTotalesAsignados($ListEnc, $array);
        $ListEnc->gofirst();
        $file = '';
        $e = 'A';
        $elem = $ListEnc->getelem();
        $keys = array();
        foreach($elem as $key => $value){
            $file .= $key.";";
            $keys[$key] = $e;
            $ultima = $e;
            ++$e;
        }
        $file .= "\n";
        $i = 2;
        do{
            $elem = $ListEnc->getelem();
             $file .= implode(";", $elem)."\n";
         
        }while($ListEnc->gonext() && $i++);
        //se cambia time out de ejecucion.
        ini_set("max_execution_time",0);   
        
         
        header( 'Content-Type: text/plain' );
        header("Content-Length: ".strlen($file));
        header( 'Content-Disposition: attachment;filename='.'ClientesTotalesAsignados' . date('Ymd').'.csv');
        echo $file;
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








?>