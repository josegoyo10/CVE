<?php
class daoordenpicking{
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

    public function getencordenpicking($List) {
		$List->gofirst();
		$query = "	SELECT  op.id_ordenpicking, 
                            op.id_ordenent,  
                            op.id_estado,  
							oe.id_cotizacion,
							op.id_prioridad,
							oe.numdocpago factura, 
                            e.descripcion as nomestado,
							pri.descripcion as nomprioridad,
                            op.id_direccion,  
                            op.rutcliente,  
                            op.cod_local,  
                            l.nom_local,
                            te.id_tipoentrega, 
                            te.descripcion as nomtipoentrega,
                            op.razonsoc,  
                            op.direccion,  
                            op.comuna,  
                            op.fonocontacto,  
                            op.observaciones,  
                            op.nota,  
                            op.id_usuario,  
                            op.usuariocrea,
                            op.feccrea,
                            op.n_impresiones,
                            op.usuario_impresion,
                            oe.fecha_retira_cliente,
                            oe.fecha_retira_inmediato,
                            oe.fecha_despacho_programado,
                            oe.zona
							
                    FROM 	ordenpicking_e op 
                    LEFT JOIN 	estado e on e.id_estado = op.id_estado
					LEFT JOIN 	prioridad pri on pri.id_prioridad = op.id_prioridad 
					LEFT JOIN 	ordenent_e oe on oe.id_ordenent = op.id_ordenent 
                    LEFT JOIN 	tipoentrega te on te.id_tipoentrega = oe.id_tipoentrega 
                    LEFT JOIN 	locales l on l.cod_local = op.cod_local 
                    WHERE 	1 
                    " . (($List->getelem()->id_ordenpicking)? " and id_ordenpicking = ".$List->getelem()->id_ordenpicking." " : "") . "
                    " . (($List->getelem()->id_ordenent)? " and op.id_ordenent = ".$List->getelem()->id_ordenent." " : "") . "
                    " . (($List->getelem()->id_tipoentrega)? " and oe.id_tipoentrega = ".$List->getelem()->id_tipoentrega." " : "") . "
                    " . (($List->getelem()->id_direccion)? " and op.id_direccion = ".$List->getelem()->id_direccion." " : "") . "
                    " . (($List->getelem()->rutcliente)? " and op.rutcliente = ".$List->getelem()->rutcliente." " : "") . "
                    " . (($List->getelem()->razonsoc)? " and op.razonsoc like '%".addslashes($List->getelem()->razonsoc)."%'" : "") . "
                   	" . (($List->getelem()->fechaucofini)? " and op.feccrea >= '".$List->getelem()->fechaucofini."'" : "") . "
                    " . (($List->getelem()->fechaucoffin)? " and op.feccrea <= '".$List->getelem()->fechaucoffin."'" : "") . "
					" . (($List->getelem()->prioridad)? " and op.id_prioridad = '".$List->getelem()->prioridad."' " : "") . "
					" . (($List->getelem()->cod_local)? " and op.cod_local = '".$List->getelem()->cod_local."' " : "") . "
                    " . (($List->getelem()->id_estado)? " and op.id_estado = '".$List->getelem()->id_estado."' " : "") . "
                    ORDER BY  id_estado ASC, id_prioridad DESC, id_ordenpicking ASC"  . "
                    " . (($List->getelem()->limite)? " LIMIT ".$List->getelem()->limite : "") . "";
       /* 
		$query1 = "	SELECT COUNT(*) cont
                    FROM 	ordenpicking_e op
                    LEFT JOIN 	estado e on e.id_estado = op.id_estado
					LEFT JOIN 	prioridad pri on pri.id_prioridad = op.id_prioridad 
					LEFT JOIN 	ordenent_e oe on oe.id_ordenent = op.id_ordenent 
                    LEFT JOIN 	tipoentrega te on te.id_tipoentrega = oe.id_tipoentrega 
                    LEFT JOIN 	locales l on l.cod_local = op.cod_local
                    WHERE 	1 
                    " . (($List->getelem()->id_ordenpicking)? " and id_ordenpicking = ".$List->getelem()->id_ordenpicking." " : "") . "
                    " . (($List->getelem()->id_ordenent)? " and op.id_ordenent = ".$List->getelem()->id_ordenent." " : "") . "
                    " . (($List->getelem()->id_tipoentrega)? " and oe.id_tipoentrega = ".$List->getelem()->id_tipoentrega." " : "") . "
                    " . (($List->getelem()->id_direccion)? " and op.id_direccion = ".$List->getelem()->id_direccion." " : "") . "
                    " . (($List->getelem()->rutcliente)? " and op.rutcliente = ".$List->getelem()->rutcliente." " : "") . "
                    " . (($List->getelem()->razonsoc)? " and op.razonsoc like '%".addslashes($List->getelem()->razonsoc)."%'" : "") . "
                   	" . (($List->getelem()->fechaucofini)? " and op.feccrea >= '".$List->getelem()->fechaucofini."'" : "") . "
                    " . (($List->getelem()->fechaucoffin)? " and op.feccrea <= '".$List->getelem()->fechaucoffin."'" : "") . "
					" . (($List->getelem()->prioridad)? " and op.id_prioridad = '".$List->getelem()->prioridad."' " : "") . "
					" . (($List->getelem()->cod_local)? " and op.cod_local = '".$List->getelem()->cod_local."' " : "") . "
                    " . (($List->getelem()->id_estado)? " and op.id_estado = '".$List->getelem()->id_estado."' " : "") ;


        $res1 = $this->bd->query($query1);
        if (!$res1) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query1, 1);
        $row1 = $res1->fetch_assoc();
        $total_orden_pick		= 	$row1['cont'];*/
        $total_orden_pick               =       $List->getelem()->limite;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Cotizacion = new dtoencordenpicking;
            $Cotizacion->id_ordenpicking= 	$row['id_ordenpicking'];
            $Cotizacion->id_ordenent	= 	$row['id_ordenent'];				
            $Cotizacion->id_cotizacion	= 	$row['id_cotizacion'];				
            $Cotizacion->factura		= 	$row['factura'];
            $Cotizacion->id_estado		= 	$row['id_estado'];
            $Cotizacion->nomestado		= 	$row['nomestado'];					
            $Cotizacion->id_direccion	= 	$row['id_direccion'];	
            $Cotizacion->id_tipoentrega	= 	$row['id_tipoentrega'];	
            $Cotizacion->nomtipoentrega	= 	$row['nomtipoentrega'];	
            $Cotizacion->rutcliente		= 	$row['rutcliente'];	
            $Cotizacion->cod_local		= 	$row['cod_local'];
            $Cotizacion->nom_local		= 	$row['nom_local'];
            $Cotizacion->razonsoc		= 	$row['razonsoc'];	
            $Cotizacion->direccion		= 	$row['direccion'];											
            $Cotizacion->comuna			= 	$row['comuna'];	
            $Cotizacion->fonocontacto	= 	$row['fonocontacto'];	
            $Cotizacion->observaciones	= 	$row['observaciones'];	
            $Cotizacion->nota			= 	$row['nota'];	
            $Cotizacion->id_usuario		= 	$row['id_usuario'];
            $Cotizacion->usuariocrea	= 	$row['usuariocrea'];
            $Cotizacion->feccrea		= 	$row['feccrea'];      
            $Cotizacion->prioridad		= 	$row['id_prioridad'];  
            $Cotizacion->nomprioridad	= 	$row['nomprioridad'];    
            $Cotizacion->puedever		= 	(($row['id_estado']=='PC')?true:true);
            $Cotizacion->puedemodificar	= 	(($row['id_estado']=='PC')?true:false);
            $Cotizacion->total_orden_pick =	$total_orden_pick;
            $Cotizacion->n_impresiones	= 	$row['n_impresiones'];
            $Cotizacion->usuario_impresion	= 	$row['usuario_impresion'];
            $Cotizacion->fecha_retira_cliente	= 	$row['fecha_retira_cliente'];
            $Cotizacion->fecha_retira_inmediato	= 	$row['fecha_retira_inmediato'];
            $Cotizacion->fecha_despacho_programado	= 	$row['fecha_despacho_programado'];
            $Cotizacion->zona	= 	$row['zona'];
            $List->addlast($Cotizacion);
        }
        $res->free();
        return true;
    }
    
    public function getMonitorordenpicking($List) {
		$List->gofirst();
		$query = "	SELECT  op.id_ordenpicking, 
                            op.id_ordenent,  
                            op.id_estado,  
							op.id_prioridad,
                            e.descripcion as nomestado,
							pri.descripcion as nomprioridad,
                            op.rutcliente,  
                            op.cod_local,  
                            l.nom_local,
                            te.id_tipoentrega, 
                            te.descripcion as nomtipoentrega,
                            op.razonsoc,  
                            op.usuariocrea,
                            op.feccrea							
                    FROM 	ordenpicking_e op 
                    LEFT JOIN 	estado e on e.id_estado = op.id_estado
					LEFT JOIN 	prioridad pri on pri.id_prioridad = op.id_prioridad 
					LEFT JOIN 	ordenent_e oe on oe.id_ordenent = op.id_ordenent 
                    LEFT JOIN 	tipoentrega te on te.id_tipoentrega = oe.id_tipoentrega 
                    LEFT JOIN 	locales l on l.cod_local = op.cod_local 
                    WHERE 	1 and op.id_estado <> 'ES'
                    " . (($List->getelem()->id_ordenpicking)? " and id_ordenpicking = ".$List->getelem()->id_ordenpicking." " : "") . "
                    " . (($List->getelem()->id_ordenent)? " and op.id_ordenent = ".$List->getelem()->id_ordenent." " : "") . "
                    " . (($List->getelem()->id_tipoentrega)? " and oe.id_tipoentrega = ".$List->getelem()->id_tipoentrega." " : "") . "
                    " . (($List->getelem()->rutcliente)? " and op.rutcliente = ".$List->getelem()->rutcliente." " : "") . "
                    " . (($List->getelem()->razonsoc)? " and op.razonsoc like '%".addslashes($List->getelem()->razonsoc)."%'" : "") . "
                   	" . (($List->getelem()->fechaucofini)? " and op.feccrea >= '".$List->getelem()->fechaucofini."'" : "") . "
                    " . (($List->getelem()->fechaucoffin)? " and op.feccrea <= '".$List->getelem()->fechaucoffin."'" : "") . "
					" . (($List->getelem()->prioridad)? " and op.id_prioridad = '".$List->getelem()->prioridad."' " : "") . "
					" . (($List->getelem()->cod_local)? " and op.cod_local = '".$List->getelem()->cod_local."' " : "") . "
                    " . (($List->getelem()->id_estado)? " and op.id_estado = '".$List->getelem()->id_estado."' " : "") . "
                    ORDER BY op.id_ordenpicking DESC"  . "
                    " . (($List->getelem()->limite)? " LIMIT ".$List->getelem()->limite : "") . "";
        $total_orden_pick               =       $List->getelem()->limite;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Cotizacion = new dtoencordenpicking;
            $Cotizacion->id_ordenpicking= 	$row['id_ordenpicking'];
            $Cotizacion->id_ordenent	= 	$row['id_ordenent'];				
            $Cotizacion->id_estado		= 	$row['id_estado'];
            $Cotizacion->nomestado		= 	$row['nomestado'];					
            $Cotizacion->id_tipoentrega	= 	$row['id_tipoentrega'];	
            $Cotizacion->nomtipoentrega	= 	$row['nomtipoentrega'];	
            $Cotizacion->rutcliente		= 	$row['rutcliente'];	
            $Cotizacion->cod_local		= 	$row['cod_local'];
            $Cotizacion->nom_local		= 	$row['nom_local'];
            $Cotizacion->razonsoc		= 	$row['razonsoc'];	
            $Cotizacion->direccion		= 	$row['direccion'];											
            $Cotizacion->usuariocrea	= 	$row['usuariocrea'];
            $Cotizacion->feccrea		= 	$row['feccrea'];      
            $Cotizacion->prioridad		= 	$row['id_prioridad'];  
            $Cotizacion->nomprioridad	= 	$row['nomprioridad'];    
            $Cotizacion->puedever		= 	(($row['id_estado']=='PC')?true:true);
            $Cotizacion->puedemodificar	= 	(($row['id_estado']=='PC')?true:false);
            $Cotizacion->total_orden_pick =	$total_orden_pick;
            $List->addlast($Cotizacion);
        }
        $res->free();
        return true;
    }

    public function getdetordenpicking($List) {
		$List->gofirst();
    $query = "SELECT picd.id_linea,
                          id_ordenpicking,
                          picd.numlinea as numlinea,
                          picd.descripcion as descripcion,
                          picd.codprod as codprod,
                          picd.barra as barra,
                          picd.cantidad as cantidad,
                          picd.totallinea as totallinea,
                          picd.cantidadp as cantidadp,
			                    picd.id_lineadoc as id_lineadoc,
                          picd.unimed as unimed,
                          if(p.id_prod_tipo is null,'PS',picd.codtipo) as codtipo,
                          if(p.tipificacion_tipo_producto is null,'Producto en Stock',p.tipificacion_tipo_producto) as nomtipoproduct
                    FROM  ordenpicking_d picd
                    join  ordenpicking_e pice using(id_ordenpicking)
                    left outer join  producto_tipo p on (p.id_prod_tipo=picd.codtipo)
                    WHERE picd.codtipo <> 'SV' " . (($List->getelem()->id_ordenpicking)? " and id_ordenpicking = ".$List->getelem()->id_ordenpicking." " : "") . "
		       ";
        /*$query = " SELECT picd.id_linea,
                          id_ordenpicking,
                          picd.numlinea as numlinea,
                          picd.descripcion as descripcion,
                          picd.codprod as codprod,
                          picd.barra as barra,
                          picd.cantidad as cantidad,
                          picd.totallinea as totallinea,
                          picd.cantidadp as cantidadp,
						  picd.id_lineadoc as id_lineadoc,
                          picd.unimed as unimed,
                          cotd.codtipo as codtipo,
                          prodt.tipificacion_tipo_producto as nomtipoproduct,
                          cotd.id_tiporetiro,
                          cotd.id_tipoentrega,
                          cotd.pventaneto,
                          cotd.peso
                    FROM  ordenpicking_d picd join ordenpicking_e pice using(id_ordenpicking)
                    join  ordenent_e ore using(id_ordenent)
                    join  cotizacion_e cot using (id_cotizacion)
                    join  cotizacion_d cotd using (id_cotizacion)
                    inner join  producto_tipo prodt
                    WHERE prodt.id_prod_tipo=cotd.codtipo and picd.codprod=cotd.codprod and ore.id_ordenent=pice.id_ordenent and picd.codtipo <> 'SV' 
                    " . (($List->getelem()->id_ordenpicking)? " and id_ordenpicking = ".$List->getelem()->id_ordenpicking." " : "") . "
                    ";*/
        //general::writelog("Sentencia Picking : ".$query );
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetordenpicking;
            $Registro->id_linea			= 	$row['id_linea'];
            $Registro->id_ordenpicking	= 	$row['id_ordenpicking'];	
            $Registro->numlinea			= 	$row['numlinea'];					
            $Registro->descripcion		= 	$row['descripcion'];
            $Registro->codprod			= 	$row['codprod'];				
            $Registro->barra			= 	$row['barra'];	
            $Registro->cantidad			= 	$row['cantidad'];								
            $Registro->id_lineadoc		= 	$row['id_lineadoc'];								
            $Registro->totallinea		= 	$row['totallinea'];	
            $Registro->cantidadp		= 	$row['cantidadp'];	
            $Registro->unimed			= 	$row['unimed'];
            $Registro->nomtipoproduct	= 	$row['nomtipoproduct'];
            $Registro->codtipo			= 	$row['codtipo'];
            $Registro->id_tiporetiro	= 	$row['id_tiporetiro'];
            $Registro->id_tipoentrega	= 	$row['id_tipoentrega'];
            $Registro->pventaneto		= 	$row['pventaneto'];
            $Registro->peso				= 	$row['peso'];					
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    /*Obtener peso de coti en pick*/
    public function getpesopicking($List){
    	
    	$List->gofirst();
    	$query = "SELECT              
    	            picd.id_ordenpicking,
                    picd.id_ordenent,
                    oed.peso
                    FROM  ordenpicking_e picd 
                    left join ordenent_d oed on oed.id_ordenent = picd.id_ordenent
                    WHERE " . (($List->getelem()->id_ordenpicking)? " id_ordenpicking = ".$List->getelem()->id_ordenpicking." " : "") . "
		       ";
        
        //general::writelog("Sentencia Picking : ".$query );
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetordenpicking;
            $Registro->peso				= 	$row['peso'];					
            $List->addlast($Registro);
        }
        $res->free();
        return true;
       	
    }
    /*Fin Obtener peso coti en pick*/   
	public function getpedidoespecialgenerico($List){
    	
    	$List->gofirst();
    	$query = "SELECT 
    			  count(codtipo) as cantidad 
    			  FROM ordenpicking_d where codtipo='PE'  
    			  and id_ordenpicking= ".$List->getelem()->id_ordenpicking."";
        //general::writelog("Sentencia Picking : ".$query );
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodetordenpicking;
            $Registro->cantidad				= 	$row['cantidad'];					
            $List->addlast($Registro);
        }
        $res->free();
        return true;
       	
    }
    
	public function getcountenespera($List){
    	
    	$List->gofirst();
    	$query = "SELECT id_ordenpicking FROM ordenpicking_e where id_estado='ES'   
    			  and id_ordenent= ".$List->getelem()->id_ordenent."";
        //general::writelog("Sentencia Picking : ".$query );
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoencordenpicking;
            $Registro->id_ordenpicking		= 	$row['id_ordenpicking'];					
            $List->addlast($Registro);
        }
        $res->free();
        return true;
       	
    }
    
	public function setOpestadopegenerico($List){
    	
    	$List->gofirst();
    	$query = "UPDATE ordenpicking_e
    			  SET id_estado = '". $List->getelem()->id_estado . "'
    			  WHERE 	1 
                  " . (($List->getelem()->id_ordenpicking)? " and id_ordenpicking = ".$List->getelem()->id_ordenpicking." " : "") . " 
                  " . (($List->getelem()->id_ordenent)? " and id_estado='ES' and id_ordenent= ".$List->getelem()->id_ordenent." " : "") ."";       
        //general::writelog("Sentencia Picking : ".$query );
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        return true;
    }
    
	public function dividirpedidoespecial_pnormal($List){
    	
    	$List->gofirst();
    	$query = "SELECT count(codtipo) as cantidad FROM ordenpicking_d where codtipo='PS' and id_ordenpicking=".$List->getelem()->id_ordenpicking."";       

        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
        while ($row = $res->fetch_assoc()){
            //$Registro = new dtodetordenpicking;	
            $Registrocantidad= 	$row['cantidad'];								           					
            //$List->addlast($Registro);
        }
        $res->free();
        if($Registrocantidad > 0){
        $query="insert into ordenpicking_e (id_ordenpicking, id_ordenent, id_estado, id_direccion, rutcliente, cod_local, razonsoc, direccion, comuna, fonocontacto, observaciones, nota, id_usuario, usuariocrea, usrcrea, feccrea, usrmod, fecmod, id_prioridad, n_impresiones, usuario_impresion)
		select NULL,id_ordenent, 'PC', id_direccion, rutcliente, cod_local, razonsoc, direccion, comuna, fonocontacto, observaciones, nota, id_usuario, usuariocrea, usrcrea, feccrea, usrmod, fecmod, id_prioridad, n_impresiones, usuario_impresion ordenpicking_e FROM ordenpicking_e where id_ordenpicking=".$List->getelem()->id_ordenpicking."";
        $res = $this->bd->querynoselect($query);
        
        	if (!$res){
            	$this->rollback();
            	throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            }
            $id_ordenpicking_ult = $this->bd->last_insert_id();
            $query="insert into ordenpicking_d (id_linea, id_ordenpicking, numlinea, descripcion, codprod, barra, cantidad, totallinea, cantidadp, id_lineadoc, codtipo, codsubtipo, usrcrea, feccrea, usrmod, fecmod, unimed)
			SELECT NULL,".($id_ordenpicking_ult+0).", numlinea, descripcion, codprod, barra, cantidad, totallinea, cantidadp, id_lineadoc, codtipo, codsubtipo, usrcrea, feccrea, usrmod, fecmod, unimed FROM ordenpicking_d where codtipo <>'PE' and id_ordenpicking=".$List->getelem()->id_ordenpicking."";
            $res = $this->bd->querynoselect($query);
            
        	if (!$res){
            	$this->rollback();
            	throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            }
            $query="delete from ordenpicking_d where codtipo <>'PE' and id_ordenpicking=".$List->getelem()->id_ordenpicking."";
            $res = $this->bd->querynoselect($query);
        	
            if (!$res){
            	$this->rollback();
            	throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            }  
			
        	$query="insert into documento_e (id_documento, id_tipodocumento, id_tipoorigen, estado, sigtipodoc, pagina, tipoorigen, numorigen, numdocumento, fechadocumento, numdocref, numdocrefop, codigovendedor, rutcliente, razonsoc, id_giro, giro, direccion, comuna, iva, totaltexto, totalnum, totaliva, totalnumiva, condicion, diascondicion, fonocontacto, observaciones, nota, codlocalventa, codlocalcsum, lockprintgde, lockprintfct, indmsgsap, indodeasap, indnullsap, usrcrea, feccrea, usrmod, fecmod, mediopago, nreimpresion)
			SELECT NULL, id_tipodocumento, id_tipoorigen, estado, sigtipodoc,2, tipoorigen, numorigen, numdocumento, fechadocumento, numdocref,".$id_ordenpicking_ult.", codigovendedor, rutcliente, razonsoc, id_giro, giro, direccion, comuna, iva, totaltexto, totalnum, totaliva, totalnumiva, condicion, diascondicion, fonocontacto, observaciones, nota, codlocalventa, codlocalcsum, lockprintgde, lockprintfct, indmsgsap, indodeasap, indnullsap, usrcrea, feccrea, usrmod, fecmod, mediopago, nreimpresion FROM documento_e where sigtipodoc='GDE' and numdocrefop=".$List->getelem()->id_ordenpicking."";
            $res = $this->bd->querynoselect($query);
            
        	if (!$res){
            	$this->rollback();
            	throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            }
            
            $id_documento_ult = $this->bd->last_insert_id();
            $query="insert into documento_d (id_linea, id_documento, numlinea, descripcion, codprod, barra, pventaneto, pventaiva, cantidad, pcosto, totallinea, impuesto1, impuesto2, codtipo, codsubtipo, id_linearef, usrcrea, feccrea, usrmod, fecmod, unimed, rutproveedor, nomproveedor, marcaflete, iva)
			SELECT NULL,".($id_documento_ult+ 0).", numlinea, descripcion, codprod, barra, pventaneto, pventaiva, cantidad, pcosto, totallinea, impuesto1, impuesto2, codtipo, codsubtipo, id_linearef, usrcrea, feccrea, usrmod, fecmod, unimed, rutproveedor, nomproveedor, marcaflete, iva
			FROM documento_d where codtipo <>'PE' and id_documento =(SELECT id_documento FROM documento_e where sigtipodoc='GDE' and numdocrefop=".$List->getelem()->id_ordenpicking.")";
            $res = $this->bd->querynoselect($query); 

        	if (!$res){
            	$this->rollback();
            	throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            }
            
            $query="delete from documento_d where codtipo <>'PE' and id_documento =(SELECT id_documento FROM documento_e where sigtipodoc='GDE' and numdocrefop=".$List->getelem()->id_ordenpicking.")";
            $res = $this->bd->querynoselect($query);
        	
            if (!$res){
            	$this->rollback();
            	throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            }  
        }
        
        $List->clearlist();
        $Registro = new dtodetordenpicking;
        $Registro->id_ordenpicking	= 	$id_ordenpicking_ult;
        $List->addlast($Registro);
        return true;
    }
    
    public function saveencordenpicking($List) {
    	global $ses_usr_login, $ses_usr_id;
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("N&uacute;mero incorrecto de elementos", 0);
    	}
		
    	if ($List->getelem()->id_ordenpicking){
    		//Es una orden de entrega antigua, se hace UPDATE
            $query = "	UPDATE ordenpicking_e 
                        SET	usrcrea = usrcrea
                        " . (($List->getelem()->id_ordenent)? ", id_ordenent = ". $List->getelem()->id_ordenent : "") . "
                        " . (($List->getelem()->id_estado)? ", id_estado = '". $List->getelem()->id_estado . "'": "") . "
                        " . (($List->getelem()->id_direccion)? ", id_direccion = ". $List->getelem()->id_direccion : "") . "
                        " . (($List->getelem()->rutcliente)? ", rutcliente = ". $List->getelem()->rutcliente : "") . "
                        " . (($List->getelem()->cod_local)? ", cod_local = '". $List->getelem()->cod_local . "'" : "") . "
                        " . (($List->getelem()->razonsoc)? ", razonsoc = '". addslashes($List->getelem()->razonsoc) . "'" : "") . "
                        " . (($List->getelem()->direccion)? ", direccion = '". addslashes($List->getelem()->direccion) . "'" : "") . "
                        " . (($List->getelem()->comuna)? ", comuna = '". $List->getelem()->comuna . "'" : "") . "
                        " . (($List->getelem()->fonocontacto)? ", fonocontacto = '". $List->getelem()->fonocontacto . "'" : "") . "
                        " . (($List->getelem()->observaciones)? ", observaciones = '". $List->getelem()->observaciones . "'" : "") . "
                        " . (($List->getelem()->nota)? ", nota = '". $List->getelem()->nota . "'" : "") . "
                        , id_usuario = $ses_usr_id 
                        , usuariocrea = '".$ses_usr_login."'
                        , usrmod = '".$ses_usr_login."' 
                        , fecmod = now()
                        WHERE id_ordenpicking = ".$List->getelem()->id_ordenpicking ;
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

            return true;
    	}
    	else {
	    	//Es una orden nueva, se hace INSERT
            $query = "	INSERT INTO ordenpicking_e (
							id_ordenpicking,
							id_ordenent,
							id_estado,
							id_direccion,
							rutcliente,
							cod_local,
							razonsoc,
							direccion,
							comuna,
							fonocontacto,
							observaciones,
							nota,
							id_usuario,
							usuariocrea,
							id_prioridad, 
							usrcrea,
							feccrea,
							usrmod,
							fecmod
                        )
                        VALUES (
                            null,
                            ".($List->getelem()->id_ordenent+0).",
                            'PC',
                            ".$List->getelem()->id_direccion/*(($List->getelem()->id_direccion)?$List->getelem()->id_direccion:'null')*/.",
                            ".($List->getelem()->rutcliente+0).",
                            '".$List->getelem()->cod_local."',
                            '".addslashes($List->getelem()->razonsoc)."',
                            '".addslashes($List->getelem()->direccion)."',
                            '".$List->getelem()->comuna."',
                            '".$List->getelem()->fonocontacto."',
                            '".addslashes($List->getelem()->observaciones)."',
                            '".$List->getelem()->nota."',
                            ".($ses_usr_id+0).",
                            '".$ses_usr_login."',
                            ".((!$List->getelem()->prioridad)?1:$List->getelem()->prioridad).",
                            '".$ses_usr_login."',
                            now(),
                            '".$ses_usr_login."',
                            now()
                        )";
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

            $List->getelem()->id_ordenpicking = $this->bd->last_insert_id();
            return true;
    	}
    }

	public function guardarhistoria($List) {
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("N&uacute;mero incorrecto de elementos", 0);
    	}		
    	if ($List->getelem()->id_ordenpicking){
            $query = "insert into h_impresiones_picking (id_ordenpicking, usuario_impresion, fecha_hora, n_impresiones) values (".$List->getelem()->id_ordenpicking."," . (($List->getelem()->usuario_impresion)? "". $List->getelem()->usuario_impresion : "".$_SESSION["ses_usr_id"]).",now(),".$List->getelem()->n_impresiones.")" ;
            																									 

            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

            return true;
    	}
    }
    
	public function addimpresionordenpicking($List) {
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
    	}		
    	if ($List->getelem()->id_ordenpicking){
            $query = "	update ordenpicking_e set n_impresiones=n_impresiones+1,usuario_impresion='".$List->getelem()->usuario_impresion."' where id_ordenpicking in ("
            .$List->getelem()->id_ordenpicking.")" ;
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

            return true;
    	}
    }
    
	public function addimpresionhistrial($List) {
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
    	}		
    	if ($List->getelem()->id_ordenpicking){
            $query = "	update ordenpicking_e set n_impresiones=n_impresiones+1,usuario_impresion='".$List->getelem()->usuario_impresion."' where id_ordenpicking in ("
            .$List->getelem()->id_ordenpicking.")" ;
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

            return true;
    	}
    }

    public function deldetordenpicking($List) {
    	$List->gofirst();
    	if ($List->numelem()!=1){
            throw new CTRLException("NÃºmero incorrecto de elementos", 0);
    	}		
    	if ($List->getelem()->id_ordenpicking){
    		//Es una OP antigua, se el DELETE
            $query = "	DELETE FROM ordenpicking_d
                        WHERE id_ordenpicking = ".$List->getelem()->id_ordenpicking ;
            $res = $this->bd->querynoselect($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

            return true;
    	}
    }
    
    public function savedetordenpicking($ListEnc, $ListDet) {
    	global $ses_usr_login;
    	$ListEnc->gofirst();
    	if ($ListEnc->numelem()!=1){
            throw new CTRLException("NÃºmero incorrecto de elementos", 0);
    	}
		if (!$ListEnc->getelem()->id_ordenpicking){
            throw new CTRLException("No viene Id Orden de Picking", 0);
    	}
    	
    	if (!$ListDet)
    		return true;

    	$ListDet->gofirst();
    	$linecounter = 1;
		if (!$ListDet->isvoid()) {
			do {
				if ($ListDet->getelem()->codprod=='12501'){
					$ListDet->getelem()->cantidadp = $ListDet->getelem()->cantidad;

				}
				//Insertamos los registros de detalle
                $query = "	INSERT INTO ordenpicking_d (
								id_linea,
								id_ordenpicking,
								numlinea,
								descripcion,
								codprod,
								barra,
								cantidad,
								cantidadp,
								id_lineadoc, 
								totallinea,
								unimed,
								codtipo,
								codsubtipo,
								usrcrea,
								feccrea,
								usrmod,
								fecmod
                            )
                            VALUES (
                                null,
                                ".$ListEnc->getelem()->id_ordenpicking.",
								".($linecounter+0).",
                                '".addslashes($ListDet->getelem()->descripcion)."',
                                ".($ListDet->getelem()->codprod+0).",
                                '".$ListDet->getelem()->barra."',
                                ".($ListDet->getelem()->cantidad+0).",
                                ".($ListDet->getelem()->cantidadp+0).",
                                ".($ListDet->getelem()->id_lineadoc+0).",
                                ".($ListDet->getelem()->totallinea+0).",
                                '".$ListDet->getelem()->unimed."',
                                '".$ListDet->getelem()->codtipo."',
                                '".$ListDet->getelem()->codsubtipo."',
                                '".$ses_usr_login."',
                                now(),
                                '".$ses_usr_login."',
                                now()
                            )";
                $res = $this->bd->querynoselect($query);
                //general::writeevent($query);
                $linecounter++;
                if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
			} while ($ListDet->gonext());
		}
		return true;
    }
}
?>
