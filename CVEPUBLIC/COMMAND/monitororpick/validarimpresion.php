<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitororpick/monitor_orpick_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////
//echo $_POST['usuario'];
//echo $_POST['clave'];
//echo $_POST['valuecadenarehtm'];
//echo $_POST['valuecadenahtm'];
if ($_POST['contintentoimp'] >= 1)
{
	$confimp = new getidmodulos("ID_MODULO");
	$idmodulo=$confimp->ID_MODULO_REIMPRESION;
	
	$Listusuariovalidoimp  = new connlist;
	$mRegistro=new dtousuario;
	$usuariolis =$_POST['usuario'];
	$clavelist =$_POST['clave'];
	bizcve::usuariomodulovalido($Listusuariovalidoimp,$usuariolis,$clavelist,$idmodulo);
	$Listusuariovalidoimp->gofirst();
	
	
		if ($Listusuariovalidoimp->getelem()->id!='')
		{
			
			
			if($_POST['valuecadenahtm']!=''){
				$coladeimpresion="".$_POST['valuecadenarehtm'].",".$_POST['valuecadenahtm']."";
				echo "<script Language='JavaScript'><!--
				window.close();
				window.open('../../COMMAND/monitororpick/printframe.php?popup=1&logval=1&id_ordenpicking=".$coladeimpresion."&id_usuariore=".$Listusuariovalidoimp->getelem()->id."&apellidosre=".$Listusuariovalidoimp->getelem()->usr_apellidos."&nombresre=".$Listusuariovalidoimp->getelem()->usr_nombres."','popup',100, 100, 760, 500);	
				//--></script>";
				
				}
			else{
				$coladeimpresion=$_POST['valuecadenarehtm'];
				echo "<script Language='JavaScript'><!--
				window.close();
				window.open('../../COMMAND/monitororpick/printframe.php?popup=1&logval=1&id_ordenpicking=".$coladeimpresion."&id_usuariore=".$Listusuariovalidoimp->getelem()->id."&apellidosre=".$Listusuariovalidoimp->getelem()->usr_apellidos."&nombresre=".$Listusuariovalidoimp->getelem()->usr_nombres."','popup',100, 100, 760, 500);	
				//--></script>";
				
				}	
		}
		else
		{
			if($_POST['valuecadenahtm']!=''){
			$coladeimpresion=$_POST['valuecadenahtm'];
			
			echo "<script Language='JavaScript'><!--
			window.open('../../COMMAND/monitororpick/printframe.php?popup=1&mensaje=1&logval=1&id_ordenpicking=".$coladeimpresion."&id_usuariore=".$Listusuariovalidoimp->getelem()->id."','popup',100, 100, 760, 500);	
			window.close()
			//--></script>";
			
			}
			else{
				
				echo "<script Language='JavaScript'><!--
				window.close();
				alert('Su usuario y/o contraseña son inválidos, por favor verifique e ingrese nuevamente los datos');
				window.close();
				//--></script>";	
			}
		}
}
$tupla =$_REQUEST['id_ordenpicking'];
$tuparray=split(',',$tupla);
foreach($tuparray as $key=>$value){
	$ListEnc  = new connlist;
	$mRegistro=new dtoencordenpicking;
	$mRegistro->id_ordenpicking =$value;
	$ListEnc->addlast($mRegistro);
	bizcve::getordenpick($ListEnc,$ListDet=new connlist);
	$ListEnc->gofirst();
	if($ListEnc->getelem()->n_impresiones > 0){
				
				$valuecadenare=''.$value.','.$valuecadenare.'';
				}
				else{
				$valuecadena=''.$value.','.$valuecadena.'';
				}
}
$valuecadenare=substr($valuecadenare,0,-1);
$valuecadena=substr($valuecadena,0,-1);

if($valuecadenare=='' and $valuecadena!='')
{
echo "<script Language='JavaScript'><!--
				window.open('../../COMMAND/monitororpick/printframe.php?imprimircadena=1&popup=1&logval=&id_ordenpicking=".$valuecadena."&id_usuariore=&apellidosre=&nombresre=','popup',100, 100, 760, 500);	
				//--></script>";
				echo "<script Language='JavaScript'><!--
				window.close();
				//--></script>";
}

if($valuecadenare!='' and $_POST['contintentoimp'] < 1)
{
///////////////////////// ZONA DE DESPLIEGUE /////////////////////////
$MiTemplate = new template;
$MiTemplate->set_file("main", TEMPLATE . "monitororpick/validarimpresion.html");
$MiTemplate->set_var('cadenar',$valuecadenare);
$MiTemplate->set_var('cadena',$valuecadena);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");
}


///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>