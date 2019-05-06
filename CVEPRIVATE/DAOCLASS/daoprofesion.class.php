<?php
class daoprofesion{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   
   
	public function getprofesion($List) {
		$List->gofirst();
        $query = "SELECT id,descripcion FROM cu_profesion";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Profesion = new dtoprofesion;
            $Profesion->id_profesion = $row['id'];
            $Profesion->descripcion = $row['descripcion'];                                               
            $List->addlast($Profesion);
        }
        $res->free();
        return true;
    }

}
?>