<?
class daoordenent{
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


	// Campos Auxiliares
	public function getencordenentan($List) {
		$List->gofirst();
        $query = "	SELECT c.id_ordenent   
                    FROM   ordenent_e c " .
					" WHERE  id_estado IN ('OB','OM','OA') " .
					(($List->getelem()->verif_anul_tiempo!==null)? " and TIMESTAMPDIFF(HOUR,c.feccrea,NOW()) >= 48 " : "") . 
				"   ORDER BY c.id_ordenent DESC ";
        $total_orden = $List->getelem()->limite;
		$res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);         
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoencordenent;
            $Registro->id_ordenent = $row['id_ordenent'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
	// Campos Auxiliares

    public function getencordenent($List) {
		$List->gofirst();
        $query = "	SELECT distinct c.id_ordenent, c.id_cotizacion,c.id_estado,
                            e.descripcion as nomestadorent,
                            e.tipo, id_tipopago,
                            id_tipodocpago, te.id_tipoentrega,
							te.descripcion as nomtipoentrega, id_direccion,
							c.id_tipoflujo, tf.nomtflujo as nomtipoflujo, c.codigovendedor,
                            c.rutcliente,
                            c.rutvendedor,
                            c.codlocalventa,
                            c.codlocalcsum, c.razonsoc,
                            c.giro, c.id_giro,c.fechacompra,
                            c.direccion, c.comuna,
                            c.iva, c.condicion,
                            c.diascondicion, c.fonocontacto,
                            c.observaciones, c.nota,
                            c.id_usuario, c.numdocpago,
                            c.obsdesb,c.usrcrea, c.fonocontacto as telefono,
                            c.feccrea, c.indmsgsap,   l.nom_local nom_localcsum,
                            c.fecha_retira_cliente, c.fecha_retira_inmediato, c.fecha_despacho_programado,
                            c.zona,
                            c.rete_iva_oe,
                            c.totaloe,
                            l2.nom_local nom_localventa,
                            f.nvevaliddesde as validdesde, f.nvevalidhasta as validhasta, f.feccrea as feccreacoti,  
                            f.rete_ica, f.rete_iva, f.rete_renta, f.cot_iva, f.valortotal, ci.descripcion ciudad       
                            FROM ordenent_e c
					JOIN 	estado e on c.id_estado=e.id_estado
					LEFT JOIN 	tipoentrega te on te.id_tipoentrega = c.id_tipoentrega
					LEFT JOIN 	cotizacion_e f on c.id_cotizacion = f.id_cotizacion and c.rutcliente = f.rutcliente
					LEFT JOIN 	tipoflujo tf on tf.id_tipoflujo = c.id_tipoflujo
					LEFT JOIN 	locales l on l.cod_local= c.codlocalcsum
					LEFT JOIN 	locales l2 on l2.cod_local= c.codlocalventa 
					LEFT JOIN 	comuna co on co.descripcion = c.comuna
					LEFT JOIN ciudad ci on ci.id_ciudad = co.id_ciudad  
                    WHERE 	1 
                    " . (($List->getelem()->id_ordenent)? " and c.id_ordenent = ".$List->getelem()->id_ordenent." " : "") . "
                    " . (($List->getelem()->id_cotizacion)? " and c.id_cotizacion = ".$List->getelem()->id_cotizacion." " : "") . "
                    " . (($List->getelem()->id_tipoentrega)? " and te.id_tipoentrega = ".$List->getelem()->id_tipoentrega." " : "") . "
                    " . (($List->getelem()->id_tipopago)? " and id_tipopago = ".$List->getelem()->id_tipopago." " : "") . "
                    " . (($List->getelem()->id_tipoflujo)? " and tf.id_tipoflujo in (".$List->getelem()->id_tipoflujo.")" : "") . "
                    " . (($List->getelem()->id_direccion)? " and c.id_direccion = ".$List->getelem()->id_direccion."" : "") . "
                    " . (($List->getelem()->rutcliente)? " and c.rutcliente = ".$List->getelem()->rutcliente." " : "") . "
                    " . (($List->getelem()->razonsoc)? " and c.razonsoc like '%".addslashes($List->getelem()->razonsoc)."%'" : "") . "
                    " . (($List->getelem()->fechaucofini)? " and c.feccrea >= '".$List->getelem()->fechaucofini."'" : "") . "
                    " . (($List->getelem()->fechaucoffin)? " and c.feccrea <= '".$List->getelem()->fechaucoffin."'" : "") . "
					" . (($List->getelem()->codlocalcsum)? " and c.codlocalcsum = '".$List->getelem()->codlocalcsum."' " : "") . "
                    " . (($List->getelem()->codlocalventa)? " and c.codlocalventa = '".$List->getelem()->codlocalventa."' " : "") ."
					" . (($List->getelem()->id_estado)? " and c.id_estado = '".$List->getelem()->id_estado."' " : "") . "
                    " . (($List->getelem()->indmsgsap!==null)? " and c.indmsgsap = ".$List->getelem()->indmsgsap." " : "") . "
                    " . (($List->getelem()->verif_anul_tiempo!==null)? " and TIMESTAMPDIFF(HOUR,c.feccrea,NOW()) >= 48 " : "") . "                  ORDER BY c.id_ordenent DESC "
                    .(($List->getelem()->limite)?  " LIMIT ".$List->getelem()->limite : "")."";
               $total_orden            =       $List->getelem()->limite;
		//general::writeevent($query);
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);         
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoencordenent;
            $Registro->id_ordenent		= 	$row['id_ordenent'];
            $Registro->id_cotizacion	= 	$row['id_cotizacion'];
            $Registro->id_estado		= 	$row['id_estado'];
            $Registro->nomestadorent	= 	$row['nomestadorent'];	
            $Registro->tipo				= 	$row['tipo'];								
            $Registro->id_tipopago		= 	$row['id_tipopago'];
            $Registro->id_tipodocpago	= 	$row['id_tipodocpago'];
            $Registro->id_tipoentrega	= 	$row['id_tipoentrega'];
            $Registro->nomtipoentrega	= 	$row['nomtipoentrega'];
            $Registro->id_direccion		= 	$row['id_direccion'];
            $Registro->id_tipoflujo		= 	$row['id_tipoflujo'];
            $Registro->nomtipoflujo		= 	$row['nomtipoflujo'];
            $Registro->codigovendedor	= 	$row['codigovendedor'];
            $Registro->rutcliente		= 	$row['rutcliente'];
            $Registro->rutvendedor		= 	$row['rutvendedor'];
            $Registro->codlocalventa	= 	$row['codlocalventa'];
            $Registro->codlocalcsum		= 	$row['codlocalcsum'];
            $Registro->nom_localcsum	= 	$row['nom_localcsum'];	
            $Registro->nom_localventa	= 	$row['nom_localventa'];	
            $Registro->razonsoc			= 	$row['razonsoc'];
            $Registro->giro				= 	$row['giro'];
            $Registro->id_giro			= 	$row['id_giro'];
            $Registro->direccion		= 	$row['direccion'];
            $Registro->comuna			= 	$row['comuna'];
            $Registro->ciudad           =   $row['ciudad'];
            $Registro->iva				= 	$row['iva'];
            $Registro->condicion		= 	$row['condicion'];
            $Registro->diascondicion	= 	$row['diascondicion'];
            $Registro->fonocontacto		= 	$row['fonocontacto'];
            $Registro->observaciones	= 	$row['observaciones'];
            $Registro->nota				= 	$row['nota'];
            $Registro->id_usuario		= 	$row['id_usuario'];		
            $Registro->numdocpago		= 	$row['numdocpago'];
            $Registro->obsdesb		    = 	$row['obsdesb'];	
            $Registro->usrcrea		    = 	$row['usrcrea'];					
            $Registro->feccrea		    = 	$row['feccrea'];				
            $Registro->indmsgsap		= 	$row['indmsgsap'];
            $Registro->validdesde		= 	$row['validdesde'];
            $Registro->validhasta		= 	$row['validhasta'];
            $Registro->feccreacoti      =	$row['feccreacoti'];
            $Registro->telefono         =	$row['telefono'];
            $Registro->rete_ica		    = 	$row['rete_ica'];
            $Registro->rete_renta		= 	$row['rete_renta'];
            $Registro->rete_iva		    = 	$row['rete_iva'];	
            $Registro->cot_iva		    = 	$row['cot_iva'];
            $Registro->valortotal	    = 	$row['valortotal'];
            $Registro->fechacompra	    = 	$row['fechacompra'];
            $Registro->zona     	    = 	$row['zona'];
            $Registro->fecha_retira_cliente	    = 	$row['fecha_retira_cliente'];
            $Registro->fecha_retira_inmediato	    = 	$row['fecha_retira_inmediato'];
            $Registro->fecha_despacho_programado	    = 	$row['fecha_despacho_programado'];				
			if (($row['id_estado']=='OB') || ($row['id_estado']=='OM')) {
				$Registro->puedever		= 	false;
			} else {
				$Registro->puedever		= 	true;
			}
            $Registro->total_orden		=	$total_orden;
            $Registro->rete_iva_oe	    = 	$row['rete_iva_oe'];
            $Registro->totaloe	    = 	$row['totaloe'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
    /*Insertar Cod EAN*/
    public function putean($cod_barra_os, $cod_ordenente){
    	
    	$query = "UPDATE ordenent_e
    	          SET cod_ean = ".$cod_barra_os."
    	          WHERE id_ordenent = ".$cod_ordenente."";
    	          
    	$res = $this->bd->query($query);
        
    	if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);         
        
        return true;
    }
    /*Fin Insertar Cod EAN*/
    
    public function getinfoop($List, $opcion){
    	
    	$query = "SELECT VAR_GLO_ID,VAR_DESCRIPCION as var_descripcion FROM glo_variables g WHERE VAR_ID = ".$opcion."";
    	
    	$res = $this->bd->query($query);
        
    	if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);         
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoencordenent;
            $Registro->var_descripcion	=	$row['var_descripcion'];
            $Registro->tipo_mensaje		=	$row['VAR_GLO_ID'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
	public function updatemensajeglo($List, $opcion ,$contenido){
    	
    	$query = "update glo_variables set VAR_DESCRIPCION ='$contenido' WHERE VAR_ID = ".$opcion."";
    	
    	$res = $this->bd->query($query);
        
    	if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);         
        $List->clearlist();
        return true;
    }
    
   public function getMonitorordenent($List) {
		$List->gofirst();
        $query = "	SELECT  
							id_ordenent,
                            id_cotizacion,
                            oe.id_estado,
                            e.descripcion as nomestadorent,
                            e.tipo,
                            numdocpago,
                            id_tipodocpago, 
                            te.id_tipoentrega, 
							te.descripcion as nomtipoentrega,
							oe.id_tipoflujo,
							tf.nomtflujo as nomtipoflujo,
                            rutcliente,
                            oe.feccrea, 
                            codlocalcsum, 
                            l.nom_local nom_localcsum,
							l2.nom_local nom_localventa,
                            razonsoc 
                    FROM 	ordenent_e oe
                    JOIN 	estado e on oe.id_estado=e.id_estado
                    LEFT JOIN 	locales l on l.cod_local=oe.codlocalcsum
					LEFT JOIN 	locales l2 on l2.cod_local=oe.codlocalventa
					LEFT JOIN 	tipoentrega te on te.id_tipoentrega = oe.id_tipoentrega 
					LEFT JOIN 	tipoflujo tf on tf.id_tipoflujo = oe.id_tipoflujo 
                    WHERE 	1 


                    " . (($List->getelem()->id_ordenent)? " and id_ordenent = ".$List->getelem()->id_ordenent." " : "") . "
                    " . (($List->getelem()->id_cotizacion)? " and id_cotizacion = ".$List->getelem()->id_cotizacion." " : "") . "
                    " . (($List->getelem()->id_tipoentrega)? " and te.id_tipoentrega = ".$List->getelem()->id_tipoentrega." " : "") . "
                    " . (($List->getelem()->id_tipopago)? " and oe.id_tipopago = ".$List->getelem()->id_tipopago." " : "") . "
                    " . (($List->getelem()->fechaucofini)? " and oe.feccrea >= '".$List->getelem()->fechaucofini."'" : "") . "
                    " . (($List->getelem()->fechaucoffin)? " and oe.feccrea <= '".$List->getelem()->fechaucoffin."'" : "") . "
                    " . (($List->getelem()->id_tipoflujo)? " and tf.id_tipoflujo in (".$List->getelem()->id_tipoflujo.")" : "") . "
                    " . (($List->getelem()->rutcliente)? " and rutcliente = ".$List->getelem()->rutcliente." " : "") . "
                    " . (($List->getelem()->razonsoc)? " and razonsoc like '%".addslashes($List->getelem()->razonsoc)."%'" : "") . "
					" . (($List->getelem()->codlocalventa)? " and codlocalventa = '".$List->getelem()->codlocalventa."' " : "") . "
					" . (($List->getelem()->codlocalcsum)? " and codlocalcsum = '".$List->getelem()->codlocalcsum."' " : "") . "
					" . (($List->getelem()->id_estado)? " and oe.id_estado IN ('".$List->getelem()->id_estado."') " : "") . "
                    ORDER BY id_ordenent DESC "
                    .(($List->getelem()->limite)?  " LIMIT ".$List->getelem()->limite : "")."";
        
        $total_orden            =       $List->getelem()->limite;

        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);         
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoencordenent;
            $Registro->id_ordenent		= 	$row['id_ordenent'];
            $Registro->id_cotizacion	= 	$row['id_cotizacion'];
            $Registro->id_estado		= 	$row['id_estado'];
            $Registro->nomestadorent	= 	$row['nomestadorent'];	
            $Registro->tipo				= 	$row['tipo'];								
            $Registro->id_tipopago		= 	$row['id_tipopago'];
            $Registro->id_tipodocpago	= 	$row['id_tipodocpago'];
            $Registro->id_tipoentrega	= 	$row['id_tipoentrega'];
            $Registro->nomtipoentrega	= 	$row['nomtipoentrega'];
            $Registro->id_direccion		= 	$row['id_direccion'];
            $Registro->id_tipoflujo		= 	$row['id_tipoflujo'];
            $Registro->nomtipoflujo		= 	$row['nomtipoflujo'];
            $Registro->codigovendedor	= 	$row['codigovendedor'];
            $Registro->rutcliente		= 	$row['rutcliente'];
            $Registro->numdocpago		= 	$row['numdocpago'];
            $Registro->codlocalcsum		= 	$row['codlocalcsum'];
			$Registro->nom_localventa	= 	$row['nom_localventa'];
            $Registro->nom_localcsum	= 	$row['nom_localcsum'];	
            $Registro->razonsoc			= 	$row['razonsoc'];
            $Registro->feccrea		    = 	$row['feccrea'];	
			if (($row['id_estado']=='OB') || ($row['id_estado']=='OM')) {
				$Registro->puedever		= 	false;
			} else {
				$Registro->puedever		= 	true;
			}
            $Registro->total_orden		=	$total_orden;
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
	public function reportecompraspendientes($List) {
		$List->gofirst();
        $query = "	SELECT  codlocalcsum,
                            l.nom_local nom_localcsum,
							id_ordenent,
                            id_cotizacion,
                            razonsoc,
                            oe.fonocontacto,
                            oe.id_direccion,
                            oe.fechacompra,
                            oe.totaloe,
                            oe.id_estado,
                            rutcliente,
                            fecha_retira_cliente,
                            fecha_retira_inmediato,
                            fecha_despacho_programado,
                            oe.id_estado
                    FROM 	ordenent_e oe
                    JOIN    arreglos_florales flo on  id_os=id_cotizacion
                    JOIN 	estado e on oe.id_estado=e.id_estado
                    LEFT JOIN 	locales l on l.cod_local=oe.codlocalcsum
					LEFT JOIN 	tipoentrega te on te.id_tipoentrega = oe.id_tipoentrega
					LEFT JOIN 	tipoflujo tf on tf.id_tipoflujo = oe.id_tipoflujo
                    WHERE 	1
           " . (($List->getelem()->fechaucofini)? "and oe.fechacompra>='".$List->getelem()->fechaucofini."' " : "") . "
           " . (($List->getelem()->fechaucoffin)? "and oe.fechacompra<='".$List->getelem()->fechaucoffin."' " : "") . "
           " . (($List->getelem()->codlocalcsum)? "and codlocalcsum = '".$List->getelem()->codlocalcsum."' " : "") . "
           " . (($List->getelem()->id_estado)? "and oe.id_estado in ('".$List->getelem()->id_estado."') " : "and oe.id_estado in ('OG','OF')") . "";
          

        $res = $this->bd->query($query);
        //general::writeevent('para el reporte arreglos florales'.$query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);         
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoencordenent;
            $Registro->id_estado		= 	$row['id_estado'];
            $Registro->rutcliente		= 	$row['rutcliente'];
            $Registro->codlocalcsum		= 	$row['codlocalcsum'];
            $Registro->nom_local		= 	$row['nom_localcsum'];
            $Registro->id_ordenent		= 	$row['id_ordenent'];
            $Registro->id_cotizacion	= 	$row['id_cotizacion'];
            $Registro->razonsoc			= 	$row['razonsoc'];	
            $Registro->fonocontacto		= 	$row['fonocontacto'];								
            $Registro->id_direccion		= 	$row['id_direccion'];
            $Registro->fechacompra		= 	$row['fechacompra'];
            $Registro->valortotal		= 	$row['totaloe'];
            $Registro->id_estado		= 	$row['id_estado'];
            $Registro->fecha_retira_cliente		= 	$row['fecha_retira_cliente'];
            $Registro->fecha_retira_inmediato	= 	$row['fecha_retira_inmediato'];
            $Registro->fecha_despacho_programado= 	$row['fecha_despacho_programado'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
	public function reportecompraspendientespe($List) {
		$List->gofirst();
        $query = "	SELECT  codlocalcsum,
                            l.nom_local nom_localcsum,
							id_ordenent,
                            id_cotizacion,
                            razonsoc,
                            oe.fonocontacto,
                            oe.id_direccion,
                            oe.fechacompra,
                            oe.totaloe,
                            oe.id_estado,
                            rutcliente,
                            fecha_retira_cliente,
                            fecha_retira_inmediato,
                            fecha_despacho_programado,
                            oe.id_estado
                    FROM 	ordenent_e oe
                    JOIN 	estado e on oe.id_estado=e.id_estado
                    LEFT JOIN 	locales l on l.cod_local=oe.codlocalcsum
					LEFT JOIN 	tipoentrega te on te.id_tipoentrega = oe.id_tipoentrega
					LEFT JOIN 	tipoflujo tf on tf.id_tipoflujo = oe.id_tipoflujo
                    WHERE 	id_cotizacion not in (SELECT id_os FROM arreglos_florales)
           " . (($List->getelem()->fechaucofini)? "and oe.fechacompra>='".$List->getelem()->fechaucofini."' " : "") . "
           " . (($List->getelem()->fechaucoffin)? "and oe.fechacompra<='".$List->getelem()->fechaucoffin."' " : "") . "
           " . (($List->getelem()->codlocalcsum)? "and codlocalcsum = '".$List->getelem()->codlocalcsum."' " : "") . "
           " . (($List->getelem()->id_estado)? "and oe.id_estado in ('".$List->getelem()->id_estado."') " : "and oe.id_estado in ('OG','OF')") . "";
          

        $res = $this->bd->query($query);
  
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);         
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoencordenent;
            $Registro->id_estado		= 	$row['id_estado'];
            $Registro->rutcliente		= 	$row['rutcliente'];
            $Registro->codlocalcsum		= 	$row['codlocalcsum'];
            $Registro->nom_local		= 	$row['nom_localcsum'];
            $Registro->id_ordenent		= 	$row['id_ordenent'];
            $Registro->id_cotizacion	= 	$row['id_cotizacion'];
            $Registro->razonsoc			= 	$row['razonsoc'];	
            $Registro->fonocontacto		= 	$row['fonocontacto'];								
            $Registro->id_direccion		= 	$row['id_direccion'];
            $Registro->fechacompra		= 	$row['fechacompra'];
            $Registro->valortotal		= 	$row['totaloe'];
            $Registro->id_estado		= 	$row['id_estado'];
            $Registro->fecha_retira_cliente		= 	$row['fecha_retira_cliente'];
            $Registro->fecha_retira_inmediato	= 	$row['fecha_retira_inmediato'];
            $Registro->fecha_despacho_programado= 	$row['fecha_despacho_programado'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
  	public function getFlujo($List) {
		$List->gofirst();
        $query = "	SELECT  
							tf.id_tipoflujo,
							tf.nomtflujo as nomtipoflujo
                    FROM 	tipoflujo tf
                    WHERE 	1 
                    " . (($List->getelem()->id_tipoflujo)? " and tf.id_tipoflujo in (".$List->getelem()->id_tipoflujo.")" : "") . "
                    ORDER BY tf.id_tipoflujo DESC "
                    .(($List->getelem()->limite)?  " LIMIT ".$List->getelem()->limite : "")."";
        
        $total_orden            =       $List->getelem()->limite;

        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);         
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoencordenent;
            $Registro->id_tipoflujo		= 	$row['id_tipoflujo'];
            $Registro->nomtipoflujo		= 	$row['nomtipoflujo'];
            $Registro->total_orden		=	$total_orden;
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function getencordenentsap($List) {
		$List->gofirst();
        $query = "	SELECT  distinct 
							id_ordenent,
							id_cotizacion,
							oe.id_estado,
							e.descripcion as nomestadorent,
							e.tipo,
							id_tipopago,
							id_tipodocpago,
							te.id_tipoentrega,
							te.descripcion as nomtipoentrega,
							id_direccion,
							oe.id_tipoflujo,
							tf.nomtflujo as nomtipoflujo,
							oe.codigovendedor,
							oe.rutcliente,
							rutvendedor,
							oe.codlocalventa,
							oe.codlocalcsum,
							l.nom_local nom_localcsum,
							l2.nom_local nom_localventa,
							oe.razonsoc,
							oe.giro,
							oe.id_giro,
							oe.direccion,
							oe.comuna,
							oe.iva,
							oe.condicion,
							oe.diascondicion,
							oe.fonocontacto,
							oe.observaciones,
							oe.nota,
							id_usuario,
							numdocpago,
							obsdesb,
							oe.usrcrea,
							oe.feccrea,
							oe.indmsgsap
                    FROM 	ordenent_e oe
                    JOIN 	estado e on oe.id_estado=e.id_estado
                    LEFT JOIN 	locales l on l.cod_local=oe.codlocalcsum
                    LEFT JOIN 	locales l2 on l2.cod_local=oe.codlocalventa
					LEFT JOIN 	tipoentrega te on te.id_tipoentrega = oe.id_tipoentrega 
					LEFT JOIN 	tipoflujo tf on tf.id_tipoflujo = oe.id_tipoflujo 
					JOIN 		documento_e de on de.numorigen = oe.id_ordenent and (de.indmsgsap = 0 or oe.indmsgsap = 0)
                    WHERE 	1 
                    " . (($List->getelem()->id_ordenent)? " and id_ordenent = ".$List->getelem()->id_ordenent." " : "") . "
                    " . (($List->getelem()->id_cotizacion)? " and id_cotizacion = ".$List->getelem()->id_cotizacion." " : "") . "
                    " . (($List->getelem()->id_tipoentrega)? " and te.id_tipoentrega = ".$List->getelem()->id_tipoentrega." " : "") . "
                    " . (($List->getelem()->id_tipoflujo)? " and tf.id_tipoflujo in (".$List->getelem()->id_tipoflujo.")" : "") . "
                    " . (($List->getelem()->id_direccion)? " and oe.id_direccion = ".$List->getelem()->id_direccion."" : "") . "
                    " . (($List->getelem()->rutcliente)? " and rutcliente = ".$List->getelem()->rutcliente." " : "") . "
                    " . (($List->getelem()->razonsoc)? " and razonsoc like '%".addslashes($List->getelem()->razonsoc)."%'" : "") . "
                    " . (($List->getelem()->fechaucofini)? " and oe.feccrea >= '".$List->getelem()->fechaucofini."'" : "") . "
                    " . (($List->getelem()->fechaucoffin)? " and oe.feccrea <= '".$List->getelem()->fechaucoffin."'" : "") . "
					" . (($List->getelem()->codlocalcsum)? " and codlocalcsum = '".$List->getelem()->codlocalcsum."' " : "") . "
                    " . (($List->getelem()->codlocalventa)? " and codlocalventa = '".$List->getelem()->codlocalventa."' " : "") ."
					" . (($List->getelem()->id_estado)? " and oe.id_estado = '".$List->getelem()->id_estado."' " : "") . "
                    ORDER BY id_ordenent ASC ";
        //general::writelog($query);
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoencordenent;
            $Registro->id_ordenent		= 	$row['id_ordenent'];
            $Registro->id_cotizacion	= 	$row['id_cotizacion'];
            $Registro->id_estado		= 	$row['id_estado'];
            $Registro->nomestadorent	= 	$row['nomestadorent'];	
            $Registro->tipo				= 	$row['tipo'];								
            $Registro->id_tipopago		= 	$row['id_tipopago'];
            $Registro->id_tipodocpago	= 	$row['id_tipodocpago'];
            $Registro->id_tipoentrega	= 	$row['id_tipoentrega'];
            $Registro->nomtipoentrega	= 	$row['nomtipoentrega'];
            $Registro->id_direccion		= 	$row['id_direccion'];
            $Registro->id_tipoflujo		= 	$row['id_tipoflujo'];
            $Registro->nomtipoflujo		= 	$row['nomtipoflujo'];
            $Registro->codigovendedor	= 	$row['codigovendedor'];
            $Registro->rutcliente		= 	$row['rutcliente'];
            $Registro->rutvendedor		= 	$row['rutvendedor'];
            $Registro->codlocalventa	= 	$row['codlocalventa'];
            $Registro->codlocalcsum		= 	$row['codlocalcsum'];
            $Registro->nom_localcsum	= 	$row['nom_localcsum'];	
            $Registro->nom_localventa	= 	$row['nom_localventa'];	
            $Registro->razonsoc			= 	$row['razonsoc'];
            $Registro->giro				= 	$row['giro'];
            $Registro->id_giro			= 	$row['id_giro'];
            $Registro->direccion		= 	$row['direccion'];
            $Registro->comuna			= 	$row['comuna'];
            $Registro->iva				= 	$row['iva'];
            $Registro->condicion		= 	$row['condicion'];
            $Registro->diascondicion	= 	$row['diascondicion'];
            $Registro->fonocontacto		= 	$row['fonocontacto'];
            $Registro->observaciones	= 	$row['observaciones'];
            $Registro->nota				= 	$row['nota'];
            $Registro->id_usuario		= 	$row['id_usuario'];		
            $Registro->numdocpago		= 	$row['numdocpago'];
            $Registro->obsdesb		    = 	$row['obsdesb'];	
            $Registro->usrcrea		    = 	$row['usrcrea'];					
            $Registro->feccrea		    = 	$row['feccrea'];				
            $Registro->indmsgsap		= 	$row['indmsgsap'];				
			if (($row['id_estado']=='OB') || ($row['id_estado']=='OM')) {
				$Registro->puedever		= 	false;
			} else {
				$Registro->puedever		= 	true;
			}
            $Registro->total_orden		=	$row1['cont'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
 	public function getencordenentsapflujo5($List) {
		$List->gofirst();
        $query = "	SELECT  distinct 
							id_ordenent,
							id_cotizacion,
							oe.id_estado,
							e.descripcion as nomestadorent,
							e.tipo,
							id_tipopago,
							id_tipodocpago,
							te.id_tipoentrega,
							te.descripcion as nomtipoentrega,
							id_direccion,
							oe.id_tipoflujo,
							tf.nomtflujo as nomtipoflujo,
							oe.codigovendedor,
							oe.rutcliente,
							rutvendedor,
							oe.codlocalventa,
							oe.codlocalcsum,
							l.nom_local nom_localcsum,
							l2.nom_local nom_localventa,
							oe.razonsoc,
							oe.giro,
							oe.id_giro,
							oe.direccion,
							oe.comuna,
							oe.iva,
							oe.condicion,
							oe.diascondicion,
							oe.fonocontacto,
							oe.observaciones,
							oe.nota,
							id_usuario,
							numdocpago,
							obsdesb,
							oe.usrcrea,
							oe.feccrea,
							oe.indmsgsap
                    FROM 	ordenent_e oe
                    JOIN 	estado e on oe.id_estado=e.id_estado
                    LEFT JOIN 	locales l on l.cod_local=oe.codlocalcsum
                    LEFT JOIN 	locales l2 on l2.cod_local=oe.codlocalventa
					LEFT JOIN 	tipoentrega te on te.id_tipoentrega = oe.id_tipoentrega 
					LEFT JOIN 	tipoflujo tf on tf.id_tipoflujo = oe.id_tipoflujo 
					 
                    WHERE 	1 and oe.indmsgsap = 0
                    " . (($List->getelem()->id_ordenent)? " and id_ordenent = ".$List->getelem()->id_ordenent." " : "") . "
                    " . (($List->getelem()->id_cotizacion)? " and id_cotizacion = ".$List->getelem()->id_cotizacion." " : "") . "
                    " . (($List->getelem()->id_tipoentrega)? " and te.id_tipoentrega = ".$List->getelem()->id_tipoentrega." " : "") . "
                    " . (($List->getelem()->id_tipoflujo)? " and tf.id_tipoflujo in (".$List->getelem()->id_tipoflujo.")" : "") . "
                    " . (($List->getelem()->id_direccion)? " and oe.id_direccion = ".$List->getelem()->id_direccion."" : "") . "
                    " . (($List->getelem()->rutcliente)? " and rutcliente = ".$List->getelem()->rutcliente." " : "") . "
                    " . (($List->getelem()->razonsoc)? " and razonsoc like '%".addslashes($List->getelem()->razonsoc)."%'" : "") . "
                    " . (($List->getelem()->fechaucofini)? " and oe.feccrea >= '".$List->getelem()->fechaucofini."'" : "") . "
                    " . (($List->getelem()->fechaucoffin)? " and oe.feccrea <= '".$List->getelem()->fechaucoffin."'" : "") . "
					" . (($List->getelem()->codlocalcsum)? " and codlocalcsum = '".$List->getelem()->codlocalcsum."' " : "") . "
                    " . (($List->getelem()->codlocalventa)? " and codlocalventa = '".$List->getelem()->codlocalventa."' " : "") ."
					" . (($List->getelem()->id_estado)? " and oe.id_estado = '".$List->getelem()->id_estado."' " : "") . "
                    ORDER BY id_ordenent ASC ";
        //general::writelog($query);
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoencordenent;
            $Registro->id_ordenent		= 	$row['id_ordenent'];
            $Registro->id_cotizacion	= 	$row['id_cotizacion'];
            $Registro->id_estado		= 	$row['id_estado'];
            $Registro->nomestadorent	= 	$row['nomestadorent'];	
            $Registro->tipo				= 	$row['tipo'];								
            $Registro->id_tipopago		= 	$row['id_tipopago'];
            $Registro->id_tipodocpago	= 	$row['id_tipodocpago'];
            $Registro->id_tipoentrega	= 	$row['id_tipoentrega'];
            $Registro->nomtipoentrega	= 	$row['nomtipoentrega'];
            $Registro->id_direccion		= 	$row['id_direccion'];
            $Registro->id_tipoflujo		= 	$row['id_tipoflujo'];
            $Registro->nomtipoflujo		= 	$row['nomtipoflujo'];
            $Registro->codigovendedor	= 	$row['codigovendedor'];
            $Registro->rutcliente		= 	$row['rutcliente'];
            $Registro->rutvendedor		= 	$row['rutvendedor'];
            $Registro->codlocalventa	= 	$row['codlocalventa'];
            $Registro->codlocalcsum		= 	$row['codlocalcsum'];
            $Registro->nom_localcsum	= 	$row['nom_localcsum'];	
            $Registro->nom_localventa	= 	$row['nom_localventa'];	
            $Registro->razonsoc			= 	$row['razonsoc'];
            $Registro->giro				= 	$row['giro'];
            $Registro->id_giro			= 	$row['id_giro'];
            $Registro->direccion		= 	$row['direccion'];
            $Registro->comuna			= 	$row['comuna'];
            $Registro->iva				= 	$row['iva'];
            $Registro->condicion		= 	$row['condicion'];
            $Registro->diascondicion	= 	$row['diascondicion'];
            $Registro->fonocontacto		= 	$row['fonocontacto'];
            $Registro->observaciones	= 	$row['observaciones'];
            $Registro->nota				= 	$row['nota'];
            $Registro->id_usuario		= 	$row['id_usuario'];		
            $Registro->numdocpago		= 	$row['numdocpago'];
            $Registro->obsdesb		    = 	$row['obsdesb'];	
            $Registro->usrcrea		    = 	$row['usrcrea'];					
            $Registro->feccrea		    = 	$row['feccrea'];				
            $Registro->indmsgsap		= 	$row['indmsgsap'];				
			if (($row['id_estado']=='OB') || ($row['id_estado']=='OM')) {
				$Registro->puedever		= 	false;
			} else {
				$Registro->puedever		= 	true;
			}
            $Registro->total_orden		=	$row1['cont'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

	public function getdetordenentpespecial($List) {
		$List->gofirst();
        
		$query = "	select count(codtipo) as numtipo,
					sum(if(n_compra >1,1,0)) as n_compra,
					(SELECT count(id_ordenpicking) FROM ordenpicking_e o where id_ordenent=".$List->getelem()->id_ordenent." and id_estado='ES') as ope
		from ordenent_d od left join ordenescompra compra on (od.id_linea=compra.id_linea)where codtipo='PE' and od.id_ordenent=".$List->getelem()->id_ordenent."";
        //general::writeevent('conteo ', $query);
        $res = $this->bd->query($query);
         
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetordenent;
            $Registro->numlinea			= 	$row['numtipo'];
            $Registro->totallinea		= 	$row['n_compra'];
            $Registro->cantidadp		= 	$row['ope'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
    public function getdetordenent($List) {
		$List->gofirst();
        $query = "	SELECT DISTINCT	d.id_linea, 
                            d.id_ordenent,  
                            d.id_tiporetiro,  
                            d.numlinea, 
                            d.descripcion,  
                            d.codprod,  
                            d.barra,  
							d.nomproveedor,  
							d.rutproveedor,  
                            d.pcosto,  
                            d.pventaneto,  
                            d.pventaiva,  
                            d.totallinea,  
                            d.cantidade,  
                            d.cantidadp,  
                            d.cantidadd,  
                            d.id_lineadoc,  
                            d.id_documento,
                            d.id_documentof,
                            d.id_documentog,
                            d.unimed,
							ef.pagina paginaf,
							eg.pagina paginag,
							d.codtipo,
							d.codsubtipo,
   							oe.id_tipoentrega,
   							d.instalacion,
   							d.peso,
   							d.descuento,
   							d.iva
                    FROM 	ordenent_d d
                    LEFT JOIN ordenent_e oe on oe.id_ordenent = d.id_ordenent      
					LEFT JOIN	documento_e ef on ef.id_documento = d.id_documentof 
					LEFT JOIN	documento_e eg on eg.id_documento = d.id_documentog 
                    WHERE 	1 
                    " . (($List->getelem()->codtipo)? " and d.codtipo = '".$List->getelem()->codtipo."' " : "") . "
                    " . (($List->getelem()->id_ordenent)? " and d.id_ordenent = ".$List->getelem()->id_ordenent." " : "") . "
					" . (($List->getelem()->id_linea)? " and id_linea = ".$List->getelem()->id_linea." " : "") . "
					ORDER BY 1 
                    ";
        
        $res = $this->bd->query($query);
        //general::writeevent('consulta detalle',$query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetordenent;
            $Registro->id_linea			= 	$row['id_linea'];
            $Registro->id_ordenent		= 	$row['id_ordenent'];
            $Registro->id_tiporetiro	= 	$row['id_tiporetiro'];
            $Registro->id_tipoentrega	= 	$row['id_tipoentrega'];
            $Registro->numlinea			= 	$row['numlinea'];
            $Registro->descripcion		= 	$row['descripcion'];
            $Registro->codprod			= 	$row['codprod'];
            $Registro->barra			= 	$row['barra'];
            $Registro->nomproveedor		= 	$row['nomproveedor'];
            $Registro->rutproveedor		= 	$row['rutproveedor'];
            $Registro->pcosto			= 	$row['pcosto'];
            $Registro->pventaneto		= 	$row['pventaneto'];
            $Registro->pventaiva		= 	$row['pventaiva'];
            $Registro->totallinea		= 	$row['totallinea'];
            $Registro->cantidade		= 	$row['cantidade'];
            $Registro->cantidadp		= 	$row['cantidadp'];
            $Registro->cantidadd		= 	$row['cantidadd'];
            $Registro->id_lineadoc		= 	$row['id_lineadoc'];
            $Registro->id_documento		= 	$row['id_documento'];
            $Registro->id_documentof	= 	$row['id_documentof'];
            $Registro->id_documentog	= 	$row['id_documentog'];
            $Registro->unimed			= 	$row['unimed'];
            $Registro->paginaf			= 	$row['paginaf'];
            $Registro->paginag			= 	$row['paginag'];
            $Registro->codtipo   		= 	$row['codtipo'];             
            $Registro->codsubtipo		= 	$row['codsubtipo'];
            $Registro->instalacion		= 	$row['instalacion'];
            $Registro->peso		        = 	$row['peso'];
            $Registro->descuento		= 	$row['descuento'];
            $Registro->iva      		= 	$row['iva'];
                         
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
	public function getdetoerdenentregasumimp($List) {
		$List->gofirst();
        $query = "	SELECT
					sum(rete_ica) as rete_ica,
					sum(rete_renta) as rete_renta
					FROM ordenent_d
					where id_ordenent=" .$List->getelem()->id_ordenent."";
       
        $res = $this->bd->query($query);
        //general::writeevent('mmm',$query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetordenent;
            $Registro->rete_ica		= 	$row['rete_ica'];
            $Registro->rete_renta 	= 	$row['rete_renta'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
	public function getdetcomprapendiente($List) {
		$List->gofirst();
        $query = "	SELECT n_compra, id_ordenent, id_linea FROM ordenescompra where id_linea=".$List->getelem()->id_linea."";
        
        $res = $this->bd->query($query);
        //general::writeevent('consulta compra venta',$query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetordenent;
            $Registro->codprod			= 	$row['n_compra'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
    /*Obtener Impuestos de Cotizacion_d*/
    public function getimpuestos($List, $id_cotizacion) {
        $query = "	SELECT  e.rete_ica as ret_ica,
							e.rete_iva as ret_iva,
							e.rete_renta as ret_renta,
							e.cot_iva as coti_iva
                    FROM  cotizacion_e e
					
                    WHERE e.id_cotizacion = ".$id_cotizacion."";
                    
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetordenent;
            $Registro->ret_ica		= 	$row['ret_ica'];
            $Registro->ret_iva 		= 	$row['ret_iva'];
            $Registro->ret_renta   	= 	$row['ret_renta'];
            $Registro->coti_iva     = 	$row['coti_iva'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    /*Fin Obtener Impuestos de Cotizacion_d*/
    
	public function oe_divi_producospos($cadena_id_oe) {
		
	  $id_oeC=split(',',$cadena_id_oe);
	  foreach($id_oeC as $key=>$value){
			
        $query = "	SELECT cantidade/".CANTIDAD_POS." as div_pos,descuento/cantidade as descuento_unitario,id_linea, id_ordenent, id_tiporetiro, numlinea, descripcion, codprod, barra, pcosto, pventaneto, pventaiva, totallinea, cantidade, cantidadp, cantidadd, id_lineadoc, id_documento, id_documentof, id_documentog, codtipo, codsubtipo, usrcrea, feccrea, usrmod, fecmod, unimed, rutproveedor, nomproveedor, marcaflete, instalacion, peso, descuento, iva, rete_ica, rete_renta, margenlinea
        			FROM ordenent_d o where id_ordenent=".$value." and cantidade > ".CANTIDAD_POS."";
                    
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        
        while ($row = $res->fetch_assoc()){
        	$div_pos=str_replace(".", ",",$row['div_pos']);
        	$div_pos=split(',',$div_pos);
         	for($i = 1; $i <=  $div_pos[0]; $i ++){
         		if($i==1){
         			$query = "update ordenent_d set pventaiva=((pventaneto*".CANTIDAD_POS.")*1.19),totallinea=(pventaneto*".CANTIDAD_POS."),cantidade=".CANTIDAD_POS.",descuento=(".$row['descuento_unitario']."*".CANTIDAD_POS.")  where id_linea=".$row['id_linea'];
         		}
         		else{
         			$query = "insert into ordenent_d (id_linea, id_ordenent, id_tiporetiro, numlinea, descripcion, codprod, barra, pcosto, pventaneto, pventaiva, totallinea, cantidade, cantidadp, cantidadd, id_lineadoc, id_documento, id_documentof, id_documentog, codtipo, codsubtipo, usrcrea, feccrea, usrmod, fecmod, unimed, rutproveedor, nomproveedor, marcaflete, instalacion, peso, descuento, iva, rete_ica, rete_renta, margenlinea)
							  SELECT null, id_ordenent, id_tiporetiro, numlinea, descripcion, codprod, barra, pcosto, pventaneto, pventaiva, totallinea, cantidade, cantidadp, cantidadd, id_lineadoc, id_documento, id_documentof, id_documentog, codtipo, codsubtipo, usrcrea, feccrea, usrmod, fecmod, unimed, rutproveedor, nomproveedor, marcaflete, instalacion, peso, descuento, iva, rete_ica, rete_renta, margenlinea FROM ordenent_d o
							  where id_linea=".$row['id_linea'];	
         		}
         		$res_div = $this->bd->query($query);
        		if (!$res_div) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
          	}
          	
          	$cantidad_faltante=$row['cantidade']-($div_pos[0]* CANTIDAD_POS);
          	
          	if($cantidad_faltante > 0){
          			$query = "insert into ordenent_d (id_linea, id_ordenent, id_tiporetiro, numlinea, descripcion, codprod, barra, pcosto, pventaneto, pventaiva, totallinea, cantidade, cantidadp, cantidadd, id_lineadoc, id_documento, id_documentof, id_documentog, codtipo, codsubtipo, usrcrea, feccrea, usrmod, fecmod, unimed, rutproveedor, nomproveedor, marcaflete, instalacion, peso, descuento, iva, rete_ica, rete_renta, margenlinea)
							  SELECT null, id_ordenent, id_tiporetiro, numlinea, descripcion, codprod, barra, pcosto, pventaneto, (pventaneto*".$cantidad_faltante."), (pventaneto*".$cantidad_faltante."), ".$cantidad_faltante.", cantidadp, cantidadd, id_lineadoc, id_documento, id_documentof, id_documentog, codtipo, codsubtipo, usrcrea, feccrea, usrmod, fecmod, unimed, rutproveedor, nomproveedor, marcaflete, instalacion, peso, (".$row['descuento_unitario']."*".$cantidad_faltante."), iva, rete_ica, rete_renta, margenlinea FROM ordenent_d o
							  where id_linea=".$row['id_linea'];
          		$res_div = $this->bd->query($query);
        		if (!$res_div) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
          	}
        general::inserta_tracking("",$value,"","","Se realiza la divisi�n del producto ".$row['codprod']." puesto que la cantidad ingresada excede la capacidad m�xima del POS ");
        }
        $res->free();
	  }
        return true;
    }
    
    public function saveencordenent($List, $fecha_rc, $fecha_ei, $fecha_dp,$valor_margen) {
    	
    	 // echo '<pre>';
      //     print_r($List);
      //   echo '</pre>';
       
        file_put_contents("saveencordenentList.txt",  $valor_margen);

        global $ses_usr_login, $ses_usr_id;
    	$List->gofirst();
    	if ($List->numelem()!=1){
    		throw new CTRLException("Numero incorrecto de elementos", 0);
    	}
    	
    	/*if($ses_usr_login == '' && $ses_usr_id == ''){
    		$ses_usr_login = 'adimin';
    		$ses_usr_id = '1';
    		general::writelog("este es sesion".$ses_usr_id);
    	}*/
		 
         echo "<script>alert('save 1');</script>";

    	if ($List->getelem()->id_ordenent){
    		
    		//Es una orden de entrega antigua, se hace UPDATE
            $query = "	UPDATE ordenent_e 
                        SET	usrcrea = usrcrea
                        " . (($List->getelem()->id_cotizacion)? ", id_cotizacion = ". $List->getelem()->id_cotizacion : "") . "
                        " . (($List->getelem()->id_estado)? ", id_estado = '". $List->getelem()->id_estado . "'": "") . "
                        " . (($List->getelem()->id_tipopago)? ", id_tipopago = ". $List->getelem()->id_tipopago : "") . "
                        " . (($List->getelem()->id_tipodocpago)? ", id_tipodocpago = ". $List->getelem()->id_tipodocpago : "") . "
                        " . (($List->getelem()->id_tipoentrega)? ", id_tipoentrega = ". $List->getelem()->id_tipoentrega : "") . "
                        " . (($List->getelem()->id_direccion)? ", id_direccion = ". $List->getelem()->id_direccion : "") . "
                        " . (($List->getelem()->id_tipoflujo)? ", id_tipoflujo = ". $List->getelem()->id_tipoflujo : "") . "
                        " . (($List->getelem()->codigovendedor)? ", codigovendedor = '". $List->getelem()->codigovendedor ."'": "") . "
                        " . (($List->getelem()->rutcliente)? ", rutcliente = ". $List->getelem()->rutcliente : "") . "
                        " . (($List->getelem()->codlocalventa)? ", codlocalventa = '". $List->getelem()->codlocalventa . "'" : "") . "
                        " . (($List->getelem()->codlocalcsum)? ", codlocalcsum = '". $List->getelem()->codlocalcsum . "'" : "") . "
                        " . (($List->getelem()->razonsoc)? ", razonsoc = '". addslashes($List->getelem()->razonsoc) . "'" : "") . "
                        " . (($List->getelem()->id_giro)? ", id_giro = '". $List->getelem()->id_giro . "'" : "") . "
                        " . (($List->getelem()->giro)? ", giro = '". addslashes($List->getelem()->giro) . "'" : "") . "
                        " . (($List->getelem()->direccion)? ", direccion = '". addslashes($List->getelem()->direccion) . "'" : "") . "
                        " . (($List->getelem()->comuna)? ", comuna = '". $List->getelem()->comuna . "'" : "") . "
                        " . (($List->getelem()->iva)? ", iva = ". $List->getelem()->iva : "") . "
                        " . (($List->getelem()->condicion)? ", condicion = '". $List->getelem()->condicion . "'" : "") . "
                        " . (($List->getelem()->diascondicion)? ", diascondicion = ". $List->getelem()->diascondicion : "") . "
                        " . (($List->getelem()->fonocontacto)? ", fonocontacto = '". $List->getelem()->fonocontacto . "'" : "") . "
                        " . (($List->getelem()->observaciones)? ", observaciones = '". addslashes($List->getelem()->observaciones) . "'" : "") . "
                        " . (($List->getelem()->nota)? ", nota = '". $List->getelem()->nota . "'" : "") . "
                        , id_usuario = 1 
                        , usuariocrea = 'ws'
                        " . (($List->getelem()->numdocpago)? ", numdocpago = '". $List->getelem()->numdocpago . "'" : "") . "
                        " . (($List->getelem()->fechacompra)? ", fechacompra = '". $List->getelem()->margentotal . "'": (($List->getelem()->id_estado=='OG')?", fechacompra = '".date("Y-m-d"). "'":"")) . "
                        " . (($List->getelem()->obsdesb)? ", obsdesb = '". $List->getelem()->obsdesb . "'" : "") . "
                        " . (($List->getelem()->indmsgsap!==null)? ", indmsgsap = ". $List->getelem()->indmsgsap : "") . "
                        , usrmod = 'ws'  
                        , fecmod = now()
                        WHERE id_ordenent = ".$List->getelem()->id_ordenent ;
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            return true;
            
    	}
    	else {
		general::writelog('rut cliente p'.$List->getelem()->rutcliente);

       // echo "<script>alert('save 2');</script>"
       
        /************************************
            obtener la observacion del pos colocada en la cotizacion..
            fecha:06-11-2018.
            Jose G. 
        /*************************************/
        $getObsPos = bizcve::showObservacionPos($List->getelem()->id_cotizacion);
       


        file_put_contents("ordenentregaInsert.txt", $getObsPos);
        file_put_contents("queryOrdenInsertar.txt", $List->getelem()->margen);
	    	//Es una cotización nueva, se hace INSERT
            $query = "	INSERT INTO ordenent_e (	
							id_ordenent,
							id_cotizacion,
							id_estado,
							id_tipopago,
							id_tipodocpago,
							id_tipoentrega,
							id_direccion,
							id_tipoflujo,
							codigovendedor,
							rutcliente,
							codlocalventa,
							codlocalcsum,
							razonsoc,
							id_giro,
							giro,
							direccion,
							comuna,
							iva,
							condicion,
							diascondicion,
							fonocontacto,
							observaciones,
							nota,
							id_usuario,
							usuariocrea,
							numdocpago,
							obsdesb,
							fechacompra,
							indmsgsap, 
							usrcrea,
							feccrea,
							usrmod,
							fecmod,
							fecha_retira_cliente,
							fecha_retira_inmediato,
							fecha_despacho_programado,
							totaliva,
							zona,
							rete_iva_oe,
                            obspos,
                            margen
                        )
                        VALUES (
                            null,
                            ".($List->getelem()->id_cotizacion+0).",
                            '".$List->getelem()->id_estado."',
                            ".(($List->getelem()->id_tipopago)?$List->getelem()->id_tipopago:'null').",
                            ".(($List->getelem()->id_tipodocpago)?$List->getelem()->id_tipodocpago:'null').",
                            ".(($List->getelem()->id_tipoentrega)?$List->getelem()->id_tipoentrega:'null').",
                            '".$List->getelem()->id_direccion."',
                            ".(($List->getelem()->id_tipoflujo)?$List->getelem()->id_tipoflujo:'null').",
                            '".$List->getelem()->codigovendedor."',
                            ".($List->getelem()->rutcliente+0).",
                            '".$List->getelem()->codlocalventa."',
                            '".$List->getelem()->codlocalcsum."',
                            '".addslashes($List->getelem()->razonsoc)."',
                            '".$List->getelem()->id_giro."',
                            '".addslashes($List->getelem()->giro)."',
                            '".addslashes($List->getelem()->direccion)."',
                            '".$List->getelem()->comuna."',
                            '".$List->getelem()->iva."',
                            '".$List->getelem()->condicion."',
                            '".($List->getelem()->diascondicion+0)."',
                            '".$List->getelem()->fonocontacto."',
                            '".addslashes($List->getelem()->observaciones)."',
                            '".$List->getelem()->nota."',
                            ".($ses_usr_id+0).",
                            '".$ses_usr_login."',
                            '".($List->getelem()->numdocpago+0)."',
                            '".$List->getelem()->obsdesb."',
                            now(), 
							0, 
                            '".$ses_usr_login."',
                            now(),
                            '".$ses_usr_login."',
                            now(),
                            '".$fecha_rc."',
                            '".$fecha_ei."',
                            '".$fecha_dp."',
							'".$List->getelem()->totaliva."',
							'".$List->getelem()->zona."',
							'".$List->getelem()->rete_iva_oe."',
                            '".$getObsPos."',
                            '".$valor_margen."'
                            
                        )";
	     //general::writeevent("Insert ordenentrega Encabezado : ".$query);
            $res = $this->bd->querynoselect($query);
            // file_put_contents("queryOrdenInsertar.txt", print_r($res,true));
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

            $List->getelem()->id_ordenent = $this->bd->last_insert_id();
            return true;
    	}
    }
    
    /*Actualizar Total de la OE*/
	public function updateoe($id_ordenent,$sumtotal,$rete_iva2,$totaliva){
    	
    	$query = "UPDATE ordenent_e
    	          SET totaloe = ".$sumtotal.""
    	          .(($rete_iva2)? ", rete_iva_oe = ".$rete_iva2."" : "").""
    	          .(($totaliva)? ", totaliva = ".$totaliva."" : "").""
    	          ." WHERE id_ordenent = ".$id_ordenent."";
    	//general::writeevent($query);          
    	$res = $this->bd->query($query);
        
    	if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);         
        
        return true;
    }
    /*Fin Actualizar Total de la OE*/
	
	public function cambioindicadorsap($List) {
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("N&uacute;mero incorrecto de elementos", 0);
    	}
		
    	if ($List->getelem()->id_ordenent){
    		//Es una orden de entrega antigua, se hace UPDATE
            $query = "	UPDATE ordenent_e 
                        SET	usrcrea = usrcrea
                        " . (($List->getelem()->indmsgsap!==null)? ", indmsgsap = ". $List->getelem()->indmsgsap : "") . "
                        " . (($List->getelem()->usrmod)? ", usrmod = '". $List->getelem()->usrmod."'" : "") . "
                        , fecmod = now()
                        WHERE id_ordenent = ".$List->getelem()->id_ordenent ;
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            return true;
    	}

    }
    public function savedetordenent($ListEnc, $ListDet) {
    	global $ses_usr_login;
    	$ListEnc->gofirst();
    	if ($ListEnc->numelem()!=1){
            throw new CTRLException("N&uacute;mero incorrecto de elementos", 0);
    	}
		if (!$ListEnc->getelem()->id_ordenent){
            throw new CTRLException("No viene Id de Orden de Entrega", 0);
    	}
    	
    	if($ses_usr_login == '' && $ses_usr_id == ''){
    		$ses_usr_login = 'adimin';
    		$ses_usr_id = '1';
    	}
    	
    	
    	if (!$ListDet)
    		return true;

    	$ListDet->gofirst();
    	//$descripcion = 
		if (!$ListDet->isvoid()) {
			do {
				//Insertamos los registros de detalle
                $query = "	INSERT INTO ordenent_d (	
								id_linea,
								id_ordenent,
								id_tiporetiro,
								numlinea,
								descripcion,
								codprod,
								barra,
								nomproveedor,
								rutproveedor,
								pcosto,
								pventaneto,
								pventaiva,
								totallinea,
								cantidade,
								cantidadp,
								cantidadd,
								id_lineadoc, 
								unimed,
								codtipo,
								codsubtipo,
								usrcrea,
								feccrea,
								usrmod,
								fecmod,
								instalacion,
								peso,
								descuento,
								iva,
								rete_ica,
								rete_renta,
								margenlinea
								
                            )
                            VALUES (
                                null,
                                ".$ListEnc->getelem()->id_ordenent.",
                                ".($ListDet->getelem()->id_tiporetiro+0).",
                                ".($ListDet->getelem()->numlinea+0).",
								'".htmlspecialchars(str_replace("'", " ", $ListDet->getelem()->descripcion),ENT_QUOTES)."',
                                ".($ListDet->getelem()->codprod+0).",
                                '".($ListDet->getelem()->barra)."',
								'".htmlspecialchars(str_replace("'", " ", $ListDet->getelem()->nomproveedor),ENT_QUOTES)."',                                
								".($ListDet->getelem()->rutproveedor+0).",
								".($ListDet->getelem()->pcosto+0).",
                                ".($ListDet->getelem()->pventaneto+0).",
                                ".($ListDet->getelem()->pventaiva+0).",
                                ".($ListDet->getelem()->totallinea+0).",
                                ".($ListDet->getelem()->cantidade+0).",
                                ".($ListDet->getelem()->cantidadp+0).",
                                ".($ListDet->getelem()->cantidadd+0).",
                                ".($ListDet->getelem()->id_lineadoc+0).",
                                '".$ListDet->getelem()->unimed."',
                                '".$ListDet->getelem()->codtipo."',
                                '".$ListDet->getelem()->codsubtipo."',
                                '".$ses_usr_login."',
                                now(),
                                '".$ses_usr_login."',
                                now(),
                                '".$ListDet->getelem()->instalacion."',
                                '".$ListDet->getelem()->peso."',
                                '".$ListDet->getelem()->descuento."',
				    			'".$ListDet->getelem()->iva."',
				    			'".$ListDet->getelem()->rete_ica."',
				    			'".$ListDet->getelem()->rete_renta."',
				    			'".$ListDet->getelem()->margenlinea."'
                            )";
                $res = $this->bd->querynoselect($query);
                if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
			} while ($ListDet->gonext());
		}
		return true;
    }
    
	public function savedetordenescomprapendientes($idline,$ncompra,$idoe) {

				
                $query = "	INSERT INTO ordenescompra (	
								 id_linea,
								 n_compra, 
								 id_ordenent
                            )
                            VALUES (
                                '".$idline."',
				    			'".$ncompra."',
				    			'".$idoe."'
                            )";
                $res = $this->bd->querynoselect($query);
                
                //general::writeevent($query);
                if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
			
		return true;
    }
    
   /*Optener Detalle Impuesto*/
    public function getdetalleimpuestoe($List, $id_ordenent,$grupoimp) {    	
		$query = "	SELECT  rete_renta,
                            rete_ica,
                            iva,
                            (iva/100)+1 impivatotal,
                            sum((totallinea/((iva/100)+1))) as totalsiniva,
                            sum(round((totallinea/((iva/100)+1))*(".$grupoimp."/100))) as imptotal
                    FROM 	ordenent_d cd
                    WHERE
                    id_ordenent = ".$id_ordenent." group by $grupoimp";
                   
		
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetordenent;
            $Registro->sumiva           =   $row['imptotal'];
            $Registro->rete_ica			= 	$row['rete_ica'];
            $Registro->rete_renta		= 	$row['rete_renta'];
            $Registro->iva			    = 	$row['iva'];
            $Registro->sumtotaliva		= 	$row['totalsiniva'];            
            $List->addlast($Registro);
        }
            $res->free();
        return true;
    }
    /*Fin getdetalleimpuesto*/
    
	/*Impuesto detallado*/
    /*Optener Detalle Impuesto*/
    public function getdetalleimpuestoed($List, $id_ordenent,$grupoimp) {    	
		$query = "	SELECT  rete_renta,
                            rete_ica,
                            iva,
                            (iva/100)+1 impivatotal,
                            sum((totallinea/((iva/100)+1))) as totalsiniva,
                            sum(round((totallinea/((iva/100)+1))*(".$grupoimp."/100))) as imptotal
                    FROM 	ordenent_d cd
                    JOIN 	tiporetiro tr on (tr.id_tiporetiro=cd.id_tiporetiro)
                    WHERE
                    id_ordenent = ".$id_ordenent." group by $grupoimp";
                   
		
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetordenent;
            $Registro->sumiva           =   $row['imptotal'];
            $Registro->rete_ica			= 	$row['rete_ica'];
            $Registro->rete_renta		= 	$row['rete_renta'];
            $Registro->iva			    = 	$row['iva'];
            $Registro->sumtotaliva		= 	$row['totalsiniva'];            
            $List->addlast($Registro);
        }
            $res->free();
        return true;
    }
    /*Fin getdetalleimpuesto*/
    
    /*Fin de Impuesto detallado*/
    public function reservadisponible($listoe) {
    	global $ses_usr_login;
    	$listoe->gofirst();
    	if ($listoe->numelem()!=1){
            //throw new CTRLException("Número incorrecto de elementos", 0);
            general::writelog("ERROR DAOExcepcion: Clase " . __CLASS__ . ", metodo " . __FUNCTION__ . ", Descripcion: " . "Número incorrecto de elementos en lista");
            return false;
    	}
    	
		if (!$listoe->getelem()->id_ordenent){
            //throw new CTRLException("No viene Id de Orden de Entrega", 0);
            general::writelog("ERROR DAOExcepcion: Clase " . __CLASS__ . ", metodo " . __FUNCTION__ . ", Descripcion: " . "No viene Id de Orden de Entrega");
            return false;
    	}
    	
/*		if (!$listoe->getelem()->id_documento){
            general::writelog("ERROR DAOExcepcion: Clase " . __CLASS__ . ", metodo " . __FUNCTION__ . ", Descripcion: " . "No viene Id de Documento en Orden de Entrega " . $listoe->getelem()->id_ordenent);
            return false;
    	}*/
    	
    	if ($listoe->getelem()->id_tipopago == 2){ //No es pago crédito. Retornamos de inmediato
            return true;
    	}
    	
    	if (!$listoe->getelem()->rutcliente){
            //throw new CTRLException("No viene Rut de Cliente en la Orden de Entrega", 0);
            general::writelog("ERROR DAOExcepcion: Clase " . __CLASS__ . ", metodo " . __FUNCTION__ . ", Descripcion: " . "No viene Rut de Cliente en Orden de Entrega " . $listoe->getelem()->id_ordenent);
            return false;
    	}
    	
    	$listoe->gofirst();
              $query = "	INSERT INTO disponible (	
								id_linea, 
								id_tipomovimiento,
								rut,
								monto,
								id_ordenent, 
								id_documento, 
								usrcrea,
								feccrea,
								usrmod,
								fecmod
                          	)
                          	VALUES (
	                            null,
								2,
								" . $listoe->getelem()->rutcliente . ",
								" . ($listoe->getelem()->monto+0) . ",
	                            " . ($listoe->getelem()->id_ordenent+0) . ",
	                            " . ($listoe->getelem()->id_documento+0) . ",
	                            '".$ses_usr_login."',
	                            now(),
	                            '".$ses_usr_login."',
	                            now()
                          	)";
              $res = $this->bd->querynoselect($query);
              //if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
              if (!$res){
				general::writelog("ERROR DAOExcepcion: Clase " . __CLASS__ . ", metodo " . __FUNCTION__ . ", Descripcion: " . $this->bd->error() . " [$query]");
	            return false;
              }
		return true;
    }

    public function deshacerreservadisponible($listoe, $insolooe = false) {
    	$listoe->gofirst();
    	if ($listoe->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
    	}
		if (!$listoe->getelem()->id_ordenent){
            throw new CTRLException("No viene Id de Orden de Entrega", 0);
    	}
    	
    	$listoe->gofirst();
              $query = "	DELETE FROM disponible
							WHERE 1 
								" . (($insolooe)?" and (id_documento = 0 or id_documento IS NULL)":"") ."  
								and id_ordenent = " . ($listoe->getelem()->id_ordenent + 0);
              $res = $this->bd->querynoselect($query);
              if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
    }

    public function eliminaroe($listoe) {
    	$listoe->gofirst();
    	if ($listoe->numelem()!=1){
            throw new CTRLException("N&uacute;mero incorrecto de elementos", 0);
    	}
		if (!$listoe->getelem()->id_ordenent){
            throw new CTRLException("No viene Id de Orden de Entrega", 0);
    	}
    	
    	$listoe->gofirst();
        $query = "	DELETE FROM ordenent_e
					WHERE id_ordenent = " . ($listoe->getelem()->id_ordenent+0);
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
	}

	public function ActualizaCantOEOP($listopdetnew, $operacion) {
    	global $ses_usr_login;

    	if (!$listopdetnew) return true;
		if (!$listopdetnew->numelem()) return true;
		
		if ($operacion != '+'  && $operacion != '-'){
            throw new CTRLException("Operador incorrecto", 0);
    	}

    	$listopdetnew->gofirst();
    	$this->initrx();
		do {
            $query = "	UPDATE ordenent_d 
                        SET	cantidadp = cantidadp " . $operacion  . ($listopdetnew->getelem()->cantidad+0) . "
                        , usrmod = '".$ses_usr_login."' 
                        , fecmod = now()
                        WHERE id_linea = ".($listopdetnew->getelem()->id_lineadoc+0) ;
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		} while ($listopdetnew->gonext());
		$this->commit();
		return true;
	}
	
}
?>
