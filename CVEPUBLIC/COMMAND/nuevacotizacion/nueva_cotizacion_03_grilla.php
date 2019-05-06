<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
//$pag_ini = '../start/start_01.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////




///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$tipopedido =$_GET["tipopedido"];
$tipobus  =$_GET["tipobus"];
$textobus =$_GET["textobus"];
$pag =$_GET["pag"]; 

//$tipobus =null;
//$textobus="";
//echo $_GET["codlocal"];
//echo $tipobus."<br>";
//echo $textobus;
//echo MONITOR_LI_COT;

$MiTemplate = new template;
$MiTemplate->set_file("main","../../TEMPLATE/nuevacotizacion/nueva_cotizacion_03_grilla.html");

$MiTemplate->set_var('tipopedido',	$tipopedido);
$numero = 1;
$MiTemplate->set_var('fila',	$numero);

if ($textobus ==""){
	
	$MiTemplate->set_var('cantidad',0);
	$MiTemplate->set_var('pagactual',1);
	$MiTemplate->set_var('limite',LIMITE_REG);
	
	$MiTemplate->parse("OUT_M", array("main"), true);
	$MiTemplate->p("OUT_M");
}else{
	$lista =new connlist();
	$dtoproducto = new dtoproducto;

	if ($tipobus =="sap"){
		$dtoproducto->sap = $textobus;
	}
	if ($tipobus =="des"){
		$dtoproducto->descripcion = $textobus;
	}
	if ($tipobus =="bar"){
		$dtoproducto->barra = $textobus;
	}
	if ($tipobus =="nom"){
		$dtoproducto->nomprov = $textobus;
	}
		
	$dtoproducto->prod_subtipo=$tipopedido;
	$dtoproducto->csum = $_GET["codlocal"];
	$dtoproducto->numretlimit = LIMITE_REG;
	$dtoproducto->numretlimitdes = $pag*LIMITE_REG;
	$dtoproducto->pagactual = $pag;
	$lista->addlast($dtoproducto);

	bizcve::getproducto($lista);
	
	/****************************/
	$centro_id = $dtoproducto->csum;
	// OBTENEMOS DATOS DEL LOCAL DE SUMINISTRO ( el id almacen nos interesa ) 
	bizcve::getlocales($ListLoc = new connlist(new dtolocal(array('cod_local'=>$centro_id))));
	$ListLoc->gofirst();    
	$almacen_id = $ListLoc->getelem()->almacen_cod;
	$lista->gofirst();
	
	$productos_input = array();
	$productos_input_unimed = array();
	do {
		array_push($productos_input, $lista->getelem()->sap);
		array_push($productos_input_unimed, $lista->getelem()->unidmed);
	} while($lista->gonext());
	
	// si el centro de suministro es oneeasy, consulto al webservice
	if($ListLoc->getelem()->oneeasy == '1') {		
		// Consulto el stock de los productos desde el webservice
		$error = "No se pudo obtener el Stock en línea.";
		$productos = ActualizarStockProductosOnline($productos_input, $centro_id, $almacen_id, $productos_input_unimed, $error);

           //Original
		// if (!$productos && $error != '0') {
		//  	echo "<script type='text/javascript'>alert('".$error."');</script>";
	 // }
         
	}
	else {
		$productos = array();
	}
	
	// Vuelvo a cargar los productos luego de consultar el stock
	$lista->clearlist();
	$lista->gofirst();
	$lista->addlast($dtoproducto);
	bizcve::getproducto($lista);
  	/****************************/
	
	if($lista->numelem() == 0){
		
		$MiTemplate->set_var('cantidad',0);
		$MiTemplate->set_var('pagactual',1);
		$MiTemplate->set_var('limite',LIMITE_REG);
		
	}else{
		$lista->gofirst();
		$MiTemplate->set_var('cantidad',$lista->getelem()->numretreal);
		
		$MiTemplate->set_var('pagactual',$lista->getelem()->pagactual);
		$MiTemplate->set_block("main","Productos","BLO_pro");
		do{ 
				
			$dtobusavanzada = $lista->getelem();
			$MiTemplate->set_var('ean',     $lista->getelem()-> barra);
			$MiTemplate->set_var('articulo',$lista->getelem()-> sap);
			$MiTemplate->set_var('des',		str_replace(",", ".", $lista->getelem()-> descripcion));
			$MiTemplate->set_var('um',		$lista->getelem()-> unidmed);
			$MiTemplate->set_var('pventa',	$lista->getelem()-> pventa);
			
			// Si se pudo obtener el stock online lo traigo, caso contrario busco el del dia anterior
			if (isset($productos[$lista->getelem()->barra])) {
				$stock = $productos[$lista->getelem()->barra];
			}
			else {
				$stock = $lista->getelem()->stock;
			}
			
			$MiTemplate->set_var('stock',   $stock);
            $MiTemplate->set_var('prove',	str_replace(",", ".", $lista->getelem()-> nomprov));
			$MiTemplate->set_var('fila',	$numero);
			$MiTemplate->set_var('limite',LIMITE_REG);
			$numero++;
			
			$MiTemplate->parse("BLO_pro", "Productos",true);	
			
		}while ($lista->gonext());
		
	
	}	

	$MiTemplate->parse("OUT_M", array("main"), true);
	$MiTemplate->p("OUT_M");
}

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
?>
