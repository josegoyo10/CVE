<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../admclientes/transferencia.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

/*Despliegue de informacion de cliente*/
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);


////////////////////////////////////////////////////////////////////////
if($_GET['accion']=='ajax'){
  
  // Si es para actualizar la request ajax entonces le saco el header y el footer y devuelvo el resultado
  // ajax_transferencia.htm
  
  // tipo_cliente
  // nombre
  // rutingresado
  // select_vendedores
  
  $MiTemplate->set_file("main", TEMPLATE . "admclientes/ajax_transferencia.htm");
  
  $confimp = new getidcontribuyente("CONTRIBUYENTE");
  $opcioncon1=$confimp->EMPRESARIAL;
  /*filtro tipo de cliente*/
  $Listcontri  = new connlist;
  bizcve::gettipocontribuyente($Listcontri);
  $Listcontri->gofirst();
  if (!$Listcontri->isvoid()) {
  $MiTemplate->set_block('main' , "contri" , "BLO_contri");
  	do {
  		$MiTemplate->set_var('nombrecontri', $Listcontri->getelem()->nombre);
  		$MiTemplate->set_var('id', $Listcontri->getelem()->id);
  		$MiTemplate->set_var('selectedcontri', ($_GET['tipo_cliente'] == $Listcontri->getelem()->id)?'selected':'');
  		$MiTemplate->parse("BLO_contri", "contri", true);	
  	} while ($Listcontri->gonext());
  }
  /*Filtro Vendedor*/  
  $List = new connlist;
  $mRegistro= new dtousuario;
  $mRegistro->usr_tipo='000';
  $mRegistro->id_tipousuario='2';
  $List->addlast($mRegistro);
  bizcve::GetUsers($List);
  $List->gofirst();
  $MiTemplate->set_block('main' , "vendedores" , "BLO_vendedores");
  if (!$List->isvoid()) {
  	
  	do {
  		$MiTemplate->set_var('codigovendedor',$List->getelem()->codigovendedor);
  		$MiTemplate->set_var('nomvendedor',$List->getelem()->usr_nombres." ".$List->getelem()->usr_apellidos." (".($List->getelem()->cod_local?$List->getelem()->cod_local:'LOCAL NO ASIGNADO').")");
  		$MiTemplate->set_var('selected', ($_GET['select_vendedores'] == $List->getelem()->codigovendedor)?'selected':'');		
  		$MiTemplate->parse("BLO_vendedores", "vendedores", true);
  	} while ($List->gonext());
  }
  ///*Fin Filtro Vendedor*/
  $MiTemplate->set_var('nombreing',($_GET['nombre']?$_GET['nombre']:''));
  $MiTemplate->set_var('ruting',($_GET['rutingresado']?$_GET['rutingresado']:'')); 
  
  $ListCliCVE = new connlist;
  $ClientesCVE = new dtoinfocliente;
  $ClientesCVE->razonsoc=($_GET['nombre']?$_GET['nombre']:'');
  $ClientesCVE->rut=($_GET['rutingresado']?$_GET['rutingresado']:'');
  $ClientesCVE->id_contribuyente=($_GET['tipo_cliente']?$_GET['tipo_cliente']:'');
  ($_GET['select_vendedores']?$ClientesCVE->codigovendedor=$_GET['select_vendedores']:'');
  $ClientesCVE->limite = LIMITE_DESPLIEGUE_CLIENTE_NUEVO;
  $ClientesCVE->orderby = 'razonsoc';
  	
  $ListCliCVE->addlast($ClientesCVE);
  bizcve::getClienteRepor($ListCliCVE);
  $ListCliCVE->gofirst();
  $MiTemplate->set_block('main' , "infocliente" , "BLO_infocliente");
  $i=0;
  if (!$ListCliCVE->isvoid()) {
  	do {
  		$MiTemplate->set_var('acciones',"<a href=\"javascript:addRow('".$ListCliCVE->getelem()->rut."', '".$ListCliCVE->getelem()->direccionservicio."', '".$ListCliCVE->getelem()->razonsoc."', '".$ListCliCVE->getelem()->vendedor." ()')\">Agregar a lista</a>&nbsp;");
  		$MiTemplate->set_var('rut',$ListCliCVE->getelem()->rut);
  		$MiTemplate->set_var('rutdv',(($ListCliCVE->getelem()->id_contribuyente == $opcioncon1)?$ListCliCVE->getelem()->rut.'-'.general::digiVer($ListCliCVE->getelem()->rut):$ListCliCVE->getelem()->rut));
  		$MiTemplate->set_var('tipocliente',$ListCliCVE->getelem()->direccionservicio);
  		$MiTemplate->set_var('razonsoc',$ListCliCVE->getelem()->razonsoc);
  		$MiTemplate->set_var('i',$i);
  		$MiTemplate->set_var('vendedor',($ListCliCVE->getelem()->vendedor?$ListCliCVE->getelem()->vendedor:'&nbsp;'));
  		$MiTemplate->parse("BLO_infocliente", "infocliente", true);
  		$i++;
  	} while ($ListCliCVE->gonext());
  }
  /*Fin Despliegue General*/


}
else
{
  
  ////////////////////////////////////////////////////////////////////////
  
  // Cuando se tire la busqueda construir el query string, tirar el ajax request, y cuando el ajax request
  // devuelva, mostrarlo en el div al resultado
  // transferencia.htm
  
  if( isset( $_POST['clientes_seleccionados']) && isset($_POST['nuevo_vendedor']) )
  {

    // Valido que el vendedor sea valido y obtengo el nombre del vendedor
    $List = new connlist;
    $mRegistro= new dtousuario;
    $mRegistro->usr_id= (int)$_POST['nuevo_vendedor'] ;
    $List->addlast($mRegistro);
    bizcve::GetUsers($List);
    $List->gofirst();     
    if (!$List->isvoid()) {      
      // Valido que sean ruts validos      
      $ruts = $_POST["clientes_seleccionados"];
      $rut_lista='';
      for( $i = 0;$i<count($ruts);$i++)
      {
           $rut_lista .= (integer)($_POST["clientes_seleccionados"][$i]);
           if( $i != (count($ruts)-1))
            $rut_lista .=',';
      }      

      // update cliente set codigovendedor= where rut in
     $res = $_SESSION["DBACESS"]->querynoselect("update cliente set codigovendedor='".$List->getelem()->codigovendedor."' where rut in ($rut_lista)");  
      if (!$res) 
        throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);     
      
    }  

    // Si se envio el formulario para transferir clientes muestro "Se transfirieron x clientes blabla"
    $MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
    $MiTemplate->set_var('error_app', $mensaje_error);
    
    $MiTemplate->set_file("main", TEMPLATE . "admclientes/transferencia_ok.htm");  
    $MiTemplate->set_var('numbero_clientes', count($ruts));      
    $MiTemplate->set_var('vendedor', $List->getelem()->usr_nombres." ".$List->getelem()->usr_apellidos." (".($List->getelem()->cod_local?$List->getelem()->cod_local:'LOCAL NO ASIGNADO').")");
  }
  else
  {
    $MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
    $MiTemplate->set_var('error_app', $mensaje_error);
    
    $MiTemplate->set_file("main", TEMPLATE . "admclientes/transferencia.htm");  
    
    /*Filtro Vendedor*/  
    $List = new connlist;
    $mRegistro= new dtousuario;
    $mRegistro->usr_tipo='000';
    $mRegistro->id_tipousuario='2';
    $List->addlast($mRegistro);
    bizcve::GetUsers($List);
    $List->gofirst();
    $MiTemplate->set_block('main' , "vendedores" , "BLO_vendedores");
    if (!$List->isvoid()) {
    	
    	do {
    		$MiTemplate->set_var('id',$List->getelem()->id);
    		$MiTemplate->set_var('nomvendedor',$List->getelem()->usr_nombres." ".$List->getelem()->usr_apellidos." (".($List->getelem()->cod_local?$List->getelem()->cod_local:'LOCAL NO ASIGNADO').")"); 	
    		$MiTemplate->parse("BLO_vendedores", "vendedores", true);
    	} while ($List->gonext());
    }    
  }

  ////////////////////////////////////////////////////////////////////////
  
}
if($_GET['accion']!='ajax'){
$MiTemplate->pparse("OUT_H", array("header"), false);
}
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
if($_GET['accion']!='ajax'){
  include '../menu/menu.php';
  include '../menu/footer.php';
}

?>    