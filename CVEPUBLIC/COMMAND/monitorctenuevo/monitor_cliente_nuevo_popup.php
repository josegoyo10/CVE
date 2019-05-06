<?
///////////////////////// ZONA DE INCLUSION /////////////////////////
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////
$configclitipo = new getidcontribuyente("CONTRIBUYENTE");
$opcion=$configclitipo->JURIDICO;
$opcion1=$configclitipo->EMPRESARIAL;
if ($accionmod == 'grabarmod') {

	$List = new connlist;
	$iClientes = new dtoinfocliente;
	$iClientes->rut=$_POST['rut'];
	$iClientes->codigovendedor =$_POST['select_vendedores'];


	$List->addlast($iClientes);
	if (!bizcve::putCliente($List))
		$mensaje_error = 'Problemas al modificar el vendedor. Cont?ctese con el administrador';
	else {
		general::writeevent('Se ha modificado la asignacion de vendedor al cliente con el rut '.$_POST['rut'].'. El codigo del nuevo vendedor es: '.$_POST['select_vendedores'].', y el nombre del vendedor es: '.$_REQUEST['nomvendedor'].'.');
		?>
		<script>
		window.returnValue='reload';
		window.close();
		</script>
		<?
		exit();
	}

}
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
/**/
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);
$MiTemplate->set_var('error_app', $mensaje_error);
$MiTemplate->set_file("main", TEMPLATE . "monitorctenuevo/monitor_cliente_nuevo_popup.htm");
/**/
/*Despliegue Resumen Cliente*/
$List = new connlist;
$mRegistro = new dtoinfocliente;
$mRegistro->rut=$_GET['rut'];
$List->addlast($mRegistro);
bizcve::getcliente($List);
$List->gofirst();
$MiTemplate->set_block('main' , "infocliente" , "BLO_infocliente");
if (!$List->isvoid()) {
	$MiTemplate->set_var('nomtipcliente', $List->getelem()->nomtipcliente);			
	$MiTemplate->set_var('comentario', $List->getelem()->comentario);			
	$MiTemplate->set_var('rut',$List->getelem()->rut);
	$MiTemplate->set_var('rutdv',(($List->getelem()->id_contribuyente == $opcion1)?$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut) : $List->getelem()->rut ));
	$MiTemplate->set_var('dcrazonsoc', $List->getelem()->razonsoc);
	$MiTemplate->set_var('dcfonocontacto', $List->getelem()->fonocontacto);
	$MiTemplate->set_var('dcnomciudade', $List->getelem()->nomciudad);
	$MiTemplate->set_var('dcdireccion', $List->getelem()->direccion);
	$MiTemplate->set_var('dcid_ciudad', $List->getelem()->id_ciudad);
	$MiTemplate->set_var('dcnomrubro', $List->getelem()->nomrubro);
	$MiTemplate->set_var('dcdescripcion', $List->getelem()->giro);
	$codvencli=$List->getelem()->codigovendedor;
	$Listlocalizacion  = new connlist;
	$registrolocalizacion->id_localizacion=$List->getelem()->id_comuna;
	$Listlocalizacion->addlast($registrolocalizacion);
	bizcve::getlocalizacion($Listlocalizacion);
	$Listlocalizacion->gofirst();
	if (!$Listlocalizacion->isvoid()) {
		do {
		$localiciu=$Listlocalizacion->getelem()->ciudad;
		$localibar=$Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad;
		$localidep=$Listlocalizacion->getelem()->departamento;
		$MiTemplate->set_var('dcciudad', $Listlocalizacion->getelem()->ciudad);
		$MiTemplate->set_var('dcnomcomuna', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
		$MiTemplate->set_var('dcdepartamento', $Listlocalizacion->getelem()->departamento);
		
		} while ($Listlocalizacion->gonext());
	}
	
	$MiTemplate->parse("BLO_infocliente", "infocliente", true);
}
/*Fin Despliegue Resumen Cliente*/
/*Despliegue Seleccion Vendedor*/ 
$List = new connlist;
$mRegistro= new dtousuario;
$mRegistro->usr_tipo='VE';
$mRegistro->id_tipousuario='1,2';
$List->addlast($mRegistro);
bizcve::GetUsers($List);
$List->gofirst();
$MiTemplate->set_block('main' , "vendedores" , "BLO_vendedores");
if (!$List->isvoid()) {
	$MiTemplate->set_var('selectedt', ($codvencli == 0)?'selected':'');
	do {
		$MiTemplate->set_var('codigovendedor',$List->getelem()->codigovendedor);
		$MiTemplate->set_var('nomvendedor',$List->getelem()->usr_nombres." ".$List->getelem()->usr_apellidos." (".($List->getelem()->cod_local?$List->getelem()->cod_local:'LOCAL NO ASIGNADO').")");
		$MiTemplate->set_var('selected', ($codvencli == $List->getelem()->codigovendedor)?'selected':'');
		
		$MiTemplate->parse("BLO_vendedores", "vendedores", true);
	} while ($List->gonext());
}
/*Fin Seleccion Vendedor*/
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
///////////////////////// ZONA PIE DE PAGINA /////////////////////////
?>