<?
class dtoperfiles {
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
        $this->arreglo[ 'id' ] = null;
        $this->arreglo[ 'nombre' ] = null;
        $this->arreglo[ 'descripcion' ] = null;
        $this->arreglo[ 'padre_id' ] = null;
        $this->arreglo[ 'usr_crea' ] = null;
        $this->arreglo[ 'fec_crea' ] = null;
        $this->arreglo[ 'usr_mod' ] = null;
        $this->arreglo[ 'fec_mod' ] = null;
        $this->arreglo[ 'solo_lectura' ] = null;
        
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