<?
class dtocomuna {
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
        $this->arreglo[ 'id_comuna' ] = null;
        $this->arreglo[ 'nomcomuna' ] = null;
        $this->arreglo[ 'id_ciudad' ] = null;
        $this->arreglo[ 'nomciudad' ] = null;
        $this->arreglo[ 'id_region' ] = null;
        $this->arreglo[ 'nomregion' ] = null;
        $this->arreglo[ 'usrcrea' ] = null;
        $this->arreglo[ 'usrmod' ] = null;
        $this->arreglo[ 'id_comunad' ] = null;
        $this->arreglo[ 'nomcomunad' ] = null;
        
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
