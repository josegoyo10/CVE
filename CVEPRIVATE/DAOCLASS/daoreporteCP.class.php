<?php
class daoreporte{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   
	    
	/* Reporte cuadratura*/
    public function getreportecuadratura($List) {
		$List->gofirst();
		$query="SELECT 	d.numdocumento,
						td.sigtipodoc,
						DATE_FORMAT(d.fechadocumento, '%d-%m-%Y') fechadocumento,
						l1.nom_local nomlocemi,
						l2.nom_local nomloccsum,
						d.rutcliente,
						c.razonsoc,
						c.id_tipodocpago,
						c.id_contribuyente,
						tdp.descripcion nommedpag,
						oe.numdocpago,
						d.diascondicion,
						d.totalnum,
						d.totaliva,
						d.totalnumiva,
						d.codigovendedor
				FROM documento_e d
					left join tipodocumento td on td.id_tipodocumento = d.id_tipodocumento
					left join locales l1 on l1.cod_local = d.codlocalventa
					left join locales l2 on l2.cod_local = d.codlocalcsum
					left join cliente c on d.rutcliente = c.rut
					join ordenent_e oe on oe.id_ordenent = d.numorigen and d.tipoorigen = 'OE' and oe.id_estado in ('OA', 'OB', 'OF', 'OG', 'OR')
					left join tipodocpago tdp on tdp.id_tipodocpago = oe.id_tipodocpago
				WHERE d.lockprintfct = 1
                    and d.id_tipodocumento in  (1, 3)
                    " . (($List->getelem()->codlocalemi)?" and d.codlocalventa = '".$List->getelem()->codlocalemi."' " : "") . "
                    " . (($List->getelem()->fecinicio)? " and d.fechadocumento >= '".$List->getelem()->fecinicio."'" : "") . "
                    " . (($List->getelem()->fectermino)? " and d.fechadocumento <= '".$List->getelem()->fectermino."'" : "") . "
                    " . (($List->getelem()->foliodesde)? " and d.numdocumento >= ".$List->getelem()->foliodesde."" : "") . "
                    " . (($List->getelem()->foliohasta)? " and d.numdocumento <= ".$List->getelem()->foliohasta."" : "") . "
            	order by 4 asc, 
                        1 asc LIMIT ".LIMITE_REPORTE_CUADRATURA."
				" ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoreporte;
			$Registro->numdocumento		=	$row['numdocumento'];
			$Registro->sigtipodoc		=	$row['sigtipodoc'];
			$Registro->fechadocumento	=	$row['fechadocumento'];
			$Registro->nomlocemi		=	$row['nomlocemi'];
			$Registro->nomloccsum		=	$row['nomloccsum'];
			$Registro->rutcliente		=	$row['rutcliente'];
			$Registro->id_contribuyente	=	$row['id_contribuyente'];
			$Registro->razonsoc			=	$row['razonsoc'];
			$Registro->nommedpag		=	$row['nommedpag'];
			$Registro->numdocpago		=	$row['numdocpago'];
			$Registro->tipopago			=	$row['id_tipodocpago'];
			$Registro->numdocref		=	$row['numdocref'];
			$Registro->totalnum			=	$row['totalnum'];
			$Registro->totaliva			=	$row['totaliva'];
			$Registro->totalnumiva		=	$row['totalnumiva'];
			$Registro->condicion_pago	=	$row['diascondicion'];
			$Registro->codigovendedor	=	$row['codigovendedor'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
	/* Reporte ventas por vendedor*/
    public function getreportevendedor($List) {
		$List->gofirst();
		$query="select MONTHNAME(fechacompra) as mes,
					   nom_local,
					   LEFT(fechacompra,4) as years,
					   count(*),
					   concat(usr_nombres, ' ', usr_apellidos) vendedor,
					   sum(margen),
					   sum(margen)/count(*) as margen_promedio,
					   sum(total) as total,
					   sum(descuento) as descuento 
					FROM (SELECT 	o.fechacompra,
							lo.nom_local,
							o.rutcliente,
							o.razonsoc,
							o.id_ordenent,
							sum(od.descuento) as descuento,
							estado.descripcion as estado,
							usu.usr_nombres,
							usu.usr_apellidos,
							usu.codigovendedor,
							sum(od.totallinea) as totaldet,
              				o.totaloe as total,
              				(round((((sum(od.totallinea)-(sum(od.pcosto* od.cantidade)))* 100)/sum(od.totallinea)) * 100)/100) as margen,
              				id_contribuyente,
              				numdocumento
					FROM ordenent_d od join ordenent_e o on (o.id_ordenent=od.id_ordenent and od.codtipo<>'SV')
						join cliente cli on(rut=rutcliente)
						join locales lo on (o.codlocalventa=cod_local)
						join estado on (o.id_estado=estado.id_estado)
						join usuarios usu on (usu.codigovendedor=o.codigovendedor)
						left join documento_e de on(de.sigtipodoc='FCT' and o.id_ordenent=de.numorigen)
					where o.id_estado='OG' 
					" . (($List->getelem()->fecinicio)? " and o.fechacompra >= '".$List->getelem()->fecinicio."'" : "") . "
			        " . (($List->getelem()->fectermino)? " and o.fechacompra <= '".$List->getelem()->fectermino."'" : "") . "
					" . (($List->getelem()->codvendedor)? " and o.codigovendedor = '".$List->getelem()->codvendedor."'" : "") . "
          			" . (($List->getelem()->codlocalemi)?" and o.codlocalventa = '".$List->getelem()->codlocalemi."'" : "") . "
          			group by o.id_ordenent order by o.fechacompra,o.rutcliente) as consulta group by MONTH(fechacompra) order by fechacompra limit 12";
		/*$query="SELECT l.nom_local,
					concat(u.usr_nombres, ' ', u.usr_apellidos) vendedor,
					d.codigovendedor,
					ROUND(sum(d.totalnum)) neto,
					ROUND(sum(d.totaliva)) iva,
					ROUND(sum(d.totalnumiva)) ventas,
					ROUND(round(((sum(d.totalnum) - sum(dd.pcosto1))/sum(dd.pcosto1)*10))/10, 1) mgprom,
					ROUND(sum(d.totalnum) - sum(dd.pcosto1)) contneto
				FROM ordenent_e oe
					join documento_e d on oe.id_ordenent = d.numorigen
					left join usuarios u on u.codigovendedor = d.codigovendedor
					left join locales l on d.codlocalventa = l.cod_local
					
					join(
					SELECT id_documento, sum(pcosto) pcosto1
					FROM documento_d
					GROUP BY 1 ) as dd on dd.id_documento = d.id_documento
					
				WHERE oe.id_estado in ('OA','OF','OG') AND d.lockprintfct = 1 and id_tipodocumento = 1
					" . (($List->getelem()->codlocalemi)?" and d.codlocalventa = '".$List->getelem()->codlocalemi."'" : "") . "
			        " . (($List->getelem()->fecinicio)? " and d.fechadocumento >= '".$List->getelem()->fecinicio."'" : "") . "
			        " . (($List->getelem()->fectermino)? " and d.fechadocumento <= '".$List->getelem()->fectermino."'" : "") . "
					" . (($List->getelem()->codvendedor)? " and d.codigovendedor = '".$List->getelem()->codvendedor."'" : "") . "
					" . (($List->getelem()->codventa)? " and d.codigovendedor = '".$List->getelem()->codventa."'" : "") . "
				group by 2, 1, 3
				order by 2 asc,
					6 desc,
					8 desc LIMIT ".LIMITE_REPORTE_VENTASVENDEDOR." ";
		*/
        $res = $this->bd->query($query);
		//general::writeevent(" Consulta reporte por vendedor".$query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoreporte;
			$Registro->nomlocemi		=	$row['nom_local'];
			$Registro->nomvendedor		=	$row['vendedor'];
			$Registro->codventa			=	$row['mes'].' '.$row['years'];
			//$Registro->neto				=	$row['neto'];
			//$Registro->iva				=	$row['iva'];
			//$Registro->total_venta		=	$row['ventas'];			
			$Registro->margenpromedio	=	$row['margen_promedio'];
			$Registro->contribucion		=	$row['total'];
			//$Registro->total_neto		=	$row['contneto'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

	/* Reporte margen mínimo*/
    public function getreportemargen($List) {
			$List->gofirst();
			$query="SELECT l.nom_local localemisor,
						c.usuariocrea usuario,
						DATE_FORMAT(c.fecmod, '%d-%m-%Y') fecha,
						c.id_cotizacion id_cotizacion,
						t.descripcion tipoventa,
						d.codprod sap,
						d.descripcion descripcion,
						d.cantidad cantidad,
						d.margenlinea margenlinea,
						ROUND(d.pcosto) pcosto,
						ROUND(d.pventaneto) pventaneto,
						ROUND(d.totallinea) totallinea
					FROM cotizacion_e c
						left join tipoventa t on t.id_tipoventa = c.id_tipoventa
						left join locales l on c.codlocalventa = l.cod_local
						join cotizacion_d d on d.id_cotizacion=c.id_cotizacion
					WHERE c.id_estado in ('CB', 'CD', 'CE', 'CF', 'CV')
						" . (($List->getelem()->usuario)? " and c.usuariocrea like '%".$List->getelem()->usuario."%'" : "") . "
						" . (($List->getelem()->codlocalemi)?" and c.codlocalventa = '".$List->getelem()->codlocalemi."' " : "") . "
						" . (($List->getelem()->cotizacion)?" and c.id_cotizacion = '".$List->getelem()->cotizacion."' " : "") . "
						" . (($List->getelem()->codsap)?" and d.codprod = '".$List->getelem()->codsap."' " : "") . "
						" . (($List->getelem()->margen_limite)?" and d.margenlinea <= '".$List->getelem()->margen_limite."' " : "") . "
				        " . (($List->getelem()->fecinicio)? " and c.fecmod >= '".$List->getelem()->fecinicio."'" : "") . "
				        " . (($List->getelem()->fectermino)? " and c.fecmod <= '".$List->getelem()->fectermino."'" : "") . "
					ORDER BY 1 asc, 
						c.id_cotizacion desc,
						4 asc LIMIT ".LIMITE_REPORTE_MGMIN."
					" ;
	        $res = $this->bd->query($query);
	        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
	
	        $List->clearlist();
	        while ($row = $res->fetch_assoc()){
	            $Registro = new dtoreporte;
				$Registro->codlocalemi			=	$row['localemisor'];
				$Registro->usuario				=	$row['usuario'];
				$Registro->fechadocumento		=	$row['fecha'];
				$Registro->cotizacion			=	$row['id_cotizacion'];
				$Registro->tipo_venta			=	$row['tipoventa'];
				$Registro->codsap				=	$row['sap'];
				$Registro->descripcion			=	$row['descripcion'];
				$Registro->cantidad				=	$row['cantidad'];
				$Registro->margenpromedio		=	$row['margenlinea'];
				$Registro->costo_unitario		=	$row['pcosto'];
				$Registro->precioventa_unitario = 	$row['pventaneto'];	
				$Registro->total_venta			= 	$row['totallinea'];				
	            $List->addlast($Registro);
	        }
	        $res->free();
	        return true;
	    }
    
	/* Reporte desbloqueos*/
	public function getreportedesbloqueos($List) {
			$List->gofirst();
			$query="SELECT 'Easy Temuco Portal', 'OE', '2708', 'OE 2708', '578', '01-08-2007', '11-08-2007', '15-08-2007', '20-08-2007', '13:52:54', 'Bloqueado', 'No aplica' from tipodocumento
					" ;
	        $res = $this->bd->query($query);
	        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
	
	        $List->clearlist();
	        while ($row = $res->fetch_assoc()){
	            $Registro = new dtoreporte;
				$Registro->codlocalemi			=	$row['Easy Temuco Portal'];
				$Registro->entidad				=	$row['OE'];
				$Registro->numero_entidad		=	$row['2708'];
				$Registro->referencia			=	$row['OE 2708'];
				$Registro->codvendedor			=	$row['578'];
				$Registro->fecinicio			=	$row['01-08-2007'];
				$Registro->fecha_desbloqueo		=	$row['11-08-2007'];
				$Registro->fecinicio2			=	$row['15-08-2007'];
				$Registro->fectermino2			=	$row['20-08-2007'];
				$Registro->hora					=	$row['13:52:54'];			
				$Registro->datos				=	$row['Bloqueado'];
				$Registro->resultado			=	$row['No aplica'];
	            $List->addlast($Registro);
	        }
	        $res->free();
	        return true;
	    }
	    
	/* Reporte OE Anuladas*/
	public function getreporteoe($List) {
			$List->gofirst();
			$query="SELECT oe.id_ordenent id_ordenent,
						l.nom_local nom_local,
						oe.usrmod usuario,
						DATE_FORMAT(oe.fecmod, '%d-%m-%Y') fecha,
						DATE_FORMAT(oe.fecmod, '%H:%i') hora,
						' ' comentarios,
						de1.numdocumento fctasoc,
						de2.numdocumento gdeasoc
					FROM ordenent_e oe
						left join locales l on l.cod_local = oe.codlocalventa
						left join documento_e de1 on de1.numorigen = oe.id_ordenent and de1.tipoorigen = 'OE' and de1.id_tipodocumento = 1 and de1.numdocumento > '0' and de1.numdocumento > ''
						left join documento_e de2 on de2.numorigen = oe.id_ordenent and de2.tipoorigen = 'OE' and de2.id_tipodocumento = 2 and de2.numdocumento > '0'  and de2.numdocumento > '' 
					where oe.id_estado = 'ON'
						" . (($List->getelem()->oe)?" and oe.id_ordenent = '".$List->getelem()->oe."' " : "") . "
						" . (($List->getelem()->codlocalemi)?" and oe.codlocalventa = '".$List->getelem()->codlocalemi."' " : "") . "
						" . (($List->getelem()->usuario)? " and oe.usrmod like '%".$List->getelem()->usuario."%'" : "") . "
				        " . (($List->getelem()->fecinicio)? " and oe.fecmod >= '".$List->getelem()->fecinicio."'" : "") . "
				        " . (($List->getelem()->fectermino)? " and oe.fecmod <= '".$List->getelem()->fectermino."'" : "") . "
						" . (($List->getelem()->fct)?" and de1.numdocumento = '".$List->getelem()->fct."' " : "") . "
						" . (($List->getelem()->gde)?" and de2.numdocumento = '".$List->getelem()->gde."' " : "") . "
					order by 2 asc, 1 asc LIMIT ".LIMITE_REPORTE_OEANULADAS."" ;
	        $res = $this->bd->query($query);
	        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
	
	        $List->clearlist();
	        while ($row = $res->fetch_assoc()){
	            $Registro = new dtoreporte;
				$Registro->entidad				=	$row['id_ordenent'];
				$Registro->codlocalemi			=	$row['nom_local'];
				$Registro->usuario				=	$row['usuario'];
				$Registro->fechadocumento		=	$row['fecha'];
				$Registro->hora					=	$row['hora'];
				$Registro->comentario			=	$row['comentarios'];
				$Registro->fct					=	$row['fctasoc'];
				$Registro->gde					=	$row['gdeasoc'];
	            $List->addlast($Registro);
	        }
	        $res->free();
	        return true;
	    }
	    
	/* Reporte gde*/
	public function getreportegde($List) {
			$List->gofirst();
			$query="SELECT d.numdocumento,
						d.id_documento,
						d.numorigen oe,
						DATE_FORMAT(d.fechadocumento, '%d-%m-%Y') fdocumento,
						d.numdocref fctasoc,
						l.nom_local localsuministro,
						tf.descripcion tipoentrega,
						tf.nomtflujo tipofact,
						d.rutcliente,
						c.id_contribuyente,
						d.razonsoc,
						concat(di.direccion , ', ', co.descripcion) destino
					FROM documento_e d
						left join locales l on l.cod_local = d.codlocalcsum
						join ordenent_e oe on oe.id_ordenent = d.numorigen  and d.tipoorigen = 'OE' and oe.id_estado in ('OA', 'OB', 'OF', 'OG', 'OR')
						left join direccion di on di.id_direccion = oe.id_direccion
						left join comuna co on co.id_comuna = di.id_comuna
						left join tipoflujo tf on tf.id_tipoflujo = oe.id_tipoflujo
						left join cliente c on d.rutcliente = c.rut
					WHERE 1 and d.id_tipodocumento = 2 and d.numdocumento <> '0' and d.numdocumento <> ''
						" . (($List->getelem()->codlocalcsum)?" and d.codlocalcsum = '".$List->getelem()->codlocalcsum."' " : "") . "
				        " . (($List->getelem()->fecinicio)? " and d.fechadocumento >= '".$List->getelem()->fecinicio."'" : "") . "
				        " . (($List->getelem()->fectermino)? " and d.fechadocumento <= '".$List->getelem()->fectermino."'" : "") . "
						" . (($List->getelem()->numdocumento)?" and d.numdocumento = '".$List->getelem()->numdocumento."' " : "") . "
						" . (($List->getelem()->oe)?" and d.numorigen = '".$List->getelem()->oe."' " : "") . "
						" . (($List->getelem()->rutcliente)?" and d.rutcliente = '".$List->getelem()->rutcliente."' " : "") . "
						" . (($List->getelem()->razonsoc)? " and d.razonsoc like '%".$List->getelem()->razonsoc."%'" : "") . "
						" . (($List->getelem()->tipo_entrega)?" and oe.id_tipoentrega = '".$List->getelem()->tipo_entrega."' " : "") . "
						" . (($List->getelem()->tipo_factura)?" and tf.id_tipoflujo in (".$List->getelem()->tipo_factura.") " : "") . "
					order by 6 asc,
						1 asc LIMIT ".LIMITE_REPORTE_GDE."" ;
	        $res = $this->bd->query($query);
	        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
	
	        $List->clearlist();
	        while ($row = $res->fetch_assoc()){
	            $Registro = new dtoreporte;
				$Registro->numdocumento			=	$row['numdocumento'];
				
				$Registro->numinterno			=	$row['id_documento'];
				$Registro->oe					=	$row['oe'];
				$Registro->fechadocumento		=	$row['fdocumento'];
				$Registro->fct					=	$row['fctasoc'];
				$Registro->tipo_entrega			=	$row['tipoentrega'];
				$Registro->tipo_fct				=	$row['tipofact'];
				$Registro->codlocalcsum			=	$row['localsuministro'];
				$Registro->rutcliente			=	$row['rutcliente'];
				$Registro->id_contribuyente		=	$row['id_contribuyente'];
				$Registro->razonsoc				=	$row['razonsoc'];
				$Registro->destino				=	$row['destino'];
	            $List->addlast($Registro);
	        }
	        $res->free();
	        return true;
	    }
	    
/* Reporte Documentos area tributaria*/
	public function getreportedocumentosall($List) {
			$List->gofirst();
			if($List->getelem()->lockprint=='2'){
				$List->getelem()->lockprint = 'null';
			}
			if($List->getelem()->indmsgsap=='2'){
				$List->getelem()->indmsgsap = 'null';
			}
			$query="SELECT d.numdocumento,
						d.id_documento,
						d.numorigen oe,
						oe.id_estado id_estado,
						d.indmsgsap enviado_sap,
						e.descripcion des,
						d.lockprintfct impreso,						
						DATE_FORMAT(d.fechadocumento, '%d-%m-%Y') fdocumento,
						d.numdocref fctasoc,
						l.nom_local localsuministro,
						d.codlocalventa localventa,
						tf.descripcion tipoentrega,
						tf.nomtflujo tipofact,
						d.rutcliente,
						c.id_contribuyente,
						d.razonsoc,
						d.sigtipodoc tipo_doc,
						oe.numdocpago docpago,
						d.numdocref docref,
						d.totalnum neto,
						d.totaliva iva,
						d.totalnumiva total,
						concat(di.direccion , ', ', co.descripcion) destino
					FROM documento_e d
						left join locales l on l.cod_local = d.codlocalcsum
						join ordenent_e oe on oe.id_ordenent = d.numorigen  and d.tipoorigen = 'OE' and oe.id_estado in ('OG', 'OR', 'ON')
						left join estado e on oe.id_estado = e.id_estado
						left join direccion di on di.id_direccion = oe.id_direccion
						left join comuna co on co.id_comuna = di.id_comuna
						left join tipoflujo tf on tf.id_tipoflujo = oe.id_tipoflujo
						left join cliente c on d.rutcliente = c.rut
					WHERE 1 
						" . (($List->getelem()->lockprint)?" and d.lockprintfct = '".$List->getelem()->lockprint."' " : "") . "
						" . (($List->getelem()->indmsgsap)?" and d.indmsgsap = '".$List->getelem()->indmsgsap."' " : "") . "																
						" . (($List->getelem()->tipodocumento)?" and d.id_tipodocumento = '".$List->getelem()->tipodocumento."' " : "") . "
						" . (($List->getelem()->codlocalemi)?" and d.codlocalcsum = '".$List->getelem()->codlocalemi."' " : "") . "
				        " . (($List->getelem()->fecinicio)? " and d.fechadocumento >= '".$List->getelem()->fecinicio."'" : "") . "
				        " . (($List->getelem()->fectermino)? " and d.fechadocumento <= '".$List->getelem()->fectermino."'" : "") . "
						" . (($List->getelem()->numdocumento)?" and d.numdocumento = '".$List->getelem()->numdocumento."' " : "") . "
						" . (($List->getelem()->numinterno)?" and d.id_documento = '".$List->getelem()->numinterno."' " : "") . "
						" . (($List->getelem()->rutcliente)?" and d.rutcliente = '".$List->getelem()->rutcliente."' " : "") . "
						" . (($List->getelem()->razonsoc)? " and d.razonsoc like '%".$List->getelem()->razonsoc."%'" : "") . "
						" . (($List->getelem()->tipo_entrega)?" and oe.id_tipoflujo = '".$List->getelem()->tipo_entrega."' " : "") . "
						" . (($List->getelem()->tipo_factura)?" and tf.id_tipoflujo in (".$List->getelem()->tipo_factura.") " : "") . "
						" . (($List->getelem()->estado)?" and oe.id_estado = '".$List->getelem()->estado."' " : "") . "
					order by d.fechadocumento DESC,
						1 asc LIMIT ".LIMITE_REPORTE_DOC."" ;
	        $res = $this->bd->query($query);
			general::writeevent($query);
	        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
	
	        $List->clearlist();
	        while ($row = $res->fetch_assoc()){
	            $Registro = new dtoreporte;
				$Registro->numdocumento			=	$row['numdocumento'];
				$Registro->numinterno			=	$row['id_documento'];				
				$Registro->sigtipodoc			=	$row['tipo_doc'];
				$Registro->oe					=	$row['oe'];
				$Registro->id_estado			=	$row['des'];
				$Registro->lockprint			=	$row['impreso'];				
				$Registro->indmsgsap			=	$row['enviado_sap'];				
				$Registro->fechadocumento		=	$row['fdocumento'];
				$Registro->fct					=	$row['fctasoc'];
				$Registro->tipo_entrega			=	$row['tipoentrega'];
				$Registro->tipo_fct				=	$row['tipofact'];
				$Registro->nomloccsum			=	$row['localsuministro'];
				$Registro->codlocalemi			=	$row['localventa'];				
				$Registro->rutcliente			=	$row['rutcliente'];
				$Registro->id_contribuyente		=	$row['id_contribuyente'];
				$Registro->razonsoc				=	$row['razonsoc'];
				$Registro->destino				=	$row['destino'];
				$Registro->tipodocumento	=	$row['docpago'];
				$Registro->referencia		=	$row['docref'];
				$Registro->neto				=	$row['neto'];
				$Registro->iva				=	$row['iva'];
				$Registro->total_venta		=	$row['total'];	
	            $List->addlast($Registro);
	        }
	        $res->free();
	        return true;
	    }
	    
	
	/* Reporte cotizaciones*/
	public function getreportecotizacion($List) {
			$List->gofirst();
			$query="SELECT c.id_cotizacion,
						c.usuariocrea,
						DATE_FORMAT(c.feccrea, '%d-%m-%Y') fcreacion,
						DATE_FORMAT(c.validhasta, '%d-%m-%Y') fvencimiento,
						e.descripcion estado,
						c.rutcliente,
						i.id_contribuyente,
						c.razonsoc,
						c.margentotal,
						t.descripcion tipoventa,
						l1.nom_local localemisor,
						l2.nom_local localsuministro,
						ROUND(c.valortotal) valortotal
					FROM cotizacion_e c
						left join estado e on e.id_estado = c.id_estado and e.tipo = 'CO'
						left join tipoventa t on t.id_tipoventa = c.id_tipoventa
						left join locales l1 on c.codlocalventa = l1.cod_local
						left join locales l2 on c.codlocalventa = l2.cod_local
						left join cliente i on c.rutcliente = i.rut
					WHERE c.id_estado in ('CE', 'CD', 'CV', 'CF')
				        " . (($List->getelem()->fecinicio)? " and c.feccrea >= '".$List->getelem()->fecinicio."'" : "") . "
				        " . (($List->getelem()->fectermino)? " and c.feccrea <= '".$List->getelem()->fectermino."'" : "") . "
				        " . (($List->getelem()->fecinicio2)? " and c.validhasta >= '".$List->getelem()->fecinicio2."'" : "") . "
				        " . (($List->getelem()->fectermino2)? " and c.validhasta <= '".$List->getelem()->fectermino2."'" : "") . "
						" . (($List->getelem()->cotizacion)?" and c.id_cotizacion = '".$List->getelem()->cotizacion."' " : "") . "
						" . (($List->getelem()->rutcliente)?" and c.rutcliente = ".$List->getelem()->rutcliente." " : "") . "
						" . (($List->getelem()->razonsoc)? " and c.razonsoc like '%".$List->getelem()->razonsoc."%'" : "") . "
						" . (($List->getelem()->tipo_venta)?" and c.id_tipoventa = '".$List->getelem()->tipo_venta."' " : "") . "
						" . (($List->getelem()->codlocalemi)?" and c.codlocalventa = '".$List->getelem()->codlocalemi."' " : "") . "
						" . (($List->getelem()->codlocalcsum)?" and c.codlocalcsum = '".$List->getelem()->codlocalcsum."' " : "") . "
						" . (($List->getelem()->estado)?" and c.id_estado = '".$List->getelem()->estado."' " : "") . "
					ORDER BY 1 asc LIMIT ".LIMITE_REPORTE_COTIZACIONES."" ;
			
	        $res = $this->bd->query($query);
	        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
	
	        $List->clearlist();
	        while ($row = $res->fetch_assoc()){
	            $Registro = new dtoreporte;
				$Registro->cotizacion		=	$row['id_cotizacion'];
				$Registro->codvendedor		=	$row['usuariocrea'];
				$Registro->fecinicio		=	$row['fcreacion'];
				$Registro->fectermino		=	$row['fvencimiento'];
				$Registro->estado			=	$row['estado'];
				$Registro->rutcliente		=	$row['rutcliente'];
				$Registro->id_contribuyente	=	$row['id_contribuyente'];
				$Registro->razonsoc			=	$row['razonsoc'];
				$Registro->tipo_venta		=	$row['tipoventa'];
				$Registro->margenpromedio	=	$row['margentotal'];
				$Registro->nomlocemi		=	$row['localemisor'];				
				$Registro->nomloccsum		=	$row['localsuministro'];								
				$Registro->total_neto		=	$row['valortotal'];												
	            $List->addlast($Registro);
	        }
	        $res->free();
	        return true;
	    }
	    
	/* Reporte clientes*/
	public function getreportecliente($List) {
			$List->gofirst();
			//general::alert(date( "h:i:s" , time () ));
			$query="select c.rut,
			            c.id_contribuyente,
						c.razonsoc,
						c.id_contribuyente,
						t.descripcion tipocli,
						if(c.bloqueo1, 'Bloqueado en SAP', '') blosap,
						if(c.bloqueo2, 'Bloqueado por morosidad', '') blomoro,
						if(c.bloqueo3, 'Bloqueado en CVE', '') blocve,
						if(c.valdisp < now(), 'Bloqueado por disponible vencido','') blodisp,
						DATE_FORMAT(c.valdisp, '%d-%m-%Y') vencdisp,
						concat(u.usr_nombres, ' ', usr_apellidos) vendedor,
						tc.descripcion condpago,
						r.descripcion rubro,
						l.nom_local,
						(sum(if(id_tipomovimiento = 1,d.monto,0)) + sum(if(id_tipomovimiento = 3,d.monto,0))) total_linea,
						(sum(if(id_tipomovimiento = 1,d.monto,0)) - sum(if(id_tipomovimiento = 2,d.monto,0))) disponible
					from cliente c
						left JOIN tipocliente t on t.id_tipocliente = c.id_tipocliente
						left JOIN disponible d on d.rut = c.rut
						left join tipocondicionpago tc on tc.id_tipoconpago = c.diascondicion
						left join rubro r on r.id_rubro = c.id_rubro
						left join locales l on l.cod_local = c.codlocaluco
						left join usuarios u on u.codigovendedor = c.codigovendedor and u.id_tipousuario = 2
					where 1
						" . (($List->getelem()->tipo_cliente)? " and c.id_tipocliente = ".$List->getelem()->tipo_cliente."" : "") . "
						" . (($List->getelem()->rutcliente)?" and c.rut = '".$List->getelem()->rutcliente."' " : "") . "
						" . (($List->getelem()->nombrecliente)? " and c.razonsoc like '%".$List->getelem()->nombrecliente."%'" : "") . "
						" . (($List->getelem()->bloqueo1)?" and c.bloqueo1 = '".$List->getelem()->bloqueo1."' " : "") . "
						" . (($List->getelem()->bloqueo2)?" and c.bloqueo2 = '".$List->getelem()->bloqueo2."' " : "") . "
						" . (($List->getelem()->bloqueo3)?" and c.bloqueo3 = '".$List->getelem()->bloqueo3."' " : "") . "
				        " . (($List->getelem()->fecinicio)? " and c.valdisp >= '".$List->getelem()->fecinicio."'" : "") . "
				        " . (($List->getelem()->fectermino)? " and c.valdisp <= '".$List->getelem()->fectermino."'" : "") . "
						" . (($List->getelem()->rubro)?" and c.id_rubro = '".$List->getelem()->rubro."' " : "") . "
						
				        " . (($List->getelem()->codlocalemi)?" and c.codlocaluco = '".$List->getelem()->codlocalemi."' " : "") . "
					group by 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12
					order by 8 asc, 
						1 asc LIMIT ".LIMITE_REPORTE_CLIENTES."";
	        $res = $this->bd->query($query);
			//general::writeevent('Termino de Proceso INGRESO CLIENTES PREFERENTE. Usuario '.$user.' a las  '.);
			//date( "h:i:s" , time () )
	        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
	
	        $List->clearlist();
	        while ($row = $res->fetch_assoc()){
	            $Registro = new dtoreporte;
				$Registro->rutcliente		=	$row['rut'];
				$Registro->id_contribuyente	=	$row['id_contribuyente'];
				$Registro->nombrecliente	=	$row['razonsoc'];
				$Registro->tipo_cliente		=	$row['tipocli'];
				$Registro->bloqueo1			=	$row['blosap'];
				$Registro->bloqueo2			=	$row['blomoro'];
				$Registro->bloqueo3			=	$row['blocve'];
				$Registro->bloqueodisp		=	$row['blodisp'];
				$Registro->disponible		=	$row['disponible'];
				$Registro->fecinicio		=	$row['vencdisp'];
				$Registro->nomvendedor		=	$row['Perico los palotes'];
				$Registro->condicion_pago	=	$row['condpago'];				
				$Registro->rubro			=	$row['rubro'];
				$Registro->total_linea		=	$row['total_linea'];												
				$Registro->nomlocemi		=	$row['nom_local'];
				$Registro->id_contribuyente	=	$row['id_contribuyente'];												
	            $List->addlast($Registro);
	        }
	        $res->free();
	        return true;
	    }
	    
	/* Reporte ventas por cliente*/
	public function getventascliente($List) {
			$List->gofirst();
			$query="SELECT 	o.fechacompra, 
							lo.nom_local,
							o.rutcliente,
							o.razonsoc,
							o.id_ordenent,
							sum(od.descuento) as descuento,
							if(id_tipoentrega=1 and id_tiporetiro=2,'Retira Cliente' ,if(id_tipoentrega=2 and id_tiporetiro=2,'Desp. Programado',if(id_tipoentrega=1 and id_tiporetiro=1,'Retira Inmediato','No aisgnado'))) as tipo_salida,
							estado.descripcion as estado,
							usu.usr_nombres,
							usu.usr_apellidos,
							usu.codigovendedor, 
							sum(od.totallinea) as totaldet,
              				o.totaloe as total,
              				(round((((sum(od.totallinea)-(sum(od.pcosto* od.cantidade)))* 100)/sum(od.totallinea)) * 100)/100) as margen,
              				id_contribuyente,
              				numdocumento,
              				sum(round((od.totallinea/((od.iva/100)+1))*(od.rete_renta/100))) as rete_renta,
                      		sum(round((od.totallinea/((od.iva/100)+1))*(od.rete_ica/100))) as rete_ica,
                      		o.rete_iva_oe as rete_iva,
                      		o.totaliva as totaliva
					FROM ordenent_d od join ordenent_e o on (o.id_ordenent=od.id_ordenent) 
						join cliente cli on(rut=rutcliente) 
						join locales lo on (o.codlocalventa=cod_local) 
						join estado on (o.id_estado=estado.id_estado) 
						left join usuarios usu on (usu.codigovendedor=o.codigovendedor and usu.codigovendedor <> '')
						left join documento_e de on(de.sigtipodoc='FCT' and o.id_ordenent=de.numorigen) 
					where o.id_estado='OG' 
						" . (($List->getelem()->codlocalemi)?" and o.codlocalventa = '".$List->getelem()->codlocalemi."' " : "") . " 
						" . (($List->getelem()->fecinicio)? " and fechacompra >= '".$List->getelem()->fecinicio."'" : "") . " 
						" . (($List->getelem()->fectermino)? " and fechacompra<= '".$List->getelem()->fectermino."'" : "") . " 
						" . (($List->getelem()->codigovendedor)? " and o.codigovendedor= ".$List->getelem()->codigovendedor."" : "") . "  
						" . (($List->getelem()->rutcliente)? " and o.rutcliente = ".$List->getelem()->rutcliente."" : "") . " 
						" . (($List->getelem()->razonsoc)? " and o.razonsoc like '%".$List->getelem()->razonsoc."%'" : "") . " 
						" . (($List->getelem()->tipo_cliente)? " and id_contribuyente = ".$List->getelem()->tipo_cliente."" : "") . " 
						group by o.id_ordenent order by o.fechacompra,o.rutcliente";
			
	        $res = $this->bd->query($query);
	        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
			//general::writeevent('reporte vantas cliente'.$query);
	        $List->clearlist();
	        while ($row = $res->fetch_assoc()){
	            $Registro = new dtoreporte;
	            $Registro->fecinicio		=	$row['fechacompra'];
				$Registro->nomlocemi		=	$row['nom_local'];
				$Registro->rutcliente		=	$row['rutcliente'];
				$Registro->idcliente		=	$row['razonsoc'];
				$Registro->numdocpago		=	$row['id_ordenent'];
				$Registro->neto_fct			=	$row['descuento'];
				$Registro->tipo_entrega		=	$row['tipo_salida'];
				$Registro->estado			=	$row['estado'];
				$Registro->codvendedor		=	$row['codigovendedor'];
				$Registro->nomvendedor		=	$row['usr_nombres'].' '.$row['usr_apellidos'];
				$Registro->total_venta		=	$row['total'];
				$Registro->totalmargen		=	$row['margen'];
				$Registro->tipo_cliente		=	$row['id_contribuyente'];
				$Registro->numdocumento		=	$row['numdocumento'];
				$Registro->rete_ica			=	$row['rete_ica'];
				$Registro->rete_iva			=	$row['rete_iva'];
				$Registro->rete_renta		=	$row['rete_renta'];
				$Registro->totaliva			=	$row['totaliva'];
				$Registro->total_linea		=	$row['totaldet'];
				$List->addlast($Registro);
	        }
	        $res->free();
	        return true;
	    }

	    public function getventascliente_margen($List) {
			$List->gofirst();
			$query="SELECT 	(round((((sum(od.totallinea)-(sum(od.pcosto* od.cantidade)))* 100)/sum(od.totallinea)) * 100)/100) as margen,
					sum(od.descuento) as descuento
					FROM ordenent_d od join ordenent_e o on (o.id_ordenent=od.id_ordenent and od.codtipo<>'SV') 
						join cliente cli on(rut=rutcliente) 
						join locales lo on (o.codlocalventa=cod_local) 
						join estado on (o.id_estado=estado.id_estado) 
						left join usuarios usu on (usu.codigovendedor=o.codigovendedor and usu.codigovendedor <> '')
						left join documento_e de on(de.sigtipodoc='FCT' and o.id_ordenent=de.numorigen) 
					where o.id_estado='OG' 
						" . (($List->getelem()->codlocalemi)?" and o.codlocalventa = '".$List->getelem()->codlocalemi."' " : "") . " 
						" . (($List->getelem()->fecinicio)? " and fechacompra >= '".$List->getelem()->fecinicio."'" : "") . " 
						" . (($List->getelem()->fectermino)? " and fechacompra<= '".$List->getelem()->fectermino."'" : "") . " 
						" . (($List->getelem()->codigovendedor)? " and o.codigovendedor= ".$List->getelem()->codigovendedor."" : "") . "  
						" . (($List->getelem()->rutcliente)? " and o.rutcliente = ".$List->getelem()->rutcliente."" : "") . " 
						" . (($List->getelem()->razonsoc)? " and o.razonsoc like '%".$List->getelem()->razonsoc."%'" : "") . " 
						" . (($List->getelem()->tipo_cliente)? " and id_contribuyente = ".$List->getelem()->tipo_cliente."" : "") . " 
						group by o.id_ordenent order by o.fechacompra,o.rutcliente";
			
	        $res = $this->bd->query($query);
	        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
			general::writeevent('reporte vantas cliente'.$query);
	        $List->clearlist();
	        while ($row = $res->fetch_assoc()){
	            $Registro = new dtoreporte;
				$Registro->totalmargen		=	$row['margen'];
				$List->addlast($Registro);
	        }
	        $res->free();
	        return true;
	    } 
	    
	/* Reporte facturas y ncr*/
	public function getreportefacturas($List) {
			$List->gofirst();
			$query="SELECT d.numdocumento,
						td.sigtipodoc,
						d.numorigen oe,
						DATE_FORMAT(d.fechadocumento, '%d-%m-%Y') fdocumento,
						t.descripcion tipoventa,
						l1.nom_local localemisor,
						l2.nom_local localsuministro,
						d.rutcliente,
						c.id_contribuyente,
						c.razonsoc,
						tdp.descripcion mediopago,
						oe.numdocpago docpago,
						d.numdocref docref,
						d.totalnum neto,
						d.totaliva iva,
						d.totalnumiva total
					FROM documento_e d
						left join tipodocumento td on td.id_tipodocumento = d.id_tipodocumento
						left join locales l1 on l1.cod_local = d.codlocalventa
						left join locales l2 on l2.cod_local = d.codlocalcsum
						left join cliente c on d.rutcliente = c.rut
						join ordenent_e oe on oe.id_ordenent = d.numorigen and d.tipoorigen = 'OE' and oe.id_estado in ('OA', 'OB', 'OF', 'OG', 'OR')
						left join tipodocpago tdp on tdp.id_tipodocpago = oe.id_tipodocpago
						left join cotizacion_e ce on ce.id_cotizacion = oe.id_cotizacion
						left join tipoventa t on t.id_tipoventa = ce.id_tipoventa
					WHERE d.id_tipodocumento in (1, 3) and d.lockprintfct = 1
						" . (($List->getelem()->tipodocumento)?" and d.id_tipodocumento = '".$List->getelem()->tipodocumento."' " : "") . "
						" . (($List->getelem()->codlocalemi)?" and d.codlocalventa = '".$List->getelem()->codlocalemi."' " : "") . "
						" . (($List->getelem()->numdoccve)?" and d.id_documento = '".$List->getelem()->numdoccve."' " : "") . "
						" . (($List->getelem()->numdocumento)?" and d.numdocumento = '".$List->getelem()->numdocumento."' " : "") . "
						" . (($List->getelem()->fecinicio)?" and d.fechadocumento >= '".$List->getelem()->fecinicio."' " : "") . "
						" . (($List->getelem()->fectermino)?" and d.fechadocumento <= '".$List->getelem()->fectermino."' " : "") . "
						" . (($List->getelem()->rutcliente)?" and d.rutcliente = '".$List->getelem()->rutcliente."' " : "") . "
						" . (($List->getelem()->razonsoc)? " and d.razonsoc like '%".$List->getelem()->razonsoc."%'" : "") . "		
						" . (($List->getelem()->tipo_venta)?" and t.id_tipoventa = ".$List->getelem()->tipo_venta." " : "") . "
						" . (($List->getelem()->tipo_factura)?" and oe.id_tipoflujo = ".$List->getelem()->tipo_factura." " : "") . "

					order by 6 asc, 
						1 asc LIMIT ".LIMITE_REPORTE_FACTURAS."" ;
	        $res = $this->bd->query($query);
	        //general::writeevent($query);
	        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
	
	        $List->clearlist();
	        while ($row = $res->fetch_assoc()){
	            $Registro = new dtoreporte;
				$Registro->numdocumento		=	$row['numdocumento'];												
	            $Registro->sigtipodoc	=	$row['sigtipodoc'];
				$Registro->oe				=	$row['oe'];
				$Registro->fechadocumento	=	$row['fdocumento'];
				$Registro->tipo_venta		=	$row['tipoventa'];				
				$Registro->nomlocemi		=	$row['localemisor'];								
				$Registro->nomloccsum		=	$row['localsuministro'];												
				$Registro->rutcliente		=	$row['rutcliente'];
				$Registro->id_contribuyente	=	$row['id_contribuyente'];																
				$Registro->razonsoc			=	$row['razonsoc'];
				$Registro->tipopago			=	$row['mediopago'];
				$Registro->tipodocumento	=	$row['docpago'];
				$Registro->referencia		=	$row['docref'];
				$Registro->neto				=	$row['neto'];
				$Registro->iva				=	$row['iva'];
				$Registro->total_venta		=	$row['total'];
				$List->addlast($Registro);
	        }
	        $res->free();
	        return true;
	    }

	/* Reporte detalle ventas*/
	public function getreportedetalleventas($List) {
			$List->gofirst();
			$query="select	T1.nom_local 'Local',
						if(T1.cuenta1 is null, 0, T1.cuenta1) 'Total Facturas',
						ROUND(if(T1.total1n is null, 0, T1.total1n)) 'Neto Facuras',
						if(T2.cuenta2 is null, 0, T2.cuenta2) 'Total NCR',
						ROUND(if(T2.total2n is null, 0, T2.total2n)) 'Neto NCR',
						ROUND(if(T1.total1n is null, 0, T1.total1n) - if(T2.total2n is null, 0, T2.total2n)) 'Total Neto',
						ROUND(if(T1.total1i is null, 0, T1.total1i) - if(T2.total2i is null, 0, T2.total2i)) 'Total IVA',
						ROUND(if(T1.total1t is null, 0, T1.total1t) - if(T2.total2t is null, 0, T2.total2t)) 'Total Ventas'
					from (
						SELECT l.cod_local, l.nom_local, count(*) cuenta1, sum(d.totalnum) total1n, sum(d.totaliva) total1i, sum(d.totalnumiva) total1t
						FROM documento_e d join cliente c on d.rutcliente = c.rut
						join locales l on l.cod_local = d.codlocalventa
						join ordenent_e oe on oe.id_ordenent = d.numorigen and d.tipoorigen = 'OE' and oe.id_estado in ('OA', 'OB', 'OF', 'OG', 'OR')
						where d.numdocumento <> '1'
						and d.id_tipodocumento = 1
						" . (($List->getelem()->tipo_cliente)?" and c.id_tipocliente = '".$List->getelem()->tipo_cliente."' " : "") . "
						" . (($List->getelem()->codlocalemi)?" and d.codlocalventa = '".$List->getelem()->codlocalemi."' " : "") . "
						" . (($List->getelem()->fecinicio)?" and d.fechadocumento >= '".$List->getelem()->fecinicio."' " : "") . "
						" . (($List->getelem()->fectermino)?" and d.fechadocumento <= '".$List->getelem()->fectermino."' " : "") . "
						group by l.nom_local
					) as T1
					left join
					(
						SELECT l.cod_local, count(*) cuenta2, sum(d.totalnum) total2n, sum(d.totaliva) total2i, sum(d.totalnumiva) total2t
						FROM documento_e d join cliente c on d.rutcliente = c.rut
						join locales l on l.cod_local = d.codlocalventa
						where 1
						and d.id_tipodocumento = 3
						" . (($List->getelem()->tipo_cliente)?" and c.id_tipocliente = '".$List->getelem()->tipo_cliente."' " : "") . "
						" . (($List->getelem()->codlocalemi)?" and d.codlocalventa = '".$List->getelem()->codlocalemi."' " : "") . "
						" . (($List->getelem()->fecinicio)?" and d.fechadocumento >= '".$List->getelem()->fecinicio."' " : "") . "
						" . (($List->getelem()->fectermino)?" and d.fechadocumento <= '".$List->getelem()->fectermino."' " : "") . "
						group by l.nom_local
					) as T2
					on T1.cod_local = T2.cod_local
					order by 8 desc, 
						2 desc LIMIT ".LIMITE_REPORTE_DETALLEVENTAS.""  ;
			general::writeevent($query);
	        $res = $this->bd->query($query);
	        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
	
	        $List->clearlist();
	        while ($row = $res->fetch_assoc()){
	            $Registro = new dtoreporte;
				$Registro->nomlocemi		=	$row['Local'];
	            $Registro->totalfacturas	=	$row['Total Facturas'];												
	            $Registro->neto_fct			=	$row['Neto Facuras'];
				$Registro->total_ncr		=	$row['Total NCR'];
				$Registro->neto_ncr			=	$row['Neto NCR'];				
				$Registro->total_neto		=	$row['Total Neto'];
				$Registro->totaliva			=	$row['Total IVA'];												
				$Registro->total_venta		=	$row['Total Ventas'];				
				$List->addlast($Registro);
	        }
	        $res->free();
	        return true;
	    }
}
?>
