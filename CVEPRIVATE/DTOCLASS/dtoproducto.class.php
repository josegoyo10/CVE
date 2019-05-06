<?
class dtoproducto {
    /*** variables de clase ***/
	private $arreglo = array();
	
	/*** Constructor ***/ 
	function __construct($arrelem = null) {
        $this->arreglo[ 'catprod' ] = null;
        $this->arreglo[ 'descat' ] = null;
        $this->arreglo[ 'nivel' ] = null;
        $this->arreglo[ 'catpadre' ] = null;
		$this->arreglo['cod_prod1']   = null;
		$this->arreglo['id_producto']   = null;
		$this->arreglo['sap']   = null;
		$this->arreglo['barra']   = null;
		$this->arreglo['descripcion']   = null;
		$this->arreglo['descripcionc']   = null;
		$this->arreglo['prod_tipo']   = null;
		$this->arreglo['prod_subtipo']   = null;
		$this->arreglo['csum']   = null;	//Código del local Centro de suministro
		$this->arreglo['pcosto']   = null;
		$this->arreglo['plista']   = null;
		$this->arreglo['pventa']   = null;
		$this->arreglo['stock']   = null;
		$this->arreglo['unidmed']   = null;
		$this->arreglo['idprov']   = null;
		$this->arreglo['nomprov']   = null;
		$this->arreglo['rutproveedor']   = null;
		$this->arreglo['razonsocprov']   = null;
		$this->arreglo['numretreal']   = null;	//Cantidad total de registros encontrados
		$this->arreglo['numretlimit']   = null; //Cantidad total de registros retornados
		$this->arreglo['numretlimitdes']   = null; //Cantidad desde de registros retornados
        $this->arreglo['pagactual']   = null; //Cantidad desde de registros retornados
		$this->arreglo['id_catprod']   = null;
		$this->arreglo['peso']   = null;
		$this->arreglo['ica']   = null;
		$this->arreglo['ivap']   = null;
		$this->arreglo['renta']   = null;
		$this->arreglo['codtipo']   = null;
		$this->arreglo['tipopedido']   = null;
		$this->arreglo['actualizarinventario']   = false;       
		$this->arreglo['grupocat']   = null;
        if (is_array($arrelem))
        	foreach($arrelem as $key=>$value)
        		$this->$key = $value;
	}

	/*** Setter ***/
    public function __set($name, $value) {
		if (array_key_exists($name, $this->arreglo)) {
			$this->arreglo[$name] = $value;
		} else {
			throw new SYSException(__CLASS__ , __FUNCTION__ , "Error: No existe el atributo requerido en SET $name", __METHOD__, 3);
		}
    }

	/*** Getter ***/
    public function __get($name) {
		if (array_key_exists($name, $this->arreglo)) {
			return $this->arreglo[$name];
		} else {
			throw new SYSException(__CLASS__ , __FUNCTION__ , "Error: No existe el atributo requerido en GET $name", __METHOD__, 3);
		}
    }
}
?>
