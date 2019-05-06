<?php
session_start();
include (dirname(__FILE__).DIRECTORY_SEPARATOR.'Auxiliares.php');


// segun el entorno
if( is_dir('/var/www/html/cveco-desarrollo.cencosud.corp/'))
{
    // desarrollo
    $_SESSION["CONFIG"] = new listaconfig('configcve.ini');
}
else if (trim($_SERVER['HTTP_HOST']) == 'cveco-testing.cencosud.corp')
{
    // testing
    $_SESSION["CONFIG"] = new listaconfig('configcve.ini');
}
else
{
    // produccion
    $_SESSION["CONFIG"] = new listaconfig('configcve.ini');

}
$_SESSION["DBACESS"] = null;
$_SESSION["DBACESS"] = new DBAccess2($_SESSION["CONFIG"]->getValue('DATABASE','DBSERVER'), $_SESSION["CONFIG"]->getValue('DATABASE','DBUSER'), $_SESSION["CONFIG"]->getValue('DATABASE','DBPASS'), $_SESSION["CONFIG"]->getValue('DATABASE','DBDATABASE'));

class listaconfig {
  
    /*** variables de clase ***/
    private $First = null;
    private $Last = null;
    private $Act = null;

    function __construct($filename) 
    {
        $this->iniFilename = $filename;
        //Buscamos el archivo ini en las rutas preestablecidas
        //Comentario
		$pathArray = explode( PATH_SEPARATOR, get_include_path());
                $pathArray[]='C:/wamp/www/Trunk/Colombia/CVE/CVE_PPAL/confphp/';
		$archivo_encontrado = false;
		foreach($pathArray as $include_dir){
			if (!$archivo_encontrado && file_exists($include_dir.$filename)){
				$archivo_encontrado = true;
				$archivo = $include_dir.$filename;
			}
		}
		if (!$archivo_encontrado){
			echo "ERROR: No se encuentra archivo de configuracion $filename";
			exit();
		}
        
        if($iniParsedArray = parse_ini_file( $archivo, true ) ) {
            if (is_array($iniParsedArray)){
                foreach( $iniParsedArray as $key => $value ) {//LLAVE
                    if (is_array($value)){
                    	foreach( $value as $name => $dato ) {//VALOR
                    		$Dto = new DtoElementIni;
                            $Dto->Key = $key;
                            $Dto->Name = $name;
			    if($name == 'DBUSER' || $name == 'DBPASS'){
                                $Dto->Value = decode($dato);
                            }else {
                                $Dto->Value = $dato; 
                            }
                            $this->AddElement($Dto);
                            //echo "[".$key."][".$name."][".$dato."]<br>";                            
                    	}
                    }
                                     	
                }
            }
        } else {
            return false;
        } 
    }
 
 
    private function IsNullElemt($valor){
        if(is_null($valor)){
            return true;    
        }else{
            return false;
        }
    }    
    
    public function AddElement($Dto){
        if ($this->IsNullElemt($this->First)){
            $this->First = $Dto;
            $this->Last = $Dto ;           
            $this->Act = $Dto  ;
        }else{
            $this->Act = $this->Last; 
            $this->Last = $Dto ;
            $Dto->Prev = $this->Act;
            $this->Act->Next = $Dto;
            $this->Act = $Dto;
        }
    } 
    
    public function getSection( $key ){
        
        $this->Act = $this->First;
        do{
        	if(!$this->IsNullElemt($this->Act)){
        		if($this->Act->Key == $key ){
                    $ArraySection[$this->Act->Name]=$this->Act->Value;
                }
        	}
            $this->Act = $this->Act->Next;   
        }while(!$this->IsNullElemt($this->Act));
            if ($ArraySection){
            	return $ArraySection;
            }else{
                return false;
            }
    }    

    public function getValue( $key ,$Name)
    {
        $this->Act = $this->First;
        do{
            if(!$this->IsNullElemt($this->Act)){
                if($this->Act->Key == $key && $this->Act->Name == $Name){
                    return $this->Act->Value;
                }
            }
            $this->Act = $this->Act->Next;   
        }while(!$this->IsNullElemt($this->Act));
        if($this->ArraySection){
            return $this->ArraySection;
        }else{
            return false;
        }
    }       
      
}

class DtoElementIni {
     private $Next = null;
     private $Prev = null;
     private $Key = null;
     private $Name = null;     
     private $Value = null;
     
    public function __get($var){
        return $this->$var;
    }

    public function __set($name, $value){
        $this->$name = $value;
        return true;
    }    
}

class DBAccess2 {
    /*** variables de clase ***/
    private $arrayValidTypes  = array("d"=>1 ,"f"=>2,"n"=>3,"s"=>4);
    private  $link  = null;
    private  $res   = null;  

    /*** constructor ***/
    function __construct($server='', $username='', $password='', $database=''){
        if($this->link = mysqli_connect($server, $username,$password,$database)){
            return true;
        }else{
            return false;
        } 
    }
    public function __destruct() 
    { 
        //mysqli_close($this->link); 
    }  
    
    /*** m�todos p�blicos ***/
    public function errno() 
    { 
        return mysqli_errno($this->link); 
    } 

    public function error() 
    { 
        return mysqli_error($this->link); 
    } 

    public static function escape_string($string) 
    { 
        return mysqli_real_escape_string($string); 
    } 
    
    private function validateDateTime(){
    	//
    }
    
    private function validateType($type,$value){
        if ($this->arrayValidTypes[$type] == 1){//date falata validar formato de fecha
            return true;    
        }else{
            if ($this->arrayValidTypes[$type] == 2){
                if(is_float($value)){
                    return true;
                }else{
                    return false;
                }   
            }else{
                if ($this->arrayValidTypes[$type] == 3){
                    if(is_numeric($value)){
                        return true;
                    }else{
                        return false;
                    }     
                }else{
                    if ($this->arrayValidTypes[$type] == 4){
                        if(is_string($value)){
                            return true;
                        }else{
                            return false;
                        }     
                    }else{
                        return false;                        
                    }                    
                }                
            }           
        }
    }

    public function query($query,$arrayValues="",$arrayTypes=""){
        $error = false;     
        if (!$arrayTypes && !$arrayValues){
            if ($this->res = mysqli_query($this->link,$query)){
                return $this->res;
            }
        }else{//validar query
            if (is_array($arrayTypes) && is_array($arrayValues))   {
                $i = 0;
                foreach( $arrayTypes as $key => $type ) {
                    if (!$this->validateType($type,$arrayValues[$i])){
                        $error = true;
                        break;
                    }else{
                        $pos = strpos($query, "?");
                        $query_tmp1 = substr($query, 0, ($pos+1));  
                        $query_tmp2 = substr($query, ($pos+1));
                        $query = str_replace("?", $arrayValues[$i], $query_tmp1).$query_tmp2;
                    }
                    $i++; 
                                        
                }
                if (!$error){
                    if ($this->res = mysqli_query($this->link,$query)){
                        return $this->res;
                    }else{
                        return false;
                    }                   
                }else{
                    return false;
                }
            }else{
                return false;
            }           
        }   
    }          
          
    public function querynoselect($query){
		return mysqli_query($this->link,$query);
    }          
          
    public function fetch_array($result, $array_type = MYSQL_BOTH) 
    { 
        return mysqli_fetch_array($result, $array_type); 
    } 

    public function fetch_row($result) 
    { 
        return mysqli_fetch_row($result); 
    } 
     
    public function fetch_assoc($result) 
    { 
        return mysqli_fetch_assoc($result); 
    } 
     
    public function fetch_object($result) 
    { 
        return mysqli_fetch_object($result); 
    } 
     
    public function close() 
    { 
        return mysqli_close($this->link); 
    }  
    
    public function affected_rows(){
        if (mysqli_affected_rows( $this->link )){
            return mysqli_affected_rows( $this->link );
        }else{
            return false;
        }
    }
    
    public function num_rows(){
        if (mysqli_num_rows( $this->res )){
            return mysqli_num_rows( $this->res );
        }else{
            return false;
        }
    }

    public function query_array($name_query){
    	
    }

    public function last_insert_id(){
    	//return $mysqli->insert_id;
    	return mysqli_insert_id($this->link);
    }

    public function isconnected(){
    	return $this->link;
    }

}

function ActualizarStockProductosOnline($productos_input, $centro_id, $almacen_id, $productos_input_unimed, &$error) {
	$bd = $_SESSION["DBACESS"];
	$query = "SELECT VAR_VALOR 
			  FROM glo_variables 
			  WHERE VAR_LLAVE = 'MSG_ERR_WS' 
			  LIMIT 1";
	$res = $bd->query($query);
	$row = $res->fetch_assoc();
	unset($bd);
	
	if ($row['VAR_VALOR'] == '0') {
		$error = '0';
	}
	
	if (count($productos_input) == 0 || empty($productos_input[0]))
		return true;
	
	if (count($productos_input) != count($productos_input_unimed))
		return false;
	
	if (trim($centro_id) == '' || trim($almacen_id) == '')
		return false;
	
	$conf = new getdbconfig("DATABASE_CPE");
	$bd = new DBAccess2($conf->DBSERVER, $conf->DBUSER, $conf->DBPASS, $conf->DBDATABASE);
	if (!$bd->isconnected())
		throw new DAOException(__CLASS__ , __FUNCTION__ , "No se ha podido conectar a Base de Datos [DBSERVER:".$conf->DBSERVER.", USER:".$conf->DBUSER.", PASS:********, DB:".$conf->DBDATABASE."]", 0, 1);
	
	$Webservice = new WebserviceOracleSAPOnline();
	
	$productosStock = $Webservice->ObtenerStockProducto($productos_input, $centro_id, $almacen_id, $productos_input_unimed);
	
	if ($productosStock['error'] != 'OK') {
		if ($row['VAR_VALOR'] == '1' && $productosStock['error'] != "") {
			$error = $productosStock['error'];
		}
		return false;
	}
	
	if ($productos_input[0] == '')
	{
		return true;
	}
	if ($productosStock[0]['producto_sap_id'] == '')
	{
		return false;
	}
	else
	{
		$productos = array();
		
		for( $j = 0; $j < count($productosStock)-1; $j++ )
		{
			// Busco el c�digo de barra para ese c�digo sap y UM
			$query_barcode = "SELECT DISTINCT cod_barra 
							  FROM `$conf->DBDATABASE`.`codbarra` 
							  WHERE cod_prod1 = '".$productosStock[$j]['producto_sap_id']."' ";

           			
			$res = $bd->query($query_barcode);
			$num_rows = $res->num_rows;
			 
			// Si no se encontr�
			if ($num_rows == 0)
				return false;
			
			// recorro todos los codbarra y guardo el nuevo stock para el producto
			while ($row = $res->fetch_assoc())
				$productos[$row['cod_barra']] = $productosStock[$j]['stock'];
			
			$res->free();
		}
		$error = '0';
		return $productos;
	}
}

function ConsultarClienteOnline($rut) {
	$bd = $_SESSION["DBACESS"];

	$Webservice = new WebserviceOracleSAPOnline();  
	$credito = $Webservice->ObtenerCreditoCliente($rut);
	
	$query = "SELECT VAR_VALOR 
				FROM glo_variables 
				WHERE VAR_LLAVE = 'MSG_ERR_WS' 
				LIMIT 1";
	$res = $bd->query($query);
	$row = $res->fetch_assoc();
	
	$mensaje = "No se pudo obtener el Credito en linea.";
	if ($credito['error'] != 'OK' && $row['VAR_VALOR'] == '1') {
		if ($credito['error'] != "") {
			$mensaje = $credito['error'];
		}
		echo "<script type='text/javascript'>alert('".$mensaje."');</script>";
		return false;
	}
	else if ($credito['fecha_vencimiento'] == '' && $row['VAR_VALOR'] == '1') {
		echo "<script type='text/javascript'>alert('".$mensaje."');</script>";
		return false;
	}
	
	//Actualizo el disponible con las cotizaciones generadas durante el dia
	$query = "SELECT SUM(monto) as monto 
			  FROM disponible 
			  WHERE rut = $rut 
			  AND feccrea >= DATE_FORMAT(NOW(),'%Y-%m-%d 00:00:00') 
			  AND id_tipomovimiento = 3 ";
	$res = $bd->query($query);
	
	if ($res) {
		$row = $res->fetch_assoc();
		$credito['limite_disponible'] = (floatval($credito['limite_disponible']) - floatval($row['monto'])); 
	}
	
	return $credito;
}

?>
