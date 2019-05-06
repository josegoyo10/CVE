<?php

 // ini_set('display_errors', 1);
 // ini_set('display_startup_errors', 1);
 // error_reporting(E_ALL);  

///////////////////////// ZONA DE INCLUSION /////////////////////////
    $pag_ini = '../reporteseguridad/reporte_seguridad.php';
    include_once("../../INCLUDE/ini.php");
    include_once("../../INCLUDE/autoload.php");
    include_once("../../INCLUDE/aplication_top.php");



///////////////////////// ZONA DE ACCIONES /////////////////////////
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
    $MiTemplate = new template;
    $MiTemplate->set_file("main", TEMPLATE . "reporteclientescompras/reporte_clientescompra.htm");

/*** Fecha de Inicio ***/
    $MiTemplate->set_var("fec_valid",$_REQUEST['fec_valid']);   
    $fecinicio = ($_REQUEST['fec_valid'])?general::formato_fecha_english($_REQUEST['fec_valid']):'';
/*** Fecha de Termino ***/
    $MiTemplate->set_var("fec_valid2",$_REQUEST['fec_valid2']); 
    $fectermino = ($_REQUEST['fec_valid2'])?general::formato_fecha_english($_REQUEST['fec_valid2']):'';

   $fecha_inicio     = $fecinicio;
   $fecha_fin        =  $fectermino;
      

/*** Seleccione usuario ***/
$List = new connlist;
$mRegistro= new dtousuario;
$mRegistro->id_tipousuario='1,2';
$mRegistro->usr_tipo='VE';
$mRegistro->usr_estado=" 0";


//Obtener todos los Vendedores
   $List->addlast($mRegistro);
    bizcve::GetUsers($List);
    $List->gofirst();
    $MiTemplate->set_block('main' , "usuario" , "BLO_usuario");
    if (!$List->isvoid()) {
        do {
            if($List->getelem()->codigovendedor){
                $MiTemplate->set_var('codigousuario',$List->getelem()->codigovendedor);
                $MiTemplate->set_var('nomusuario',$List->getelem()->usr_nombres." ".$List->getelem()->usr_apellidos." (".($List->getelem()->cod_local?$List->getelem()->cod_local:'LOCAL NO ASIGNADO').")");
                $MiTemplate->set_var('selecteda', ($_POST['select_usuario']==$List->getelem()->codigovendedor)?'selected':'-1');
                $MiTemplate->parse("BLO_usuario", "usuario", true);
            }
        } while ($List->gonext());
    }
$codusuario = $_POST['select_usuario'];
/*Fin Seleccion usuario*/


   if ((trim($_REQUEST['tipo_reporte'])) == 1){
  
        $ListEnc = new connlist;

        $ListEnc->gofirst();
        $array = Array();
        bizcve::getClientescompra($ListEnc,$fecha_inicio, $fecha_fin,$codusuario,$array);
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
        header( 'Content-Disposition: attachment;filename='.'ClientesCompras' . date('Ymd').'.csv');
        echo $file;


            
    } elseif ((trim($_REQUEST['tipo_reporte'])) == 2) {

     
        // echo "Tipo 2:".$_REQUEST['tipo_reporte']."<br>\n";
       //  echo "F.ini: ". $fecinicio."<br>";
  
       $ListEnc = new connlist;

        $ListEnc->gofirst();
        $array = Array();
        bizcve::getClientesnocompra($ListEnc,$fecha_inicio, $fecha_fin,$codusuario,$array);
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

         //Llamar funcion para limpiar la tabla temporal.
         $name_table = 'usuarios_temporal';
         bizcve::truncatetabla($name_table);

        //se cambia time out de ejecucion.
        ini_set("max_execution_time",0);   
        
         
        header( 'Content-Type: text/plain' );
        header("Content-Length: ".strlen($file));
        header( 'Content-Disposition: attachment;filename='.'ClientessinCompras' . date('Ymd').'.csv');
        echo $file;

      
       }


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