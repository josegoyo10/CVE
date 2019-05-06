<? 
class daotipodocumentoidentidad{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   
   
	public function gettipodocumentoidentidad($List) {
		$List->gofirst();
        $query = "SELECT id_documento_identidad, siglas_documento, descripcion_documento FROM documento_identidad order by descripcion_documento";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $User = new dtotipodocumentoidentidad;
            $User->id_documento_identidad = $row['id_documento_identidad'];
            $User->siglas_documento = $row['siglas_documento'];                
            $User->descripcion_documento = $row['descripcion_documento'];                 
                                             
            $List->addlast($User);
        }
        $res->free();
        return true;
    }

}
?>
