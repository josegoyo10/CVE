<?
class ctrlevento{

    public function setevento($id_evento = NULL, $tipo_id_evento = NULL, $ip = NULL, $nombre_objeto = NULL, 
        $tipo_objeto = NULL, $descripcion_objeto = NULL, $estado_anterior = NULL, $estado_posterior = NULL, $usuario_accion = NULL) {
    	try {
    	   $obj = new daoevento;	
    	   return $obj->setevento($id_evento, $tipo_id_evento , $ip, $nombre_objeto, 
        $tipo_objeto, $descripcion_objeto, $estado_anterior, $estado_posterior, $usuario_accion);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

        public function getevento($ListEnc) {
        try {
           $obj = new daoevento;    
           return $obj->getevento($ListEnc);
        }
        catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
        catch(DAOException $e)  {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
        catch(Exception $e)     {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
     public function geteventoEX($ListEnc) {
        try {
           $obj = new daoevento;    
           return $obj->geteventoEX($ListEnc);
        }
        catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
        catch(DAOException $e)  {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
        catch(Exception $e)     {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

     /****************************************************/

     public function LogErrors($clase, $funcion, $error, $query, $code,$url,$usuario_id) {

        try {
           
           $obj = new daoevento;    
           return $obj->LogErrors($clase, $funcion, $error, $query, $code,$url,$usuario_id);
        }
        catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
        catch(DAOException $e)  {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
        catch(Exception $e)     {throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
          }


}
  
?>