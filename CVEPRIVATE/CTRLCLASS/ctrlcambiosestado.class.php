<?
class ctrlcambiosestado{

    public function getcambiosestado($List) {
    	try {
    	   $obj = new daocambiosestado;
           return $obj->getcambiosestado($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getcambiosestadooe($List) {
    	try {
    	   $obj = new daocambiosestado;
           return $obj->getcambiosestadooe($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

  	public function cambiosestadocot($ListEnc) {
    global $ses_usr_codlocal; 
   	
   	try {
   		
   		$obj = new daocambiosestado;
        return $obj->cambiosestadocot($ListEnc);
   	   
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
  
   public function cambiosestado($ListEnc) {
    global $ses_usr_codlocal; 
   	
   	try {
   	   	$obj = new daocambiosestado;
   	   	$obj->verificarcambiosestado($ListEnc);
   	   	$numero = $ListEnc->numelem();
   	   	if ( $ListEnc->numelem()==1) {
				$ListEnc->gofirst();
				$ListDet = new connlist;
				$Registro = new dtocambiosestado;
    	   		$Registro->id_cotizacion= $ListEnc->getelem()->id_cotizacion;
				$Registro->id_estado_origen= $ListEnc->getelem()->id_estado_origen;
				$Registro->id_estado_destino= $ListEnc->getelem()->id_estado_destino;      	   		
				$ListDet->addlast($Registro);
    	   		$obj->savecambiosestado($ListDet);
    	   		
/*    	   		if ($ListEnc->getelem()->id_estado_destino == 'CT') {
    	   			//Si se pasa a estado CT, implica que se modifica y por lo tanto se cambia el centro de suministro
    	   			$CtrlCo = new ctrlcotizacion;
    	   			$CtrlCo->putcotizacion(new connlist(new dtocotizacion(array( 'id_cotizacion' => $ListEnc->getelem()->id_cotizacion,
    	   																		 'codlocalcsum' => $ses_usr_codlocal ))), null);
    	   		}*/
    	   	}
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    
   public function cambiosestadordenent($ListEnc) {
	$ListEnc->gofirst();
	$id_ordenent=$ListEnc->getelem()->id_ordenent;
   	try {
   	   	$obj = new daocambiosestado;
   	   	$obj->verificarcambiosestado($ListEnc);
   	   	$numero = $ListEnc->numelem();
   	   	if ( $ListEnc->numelem()==1) {
				$ListEnc->gofirst();
				$ListDet = new connlist;
				$Registro = new dtocambiosestado;
    	   		$Registro->id_ordenent= $id_ordenent;
				$Registro->id_estado_origen= $ListEnc->getelem()->id_estado_origen;    	   		
				$Registro->id_estado_destino= $ListEnc->getelem()->id_estado_destino;      	   		
				$ListDet->addlast($Registro);
    	   		$obj->savecambiosestadooe($ListDet);
    	   	}
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function cambioordenent($ListEnc) {
	$ListEnc->gofirst();
	try {
   	   	$obj = new daocambiosestado;
		return $obj->savecambiooe($ListEnc); 
		}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
   	
}
?>
