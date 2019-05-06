<?
class dtodetordenpicking {
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
	    $this->arreglo['id_linea'] = null;
        $this->arreglo['id_ordenpicking'] = null;
        $this->arreglo['numlinea'] = null;
        $this->arreglo['descripcion'] = null;
        $this->arreglo['codprod'] = null;
        $this->arreglo['barra'] = null;
        $this->arreglo['cantidad'] = null;
        $this->arreglo['id_lineadoc'] = null;
        $this->arreglo['totallinea'] = null;
        $this->arreglo['cantidadp'] = null;   
        $this->arreglo[ 'unimed' ] = null;        
        $this->arreglo[ 'codtipo' ] = null;        
        $this->arreglo[ 'codsubtipo' ] = null;        
        $this->arreglo[ 'nomtipoproduct' ] = null;
        $this->arreglo[ 'id_tiporetiro' ] = null;
        $this->arreglo[ 'id_tipoentrega' ] = null;
        $this->arreglo[ 'pventaneto' ] = null; 
        $this->arreglo[ 'peso' ] = null; 
        
        
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
