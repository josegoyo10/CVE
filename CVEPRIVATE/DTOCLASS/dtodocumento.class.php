<?
class dtodocumento {
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
        $this->arreglo[ 'id_documento' ] = null;
        $this->arreglo[ 'id_tipodocumento' ] = null;
        $this->arreglo[ 'id_cotizacion' ] = null;
        $this->arreglo[ 'indodeasap' ] = null;
        $this->arreglo[ 'id_tipoorigen' ] = null;
        $this->arreglo[ 'sigtipodoc' ] = null;
        $this->arreglo[ 'pagina' ] = null;
        $this->arreglo[ 'tipoorigen' ] = null;
        $this->arreglo[ 'numorigen' ] = null;
        $this->arreglo[ 'origen' ] = null;
        $this->arreglo[ 'numdocumento' ] = null;
        $this->arreglo[ 'fechadocumento' ] = null;
        $this->arreglo[ 'fechahora' ] = null;
        $this->arreglo[ 'timewarning' ] = null;
        $this->arreglo[ 'numdocref' ] = null;
        $this->arreglo[ 'numdocrefop' ] = null;
        $this->arreglo[ 'id_proveedor' ] = null;
        $this->arreglo[ 'codigovendedor' ] = null;
        $this->arreglo[ 'rutcliente' ] = null;
        $this->arreglo[ 'rutproveedor' ] = null;        
        $this->arreglo[ 'razonsoc' ] = null;
        $this->arreglo[ 'id_giro' ] = null;
        $this->arreglo[ 'giro' ] = null;
        $this->arreglo[ 'direccion' ] = null;
        $this->arreglo[ 'comuna' ] = null;
        $this->arreglo[ 'iva' ] = null;
        $this->arreglo[ 'totaltexto' ] = null;
        $this->arreglo[ 'totalnum' ] = null;
        $this->arreglo[ 'totaliva' ] = null;
        $this->arreglo[ 'totalnumiva' ] = null;
        $this->arreglo[ 'condicion' ] = null;
        $this->arreglo[ 'diascondicion' ] = null;
        $this->arreglo[ 'fonocontacto' ] = null;
        $this->arreglo[ 'observaciones' ] = null;
        $this->arreglo[ 'nota' ] = null;
        $this->arreglo[ 'codlocalventa' ] = null;
        $this->arreglo[ 'codlocalcsum' ] = null;
        $this->arreglo[ 'lockprintgde' ] = null;
        $this->arreglo[ 'lockprintfct' ] = null;
        $this->arreglo[ 'indmsgsap' ] = null;
        $this->arreglo[ 'txtprn' ] = null;
        $this->arreglo[ 'flujo' ] = null;
        $this->arreglo[ 'monto' ] = null;
        $this->arreglo[ 'feccrea' ] = null;        
        $this->arreglo[ 'usrcrea' ] = null;             
        $this->arreglo[ 'fecmod' ] = null;        
        $this->arreglo[ 'usrmod' ] = null; 
        $this->arreglo[ 'id_tipoflujo' ] = null;
        $this->arreglo[ 'id_ordenent' ] = null;
        $this->arreglo[ 'cod_local' ] = null;
        $this->arreglo[ 'numfolio_fct' ] = null;
        $this->arreglo[ 'numfolio_gde' ] = null;
        $this->arreglo[ 'folionum' ] = null;        
        $this->arreglo[ 'prorrateoflete'] = null;            
        $this->arreglo[ 'mediopago' ] = null;      
        $this->arreglo[ 'estado' ] = null;
		$this->arreglo[ 'indnullsap' ] = null;
		$this->arreglo[ 'nreimpresion' ] = null;		
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
