<?
class dtoinfocliente{
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
        $this->arreglo[ 'rut' ] = null;
        $this->arreglo[ 'id_comuna' ] = null;
        $this->arreglo[ 'id_cotizacion' ] = null;        
        $this->arreglo[ 'nomcomuna' ] = null;
        $this->arreglo[ 'comunaservicio' ] = null;
        $this->arreglo[ 'id_ciudad' ] = null;
        $this->arreglo[ 'nomciudad' ] = null;
        $this->arreglo[ 'ciudadservicio' ] = null;
        $this->arreglo[ 'id_region' ] = null;
        $this->arreglo[ 'diascondicion' ] = null;
        $this->arreglo[ 'nomregion' ] = null;
        $this->arreglo[ 'id_rubro' ] = null;
        $this->arreglo[ 'nomrubro' ] = null;
        $this->arreglo[ 'id_tipocliente' ] = null;
        $this->arreglo[ 'nomtipcliente' ] = null;
        $this->arreglo[ 'id_tipodocpago' ] = null;
        $this->arreglo[ 'nomtipdocpago' ] = null;
        $this->arreglo[ 'codigovendedor' ] = null;
        $this->arreglo[ 'vendedor' ] = null;
        $this->arreglo[ 'razonsoc' ] = null;
        $this->arreglo[ 'id_giro' ] = null;
        $this->arreglo[ 'giro' ] = null;
        $this->arreglo[ 'contacto' ] = null;
        $this->arreglo[ 'fonocontacto' ] = null;
        $this->arreglo[ 'fonoservicio' ] = null;
        $this->arreglo[ 'email' ] = null;
        $this->arreglo[ 'direccion' ] = null;
        $this->arreglo[ 'direccionservicio' ] = null;
        $this->arreglo[ 'locksap' ] = null;
        $this->arreglo[ 'lockmoro' ] = null;
        $this->arreglo[ 'lockcve' ] = null;
        $this->arreglo[ 'lockfecha' ] = null;
        $this->arreglo[ 'valdisp' ] = null;
        $this->arreglo[ 'comentario' ] = null;
        $this->arreglo[ 'codlocaluco' ] = null;
        $this->arreglo[ 'nomlocaluco' ] = null;
        $this->arreglo[ 'fechaucofini' ] = null;
        $this->arreglo[ 'fechaucoffin' ] = null;
        $this->arreglo[ 'fechauco' ] = null;
        $this->arreglo[ 'orderby' ] = null;
        $this->arreglo[ 'disponible' ] = null; 
        $this->arreglo[ 'codclisap' ] = null; 
        $this->arreglo[ 'usrcrea' ] = null;
        $this->arreglo[ 'feccrea' ] = null;
        $this->arreglo[ 'usrmod' ] = null;          
        $this->arreglo[ 'fecmod' ] = null;                  
        $this->arreglo[ 'fchalimite' ] = null; ////Mantis 30518: Deshabilitacion boton de generacion de cotizacion                  
        $this->arreglo[ 'id_linea' ] = null;        
        $this->arreglo[ 'monto' ] = null;
        $this->arreglo[ 'rutcliente' ] = null;                          
        $this->arreglo[ 'id_ordenent' ] = null;         
        $this->arreglo[ 'id_documento' ] = null;            
            $this->arreglo[ 'diascondicion' ] = null;                   
            $this->arreglo[ 'id_tipoconpago' ] = null; 
            $this->arreglo[ 'numdiaspago' ] = null;     
        $this->arreglo['limite'] = null;
        $this->arreglo['total_encontrado'] = null;  
        $this->arreglo['registro'] = null;          
        $this->arreglo[ 'id_clientepref' ] = null;        
        $this->arreglo['sinasignar'] = null;
        $this->arreglo['rete_iva'] = null;
        $this->arreglo['rete_ica'] = null;
        $this->arreglo['rete_renta'] = null;
        $this->arreglo['id_documento_identidad'] = null;
        $this->arreglo['id_clasificacion_cli'] = null;
        $this->arreglo['apellido'] = null;
        $this->arreglo['apellido1'] = null;
        $this->arreglo['celcontactoe'] = null;
        $this->arreglo['fax'] = null;
        $this->arreglo['id_contribuyente'] = null;        
        $this->arreglo['id_regimencontri'] = null;
        $this->arreglo['genero'] = null;
        $this->arreglo['accionupdate'] = null;
        $this->arreglo['id_profesion'] = null;
        $this->arreglo['profesion'] = null;
        $this->arreglo['contribuyente'] = null;

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
