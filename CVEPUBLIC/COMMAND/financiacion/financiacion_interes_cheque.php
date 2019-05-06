<?php
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
///////////////////////// ZONA DE INCLUSION /////////////////////////
//echo "respuesta del cheque".$_GET['ncheque'].'-'.$_GET['cinicial'].'-'.$_GET['totalcot'];
$cheques=$_GET['ncheque'];
$ivaCheq = CHEQ_POS_IVA;

//monto interes pro el numero de cheques
$List = new connlist;
$Registro = new dtooperaciones;
$Registro->valor =$cheques;   
$List->addlast($Registro);
bizcve::financiacion_interes_ncheques($List);
$List->gofirst();
$interes=$List->getelem()->valor;

//monto a financiar
$montoafinanciar=$_GET['totalcot']-round($_GET['cinicial']);
$montoafinanciar=($montoafinanciar < 0?0:$montoafinanciar);

//cuota
if($interes == 0){
	$quota1 = ($montoafinanciar + $interest) / $cheques;	
	}	
else{
	$quota1 = round($montoafinanciar * $interes) * (pow(1+$interes, $cheques)/(pow(1+$interes, $cheques)-1));
	$interest = round(($quota1 * $cheques) - $montoafinanciar);
}
//Completa los Valores a retornar
    $baseIvaInt = number_format((($interest) / ($ivaCheq + 1)), 0, '', '.'); 
    $IvaInt = number_format((round(((round($interest) / ($ivaCheq + 1))) * $ivaCheq)), 0, '', '.');
    $totalFin = number_format(($_GET['totalcot'] + round($interest)), 0, '', '.');   
    $interest = number_format($interest, 0, '', '.');    
    $cuotaInit = number_format($_GET['cinicial'], 0, '', '.');
    $amount = number_format($montoafinanciar, 0, '', '.');
    $interes = $interes*100;
    $quota1 = number_format($quota1, 0, '', '.');
    
	echo $totalFin."|".$cuotaInit."|".$cheques."|".$montoafinanciar."|".$interes."|".$quota1."|".$ivaCheq."|".$interest."|".$IvaInt."|".$baseIvaInt."|".$_GET['id_cot'];
?>