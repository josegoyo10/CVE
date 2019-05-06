<?
class ctrlordenpick{
    
    public function getordenpick($ListEnc, $ListDet = null) {
       	try {
       		$ListEnc->gofirst();
    	   	$obj = new daoordenpicking;
    	   	$obj->getencordenpicking($ListEnc);
       		$ListEnc->gofirst();
   	   	
    	   	if ($ListEnc->numelem()==1 && $ListDet!=null) {
    	   		$ListDet->clearlist();
    	   		$Registro = new dtodetordenpicking;
    	   		$Registro->id_ordenpicking= $ListEnc->getelem()->id_ordenpicking;
     	   		$ListDet->addlast($Registro);
    	   		$obj->getdetordenpicking($ListDet);
    	   	}
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function guardarhistoria ($ListEnc, $ListDet = null) {
       	try {
       		$ListEnc->gofirst();
    	   	$obj = new daoordenpicking;
    	   	$obj->guardarhistoria($ListEnc);
       		$ListEnc->gofirst();
   	   	
    	   	if ($ListEnc->numelem()==1 && $ListDet!=null) {
    	   		$ListDet->clearlist();
    	   		$Registro = new dtodetordenpicking;
    	   		$Registro->id_ordenpicking= $ListEnc->getelem()->id_ordenpicking;
     	   		$ListDet->addlast($Registro);
    	   		$obj->getdetordenpicking($ListDet);
    	   	}
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getMonitorordenpick($ListEnc, $ListDet = null) {
       	try {
       		$ListEnc->gofirst();
    	   	$obj = new daoordenpicking;
    	   	$obj->getMonitorordenpicking($ListEnc);
       		$ListEnc->gofirst();
   	   	
    	   	if ($ListEnc->numelem()==1 && $ListDet!=null) {
    	   		$ListDet->clearlist();
    	   		$Registro = new dtodetordenpicking;
    	   		$Registro->id_ordenpicking= $ListEnc->getelem()->id_ordenpicking;
     	   		$ListDet->addlast($Registro);
    	   		$obj->getdetordenpicking($ListDet);
    	   	}
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
   
    
    public function putordenpicking($ListEnc, $ListDet) {
    	try {
    		$ListEnc->gofirst();
    	   	$obj = new daoordenpicking;
    	   	$obj->initrx();
    		if (!$obj->saveencordenpicking($ListEnc)) {
    	   		$obj->rollback();
    			return false;
    		}
    		if ($ListDet) {
	    		if (!$obj->deldetordenpicking($ListEnc)) {
	    	   		$obj->rollback();
	    			return false;
	    		}
	    		if (!$obj->savedetordenpicking($ListEnc, $ListDet)) {
	    	   		$obj->rollback();
	    			return false;
	    		}
    		}
    	   	$obj->commit();
    		return true;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function cerrarpicking($listop, $listpcant, $listopgen) {
    	try {

			$listop->gofirst();
			if (!$listop->getelem()->id_ordenpicking) //Que venga el id de OP
				throw new CTRLException('La Orden de Picking no existe', 2);
			
    		//Recupera OP
			$this->getordenpick($listop, $listopdet = new connlist);
			$listop->gofirst();
			$direccion = $listop->getelem()->id_direccion;
			if ($listop->getelem()->id_estado != 'PC') //Que la OP tenga estado adecuado
				throw new CTRLException('La Orden de Picking no se puede cerrar debido a que su estado actual no lo permite', 2);

			$CtrlOE = new ctrlordenent();
			//Busco la OE para obtener el tipo de flujo
			$CtrlOE->getordenent($listoe = new connlist(new dtoencordenent(array('id_ordenent'=>$listop->getelem()->id_ordenent))), $listoedet = new connlist);
			if ($listoe && $listoe->numelem())
				$listoe->gofirst();
			$tipoflujo = $listoe->getelem()->id_tipoflujo; 
			$id_ordenent = $listoe->getelem()->id_ordenent; 
			
			if($tipoflujo==3 || $tipoflujo==4||$tipoflujo==5)
			{
				if ($direccion < 0){ //Que venga el id de Direccion
					throw new CTRLException('La orden de picking que esta intentando cerrar no cuenta con una direccion de despacho. Es necesario agregar una para cerrar el picking.', 2);												
				}else{
					bizcve::getdirdesp($Listd = new connlist(new dtodireccion(array('id_direccion'=>$direccion))));
					$Listd->gofirst();
					$iddireccionvalida = $Listd->getelem()->id_direccion;
					$idcomunavalida = $Listd->getelem()->id_comuna;
					$descripcionvalida = $Listd->getelem()->descripcion;
					if(!$iddireccionvalida||!$idcomunavalida||!$descripcionvalida){
						throw new CTRLException('La direccion de despacho seleccionada no contiene todos los datos obligatorios, para cerrar la orden de picking. Por favor complete esta informacion.', 2);																	
					}
				}   	
					//Validacion que direccion de despacho tenga los datos obligatorios
					if(!$iddireccionvalida|| !$idcomunavalida|| !$descripcionvalida){
						general::alert('Faltan datos obligatorios en la direccion de despacho seleccionada. Por favor complete la informacion faltante.');
					return false;
					}		
			}

			if ($tipoflujo == 2) {
				//SI NO SE HAN IMPRESO LAS FCT, ARROJAMOS UN ERROR AL CERRAR
				//Obtengo todas las guias que apuntan a la OP
				$CtrlDoc = new ctrldocumento;
				$CtrlDoc->getdocumento($listadoc = new connlist(new dtodocumento(array('numdocrefop'=>$listop->getelem()->id_ordenpicking,
																					   'id_tipodocumento'=>2))), null);
					
				//Itero por cada guia
				$listadoc->gofirst();
				if ($listadoc->numelem()) {
					do { //recupero la factura de la que proviene y su numdocumento
						if ($listadoc->getelem()->numdocref) {
							$CtrlDoc->getdocumento($listadoc2 = new connlist(new dtodocumento(array('id_documento'=>$listadoc->getelem()->numdocref))), null);
							$listadoc2->gofirst();
							if (!$listadoc2->getelem())
								throw new CTRLException('La Guia de Despacho ' . $listadoc->getelem()->id_documento . ' tiene asignada una factura no existente', 2);
							
							if (!$listadoc2->getelem()->numdocumento)
								throw new CTRLException('Antes de cerrar la Orden de Picking debe imprimir y asignar n�mero de folio a la(s) factura(s) asociadas', 2);
						}
						else {
							throw new CTRLException('La Guia de Despacho ' . $listadoc->getelem()->id_documento . ' no tiene asignada factura', 2);
						}
					} while ($listadoc->gonext());
				}
				else {
					throw new CTRLException('No existen Guias de Despacho asociadas a la OP', 2);
				}
			}

			if ($tipoflujo == 3) {
				//SI NO SE HAN IMPRESO LAS FCT, ARROJAMOS UN ERROR AL CERRAR
				//Obtengo todas las facturas que derivan de la OE
				$CtrlDoc = new ctrldocumento;
				$CtrlDoc->getdocumento($listadoc = new connlist(new dtodocumento(array('numorigen'=>$id_ordenent,
																					   'id_tipodocumento'=>1))), null);
					
				//Itero por cada factura
				$listadoc->gofirst();
				if ($listadoc->numelem()) {
					do { 
						if (!$listadoc->getelem()->numdocumento)
							throw new CTRLException('Antes de cerrar la Orden de Picking debe imprimir y asignar numero de folio a la(s) factura(s) asociadas', 2);
					} while ($listadoc->gonext());
				}
				else {
					throw new CTRLException('No existen Facturas asociadas a la OP', 2);
				}
			}
			
			//Recupera prod de la OP
			if ($listopdet) $listopdet->gofirst();
			if ($listpcant) $listpcant->gofirst();
			
			//Ingreso los elementos de $listpcant en un arreglo asociatovo
			$arreglocant = array();
			if ($listpcant && $listpcant->numelem()){
				do{
					$arreglocant[$listpcant->getelem()->id_linea] = ($listpcant->getelem()->cantidadp+0);
				} while($listpcant->gonext());
			}
			
			//Ingreso los elementos de $listopdet en un arreglo asociatovo
			$arreglocantrefoe = array();
			if ($listopdet && $listopdet->numelem()){
				do{
					$arreglocantrefoe[$listopdet->getelem()->id_lineadoc] = ($arreglocant[$listopdet->getelem()->id_linea]+0);
				} while($listopdet->gonext());
			}
			
			$indgenera = false;
			$listnewopdet = new connlist;
			if ($listopdet && $listopdet->numelem()){
				$listopdet->gofirst();
				do{
					if (($arreglocant[$listopdet->getelem()->id_linea]+0) < $listopdet->getelem()->cantidad){
						//Se reasigna la linea a otro DTO de orden de picking
						$newdtoop = clone($listopdet->getelem());
						$newdtoop->id_linea = null;
						$newdtoop->id_ordenpicking = null;
						$newdtoop->numlinea = null;
						$newdtoop->cantidad = ($listopdet->getelem()->cantidad - $arreglocant[$listopdet->getelem()->id_linea]);
						$newdtoop->cantidadp = 0;
						$newdtoop->totallinea = round((($listopdet->getelem()->cantidad - $arreglocant[$listopdet->getelem()->id_linea]) * $listopdet->getelem()->totallinea) / $listopdet->getelem()->cantidad);
						$listnewopdet->addlast($newdtoop);
						$indgenera = true;
					}
					$listopdet->getelem()->cantidadp = $arreglocant[$listopdet->getelem()->id_linea];
				} while($listopdet->gonext());
			}

			if ($indgenera) {
				//Si se generaron nuevas lineas, creo la nueva OP
				$newdtoencop = clone($listop->getelem());
				$newdtoencop->id_ordenpicking = null;
				$newdtoencop->id_estado = null;
				$this->putordenpicking($listopnew = new connlist($newdtoencop), $listnewopdet);
				//Agrego la nueva OP al listado de op de retorno
				$listopnew->gofirst();
				$lanuevaop = $listopnew->getelem()->id_ordenpicking;
				general::inserta_tracking(null, null, $listopnew->getelem()->id_ordenpicking, null, 'Se ha creado una nueva Orden de Picking a partir de la Orden de Picking ' . $listop->getelem()->id_ordenpicking);
				$listopgen->addlast($listopnew->getelem());

				if ($listoe && $listoe->numelem()) {
					$listoe->gofirst();
					if ($listoe->getelem()->id_tipoflujo==3 || $listoe->getelem()->id_tipoflujo == 2 ) {
						$CtrlDOC = new ctrldocumento();
						//Buscar las GDE de la op original
						$CtrlDOC->getdocumento($Listdoc = new connlist(new dtodocumento(array('numdocrefop'=>$listop->getelem()->id_ordenpicking, 'id_tipodocumento'=>2))), $listdet = new connlist);
						if ($Listdoc && $Listdoc->numelem()) {
							$Listdoc->gofirst();
							//por cada documento GDE busco su referencia en la línea de la OP
							do {
								//Recupero el detalle de la GDE
								$inddocmodify = false;
								$sumatotales = 0; 
								$Listdetdocnew = new connlist(); 
								$CtrlDOC->getdocumento($ListdocGDE = new connlist(new dtodocumento(array('id_documento'=>$Listdoc->getelem()->id_documento))), $ListdocGDEdet = new connlist);
								$ListdocGDE->gofirst();
								if ($ListdocGDEdet && $ListdocGDEdet->numelem()) {
									$ListdocGDEdet->gofirst();
									//por cada línea de detalle de la GDE
									do {
										//Busco la línea de detalle de la GDE en el arreglo
										if ($arreglocantrefoe[$ListdocGDEdet->getelem()->id_linearef] < $ListdocGDEdet->getelem()->cantidad) {
											$inddocmodify = true;
											//Cada remanente de línea, agregarlo a una nueva detalle GDE 
											$detdocnew = clone($ListdocGDEdet->getelem());
											$detdocnew->cantidad = $ListdocGDEdet->getelem()->cantidad - $arreglocantrefoe[$ListdocGDEdet->getelem()->id_linearef];
											$detdocnew->totallinea = round($detdocnew->cantidad * $detdocnew->pventaneto);
											$Listdetdocnew->addlast($detdocnew);
											$sumatotales += $detdocnew->totallinea;
											//Actualizo los valores
											if ($arreglocantrefoe[$ListdocGDEdet->getelem()->id_linearef]>0) {
												//Solo se modifica la línea del documento
												$ListdocGDEdet->getelem()->cantidad = $arreglocantrefoe[$ListdocGDEdet->getelem()->id_linearef];
											}
											else {
												//Se elimina la línea del documento
												$ListdocGDEdet->setelem(null);
											}
										}
									} while ($ListdocGDEdet->gonext());
								}
								//Ingresar el documento sólo si fue modificado
								if ($inddocmodify){
									$dtoencGDEnew = clone($ListdocGDE->getelem());

									//Hacer put del documento GDE reciente
									//Reviso que si dentro de los elementos viene alguno no nulo
									$ListdocGDEdet->gofirst();
									$tieneelementos = false;
									if ($ListdocGDEdet->numelem()) {
										do {
											if ($ListdocGDEdet->getelem())
												$tieneelementos = true; 
										} while($ListdocGDEdet->gonext());
									}
									if (!$tieneelementos) {
										//Si el documento no tiene linea de detalle, lo borramos
										$CtrlDOC->deldocumento($ListdocGDE);
										$ListdocGDE->gofirst();
										general::writeevent('Elimino el documento: '. $ListdocGDE->getelem()->id_documento);
										general::inserta_tracking(null, null, null, $ListdocGDE->getelem()->id_documento, 'El documento ha sido eliminado');
									}
									else {
										//Sino, lo actualizamos
										
										$CtrlDOC->putdocumento($ListdocGDE, $ListdocGDEdet);
									}
									
									//Ingresar la guía nueva
									if ($Listdetdocnew->numelem()){
										$dtoencGDEnew->pagina = ($CtrlDOC->getpaginadoc(new connlist(new dtoencordenent(array('id_ordenent'=>$listop->getelem()->id_ordenent))), 2) + 1);
										$dtoencGDEnew->id_documento = null;
										$dtoencGDEnew->numdocrefop = $lanuevaop;
										bizcve::putdocumento($nuevagde = new connlist($dtoencGDEnew), $Listdetdocnew);
									}
									
								}
							} while ($Listdoc->gonext());
						}
					}
				}
			}
			
			if ($listoe && $listoe->numelem()) {
				$listoe->gofirst();
				if ($listoe->getelem()->id_tipoflujo==3 || $listoe->getelem()->id_tipoflujo==2) {
					//Modifico el estado de la OP antigua a PD
					$listop->getelem()->id_estado = 'PD';
					$this->putordenpicking($listop, $listopdet);
					$listop->gofirst();
					general::inserta_tracking(null, $listop->getelem()->id_ordenent, $listop->getelem()->id_ordenpicking, null, 'La Orden de Picking '.$listop->getelem()->id_ordenpicking.' ha sido cerrada');
				}
				if ($listoe->getelem()->id_tipoflujo==3 || $listoe->getelem()->id_tipoflujo==4) {
				//if ($listoe->getelem()->id_tipoflujo==4) {
					//Hago esto sólo para actualizar las cantidades pickeadas de la OP antes de mandarla a despachoa domicilio
					$this->putordenpicking($listop, $listopdet);
					
					$listop->gofirst();
			    	$wml_desp=$this->InsertaOdWs($listop);
			    	$resultado_ws = wsclient::envia_nueva_gd($wml_desp,$msgerror);
     				if (!$resultado_ws) {
						general::writelog("No se ha podido ingresar la OD en sistema de despacho. Error: $msgerror\n. XML: \n$wml_desp");
						general::alert("No se ha podido ingresar la OD en sistema de despacho. Contacte al administrador del sistema");
					}
					else {
						general::writeevent('Se ha generado la orden de Despacho nº'. $resultado_ws .' en el sistema de Despacho a domicilio');
						//Modifico el estado de la OP antigua a PD
						$listop->getelem()->id_estado = 'PD';
						$this->putordenpicking($listop, $listopdet);
						$listop->gofirst();
						general::inserta_tracking(null, $listop->getelem()->id_ordenent, $listop->getelem()->id_ordenpicking, null, 'La Orden de Picking '.$listop->getelem()->id_ordenpicking.' ha sido cerrada y se ha generado la Orden de Despacho '.$resultado_ws.' en el sistema de Despacho a Domicilio ');
						general::alert('Se ha generado la orden de Despacho '. $resultado_ws .' en el sistema de Despacho a domicilio');
					}
				}
			}
		
			return true ;
    	}
    	catch(BUSException $e) 	{throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

	/******************function para WS***********/
    public function InsertaOdWs($listop){
   	global $ses_usr_login;    	
	$listop->gofirst();
	//header
	$xml_header="<header>
		<fecha>".date("Y-m-d")."</fecha>
		<hora>".date("H:i:s")."</hora>
		<operador>".$ses_usr_login."</operador>
		<sistema>Centro Venta Empresa</sistema></header>";
	//para la verificacion
		$xml_headermd5="<header>
		<operador>".$ses_usr_login."</operador>
		<sistema>Centro Venta Empresa</sistema></header>";
	
	$this->getordenpick($ListEnc=new connlist(new dtoencordenpicking(array('id_ordenpicking'=>$listop->getelem()->id_ordenpicking,'id_ordenent'=>$listop->getelem()->id_ordenent))),$ListDet = new connlist);

	/**/
	$Dao = new daoordenpicking;
	$Dao->getpesopicking($ListDe= new connlist(new dtoencordenpicking(array('id_ordenpicking'=>$listop->getelem()->id_ordenpicking))));
	
	/**/
	
	
	//encabezado orden pick
	$ListEnc->gofirst();
	if (!$ListEnc->isvoid()) {
	/*recupera el id comuna*/	
   	$obj = new daotipos;
	/*para obtener la comuna del despacho*/
   	if($ListEnc->getelem()->id_direccion > 0){
   		$Listdes  = new connlist;
		$mRegistrod=new dtodireccion;
		$mRegistrod->id_direccion = $ListEnc->getelem()->id_direccion;
		$Listdes->addlast($mRegistrod);
		bizcve::getdirdesp($Listdes);
		$Listdes->gofirst();
		$registrolocalizacion1 = $Listdes->getelem()->id_comuna;
		$tel_contacto2 = "";
		$indicacion = $Listdes->getelem()->comentario;
		$direccion = $ListEnc->getelem()->direccion;
		$comuna = $Listdes->getelem()->id_comuna;
	}else{
		bizcve::getCliente($List = new connlist(new dtoinfocliente(array('rut'=>$ListEnc->getelem()->rutcliente))));
		$registrolocalizacion1 = $List->getelem()->id_comuna; 
		$tel_contacto2 = $List->getelem()->celcontactoe;
		$indicacion = $List->getelem()->comentario;
		$direccion = $List->getelem()->direccion;
		$comuna =$List->getelem()->id_comuna;
	}

	//general::writelog("Localizacion Generada : " . $registrolocalizacion1);
	
	 // Recupera las descripciones de departamento, ciudad, localidad
	$Listlocalizacion  = new connlist;
	$registrolocalizacion->id_localizacion=$registrolocalizacion1;
	$Listlocalizacion->addlast($registrolocalizacion);
	bizcve::getlocalizacion($Listlocalizacion);
	
	$idordnent = $ListEnc->getelem()->id_ordenent;
	
	$Dao1 = new daoordenent;
	$Dao1->getencordenent($ListEnc1 = new connlist(new dtoencordenent(array('id_ordenent'=>$idordnent))));
	$ListEnc1->gofirst();

	/*Validar la Fecha de Entrega*/
	if($ListEnc1->getelem()->fecha_retira_cliente != '0000-00-00'){
		$fechaentrega = general::formato_fecha($ListEnc1->getelem()->fecha_retira_cliente);
	}
	if($ListEnc1->getelem()->fecha_retira_inmediato != '0000-00-00'){
		$fechaentrega = general::formato_fecha($ListEnc1->getelem()->fecha_retira_inmediato);
	}
	if($ListEnc1->getelem()->fecha_despacho_programado != '0000-00-00'){
		$fechaentrega = general::formato_fecha($ListEnc1->getelem()->fecha_despacho_programado);
	}
	/*Fin Validar la Fecha de Entrega*/

	//$obj->getcomuna($Listc = new connlist(new dtocomuna(array('nomcomuna'=>$ListEnc->getelem()->comuna))));	
	//$Listc->gofirst();
	$Listlocalizacion->gofirst();		
		$xml_enc = "<encabezado>
			<tipodocref>6</tipodocref>
			<fechahingreso>6</fechahingreso>
			<ndocref>".$ListEnc->getelem()->id_ordenpicking."</ndocref>
			<lugarcompra>".$ListEnc->getelem()->cod_local."</lugarcompra>
			<fechacompra>".$ListEnc->getelem()->feccrea."</fechacompra>
			<origeningreso>6</origeningreso>
			<descripcion>".$ListEnc->getelem()->id_ordenent.' - '.' CVE '."</descripcion>
			<nomcliente>".$ListEnc->getelem()->razonsoc." </nomcliente>
			<clie_rut>".$ListEnc->getelem()->rutcliente."</clie_rut>
			<telfonodes>".$ListEnc->getelem()->fonocontacto." </telfonodes>
			<direcciondes>".$direccion."</direcciondes>
			<clie_tipo>".'e'."</clie_tipo>
			<direcomuna>".$comuna." </direcomuna>
			<tipocarga>1</tipocarga>
			<tipodesp>1</tipodesp>
			<tipobulto>2</tipobulto>
			<jornada>1</jornada>
			<usrid>5</usrid>
			<telcontacto1> </telcontacto1>
			<telcontacto2>".$tel_contacto2."</telcontacto2>
			<indicacion>".$indicacion."</indicacion>
			<departamento>".$Listlocalizacion->getelem()->departamento."</departamento>
			<ciudad>".$Listlocalizacion->getelem()->ciudad."</ciudad>
			<localidad>".$Listlocalizacion->getelem()->localidad."</localidad>
			<location>".$registrolocalizacion1."</location>
			<barrio>".$Listlocalizacion->getelem()->barrio."</barrio>
			<zona>".$ListEnc1->getelem()->zona."</zona>
			<fechaentrega>".$fechaentrega."</fechaentrega>
		</encabezado>";
		$xml_items ="<items>";		
	}
	$ListDet->gofirst();
	$ListDe->gofirst();
	if (!$ListDet->isvoid()) {
		do {
				//armo xml Cuerpo con productos
/*				$xml_items .="<producto>
						<id_detalle>".$ListDet->getelem()->id_lineadoc."</id_detalle>
						<codbarra>".$ListDet->getelem()->codprod."</codbarra>
						<tipocodigo>".'3'."</tipocodigo>
						<unimed>".'3'."</unimed>
						<cantidad>".$ListDet->getelem()->cantidadp."</cantidad>
						<descriprod>".$ListDet->getelem()->descripcion."</descriprod>
					</producto>";*/
			if ($ListDet->getelem()->cantidadp > 0) {
				$xml_items .="<producto>
						<id_detalle>".$ListDet->getelem()->id_lineadoc."</id_detalle>
						<codbarra>".$ListDet->getelem()->codprod."</codbarra>
						<tipocodigo>3</tipocodigo>
						<unimed>4</unimed>
						<cantidad>".$ListDet->getelem()->cantidadp."</cantidad>
						<descriprod>".$ListDet->getelem()->barra." - " .$ListDet->getelem()->descripcion."</descriprod>
						<pesoprod>".$ListDe->getelem()->peso."</pesoprod>
					</producto>";
				
				$ListDe->gonext();
			}
		}while ($ListDet->gonext());
		$xml_items .="</items>";
	}	
	$xmlmd5 ="<?xml version='1.0'?><main>".$xml_headermd5."<data>".$xml_enc.$xml_items."</data></main>";
	$xmd5 = md5($xmlmd5);
	$xml_md5="<md5><ident>".$xmd5."</ident></md5>";
	
	$xml ="<?xml version='1.0'?><main>".$xml_header."<data>".$xml_enc.$xml_items.$xml_md5."</data></main>";
	/*$xml ="<?xml version='1.0'?><main>".$xml_header."<data>".$xml_enc.$xml_items."</data></main>";*/
	
	general::writeevent("XML Despacho : " . $xml);
	return $xml;
   }    
   
   public function addimpresionordenpicking($ListEnc) {
       	try {
    	   $obj = new daoordenpicking;
   	   		$obj->addimpresionordenpicking($ListEnc);
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function getdetordenpick($ListDet) {
       	try {
    	   $obj = new daoordenpicking;
   	   		$obj->getdetordenpicking($ListDet);
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }   
    
    public function getpedidoespecialgenerico($ListEnc) {
       	try {
    	   $obj = new daoordenpicking;
   	   		$obj->getpedidoespecialgenerico($ListEnc);
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }  

    public function setOpestadopegenerico($ListEnc) {
       	try {
    	   $obj = new daoordenpicking;
   	   		$obj->setOpestadopegenerico($ListEnc);
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    } 
    
    public function getcountenespera($ListEnc) {
       	try {
    	   $obj = new daoordenpicking;
   	   		$obj->getcountenespera($ListEnc);
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    } 

    public function dividirpedidoespecial_pnormal($ListEnc) {
       	try {
    	   $obj = new daoordenpicking;
   	   		$obj->dividirpedidoespecial_pnormal($ListEnc);
    	   	return true ;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }  
   
   
}
?>