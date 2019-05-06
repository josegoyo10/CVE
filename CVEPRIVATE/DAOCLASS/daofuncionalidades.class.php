<?php

class daofuncionalidades{

	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   

    public function getfuncionalidadesasignables($List, $iPerfil_asignador_id, $iPerfil_asignado_id, $bAsignadas) {
    	try {
        if( $bAsignadas )
        {
            $query="select funcionalidades.id as id, funcionalidades.nombre as nombre from funcionalidades where id in (select funcionalidad_id from funcionalidadesasignablesporperfil where perfil_asignador_id=$iPerfil_asignador_id and perfil_asignable_id=$iPerfil_asignado_id)";
        }
        else
        {
            $query="select funcionalidades.id as id, funcionalidades.nombre as nombre from funcionalidades where id not in (select funcionalidad_id from funcionalidadesasignablesporperfil where perfil_asignador_id=$iPerfil_asignador_id and perfil_asignable_id=$iPerfil_asignado_id)";
        }
  			$res = $this->bd->query($query);
  			if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
  			
        $List->clearlist();     
        while ($row = $res->fetch_assoc()){
          $Funcionalidad = new dtofuncionalidades;
          $Funcionalidad->id	= $row['id'];
          $Funcionalidad->nombre	= $row['nombre'];
          $List->addlast($Funcionalidad);
        }
        $res->free();
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getfuncionalidadesdelperfil($List, $iPerfil_id, $bAsignadas) {
      global $ses_usr_id;    
    	try {    
      
        // Obtengo los ID de los perfiles del usuario logeado
        $res = $this->bd->query("select peus_per_id as perfil_id from perfilesxusuario where peus_usr_id=".$ses_usr_id);      
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), "select peus_per_id as perfil_id from perfilesxusuario where peus_usr_id=".$ses_usr_id, 1);
        $strPerfilesIDs='(';
        while ($row = $res->fetch_assoc()){
          $strPerfilesIDs.=$row['perfil_id'].',';     
        }
        $strPerfilesIDs.='-999)';
      
        if( $bAsignadas )
        {
          $query="select funcionalidades.id as id, funcionalidades.nombre as nombre from funcionalidades where funcionalidades.id in ( select perfilesxfuncionalidad.funcionalidad_id as funcionalidad_id from perfilesxfuncionalidad where perfilesxfuncionalidad.perfil_id=$iPerfil_id) and funcionalidades.id in ( select distinct funcionalidad_id from funcionalidadesasignablesporperfil where perfil_asignador_id in $strPerfilesIDs and perfil_asignable_id=$iPerfil_id )";
        }
        else
        {
          $query="select funcionalidades.id as id, funcionalidades.nombre as nombre from funcionalidades where funcionalidades.id not in ( select perfilesxfuncionalidad.funcionalidad_id as funcionalidad_id from perfilesxfuncionalidad where perfilesxfuncionalidad.perfil_id=$iPerfil_id) and funcionalidades.id in ( select distinct funcionalidad_id from funcionalidadesasignablesporperfil where perfil_asignador_id in $strPerfilesIDs and perfil_asignable_id=$iPerfil_id )";
        }
  			$res = $this->bd->query($query);
  			if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();     
        while ($row = $res->fetch_assoc()){
          $Funcionalidad = new dtofuncionalidades;
          $Funcionalidad->id	= $row['id'];
          $Funcionalidad->nombre	= $row['nombre'];
          $List->addlast($Funcionalidad);
        }
        $res->free();
      }
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }    
}
	
?>