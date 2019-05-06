<?php

///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../nuevacotizacion/nueva_cotizacion_00.php';
//session_start();
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
require_once('../wsClientUnique/ClientUnique.php');
///////////////////////// ZONA DE ACCIONES /////////////////////////
$configti = new getidcontribuyente("CONTRIBUYENTE");
$opcion=$configti->NATURAL;
$opcion1=$configti->JURIDICO;
$opcion2=$configti->EMPRESARIAL;
$opcion3=$configti->SOCIOE;
//se valida la existencia del cliente en el Web Service 
$confimp = new getrespuestaws("RESPUESTAWS");
$configbuscarcunico=$confimp->RESPUESTABUSCARCU;
//file_put_contents('configbuscarcunico.txt', $configbuscarcunico);

$response = ClientUnique::searchById($_GET['rut']);
file_put_contents('responseClientUnique.txt', $response);
if($response){
	//echo $response [State];
	if($response [State]==$configbuscarcunico)
	{
		$List = new connlist;
		$ListCli = new dtoinfocliente;
		$ListCli->rut=$_GET['rut'];
		$ListCli->id_comuna=$response [Location];
		$ListCli->id_rubro='';
		$ListCli->id_tipocliente=2;
		$ListCli->id_tipodocpago=2;
		//$ListCli->id_giro=$response [Occupation];
		//$ListCli->id_giro='C001';
		$obj = new daoinfocliente;
		$ListCliVen = new connlist;
		$ListCliReg = new dtoinfocliente;
		$ListCliReg->rut=$_GET['rut'];
		$ListCliVen->addlast($ListCliReg);
    	
		if (!$obj->existecliente($ListCliVen)) {
        $codigo_de_vendedor=bizcve::get_codigo_vendedor_para_cliente_nuevo();            
    		$ListCli->codigovendedor=$codigo_de_vendedor;   
    	}
		
    	$ListCli->giro='';
		
		// 8 Socio Experto (8-1, 8-4, 8-10, 8-11, 8-14, 8-15) 5 Empresa
		$flag_socio = false;
		for ($i=0; $i<=$response[MaxIdTypeCustomer]; $i++) {
			if ($response[$i][IdTypeCustomer] == 8) {		
				$flag_socio = true;
			}
		}
    	
		if ($flag_socio) {
			$ListCli->razonsoc = trim($response[FirstName]).' '.trim($response[Surname1]).' '.trim($response[Surname2]);
			$ListCli->contacto = $response[FirstName];
			$ListCli->apellido = $response[Surname1];
			$ListCli->apellido1 = $response[Surname2];
		}
		else {
			$aux = explode(" ", $response[Contact]);
			$datoscontacto = array();
			
			while ($aux) {
				$data = array_shift($aux);
				if(trim($data) != "") {
					$datoscontacto[] = trim($data);
				}
			}
			
			$contacto = "";
			for ($i=2; $i<count($datoscontacto); $i++) {
				if ($contacto != "") {
					$contacto .= " ";
				}
				$contacto .= $datoscontacto[$i];
			}
			
			$ListCli->apellido = $datoscontacto[0];
			$ListCli->apellido1 = $datoscontacto[1];
			$ListCli->contacto = $contacto;
			$ListCli->razonsoc = $response[FirstName];
		}
		
		$ListCli->fonocontacto=$response [Phone];
		$ListCli->email=$response [Email];
		$ListCli->direccion=$response [Address];
		$ListCli->locksap=0;
		$ListCli->lockmoro=0;
		$ListCli->lockcve=0;
		$ListCli->valdisp='';
		$ListCli->codclisap=$response [State];
		$ListCli->comentario='';
	
		if($List->getelem()->id_contribuyente == $opcion2){
			$ListCli->codlocaluco=TIENDA_VIRTUAL_ID;
		}
		else{
			$ListUsrSesion = new connlist;
			$DUser = new dtousuario;
			$DUser->usr_id =$ses_usr_id;
			$ListUsrSesion->addlast($DUser); 
			bizcve::GetUsers($ListUsrSesion);
			$ListUsrSesion->gofirst();
			$ListCli->codlocaluco=$ListUsrSesion->getelem()->cod_local;
		}
	
		$ListCli->id_clientepref=2;
		(($response [ReteIca]=='true')?$rete_ica=1:$rete_ica="'0'");
		$ListCli->rete_ica=$rete_ica;
		(($response [ReteIva]=='true')?$rete_iva=1:$rete_iva="'0'");
		$ListCli->rete_iva=$rete_iva;
		(($response [ReteFuente]=='true')?$rete_renta=1:$rete_renta="'0'");
		$ListCli->rete_renta=$rete_renta;
	
		$tipo_cliente_CVE=false;
		
		$Listgroup  = new connlist;
		bizcve::getcu_group($Listgroup);
		$Listgroup->gofirst();
		if (!$Listgroup->isvoid()){
			do {
				
				if($response [IdGroup]==$Listgroup->getelem()->id_group){
					
					$Listgroup_id_contribuyente  = new connlist;
					$dtogroup_id_contribuyente = new dtotipocontribuyente;
					$dtogroup_id_contribuyente->admitido=true;
					$Listgroup_id_contribuyente->addlast($dtogroup_id_contribuyente);
					
					bizcve::gettb_tipocontribuyente($Listgroup_id_contribuyente);
					if($Listgroup_id_contribuyente->numelem() > 0){
						
						for($i =0;  $i<= $response[MaxIdTypeCustomer]; $i++){
							$Listgroup_id_contribuyente->gofirst();
							
							for($ic=0; $ic<$Listgroup_id_contribuyente->numelem(); $ic++){
								general::writeevent("grupos tipos consulta".$Listgroup_id_contribuyente->getelem()->id_contribuyente);
								if($response [$i][IdTypeCustomer]==$Listgroup_id_contribuyente->getelem()->id_contribuyente)
								{
									$ListCli->id_contribuyente=$response [$i][IdTypeCustomer];
									$tipo_cliente_CVE = true;
									break;		
								}
								$Listgroup_id_contribuyente->gonext();
							}
							
							if($tipo_cliente_CVE){
								break;
							}
						}
					}
				}
				if($tipo_cliente_CVE){
					break;
				}
			} while ($Listgroup->gonext());
		}
	
		$ListCli->id_documento_identidad=$response [IdDoc];
		$ListCli->id_clasificacion_cli=$response [IdCategory];
		$ListCli->celcontactoe=$response [Phone2];
		$ListCli->fax=$response [Fax];
		$ListCli->accionupdate ='updatecli';
		$ListCli->id_regimencontri=$response [IdTypeContribuyente];
		$ListCli->genero=$response [Gender];
		$ListCli->id_profesion=$response [Profession];//ingresar validacion debe ser numerico.
		$List->addlast($ListCli);
			
		if($tipo_cliente_CVE == false){ 
			header("Location: nueva_cotizacion_00.php?error=3");
			exit;
		}
		else{
			if (!bizcve::putcliente($List))
				$mensaje_error = 'Problemas al grabar el cliente. Contactese con el administrador';
			
				general::writeevent('Se han guardado los  datos del cliente en cve, consultados desde cliente unico');
				
				header("Location: nueva_cotizacion_01.php?rut=".$_GET['rut']."&tipocliente=".$_GET['tipocliente']."&crearxmlcrearcliente=0");
				exit;		
		}
	}
	else
	{  	
		/*header("Location: nueva_cotizacion_01.php?rut=".$_GET['rut']."&tipocliente=".$_GET['tipocliente']."&crearxmlcrearcliente=1");*/
		general::writeevent('respuesta del ESB Cliente Unico '.$response [desc]);
		header("Location: nueva_cotizacion_00.php?error=5&msgws=".$response [desc]);
		exit;
	}
}
else
{
	general::writelog('El WS ClientUnique,searchById no se encuentra disponible para consultar datos del cliente');
	header("Location: nueva_cotizacion_00.php?error=6");
	return;
}
?>