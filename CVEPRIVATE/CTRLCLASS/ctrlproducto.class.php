<?php
class ctrlproducto{

    public function getproducto($List) {
    	try {
    	   	$obj = new daoproductocpe;
    	   	return $obj->getproducto($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getDescrSKU(&$List) {
        try {
                $obj = new daoproductocpe;
                return $obj->getDescrSKU($List);
        }
        catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
        catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
        catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getSkuDescr($List) {
        try {
                $obj = new daoproductocpe;
                return $obj->getSkuDescr($List);
        }
        catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
        catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
        catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getproveedores($List) {
    	try {
    	   	$obj = new daoproductocpe;
    	   	return $obj->getproveedores($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getproductof($List) {
    	try {
    	   	$obj = new daoproductocpe;
    	   	return $obj->getproductof($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getproductogrilla($List) {
    	try {
    	   	//general::writeevent($List_Inv->getelem()->stock);
    	   	$obj_int = new ctrlproducto;
    	   	return $obj_int->setinventarioreal($List);
    	   	  	 
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getplista($List) {
    	try {
    	   	$obj = new daoproductocpe;
    	   	return $obj->getplista($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getprovpreferencial($List) {
    	try {
    	   	$obj = new daoproductocpe;
    	   	return $obj->getprovpreferencial($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getproductoxproveedor($List) {
    	try {
    	   	$obj = new daoproductocpe;
    	   	return $obj->getproductoxproveedor($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
	public function getproductoxdatosproveedor($List) {
    	try {
    	   	$obj = new daoproductocpe;
    	   	return $obj->getproductoxdatosproveedor($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function limpiatabla($List) {
    	try {
    	   	$obj = new daodocumento;
    	   	return $obj->limpiatabla($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    public function getnivel4($List) {
    	try {
    	   	$obj = new daoproductocpe;
    	   	return $obj->getnivel4($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function getnivel3($List) {
    	try {
    	   	$obj = new daoproductocpe;
    	   	return $obj->getnivel3($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function getnivel2($List) {
    	try {
    	   	$obj = new daoproductocpe;
    	   	return $obj->getnivel2($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function getnivel1($List) {
    	try {
    	   	$obj = new daoproductocpe;
    	   	return $obj->getnivel1($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function getpadre3($List) {
    	try {
    	   	$obj = new daodocumento;
    	   	return $obj->getpadre3($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function getpadre2($List) {
    	try {
    	   	$obj = new daodocumento;
    	   	return $obj->getpadre2($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function putnivel4($List) {
    	try {
    	   	$obj = new daodocumento;
    	   	return $obj->putnivel4($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function putnivel3($List) {
    	try {
    	   	$obj = new daodocumento;
    	   	return $obj->putnivel3($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function putnivel2($List) {
    	try {
    	   	$obj = new daodocumento;
    	   	return $obj->putnivel2($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }

    public function putnivel1($List) {
    	try {
    	   	$obj = new daodocumento;
    	   	return $obj->putnivel1($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
    
    public function getproductoinventario($List) {
    	try {
    	   	$obj = new daoproductocpe;
    	   	return $obj->getproductoinventario($List);
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }


    
	public function setinventarioreal($List) {
    	try {
    		
    		$list_ws_Inv = new connlist;

            
    		
    		$obj = new daoproductocpe;
    	   	$obj->getproductogrilla($List);
    		//general::writeevent("ingresa al guardar");
    		//$List_Inv = new connlist;
             
            

    		$List_Inv = clone($List);
    		$List->clearlist();
    		$List_Inv->gofirst();

          file_put_contents("setpaso.txt", print_r($List_Inv,true));

    		
    		if (!$List_Inv->isvoid()) {
				do {

                    
					
						$Registro = new dtoproducto;
                        $tmp =  new daocotizacion();
                        $Registro->grupocat =$tmp->getCatProd($List_Inv->getelem()->sap);
                                   
                         

			            $Registro->cod_prod1   	= $List_Inv->getelem()->cod_prod1;
			            $Registro->id_producto	= $List_Inv->getelem()->id_producto;
			            $Registro->sap   		= $List_Inv->getelem()->sap;
			            $Registro->barra   		= $List_Inv->getelem()->barra;
			           	$Registro->descripcion	= $List_Inv->getelem()->descripcion;
			            $Registro->prod_tipo	= $List_Inv->getelem()->prod_tipo;
			            $Registro->prod_subtipo	= $List_Inv->getelem()->prod_subtipo;
			            $Registro->csum   		= $List_Inv->getelem()->csum;
			            $Registro->pcosto   	= $List_Inv->getelem()->pcosto;
			            $Registro->pventa   	= $List_Inv->getelem()->pventa;

                

			            //general::writeevent("valor actuinv despues de dao".$List_Inv->getelem()->actualizarinventario);
			            if($List_Inv->getelem()->actualizarinventario==true){
							//general::writeevent("consume servicio");
			            	$list_ws_Inv->clearlist();
				            $Registro_ws_Inv = new dtoproducto;
				            $Registro_ws_Inv->barra = $List_Inv->getelem()->barra;
				            $Registro_ws_Inv->sap 	= $List_Inv->getelem()->sap;
				            $Registro_ws_Inv->csum  = $List_Inv->getelem()->csum;
				            $list_ws_Inv->addlast($Registro_ws_Inv);
				            //general::writeevent("inv cp".$List_Inv->getelem()->stock);
			            //sleep(10);
			            
				            try{
					            $wsResponse=webservicecve::ws_Inventory_Real($list_ws_Inv);
					            
					            if($wsResponse){
					            	
					            	if($wsResponse['state']==1){
					            		
										if($wsResponse[0]['amount'] > 0){
											$Registro->stock   		= $wsResponse[0]['amount'];
										}
										else{
											$Registro->stock   		= "0";
										}
										
					            	}
					            	else{
					            		$Registro->stock		= $List_Inv->getelem()->stock;
					            		//general::writeevent("Inventario Real estado ".$wsResponse['state']."stock ".$wsResponse[0]['amount']."mensaje ".$wsResponse['message']);
					            	}
					            	
					            }
					            else{
					            	$Registro->stock		= $List_Inv->getelem()->stock;
					            	general::writeevent("Inventario Real no responde");
					            }
				            }
				            catch (Exception $Mensage_E){
				            	$Registro->stock		= $List_Inv->getelem()->stock;
				            	general::writelog("Error :".$Mensage_E->getMessage());
				            }
			            }
			            else{
			            	$Registro->stock		= $List_Inv->getelem()->stock;
			            }
			            $Registro->unidmed   	= $List_Inv->getelem()->unidmed;
						$Registro->nomprov   	= $List_Inv->getelem()->nomprov;
			            $Registro->numretlimit	= $List_Inv->getelem()->numretlimit;
						$Registro->id_catprod  	= $List_Inv->getelem()->id_catprod;
                        $Registro->peso  		= $List_Inv->getelem()->peso;
						$Registro->ica  		= $List_Inv->getelem()->ica;
						$Registro->ivap  		= $List_Inv->getelem()->ivap;
						$Registro->renta  		= $List_Inv->getelem()->renta;
						$List ->addlast($Registro);
					} while ($List_Inv->gonext());
				}
			
    	   	return $List;
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
 }
?>
