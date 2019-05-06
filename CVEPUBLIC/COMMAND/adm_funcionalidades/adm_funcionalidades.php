<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../adm_funcionalidades/adm_funcionalidades.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

$bd = $_SESSION["DBACESS"];

$strErrorMessage='';
if( isset( $_POST['perfil_id'] ) )
{  
    
    // To-Do: chequear que $_POST['perfil_id'] es valido y chequear que $_POST['funcionalidades_asignados'] son validos
    
    // borro todas las funcionalidades asociadas a este perfil

    // Obtengo los ID de los perfiles del usuario logeado
    $res = $bd->query("select peus_per_id as perfil_id from perfilesxusuario where peus_usr_id=".$ses_usr_id);      
    if (!$res)
    {
        throw new DAOException(__CLASS__ , __FUNCTION__ , $bd->error(), "select peus_per_id as perfil_id from perfilesxusuario where peus_usr_id=".$ses_usr_id, 1);
    }
    $strPerfilesIDs='(';
    while ($row = $res->fetch_assoc()){
      $strPerfilesIDs.=$row['perfil_id'].',';     
    }
    $strPerfilesIDs.='-999)';

    // borro todas las funcionalidades asociadas a este perfil que puede llegar a asignar este perfil
    $bd->querynoselect("delete from perfilesxfuncionalidad where funcionalidad_id in (select funcionalidad_id from funcionalidadesasignablesporperfil where perfil_asignador_id in $strPerfilesIDs and perfil_asignable_id=".(int)$_POST['perfil_id']." ) and perfil_id=".(int)$_POST['perfil_id']);

    // asigno los nuevos
    for($i=0; $i < count($_POST['funcionalidades_asignados']); $i++ )
    {
        // me fijo si el perfil del usuario puede asignar esta funcionalidad a este perfil
        $res = $bd->query("select funcionalidad_id from funcionalidadesasignablesporperfil where perfil_asignador_id in $strPerfilesIDs and funcionalidad_id=".(int)$_POST['funcionalidades_asignados'][$i]." and perfil_asignable_id=".(int)$_POST['perfil_id']);                      
        if (!$res)
        {
            throw new DAOException(__CLASS__ , __FUNCTION__ , $bd->error(), "select funcionalidad_id from funcionalidadesasignablesporperfil where perfil_asignador_id in $strPerfilesIDs and perfil_asignable_id=".(int)$_POST['perfil_id'], 1);
        }      
        if( $bd->num_rows() != 0 )
        {
            // la funcionalidad es asignable por este perfil a este perfil
            $bd->querynoselect("insert into perfilesxfuncionalidad (perfil_id, funcionalidad_id) values (".(int)$_POST['perfil_id'].", ".(int)$_POST['funcionalidades_asignados'][$i].")");   
        }
        else
        {
            // la funcionalidad no es asignable por este perfil a este perfil
            $strErrorMessage='No tiene permisos para asociar alguna de las funcionalidades, intente nuevamente.';
        }
        
    }
}

if($strErrorMessage!='')
{
    echo "<script type='text/javascript'>alert('$strErrorMessage');</script>";
}

function listado_permisos( $bd,$patron) {
    $MiTemplate = new template;
    $MiTemplate->set_var('error_app', $mensaje_error);
    $MiTemplate->set_var("TITULO", TITULO);
    $MiTemplate->set_var("TEXT_TITULO","Administracion de funcionalidades por perfil ");
    $MiTemplate->set_var("SUBTITULO1",TEXT_2);
    
    $MiTemplate->set_var("TEXT_1","Asigne las funcionalidades para el perfil.");
    
    // Agregamos el header
    $MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
    
    $MiTemplate->set_var("BARRA_HERRAMIENTAS",$barra_her);
    $MiTemplate->set_file("barra_her",TEMPLATE."presentacion/barra.html");
    $MiTemplate->parse("OUT_BARRA","barra_her");
    
    // Agregamos el main
    $MiTemplate->set_file("main",TEMPLATE."adm_funcionalidades/listado.html");    

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
        if( !isset($_GET['perfil_id']) && $i == 0 )
        {  
          $iPerfil_id=$List->getelem()->id;
          $MiTemplate->set_var('selected', 'selected');
        }
        else
        {
          // marcamos el perfil seleccionado
          if( isset($_GET['perfil_id']) && ((int)$_GET['perfil_id']) == $List->getelem()->id )
          {
            $iPerfil_id=$List->getelem()->id;
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
          
    // Fin Despliegue Perfiles   
    
    // Funcionalidades No Asignadas 
    
    $MiTemplate->set_block('main' , "funcionalidades_no_asignadas" , "BLO_funcionalidades_no_asignadas");   
    
    $List  = new connlist;
    bizcve::getfuncionalidadesdelperfil($List, $iPerfil_id, false);   
    $List->gofirst(); 
    if (!$List->isvoid()) 
    {
    	do {    	
    		$MiTemplate->set_var('id_funcionalidad', $List->getelem()->id);			
    		$MiTemplate->set_var('descripcion', $List->getelem()->nombre);   	
        $MiTemplate->set_var('selected', '');	  
        $MiTemplate->parse("BLO_funcionalidades_no_asignadas", "funcionalidades_no_asignadas", true);             
    	} while ($List->gonext());
    }      

    // Fin Funcionalidades No Asignadas
     
    // Funcionalidades Asignadas 
    
    $MiTemplate->set_block('main' , "funcionalidades_asignadas" , "BLO_funcionalidades_asignadas");   
    
    $List  = new connlist;
    bizcve::getfuncionalidadesdelperfil($List, $iPerfil_id, true);  
    $List->gofirst();
    if (!$List->isvoid()) 
    {
    	do {    	
    		$MiTemplate->set_var('id_funcionalidad', $List->getelem()->id);			
    		$MiTemplate->set_var('descripcion', $List->getelem()->nombre);   	 
        $MiTemplate->set_var('selected', '');	 
        $MiTemplate->parse("BLO_funcionalidades_asignadas", "funcionalidades_asignadas", true);             
    	} while ($List->gonext());
    }      

    // Fin Funcionalidades Asignadas
    
       



	///////////////////////// ZONA PIE DE PAGINA /////////////////////////	
	$MiTemplate->parse("OUT_M", array("header", "main"), true);
	$MiTemplate->p("OUT_M");

}

/**********************************************************************************************/
if( $action == 'del' )
    delete_usuario( $bd,$usr_id );
else {
    listado_permisos($bd, $patron );
	include '../menu/menu.php';
	include '../menu/footer.php';
	}

/**********************************************************************************************/

//include "../../includes/application_bottom.php";

?>
