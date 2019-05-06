<?php
class daotipocontribuyente{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   
   
	public function gettipocontribuyente($List) {
		$List->gofirst();
        $query = "SELECT id_contribuyente, descripcion, admitido 
        		  FROM tipocontribuyente
        		  WHERE 1
                  " . (($List->getelem()->admitido)? " AND admitido = ".$List->getelem()->admitido." " : "") . " 
        		  order by id_contribuyente";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		general::writeevent($query);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $User = new dtotipocontribuyente;
            $User->id_contribuyente = $row['id_contribuyente'];
            $User->descripcion = $row['descripcion'];                
            $User->admitido = $row['admitido'];                          
            $List->addlast($User);
        }
        $res->free();
        return true;
    }

}
?>