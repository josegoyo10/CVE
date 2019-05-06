<?
class daocotizacion{
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

    public function getenccotizacion($List) {
    	global $ses_usr_id;
    	$confimp = new getidcontribuyente("CONTRIBUYENTE");
		$opcion=$confimp->JURIDICO;
		$opcion1=$confimp->EMPRESARIAL;
		$opcion2=$confimp->SOCIOE;
    	$tipoUsuariocol = bizcve::getTipoUsuarioCotiza($ses_usr_id);
    	(($tipoUsuariocol == 2 || $tipoUsuariocol == 3)? $usuariosistema=$opcion1 : $usuariosistema=$opcion);
		$Lista = $List;
    	$List->gofirst();
        $query = "	SELECT id_cotizacion,
                            ce.id_estado,
                            e.descripcion as nomestado,
                            ce.id_tipoventa,
                            tv.descripcion as nomtipoventa,
                            ce.codigovendedor,
                            rutcliente,
                            ce.codlocalventa,
                            l.nom_local,
                            l.dir_local,
                            l2.dir_local dir_localcsum,
                            codlocalcsum,
                            l2.nom_local nom_localcsum,
                            ce.razonsoc,
                            ce.id_giro,
                            f.descripcion as giro,
                            ce.direccion,
                            comuna,
                            iva,
                            validdesde,
                            validhasta,
                            validdias,
                            nvevaliddesde,
                            nvevalidhasta,
                            nvevaliddias,
                            condicion,
                            ce.diascondicion,
                            ce.fonocontacto,
                            observaciones, 
                            nota, 
                            id_usuario, 
                            usuariocrea, 
                            valortotal, 
                            margentotal, 
                            obsdesb,
							ce.feccrea,
							ce.rete_ica,
							ce.rete_iva,
							ce.rete_renta,
							ce.cot_iva,
							ce.id_dirdespacho,
							ce.zona,
              upper(ciu.descripcion) as ciudad,
              dir.contacto,
              dir.comentario as comentariodir,
              cli.id_contribuyente
                    FROM 	cotizacion_e ce
                    LEFT JOIN   cliente cli on (cli.rut=ce.rutcliente)
                    LEFT JOIN 	estado e on (e.id_estado=ce.id_estado)
                    LEFT JOIN   tipogiro f on f.id_giro = ce.id_giro
                    LEFT JOIN 	tipoventa tv on (tv.id_tipoventa=ce.id_tipoventa)
                    LEFT JOIN 	locales l on (l.cod_local=ce.codlocalventa)
                    LEFT JOIN 	locales l2 on (l2.cod_local=ce.codlocalcsum)
                    LEFT JOIN   direccion dir on (ce.rutcliente=dir.rut and ce.direccion=dir.direccion)
                    LEFT JOIN   comuna comu on (dir.id_comuna=comu.id_comuna)
                    LEFT JOIN   ciudad ciu on (comu.id_ciudad=ciu.id_ciudad)
                    WHERE 	1 
                    " . (($List->getelem()->id_cotizacion)? " and id_cotizacion = ".$List->getelem()->id_cotizacion." " : "") . "
                    " . (($List->getelem()->rutcliente)? " and rutcliente = ".$List->getelem()->rutcliente." " : "") . "
                    " . (($List->getelem()->razonsoc)? " and ce.razonsoc like '%".addslashes($List->getelem()->razonsoc)."%'" : "") . "
                    " . (($List->getelem()->id_tipoventa)? " and ce.id_tipoventa = ".$List->getelem()->id_tipoventa." " : "") . "
                    " . (($List->getelem()->codlocalcsum)? " and codlocalcsum = '".$List->getelem()->codlocalcsum."' " : "") . "
                    " . (($List->getelem()->fechaucofini)? " and ce.feccrea >= '".$List->getelem()->fechaucofini."'" : "") . "
                    " . (($List->getelem()->fechaucoffin)? " and ce.feccrea <= '".$List->getelem()->fechaucoffin."'" : "") . "
                    " . (($List->getelem()->id_estado)? " and ce.id_estado = '".$List->getelem()->id_estado."' " : "") . "
                    " . (($List->getelem()->codigovendedor!==null)? " and cli.codigovendedor = '".$List->getelem()->codigovendedor."'" : "") . "
                    " . (($List->getelem()->orderby)? " ORDER BY ".$List->getelem()->orderby : "ORDER BY 1 DESC") . "
                    " . (($List->getelem()->limite)? " LIMIT ".$List->getelem()->limite : "") . "
                    ";
/*        
        $query1 = "	SELECT COUNT(*) cont
                    FROM 	cotizacion_e ce
                    LEFT JOIN 	estado e on (e.id_estado=ce.id_estado)
                    LEFT JOIN 	tipoventa tv on (tv.id_tipoventa=ce.id_tipoventa)
                    LEFT JOIN 	locales l on (l.cod_local=ce.codlocalventa)
                    LEFT JOIN 	locales l2 on (l2.cod_local=ce.codlocalcsum)
                    WHERE 	1 
                    " . (($List->getelem()->id_cotizacion)? " and id_cotizacion = ".$List->getelem()->id_cotizacion." " : "") . "
                    " . (($List->getelem()->rutcliente)? " and rutcliente = ".$List->getelem()->rutcliente." " : "") . "
                    " . (($List->getelem()->razonsoc)? " and razonsoc like '%".addslashes($List->getelem()->razonsoc)."%'" : "") . "
                    " . (($List->getelem()->id_tipoventa)? " and ce.id_tipoventa = ".$List->getelem()->id_tipoventa." " : "") . "
                    " . (($List->getelem()->codlocalcsum)? " and codlocalcsum = '".$List->getelem()->codlocalcsum."' " : "") . "
                    " . (($List->getelem()->fechaucofini)? " and ce.feccrea >= '".$List->getelem()->fechaucofini."'" : "") . "
                    " . (($List->getelem()->fechaucoffin)? " and ce.feccrea <= '".$List->getelem()->fechaucoffin."'" : "") . "
                    " . (($List->getelem()->id_estado)? " and ce.id_estado = '".$List->getelem()->id_estado."' " : "") . "
                    " . (($List->getelem()->codigovendedor!==null)? " and codigovendedor = '".$List->getelem()->codigovendedor."'" : "") . "
                    ";

        $res1 = $this->bd->query($query1);
        if (!$res1) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query1, 1);
        $row1 = $res1->fetch_assoc();
        $total_coti		= 	$row1['cont'];*/
        $total_coti             =       $List->getelem()->limite;
        //general::writeevent($query);
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Cotizacion = new dtocotizacion;
            $Cotizacion->id_cotizacion  = 	$row['id_cotizacion'];
            $Cotizacion->id_estado		= 	$row['id_estado'];				
            $Cotizacion->nomestado		= 	$row['nomestado'];					
            $Cotizacion->id_tipoventa	= 	$row['id_tipoventa'];	
            $Cotizacion->nomtipoventa	= 	$row['nomtipoventa'];
            $Cotizacion->codigovendedor	= 	$row['codigovendedor'];	
            $Cotizacion->rutcliente		= 	$row['rutcliente'];	
            $Cotizacion->codlocalventa	= 	$row['codlocalventa'];
            $Cotizacion->nom_local		= 	$row['nom_local'];
            $Cotizacion->dir_local		= 	$row['dir_local'];				
            $Cotizacion->dir_localcsum	= 	$row['dir_localcsum'];				
            $Cotizacion->codlocalcsum	= 	$row['codlocalcsum'];	
            $Cotizacion->nom_localcsum	= 	$row['nom_localcsum'];
            //$Cotizacion->nom_localcsum	= 	$row['id_contribuyente'];	
            $Cotizacion->razonsoc		= 	$row['razonsoc'];											
            $Cotizacion->id_giro		= 	$row['id_giro'];	
            $Cotizacion->giro			= 	$row['giro'];	
            $Cotizacion->direccion		= 	$row['direccion'];	
            $Cotizacion->comuna			= 	$row['comuna'];	
            $Cotizacion->iva			= 	$row['iva'];
            $Cotizacion->validdesde		= 	$row['validdesde'];
            $Cotizacion->validhasta		= 	$row['validhasta'];			
            $Cotizacion->validdias		= 	$row['validdias'];	
            $Cotizacion->nvevaliddesde	= 	$row['nvevaliddesde'];
            $Cotizacion->nvevalidhasta	= 	$row['nvevalidhasta'];			
            $Cotizacion->nvevaliddias	= 	$row['nvevaliddias'];	
            $Cotizacion->diascondicion	= 	$row['diascondicion'];	
            $Cotizacion->condicion		= 	$row['condicion'];					
            $Cotizacion->fonocontacto	= 	$row['fonocontacto'];								
            $Cotizacion->nota			= 	$row['nota'];
            $Cotizacion->id_usuario		= 	$row['id_usuario'];
            $Cotizacion->usuariocrea	= 	$row['usuariocrea'];
            $Cotizacion->valortotal		= 	$row['valortotal'];
            $Cotizacion->margentotal	= 	$row['margentotal'];
            $Cotizacion->obsdesb		= 	$row['obsdesb'];
            $Cotizacion->observaciones	= 	$row['observaciones'];   
            $Cotizacion->feccrea		= 	$row['feccrea'];
            $Cotizacion->rete_ica		= 	$row['rete_ica'];
            $Cotizacion->rete_renta		= 	$row['rete_renta'];
            $Cotizacion->rete_iva		= 	$row['rete_iva'];	
            $Cotizacion->cot_iva		= 	$row['cot_iva'];
            $Cotizacion->ciudad 		= 	$row['ciudad'];
            $Cotizacion->contacto 		= 	$row['contacto'];
            $Cotizacion->comentariodir	= 	$row['comentariodir'];
            $Cotizacion->id_dirdespacho	= 	$row['id_dirdespacho'];
            $Cotizacion->zona       	= 	$row['zona'];   
            if($usuariosistema==$row['id_contribuyente'] ||($usuariosistema==$opcion1 && $opcion2==$row['id_contribuyente'])){
            if(($row['id_estado']=='CB')){
            	$Cotizacion->puedever		= 	false;
            	$Cotizacion->puedemodificar	= 	false;
            	$Cotizacion->puedeeliminar	= 	false;
            }
            if(($row['id_estado']=='CT')){
            	$Cotizacion->puedever		= 	true;
            	$Cotizacion->puedemodificar	= 	true;
            	$Cotizacion->puedeeliminar	= 	true;
            }
        	if(($row['id_estado']=='CV')){
            	$Cotizacion->puedever		= 	true;
            	$Cotizacion->puedemodificar	= 	true;
            	$Cotizacion->puedeeliminar	= 	false;
            }
        	if(($row['id_estado']=='CF')){
            	$Cotizacion->puedever		= 	false;
            	$Cotizacion->puedemodificar	= 	false;
            	$Cotizacion->puedeeliminar	= 	false;
            }
            }
            else{
            if(($row['id_estado']=='CB')){
            	$Cotizacion->puedever		= 	false;
            	$Cotizacion->puedemodificar	= 	false;
            	$Cotizacion->puedeeliminar	= 	false;
            }
            if(($row['id_estado']=='CT')){
            	$Cotizacion->puedever		= 	false;
            	$Cotizacion->puedemodificar	= 	false;
            	$Cotizacion->puedeeliminar	= 	false;
            }
        	if(($row['id_estado']=='CV')){
            	$Cotizacion->puedever		= 	false;
            	$Cotizacion->puedemodificar	= 	false;
            	$Cotizacion->puedeeliminar	= 	false;
            }
        	if(($row['id_estado']=='CF')){
            	$Cotizacion->puedever		= 	false;
            	$Cotizacion->puedemodificar	= 	false;
            	$Cotizacion->puedeeliminar	= 	false;
            }	
            }
            
            /*
            $Cotizacion->puedever		= 	(($row['id_estado']=='CB')?false:true);
            $Cotizacion->puedemodificar	= 	(($row['id_estado']=='CT')?true:false);
            $Cotizacion->puedeeliminar	= 	(($row['id_estado']=='CT')?true:false);
            
            
            $Cotizacion->puedever		= 	(($row['id_estado']=='CV')?true:false);
            $Cotizacion->puedemodificar	=	(($row['id_estado']=='CV')?true:false);
			*/
			$Cotizacion->total_coti		=	$total_coti;
            $List->addlast($Cotizacion);            }
        $res->free();
		return true;
    }
    
    public function getMonitorcotizacion($List) {
		$Lista = $List;
    	$List->gofirst();
        $query = "	SELECT id_cotizacion, 
                            ce.id_estado, 
                            e.descripcion as nomestado,
                            ce.id_tipoventa, 
                            tv.descripcion as nomtipoventa,
                            rutcliente, 
                            l2.dir_local dir_localcsum,
                            codlocalcsum, 
                            l2.nom_local nom_localcsum,
                            razonsoc, 
                            id_usuario, 
                            usuariocrea, 
                            valortotal, 
							ce.feccrea
                    FROM 	cotizacion_e ce
                    LEFT JOIN 	estado e on (e.id_estado=ce.id_estado)
                    LEFT JOIN 	tipoventa tv on (tv.id_tipoventa=ce.id_tipoventa)
                    LEFT JOIN 	locales l2 on (l2.cod_local=ce.codlocalcsum)
                    WHERE 	1 
                    " . (($List->getelem()->id_cotizacion)? " and id_cotizacion = ".$List->getelem()->id_cotizacion." " : "") . "
                    " . (($List->getelem()->rutcliente)? " and rutcliente = ".$List->getelem()->rutcliente." " : "") . "
                    " . (($List->getelem()->razonsoc)? " and razonsoc like '%".addslashes($List->getelem()->razonsoc)."%'" : "") . "
                    " . (($List->getelem()->id_tipoventa)? " and ce.id_tipoventa = ".$List->getelem()->id_tipoventa." " : "") . "
                    " . (($List->getelem()->codlocalcsum)? " and codlocalcsum = '".$List->getelem()->codlocalcsum."' " : "") . "
                    " . (($List->getelem()->codlocalventa)? " and codlocalventa = '".$List->getelem()->codlocalventa."' " : "") . "
                    " . (($List->getelem()->fechaucofini)? " and ce.feccrea >= '".$List->getelem()->fechaucofini."'" : "") . "
                    " . (($List->getelem()->fechaucoffin)? " and ce.feccrea <= '".$List->getelem()->fechaucoffin."'" : "") . "
                    " . (($List->getelem()->id_estado)? " and ce.id_estado = '".$List->getelem()->id_estado."' " : "") . "
                    " . (($List->getelem()->codigovendedor!==null)? " and codigovendedor = '".$List->getelem()->codigovendedor."'" : "") . "
                    " . (($List->getelem()->orderby)? " ORDER BY ".$List->getelem()->orderby : "ORDER BY 1 DESC") . "
                    " . (($List->getelem()->limite)? " LIMIT ".$List->getelem()->limite : "") . "
                    ";

        $total_coti             =       $List->getelem()->limite;
        //general::writeevent("SELECT COTIZACION ". $query);
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Cotizacion = new dtocotizacion;
            $Cotizacion->id_cotizacion  = 	$row['id_cotizacion'];
            $Cotizacion->id_estado		= 	$row['id_estado'];				
            $Cotizacion->nomestado		= 	$row['nomestado'];					
            $Cotizacion->id_tipoventa	= 	$row['id_tipoventa'];	
            $Cotizacion->nomtipoventa	= 	$row['nomtipoventa'];
            $Cotizacion->rutcliente		= 	$row['rutcliente'];	
            $Cotizacion->dir_localcsum	= 	$row['dir_localcsum'];				
            $Cotizacion->codlocalcsum	= 	$row['codlocalcsum'];	
            $Cotizacion->nom_localcsum	= 	$row['nom_localcsum'];	
            $Cotizacion->razonsoc		= 	$row['razonsoc'];											
            $Cotizacion->id_usuario		= 	$row['id_usuario'];
            $Cotizacion->usuariocrea	= 	$row['usuariocrea'];
            $Cotizacion->feccrea		= 	$row['feccrea'];   
            $Cotizacion->puedever		= 	(($row['id_estado']=='CB')?false:true);
            $Cotizacion->puedemodificar	= 	(($row['id_estado']=='CT' || $row['id_estado']=='CV')?true:false);
            $Cotizacion->puedeeliminar	= 	(($row['id_estado']=='CT')?true:false);
            $Cotizacion->total_coti		=	$total_coti;
            $List->addlast($Cotizacion);            }
        $res->free();
		return true;
    }
    
	public function getcotizacionestado($List) {
		$Lista = $List;
    	$List->gofirst();
        $query = "	SELECT descripcion 
        			FROM cotizacion_e cot 
        			join  estado est on (tipo='CO' and est.id_estado=cot.id_estado) 
        			where id_cotizacion=".$List->getelem()->id_cotizacion;

        //general::writeevent("estado coti ". $query);
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Cotizacion = new dtocotizacion;				
            $Cotizacion->nomestado		= 	$row['descripcion'];					
            $List->addlast($Cotizacion);
        }
        $res->free();
		return true;
    }
    
	public function getcountcotizacion($List) {

    	$List->gofirst();
        $query = "	SELECT * FROM cotizacion_e
                    WHERE 1 
                    ".(($List->getelem()->id_dirdespacho)? " and id_dirdespacho=".$List->getelem()->id_dirdespacho."":"")."";
        
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Cotizacion = new dtocotizacion;
            $Cotizacion->feccrea		= 	$row['feccrea'];   
            $List->addlast($Cotizacion);            
        }
        $res->free();
		return true;
    }

    public function getdetcotizacion($List) {
    	global $ses_usr_codlocal; 
    
		$escotizacionviente = $this->escotivigente($List);
		
    	$List->gofirst();
		$reqdet = $List->getelem()->reqdet;
		$codlocalcsum = $List->getelem()->codlocalcsum;
		
		//Recupero la plaza del centro de suministros y del local actual
		$CtrlLocal = new ctrllocal;
		$CtrlLocal->getlocales($listloc1 = new connlist(new dtolocal(array('cod_local'=>$codlocalcsum))));
		$listloc1->gofirst();
		$CtrlLocal->getlocales($listloc2 = new connlist(new dtolocal(array('cod_local'=>$ses_usr_codlocal))));
		$listloc2->gofirst();
		
		if ($listloc1->getelem()->plaza != $listloc2->getelem()->plaza)
			$plazadistinta = true;
		else
			$plazadistinta = false;
		
		$query = "	SELECT 	id_linea, 
                            id_cotizacion, 
                            cd.id_tiporetiro,
                            tr.descripcion as nomtiporetiro,								 
							cd.id_tipoentrega,
                            numlinea, 
                            cd.descripcion, 
                            codprod, 
                            barra, 	
                            pcosto, 
                            pventaneto, 
                            cargoflete, 
                            valorfleteh, 
                            pventaiva, 
                            totallinea, 
                            cantidad, 
                            cantidade, 
                            margenlinea,		
                            unimed,
							nomproveedor,
                            codtipo, 
							rutproveedor,
                            codsubtipo,
                            instalacion,
                            descuento,
                            peso,
                            rete_ica,
                            rete_renta,
                            cot_iva
                    FROM 	cotizacion_d cd
                    JOIN 	tiporetiro tr on (tr.id_tiporetiro=cd.id_tiporetiro)
                    WHERE 	1 
                    " . (($List->getelem()->id_cotizacion)? " and id_cotizacion = ".$List->getelem()->id_cotizacion." " : "") . "
                    ORDER BY numlinea 
                    ";
        $res = $this->bd->query($query);
        
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetcotizacion;
            $Registro->id_linea			= 	$row['id_linea'];
            $Registro->id_cotizacion	= 	$row['id_cotizacion'];	
            $Registro->id_tiporetiro	= 	$row['id_tiporetiro'];	
            $Registro->nomtiporetiro	= 	$row['nomtiporetiro'];											
            $Registro->id_tipoentrega	= 	$row['id_tipoentrega'];	
            $Registro->numlinea			= 	$row['numlinea'];					
            $Registro->descripcion		= 	htmlspecialchars($row['descripcion']);
            $Registro->codprod			= 	$row['codprod'];				
            $Registro->barra			= 	$row['barra'];	
            $Registro->nomprov			= 	$row['nomproveedor'];	
            $Registro->pcosto			= 	round($row['pcosto']);
            $Registro->pventaneto		= 	round($row['pventaneto']);	
            $Registro->cargoflete		= 	$row['cargoflete'];	
            $Registro->valorfleteh		= 	$row['valorfleteh'];	
            $Registro->pventaiva		= 	$row['pventaiva'];	
            $Registro->cantidad			= 	$row['cantidad'];	
            $Registro->cantidade		= 	$row['cantidade'];																
            $Registro->totallinea		= 	$row['totallinea'];	
            $Registro->margenlinea		= 	$row['margenlinea']; 
            $Registro->unimed			= 	$row['unimed'];	
            $Registro->codtipo			= 	$row['codtipo'];
            $Registro->rutproveedor		= 	$row['rutproveedor'];
            $Registro->codsubtipo		= 	$row['codsubtipo'];
            $Registro->instalacion		= 	$row['instalacion'];
            $Registro->descuento		= 	$row['descuento'];
            $Registro->peso				= 	$row['peso'];
            $Registro->rete_ica			= 	$row['rete_ica'];
            $Registro->rete_renta		= 	$row['rete_renta'];
            $Registro->cot_iva			= 	$row['cot_iva'];
			
            //general::alert($Registro->pcosto);
            if ($reqdet && isset($row['codprod'])){
            	$ListaDetAddPro = new connlist;
    	   		$dtoproducto = new dtoproducto;
				$dtoproducto -> numretlimit = 100;
				$dtoproducto -> csum = $codlocalcsum;
			 	$dtoproducto -> sap = $row['codprod'];
    	   		$ListaDetAddPro->addlast($dtoproducto);
    	   		$c = new ctrlproducto;
    	   		$c->getproductogrilla($ListaDetAddPro);
    	   		$ListaDetAddPro->gofirst();
    	   		$Registro->lisdetprod = $ListaDetAddPro;

    	   		if ($ListaDetAddPro->numelem()){
    	   			do {
    	   				if ($ListaDetAddPro->getelem()->unidmed == $Registro->unimed) {
			    	   		//Actualizo los precios de venta si se requiere detalle y si se venci贸 la fecha de la cotizaci贸n o el local pertenece a otra plaza
				            if (!$escotizacionviente || $plazadistinta) {
			    	   			$Registro->pventaneto = $ListaDetAddPro->getelem()->pventa;
				            }
			    	   		//Actualizo los precios de costo siempre
			    	   		//if ($codlocalcsum != $ses_usr_codlocal) {
			    	   			//$Registro->pcosto = $ListaDetAddPro->getelem()->pcosto;
			    	   		//}
    	   				}
    	   			} while ($ListaDetAddPro->gonext());
    	   		}
            }
            
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
	public function getdetcotizacionsumimp($List) {
    	
    	$List->gofirst();
		
		$query = "	SELECT 
					sum(rete_ica) as rete_ica,
					sum(rete_renta) as rete_renta 
					FROM cotizacion_d  
					where id_cotizacion=".$List->getelem()->id_cotizacion."";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetcotizacion;
            $Registro->rete_ica			= 	$row['rete_ica'];
            $Registro->rete_renta		= 	$row['rete_renta'];
			
            //general::alert($Registro->pcosto);
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
	public function getdetcotizacioncountpegenerico($List) {
    	
    	$List->gofirst();
		
		$query = "	SELECT sum(if(codsubtipo ='GE',1,0)) as cantidad
					FROM cotizacion_d  
					where id_cotizacion=".$List->getelem()->id_cotizacion."";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetcotizacion;
            $Registro->cantidad			= 	$row['cantidad'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    /*Metodo getdetalleimpuesto*/
    public function getdetalleimpuesto($List, $id_coti,$grupoimp) {    	
		$query = "	SELECT  rete_renta,
                            rete_ica,
                            cot_iva,
                            (cot_iva/100)+1 impivatotal,
                            sum((totallinea/((cot_iva/100)+1))) as totalsiniva,
                            sum(round((totallinea/((cot_iva/100)+1))*(".$grupoimp."/100))) as imptotal
                    FROM 	cotizacion_d cd
                    WHERE
                    id_cotizacion = ".$id_coti." group by $grupoimp";
                   
		
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetcotizacion;
            $Registro->sumiva           =   $row['imptotal'];
            $Registro->rete_ica			= 	$row['rete_ica'];
            $Registro->rete_renta		= 	$row['rete_renta'];
            $Registro->cot_iva			= 	$row['cot_iva'];
            $Registro->sumtotaliva		= 	$row['totalsiniva'];            
            $List->addlast($Registro);
        }
            $res->free();
        return true;
    }
    /*Fin getdetalleimpuesto*/
    public function saveenccotizacion($List) {
    	global $ses_usr_login, $ses_usr_id;
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("N鷐ero incorrecto de elementos", 0);
    	}
		
    	if ($List->getelem()->id_cotizacion){

    		//Es una cotizaci贸n antigua, se hace UPDATE
            $query = "	UPDATE cotizacion_e 
                        SET	usrcrea = usrcrea
                        " . (($List->getelem()->id_estado)? ", id_estado = '". $List->getelem()->id_estado . "'": "") . "
                        " . (($List->getelem()->id_tipoventa)? ", id_tipoventa = ". $List->getelem()->id_tipoventa : "") . "
                        " . (($List->getelem()->codigovendedor)? ", codigovendedor = '". $List->getelem()->codigovendedor ."'": "") . "
                        " . (($List->getelem()->rutcliente)? ", rutcliente = ". $List->getelem()->rutcliente : "") . "
                        " . (($List->getelem()->codlocalventa)? ", codlocalventa = '". $List->getelem()->codlocalventa . "'" : "") . "
                        " . (($List->getelem()->codlocalcsum)? ", codlocalcsum = '". $List->getelem()->codlocalcsum . "'" : "") . "
                        " . (($List->getelem()->razonsoc)? ", razonsoc = '". addslashes($List->getelem()->razonsoc) . "'" : "") . "
                        " . (($List->getelem()->id_giro)? ", id_giro = '". $List->getelem()->id_giro . "'" : "") . "
                        " . (($List->getelem()->giro)? ", giro = '". addslashes($List->getelem()->giro) . "'" : "") . "
                        " . (($List->getelem()->direccion)? ", direccion = '". $List->getelem()->direccion . "'" : "") . "
                        " . (($List->getelem()->comuna)? ", comuna = '". $List->getelem()->comuna . "'" : "") . "
                        " . (($List->getelem()->iva)? ", iva = ". $List->getelem()->iva : "") . "
                        " . (($List->getelem()->validdesde)? ", validdesde = '". $List->getelem()->validdesde . "'" : "") . "
                        " . (($List->getelem()->validhasta)? ", validhasta = '". $List->getelem()->validhasta . "'" : "") . "
                        " . (($List->getelem()->validdias)? ", validdias = ". $List->getelem()->validdias : "") . "
                        " . (($List->getelem()->nvevaliddesde)? ", nvevaliddesde = '". $List->getelem()->nvevaliddesde . "'" : "") . "
                        " . (($List->getelem()->nvevalidhasta)? ", nvevalidhasta = '". $List->getelem()->nvevalidhasta . "'" : "") . "
                        " . (($List->getelem()->nvevaliddias)? ", nvevaliddias = ". $List->getelem()->nvevaliddias : "") . "
                        " . (($List->getelem()->condicion)? ", condicion = '". $List->getelem()->condicion . "'" : "") . "
                        " . (($List->getelem()->diascondicion)? ", diascondicion = ". $List->getelem()->diascondicion : "") . "
                        " . (($List->getelem()->fonocontacto)? ", fonocontacto = '". $List->getelem()->fonocontacto . "'" : "") . "
                        " . (($List->getelem()->rete_iva)? ", rete_iva = ". $List->getelem()->rete_iva . "" : "") . "
                        " . (($List->getelem()->rete_ica)? ", rete_ica = ". $List->getelem()->rete_ica . "" : "") . "
                        " . (($List->getelem()->rete_renta)? ", rete_renta = ". $List->getelem()->rete_renta . "" : "") . "
                        " . (($List->getelem()->cot_iva)? ", cot_iva = '". $List->getelem()->cot_iva . "'" : "") . "
                        " . (($List->getelem()->id_dirdespacho)? ", id_dirdespacho = '". $List->getelem()->id_dirdespacho . "'" : "") . "
                        " . (($List->getelem()->observaciones)? ", observaciones = '". addslashes($List->getelem()->observaciones) . "'" : "") . "
                        " . (($List->getelem()->nota)? ", nota = '". $List->getelem()->nota . "'" : "") . "
                        , id_usuario = $ses_usr_id 
                        , usuariocrea = '".$ses_usr_login."'
                        " . (($List->getelem()->valortotal)? ", valortotal = ". (($List->getelem()->valortotal+0)-($List->getelem()->rete_iva+0)-($List->getelem()->rete_ica+0)-($List->getelem()->rete_renta+0)) : "") . "
                        " . (($List->getelem()->margentotal)? ", margentotal = ". $List->getelem()->margentotal : "") . "
                        " . (($List->getelem()->obsdesb)? ", obsdesb = '". $List->getelem()->obsdesb . "'" : "") . "
                        , usrmod = '".$ses_usr_login."' 
                        , fecmod = now()
                        WHERE id_cotizacion = ".$List->getelem()->id_cotizacion ;
            $res = $this->bd->querynoselect($query);
           // general::writeevent($query);          
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

            return true;
    	}
    	else {
	    	//Es una cotizaci贸n nueva, se hace INSERT
            $query = "	INSERT INTO cotizacion_e (	
                            id_cotizacion,
                            id_estado,
                            id_tipoventa,
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
                            validdesde,
                            validhasta,
                            validdias,
                            nvevaliddesde,
                            nvevalidhasta,
                            nvevaliddias,
                            condicion,
                            diascondicion,
                            fonocontacto,
                            observaciones,
                            nota,
                            id_usuario,
                            usuariocrea,
                            valortotal,
                            margentotal,
                            rete_iva,
                            rete_ica,
                            rete_renta,
                            cot_iva,
                            id_dirdespacho,
                            obsdesb,
                            usrcrea,
                            feccrea,
                            usrmod,
                            fecmod
                        )
                        VALUES (
                            null,
                            '".$List->getelem()->id_estado."',
                            ".($List->getelem()->id_tipoventa+0).",
                            '".$List->getelem()->codigovendedor."',
                            ".($List->getelem()->rutcliente+0).",
                            '".$List->getelem()->codlocalventa."',
                            '".$List->getelem()->codlocalcsum."',
                            '".addslashes($List->getelem()->razonsoc)."',
                            '".$List->getelem()->id_giro."',
                            '".addslashes($List->getelem()->giro)."',
                            '".$List->getelem()->direccion."',
                            '".$List->getelem()->comuna."',
                            '".$List->getelem()->iva."',
                            '".$List->getelem()->validdesde."',
                            '".$List->getelem()->validhasta."',
                            '".($List->getelem()->validdias+0)."',
                            ".(($List->getelem()->nvevaliddesde)?"'".$List->getelem()->nvevaliddesde."'":"null").",
                            ".(($List->getelem()->nvevalidhasta)?"'".$List->getelem()->nvevalidhasta."'":"null").",
                            '".($List->getelem()->nvevaliddias+0)."',
                            '".$List->getelem()->condicion."',
                            '".($List->getelem()->diascondicion+0)."',
                            '".$List->getelem()->fonocontacto."',
                            '".addslashes($List->getelem()->observaciones)."',
                            '".$List->getelem()->nota."',
                            ".($ses_usr_id+0).",
                            '".$ses_usr_login."',
                            '".(($List->getelem()->valortotal+0)-($List->getelem()->rete_iva+0)-($List->getelem()->rete_ica+0)-($List->getelem()->rete_renta+0))."',
                            '".($List->getelem()->margentotal+0)."',
                            '".($List->getelem()->rete_iva+0)."',
                            '".($List->getelem()->rete_ica+0)."',
                            '".($List->getelem()->rete_renta+0)."',
                            '".($List->getelem()->cot_iva+0)."',
                            '".($List->getelem()->id_dirdespacho+0)."',
                            '".$List->getelem()->obsdesb."',
                            '".$ses_usr_login."',
                            now(),
                            '".$ses_usr_login."',
                            now()
                        )";
            $res = $this->bd->querynoselect($query);
            
         
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

            $List->getelem()->id_cotizacion = ($this->bd->last_insert_id());
            return true;
    	}
    }

    public function delenccotizacion($List) {
    	global $ses_usr_login;
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("N煤mero incorrecto de elementos", 0);
    	}		
    	if ($List->getelem()->id_cotizacion){
    		//Es una cotizaci贸n antigua, se el DELETE
            $query = "	DELETE FROM cotizacion_e
                        WHERE id_cotizacion = ".$List->getelem()->id_cotizacion ;
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

            return true;
    	}
    }


    /*Eliminar Flete de Cotizacion*/
    public function deldetcotizacionf($idcotizacion) {
    	global $ses_usr_login;
 	//Es una cotizaci贸n antigua, se el DELETE
       $query = "	DELETE FROM cotizacion_d 
                     WHERE codtipo='SV' and codsubtipo= 'DE' and id_cotizacion = ".$idcotizacion ;
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

            return true;
    	
    }
    /*Fin Eliminar Flete de Cotizacion*/
	public function cuontcotizacionf($List) {
    	global $ses_usr_login;
    	$List->gofirst();
 	//Es una cotizaci贸n antigua, se el DELETE
       $query = "SELECT count(codtipo) as countf FROM cotizacion_d  where codtipo='SV' and codsubtipo= 'DE' and id_cotizacion=".$List->getelem()->id_cotizacion ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
 		$List->clearlist();	
        while ($row = $res->fetch_assoc()){
            
            $Cotizacion = new dtocotizacion;
            $Cotizacion->numlinea1  = 	$row['countf'];            
            
        $List->addlast($Cotizacion);            }
        $res->free();
		return true;
    	
    }
    
   /*Actualizar Precio encabezado Flete*/
    public function saveenccotizacionf($List) {
    	$List->gofirst();
    	$query = "	UPDATE cotizacion_e 
                    SET	valortotal = '". $List->getelem()->valortotal . "',
                    zona = '".$List->getelem()->zona."' 
                    WHERE id_cotizacion = ".$List->getelem()->id_cotizacion;
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        return true;
    	
    }
    
    /*Fin Actualizar Precio encabezado Flete*/
  
	public function cambioestadocotizacion($List) {
    	global $ses_usr_login;
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("Numero incorrecto de elementos", 0);
    	}		
    	if ($List->getelem()->id_cotizacion){
    		//Es una cotizaci贸n antigua, se el DELETE
            $query = "	update cotizacion_e set id_estado='".$List->getelem()->id_estado."' where id_cotizacion=".$List->getelem()->id_cotizacion ;
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

            return true;
    	}
    }
    
    public function deldetcotizacion($List) {
    	global $ses_usr_login;
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("Numero incorrecto de elementos", 0);
    	}		
    	if ($List->getelem()->id_cotizacion){
    		//Es una cotizaci贸n antigua, se el DELETE
            $query = "	DELETE FROM cotizacion_d
                        WHERE id_cotizacion = ".$List->getelem()->id_cotizacion ;
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

            return true;
    	}
    }
    
    public function savedetcotizacion($ListEnc, $ListDet) {
    	global $ses_usr_login;
    	$ListEnc->gofirst();
    	if ($ListEnc->numelem()!=1){
            throw new CTRLException("Numero incorrecto de elementos", 0);
    	}
		if (!$ListEnc->getelem()->id_cotizacion){
            throw new CTRLException("No viene Id de cotizacion", 0);
    	}
    	
    	if (!$ListDet)
    		return true;

    	//Variable para guardar el total nuevo
    	$totaln = 0; 
    		
    	$ListDet->gofirst();
		if (!$ListDet->isvoid()) {
			$contadorlinea = 1;
			do {
				if (!$ListDet->getelem())
					continue;
				//Insertamos los registros de detalle
                $query = "	INSERT INTO cotizacion_d (	
                                id_linea,
                                id_cotizacion,
                                id_tiporetiro,
								id_tipoentrega,
                                numlinea,
                                descripcion,
                                codprod,
                                barra,
                                pcosto,
                                pventaneto,
                                cargoflete,
                                valorfleteh,
                                pventaiva,
                                totallinea,
                                cantidad,
                                cantidade,
                                margenlinea,
                                nomproveedor,
								rutproveedor,
                                unimed,
                                codtipo,
                                codsubtipo,
                                instalacion,
                                descuento,
                                peso,
                                rete_ica,
                                rete_renta,
                                cot_iva,
                                usrcrea,
                                feccrea,
                                usrmod,
                                fecmod
                            )
                            VALUES (
                                null,
                                ".$ListEnc->getelem()->id_cotizacion.",
                                ".($ListDet->getelem()->id_tiporetiro+0).",
                                ".($ListDet->getelem()->id_tipoentrega+0).",
                                ".($contadorlinea+0).",
                                '".html_entity_decode($ListDet->getelem()->descripcion)."',
                                ".($ListDet->getelem()->codprod+0).",
                                ".($ListDet->getelem()->barra).",
                                ".($ListDet->getelem()->pcosto+0).",
                                ".($ListDet->getelem()->pventaneto+0).",
                                ".($ListDet->getelem()->cargoflete+0).",
                                ".($ListDet->getelem()->valorfleteh+0).",
                                ".($ListDet->getelem()->pventaiva+0).",
                                ".($ListDet->getelem()->totallinea+0).",
                                ".($ListDet->getelem()->cantidad+0).",
                                ".($ListDet->getelem()->cantidade+0).",
                                ".($ListDet->getelem()->margenlinea+0).",
                                '".($ListDet->getelem()->nomprov)."',
                                ".($ListDet->getelem()->rutproveedor+0).",
                                '".$ListDet->getelem()->unimed."',
                                '".$ListDet->getelem()->codtipo."',
                                '".$ListDet->getelem()->codsubtipo."',
                                '".$ListDet->getelem()->instalacion."',
                                ".($ListDet->getelem()->descuento+0).",
                                ".($ListDet->getelem()->peso+0).",
                                ".($ListDet->getelem()->rete_ica+0).",
                                ".($ListDet->getelem()->rete_renta+0).",
                                ".($ListDet->getelem()->cot_iva+0).",
                                '".$ses_usr_login."',
                                now(),
                                '".$ses_usr_login."',
                                now()
                            )";
                $res = $this->bd->querynoselect($query);
                if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
                $totaln += $ListDet->getelem()->totallinea + 0;
                ++$contadorlinea;
			} while ($ListDet->gonext());
		}
		//return true;
		return $totaln;
    }

	public function ActualizaCantNVEOE($listoedet, $operacion) {
    	global $ses_usr_login;

    	if (!$listoedet) return true;
		if (!$listoedet->numelem()) return true;
		
		if ($operacion != '+'  && $operacion != '-'){
            throw new CTRLException("Operador incorrecto", 0);
    	}

    	$listoedet->gofirst();
    	$this->initrx();
		do {
            $query = "	UPDATE cotizacion_d 
                        SET	cantidade = cantidade " . $operacion  . ($listoedet->getelem()->cantidade+0) . "
                        , usrmod = '".$ses_usr_login."' 
                        , fecmod = now()
                        WHERE id_linea = ".($listoedet->getelem()->id_lineadoc+0) ;
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		} while ($listoedet->gonext());
		$this->commit();
		return true;
	}
	
	public function dupcotizacion($List) {
    	global $ses_usr_login, $ses_usr_codlocal, $ses_usr_id;
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("Numero incorrecto de elementos", 0);
    	}		
    	if (!$ses_usr_codlocal){
            throw new CTRLException("El usuario no tiene asignado local. No puede duplicar la cotizacion", 0);
    	}		
    	if ($List->getelem()->id_cotizacion){
    		$this->initrx();
    		//Duplicamos el encabezado
            $query = "	INSERT INTO cotizacion_e (id_cotizacion, id_estado, id_tipoventa, codigovendedor, rutcliente, codlocalventa, codlocalcsum, razonsoc, id_giro, giro, direccion, comuna, iva, validdesde, validhasta, validdias, nvevaliddesde, nvevalidhasta, nvevaliddias, condicion, diascondicion, fonocontacto, observaciones, nota, id_usuario, usuariocrea, valortotal, margentotal, obsdesb, usrcrea, feccrea, usrmod, fecmod, rete_iva, rete_ica, rete_renta, cot_iva, id_dirdespacho)
                        SELECT NULL, 'CV', id_tipoventa, codigovendedor, rutcliente, codlocalcsum, codlocalcsum, razonsoc, id_giro, giro, direccion, comuna, iva, now(), validhasta , ".(DIAS_VALID_COTI+0).",now(), nvevalidhasta,".(DIAS_VALID_COTI+0).", condicion, diascondicion, fonocontacto, null, null, $ses_usr_id, '$ses_usr_login', valortotal, margentotal, null, '$ses_usr_login', now(), '$ses_usr_login', now(), rete_iva, rete_ica, rete_renta, cot_iva, id_dirdespacho 
						FROM cotizacion_e
						WHERE id_cotizacion = ".$List->getelem()->id_cotizacion ;
            $res = $this->bd->querynoselect($query);
            //general::writeevent($query);
            if (!$res) {
            	$this->rollback();
            	throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            }
            $id_cotizacion_ult = $this->bd->last_insert_id();
            //Duplicamos el detalle
            $query = "	INSERT INTO cotizacion_d (id_linea, id_cotizacion, id_tiporetiro, id_tipoentrega, numlinea, descripcion, codprod, barra, pcosto, pventaneto, cargoflete, valorfleteh, pventaiva, totallinea, cantidad, cantidade, margenlinea, incluirentotal, unimed, codtipo, codsubtipo, usrcrea, feccrea, usrmod, fecmod, rutproveedor, nomproveedor, instalacion, descuento, peso, rete_ica, rete_renta, cot_iva)
                        SELECT NULL, ".($id_cotizacion_ult+0).", id_tiporetiro, id_tipoentrega, numlinea, descripcion, codprod, barra, pcosto, pventaneto, cargoflete, valorfleteh, pventaiva, totallinea, cantidad, 0, margenlinea, null, unimed, codtipo, codsubtipo, '$ses_usr_login', now(), '$ses_usr_login', now(), rutproveedor, nomproveedor, instalacion, descuento, peso, rete_ica, rete_renta, cot_iva
						FROM cotizacion_d
						WHERE id_cotizacion = ".$List->getelem()->id_cotizacion ." order by  numlinea ";
            $res = $this->bd->querynoselect($query);
            //general::writeevent($query);
            if (!$res) {
            	$this->rollback();
            	throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            }
            
            $this->commit();
            $List->getelem()->id_cotizacion = $id_cotizacion_ult;
            return true;
    	}
    	return false;
    }
	
    public function dupcotizacioncaducada($List) {
    	global $ses_usr_login, $ses_usr_codlocal, $ses_usr_id;
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("Numero incorrecto de elementos", 0);
    	}		
    	if (!$ses_usr_codlocal){
            throw new CTRLException("El usuario no tiene asignado local. No puede duplicar la cotizacion", 0);
    	}		
    	if ($List->getelem()->id_cotizacion){
    		$this->initrx();
    		//Duplicamos el encabezado
            $query = "	INSERT INTO cotizacion_e (id_cotizacion, id_estado, id_tipoventa, codigovendedor, rutcliente, codlocalventa, codlocalcsum, razonsoc, id_giro, giro, direccion, comuna, iva, validdesde, validhasta, validdias, nvevaliddesde, nvevalidhasta, nvevaliddias, condicion, diascondicion, fonocontacto, observaciones, nota, id_usuario, usuariocrea, valortotal, margentotal, obsdesb, usrcrea, feccrea, usrmod, fecmod, rete_iva, rete_ica, rete_renta, cot_iva, id_dirdespacho)
                        SELECT NULL, 'CV', id_tipoventa, codigovendedor, rutcliente,' $ses_usr_codlocal','$ses_usr_codlocal' , razonsoc, id_giro, giro, direccion, comuna, iva, now(),DATE_ADD(now(), INTERVAL ".(DIAS_VALID_COTI+0)." DAY), ".(DIAS_VALID_COTI+0).",now(),DATE_ADD(now(), INTERVAL ".(DIAS_VALID_COTI+0)." DAY),".(DIAS_VALID_COTI+0).", condicion, diascondicion, fonocontacto, null, null, $ses_usr_id, '$ses_usr_login', 0, 0, null, '$ses_usr_login', now(), '$ses_usr_login', now(), 0, 0, 0, 0, 0 
						FROM cotizacion_e
						WHERE id_cotizacion = ".$List->getelem()->id_cotizacion ;
            $res = $this->bd->querynoselect($query);
            //general::writeevent($query);
            if (!$res) {
            	$this->rollback();
            	throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            }
            $id_cotizacion_ult = $this->bd->last_insert_id();
            //Duplicamos el detalle
            $query = "	INSERT INTO cotizacion_d (id_linea, id_cotizacion, id_tiporetiro, id_tipoentrega, numlinea, descripcion, codprod, barra, pcosto, pventaneto, cargoflete, valorfleteh, pventaiva, totallinea, cantidad, cantidade, margenlinea, incluirentotal, unimed, codtipo, codsubtipo, usrcrea, feccrea, usrmod, fecmod, rutproveedor, nomproveedor, instalacion, descuento, peso, rete_ica, rete_renta, cot_iva)
                        SELECT NULL, ".($id_cotizacion_ult+0).", id_tiporetiro, id_tipoentrega, numlinea, descripcion, codprod, barra, prec_costo, prec_valor, cargoflete, valorfleteh,0, 0, cantidad, 0, 0, null, unimed, codtipo, codsubtipo, '$ses_usr_login', now(), '$ses_usr_login', now(), rutproveedor, nomproveedor, instalacion, 0, peso, 0, 0, 0
						FROM cotizacion_d 
						WHERE id_cotizacion = ".$List->getelem()->id_cotizacion ."  order by  numlinea ";
            $res = $this->bd->querynoselect($query);
            //general::writeevent($query);
            if (!$res) {
            	$this->rollback();
            	throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            }
            
            $this->commit();
            $List->getelem()->id_cotizacion = $id_cotizacion_ult;
            return true;
    	}
    	return false;
    }
    
    public function gencotizacionremnve($List) {
    	global $ses_usr_login, $ses_usr_codlocal, $ses_usr_id;
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("Numero incorrecto de elementos", 0);
    	}		
    	if (!$ses_usr_codlocal){
            throw new CTRLException("El usuario no tiene asignado local", 0);
    	}		
    	if ($List->getelem()->id_cotizacion){
    		$this->initrx();
    		//Duplicamos el encabezado
            $query = "	INSERT INTO cotizacion_e (id_cotizacion, id_estado, id_tipoventa, codigovendedor, rutcliente, codlocalventa, codlocalcsum, razonsoc, id_giro, giro, direccion, comuna, iva, validdesde, validhasta, validdias, nvevaliddesde, nvevalidhasta, nvevaliddias, condicion, diascondicion, fonocontacto, observaciones, nota, id_usuario, usuariocrea, valortotal, margentotal, obsdesb, usrcrea, feccrea, usrmod, fecmod)
                        SELECT NULL, 'CT', id_tipoventa, codigovendedor, rutcliente, '$ses_usr_codlocal', codlocalcsum, razonsoc, id_giro, giro, direccion, comuna, iva, now(), ADDDATE(now(), ".(DIAS_VALID_COTI+0).") , ".(DIAS_VALID_COTI+0).", null, null, null, condicion, diascondicion, fonocontacto, null, null, $ses_usr_id, '$ses_usr_login', valortotal, margentotal, null, '$ses_usr_login', now(), '$ses_usr_login', now() 
						FROM cotizacion_e
						WHERE id_cotizacion = ".$List->getelem()->id_cotizacion ;
            $res = $this->bd->querynoselect($query);
            if (!$res) {
            	$this->rollback();
            	throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            }
            $id_cotizacion_ult = $this->bd->last_insert_id();
            //Duplicamos el detalle de los productos que no est谩n en ninguna OE
            $query = "	INSERT INTO cotizacion_d (id_linea, id_cotizacion, id_tiporetiro, id_tipoentrega, numlinea, descripcion, codprod, barra, nomproveedor, rutproveedor, pcosto, pventaneto, cargoflete, valorfleteh, pventaiva, totallinea, cantidad, cantidade, margenlinea, incluirentotal, unimed, codtipo, codsubtipo, usrcrea, feccrea, usrmod, fecmod)
                        SELECT NULL, ".($id_cotizacion_ult+0).", id_tiporetiro, id_tipoentrega, numlinea, descripcion, codprod, barra, nomproveedor, rutproveedor, pcosto, pventaneto, cargoflete, valorfleteh, pventaiva, if (cantidade is null, round(cantidad*(pventaneto+cargoflete)), round((cantidad-cantidade)*(pventaneto+cargoflete))), if (cantidade is null, cantidad, cantidad-cantidade), 0, margenlinea, null, unimed, codtipo, codsubtipo, '$ses_usr_login', now(), '$ses_usr_login', now() 
						FROM cotizacion_d
						WHERE id_cotizacion = ".$List->getelem()->id_cotizacion ." and cantidad > 0 and (cantidade is null or cantidade < cantidad)";
            $res = $this->bd->querynoselect($query);
            if (!$res) {
            	$this->rollback();
            	throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            }
			//Recupero la suma de los productos de la cotizacion nueva
			$query = "	SELECT 	id_linea, totallinea
	                    FROM 	cotizacion_d
	                    WHERE 	id_cotizacion = " . ($id_cotizacion_ult+0) ."
						ORDER BY numlinea";
	        $res2 = $this->bd->query($query);
            if (!$res2) {
            	$this->rollback();
            	throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            }
            $suma = 0; 
	        $contador = 1;
	        while ($row = $res2->fetch_assoc()) {
		        $suma += $row['totallinea'];
		        //Actualizamos el n煤mero de l铆nea
				$queryn = "	UPDATE 	cotizacion_d 
							SET 	numlinea = $contador 
		                    WHERE 	id_linea = ".$row['id_linea'] ;
		        $res3 = $this->bd->query($queryn);
	            if (!$res3) {
	            	$this->rollback();
	            	throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $queryn, 1);
	            }
		        $contador++;
	        }
            //Actualizo el total de la cotizacion
            $query = "	UPDATE 	cotizacion_e 
						SET 	valortotal = $suma 
	                    WHERE 	id_cotizacion = " . ($id_cotizacion_ult+0) ;
            $res = $this->bd->querynoselect($query);
            if (!$res) {
            	$this->rollback();
            	throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            }
            
            $this->commit();
            $List->getelem()->id_cotizacion = $id_cotizacion_ult;
            return true;
    	}
    	return false;
    }

    public function gennve($List) {
    	global $ses_usr_login;
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("N煤mero incorrecto de elementos", 0);
    	}
    	if ($List->getelem()->id_cotizacion){
    		//Duplicamos el encabezado
            $query = "	UPDATE cotizacion_e 
                        SET	id_estado = 'CV'
							, nvevaliddesde = '".$List->getelem()->nvevaliddesde."'
							, nvevalidhasta = '".$List->getelem()->nvevalidhasta."'
                        	, razonsoc = '". addslashes($List->getelem()->razonsoc) . "'
                        	, id_giro = '". $List->getelem()->id_giro . "'
                        	, giro = '". addslashes($List->getelem()->giro) . "'
                        	, direccion = '". addslashes($List->getelem()->direccion) . "'
                        	, comuna = '". $List->getelem()->comuna . "'
                        	, fonocontacto = '". $List->getelem()->fonocontacto . "'
	                        , usrmod = '".$ses_usr_login."'
	                        , fecmod = now()
                        WHERE id_cotizacion = ".$List->getelem()->id_cotizacion ;
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
			return true;
    	}
    	return false;
    }

    public function getcotizacionsap($List) {
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("Numero incorrecto de elementos", 0);
    	}
    	if ($List->getelem()->id_cotizacion){
    		//Obtenemos el precio del flete para la cotizaci髇 buscada
			$query = "	SELECT 	sum(cargoflete*cantidad) cargo
	                    FROM 	cotizacion_d
	                    WHERE 	id_cotizacion = ".$List->getelem()->id_cotizacion;
    	    $res = $this->bd->query($query);
    	    //general::writeevent($query);
        	if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        	$List->clearlist();
	        while ($row = $res->fetch_assoc()){
	            $Cotizacion = new dtodetcotizacion;
	            $Cotizacion->cargoflete  = 	$row['cargo'];
	            $List->addlast($Cotizacion);            }
        	$res->free();
			return true;
    	}
    }
    
    /*Actualizar Total de la OE*/
	public function updatecoti($idcotizacion,$sumtotal,$totaliva,$totalica,$totalrenta,$rete_iva2){
    	
    	$query = "UPDATE cotizacion_e
    	          SET rete_iva = ".$rete_iva2.",
    	          rete_ica = ".$totalica.",
    	          rete_renta = ".$totalrenta.",
    	          cot_iva = ".$totaliva.",
    	          valortotal = ".$sumtotal."
    	          WHERE id_cotizacion = ".$idcotizacion."";
    	          
    	$res = $this->bd->query($query);
        
    	if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);         
        
        return true;
    }
    /*Fin Actualizar Total de la OE*/

	public function getfletesap($List) {
    	$List->gofirst();

		if ($List->getelem()->id_cotizacion){
    		//Obtenemos el precio del flete para la cotizaci髇 buscada
			$query = "	SELECT 	sum(pventaneto*cantidad) cargo,
						sum(cargoflete) flete
	                    FROM 	cotizacion_d
	                    WHERE 	id_cotizacion = '".$List->getelem()->id_cotizacion."'
                        " . (($List->getelem()->numlinea)? " and numlinea <(".$List->getelem()->numlinea.")" : "") . "
						" . (($List->getelem()->numlinea1)? " and numlinea >(".$List->getelem()->numlinea1.")" : "") . "
						ORDER BY numlinea ASC";
    	    $res = $this->bd->query($query);
    	    //general::writeevent($query);
        	if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        	$List->clearlist();
	        while ($row = $res->fetch_assoc()){
	            $Cotizacion = new dtocotizacion;
	            $Cotizacion->cargoflete  = 	$row['cargo'];
	            $Cotizacion->flete  = 	$row['flete'];
	            $List->addlast($Cotizacion);            }
        	$res->free();
			return true;
    	}
    }
    
    public function caducacotizacion($List) {
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("N煤mero incorrecto de elementos", 0);
    	}
    	if ($List->getelem()->id_cotizacion){
    		//Cambiamos el estado
            $query = "	UPDATE cotizacion_e 
                        SET	id_estado = '".$List->getelem()->estado."'
	                        , usrmod = '".$List->getelem()->usrmod."'
	                        , fecmod = now()
                        WHERE id_cotizacion = ".$List->getelem()->id_cotizacion;
            
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
			return true;
    	}
    	return false;
    }
    
    public function ActualizaNumDocOe($listencdoc, $ides_linea, $documento_tipo) {
    	global $ses_usr_login;

    	if (!$listencdoc) return true;
		if (!$listencdoc->numelem()) return true;
		
    	$listencdoc->gofirst();
        $query = "	UPDATE ordenent_d 
                    SET	$documento_tipo = " . ($listencdoc->getelem()->id_documento) . "
                    , usrmod = '".$ses_usr_login."' 
                    , fecmod = now()
                    WHERE id_linea in (0".($ides_linea).")" ;
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

		return true;
    }

    private function escotivigente($List) {
		$List->gofirst();
        $query = "	SELECT validhasta >= CURDATE() vigente
					FROM cotizacion_e
					WHERE id_cotizacion = " . $List->getelem()->id_cotizacion ; 
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $row = $res->fetch_assoc(); 
        return $row['vigente'];
    }
    
}
?>