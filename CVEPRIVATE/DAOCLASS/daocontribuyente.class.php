<? 
class daocontribuyente{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   
   
	public function getcontribuyente($List) {
		$List->gofirst();
        $query = "SELECT id_regimencontri, upper(descripcionregimen) as descripcionregimen  FROM regimen_contribuyente order by id_regimencontri";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $User = new dtocontribuyente;
            $User->id_regimencontri = $row['id_regimencontri'];
            $User->descripcionregimen = $row['descripcionregimen'];                
                             
                                             
            $List->addlast($User);
        }
        $res->free();
        return true;
    }

}
?>
