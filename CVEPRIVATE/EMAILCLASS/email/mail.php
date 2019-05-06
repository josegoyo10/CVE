<?php
   require CLASES."class.phpmailer.php";
   class envio
   {
       private $envimail;
       function __construct()
       {
       $this->envimail = new PHPMailer();
        $this->envimail->IsSMTP();
        $this->envimail->SMTPDebug = 2;
        $this->envimail->IsHTML(true);
        $this->envimail->Host     = HOST;
        $this->envimail->From     = USERNAME;
        $this->envimail->FromName = NOMBREC;
       }

       function envia($destino,$nombre,$cabecera,$detalle,$replys=null,$nombresrp=null,$replyscopia=null,$nombrescopia=null)
       {
            //ini_set("display_errors",0);
            $this->envimail->Subject = $cabecera;
            $this->envimail->MsgHTML($detalle);
            $this->envimail->AddAddress($destino, $nombre);
            $archivo=LOGS."logmail.txt";
            $fp=fopen($archivo,"a+");
            if ($replys<>null)
            {
                while(list($clave,$valor)=each($replys))
                {
                    $this->envimail->AddAddress($valor,$nombresrp[$clave]);
                }
            }
            if ($replyscopia<>null)
			            {
			                while(list($clave,$valor)=each($replyscopia))
			                {
			                    $this->envimail->AddCC($valor,$nombrescopia[$clave]);
			                }
            }
            $exito = $this->envimail->Send();
            fwrite($fp,date("l, F j, Y. h:i A")."# seguimiento correo #".$destino."#".$nombre."#".$exito."\r\n");
            fclose($fp);

       }
       function adicionadireccion($direcciones,$nombre)
       {
           $this->envimail->AddAddress($direcciones,$nombre);
       }
       function Abrehtml($archivo)
       {
           $cadena="";
           if($fp=fopen($archivo,'rb'))
           {
               while(!feof($fp))
               {
                   $cadena.=fread($fp,1024);
               }
               fclose($fp);
           return $cadena;
           }
           else
           {
               return false;
           }
       }
}
?>
