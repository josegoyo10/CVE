<?php
class dtotransferenciamercancia{
	private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
        
		$this->arreglo[ 'codlocalsuministro' ] = null;
		$this->arreglo[ 'codlocalfactura' ] = null;
		$this->arreglo[ 'fecha_ini' ] = null;
		$this->arreglo[ 'fecha_fin' ] = null;
		$this->arreglo[ 'id_estado' ] = null;
		$this->arreglo[ 'id_tipoentrega' ] = null;
		$this->arreglo[ 'rutcliente' ] = null;
		$this->arreglo[ 'razonsoc' ] = null;
		$this->arreglo[ 'id_cotizacion' ] = null;
		$this->arreglo[ 'id_ordenent' ] = null;
		$this->arreglo[ 'numdocpago' ] = null;
		$this->arreglo[ 'tipoentrega' ] = null;
		$this->arreglo[ 'localfactura' ] = null;
		$this->arreglo[ 'localsuministro' ] = null;
		$this->arreglo[ 'estado' ] = null;
		$this->arreglo[ 'tipoentrega' ] = null;
		$this->arreglo[ 'codigovendedor' ] = null;
		$this->arreglo[ 'totaloe' ] = null;
		$this->arreglo[ 'limite' ] = null;
		
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