<?
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");


$List  = new connlist;

$MiTemplate = new template;

// Inclusión de header
$MiTemplate->set_file("header","../../TEMPLATE/presentacion/header.htm");

//header ('Location: nueva_cotizacion_01.php?rut='.($rut));
// Inclusión de main
$MiTemplate->set_file("main","../../TEMPLATE/nuevacotizacion/comuna.htm");


/*Código encargado de rescatar información y desplegarla en el template.*/
//	$_POST['rut']=$_GET['rut'];

$List = new connlist;
//$mRegistro = new dtoinfocliente;
//$mRegistro->rut =$_POST['rut'];

//$rut=$_POST['rut'];
$List->addlast($mRegistro);

bizcve::getComuna($List);

$List->gofirst();
if (!$List->isvoid()) {
	$MiTemplate->set_block('main' , "listaclientes" , "BLO_listaclientes");
	do {

		$MiTemplate->set_var('id_comuna', $List->getelem()->id_comuna);
		$MiTemplate->set_var('id_ciudad', $List->getelem()->id_ciudad);
		$MiTemplate->parse("BLO_listaclientes", "listaclientes", true);	
	} while ($List->gonext());
	echo $List;
}
else {
	echo "Lista vacÃ­a";
}
/**/
$MiTemplate->pparse("OUT_H", array("header"), false);
include '../menu/menu.php';
/**/
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

// Inclusión de pie de página.
include '../menu/footer.php';
?>
