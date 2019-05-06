<?php
class bbrq {
	public function leedirectorio($directorio,$pre,$largopref,$largonomb,$ext){
		
		if(!$directorioinicio = opendir($directorio)){
			throw new Exception('Fallo inesperado al intentar abrir el directorio: '. $directorio);
			return;
		}
		$cont=0;
		while (false !== ($archivo = readdir($directorioinicio))){
		
			if (substr($archivo, 0, $largopref) == $pre){
					
				if (strtoupper (substr($archivo,$largonomb, 4)) == $ext){
									
					if(!$directoriobusqueda = opendir($directorio)){
						throw new Exception('Fallo inesperado al intentar abrir el directorio: '. $directoriobusqueda);
						return;
					}
					
					while (false !== ($archivobusqueda = readdir($directoriobusqueda))){
						
						if (substr($archivobusqueda, 0, $largopref) == $pre){
							general::alert(substr($archivo, 0, $largonomb-1)."       ".$archivobusqueda );
							if (substr($archivo, 0, $largonomb-1) == $archivobusqueda){
								
								$ordenados[$cont]= $archivobusqueda;
								$cont++;
								break;
							}
						}
					}
				}	
			}
		}
		
		if ($cont != 0){
			if(!natcasesort($ordenados)){
			throw new Exception('Fallo inesperado al intentar abrir el directorio: '. $directorio);
			return;
			}else{
				return $ordenados;
			}
		}else{
			return;
		}
	}
	
	
	public function BuscaArchivos($directorio,$Ext,$largoExt,$largonomb){
		
		if(!$directorioinicio = opendir($directorio)){
			throw new Exception('Fallo inesperado al intentar abrir el directorio: '. $directorio);
			return;
		}
		$cont=0;
		//general::alert('ext '.$Ext);
		//general::alert('$largoExt '.$largoExt);
		$res = $largonomb-$largoExt;
		//general::writelog('lar '.$res);
		
		while (false !== ($archivo = readdir($directorioinicio))){
			//general::writelog('nombre '.substr($archivo,$largonomb, $largoExt));
			if (substr($archivo,$largonomb, $largoExt) == $Ext){
				$ordenados[$cont]= substr($archivo,0,$largonomb-1);
				$cont++;
				//general::writelog('nombre '.substr($archivo,0,$largonomb-1));
				
			}
				
				/*general::alert(substr($archivo, $largonomb, $largoExt));
				if (strtoupper (substr($archivo,$largonomb, 3)) == $ext){
									
					if(!$directoriobusqueda = opendir($directorio)){
						throw new Exception('Fallo inesperado al intentar abrir el directorio: '. $directoriobusqueda);
						return;
					}
					
					while (false !== ($archivobusqueda = readdir($directoriobusqueda))){
						
						if (substr($archivobusqueda, 0, $largopref) == $pre){
							//general::alert(substr($archivo, 0, $largonomb-1)."       ".$archivobusqueda );
							if (substr($archivo, 0, $largonomb-1) == $archivobusqueda){
								
								$ordenados[$cont]= $archivobusqueda;
								$cont++;
								break;
							}
						}
					}
				}	*/
			
		}
		
		if ($cont != 0){
			if(!natcasesort($ordenados)){
			throw new Exception('Fallo inesperado al intentar abrir el directorio: '. $directorio);
			return;
			}else{
				return $ordenados;
			}
		}else{
			return;
		}
	}
	
	public function buscaarchivosmalos($directorio,$ext){
		/*recupero informaci�n sobre la ruta del directorio*/   
    	$direcActual = pathinfo(getcwd());
    	
    	if ($direcActual['basename'] != $directorio){
    		if(!file_exists($directorio)){
	    		throw new Exception('El Directorio no existe EN LA RUTA ESPECIFICADA: '. $directorio);
	    		return;
	    	}else{
		    	if (!chdir($directorio)){
		    		throw new Exception('El Directorio no existe '. $directorio);
		    		return;	
		    	}
	    	}
	    }
		
		
		if(!$directorioinicio = opendir($directorio)){
			throw new Exception('Fallo inesperado al intentar abrir el directorio: '. $directorio);
			return;
		}
		$cont = 0;
		$archivosmalos = array();			
		while (false !== ($archivodeldirectorio = readdir($directorioinicio))){
			$trg = substr($archivodeldirectorio,-3);
			if ($trg != strtoupper($ext) && $trg != strtolower($ext)) {
				$archivodeldirectorio2 = $archivodeldirectorio.'.'.strtoupper($ext);
				$archivodeldirectorio3 = $archivodeldirectorio.'.'.strtolower($ext);
				if(!(file_exists($archivodeldirectorio2) && file_exists($archivodeldirectorio3))){
					if (!is_dir($archivodeldirectorio)){
						$archivosmalos[$cont]=$archivodeldirectorio;
						$cont++;
					}
				}
			
			}
		}
		if ($cont){
			return $archivosmalos;
		}else{
			return;
		}
			
	}
		
	
	
	
	
	
	
	public function leedirectorio2($directorio){
		$directorio = opendir($directorio);
		$cont=0;
		while ($archivo = readdir($directorio)){
			$ordenados[$cont]= $archivo;
			$cont++;
		}
		echo "<pre>";
		print_r($ordenados);
		/*Borro elementos no deseados*/
		unset($ordenados[0]);
		unset($ordenados[1]);
		
		/*Ordeno el directorio ascendentemente*/ 
		natcasesort($ordenados);
		
	
		return $ordenados;
	}
	
	public function OrdenaDirectorio($directorio){
		/*Cambio al directorio deseado*/
		//echo "<br>".getcwd();
		chdir($directorio);
		
		//echo "<br>".getcwd();
		/*Abro el directorio*/
		$dir=opendir(".");
		
		/*Recorro el directorio y obtengo la fecha de creaci�n de cada archivo*/
 		while($archivos=readdir($dir)){
  			$fecha[$archivos]= filemtime($archivos);
 		}
		
		/*Borro elementos no deseados*/
		unset($fecha['.']);
		unset($fecha['..']);
		
		/*Ordeno el directorio ascendentemente*/ 
		natcasesort($fecha);
		return 	$fecha;	
	}
    
 
    
/*****************************************************************************/ 
//Descripci�n : esta funci�n permite esribir un mensaje en un archivo de texto
//Parametros  : 
// 
/*****************************************************************************/    

    public function guardaArchivo($msg,$nom,$directorio,$gz){
 		/*recupero informaci�n sobre la ruta del directorio*/   
    	$direcActual = pathinfo(getcwd());
    	
    	if ($direcActual['basename'] != $directorio){
    		if(!file_exists($directorio)){
	    		general::writelog('este es el directorio '.$directorio);
    			throw new Exception('El Directorio no existe EN LA RUTA ESPECIFICADA: '. $directorio);
	    		return;
	    	}else{
		    	if (!chdir($directorio)){
		    		throw new Exception('El Directorio no existe '. $directorio);
		    		return;	
		    	}
	    	}
	    }
	   	
		
		if(!$fo=fopen($nom,'w')){
			throw new Exception('Problemas en la Apertura del Archivo: '. $directorio.$nom);
			return;
		}
		
		if(!fwrite($fo,$msg)){
			throw new Exception('Problemas en la Escritura del Archivo: '. $directorio.$nom);
			return;
		}
    	
    	if($gz){
    		$command = 'gzip -9 '.$nom;
			$cmd = shell_exec($command);
    	}
    	return true;
	}
   
    
    
   
    
    function Get($Nom,$directorio){
    	
    	if ($Nom == ""){
    		$ArchivosFifo = bbrq::OrdenaDirectorio($directorio);
	  		foreach($ArchivosFifo as $NomArchivo){	
				$Archivo=array_search($NomArchivo,$ArchivosFifo);
    	   		
    	   		if (file_exists($Archivo)){
      				$lineas=file($Archivo); 
    	   			$trozos = explode("|",$lineas[0]);	
    	   			$msg = new DtoMsg();
					$msg -> header = $trozos[0];
					$msg -> data   = $trozos[1];
					$msg -> id	   = $trozos[2];
					
					unlink($Archivo);
					return $msg;
    			}else{
    				return false;
    			}
	  		}
    	}else{
    		chr($directorio);
    		$Archivo= $Nom;
    		if (file_exists($Archivo)){
      			$lineas=file($Archivo); 
    	   		
    	   		$trozos = explode("|",$lineas[0]);	
    	   		$msg = new DtoMsg();
				$msg -> header = $trozos[0];
				$msg -> data   = $trozos[1];
				$msg -> id	   = $trozos[2];
				
				unlink($Archivo);
				return $msg;
    		}
    		
    	}	
    }   
}
?>
