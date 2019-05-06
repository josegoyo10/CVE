<?
class daolocal{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   
	    
    public function getlocales($List) {
		$List->gofirst();    	
        $query = "  SELECT  cod_local,
                            if(cod_local ='".$List->getelem()->cod_local."', 'selected', '') as cod_local_selected ,
                            nom_local, 
                            dir_local, 
                            ip_local, 
                            foliofct,
							plaza,
							ofventa,
							foliogde,
							cod_local_pos,
							id_localizacion,
							almacen_cod,
							oneeasy
                    FROM locales
                    WHERE 1
                    " . (($List->getelem()->not_cod_local)? " and cod_local not in('" . $List->getelem()->not_cod_local . "')" : "") . "
                    " . (($List->getelem()->cod_local)? " and cod_local = '" . $List->getelem()->cod_local . "'" : "") . "
                    " . (($List->getelem()->ofventa)? " and ofventa = '" . $List->getelem()->ofventa . "'" : "") . "
                    order by nom_local" ;
        
        $res = $this->bd->query($query);
        //general::writeevent('locales '.$query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Loc = new dtolocal;
            $Loc->nom_local	= $row['nom_local'];
            $Loc->cod_local	= $row['cod_local']; 
            $Loc->cod_local_selected	= $row['cod_local_selected'];  	 								
            $Loc->dir_local	= $row['dir_local']; 
            $Loc->ip_local	= $row['ip_local']; 
            $Loc->plaza	= $row['plaza']; 
            $Loc->ofventa	= $row['ofventa']; 
            $Loc->foliofct	= $row['foliofct'];				
            $Loc->foliogde	= $row['foliogde'];
            $Loc->cod_local_pos = $row['cod_local_pos'];
            $Loc->id_localizacion = $row['id_localizacion'];
            $Loc->almacen_cod = $row['almacen_cod']; 
            $Loc->oneeasy = $row['oneeasy'];
            $List->addlast($Loc);
        }
        $res->free();
        return true;
    }
    
	public function getcambiolocales($List) {
		$List->gofirst();
		    	
        $query = "  SELECT  cod_local,
                            nom_local, 
                            dir_local, 
                            ip_local, 
                            foliofct,
							plaza,
							ofventa,
							foliogde,
							cod_local_pos,
							id_localizacion
                    FROM locales
                    WHERE 1 
                    " . (($List->getelem()->cod_local)? " and cod_local = '" . $List->getelem()->cod_local . "'" : "") . "
                    " . (($List->getelem()->cod_local)? "or cod_local =(SELECT cod_local FROM  locales join facturacion_suministro on (cod_local_fac = cod_local and tienda_virtual=true) and cod_local_sum='" . $List->getelem()->cod_local . "')" : "") . "
                    order by nom_local" ;
        // general::writeevent($query);
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Loc = new dtolocal;
            $Loc->nom_local	= $row['nom_local'];
            $Loc->cod_local	= $row['cod_local']; 
            $Loc->cod_local_selected	= $row['cod_local_selected'];  	 								
            $Loc->dir_local	= $row['dir_local']; 
            $Loc->ip_local	= $row['ip_local']; 
            $Loc->plaza	= $row['plaza']; 
            $Loc->ofventa	= $row['ofventa']; 
            $Loc->foliofct	= $row['foliofct'];				
            $Loc->foliogde	= $row['foliogde'];
            $Loc->cod_local_pos = $row['cod_local_pos'];
            $Loc->id_localizacion = $row['id_localizacion'];
            $List->addlast($Loc);
        }
        $res->free();
        return true;
    }
    
	public function local_sum_asociado($List) {
		$List->gofirst();
		    	
        $query = "  SELECT  
        			cod_local_fac,
        			cod_local_sum
                    FROM facturacion_suministro
                    WHERE 1 
                    " . (($List->getelem()->cod_local_fac)? " and cod_local_fac = '" . $List->getelem()->cod_local_fac . "'" : "") . "
                    " . (($List->getelem()->cod_local_sum)? " and cod_local_sum = '" . $List->getelem()->cod_local_sum . "'" : "") . "";
        //general::writeevent($query);
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Loc = new dtolocal;
            $Loc->cod_local_fac	= $row['cod_local_fac'];
            $Loc->cod_local_sum	= $row['cod_local_sum']; 
            $List->addlast($Loc);
        }
        $res->free();
        return true;
    }
    
    public function getlocaleselect($List) {
		$List->gofirst();    	
        $query = "  SELECT  cod_local,
                            if(cod_local ='".$List->getelem()->cod_local."', 'selected', '') as cod_local_selected ,
                            nom_local, 
                            dir_local, 
                            ip_local, 
                            foliofct, 
							plaza,
							ofventa
                    FROM locales
                    WHERE 1
                    ORDER BY nom_local" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Loc = new dtolocal;
            $Loc->nom_local	= $row['nom_local'];
            $Loc->cod_local	= $row['cod_local']; 
            $Loc->cod_local_selected	= $row['cod_local_selected'];  	 								
            $List->addlast($Loc);
        }
        $res->free();
        return true;
    }
    
    
    public function validaiplocal($List) {
		$List->gofirst();
    	$query = "SELECT ip,
                         cod_local 
                  FROM iplocal
                  WHERE 1 
                  " . (($List->getelem()->cod_local)? " and cod_local = '".$List->getelem()->cod_local."' " : "") . "
                  " . (($List->getelem()->ip_local)? " and ip = '".$List->getelem()->ip_local."' " : "") . "
                 " ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        while ($row = $res->fetch_assoc()){
            $Loc = new dtolocal;
            $Loc->ip_local = $row['ip'];
            $Loc->cod_local = $row['cod_local'];                
            $List->addlast($Loc);
        }
        $res->free();
        return true;
    }
   
    public function getiplocal($List) {
		$List->gofirst();
        $query = "	SELECT 	l.nom_local,
							ip,
							i.cod_local 
					FROM 	iplocal i
					JOIN	locales l on i.cod_local=l.cod_local
					WHERE	1 
					" . (($List->getelem()->ip)? " and ip like '%" . $List->getelem()->ip . "%'" : "") . "
					" . (($List->getelem()->cod_local!='0')? " and i.cod_local = '" . $List->getelem()->cod_local . "'" : "") . "
					order by l.nom_local";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Loc = new dtolocal;
            $Loc->nom_local = $row['nom_local'];                     
            $Loc->cod_local = $row['cod_local'];   
            $Loc->ip_local  = $row['ip'];
            $List->addlast($Loc);
        }
        $res->free();
        return true;
    }    

    public function insertiplocal($List){
    	global $ses_usr_login;
		$List->gofirst();
        $query = "	INSERT INTO iplocal (
					ip, 
					cod_local, 
					usrcrea, 
					feccrea   	
                    )
                    VALUES (
                            '".$List->getelem()->ip_local."',
                            '".$List->getelem()->cod_local."',
                            '".$ses_usr_login."',
                            now()
                    )";
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        return true;
    }

	    public function savelocal($List){
    	global $ses_usr_login;
		$List->gofirst();
        $query = "	INSERT INTO locales (
					cod_local, 
					nom_local, 
					dir_local, 
					ip_local,
					cod_local_pos,
					plaza,
					ofventa,
					despdom,
					foliofct,
					foliogde
                    )
                    VALUES (
                            " . (($List->getelem()->cod_local)? "'" . $List->getelem()->cod_local . "'" : "null").",
							" . (($List->getelem()->nom_local)? "'" . $List->getelem()->nom_local . "'" : "null").",
                            " . (($List->getelem()->dir_local)? "'" . $List->getelem()->dir_local . "'" : "null").",
                            " . (($List->getelem()->ip_local)? "'" . $List->getelem()->ip_local . "'" : "null").",
							" . (($List->getelem()->cod_local_pos)? "'" . $List->getelem()->cod_local_pos . "'" : "null").",
                            " . (($List->getelem()->plaza)? "'" . $List->getelem()->plaza . "'" : "null").",
                            " . (($List->getelem()->id_sap)? "'" . $List->getelem()->id_sap . "'" : "null").",
                            " . (($List->getelem()->despdom)? "'" . $List->getelem()->despdom . "'" : "null").",
                            " . (($List->getelem()->foliofct)? "'" . $List->getelem()->foliofct . "'" : "null").",
                            " . (($List->getelem()->foliogde)? "'" . $List->getelem()->foliogde . "'" : "null")."
                    )";
        $res = $this->bd->querynoselect($query);
		//general::writeevent($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        return true;
    }

	 public function updatelocal($List){
    	global $ses_usr_login;
		$List->gofirst();
        $query = "	UPDATE locales SET 
                            " . (($List->getelem()->cod_local)? " cod_local ='" . $List->getelem()->cod_local . "'" : "")."
							" . (($List->getelem()->nom_local)? " ,nom_local ='" . $List->getelem()->nom_local . "'" : "")."
                            " . (($List->getelem()->dir_local)? " ,dir_local ='" . $List->getelem()->dir_local . "'" : "")."
                            " . (($List->getelem()->ip_local)? " ,ip_local ='" . $List->getelem()->ip_local . "'" : "")."
							" . (($List->getelem()->cod_local_pos)? " ,cod_local_pos ='" . $List->getelem()->cod_local_pos . "'" : "")."
                            " . (($List->getelem()->plaza)? " ,plaza ='" . $List->getelem()->plaza . "'" : "")."
                            " . (($List->getelem()->id_sap)? " ,ofventa ='" . $List->getelem()->id_sap . "'" : "")."
                            " . (($List->getelem()->despdom)? " ,despdom ='" . $List->getelem()->despdom . "'" : "")."
                   WHERE cod_local = '".$List->getelem()->cod_local_selected."'";
        $res = $this->bd->querynoselect($query);
		//general::writeevent($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        return true;
    }
    
    public function deliplocal($List) {
    	global $ses_usr_login;
    	$List->gofirst();
            $query = "	DELETE FROM iplocal
                        WHERE 1
						and  ip = '".$List->getelem()->ip."' 
						and  cod_local = '".$List->getelem()->cod_local."'"            ;
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            return true;

    }    
    
 public function saveiplocal($List) {
    	global $ses_usr_login;
    	$List->gofirst();
            $query = "	UPDATE iplocal 
                        SET
					      ip = '".$List->getelem()->ip_local."' 
					    , cod_local = '".$List->getelem()->cod_local."' 
                        , usrmod = '".$ses_usr_login."' 
                        , fecmod = now()
                        WHERE 1
					" . (($List->getelem()->ip)? " and ip = '" . $List->getelem()->ip . "'" : "") . "
					" . (($List->getelem()->cod_local)? " and cod_local = '" . $List->getelem()->cod_local . "'" : "")."
					";
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

            return true;
    	}    
    
    
}
?>
