<?php
if( isset($_POST['hidden'])  ) {
    if($_POST['key'])
    $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
    
    $file = fopen($_POST['key'], 'r');
    $key256 = fread($file, 32);
    fclose($file);
    $file = fopen($_POST['iv'], 'r');
    $iv = fread($file, 16);
    fclose($file);
    
    $v[0] = "ru";
    
    for($i=1; $i<=4; $i++){
        if (mcrypt_generic_init($cipher, $key256, $iv) != -1)
	{
		$v[] = mcrypt_generic($cipher,$_POST['v'.$i] );
		mcrypt_generic_deinit($cipher);
	}
    }
    
    echo '
    <br><br>
    Copie y pegue los datos generados en su configcve.ini en la sección DBUSER y DBPASS<br><br>
        [DATABASE]<br>
        DBUSER = '.bin2hex($v[1]).'<br>
        DBPASS = '.bin2hex($v[2]).'<br>

        <br>[DATABASE]<br>
        DBUSER = '.bin2hex($v[3]).'<br>
        DBPASS = '.bin2hex($v[4]).'<br>
<br>';
    
    
    
    
}else{
    $postVar = $_POST['key'];
    //echo "<form method='post' action='index.php'>
	echo"<form method='post' action='generadorClaves.php'>
    <p> En este Campo usted tiene que escribir la ruta tal cual esta en la barra del navegador de las carpetas ejemplo : c:\key</p>
        Key file: <input type='text' name='key' value='$postVar'> 
        <br> ruta del archivo de clave. Puede ser cualquier archivo. se leerán los primeros 32bytes(256bits) y se utilizarán como clave
        
                                                                    <br><br>
        <p> En este Campo usted tiene que escribir la ruta tal cual esta en la barra del navegador de las carpetas ejemplo : c:\iv</p>
        IV file: <input type='text' name='iv'> <br> ruta del archivo que contiene el vector de inicialicación.<br>
        <br><br>
        Escriba los datos del usuario y la password a encriptar<br>
        [DATABASE] <br>
        DBUSER = <input type='text' name='v1'> <br>
        DBPASS = <input type='text' name='v2'> <br>

        <br>[DATABASE] <br>
        DBUSER = <input type='text' name='v3'> <br>
        DBPASS = <input type='text' name='v4'> <br>
        <br>
        
        <p> al hacer click en hacer se codificaran las claves con los datos utilizados anteriormente.</p>
        <input type='hidden' value='true' name='hidden'>
        <input type=submit name=ok value=hacer>
        </form>";
}
?>
