<html>
<head>
<SCRIPT LANGUAGE="JavaScript">
function imprimir() {
this.focus();
this.print();
}
</SCRIPT>
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<script language="javascript" src="../../TEMPLATE/general/funciones.js"></script>
<link href= "../../TEMPLATE/general/estilos.css" rel="stylesheet" type="text/css" />
<table width="600" height="403" border="0" bordercolor="black" cellpadding="0" cellspacing="0" style="border: 2px solid #ffffff;">
	<tr>
		<td height="69" valign="top">
			<table width="550s"  border="0" cellspacing="2" cellpadding="2">
			<tr>
				<td width="15%" height="49"><img src="../../IMAGES/logotipo_negro.gif"></td>
				<td width="457" class="titulonormal">&nbsp;Orden de Pedido N&ordm; {id_ordenent}</td>
				<td width="6%">{cod_barra_os}</td>
			</tr>
			<tr>
				<td height="11" colspan="3" background="../../IMAGES/barra.gif"></td>
			</tr>   
			</table>
		</td>
	</tr>  
	<tr>
		<td valign="top"><!-- InstanceBeginEditable name="Cuerpo" -->
		<table width="550"  border="0" cellspacing="2" cellpadding="2" class="textonormal">
			<tr>
			<td valign="top">
			<table width="550" border="0"  cellpadding="2" cellspacing="1" class="textonormal">
				<tr>
					<td><fieldset>
					<legend><strong>Datos Cotizaci&oacute;n</strong></legend>
					<table width="550" border="0" align="center" cellpadding="2" cellspacing="1" class="textonormal">
						<tr>                 
							<!-- <th align="left" width="20%">N&ordm; OE</th>
							<td width="30%">{oe}</td>-->
							<th align="left" width="20%">No. Cotizaci&oacute;n</th>
							<td  width="30%">{id_cotizacion}</td>
							<th align="left" width="20%">Fecha de Cotizaci&oacute;n</th>
							<td width="30%">{feccreacoti}</td>
							
						</tr>
						<tr>
						    <th align="left" width="20%">Estado</th>
							<td  width="30%"><font color="#FF0000">{nomestadorent}</font> </td>
							<!-- <th align="left" width="20%">Tipo Entrega</th>
							<td  width="30%">{nomtipoentrega}</td>-->
							<!-- <th align="left" width="20%">Tipo Facturaci&oacute;n</th>
							<td  width="30%">{nomtipoflujo}</td>-->
							<th align="left" width="20%">Tienda</th>
							<td  width="30%">{nom_local}</td>
						</tr>
						<tr>
							<th align="left" width="20%">Atendido Por</th>
							<td  width="30%">{nombrevendedor}</td>
							<th align="left" width="20%">Fecha de Entrega</th>
							<td  width="30%">{}</td>
							
						</tr>
						<tr>
							<tr>
								<th align="left">V&#225;lido Desde</th>
								<td>{validdesde}</td>
								<th align="left"> V&#225;lido Hasta</th>
								<td>{validhasta} </td>
							</tr>                  
							<!-- <th align="left" width="20%">Tienda</th>
							<td  width="30%">{nom_localcsum}</td> -->                    
						</tr>
						<tr>
					    	<th align="left" width="20%">Tipo de Pago</th>
							<td width="200">{tipopago}&nbsp;{condicion}</td>							
						    <!--<th align="left" width="20%">IVA</th>
							<td  width="30%" >{iva}%</td>
							<th align="left" width="20%">Creador</th>
							<td width="30%">{usuariocrea} </td>-->
							<th align="left" width="20%">Observaciones</th>
							<td colspan=3>{nota}</td>
						</tr>
													
					</table>
					</fieldset></td>
				</tr>
				<tr>
					<td><fieldset>
					<legend>Direcci&oacute;n de Servicio (Despachos e Instalaciones)</legend>
						<table width="550" border="0" align="center" cellpadding="2" cellspacing="1" class="textonormal">
							<tr>
								<th align="left" width="20%">Tel&eacute;fono</th>
								<td width="30%" >{telefonoe}</td>
     						</tr>
							<tr>
								<th align="left" width="20%">Direcci&oacute;n</th>
								<td  width="30%">{direccione}</td>
								<th align="left" width="20%">Barrio</th>
								<td  width="30%">{barrioe}</td>
							</tr>
							<tr>
								<th align="left" width="20%">Comentarios</th>
								<td  width="30%">{observaciones}</td>
							</tr>
						</table>
					</fieldset></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
		<table width="550" border="0" cellpadding="2" cellspacing="0" class="textonormal">
<tr>
				<td width="550">
			  <table width="550" border="0" cellpadding="0" cellspacing="0" class="tabla2">
<tr>
							<th width="40" align="center">CODIGO</th>
							<th width="40" align="center">TIPO</th>
							<th width="280" align="center">DESCRIPCI&Oacute;N</th>
							<th width="60" align="center">TIPO DE DESPACHO</th>
							<th width="40" align="center">UNIDAD DE MEDIDA</th>
							<th width="60" align="center">INSTALACION</th>
							<th width="40" align="center">PESO</th>
							<th width="40" align="center">CANTIDAD</th>         
							<th width="80" align="center">Precio</th>
							<th width="90" align="center">Total</th>
						</tr>
					</table>
			</td>
		  </tr>	
			<tr>
				<td valign="top">	
					<table width="550" border="0"  cellpadding="0" cellspacing="0"  class="tabla2">             
					<!-- BEGIN detalleproductos -->              
			  <tr valign="top">
						<td width="40" height="20" align="center">{codprod}&nbsp;</td>
						<td width="40" height="20" align="center">{codtipo}&nbsp;</td>
						<td width="235" height="20" align="center">{descripcion}</td>
						<td width="60" height="20" align="center">{retdesp}</td>
						<td width="50" height="20"  align="center">{unimed}</td>
						<td width="76" height="20" align="right">{instalacion}</td>
						<td width="40" height="20" align="right">{peso}</td>
						<td width="40" height="20"  align="right">{cantidad}</td>
						<td width="80" height="20"  align="right">{precio}</td>              
						<td width="90" height="20"  align="right">{totallinea}</td>
					</tr>
					<!-- END detalleproductos -->                

					</table>
			  </td>
			</tr>					
			<tr>
				<td valign="top">
					<table width="550" border="0" cellpadding="0" cellspacing="0" class="tabla3">
					<FORM NAME="nuevaoe" METHOD="POST">	
					<tr>
				<td width="40" height="20" ></td>
				<td width="80" height="20" ></td>
				<td width="200" height="20" ></td>                
				<td width="100" height="20" align="left">Sub-Total</td>
				<td width="50" height="20"  ></td>								
				<td width="90" height="20"  align="right">{valortotal}&nbsp;</td>  
			</tr>
			<tr>
				<td width="40" height="20" ></td>
				<td width="80" height="20" ></td>
				<td width="200" height="20" ></td>                
				<td width="100" height="20"  align="left">Descuentos</td>
				<td width="50" height="20"></td>								
				<td width="90" height="20" align="right">{descuentos}&nbsp;</td>  
			</tr>
			<tr>
				<td width="40" height="20" ></td>
				<td width="80" height="20" ></td>
				<td width="200" height="20" ></td>                
				<td width="100" height="20" align="left">Valor IVA</td>
				<td width="50" height="20"  ></td>								
				<td width="90" height="20" align="right">{viva}&nbsp;</td>  
			</tr>
			<tr>
				<td width="40" height="20" ></td>
				<td width="80" height="20" ></td>
				<td width="200" height="20" ></td>                
				<td width="100" height="20" align="left">Retenci&oacute;n IVA</td>
				<td width="50"  height="20"></td>								
				<td width="90"  height="20" align="right">{rete_iva}&nbsp;</td>  
			</tr>
			<tr>
				<td width="40" height="20" ></td>
				<td width="80" height="20" ></td>
				<td width="200" height="20" ></td>                
				<td width="100" height="20" align="left">Retenci&oacute;n Renta</td>
				<td width="50" height="20" ></td>								
				<td width="90" height="20" align="right">{rete_renta}&nbsp;</td>  
			</tr>
			<tr>
				<td width="40" height="20" ></td>
				<td width="80" height="20"></td>
				<td width="200"  height="20"></td>                
				<td width="100" height="20" align="left">Retenci&oacute;n ICA</td>
				<td width="50"  height="20"></td>								
				<td width="90"  height="20" align="right">{rete_ica}&nbsp;</td>  
			</tr>
				<tr>
				<td width="40" height="20" ></td>
				<td width="80" height="20"></td>
				<td width="200" height="20"></td> 
				<td align="left"  width="100" height="20">Total A Pagar</td>
				<td width="50" height="20"></td>						
				<td align="right" height="20" width="90">{sumtotal}&nbsp;</td>
			</tr>	
				
					</form>
					</table>
			  </td>
			</tr>
		</table>	
	  </td>
	</tr>
	<tr><td width="550"></td></tr>
	<tr><td align="center">El Valor de fletes cotizados esta sujeto a cambios de tarifas o cambio de cantidades en la compra.</td></tr>
	<tr><td width="550" height="�"></td></tr>

	
	<tr><td align="center">DETALLE DE IVA INCLUIDO EN LA COTIZACION</td></tr>
	<tr>
	<td width="550">
		<fieldset style=" width : 550px;"><table width="550" border="0" align="center" cellpadding="2" cellspacing="2" class="textonormal" style=" width : 550px;">
			<tr>
			   <td align="center">Descripci&oacute;n</td>
			   <td align="center">Base IVA</td>
			   <td align="center">vlr IVA</td>
			</tr>
			<tr>
			<!-- BEGIN iva -->
			   <td align="center">{ivap}%</td>
			   <td align="center">{totalsiniva}</td>
			   <td align="center">{impivatotal}</td>
			<!-- END iva -->   
		   </tr>			
		</table></fieldset>
	</td>
	</tr>
	<tr>
	<td width="550">
		<fieldset style=" width : 550px;"><table width="550" border="0" cellpadding="2" cellspacing="2" class="textonormal" style=" width : 550px;">
			<tr><td width="550">{infocotioe}</td></tr>
			<tr><td width="550"></td></tr>
			<tr><td width="550" align="center">{infocotioe2}</td></tr>			
		</table></fieldset>
	</td>
	</tr>
	<tr><td></td></tr>
	<tr>
		<td>
		  <fieldset style=" width : 550px;"><table width="550" border="0" align="center" cellpadding="2" cellspacing="2" class="textonormal" style=" width : 550px;">
			<tr><td width="550" align="center">{infocotioe3}</td></tr>			
		</table></fieldset>
		</td>
	</tr>
	<tr><td></td></tr>
	<tr>
		<td>
		  <fieldset style=" width : 550px;"><table width="550" border="0" align="center" cellpadding="2" cellspacing="2" class="textonormal" style=" width : 550px;">
			<tr><td width="550" align="center">{infocotioe4}</td></tr>			
		</table></fieldset>
		</td>
	</tr>
	<tr><td></td></tr>
	<tr>
		<td>
		  <fieldset style=" width : 550px;"><table width="550" border="0" align="center" cellpadding="2" cellspacing="2" class="textonormal" style=" width : 550px;">
			<tr><td width="550">{infocotioe5}</td></tr>			
		</table></fieldset>
		</td>
	</tr>
	<tr><td align="right">Pagina 1 de 1</td></tr>
</table>
</body>
</html>

