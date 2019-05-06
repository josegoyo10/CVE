<?
class dtodetordenent {
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
        $this->arreglo[ 'id_linea' ] = null;
        $this->arreglo[ 'id_ordenent' ] = null;
        $this->arreglo[ 'id_tiporetiro' ] = null;
        $this->arreglo[ 'id_tipoentrega' ] = null;
        $this->arreglo[ 'numlinea' ] = null;
        $this->arreglo[ 'descripcion' ] = null;
        $this->arreglo[ 'codprod' ] = null;
        $this->arreglo[ 'barra' ] = null;
        $this->arreglo[ 'nomproveedor' ] = null;                
        $this->arreglo[ 'rutproveedor' ] = null;                
        $this->arreglo[ 'pcosto' ] = null;
        $this->arreglo[ 'pventaneto' ] = null;
        $this->arreglo[ 'pventaiva' ] = null;
        $this->arreglo[ 'totallinea' ] = null;
        $this->arreglo[ 'cantidade' ] = null;
        $this->arreglo[ 'cantidadp' ] = null;
        $this->arreglo[ 'cantidadd' ] = null;
        $this->arreglo[ 'id_lineadoc' ] = null;
        $this->arreglo[ 'id_documento' ] = null;
        $this->arreglo[ 'id_documentof' ] = null;
        $this->arreglo[ 'id_documentog' ] = null;
        $this->arreglo[ 'unimed' ] = null;        
        $this->arreglo[ 'codtipo' ] = null;        
        $this->arreglo[ 'codsubtipo' ] = null;        
        $this->arreglo[ 'paginaf' ] = null;        
        $this->arreglo[ 'paginag' ] = null;        
        $this->arreglo[ 'marcaflete' ] = null;  
        $this->arreglo[ 'instalacion' ] = null;
        $this->arreglo[ 'peso' ] = null; 
        $this->arreglo[ 'ret_ica' ] = null;
        $this->arreglo[ 'ret_iva' ] = null;
        $this->arreglo[ 'ret_renta' ] = null;
        $this->arreglo[ 'rete_ica' ] = null;
        $this->arreglo[ 'rete_renta' ] = null;
        $this->arreglo[ 'coti_iva' ] = null;
        $this->arreglo[ 'sumiva' ] = null;
        $this->arreglo[ 'sumtotaliva' ] = null;
        $this->arreglo[ 'descuento' ] = null;
        $this->arreglo[ 'codlocalventa' ] = null;
        $this->arreglo[ 'iva' ] = null;
        $this->arreglo[ 'margenlinea' ] = null;
        $this->arreglo[ 'obspos' ] = null;               
        
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
