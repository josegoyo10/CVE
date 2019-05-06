<?php
class ctrltipocontribuyente{

    public function gettb_tipocontribuyente($List) {
    	try {
    	   $obj =  new daotipocontribuyente;	
    	   return $obj->gettipocontribuyente($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    
}
?>