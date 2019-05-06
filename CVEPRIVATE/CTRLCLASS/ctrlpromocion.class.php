<?
class ctrlpromocion{


    public function getMonitorpromocion($List) {
       	try {
       		$List->gofirst();
       		//$reqdet = $List->getelem()->reqdet;
       		/* valor con que se llama =1*/
       		$obj = new daopromocion;
    	   	$obj->getMonitorpromocion($List);
			//$List->gofirst();
			//if ($reqdet && $ListEnc->getelem()->id_estado!='CT')
			//if($ListEnc->getelem()->id_estado!='CB')
			//	throw new CTRLException('No se puede modificar esta cotizacion', 2);
    	   	return true;
       	}   
    	
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
	
    public function getGrupoDet($List) {
       	try {
       		$List->gofirst();
       		//$reqdet = $List->getelem()->reqdet;
       		/* valor con que se llama =1*/
       		$obj = new daopromocion;
    	   	$obj->getGrupoDet($List);
			//$List->gofirst();
			//if ($reqdet && $ListEnc->getelem()->id_estado!='CT')
			//if($ListEnc->getelem()->id_estado!='CB')
			//	throw new CTRLException('No se puede modificar esta cotizacion', 2);
    	   	return true;
       	}   
    	
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    
    public function insertgrupo($List) {
       	try {
       		$List->gofirst();
       		//$reqdet = $List->getelem()->reqdet;
       		/* valor con que se llama =1*/
       		$obj = new daopromocion;
    	   	$obj->insertgrupo($List);
			//$List->gofirst();
			//if ($reqdet && $ListEnc->getelem()->id_estado!='CT')
			//if($ListEnc->getelem()->id_estado!='CB')
			//	throw new CTRLException('No se puede modificar esta cotizacion', 2);
    	   	return true;
       	}   
    	
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    
    
    
	public function insertpromo($List) {
       	try {
       		$List->gofirst();
       		//$reqdet = $List->getelem()->reqdet;
       		/* valor con que se llama =1*/
       		$obj = new daopromocion;
    	   	$obj->insertpromo($List);
			//$List->gofirst();
			//if ($reqdet && $ListEnc->getelem()->id_estado!='CT')
			//if($ListEnc->getelem()->id_estado!='CB')
			//	throw new CTRLException('No se puede modificar esta cotizacion', 2);
    	   	return true;
       	}   
    	
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
public function deletgrupo($List) {
       	try {
       		$List->gofirst();
       		//$reqdet = $List->getelem()->reqdet;
       		/* valor con que se llama =1*/
       		$obj = new daopromocion;
    	   	$obj->deletgrupo($List);
			//$List->gofirst();
			//if ($reqdet && $ListEnc->getelem()->id_estado!='CT')
			//if($ListEnc->getelem()->id_estado!='CB')
			//	throw new CTRLException('No se puede modificar esta cotizacion', 2);
    	   	return true;
       	}   
    	
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    
	public function deletcp($List) {
       	try {
       		$List->gofirst();
       		//$reqdet = $List->getelem()->reqdet;
       		/* valor con que se llama =1*/
       		$obj = new daopromocion;
    	   	$obj->deletcp($List);
			//$List->gofirst();
			//if ($reqdet && $ListEnc->getelem()->id_estado!='CT')
			//if($ListEnc->getelem()->id_estado!='CB')
			//	throw new CTRLException('No se puede modificar esta cotizacion', 2);
    	   	return true;
       	}   
    	
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    
    
    
	public function insertcp($List) {
       	try {
       		$List->gofirst();
       		//$reqdet = $List->getelem()->reqdet;
       		/* valor con que se llama =1*/
       		$obj = new daopromocion;
    	   	$obj->insertcp($List);
			//$List->gofirst();
			//if ($reqdet && $ListEnc->getelem()->id_estado!='CT')
			//if($ListEnc->getelem()->id_estado!='CB')
			//	throw new CTRLException('No se puede modificar esta cotizacion', 2);
    	   	return true;
       	}   
    	
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    
    
	public function deletpromo($List) {
       	try {
       		$List->gofirst();
       		//$reqdet = $List->getelem()->reqdet;
       		/* valor con que se llama =1*/
       		$obj = new daopromocion;
    	   	$obj->deletpromo($List);
			//$List->gofirst();
			//if ($reqdet && $ListEnc->getelem()->id_estado!='CT')
			//if($ListEnc->getelem()->id_estado!='CB')
			//	throw new CTRLException('No se puede modificar esta cotizacion', 2);
    	   	return true;
       	}   
    	
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    
	public function getsubrubro($List) {
       	try {
       		$List->gofirst();
       		$obj = new daopromocion;
    	   	$obj->getsubrubro($List);
    	   	return true;
       	}   
    	
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }   
	public function getrubrosubrubro($List) {
       	try {
       		$List->gofirst();
       		$obj = new daopromocion;
    	   	$obj->getrubrosubrubro($List);
    	   	return true;
       	}   
    	
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }   
}
?>
