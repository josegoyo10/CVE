<?php
session_start();
include (dirname(__FILE__).DIRECTORY_SEPARATOR.'Auxiliares.php');
// segun el entorno
if( is_dir('/var/www/html/cveco-testing.cencosud.corp/') || is_dir('/var/www/html/cveco-desarrollo.cencosud.corp/'))
{
    // testing / desarrollo
    $_SESSION["CONFIG"] = new listaconfig('configcve.ini');
}
else
{
    // produccion
    $_SESSION["CONFIG"] = new listaconfig('configcve.ini');
}
$_SESSION["DBACESS"] = null;

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
			    if($name == DBUSER || $name == DBPASS){
                                $Dto->Value = decode($dato);
                            }  else {
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
?>