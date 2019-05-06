<?php
class daotipos{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   
	    
	public function gettipousuario($List) {
        $query = "	SELECT 	id_tipousuario as id, 
                            descripcion as nombre 
                    FROM 	tipousuario ORDER BY descripcion" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
	public function gettipocontribuyente($List) {
        $query = "	SELECT id_contribuyente, descripcion FROM tipocontribuyente order by descripcion" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id_contribuyente'];
            $Registro->nombre 	= 	$row['descripcion'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function gettipoventa($List) {
        $query = "	SELECT 	id_tipoventa as id, 
                            descripcion as nombre 
                    FROM 	tipoventa
                    WHERE id_tipoventa = 2" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function gettiporetiro($List) {
        $query = "	SELECT 	id_tiporetiro as id, 
                            descripcion as nombre 
                    FROM 	tiporetiro" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function gettipopago($List) {
        $query = " SELECT 	id_tipopago as id, 
                            descripcion as nombre 
                    FROM 	tipopago" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function gettipodocpago($List) {
    	if ($List && $List->numelem())
    		$List->gofirst();
        $query = " SELECT 	id_tipodocpago as id, 
                            descripcion as nombre,
							reqnumdoc as valor, 
							id_tipopago as valor2 
                   FROM 	tipodocpago
                   WHERE 1
                   " . (($List->getelem()->valor2)? "and id_tipopago =".$List->getelem()->valor2." " : "")."
                   " . (($List->getelem()->valor3)? "and id_tipodocpago =".$List->getelem()->valor3." " : "")."
                   ";
     
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $Registro->valor 	= 	$row['valor'];
            $Registro->valor2 	= 	$row['valor2'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function gettipomovimiento($List) {
        $query = "	SELECT 	id_tipomovimiento as id, 
                            descripcion as nombre 
                    FROM 	tipomovimiento" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function gettipomensaje($List) {
        $query = "	SELECT 	id_tipomensaje as id, 
                            descripcion as nombre 
                    FROM 	tipomensaje" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function gettipoflujo($List) {
        $List->gofirst();
        $query= "  SELECT  id_tipoflujo as id,
					        descripcion as nombre,
					     	nomtflujo as valor,
							tipoz as valor2,
							tipofacturacion as valor3
                   FROM 	tipoflujo
                   WHERE 1
                   " . (($List->getelem()->id)? "and id_tipoflujo =".$List->getelem()->id." " : "")."
                   " . (($List->getelem()->nombre)? "and descripcio ='".$List->getelem()->nombre."'" : "")."
                   " . (($List->getelem()->valor)? "and nomtflujo ='".$List->getelem()->valor."'" : "")."
                   " . (($List->getelem()->valor2) ?"and tipoz ='".$List->getelem()->valor2."'" : "")."
                   ";
		$res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $Registro->valor 	= 	$row['valor'];
            $Registro->valor2 	= 	$row['valor2'];
            $Registro->valor3 	= 	$row['valor3'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
	public function gettipoflujoreporte($List) {
        $List->gofirst();
        $query= "   SELECT  id_tipoflujo, descripcion FROM tipoflujo
                   ";
		$res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id_tipoflujo'];
            $Registro->nombre 	= 	$row['descripcion'];
   //         general::alert($row['id_tipoflujo']);
  //          general::alert($row['descripcion']);            
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function gettipoentrega($List) {
        $query = "	SELECT 	id_tipoentrega as id, 
                            descripcion as nombre 
                    FROM 	tipoentrega" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function gettipodocumento($List) {
        $query = "	SELECT 	id_tipodocumento as id, 
                            descripcion as nombre 
                    FROM 	tipodocumento" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
    public function gettipodocumentoreporte($List) {
        $query = "	SELECT 	id_tipodocumento as id, 
                            descripcion as nombre 
                    FROM 	tipodocumento
					WHERE id_tipodocumento <> 2" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function gettipocliente($List) {
        $query = "	SELECT 	id_tipocliente as id, 
                            descripcion as nombre 
                    FROM 	tipocliente" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function getrubro($List) {
        $query = "	SELECT 	id_rubro as id, 
                            descripcion as nombre 
                    FROM 	rubro" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
    public function getprioridad($List) {
    	$query = "	SELECT 	id_prioridad as id, 
                            descripcion as nombre 
                    FROM 	prioridad" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function getciudad($List){

    	$query = "	SELECT 	id_ciudad as id_ciudad, 
                            descripcion as nomciudad 
                    FROM 	ciudad 
                   	WHERE 	1
                    ";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtocomuna;
            $Registro->id_ciudad 	= 	$row['id_ciudad'];
            $Registro->nomciudad 	= 	$row['nomciudad']; 
            $List->addlast($Registro);
        }
        $res->free();
        return true;     
    }
   
    
    public function getdepartamentos($List){

    	$query = "SELECT ID, DESCRIPTION FROM cu_department order by DESCRIPTION";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtocomuna;
            $Registro->id_ciudad 	= 	$row['ID'];
            $Registro->nomciudad 	= 	$row['DESCRIPTION']; 
            $List->addlast($Registro);
        }
        $res->free();
        return true;     
    }
    
    public function getcomuna($List, $opcionSeleccionada) {
    	$List->gofirst();
        $query = "	SELECT 	id_comuna, 
                            descripcion as nomcomuna 
                    FROM 	comuna 
                   	WHERE id_ciudad = '$opcionSeleccionada'
					";
//id_ciudad = '$opcionSeleccionada'
        
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtocomuna;
            $Registro->id_comuna 	= 	$row['id_comuna'];
            $Registro->nomcomuna 	= 	$row['nomcomuna']; 
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
	public function getciudades($List, $opcionSeleccionada) {
    	$List->gofirst();
        $query = "SELECT  a.ID_DEPARTMENT,a.ID as ID_PROVINCE, a.DESCRIPTION as MUNICIPIO, b.ID as ID_CITY,b.DESCRIPTION  as CIUDAD FROM cu_province a inner join cu_city b on a.ID=b.ID_PROVINCE and a.ID_DEPARTMENT=b.ID_DEPARTMENT where a.ID_DEPARTMENT='$opcionSeleccionada' order by CIUDAD";
        
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtocomuna;
            $Registro->id_ciudad 	= 	$row['ID_CITY'];
            $Registro->nomciudad 	= 	$row['CIUDAD'];
            $Registro->id_region 	= 	$row['ID_PROVINCE']; 
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
 	
	public function getbarrios($List, $opcionSeleccionada,$ciudad,$province) {
    	$List->gofirst();
        $query = "SELECT b.ID_DEPARTMENT,b.ID_PROVINCE,b.ID_CITY,b.ID_LOCALITY,b.ID,b.DESCRIPTION as barrio,b.LOCATION as localizacion,a.description as localidad FROM cu_neighborhood b inner join cu_locality a on(a.ID=b.ID_LOCALITY and a.ID_DEPARTMENT=b.ID_DEPARTMENT and a.ID_PROVINCE=b.ID_PROVINCE and a.ID_CITY=b.ID_CITY) where b.ID_DEPARTMENT='$opcionSeleccionada' and b.ID_PROVINCE='$province' and b.ID_CITY='$ciudad' order by b.DESCRIPTION";

        file_put_contents("querybarrios.txt", print_r($query,true));
        
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtocomuna;
            $Registro->id_comuna 	= 	$row['localizacion'];
            $Registro->nomcomuna 	= 	$row['barrio'];
            $Registro->nomcomunad 	= 	$row['localidad']; 
            $List->addlast($Registro);
        }
		//general::writeevent($query);
        $res->free();
        return true;
    }
    
    public function getcomunad($List) {
    	$query = "	SELECT 	id_comuna as id_comunad, 
                            descripcion as nomcomunad
                    FROM 	comunad
                    WHERE 1		
                    " . (($List->getelem()->id_comunad)? "and id_comuna = ".$List->getelem()->id_comunad :"" ) . "
                    order by descripcion";
        $res = $this->bd->query($query);
        
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtocomuna;
            $Registro->id_comunad	= 	$row['id_comunad'];
            $Registro->nomcomunad 	= 	$row['nomcomunad'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }	
	public function getregion($List) {
    	$List->gofirst();
        $query = "	SELECT 	re.id_region, 
							re.descripcion as nomregion 
                    FROM 	region re
                   WHERE 	1
					".(($List->getelem()->id_region)?"and re.id_region =".$List->getelem()->id_region :"") . "
                    " ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtocomuna;
            $Registro->id_region 	= 	$row['id_region'];
            $Registro->nomregion 	= 	$row['nomregion'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
    public function setregion($List){
    	$List->gofirst();
        $query = "	INSERT INTO region (	
                       
                        descripcion, 
                        usrcrea, 
                        feccrea,
                        usrmod,
                        fecmod 
                    )
                    VALUES (
                        	
                            '".$List->getelem()->nomregion."',
                            '".$List->getelem()->usrcrea."',
                            now(),
                            '".$List->getelem()->usrmod."',
                            now()
                           )";
         $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        return true;
    }
        public function setciudad($List){
    	$List->gofirst();
        $query = "	INSERT INTO ciudad (	
                        
                        descripcion, 
                        usrcrea, 
                        feccrea, 
                        usrmod, 
                        fecmod 
                    )
                    VALUES (
                        	
                            '".$List->getelem()->nomciudad."',
                            '".$List->getelem()->usrcrea."',
                            now(),
                            '".$List->getelem()->usrmod."',
                            now()
                           )";
             
         $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        return true;
    }
    
    public function setcomuna($List){
    	$List->gofirst();
        $query = "	INSERT INTO comuna (	
                       
                        id_ciudad, 
                        id_region, 
                        descripcion, 
                        usrcrea, 
                        feccrea,
                        usrmod,
                        fecmod 
                    )
                    VALUES (
                        	
                            '".$List->getelem()->id_ciudad."',
                            '".$List->getelem()->id_region."',
                            '".$List->getelem()->nomcomuna."',
                            '".$List->getelem()->usrcrea."',
                            now(),
                            '".$List->getelem()->usrmod."',
                            now()
                           )";
         $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        return true;
    }
    
    public function getglobals($List) {
        $query = "	SELECT	var_llave, 
                            var_valor 
                    FROM	glo_variables" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->nombre 	= 	$row['var_llave'];
            $Registro->valor 	= 	$row['var_valor'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

	public function getcambiosestado($List) {
		$List->gofirst();
        $query = "	SELECT distinct ce.id_estado_origen, 
                           ce.id_estado_destino, 
                           ce.tipo, 
                           ce.descripcion as nomaccion,
                           estadoterminal
                    FROM cambiosestado ce
                    join cotizacion_e co on co.id_estado=ce.id_estado_origen
                    join estado e on e.id_estado = ce.id_estado_destino 
                    WHERE 	1 
                    " . (($List->getelem()->tipo)? " and ce.tipo = '".$List->getelem()->tipo."' " : "") . "
                    " . (($List->getelem()->id_estado_origen)? " and ce.id_estado_origen = '".$List->getelem()->id_estado_origen."' " : "") . "
                    " . (($List->getelem()->id_cotizacion )? " and co.id_cotizacion  = '".$List->getelem()->id_cotizacion."' " : "") . "
                    ";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtocambiosestado;
            $Registro->id_estado_origen	 = 	$row['id_estado_origen'];
            $Registro->id_estado_destino = 	$row['id_estado_destino'];	
            $Registro->tipo				 = 	$row['tipo'];	
            $Registro->nomaccion		 = 	$row['nomaccion'];	
            $Registro->estadoterminal	 = 	$row['estadoterminal'];						
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function gettipoconpago($List) {
        $query = " SELECT 	id_tipoconpago, descripcion as nombre 
                    FROM 	tipocondicionpago
					ORDER BY 1" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id_tipoconpago'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
    public function getgiro($List) {
        $query = "	SELECT 	id_giro as id,
                    upper(descripcion) as nombre
                    FROM 	tipogiro
                    WHERE 1 " . (($List->getelem()->id)? " and id_giro = '".$List->getelem()->id."' " : "") . "order by nombre		
                 ";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
   public function setgiro($List){
    	$List->gofirst();
        $query = "	INSERT INTO giro (	
                       
                        descripcion, 
                        usrcrea, 
                        feccrea,
                        usrmod,
                        fecmod 
                    )
                    VALUES (
                        	
                            '".$List->getelem()->nombre."',
                            '".$List->getelem()->usrcrea."',
                            now(),
                            '".$List->getelem()->usrmod."',
                            now()
                           )";
         $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        return true;
    } 

    public function gettipopagoid($List) {
		$List->gofirst();
    	$query = " SELECT 	id_tipopago as id, 
                            descripcion as nombre 
                    FROM 	tipopago
                    WHERE 	1 
                    " . (($List->getelem()->id_tipopago)? " and id_tipopago = '".$List->getelem()->id_tipopago."' " : "") . "
                    ";
		
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }    

        public function getconpago($List) {
        $query = " SELECT 	id_tipoconpago as id, 
                            descripcion as nombre 
                    FROM 	tipocondicionpago
                    WHERE 	1 
                    " . (($List->getelem()->id_tipoconpago)? " and id_tipoconpago = '".$List->getelem()->id_tipoconpago."' " : "") . "
                    ";

        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }   


        public function getdocpago($List) {
		$List->gofirst();        	
        $query = " SELECT 	id_tipodocpago as id, 
                            descripcion as nombre 
                    FROM 	tipodocpago
                    WHERE 	1 
                    " . (($List->getelem()->id_tipodocpago)? " and id_tipodocpago = '".$List->getelem()->id_tipodocpago."' " : "") . "
                    ";

        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
        public function getconpagoaprox($List) {
		$List->gofirst();		
        $query = " SELECT 	min(id_tipoconpago) as id, 
                            descripcion as nombre 
                    FROM 	tipocondicionpago
                    WHERE 	1 
                    " . (($List->getelem()->id_tipoconpago)? " and id_tipoconpago >= '".$List->getelem()->id_tipoconpago."' " : "") . "
                    GROUP BY id_tipoconpago ORDER BY id_tipoconpago";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }    
    public function getclientepreferente($List) {
    	$query = "	SELECT 	DISTINCT cp.id_clientepref as  id,cp.nombre_pref as nombre
                    FROM 	cliente_preferente cp
					JOIN    cliente c on (c.id_tipocliente=cp.id_tipocliente)
                    WHERE 1		
                    " . (($List->getelem()->id_tipocliente)? "and c.id_tipocliente = ".$List->getelem()->id_tipocliente :"" ) . "
                    " . (($List->getelem()->id_clientepref)? "and cp.id_clientepref = ".$List->getelem()->id_clientepref :"" ) . "
                    ";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id_clientepref  = 	$row['id'];
            $Registro->nombre_pref 	   = 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
    public function getgrupo($List) {
        $query = "	SELECT 	id_grupo as id, 
                            nomgrupo as nombre 
                    FROM 	grupotcp 
                    WHERE 1 
                    " . (($List->getelem()->rutcliente)? " and rutcliente = ".$List->getelem()->rutcliente : "") . "
					";
        //general::writelog($query);
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->id 		= 	$row['id'];
            $Registro->nombre 	= 	$row['nombre'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function gettcp($List) {
        $query = " SELECT tcp_rut, tcp_grupo
				   FROM tcp
				   WHERE 1
                    " . (($List->getelem()->rut)? " and tcp_rut = ".$List->getelem()->rut : "") . "
					";
       // general::writeevent($query);
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtotipo;
            $Registro->rut 		= 	$row['tcp_rut'];
            $Registro->tcp_id= 	$row['tcp_grupo'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

	public function getdescuento($List){
			$List->gofirst();
		$query = " SELECT 	descuento as descuento, 
                            tipo_valor as tipo_valor 
                    FROM 	promo_cve
                    WHERE 	1 
                    " . (($List->getelem()->subrubro)? " and subrubro = ".$List->getelem()->subrubro : "") . "
                    " . (($List->getelem()->local)? " and cod_local = '".$List->getelem()->local."' ": "") . "
                    " . (($List->getelem()->tcp_grupo)? " and tcp_grupo = ".$List->getelem()->tcp_grupo : "") . "
					";

		//general::writeevent($query);
		$res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodescuento;
           	$Registro->descuento	= 	$row['descuento'];
			$Registro->tipo_valor	= 	$row['tipo_valor'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
	}

    
}
?>
