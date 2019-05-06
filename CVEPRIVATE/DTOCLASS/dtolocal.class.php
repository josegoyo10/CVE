<?
class dtolocal {
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
        $this->arreglo['cod_local'] = null;
        $this->arreglo['cod_local_selected' ] = null;        
        $this->arreglo['nom_local'] = null;
        $this->arreglo['dir_local'] = null;        
        $this->arreglo['ip_local'] = null;    
        $this->arreglo['ip'] = null;            
        $this->arreglo['plaza'] = null;            
        $this->arreglo['ofventa'] = null;            
        $this->arreglo['foliofct'] = null;         
        $this->arreglo['codigo_local'] = null;
        $this->arreglo['nombre_local'] = null;        
        $this->arreglo['foliogde'] = null;          
        $this->arreglo['numfolio_fct'] = null;          
        $this->arreglo['numfolio_gde'] = null;  
		$this->arreglo['id_sap'] = null; 
		$this->arreglo['cod_local_pos'] = null; 
 		$this->arreglo['despdom'] = null; 
 		$this->arreglo['id_localizacion'] = null;
 		$this->arreglo['not_cod_local'] = null;
 		$this->arreglo['tienda_virtual'] = null;
 		$this->arreglo['cod_local_fac'] = null;
 		$this->arreglo['cod_local_sum'] = null;
 		$this->arreglo['almacen_cod'] = null;
 		$this->arreglo['oneeasy'] = null;
 		       
        
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
