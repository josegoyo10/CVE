<?
class ctrlinfocliente{

    public function getCliente($List) {
    	global $ses_usr_codlocal;
    	try {
    	   $obj = new daoinfocliente;	
    	   $retorno = $obj->getCliente($List);
    	   $List->gofirst();
    	   if (!$List->getelem()->codigovendedor){
    	   		//Buscamos si existe el vendedor por defecto para la tienda
    	   		$CtrlUsr = new ctrlusuario();
    	   		$CtrlUsr->GetUsers($listusr = new connlist(new dtousuario(array('usr_dat_extras'=>$ses_usr_codlocal))));
    	   		if ($listusr->numelem()==1) {
    	   			$listusr->gofirst();
    	   			$List->getelem()->codigovendedor = $listusr->getelem()->codigovendedor;
    	   		}
    	   }
    	   return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getClienteReporExcel($List) {
    	global $ses_usr_codlocal;
    	try {
    	   $obj = new daoinfocliente;	
    	   $retorno = $obj->getClienteReporExcel($List);
    	   /*
    	   ////////////////////////////////
    	   // To-Do: descomentar esto ?
    	   ////////////////////////////////
    	   $List->gofirst();
    	   if (!$List->getelem()->codigovendedor){
    	   		//Buscamos si existe el vendedor por defecto para la tienda
    	   		$CtrlUsr = new ctrlusuario();
    	   		$CtrlUsr->GetUsers($listusr = new connlist(new dtousuario(array('usr_dat_extras'=>$ses_usr_codlocal))));
    	   		if ($listusr->numelem()==1) {
    	   			$listusr->gofirst();
    	   			$List->getelem()->codigovendedor = $listusr->getelem()->codigovendedor;
    	   		}
    	   } */
    	   return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }    
    
	public function getClienteRepor($List) {
    	global $ses_usr_codlocal;
    	try {
    	   $obj = new daoinfocliente;	
    	   $retorno = $obj->getClienteRepor($List);
    	   $List->gofirst();
    	   if (!$List->getelem()->codigovendedor){
    	   		//Buscamos si existe el vendedor por defecto para la tienda
    	   		$CtrlUsr = new ctrlusuario();
    	   		$CtrlUsr->GetUsers($listusr = new connlist(new dtousuario(array('usr_dat_extras'=>$ses_usr_codlocal))));
    	   		if ($listusr->numelem()==1) {
    	   			$listusr->gofirst();
    	   			$List->getelem()->codigovendedor = $listusr->getelem()->codigovendedor;
    	   		}
    	   }
    	   return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    /*Obtener Tipo de Cliente*/
    public function gettipojur($rut, $Listjur){
    	try{
    		$obj = new daoinfocliente;
    		return $obj->gettipojur($rut, $Listjur);	
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    /*Fin Obtener Tipo Cliente*/
   
    public function getMonitorCliente($List) {
    	global $ses_usr_codlocal;
    	try {
    	   $obj = new daoinfocliente;	
    	   $retorno = $obj->getMonitorCliente($List);
    	   $List->gofirst();
    	   if (!$List->getelem()->codigovendedor){
    	   		//Buscamos si existe el vendedor por defecto para la tienda
    	   		$CtrlUsr = new ctrlusuario();
    	   		$CtrlUsr->GetUsers($listusr = new connlist(new dtousuario(array('usr_dat_extras'=>$ses_usr_codlocal))));
    	   		if ($listusr->numelem()==1) {
    	   			$listusr->gofirst();
    	   			$List->getelem()->codigovendedor = $listusr->getelem()->codigovendedor;
    	   		}
    	   }
    	   return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getRegistro($List) {
    	global $ses_usr_codlocal;
    	try {
    	   $obj = new daoinfocliente;	
    	   $retorno = $obj->getRegistro($List);
    	   $List->gofirst();
    	   if (!$List->getelem()->codigovendedor){
    	   		//Buscamos si existe el vendedor por defecto para la tienda
    	   		$CtrlUsr = new ctrlusuario();
    	   		$CtrlUsr->GetUsers($listusr = new connlist(new dtousuario(array('usr_dat_extras'=>$ses_usr_codlocal))));
    	   		if ($listusr->numelem()==1) {
    	   			$listusr->gofirst();
    	   			$List->getelem()->codigovendedor = $listusr->getelem()->codigovendedor;
    	   		}
    	   }
    	   return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getdatosbasicos($List) {
    	global $ses_usr_codlocal;
    	try {
    	   $obj = new daoinfocliente;	
    	   $retorno = $obj->getdatosbasicos($List);
    	   $List->gofirst();
    	   if (!$List->getelem()->codigovendedor){
    	   		//Buscamos si existe el vendedor por defecto para la tienda
    	   		$CtrlUsr = new ctrlusuario();
    	   		$CtrlUsr->GetUsers($listusr = new connlist(new dtousuario(array('usr_dat_extras'=>$ses_usr_codlocal))));
    	   		if ($listusr->numelem()==1) {
    	   			$listusr->gofirst();
    	   			$List->getelem()->codigovendedor = $listusr->getelem()->codigovendedor;
    	   		}
    	   }
    	   return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
 
    /*Valida Usuario para reimpresion OP GD*/
	/*public function usuariomodulovalido($Listusuariovalidoimp,$usuariolis,$clavelist,$idmodulo){
		try{
			$obj = new daoinfocliente;
			return $obj->usuariomodulovalido($Listusuariovalidoimp,$usuariolis,$clavelist,$idmodulo);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
		
	}*/
    /*Fin Valida Usuario para reimpresion OP GD*/
   
    public function putcliente($List) {
    	global $ses_usr_login;
    	try {
    		if (!$List)
            	throw new CTRLException("No viene lista de elementos", 0);
            
            if ($List->numelem()) {
            	$List->gofirst();
	    		if (!$List->getelem()->rut)
	            	throw new CTRLException("No viene rut de cliente", 0);
            }
            else {
            	throw new CTRLException("La lista no contiene elementos", 0);
            }
            	
    	   	$obj = new daoinfocliente;	
    		if ($obj->existecliente($List)) {
    	   		return $obj->modifycliente($List);
    		}
    		else {
    			$obj->insertcliente($List);
    			$List->gofirst();
    			$obj->setdisponible(new connlist(new dtodisponible(array('id_tipomovimiento'=> 1,
    																	 'rut'=> $List->getelem()->rut,
    																	 'monto'=> MAX_MONTO_CTE_CVE,
    																	 'usrcrea'=> $ses_usr_login,
    																	 'usrmod'=> $ses_usr_login,
    																	))));
    		}
    	   	return true; 
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function getdirdesp($List) {
    	try {
    	   $obj = new daoinfocliente;	
    	   return $obj->getdirdesp($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function wscrearcliente($List) {
    	try {
    	   $obj = new wsxmlcve;	
    	   return $obj->wscrearcliente($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function wsupdatecliente($List) {
    	try {
    	   $obj = new wsxmlcve;	
    	   return $obj->wsupdatecliente($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function wsbuscarcliente($List) {
    	try {
    	   $obj = new wsxmlcve;	
    	   return $obj->wsbuscarcliente($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getdirdespicking($List) {
    	try {
    	   $obj = new daoinfocliente;	
    	   return $obj->getdirdespicking($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
       
    /*Metodo getdetalleimpuesto*/
    public function getdetalleimpuesto($List, $id_coti,$grupoimp) {
    	try {
    	   $obj = new daocotizacion;	
    	   return $obj->getdetalleimpuesto($List, $id_coti,$grupoimp);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    /*Fin Metodo getdetalleimpuesto*/    
    public function putdirdesp($List) {
    	try {
    	   	$obj = new daoinfocliente;
    		if ($obj->existedirdesp($List))
    	   		return $obj->modifydirdesp($List);
    		else
    	   		return $obj->insertdirdesp($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function deldirdesp($List) {
    	try {
    	   	$obj = new daoinfocliente;
    	   	return $obj->deletedirdesp($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function getdisponible($List) {
    	try {
    	   	$obj = new daoinfocliente;
    	   	return $obj->getdisponible($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

	public function setdisponible($List) {
    	try {
    	   	$obj = new daoinfocliente;
    	   	return $obj->setdisponible($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function putcargo($ListDoc) {
    	try {
    	   	$obj = new daoinfocliente;
    	   	return $obj->putcargo($ListDoc);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function ordenentcargo($id_ordenent) {
    	try {
    	   	$obj = new daoinfocliente;
    	   	return $obj->ordenentcargo($id_ordenent);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
	
	public function putclientesap($listaClientesap) {
    	try {
 			if (!$listaClientesap){
            	throw new CTRLException("No viene lista de elementos", 0);
			}	
    	   	$listaClientesap->gofirst();
    	   	$obj = new daoinfocliente;
    	   	$obj->getCliente($listaCliente = new connlist ($dtoinfocliente =new dtoinfocliente (array('rut'=>$listaClientesap->getelem()->rut))));
	    	$obj->initrx();
	    	if ($listaCliente->numelem()){
	    		if (!$obj->modifyclientesap($listaClientesap)){
	    			$obj->rollback();
	    			return false;
	    		}
	    	}else{
	    		if(!$obj->putclientesap($listaClientesap)){
	    			$obj->rollback();
	    			return false;
	    		}
	    	}
	    	$obj->commit();
	    	return true;
    	   	
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

	public function marcasapdisponible($List){
    	try {
    	   	$obj = new daoinfocliente;
    	   	return $obj->marcasapdisponible($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
/*para buscar y updatiar el disponible*/
    public function updisponible($List) {
    	global $ses_usr_codlocal;
    	try {
    	   $obj = new daoinfocliente;
    	   $List->gofirst();    	   	
    	   $monto=$List->getelem()->monto;
    	   $id_documento=$List->getelem()->id_documento;    	
    	   $retorno = $obj->buscadisponible($List);
    	   $List->gofirst();
    	   if ($List->numelem()==1){
    	   	    $id_documento=$List->getelem()->id_documento;  
    	    	$minuendo  =$List->getelem()->monto;
 		   		$sustraendo=$monto;
 		   		$resta=($minuendo-$sustraendo);

 		   		if ($resta>0){
					//updateo la linea 
					$res=$obj->modificadisponible($List = new connlist(
														  new dtoinfocliente(
												          array('monto'=>$resta,'id_linea'=>$List->getelem()->id_linea))));					
				 if ($resta>0 && $resta<MARGEN_DISPONIBLE){
				 	//general::writeevent('Resta '.$resta);
					$res=$obj->eliminadisponible($listusr = new connlist(
														    new dtoinfocliente(
												            array('id_linea'=>$List->getelem()->id_linea))));									 	
				 }			
				}else{
					//elimino la linea
					$res=$obj->eliminadisponible($listusr = new connlist(
														  new dtoinfocliente(
														  array('id_linea'=>$List->getelem()->id_linea))));					
				}
    	   }
    	   return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }    
    
    
    
}

?>
