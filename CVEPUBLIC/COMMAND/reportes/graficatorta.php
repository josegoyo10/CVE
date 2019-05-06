<?php
include ("../../INCLUDE/jpgraph-1.26/src/jpgraph.php");
include ("../../INCLUDE/jpgraph-1.26/src/jpgraph_pie.php");
include ("../../INCLUDE/jpgraph-1.26/src/jpgraph_pie3d.php");

// Some data
//$data = array(20,200,45,75,90);
//$data1 ='20,200,45,75,90';
$intentos=0; 

while ($intentos < 10) {
	$data[$intentos]=$intentos;
	$leyendaarray=$leyendaarray."-".$intentos;
	$leyenda[$intentos]=$leyendaarray;
	$intentos =$intentos+1;
	
}
// Create the Pie Graph.
$graph = new PieGraph(950,350,"auto");
$graph->SetShadow();

// Set A title for the plot
$graph->title->Set("Example 1 3D Pie plot");
$graph->title->SetFont(FF_VERDANA,FS_BOLD,18); 
$graph->title->SetColor("darkblue");
$graph->legend->Pos(0.1,0.2);

// Create pie plot
$p1 = new PiePlot3d($data);
$p1->SetTheme("sand");
$p1->SetCenter(0.4);
$p1->SetAngle(45);
$p1->value->SetFont(FF_ARIAL,FS_NORMAL,12);
$p1->SetLegends($leyenda);
//$p1->SetLegends(array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct"));

$graph->Add($p1);
$graph->Stroke();
?>