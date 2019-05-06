<?
class daooperaciones{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    
    public function __destruct(){
        //$this->bd->close();
    }   
	    
    public function getcpu($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '1' and evento = '1'" ;
        $res = $this->bd->query($query);
		//general::writeevent($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->area		= $row['area'];
            $Est->evento	= $row['evento']; 
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }

    public function getdiscolog($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '1' and evento = '2'" ;
        $res = $this->bd->query($query);
		//general::writeevent($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->area		= $row['area'];
            $Est->evento	= $row['evento']; 
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }

    public function getdiscobd($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '1' and evento = '3'" ;
        $res = $this->bd->query($query);
		//general::writeevent($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->area		= $row['area'];
            $Est->evento	= $row['evento']; 
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }

	public function getmemoria($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '1' and evento = '4'" ;
        $res = $this->bd->query($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->area		= $row['area'];
            $Est->evento	= $row['evento']; 
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }
    
	public function getclasificacionmensaje($List) {
		$List->gofirst();    	
        $query = "SELECT GLO_ID,GLO_TITULO FROM glo_grupos where GLO_ORDEN=2";
        $res = $this->bd->query($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->area		= $row['GLO_ID'];
            $Est->evento	= $row['GLO_TITULO'];   	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }

	public function getmensajeeditor($List) {
		$List->gofirst();    	
        $query = "SELECT VAR_ID,VAR_DESCRIPCION 
        		FROM glo_variables g 
        		where 1
        		" . (($List->getelem()->area)? " and VAR_GLO_ID= ".$List->getelem()->area." " : "") . "
        		order by VAR_ID";
        $res = $this->bd->query($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->valor		= $row['VAR_ID'];
            $Est->texto		= $row['VAR_DESCRIPCION'];   	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }
    
	public function financiacion_interes_ncheques($List) {
		$List->gofirst();    	
        $query = "SELECT VAR_VALOR AS INTERES
			 FROM glo_variables g
 			 WHERE VAR_GLO_ID=8
		     AND ".$List->getelem()->valor." >= SUBSTRING(SUBSTRING(VAR_LLAVE,17),1,LOCATE('-', SUBSTRING(VAR_LLAVE,18)))
  			 AND ".$List->getelem()->valor." <= SUBSTR(SUBSTRING(VAR_LLAVE,18),LOCATE('-', SUBSTRING(VAR_LLAVE,17)))
			 AND VAR_LLAVE LIKE '%_INTERES%'";
        $res = $this->bd->query($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->valor		= $row['INTERES'];   	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }
    
    public function getapache($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '2' and evento = '11'" ;
        $res = $this->bd->query($query);
		//general::writeevent($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->area		= $row['area'];
            $Est->evento	= $row['evento']; 
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }

	public function getmysql($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '2' and evento = '12'" ;
        $res = $this->bd->query($query);
		//general::writeevent($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->area		= $row['area'];
            $Est->evento	= $row['evento']; 
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }

	public function checktablas($List) {
	$List->gofirst();    	
	$query = "CHECK TABLE
      cambiosestado,
      ciudad,
      cliente,
      comuna,
      cotizacion_d,
      cotizacion_e,
      direccion,
      disponible,
      documento_d,
      documento_e,
      estado,
      glo_grupos,
      glo_variables,
      iplocal,
      locales,
      mensaje,
      modulos,
      ordenent_d,
      ordenent_e,
      ordenpicking_d,
      ordenpicking_e,
      perfiles,
      perfilesxusuario,
      permisosxmodulo,
      prioridad,
      region,
      rubro,
      stock,
      tipocliente,
      tipocondicionpago,
      tipodocpago,
      tipodocumento,
      tipoentrega,
      tipoflujo,
      tipogiro,
      tipomensaje,
      tipomovimiento,
      tipoorigen,
      tipopago,
      tiporetiro,
      tipousuario,
      tipoventa,
      tracking,
      usuarios" ;
        $res = $this->bd->query($query);
		//general::writeevent($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();  
			while ($row = $res->fetch_assoc()){
				$Est = new dtooperaciones;
				$Est->texto = $row['Msg_type'];
				$Est->error = $row['Msg_text'];
				$Est->nomtabla_error = $row['Table'];
				
				$List->addlast($Est);
			}
        $res->free();
        return true;
    }

	public function getftp($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '2' and evento = '13'" ;
        $res = $this->bd->query($query);
		//general::writeevent($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->area		= $row['area'];
            $Est->evento	= $row['evento']; 
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }

	public function getcups($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '2' and evento = '14'" ;
        $res = $this->bd->query($query);
		//general::writeevent($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->area		= $row['area'];
            $Est->evento	= $row['evento']; 
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }

	public function getfct_bd($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '4' and evento='31'" ;
        $res = $this->bd->query($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones; 
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }

	public function getfct_fs($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '4' and evento='32'" ;
        $res = $this->bd->query($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }
	
	public function getfct_ftp($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '4' and evento='33'" ;
        $res = $this->bd->query($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }

	public function getgde_bd($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '4' and evento='34'" ;
        $res = $this->bd->query($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }
	
	public function getgde_fs($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '4' and evento='35'" ;
        $res = $this->bd->query($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }
	
    public function getgde_ftp($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '4' and evento='36'" ;
        $res = $this->bd->query($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }
	
    public function getncr_bd($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '4' and evento='37'" ;
        $res = $this->bd->query($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }
	
    public function getncr_fs($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '4' and evento='38'" ;
        $res = $this->bd->query($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }
	
    public function getncr_ftp($List) {
		$List->gofirst();    	
        $query = "  SELECT  valor
                    FROM operaciones
                    WHERE 1
                    and area = '4' and evento='39'" ;
        $res = $this->bd->query($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtooperaciones;
            $Est->valor		= $row['valor'];  	 								
            $List->addlast($Est);
        }
        $res->free();
        return true;
    }
}
?>
