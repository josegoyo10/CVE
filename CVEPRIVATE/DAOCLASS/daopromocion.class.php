<?
class daopromocion{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }

    public function initrx(){
        $res = $this->bd->querynoselect("SET AUTOCOMMIT=0");
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

		return true;
    }

    public function rollback(){
        $res = $this->bd->querynoselect("ROLLBACK");
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $this->bd->querynoselect("SET AUTOCOMMIT=1");
        return true;
    }

    public function commit(){
        $res = $this->bd->querynoselect("COMMIT");
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $this->bd->querynoselect("SET AUTOCOMMIT=1");
        return true;
    }

   
    public function getMonitorpromocion($List) {
    	$List->gofirst();
 						   
    	$query = "	SELECT id_promo,
						   ce.descripcion,
  						   ce.cod_local,
                           descuento,
                           fecini,
                           fecterm,
  						   ce.usrcrea,
                           ce.feccrea,
                           ce.usrmod,
                           ce.fecmod,
						   ce.subrubro,
   						   g.nomgrupo as grupo,
						   e.descripcion as nomestado
                    FROM 	cve.promo_cve ce
                    LEFT JOIN 	estado e on (e.id_estado=ce.estado)
                    LEFT JOIN 	locales l2 on (l2.cod_local=ce.cod_local)
                    LEFT JOIN   grupotcp g on (g.id_grupo = ce.tcp_grupo)
					WHERE 	1 
                    " . (($List->getelem()->cod_local)? " and l2.cod_local = '".$List->getelem()->cod_local."' " : "") . "
                    " . (($List->getelem()->grupo)? " and g.id_grupo = '" . $List->getelem()->grupo . "'" : "") ."   
   					" . (($List->getelem()->fechaucofini)? " and ce.fecini >= '".$List->getelem()->fechaucofini."'" : "") . "
                    " . (($List->getelem()->fechaucoffin)? " and ce.fecterm <= '".$List->getelem()->fechaucoffin."'" : "") . "
                    ";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $promocion = new dtopromocion;
            $promocion->id_promo       = 	$row['id_promo'];
            $promocion->descripcion	= 	$row['descripcion'];
            $promocion->descuento	= 	$row['descuento'];
            $promocion->subrubro	= 	$row['subrubro'];
            $promocion->fecini	= 	$row['fecini'];
            $promocion->fecterm	= 	$row['fecterm'];
            $promocion->grupo	        = 	$row['grupo'];
            $promocion->usuario		= 	$row['usrcrea'];
            $promocion->feccrea		= 	$row['feccrea'];
            $promocion->nomestado		= 	$row['nomestado'];
            $promocion->cod_local	= 	$row['cod_local'];					
            $promocion->puedever		= 	(($row['id_estado']=='CB')?false:false);
            $promocion->puedemodificar	= 	(($row['id_estado']=='CT')?true:false);
            $promocion->puedeeliminar	= 	(($row['id_estado']=='CT')?true:true);

            //$promocion->total_coti		=	$total_coti;
            $List->addlast($promocion);            }
        $res->free();
		return true;
    }


     public function getGrupoDet($List) {
    	$List->gofirst();
 						   
    	$query = "	SELECT
						id_grupo,
						nomgrupo as grupo,
						g.usrcrea,
						g.feccrea,
						count(t.tcp_rut) as cantidad
					FROM grupotcp g
						 LEFT JOIN tcp as t on (t.tcp_grupo = g.id_grupo)
					WHERE 1 
					 ". (($List->getelem()->grupo)? " and g.id_grupo = '" . $List->getelem()->grupo . "'" : "") ."						 
 					 group by id_grupo
					 order by 1
	                  ;";

        $res = $this->bd->query($query);
//      general::writeevent($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $promocion = new dtopromocion;
//            general::alert($row['id_promo']);
            $promocion->id_grupo       = 	$row['id_grupo'];
            $promocion->grupo	        = 	$row['grupo'];
            $promocion->usuario		= 	$row['usrcrea'];
            $promocion->feccrea		= 	$row['feccrea'];
            $promocion->cantidad		= 	$row['cantidad'];
            $promocion->puedever		= 	(($row['id_estado']=='CB')?false:false);
            $promocion->puedemodificar	= 	(($row['id_estado']=='CT')?true:true);
            $promocion->puedeeliminar	= 	(($row['id_estado']=='CT')?true:true);

            //$promocion->total_coti		=	$total_coti;
            $List->addlast($promocion);            }
        $res->free();
		return true;
    }
    
    
	public function insertgrupo($List) {
    	$List->gofirst();
 						   
    	$query = "	INSERT INTO grupotcp VALUES
                   (null,
					'".$List->getelem()->grupo."',
					'".$List->getelem()->usuario."',
					now(),
					'".$List->getelem()->usuario."',					
					now()) 
                    ;";
//general::alert($query);
        $res = $this->bd->query($query);
//      general::writeevent($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
    }

    
    
    
    public function insertpromo($List) {
    	$List->gofirst();
 						   
    	$query = "	INSERT INTO promo_cve VALUES
                   (null,
					'".$List->getelem()->descripcion."',
					'".$List->getelem()->subrubro."',
					'".$List->getelem()->cod_local."',
					'',					
					'P',
					'".$List->getelem()->descuento."',
					'".$List->getelem()->fechaucofini."',
					'".$List->getelem()->fechaucoffin."',
					'".$List->getelem()->usuario."',
					now(),
					'".$List->getelem()->usuario."',
					now(),
					'".$List->getelem()->grupo."',
					'VG') 
                    ;";
//general::alert($query);
        $res = $this->bd->query($query);
//      general::writeevent($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
    }


    
  	 public function insertcp($List) {
    	$List->gofirst();
 					   
    	$query = "	INSERT INTO tcp VALUES
                   ('".$List->getelem()->rut."',
					".$List->getelem()->id_grupo.",
					'".$List->getelem()->usuario."',
					now(),
					'".$List->getelem()->usuario."',
					now());";
    	$res = $this->bd->query($query);
    //general::writelog($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
       }
    
    
    public function deletcp($List) {
    	$List->gofirst();
 					   
    	$query = "	DELETE FROM tcp WHERE
                    tcp_grupo = '".$List->getelem()->id_grupo."'
                    and tcp_rut = '".$List->getelem()->rut."'
				";
    	
    	$res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
       }
    

    public function deletgrupo($List) {
    	$List->gofirst();
 					   
    	$query = "	DELETE FROM grupotcp WHERE
                   id_grupo = '".$List->getelem()->id_grupo."'
                    ";

    	$res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;

    
    	$List->gofirst();
 					   
    	$query = "	DELETE FROM tcp WHERE
                   tcp_grupo = '".$List->getelem()->id_grupo."'
                    ";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
		
    }
    
 	public function deletpromo($List) {
    	$List->gofirst();
 						   
    	$query = "	DELETE FROM promo_cve WHERE
                   id_promo = '".$List->getelem()->id_promo."'
                    ";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
    }
    
    public function getsubrubro($List) {
    	$List->gofirst();
            $query = "	SELECT id_catprod_3, descat_3 FROM subrubros s
						WHERE 1
						AND id_catprod_3 ='".$List->getelem()->id_promo."'
						";
            
            $res = $this->bd->querynoselect($query);
//			general::writeevent($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $promocion = new dtopromocion;
            $promocion->id_promo	= 	$row['id_catprod_3'];
            $promocion->descripcion	= 	$row['descat_3'];
            $List->addlast($promocion);            
		}
		$res->free();
		return true;
    } 
    public function getrubrosubrubro($List) {
    	$List->gofirst();
		$query = "	SELECT DISTINCT id_catprod_3 id,
					descat_3 descat
					FROM SUBRUBROS
					WHERE 1
					AND id_catprod_3 > 0
                    AND descat_3 LIKE '%".$List->getelem()->descripcion."%'
					";
            
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $promocion = new dtopromocion;
            $promocion->id_promo	= 	$row['id'];
            $promocion->descripcion	= 	$row['descat'];
            $List->addlast($promocion);            
		}
		$res->free();
		return true;
    } 
}
?>
