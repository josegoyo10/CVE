<?
class dtousuario {
    /*** variables de clase ***/
    private $arreglo = array();
    
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
        $this->arreglo[ 'id' ] = null;    
        $this->arreglo[ 'id_tipousuario' ] = null;
        $this->arreglo[ 'cod_local' ] = null;        	
        $this->arreglo[ 'codigovendedor' ] = null;          
        $this->arreglo[ 'rutvendedor' ] = null;  
        $this->arreglo[ 'usr_clave' ] = null;         
        $this->arreglo[ 'usr_tipo' ] = null;          
        $this->arreglo[ 'usr_cod_pos' ] = null; 
        $this->arreglo[ 'usr_estado' ] = null;        
        $this->arreglo[ 'usr_dat_extras' ] = null;        
        $this->arreglo[ 'impresorag' ] = null;        
        
        $this->arreglo[ 'rut' ] = null;
        $this->arreglo[ 'nombres' ] = null;
        $this->arreglo[ 'apellidos' ] = null;
        $this->arreglo[ 'login' ] = null;
        $this->arreglo[ 'impresora' ] = null;     
       
        $this->arreglo[ 'per_id' ] = null;    
        $this->arreglo[ 'usr_id' ] = null;     
        $this->arreglo[ 'usr_nombres' ] = null;     
        $this->arreglo[ 'usr_apellidos' ] = null;                                     
        $this->arreglo[ 'login' ] = null;  
        $this->arreglo[ 'nom_local' ] = null;     
        $this->arreglo[ 'nombre_local' ] = null;              

        $this->arreglo[ 'mod_padre_id' ] = null;  
  	    $this->arreglo[ 'mod_padre_nombre' ] = null;    

  	    $this->arreglo[ 'mod_hijo_id' ] = null;  
  	    $this->arreglo[ 'mod_padre_id' ] = null;    	    
  	    $this->arreglo[ 'mod_hijo_nombre' ] = null;    	    
  	    $this->arreglo[ 'mod_url' ] = null; 
  	    $this->arreglo[ 'mod_orden' ] = null;   
  	    $this->arreglo[ 'nom_com' ] = null;   
        $this->arreglo['orderby'] = null;
        $this->arreglo['sinasignar'] = null;
        $this->arreglo[ 'usr_email' ] = null;
        $this->arreglo[ 'id' ] = null;
        $this->arreglo[ 'usr_nombres' ]	= null;
        $this->arreglo[ 'usr_apellidos' ]	= null;
		$this->arreglo[ 'per_nombre' ] = null;

		$this->arreglo[ 'ult_login' ] = null;  
        $this->arreglo[ 'fecha_creacion' ] = null;
        
        $this->arreglo[ 'nombre_perfil' ] = null;
        $this->arreglo[ 'descripcion_perfil' ] = null;
        $this->arreglo[ 'modulo' ] = null;
        
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
