<?
class dtodetdocumento {
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
        $this->arreglo[ 'id_linea' ] = null;
        $this->arreglo[ 'id_documento' ] = null;
        $this->arreglo[ 'numlinea' ] = null;
        $this->arreglo[ 'descripcion' ] = null;
        $this->arreglo[ 'codprod' ] = null;
        $this->arreglo[ 'barra' ] = null;
        $this->arreglo[ 'codtipo' ] = null;
        $this->arreglo[ 'pventaneto' ] = null;
        $this->arreglo[ 'pventaiva' ] = null;
        $this->arreglo[ 'cantidad' ] = null;
        $this->arreglo[ 'pcosto' ] = null;
        $this->arreglo[ 'totallinea' ] = null;
        $this->arreglo[ 'impuesto1' ] = null;
        $this->arreglo[ 'impuesto2' ] = null;
        $this->arreglo[ 'unimed' ] = null;        
        $this->arreglo[ 'id_linearef' ] = null;  
        $this->arreglo[ 'usrcrea' ] = null;          
        $this->arreglo[ 'feccrea' ] = null;          
        $this->arreglo[ 'usrmod' ] = null;             
        $this->arreglo[ 'marcador' ] = null;                     
        $this->arreglo[ 'rutproveedor' ] = null;   
        $this->arreglo[ 'nomproveedor' ] = null;   
        $this->arreglo[ 'codtipo' ] = null;         
        $this->arreglo[ 'codsubtipo' ] = null;          
        $this->arreglo[ 'marcaflete' ] = null; 
        $this->arreglo[ 'iva'] = null;
                 
        
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
