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
							numdocumento 
                    FROM 	documento_e 
                    WHERE 	1 
                            " . (($List->getelem()->id_documento)? " and id_documento in (".$List->getelem()->id_documento.")" : "") . "
                            " . (($List->getelem()->id_tipodocumento)? " and id_tipodocumento = ".$List->getelem()->id_tipodocumento." " : "") . "
                            " . (($List->getelem()->id_tipoorigen)? " and id_tipoorigen = ".$List->getelem()->id_tipoorigen." " : "") . "
                            " . (($List->getelem()->sigtipodoc)? " and sigtipodoc = '".$List->getelem()->sigtipodoc."' " : "") . "
                            " . (($List->getelem()->numdocumento)? " and numdocumento = ".$List->getelem()->numdocumento." " : "") . "
                            " . (($List->getelem()->numorigen!==null)? " and numorigen = ".$List->getelem()->numorigen." " : "") . "
                            " . (($List->getelem()->numdocrefop)? " and numdocrefop = ".$List->getelem()->numdocrefop." " : "") . "
                            " . (($List->getelem()->numdocref)? " and numdocref = ".$List->getelem()->numdocref." " : "") . "
                            " . (($List->getelem()->indmsgsap!==null)? " and indmsgsap = ".$List->getelem()->indmsgsap." " : "") . "
                            " . (($List->getelem()->tipoorigen)? " and tipoorigen = '".$List->getelem()->tipoorigen."'" : "") . "
                            " . (($List->getelem()->codlocalcsum)? " and codlocalcsum = '".$List->getelem()->codlocalcsum."'" : "") . "
                   	ORDER BY
							id_documento";
        //general::writeevent('consulta documento encabezado'.$query);
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
			$Registro->numfolio_gde		= 	$row['numdocumento'];
			$Registro->numfolio_fct		= 	$row['numdocumento'];
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
							doc.codigovendedor		codigovendedor,
                            doc.rutcliente			rutcliente,
                            doc.razonsoc			razonsoc,
                            doc.giro				giro,
                            doc.direccion			direccion,
                            doc.comuna				comuna	,
                            doc.iva					iva,
                            totaltexto,
                            totalnum,
                            totaliva,
                            totalnumiva,
                            doc.condicion			condicion,
                            doc.diascondicion		diascondicion,
                            doc.fonocontacto		fonocontacto,
                            doc.observaciones		observaciones,
                            doc.nota				nota,
                            doc.codlocalventa		codlocalventa,
                            doc.codlocalcsum		codlocalcsum,
							lockprintgde,
							lockprintfct,
							doc.indmsgsap			indmsgsap,
							doc.feccrea				feccrea,
              				od.id_tipodocpago 		id_tipodocpago
                    FROM documento_e doc
                    join ordenent_e od on  od.id_ordenent = doc.numorigen
	 				WHERE 	1
                            " . (($List->getelem()->id_documento)? " and id_documento in (".$List->getelem()->id_documento.")" : "") . "
                            " . (($List->getelem()->id_tipodocumento)? " and id_tipodocumento = ".$List->getelem()->id_tipodocumento." " : "") . "
                            " . (($List->getelem()->id_tipoorigen)? " and id_tipoorigen = ".$List->getelem()->id_tipoorigen." " : "") . "
                            " . (($List->getelem()->sigtipodoc)? " and sigtipodoc = '".$List->getelem()->sigtipodoc."' " : "") . "
                            " . (($List->getelem()->numdocumento <> 0 )? " and numdocumento <> 0 " : "") . "
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
            $Registro->mediopago		=	$row['id_tipodocpago'];
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
							codsubtipo,
							marcaflete
                    FROM 	documento_d
                    WHERE 	1 
                            " . (($List->getelem()->id_documento)? " and id_documento = ".$List->getelem()->id_documento." " : "") . "
                    ";
        //general::writeevent($query);
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
            $Registro->marcaflete		= 	$row['marcaflete'];
            $Registro->numordenpicking	= 	$row['marcaflete'];				            
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
							codsubtipo,
 							marcaflete
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
            $Registro->marcaflete		= 	$row['marcaflete'];            
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
    	if ($List->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
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
                        " . (($List->getelem()->numdocumento)? ", numdocumento = ". $List->getelem()->numdocumento : "") . "
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
                            ".($List->getelem()->numdocumento+0).",
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
                            now()
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
                        " . (($List->getelem()->numdocumento)? ", numdocumento = ". $List->getelem()->numdocumento : "") . "
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
                            ".($List->getelem()->numdocumento+0).",
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
								marcaflete
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
                                ".($ListDet->getelem()->marcaflete+0)."
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
    	
}
?>
