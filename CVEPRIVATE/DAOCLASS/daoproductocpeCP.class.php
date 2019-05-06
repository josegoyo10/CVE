<?php
class daoproductocpe{
	/*** atributos ***/
	private $bd = NULL;

	/*** constructor ***/
    public function __construct(){
    	$conf = new getdbconfig("DATABASE_CPE");
        $this->bd = new DBAccess2($conf->DBSERVER, $conf->DBUSER, $conf->DBPASS, $conf->DBDATABASE);
		if (!$this->bd->isconnected())
			throw new DAOException(__CLASS__ , __FUNCTION__ , "No se ha podido conectar a Base de Datos [DBSERVER:".$conf->DBSERVER.", USER:".$conf->DBUSER.", PASS:********, DB:".$conf->DBDATABASE."]", 0, 1);
    }

    public function __destruct(){
        $this->bd->close();
    }

	public function getproductocount($List){
		$List->gofirst();
        $query="SELECT	count(*) cuenta
                FROM 	productos p
                JOIN 	precios r on r.cod_prod1 = p.cod_prod1
                LEFT JOIN codbarra b on b.cod_prod1 = p.cod_prod1
                LEFT JOIN prodxprov x on x.cod_prod1 = p.cod_prod1
                JOIN 	proveedores v on v.id_proveedor = x.id_proveedor " . (($List->getelem()->nomprov)? " AND v.nom_prov like '%".str_replace(' ', '%', trim($List->getelem()->nomprov))."%' " : "") . "
                WHERE 1
                " . (($List->getelem()->sap)? " AND p.cod_prod1 = '".$List->getelem()->sap."' " : "") . "
                " . (($List->getelem()->barra)? " AND b.cod_barra like '".$List->getelem()->barra."%' " : "") . "
                " . (($List->getelem()->descripcion)? " AND p.des_larga like '%".str_replace(' ', '%', trim($List->getelem()->descripcion))."%' " : "") . "
                " . (($List->getelem()->csum)? " AND r.cod_local = '".$List->getelem()->csum."' " : "") . "
                AND b.unid_med in (".UNIMED_VALID.") ";

        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        if ($row = $res->fetch_assoc()){
            $res->free();
            return $row['cuenta'];
        }
        return 0;
    }

    public function getEAN($List) {
		$List->gofirst();

		//Si no viene alguno de los 3 datos solicitados, retornamos la misma estructura
		if (!$List->getelem()->codprod || !$List->getelem()->barra || !$List->getelem()->unimed)
        	return true;

        $codprodt = $List->getelem()->codprod;
        $codbarrat = $List->getelem()->barra;
        $unimedt = $List->getelem()->unimed;

        $query = "	SELECT	cod_barra,
							unid_med,
							cod_ppal
					FROM codbarra
					WHERE cod_prod1 = '".$List->getelem()->codprod."'
					ORDER BY cod_ppal ASC";

        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
       	$registroencontrado = false;
       	$continuar = true;
        while (($row = $res->fetch_assoc()) && $continuar){
        	$registroencontrado = true;

        	if ($codbarrat == $row['cod_barra'] && trim($unimedt) == trim($row['unid_med'])) {
            	$Registro = new dtodetordenent;
        		$Registro->codprod	= 	$codprodt;
	            $Registro->barra	= 	$codbarrat;
	            $Registro->unimed	= 	$unimedt;
            	$List->addlast($Registro);
	            $continuar = false;
        	}
        }

        if ($registroencontrado && $continuar) {
            $Registro = new dtodetordenent;
            $Registro->codprod	= 	$codprodt;
            $Registro->barra	= 	$row['cod_barra'];
            $Registro->unimed	= 	$row['unid_med'];
            $List->addlast($Registro);
        }

        if (!$registroencontrado) {
            $Registro = new dtodetordenent;
            $Registro->codprod	= 	$codprodt;
            $Registro->barra	= 	$codbarrat;
            $Registro->unimed	= 	$unimedt;
            $List->addlast($Registro);
        }

        $res->free();
        return true;
    }

    public function getmarca($List) {
		$List->gofirst();

		//Si no viene codigo producto retornamos cero
		if (!$List->getelem()->codprod)
        	return 0;

        $codprodt = $List->getelem()->codprod;

        $query = "	SELECT count(*) cuenta
					FROM codbarra
					WHERE cod_prod1 = '".$List->getelem()->codprod."'";

        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        if ($row = $res->fetch_assoc()) {
        	$numreg = $row['cuenta'];
        }

        $res->free();
        return $numreg + 0;
    }


	public function getproducto($List){
		$totalregistros = $this->getproductocount($List);
		$pag = (int)($totalregistros/LIMITE_REG);
		if ($pag < $List->getelem()->pagactual){
			$List->getelem()->numretlimitdes = $pag*LIMITE_REG;
			$List->getelem()->pagactual = $pag;
		}

		$totalregsolic = $List->getelem()->numretlimit+0;
		$List->gofirst();
        $query="SELECT	p.id_producto,
                        p.cod_prod1 sap,
                        b.cod_barra barra,
                        p.des_larga descripcion,
                        p.des_corta descripcionc,
                        p.prod_tipo,
                        p.prod_subtipo,
                        p.peso,
                        r.cod_local csum,
						r.prec_costo pcosto,
                        r.prec_valor pventa,
                        r.stock,
                        b.unid_med unidmed,
                        v.nom_prov nomprov
                FROM 	productos p
                JOIN 	precios r on r.cod_prod1 = p.cod_prod1
                LEFT JOIN codbarra b on b.cod_prod1 = p.cod_prod1
                LEFT JOIN prodxprov x on x.cod_prod1 = p.cod_prod1
                JOIN 	proveedores v on v.cod_prov = x.cod_prov " . (($List->getelem()->nomprov)? " AND v.nom_prov like '%".str_replace(' ', '%', trim($List->getelem()->nomprov))."%' " : "") . "
                WHERE 1
                " . (($List->getelem()->sap)? " AND p.cod_prod1 = '".$List->getelem()->sap."' " : "") . "
                " . (($List->getelem()->barra)? " AND b.cod_barra like '".$List->getelem()->barra."%' " : "") . "
                " . (($List->getelem()->descripcion)? " AND p.des_larga like '%".str_replace(' ', '%', trim($List->getelem()->descripcion))."%' " : "") . "
                " . (($List->getelem()->csum)? " AND r.cod_local = '".$List->getelem()->csum."' " : "") . "
                " . (($List->getelem()->prod_tipo)? " AND p.prod_tipo = '".$List->getelem()->prod_tipo."' " : "") . "
                " . (($List->getelem()->prod_subtipo)?($List->getelem()->prod_subtipo=='GE'?" AND p.prod_subtipo = '".$List->getelem()->prod_subtipo."' ":" AND p.prod_subtipo <> 'GE'"): "") . "
                AND b.unid_med in (".UNIMED_VALID.") AND p.estadoactivo <>'E' ORDER BY unidmed DESC LIMIT ".($List->getelem()->numretlimitdes+0).", ".($List->getelem()->numretlimit+0)."
                ";
    	//general::writeevent('query productos '. $query);
        $pag = $List->getelem()->pagactual+0;
        $res = $this->bd->query($query);

        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		$List->clearlist();

        while ($row = $res->fetch_assoc()){
            $Registro = new dtoproducto;
            $Registro->cod_prod1   	= $row['cod_prod1'];
            $Registro->id_producto	= $row['id_producto'];
            $Registro->sap   		= $row['sap'];
            $Registro->barra   		= $row['barra'];
            $Registro->descripcion	= htmlspecialchars(str_replace("#", "", $row['descripcion']), ENT_QUOTES);
            $Registro->prod_tipo	= $row['prod_tipo'];
            $Registro->prod_subtipo	= $row['prod_subtipo'];
            $Registro->csum   		= $row['csum'];
            $Registro->pcosto   	= round($row['pcosto']+0);
            $Registro->pventa   	= round($row['pventa']+0);
            $Registro->stock   		= $row['stock'];
            $Registro->unidmed   	= $row['unidmed'];
            $Registro->nomprov   	= htmlspecialchars($row['nomprov'], ENT_QUOTES);
            $Registro->numretreal	= ($totalregistros+0);
            $Registro->numretlimit	= ($totalregsolic+0);
            $Registro->descripcionc	= $row['descripcionc'];
            $Registro->pagactual	= $pag;

            $List ->addlast($Registro);
        }

        $res->free();
        return true;
    }

	public function getproveedores($List){

		$List->gofirst();
        $query="SELECT  id_proveedor,
        			    cod_prov,
        			    rut_prov,
        			    nom_prov,
        			    razsoc_prov,
        			    fonocto_prov,
        			    nombcto_prov,
        			    emailcto_prov,
        			    estadoactivo
        		FROM proveedores where 1
                " . (($List->getelem()->rutproveedor)? " AND cod_prov = '".$List->getelem()->rutproveedor."' " : "") . "
                " . (($List->getelem()->nomprov)? " AND nom_prov like '%".str_replace(' ', '%', trim($List->getelem()->nomprov))."%' " : "") . "
                " . (($List->getelem()->razonsocprov)? " AND razsoc_prov like '%".str_replace(' ', '%', trim($List->getelem()->razonsocprov))."%' " : "") . "";


        $res = $this->bd->query($query);
        //general::writeevent('query productos'. $query);

        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		$List->clearlist();

        while ($row = $res->fetch_assoc()){
            $Registro = new dtoproducto;
            $Registro->codtipo   	= $row['cod_prov'];
            $Registro->idprov   	= $row['id_proveedor'];
            $Registro->rutproveedor	= $row['rut_prov'];
            $Registro->nomprov   	= $row['nom_prov'];
            $Registro->razonsocprov	= $row['razsoc_prov'];
            $List ->addlast($Registro);
        }

        $res->free();
        return true;
    }

	public function getproductof($List){
		$totalregistros = $this->getproductocount($List);
		$pag = (int)($totalregistros/LIMITE_REG);
		if ($pag < $List->getelem()->pagactual){
			$List->getelem()->numretlimitdes = $pag*LIMITE_REG;
			$List->getelem()->pagactual = $pag;
		}

		$totalregsolic = $List->getelem()->numretlimit+0;
		$List->gofirst();
        $query="SELECT	p.id_producto,
                        p.cod_prod1 sap,
                        b.cod_barra barra,
                        p.des_larga descripcion,
                        p.des_corta descripcionc,
                        p.prod_tipo,
                        p.prod_subtipo,
                        p.peso,
                        r.cod_local csum,
						r.prec_costo pcosto,
                        r.prec_valor pventa,
                        r.stock,
                        r.reteica,
                        r.iva,
                        r.retefuente,
                        b.unid_med unidmed
                FROM 	productos p
                JOIN 	precios r on r.cod_prod1 = p.cod_prod1
                LEFT JOIN codbarra b on b.cod_prod1 = p.cod_prod1
                LEFT JOIN prodxprov x on x.cod_prod1 = p.cod_prod1
                WHERE
                p.cod_prod1 = '".$List->getelem()->sap."'";
    	//general::writeevent('query productos '. $query);
        $pag = $List->getelem()->pagactual+0;
        $res = $this->bd->query($query);

        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		$List->clearlist();

        while ($row = $res->fetch_assoc()){
            $Registro = new dtoproducto;
            $Registro->cod_prod1   	= $row['cod_prod1'];
            $Registro->id_producto	= $row['id_producto'];
            $Registro->sap   		= $row['sap'];
            $Registro->barra   		= $row['barra'];
            $Registro->descripcion	= htmlspecialchars(str_replace("#", "", $row['descripcion']), ENT_QUOTES);
            $Registro->prod_tipo	= $row['prod_tipo'];
            $Registro->prod_subtipo	= $row['prod_subtipo'];
            $Registro->csum   		= $row['csum'];
            $Registro->pcosto   	= round($row['pcosto']+0);
            $Registro->pventa   	= round($row['pventa']+0);
            $Registro->stock   		= $row['stock'];
            $Registro->unidmed   	= $row['unidmed'];
            $Registro->ica       	= $row['reteica'];
            $Registro->renta    	= $row['retefuente'];
            $Registro->ivap      	= $row['iva'];
            $Registro->nomprov   	= htmlspecialchars($row['nomprov'], ENT_QUOTES);
            $Registro->numretreal	= ($totalregistros+0);
            $Registro->numretlimit	= ($totalregsolic+0);
            $Registro->descripcionc	= $row['descripcionc'];
            $Registro->pagactual	= $pag;

            $List ->addlast($Registro);
        }

        $res->free();
        return true;
    }

    public function getplista($List){
		$List->gofirst();
        $query="SELECT	Distinct
						r.prec_costo * b.factor_conv pcosto,
                        round((r.prec_valor * 100 ) / (100 + ".(VALOR_IVA+0).")) * b.factor_conv pventa,
                        b.unid_med unidmed,
                        '' nomprov
                FROM 	productos p
                JOIN 	precios r on r.cod_prod1 = p.cod_prod1
                LEFT JOIN codbarra b on b.cod_prod1 = p.cod_prod1
                LEFT JOIN prodxprov x on x.cod_prod1 = p.cod_prod1
                JOIN 	proveedores v on v.id_proveedor = x.id_proveedor " . (($List->getelem()->nomprov)? " AND v.nom_prov like '%".str_replace(' ', '%', trim($List->getelem()->nomprov))."%' " : "") . "
                WHERE 1
                " . (($List->getelem()->sap)? " AND p.cod_prod1 = '".$List->getelem()->sap."' " : "") . "
                " . (($List->getelem()->csum)? " AND r.cod_local = '".$List->getelem()->csum."' " : "") . "
                AND b.unid_med in (".UNIMED_VALID.") ORDER BY unidmed DESC LIMIT 0, ".($List->getelem()->numretlimit+0)."
                ";

        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoproducto;
            if(!(round($row['pventa']+0))||round($row['pventa']+0)==0){
	            general::writelog('No ha sido posible recuperar el precio lista. El valor recuperado de precio de lista fue: '.round($row['pventa']+0)==0);
            	$Registro->plista   	= '-------';
    	        $Registro->stock   		= $row['stock'];
	            $List ->addlast($Registro);
            }else{
	            $Registro->plista   	= round($row['pventa']+0);
    	        $Registro->stock   		= $row['stock'];
        	    $List ->addlast($Registro);
            }
        }
        $res->free();
        return true;
    }
    public function getproductogrilla($List){
		//$totalregistros = $this->getproductocount($List);
		$totalregsolic = $List->getelem()->numretlimit+0;
		$List->gofirst();
        $query="SELECT	Distinct
						ct.id_catprod catprod,
        				p.id_producto,
        				(p.peso / 1000) as peso,
        				r.reteica,
        				r.iva,
        				r.retefuente,
                        p.cod_prod1 sap,
						b.cod_barra,
                        p.des_larga descripcion,
                        p.prod_tipo,
                        p.prod_subtipo,
                        r.cod_local csum,
						r.prec_costo pcosto,
                        r.prec_valor pventa,
                        r.stock stock,
                        b.unid_med unidmed,
                        v.nom_prov nomprov,
						p.id_catprod
                FROM 	productos p
                JOIN 	precios r on r.cod_prod1 = p.cod_prod1
                LEFT JOIN codbarra b on b.cod_prod1 = p.cod_prod1
                LEFT JOIN prodxprov x on x.cod_prod1 = p.cod_prod1
                JOIN 	proveedores v on v.cod_prov = x.cod_prov " . (($List->getelem()->nomprov)? " AND v.nom_prov like '%".str_replace(' ', '%', trim($List->getelem()->nomprov))."%' " : "") . "
				JOIN 	catprod cat on cat.id_catprod = p.id_catprod
                LEFT JOIN catprod ct on cat.id_catpadre = ct.id_catprod
                WHERE 1
                " . (($List->getelem()->sap)? " AND p.cod_prod1 = '".$List->getelem()->sap."' " : "") . "
                " . (($List->getelem()->barra)? " AND b.cod_barra = '".$List->getelem()->barra."' " : "") . "
                " . (($List->getelem()->descripcion)? " AND p.des_larga like '%".str_replace(' ', '%', trim($List->getelem()->descripcion))."%' " : "") . "
                " . (($List->getelem()->csum)? " AND r.cod_local = '".$List->getelem()->csum."' " : "") . "
                " . (($List->getelem()->prod_tipo)? " AND p.prod_tipo = '".$List->getelem()->prod_tipo."' " : "") . "
                " . (($List->getelem()->prod_subtipo)?($List->getelem()->prod_subtipo=='GE'?" AND p.prod_subtipo = '".$List->getelem()->prod_subtipo."' ":" AND p.prod_subtipo <> 'GE'"): "") . "
                AND b.unid_med in (".UNIMED_VALID.") AND p.estadoactivo <>'E'
                ORDER BY unidmed DESC, cod_ppal DESC
                LIMIT 0, ".($List->getelem()->numretlimit+0)."
                ";
        $res = $this->bd->query($query);
		//general::writeevent("CONSULTA PRECIO: " . $query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoproducto;
            $Registro->cod_prod1   	= $row['cod_prod1'];
            $Registro->id_producto	= $row['id_producto'];
            $Registro->sap   		= $row['sap'];
            $Registro->barra   		= $row['cod_barra'];
            $Registro->descripcion	= htmlspecialchars(str_replace("#", "", $row['descripcion']),ENT_QUOTES);
            $Registro->prod_tipo	= $row['prod_tipo'];
            $Registro->prod_subtipo	= $row['prod_subtipo'];
            $Registro->csum   		= $row['csum'];
            $Registro->pcosto   	= round($row['pcosto']+0);
            $Registro->pventa   	= round($row['pventa']+0);
            $Registro->stock   		= $row['stock'];
            $Registro->unidmed   	= $row['unidmed'];
			$Registro->nomprov   	= htmlspecialchars($row['nomprov'], ENT_QUOTES);
            $Registro->numretlimit	= ($totalregsolic+0);
			$Registro->id_catprod  	= $row['catprod'];
			$Registro->peso  	= $row['peso'];
			$Registro->ica  	= $row['reteica'];
			$Registro->ivap  	= $row['iva'];
			$Registro->renta  	= $row['retefuente'];

            $List ->addlast($Registro);
        }
        $res->free();
        return true;
    }

     /*Metodo Optener Listado Nuevo de Productos en wsprocessos*/
    public function getproductows($List,$codlocal,$ean){
    	$query = "	SELECT  o.cod_prod1, pr.des_corta, pr.prod_tipo, pr.prod_subtipo, o.unid_med, pre.prec_costo
					FROM  codbarra o
					LEFT JOIN productos pr on pr.id_producto=o.id_producto
					LEFT JOIN precios pre on pre.cod_prod1=o.cod_prod1
                    WHERE o.cod_barra = ".$ean." and pre.cod_local ='".$codlocal."'";

        //general::writelog("Sentencia CP : " . $query);
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while($row = $res->fetch_assoc()){
            $Registro = new dtodetordenent;
            $Registro->descripcion	= 	$row['des_corta'];
            $Registro->codprod 		= 	$row['cod_prod1'];
            $Registro->codtipo 		= 	$row['prod_tipo'];
            $Registro->codsubtipo 	= 	$row['prod_subtipo'];
            $Registro->unimed 		= 	$row['unid_med'];
            $Registro->pcosto	 	= 	$row['prec_costo'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    /*Fin Metodo Optener Listado Nuevo de Productos en wsprocessos*/

    public function getprovpreferencial($List){
		$totalregsolic = $List->getelem()->numretlimit+0;
		$List->gofirst();
		$query="SELECT	Distinct
        				p.id_producto,
                        p.cod_prod1 sap,
						b.cod_barra,
                        r.cod_local csum,
						r.prec_costo * b.factor_conv pcosto,
                        round((r.prec_valor * 100 ) / (100 + ".(VALOR_IVA+0).")) * b.factor_conv pventa,
                        r.stock stock,
                        v.nom_prov nomprov,
                        v.rut_prov rutproveedor
                FROM 	productos p
                JOIN 	precios r on r.cod_prod1 = p.cod_prod1
                LEFT JOIN codbarra b on b.cod_prod1 = p.cod_prod1
                LEFT JOIN prodxprov x on x.cod_prod1 = p.cod_prod1
                JOIN 	proveedores v on v.id_proveedor = x.id_proveedor " . (($List->getelem()->nomprov)? " AND v.nom_prov like '%".str_replace(' ', '%', trim($List->getelem()->nomprov))."%' " : "") . "
                WHERE 1
                " . (($List->getelem()->sap)? " AND p.cod_prod1 = '".$List->getelem()->sap."' " : "") . "
                " . (($List->getelem()->barra)? " AND b.cod_barra = '".$List->getelem()->barra."' " : "") . "
                " . (($List->getelem()->csum)? " AND r.cod_local = '".$List->getelem()->csum."' " : "") . "
                ";
//		general::writelog($query);
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoproducto;
            $Registro->sap   		= $row['sap'];
            $Registro->nomprov   	= htmlspecialchars($row['nomprov'], ENT_QUOTES);
            $Registro->rutproveedor	= $row['rutproveedor'];
            $List ->addlast($Registro);
        }
        $res->free();
        return true;
    }

	public function getproductoxproveedor($List){

		$List->gofirst();
		$query="SELECT count(id_producto) as id_producto FROM prodxprov  where 1
                " . (($List->getelem()->cod_prod1)? " AND cod_prod1= ".$List->getelem()->cod_prod1."" : "") . "
                " . (($List->getelem()->idprov)? " and cod_prov= ".$List->getelem()->idprov."" : "") . "";
		//general::writelog($query);
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoproducto;
            $Registro->id_producto   		= $row['id_producto'];
            $List ->addlast($Registro);
        }
        $res->free();
        return true;
    }

	public function getproductoxdatosproveedor($List){

		$List->gofirst();
		$query="SELECT b.rut_prov,b.razsoc_prov,b.nom_prov FROM prodxprov a join proveedores b on (a.cod_prov=b.cod_prov) where  1
                " . (($List->getelem()->cod_prod1)? " AND cod_prod1= ".$List->getelem()->cod_prod1."" : "") . "";
		//general::writelog($query);
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoproducto;
            $Registro->rutproveedor   		= $row['rut_prov'];
            $Registro->razonsocprov   		= $row['razsoc_prov'];
            $Registro->nomprov		   		= $row['nom_prov'];
            $List ->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function getnivel4($List){
		//echo('voy a llamar');
		$List->gofirst();
		$query="SELECT
			   distinct cp.id_catprod catprod,
			   cp.descat descat,
			   cp.cat_nivel nivel,
			   cp.id_catpadre catpadre
				FROM    catprod cp
				join  productos prd on cp.id_catprod = prd.id_catprod
				join  precios pre   on prd.id_producto = pre.id_producto and prd.cod_prod1 = pre.cod_prod1
				order by 1
				";
        $res = $this->bd->query($query);
		//general::writeevent($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoproducto;
			//echo (.'--'.$row['cp.id_catprod'].'--'.$row['cp.descat'].'--'.$row['cp.cat_nivel'].'--'.$row['cp.id_catpadre']);
            $Registro->catprod 		= $row['catprod'];
            $Registro->descat 		= htmlspecialchars(str_replace("'", "",$row['descat']), ENT_QUOTES);
            $Registro->nivel 		= $row['nivel'];
            $Registro->catpadre		= $row['catpadre'];
            $List ->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function getnivel3($List){
		$List->gofirst();
		$query="SELECT
			   distinct cp.id_catprod as catprod,
			   cp.descat as descat,
			   cp.id_catpadre as catpadre
				FROM
					   catprod cp
				WHERE 1
                " . (($List->getelem()->catpadre)? " AND cp.id_catprod = ('".$List->getelem()->catpadre."') " : "") . "
				";
        $res = $this->bd->query($query);
//		general::writeevent($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoproducto;
            $Registro->catprod 		= $row['catprod'];
            $Registro->descat 		= htmlspecialchars($row['descat']);
            $Registro->catpadre		= $row['catpadre'];
            $List ->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function getnivel2($List){
		$List->gofirst();
		$query="SELECT
			   distinct cp.id_catprod as catprod,
			   cp.descat as descat,
			   cp.id_catpadre as catpadre
				FROM
					   catprod cp
				WHERE 1
                " . (($List->getelem()->catpadre)? " AND cp.id_catprod = ('".$List->getelem()->catpadre."') " : "") . "
				";
        $res = $this->bd->query($query);
		//general::writeevent('query nivel 2: '.$query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoproducto;
            $Registro->catprod 		= $row['catprod'];
            $Registro->descat 		= htmlspecialchars($row['descat']);
            $Registro->catpadre		= $row['catpadre'];
            $List ->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function getnivel1($List){
		$List->gofirst();
		$query="SELECT
			   distinct cp.id_catprod as catprod,
			   cp.descat as descat,
			   cp.id_catpadre as catpadre
				FROM
					   catprod cp
				WHERE 1
                " . (($List->getelem()->catpadre)? " AND cp.id_catprod = ('".$List->getelem()->catpadre."') " : "") . "
				";
        $res = $this->bd->query($query);
		//general::writeevent('query nivel 1: '.$query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoproducto;
            $Registro->catprod 		= $row['catprod'];
            $Registro->descat 		= htmlspecialchars($row['descat']);
            $Registro->catpadre		= $row['catpadre'];
            $List ->addlast($Registro);
        }
        $res->free();
        return true;
    }


}
?>
