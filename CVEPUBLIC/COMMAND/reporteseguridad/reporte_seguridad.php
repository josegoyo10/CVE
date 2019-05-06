<?php

function tipoSEANumTipo($s){ //devuelve (por número) el grupo de eventos que se necesita.
    switch ($s){
        case 'todos':
            return 0;
        case 'eveLogin':
            return 1;
        case 'eveABMUsuario':
            return 2;
        case 'eveABMPerfiles':
            return 3;
        case 'eveDepuracion':
            return 4;
        case 'eveCriticas':
            return 5;
    }  
}

function fechaStringAInt($s) { //tal vez debiera ir afuera, ya que puede que se la use al generar los registros.
    $q = explode('/', $s); //convierte un string que representa una fecha, con formato dd/mm/yyyy a un string que representa una fecha con formato yyyy-mm-dd
    if(count($q)<3){
        return false;
    }
    return $q[2]."-".$q[1]."-".$q[0];
}






///////////////////////// ZONA DE INCLUSION /////////////////////////
//$pag_ini = '../reporteseguridad/reporte_seguridad.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
	//lo pongo acá para que no genere template (genera un csv con el contenido del html si no)
if ($_POST['enviarvalor'] == 1){ //excel
        $feini = fechaStringAInt($_POST['feini']);
        $fefin = fechaStringAInt($_POST['fefin']);//cambiar del formato de la fecha
        $ListEnc  = new connlist;
        $mRegistro = new dtoevento();
        
        $mRegistro->id_evento = tipoSEANumTipo($_POST['tipoEvento']);
        $mRegistro->feini = $feini;
        $mRegistro->fefin = $fefin;
        $ListEnc->addlast($mRegistro);
   
        $ListEnc->gofirst(); 
        bizcve::geteventoEX($ListEnc);
        
}else{
        $MiTemplate = new template;
        $MiTemplate->set_var("TITULO", TITULO);

        $MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
        //$MiTemplate->set_var('error_app', $mensaje_error);

        $MiTemplate->set_file("main", TEMPLATE . "reporteseguridad/reporte_seguridad.htm");
        /*DESPLIEGUE*/
        $ListEnc  = new connlist;

        $mRegistro = new dtoevento();
        
        $MiTemplate->set_var('noResultsA', '<!--');
        $MiTemplate->set_var('noResultsB', '-->');

        if($_POST['enviarvalor'] == 2  ){//llenar tabla con valores
                $MiTemplate->set_var('fechaucofini',$_POST['feini']);
                $MiTemplate->set_var('fechaucoffin',$_POST['fefin']);
                $feini = fechaStringAInt($_POST['feini']);
                $fefin = fechaStringAInt($_POST['fefin']);//cambiar del formato de la fecha


                $mRegistro->id_evento = tipoSEANumTipo($_POST['tipoEvento']);
                $mRegistro->feini = $feini;
                $mRegistro->fefin = $fefin;
                $ListEnc->addlast($mRegistro);

                
                $ListEnc->gofirst();
                
                $cantidadEventos = bizcve::getevento($ListEnc);
                $ListEnc->gofirst();

                //a partir de acá: template.
                $MiTemplate->set_block('main' , "reporteS" , "BLO_reporteS");
                $MiTemplate->set_block('main' , "validar" , "BLO_validar");
                        
                                
                              $MiTemplate->set_var('tipo', $_REQUEST['selectidoc']);
                              
                              if($cantidadEventos > 0){
                                  $MiTemplate->set_var('noResultsA', '<!--');
                                  $MiTemplate->set_var('noResultsB', '-->');
                                do{         //ver éste bloque.
                                        $MiTemplate->set_var('ID',$ListEnc->getelem()->id_evento);
                                        $MiTemplate->set_var('tipo',$ListEnc->getelem()->tipo_evento);
                                        $MiTemplate->set_var('fecha',$ListEnc->getelem()->fecha);
                                        $MiTemplate->set_var('tipoObjeto',$ListEnc->getelem()->tipoObjeto);
                                        $MiTemplate->set_var('ip',$ListEnc->getelem()->ip_cliente);
                                        $MiTemplate->set_var('nombre',$ListEnc->getelem()->nombre_objeto);
                                        $MiTemplate->set_var('descripcion',$ListEnc->getelem()->descripcion);
                                        $MiTemplate->set_var('estadoAnt',$ListEnc->getelem()->estado_anterior);
                                        $MiTemplate->set_var('EstadoPos',$ListEnc->getelem()->estado_posterior);
										$MiTemplate->set_var('Usuario',$ListEnc->getelem()->usuario);
                                        $MiTemplate->parse("BLO_reporteS", "reporteS", true);

                                } while ($ListEnc->gonext());
                              }else{
                                  $MiTemplate->set_var('noResultsA', '');
                                  $MiTemplate->set_var('noResultsB', '');
                              }
                                
                                 $MiTemplate->parse("BLO_completar", "completar", true); 
                        
                 $MiTemplate->set_var('feini',$_POST['feini']);
                $MiTemplate->set_var('fefin',$_POST['fefin']);
                 switch ($_POST['tipoEvento']){
                                case 'todos':
                                        $MiTemplate->set_var('selected0', 'selected');
                                        break;
                                case 'eveLogin':
                                        $MiTemplate->set_var('selected1', 'selected');
                                        break;
                                case 'eveABMUsuario':
                                        $MiTemplate->set_var('selected2', 'selected');
                                        break;
                                case 'eveABMPerfiles':
                                        $MiTemplate->set_var('selected3', 'selected');
                                        break;
                                case 'eveDepuracion':
                                        $MiTemplate->set_var('selected4', 'selected');
                                        break;
                                case 'eveCriticas':
                                        $MiTemplate->set_var('selected5', 'selected');
                                        break;
                            }

                //echo "FUERA CICLO LIST IS VOID";
        }  else {
        $MiTemplate->set_block('main' , "validar" , "BLO_validar");
        
        }
        /*FIN DESPLIEGUE*/
        $MiTemplate->pparse("OUT_H", array("header"), false);

        $MiTemplate->parse("OUT_M", array("main"), true);
        $MiTemplate->p("OUT_M");

        ///////////////////////// ZONA PIE DE PAGINA /////////////////////////
        include '../menu/menu.php';
        include '../menu/footer.php';
}

