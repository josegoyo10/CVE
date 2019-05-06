<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitororpick/monitor_orpick_00.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

$MiTemplate = new template;
/*Inclusion de header*/
$MiTemplate->set_var('error_app', $mensaje_error);

/* Inclusi?n de main*/
$MiTemplate->set_file("main", TEMPLATE . "ordenent/ordenent_popguiaprint.htm");
	
/*OBTENCION DATOS DE GUIA DE DESPACHO LISTA DE IMPRESION*/
$MiTemplate->set_var('cadenacambioestado', $_REQUEST['cadenapo']);
$tupla =$_REQUEST['cadenapo'];
$reimpresion = $_REQUEST['reimp'];
$nombreus = $_REQUEST['nom'];
$apellidous = $_REQUEST['app'];
$contador = count(split(',',$tupla));
$contadorguia=0;
$tuparray=split(',',$tupla);
$MiTemplate->set_block('main' , "GUIADESP" , "BLO_GUIADESP");
foreach($tuparray as $key=>$value){

			$contadorguia = ++ $contadorguia;
			
			$conta = 0;
			$conimpr = 0; 
			$detalle='';
			$ListEnc  = new connlist;
			$ListDet  = new connlist;	
			$Registro = new dtoencordenent;
		   	$mRegistro->id_ordenent=$_REQUEST['id_ordenent'];
			$ListEnc->addlast($mRegistro);
			
			bizcve::getordenent($ListEnc, $ListDet);
			$ListEnc->gofirst();
			
			//Direccion de Servicio
			$MiTemplate->set_var('fonoservicio', $ListEnc->getelem()->telefono);
			$MiTemplate->set_var('direccionservicio', $ListEnc->getelem()->direccion);
			//general::writeevent("pasa antes de dirdes ".$ListEnc->getelem()->id_direccion);
			bizcve::getdocumento($Listdocu = new connlist(new dtodocumento(array('id_documento'=>$value,'id_tipodocumento'=>'2','sigtipodoc'=>'GDE', 'tipoorigen'=>'OE'))), $ListDetDoc = new connlist);
			
			$Listdocu->gofirst();
		   
			//Marcar la página como impresa para que no se pueda reimprimir
			$docu = $Listdocu->getelem()->id_documento;
			
			//bizcve::marcardocimpreso($ListDoc = new connlist(new dtodocumento(array('id_documento'=>$value))));
			$ListDetDoc2 = new connlist;
			$Registrodoc = new dtodetdocumento;
			$Registrodoc->id_documento = $value; 
			$ListDetDoc2->addlast($Registrodoc);
			bizcve::getdocumentogud($ListDetDoc2);
			$detalle='';
			$ListDetDoc2->gofirst();
			$MiTemplate->set_block('main' , "detalleproductos" , "BLO_detalleproductos");	
			if(!$ListDetDoc2->isvoid()){	
				
				do{	
					if($ListDetDoc2->getelem()->codtipo != 'SV'){
					$conimpr;
					$detalle=$detalle.'<tr valign="top">
						<td width="40" height="20" align="center">'.$ListDetDoc2->getelem()->codprod.'&nbsp;</td>
						<td width="40" height="20" align="center">&nbsp;</td>
						<td width="235" height="20" align="center">'.$ListDetDoc2->getelem()->descripcion.'</td>
						<td width="40" height="20"  align="right">'.$ListDetDoc2->getelem()->cantidad.'</td>              
						<td width="90" height="20"  align="right">'.$ListDetDoc2->getelem()->cantidad.'</td>
					</tr>';
					//$conimpr = $conimpr + 1;
					}

				}while($ListDetDoc2->gonext());
						
			}
			$MiTemplate->set_var('detalleop',$detalle);
			$detalle='';
			$MiTemplate->set_var('saltopag',(($conimpr == 13)?'<H1 class=SaltoDePagina> </H1>':'<H1 class=SaltoDePagina> </H1>'));
			
			if($reimpresion == 1){
                $sum = $Listdocu->getelem()->nreimpresion + 1;
				bizcve::marcareimpresion($sum, $docu);			   
				$MiTemplate->set_var('reimpresion','<tr>
					<td valign="top">
					<table width="550" border="0"  cellpadding="2" cellspacing="1" class="textonormal">
						<tr>
							<td><fieldset>
							<legend><strong>Reimpresi&oacute;n</strong></legend>
							<table width="550" border="0" align="center" cellpadding="2" cellspacing="1" class="textonormal">
								<tr>                 
									<th align="left" width="20%">N&ordm; Reimpresi&oacute;n</th>
									<td width="30%">{numreimpresion}</td>
									<th align="left" width="20%">Autorizado por:</th>
									<td  width="30%">{nombreuser}&nbsp;&nbsp;{apellidouser}</td>
									
								</tr>
							</table>
							</fieldset></td>
						</tr>');
                $MiTemplate->set_var('numreimpresion',$sum);	
				$MiTemplate->set_var('nombreuser',$nombreus);
				$MiTemplate->set_var('apellidouser',$apellidous);
			}
			
			$Listiop = new connlist;
			$opcion = 107;
			bizcve::getinfoop($Listiop, $opcion);
			$Listiop->gofirst();
			if(!$Listiop->isvoid()){
				$MiTemplate->set_var('comentarios',$Listiop->getelem()->var_descripcion);
	
			}
			
			$ListEnc->gofirst();
			
			
		while($conta < 2){
			$conta = $conta + 1;
			
			($conta==1?$MiTemplate->set_var('ccliente','Copia para Cliente'):$MiTemplate->set_var('ccliente','Copia para Tienda'));
			
			if (!$ListEnc->isvoid()) {
				do {
						bizcve::gettipoflujo($Listz=new connlist(new dtotipo(array('id'=>$ListEnc->getelem()->id_tipoflujo))));
						$Listz->gofirst();
						$MiTemplate->set_var('nomtipoentregas', $Listz->getelem()->nombre);
					    $codlocalventa=$ListEnc->getelem()->codlocalventa;
						$MiTemplate->set_var('nomestadorent', $ListEnc->getelem()->nomestadorent);
						if($ListEnc->getelem()->fecha_retira_cliente != '0000-00-00')
							$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_cliente) );
						if($ListEnc->getelem()->fecha_retira_inmediato != '0000-00-00')
							$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_retira_inmediato) );
						if($ListEnc->getelem()->fecha_despacho_programado != '0000-00-00')
							$MiTemplate->set_var('fechaentrega',general::formato_fecha($ListEnc->getelem()->fecha_despacho_programado) );
						$MiTemplate->set_var('razonsoc', $ListEnc->getelem()->razonsoc);	
						$MiTemplate->set_var('giro', $ListEnc->getelem()->giro);
						$rut=$ListEnc->getelem()->rutcliente;
				}while ($ListEnc->gonext());	 	
			 
			}
			
			$Listcl = new connlist;
			$Listcs = new connlist;
			$Registro = new dtoinfocliente;
			$Registro->rut	= $rut;
			$Listcl->addlast($Registro);
			$Listcs->addlast($Registro);
			    
			$MiTemplate->set_var('id_ordenent', $_REQUEST['id_ordenent']);
			
			bizcve::getCliente($Listcl);
			$Listcl->gofirst();
			if (!$Listcl->isvoid()) {
				$Listcl->gofirst();
				$MiTemplate->set_var('rutcliente',(($Listcl->getelem()->id_contribuyente == 2)?$Listcl->getelem()->rut.'-'.general::digiVer($Listcl->getelem()->rut) : $Listcl->getelem()->rut ));			
				$MiTemplate->set_var('contacto', $Listcl->getelem()->contacto);					
				$MiTemplate->set_var('fonocontacto', $Listcl->getelem()->fonocontacto);
				//$MiTemplate->set_var('fonoservicio', $Listcl->getelem()->fonoservicio);		
				$MiTemplate->set_var('email', $Listcl->getelem()->email);
				//$MiTemplate->set_var('direccionservicio', $Listcl->getelem()->direccionservicio);				
			}
			
			$ListEnc->gofirst();
			//general::writeevent("pasa por guia id direccion ".$ListEnc->getelem()->id_direccion);
			if($ListEnc->getelem()->id_direccion == 0){	
				/*Insercion de Ciudad Comuna y Departamento*/
				
				$Listc = new connlist;
				$Registro = new dtoinfocliente;
				$Registro->rut	= $rut;
				$Listc->addlast($Registro);

				bizcve::getCliente($Listc);
				$Listc->gofirst();
				$Listlocalizacion  = new connlist;
				$registrolocalizacion = new dtolocalizacion;
				$registrolocalizacion->id_localizacion = $Listc->getelem()->id_comuna;

				$Listlocalizacion->addlast($registrolocalizacion);
				bizcve::getlocalizacion($Listlocalizacion);
				$Listlocalizacion->gofirst();
				if (!$Listlocalizacion->isvoid()) {
					do {
						$MiTemplate->set_var('ciudadser', $Listlocalizacion->getelem()->ciudad);
						$MiTemplate->set_var('comunaser', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
						$MiTemplate->set_var('departamentoser', $Listlocalizacion->getelem()->departamento);
					} while ($Listlocalizacion->gonext());

				}
				
			}
			else{
				
				$Listdirdes  = new connlist;
				$id_dirdes = new dtodireccion;
				$id_dirdes->id_direccion = $ListEnc->getelem()->id_direccion;
				$Listdirdes->addlast($id_dirdes);
				bizcve::getdirdesp($Listdirdes);
				$Listdirdes->gofirst();
  
				$Listlocalizacion  = new connlist;
				$registrolocalizacion = new dtolocalizacion;
				$registrolocalizacion->id_localizacion = $Listdirdes->getelem()->id_comuna;

				$Listlocalizacion->addlast($registrolocalizacion);
				bizcve::getlocalizacion($Listlocalizacion);
				$Listlocalizacion->gofirst();
				if (!$Listlocalizacion->isvoid()) {
					do {
						$MiTemplate->set_var('ciudadser', $Listlocalizacion->getelem()->ciudad);
						$MiTemplate->set_var('comunaser', $Listlocalizacion->getelem()->barrio.'-'.$Listlocalizacion->getelem()->localidad);
						$MiTemplate->set_var('departamentoser', $Listlocalizacion->getelem()->departamento);

					} while ($Listlocalizacion->gonext());

				}
				
			}
			
			$List = new connlist;
			$Registro = new dtolocal;
			$Registro->cod_local = $codlocalventa;
			$List->addlast($Registro);
			bizcve::getlocales($List);
			$List->gofirst();
			$MiTemplate->set_var('nom_local', $List->getelem()->nom_local);
			
			
			
			$MiTemplate->set_var('detalle',$detalle);
			$MiTemplate->parse("BLO_GUIADESP", "GUIADESP", true);
		  
		  
			 }
$MiTemplate->set_var('ccliente','Copia para Facturaci&oacute;n');
$MiTemplate->set_var('saltopag',(($contadorguia >= $contador)?'':'<H1 class=SaltoDePagina> </H1>'));	
$MiTemplate->parse("BLO_GUIADESP", "GUIADESP", true);
//echo  "bbbbbbb",$contadorguia,"aaaaa",$contador;
}


$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////

?>