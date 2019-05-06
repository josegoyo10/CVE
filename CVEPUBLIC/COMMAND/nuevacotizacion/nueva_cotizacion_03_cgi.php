<?php
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");

set_exception_handler('not_catched_exceptions');

//Obtenemos las variables globales
$List = new connlist;
bizcve::getglobals($List);
$List->gofirst();
if (!$List->isvoid()) {
	do {
    	define($List->getelem()->nombre, $List->getelem()->valor);
	} while ($List->gonext());
}

$textobus=$_GET["textobus"]; 
//$limite=$_GET["limite"];
$limite = 20;
$tipopedido=$_GET["tipopedido"];
$row=$_GET["row"];
$csum =$_GET["codlocal"];
$rut = $_GET["rut"];	 
$error 		= "No se pudo obtener el Stock en línea."; 
$msj_error  = "No se encuentra el producto Intente Nuevamente..";


$lista =new connlist();
$dtoproducto = new dtoproducto;

//file_put_contents("resultdtoProducto.txt", print_r($textobus,true));

$dtoproducto -> numretlimit = $limite;
$dtoproducto -> csum = $csum;
//Mantis 29078: Ampliar codigo SAP-Inicio
//Se cambia de 10 a 13 digitos
if ((strlen($textobus))>= 11){
	
	$dtoproducto -> barra = $textobus;	
}else {
 	
 	$dtoproducto -> sap = $textobus;
}
//Mantis 29078: Ampliar codigo SAP-Fin
$sap =	$dtoproducto->	sap;
$barra = $dtoproducto-> barra;	

// file_put_contents("resultSapGrillaSap.txt", $sap);
// file_put_contents("resultSapGrillaBarra.txt", $barra);


$descripcion = $dtoproducto -> descripcion;
$dtoproducto -> prod_subtipo=$tipopedido;
$dtoproducto->actualizarinventario=true;
$lista -> addfirst($dtoproducto);

//file_put_contents("resultGrillalista.txt", print_r($lista, true));

$res = bizcve::getproductogrilla($lista);
//file_put_contents("resultGrilla.txt", print_r($res, true));


// OBTENEMOS DATOS DEL LOCAL DE SUMINISTRO ( el id almacen nos interesa ) 
bizcve::getlocales($ListLoc = new connlist(new dtolocal(array('cod_local'=>$csum))));
$ListLoc->gofirst();

// Actualizo el stock del producto mediante el webservice
$productos_input = array();
$productos_input_unimed = array();
$lista->gofirst();
array_push($productos_input, $lista->getelem()->sap);
array_push($productos_input_unimed, $lista->getelem()->unidmed);
$centro_id = $csum;
$almacen_id = $ListLoc->getelem()->almacen_cod;

// si el centro de suministro es oneeasy, consulto al webservice
if ($ListLoc->getelem()->oneeasy == '1') {         
	// Actualizo el stock de los productos desde el webservice

	$productos = ActualizarStockProductosOnline($productos_input, $centro_id, $almacen_id, $productos_input_unimed, $error);

}
else {
	$productos = array();
  $error = '0';
}


$Listaprov = new connlist();
$dtopreferencial = new dtoproducto;
$dtopreferencial -> sap = $sap;
$dtopreferencial -> barra = $barra;
$dtopreferencial -> csum = $csum;
$Listaprov -> addfirst($dtopreferencial);
bizcve::getprovpreferencial($Listaprov);

//$MiTemplate ->set_var("nomprov",$Listaprov->getelem()->nomprov);				
//$MiTemplate ->set_var("rutproveedor",$Listaprov->getelem()->rutproveedor);


//MPLIEGO - SE BUSCA EL DESCUENTO
if ($lista->numelem()!= 0){
	$lista->gofirst();
	$Listaprov -> gofirst();
	do{ 
		$dtoproducto = $lista->getelem();
		$listagrupo = new connlist();
		$dtogrupo    = new dtodescuento;
		$dtogrupo -> rutcliente =$rut;
	
		bizcve::gettcp($listagrupo);
		$listagrupo->gofirst();
		$grupo = $listagrupo->getelem()->tcp_id;

		$listadescuento = new connlist();
		$dtodescuento    = new dtodescuento;
		$dtodescuento -> rutcliente =$rut;
		$dtodescuento -> ean		=$dtoproducto -> barra;
		$dtodescuento -> subrubro	=$dtoproducto -> id_catprod;
		$dtodescuento -> local		=$csum;
		$dtodescuento -> tcp_grupo	=$grupo;
		$listadescuento -> addfirst($dtodescuento);
		bizcve::getdescuento($listadescuento);
		$listadescuento->gofirst();
		
		$margenxrubro = Array();
        if($margenxrubro = bizcve::getMargenProd($dtoproducto->sap)){//si, es una asignación.
        }elseif($margenxrubro = bizcve::getDatosMargen($dtoproducto->id_catprod)){
        }else{
            $margenxrubro['margen'] = MARGEN_MINIMO;
        }


//        $margenxrubro = Array();
//		$margenxrubro = bizcve::getDatosMargen($dtoproducto -> id_catprod);
//		if(!$margenxrubro['margen'])$margenxrubro['margen']= MARGEN_MINIMO;
		
		// si se pudo obtener el stock online, traigo el online, si no traigo el del dia anterior
		if (isset($productos[$dtoproducto->barra])) { 
			$stock = $productos[$dtoproducto->barra];
		}
		else {
			$stock = $dtoproducto->stock;
		}
		
		echo $row."|".$dtoproducto -> sap."|".$dtoproducto -> barra."|".general::ModificarAEntidadesHTML($dtoproducto-> descripcion)."|".$dtoproducto -> unidmed."|".$stock."|".$dtoproducto -> pventa."|".$dtoproducto -> pcosto."|".str_replace("'", "", $dtoproducto-> nomprov)."|".$dtoproducto-> prod_tipo."|".$dtoproducto->prod_subtipo."|".$dtoproducto -> sap."|".$dtoproducto -> pventa."|".$Listaprov->getelem()->rutproveedor."|".$dtoproducto ->peso."|".$dtoproducto ->ica."|".$dtoproducto ->ivap."|".$dtoproducto ->renta."|".$listadescuento->getelem()->descuento."|".$listadescuento->getelem()->tipo_valor."|".$margenxrubro['margen']."|".$dtoproducto->grupocat."|"."<#>";	
	
	}while ($lista->gonext());
} else {

	
	echo $row."|".''."|".''."|".'No existe'."|"."<#>";
	 
}


do{
	echo "~".str_replace("'", "", $Listaprov->getelem()->nomprov)."|".$Listaprov->getelem()->rutproveedor;

}while($Listaprov->gonext());

	

if( $lista->numelem()!= 0 )

    echo "<*>".$error;
else
	echo "Articulo no Existe";
 	echo "<noproducts>";
  
function not_catched_exceptions($e) {
 	general::dspsyserr($msgerr . "Excepcion NO capturada [" . $e->getMessage() . "]");
 }
	
?>
