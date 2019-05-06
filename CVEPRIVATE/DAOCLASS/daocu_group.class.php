<?php
class daocu_group{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   
   
	public function getcu_group($List) {
		$List->gofirst();
        $query = "SELECT id_group,group_desc FROM cu_group";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $User = new dtocu_group;
            $User->id_group = $row['id_group'];
            $User->group_desc = $row['group_desc'];                                                 
            $List->addlast($User);
        }
        $res->free();
        return true;
    }

}
?>