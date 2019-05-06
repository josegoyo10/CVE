<?
class daodocumento{
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

    public function getencdocumento($List) {
		$List->gofirst();
        $query = "	SELECT 	id_documento,
                            id_tipodocumento,
                            id_tipoorigen,
                            sigtipodoc,
                            pagina,
                            tipoorigen,
                            numorigen,
                            numdocumento,
							fechadocumento,
							numdocref,
							numdocrefop,
							codigovendedor,
                            rutcliente,
                            razonsoc,
                            id_giro, 
							giro,
                            direccion,
                            comuna,
                            iva,
                            totaltexto,
                            totalnum,
                            totaliva,
                            totalnumiva,
                            condicion,
                            diascondicion,
                            fonocontacto,
                            observaciones,
                            nota,
                            codlocalventa,
                            codlocalcsum,
							lockprintgde,
							lockprintfct,
							indmsgsap,
							feccrea,
							fecmod,
							numdocumento,
							mediopago,
							nreimpresion                   
					FROM 	documento_e 
                    WHERE 	1 
                            " . (($List->getelem()->id_documento)? " and id_documento in (".$List->getelem()->id_documento.")" : "") . "
                            " . (($List->getelem()->id_tipodocumento)? " and id_tipodocumento = ".$List->getelem()->id_tipodocumento." " : "") . "
                            " . (($List->getelem()->id_tipoorigen)? " and id_tipoorigen = ".$List->getelem()->id_tipoorigen." " : "") . "
                            " . (($List->getelem()->sigtipodoc)? " and sigtipodoc = '".$List->getelem()->sigtipodoc."' " : "") . "
                            " . (($List->getelem()->numdocumento)? " and numdocumento = '".$List->getelem()->numdocumento."' " : "") . "
                            " . (($List->getelem()->numorigen!==null)? " and numorigen = ".$List->getelem()->numorigen." " : "") . "
                            " . (($List->getelem()->numdocrefop)? " and numdocrefop = ".$List->getelem()->numdocrefop." " : "") . "
                            " . (($List->getelem()->numdocref)? " and numdocref = ".$List->getelem()->numdocref." " : "") . "
                            " . (($List->getelem()->indmsgsap!==null)? " and indmsgsap = ".$List->getelem()->indmsgsap." " : "") . "
                            " . (($List->getelem()->tipoorigen)? " and tipoorigen = '".$List->getelem()->tipoorigen."'" : "") . "
                            " . (($List->getelem()->codlocalcsum)? " and codlocalcsum = '".$List->getelem()->codlocalcsum."'" : "") . "
                   	ORDER BY
							id_documento";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodocumento;
            $Registro->id_documento		= 	$row['id_documento'];
            $Registro->id_tipodocumento	= 	$row['id_tipodocumento'];
            $Registro->id_tipoorigen	= 	$row['id_tipoorigen'];
            $Registro->sigtipodoc		= 	$row['sigtipodoc'];
            $Registro->pagina			= 	$row['pagina'];
            $Registro->tipoorigen		= 	$row['tipoorigen'];
            $Registro->numorigen		= 	$row['numorigen'];
            $Registro->numdocumento		= 	$row['numdocumento'];
            $Registro->fechadocumento	= 	$row['fechadocumento'];
            $Registro->numdocref		= 	$row['numdocref'];
            $Registro->numdocrefop		= 	$row['numdocrefop'];
            $Registro->codigovendedor	= 	$row['codigovendedor'];
            $Registro->rutcliente		= 	$row['rutcliente'];
            $Registro->razonsoc			= 	$row['razonsoc'];
            $Registro->id_giro			= 	$row['id_giro'];
            $Registro->giro				= 	$row['giro'];
            $Registro->direccion		= 	$row['direccion'];
            $Registro->comuna			= 	$row['comuna'];
            $Registro->iva				= 	$row['iva'];
            $Registro->totaltexto		= 	$row['totaltexto'];
            $Registro->totalnum			= 	$row['totalnum'];
            $Registro->totaliva			= 	$row['totaliva'];
            $Registro->totalnumiva		= 	$row['totalnumiva'];
            $Registro->condicion		= 	$row['condicion'];
            $Registro->diascondicion	= 	$row['diascondicion'];
            $Registro->fonocontacto		= 	$row['fonocontacto'];
            $Registro->observaciones	= 	$row['observaciones'];
            $Registro->nota				= 	$row['nota'];
            $Registro->codlocalventa	= 	$row['codlocalventa'];
            $Registro->codlocalcsum		= 	$row['codlocalcsum'];
            $Registro->lockprintgde		= 	$row['lockprintgde'];
            $Registro->lockprintfct		= 	$row['lockprintfct'];
            $Registro->indmsgsap		= 	$row['indmsgsap'];
            $Registro->feccrea			= 	$row['feccrea'];
            $Registro->fecmod			= 	$row['fecmod'];
			$Registro->numfolio_gde		= 	$row['numdocumento'];
			$Registro->numfolio_fct		= 	$row['numdocumento'];
			$Registro->nreimpresion		= 	$row['nreimpresion'];
			$Registro->mediopago		= 	$row['mediopago'];
			$List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
   public function getdocumentoasoc($List) {
		$List->gofirst();
        $query = "	SELECT 	numdocumento 
                    FROM 	documento_e 
                    WHERE 	1 
                            " . (($List->getelem()->sigtipodoc)? " and sigtipodoc = '".$List->getelem()->sigtipodoc."' " : "") . "
                            " . (($List->getelem()->numorigen)? " and numorigen = ".$List->getelem()->numorigen." " : "") . "
							LIMIT ".LIMITE_REPORTE_GDE."";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodocumento;
			$Registro->numdocumento		= 	$row['numdocumento'];
			$List->addlast($Registro);
        }
        $res->free();
        return true;
    }

	public function gethoras_doc($List) {
		
		$List->gofirst();

		$query = "SELECT TIMEDIFF(now(), '".$List->getelem()->fecmod."') as tiempo;";
		$res = $this->bd->query($query);
//		general::writeevent($query);

		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		$List->clearlist();

		while ($row = $res->fetch_assoc()){
			$Registro = new dtodocumento;
			$Registro->timewarning		= 	$row['tiempo'];
		}$List->addlast($Registro);

        $res->free();
		return true;
    }
	
	   public function getdocumentonulo($List) {
		$List->gofirst();
        $query = "	SELECT 	numdocumento,
							id_documento,
							id_tipodocumento,
							estado,
							numorigen,
							sigtipodoc,
							numdocref,
							codlocalventa,
							pagina,
							fechadocumento,
							rutcliente,
							fecmod,
							indmsgsap,
							razonsoc
                    FROM 	documento_e 
                    WHERE 	1 
                            " . (($List->getelem()->sigtipodoc)? " and sigtipodoc = '".$List->getelem()->sigtipodoc."' " : "") . "
                            " . (($List->getelem()->numorigen)? " and numorigen = ".$List->getelem()->numorigen." " : "") . "
                            " . (($List->getelem()->id_documento)? " and id_documento = ".$List->getelem()->id_documento." " : "") . "
                            " . (($List->getelem()->numdocref)? " and numdocref = ".$List->getelem()->numdocref." " : "") . "
							AND numdocumento <> '0' AND numdocumento <> ''
							";


        
        $res = $this->bd->query($query);
		//general::writeevent($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

		$List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodocumento;
			$Registro->numdocumento		= 	$row['numdocumento'];
			$Registro->id_documento		= 	$row['id_documento'];
			$Registro->id_tipodocumento	= 	$row['id_tipodocumento'];
			$Registro->estado			= 	$row['estado'];
			$Registro->numorigen		= 	$row['numorigen'];
			$Registro->numdocref		= 	$row['numdocref'];
			$Registro->sigtipodoc		= 	$row['sigtipodoc'];
			$Registro->codlocalventa	= 	$row['codlocalventa'];
			$Registro->pagina			= 	$row['pagina'];
			$Registro->fechadocumento	= 	$row['fechadocumento'];
			$Registro->fechahora		= 	$row['fecmod'];
			$tiempomod					=	$row['fecmod'];
			$Registro->rutcliente		= 	$row['rutcliente'];
			$Registro->indmsgsap		= 	$row['indmsgsap'];
			$Registro->razonsoc			= 	$row['razonsoc'];
			$List->addlast($Registro);
        }
        $res->free();
		return true;
    }
   /*Metodo para cargar folio en version chilena en version Colombia se suprime este metodo por el id_ de  oe*/
    public function getultimofolio($List) {
    	$List->gofirst();
        $query = "	SELECT 	cod_local,
                            foliofct,
                            foliogde
                    FROM 	locales
                    WHERE 	1 
                            " . (($List->getelem()->cod_local)? " and cod_local = '".$List->getelem()->cod_local."'" : "") . "
                            " . (($List->getelem()->numfolio_fct)? " and foliofct = ".$List->getelem()->numfolio_fct." " : "") . "
                            " . (($List->getelem()->numfolio_gde)? " and foliogde = ".$List->getelem()->numfolio_gde." " : "") . "
                   			 ";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodocumento;
            $Registro->cod_local		= 	$row['cod_local'];
            $Registro->numfolio_fct	= 	$row['foliofct'];
            $Registro->numfolio_gde	= 	$row['foliogde'];
            $List->addlast($Registro);
        }

        $res->free();
        return true;

    }
    /*Fin metodo genera consecutivo de folio*/
    public function savefolio($List){
    	
    	$List->gofirst();

		//Cambio de folio
        $query = "	UPDATE locales
					SET   foliofct = ".(($List->getelem()->numfolio_fct)? $List->getelem()->numfolio_fct :"foliofct")."
						, foliogde = ".(($List->getelem()->numfolio_gde)? $List->getelem()->numfolio_gde :"foliogde")."
                    WHERE cod_local = ('".$List->getelem()->cod_local."')" ;
        $res = $this->bd->querynoselect($query);
        $fct=$List->getelem()->numfolio_fct;
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
    }
    
	public function getencdocumentosap($List) {
		$List->gofirst();
        $query = "	SELECT 	id_documento,
                            id_tipodocumento,
                            id_tipoorigen,
                            sigtipodoc,
                            pagina,
                            tipoorigen,
                            numorigen,
                            numdocumento,
							fechadocumento,
							numdocref,
							numdocrefop,
							codigovendedor,
                            rutcliente,
                            razonsoc,
                            giro,
                            direccion,
                            comuna,
                            iva,
                            totaltexto,
                            totalnum,
                            totaliva,
                            totalnumiva,
                            condicion,
                            diascondicion,
                            fonocontacto,
                            observaciones,
                            nota,
                            codlocalventa,
                            codlocalcsum,
							lockprintgde,
							lockprintfct,
							indmsgsap,
							feccrea,
							fecmod,
							mediopago
                    FROM 	documento_e 
	 				WHERE 	1 
                            " . (($List->getelem()->id_documento)? " and id_documento in (".$List->getelem()->id_documento.")" : "") . "
                            " . (($List->getelem()->id_tipodocumento)? " and id_tipodocumento = ".$List->getelem()->id_tipodocumento." " : "") . "
                            " . (($List->getelem()->id_tipoorigen)? " and id_tipoorigen = ".$List->getelem()->id_tipoorigen." " : "") . "
                            " . (($List->getelem()->sigtipodoc)? " and sigtipodoc = '".$List->getelem()->sigtipodoc."' " : "") . "
                            " . (($List->getelem()->numdocumento <> '0' )? " and numdocumento <> '0' " : "") . "
                            " . (($List->getelem()->numorigen!==null)? " and numorigen = ".$List->getelem()->numorigen." " : "") . "
                            " . (($List->getelem()->numdocref)? " and numdocref = ".$List->getelem()->numdocref." " : "") . "
                            " . (($List->getelem()->indmsgsap!==null)? " and indmsgsap = ".$List->getelem()->indmsgsap." " : "") . "
                            " . (($List->getelem()->tipoorigen)? " and tipoorigen = '".$List->getelem()->tipoorigen."'" : "") . " 
                           	";
 	
 		$res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodocumento;
            $Registro->id_documento		= 	$row['id_documento'];
            $Registro->id_tipodocumento	= 	$row['id_tipodocumento'];
            $Registro->id_tipoorigen	= 	$row['id_tipoorigen'];
            $Registro->sigtipodoc		= 	$row['sigtipodoc'];
            $Registro->pagina			= 	$row['pagina'];
            $Registro->tipoorigen		= 	$row['tipoorigen'];
            $Registro->numorigen		= 	$row['numorigen'];
            $Registro->numdocumento		= 	$row['numdocumento'];
            $Registro->fechadocumento	= 	$row['fechadocumento'];
            $Registro->numdocref		= 	$row['numdocref'];
            $Registro->numdocrefop		= 	$row['numdocrefop'];
            $Registro->codigovendedor	= 	$row['codigovendedor'];
            $Registro->rutcliente		= 	$row['rutcliente'];
            $Registro->razonsoc			= 	$row['razonsoc'];
            $Registro->id_giro			= 	$row['id_giro'];
            $Registro->giro				= 	$row['giro'];
            $Registro->direccion		= 	$row['direccion'];
            $Registro->comuna			= 	$row['comuna'];
            $Registro->iva				= 	$row['iva'];
            $Registro->totaltexto		= 	$row['totaltexto'];
            $Registro->totalnum			= 	$row['totalnum'];
            $Registro->totaliva			= 	$row['totaliva'];
            $Registro->totalnumiva		= 	$row['totalnumiva'];
            $Registro->condicion		= 	$row['condicion'];
            $Registro->diascondicion	= 	$row['diascondicion'];
            $Registro->fonocontacto		= 	$row['fonocontacto'];
            $Registro->observaciones	= 	$row['observaciones'];
            $Registro->nota				= 	$row['nota'];
            $Registro->codlocalventa	= 	$row['codlocalventa'];
            $Registro->codlocalcsum		= 	$row['codlocalcsum'];
            $Registro->lockprintgde		= 	$row['lockprintgde'];
            $Registro->lockprintfct		= 	$row['lockprintfct'];
            $Registro->indmsgsap		= 	$row['indmsgsap'];
            $Registro->feccrea			= 	$row['feccrea'];
            $Registro->fecmod			= 	$row['fecmod'];
            $Registro->mediopago		= 	$row['mediopago'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

	public function getfletesapdoc($List) {
		$List->gofirst();
		
        $query = "	SELECT 	d.totalnum,
							d.totaliva,
							d.pagina,
							oe.id_cotizacion
                    FROM 	documento_e d 
					JOIN ordenent_e oe ON d.numorigen = oe.id_ordenent
	 				WHERE 	1 
                            " . (($List->getelem()->id_documento)? " and d.id_documento = (".$List->getelem()->id_documento.")" : "") . "
                            " . (($List->getelem()->numdocumento)? " and d.numdocumento = ('".$List->getelem()->numdocumento."')" : "") . "
                            " . (($List->getelem()->numorigen)? " and d.numorigen = (".$List->getelem()->numorigen.")" : "") . "
                            and d.indodeasap = 0
                           	";
 	
 		$res = $this->bd->query($query);
		//general::writeevent($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodocumento;
            $Registro->totalnum			= 	$row['totalnum'];
            $Registro->totaliva			= 	$row['totaliva'];
	        $Registro->pagina			= 	$row['pagina'];
	        $Registro->id_cotizacion	= 	$row['id_cotizacion'];
			
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

	public function marcaodeasap($List) {
		$List->gofirst();
		
        $query = "	UPDATE documento_e 
							SET indodeasap = 1
							WHERE 1
							" . (($List->getelem()->pagina)? " and pagina = (".$List->getelem()->pagina.")" : "") . "
							AND indmsgsap = 1
							" . (($List->getelem()->id_documento)? " and id_documento = (".$List->getelem()->id_documento.")" : "") . "
                           	";
 		$res = $this->bd->query($query);
		//general::writeevent($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        //$res->free();
        return true;
    }

  public function getdetdocumentosap($List) {
		$List->gofirst();
        $query = "	SELECT d.id_linea,
                            d.id_documento,
                            d.numlinea,
                            d.descripcion,
                            d.codprod,
                            co.barra,
							d.codtipo,
                            co.pventaneto pventaco,
                            d.pventaiva,
                            d.cantidad,
							d.pcosto,
                            d.totallinea,
                            d.impuesto1,
                            d.impuesto2,
                            d.unimed,
							d.id_linearef ,
							d.rutproveedor,
							d.nomproveedor,
							d.codtipo,
							d.codsubtipo
                    FROM 	documento_d d
					JOIN documento_e de ON de.id_documento = d.id_documento
					JOIN ordenent_e oe ON de.numorigen = oe.id_ordenent
					JOIN ordenent_d od ON od.id_ordenent = oe.id_ordenent
					JOIN cotizacion_d co ON oe.id_cotizacion = co.id_cotizacion
                    WHERE 	1
                            " . (($List->getelem()->id_documento)? " and d.id_documento = ".$List->getelem()->id_documento." " : "") . "
							and d.codprod = co.codprod
							and od.barra = co.barra
							GROUP BY d.numlinea;
					";
        $res = $this->bd->query($query);
		//general::writelog("de esta query se va la informacara el pedido112: ".$query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		$List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetdocumento;
            $Registro->id_linea			= 	$row['id_linea'];
            $Registro->id_documento		= 	$row['id_documento'];
            $Registro->numlinea			= 	$row['numlinea'];
            $Registro->descripcion		= 	htmlspecialchars($row['descripcion'], ENT_QUOTES);
	    $Registro->codprod			= 	$row['codprod'];
            $Registro->barra			= 	$row['barra'];
            $Registro->codtipo			= 	$row['codtipo'];
            $Registro->pventaneto		= 	$row['pventaco'];
            $Registro->pventaiva		= 	$row['pventaiva'];
            $Registro->cantidad			= 	$row['cantidad'];
            $Registro->pcosto			= 	$row['pcosto'];
            $Registro->totallinea		= 	$row['totallinea'];
            $Registro->impuesto1		= 	$row['impuesto1'];
            $Registro->impuesto2		= 	$row['impuesto2'];
            $Registro->unimed			= 	$row['unimed'];				
            $Registro->id_linearef		= 	$row['id_linearef'];				
            $Registro->rutproveedor		= 	$row['rutproveedor'];				
            $Registro->nomproveedor		= 	$row['nomproveedor'];				
            $Registro->codtipo		        = 	$row['codtipo'];		
            $Registro->codsubtipo		= 	$row['codsubtipo'];		            
            $List->addlast($Registro);

        }
        $res->free();
        return true;            
    }   

    public function getdetdocumento($List) {
		$List->gofirst();
        $query = "	SELECT 	id_linea,
                            id_documento,
                            numlinea,
                            descripcion,
                            codprod,
                            barra,
							codtipo,
                            pventaneto,
                            pventaiva,
                            cantidad,
							pcosto,
                            totallinea,
                            impuesto1,
                            impuesto2,
                            unimed,
							id_linearef ,
							rutproveedor,
							nomproveedor,
							codtipo,
							codsubtipo
                    FROM 	documento_d
                    WHERE 	1 
                            " . (($List->getelem()->id_documento)? " and id_documento = ".$List->getelem()->id_documento." " : "") . "
                    ";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		$List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetdocumento;
            $Registro->id_linea			= 	$row['id_linea'];
            $Registro->id_documento		= 	$row['id_documento'];
            $Registro->numlinea			= 	$row['numlinea'];
            $Registro->descripcion		= 	htmlspecialchars($row['descripcion'], ENT_QUOTES);
			$Registro->codprod			= 	$row['codprod'];
            $Registro->barra			= 	$row['barra'];
            $Registro->codtipo			= 	$row['codtipo'];
            $Registro->pventaneto		= 	$row['pventaneto'];
            $Registro->pventaiva		= 	$row['pventaiva'];
            $Registro->cantidad			= 	$row['cantidad'];
            $Registro->pcosto			= 	$row['pcosto'];
            $Registro->totallinea		= 	$row['totallinea'];
            $Registro->impuesto1		= 	$row['impuesto1'];
            $Registro->impuesto2		= 	$row['impuesto2'];
            $Registro->unimed			= 	$row['unimed'];				
            $Registro->id_linearef		= 	$row['id_linearef'];				
            $Registro->rutproveedor		= 	$row['rutproveedor'];				
            $Registro->nomproveedor		= 	$row['nomproveedor'];				
            $Registro->codtipo		    = 	$row['codtipo'];		
            $Registro->codsubtipo		= 	$row['codsubtipo'];		            
            $List->addlast($Registro);

        }
        $res->free();
        return true;            
    }

	public function getdetdocumentoprn($List) {
		$List->gofirst();
        $query = "	SELECT 	id_linea,
                            id_documento,
                            numlinea,
                            descripcion,
                            codprod,
                            barra,
                            pventaneto,
                            pventaiva,
                            cantidad,
							pcosto,
                            totallinea,
                            impuesto1,
                            impuesto2,
                            unimed,
							id_linearef,
							codtipo,
							codsubtipo
                    FROM 	documento_d
                    WHERE 	1 
                            " . (($List->getelem()->id_documento)? " and id_documento = ".$List->getelem()->id_documento." " : "") . "
                    ";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		$List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetdocumento;
            $Registro->id_linea			= 	$row['id_linea'];
            $Registro->id_documento		= 	$row['id_documento'];
            $Registro->numlinea			= 	$row['numlinea'];
            $Registro->descripcion		=	html_entity_decode($row['descripcion']);
			$Registro->codprod			= 	$row['codprod'];
            $Registro->barra			= 	$row['barra'];
            $Registro->pventaneto		= 	$row['pventaneto'];
            $Registro->pventaiva		= 	$row['pventaiva'];
            $Registro->cantidad			= 	$row['cantidad'];
            $Registro->pcosto			= 	$row['pcosto'];
            $Registro->totallinea		= 	$row['totallinea'];
            $Registro->impuesto1		= 	$row['impuesto1'];
            $Registro->impuesto2		= 	$row['impuesto2'];
            $Registro->unimed			= 	$row['unimed'];				
            $Registro->id_linearef		= 	$row['id_linearef'];				
            $Registro->codtipo  		= 	$row['codtipo'];
            $Registro->codsubtipo		= 	$row['codsubtipo'];                        
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
    public function verificafoliofct($List) {
    	$List->gofirst();
        $query= "SELECT 	numdocumento, id_documento, numorigen
				FROM 	documento_e 
				WHERE 	id_tipodocumento = 1 
				" . (($List->getelem()->numdocumento+0)? " and numdocumento = '".($List->getelem()->numdocumento+0)."'" : "") . "
				";
		//RGM. 25-08-2007. El folio es único para TODA la cadena Easy
        /*" . (($List->getelem()->codlocalventa)? " and codlocalventa = '".$List->getelem()->codlocalventa."'" : "") . "                        
        " . (($List->getelem()->id_tipodocumento)? "and id_tipodocumento = '". $List->getelem()->id_tipodocumento."'" : "") . "
		";*/
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodocumento;
            $Registro->numdocumento	= 	$row['numdocumento'];
            $Registro->id_documento	= 	$row['id_documento'];
            $Registro->id_ordenent	= 	$row['numorigen'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
   
        public function verificafoliogde($List) {
    	$List->gofirst();
        $query= "SELECT 	numdocumento, id_documento, numorigen
				FROM 	documento_e 
				WHERE 	id_tipodocumento = 2 
				" . (($List->getelem()->numdocumento+0)? " and numdocumento = '".($List->getelem()->numdocumento+0)."'" : "") . "
				";
		//RGM. 25-08-2007. El folio es único para TODA la cadena Easy
        /*" . (($List->getelem()->codlocalcsum)? " and codlocalcsum = '".$List->getelem()->codlocalcsum."'" : "") . "                        
      	" . (($List->getelem()->id_tipodocumento)? "and id_tipodocumento = '". $List->getelem()->id_tipodocumento."'" : "") . "
		";*/
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodocumento;
            $Registro->numdocumento	= 	$row['numdocumento'];
            $Registro->id_documento	= 	$row['id_documento'];
            $Registro->id_ordenent	= 	$row['numorigen'];            
            $List->addlast($Registro);
        }
        $res->free();
        return true;

    } 
    
   public function saveencdocumento($List) {
    	global $ses_usr_login, $ses_usr_id;
    	$List->gofirst();
    	$i++;
    	if ($List->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
    	}
		
    	if ($List->getelem()->id_documento){
    		//Es un documento antiguo, se hace UPDATE
			if($List->getelem()->sigtipodoc == 'FCT'){
				$estado_doc = 'FG';
			}else{
				$estado_doc = 'GG';
			}
			//general::writelog("ingreso #".$i);
            $query = "	UPDATE documento_e 
                        SET	usrcrea = usrcrea
                        " . (($List->getelem()->id_tipodocumento)? ", id_tipodocumento = ". $List->getelem()->id_tipodocumento : "") . "
                        " . (($List->getelem()->codigovendedor)? ", codigovendedor = '". $List->getelem()->codigovendedor ."'": "") . "
                        " . (($List->getelem()->sigtipodoc)? ", sigtipodoc = '". $List->getelem()->sigtipodoc ."'": "") . "
                        " . (($List->getelem()->pagina)? ", pagina = ". $List->getelem()->pagina : "") . "
                        " . (($List->getelem()->tipoorigen)? ", tipoorigen = '". $List->getelem()->tipoorigen ."'": "") . "
                        " . (($estado_doc)? ", estado = '". $estado_doc ."'": "") . "
                        " . (($List->getelem()->numorigen)? ", numorigen = ". $List->getelem()->numorigen : "") . "
                        " . (($List->getelem()->numdocumento)? ", numdocumento = '". $List->getelem()->numdocumento."'" : "") . "
                        " . (($List->getelem()->numdocref)? ", numdocref = ". $List->getelem()->numdocref : "") . "
                        " . (($List->getelem()->numdocrefop)? ", numdocrefop = ". $List->getelem()->numdocrefop : "") . "
                        " . (($List->getelem()->fechadocumento)? ", fechadocumento = '". $List->getelem()->fechadocumento ."'": "") . "
                        " . (($List->getelem()->rutcliente)? ", rutcliente = ". $List->getelem()->rutcliente : "") . "
                        " . (($List->getelem()->razonsoc)? ", razonsoc = '". addslashes($List->getelem()->razonsoc) . "'" : "") . "
                        " . (($List->getelem()->id_giro)? ", id_giro = '". $List->getelem()->id_giro . "'" : "") . "
                        " . (($List->getelem()->giro)? ", giro = '". addslashes($List->getelem()->giro) . "'" : "") . "
                        " . (($List->getelem()->direccion)? ", direccion = '". addslashes($List->getelem()->direccion) . "'" : "") . "
                        " . (($List->getelem()->comuna)? ", comuna = '". $List->getelem()->comuna . "'" : "") . "
                        " . (($List->getelem()->iva)? ", iva = ". $List->getelem()->iva : "") . "
                        " . (($List->getelem()->totaltexto)? ", totaltexto = '". $List->getelem()->totaltexto . "'" : "") . "
                        " . (($List->getelem()->totalnum)? ", totalnum = ". $List->getelem()->totalnum : "") . "
                        " . (($List->getelem()->totaliva)? ", totaliva = ". $List->getelem()->totaliva : "") . "
                        " . (($List->getelem()->totalnumiva)? ", totalnumiva = ". $List->getelem()->totalnumiva : "") . "
                        " . (($List->getelem()->condicion)? ", condicion = '". $List->getelem()->condicion . "'" : "") . "
                        " . (($List->getelem()->diascondicion)? ", diascondicion = ". $List->getelem()->diascondicion : "") . "
                        " . (($List->getelem()->fonocontacto)? ", fonocontacto = '". $List->getelem()->fonocontacto . "'" : "") . "
                        " . (($List->getelem()->observaciones)? ", observaciones = '". addslashes($List->getelem()->observaciones) . "'" : "") . "
                        " . (($List->getelem()->nota)? ", nota = '". addslashes($List->getelem()->nota) . "'" : "") . "
                        " . (($List->getelem()->indmsgsap)? ", indmsgsap = '". $List->getelem()->indmsgsap . "'" : "") . "
                        " . (($List->getelem()->codlocalventa)? ", codlocalventa = '". $List->getelem()->codlocalventa . "'" : "") . "
                        " . (($List->getelem()->codlocalcsum)? ", codlocalcsum = '". $List->getelem()->codlocalcsum . "'" : "") . "
                        " . (($List->getelem()->usrmod)? ", usrmod = '". $List->getelem()->usrmod . "'" : ", usrmod = '".$ses_usr_login."'") . "   
                        , fecmod = now()
                        " . (($List->getelem()->mediopago)?",mediopago = ".$List->getelem()->mediopago:",mediopago=mediopago")."
                        
                        WHERE id_documento = ".$List->getelem()->id_documento ;
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
				
            return true;
    	}
    	else {
	    	//Es una cotización nueva, se hace INSERT
			if($List->getelem()->sigtipodoc == 'FCT'){
				$estado_doc = 'FG';
			}else{
				$estado_doc = 'GG';
			}
			//general::writelog("Inserto 1");
            $query = "	INSERT INTO documento_e (	
							id_documento,
							id_tipodocumento,
							codigovendedor, 
							id_tipoorigen,
							estado,
							sigtipodoc,
							pagina,
							tipoorigen,
							numorigen,
							numdocumento,
							numdocref,
							numdocrefop,
							fechadocumento,
							rutcliente,
							razonsoc,
							id_giro, 
							giro,
							direccion,
							comuna,
							iva,
							totaltexto,
							totalnum,
							totaliva,
							totalnumiva,
							condicion,
							diascondicion,
							fonocontacto,
							observaciones,
							nota,
							codlocalventa,
							codlocalcsum,
							indmsgsap, 
							usrcrea,
							feccrea,
							usrmod,
							fecmod,
							mediopago
                        )
                        VALUES (
                            null,
                            ".($List->getelem()->id_tipodocumento+0).",
                            '".$List->getelem()->codigovendedor."',
                            ".(($List->getelem()->id_tipoorigen)?$List->getelem()->id_tipoorigen:"1").",
                            '".$estado_doc."',
							'".$List->getelem()->sigtipodoc."',
                            ".($List->getelem()->pagina+0).",
                            '".$List->getelem()->tipoorigen."',
                            ".($List->getelem()->numorigen+0).",
                            '".($List->getelem()->numdocumento+0)."',
                            ".($List->getelem()->numdocref+0).",
                            ".($List->getelem()->numdocrefop+0).",
                            ".(($List->getelem()->fechadocumento)?"'".$List->getelem()->fechadocumento."'":"null").",
                            ".($List->getelem()->rutcliente+0).",
                            '".addslashes($List->getelem()->razonsoc)."',
                            '".$List->getelem()->id_giro."',
                            '".addslashes($List->getelem()->giro)."',
                            '".addslashes($List->getelem()->direccion)."',
                            '".$List->getelem()->comuna."',
                            ".($List->getelem()->iva+0).",
                            '".$List->getelem()->totaltexto."',
                            ".($List->getelem()->totalnum+0).",
                            ".($List->getelem()->totaliva+0).",
                            ".($List->getelem()->totalnumiva+0).",
                            '".$List->getelem()->condicion."',
                            ".($List->getelem()->diascondicion+0).",
                            '".$List->getelem()->fonocontacto."',
                            '".addslashes($List->getelem()->observaciones)."',
                            '".addslashes($List->getelem()->nota)."',
                            '".$List->getelem()->codlocalventa."',
                            '".$List->getelem()->codlocalcsum."',
							0, 
                            '".(($List->getelem()->usrcrea)?$List->getelem()->usrcrea:$ses_usr_login)."',
                            now(),
                            '".(($List->getelem()->usrmod)?$List->getelem()->usrmod:$ses_usr_login)."',
                            now(),
                            ".(($List->getelem()->mediopago)?$List->getelem()->mediopago:"0")."
                        )";
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

            $List->getelem()->id_documento = $this->bd->last_insert_id();
            return true;
    	}
    }
	public function saveencdocumentosap($List) {
    	
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
    	}
		/****** busco giro*******/
		$ctrlcom = new ctrltipos();
		$ctrlcom->getgiro($listagiro = new connlist(new dtotipo(array('id'=>$List->getelem()->id_giro))));
		$listagiro->gofirst();
				
		if(!$listagiro->numelem()){
			$ctrlcom->setgiro($listag =  new connlist(new dtotipos(array('id'=>$List->getelem()->id_giro,
																		 'nombre'=>$List->getelem()->giro,
																		 'usrcrea'=>$List->getelem()->usrcrea,
																		 'usrmod'=>$List->getelem()->usrcrea
																		 ))));
		}
    	if ($List->getelem()->id_documento){
    		
    		//Es un documento antiguo, se hace UPDATE
            $query = "	UPDATE documento_e 
                        SET	usrcrea = usrcrea
                        " . (($List->getelem()->id_tipodocumento)? ", id_tipodocumento = ". $List->getelem()->id_tipodocumento : "") . "
                        " . (($List->getelem()->codigovendedor)? ", codigovendedor = '". $List->getelem()->codigovendedor ."'": "") . "
                        " . (($List->getelem()->sigtipodoc)? ", sigtipodoc = '". $List->getelem()->sigtipodoc ."'": "") . "
                        " . (($List->getelem()->pagina)? ", pagina = ". $List->getelem()->pagina : "") . "
                        " . (($List->getelem()->tipoorigen)? ", tipoorigen = '". $List->getelem()->tipoorigen ."'": "") . "
                        " . (($List->getelem()->numorigen)? ", numorigen = ". $List->getelem()->numorigen : "") . "
                        " . (($List->getelem()->numdocumento)? ", numdocumento = '". $List->getelem()->numdocumento."'" : "") . "
                        " . (($List->getelem()->numdocref)? ", numdocref = ". $List->getelem()->numdocref : "") . "
                        " . (($List->getelem()->numdocrefop)? ", numdocrefop = ". $List->getelem()->numdocrefop : "") . "
                        " . (($List->getelem()->fechadocumento)? ", fechadocumento = '". $List->getelem()->fechadocumento ."'": "") . "
                        " . (($List->getelem()->rutcliente)? ", rutcliente = ". $List->getelem()->rutcliente : "") . "
                        " . (($List->getelem()->razonsoc)? ", razonsoc = '". addslashes($List->getelem()->razonsoc) . "'" : "") . "
                        " . (($List->getelem()->id_giro)? ", id_giro = '". $List->getelem()->id_giro . "'" : "") . "
                        " . (($List->getelem()->giro)? ", giro = '". addslashes($List->getelem()->giro) . "'" : "") . "
                        " . (($List->getelem()->direccion)? ", direccion = '". addslashes($List->getelem()->direccion) . "'" : "") . "
                        " . (($List->getelem()->comuna)? ", comuna = '". $List->getelem()->comuna . "'" : "") . "
                        " . (($List->getelem()->iva)? ", iva = ". $List->getelem()->iva : "") . "
                        " . (($List->getelem()->totaltexto)? ", totaltexto = '". $List->getelem()->totaltexto . "'" : "") . "
                        " . (($List->getelem()->totalnum)? ", totalnum = ". $List->getelem()->totalnum : "") . "
                        " . (($List->getelem()->totaliva)? ", totaliva = ". $List->getelem()->totaliva : "") . "
                        " . (($List->getelem()->totalnumiva)? ", totalnumiva = ". $List->getelem()->totalnumiva : "") . "
                        " . (($List->getelem()->condicion)? ", condicion = '". $List->getelem()->condicion . "'" : "") . "
                        " . (($List->getelem()->diascondicion)? ", diascondicion = ". $List->getelem()->diascondicion : "") . "
                        " . (($List->getelem()->fonocontacto)? ", fonocontacto = '". $List->getelem()->fonocontacto . "'" : "") . "
                        " . (($List->getelem()->observaciones)? ", observaciones = '". addslashes($List->getelem()->observaciones) . "'" : "") . "
                        " . (($List->getelem()->nota)? ", nota = '". addslashes($List->getelem()->nota) . "'" : "") . "
                        " . (($List->getelem()->indmsgsap)? ", indmsgsap = '". $List->getelem()->indmsgsap . "'" : "") . "
                        " . (($List->getelem()->codlocalventa)? ", codlocalventa = '". $List->getelem()->codlocalventa . "'" : "") . "
                        " . (($List->getelem()->codlocalcsum)? ", codlocalcsum = '". $List->getelem()->codlocalcsum . "'" : "") . "
                        " . (($List->getelem()->usrmod)? ", usrmod = '". $List->getelem()->usrmod . "'" : "") . "   
                        , fecmod = now()
                        WHERE id_documento = ".$List->getelem()->id_documento ;
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
				
            return true;
    	}
    	else {
	    	//Es una cotización nueva, se hace INSERT
            $query = "	INSERT INTO documento_e (	
							id_documento,
							id_tipodocumento,
							codigovendedor, 
							id_tipoorigen, 
							sigtipodoc,
							pagina,
							tipoorigen,
							numorigen,
							numdocumento,
							numdocref,
							numdocrefop,
							rutcliente,
							razonsoc,
							id_giro, 
							giro,
							direccion,
							comuna,
							iva,
							totaltexto,
							totalnum,
							totaliva,
							totalnumiva,
							condicion,
							diascondicion,
							fonocontacto,
							observaciones,
							nota,
							codlocalventa,
							codlocalcsum,
							indmsgsap, 
							usrcrea,
							feccrea,
							usrmod,
							fecmod
                        )
                        VALUES (
                            null,
                            ".($List->getelem()->id_tipodocumento+0).",
                            '".$List->getelem()->codigovendedor."',
                            ".(($List->getelem()->id_tipoorigen)?$List->getelem()->id_tipoorigen:"1").",
                            '".$List->getelem()->sigtipodoc."',
                            ".($List->getelem()->pagina+0).",
                            '".$List->getelem()->tipoorigen."',
                            ".($List->getelem()->numorigen+0).",
                            '".($List->getelem()->numdocumento+0)."',
                            ".($List->getelem()->numdocref+0).",
                            ".($List->getelem()->numdocrefop+0).",
                            ".($List->getelem()->rutcliente+0).",
                            '".addslashes($List->getelem()->razonsoc)."',
                            '".$List->getelem()->id_giro."',
                            '".addslashes($List->getelem()->giro)."',
                            '".addslashes($List->getelem()->direccion)."',
                            '".$List->getelem()->comuna."',
                            ".($List->getelem()->iva+0).",
                            '".$List->getelem()->totaltexto."',
                            ".($List->getelem()->totalnum+0).",
                            ".($List->getelem()->totaliva+0).",
                            ".($List->getelem()->totalnumiva+0).",
                            '".$List->getelem()->condicion."',
                            ".($List->getelem()->diascondicion+0).",
                            '".$List->getelem()->fonocontacto."',
                            '".addslashes($List->getelem()->observaciones)."',
                            '".addslashes($List->getelem()->nota)."',
                            '".$List->getelem()->codlocalventa."',
                            '".$List->getelem()->codlocalcsum."',
							0, 
                            '".(($List->getelem()->usrcrea)?$List->getelem()->usrcrea:"")."',
                            now(),
                            '".(($List->getelem()->usrmod)?$List->getelem()->usrmod:"")."',
                            now()
                        )";
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

            $List->getelem()->id_documento = $this->bd->last_insert_id();
            return true;
    	}
    }
    public function savedetdocumento($ListEnc, $ListDet) {
    	global $ses_usr_login;
    	$ListEnc->gofirst();
    	if ($ListEnc->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
    	}
		if (!$ListEnc->getelem()->id_documento){
            throw new CTRLException("No viene Id de Documento", 0);
    	}
    	
    	if (!$ListDet)
    		return true;
		$sumalinea = 0; 
    	$counterline = 1;
    	$ListDet->gofirst();
		if ($ListDet->numelem()) {
			do {
				if (!$ListDet->getelem())
					continue;
				//Insertamos los registros de detalle
                $query = "	INSERT INTO documento_d (	
								id_linea,
								id_documento,
								numlinea,
								descripcion,
								codprod,
								barra,
								pcosto,
								pventaneto,
								pventaiva,
								cantidad,
								totallinea,
								impuesto1,
								impuesto2,
								unimed,
								id_linearef, 
								usrcrea,
								feccrea,
								usrmod,
								fecmod,
								rutproveedor,
								codtipo,
								codsubtipo,
								iva
                            )
                            VALUES (
                                null,
                                ".$ListEnc->getelem()->id_documento.",
								".(($ListDet->getelem()->numlinea)?$ListDet->getelem()->numlinea:$counterline).", 
                                '".addslashes($ListDet->getelem()->descripcion)."',
                                ".($ListDet->getelem()->codprod+0).",
                                '".($ListDet->getelem()->barra)."',
                                ".($ListDet->getelem()->pcosto+0).",
                                ".($ListDet->getelem()->pventaneto+0).",
                                ".($ListDet->getelem()->pventaiva+0).",
                                ".($ListDet->getelem()->cantidad+0).",
                                ".(round($ListDet->getelem()->cantidad * $ListDet->getelem()->pventaneto)+0).",
                                ".($ListDet->getelem()->impuesto1+0).",
                                ".($ListDet->getelem()->impuesto2+0).",
                                '".$ListDet->getelem()->unimed."',
                                ".($ListDet->getelem()->id_linearef+0).",
	                            '".(($ListDet->getelem()->usrcrea)?$ListDet->getelem()->usrcrea:$ses_usr_login)."',
	                            now(),
	                            '".(($ListDet->getelem()->usrmod)?$ListDet->getelem()->usrmod:$ses_usr_login)."',
                                now(),
                                ".(($ListDet->getelem()->rutproveedor)?$ListDet->getelem()->rutproveedor:'0').",
                                '".$ListDet->getelem()->codtipo."',
                                '".$ListDet->getelem()->codsubtipo."',
                                '".$ListDet->getelem()->iva."'
                            )";
                $res = $this->bd->querynoselect($query);
                if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
                $counterline++;
                $sumalinea += round($ListDet->getelem()->cantidad * $ListDet->getelem()->pventaneto);
			} while ($ListDet->gonext());
		}
		return $sumalinea;
    }

    public function deldetdocumento($ListEnc) {
    	$ListEnc->gofirst();
    	if ($ListEnc->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
    	}
		if (!$ListEnc->getelem()->id_documento){
            throw new CTRLException("No viene Id de Documento", 0);
    	}
    	
    	$ListEnc->gofirst();
		//Eliminamos el detalle de documento
        $query = "	DELETE FROM documento_d WHERE id_documento = " . $ListEnc->getelem()->id_documento;
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
    }

    public function deldocumento($ListEnc) {
    	$ListEnc->gofirst();
    	if ($ListEnc->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
    	}
		if (!$ListEnc->getelem()->id_documento){
            throw new CTRLException("No viene Id de Documento", 0);
    	}
    	
    	$ListEnc->gofirst();
		//Eliminamos el documento
        $query = "	DELETE FROM documento_e WHERE id_documento = " . $ListEnc->getelem()->id_documento;
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
    }

    public function marcardocimpreso($ListDoc){
    	global $ses_usr_login;
    	
    	$ListDoc->gofirst();
    	if ($ListDoc->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
    	}
		if (!$ListDoc->getelem()->id_documento){
            throw new CTRLException("No viene Id de Documento", 0);
    	}
    	
		//Insertamos los registros de detalle
        $query = "	UPDATE documento_e
					SET   lockprintfct = 1
						, lockprintgde = 1
                        , usrmod = '".$ses_usr_login."'  
                        , fecmod = now()
                    WHERE id_documento = ".$ListDoc->getelem()->id_documento ;
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
		return true;
    }
    
	public function marcatodosdocimpreso($ListDoc){
    	global $ses_usr_login;
    	
    	$ListDoc->gofirst();
    	if ($ListDoc->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
    	}
		if (!$ListDoc->getelem()->id_documento){
            throw new CTRLException("No viene Id de Documento", 0);
    	}
    	
		//Insertamos los registros de detalle
        $query = "	UPDATE documento_e
					SET   lockprintfct = 1
						, lockprintgde = 1
                        , usrmod = '".$ses_usr_login."'  
                        , fecmod = now()
                    WHERE id_documento in(".$ListDoc->getelem()->id_documento.")" ;
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
		return true;
    }
    
    /*Marca numero de Reimpresiones Guia de Despacho*/
	public function marcareimpresion($sum, $docu){
    	global $ses_usr_login;
    	
		//Insertamos los registros de detalle
        $query = "	UPDATE documento_e
					SET   
                        nreimpresion = '".$sum."'  
                 
                    WHERE id_documento = ".$docu ;
        $res = $this->bd->querynoselect($query);
        //general::writeevent('paso docu',$docu);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
		return true;
    }
    /*Fin Marca numero de Reimpresiones Guia de Despacho*/

	public function anuladoc($ListDoc){
	global $ses_usr_login;
	$ListDoc->gofirst();
	if ($ListDoc->numelem()!=1){
		throw new CTRLException("Numero incorrecto de elementos", 0);
	}
	if (!$ListDoc->getelem()->numdocumento){
		throw new CTRLException("No viene Id de Documento", 0);
	}
	
	//Insertamos los registros de detalle
	if($ListDoc->getelem()->sigtipodoc == 'FCT'){
		$tiponulo = 'FN';
	}else{
		$tiponulo = 'GN';
	}
	$query = "	UPDATE documento_e
				SET   estado = '".$tiponulo."'
					, usrmod = '".$ses_usr_login."'  
					, fecmod = now()
				WHERE numdocumento = '".$ListDoc->getelem()->numdocumento ."' " .
				(($ListDoc->getelem()->id_documento)? "AND id_documento = ". $ListDoc->getelem()->id_documento : "");
				
	$res = $this->bd->querynoselect($query);
	if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
	
	return true;
}

    public function desbloqueadocprint($ListDoc){
    	global $ses_usr_login;
    	
    	$ListDoc->gofirst();
    	if ($ListDoc->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
    	}
		if (!$ListDoc->getelem()->numorigen){
            throw new CTRLException("No viene Número de OE", 0);
    	}
		if (!$ListDoc->getelem()->id_tipodocumento){
            throw new CTRLException("No viene Tipo de documento", 0);
    	}
		if (!$ListDoc->getelem()->codlocalcsum){
            throw new CTRLException("No viene el código de local", 0);
    	}

    	if ($ListDoc->getelem()->id_tipodocumento == 1)
    		$tipodoc = "lockprintfct";
    	if ($ListDoc->getelem()->id_tipodocumento == 2)
    		$tipodoc = "lockprintgde";

        $query = "	SELECT 	count(*) cuenta 
                    FROM 	documento_e 
					WHERE 	numorigen = ".$ListDoc->getelem()->numorigen."
						AND id_tipodocumento = ".$ListDoc->getelem()->id_tipodocumento."
						". (($ListDoc->getelem()->pagina)?" AND pagina = ".$ListDoc->getelem()->pagina :"") ."
						AND codlocalcsum = '".$ListDoc->getelem()->codlocalcsum."'";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        if ($row = $res->fetch_assoc()) {
        	if (!$row['cuenta']) {
        		return false;
        	}
        }
        else {
        	return false;
        }
    		
		//Insertamos los registros de detalle
        $query = "	UPDATE 	documento_e
					SET   	$tipodoc = 0, 
                        	usrmod = '".$ses_usr_login."', 
                        	fecmod = now()
					WHERE 	numorigen = ".$ListDoc->getelem()->numorigen."
						AND id_tipodocumento = ".$ListDoc->getelem()->id_tipodocumento."
						". (($ListDoc->getelem()->pagina)?" AND pagina = ".$ListDoc->getelem()->pagina :"") ."
						AND codlocalcsum = '".$ListDoc->getelem()->codlocalcsum."'";
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
		return true;
    }
    
    public function getpaginadoc($ListDoc, $tipodocumento_idtipodoc) {
    	$ListDoc->gofirst();
    	if ($ListDoc->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
    	}
		if (!$ListDoc->getelem()->id_ordenent){
            throw new CTRLException("No viene id de orden de entrega", 0);
    	}
		if (!$tipodocumento_idtipodoc){
            throw new CTRLException("No viene id de tipo de documento", 0);
    	}
    	
    	$query = "	SELECT 	max(pagina) maximo 
                    FROM 	documento_e 
					WHERE 	numorigen = ".$ListDoc->getelem()->id_ordenent."
						AND id_tipodocumento = ".$tipodocumento_idtipodoc;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        if ($row = $res->fetch_assoc()) 
        		return $row['maximo'];
        else 
        	return 0;
    }
    
	public function incrementafct($List){
    	
    	$List->gofirst();

		//Cambio de folio
        $query = "	UPDATE locales
					SET   foliofct = foliofct+1
                    WHERE cod_local = ('".$List->getelem()->cod_local."')" ;
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
    }
    
	public function incrementagde($List){
    	
    	$List->gofirst();

		//Cambio de folio
        $query = "	UPDATE locales
					SET   foliogde = foliogde+1
                    WHERE cod_local = ('".$List->getelem()->cod_local."')" ;
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
    }

	public function limpiatabla($List){
    	$List->gofirst();

		//Limpieza de tabla rubros
        $query = "	DELETE FROM subrubros" ;
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
    }

    public function putnivel4($List){
		$List->gofirst();
		$query="INSERT INTO subrubros (
										id_catprod_4,
										descat_4,
										id_catpadre_4,
										id)
				VALUES (
				'".$List->getelem()->catprod."',
				'".$List->getelem()->descat."',
				'".$List->getelem()->catpadre."',
				null
				)";
		$res = $this->bd->querynoselect($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
    }

    public function putnivel3($List){
		$List->gofirst();
		$query="INSERT INTO subrubros (
										id_catprod_3,
										descat_3,
										id_catpadre_3,
										id)
				VALUES (
				'".$List->getelem()->catprod."',
				'".html_entity_decode($List->getelem()->descat)."',
				'".$List->getelem()->catpadre."',
				null
                )";
		$res = $this->bd->querynoselect($query);
		//general::writeevent($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
    }

    public function putnivel2($List){
		$List->gofirst();
		$query="INSERT INTO subrubros (
										id_catprod_2,
										descat_2,
										id_catpadre_2,
										id)
				VALUES (
				'".$List->getelem()->catprod."',
				'".html_entity_decode($List->getelem()->descat)."',
				'".$List->getelem()->catpadre."',
				null
                )";
		$res = $this->bd->querynoselect($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
    }

    public function putnivel1($List){
		$List->gofirst();
		$query="INSERT INTO subrubros (
										id_catprod_1,
										descat_1,
										id)
				VALUES (
				'".$List->getelem()->catprod."',
				'".html_entity_decode($List->getelem()->descat)."',
				null
                )";
		$res = $this->bd->querynoselect($query);
		if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		return true;
    }

    public function getpadre3($List){
		$List->gofirst();
		$query="SELECT sr.id_catpadre_3 as catpadre
				FROM
					   subrubros sr
				WHERE 1
				AND sr.id_catpadre_3 > 0
				";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoproducto;
            $Registro->catpadre		= $row['catpadre'];
            $List ->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function getpadre2($List){
		$List->gofirst();
		$query="SELECT sr.id_catpadre_2 as catpadre
				FROM
					   subrubros sr
				WHERE 1
				AND sr.id_catpadre_2 > 0
				";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoproducto;
            $Registro->catpadre		= $row['catpadre'];
            $List ->addlast($Registro);
        }
        $res->free();
        return true;
    }

	public function getdocumentonulosap($List){
		
			$query = "SELECT  id_documento,numdocumento,
								id_tipodocumento,
								numorigen,
								fechadocumento,
								codlocalventa
						FROM documento_e
						where id_tipodocumento in (1,2)
						and estado in ('fn','gn') and indnullsap = 0";



        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		$List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodocumento;
			$Registro->id_documento  	= 	$row['id_documento'];
			$Registro->numdocumento  	= 	$row['numdocumento'];
            $Registro->id_tipodocumento	= 	$row['id_tipodocumento'];
            $Registro->numorigen		= 	$row['numorigen'];
            $Registro->fechadocumento	= 	$row['fechadocumento'];
            $Registro->codlocalventa	=	$row['codlocalventa'];
                     
            $List->addlast($Registro);
        }
        $res->free();
        return true;
	}
    
		
	public function cambioindicadorsapnull($List) {
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
    	}
		
    	if ($List->getelem()->id_documento){
    		
            $query = "	UPDATE documento_e 
                        SET	usrcrea = usrcrea
                        " . (($List->getelem()->indnullsap!==null)? ", indnullsap = ". $List->getelem()->indnullsap : "") . "
                        " . (($List->getelem()->usrmod)? ", usrmod = '". $List->getelem()->usrmod."'" : "") . "
                        , fecmod = now()
                        WHERE id_documento in ( ".$List->getelem()->id_documento.")" ;
			
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            return true;
    	}

    }
    	
}
?>
