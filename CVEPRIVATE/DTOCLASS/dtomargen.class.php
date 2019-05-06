<?
class dtomargen {
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
      		$Registro->id_margen     	=   null;
            $Registro->id_seccion      	=   null;
            $Registro->desc_seccion		= 	null;
            $Registro->id_rubro			= 	null;
            $Registro->desc_rubro		= 	null;
            $Registro->margen			= 	null;
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
