<?
class bizcve{
	public static function getdocumentonulosap($List) {
		try {
            $obj = new ctrldocumento;
            return $obj->getdocumentonulosap($List);
		}
		catch (Exception 	$e){return false;}
		
    }

	public static function cambioindicadorsapnull($list) {
		try {
            $obj = new ctrldocumento;
            return $obj->cambioindicadorsapnull($list);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function getdescuento($List) {
		try {
            $obj = new ctrltipos;
            return $obj->getdescuento($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function gettipodocumentoidentidad($List) {
		try {
            $obj = new ctrltipodocumentoidentidad;
            return $obj->gettipodocumentoidentidad($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
   public static function getclasificacioncliente($List) {
		try {
            $obj = new ctrlclasificacioncliente;
            return $obj->getclasificacioncliente($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getcontribuyente($List) {
		try {
            $obj = new ctrlcontribuyente;
            return $obj->getcontribuyente($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function envioemail($List) {
		try {
            $obj = new ctrlemail;
            return $obj->envioemail($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function gettcp($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettcp($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function GetUsers($List) {
		try {
            $obj = new ctrlusuario;
            return $obj->GetUsers($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function updateusrpassword($List) {
		try {
            $obj = new ctrlusuario;
            return $obj->updateusrpassword($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getcountuser($List) {
		try {
            $obj = new ctrlusuario;
            return $obj->getcountuser($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function gettipocontribuyente($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipocontribuyente($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function getfletesapdoc($List) {
		try {
            $obj = new ctrldocumento;
            return $obj->getfletesapdoc($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function marcaodeasap($List) {
		try {
            $obj = new ctrldocumento;
            return $obj->marcaodeasap($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function getfletesap($List) {
		try {
            $obj = new ctrlcotizacion;
            return $obj->getfletesap($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function anulaop($listoe) {
		try {
            $obj = new ctrlordenpick;
            return $obj->anulaop($listoe);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function anuladoc($listoe) {
		try {
            $obj = new ctrldocumento;
            return $obj->anuladoc($listoe);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function putdesarrollo($listoe) {
		try {
            $obj = new ctrldesarrollo;
            return $obj->putdirdesp($listoe);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getcambiosestadooe($listoe) {
		try {
            $obj = new ctrlcambiosestado;
            return $obj->getcambiosestadooe($listoe);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function infousuarioper($List,$usr) {
		try {
            $obj = new ctrlusuario;
            return $obj->infousuarioper($List,$usr);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    } 
	
	 public static function getcpu($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getcpu($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    } 

	public static function getdiscolog($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getdiscolog($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
	
	public static function getdiscobd($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getdiscobd($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function getmemoria($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getmemoria($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    } 

	public static function getapache($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getapache($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    } 

	public static function getmysql($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getmysql($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
	
	public static function checktablas($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->checktablas($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function repairtablas($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->repairtablas($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
	public static function getftp($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getftp($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function getcups($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getcups($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function getfct_bd($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getfct_bd($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function getfct_fs($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getfct_fs($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

   	public static function getfct_ftp($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getfct_ftp($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function getgde_bd($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getgde_bd($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function getgde_fs($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getgde_fs($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
	public static function getgde_ftp($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getgde_ftp($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
	public static function getncr_bd($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getncr_bd($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
	public static function getncr_fs($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getncr_fs($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
	public static function getncr_ftp($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getncr_ftp($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    public function getproducto($List){
		try {
            $obj = new ctrlproducto;
            return $obj->getproducto($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public function getproveedores($List){
		try {
            $obj = new ctrlproducto;
            return $obj->getproveedores($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public function getproductof($List){
		try {
            $obj = new ctrlproducto;
            return $obj->getproductof($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
 	public function getproductogrilla($List){
		try {
            $obj = new ctrlproducto;
            return $obj->getproductogrilla($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    public function getlocales($lista) {
		try {
            $obj = new ctrllocal;
            return $obj->getlocales($lista);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public function getcambiolocales($lista) {
		try {
            $obj = new ctrllocal;
            return $obj->getcambiolocales($lista);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }  
    
	public function getlocalessap($lista) {
		try {
            $obj = new ctrllocal;
            return $obj->getlocales($lista);
		}
		catch (Exception 	$e){return false;}
    } 
	
    public function getlocaleselect($lista) {
		try {
            $obj = new ctrllocal;
            return $obj->getlocaleselect($lista);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }    

    public function validaiplocal($List){
		try {
            $obj = new ctrllocal;
            return $obj->validaiplocal($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    } 
    
    public function getlocalselect($lista,$loc) {
		try {
            $obj = new ctrllocal;
            return $obj->getlocalselect($lista,$loc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }     
    
    public function getiplocal($lista){
		try {
            $obj = new ctrllocal;
            return $obj->getiplocal($lista);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getCliente($List) {
		try {
			$obj = new ctrlinfocliente;
			return $obj->getCliente($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}
	
	public static function getClienteRepor($List) {
		try {
			$obj = new ctrlinfocliente;
			return $obj->getClienteRepor($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}
	/*Metodo getdetalleimpuesto*/
	public static function getdetalleimpuesto($List, $id_coti, $grupoimp) {
		try{
			$obj = new ctrlinfocliente;
			return $obj->getdetalleimpuesto($List, $id_coti, $grupoimp);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}
	/*Fin getdetalleimpuesto*/
	/*Metodo getimpuestos*/
	public static function getimpuestos($List, $id_cotizacion) {
		try {
			$obj = new ctrlordenent;
			return $obj->getimpuestos($List, $id_cotizacion);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}
	/*Fin getdetalleimpuesto*/
	/*Obtener el tipo de Cliente*/
	public static function gettipojur($rut, $Listjur){
		try{
			$obj = new ctrlinfocliente;
			return $obj->gettipojur($rut, $Listjur);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}
	/*Obtener el tipo de Cliente*/
	public static function getMonitorCliente($List) {
		try {
			$obj = new ctrlinfocliente;
			return $obj->getMonitorCliente($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}
	
	/*Valida Usuario para reimpresion OP GD*/
	public static function usuariomodulovalido($Listusuariovalidoimp,$usuariolis,$clavelist,$idmodulo) {
		try {
            $obj = new ctrlusuario;
            return $obj->usuariomodulovalido($Listusuariovalidoimp,$usuariolis,$clavelist,$idmodulo);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
	/*Fin Valida Usuario para reimpresion OP GD*/

    /*Insercion y Validacion de Pago en WS */
    public static function putPagoOE($listoe, $listoegen, $caden3){
    	try{
    		
    	    $obj = new ctrlordenent;	
            return $obj->putPagoOE($listoe, $listoegen, $caden3);
    	}
        catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    /*Fin Insercion y Validacion de Pago en WS*/
    /*WS Validacion para Ingreso de Pago OE*/
public static function getPagoOE($arr){
    	
    	try{
//    		$i = 0;
//    			foreach($caden1 as $key=>$value){
//    				if($i == 0)
//    					$id_ordenent = $value;
//    				if($i == 1)
//    					$rut = $value;
//    				if($i == 2)
//    					$numfact = $value;
//    				$i++;
//    			}
    			$cont = sizeof($arr['mediopago']);
    			$i = 0;
    			foreach($arr['mediopago'] as $key2=>$value2){
    				foreach($value2 as $key3=>$value3){
    					$i++;
    					if($i == 1){
    						$numdocpago = $value3;	
    					}
    					
    					
    					
    					//$numdocpago = $value3;
	   					
	   					
    				}
    			}
    			
//    			foreach($caden4 as $key4=>$value4){
//    				if($i == 0)
//    					$tiva = $value4;
//    				if($i == 1)
//    					$riva = $value4;
//    				if($i == 2)
//    					$rica = $value4;
//    				if($i == 3)
//    					$rfuente = $value4;
//    				
//    			}
			
    		//general::writeevent("Arreglo ".implode($arr));	
    		
    		$id_ordenent = $arr['encabezado']['os'];
    		$rut		 = $arr['encabezado']['id'];
    		$numfact	 = $arr['encabezado']['numfactura'];
    		
    		$id_ordenent1 = substr($id_ordenent, 5, 7);
    		
    		$id_ordenent2 = ($id_ordenent1+0);  
    		
    		general::writeevent("Id Orden Entrega : ".$id_ordenent2);
    		
    		$tiva  = $arr['total']['iva'];
    		$riva  = $arr['total']['reteiva'];
    		$rica  = $arr['total']['reteica'];
    		$fuente= $arr['total']['retefuente'];

    		general::writelog("esta es la oe".$id_ordenent);
    		general::writelog("esta es la rut".$rut);
    		general::writelog("esta es la numfactura".$numfact);
    		general::writelog("esta es la tipopago".$numdocpago);
    		general::writelog("esta es la impuesto".$tiva);
    		
    		$caden3 = $arr['productos'];
    		
			$listagoe = new connlist($getoe = new dtoencordenent(array('id_ordenent'=> $id_ordenent2)));
			
			bizcve::getordenent($listagoe, $listagoed = new connlist);
			$listagoe->gofirst();
			
    		
    		$listaoe = new connlist($eldto = new dtopagooe(array('id_ordenent' => $id_ordenent2, 
													'id_tipodocpago' => $numdocpago,
													'numdocpago' => $numfact, 
													'id_tipoflujo' => /*$id_tipoflujo*/$listagoe->getelem()->id_tipoflujo,
													'id_direccion' => /*$id_direccion*/$listagoe->getelem()->id_direccion,
													'prioridadpick' => /*$prioridadpick*/$listagoe->getelem()->id_tipoentrega,
													)));
			if ($resp=bizcve::putPagoOE($listaoe, $listaop =  new connlist, $caden3))
		   		 general::inserta_tracking(null, $id_ordenent, null, null, 'Se ha dado curso (pago) a la Orden de Entrega');
		    
			if ($listaop) 
				$listaop->gofirst();
				$ListEncGe  = new connlist;
				$mRegistroGe=new dtoencordenpicking;
				$mRegistroGeOp=new dtoencordenpicking;
				$mRegistroGeDiv=new dtoencordenpicking;
				
			if ($listaop->numelem()==1) {
				//general::returnvalue('reload');
				//general::alertexit('Se ha generado la Orden de Picking Num. ' . $listaop->getelem()->id_ordenpicking);
				//general::writelog("Se ha generado la Orden de Picking Num.". $listaop->getelem()->id_ordenpicking);
				//verifico que la op generada contenga pedido especial generico
				$mRegistroGe->id_ordenpicking =$listaop->getelem()->id_ordenpicking;
				$ListEncGe->addlast($mRegistroGe);
				bizcve::getpedidoespecialgenerico($ListEncGe);
				$ListEncGe->gofirst();
				if($ListEncGe->getelem()->cantidad > 0){
					$ListEncGe->clearlist();
					$mRegistroGeOp->id_ordenpicking =$listaop->getelem()->id_ordenpicking;
					$mRegistroGeOp->id_estado ='ES';
					$ListEncGe->addlast($mRegistroGeOp);
					bizcve::setOpestadopegenerico($ListEncGe);
					//separamos los productos pedido especial de los productos normales
					$ListEncGe->clearlist();
					$mRegistroGeOp->id_ordenpicking =$listaop->getelem()->id_ordenpicking;
					$ListEncGe->addlast($mRegistroGeOp);
					bizcve::dividirpedidoespecial_pnormal($ListEncGe);
					$ListEncGe->gofirst();
					$nuvpicking=$ListEncGe->getelem()->id_ordenpicking;
					
				}
				//termina verificacion
				return 'Orden de Entrega Pagada, Se ha generado la Orden de Picking Num '.$listaop->getelem()->id_ordenpicking.'' .($nuvpicking?','.$nuvpicking:'');
			}
			elseif ($listaop->numelem()>1){
				$coma = ''; 
				do {
					$msglop .= $coma . $listaop->getelem()->id_ordenpicking;
					$coma = ', '; 
				} while ($listaop->gonext());
				
				$arrayOP=split(',',substr($msglop,0,-1));
				
				foreach($arrayOP as $key=>$valueOP){
					$mRegistroGe->id_ordenpicking =$valueOP;
					$ListEncGe->addlast($mRegistroGe);
					bizcve::getpedidoespecialgenerico($ListEncGe);
					$ListEncGe->gofirst();
					if($ListEncGe->getelem()->cantidad > 0){
					$ListEncGe->clearlist();
					$mRegistroGeOp->id_ordenpicking =$valueOP;
					$mRegistroGeOp->id_estado ='ES';
					$ListEncGe->addlast($mRegistroGeOp);
					bizcve::setOpestadopegenerico($ListEncGe);
					
					$ListEncGe->clearlist();
					$mRegistroGeOp->id_ordenpicking =$valueOP;
					$ListEncGe->addlast($mRegistroGeOp);
					bizcve::dividirpedidoespecial_pnormal($ListEncGe);
					$ListEncGe->gofirst();
					$nuvpicking=$nuvpicking .','.$ListEncGe->getelem()->id_ordenpicking;
					}					 
				}
				//general::returnvalue('reload');
				//general::alertexit("Se han generado las ordenes de Picking Num. $msglop");
				//general::writelog("Se han generado las ordenes de Picking Num. $msglop");
				return 'Orden de Entrega Pagada, Se han generado las ordenes de Picking Num.'.$msglop.''.($nuvpicking?','.$nuvpicking:'');
			}
			else {
				//general::returnvalue('reload');
				//general::alert('no genero pick');				
			}
			if($resp== 1){
				return 'Orden de Entrega Pagada';
			}else{
				return $resp;//general::alert('se genero la OE Completa');
			}
    	}
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    /* Fin WS Validacion para Ingreso de Pago OE*/
	public static function getdatosbasicos($List) {
		try {
			$obj = new ctrlinfocliente;
			return $obj->getdatosbasicos($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}
	
	public static function deliplocal($List) {
		try {
			$obj = new ctrllocal;
			return $obj->deliplocal($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}	
	
	public static function getciudad($List){
		
		try{
			$obj = new ctrltipos;
			return $obj->getciudad($List);
		}
	    catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}

	public static function getlocalizacion($List){
		
		try{
			$obj = new ctrllocalizacion;
			return $obj->getlocalizacion($List);
		}
	    catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}
	
	public static function getdepartamentos($List){
		
		try{
			$obj = new ctrltipos;
			return $obj->getdepartamentos($List);
		}
	    catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}
	
	public static function getcomuna($List, $opcionSeleccionada) {
		try {
            $obj = new ctrltipos;
            return $obj->getcomuna($List, $opcionSeleccionada);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getciudades($List, $opcionSeleccionada) {
		try {
            $obj = new ctrltipos;
            return $obj->getciudades($List, $opcionSeleccionada);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getbarrios($List, $opcionSeleccionada,$ciudad,$province) {
		try {
            $obj = new ctrltipos;
            return $obj->getbarrios($List, $opcionSeleccionada,$ciudad,$province);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

  	public static function putcliente($List) {
		try {
            $obj = new ctrlinfocliente;
            return $obj->putcliente($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function getmenu($username, $List) {
		try {
            $obj = new ctrlusuario;
            return $obj->getmenu($username, $List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }   

    public static function gettipousuario($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipousuario($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function gettipoventa($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipoventa($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function gettiporetiro($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettiporetiro($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function gettipopago($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipopago($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function gettipodocpago($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipodocpago($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function gettipodocpagosap($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipodocpago($List);
		}
		catch (Exception 	$e){return false;}
    }
    public static function gettipomovimiento($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipomovimiento($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function gettipomensaje($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipomensaje($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function gettipoflujo($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipoflujo($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function gettipoflujoreporte($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipoflujoreporte($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function gettipoflujossap($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipoflujo($List);
		}
		catch (Exception 	$e){return false;}
    }
    
    public static function gettipoentrega($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipoentrega($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function gettipodocumento($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipodocumento($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    public static function gettipodocumentoreporte($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipodocumentoreporte($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }    
    
    public static function getreportedocumentosall($List) {
		try {
            $obj = new ctrlreporte;
            return $obj->getreportedocumentosall($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }    
    
    public static function gettipocliente($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipocliente($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getrubro($List) {
		try {
            $obj = new ctrltipos;
            return $obj->getrubro($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getdocumento($ListEnc, $ListDet) {
		try {
            $obj = new ctrldocumento;
            return $obj->getdocumento($ListEnc, $ListDet);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getdocumentogud($ListDet) {
		try {
            $obj = new ctrldocumento;
            return $obj->getdocumentogud($ListDet);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getdocumentoasoc($List) {
		try {
            $obj = new ctrldocumento;
            return $obj->getdocumentoasoc($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	 public static function getdocumentonulo($List) {
		try {
            $obj = new ctrldocumento;
            return $obj->getdocumentonulo($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	 public static function gethoras_doc($List) {
		try {
            $obj = new ctrldocumento;
            return $obj->gethoras_doc($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
	
	public static function getdocumentocaduca($ListEnc, $ListDet) {
		try {
            $obj = new ctrldocumento;
            return $obj->getdocumento($ListEnc, $ListDet);
		}
		catch (Exception 	$e){return false;}
    }
    
	public static function getdocumentosap($ListEnc, $ListDet) {
		try {
            $obj = new ctrldocumento;
            return $obj->getdocumentosap($ListEnc, $ListDet);
		}
		catch (Exception 	$e){return false;}
		
    }
    public static function getdocumentosap2($ListEnc, $ListDet) {
		try {
            $obj = new ctrldocumento;
            return $obj->getdocumento($ListEnc, $ListDet);
		}
		catch (Exception 	$e){return false;}
		
    }
    
    public static function existemodulouser($username, $modulo) {
		try {
            $obj = new ctrlusuario;
            return $obj->existemodulouser($username, $modulo);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function usuariovalido($username, $passmd5) {
		try {
            $obj = new ctrlusuario;
            return $obj->usuariovalido($username, $passmd5);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function ipusuariovalida($idusuario, $ip) {
		try {
            $obj = new ctrlusuario;
            return $obj->ipusuariovalida($idusuario, $ip);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getTipoUsuarioCotiza($idusuario) {
		try {
            $obj = new ctrlusuario;
            return $obj->getTipoUsuarioCotiza($idusuario);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getglobals($List) {
		try {
            $obj = new ctrltipos;
            return $obj->getglobals($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getcotizacion($ListEnc, $ListDet) {
		try {
            $obj = new ctrlcotizacion;
            return $obj->getcotizacion($ListEnc, $ListDet);
		}
    	
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getcotizacionestado($ListEnc) {
		try {
            $obj = new ctrlcotizacion;
            return $obj->getcotizacionestado($ListEnc);
		}
    	
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getcountcotizacion($ListEnc) {
		try {
            $obj = new ctrlcotizacion;
            return $obj->getcountcotizacion($ListEnc);
		}
    	
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getdetcotizacioncountpegenerico($ListEnc) {
		try {
            $obj = new ctrlcotizacion;
            return $obj->getdetcotizacioncountpegenerico($ListEnc);
		}
    	
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getdetcotizacionsumimp($ListDet) {
		try {
            $obj = new ctrlcotizacion;
            return $obj->getdetcotizacionsumimp($ListDet);
		}
    	//suma de los impuestos para insert de los fletes
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getdetoerdenentregasumimp($ListDet) {
		try {
            $obj = new ctrlordenent;
            return $obj->getdetoerdenentregasumimp($ListDet);
		}
    	//suma de los impuestos para insert de los fletes
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getMonitorcotizacion($ListEnc, $ListDet) {
		try {
            $obj = new ctrlcotizacion;
            return $obj->getMonitorcotizacion($ListEnc, $ListDet);
		}
    	
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getcotizacioncaduca($ListEnc, $ListDet) {
		try {
            $obj = new ctrlcotizacion;
            return $obj->getcotizacion($ListEnc, $ListDet);
		}
		catch (Exception 	$e){return false;}
	}
	
	public static function getmodulo($List) {
		try {
            $obj = new ctrldesarrollo;
            return $obj->getmodulo($List);
		}
		catch (Exception 	$e){return false;}
	}

    public static function putcotizacion($ListEnc, $ListDet) {
		try {
            $obj = new ctrlcotizacion; 
            return $obj->putcotizacion($ListEnc, $ListDet);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function cambioestadocotizacion($ListEnc) {
		try {
            $obj = new ctrlcotizacion; 
            return $obj->cambioestadocotizacion($ListEnc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function cotizaciones_vencidas($ListEnc) {
		try {
            $obj = new ctrlcotizacion; 
            return $obj->cotizaciones_vencidas($ListEnc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function dupcotizacion($ListEnc) {
		try {
            $obj = new ctrlcotizacion;
            return $obj->dupcotizacion($ListEnc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function dupcotizacioncaducada($ListEnc) {
		try {
            $obj = new ctrlcotizacion;
            return $obj->dupcotizacioncaducada($ListEnc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function gencotizacionremnve($ListEnc) {
		try {
            $obj = new ctrlcotizacion;
            return $obj->gencotizacionremnve($ListEnc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function gennve($ListEnc) {
		try {
            $obj = new ctrlcotizacion;
            return $obj->gennve($ListEnc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function getdirdesp($List) {
		try {
            $obj = new ctrlinfocliente;
            return $obj->getdirdesp($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function wscrearcliente($List) {
		try {
            $obj = new ctrlinfocliente;
            return $obj->wscrearcliente($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    } 
    
    public static function wsupdatecliente($List) {
		try {
            $obj = new ctrlinfocliente;
            return $obj->wsupdatecliente($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    } 
    
    public static function wsbuscarcliente($List) {
		try {
            $obj = new ctrlinfocliente;
            return $obj->wsbuscarcliente($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    } 
    
    public static function getdirdespicking($List) {
		try {
            $obj = new ctrlinfocliente;
            return $obj->getdirdespicking($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }   

    public static function putdirdesp($List) {
    	try {
	        $obj = new ctrlinfocliente;
	        return $obj->putdirdesp($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function deldirdesp($List) {
		try {
            $obj = new ctrlinfocliente;
            return $obj->deldirdesp($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }    
    
    public static function getordenent($ListEnc, $ListDet) {
		try {
            $obj = new ctrlordenent;
            return $obj->getordenent($ListEnc, $ListDet);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    /*Extraer info fer la Orden de Entrega*/
    public static function getinfoop($List, $opcion){
    	try{
    		$obj = new ctrlordenent;
    		return $obj->getinfoop($List, $opcion);
    	}
        catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }/*fin orden de entrega*/
    
	public static function updatemensajeglo($List, $opcion ,$contenido){
    	try{
    		$obj = new ctrlordenent;
    		return $obj->updatemensajeglo($List, $opcion ,$contenido);
    	}
        catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getMonitorordenent($ListEnc, $ListDet) {
		try {
            $obj = new ctrlordenent;
            return $obj->getMonitorordenent($ListEnc, $ListDet);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function reportecompraspendientes($ListEnc, $ListDet) {
		try {
            $obj = new ctrlordenent;
            return $obj->reportecompraspendientes($ListEnc, $ListDet);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function reportecompraspendientespe($ListEnc, $ListDet) {
		try {
            $obj = new ctrlordenent;
            return $obj->reportecompraspendientespe($ListEnc, $ListDet);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getFlujo($ListEnc, $ListDet) {
		try {
            $obj = new ctrlordenent;
            return $obj->getFlujo($ListEnc, $ListDet);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getordenentcaduca($ListEnc, $ListDet) {
		try {
            $obj = new ctrlordenent;
            return $obj->getordenent($ListEnc, $ListDet);
		}
		catch (Exception 	$e){return false;}
    }
    public static function getordenentsap($ListEnc, $ListDet) {
		try {
            $obj = new ctrlordenent;
            return $obj->getordenentsap($ListEnc, $ListDet);
		}
		catch (Exception 	$e){return false;}
    }
 	
    public static function getordenentsapflujo5($ListEnc, $ListDet) {
		try {
            $obj = new ctrlordenent;
            return $obj->getordenentsapflujo5($ListEnc, $ListDet);
		}
		catch (Exception 	$e){return false;}
    }
    
  
    public static function gettracking($List) {
		try {
            $obj = new ctrltracking;
            return $obj->gettracking($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	} 
	
    public static function puttracking($List) {
		try {
            $obj = new ctrltracking;
            return $obj->puttracking($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}	

    public static function getcambiosestado($List) {
		try {
            $obj = new ctrlcambiosestado;
            return $obj->getcambiosestado($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}	
	
	    public static function getestado($List) {
		try {
            $obj = new ctrlestado;
            return $obj->getestados($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}
	
	public static function getestadodocumento($List) {
		try {
            $obj = new ctrlestado;
            return $obj->getestadosdocumento($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}	
	
    public static function getestados($List) {
		try {
            $obj = new ctrlestado;
            return $obj->getestados($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    	
    public static function cambiosestado($List) {
    	try {
            $obj = new ctrlcambiosestado;
            return $obj->cambiosestado($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}
	
	public static function cambiosestadocot($List) {
    	try {
            $obj = new ctrlcambiosestado;
            return $obj->cambiosestadocot($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}
	
    public static function cambiosestadordenent($List) {
    	try {
            $obj = new ctrlcambiosestado;
            return $obj->cambiosestadordenent($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}	
    
    public static function cambioordenent($List) {
    	try {
            $obj = new ctrlcambiosestado;
            return $obj->cambioordenent($List);
		}
		catch (Exception 	$e){return false;}
	}
    
    public static function delcotizacionall($List) {
		try {
            $obj = new ctrlcotizacion;
            return $obj->delcotizacionall($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}

     /*Eliminar Flete de la Cotizacion*/
     public static function delcotizacionf($idcotizacion) {
		try {
            $obj = new ctrlcotizacion;
            return $obj->delcotizacionf($idcotizacion);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}
	/*Fin Eliminar Flete de Cotizacion*/
	
	public static function cuontcotizacionf($List) {
		try {
            $obj = new ctrlcotizacion;
            return $obj->cuontcotizacionf($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}

    public static function getdisponible($List) {
		try {
            $obj = new ctrlinfocliente;
            return  $obj->getdisponible($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }	
    
   
    public static function saveiplocal($ListEnc) {
		try {
            $obj = new ctrllocal;
            return $obj->saveiplocal($ListEnc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function insertiplocal($ListEnc) {
		try {
            $obj = new ctrllocal;
            return $obj->insertiplocal($ListEnc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function getDatosFlete($Listf){
    	try{
    		$obj = new ctrlflete;
    		return $obj->getDatosFlete($Listf);	
    	}
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;} 
    }
    
    public static function generaordenent($listnve, $listpcant, $listoegen, $fecha_rc, $fecha_ei, $fecha_dp) {
		try {
            $obj = new ctrlordenent;
            return $obj->generaordenent($listnve, $listpcant, $listoegen, $fecha_rc, $fecha_ei, $fecha_dp);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function oe_divi_producospos($list) {
		try {
            $obj = new ctrlordenent;
            return $obj->oe_divi_producospos($list);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }  

    public static function generadocumento($listoe, $listpcant, $listdocgen) {
		try {
            $obj = new ctrldocumento;
            return $obj->generadocumento($listoe, $listpcant, $listdocgen);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }    

    public static function autorizaroe($listoe) {
		try {
            $obj = new ctrlordenent;
            return $obj->autorizaroe($listoe);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }    

    public static function rechazaroe($listoe) {
		try {
            $obj = new ctrlordenent;
            return $obj->rechazaroe($listoe);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }    

    public static function anularoe($listoe) {
		try {
            $obj = new ctrlordenent;
            return $obj->anularoe($listoe);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function cambioindicadorsap($listoe) {
		try {
            $obj = new ctrlordenent;
            return $obj->cambioindicadorsap($listoe);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function cerrarpicking($listop, $listpcant, $listopgen) {
		try {
            $obj = new ctrlordenpick;
            return $obj->cerrarpicking($listop, $listpcant, $listopgen);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getordenpick($ListEnc, $ListDet) {
		try {
            $obj = new ctrlordenpick;
            return $obj->getordenpick($ListEnc, $ListDet);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getpedidoespecialgenerico($ListEnc) {
		try {
            $obj = new ctrlordenpick;
            return $obj->getpedidoespecialgenerico($ListEnc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function setOpestadopegenerico($ListEnc) {
		try {
            $obj = new ctrlordenpick;
            return $obj->setOpestadopegenerico($ListEnc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getcountenespera($ListEnc) {
		try {
            $obj = new ctrlordenpick;
            return $obj->getcountenespera($ListEnc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function dividirpedidoespecial_pnormal($ListEnc) {
		try {
            $obj = new ctrlordenpick;
            return $obj->dividirpedidoespecial_pnormal($ListEnc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function guardarhistoria ($ListEnc, $ListDet) {
		try {
            $obj = new ctrlordenpick;
            return $obj->guardarhistoria($ListEnc, $ListDet);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function addimpresionordenpicking($ListEnc) {
		try {
            $obj = new ctrlordenpick;
            return $obj->addimpresionordenpicking($ListEnc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    
    public static function getMonitorordenpick($ListEnc, $ListDet) {
		try {
            $obj = new ctrlordenpick;
            return $obj->getMonitorordenpick($ListEnc, $ListDet);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getordenpickcaduca($ListEnc, $ListDet) {
		try {
            $obj = new ctrlordenpick;
            return $obj->getordenpick($ListEnc, $ListDet);
		}
		catch (Exception 	$e){return false;}
		
    }
    public static function caducacotizacion($List) {
		try {
            $obj = new ctrlcotizacion;
            return $obj->caducacotizacion($List);
		}
		catch (Exception 	$e){return false;}
    }

	public function ActualizaCantNVEOE($listoedet, $operacion){
		try {
            $obj = new ctrlcotizacion;
            return $obj->ActualizaCantNVEOE($listoedet, $operacion);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}

    public function genpedidoventasap($List){
		try {
            $obj = new ctrlordenent;
            return $obj->genpedidoventasap($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public function genfacturasap($List){
		try {
            $obj = new ctrldocumento;
            return $obj->genfacturasap($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public function genguiadespachosap($List){
		try {
            $obj = new ctrldocumento;
            return $obj->genguiadespachosap($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public function getdocumentoprn($ListEnc) {
		try {
            $obj = new ctrldocumento;
            return $obj->getdocumentoprn($ListEnc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public function getdocumentoview($ListEnc) {
		try {
            $obj = new ctrldocumento;
            return $obj->getdocumentoview($ListEnc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function marcardocimpreso($ListDoc) {
		try {
            $obj = new ctrldocumento;
            return $obj->marcardocimpreso($ListDoc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function marcatodosdocimpreso($ListDoc) {
		try {
            $obj = new ctrldocumento;
            return $obj->marcatodosdocimpreso($ListDoc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    /*Marca numero de Reimpresiones Guia de Despacho*/
	public static function marcareimpresion($sum, $docu) {
		try {
            $obj = new ctrldocumento;
            return $obj->marcareimpresion($sum, $docu);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    /* Fin Marca numero de Reimpresiones Guia de Despacho*/
    
    public static function grabaimpresorausuario($Impresoraf = null, $Impresorag = null) {
		try {
            $obj = new ctrlusuario;
            return $obj->grabaimpresorausuario($Impresoraf, $Impresorag);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function desbloqueadocprint($ListDoc){
		try {
            $obj = new ctrldocumento;
            return $obj->desbloqueadocprint($ListDoc);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
  
	public static function putclientesap($ListClientesap){
		try{
	        $obj = new ctrlinfocliente;
            return $obj->putclientesap($ListClientesap);
		}
		catch (Exception 	$e){return false;}
		
    }

    public static function putdocumento($ListEnc, $ListDet) {
		try {
            $obj = new ctrldocumento;
            return $obj->putdocumento($ListEnc, $ListDet);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    /*Insertar Cod EAN*/
    public static function putean($cod_barra_os, $cod_ordenente){
    	try {
        	    $obj = new ctrlordenent;
            	return $obj->putean($cod_barra_os, $cod_ordenente);
			}
			catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
			catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
			catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    /*Fin Insertar Cod EAN*/
    
    
    public static function putdocumentosap($ListEnc, $ListDet) {
		try {
            $obj = new ctrldocumento;
            return $obj->putdocumentosap($ListEnc, $ListDet);
		}
		catch (Exception 	$e){return false;}
		
    }

    public static function marcasapdisponible($List) {
		try {
            $obj = new ctrlinfocliente;
            return $obj->marcasapdisponible($List);
		}
		catch (Exception 	$e){return false;}
    }
    
    public static function putordenpicking($ListEnc, $ListDet) {
		try {
            $obj = new ctrlordenpick;
            return $obj->putordenpicking($ListEnc, $ListDet);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    public static function getgiro($List) {
		try {
            $obj = new ctrltipos;
            return $obj->getgiro($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
   
    public function gettipoconpago($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipoconpago($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getcomunad($List) {
		try {
            $obj = new ctrltipos;
            return $obj->getcomunad($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    
	public static function getdetordenent($List) {
		try {
            $obj = new ctrlordenent;
            return $obj->getdetordenent($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    } 
    
    public static function getclasificacionmensaje($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getclasificacionmensaje($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    } 
    
    public static function getmensajeeditor($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->getmensajeeditor($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function financiacion_interes_ncheques($List) {
		try {
            $obj = new ctrloperaciones;
            return $obj->financiacion_interes_ncheques($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    } 
    
    public static function savedetordenescomprapendientes($idline,$ncompra,$idoe) {
		try {
			
            $obj = new ctrlordenent;
            return $obj->savedetordenescomprapendientes($idline,$ncompra,$idoe);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    } 

    public static function getdetordenentpespecial($List) {
		try {
            $obj = new ctrlordenent;
            return $obj->getdetordenentpespecial($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }  

	public static function gettipopagoid($List) {
		try {
            $obj = new ctrltipos;
            return $obj->gettipopagoid($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function getconpago($List) {
		try {
            $obj = new ctrltipos;
            return $obj->getconpago($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }    
    
    public static function getdocpago($List) {
		try {
            $obj = new ctrltipos;
            return $obj->getdocpago($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }     
    
	public static function getdetordenpick($List) {
		try {
            $obj = new ctrlordenpick;
            return $obj->getdetordenpick($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    } 
    
    public static function getprioridad($List) {
		try {
            $obj = new ctrltipos;
            return $obj->getprioridad($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getultimofolio($List) {
		try {
            $obj = new ctrldocumento;
            return $obj->getultimofolio($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function savefolio($List) {
		try {
            $obj = new ctrldocumento;
            return $obj->savefolio($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function savelocal($List) {
		try {
            $obj = new ctrllocal;
            return $obj->savelocal($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

		public static function updatelocal($List) {
		try {
            $obj = new ctrllocal;
            return $obj->updatelocal($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function incrementafct($List) {
		try {
            $obj = new ctrldocumento;
            return $obj->incrementafct($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function incrementagde($List) {
		try {
            $obj = new ctrldocumento;
            return $obj->incrementagde($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getplista($List) {
		try {
            $obj = new ctrlproducto;
            return $obj->getplista($List);

		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function getprovpreferencial($List) {
		try {
            $obj = new ctrlproducto;
            return $obj->getprovpreferencial($List);

		}
		
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getproductoxproveedor($List) {
		try {
            $obj = new ctrlproducto;
            return $obj->getproductoxproveedor($List);

		}
		
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getproductoxdatosproveedor($List) {
		try {
            $obj = new ctrlproducto;
            return $obj->getproductoxdatosproveedor($List);

		}
		
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getdetcomprapendiente($List) {
		try {
            $obj = new ctrlordenent;
            return $obj->getdetcomprapendiente($List);

		}
		
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function limpiatabla($List) {
		try {
            $obj = new ctrlproducto;
            return $obj->limpiatabla($List);

		}
		
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getnivel4($List) {
		try {
            $obj = new ctrlproducto;
            return $obj->getnivel4($List);

		}
		
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function putnivel4($List) {
		try {
            $obj = new ctrlproducto;
            return $obj->putnivel4($List);

		}
		
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function getnivel3($List) {
		try {
            $obj = new ctrlproducto;
            return $obj->getnivel3($List);

		}
		
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function putnivel3($List) {
		try {
            $obj = new ctrlproducto;
            return $obj->putnivel3($List);

		}
		
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function getnivel2($List) {
		try {
            $obj = new ctrlproducto;
            return $obj->getnivel2($List);

		}
		
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function getnivel1($List) {
		try {
            $obj = new ctrlproducto;
            return $obj->getnivel1($List);

		}
		
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function getpadre3($List) {
		try {
            $obj = new ctrlproducto;
            return $obj->getpadre3($List);

		}
		
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function getpadre2($List) {
		try {
            $obj = new ctrlproducto;
            return $obj->getpadre2($List);

		}
		
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

	public static function putnivel2($List) {
		try {
            $obj = new ctrlproducto;
            return $obj->putnivel2($List);

		}
		
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function putnivel1($List) {
		try {
            $obj = new ctrlproducto;
            return $obj->putnivel1($List);

		}
		
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function verificafoliofct($List) {
		try {
            $obj = new ctrldocumento;
            return $obj->verificafoliofct($List);
		}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function verificafoliogde($List) {
		try {
            $obj = new ctrldocumento;
            return $obj->verificafoliogde($List);
		}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getRegistro($List) {
		try {
            $obj = new ctrlinfocliente;
            return $obj->getRegistro($List);
		}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function getreportecuadratura($List) {
		try {
            $obj = new ctrlreporte;
            return $obj->getreportecuadratura($List);
		}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getreportevendedor($List) {
		try {
            $obj = new ctrlreporte;
            return $obj->getreportevendedor($List);
		}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getreportemargen($List) {
		try {
            $obj = new ctrlreporte;
            return $obj->getreportemargen($List);
		}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getreportedesbloqueos($List) {
		try {
            $obj = new ctrlreporte;
            return $obj->getreportedesbloqueos($List);
		}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getreporteoeblo($List) {
		try {
            $obj = new ctrlreporte;
            return $obj->getreporteoeblo($List);
		}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getreportegde($List) {
		try {
            $obj = new ctrlreporte;
            return $obj->getreportegde($List);
		}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getreportecotizacion($List) {
		try {
            $obj = new ctrlreporte;
            return $obj->getreportecotizacion($List);
		}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getreportecliente($List) {
		try {
            $obj = new ctrlreporte;
            return $obj->getreportecliente($List);
		}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getventascliente($List) {
		try {
            $obj = new ctrlreporte;
            return $obj->getventascliente($List);
		}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function getventascliente_margen($List) {
		try {
            $obj = new ctrlreporte;
            return $obj->getventascliente_margen($List);
		}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    public static function getreportefacturas($List) {
		try {
            $obj = new ctrlreporte;
            return $obj->getreportefacturas($List);
		}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
	public static function getreportedetalleventas($List) {
		try {
            $obj = new ctrlreporte;
            return $obj->getreportedetalleventas($List);
		}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
	
	public static function delrutsap($List) {
		try {
            $obj = new ctrlinfocliente;
            return $obj->delrutsap($List);
		}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function getgrupo($List) {
    try {
            $obj = new ctrltipos;
            return $obj->getgrupo($List);
		}
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    public static function getMonitorpromocion($List) {
		try {
            $obj = new ctrlpromocion;
            return $obj->getMonitorpromocion($List);
		}
    	
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

public static function getGrupoDet($List) {
		try {
            $obj = new ctrlpromocion;
            return $obj->getGrupoDet($List);
		}
    	
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function insertgrupo($List) {
		try {
            $obj = new ctrlpromocion;
            return $obj->insertgrupo($List);
		}
    	
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    
	public static function insertpromo($List) {
		try {
            $obj = new ctrlpromocion;
            return $obj->insertpromo($List);
		}
    	
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    
	public static function deletcp($List) {
		try {
            $obj = new ctrlpromocion;
            return $obj->deletcp($List);
		}
    	
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
	public static function insertcp($List) {
		try {
            $obj = new ctrlpromocion;
            return $obj->insertcp($List);
		}
    	
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
public static function deletgrupo($List) {
		try {
            $obj = new ctrlpromocion;
            return $obj->deletgrupo($List);
		}
    	
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
    
    
	public static function deletpromo($List) {
		try {
            $obj = new ctrlpromocion;
            return $obj->deletpromo($List);
		}
    	
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }	

	public static function getsubrubro($List) {
		try {
            $obj = new ctrlpromocion;
            return $obj->getsubrubro($List);
		}
    	
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }
	public static function getrubrosubrubro($List) {
		try {
            $obj = new ctrlpromocion;
            return $obj->getrubrosubrubro($List);
		}
    	
		catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
    }

    



    
    
}
?>
