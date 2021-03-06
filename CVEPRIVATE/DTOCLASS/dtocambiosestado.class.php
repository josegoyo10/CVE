<?
class dtocambiosestado {
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
        $this->arreglo[ 'id_cotizacion' ] = null;     
        $this->arreglo[ 'id_ordenent' ] = null;             
        $this->arreglo[ 'id_estado_origen' ] = null;
        $this->arreglo[ 'id_estado_destino' ] = null;        
        $this->arreglo[ 'tipo' ] = null;          
        $this->arreglo[ 'nomaccion' ] = null;
        $this->arreglo[ 'estadoterminal' ] = null;    
        $this->arreglo[ 'usrmod' ] = null;
        $this->arreglo[ 'color' ] = null;
        
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
