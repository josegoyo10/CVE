<?
class dtoencordenent {
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {

        $this->arreglo[ 'id_ordenent' ] = null;
        $this->arreglo[ 'id_cotizacion' ] = null;
        $this->arreglo[ 'id_estado' ] = null;
        $this->arreglo[ 'id_estado_destino' ] = null;
        $this->arreglo[ 'id_tipopago' ] = null;
        $this->arreglo[ 'id_tipodocpago' ] = null;
        $this->arreglo[ 'id_tipoentrega' ] = null;
        $this->arreglo[ 'nomtipoentrega' ] = null;
        $this->arreglo[ 'id_direccion' ] = null;
        $this->arreglo[ 'id_tipoflujo' ] = null;
        $this->arreglo[ 'nomtipoflujo' ] = null;
        $this->arreglo[ 'codigovendedor' ] = null;
        $this->arreglo[ 'numdocpago' ] = null;                
        $this->arreglo[ 'rutcliente' ] = null;
        $this->arreglo[ 'rutvendedor' ] = null;
        $this->arreglo[ 'codlocalventa' ] = null;
        $this->arreglo[ 'codlocalcsum' ] = null;
        //obtencion de fecha
        $this->arreglo['validdesde'] = null;
        $this->arreglo['validhasta'] = null;
        $this->arreglo['fecha_retira_cliente'] = null;
        $this->arreglo['fecha_retira_inmediato'] = null;
        $this->arreglo['fecha_despacho_programado'] = null;				
            
        //obtencion de fecha
        $this->arreglo[ 'nom_local' ] = null;
        $this->arreglo[ 'nom_localcsum' ] = null;
        $this->arreglo[ 'nom_localventa' ] = null;
        $this->arreglo[ 'nom_localventa' ] = null;
        $this->arreglo[ 'razonsoc' ] = null;
        $this->arreglo[ 'giro' ] = null;
        $this->arreglo[ 'id_giro' ] = null;
        $this->arreglo[ 'direccion' ] = null;
        $this->arreglo[ 'comuna' ] = null;
        $this->arreglo[ 'ciudad' ] = null;
        $this->arreglo[ 'iva' ] = null;                
        $this->arreglo[ 'condicion' ] = null;
        $this->arreglo[ 'diascondicion' ] = null;
        $this->arreglo[ 'fonocontacto' ] = null;
        $this->arreglo[ 'observaciones' ] = null;
        $this->arreglo[ 'nota' ] = null;
        $this->arreglo[ 'id_usuario' ] = null;
        $this->arreglo[ 'fechacompra' ] = null;                
        $this->arreglo[ 'obsdesb' ] = null;    
        $this->arreglo[ 'usrcrea' ] = null; 
        $this->arreglo[ 'usrmod' ] = null;    
        $this->arreglo[ 'fecmod' ] = null;
        $this->arreglo[ 'feccrea' ] = null;                   
        $this->arreglo[ 'tipo' ] = null;        
        $this->arreglo[ 'nomestadorent' ] = null;        
        $this->arreglo[ 'puedever' ] = null;
        $this->arreglo[ 'indmsgsap' ] = null;
        $this->arreglo[ 'numdocumento' ] = null;  
        $this->arreglo[ 'fechaucofini' ] = null;
        $this->arreglo[ 'fechaucoffin' ] = null;
        $this->arreglo[ 'limite' ] = null;        
        $this->arreglo[ 'total_orden' ] = null;
        $this->arreglo[ 'prorrateoflete' ] = null;        
        $this->arreglo[ 'numorigen' ] = null;
        $this->arreglo[ 'telefono' ] = null;        
                      
		//Campos Auxiliares
        $this->arreglo[ 'id_ordenpicking' ] = null;
        $this->arreglo[ 'id_documento' ] = null;
        $this->arreglo[ 'tipodocgen' ] = null;
        $this->arreglo[ 'monto' ] = null;
        $this->arreglo[ 'prioridadpick' ] = null;
        $this->arreglo[ 'var_descripcion' ] = null;
        $this->arreglo[ 'feccreacoti' ] = null;
        $this->arreglo[ 'rete_ica' ] = null;
        $this->arreglo[ 'rete_renta' ] = null;
        $this->arreglo[ 'rete_iva' ] = null;	
        $this->arreglo[ 'cot_iva' ] = null;
        $this->arreglo[ 'valortotal' ] = null;
        $this->arreglo[ 'totaliva' ] = null;
        $this->arreglo['id_dirdespacho'] = null;
        $this->arreglo['zona'] = null;
        $this->arreglo['rete_iva_oe'] = null;
        $this->arreglo['totaloe'] = null;
        $this->arreglo['tipo_mensaje'] = null;
        
          $this->arreglo['margen'] = null;
        //Campos Anulacion x Tiempo
		$this->arreglo['verif_anul_tiempo'] = null;
        //Campos Anulacion x Tiempo

		//Nombre del local de venta
		$this->arreglo['nom_localventa'] = null;
		//Nombre del local de venta
                
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
