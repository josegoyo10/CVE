<?php
include ("../../INCLUDE/jpgraph-1.26/src/jpgraph.php");
include ("../../INCLUDE/jpgraph-1.26/src/jpgraph_bar.php");
include ("../../INCLUDE/jpgraph-1.26/src/jpgraph_line.php");
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");
	$Listado  = new connlist;
	$mRegistro = new dtoreporte;
	$mRegistro->codlocalemi = $_GET['localpos'];	
	$mRegistro->fecinicio = $_GET['finipos'];
	$mRegistro->fectermino = $_GET['ffinpos'];
	$mRegistro->codvendedor = $_GET['codusupos'];
	$Listado->addlast($mRegistro);
	bizcve::getreportevendedor($Listado);
	$Listado->gofirst();
	$i = 0;
	$contadorr = 0; 
	if (!$Listado->isvoid()) {
		do {
			++$contadorr;
			if ($contadorr > LIMITE_REPORTE_VENTASVENDEDOR && !$contadorstat) {
				$contadorstat = $contadorr - 1; //No sigo parseando más datos
			}
			if (!$contadorstat) {
					$months[$i]=$Listado->getelem()->codventa;				
					$ydata[$i] =$Listado->getelem()->contribucion;
					$ydata2[$i] =0;
					$i++;
					$totalvalor14 += $Listado->getelem()->margenpromedio;			
					
					$totalvalor15 += $Listado->getelem()->contribucion;					
	
			}
		} while ($Listado->gonext());
	}
		
// Some "random" data
//$ydata2 = array(0,0,0,0);

// Create the graph. 
$graph = new Graph(550,250);	
$graph->SetScale("textlin");
$graph->SetMarginColor('white');
// Adjust the margin slightly so that we use the 
// entire area (since we don't use a frame)
$graph->SetMargin(70,1,20,70);

// Box around plotarea
$graph->SetBox(); 

// No frame around the image
$graph->SetFrame(false);

// Setup the X and Y grid
$graph->ygrid->SetFill(true,'#DDDDDD@0.5','#BBBBBB@0.5');
$graph->ygrid->SetLineStyle('dashed');
$graph->ygrid->SetColor('gray');
$graph->xgrid->Show();
$graph->xgrid->SetLineStyle('dashed');
$graph->xgrid->SetColor('gray');

// Setup month as labels on the X-axis
$graph->xaxis->SetTickLabels($months);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8);
$graph->xaxis->SetLabelAngle(20);

// Create a bar pot
$bplot = new BarPlot($ydata);
$bplot->SetWidth(0.6);
$fcol='#440000';
$tcol='#FF9090';

$bplot->SetFillGradient($fcol,$tcol,GRAD_LEFT_REFLECTION);
//ini_set ('error_reporting', E_ALL);
// Set line weigth to 0 so that there are no border
// around each bar
$bplot->SetWeight(0);

$graph->Add($bplot);

// Create filled line plot
$lplot = new LinePlot($ydata2);
$lplot->SetFillColor('skyblue@0.5');
$lplot->SetColor('navy@0.7');
$lplot->SetBarCenter();

$lplot->mark->SetType(MARK_SQUARE);
$lplot->mark->SetColor('blue@0.5');
$lplot->mark->SetFillColor('lightblue');
$lplot->mark->SetSize(6);

$graph->Add($lplot);

// .. and finally send it back to the browser
$graph->Stroke();
?>