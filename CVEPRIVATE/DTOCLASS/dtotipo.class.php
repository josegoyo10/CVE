<?
class dtotipo {
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
        $this->arreglo[ 'id' ] = null;
        $this->arreglo[ 'rut' ] = null;
        $this->arreglo[ 'tcp_id' ] = null;
        $this->arreglo[ 'nombre' ] = null;
        $this->arreglo[ 'valor' ] = null;
        $this->arreglo[ 'valor2' ] = null;
        $this->arreglo[ 'valor3' ] = null;
        $this->arreglo[ 'usrcrea' ] = null;
        $this->arreglo[ 'usrmod' ] = null;
        $this->arreglo[ 'id_tipopago' ] = null;        
        $this->arreglo[ 'id_tipoconpago' ] = null;             
        $this->arreglo[ 'id_tipodocpago' ] = null;            
        $this->arreglo[ 'nomtipoflujo' ] = null;
        $this->arreglo[ 'id_tipocliente' ] = null;      
        $this->arreglo[ 'id_clientepref' ] = null;          
        $this->arreglo[ 'nombre_pref' ] = null;                                
        
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
