<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../realinventory/inventario_real.php';
//session_start();
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE ACCIONES /////////////////////////

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template();
$MiTemplate->set_var("TITULO", TITULO);


/*Inclusion de header*/
$MiTemplate->set_file("header","../../TEMPLATE/presentacion/header.htm");

/*Inclusion de main*/
$MiTemplate->set_file('main',"../../TEMPLATE/realinventory/inventario_real.htm");

//Recuperamos y asignamos los parametros de consulta
/*** Tiendas ***/ 
	
$List = new connlist;
bizcve::getlocales($List);
$List->gofirst();
$tiendas = array();
$error = "No se pudo obtener el Stock en línea.";
$cont_error = 0;

if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "tiendas" , "BLO_tiendas");
	do {
		$tiendas[$List->getelem()->cod_local] = $List->getelem()->nom_local;
		$MiTemplate->set_var('cod_local', $List->getelem()->cod_local);
		$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);		
		$MiTemplate->parse("BLO_tiendas", "tiendas", true);	
	} while ($List->gonext());
}

if ($accion == 'Buscar') {
	
	$lista = new connlist;
	$listaproductos = array();
	$producto = array();
	$popup = false;
	$c = 0;
	
	if ($_POST['tienda'] != "") {
		foreach ($tiendas as $clave => $valor) {
			if ($_POST['tienda'] != $clave) {
				unset($tiendas[$clave]);	
			}
		}
	}
	
	foreach ($tiendas as $clave => $valor) {
		
		$dtoproducto = new dtoproducto;
		if ($cod_sap == 'sap') {
			$dtoproducto->sap = $codigo;
		}
		if ($cod_ean == 'ean') {
			$dtoproducto->barra = $codigo;
		}
		$dtoproducto->csum = $clave;
		$dtoproducto->numretlimit = LIMITE_REG;
		$dtoproducto->numretlimitdes = 0;
		$lista->addlast($dtoproducto);
		
		bizcve::getproducto($lista);
		
		$lista->gofirst();
		if (!$lista->isvoid()) {
			$listaproductos[$c]['sap'] = $lista->getelem()->sap;
			$listaproductos[$c]['cod_tienda'] = $clave;
			$listaproductos[$c]['des_tienda'] = $valor;
			$listaproductos[$c]['producto'] = $lista->getelem()->descripcionc;
			$listaproductos[$c]['ean'] = $lista->getelem()->barra;
			$listaproductos[$c]['precio'] = round($lista->getelem()->pventa);
			$listaproductos[$c]['preciocosto'] = round($lista->getelem()->pcosto);
			$listaproductos[$c]['margen'] = round((((-$lista->getelem()->pcosto/$lista->getelem()->pventa)+1)*100),2)+0;
		   	$listaproductos[$c++]['stock'] = $lista->getelem()->stock;
			
			$centro_id = $dtoproducto->csum;
			bizcve::getlocales($ListLoc = new connlist(new dtolocal(array('cod_local' => $centro_id))));
			$ListLoc->gofirst();    
			$almacen_id = $ListLoc->getelem()->almacen_cod;
			
			$producto_input = array();
			$producto_input_unimed = array();
			
			array_push($producto_input, $lista->getelem()->sap);
			array_push($producto_input_unimed, $lista->getelem()->unidmed);
			
			// Si el centro de suministro es oneeasy, consulto al webservice
			if ($ListLoc->getelem()->oneeasy == '1') {
				// Consulto el stock del producto desde el webservice
				$producto[$centro_id] = ActualizarStockProductosOnline($producto_input, $centro_id, $almacen_id, $producto_input_unimed, $error);
				if (!$producto[$centro_id] && $error != '0') {
					$cont_error++;
					$popup = true;
				}
			}
		}		
		$lista->clearlist();
		$lista->gofirst();
	}
	
	if ($popup) {
		if ($cont_error == 1) {
			echo "<script type='text/javascript'>alert('".$error."');</script>";
		}
		else {
			echo "<script type='text/javascript'>alert('No se pudo obtener el Stock en línea.');</script>";
		}
	}
	
	if (count($listaproductos) > 0) {
		$MiTemplate->set_block('main' , "consulta_inv" , "BLO_inventario");
		
		for ($j=0; $j<count($listaproductos); $j++) {
        	
			$MiTemplate->set_var('producto', $listaproductos[$j]['producto']);
			$MiTemplate->set_var('cod_sap', $listaproductos[$j]['sap']);
        	$MiTemplate->set_var('precio', number_format($listaproductos[$j]['precio']));
        	$MiTemplate->set_var('tienda', $listaproductos[$j]['des_tienda']);
        	$MiTemplate->set_var('ean', $listaproductos[$j]['ean']);
        	$MiTemplate->set_var('preciocosto', number_format($listaproductos[$j]['preciocosto']));
        	$MiTemplate->set_var('margen', $listaproductos[$j]['margen']);
	        // Si se pudo obtener el stock online lo traigo, caso contrario imprimo el de la db
			if (isset($producto[$listaproductos[$j]['cod_tienda']][$listaproductos[$j]['ean']])) {
				$stock = '* '.number_format($producto[$listaproductos[$j]['cod_tienda']][$listaproductos[$j]['ean']]);
			}
			else {
				$stock = number_format($listaproductos[$j]['stock']);
			}
        	
        	$MiTemplate->set_var('inventario', $stock);
        	
        	$MiTemplate->parse("BLO_inventario", "consulta_inv", true);
        }
	}
	else {
		$MiTemplate->set_var("mensaje", "EL PRODUCTO NO SE ENCONTRÓ");		
	}
}

$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';

?>