<?
class ctrlcotizacion{

    public function getcotizacion($ListEnc, $ListDet = null) {
       	try {
       		$ListEnc->gofirst();
       		$reqdet = $ListEnc->getelem()->reqdet;      		
       		/* valor con que se llama =1*/
       		$recflpro0=$ListEnc->getelem()->prorrateoflete;
       		$obj = new daocotizacion;
    	   	$obj->getenccotizacion($ListEnc);
			$ListEnc->gofirst();
			if (($reqdet) && $ListEnc->getelem()->id_estado!='CT')
			if($ListEnc->getelem()->id_estado!='CB')
				if (($ListEnc->getelem()->id_estado!='CV')) // SE ADICIONA EL CONTROL PARA QUE PUEDA MODIFICAR UNA COTIZACION EN ESTADO CV - COTIZACION. LOCALIZACION COLOMBIA 25 JUNIO
					throw new CTRLException('No se puede modificar esta cotizacion colombia', 2);
    	   	if ($ListEnc->numelem()==1 && $ListDet!=null) {
    	   		$ListDet->clearlist();
    	   		$Registro = new dtodetcotizacion;
    	   		$Registro->id_cotizacion= $ListEnc->getelem()->id_cotizacion;
    	   		$Registro->reqdet= $reqdet;
    	   		$Registro->codlocalcsum= $ListEnc->getelem()->codlocalcsum;
    	   		$ListDet->addlast($Registro);
    	   		$obj->getdetcotizacion($ListDet);
    	   	}
    	   	return true;
       	}   
    	
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getcotizacionsap($ListEnc, $ListDet = null) {
    		try {
    	   $obj = new daocotizacion;	
    	   return $obj->getcotizacionsap($ListEnc, $ListDet);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}
	
	public function getcotizacionestado($ListEnc) {
    		try {
    	   $obj = new daocotizacion;	
    	   return $obj->getcotizacionestado($ListEnc);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}
	
	public function getdetcotizacioncountpegenerico($ListEnc) {
    		try {
    	   $obj = new daocotizacion;	
    	   return $obj->getdetcotizacioncountpegenerico($ListEnc);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}

    public function getfletesap($ListEnc, $ListDet = null) {
    		try {
    	   $obj = new daocotizacion;	
    	   return $obj->getfletesap($ListEnc, $ListDet);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}
	
	public function cambioestadocotizacion($ListEnc) {
    		try {
    	   $obj = new daocotizacion;	
    	   return $obj->cambioestadocotizacion($ListEnc);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}
	
	public function getcountcotizacion($ListEnc) {
    		try {
    	   $obj = new daocotizacion;	
    	   return $obj->getcountcotizacion($ListEnc);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}
	
	public function getdetcotizacionsumimp($ListDet) {
    		try {
    	   $obj = new daocotizacion;	
    	   return $obj->getdetcotizacionsumimp($ListDet);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}
	
    public function getpventanetosap($ListEnc, $ListDet = null) {
    		try {
    	   $obj = new daocotizacion;	
    	   return $obj->getpventanetosap($ListEnc, $ListDet);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}
    
    public function getMonitorcotizacion($ListEnc, $ListDet = null) {
       	try {
       		$ListEnc->gofirst();
       		$reqdet = $ListEnc->getelem()->reqdet;
       		/* valor con que se llama =1*/
       		$obj = new daocotizacion;
    	   	$obj->getMonitorcotizacion($ListEnc);
			$ListEnc->gofirst();
			if ($reqdet && $ListEnc->getelem()->id_estado!='CT')
			if($ListEnc->getelem()->id_estado!='CB')
				throw new CTRLException('No se puede modificar esta cotizacion', 2);
    	   	if ($ListEnc->numelem()==1 && $ListDet!=null) {
    	   		$ListDet->clearlist();
    	   		$Registro = new dtodetcotizacion;
    	   		$Registro->id_cotizacion= $ListEnc->getelem()->id_cotizacion;
    	   		$Registro->reqdet= $reqdet;
    	   		$Registro->codlocalcsum= $ListEnc->getelem()->codlocalcsum;
    	   		$ListDet->addlast($Registro);
    	   		$obj->getdetcotizacion($ListDet);
    	   	}
    	   	return true;
       	}   
    	
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function putcotizacion($ListEnc, $ListDet) {
    	//general::writelog('putcotizacion ');    	
    	global $ses_usr_codlocal;
    	try {
    		$ListEnc->gofirst();
		    $this->getcotizacion($ListEncOrig = new connlist(clone($ListEnc->getelem())), $ListDetOrig = new connlist);
    		$id_co = $ListEnc->getelem()->id_cotizacion;
    		//$prorrateoflete=$ListEnc->getelem()->prorrateoflete;
    		//Validamos el vendedor solo si es una cotización nueva
    		if (!$ListEnc->getelem()->id_cotizacion) {
	    		$ListVend = new connlist;
				$RegVend= new dtousuario;
				$RegVend->id_tipousuario = '2,3'; /*Tipo Usuario Vendedor*/
				$RegVend->codigovendedor = $ListEnc->getelem()->codigovendedor; /*Usuario Vendedor*/
				$ListVend->addlast($RegVend);
				$ctrlus = new ctrlusuario;
				$ctrlus->GetUsers($ListVend);
	    		//Validamos que el código de vendedor sea válido
				if (!$ListVend->numelem())
	    			throw new CTRLException('El codigo de vendedor ingresado no es valido', 2);
		
	    		//Validamos que el vendedor esté asignado a este local
	    		$ListVend->gofirst();
				if ($ListVend->getelem()->cod_local && $ListVend->getelem()->cod_local != $ses_usr_codlocal && $ListVend->getelem()->id_tipousuario == 3)
	    			throw new CTRLException('El vendedor ingresado NO esta asigando a este local', 2);
    		}				
    			
    		/*ASIGNO ESTADO EN FUNCION DEL MARGEN*/
    		if ($ListEnc->getelem()->valortotal > 0) {
	    		if ($ListEncOrig->getelem()->id_estado == 'CT' || $ListEncOrig->getelem()->id_estado == 'CB' || $ListEncOrig->getelem()->id_estado == 'CV') {
	    			//general::alert($ListEnc->getelem()->margentotal.' '.MARGEN_COTIZADOR);
					$bandera = true;
					if ($ListEnc->getelem()->margentotal < MARGEN_COTIZADOR and $ListEnc->getelem()->bloqueopormargen == 1 or ($ListEnc->getelem()->bloqueoporcarga == 1)) {
	    				//general::alert($ListEnc->getelem()->bloqueoporcarga);
						
							$ListEnc->getelem()->id_estado = 'CB';
							//$mensaje = "La cotizacion ha pasado a estado Bloqueada";
							//general::inserta_tracking($ListEnc->getelem()->id_cotizacion,null ,null , null, 'La cotizacion ha sido Bloqueda por margen');	    				
							$mensaje = "La cotizacion ha pasado a estado Bloqueada, por margen";
							$bandera = false;
					}	
					if ($ListEnc->getelem()->bloqueopormargen == 1){
						$ListEnc->getelem()->id_estado = 'CB';    				
						$mensaje = "La cotizacion ha pasado a estado Bloqueada, por margen";
					}else { 
						if ($bandera== true){
							$ListEnc->getelem()->id_estado = 'CE';
							//$mensaje = "La cotizacion ha pasado a estado Entregada";
						}
	    			}
	    		}
	    		else{
	    			throw new CTRLException('La cotizacion no puede ser modificada debido a que no tiene estado adecuado', 2);
	    		}
    		}
    		else {
   				$ListEnc->getelem()->id_estado = 'CT';
    		}
   		
    	   	$obj = new daocotizacion;
    	   	$obj->initrx();
    		if (!$obj->saveenccotizacion($ListEnc)) {
    	   		$obj->rollback();
    			return false;
    		}
    		if ($ListDet) {
	    		if (!$obj->deldetcotizacion($ListEnc)) {
	    	   		$obj->rollback();
	    			return false;
	    		}
	    		if (!($totaln = $obj->savedetcotizacion($ListEnc, $ListDet))) {
	    	   		$obj->rollback();
	    			return false;
	    		}
	    		//Actualizamos el total con el valor de la suma de los detalles
	    		if (!$obj->saveenccotizacion(new connlist(new dtocotizacion(array('id_cotizacion' => $id_co,
	    							'valortotal' => ($totaln+0)
	    							//'prorrateoflete'=>$prorrateoflete
	    							))))) {
	    	   		$obj->rollback();
	    			return false;
	    		}
	    		
    		}
    	   	$obj->commit();
    	   	if ($mensaje) {
    	   		$ListEnc->gofirst();
    	   		general::inserta_tracking($ListEnc->getelem()->id_cotizacion, null, null, null, $mensaje);
    	   	}
    		return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function dupcotizacion($ListEnc) {
    	try {
    	   $obj = new daocotizacion;
    	   return $obj->dupcotizacion($ListEnc);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function dupcotizacioncaducada($ListEnc) {
    	try {
    	   $obj = new daocotizacion;
    	   return $obj->dupcotizacioncaducada($ListEnc);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function gencotizacionremnve($ListEnc) {
    	try {
    	   $obj = new daocotizacion;
    	   return $obj->gencotizacionremnve($ListEnc);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function gennve($List) {
    	global $ses_usr_codlocal;
    	try {
    		$List->gofirst();
    		$direccioncoti=$List->getelem()->id_cotizacion;
    		//Recupero datos de la cotizaciÃ³n original
    		$this->getcotizacion($Listorig = new connlist(new dtocotizacion(array('id_cotizacion'=>$List->getelem()->id_cotizacion))), $LIstDetOrig = new connlist);
    		$Listorig->gofirst();
            	
    		//Valido que la CO tenga estado CE
    		//if ($Listorig->getelem()->id_estado!='CE')
    		//if ($Listorig->getelem()->id_estado!='CB')
            //	throw new CTRLException("La cotizacion no puede generar NVE debido a que su estado actual no lo permite", 2);
    		//Recupero datos del cliente
    		$Ctrlcliente = new ctrlinfocliente;
    		$Ctrlcliente->getCliente($Listcte = new connlist(new dtoinfocliente(array('rut'=>$Listorig->getelem()->rutcliente))));
            $Listcte->gofirst();

            //Valido que el centro de suministro sea equivalente al local actual
            //if ( $Listorig->getelem()->codlocalcsum != $ses_usr_codlocal) 
            //	throw new CTRLException("La cotizaciÃ³n no puede generar NVE debido a que pertenece a un centro de suministro distinto. Primero debe editar la CotizaciÃ³n para actualizar los precios al centro de suministro actual", 2);
            
    		//Valido que cliente tenga todos sus datos
    		if (!$Listcte->getelem()->razonsoc || !$Listcte->getelem()->direccion)// || !$Listcte->getelem()->nomcomuna || !$Listcte->getelem()->fonocontacto)
            	throw new CTRLException("La cotizacion no puede generar NVE debido a que el cliente no tiene todos sus datos", 2);
            	
    		//Valido que Cliente no estÃ© bloqueado
    		//if ($Listcte->getelem()->locksap || $Listcte->getelem()->lockmoro || $Listcte->getelem()->lockcve || $Listcte->getelem()->lockfecha)
            //	throw new CTRLException("La cotizacion no puede generar NVE debido a que el cliente se encuentra bloqueado", 2);

			//Recupero disponible del cliente
    		$Ctrlcliente = new ctrlinfocliente;
    		$disponible = $Ctrlcliente->getdisponible($Listcte);
            //Valido que Cliente no tenga saldo < a cero
    		//if ($disponible < 0)
            //	throw new CTRLException("La cotizacion no puede generar NVE debido a que ya existe una cotizacion previa en estado Bloqueada", 2);
    		
            //Asigno los datos del cliente
            
            
            

$ListEnc = new connlist;
$Registro = new dtocotizacion;
$Registro->id_cotizacion	=  $direccioncoti;
$Registro->prorrateoflete =1;   
$ListEnc->addlast($Registro);
bizcve::getcotizacion($ListEnc, $ListDet);
$ListEnc->gofirst();
if (!$ListEnc->isvoid()) {
	$direccioncotizacion=$ListEnc->getelem()->direccion;
	$comunacotizacion=$ListEnc->getelem()->comuna;
	$fonocontactocotizacion=$ListEnc->getelem()->fonocontacto;
}
           
           
            $List->getelem()->razonsoc = $Listcte->getelem()->razonsoc;
            $List->getelem()->id_giro = $Listcte->getelem()->id_giro;
            $List->getelem()->giro = $Listcte->getelem()->giro;
   			$List->getelem()->direccion = $direccioncotizacion;
   			//$List->getelem()->direccion = $direccioncoti;
   			//echo "codigo cotizacion",$direccioncoti;
            $List->getelem()->comuna = $comunacotizacion;
            $List->getelem()->fonocontacto = $fonocontactocotizacion;
            //Prorrateo el flete si es que no se ha hecho
	         /*EMPIEZA PRORRATEO
	          *    $SumaFlete = 0;
	            $SumaResto = 0; 
	            $LIstDetOrig->gofirst();
	            //Obtengo el valor del flete
	            do {
	            	if ($LIstDetOrig->getelem()->codtipo=='SV' && $LIstDetOrig->getelem()->codsubtipo=='DE') {
            			$SumaFlete += round($LIstDetOrig->getelem()->pventaneto * $LIstDetOrig->getelem()->cantidad);
	            	}
	            	else {
	            		if ($LIstDetOrig->getelem()->codtipo=='PS' && $LIstDetOrig->getelem()->id_tipoentrega==2)
	            			$SumaResto += round($LIstDetOrig->getelem()->pventaneto * $LIstDetOrig->getelem()->cantidad);
	            	}
	            } while($LIstDetOrig->gonext());
	            
	            if ($SumaFlete) {
		            //Busco los productos de despacho y modifico el precio de venta
		            $sumaconprorrateo = 0;
		            $LIstDetOrig->gofirst();
		            $puntero_producto = null;
		            do {
		            	if ($LIstDetOrig->getelem()->codtipo=='SV' && $LIstDetOrig->getelem()->codsubtipo=='DE') {
	            			$LIstDetOrig->getelem()->valorfleteh = $LIstDetOrig->getelem()->pventaneto;
		            		$LIstDetOrig->getelem()->pventaneto = 0;
		            		$LIstDetOrig->getelem()->totallinea = 0;
		            		$LIstDetOrig->getelem()->margenlinea = 0;
		            	}
		            	if ($LIstDetOrig->getelem()->codtipo=='PS' && $LIstDetOrig->getelem()->id_tipoentrega==2){
		            		$puntero_producto = $LIstDetOrig->getelem();
		            		$LIstDetOrig->getelem()->cargoflete = round($LIstDetOrig->getelem()->pventaneto*(1+$SumaFlete/$SumaResto)) - $LIstDetOrig->getelem()->pventaneto;
		            		$LIstDetOrig->getelem()->totallinea = round(($LIstDetOrig->getelem()->cargoflete+$LIstDetOrig->getelem()->pventaneto)*$LIstDetOrig->getelem()->cantidad);
		            	}
		            	$sumaconprorrateo += $LIstDetOrig->getelem()->totallinea;
		            } while($LIstDetOrig->gonext());
	
		            //MOD. RGM 07-11-2006. ESTO PROVOCA UN ERROR DE CALCULO, SE OMITE
		            //Cargo los pesos de diferencia al primer producto
//	           		$puntero_producto->cargoflete += ($SumaFlete + $SumaResto) - $sumaconprorrateo;
//	           		$puntero_producto->totallinea = round(($puntero_producto->cargoflete+$puntero_producto->pventaneto)*$puntero_producto->cantidad);
	
	           		//Elimino el producto flete de la cotizaciÃ³n
	           		$nuevototal = 0; 
		            $LIstDetOrig->gofirst();
		            do {
		            	if ($LIstDetOrig->getelem()->codtipo=='SV' && $LIstDetOrig->getelem()->codsubtipo=='DE') {
	            			$LIstDetOrig->setelem(null);
		            	}
		            	else {
		            		$nuevototal += $LIstDetOrig->getelem()->totallinea;
		            	}
		            } while($LIstDetOrig->gonext());
	
		            //Actualizo el valor de la cotizaciÃ³n
		            $Listorig->getelem()->valortotal = $nuevototal;
	            }

//colombia disab
TERMINA PRORRATEO*/		            
    	   	$obj = new daocotizacion;
    	   	//Grabo el nuevo encabezado
    	   	$obj->saveenccotizacion($Listorig);
            if ($SumaFlete) {
	    	   	//Borro el detalle antiguo
	    	   	$obj->deldetcotizacion($Listorig);
	    	   	//Grabo el nuevo detalle
	    		$obj->savedetcotizacion($Listorig, $LIstDetOrig);
            }
    		//Genero la NVE
    		return $obj->gennve($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function delcotizacionall($List) {
		try {
			$ListEnc = new connlist;
			$obj = new daocotizacion;
			/*si existe la cotizaciÃ³n id_cotizacion */
			$obj->getenccotizacion($List);   	   	
			/*si trae*/
			$numero = $List->numelem();
			if ( $List->numelem()==1) {
				$List->gofirst();
				$Registro = new dtocotizacion;
				$Registro->id_cotizacion= $List->getelem()->id_cotizacion;
				$Registro->id_estado= $List->getelem()->id_estado;    	   		
				$Registro->rutcliente= $List->getelem()->rutcliente;    	   		
				$ListEnc->addlast($Registro);
				// JUNIO25 CAMBIO DE ESTADO PARA PERMITIR ELIMINAR COTIZACIONES EN ESTADO COTIZACION ANTERIORMENTE NOTA DE VENTA
				if($List->getelem()->id_estado=='CT' || $List->getelem()->id_estado=='CV'){				
					$obj->delenccotizacion($ListEnc);
					return true;
				}else{
                    throw new CTRLException("No se puede Eliminar la CO debido a que no esta en Trabajo", 2);
				}
			}
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}

   /*Eliminar Flete de la Cotizacion*/
	public function delcotizacionf($idcotizacion) {
		try {
			
			$obj = new daocotizacion;
			return $obj->deldetcotizacionf($idcotizacion);
	
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}
	
	/*Fin Eliminar Flete de la Cotizacion*/

	public function cuontcotizacionf($List) {
		try {
			
			$obj = new daocotizacion;
			return $obj->cuontcotizacionf($List);
	
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}
	
	public function ActualizaCantNVEOE($listoedet, $operacion){
		try {
    	   $obj = new daocotizacion;	
    	   return $obj->ActualizaCantNVEOE($listoedet, $operacion);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}

    public static function caducacotizacion($List) {
		try {
			//Validamos el estado 
			$List->gofirst();
			if ($List->getelem()->id_estado != 'CE' && $List->getelem()->id_estado == 'CB')
                throw new CTRLException("No se puede Caducar la CO debido a que no tiene estado adecuado", 2);
						
			$obj = new daocotizacion;	
    	   	return $obj->caducacotizacion($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
}
?>