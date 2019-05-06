<?php
class general{

	function digiVer($nit){

		$nit=strtoupper(ereg_replace('\.|,|-','',$nit));
		$sub_nit=$nit;
		//$sub_nit=substr($nit,0,strlen($nit)-1);
		//$sub_dv=substr($nit,-1);

		$s=0;
		$y=0;

		$arreglodv[0]=3;
		$arreglodv[1]=7;
		$arreglodv[2]=13;
		$arreglodv[3]=17;
		$arreglodv[4]=19;
		$arreglodv[5]=23;
		$arreglodv[6]=29;
		$arreglodv[7]=37;
		$arreglodv[8]=41;
		$arreglodv[9]=43;
		$arreglodv[10]=47;
		$arreglodv[11]=53;
		$arreglodv[12]=59;
		$arreglodv[13]=67;
		$arreglodv[14]=71;

		for ( $i=strlen($sub_nit)-1;$i>=0;$i-- )
		{
			$sumanitarreglo += $sub_nit[$i]*$arreglodv[$y];
			$y++;

		}

		if ( ($sumanitarreglo%11)==0)
		{
			$digitoverificacion=0;
			return ($digitoverificacion);
		}
		if ( ($sumanitarreglo%11)==1)
		{
			$digitoverificacion=1;
			return ($digitoverificacion);
		}
		else
		{
			$digitoverificacion=11-($sumanitarreglo%11);
			return ($digitoverificacion);
		}



	}

	function formato_fecha ($fechadb) {
		$arr1 = split(" ", $fechadb);
		$arrfecha = split("-", $arr1[0]);
		if ($arrfecha[0] == 0)
			return "";
		else
			return $arrfecha[2] . "/" . $arrfecha[1] . "/" . $arrfecha[0] ;
	}

	function formato_fecha_FORM2DB ($fechaform) {
		$arr1 = split("/", $fechaform);
		return $arr1[2] . "-" . $arr1[1] . "-" . $arr1[0] ;
	}

   function formato_fecha_english ($fechaform) {
		$arr1 = split("/", $fechaform);
			return $arr1[2] . "-" . $arr1[1] . "-" . $arr1[0] ;
	}



	function formato_fecha_sap ($fechaform) {
		$arr1 = split("-", $fechaform);
		return $arr1[0] . $arr1[1] . $arr1[2] ;
	}

	function formato_hora ($fechadb) {
		$arr1 = split(" ", $fechadb);
		$arrhora = split(":", $arr1[1]);
		return $arrhora[0];
	}

	function formato_min ($fechadb) {
		$arr1 = split(" ", $fechadb);
		$arrmin = split(":", $arr1[1]);
		return $arrmin[1];
	}

	function fecha_MYSQL2PHP($fechaMysql = null){
		$arr1 = split(" ", $fechaMysql);
		$arrfecha = split("-", $arr1[0]);
		$arrhora = split(":", $arr1[1]);
		//return mktime($arrhora[0], $arrhora[1], $arrhora[2], $arrfecha[1], $arrfecha[2], $arrfecha[0]);
		if ($fechaMysql)
			return mktime(0, 0, 0, $arrfecha[1], $arrfecha[2], $arrfecha[0]);
		else
			return mktime(0, 0, 0, date("m"), date("d"), date("Y"));
	}

	function fecha_PHP2TPL($fechaphp = null){
		if (!$fechaphp)
			return date("d") . "/" . date("m") . "/" . date("Y");
		else
			return $fechaphp;
	}

	function suma_fechas($fecha,$ndias){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
	    	list($dia,$mes,$año)=split("/", $fecha);

		if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
			list($dia,$mes,$año)=split("-",$fecha);
	        $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
	        $nuevafecha=date("d-m-Y",$nueva);

	      return ($nuevafecha);
	}

	function desconectar_usuario( $ses_ult_carga ) {
		$dif = time() - $ses_ult_carga;
	    if( $dif > MINUTOS_AUTOLOGOUT*60 )
			header( "Location: ../start/logout_01.php" );
	}

	function writelog( $texto_in ) {
	    global $ses_usr_login;
	    $dir_log = $_SESSION["CONFIG"]->getValue('APPLICATION','PATH_LOG');
            // file_put_contents('dir_log.txt', error_log());
	    if( $dir_log && is_dir($dir_log)) {
	       error_log(date("dmY His", time()) . " " . $_SERVER["REMOTE_ADDR"] . " $ses_usr_login => " . $texto_in  . sprintf("%c%c",0x0D, 0x0A) , 3, $dir_log.date("Ymd", time() )."_error.log");
	    	return true;
	    }
	    else {
	    	return false;
	    }
	}

	function writeevent( $texto_in ) {
	    global $ses_usr_login;
	    $dir_log = $_SESSION["CONFIG"]->getValue('APPLICATION','PATH_LOG');
	    if( $dir_log && is_dir($dir_log)) {
	        error_log( date("dmY His", time() ) . " " . $_SERVER["REMOTE_ADDR"] . " $ses_usr_login => " . $texto_in  . sprintf("%c%c",0x0D, 0x0A) , 3, $dir_log.date("Ymd", time() )."_event.log");
	    	return true;
	    }
	    else {
	    	return false;
	    }
	}

	/*Toma un id_estado y retorna su nombre*/
	function nombre_estado( $id_estado) {
	    global $ses_usr_login;
		$List  = new connlist;
		$mRegistro=new dtoestado;
	    $mRegistro->id_estado =$id_estado;
		$List->addlast($mRegistro);
		bizcve::getestados($List);
		$List->gofirst();
		$nombre=$List->getelem()->descripcion;
		return $nombre;
	}

	/*para insertar el tracking*/
	function inserta_tracking( $id_co, $id_oe, $id_op, $id_do, $descripcion, $tipo = 'SYS', $user = null) {
		$List = new connlist;
		$itracking = new dtotracking;
		$itracking->id_cotizacion =		$id_co;
		$itracking->id_ordenent =		$id_oe;
		$itracking->id_ordenpicking =	$id_op;
		$itracking->id_documento =		$id_do;
		$itracking->descripcion =		sprintf("%252.252s", $descripcion);
		$itracking->tipo =				$tipo;
		$itracking->usrcrea =			$user;
		$List->addlast($itracking);
		return bizcve::puttracking($List);
	}

	/* toma un precio y lo deja formatiado con puntitos*/
	function formato_precio($val) {
	   $s = "";
	   $valor = abs($val);
	   $largo = strlen($valor);
	   $mod = ($largo % 3 );
	   for ($i=0; $i<$largo; $i++) {
	      if (((($i - $mod) % 3) == 0) && ($i != 0)) {
	         $s = $s . ".";
	      }
	      $s = $s . substr($valor, $i, 1);
	   }
	   return $s;
	}
	/*para la impresion de codigo de barra*/
	function dvEAN13($r){
		$Factor = 3;
		$weightedTotal = 0;

		for($I = strlen($r)-1; $I>=0; --$I){
			$CurrentCharNum = substr($r, $I, 1);
			$weightedTotal = $weightedTotal + ($CurrentCharNum * $Factor);
			$Factor = 4 - $Factor;
		}

		$I = ($weightedTotal % 10);
		If ($I != 0)
			$CheckDigit = 10 - $I;
		else
			$CheckDigit = 0;

		return $CheckDigit;
	}

	function gencode_EAN13($number, $ancho, $alto ) {
		//Genera imagen para código EAN13
		$srcimg = "../../IMAGES/barcode/";
		$altoimg = $alto*85/100;
		$altoimg2 = $alto*15/100;
		$anchoimg = $ancho/95*7;
		$anchoimg2 = $ancho/95*3;
		$anchoimg3 = $ancho/95*5;

		$arr_orientacion = Array (	'000000',
									'001011',
									'001101',
									'001110',
									'010011',
									'011001',
									'011100',
									'010101',
									'010110',
									'011010');
		if (strlen($number)>13) {
			return "<br><b>Problemas en el código<br>Códgo NO es EAN13</b>";
			exit();
		}

		$dig_inic = substr(sprintf("%013s", $number), 0, 1);
		$tramoizq = substr(sprintf("%013s", $number), 1, 6);
		$tramoder = substr(sprintf("%013s", $number), 7, 6);

		$ret .= "<table border=0 cellspacing=0 cellpadding=0>";
		$ret .= "<tr>";

		$ret .= "<td>";
		$ret .= "&nbsp;";
		$ret .= "</td>";

		$ret .= "<td>";
		$ret .= "<img src=\"".$srcimg."c1-c3.png\" height=\"$altoimg\" width=\"$anchoimg2\">";
		$ret .= "</td>";

		for ($i=0; $i<6; ++$i) { //Para el tramo izquierda
			$ret .= "<td>";
			$ret .= "<img src=\"".$srcimg.((!substr($arr_orientacion[$dig_inic], $i, 1))?substr($tramoizq, $i, 1)."-der-neg.png":substr($tramoizq, $i, 1)."-izq.png") . "\" height=\"$altoimg\" width=\"$anchoimg\">";
			$ret .= "</td>";
		}

		$ret .= "<td>";
		$ret .= "<img src=\"".$srcimg."c2.png\" height=\"$altoimg\" width=\"$anchoimg3\">";
		$ret .= "</td>";

		for ($i=0; $i<6; ++$i) { //Para el tramo derecha
			$ret .= "<td>";
			$ret .= "<img src=\"".$srcimg.substr($tramoder, $i, 1)."-der.png\" height=\"$altoimg\" width=\"$anchoimg\">";
			$ret .= "</td>";
		}

		$ret .= "<td>";
		$ret .= "<img src=\"".$srcimg."c1-c3.png\" height=\"$altoimg\" width=\"$anchoimg2\">";
		$ret .= "</td>";

		$ret .= "</tr>";
		$ret .= "<tr>";

		$ret .= "<td>";
		$ret .= $dig_inic . "&nbsp;";;
		$ret .= "</td>";

		$ret .= "<td valign=top>";
		$ret .= "<img src=\"".$srcimg."c1-c3.png\" height=\"$altoimg2\" width=\"$anchoimg2\">";
		$ret .= "</td>";

		for ($i=0; $i<6; ++$i) { //Para el tramo izquierda
			$ret .= "<td align=center>";
			$ret .= substr($tramoizq, $i, 1);
			$ret .= "</td>";
		}

		$ret .= "<td valign=top>";
		$ret .= "<img src=\"".$srcimg."c2.png\" height=\"$altoimg2\" width=\"$anchoimg3\">";
		$ret .= "</td>";

		for ($i=0; $i<6; ++$i) { //Para el tramo derecha
			$ret .= "<td align=center>";
			$ret .= substr($tramoder, $i, 1);
			$ret .= "</td>";
		}

		$ret .= "<td valign=top>";
		$ret .= "<img src=\"".$srcimg."c1-c3.png\" height=\"$altoimg2\" width=\"$anchoimg2\">";
		$ret .= "</td>";

		$ret .= "</tr>";
		$ret .= "</table>";
		return $ret;
	}

	function umconvertcvesap($umcve) {
		switch ($umcve) {
			case 'ST':
				return 'UN';
				break;
			default :
				return $umcve;
				break;
		}
	}

	function umconvertsapcve($umsap) {
		switch ($umcve) {
			case 'UN':
				return 'ST';
				break;
			default :
				return $umsap;
				break;
		}
	}

	function se_puede( $funcion, $permisos ) {
	    if( $funcion == 'i' ) {
	        $fun = substr( $permisos, 0, 1 );
	        if( $fun == 1 ) {
	            return 1;
	        }
	    }
	    else if( $funcion == 'd' ) {
	        $fun = substr( $permisos, 1, 1 );
	        if( $fun == 1 ) {
	            return 1;
	        }
	    }
	    else if( $funcion == 'u' ) {
	        $fun = substr( $permisos, 2, 1 );
	        if( $fun == 1 ) {
	            return 1;
	        }
	    }
	    else if( $funcion == 's' ) {
	        $fun = substr( $permisos, 3, 1 );
	        if( $fun == 1 ) {
	            return 1;
	        }
	    }
	    return 0;
	}

	function kid_href( $pagina, $parametros, $texto, $titulo, $class, $target='' ) {
		$href = "";
	    $href .= "'$pagina?tm=".time()."&$parametros'";
	    if( $titulo )
	        $href .= " title='$titulo'";
	    if( $class )
	        $href .= " class='$class'";
	    if( $target )
	        $href .= " target='$target'";
	    return( "<A HREF=$href>$texto</a>" );

	}

	function dspsyserr($msgerr){
		general::writelog ("ERROR de aplicacion: $msgerr");
		echo "<script>document.location='../start/dspsyserr.php';</script>";
		exit();
	}

	function dspmsgerr($msgerr){
		echo "<script>alert('$msgerr');</script>";
	}

	function get_nombre_usr( $ses_usr_id){
	    $List = new connlist;
		$Registro = new dtousuario;
		$Registro->usr_id = $ses_usr_id;
		$List->addlast($Registro);
	 	bizcve::GetUsers($List);
		$List->gofirst();
		if (!$List->isvoid()) {
			do {
				$nombre=$List->getelem()->usr_nombres." ". $List->getelem()->usr_apellidos;
			} while ($List->gonext());
		}
		return $nombre;
	}

	function num2letras($num, $fem = false, $dec = true) {
		if (strlen($num) > 14) die("El numero introducido es demasiado grande");
		   $matuni[2]  = "dos";
		   $matuni[3]  = "tres";
		   $matuni[4]  = "cuatro";
		   $matuni[5]  = "cinco";
		   $matuni[6]  = "seis";
		   $matuni[7]  = "siete";
		   $matuni[8]  = "ocho";
		   $matuni[9]  = "nueve";
		   $matuni[10] = "diez";
		   $matuni[11] = "once";
		   $matuni[12] = "doce";
		   $matuni[13] = "trece";
		   $matuni[14] = "catorce";
		   $matuni[15] = "quince";
		   $matuni[16] = "dieciseis";
		   $matuni[17] = "diecisiete";
		   $matuni[18] = "dieciocho";
		   $matuni[19] = "diecinueve";
		   $matuni[20] = "veinte";
		   $matunisub[2] = "dos";
		   $matunisub[3] = "tres";
		   $matunisub[4] = "cuatro";
		   $matunisub[5] = "quin";
		   $matunisub[6] = "seis";
		   $matunisub[7] = "sete";
		   $matunisub[8] = "ocho";
		   $matunisub[9] = "nove";

		   $matdec[2] = "veint";
		   $matdec[3] = "treinta";
		   $matdec[4] = "cuarenta";
		   $matdec[5] = "cincuenta";
		   $matdec[6] = "sesenta";
		   $matdec[7] = "setenta";
		   $matdec[8] = "ochenta";
		   $matdec[9] = "noventa";
		   $matsub[3]  = 'mill';
		   $matsub[5]  = 'bill';
		   $matsub[7]  = 'mill';
		   $matsub[9]  = 'trill';
		   $matsub[11] = 'mill';
		   $matsub[13] = 'bill';
		   $matsub[15] = 'mill';
		   $matmil[4]  = 'millones';
		   $matmil[6]  = 'billones';
		   $matmil[7]  = 'de billones';
		   $matmil[8]  = 'millones de billones';
		   $matmil[10] = 'trillones';
		   $matmil[11] = 'de trillones';
		   $matmil[12] = 'millones de trillones';
		   $matmil[13] = 'de trillones';
		   $matmil[14] = 'billones de trillones';
		   $matmil[15] = 'de billones de trillones';
		   $matmil[16] = 'millones de billones de trillones';

		   $num = trim((string)@$num);
		   if ($num[0] == '-') {
		      $neg = 'menos ';
		      $num = substr($num, 1);
		   }else
		      $neg = '';
		   while ($num[0] == '0') $num = substr($num, 1);
		   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;
		   $zeros = true;
		   $punt = false;
		   $ent = '';
		   $fra = '';
		   for ($c = 0; $c < strlen($num); $c++) {
		      $n = $num[$c];
		      if (! (strpos(".,'''", $n) === false)) {
		         if ($punt) break;
		         else{
		            $punt = true;
		            continue;
		         }

		      }elseif (! (strpos('0123456789', $n) === false)) {
		         if ($punt) {
		            if ($n != '0') $zeros = false;
		            $fra .= $n;
		         }else

		            $ent .= $n;
		      }else

		         break;

		   }
		   $ent = '     ' . $ent;
		   if ($dec and $fra and ! $zeros) {
		      $fin = ' coma';
		      for ($n = 0; $n < strlen($fra); $n++) {
		         if (($s = $fra[$n]) == '0')
		            $fin .= ' cero';
		         elseif ($s == '1')
		            $fin .= $fem ? ' una' : ' un';
		         else
		            $fin .= ' ' . $matuni[$s];
		      }
		   }else
		      $fin = '';
		   if ((int)$ent === 0) return 'Cero ' . $fin;
		   $tex = '';
		   $sub = 0;
		   $mils = 0;
		   $neutro = false;
		   while ( ($num = substr($ent, -3)) != '   ') {
		      $ent = substr($ent, 0, -3);
		      if (++$sub < 3 and $fem) {
		         $matuni[1] = 'una';
		         $subcent = 'as';
		      }else{
		         $matuni[1] = $neutro ? 'un' : 'un';
		         $subcent = 'os';
		      }
		      $t = '';
		      $n2 = substr($num, 1);
		      if ($n2 == '00') {
		      }elseif ($n2 < 21)
		         $t = ' ' . $matuni[(int)$n2];
		      elseif ($n2 < 30) {
		         $n3 = $num[2];
		         if ($n3 != 0) $t = 'i' . $matuni[$n3];
		         $n2 = $num[1];
		         $t = ' ' . $matdec[$n2] . $t;
		      }else{
		         $n3 = $num[2];
		         if ($n3 != 0) $t = ' y ' . $matuni[$n3];
		         $n2 = $num[1];
		         $t = ' ' . $matdec[$n2] . $t;
		      }
		      $n = $num[0];
		      if ($n == 1) {
		         $t = ' ciento' . $t;
		      }elseif ($n == 5){
		         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
		      }elseif ($n != 0){
		         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
		      }
		      if ($sub == 1) {
		      }elseif (! isset($matsub[$sub])) {
		         if ($num == 1) {
		            $t = ' mil';
		         }elseif ($num > 1){
		            $t .= ' mil';
		         }
		      }elseif ($num == 1) {
		         $t .= ' ' . $matsub[$sub] . '?n';
		      }elseif ($num > 1){
		         $t .= ' ' . $matsub[$sub] . 'ones';
		      }
		      if ($num == '000') $mils ++;
		      elseif ($mils != 0) {
		         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
		         $mils = 0;
		      }
		      $neutro = true;
		      $tex = $t . $tex;
		   }
		   $tex = $neg . substr($tex, 1) . $fin;
		   return ucfirst($tex);
		}

	public function alert($msg){
		echo "<script>alert('$msg');</script>";
	}

	public function alertexit($msg){
		echo "<script>alert('$msg');window.close();</script>";
		exit();
	}

	public function alertexitredirect($msg){
		echo "<script>alert('$msg');window.location = '../start/start_01.php'; </script>";
		exit();
	}

	public function confirmexit($msg, $acctrue, $accfalse){
		echo "	<script>
				if (confirm('$msg')){
					$acctrue;
				}
				else {
					$accfalse;
				}
				window.close();
				</script>";
		exit();
	}

	public function confirm($msg, $acctrue, $accfalse){
		echo "	<script>
				if (confirm('$msg')){
					$acctrue;
				}
				else {
					window.close();
				}
				</script>";
		exit();
	}

	public function confirmreturn($msg, $acctrue, $accfalse, $tupla){
		//general::alert('esta es la dupla'.$tupla.'');
		echo "	<script>
				if (confirm('$msg')){
					//acctrue;
					 window.open('../../COMMAND/monitororent/printframe2.php?popup=1&id_ordenent=$tupla','','width=303,height=163,top=100,left=100,scrollbars=NO');
					 window.close();
				}
				else {
					$accfalse;
				}
				window.close();
				</script>";
		exit();
	}

//anadido por J.G 30-01-2019
	public function confirmf($msg, $acctrue, $accfalse, $idcotizacion,$margen){

		
		echo "	<script>
				if (confirm('$msg')){
					 window.open('../../COMMAND/nuevacotizacion/nueva_cotizacion_05.php?popup=1&aci=1&nac=1&id_cotizacion=$idcotizacion&margenOrden_ent=$margen','','top=20, left=100 ,width=800,height=780'); 
			         window.close(); 
				}
				else {
					window.close();
				}
				</script>";
		exit();
	}

	public function close(){
		echo "<script>window.close();</script>";
	}

	public function returnvalue($msg){
		echo "<script>window.returnValue = '$msg';</script>";
	}

	public function location($url){
		echo "<script>document.location = '$url';</script>";
		exit();
	}

	public function dump($list){
		echo "<pre>";
		print_r ($list);
		echo "</pre>";
	}

	public function QuitarAcentos($s) {
		$s = ereg_replace("[áàâãª]","a",$s);
   		$s = ereg_replace("[ÁÀÂÃ]","A",$s);
   		$s = ereg_replace("[ÍÌÎ]","I",$s);
   		$s = ereg_replace("[íìî]","i",$s);
   		$s = ereg_replace("[éèê]","e",$s);
   		$s = ereg_replace("[ÉÈÊ]","E",$s);
		$s = ereg_replace("[óòôõº]","o",$s);
   		$s = ereg_replace("[ÓÒÔÕ]","O",$s);
   		$s = ereg_replace("[úùû]","u",$s);
   		$s = ereg_replace("[ÚÙÛ]","U",$s);
   		$s = ereg_replace("['']"," ",$s);
   		$s = str_replace("ç","c",$s);
   		$s = str_replace("Ç","C",$s);
		$s = str_replace( "'", " ",$s);
		$s = str_replace( "''", " ",$s);
   		return $s;
}

	public function Quitartilde($s) {
		$s = ereg_replace("[�]","A",$s);
   		$s = ereg_replace("[�]","a",$s);
   		$s = ereg_replace("[�]","E",$s);
   		$s = ereg_replace("[�]","e",$s);
		$s = ereg_replace("[�]","i",$s);
   		$s = ereg_replace("[�]","I",$s);
		$s = ereg_replace("[�]","O",$s);
   		$s = ereg_replace("[�]","o",$s);
		$s = ereg_replace("[�]","U",$s);
   		$s = ereg_replace("[�]","u",$s);
   		return $s;
	}

	public function NoCaracteresEspeciales($s) {
		$CaracteresNoValidos = array("�", "�");
		$s= str_replace($CaracteresNoValidos ," ",$s);
		return $s;
	}
	
	public function ModificarAEntidadesHTML($s) {
		$sano = array("�", "�", "�","�","�","'",'"',"�","�","�","�","�","�","�","�","`","&#039;");
		$sabroso = array("&#148;","&#147;", "&frac14;","&frac12;","&frac34;"," ",' '," ","&reg;","&uml;","&deg;","&ordm;","&acute;","&Oslash;","&oslash;"," ","&acute;");
		$nueva_frase = str_replace($sano, $sabroso,$s);
		return $nueva_frase;
	}
	
	public function NoSQL($s) {
		$buscar = array("insert", "update", "like" ,"INSERT" ,"UPDATE" ,"LIKE");
		$nopermitodo = array(" "," "," "," "," "," ");
		$nuevo_string = str_replace($buscar, $nopermitodo,$s);
		return $nuevo_string;
	}

	/***********************************************************************************/
	// CompletaEspaciosD
	// Descripcion: Rellena una cadena con espacios a la derecha
	/***********************************************************************************/
	public function CompletaEspaciosD($variable, $tamano){
	    return  sprintf("%-".($tamano+0).".".($tamano+0)."s", $variable);
	}

	/***********************************************************************************/
	// CompletaCerosD
	// Descripcion: Rellena una cadena con ceros a la derecha
	/***********************************************************************************/
	public function CompletaCerosD($variable, $tamano){
	    return  sprintf("%-0".($tamano+0).".".($tamano+0)."s", $variable);
	}

	/***********************************************************************************/
	// CompletaCerosI
	// Descripcion: Rellena una cadena con ceros a la izquierda
	/***********************************************************************************/
	public function CompletaCerosI($variable, $tamano){
	    return  sprintf("%0".($tamano+0).".".($tamano+0)."s", $variable);
	}
        
        
    /* funciones de excel */

    function configureExcel(&$objPHPExcel, $creator = '', $title = ''){
        $objPHPExcel->getProperties()->setCreator($creator)
                ->setLastModifiedBy($creator)
                ->setTitle($title);
        $objPHPExcel->getActiveSheet()->setTitle($title);

        $objPHPExcel->setActiveSheetIndex(0);
        PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);


        $objPHPExcel->getActiveSheet()->setTitle($title);
    }

    function formatExcel(&$objPHPExcel, $ultimaColumna = 'A', $ultimaFila = 1){
        //encabezado
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $ultimaColumna . '1')->applyFromArray(
                array('fill' => array(
                        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('argb' => '999C9C9C')
                    )
                )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $ultimaColumna . $ultimaFila)->applyFromArray(
                array('borders' => array(
                        'inside'  => array('style' => PHPExcel_Style_Border::BORDER_DOTTED),
                        'outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                    )
                )
        );
        $objPHPExcel->getActiveSheet()->setAutoFilter("A1:${ultimaColumna}1");
        $i = 'A';
        while(strcmp(str_pad($i, strlen($ultimaColumna), ' ', STR_PAD_LEFT), str_pad($ultimaColumna, strlen($i), ' ', STR_PAD_LEFT)) <= 0){
            $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
            ++$i;
        }
    }

    function downloadExcel(&$objPHPExcel, $filename = '', $saveTo = null){
        $objPHPExcel->setActiveSheetIndex(0);
        PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
        
        if (is_null($saveTo)){
            // Redirect output to a client?s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
        }else
        {
            echo "Generando";
        }


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
       
        $objWriter->save((is_null($saveTo)) ? 'php://output' : $saveTo); 
        
    }

}

