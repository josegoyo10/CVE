<?
class dtopromocion {
    /*** variables de clase ***/
    private $arreglo = array();
        
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
		$this->arreglo['id_promo'] = null;
    	$this->arreglo['descripcion'] = null;
    	$this->arreglo['subrubro'] = null;
        $this->arreglo['nom_localcsum'] = null;
        $this->arreglo['descuento'] = null;
        $this->arreglo['cod_local'] = null;        
        $this->arreglo['fecini'] = null;
        $this->arreglo['fecterm'] = null;
		$this->arreglo['usuario'] = null;
		$this->arreglo['feccrea'] = null;
		$this->arreglo['usrmod'] = null;
        $this->arreglo['fecmod'] = null;
        $this->arreglo['grupo'] = null;
        $this->arreglo['id_grupo'] = null;
        $this->arreglo['cantidad'] = null;
        $this->arreglo['nomestado'] = null; 
        $this->arreglo['rut'] = null;
        //$this->arreglo['estado'] = null;
        $this->arreglo['puedever'] = null; 
        $this->arreglo['puedemodificar'] = null;
        $this->arreglo['puedeeliminar'] = null;
        $this->arreglo[ 'fechaucofini'] = null; //Para manejo del objeto calendar
        $this->arreglo[ 'fechaucoffin'] = null; //Para manejo del objeto calendar
                                         
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
