<?
class ctrldocumento{

    public function getdocumento($ListEnc, $ListDet = null) {
    	try {

			$obj = new daodocumento;
    	   	$obj->getencdocumento($ListEnc);
    	   	if ($ListEnc->numelem()==1 && $ListDet!=null) {
				$ListEnc->gofirst();	
    	   		$ListDet->clearlist();
    	   		$Registro = new dtodetdocumento;
    	   		$Registro->id_documento	= $ListEnc->getelem()->id_documento;
				if($ListEnc->getelem()->observaciones == 'flete'){
					general::writelog('voy a grabar con det sap');
    	   			$ListDet->addlast($Registro);
    	   			$obj->getdetdocumentosap($ListDet);
				}else{
    	   			$ListDet->addlast($Registro);
    	   			$obj->getdetdocumento($ListDet);
				}
    	   	}
   	   	
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getdocumentogud($ListDet) {
    	try {

			$obj = new daodocumento;
    	   	return $obj->getdetdocumento($ListDet);
    	   	   	
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    
    
    public function getultimofolio($List) {
    	try {
    	   $obj = new daodocumento;
    	   return $obj->getultimofolio($List);
    	   $List->gofirst();
    	   $List->clearlist();
    	   $Registro = new dtodocumento;
    	   $Registro->cod_local = $List->getelem()->cod_local;
    	   $Registro->numfolio_fct = $List->getelem()->numfolio_fct;
       	   $Registro->numfolio_gde = $List->getelem()->numfolio_gde;
    	   $List->addlast($Registro);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function anuladoc($ListEnc, $ListDet = null) {
    	try {		
    	   	$obj = new daodocumento;
    	   	$obj->anuladoc($ListEnc);
    	   	return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function savefolio($List) {
    	try {
    	   $obj = new daodocumento;
    	   return $obj->savefolio($List);
    	   $List->gofirst();
    	   $List->clearlist();
    	   $Registro = new dtodocumento;
    	   $Registro->cod_local = $List->getelem()->cod_local;
    	   $Registro->numfolio_fct = $List->getelem()->numfolio_fct;
       	   $Registro->numfolio_gde = $List->getelem()->numfolio_gde;
    	   $List->addlast($Registro);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getdocumentoprint($ListEnc, $ListDet = null) {
    	try {
    		$obj = new daodocumento;
    	   	$obj->getencdocumento($ListEnc);
    	   	if ($ListEnc->numelem()==1 && $ListDet!=null) {
				$ListEnc->gofirst();	
				$ListDet->clearlist();
    	   		$Registro = new dtodetdocumento;
    	   		$Registro->id_documento	= $ListEnc->getelem()->id_documento;
    	   		$ListDet->addlast($Registro);
    	   		$obj->getdetdocumentoprn($ListDet);
    	   	}
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
     public function getdocumentosap($ListEnc, $ListDet = null) {
    	try {
    	   	$obj = new daodocumento;
    	   	$obj->getencdocumentosap($ListEnc);
    	   	
    	   	if ($ListEnc->numelem()==1 && $ListDet!=null) {
    	 		$ListEnc->gofirst();	
    	   		$ListDet->clearlist();
    	   		$Registro = new dtodetdocumento;
    	   		$Registro->id_documento	= $ListEnc->getelem()->id_documento;
    	   		$ListDet->addlast($Registro);
    	   		$obj->getdetdocumentosap($ListDet);
    	   	}
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
	public static function getfletesapdoc($List) {
		try {
            $obj = new daodocumento;
            return $obj->getfletesapdoc($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function marcaodeasap($List) {
		try {
            $obj = new daodocumento;
            return $obj->marcaodeasap($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    //VA EN TEMPLATE
    public function getdocumentoprn($ListEnc) {
    	try {
    		$this->getdocumentoprint($ListEnc, $ListDet = new connlist);
    		$ListEnc->gofirst();
    		$tipodoc=$ListEnc->getelem()->id_tipodocumento;
    		
			$MiTemplate = new template;
    		if ($ListEnc->getelem()->id_tipodocumento == 1){
				$MiTemplate->set_file("documento", TEMPLATE . "impresion/impresion_fct.tpl");
    		}
			elseif ($ListEnc->getelem()->id_tipodocumento == 2){
				$MiTemplate->set_file("documento", TEMPLATE . "impresion/impresion_gde.tpl");
			
			}
				else
				throw new DAOException('El tipo de documento no es válido', 2);
				
			//Obtención de la orden de entrega.
			
			$ListOE  = new connlist;
			$Listoedet = new connlist;
			
			$oe=new dtoencordenent;
			$oe->id_ordenent=$ListEnc->getelem()->numorigen;

			if ($ListEnc->getelem()->id_tipodocumento == 2){
				$foliodocumento=2;
    			$Listdoce=new connlist;
    			$Listdocd=new connlist;
    			
    			$oeref=new dtodocumento;
				$oeref->numorigen=$ListEnc->getelem()->numorigen;
				$oeref->id_tipodocumento=1;							
				$Listdoce->addlast($oeref);
				bizcve::getdocumento($Listdoce,$Listdocd=null);
				$Listdoce->gofirst();
				
				$MiTemplate->set_var("fct", $Listdoce->getelem()->numdocumento);
			}

			$ListOE->addlast($oe);
			bizcve::getordenent($ListOE,$Listoedet);
			$ListOE->gofirst();
			
			$coti=$ListOE->getelem()->id_cotizacion;
			$numdocpago = $ListOE->getelem()->numdocpago;
			
			//Obtención de la Cotización a partir del id obtenido en la OE.
			
			$Listcoti  = new connlist;
			$Listcotidet = new connlist;
			
			$cotizacion=new dtocotizacion;
			
			$cotizacion->id_cotizacion= $coti;
			$Listcoti->addlast($cotizacion);
			bizcve::getcotizacion($Listcoti, $Listcotidet);
			$Listcoti->gofirst();
			
			$tipoventa=$Listcoti->getelem()->nomtipoventa;
			
			$fecha = general::fecha_PHP2TPL(general::formato_fecha($ListEnc->getelem()->fechadocumento));
			$condicion= $ListEnc->getelem()->diascondicion;
			
    		//Llenamos los datos de encabezado
    		$MiTemplate->set_var("nombre_cliente", $ListEnc->getelem()->razonsoc);
    		$MiTemplate->set_var("giro", $ListEnc->getelem()->giro);    		
    		$MiTemplate->set_var("rut_cliente", $ListEnc->getelem()->rutcliente . "-" . general::digiver($ListEnc->getelem()->rutcliente));
    		$MiTemplate->set_var("fechaactual", general::formato_fecha($ListEnc->getelem()->fechadocumento));
    		$MiTemplate->set_var("direccion_cliente", $ListEnc->getelem()->direccion);
    		$MiTemplate->set_var("nombre_comuna", $ListEnc->getelem()->comuna);
    		$MiTemplate->set_var("Ctelefono_g", $ListEnc->getelem()->fonocontacto);
    		$MiTemplate->set_var("condicion", $ListEnc->getelem()->condicion); 
    		$MiTemplate->set_var("oe", $ListEnc->getelem()->numorigen); 
    		$MiTemplate->set_var("tipo_venta", $tipoventa);   		
    		$MiTemplate->set_var("gde", $ListEnc->getelem()->id_documento);
    		$MiTemplate->set_var("vencimiento", general::suma_fechas($fecha, $condicion));
			$fecmod = $ListEnc->getelem()->fecmod;
			$fec = substr($fecmod, 11, 8);
    		$MiTemplate->set_var("fecha_mod", $fec);  
    		$MiTemplate->set_var("cod_vendedor", $ListEnc->getelem()->codigovendedor);  
    		$MiTemplate->set_var("numdocpago", $numdocpago);
    		
    		if ($ListEnc->getelem()->id_tipodocumento == 1)
    			$MiTemplate->set_var("codlocalventa", $ListEnc->getelem()->codlocalventa);  	
			if ($ListEnc->getelem()->id_tipodocumento == 2)
    			$MiTemplate->set_var("codlocalventa", $ListEnc->getelem()->codlocalcsum);  	

    		$local=$ListEnc->getelem()->codlocalventa;
			if($tipodoc==1){
//	    		$Lista  = new connlist;
//				$mfolio= new dtodocumento;
//				$mfolio->cod_local=$local;

//				$Lista->addlast($mfolio);
//				if(bizcve::getultimofolio($Lista)){
//					$Lista->gofirst();
					$MiTemplate->set_var('numfolio', $ListEnc->getelem()->numfolio_fct);
					$fct=$ListEnc->getelem()->numfolio_fct;
//				}
			}
			elseif($tipodoc==2){
//				$Lista  = new connlist;
//				$mfolio= new dtodocumento;
//				$mfolio->cod_local=$local;

//				$Lista->addlast($mfolio);
//				if(bizcve::getultimofolio($Lista)){
//					$Lista->gofirst();
					$MiTemplate->set_var('numfolio', $ListEnc->getelem()->numfolio_gde);				
					$gde=$ListEnc->getelem()->numfolio_gde;
//				}
			}
    		
    	//Llenamos los datos del detalle
    		$sumaneto = 0; 
    		$linea = 0;
    		$ListDet->gofirst(); 
			$MiTemplate->set_block("documento", "Bloque_det_guias", "PBL_Guia");
			if ($ListDet->numelem()) {
				if($tipodoc == 2){
			//general::alert('voy a llenar el detalle');
					$counteritem = 0;
					do {
						/*Rutina para obtener Barra*/

							$Listmarca = new connlist;
							$codprod = $ListDet->getelem()->codprod;
							$barra = $ListDet->getelem()->barra;
							$unimed = $ListDet->getelem()->unimed;
							$obj = new daoproductocpe;
							$Listmarca->gofirst();	
				    	   	$Registro = new dtodetordenent;
				    	   	$Registro->codprod	= $codprod;
				    	   	$Registro->barra	= $barra;				    	   	
				    	   	$Registro->unimed	= $unimed;	
				    	   	$Listmarca->addlast($Registro);
							$obj->getEAN($Listmarca);

				    	   	$MiTemplate->set_var("barra", $Listmarca->getelem()->barra);
				    	   	$MiTemplate->set_var("unimed", $Listmarca->getelem()->unimed);
							
							/*Rutina para obtener marca*/
						if(($ListDet->getelem()->barra)&&($ListDet->getelem()->barra)!=0){
							$Listmarca = new connlist;
							$codprod = $ListDet->getelem()->codprod;
				    	   	$obj = new daoproductocpe;
								$Listmarca->gofirst();	
				    	   		$Registro = new dtodetordenent;
				    	   		$Registro->codprod	= $codprod;
				    	   		$Listmarca->addlast($Registro);
								$var = $obj->getmarca($Listmarca);
							if($var>1){
					    	   	$MiTemplate->set_var("marca", '*');
					    	   	$MiTemplate->set_var("barra", $ListDet->getelem()->barra);					    	   	
				    	   	}else{
				    	   		$MiTemplate->set_var("marca", '');
								$MiTemplate->set_var("barra", $ListDet->getelem()->barra);				    	   		
				    	   	}
				    	   	
						}else{
							$MiTemplate->set_var("marca", ' ');
							$MiTemplate->set_var("barra", ' ');
						}
						$counteritem++;
						$MiTemplate->set_var("item", $counteritem);
						$MiTemplate->set_var("unimed", $ListDet->getelem()->unimed);
						$MiTemplate->set_var("codigo", $ListDet->getelem()->codprod);
						//$MiTemplate->set_var("barra", $ListDet->getelem()->barra);
						$MiTemplate->set_var("cantidad", $ListDet->getelem()->cantidad);
	    				$MiTemplate->set_var("descripcion", $ListDet->getelem()->descripcion);
						//$MiTemplate->set_var("preciounitario", number_format(round($ListDet->getelem()->pventaneto)));
						$MiTemplate->set_var("preciounitario", number_format($ListDet->getelem()->pventaneto,2));						
						$MiTemplate->set_var("totallinea", number_format(round($ListDet->getelem()->cantidad * $ListDet->getelem()->pventaneto)));  
						$sumaneto += round($ListDet->getelem()->cantidad * $ListDet->getelem()->pventaneto);
						$MiTemplate->parse("PBL_Guia", "Bloque_det_guias", true); 
						++$linea;
					} while ($ListDet->gonext());
				}else{
					do {
						$counteritem++;
						$MiTemplate->set_var("item", $counteritem);
						$MiTemplate->set_var("unimed", $ListDet->getelem()->unimed);
						$MiTemplate->set_var("codigo", $ListDet->getelem()->codprod);
						$MiTemplate->set_var("cantidad", $ListDet->getelem()->cantidad);
	    				$MiTemplate->set_var("descripcion", $ListDet->getelem()->descripcion);
	   					$MiTemplate->set_var("barra", $ListDet->getelem()->barra); 
	   					$MiTemplate->set_var("marca", $ListDet->getelem()->numlinea);
						//$MiTemplate->set_var("preciounitario", number_format(round($ListDet->getelem()->pventaneto)));
	   					$MiTemplate->set_var("preciounitario", number_format($ListDet->getelem()->pventaneto,2));
						$MiTemplate->set_var("totallinea", number_format(round($ListDet->getelem()->cantidad * $ListDet->getelem()->pventaneto)));  
						$sumaneto += round($ListDet->getelem()->cantidad * $ListDet->getelem()->pventaneto);
						$MiTemplate->parse("PBL_Guia", "Bloque_det_guias", true); 
						++$linea;
					} while ($ListDet->gonext());
				}
			}
    		
    		$MiTemplate->set_var("totalneto", number_format($sumaneto));
    		$MiTemplate->set_var("iva", $ListEnc->getelem()->iva);
    		$MiTemplate->set_var("ivadoc", number_format(round($ListEnc->getelem()->iva * $sumaneto / 100)));
    		$total = round($ListEnc->getelem()->iva * $sumaneto /100) + $sumaneto;
    		$MiTemplate->set_var("totaldoc", number_format($total));
    		$MiTemplate->set_var("totaldoctexto", general::num2letras($total)); 
    		for ($i=1; $i<=CANT_LINEAS_GUIA-$linea;++$i)
    			$lineas .= "\n";
    		$MiTemplate->set_var("lineablanca", $lineas); 
    		
    		$MiTemplate->parse("DETALLEDOC", "documento", true);
    		
    		$ListEnc->getelem()->txtprn = $MiTemplate->subst("DETALLEDOC");
    	   	return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
 //VA EN EL PREVIEW  
    public function getdocumentoview($ListEnc) {
    	try {
    		$this->getdocumentoprint($ListEnc, $ListDet = new connlist);
    		$ListEnc->gofirst();
    		$MiTemplate = new template;
			$tipodocu=$ListEnc->getelem()->id_tipodocumento;
	
    		if ($ListEnc->getelem()->id_tipodocumento == 1){
				$MiTemplate->set_file("documento", TEMPLATE . "ordenent/impresion_fct.htm");
    		}
			elseif ($ListEnc->getelem()->id_tipodocumento == 2){
				$MiTemplate->set_file("documento", TEMPLATE . "ordenent/impresion_gde.htm");
				$MiTemplate->set_var("fct", $ListEnc->getelem()->numdocumento);
			}
				else
				throw new DAOException('El tipo de docmento no es valido', 2);
			//Obtención de la orden de entrega.
			
			$ListOE  = new connlist;
			$Listoedet = new connlist;
			
			$oe=new dtoencordenent;
			$oe->id_ordenent=$ListEnc->getelem()->numorigen;
			
    		if ($ListEnc->getelem()->id_tipodocumento == 2){
    			$archivo=2;
    			$Listdoce=new connlist;
    			$Listdocd=new connlist;
    			
    			$oeref=new dtodocumento;
				$oeref->numorigen=$ListEnc->getelem()->numorigen;
				$oeref->id_tipodocumento=1;			
				$Listdoce->addlast($oeref);
				bizcve::getdocumento($Listdoce,$Listdocd=null);
				$Listdoce->gofirst();
				
				$MiTemplate->set_var("fct", $Listdoce->getelem()->numdocumento);
			}
			
			$ListOE->addlast($oe);
			bizcve::getordenent($ListOE,$Listoedet);
			$ListOE->gofirst();
			
			$coti=$ListOE->getelem()->id_cotizacion;
			
			//Obtención de la Cotización a partir del id obtenido en la OE.
			
			$Listcoti  = new connlist;
			$Listcotidet = new connlist;
			
			$cotizacion=new dtocotizacion;
			
			$cotizacion->id_cotizacion= $coti;
			
			$Listcoti->addlast($cotizacion);
			bizcve::getcotizacion($Listcoti, $Listcotidet);
			$Listcoti->gofirst();
			
			$tipoventa=$Listcoti->getelem()->nomtipoventa;
			
			$fecha = general::fecha_PHP2TPL(general::formato_fecha($ListEnc->getelem()->fechadocumento));
			$condicion= $ListEnc->getelem()->diascondicion;

			
    		//Llenamos los datos de encabezado
			$MiTemplate->set_var('numfolio', $_REQUEST['numdocumento']);
			$MiTemplate->set_var("nombre_cliente", $ListEnc->getelem()->razonsoc);
    		$MiTemplate->set_var("giro", $ListEnc->getelem()->giro);    		
    		$MiTemplate->set_var("rut_cliente", $ListEnc->getelem()->rutcliente . "-" . general::digiver($ListEnc->getelem()->rutcliente));
    		$MiTemplate->set_var("fechaactual", general::formato_fecha($ListEnc->getelem()->fechadocumento));
    		
    		/*DIRECCION DE DESPACHO*/
    		if($ListEnc->getelem()->id_tipodocumento == 2){
    		    /*Despliegue direcciones despacho*/
				$List  = new connlist;
				//general::alert($_REQUEST['dir']);
				$dir= $_REQUEST['id_direccion'];
				$mRegistro->id_direccion=$dir;
				$List->addlast($mRegistro);
				
				bizcve::getdirdesp($List);  
				$List->gofirst();   
				$MiTemplate->set_var('direccion_cliente', $List->getelem()->direccion);
				$MiTemplate->set_var("nombre_comuna", $List->getelem()->nomcomuna);
			}else{
    			$MiTemplate->set_var("direccion_cliente", $ListEnc->getelem()->direccion);
    			$MiTemplate->set_var("nombre_comuna", $ListEnc->getelem()->comuna);				
			}
    		/**********************/	
    		$MiTemplate->set_var("Ctelefono_g", $ListEnc->getelem()->fonocontacto);
    		$MiTemplate->set_var("condicion", $ListEnc->getelem()->condicion);    		
    		$MiTemplate->set_var("oe", $ListEnc->getelem()->numorigen);
    		$MiTemplate->set_var("vencimiento", general::suma_fechas($fecha, $condicion));
    		$MiTemplate->set_var("tipo_venta", $tipoventa);	
			$fecmod = $ListEnc->getelem()->fecmod;
			$fec = substr($fecmod, 11, 8);
    		$MiTemplate->set_var("fecha_mod", $fec);   		
    		$MiTemplate->set_var("cod_vendedor", $ListEnc->getelem()->codigovendedor);  
    		if ($ListEnc->getelem()->id_tipodocumento == 1)
    			$MiTemplate->set_var("codlocalventa", $ListEnc->getelem()->codlocalventa);  	
			if ($ListEnc->getelem()->id_tipodocumento == 2)
    			$MiTemplate->set_var("codlocalventa", $ListEnc->getelem()->codlocalcsum);  	
    		
			$local=$ListEnc->getelem()->codlocalventa;
			/************/
    		//Llenamos los datos del detalle
    		$sumaneto = 0; 
    		$linea = 0;
    		$ListDet->gofirst(); 
			$MiTemplate->set_block("documento", "Bloque_det_guias", "PBL_Guia");
			if ($ListDet->numelem()) {
				if($archivo == 2){
					do {
						/*Rutina para obtener Barra*/
						$Listmarca = new connlist;
						$codprod = $ListDet->getelem()->codprod;
						$barra = $ListDet->getelem()->barra;
						$unimed = $ListDet->getelem()->unimed;
						$obj = new daoproductocpe;
						$Listmarca->gofirst();	
				    	$Registro = new dtodetordenent;
				    	$Registro->codprod	= $codprod;
				    	$Registro->barra	= $barra;				    	   	
				    	$Registro->unimed	= $unimed;	
				    	$Listmarca->addlast($Registro);
						$obj->getEAN($Listmarca);
			    	   	$MiTemplate->set_var("barra", $Listmarca->getelem()->barra);
			    	   	$MiTemplate->set_var("unimed", $Listmarca->getelem()->unimed);
						/*Rutina para obtener marca*/
						if(($ListDet->getelem()->barra)&&($ListDet->getelem()->barra)!=0){
							$Listmarca = new connlist;
							$codprod = $ListDet->getelem()->codprod;
				    	   	$obj = new daoproductocpe;
								$Listmarca->gofirst();	
				    	   		$Registro = new dtodetordenent;
				    	   		$Registro->codprod	= $codprod;
				    	   		$Listmarca->addlast($Registro);
								$var = $obj->getmarca($Listmarca);
							if($var>1){
					    	   	$MiTemplate->set_var("marca", '*');
					    	   	$MiTemplate->set_var("barra", $ListDet->getelem()->barra);					    	   	
				    	   	}else{
				    	   		$MiTemplate->set_var("marca", ' ');
								$MiTemplate->set_var("barra", $ListDet->getelem()->barra);	
								$barra=$ListDet->getelem()->barra;
								//general::alert($barra);
				    	   	}
				    	   	
						}else{
							$MiTemplate->set_var("marca", ' ');
							$MiTemplate->set_var("barra", ' ');
						}
						$MiTemplate->set_var("item", $ListDet->getelem()->numlinea);
						$MiTemplate->set_var("unimed", $ListDet->getelem()->unimed);
						$MiTemplate->set_var("codigo", $ListDet->getelem()->codprod);
						$MiTemplate->set_var("barra", $ListDet->getelem()->barra);
						$MiTemplate->set_var("cantidad", $ListDet->getelem()->cantidad);
	    				$MiTemplate->set_var("descripcion", $ListDet->getelem()->descripcion);
						//$MiTemplate->set_var("preciounitario",$ListDet->getelem()->pventaneto);
	    				$MiTemplate->set_var("preciounitariosd", round($ListDet->getelem()->pventaneto));						
	    				$MiTemplate->set_var("preciounitario", number_format($ListDet->getelem()->pventaneto,2));
						$MiTemplate->set_var("totallinea", round($ListDet->getelem()->cantidad * $ListDet->getelem()->pventaneto));  
						$sumaneto += round($ListDet->getelem()->cantidad * $ListDet->getelem()->pventaneto);
						$MiTemplate->parse("PBL_Guia", "Bloque_det_guias", true); 
						++$linea;
					} while ($ListDet->gonext());
				}else{
					do {
						$MiTemplate->set_var("item", $ListDet->getelem()->numlinea);
						$MiTemplate->set_var("unimed", $ListDet->getelem()->unimed);
						$MiTemplate->set_var("codigo", $ListDet->getelem()->codprod);
						$MiTemplate->set_var("cantidad", $ListDet->getelem()->cantidad);
	    				$MiTemplate->set_var("descripcion", $ListDet->getelem()->descripcion);
	   					//$MiTemplate->set_var("barra", $ListDet->getelem()->barra); 
	   					$MiTemplate->set_var("marca", $ListDet->getelem()->numlinea);
						//$MiTemplate->set_var("preciounitario", round($ListDet->getelem()->pventaneto));
	   					//number_format($precio,2)
						//$MiTemplate->set_var("preciounitario",$ListDet->getelem()->pventaneto);
	    				$MiTemplate->set_var("preciounitariosd", round($ListDet->getelem()->pventaneto));						
	   					$MiTemplate->set_var("preciounitario", number_format($ListDet->getelem()->pventaneto,2));
	   					$MiTemplate->set_var("totallinea", round($ListDet->getelem()->cantidad * $ListDet->getelem()->pventaneto));  
						$sumaneto += round($ListDet->getelem()->cantidad * $ListDet->getelem()->pventaneto);
						$MiTemplate->parse("PBL_Guia", "Bloque_det_guias", true); 
						++$linea;
					} while ($ListDet->gonext());
				}
			}
			
    		$MiTemplate->set_var("totalneto", number_format($sumaneto));
    		$MiTemplate->set_var("iva", $ListEnc->getelem()->iva);
    		$MiTemplate->set_var("ivadoc", number_format(round($ListEnc->getelem()->iva * $sumaneto / 100)));
    		$total = round($ListEnc->getelem()->iva * $sumaneto /100) + $sumaneto;
    		$MiTemplate->set_var("totaldoc", number_format($total));
    		$MiTemplate->set_var("totaldoctexto", general::num2letras($total)); 
    		for ($i=1; $i<=CANT_LINEAS_GUIA-$linea;++$i)
    			$lineas .= "</br>&nbsp;";
    		$MiTemplate->set_var("lineablanca", $lineas); 
    		
    		$MiTemplate->parse("DETALLEDOC", "documento", true);
    		
    		$ListEnc->getelem()->txtprn = $MiTemplate->subst("DETALLEDOC");
    	   	return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function putdocumento($ListEnc, $ListDet = null) {
    	try {
    		$ListEnc->gofirst();
    		$ivadoc = $ListEnc->getelem()->iva;
    	   	$obj = new daodocumento;
    	   	$obj->initrx();
    		if (!$obj->saveencdocumento($ListEnc)) {
    	   		$obj->rollback();
    			return false;
    		}
    		if ($ListDet && $ListDet->numelem()){
	    		if ($ListDet) {
		    		
		    		if (!$obj->deldetdocumento($ListEnc)) {
		    	   		$obj->rollback();
		    			return false;
		    		}
		    		
	    			if (!($suma = $obj->savedetdocumento($ListEnc, $ListDet))) {
		    	   		$obj->rollback();
		    			return false;
		    		}
		    		$ListEnc->gofirst();
		    		$ListEnc->getelem()->totalnum = $suma;
		    		$ListEnc->getelem()->totaliva = round($suma * $ivadoc/100);
		    		$ListEnc->getelem()->totalnumiva = round($suma * $ivadoc/100) + $suma;
		    		$ListEnc->getelem()->totaltexto = general::num2letras($ListEnc->getelem()->totalnumiva);
		    		if (!$obj->saveencdocumento($ListEnc)) {
		    	   		$obj->rollback();
		    			return false;
		    		}
	    		}
    		}
    	   	$obj->commit();
    		return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
	
    public function verificafoliofct($List) {
    	try {
    		$List->gofirst();
    	   	$obj = new daodocumento;
    	   	$obj->initrx();
    		if (!$obj->verificafoliofct($List)) {
      			return false;
    		}
		}
    	
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function verificafoliogde($List) {
    	try {
    		$List->gofirst();
    	   	$obj = new daodocumento;
    	   	$obj->initrx();
    		if (!$obj->verificafoliogde($List)) {
      			return false;
    		}
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getdocumentoasoc($List) {
    	try {
    		$List->gofirst();
    	   	$obj = new daodocumento;
    	   	$obj->initrx();
    		if (!$obj->getdocumentoasoc($List)) {
      			return false;
    		}
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
	

	 public function gethoras_doc($List) {
    	try {
    		$List->gofirst();
    	   	$obj = new daodocumento;
    	   	$obj->initrx();
    		if (!$obj->gethoras_doc($List)) {
      			return false;
    		}
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

	 public function getdocumentonulo($List) {
    	try {
    		$List->gofirst();
    	   	$obj = new daodocumento;
    	   	$obj->initrx();
    		if (!$obj->getdocumentonulo($List)) {
      			return false;
    		}
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
	
	public function putdocumentosap($ListEnc, $ListDet = null) {
    	try {
    		$ListEnc->gofirst();
    		$ivadoc = $ListEnc->getelem()->iva;
    	   	$obj = new daodocumento;
    	   	$obj->initrx();
    		if (!$obj->saveencdocumentosap($ListEnc)){
    	   		$obj->rollback();
    			return false;
    		}
    		if ($ListDet && $ListDet->numelem()){
	    		if ($ListDet) {
		    		
		    		if (!$obj->deldetdocumento($ListEnc)) {
		    	   		$obj->rollback();
		    			return false;
		    		}
		    		
	    			if (!($suma = $obj->savedetdocumento($ListEnc, $ListDet))) {
		    	   		$obj->rollback();
		    			return false;
		    		}
		    		$ListEnc->gofirst();
		    		$ListEnc->getelem()->totalnum = $suma;
		    		$ListEnc->getelem()->totaliva = round($suma * $ivadoc/100);
		    		$ListEnc->getelem()->totalnumiva = round($suma * $ivadoc/100) + $suma;
		    		$ListEnc->getelem()->totaltexto = general::num2letras($ListEnc->getelem()->totalnumiva);
		    		if (!$obj->saveencdocumentosap($ListEnc)) {
		    	   		$obj->rollback();
		    			return false;
		    		}
	    		}
    		}
    	   	$obj->commit();
    		return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function deldocumento($listdoc) {
    	try {
    	   $obj = new daodocumento;
    	   return $obj->deldocumento($listdoc);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function generadocumento($listoe, $listpcant, $listdocgen) {
    	try {
			//Recupera OE
			$listoedet = new connlist;
			$CtrlOe = new ctrlordenent;
			
			$listoe->gofirst();
			$tipodocgen = $listoe->getelem()->tipodocgen;
			$CtrlOe->getordenent($listoe, $listoedet);
			$listoe->gofirst();
    	    		

			//Que la OE tenga estado adecuado
			if ($listoe->getelem()->id_estado != 'OG'){ 
				return 'Orden de Entrega Pagada' ;
			}
			if ( $tipodocgen == 'FCT') {
				$tipodocumento_sigtipodoc = 'FCT';
				$tipodocumento_idtipodoc = '1';
				$documento_tipo = 'id_documentof';
			}
			elseif ($tipodocgen == 'GDE') {
				$tipodocumento_sigtipodoc = 'GDE';
				$tipodocumento_idtipodoc = '2';
				$documento_tipo = 'id_documentog';
			}
			else
				throw new CTRLException('No se ha indicado el tipo de documento a emitir', 2);			
			
			if ($listoe->getelem()->id_tipoflujo != 1 && $listoe->getelem()->id_tipoflujo != 2 && $listoe->getelem()->id_tipoflujo != 3)
				return true; //Sólo se generan para las facturaciones anticipadas

			//Recupero la OP, si existe, asociada a este documento
			$CtrlOp = new ctrlordenpick();
			$CtrlOp->getordenpick($listop = new connlist(new dtoencordenpicking(array('id_ordenent'=>$listoe->getelem()->id_ordenent))), null);
			if ($listop && $listop->numelem()) 
				$listop->gofirst();
				
			//Ingreso los elementos de $listpcant en un arreglo asociativo
			if ($listpcant) $listpcant->gofirst();
			$arreglocant = array();
			if ($listpcant && $listpcant->numelem()){
				do{
					$arreglocant[$listpcant->getelem()->id_linea] = true;
				} while($listpcant->gonext());
			}

			$arrdocenc = array(); //Arreglo para no repetir los elementos ya ingresados

			//Primero itero sobre los productos que YA tiene documento asignado y agrego a la $listdocgen esos documentos
			if ($listoedet) $listoedet->gofirst();
			do {
				if ($arreglocant[$listoedet->getelem()->id_linea]){
					//Elemento encontrado
					if ($listoedet->getelem()->$documento_tipo && !$arrdocenc[$listoedet->getelem()->$documento_tipo]){
						//Existe el documento en la línea. Lo agrego
						$listdocgen->addlast(new dtodocumento(array('id_documento'=>$listoedet->getelem()->$documento_tipo)));
						$arrdocenc[$listoedet->getelem()->$documento_tipo] = true;
					}
				}
			} while ($listoedet->gonext());
			
			$CtrlOe = new ctrlordenent;
			
			$counterline = 0; 
			$listdetdoc = new connlist;
			$sumatotal = 0;
			$ides_linea = '';
			$arrdocencn = array();
			$i=0;
			
			if($listoedet){
				$listoedet->gofirst();
				do{
						$counterline++;												
					    $barra=$listoedet->getelem()->barra;
						$listdetdoc->addlast($data = new dtodetdocumento(array(	'numlinea' => $counterline,
																		'descripcion' => $listoedet->getelem()->descripcion,
																		'codprod' => $listoedet->getelem()->codprod,
																		'pcosto' => $listoedet->getelem()->pcosto,
																		'barra' => $listoedet->getelem()->barra,
																		'pventaneto' => $listoedet->getelem()->pventaneto,
																		'cantidad' => $listoedet->getelem()->cantidade,
																		'totallinea' => $listoedet->getelem()->totallinea,
																		'unimed' => $listoedet->getelem()->unimed, 
																		'id_linearef' => $listoedet->getelem()->id_linea,
																		'codsubtipo'=>$listoedet->getelem()->codsubtipo,
																		'codtipo'=>$listoedet->getelem()->codtipo,
																		'iva'=>$listoedet->getelem()->iva							
						)));
					
				}while($listoedet->gonext());
			}
			
			//Segundo, Itero sobre las líneas que no tienen documento asignado
			$listoedet->gofirst();
			do {
				if ($arreglocant[$listoedet->getelem()->id_linea]){
						//Elemento encontrado
						if (!$listoedet->getelem()->$documento_tipo){
							//Existe la línea y no tiene doc asignado
							//Genero Header e invoco a putdocumento
							$listencdoc = new connlist(new dtodocumento(array(	'id_tipodocumento' => $tipodocumento_idtipodoc,
																				'sigtipodoc' => $tipodocumento_sigtipodoc,
																				'pagina' => $this->getpaginadoc($listoe, $tipodocumento_idtipodoc)+1,
																				'tipoorigen' => 'OE',
																				'codigovendedor' => $listoe->getelem()->codigovendedor,
																				'numorigen' => $listoe->getelem()->id_ordenent,
																				'numdocrefop' => $listop->getelem()->id_ordenpicking,
																				'rutcliente' => $listoe->getelem()->rutcliente,
																				'razonsoc' => $listoe->getelem()->razonsoc,
																				'id_giro' => $listoe->getelem()->id_giro,
																				'giro' => $listoe->getelem()->giro,
																				'direccion' => $listoe->getelem()->direccion,
																				'comuna' => $listoe->getelem()->comuna,
																				'iva' => $listoe->getelem()->iva,
																				'totaltexto' => general::num2letras($sumatotal+(round($sumatotal*$listoe->getelem()->iva/100))),
																				'totalnum' => $sumatotal,
																				'totaliva' => round($sumatotal*$listoe->getelem()->iva/100),
																				'totalnumiva' => $sumatotal+(round($sumatotal*$listoe->getelem()->iva/100)),
																				'condicion' => $listoe->getelem()->condicion,
																				'diascondicion' => $listoe->getelem()->diascondicion,
																				'fonocontacto' => $listoe->getelem()->fonocontacto,
																				'observaciones' => $listoe->getelem()->observaciones,
																				'codlocalventa' => $listoe->getelem()->codlocalventa,
																				'codlocalcsum' => $listoe->getelem()->codlocalcsum,
																				'mediopago' =>	$listoe->getelem()->id_tipodocpago,
																				'numdocumento' => $listoe->getelem()->numdocpago,
																		)));
						
							//general::writelog('meio pago1 '.$listoe->getelem()->id_tipodocpago);
							//Genero el documento
							$i++;
							general::writelog("numero que itero".$i);
							$this->putdocumento($listencdoc, $listdetdoc);
							//Si el documento es factura, genero el cargo de disponible asociado a la Factura solo si es crédito
							if ($tipodocumento_idtipodoc == 1 && $listoe->getelem()->id_tipopago == 1) {
								$listencdoc->gofirst();
								$CtrlOe->reservadisponible(new connlist(new dtoencordenent(array(	'rutcliente'=> $listencdoc->getelem()->rutcliente,
																								'monto'=> $listencdoc->getelem()->totalnumiva, 
																								'id_ordenent'=> $listencdoc->getelem()->numorigen, 
																								'id_documento'=> $listencdoc->getelem()->id_documento
																								))));
							}
							//Agrego el num retornado a la $listdocgen
							$listencdoc->gofirst();
							//Agrego el tracking
							general::inserta_tracking(null, $listoe->getelem()->id_ordenent, null, $listencdoc->getelem()->id_documento, 'Se ha creado un nuevo documento');
							$listdocgen->addlast(new dtodocumento(array('id_documento'=>$listencdoc->getelem()->id_documento)));
							$numdocref = $listencdoc->getelem()->id_documento; 
							//Actualizo líneas de detalle de OE con núm doc generado
							$this->ActualizaNumDocOe($listencdoc, $ides_linea, $documento_tipo);
							
							//Si el doc es factura y el tipo de flujo es 1 o 2 genero inmediatamente las GDE
							if ($tipodocumento_idtipodoc == 1 && ($listoe->getelem()->id_tipoflujo == 1 || $listoe->getelem()->id_tipoflujo == 2 || $listoe->getelem()->id_tipoflujo == 3 )) {
								$listencdoc->gofirst();
								$listencdoc->getelem()->id_documento = null;
								$listencdoc->getelem()->id_tipodocumento = 2;
								$listencdoc->getelem()->sigtipodoc = 'GDE';
								$listencdoc->getelem()->numdocref = $numdocref;
								general::writelog("segunda salvada del documento");
								$this->putdocumento($listencdoc, $listdetdoc);
								$this->ActualizaNumDocOe($listencdoc, $ides_linea, 'id_documentog');
							}
							
							 
							$listdetdoc = new connlist;
							$sumatotal = 0;
							$ides_linea = '';
							//Vacío el arreglo con los números de línea
							$arrdocencn = array();
						
						
						
							$arrdocencn[$listoedet->getelem()->id_linea] = true;
							$sumatotal += $listoedet->getelem()->totallinea;
							$ides_linea .= ',' . $listoedet->getelem()->id_linea; 
						}
					}
				
			} while ($listoe->gonext());
			/*if ($counterline){
				//Genero Header e invoco a putdocumento
				$listencdoc = new connlist(new dtodocumento(array(	'id_tipodocumento' => $tipodocumento_idtipodoc,
																	'sigtipodoc' => $tipodocumento_sigtipodoc,
																	'pagina' => $this->getpaginadoc($listoe, $tipodocumento_idtipodoc)+1,
																	'tipoorigen' => 'OE',
																	'codigovendedor' => $listoe->getelem()->codigovendedor,
																	'numorigen' => $listoe->getelem()->id_ordenent,
																	'numdocrefop' => $listop->getelem()->id_ordenpicking,
																	'rutcliente' => $listoe->getelem()->rutcliente,
																	'razonsoc' => $listoe->getelem()->razonsoc,
																	'id_giro' => $listoe->getelem()->id_giro,
																	'giro' => $listoe->getelem()->giro,
																	'direccion' => $listoe->getelem()->direccion,
																	'comuna' => $listoe->getelem()->comuna,
																	'iva' => $listoe->getelem()->iva,
																	'totaltexto' => general::num2letras($sumatotal+(round($sumatotal*$listoe->getelem()->iva/100))),
																	'totalnum' => $sumatotal,
																	'totaliva' => round($sumatotal*$listoe->getelem()->iva/100),
																	'totalnumiva' => $sumatotal+(round($sumatotal*$listoe->getelem()->iva/100)),
																	'condicion' => $listoe->getelem()->condicion,
																	'diascondicion' => $listoe->getelem()->diascondicion,
																	'fonocontacto' => $listoe->getelem()->fonocontacto,
																	'observaciones' => $listoe->getelem()->observaciones,
																	'codlocalventa' => $listoe->getelem()->codlocalventa,
																	'codlocalcsum' => $listoe->getelem()->codlocalcsum,
																	'mediopago' =>	$listoe->getelem()->id_tipodocpago
															)));
				//general::writelog('meio pago2 '.$listoe->getelem()->id_tipodocpago);
				//Genero el documento
				general::writelog("tercera salvada del documento");
				$this->putdocumento($listencdoc, $listdetdoc);
				//Si el documento es factura, genero el cargo de disponible asociado a la Factura solo si es crédito
				if ($tipodocumento_idtipodoc == 1 && $listoe->getelem()->id_tipopago == 1) {
					$listencdoc->gofirst();
					$CtrlOe->reservadisponible(new connlist(new dtoencordenent(array(	'rutcliente'=> $listencdoc->getelem()->rutcliente,
																					'monto'=> $listencdoc->getelem()->totalnumiva, 
																					'id_ordenent'=> $listencdoc->getelem()->numorigen, 
																					'id_documento'=> $listencdoc->getelem()->id_documento
																					))));
				}
				//Agrego el num retornado a la $listdocgen
				$listencdoc->gofirst();
				//Agrego el tracking
				general::inserta_tracking(null, $listoe->getelem()->id_ordenent, null, $listencdoc->getelem()->id_documento, 'Se ha creado un nuevo documento');
				$listdocgen->addlast(new dtodocumento(array('id_documento'=>$listencdoc->getelem()->id_documento)));
				$numdocref = $listencdoc->getelem()->id_documento; 
				//Actualizo líneas de detalle de OE con núm doc generado
				$this->ActualizaNumDocOe($listencdoc, $ides_linea, $documento_tipo);
				
				//Si el doc es factura y el tipo de flujo es 1 o 2 genero inmediatamente las GDE
				if ($tipodocumento_idtipodoc == 1 && ($listoe->getelem()->id_tipoflujo == 1 || $listoe->getelem()->id_tipoflujo == 2)) {
					$listencdoc->gofirst();
					$listencdoc->getelem()->id_documento = null;
					$listencdoc->getelem()->id_tipodocumento = 2;
					$listencdoc->getelem()->sigtipodoc = 'GDE';
					$listencdoc->getelem()->numdocref = $numdocref;
					general::writelog("cuarta salvada del documento");
					$this->putdocumento($listencdoc, $listdetdoc);
					$this->ActualizaNumDocOe($listencdoc, $ides_linea, 'id_documentog');
				}
			}*/
			
			//Elimino el cargo asociado a la OE para dejar sólo los asociados a la factura
			$CtrlOe->deshacerreservadisponible($listoe, true);
			
			return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getpaginadoc($listdocoe, $tipodocumento_idtipodoc) {
    	try {
    	   $obj = new daodocumento;
    	   return $obj->getpaginadoc($listdocoe, $tipodocumento_idtipodoc);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    private function ActualizaNumDocOe($listencdoc, $ides_linea, $documento_tipo){
    	try {
    	   $obj = new daocotizacion;
    	   return $obj->ActualizaNumDocOe($listencdoc, $ides_linea, $documento_tipo);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

	
    public function marcardocimpreso($ListDoc){
    	try {
    	   $obj = new daodocumento;
    	   return $obj->marcardocimpreso($ListDoc);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function marcatodosdocimpreso($ListDoc){
    	try {
    	   $obj = new daodocumento;
    	   return $obj->marcatodosdocimpreso($ListDoc);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    /*Marca numero de Reimpresiones Guia de Despacho*/
	public function marcareimpresion($sum, $docu){
    	try {
    	   $obj = new daodocumento;
    	   return $obj->marcareimpresion($sum, $docu);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    /*Fin Marca numero de Reimpresiones Guia de Despacho*/
    
    public function desbloqueadocprint($ListDoc){
    	try {
    	   $obj = new daodocumento;
    	   return $obj->desbloqueadocprint($ListDoc);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function incrementafct($List) {
    	try {
    	   $obj = new daodocumento;
    	   return $obj->incrementafct($List);
    	   $List->gofirst();
    	   $List->clearlist();
    	   $Registro = new dtodocumento;
    	   $Registro->cod_local = $List->getelem()->cod_local;
    	   $List->addlast($Registro);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function incrementagde($List) {
    	try {
    	   $obj = new daodocumento;
    	   return $obj->incrementagde($List);
    	   $List->gofirst();
    	   $List->clearlist();
    	   $Registro = new dtodocumento;
    	   $Registro->cod_local = $List->getelem()->cod_local;
    	   $List->addlast($Registro);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function getdocumentonulosap($ListDoc){
    	try {
    	   $obj = new daodocumento;
    	   return $obj->getdocumentonulosap($ListDoc);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public static function cambioindicadorsapnull($list) {
		try {
            $obj = new daodocumento;
            return $obj->cambioindicadorsapnull($list);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
}
?>
