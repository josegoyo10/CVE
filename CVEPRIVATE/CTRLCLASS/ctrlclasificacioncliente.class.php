<?
class ctrlclasificacioncliente{

    public function getclasificacioncliente($List) {
    	try {
    	   $obj =  new daoclasificacioncliente;	
    	   return $obj->getclasificacioncliente($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    
}
?>
