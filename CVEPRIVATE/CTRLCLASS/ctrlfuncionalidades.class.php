                                                               <?
class ctrlfuncionalidades{

	public function getfuncionalidadesasignables($List, $iPerfil_asignador_id, $iPerfil_asignado_id, $bAsignadas){
		try{
    		$obj = new daofuncionalidades;
    		return $obj->getfuncionalidadesasignables($List, $iPerfil_asignador_id, $iPerfil_asignado_id, $bAsignadas);	
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}
	public function getfuncionalidadesdelperfil($List, $iPerfil_id, $bAsignadas){
		try{
    		$obj = new daofuncionalidades;
    		return $obj->getfuncionalidadesdelperfil($List, $iPerfil_id, $bAsignadas);	
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}  
}
?>
