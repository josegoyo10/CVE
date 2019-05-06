<?
class dtoemail {
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
        $this->arreglo[ 'SMTPAuten' ] = null;    
        $this->arreglo[ 'Usuarioemail' ] = null;
        $this->arreglo[ 'Passwordemail' ] = null;
        $this->arreglo[ 'From' ] = null;
        $this->arreglo[ 'FromName' ] = null;
        $this->arreglo[ 'AddAddress' ] = null;
        $this->arreglo[ 'AddCC' ] = null;
        $this->arreglo[ 'AddBCC' ] = null;
        $this->arreglo[ 'Asunto' ] = null;
        $this->arreglo[ 'Contenido' ] = null;
        $this->arreglo[ 'AltBody' ] = null;
        $this->arreglo[ 'Tipoemail' ] = null; 
        $this->arreglo[ 'Respuesta' ] = null;
        $this->arreglo[ 'id_cot' ] = null; 
        $this->arreglo[ 'AddAttachment' ] = null;        	
               
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