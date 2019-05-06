<?
class daoestado{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   
	    
    public function getestados($List) {
		$List->gofirst();    	
        $query = "  SELECT  id_estado, 
                            descripcion, 
                            tipo
                    FROM estado
                    WHERE 1
                    and id_estado <> 'ES'
                    " . (($List->getelem()->tipo)? " and tipo = '".$List->getelem()->tipo."' " : "") . "	
                    " . (($List->getelem()->id_estado)? " and id_estado = '".$List->getelem()->id_estado."' " : "") . "	
                    order by descripcion " ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtoestado;
            $Est->id_estado		= $row['id_estado'];
            $Est->descripcion	= $row['descripcion']; 
            $Est->tipo			= $row['tipo'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }
    
    public function getestadosdocumento($List) {
		$List->gofirst();    	
        $query = "  SELECT  id_estado, 
                            descripcion, 
                            tipo
                    FROM estado
                    WHERE 1
                    " . (($List->getelem()->tipo)? " and tipo = '".$List->getelem()->tipo."' " : "") . "	
                    " . (($List->getelem()->id_estado)? " and id_estado IN ('".$List->getelem()->id_estado."') " : "") . "	
                    order by descripcion " ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtoestado;
            $Est->id_estado		= $row['id_estado'];
            $Est->descripcion	= $row['descripcion']; 
            $Est->tipo			= $row['tipo'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }
}
?>
