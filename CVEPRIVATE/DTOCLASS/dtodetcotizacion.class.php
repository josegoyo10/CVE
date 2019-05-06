<?
class dtodetcotizacion {
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
    	$this->arreglo['id_linea'] = null;
    	$this->arreglo['id_cotizacion'] = null;
		$this->arreglo['id_tiporetiro'] = null;
		$this->arreglo['id_tipoentrega'] = null;
		$this->arreglo['nomtiporetiro'] = null;				
		$this->arreglo['numlinea'] = null;
    	$this->arreglo['descripcion'] = null;
        $this->arreglo['codlocalcsum'] = null;
    	$this->arreglo['codprod'] = null;
     	$this->arreglo['barra'] = null;
     	$this->arreglo['nomprov'] = null;
		$this->arreglo['rutproveedor']   = null;
     	$this->arreglo['pcosto'] = null;
		$this->arreglo['pventaneto'] = null; 
		$this->arreglo['cargoflete'] = null;
		$this->arreglo['valorfleteh'] = null;
		$this->arreglo['pventaiva'] = null;
		$this->arreglo['totallinea'] = null;
		$this->arreglo['cantidad'] = null;
		$this->arreglo['cantidade'] = null;
		$this->arreglo['margenlinea'] = null;
        $this->arreglo['incluirentotal'] = null;
		$this->arreglo['usrcrea'] = null;
		$this->arreglo['unimed'] = null;
        $this->arreglo['codtipo'] = null;
        $this->arreglo['codsubtipo'] = null;
        $this->arreglo['reqdet'] = null;
        $this->arreglo['lisdetprod'] = null;
        $this->arreglo['marcaflete'] = null;
        $this->arreglo['instalacion'] = null;
        $this->arreglo['descuento'] = null;
        $this->arreglo['peso'] = null;
        $this->arreglo['rete_ica'] = null;
        $this->arreglo['rete_renta'] = null;
        $this->arreglo['cot_iva'] = null;         
        $this->arreglo['sumiva'] = null;
        $this->arreglo['sumtotaliva'] = null;
        $this->arreglo['actualizarinventario'] = false;
        
        $this->arreglo['grupocat'] = null;
		        
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
