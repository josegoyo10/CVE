<?
class dtoencordenpicking {
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
	    $this->arreglo['id_ordenpicking'] = null;
        $this->arreglo['id_ordenent'] = null;
        $this->arreglo['id_estado'] = null;
        $this->arreglo['id_cotizacion'] = null;
        $this->arreglo['factura'] = null;
        $this->arreglo['nomestado'] = null;        
        $this->arreglo['id_direccion'] = null;
        $this->arreglo['id_tipoentrega'] = null;
        $this->arreglo['nomtipoentrega'] = null;
        $this->arreglo['rutcliente'] = null;
        $this->arreglo['cod_local'] = null;
        $this->arreglo['nom_local'] = null;        
        $this->arreglo['razonsoc'] = null;
        $this->arreglo['direccion'] = null;
        $this->arreglo['comuna'] = null;
        $this->arreglo['fonocontacto'] = null;
        $this->arreglo['observaciones'] = null;
        $this->arreglo['nota'] = null;
        $this->arreglo['id_usuario'] = null;
        $this->arreglo['usuariocrea'] = null;   
        $this->arreglo['puedever'] = null;
        $this->arreglo['puedemodificar'] = null;
        $this->arreglo['feccrea'] = null;        
        $this->arreglo[ 'fechaucofini' ] = null;
        $this->arreglo[ 'fechaucoffin' ] = null;
        $this->arreglo[ 'prioridad' ] = null;
        $this->arreglo[ 'nomprioridad' ] = null;
        $this->arreglo[ 'limite' ] = null;        
        $this->arreglo[ 'total_orden_pick' ] = null;
         $this->arreglo[ 'n_impresiones' ] = null;
        $this->arreglo[ 'usuario_impresion' ] = null;
        $this->arreglo[ 'fecha_retira_cliente' ] = null;
        $this->arreglo[ 'fecha_retira_inmediato' ] = null;
        $this->arreglo[ 'fecha_despacho_programado' ] = null;
        $this->arreglo[ 'zona' ] = null;
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