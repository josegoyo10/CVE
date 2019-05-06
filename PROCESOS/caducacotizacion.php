<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
include_once("/var/www/html/cve/INCLUDE/ini.php");
include_once("/var/www/html/cve/INCLUDE/autoload.php");
//include_once("../CVEPUBLIC/INCLUDE/aplication_top.php");
//
/////////////////////// ZONA DE ACCIONES /////////////////////////
 
//exec('whoami',$salida);
/*
if ($argc != 2) {
       
        echo "ERROR: uso no valido de caducacotizacion.php\n";
        exit();
}

if ($argv[1] == 'SYSTEM') {
	
	caduca();
}
else {
	echo "ERROR: usuario ".$argv[1]." incorrecto para caducacotizacion.php\n";
}
*/
$command = 'whoami';
$user = shell_exec($command);
//$user = 'LINUX'; 
general::writeevent("                                                                                                             ");
	general::writeevent("                                                                                                             "); 
	general::writeevent("*************************************************************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("*************************************************************************************************************");
	general::writeevent("                                                                                                             ");
	general::writeevent("                                                                                                             ");
general::writeevent('Incio de Proceso Caduca Cotizacion por Usuario '.$user.' a las  '.date( "h:i:s" , time() ));

oe1($user);
oe2($user);
oe3($user);
oe4($user);
caduca($user);

general::writeevent('termino de Proceso Caduca Cotizacion por Usuario '.$user.' a las  '.date( "h:i:s" , time() ));


function caduca($user){
	$cont = 0;
	$listadoCotizaciones = '';
	
	/***************** COTIZACION ESTADO CE *************************/
	
	if(!bizcve::getcotizacioncaduca($listaEnc = new connlist(new dtocotizacion(array('id_estado'=>'CE'))),$listaDet = new connlist())){
		general::writeevent('Error al obtener Coizaciones en estado CE');
		continue;
	}
		
		if ($listaEnc->numelem()){
			$listaEnc -> gofirst();
			do{
				    if (general::fecha_MYSQL2PHP($listaEnc->getelem()->validhasta) < general::fecha_MYSQL2PHP()){   
    			
    			if(!bizcve::caducacotizacion($listaCad = new connlist(new dtocotizacion(array('id_cotizacion'=>$listaEnc->getelem()->id_cotizacion,
    																						'estado'=>'CD',
    																						'usrmod'=>$user	
    																						 ))))){
    				general::writeevent('Error al Cambiar estado en Cotizacion N: '.$listaEnc->getelem()->id_cotizacion);
    				continue;
    			}
	        			$listadoCotizaciones .= $listaEnc->getelem()->id_cotizacion.', ';
                $cont++;
                        general::inserta_tracking( $listaEnc->getelem()->id_cotizacion, null, null, null, "La cotizacion ha caducado");
	    			}
		}while ($listaEnc -> gonext());
	} 
	
	/***************** COTIZACION ESTADO CV *************************/

	if(!bizcve::getcotizacioncaduca($listaEnccv = new connlist(new dtocotizacion(array('id_estado'=>'CV'))),$listaDetcv = new connlist())){
		general::writeevent('Error al obtener Cotizaciones en estado CV');
		return;
	}
	
	if ($listaEnccv->numelem()){
		$listaEnccv->gofirst();
		do{
			if(!bizcve::getordenentcaduca($listaord = new connlist(new dtoencordenent(array('id_cotizacion'=>$listaEnccv->id_cotizacion))),null)){
				general::writeevent('Error al obtener Ordenes de entrega para estado cotizaciones en estado CV');
				return;
			}
			if (!$listaord->numelem()){// SI NO TIENE OE
				do{
				    if (general::fecha_MYSQL2PHP($listaEnccv->getelem()->nvevalidhasta) < general::fecha_MYSQL2PHP()){   
		    			if (!bizcve::caducacotizacion(new conlist(new dtocotizacion(array('estado'=>'CD','id_cotizacion'=>$listaEnccv->getelem()->id_cotizacion))))){
		    				general::writeevent('Error al Cambiar estado en Cotizacion N: '.$listaEnccv->getelem()->id_cotizacion);
		    				continue;
		    			}
		                $listadoCotizaciones .= $listaEnccv->getelem()->id_cotizacion.', ';
		                $cont++;
		                general::inserta_tracking( $listaEnccv->getelem()->id_cotizacion, null, null, null, "La cotizacion ha caducado");
					}
					
				}while ($listaEnccv->gonext());
			}else{// SI TIENE OE
			    if (general::fecha_MYSQL2PHP($listaEnccv->getelem()->nvevalidhasta) < general::fecha_MYSQL2PHP()){   
	    			
	    			if (!bizcve::caducacotizacion(new connlist(new dtocotizacion(array('estado'=>'CF','id_cotizacion'=>$listaEnccv->getelem()->id_cotizacion))))){
	    				general::writeevent('Error al Cambiar estado en Cotizacion N: '.$listaEnccv->getelem()->id_cotizacion);
	    				continue;
	    			}
	    			$listadoCotizaciones .= $listaEnccv->getelem()->id_cotizacion.', ';
	    			$cont++;
	                general::inserta_tracking( $listaEnccv->getelem()->id_cotizacion, null, null, null, "La cotizacion ha caducado");
				}else{
					$listaord->gofirst();
					$todasOf = true;
					do{
						if ($listaord->getelem()->id_estado != 'OF'){
							$todasOf = false;
						}
					}while($listaord->gonext());
					
					$listaDetcv->gofirst();
					$todoEntregado = true;
					do {
						if ($listaDetcv->getelem()->cantidad != $listaDetcv->getelem()->cantidade){
							$todoEntregado = false;
						}
					}while($listaDetcv->gonext());
					
					if ($todasOf && $todoEntregado){
						if (!bizcve::caducacotizacion(new connlist(new dtocotizacion(array('estado'=>'CF','id_cotizacion'=>$listaEnccv->getelem()->id_cotizacion))))){
	    					general::writeevent('Error al Cambiar estado en Cotizacion N: '.$listaEnccv->getelem()->id_cotizacion);
	    					continue;
		    			}
	    	            $listadoCotizaciones .= $listaEnccv->getelem()->id_cotizacion.', ';
			$cont++;
	    	            general::inserta_tracking( $listaEnccv->getelem()->id_cotizacion, null, null, null, "La cotizacion ha caducado");
					}
				}
		} 
		}while ($listaEnccv->gonext());
	}

	general::writeevent('Se caducaron las siguientes cotizaciones '.$listadoCotizaciones.' TOTAL '.$cont);

}
	
function oe1($user){
	$listaEncode = new connlist($ordenentrega = new dtoencordenent(array ('id_estado' => 'OG',
															    		  'id_tipoflujo'=> 1
															   			  )));
	if(!bizcve::getordenentcaduca($listaEncode,$listaDetode = new connlist())){
		general::writeevent('Error al obtener OE en flujo 1');
		return;
	}
	
	
	if ($listaEncode->numelem()){
	$listaEncode->gofirst();
	do{
			
		if(!bizcve::getdocumentocaduca($listagde = new connlist(new dtodocumento(array('numorigen'=>$listaEncode->getelem()->id_ordenent,'id_tipodocumento'=>2))),$listaDet = new connlist)){
			general::writeevent('Error al obtener GDE en flujo 1');
			return;
		}
			
		$listagde->gofirst();
		$faltan = false; 
		do{
				if($listagde->getelem()->indmsgsap){
				$faltan = true;
			}
		}while ($listagde->gonext());
		
		if (!$faltan) {
				if(!bizcve::cambioordenent($ListEnc = new connlist(new dtocambiosestado(array('id_ordenent'=>$listaEncode->getelem()->id_ordenent,'id_estado_destino'=>'OF','usrmod'=>$user))))){
					general::writeevent('Error al cambiar estado de OE id '.$listaEncode->getelem()->id_ordenent.' en flujo 1');
				return;	
			}
		}
			
	}while ($listaEncode->gonext());
		return true;
	}else{
		general::writeevent('No se encontraron  OE en flujo 3');
		return true;
	}	
	
	
}
	
	
function oe2($user){
	$listaEncode = new connlist($ordenentrega = new dtoencordenent(array ('id_estado' => 'OG',
															    		  'id_tipoflujo'=> 2
															   			  )));
	if(!bizcve::getordenentcaduca($listaEncode,$listaDetode = new connlist())){
		general::writeevent('Error al obtener OE en flujo 2');
		return;
	}
	
	if ($listaEncode->numelem()){
	$listaEncode->gofirst();
	do{
		if(!bizcve::getdocumentocaduca($listagde = new connlist(new dtodocumento(array('numorigen'=>$listaEncode->getelem()->id_ordenent,'id_tipodocumento'=>2))),$listaDet = new connlist)){
			general::writeevent('Error al obtener GDE en flujo 2');
			return;
		}
		$listagde->gofirst();
		$faltan = false; 
		do{
			if(!$listagde->getelem()->indmsgsap){
				$faltan = true;
			}
		}while ($listagde->gonext());
		
		if (!$faltan) {
				if(!bizcve::cambioordenent($ListEnc = new connlist(new dtocambiosestado(array('id_ordenent'=>$listaEncode->getelem()->id_ordenent,'id_estado_destino'=>'OF','usrmod'=>$user))))){
					general::writeevent('Error al cambiar estado de OE id '.$listaEncode->getelem()->id_ordenent.' en flujo 2');
				return;
			}	
		}
	}while ($listaEncode->gonext());
	}else{
		general::writeevent('No se encontraron  OE en flujo 3');
		return true;
	}
} 

function oe3($user){
	$listaEncode = new connlist($ordenentrega = new dtoencordenent(array ('id_estado' => 'OG',
															    		  'id_tipoflujo'=> 3
															   			  )));
	if(!bizcve::getordenentcaduca($listaEncode,$listaDetode = new connlist())){
		general::writeevent('Error al obtener OE en flujo 3');
		return;
	}
	
	
	if ($listaEncode->numelem()){
	$listaEncode->gofirst();
	do{
		if(!bizcve::getordenpickcaduca($listaop = new connlist(new dtoencordenpicking(array('id_ordenent'=>$listaEncode->getelem()->id_ordenent))),$listaDet = new connlist)){
			general::writeevent('Error al obtener OP en flujo 3');
			return;
		}
		$listaop->gofirst();
		$faltaop = false;
		do{
			if($listaop->getelem()->id_estado !='PF'){
				$faltaop = true;
			}
		}while ($listaop->gonext());
			
			if(!bizcve::getdocumentocaduca($listagde = new connlist(new dtodocumento(array('numorigen'=>$listaEncode->getelem()->id_ordenent,'id_tipodocumento'=>2))),$listaDet = new connlist)){
			general::writeevent('Error al obtener GDE en flujo 3');
			return;	
		}
		$listagde->gofirst();
		$faltagde = false; 
		do{
			if(!$listagde->getelem()->indmsgsap){
				$faltagde = true;
			}	
		}while($listagde->gonext());
		
			if (!($faltaop || $faltagde)){
			if (!bizcve::cambioordenent($ListEnc = new connlist(new dtocambiosestado(array('id_ordenent'=>$listaEncode->getelem()->id_ordenent,'id_estado_destino'=>'OF','usrmod'=>$user))))){
				general::writeevent('Error al cambiar estado de OE id '.$listaEncode->getelem()->id_ordenent.' en flujo 3');
				return;				
			}
		}
		
	}while ($listaEncode->gonext());
		return true;
	}else{
		general::writeevent('No se encontraron  OE en flujo 3');
		return true;
	}
}
function oe4($user){
	$listaEncode = new connlist($ordenentrega = new dtoencordenent(array ('id_estado' => 'OG',
															    		  'id_tipoflujo'=> 4
															   			  )));
	if(!bizcve::getordenent($listaEncode,$listaDetode = new connlist())){
		general::writeevent('Error al obtener OE en flujo 4');
		return;
	}
	$listaEncode->gofirst();
	do{
		if(!bizcve::getordenpickcaduca($listaop = new connlist(new dtoencordenpicking(array('id_ordenent'=>$listaEncode->getelem()->id_ordenent))),$listaDet = new connlist)){
			general::writeevent('Error al obtener OP en flujo 4');
			return;			
		}
		$listaop->gofirst();
		$faltaop = false;
		do{
			if($listaop->getelem()->id_estado !='PF'){
				$faltaop = true;
			}
		}while ($listaop->gonext());
		if(!bizcve::getdocumento($listagde = new connlist(new dtodocumento(array('numorigen'=>$listaEncode->getelem()->id_ordenent,'id_tipodocumento'=>1))),$listaDet = new connlist)){
			general::writeevent('Error al obtener FCT en flujo 4');
			return;			
		}
		$listagde->gofirst();
		$faltagde = false; 
		do{
			if(!$listagde->getelem()->indmsgsap){
				$faltagde = true;
			}	
		}while($listagde->gonext());
		
		if (!($faltaop || $faltagde)){
			if(!bizcve::cambioordenent($ListEnc = new connlist(new dtocambiosestado(array('id_ordenent'=>$listaEncode->getelem()->id_ordenent,'id_estado_destino'=>'OF','usrmod'=>$user))))){
				general::writeevent('Error al cambiar estado de OE id '.$listaEncode->getelem()->id_ordenent.' en flujo 4');
				return;	
			}
		}
		
	}while ($listaEncode->gonext());
}
?>
