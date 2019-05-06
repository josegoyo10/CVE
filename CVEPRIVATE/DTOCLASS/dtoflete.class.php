<?
class dtoflete{
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
        $this->arreglo[ 'rut' ] = null;
        $this->arreglo[ 'id_cotizacion' ] = null;        
        $this->arreglo[ 'comuna' ] = null;
        $this->arreglo[ 'departamento' ] = null;
        $this->arreglo[ 'ciudad' ] = null;
        $this->arreglo[ 'id_tipocliente' ] = null;
        $this->arreglo[ 'nomtipcliente' ] = null;
        $this->arreglo[ 'direccion' ] = null;
        $this->arreglo[ 'codlocalventa' ] = null;
        $this->arreglo[ 'nomlocalventa' ] = null;
        $this->arreglo[ 'id_ordenent' ] = null; 
        $this->arreglo[	'fechad'] = null;
        $this->arreglo[	'id_tipoentrega' ] = null;
        $this->arreglo[	'id_estado' ] = null;
        $this->arreglo[	'cod_tipo' ] = null;
        $this->arreglo[	'dirdesp' ] = null;
        $this->arreglo[	'codlocalcsum' ] = null;       	
       	
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
