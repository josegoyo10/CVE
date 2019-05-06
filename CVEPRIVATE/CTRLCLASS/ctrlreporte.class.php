<?
 // ini_set('display_errors', 1);
 // ini_set('display_startup_errors', 1);
 // error_reporting(E_ALL);

class ctrlreporte{

    public function getreportecuadratura($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getreportecuadratura($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getreportevendedor($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getreportevendedor($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
	
	 public function setdesbloqueo($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->setdesbloqueo($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	
    
    public function getreportedocumentosall($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getreportedocumentosall($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getreportemargen($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getreportemargen($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getreportedesbloqueos($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getreportedesbloqueos($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getreporteoeblo($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getreporteoe($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getreportegde($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getreportegde($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getreportecotizacion($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getreportecotizacion($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
	
	public function getreportedesbloqueoscotizacion($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getreportedesbloqueoscotizacion($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
	
	
    
	public function getreportecotizacionExcel($List) {
    	global $ses_usr_codlocal;
    	try {
    	   $obj = new daoreporte;	
		   $retorno = $obj->getreportecotizacionExcel($List);
		   return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }   
	
	public function getreportedesbloqueocotizacionExcel($List) {
    	global $ses_usr_codlocal;
    	try {
    	   $obj = new daoreporte;	
		   $retorno = $obj->getreportedesbloqueocotizacionExcel($List);
		   return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }   
	
    public function getreportecliente($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getreportecliente($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getventascliente($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getventascliente($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getventascliente_margen($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getventascliente_margen($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getreportefacturas($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getreportefacturas($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getreportedetalleventas($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getreportedetalleventas($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getReporteTransferenciaMercancia($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getReporteTransferenciaMercancia($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getModulos($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getModulos($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getPermisosXModulo($List) {
    	try {
    	   $obj = new daoreporte;
           return $obj->getPermisosXModulo($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getTablaUsuarios($List) 
    {
    	try {
    	   $obj = new daoreporte;
           return $obj->getTablaUsuarios($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    //Mantis 26818 Inicio
    public function getClientesAsignadosVendedores($List) 
    {
    	try {
    	   $obj = new daoreporte;
           return $obj->getClientesAsignadosVendedores($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

  //JOSE GREGORIO CLIENTES TOTALES ASIGNADOS
    public function getClientesTotalesAsignados($List) 
    {
        try {
           $obj = new daoreporte;
           return $obj->getClientesTotalesAsignados($List);
        }
        catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
        catch(DAOException $e)  {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
        catch(Exception $e)     {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    
    //Jose Gregorio Cliente que no han comprado dado una fecha inicio y fin
    public function getClientesnocompra($List,$fecha_inicio, $fecha_fin,$codigo_vendedor) 
    {

        try {
           $obj = new daoreporte;
           return $obj->getClientesnocompra($List,$fecha_inicio, $fecha_fin,$codigo_vendedor);
        }
        catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
        catch(DAOException $e)  {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
        catch(Exception $e)     {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

      //Jose Gregorio Cliente que  han comprado dado una fecha inicio y fin
    public function getClientescompra($List,$fecha_inicio, $fecha_fin,$codigo_vendedor) 
    {

        try {
           $obj = new daoreporte;
           return $obj->getClientescompra($List,$fecha_inicio, $fecha_fin,$codigo_vendedor);
        }
        catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
        catch(DAOException $e)  {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
        catch(Exception $e)     {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }






     
    //Jose Gregorio Truncate tabla.

        public function truncatetabla($nombre) {

        try {
           $obj = new daoreporte;
           return $obj->truncatetabla($nombre);
        }
            catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
            catch(DAOException $e)  {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
            catch(Exception $e)     {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
         }





    //Mantis 26818 Fin
        //Mantis 26826 Inicio
    public function getMedioPagoEntregaVenta($List) 
    {
    	try {
    	   $obj = new daoreporte;
           return $obj->getMedioPagoEntregaVenta($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    //Mantis 26826 Fin
}

