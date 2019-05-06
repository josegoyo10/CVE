<?php
///////////////////////// ZONA DE INCLUSION /////////////////////////
$pag_ini = '../monitorctevendedor/monitor_vendedor.php';
include_once("../../INCLUDE/ini.php");
include_once("../../INCLUDE/autoload.php");
include_once("../../INCLUDE/aplication_top.php");

///////////////////////// ZONA DE ACCIONES /////////////////////////

if ($accion5 == 'modificar') {
	$List = new connlist;
	$iClientes = new dtoinfocliente;
	
	header("Location: monitor_vendedor_01.php?rut=".$_POST['rut']);
}

///////////////////////// ZONA DE DESPLIEGUE /////////////////////////

/*Despliegue de informaci?n de cliente*/
$MiTemplate = new template;
$MiTemplate->set_var("TITULO", TITULO);

$MiTemplate->set_file("header", TEMPLATE . "presentacion/header.htm");
$MiTemplate->set_var('error_app', $mensaje_error);

$MiTemplate->set_file("main", TEMPLATE . "monitorctevendedor/monitor_vendedor.htm");

/*Despliegue Filtro Rubro*/
$List  = new connlist;
bizcve::getrubro($List);
$List->gofirst();
$MiTemplate->set_block('main' , "rubro" , "BLO_rubro");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nombre', $List->getelem()->nombre);
		$MiTemplate->set_var('selected', ($_POST['select_rubro'] == $List->getelem()->id)?'selected':'');
		
        $MiTemplate->parse("BLO_rubro", "rubro", true);  	
	} while ($List->gonext());
}
/*Fin Despliegue Filtro Rubro*/

/*Despliegue Filtro Registro*/
$MiTemplate->set_block('main' , "registro" , "BLO_registro");
	$MiTemplate->set_var('Todos','TODOS' );
	$MiTemplate->set_var('Incompleto','Incompleto' );
	$MiTemplate->set_var('Completo','Completo' );
   	$MiTemplate->set_var('selectedc', ($_POST['select_registro'] == 1)?'selected':'');
   	$MiTemplate->set_var('selectedi', ($_POST['select_registro'] == 2)?'selected':'');
   	$MiTemplate->set_var('selectedt', ($_POST['select_registro'] == 0)?'selected':'');
   	
    $MiTemplate->parse("BLO_registro", "registro", true); 	
/*Fin Despliegue Filtro Registro

/*Despliegue Filtro Tipo Cliente*/
$List  = new connlist;
bizcve::gettipocliente($List);
$List->gofirst();
$MiTemplate->set_block('main' , "tipo_cliente" , "BLO_tipo_cliente");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('id', $List->getelem()->id);
		$MiTemplate->set_var('nombre', $List->getelem()->nombre);
		$MiTemplate->set_var('selected', ($_POST['select_tipo_cliente'] == $List->getelem()->id)?'selected':'');
		
        $MiTemplate->parse("BLO_tipo_cliente", "tipo_cliente", true);  	
	} while ($List->gonext());
}
/*Fin Despliegue Filtro Tipo Cliente*/

/*DESPLIEGUE*/  
/*Despliegue Resultado Filtro*/
 
$List = new connlist;
$mRegistro = new dtoinfocliente;
$mRegistro->id_rubro = ($_POST['select_rubro'])?$_POST['select_rubro']:null;
$mRegistro->id_tipocliente = ($_POST['select_tipo_cliente'])?$_POST['select_tipo_cliente']:null;
$mRegistra->id_rubro = ($_POST['select_rubro'])?$_POST['select_rubro']:null;
$mRegistra->id_tipocliente = ($_POST['select_tipo_cliente'])?$_POST['select_tipo_cliente']:null;

/*cuando no tiene codigo de vendedor  asignado, problema si es tipousuario 1*/
if ($ses_usr_codvendedor)
	$mRegistro->codigovendedor=$ses_usr_codvendedor;
else
	$mRegistro->codigovendedor=0;

$List->addlast($mRegistro);

if ($ses_usr_codvendedor)
	$mRegistra->codigovendedor=$ses_usr_codvendedor;
else
	$mRegistra->codigovendedor=0;

bizcve::getCliente($List);

$List->gofirst();
$MiTemplate->set_block('main' , "infocliente" , "BLO_infocliente");
if (!$List->isvoid()) {
	do {
		$MiTemplate->set_var('rut',$List->getelem()->rut);
		$MiTemplate->set_var('rutdv',(($List->getelem()->id_contribuyente == 2)?$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut) : $List->getelem()->rut ));
		$MiTemplate->set_var('razonsoc',$List->getelem()->razonsoc);
		$MiTemplate->set_var('id_rubro',$List->getelem()->id_rubro);
		$MiTemplate->set_var('nomrubro',$List->getelem()->nomrubro);
		$MiTemplate->set_var("nomtipcliente",$List->getelem()->nomtipcliente);
		$MiTemplate->set_var('comentario',$List->getelem()->comentario);
		
		if(!$List->getelem()->rut||!$List->getelem()->razonsoc||!$List->getelem()->contacto||!$List->getelem()->fonocontacto||!$List->getelem()->direccion||!$List->getelem()->id_comuna||!$List->getelem()->giro||!$List->getelem()->id_rubro||!$List->getelem()->email) {
			$registrocompleto = false;
			$MiTemplate->set_var('Registro','
		
						<td width="1"  align="center" class="fondoregistro">&nbsp;</td>
			<td width="63" align="right" class="fondoregistro">'.(($List->getelem()->id_contribuyente == 2)?$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut) : $List->getelem()->rut ).'&nbsp;</td>
			<td width="11"  align="center" class="fondoregistro">&nbsp;</td>
			<td width="106" align="left" class="fondoregistro">'.$List->getelem()->razonsoc.'&nbsp;</td>
			<td width="4"  align="center" class="fondoregistro">&nbsp;</td>
			<td width="121" align="left" class="fondoregistro">'.$List->getelem()->nomrubro.'&nbsp;</td>
			<td width="6"  align="center" class="fondoregistro">&nbsp;</td>
			<td width="94" align="left" class="fondoregistro">'.$List->getelem()->nomtipcliente.'&nbsp;</td>
			<td width="6"  align="center" class="fondoregistro">&nbsp;</td>
			<td width="106"  align="left" class="fondoregistro">'.$List->getelem()->comentario.'&nbsp;</td>
			<td width="6"  align="center" class="fondoregistro">&nbsp;</td>
			<td width="80"  align="left" class="fondoregistro">Incompleto&nbsp;</td>
			<td width="99"  align="center" class="fondoregistro"><a href="#"><img onClick="editar_registro(this);" src="../../IMAGES/editicon.gif" alt="Modificar Registro" border="0" align="middle" id="'.$List->getelem()->rut.'"id2="'.$List->getelem()->id_rubro.'"></a>
			&nbsp;</td>
		
			');

		}
		else {
			$registrocompleto = true;
			$MiTemplate->set_var('Registro','
			
			<td width="1"  align="center">&nbsp;</td>
			<td width="63" align="right">'.$List->getelem()->rut.'-'.general::digiVer($List->getelem()->rut).'&nbsp;</td>
			<td width="11"  align="center">&nbsp;</td>
			<td width="106" align="left">'.$List->getelem()->razonsoc.'&nbsp;</td>
			<td width="4"  align="center">&nbsp;</td>
			<td width="121" align="left" >'.$List->getelem()->nomrubro.'&nbsp;</td>
			<td width="6"  align="center">&nbsp;</td>
			<td width="94" align="left">'.$List->getelem()->nomtipcliente.'&nbsp;</td>
			<td width="6"  align="center">&nbsp;</td>
			<td width="106"  align="left">'.$List->getelem()->comentario.'&nbsp;</td>
			<td width="6"  align="center">&nbsp;</td>
			<td width="83"  align="left">Completo&nbsp;</td>
			<td width="99"  align="center"><a href="#"><img onClick="editar_registro(this);" src="../../IMAGES/editicon.gif" alt="Modificar Registro" border="0" align="middle" id="'.$List->getelem()->rut.'"id2="'.$List->getelem()->id_rubro.'"></a>
			&nbsp;</td>'

			);
		}
		
		if (!$_POST['select_registro']) {
			$MiTemplate->parse("BLO_infocliente", "infocliente", true);
		}
		else {
			if ($_POST['select_registro']==1 && $registrocompleto==1)
				$MiTemplate->parse("BLO_infocliente", "infocliente", true);
			if ($_POST['select_registro']==2 && $registrocompleto==null){
				$MiTemplate->parse("BLO_infocliente", "infocliente", true);				
			}

		}
	} while ($List->gonext());
}
/*FIN LIST */

/*Fin Despliegue Resultado Filtro*/
/*FIN DESPLIEGUE*/

$MiTemplate->pparse("OUT_H", array("header"), false);
$MiTemplate->parse("OUT_M", array("main"), true);
$MiTemplate->p("OUT_M");

///////////////////////// ZONA PIE DE PAGINA /////////////////////////
include '../menu/menu.php';
include '../menu/footer.php';
?>