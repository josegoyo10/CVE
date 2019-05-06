<?
class daotracking{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   
	
    public function gettracking($List){
		$List->gofirst();
        $query = "	SELECT	id_tracking,
                            id_cotizacion,
                            id_ordenent,
                            id_ordenpicking,
                            id_documento,
                            tipo,
                            descripcion,
                            usrcrea,
                            DATE_FORMAT(feccrea, '%e/%m/%Y %H:%i:%S') as feccrea
                    FROM tracking
                    WHERE 1
                    " . (($List->getelem()->id_cotizacion)? " and id_cotizacion = ".$List->getelem()->id_cotizacion : "") . "
                    " . (($List->getelem()->id_ordenent)? " and id_ordenent = ".$List->getelem()->id_ordenent : "") . "
                    " . (($List->getelem()->id_ordenpicking)? " and id_ordenpicking = ".$List->getelem()->id_ordenpicking : "") . "
                    " . (($List->getelem()->id_documento)? " and id_documento = ".$List->getelem()->id_documento : "") . "
                    ";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotracking;
            $Registro->id_cotizacion	= 	$row['id_cotizacion'];
            $Registro->id_ordenent		= 	$row['id_ordenent'];
            $Registro->id_ordenpicking	= 	$row['id_ordenpicking'];
            $Registro->id_documento		= 	$row['id_documento'];
            $Registro->tipo				= 	$row['tipo'];
            $Registro->descripcion		= 	$row['descripcion'];
            $Registro->usrcrea			= 	$row['usrcrea'];
            $Registro->feccrea			= 	$row['feccrea'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function inserttracking($List){
    	global $ses_usr_login;
		$List->gofirst();
        $query = "	INSERT INTO tracking (	
                        id_cotizacion,
                        id_ordenent, 
                        id_ordenpicking, 
                        id_documento, 
                        tipo, 
                        descripcion, 
                        usrcrea, 
                        feccrea,
                        usrmod, 
                        fecmod
                    )
                    VALUES (
                            ".($List->getelem()->id_cotizacion+0).",
                            ".($List->getelem()->id_ordenent+0).",
                            ".($List->getelem()->id_ordenpicking+0).",
                            ".($List->getelem()->id_documento+0).",
                            '".$List->getelem()->tipo."',
                            '".sprintf("%252.252s", $List->getelem()->descripcion)."',
                            '".(($List->getelem()->usrcrea)?$List->getelem()->usrcrea:$ses_usr_login)."',
                            now(),
                            '".$ses_usr_login."',
                            now()
                    )";
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        return true;
    }
}
?>
