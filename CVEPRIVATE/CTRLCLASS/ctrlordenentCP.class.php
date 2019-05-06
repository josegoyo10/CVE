<?
class ctrlordenent{

    public function getordenent($ListEnc, $ListDet = null) {
    	try {		
    	   	$obj = new daoordenent;
    	   	$obj->getencordenent($ListEnc);
    	   	if ($ListEnc->numelem()==1 && $ListDet!=null) {
				$ListEnc->gofirst();
    	   		$ListDet->clearlist();
    	   		$Registro = new dtodetordenent;
    	   		$Registro->id_ordenent	= $ListEnc->getelem()->id_ordenent;
    	   		$ListDet->addlast($Registro);
    	   		$obj->getdetordenent($ListDet);
    	   		if ($ListDet && $ListDet->numelem()) $ListDet->gofirst();
				$montobruto = 0;
    	   		do {
    	   			$montobruto += $ListDet->getelem()->totallinea;
    	   		} while ($ListDet->gonext());
    	   		$montoiva = $montobruto +  round($montobruto * $ListEnc->getelem()->iva/100);
    	   		$ListEnc->getelem()->monto = $montoiva;
    	   	}
    	   	return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	    
    public function getinfoop($List, $opcion){
    	try{
    		$obj = new daoordenent;
    		$obj->getinfoop($List, $opcion);
    		return true;
    	}
        catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function updatemensajeglo($List, $opcion ,$contenido){
    	try{
    		$obj = new daoordenent;
    		$obj->updatemensajeglo($List, $opcion ,$contenido);
    		return true;
    	}
        catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getimpuestos($List, $id_cotizacion){
   		try{
    		$obj = new daoordenent;
    		return $obj->getimpuestos($List, $id_cotizacion);
    		
   		}
       	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
   		catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
   		catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getMonitorordenent($ListEnc, $ListDet = null) {
    	try {		
    	   	$obj = new daoordenent;
    	   	$obj->getmonitorordenent($ListEnc);
    	   	return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function reportecompraspendientes($ListEnc, $ListDet = null) {
    	try {		
    	   	$obj = new daoordenent;
    	   	$obj->reportecompraspendientes($ListEnc);
    	   	return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function reportecompraspendientespe($ListEnc, $ListDet = null) {
    	try {		
    	   	$obj = new daoordenent;
    	   	$obj->reportecompraspendientespe($ListEnc);
    	   	return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getFlujo($ListEnc, $ListDet = null) {
    	try {		
    	   	$obj = new daoordenent;
    	   	$obj->getFlujo($ListEnc);
    	   	return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function getordenentsap($ListEnc, $ListDet = null) {
    	try {
    	   	$obj = new daoordenent;
    	   	$obj->getencordenentsap($ListEnc);
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
	public function getordenentsapflujo5($ListEnc, $ListDet = null) {
    	try {
    	   	$obj = new daoordenent;
    	   	$obj->getencordenentsapflujo5($ListEnc);
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    private function putordenent($ListEnc, $ListDet, $fecha_rc, $fecha_ei, $fecha_dp) {
    	try {
    		$ListEnc->gofirst();
			$RegVend= new dtousuario(array(	'id_tipousuario' => '2,3', /*Tipo Usuario Vendedor*/
											'codigovendedor' => $ListEnc->getelem()->codigovendedor
											));
			$ListVend = new connlist($RegVend);
			$ctrlus = new ctrlusuario;
			$ctrlus->GetUsers($ListVend);
			
    		if (!$ListVend->numelem())
    			throw new CTRLException('El codigo de vendedor ingresado no es valido', 2);
    		
    	   	$obj = new daoordenent;
    	   	$obj->initrx();
    	   	
    		if (!$obj->saveencordenent($ListEnc, $fecha_rc, $fecha_ei, $fecha_dp)) {
    	   		$obj->rollback();
    			return false;
    		}
    		if (!$obj->savedetordenent($ListEnc, $ListDet)) {
    	   		$obj->rollback();
    			return false;
    		}
    	   	$obj->commit();
    		return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    /*Insertar Cod EAN*/
	public static function putean($cod_barra_os, $cod_ordenente){
    	try {
        	    $obj = new daoordenent;
            	return $obj->putean($cod_barra_os, $cod_ordenente);
			}
		catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    /*Fin Insertar Cod EAN*/

    public function reservadisponible($listoe) {
    	try {
			$listoe->gofirst();
			$this->getordenent($listoeorig = new connlist(clone($listoe->getelem())), $listoedet = new connlist);

            //Validar estado de la OE
			if ($listoeorig->getelem()->id_estado != 'OB' && $listoeorig->getelem()->id_estado != 'OA' && $listoeorig->getelem()->id_estado != 'OG') {
				//throw new CTRLException('No se puede hacer la reserva de disponible debido a que la OE no tiene estado adecuado', 2);
	            general::writelog("No se puede hacer la reserva de disponible debido a que la OE no tiene estado adecuado");
	            return false;
			}
			
			//Recupero el cliente
			$CtrlCte = new ctrlinfocliente;
			$CtrlCte->getCliente($listcte = new connlist(new dtoinfocliente(array('rut'=>$listoeorig->getelem()->rutcliente))));
			$listcte->gofirst();
			if ($listcte->getelem()->id_tipocliente == 1 || $listcte->getelem()->id_tipocliente == 2){ //Es un cliente SAP O CVE
				//Valido que no exista un cargo previo en la tabla de disponible para la OE
//				if (!ctrlinfocliente::ordenentcargo($listoeorig->getelem()->id_ordenent)) {
		    	   	$obj = new daoordenent;
		    	   	return $obj->reservadisponible($listoe);
//				}
//				else {
//					general::writelog('Ya existe un cargo previo para la OE ' . $listoeorig->getelem()->id_ordenent);
//					return true;
//					} 
			}
			else {
				return true;
			}
   		}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function deshacerreservadisponible($listoe, $param) {
    	try {
    	   	$obj = new daoordenent;
    	   	return $obj->deshacerreservadisponible($listoe, $param);
   		}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function generaordenent($listnve, $listpcant, $listoegen, $fecha_rc, $fecha_ei, $fecha_dp) {
    	try {
    		//Recupero el comentario de la nve
    		$listnve->gofirst();
    		$comment = $listnve->getelem()->nota; 
    		$condicion = $listnve->getelem()->condicion; 
    		$diascondicion = $listnve->getelem()->diascondicion; 
    		$id_tipopago = $listnve->getelem()->id_tipopago; 
    		//Recupera NVE
			$listnvedet = new connlist;
			$CtrlCot = new ctrlcotizacion;
			$CtrlCot->getcotizacion($listnve, $listnvedet);
			$listnve->gofirst();
			if ($listnve->getelem()->id_estado != 'CV') //Que la NVE tenga estado adecuado		
				throw new CTRLException('La cotización no puede generar OE debido a que su estado actual no lo permite', 2);
			if ($listnve->getelem()->nvevalidhasta && general::fecha_MYSQL2PHP($listnve->getelem()->nvevalidhasta) < general::fecha_MYSQL2PHP()) //Que la NVE tenga fecha válida
				throw new CTRLException('La cotización no puede generar OE debido a que está vencida', 2);

			//Recupero el cliente
			//general::writelog('rut'.$listnve->getelem()->rutcliente);
			$listcte = new connlist(new dtoinfocliente(array('rut'=>$listnve->getelem()->rutcliente)));
			$CtrlCte = new ctrlinfocliente;
			$CtrlCte->getCliente($listcte);
			$listcte->gofirst();
			//if ($listcte->getelem()->locksap || $listcte->getelem()->lockmoro || $listcte->getelem()->lockcve || $listcte->getelem()->lockfecha) //Que el cliente no esté bloqueado
			//	throw new CTRLException('La cotización no puede generar OE debido a que el cliente está bloqueado', 2);
			$bloquear_oe_4_criterios_locksap = $listcte->getelem()->locksap;
			$bloquear_oe_4_criterios_lockmoro = $listcte->getelem()->lockmoro;
			$bloquear_oe_4_criterios_lockcve = $listcte->getelem()->lockcve;
			$bloquear_oe_4_criterios_lockfecha = $listcte->getelem()->lockfecha;
			
			if ($listcte->getelem()->locksap || $listcte->getelem()->lockmoro || $listcte->getelem()->lockcve || $listcte->getelem()->lockfecha) //Cualquier criterio de bloqueo activado, bloqeua la OE
				$bloquear_oe_4_criterios = true; 
			
			//Recupera Disponible
			$montodisponible = $CtrlCte->getdisponible($listcte);
			//if ($id_tipopago == 1 && $montodisponible < 0) //Que tenga disponible mayor a cero si el tipo de pago es crédito
			//	throw new CTRLException('La cotización no puede generar OE debido a que ya existe una OE previa bloqueada', 2);

			//Recupera prod de la NVE
			if ($listnvedet) $listnvedet->gofirst();
			if ($listpcant) $listpcant->gofirst();
			
			//Ingreso los elementos de $listpcant en un arreglo asociatovo
			$arreglocant = array();
			if ($listpcant && $listpcant->numelem()){
				do{
					$arreglocant[$listpcant->getelem()->id_linea] = $listpcant->getelem()->cantidad;
				} while($listpcant->gonext());
			}
			
			$listoedetretin = new connlist;
			$montototalretin = 0;
			$countterretin = 0;
			
			$listoedetret = new connlist;
			$montototalret = 0;
			$countterret = 0;
			
			$listoedetdesp = new connlist;
			$montototaldesp = 0;
			$countterdesp = 0;

			$listoedetprov = new connlist;
			$montototalprov = 0;
			$countterprov  = 0;
			
			if ($listnvedet && $listnvedet->numelem()){
				do{
					if ($arreglocant[$listnvedet->getelem()->id_linea]){
						if ($listnvedet->getelem()->id_tipoentrega == 1 && $listnvedet->getelem()->id_tiporetiro == 1){ //Retira Cliente Inmediato
							$montototalretin += round($arreglocant[$listnvedet->getelem()->id_linea] * ($listnvedet->getelem()->pventaneto + $listnvedet->getelem()->cargoflete));
							$countterretin++;
							$listoedetretin->addlast(new dtodetordenent(array('id_tiporetiro' => 1,
																			'numlinea' => $countterretin,
																			'descripcion'=> $listnvedet->getelem()->descripcion,
																			'codprod' => $listnvedet->getelem()->codprod,
																			'pcosto' => $listnvedet->getelem()->pcosto,
																			'barra' => $listnvedet->getelem()->barra,
																			'nomproveedor' => 'No corresponde',
																			'rutproveedor' => '0',
																			'pventaneto' => $listnvedet->getelem()->pventaneto + $listnvedet->getelem()->cargoflete,
																			'totallinea' => $arreglocant[$listnvedet->getelem()->id_linea] * ($listnvedet->getelem()->pventaneto+$listnvedet->getelem()->cargoflete),
																			'cantidade' => $arreglocant[$listnvedet->getelem()->id_linea],
																			'unimed'=> $listnvedet->getelem()->unimed,
																			'id_lineadoc'=> $listnvedet->getelem()->id_linea,
																			'codtipo'=> $listnvedet->getelem()->codtipo,
																			'codsubtipo'=> $listnvedet->getelem()->codsubtipo,
																			'instalacion'=> $listnvedet->getelem()->instalacion,
																			'peso'=> $listnvedet->getelem()->peso,
																			'descuento'=> $listnvedet->getelem()->descuento,
																			'pventaiva'=> $listnvedet->getelem()->pventaiva,
																			'iva'=>$listnvedet->getelem()->cot_iva,
																			'rete_ica'=>$listnvedet->getelem()->rete_ica,
																			'rete_renta'=>$listnvedet->getelem()->rete_renta,
																			'margenlinea'=>$listnvedet->getelem()->margenlinea
																			)));
							if ($arreglocant[$listnvedet->getelem()->id_linea] > ($listnvedet->getelem()->cantidad - $listnvedet->getelem()->cantidade))
								throw new CTRLException('La cotización no puede generar OE debido a que solicita mayor cantidad del producto contenido en la Cotizacion [' . $listnvedet->getelem()->descripcion . ']', 2);
						}
						if ($listnvedet->getelem()->id_tipoentrega == 1 && $listnvedet->getelem()->id_tiporetiro == 2){ //Retira Cliente Posterior
							$montototalret += round($arreglocant[$listnvedet->getelem()->id_linea] * ($listnvedet->getelem()->pventaneto + $listnvedet->getelem()->cargoflete));
							$countterret++;
							$listoedetret->addlast(new dtodetordenent(array('id_tiporetiro' => 2,
																			'numlinea' => $countterret,
																			'descripcion'=> $listnvedet->getelem()->descripcion,
																			'codprod' => $listnvedet->getelem()->codprod,
																			'pcosto' => $listnvedet->getelem()->pcosto,
																			'barra' => $listnvedet->getelem()->barra,
																			'nomproveedor' => 'No corresponde',
																			'rutproveedor' => '0',
																			'pventaneto' => $listnvedet->getelem()->pventaneto + $listnvedet->getelem()->cargoflete,
																			'totallinea' => $arreglocant[$listnvedet->getelem()->id_linea] * ($listnvedet->getelem()->pventaneto+$listnvedet->getelem()->cargoflete),
																			'cantidade' => $arreglocant[$listnvedet->getelem()->id_linea],
																			'unimed'=> $listnvedet->getelem()->unimed,
																			'id_lineadoc'=> $listnvedet->getelem()->id_linea,
																			'codtipo'=> $listnvedet->getelem()->codtipo,
																			'codsubtipo'=> $listnvedet->getelem()->codsubtipo,
																			'instalacion'=> $listnvedet->getelem()->instalacion,
																			'peso'=> $listnvedet->getelem()->peso,
																			'descuento'=> $listnvedet->getelem()->descuento,
																			'pventaiva'=> $listnvedet->getelem()->pventaiva,
																			'iva'=>$listnvedet->getelem()->cot_iva,
																			'rete_ica'=>$listnvedet->getelem()->rete_ica,
																			'rete_renta'=>$listnvedet->getelem()->rete_renta,
																			'margenlinea'=>$listnvedet->getelem()->margenlinea
																			)));
							if ($arreglocant[$listnvedet->getelem()->id_linea] > ($listnvedet->getelem()->cantidad - $listnvedet->getelem()->cantidade))
								throw new CTRLException('La cotización no puede generar OE debido a que solicita mayor cantidad del producto contenido en la Cotizacion [' . $listnvedet->getelem()->descripcion . ']', 2);
						}
						if ($listnvedet->getelem()->id_tipoentrega == 2){ //Despacho a Domicilio
							$montototaldesp += round($arreglocant[$listnvedet->getelem()->id_linea] * ($listnvedet->getelem()->pventaneto + $listnvedet->getelem()->cargoflete));
							$countterdesp++;
							$listoedetdesp->addlast(new dtodetordenent(array('id_tiporetiro' => 2,
																			'numlinea' => $countterdesp,
																			'descripcion'=> $listnvedet->getelem()->descripcion,
																			'codprod' => $listnvedet->getelem()->codprod,
																			'pcosto' => $listnvedet->getelem()->pcosto,
																			'barra' => $listnvedet->getelem()->barra,
																			'nomproveedor' => 'No corresponde',
																			'rutproveedor' => '0',
																			'pventaneto' => $listnvedet->getelem()->pventaneto + $listnvedet->getelem()->cargoflete,
																			'totallinea' => $arreglocant[$listnvedet->getelem()->id_linea] * ($listnvedet->getelem()->pventaneto+$listnvedet->getelem()->cargoflete),
																			'cantidade' => $arreglocant[$listnvedet->getelem()->id_linea],
																			'unimed'=> $listnvedet->getelem()->unimed,
																			'id_lineadoc'=> $listnvedet->getelem()->id_linea,
																			'codtipo'=> $listnvedet->getelem()->codtipo,
																			'codsubtipo'=> $listnvedet->getelem()->codsubtipo,
																			'instalacion'=> $listnvedet->getelem()->instalacion,
																			'peso'=> $listnvedet->getelem()->peso,
																			'descuento'=> $listnvedet->getelem()->descuento,
																			'pventaiva'=> $listnvedet->getelem()->pventaiva,
																			'iva'=>$listnvedet->getelem()->cot_iva,
																			'rete_ica'=>$listnvedet->getelem()->rete_ica,
																			'rete_renta'=>$listnvedet->getelem()->rete_renta,
																			'margenlinea'=>$listnvedet->getelem()->margenlinea
																			)));
							if ($arreglocant[$listnvedet->getelem()->id_linea] > ($listnvedet->getelem()->cantidad - $listnvedet->getelem()->cantidade))
								throw new CTRLException('La cotización no puede generar OE debido a que solicita mayor cantidad del producto contenido en la Cotizacion [' . $listnvedet->getelem()->descripcion . ']', 2);
						}
						
						if ($listnvedet->getelem()->id_tipoentrega == 3){ //Despacho Por Proveedor
							$montototalprov += round($arreglocant[$listnvedet->getelem()->id_linea] * ($listnvedet->getelem()->pventaneto + $listnvedet->getelem()->cargoflete));
							$countterprov++;
							$listoedetprov->addlast(new dtodetordenent(array('id_tiporetiro' => 3,
																			'numlinea' => $countterprov,
																			'descripcion'=> $listnvedet->getelem()->descripcion,
																			'codprod' => $listnvedet->getelem()->codprod,
																			'pcosto' => $listnvedet->getelem()->pcosto,
																			'barra' => $listnvedet->getelem()->barra,
																			'nomproveedor' => $listnvedet->getelem()->nomprov,
																			'rutproveedor' => $listnvedet->getelem()->rutproveedor,
																			'pventaneto' => $listnvedet->getelem()->pventaneto + $listnvedet->getelem()->cargoflete,
																			'totallinea' => $arreglocant[$listnvedet->getelem()->id_linea] * ($listnvedet->getelem()->pventaneto+$listnvedet->getelem()->cargoflete),
																			'cantidade' => $arreglocant[$listnvedet->getelem()->id_linea],
																			'unimed'=> $listnvedet->getelem()->unimed,
																			'id_lineadoc'=> $listnvedet->getelem()->id_linea,
																			'codtipo'=> $listnvedet->getelem()->codtipo,
																			'codsubtipo'=> $listnvedet->getelem()->codsubtipo,
																			'instalacion'=> $listnvedet->getelem()->instalacion,
																			'peso'=> $listnvedet->getelem()->peso,
																			'descuento'=> $listnvedet->getelem()->descuento,
																			'pventaiva'=> $listnvedet->getelem()->pventaiva,
																			'iva'=>$listnvedet->getelem()->cot_iva,
																			'rete_ica'=>$listnvedet->getelem()->rete_ica,
																			'rete_renta'=>$listnvedet->getelem()->rete_renta,
																			'margenlinea'=>$listnvedet->getelem()->margenlinea
																			)));
							if ($arreglocant[$listnvedet->getelem()->id_linea] > ($listnvedet->getelem()->cantidad - $listnvedet->getelem()->cantidade))
								throw new CTRLException('La cotización no puede generar OE debido a que solicita mayor cantidad del producto contenido en la Cotizacion [' . $listnvedet->getelem()->descripcion . ']', 2);
						}
					}
				} while($listnvedet->gonext());
			}
			
////////////////////////////////////////////
			$Ctrlr = new ctrltipos;
			$Ctrlr->getconpagoaprox($lista=new connlist(new dtotipo(array('id_tipoconpago'=>$listcte->getelem()->numdiaspago))));	 	
			$lista->gofirst();
			$diascond=$lista->getelem()->id;
////////////////////////////////////////////			
			
			//$montototaloe = (($montototaldesp + $montototalret + $montototalretin + $montototalprov) +  (round(($montototaldesp + $montototalret+ $montototalretin +$montototalprov) * $listnve->getelem()->iva/100)));
			$montototaloe = $listnve->getelem()->valortotal;
			//$montototaloe = (($montototaldesp + $montototalret + $montototalretin + $montototalprov));
			/*general::writeevent('total validar oe'.$montototaloe);
			general::writeevent('total desp'.$montototaldesp);
			general::writeevent('total ret'.$montototalret);
			general::writeevent('total retin'.$montototalretin);
			general::writeevent('total TOTAL COT'.$listnve->getelem()->valortotal);*/
			if ( $montodisponible >= $montototaloe || $id_tipopago == 2) {
				//Si cliente NO tiene condición de pago asignada y número ingresado en OE es mayor a DIAS_CONDICION_PAGO
				if (!trim($listcte->getelem()->numdiaspago) && $diascondicion > DIAS_CONDICION_PAGO) { //Controlamos el bloqueo a nivel de condición de pago
					$bloqueo_condpago = true;
					$estadofinal = 'OB'; //Orden Entrega Bloqueada
				}
				else if (trim($listcte->getelem()->numdiaspago) && $diascondicion > $diascond) {
					//Si cliente tiene condicion de pago asignada y elige una mayor a la asiganda, bloqueamos
					$bloqueo_condpago = true;
					$estadofinal = 'OB'; //Orden Entrega Bloqueada					
				}
				else {
					if ($bloquear_oe_4_criterios && $id_tipopago != 2)
						$estadofinal = 'OB'; //Orden Entrega Bloqueada
					else
						$estadofinal = 'OA'; //Orden Entrega Autorizada
				}
			}
			else {
				$estadofinal = 'OB'; //Orden Entrega Bloqueada
			}

			if ( $montodisponible < $montototaloe && $id_tipopago != 2 ) {
				$vartrackblo .= "- El disponible de credito ($ $montodisponible) NO es suficiente ($ $montototaloe)<br>";
			}
			if ( !trim($listcte->getelem()->numdiaspago) && $diascondicion > DIAS_CONDICION_PAGO ) {
				$vartrackblo .= "- Condicion de pago mayor ($diascondicion) a la definida para el cliente (".DIAS_CONDICION_PAGO.")<br>";
			}
			if ( trim($listcte->getelem()->numdiaspago) && $diascondicion > $diascond ) {
				$vartrackblo .= "- Condicion de pago mayor ($diascondicion) a la definida para el cliente (".$diascond.")<br>";
			}
			if ( $bloquear_oe_4_criterios_locksap ) {
				$vartrackblo .= "- Cliente bloqueado en SAP<br>";
			}
			if ( $bloquear_oe_4_criterios_lockmoro ) {
				$vartrackblo .= "- Cliente bloqueado por morosidad<br>";
			}
			if ( $bloquear_oe_4_criterios_lockcve ) {
				$vartrackblo .= "- Cliente bloqueado en CVE<br>";
			}
			if ( $bloquear_oe_4_criterios_lockfecha ) {
				$vartrackblo .= "- Cliente bloqueado por disponible vencido<br>";
			}
			
			//Genero el DTO de encabezado de las OE
			general::writelog('idcotizacino'.$listnve->getelem()->id_cotizacion);
			general::writelog('id_estado'.$estadofinal);
			$dtooeencnew = new dtoencordenent(array('id_cotizacion' => $listnve->getelem()->id_cotizacion,
													'id_estado' => $estadofinal,
			                                        'id_direccion' =>$listnve->getelem()->id_dirdespacho,
													'codigovendedor' => $listnve->getelem()->codigovendedor,
													'rutcliente' => $listnve->getelem()->rutcliente,
													'codlocalventa' => $listnve->getelem()->codlocalventa,
													'codlocalcsum' => $listnve->getelem()->codlocalcsum,
													'razonsoc' => $listnve->getelem()->razonsoc,
													'id_giro' => $listnve->getelem()->id_giro,
													'giro' => $listnve->getelem()->giro,
													'direccion' => $listnve->getelem()->direccion,
													'comuna' => $listnve->getelem()->comuna,
													'iva' => $listnve->getelem()->iva,
													'condicion' => $condicion,
													'diascondicion' => $diascondicion,
													'fonocontacto' => $listnve->getelem()->fonocontacto,
													'totaliva'=>$listnve->getelem()->cot_iva,
													'zona'=>$listnve->getelem()->zona,
													'rete_iva_oe'=>$listnve->getelem()->rete_iva
													));
																
			//Insertamos las OE nuevas
			if ($countterretin) { //Se inserta la OE de retira cliente inmediato
				$dtooeencnewretin = clone($dtooeencnew); //Genero un Clon del objeto encabezado
				$dtooeencnewretin->id_tipoentrega = 1;
				$dtooeencnewretin->id_tipoflujo = 1;
				$dtooeencnewretin->id_tipopago = $id_tipopago;
				$listoeencretin = new connlist($dtooeencnewretin);
				$listoeencretin->gofirst();
				$listoeencretin->getelem()->nota = $comment;
				//Ingreso la OE
				   
               if($fecha_rc != '0000-00-00' || $fecha_dp !='0000-00-00' ){
				   $fecha_c='0000-00-00';
				   $fecha_d='0000-00-00';
					$this->putordenent($listoeencretin, $listoedetretin, $fecha_c, $fecha_ei, $fecha_d);
						$listoeencretin->gofirst();
					general::inserta_tracking($listnve->getelem()->id_cotizacion, $listoeencretin->getelem()->id_ordenent, null, null, 'Se ha creado una nueva Orden de Entrega');
				
				if ($id_tipopago != 2 && $vartrackblo) {
					general::inserta_tracking($listnve->getelem()->id_cotizacion, $listoeencretin->getelem()->id_ordenent, null, null, "La orden de entrega ha sido bloqueada por los siguientes motivos:<br>$vartrackblo");
				}
				
/*				if ($listoeencretin->getelem()->id_estado!='OB'){
				//Ingreso el registro en el tracking
					general::inserta_tracking($listnve->getelem()->id_cotizacion, $listoeencretin->getelem()->id_ordenent, null, null, 'Se ha creado una nueva Orden de Entrega');
				}else{//para el caso de crearse bloqueada
					if ($bloqueo_condpago)
						general::inserta_tracking($listnve->getelem()->id_cotizacion, $listoeencretin->getelem()->id_ordenent, null, null, 'Se ha creado una nueva Orden de Entrega en estado Bloqueado. (El total de la OE supera el disponible del cliente)');								
					else
						general::inserta_tracking($listnve->getelem()->id_cotizacion, $listoeencretin->getelem()->id_ordenent, null, null, 'Se ha creado una nueva Orden de Entrega en estado Bloqueado. (La condicion de pago seleccionada es mayor a la máxima permitida)');								
				}	*/
				//Actualizo cantidades en la NVE original
				$CtrlCot->ActualizaCantNVEOE($listoedetretin, '+');
				//Hago la reserva de disponible
				//$listoeencretin->getelem()->monto = ($montototalretin +  (round($montototalretin * $listnve->getelem()->iva/100)));
				$listoeencretin->getelem()->monto = $listnve->getelem()->valortotal;
				if ($id_tipopago == 1) { //Sólo si el págo es crédito
					if (!$this->reservadisponible($listoeencretin)) {
						//Anulo la OE
						$this->anularoe($listoeencretin);
						//Actualizo cantidades en la NVE original
						$CtrlCot->ActualizaCantNVEOE($listoedetretin, '-');
						//Elimino la OE
						$this->eliminaroe($listoeencretin);
						throw new CTRLException('No se puede hacer el cargo al cliente. Contáctese con el administrador del sistema', 2);
					}
				}
				//Retorno la OE generada
				$listoeencretin->gofirst();
				$listoegen->addlast($listoeencretin->getelem());
               }
               else{
               		$this->putordenent($listoeencretin, $listoedetretin, $fecha_rc, $fecha_ei, $fecha_dp);
               
					$listoeencretin->gofirst();
					general::inserta_tracking($listnve->getelem()->id_cotizacion, $listoeencretin->getelem()->id_ordenent, null, null, 'Se ha creado una nueva Orden de Entrega');
				
				if ($id_tipopago != 2 && $vartrackblo) {
					general::inserta_tracking($listnve->getelem()->id_cotizacion, $listoeencretin->getelem()->id_ordenent, null, null, "La orden de entrega ha sido bloqueada por los siguientes motivos:<br>$vartrackblo");
				}
				
/*				if ($listoeencretin->getelem()->id_estado!='OB'){
				//Ingreso el registro en el tracking
					general::inserta_tracking($listnve->getelem()->id_cotizacion, $listoeencretin->getelem()->id_ordenent, null, null, 'Se ha creado una nueva Orden de Entrega');
				}else{//para el caso de crearse bloqueada
					if ($bloqueo_condpago)
						general::inserta_tracking($listnve->getelem()->id_cotizacion, $listoeencretin->getelem()->id_ordenent, null, null, 'Se ha creado una nueva Orden de Entrega en estado Bloqueado. (El total de la OE supera el disponible del cliente)');								
					else
						general::inserta_tracking($listnve->getelem()->id_cotizacion, $listoeencretin->getelem()->id_ordenent, null, null, 'Se ha creado una nueva Orden de Entrega en estado Bloqueado. (La condicion de pago seleccionada es mayor a la máxima permitida)');								
				}	*/
				//Actualizo cantidades en la NVE original
				$CtrlCot->ActualizaCantNVEOE($listoedetretin, '+');
				//Hago la reserva de disponible
				//$listoeencretin->getelem()->monto = ($montototalretin +  (round($montototalretin * $listnve->getelem()->iva/100)));
				$listoeencretin->getelem()->monto = $listnve->getelem()->valortotal;
				if ($id_tipopago == 1) { //Sólo si el págo es crédito
					if (!$this->reservadisponible($listoeencretin)) {
						//Anulo la OE
						$this->anularoe($listoeencretin);
						//Actualizo cantidades en la NVE original
						$CtrlCot->ActualizaCantNVEOE($listoedetretin, '-');
						//Elimino la OE
						$this->eliminaroe($listoeencretin);
						throw new CTRLException('No se puede hacer el cargo al cliente. Contáctese con el administrador del sistema', 2);
					}
				}
				//Retorno la OE generada
				$listoeencretin->gofirst();
				$listoegen->addlast($listoeencretin->getelem());
               }
			}
			if ($countterret) { //Se inserta la OE de retira cliente posterior
				$dtooeencnewret = clone($dtooeencnew); //Genero un Clon del objeto encabezado
				$dtooeencnewret->id_tipoentrega = 1;
				$dtooeencnewret->id_tipoflujo = 2;
				$dtooeencnewret->id_tipopago = $id_tipopago;
				$listoeencret = new connlist($dtooeencnewret);
				$listoeencret->gofirst();
				$listoeencret->getelem()->nota = $comment;
				
				
				
				
				if($fecha_ei != '0000-00-00' || $fecha_dp !='0000-00-00' ){
					$fecha_e='0000-00-00';
				   	$fecha_d='0000-00-00';
					//Ingreso la OE
					$this->putordenent($listoeencret, $listoedetret, $fecha_rc, $fecha_e, $fecha_d);
					$listoeencret->gofirst();
					//Ingreso el registro en el tracking
					general::inserta_tracking($listnve->getelem()->id_cotizacion, $listoeencret->getelem()->id_ordenent, null, null, 'Se ha creado una nueva Orden de Entrega');
					//Actualizo cantidades en la NVE original
					$CtrlCot->ActualizaCantNVEOE($listoedetret, '+');
					//Hago la reserva de disponible
					//$listoeencret->getelem()->monto = ($montototalret +  (round($montototalret * $listnve->getelem()->iva/100)));
					$listoeencret->getelem()->monto = $listnve->getelem()->valortotal;
					
				if ($id_tipopago == 1) { //Sólo si el págo es crédito
					if (!$this->reservadisponible($listoeencret)) {
						//Anulo la OE
						$this->anularoe($listoeencret);
						//Actualizo cantidades en la NVE original
						$CtrlCot->ActualizaCantNVEOE($listoedetret, '-');
						//Elimino la OE
						$this->eliminaroe($listoeencret);
						throw new CTRLException('No se puede hacer el cargo al cliente. Contáctese con el administrador del sistema', 2);
					}
				}
				//Retorno la OE generada
				$listoeencret->gofirst();
				$listoegen->addlast($listoeencret->getelem());
				}else{
				    $this->putordenent($listoeencret, $listoedetret, $fecha_rc, $fecha_ei, $fecha_dp);
					$listoeencret->gofirst();
					//Ingreso el registro en el tracking
					general::inserta_tracking($listnve->getelem()->id_cotizacion, $listoeencret->getelem()->id_ordenent, null, null, 'Se ha creado una nueva Orden de Entrega');
					//Actualizo cantidades en la NVE original
					$CtrlCot->ActualizaCantNVEOE($listoedetret, '+');
					//Hago la reserva de disponible
					//$listoeencret->getelem()->monto = ($montototalret +  (round($montototalret * $listnve->getelem()->iva/100)));
					$listoeencret->getelem()->monto = $listnve->getelem()->valortotal;
				if ($id_tipopago == 1) { //Sólo si el págo es crédito
					if (!$this->reservadisponible($listoeencret)) {
						//Anulo la OE
						$this->anularoe($listoeencret);
						//Actualizo cantidades en la NVE original
						$CtrlCot->ActualizaCantNVEOE($listoedetret, '-');
						//Elimino la OE
						$this->eliminaroe($listoeencret);
						throw new CTRLException('No se puede hacer el cargo al cliente. Contáctese con el administrador del sistema', 2);
					}
				}
				//Retorno la OE generada
				$listoeencret->gofirst();
				$listoegen->addlast($listoeencret->getelem());
				}
			}
			if ($countterdesp) { //Se inserta la OE de despacho a domicilio
				$dtooeencnewdesp = clone($dtooeencnew); //Genero un Clon del objeto encabezado
				$dtooeencnewdesp->id_tipoentrega = 2;
				$dtooeencnewdesp->id_tipoflujo = 3; //Por defecto seteamos la facturación inmediata
				$dtooeencnewdesp->id_tipopago = $id_tipopago;
				$listoeencdesp = new connlist($dtooeencnewdesp);
				$listoeencdesp->gofirst();
				$listoeencdesp->getelem()->nota = $comment;
				
				
				if($fecha_ei != '0000-00-00' || $fecha_rc !='0000-00-00' ){
					$fecha_e = '0000-00-00';  
					$fecha_c = '0000-00-00';
					//Ingreso la OE
					$this->putordenent($listoeencdesp, $listoedetdesp, $fecha_c, $fecha_e, $fecha_dp);
					$listoeencdesp->gofirst();
					//Ingreso el registro en el tracking
					general::inserta_tracking($listnve->getelem()->id_cotizacion, $listoeencdesp->getelem()->id_ordenent, null, null, 'Se ha creado una nueva Orden de Entrega');
					//Actualizo cantidades en la NVE original
					$CtrlCot->ActualizaCantNVEOE($listoedetdesp, '+');
					//Hago la reserva de disponible
					//$listoeencdesp->getelem()->monto = ($montototaldesp +  (round($montototaldesp * $listnve->getelem()->iva/100)));
					$listoeencdesp->getelem()->monto = $listnve->getelem()->valortotal;
					
				if ($id_tipopago == 1) { //Sólo si el págo es crédito
					if (!$this->reservadisponible($listoeencdesp)) {
						//Anulo la OE
						$this->anularoe($listoeencdesp);
						//Actualizo cantidades en la NVE original
						$CtrlCot->ActualizaCantNVEOE($listoedetdesp, '-');
						//Elimino la OE
						$this->eliminaroe($listoeencdesp);
						throw new CTRLException('No se puede hacer el cargo al cliente. Contactese con el administrador del sistema', 2);
					}
				}
				//Retorno la OE generada
				$listoeencdesp->gofirst();
				$listoegen->addlast($listoeencdesp->getelem());
			}else{
						$this->putordenent($listoeencdesp, $listoedetdesp, $fecha_rc, $fecha_ei, $fecha_dp);
					
				
					$listoeencdesp->gofirst();
					//Ingreso el registro en el tracking
					general::inserta_tracking($listnve->getelem()->id_cotizacion, $listoeencdesp->getelem()->id_ordenent, null, null, 'Se ha creado una nueva Orden de Entrega');
					//Actualizo cantidades en la NVE original
					$CtrlCot->ActualizaCantNVEOE($listoedetdesp, '+');
					//Hago la reserva de disponible
					$listoeencdesp->getelem()->monto = $listnve->getelem()->valortotal;
					//$listoeencdesp->getelem()->monto = ($montototaldesp +  (round($montototaldesp * $listnve->getelem()->iva/100)));
				
				if ($id_tipopago == 1) { //Sólo si el págo es crédito
					if (!$this->reservadisponible($listoeencdesp)) {
						//Anulo la OE
						$this->anularoe($listoeencdesp);
						//Actualizo cantidades en la NVE original
						$CtrlCot->ActualizaCantNVEOE($listoedetdesp, '-');
						//Elimino la OE
						$this->eliminaroe($listoeencdesp);
						throw new CTRLException('No se puede hacer el cargo al cliente. Contactese con el administrador del sistema', 2);
					}
				}
				//Retorno la OE generada
				$listoeencdesp->gofirst();
				$listoegen->addlast($listoeencdesp->getelem());	
			}
		}
			
			
			
			
///////////////////////////////////////			
/*DESPACHO PROVEEDOR*/
			if ($countterprov) { //Se inserta la OE de despacho proveedor
				$dtooeencnewprov = clone($dtooeencnew); //Genero un Clon del objeto encabezado
				$dtooeencnewprov->id_tipoentrega = 3;
				$dtooeencnewprov->id_tipoflujo = 5; //Por defecto seteamos la facturación despacho proveedor
				$dtooeencnewprov->id_tipopago = $id_tipopago;
				$listoeencprov = new connlist($dtooeencnewprov);
				$listoeencprov->gofirst();
				$listoeencprov->getelem()->nota = $comment;
				
				//Ingreso la OE
				$this->putordenent($listoeencprov, $listoedetprov, $fecha_rc, $fecha_ei, $fecha_dp);
				$listoeencprov->gofirst();
				//Ingreso el registro en el tracking
				general::inserta_tracking($listnve->getelem()->id_cotizacion, $listoeencprov->getelem()->id_ordenent, null, null, 'Se ha creado una nueva Orden de Entrega');
				//Actualizo cantidades en la NVE original
				$CtrlCot->ActualizaCantNVEOE($listoedetprov, '+');
				//Hago la reserva de disponible
				//$listoeencprov->getelem()->monto = ($montototalprov +  (round($montototalprov * $listnve->getelem()->iva/100)));
				if ($id_tipopago == 1) { //Sólo si el págo es crédito
					if (!$this->reservadisponible($listoeencprov)) {
						//Anulo la OE
						$this->anularoe($listoeencprov);
						//Actualizo cantidades en la NVE original
						$CtrlCot->ActualizaCantNVEOE($listoedetprov, '-');
						//Elimino la OE
						$this->eliminaroe($listoeencprov);
						throw new CTRLException('No se puede hacer el cargo al cliente. Contáctese con el administrador del sistema', 2);
					}
				}
				//Retorno la OE generada
				$listoeencprov->gofirst();
				$listoegen->addlast($listoeencprov->getelem());
			}

///////////////////////////////////////////////			
			
			if (!$countterret && !$countterretin && !$countterdesp &&!$countterprov)
				throw new CTRLException('La Cotizacion no ha generado Ordenes de Entrega', 2);
			
			return true ;
    	}
    	catch(BUSException $e) 	{throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function putPagoOE($listoe, $listopgen, $caden3) {
    	global $ses_usr_codlocal;
    	try {		
   					
			//Recupera OE
			$listoe->gofirst();
			$this->getordenent($listoeorig = new connlist(new dtoencordenent(array('id_ordenent'=>$listoe->getelem()->id_ordenent))), $listoedet = new connlist);
    		//$listoeorig->gofirst();		//para ver si tiene despacho desde el csum
			general::writelog("Estado : ".$listoeorig->getelem()->id_estado);
				if($listoeorig){
					$listoeorig->gofirst();
					//pregunta si cum tiene despacho a domicilio		
					$flujo= $listoeorig->getelem()->id_tipoflujo;
					$CtrlLoc = new ctrllocal();
					$direccion = $listoe->getelem()->id_direccion;
					//Busco la OE para obtener el tipo de flujo
					$CtrlLoc->getlocales($lista = new connlist(new dtolocal(array('cod_local'=>$listoeorig->getelem()->codlocalcsum))));
					$lista->gofirst();
					if($lista->getelem()->foliogde){
						$despacho=true;
						//genera OP
					}else{
						$despacho=false;	
						// no genera OP		
					}
				}
			
			
			if (!$listoedet || !$listoedet->numelem()) return 'La Orden de Entrega no tiene productos'/*throw new CTRLException('La Orden de Entrega no tiene productos', 2)*/;

			$listoeorig->gofirst();
			$listoedet->gofirst();

			//Validar Tipo de Pago de la OE nueva
			/*if (!$listoe->getelem()->id_tipopago) throw new CTRLException('La Orden de Entrega no tiene tipo de pago asociado', 2);*/

			//Validar Tipo de documento Pago de la OE nueva
			if (!$listoe->getelem()->id_tipodocpago) return 'La Orden de Entrega no tiene tipo de documento de pago asociado' /*throw new CTRLException('La Orden de Entrega no tiene tipo de documento de pago asociado', 2)*/;

			//Validar tipo de facturaci�n
			/*if (!$listoe->getelem()->id_tipoflujo) throw new CTRLException('La Orden de Entrega no tiene asignado tipo de facturaci�n', 2);*/

			//Validar que la direccion de despacho tenga informacion en los campos obligatorios
			$direccion = $listoe->getelem()->id_direccion;
			if($flujo==3||$flujo==4||$flujo==5){
					bizcve::getdirdesp($Listd = new connlist(new dtodireccion(array('id_direccion'=>$direccion))));
					$Listd->gofirst();
					$iddireccionvalida = $Listd->getelem()->id_direccion;
					$idcomunavalida = $Listd->getelem()->id_comuna;
					$descripcionvalida = $Listd->getelem()->descripcion;
					if(!$iddireccionvalida||!$idcomunavalida||!$descripcionvalida||$idcomunavalida==-1){
						return 'La direccion de despacho seleccionada no contiene todos los datos obligatorios para continuar con el proceso de venta. Por favor complete esta informacion.'/*throw new CTRLException('La direccion de despacho seleccionada no contiene todos los datos obligatorios para continuar con el proceso de venta. Por favor complete esta informacion.', 2)*/;																	
				}
			}
			
			general::writelog("Estado : ".$listoeorig->getelem()->id_estado);
			//Validar Estado de la OE antigua
			if ($listoeorig->getelem()->id_estado == 'OG') return 'La Orden de Entrega esta en estado Pagada';/*throw new CTRLException('La Orden de Entrega no tiene direccion de despacho', 2)*/
			
			if ($listoeorig->getelem()->id_estado == 'OB') return 'La Orden de Entrega esta en estado Bloqueada';
			
			if ($listoeorig->getelem()->id_estado == 'OF') return 'La Orden de Entrega esta en estado Finalizada';
			
			if ($listoeorig->getelem()->id_estado == 'ON') return 'La Orden de Entrega esta en estado Nula';
			
			if ($listoeorig->getelem()->id_estado == 'OR') return 'La Orden de Entrega esta en estado Rechazada';
			
			//Validar despacho en caso de tipo de entrega
			/*general::writelog("esta es id_direccion".$listoe->getelem()->id_direccion);
			if ($listoeorig->getelem()->id_tipoentrega == 2 && !$listoe->getelem()->id_direccion) return 'La Orden de Entrega no tiene direccion de despacho'/*throw new CTRLException('La Orden de Entrega no tiene direccion de despacho', 2)*/
			
			$contador =  sizeof($caden3);
			
			if($contador != 0){
    			//Insertar y Extraer Nuevo listado de Productos
				$Daop = new daoproductocpe;
				$Daop2 = new daoordenent;
				$listoedet2 = new connlist;
				$Listp = new connlist($local = new dtoencordenent(array('codlocalventa'=> $listoeorig->getelem()->codlocalventa)));
				$Listp->gofirst();
			    $codlocal = $Listp->getelem()->codlocalventa;
    			$i=0;
    		
    			//general::writelog("este es el contador".$contador);
    			if($contador != 3){
    				foreach($caden3 as $key=>$value){
    					foreach($value as $key2=>$value2){
    					if($i==0)
    						$precio = $value2;
    					if($i==1)
    						$cantidad = $value2;
    					if($i==2){
    						$ean = $value2;
    		   				$Daop->getproductows($Listp,$codlocal,$ean);
    		   				$Listp->gofirst();
    		   				general::writelog("si los busco".$Listp->getelem()->descripcion);
							general::writelog("si los busco".$Listp->getelem()->codprod);
							general::writelog("si los retiro".$listoedet->getelem()->id_tiporetiro);
							general::writelog("si los orden".$listoeorig->getelem()->id_ordenent);
							$totallinea= $precio * $cantidad;
    		   				$listoedet2->addlast(new dtodetordenent(array('id_tiporetiro'=> $listoedet->getelem()->id_tiporetiro,	
    		   															'id_ordenent'=> $listoeorig->getelem()->id_ordenent,
																		'descripcion'=> $Listp->getelem()->descripcion,
																		'codprod' => $Listp->getelem()->codprod,
																		'pventaneto' => $precio,
																		'barra' => $ean,
																		'nomproveedor' => 'No corresponde',
																		'rutproveedor' => '0',
																		'cantidadp' => $cantidad,
    		   															'cantidade'=>$cantidad,
    		   															'codtipo' => $Listp->getelem()->codtipo,
    		   															'codsubtipo' => $Listp->getelem()->codsubtipo,
    		   															'unimed' => $Listp->getelem()->unimed,
    		   															'totallinea' =>$totallinea,
    		   															'pcosto'=> $Listp->getelem()->pcosto,
    		   															'peso'=> $Listp->getelem()->peso,
    		   															)));
			   				$Daop2->savedetordenent($listoeorig,$listoedet2);
    					}
    					
    					$i++;
    					}
    				}
    			}else{
    				foreach($caden3 as $key=>$value){
							foreach($value as $key2=>$value2){
									if($i==0){
    									$precio = $value2;
    									general::writelog("valor precio".$precio);
									}
    								if($i==1){
  		  								$cantidad = $value2;
    									general::writelog("valor cantidad".$cantidad);
    								}
    								if($i==2){
    									general::writelog("ean".$value2);
    									$ean = $value2;
    		   							$Daop->getproductows($Listp,$codlocal,$ean);
    		   							$Listp->gofirst();
    		   							general::writelog("si los busco".$Listp->getelem()->descripcion);
										general::writelog("si los busco".$Listp->getelem()->codprod);
										general::writelog("si los retiro".$listoedet->getelem()->id_tiporetiro);
										general::writelog("si los orden".$listoeorig->getelem()->id_ordenent);
										$totallinea= $precio * $cantidad;
    		   							$listoedet2->addlast(new dtodetordenent(array('id_tiporetiro'=> $listoedet->getelem()->id_tiporetiro,	
    		   																		  'id_ordenent'=> $listoeorig->getelem()->id_ordenent,
																					  'descripcion'=> $Listp->getelem()->descripcion,
																					  'codprod' => $Listp->getelem()->codprod,
																					  'pventaneto' => $precio,
																					  'barra' => $ean,
																				      'nomproveedor' => 'No corresponde',
																		              'rutproveedor' => '0',
																		              'cantidadp' => $cantidad,
    		   															              'cantidade'=>$cantidad,
    		   															              'codtipo' => $Listp->getelem()->codtipo,
    		   															              'codsubtipo' => $Listp->getelem()->codsubtipo,
    		   															              'unimed' => $Listp->getelem()->unimed,
    		   															              'totallinea' =>$totallinea,
    		   																		  'pcosto'=> $Listp->getelem()->pcosto,
    		   																		  'peso'=> $Listp->getelem()->peso,
    		   																		  'instalacion'=>'NO'
    		   											     )));
			   							$Daop2->savedetordenent($listoeorig,$listoedet2);
			   							$listoedet2->clearlist();    				
    								}
    		    		    
    								$i++;
									if($i==3){
										general::writelog("esta es el indice".$i);
										$i=0;
										general::writelog("esta es el indice".$i);
									}
							}
						}					
    			}
			}		
		    	//Modificar Registro
			$DaoOE = new daoordenent;
    		/*if ( $listoeorig->getelem()->id_tipoentrega==1 and $listoedet->getelem()->id_tiporetiro==1)
			{       
				$listoe->getelem()->id_estado = 'OF';
			}else{
				$listoe->getelem()->id_estado = 'OG';
			}*/
			$listoe->getelem()->id_estado = 'OG';
			$DaoOE->saveencordenent($listoe);
    		//si el flujo corresponde y tiene no despacho desde csum
			if(!$despacho && ($flujo==3 || $flujo==4)){
				general::inserta_tracking(null, $listoeorig->getelem()->id_ordenent, null, null, 'Se ha dado curso (pago) a la Orden de Entrega');				
                general::inserta_tracking(null, $listoeorig->getelem()->id_ordenent, null, null, 'No crea Orden de Picking. Centro de suministro '. $listoeorig->getelem()->nom_localcsum .' no tiene despacho a domicilio');								
				//Marco �ltima compra del cliente
				$ctrlcte = new ctrlinfocliente();
				$ctrlcte->putcliente(new connlist(new dtoinfocliente(array('rut'=>$listoeorig->getelem()->rutcliente, 'codlocaluco'=> $ses_usr_codlocal))));
	
				//Genero los registros de documentos necesarios
				$CtrlDoc = new ctrldocumento();
				$listoe->gofirst();				
				$listoe->getelem()->tipodocgen = 'FCT';
							
				$CtrlDoc->generadocumento($listoe, $listoedet, $listdocgen = new connlist());
				
				//general::alertexit('No genera Orden de Picking, ' .$listoeorig->getelem()->nom_localcsum .' no tiene despacho a domicilio');
                general::writelog('No genera Orden de Picking, ' .$listoeorig->getelem()->nom_localcsum .' no tiene despacho a domicilio');		
				return false;				
			}			
			
		
			$listopdetnewdes = new connlist;
			$listopdetnewret = new connlist;
			$CtrlOP = new ctrlordenpick;
			
			//Generaci�n de las OP
			$listoedet->gofirst();
			$contadordes = 0;
			$contadorret = 1;
			bizcve::getordenent($listoeorig2 = new connlist(new dtoencordenent(array('id_ordenent'=>$listoe->getelem()->id_ordenent))), $listoedet2 = new connlist);
			$listoedet2->gofirst();
			$listoeorig2->gofirst();
			do {
				//OP para despacho a domicilio
				if(	$listoeorig2->getelem()->id_tipoentrega == 2){
					//Modificaci�n RGM 21.12.2006. Para flujo 3, se generan tantas OP como facturas
					//Agregamos la l�neas de detalle
					$contadordes++;
					if ($listoedet2->getelem()->codprod=='12501'){
						$cantidadp = $listoedet2->getelem()->cantidade;
					}
					//if ($listoedet->getelem()->codtipo!='SV'){
					$listopdetnewdes->addlast(new dtodetordenpicking(array('numlinea' => $contadordes, 
																	'descripcion' => $listoedet2->getelem()->descripcion, 
																	'codprod' => $listoedet2->getelem()->codprod, 
																	'barra' => $listoedet2->getelem()->barra, 
																	'cantidad' => $listoedet2->getelem()->cantidade, 
						                                            'cantidadp' => $cantidadp,                                              
                                                                    'totallinea' => $listoedet2->getelem()->totallinea, 
																	'id_lineadoc' => $listoedet2->getelem()->id_linea, 
																	'unimed' => $listoedet2->getelem()->unimed, 
																	'codtipo' => $listoedet2->getelem()->codtipo, 
																	'codsubtipo' => $listoedet2->getelem()->codsubtipo 					
																	)));
					//}
					/*if ($con
					 *  enc");
						$CtrlOP->putordenpicking($newop = new connlist(new dtoencordenpicking(array(	'id_ordenent'=> $listoeorig->getelem()->id_ordenent,
																							'id_direccion'=> $direccion,
																							'rutcliente'=> $listoeorig->getelem()->rutcliente,
																							'cod_local'=> $listoeorig->getelem()->codlocalcsum,
																							'razonsoc'=> $listoeorig->getelem()->razonsoc,
																							'direccion'=> $listoeorig->getelem()->direccion,
																							'comuna'=> $listoeorig->getelem()->comuna,
																							'fonocontacto'=> $listoeorig->getelem()->fonocontacto,
																							'prioridad'=> $listoe->getelem()->prioridadpick
																							))), $listopdetnewdes);
						$this->ActualizaCantOEOP($listopdetnewdes, '+');
						$newop->gofirst();
		                general::inserta_tracking(null, $listoeorig->getelem()->id_ordenent, $newop->getelem()->id_ordenpicking, null, 'Se ha creado una nueva Orden de Picking (OP '. $newop->getelem()->id_ordenpicking .')');
		                $listopgen->addlast($newop->getelem());
						$contadordes = 0; 
						$listopdetnewdes = new connlist;
					}*/

				}
				
				//OP para retira cliente
				if ($listoedet2->getelem()->codtipo!='SV'){
				if( $listoeorig2->getelem()->id_tipoentrega == 1 && $listoedet2->getelem()->id_tiporetiro == 2){
					$listopdetnewret->addlast(new dtodetordenpicking(array('numlinea' => $contadorret, 
																	'descripcion' => $listoedet2->getelem()->descripcion, 
																	'codprod' => $listoedet2->getelem()->codprod, 
																	'barra' => $listoedet2->getelem()->barra, 
																	'cantidad' => $listoedet2->getelem()->cantidade, 
																	'totallinea' => $listoedet2->getelem()->totallinea, 
																	'id_lineadoc' => $listoedet2->getelem()->id_linea, 
																	'unimed' => $listoedet2->getelem()->unimed, 
																	'codtipo' => $listoedet2->getelem()->codtipo, 
																	'codsubtipo' => $listoedet2->getelem()->codsubtipo 
																	)));
					++$contadorret;
				}
				}
			} while($listoedet2->gonext());

			//Ingresamos la OP despacho domicilio si es que qued� resto de las ya generadas
			if ($contadordes) {
			//	general::writelog("Este es el valor de la direccion".$direccion);
				//Modificaci�n RGM 21.12.2006. Para flujo 3, se generan tantas OP como facturas
				$CtrlOP->putordenpicking($newop = new connlist(new dtoencordenpicking(array(	'id_ordenent'=> $listoeorig2->getelem()->id_ordenent,
																					'id_direccion'=>$direccion,
																					'rutcliente'=> $listoeorig2->getelem()->rutcliente,
																					'cod_local'=> $listoeorig2->getelem()->codlocalcsum,
																					'razonsoc'=> $listoeorig2->getelem()->razonsoc,
																					'direccion'=> $listoeorig2->getelem()->direccion,
																					'comuna'=> $listoeorig2->getelem()->comuna,
																					'fonocontacto'=> $listoeorig2->getelem()->fonocontacto,
																					'prioridad'=> $listoe->getelem()->prioridadpick
																					))), $listopdetnewdes);
				$this->ActualizaCantOEOP($listopdetnewdes, '+');
				$newop->gofirst();
                general::inserta_tracking(null, $listoeorig2->getelem()->id_ordenent, $newop->getelem()->id_ordenpicking, null, 'Se ha creado una nueva Orden de Picking (OP '. $newop->getelem()->id_ordenpicking .')');
                $listopgen->addlast($newop->getelem());
			}

			//Ingresamos la OP retira cliente
			if ($listopdetnewret->numelem()) {
				//general::writelog("Este es el valor de la direccion".$direccion);
				$CtrlOP->putordenpicking($newop = new connlist(new dtoencordenpicking(array(	'id_ordenent'=> $listoeorig2->getelem()->id_ordenent,
																					'id_direccion'=> $direccion,
																					'rutcliente'=> $listoeorig2->getelem()->rutcliente,
																					'cod_local'=> $listoeorig2->getelem()->codlocalcsum,
																					'razonsoc'=> $listoeorig2->getelem()->razonsoc,
																					'direccion'=> $listoeorig2->getelem()->direccion,
																					'comuna'=> $listoeorig2->getelem()->comuna,
																					'fonocontacto'=> $listoeorig2->getelem()->fonocontacto,
																					'prioridad'=> $listoe->getelem()->prioridadpick
																					))), $listopdetnewret);
				$this->ActualizaCantOEOP($listopdetnewret, '+');
				$newop->gofirst();
                general::inserta_tracking(null, $listoeorig2->getelem()->id_ordenent, $newop->getelem()->id_ordenpicking, null, 'Se ha creado una nueva Orden de Picking');
                $listopgen->addlast($newop->getelem());
			}
			
			//Hago el cargo al disponible s�lo si es cliente SAP
/*			$ctrlcte = new ctrlinfocliente();
			$ctrlcte->getCliente($listcte = new connlist(new dtoinfocliente(array('rut'=>$listoeorig->getelem()->rutcliente))));
			$listcte->gofirst();
			if ($listcte->getelem()->id_tipocliente == 1) { //Es Cliente SAP
				//Hago el cargo
				$ctrlcte->putcargo($listoeorig);
			}*/
			
			//Marco �ltima compra del cliente
			$ctrlcte = new ctrlinfocliente();
			$ctrlcte->putcliente(new connlist(new dtoinfocliente(array('rut'=>$listoeorig->getelem()->rutcliente, 'codlocaluco'=> $ses_usr_codlocal))));
			
			//Genero los registros de documentos necesarios
			$CtrlDoc = new ctrldocumento();
			$listoe->getelem()->tipodocgen = 'FCT';
			//general::writelog("Entro aqui al documento 1");
			$CtrlDoc->generadocumento($listoe, $listoedet, $listdocgen = new connlist());
			

			return true ;			
		
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }    
    public function autorizaroe($listoe) {
    	global $ses_usr_login;
    	try {
			$listoe->gofirst();
			$this->getordenent($listoeorig = new connlist(clone($listoe->getelem())), $listoedet = new connlist);
			//Validar Que exista la OE
			if (!$listoeorig || !$listoeorig->numelem()) 
				throw new CTRLException('La Orden de Entrega no existe', 2);
    		//Validar estado de la OE
			if ($listoeorig->getelem()->id_estado != 'OB') 
				throw new CTRLException('No se puede autorizar la OE debido a que no tiene estado adecuado', 2);
				
			$obj = new daoordenent;
			$retorno = $obj->saveencordenent(new connlist(new dtoencordenent(array(   'id_ordenent' => $listoe->getelem()->id_ordenent
																					, 'id_estado' => 'OA'
																					, 'diascondicion' => $listoe->getelem()->diascondicion 
																					, 'condicion' => $listoe->getelem()->condicion
																					, 'obsdesb' => 'Autorizado por ' . $ses_usr_login . '. ' . $listoe->getelem()->obsdesb))));
			if ($retorno)
				ctrltracking::puttracking(new connlist(new dtotracking(array('id_ordenent' => $listoe->getelem()->id_ordenent
																			, 'tipo' => 'SYS'
																			, 'descripcion' => 'Se ha autorizado la Orden de entrega')))); 
			return $retorno;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function rechazaroe($listoe) {
    	global $ses_usr_login;
    	try {
			$listoe->gofirst();
			$this->getordenent($listoeorig = new connlist(clone($listoe->getelem())), $listoedet = new connlist);
			//Validar Que exista la OE
			if (!$listoeorig || !$listoeorig->numelem()) 
				throw new CTRLException('La Orden de Entrega no existe', 2);
    		//Validar estado de la OE
			if ($listoeorig->getelem()->id_estado != 'OB') 
				throw new CTRLException('No se puede rechazar la OE debido a que no tiene estado adecuado', 2);
    								
			$obj = new daoordenent;
			$retorno = $obj->saveencordenent(new connlist(new dtoencordenent(array(   'id_ordenent' => $listoe->getelem()->id_ordenent
																					, 'id_estado' => 'OR'
																					, 'obsdesb' => 'Rechazado por ' . $ses_usr_login . '. ' . $listoe->getelem()->obsdesb))));
			//Reversar el cargo al disponible del cliente (si existe)
			$obj->deshacerreservadisponible($listoe);
			
			if ($retorno)
				ctrltracking::puttracking(new connlist(new dtotracking(array('id_ordenent' => $listoe->getelem()->id_ordenent
																			, 'tipo' => 'SYS'
																			, 'descripcion' => 'Se ha rechazado la Orden de entrega')))); 
			return $retorno;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function anularoe($listoe) {
    	global $ses_usr_login;
    	try {
			$listoe->gofirst();
			$this->getordenent($listoeorig = new connlist(clone($listoe->getelem())), $listoedet = new connlist);
				
			$obj = new daoordenent;
			$retorno = $obj->saveencordenent(new connlist(new dtoencordenent(array(   'id_ordenent' => $listoe->getelem()->id_ordenent
																					, 'id_estado' => 'ON'
																					, 'obsdesb' => 'Anulado por ' . $ses_usr_login . '. ' . $listoe->getelem()->obsdesb))));
			//Reversar el cargo al disponible del cliente (si existe)
			$obj->deshacerreservadisponible($listoe);
																								
			if ($retorno)
				ctrltracking::puttracking(new connlist(new dtotracking(array('id_ordenent' => $listoe->getelem()->id_ordenent
																			, 'tipo' => 'SYS'
																			, 'descripcion' => 'Se ha anulado la Orden de entrega')))); 
			return $retorno;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
	
	public function cambioindicadorsap($listoe) {
    	global $ses_usr_login;
    	try {
			$listoe->gofirst();
			$this->getordenent($listoeorig = new connlist(new dtoencordenent(array ('id_ordenent'=>$listoe->getelem()->id_ordenent))), $listoedet = new connlist);
			//Validar Que exista la OE
			
			if (!$listoeorig || !$listoeorig->numelem()) 
				throw new CTRLException('La Orden de Entrega no existe', 2);
    		//Validar estado de la OE
			if ($listoeorig->getelem()->id_estado != 'OG') 
				throw new CTRLException('No se puede Cambiar el indicador Envio sap debido a que la OE no tiene el estado adecuado', 2);
				
			$obj = new daoordenent;
			$retorno = $obj->cambioindicadorsap($listoe);													
			if ($retorno)
				ctrltracking::puttracking(new connlist(new dtotracking(array('id_ordenent' => $listoe->getelem()->id_ordenent
																			, 'tipo' => 'SYS'
																			, 'descripcion' => 'Se ha enviado la Orden de entrega a Sap')))); 
			return $retorno;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    private function eliminaroe($listoe) {
    	try {
			$listoe->gofirst();
			$listoeorig = new connlist(new dtoencordenent(array('id_ordenent'=>$listoe->getelem()->id_ordenent)));
			$this->getordenent($listoeorig, $listdetoeorig = new connlist);
			//Validar Que exista la OE
			if (!$listoeorig || !$listoeorig->numelem()) 
				throw new CTRLException('La Orden de Entrega no existe', 2);
    		//Validar estado de la OE
			if ($listoeorig->getelem()->id_estado != 'ON') 
				throw new CTRLException('No se puede eliminar la OE debido a que no tiene estado adecuado', 2);
    		//Valido que no hayan cargos pendientes en la OE (disponible)
    		if (ctrlinfocliente::ordenentcargo($listoeorig->getelem()->id_ordenent))
				throw new CTRLException('No se puede eliminar la OE debido a que tiene cargos asociados', 2);

			$obj = new daoordenent;
    	   	return $obj->eliminaroe($listoe);
   		}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function ActualizaCantOEOP($listopdetnew, $operacion){
		try {
    	   $obj = new daoordenent;	
    	   return $obj->ActualizaCantOEOP($listopdetnew, $operacion);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
	}

    
    public function genpedidoventasap($List){
		try {
			//Obtener encabezado y detalle de la OE
			$this->getordenent($List, $Listdet = new connlist);
			$List->gofirst();
			if (!$List->getelem()->id_ordenent) 
				throw new CTRLException('No se puede generar el pedido de venta debido a que no viene Id de orden de entrega', 2);
				
			//Obtengo el nombre de la ciudad y la region
			$ctrlcom = new ctrltipos();
			$ctrlcom->getcomuna($ListCom = new connlist(new dtocomuna(array('nomcomuna'=>$List->getelem()->comuna))));
			$ListCom->gofirst();
			
			//Obtengo datos adicionales del cliente
			$ctrlcte = new ctrlinfocliente();
			$ctrlcte->getCliente($ListCte = new connlist(new dtoinfocliente(array('rut'=>$List->getelem()->rutcliente))));
			$ListCte->gofirst();
			
			//Obtengo datos de tipos de flujos
			$ctrltipo = new ctrltipos();
			$ctrltipo->gettipoflujo($ListTipo = new connlist(new dtotipo(array('id'=>$List->getelem()->id_tipoflujo))));
			$ListTipo->gofirst();
			
			//Escribirlos en un stream formateado el encabezado
			$encabezado = general::CompletaEspaciosD('C', 1); 								//TIP_REG		CHAR	1	0	Tipo de Registro
			$encabezado .= general::CompletaCerosI($List->getelem()->id_ordenent, 10); 		//DOC_NUMBER	CHAR	10	0	Número de documento
			$encabezado .= general::CompletaEspaciosD('?', 4); 								//DOC_TYPE		CHAR	4	0	Tipo de venta
			$encabezado .= general::CompletaEspaciosD($List->getelem()->codlocalventa, 4); 	//VKBUR			CHAR	4	0	Oficina de ventas
			$encabezado .= general::CompletaCerosI($List->getelem()->codigovendedor, 3); 	//VKGRP			CHAR	3	0	Vendedor
			$encabezado .= general::CompletaEspaciosD($ListTipo->getelem()->valor2, 3);		//INCO1			CHAR	3	0	Forma de entrega
			$encabezado .= general::CompletaCerosI($List->getelem()->rutcliente, 10); 		//KUNNR			CHAR	10	0	Código de cliente
			$encabezado .= general::CompletaEspaciosD($List->getelem()->razonsoc, 35); 		//NAME1			CHAR	35	0	Nombre de cliente
			$encabezado .= general::CompletaEspaciosD($List->getelem()->direccion, 35); 	//STRAS			CHAR	35	0	Dirección (Calle y número)
			$encabezado .= general::CompletaEspaciosD($List->getelem()->comuna, 35); 		//ORT02			CHAR	35	0	Comuna
			$encabezado .= general::CompletaEspaciosD($ListCom->getelem()->nomciudad, 35); 	//ORT01			CHAR	35	0	Ciudad
			$encabezado .= general::CompletaCerosI($ListCom->getelem()->id_region, 3); 		//REGIO			CHAR	3	0	Región
			$encabezado .= general::CompletaEspaciosD($ListCom->getelem()->nomregion, 20); 	//REGIO_TEXT	CHAR	20	0	Nombre Región
			$encabezado .= general::CompletaEspaciosD($List->getelem()->fonocontacto, 15); 	//TELF1			CHAR	15	0	Fono
			$encabezado .= general::CompletaEspaciosD($ListCte->getelem()->email, 30); 		//EMAIL			CHAR	30	0	Email
			$encabezado .= general::CompletaEspaciosD('CHI', 3); 							//LAND1			CHAR	3	0	País
			$encabezado .= general::CompletaCerosI($List->getelem()->rutcliente, 16); 		//STCD1			CHAR	16	0	Id. Fiscal (RUT)
			$encabezado .= general::CompletaCerosI(round($List->getelem()->iva), 2); 		//IND_IVA		DEC		2	2	% IVA
			$encabezado .= general::CompletaCerosI($ListCte->getelem()->id_rubro, 4); 		//BRSCH			CHAR	4	0	Giro comercial
			$encabezado .= general::CompletaEspaciosD($ListCte->getelem()->nomrubro, 30); 	//BRSCH_TEXT	CHAR	20	0	Descripción del giro
			$encabezado .= "\n";
			
			//Iterar por el detalle de la OE
			$Listdet->gofirst();
			if ($Listdet->numelem()) {
				do {
					//Imprimir archivo de texto (Utilizar rutina de chino)
					$detalle .= general::CompletaEspaciosD('D', 1);												//TIP_REG		CHAR	1	0	Tipo de Registro
					$detalle .= general::CompletaCerosI($List->getelem()->id_ordenent, 10); 					//DOC_NUMBER	CHAR	10	0	Número de documento
					$detalle .= general::CompletaCerosI($Listdet->getelem()->numlinea, 6); 						//ITEM			CHAR	6	0	Número de Item
					$detalle .= general::CompletaCerosI($Listdet->getelem()->codprod, 18); 						//MATERIAL		CHAR	18	0	Artículo
					$detalle .= general::CompletaEspaciosD($List->getelem()->codlocalcsum, 4); 					//PLANT			CHAR	4	0	Tienda que despacha
						$cantsd = (int)$Listdet->getelem()->cantidade; 
						$cantde = substr($Listdet->getelem()->cantidade, -2);
					$detalle .= general::CompletaCerosI($cantsd, 12) . general::CompletaCerosD($cantde, 3); 	//REQ_QTY	DEC		15	3	Cantidad
					$detalle .= general::CompletaEspaciosD($Listdet->getelem()->unimed, 3); 					//SALES_UNIT	CHAR	3	0	Unidad de medida de venta
					$detalle .= general::CompletaCerosI(round($Listdet->getelem()->pventaneto), 13) . '00'; 	//PRECIO_VENTA	DEC	15	2	Precio de venta
					$detalle .= general::CompletaCerosI(0, 15); 												//TODO: 2da etapa OE con PCosto //PRECIO_COSTO	DEC	15	2	Precio de costo
					$detalle .= "\n";
				} while ($Listdet->gonext());
			}
			
			$nom = 'CVEOE'.general::CompletaCerosI($List->getelem()->id_ordenent,8);
			bbrq::guardaArchivo($encabezado.$detalle,$nom,$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT'),false);
			$nom .= '.trg';
			bbrq::guardaArchivo(' ',$nom,$_SESSION["CONFIG"]->getValue('APPLICATION','PATH_BIN_OUT'),false);
			 
			
			
			return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
   
    public function getdetordenent($ListDet) {
       	try {
    	   $obj = new daoordenent;
   	   		$obj->getdetordenent($ListDet);
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getdetoerdenentregasumimp($ListDet) {
       	try {
    	   $obj = new daoordenent;
   	   		$obj->getdetoerdenentregasumimp($ListDet);
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getdetcomprapendiente($List) {
       	try {
    	   $obj = new daoordenent;
   	   		$obj->getdetcomprapendiente($List);
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function savedetordenescomprapendientes($idline,$ncompra,$idoe) {
       	try {
       			 $Listocomprapen = new connlist;
				 $detcomprapen = new dtodetordenent;
				 $detcomprapen->id_linea 	= $idline;
				 $Listocomprapen->addlast($detcomprapen);
				 bizcve::getdetcomprapendiente($Listocomprapen);
				 
				 $Listocomprapen->gofirst();
				 if($Listocomprapen->getelem()->codprod >0)
				 {	 				 
    	   		 return true ;
				 }
				 else{
				 $obj = new daoordenent;
   	   			 $obj->savedetordenescomprapendientes($idline,$ncompra,$idoe);
				 return true ;
				 }	
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getdetordenentpespecial($ListDet) {
       	try {
    	   $obj = new daoordenent;
   	   		$obj->getdetordenentpespecial($ListDet);
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    

    
    
}
?>