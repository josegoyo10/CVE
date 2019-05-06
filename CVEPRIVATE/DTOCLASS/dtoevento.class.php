<?
class dtoevento {
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
        $this->arreglo[ 'id' ] = null; //¿id de evento o id de base de datos? asumo lo segundo.
        $this->arreglo[ 'id_evento' ] = null;
        $this->arreglo[ 'tipo_evento' ] = null;
        $this->arreglo[ 'fecha' ] = null;
        $this->arreglo[ 'hora' ] = null;        
        $this->arreglo[ 'tipoObjeto' ] = null;        
        $this->arreglo[ 'ip_cliente' ] = null; 
        $this->arreglo[ 'nombre_objeto' ] = null;        
        $this->arreglo[ 'tipo_objeto' ] = null;               
        $this->arreglo[ 'descripcion' ] = null;
        $this->arreglo[ 'estado_anterior' ] = null;
        $this->arreglo[ 'estado_posterior' ] = null;
        $this->arreglo[ 'usuario' ] = null;
        $this->arreglo[ 'checksum' ] = null; 
        //elementos para facilitar las búsquedas
        $this->arreglo[ 'feini' ] = null;
        $this->arreglo[ 'fefin' ] = null;

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
