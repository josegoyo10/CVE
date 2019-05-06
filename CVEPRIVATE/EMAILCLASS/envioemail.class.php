<?
require "email/class.phpmailer.php";
class  envioemail{
  
  function envio($List) {
  
  $List->gofirst();	
  if($List->getelem()->AddAddress){
  $mail = new phpmailer();
  //$mail->PluginDir = "email/";
  $mail->IsSMTP();
  $mail->Host = "172.28.0.15";
  $mail->SMTPAuth = $List->getelem()->SMTPAuten;
  $mail->Username = $List->getelem()->Usuarioemail; 
  $mail->Password = $List->getelem()->Passwordemail;
  $mail->From = $List->getelem()->From;
  $mail->FromName = $List->getelem()->FromName;
  $mail->AddAddress($List->getelem()->AddAddress);
  (($List->getelem()->AddCC)? $mail->AddCC($List->getelem()->AddCC): "");
  (($List->getelem()->AddBCC)?$mail->AddBCC($List->getelem()->AddBCC):"");
  $mail->Subject =  str_replace('</p>','',str_replace('<p class="mceNonEditable">','',$List->getelem()->Asunto));
  $mail->Body = $List->getelem()->Contenido; 
  $mail->AltBody = $List->getelem()->AltBody;
  if($List->getelem()->Tipoemail=="CO"){
  	if($List->getelem()->AddAttachment=='YES'){
  	$mail->AddAttachment("/var/www/html/cvecolombia/CVEPRIVATE/CREATEPDF/archivos_pdf/CotizacionCVE_".$List->getelem()->id_cot.".pdf","CotizacionCVE_".$List->getelem()->id_cot.".pdf");
  	}
  	else{
  	$mail->AddEmbeddedImage("/var/www/html/cvecolombia/CVEPUBLIC/IMAGES/logotipo_negro.gif","logotipo_negro.gif");
  	$mail->AddEmbeddedImage("/var/www/html/cvecolombia/CVEPUBLIC/IMAGES/barra.gif","barra.gif");	
  	}
  
  }
  $exito = $mail->Send();

 $intentos=1; 
  while ((!$exito) && ($intentos < 2)) {
	sleep(3);
     	$exito = $mail->Send();
     	$intentos=$intentos+1;	
	
   }
 
 $List->clearlist();
 $Listres = new dtoemail;
   if(!$exito)
   {
   	$Listres->Respuesta="Problemas enviando correo, detalle del problema:".$mail->ErrorInfo."";
   	//$Listres->Respuesta="Problemas enviando correo electronico a".$valor."";
   }
   else
   {
   	$Listres->Respuesta="Mensaje enviado correctamente";
   }
   
  }
  else{
  	$List->clearlist();
 	$Listres = new dtoemail;
 	$Listres->Respuesta="es necesario ingresar la direccion de coreo electronico del cliente";
 	
  }
  $List->addlast($Listres); 
  return true;
  }
}
?>