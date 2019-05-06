<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
//$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_file("main", TEMPLATE ."reporte_mediospago_entvta/reporte_mediospago_entvta.htm");

//Recuperamos y asignamos los parámetros de consulta

/*** Fecha de Inicio ***/
	$MiTemplate->set_var("fec_valid",$_REQUEST['fec_valid']);	
	$fecinicio = ($_REQUEST['fec_valid'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid']) . ' 00:00:00':null;
/*** Fecha de Termino ***/
	$MiTemplate->set_var("fec_valid2",$_REQUEST['fec_valid2']);	
	$fectermino = ($_REQUEST['fec_valid2'])?general::formato_fecha_FORM2DB($_REQUEST['fec_valid2']) . ' 00:00:00':null;


//Mostramos el detalle del reporte
if ($_REQUEST['accion'] == 'ver') {
	//Ejecutamos la consulta
        
	$ListEnc = new connlist;
        $mRegistro = new dtoreporte;

	$mRegistro->fecinicio = $fecinicio;
	$mRegistro->fectermino = $fectermino;
	
	$ListEnc->addlast($mRegistro);
                
        $ListEnc->gofirst();
        $hay = bizcve::getMedioPagoEntregaVenta($ListEnc);
        
       
        if ($hay > 0){
            
            
            
            $msg_error=" ";
            $ListEnc->gofirst();
            $file = '';
            //$e = 'A';
            $elem = $ListEnc->getelem();

            $keys = array();
            foreach($elem as $key => $value){
                $file .= $key.";";
    
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
            header( 'Content-Disposition: attachment;filename='.'Medios de Pago y Entrega Venta_' . date('dmY').'.csv');
            echo $file;

        }else {
          general::alert('No se encontraron datos para el rango seleccionado' );

        }
       
}

/*FIN DESPLIEGUE*/

$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>