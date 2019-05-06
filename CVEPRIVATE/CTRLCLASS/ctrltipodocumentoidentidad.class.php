<?
class ctrltipodocumentoidentidad{

    public function gettipodocumentoidentidad($List) {
    	try {
    	   $obj =  new daotipodocumentoidentidad;	
    	   return $obj->gettipodocumentoidentidad($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    
}
?>
