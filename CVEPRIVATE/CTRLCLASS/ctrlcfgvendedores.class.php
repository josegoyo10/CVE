<?php

class ctrlcfgvendedores{

    public function get_codigo_vendedor_para_cliente_nuevo() {
    	try {
    	   $obj = new daocfgvendedores;	
    	   return $obj->get_codigo_vendedor_para_cliente_nuevo();
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
}
	
?>