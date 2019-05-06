<? 
class daoclasificacioncliente{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   
   
	public function getclasificacioncliente($List) {
		$List->gofirst();
        $query = "SELECT id_clasificacion_cli, descripcion_clasificacion FROM clasificacion_cliente";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $User = new dtoclasificacioncliente;
            $User->id_clasificacion_cli = $row['id_clasificacion_cli'];
            $User->descripcion_clasificacion = $row['descripcion_clasificacion'];                
                             
                                             
            $List->addlast($User);
        }
        $res->free();
        return true;
    }

}
?>
