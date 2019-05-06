<?php
require_once('../../INCLUDE/nusoap/nusoap.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
//require_once('lib/nusoap.php');

 $wsdl = "http://10.95.48.80/Trunk/Colombia/CVE/CVE_PPAL/CVEPUBLIC/COMMAND/wscve/cotizarServer.php?wsdl"; 

 $client = new nusoap_client($wsdl, true);
 $error  = $client->getError();
  
  if(isset($_POST['cotizar'])){
      $idCotizacion = trim($_POST['cotizacion_id']);
 
	
	if ($error) {
		echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
	}
	 
	$result 	= $client->call("cotizarCVE.getCotizacion", array("idCotizacion" => $idCotizacion));
    $resultado    =  explode("Vendedor:", $result);
    $observacion  = $resultado[0]; 
    $codigo 	  = $resultado[1];




 
	if ($client->fault) {
		echo "<h2>Fault</h2><pre>";
		print_r($result);
		echo "</pre>";
	} else {
		$error = $client->getError();
		if ($error) {
			echo "<h2>Error</h2><pre>" . $error . "</pre>";
		} 
	}
 } else {
 		
       if(isset($_GET['idCotizacion']) OR (isset($_POST['idCotizacion']))){
 		   $idCotizacion = trim($_GET['idCotizacion']);
       
	
			if ($error) {
				echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
			}
			 
			$result = $client->call("cotizarCVE.getCotizacion", array("idCotizacion" => $idCotizacion));  $resultado   =  explode("Vendedor:", $result);
             $observacion = $resultado[0]; 
             $codigo 	  = $resultado[1];

		   
		   

			if ($client->fault) {
				echo "<h2>Fault</h2><pre>";
				print_r($result);
				echo "</pre>";
			} else {
				$error = $client->getError();
				if ($error) {
					echo "<h2>Error</h2><pre>" . $error . "</pre>";
				} 
			}


		}

}




?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/	bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
</head>
<body>
   <main role="main" class="container" style="padding-top:10px;">
      <div class='row'>
         <form class="form-inline" method='POST' name='form1'>
            <?php if($error) { ?> 
            <div class="alert alert-danger fade in">
               <a href="#" class="close" data-dismiss="alert">&times;</a>
               <strong>Error!</strong>&nbsp;<?php echo $error; ?> 
            </div>
            <?php } ?>
            <div class="form-group">
               <label for="nro_cotizacion">Nro Cotizaci&oacute;n:&nbsp;&nbsp;</label>
               <input type="text" class="form-control" name="cotizacion_id" id="cotizacion_id" placeholder="Ingrese ID de cotizacion">
            </div>
            <button type="submit" name='cotizar' class="btn btn-default">Enviar</button>
         </form>
		 <br><br><br>
	   </div>
		<div class="row">
		 <div class="col-md-8">
          <h2>Informacion Cotizaci&oacute;n</h2>
          <table class="table">
            <thead>
               <tr>
                  <th>Descripción Observación</th>
                  <th>Codigo Vendedor</th>
               </tr>
            </thead>
            <tbody>
              
               <TR>
			     <TD>
			     	<?php if(isset($result)) { ?>
				   		<p style="font-weight:bold;"><?php echo ucwords($observacion);?></p>
				   		
				   	<?php }else { ?>
                       <p style="font-weight:bold;">No hay Información para la cotizacion solicitada</p>

				   <?php	} ?>
				 </TD>
			      <TD>
                    <p style="font-weight:bold;">  <?php if(isset($codigo)) echo $codigo;?></p>

			      </TD>

			   </TR>
			   
		
               </tbody>
           </table>
		 </div>
	   </div> 
    </main>
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
</body>
</html>
