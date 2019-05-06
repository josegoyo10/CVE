<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../adm_funcionalidades_asignables/adm_funcionalidades_asignables.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

$bd = $_SESSION["DBACESS"];
if( isset( $_POST['perfiles'] ) )
{
    // To-Do: chequear que $_POST['perfiles'] sea valido y chequear que $_POST['perfiles_asignables'] y $_POST['funcionalidades_asignables'][$i] sea valido
    
    // borro los existentes
    $_SESSION["DBACESS"]->querynoselect("delete from funcionalidadesasignablesporperfil WHERE perfil_asignador_id=".(int)$_POST['perfiles']." and perfil_asignable_id=".(int)$_POST['perfiles_asignables']);    
    // asigno los nuevos
    for($i=0; $i < count($_POST['funcionalidades_asignables']); $i++ )
    {
        $_SESSION["DBACESS"]->querynoselect("insert into funcionalidadesasignablesporperfil (perfil_asignador_id, funcionalidad_id, perfil_asignable_id) values (".(int)$_POST['perfiles'].", ".(int)$_POST['funcionalidades_asignables'][$i].",".(int)$_POST['perfiles_asignables'].")");
    }
}

function listado_permisos( $bd,$patron) {
    $MiTemplate = new template;
    $MiTemplate->set_var('error_app', $mensaje_error);
    $MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("TEXT_TITULO","Administracion de funcionalidades asignables por perfil ");
    $MiTemplate->set_var("SUBTITULO1",TEXT_2);

    $MiTemplate->set_var("TEXT_1","Asigne las funcionalidades para el perfil.");


    // Agregamos el header
    $MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");

    $MiTemplate->set_var("BARRA_HERRAMIENTAS",$barra_her);
    $MiTemplate->set_file("barra_her",TEMPLATE."presentacion/barra.html");
    $MiTemplate->parse("OUT_BARRA","barra_her");

    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_funcionalidades_asignables/listado.html");

    // Perfiles

    $MiTemplate->set_block('main' , "perfiles" , "BLO_perfiles");   

    $List  = new connlist;
    bizcve::getperfiles($List);
    $List->gofirst();
    $i=0;
    if (!$List->isvoid()) 
    {
          do {    	
              $MiTemplate->set_var('id_perfil', $List->getelem()->id);			
              $MiTemplate->set_var('descripcion', $List->getelem()->nombre);   	 

              // el primer perfil por defecto
              if( !isset($_GET['perfil_asignador_id']) && $i == 0 )
              {  
                $iPerfilAsignadorID=$List->getelem()->id;
                $MiTemplate->set_var('selected', 'selected');
              }
              else
              {
                // marcamos el perfil seleccionado
                if( isset($_GET['perfil_asignador_id']) && ((int)$_GET['perfil_asignador_id']) == $List->getelem()->id )
                {
                  $iPerfilAsignadorID=$List->getelem()->id;
                  $MiTemplate->set_var('selected', 'selected');
                }
                else
                {
                   $MiTemplate->set_var('selected', '');
                }
              }
              $i++;      

              $MiTemplate->parse("BLO_perfiles", "perfiles", true);       

          } while ($List->gonext());
    }   

    // Perfiles Asignables

    $MiTemplate->set_block('main' , "perfiles_asignables" , "BLO_perfiles_asignables");   

    $List  = new connlist;
    bizcve::getperfiles($List);
    $List->gofirst();
    $i=0;
    if (!$List->isvoid()) 
    {
          do {    	
              $MiTemplate->set_var('id_perfil', $List->getelem()->id);			
              $MiTemplate->set_var('descripcion', $List->getelem()->nombre);  

              // el primer perfil por defecto
              if( !isset($_GET['perfil_asignado_id']) && $i == 0 )
              {  
                $iPerfilAsignadoID=$List->getelem()->id;
                $MiTemplate->set_var('selected', 'selected');
              }
              else
              {
                // marcamos el perfil seleccionado
                if( isset($_GET['perfil_asignado_id']) && ((int)$_GET['perfil_asignado_id']) == $List->getelem()->id )
                {
                  $iPerfilAsignadoID=$List->getelem()->id;
                  $MiTemplate->set_var('selected', 'selected');
                }
                else
                {
                   $MiTemplate->set_var('selected', '');
                }
              }
              $i++;        

              $MiTemplate->parse("BLO_perfiles_asignables", "perfiles_asignables", true);       

          } while ($List->gonext());
    }  



    // Fin Despliegue Perfiles   

    // Funcionalidades No Asignadas 

    $MiTemplate->set_block('main' , "funcionalidades_no_asignadas" , "BLO_funcionalidades_no_asignadas");   

    $List  = new connlist;
    bizcve::getfuncionalidadesasignables($List,$iPerfilAsignadorID,$iPerfilAsignadoID, false);  
    $List->gofirst();
    $i=0;  
    if (!$List->isvoid()) 
    {
          do {
          $MiTemplate->set_var('id_funcionalidad', $List->getelem()->id);			
          $MiTemplate->set_var('descripcion', $List->getelem()->nombre);    
          $MiTemplate->parse("BLO_funcionalidades_no_asignadas", "funcionalidades_no_asignadas", true);                
          } while ($List->gonext());   
    }  

    // Fin Funcionalidades No Asignadas

    // Funcionalidades Asignadas 

    $MiTemplate->set_block('main' , "funcionalidades_asignadas" , "BLO_funcionalidades_asignadas");   

    $List  = new connlist;
    bizcve::getfuncionalidadesasignables($List,$iPerfilAsignadorID,$iPerfilAsignadoID, true);  
    $List->gofirst();
    $i=0;  
    if (!$List->isvoid()) 
    {
          do {
          $MiTemplate->set_var('id_funcionalidad', $List->getelem()->id);			
          $MiTemplate->set_var('descripcion', $List->getelem()->nombre);    
          $MiTemplate->parse("BLO_funcionalidades_asignadas", "funcionalidades_asignadas", true);                
          } while ($List->gonext());   
    }    

    // Fin Funcionalidades Asignadas    

	///////////////////////// ZONA PIE DE PAGINA /////////////////////////	
	$MiTemplate->parse("OUT_M", array("header", "main"), true);
	$MiTemplate->p("OUT_M");

}

/**********************************************************************************************/

listado_permisos($bd, $patron );
include '../menu/menu.php';
include '../menu/footer.php';

/**********************************************************************************************/

//include "../../includes/application_bottom.php";

?>
