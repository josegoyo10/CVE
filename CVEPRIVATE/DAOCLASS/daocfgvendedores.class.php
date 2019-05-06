<?php

class daocfgvendedores{

	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   

    public function get_codigo_vendedor_para_cliente_nuevo() {
    	try {
  			$query="select value from cfg_vendedores where `key`='vendedor_por_defecto_nuevo_cliente'";
  			$res = $this->bd->query($query);
  			if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
  			
  			if( $row = $res->fetch_assoc() )
  				return $row['value'];
  			else
  				throw new DAOException(__CLASS__ , __FUNCTION__ , 'No existe la clave vendedor_por_defecto_nuevo_cliente en la tabla cfg_vendedores.', $query, 1);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
}
	
?>