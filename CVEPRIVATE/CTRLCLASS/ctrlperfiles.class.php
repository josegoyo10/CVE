<?
class ctrlperfiles{

	public function getperfiles($List, $reporte = false){
		try{
    		$obj = new daoperfiles;
    		return $obj->getperfiles($List, $reporte);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}
}
?>
