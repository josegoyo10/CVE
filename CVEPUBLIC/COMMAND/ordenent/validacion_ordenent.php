<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////


///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_var('error_app', $mensaje_error);

/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "ordenent/valida_orden.htm");
//echo $_REQUEST['id_ordenent'];
$tupla =$_REQUEST['id_ordenent'];
$contador = count(split(',',$tupla));
$tuparray=split(',',$tupla);
if($contador == 1){
	
	bizcve::getdocumento($List = new connlist(new dtodocumento(array('tipoorigen'=>'OE', 'id_tipodocumento'=>'2', 'numorigen'=>$tupla))), $ListDet = new connlist);
    $List->gofirst();
    if ($List->numelem()) {
	    $vari = 0;
		do {
    
    			//Busco la OP si existe y veo que esté cerrada en PD
				$lockprintop = false;
				if ($List->getelem()->numdocrefop) {
					bizcve::getordenpick($Listop = new connlist(new dtoencordenpicking(array('id_ordenpicking'=>$List->getelem()->numdocrefop))), null);
					$Listop->gofirst();
					if ($Listop->getelem() && $Listop->getelem()->id_estado != 'PD'){
						$lockprintop = $List->getelem()->numdocrefop;
					}

				}
	
				if($lockprintop > 0){
		
					general::alert('Esta gu\xeda de despacho  No OE ' . $tupla . ' no puede ser impreso debido a que no se ha cerrado la\nOrden de Picking asociada (OP: '.$lockprintop.')');
					echo "<script>";
	    			echo "window.close();";
	    			echo "</script>";
					$vari = 1;

		
				}
	
				if($List->getelem()->indmsgsap == '1'){
		
	   				general::alert('Esta gu\xeda de despacho  No OE ' . $tupla . ' ya ha sido enviado a SAP.\nNo puede reimprimir el documento');
	   				echo "<script>";
	   				echo "window.close();";
	   				echo "</script>";
       				$vari = 2;

		
				}		
   
				if($List->getelem()->lockprintgde == '1' && $vari == 0){
		
					general::confirmreturn('Esta gu\xeda de despacho  No OE ' . $tupla . ' ya fue impresa.\n \xbfDesea Reimprimirla?',true,false,$tupla);
					$vari = 3;
	
				}
				
				if($vari == 0){
					
					echo "<script type='text/javascript'>";
					echo " window.open('../../COMMAND/monitororent/printframe.php?popup=1&id_ordenent=$tupla','','width=760,height=500');";
					echo "</script>";
					
				}
				
				
	    } while ($List->gonext());

    }
	       
	
	
}else{
    	
	$ordenimp = array();
	$ordenimptop = array();
	$lockprinta = array();
	$ordenindsap = array();
	$i = 0;
	$j = 0;
	$k = 0;
	$l = 0;
	$vari =0;
	foreach($tuparray as $key=>$value){
	  
		bizcve::getdocumento($List = new connlist(new dtodocumento(array('tipoorigen'=>'OE', 'id_tipodocumento'=>'2', 'numorigen'=>$value))), $ListDet = new connlist);
	    $List->gofirst();
	    

	    //Busco la OP si existe y veo que esté cerrada en PD
		$lockprintop = false;
		if ($List->getelem()->numdocrefop) {
				bizcve::getordenpick($Listop = new connlist(new dtoencordenpicking(array('id_ordenpicking'=>$List->getelem()->numdocrefop))), null);
				$Listop->gofirst();
				if ($Listop->getelem() && $Listop->getelem()->id_estado != 'PD'){
						$lockprintop = $List->getelem()->numdocrefop;
				}
	
		}
		
		if($lockprintop > 0){
			  $ordenimptop[$j] = $value;
			  $lockprinta[$k] = $lockprintop; 
			  $j++;	
			  $k++;
			  $vari = 1;
	      }
		
		  if($List->getelem()->indmsgsap == '1'){
			  $ordenindsap[$l] = $value; 
              $l++; 
	       	  $vari = 2;
	       }		
	   
		   if($List->getelem()->lockprintgde == '1' && $vari != 1 && $vari != 2){
			            
			  $ordenimp[$i] = $value;
			  $i++;	
			  $vari = 3;
			 
			}
					
	}
	
	if($vari == 1){
		$coma_separated = implode(",",$ordenimptop);
		$op = implode(",",$lockprinta);
		general::alert('Esta gu\xeda de despacho  No OE ' . $coma_separated . ' no puede ser impreso debido a que no se ha cerrado la\nOrden de Picking asociada (OP: '.$op.')');
		echo "<script>";
		echo "window.close();";
		echo "</script>";
	}
	
	if($vari == 2){
		$coma_separated = implode(",",$ordenindsap);
		general::alert('Esta gu\xeda de despacho  No OE ' . $coma_separated . ' ya ha sido enviado a SAP.\nNo puede reimprimir el documento');
		echo "<script>";
		echo "window.close();";
		echo "</script>";
		
	}
	
	if($vari == 3){
		$comma_separated = implode(",", $ordenimp);
		general::confirmreturn('Esta gu\xeda de despacho  No OE ' . $comma_separated . ' ya fue impresa.\n \xbfDesea Reimprimirla?',true,false,$tupla);
	}
	
	if($vari == 0){
						
		echo "<script type='text/javascript'>";
		echo " window.open('../../COMMAND/monitororent/printframe.php?popup=1&id_ordenent=$tupla','','width=760,height=500');";
		echo "</script>";
						
	}
		
}


$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>