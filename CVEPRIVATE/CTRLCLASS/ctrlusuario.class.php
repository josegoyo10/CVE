<?
class ctrlusuario{

    public function GetUsers($List) {
    	try {
    	   $obj =  new daousuario;	
    	   return $obj->GetUsers($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function updateusrpassword($List) {
    	try {
    	   $obj =  new daousuario;	
    	   return $obj->updateusrpassword($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getcountuser($List) {
    	try {
    	   $obj =  new daousuario;	
    	   return $obj->getcountuser($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function infousuarioper($List,$usr) {
    	try {
    	   $obj =  new daousuario;	
    	   return $obj->infousuarioper($List,$usr);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }    

    public function modulospadre($List,$usr,$per) {
    	try {
    	   $obj =  new daousuario;	
    	   return $obj->modulospadre($List,$usr,$per);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }  

    public function moduloshijo($List,$usr,$per,$modpadre) {
    	try {
    	   $obj =  new daousuario;	
    	   return $obj-> moduloshijo($List,$usr,$per,$modpadre);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }  

    public function getlocalusr($List,$usr) {
    	try {
    	   $obj =  new daousuario;	
    	   return $obj-> getlocalusr($List,$usr);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }     
    
    public function getmenu($username, $List) {
    	try {
    	   	$obj =  new daousuario;	
    	   	return $obj->getmenu($username, $List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function existemodulouser($username, $modulo) {
    	try {
    	   	$obj =  new daousuario;	
    	   	return $obj->existemodulouser($username, $modulo);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function tienepermisodefuncionalidad($funcionalidad_nombre) {
    	try {
    	   	$obj =  new daousuario;	
    	   	return $obj->tienepermisodefuncionalidad($funcionalidad_nombre);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }    

    public function usuariovalido($username) {
    	try {
    	   	$obj =  new daousuario;	
    	   	return $obj->usuariovalido(general::NoSQL($username));
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getTipoUsuarioCotiza($idusuario)  {
    	try {
    	   	$obj =  new daousuario;	
    	   	return $obj->getTipoUsuarioCotiza($idusuario);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function ipusuariovalida($idusuario, $ip) {
    	try {
    	   	$obj =  new daousuario;	
    	   	return $obj->ipusuariovalida($idusuario, $ip);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function grabaimpresorausuario($Impresoraf, $Impresorag) {
    	try {
    	   	$obj =  new daousuario;	
    	   	return $obj->grabaimpresorausuario($Impresoraf, $Impresorag);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    
    public function usuariomodulovalido($Listusuariovalidoimp,$usuariolis,$clavelist,$idmodulo) {
    	try {
    	   	$obj =  new daousuario;	
    	   	return $obj->usuariomodulovalido($Listusuariovalidoimp,$usuariolis,$clavelist,$idmodulo);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

     public function nombresDeNombreParecido($list) {
    	try {
                
    	   	$obj =  new daousuario;	
    	   	return $obj->nombresDeNombreParecido($list);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function reporteDeUsuarios($list) {
        try {
                
            $obj =  new daousuario; 
            return $obj->reporteDeUsuarios($list);
        }
        catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
        catch(DAOException $e)  {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
        catch(Exception $e)     {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function reporteUsuariosPorPerfiles($list) {
        try {
                
            $obj =  new daousuario; 
            return $obj->reporteUsuariosPorPerfiles($list);
        }
        catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
        catch(DAOException $e)  {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
        catch(Exception $e)     {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function nombresDeLoginParecido($list) {
        try {
                
            $obj =  new daousuario; 
            return $obj->nombresDeLoginParecido($list);
        }
        catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
        catch(DAOException $e)  {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
        catch(Exception $e)     {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function reporteDeUsuariosEx($list) {
        try {
                
            $obj =  new daousuario; 
            return $obj->reporteDeUsuariosEx($list);
        }
        catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
        catch(DAOException $e)  {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
        catch(Exception $e)     {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function verificacionDePermisos($usuario, $modulo, $tipo) {
        try {
                
            $obj =  new daousuario; 
            return $obj->verificacionDePermisos($usuario, $modulo, $tipo);
        }
        catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
        catch(DAOException $e)  {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
        catch(Exception $e)     {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
}
?>
