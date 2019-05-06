<?
class ctrlflete{

	public function getDatosFlete($Listf){
		try{
    		$obj = new daoflete;
    		return $obj->getDatosFlete($Listf);	
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}

	// Añadido por J.G el dia 11-04-2019

    public function getDataFlete($id_location,$id_store, $tipo_despacho){
		

		try{
            
    		$obj = new daoflete;
    		return $obj->getDataFlete($id_location,$id_store, $tipo_despacho);	
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	    }


   }



?>
