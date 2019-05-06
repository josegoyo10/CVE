<?
class daocambiosestado{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   
    
	public function getcambiosestado($List) {
	    $List->gofirst();
         $query = "	SELECT distinct ce.id_estado_origen, 
						   ce.id_estado_destino, 
						   ce.tipo, 
						   ce.descripcion as nomaccion,
						   estadoterminal,
						   ce.color
					FROM cambiosestado ce
					join cotizacion_e co on co.id_estado=ce.id_estado_origen
					join estado e on e.id_estado = ce.id_estado_destino 
					WHERE 	1 
					" . (($List->getelem()->tipo)? " and ce.tipo = '".$List->getelem()->tipo."' " : "") . "
					" . (($List->getelem()->id_estado_origen)? " and ce.id_estado_origen = '".$List->getelem()->id_estado_origen."' " : "") . "
					" . (($List->getelem()->id_cotizacion )? " and co.id_cotizacion  = ".$List->getelem()->id_cotizacion." " : "") . "
					ORDER BY ce.id_estado_origen";
      
       $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtocambiosestado;
            $Registro->id_estado_origen	 = 	$row['id_estado_origen'];
            $Registro->id_estado_destino = 	$row['id_estado_destino'];	
            $Registro->tipo				 = 	$row['tipo'];	
            $Registro->nomaccion		 = 	$row['nomaccion'];	
            $Registro->estadoterminal	 = 	$row['estadoterminal'];						
            $Registro->color	 		 = 	$row['color'];						
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function getcambiosestadooe($List) {
	    $List->gofirst();
         $query = "	SELECT distinct ce.id_estado_origen, 
						   ce.id_estado_destino, 
						   ce.tipo, 
						   ce.descripcion as nomaccion,
						   estadoterminal,
						   ce.color
					FROM cambiosestado ce
					join ordenent_e oe on oe.id_estado=ce.id_estado_origen
					join estado e on e.id_estado = ce.id_estado_destino 
					WHERE 	1 
					" . (($List->getelem()->tipo)? " and ce.tipo = '".$List->getelem()->tipo."' " : "") . "
					" . (($List->getelem()->id_estado_origen)? " and ce.id_estado_origen = '".$List->getelem()->id_estado_origen."' " : "") . "
					" . (($List->getelem()->id_ordenent)? " and oe.id_ordenent  = ".$List->getelem()->id_ordenent." " : "") . "
					";
       $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtocambiosestado;
            $Registro->id_estado_origen	 = 	$row['id_estado_origen'];
            $Registro->id_estado_destino = 	$row['id_estado_destino'];	
            $Registro->tipo				 = 	$row['tipo'];	
            $Registro->nomaccion		 = 	$row['nomaccion'];	
            $Registro->estadoterminal	 = 	$row['estadoterminal'];						
            $Registro->color	 		 = 	$row['color'];						
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
    
	public function verificarcambiosestado($List) {
	    $List->gofirst();
        $query = "	SELECT  id_estado_origen,
							id_estado_destino, 
							descripcion as nomaccion
					FROM cambiosestado
					WHERE 	1 
					" . (($List->getelem()->id_estado_origen)? " and id_estado_origen = '".$List->getelem()->id_estado_origen."' " : "") . "
					" . (($List->getelem()->id_estado_destino)? " and id_estado_destino = '".$List->getelem()->id_estado_destino."' " : "") . "
					";
        $id_cot=$List->getelem()->id_cotizacion;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtocambiosestado;
            $Registro->id_estado_origen	 = 	$row['id_estado_origen'];
            $Registro->id_estado_destino = 	$row['id_estado_destino'];	
            $Registro->nomaccion		 = 	$row['nomaccion'];	
            $Registro->id_cotizacion	 =  $id_cot;			
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
    public function savecambiosestado($List) {
    	global $ses_usr_login;
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
            return false;
    	}
        $query = "	UPDATE cotizacion_e 
                    SET	id_estado='".$List->getelem()->id_estado_destino ."' 
                    , usrmod = '".$ses_usr_login."' 
                    , fecmod = now()
                    WHERE id_cotizacion = ".$List->getelem()->id_cotizacion ;
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        return true;
   	}

	public function cambiosestadocot($List) {
    	global $ses_usr_login;
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
            return false;
    	}
        $query = "	UPDATE cotizacion_e 
                    SET	id_estado='".$List->getelem()->id_estado_destino ."' 
                    , usrmod = '".$ses_usr_login."' 
                    , fecmod = now()
                    WHERE id_cotizacion = ".$List->getelem()->id_cotizacion ;
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        return true;
   	}

    public function savecambiooe($List) {
    	
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
            return false;
    	}
        $query = "	UPDATE ordenent_e 
                    SET	id_estado='".$List->getelem()->id_estado_destino ."' 
                    , usrmod = '".$List->getelem()->usrmod."' 
                    , fecmod = now()
                    WHERE id_ordenent = ".$List->getelem()->id_ordenent ;
		$res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        return true;
   	}
    
}
?>
