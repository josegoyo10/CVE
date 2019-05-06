<?php

function decode($string) {
    $ruta_key = 'C:/wamp/www/Trunk/Colombia/CVE/CVE_PPAL'.DIRECTORY_SEPARATOR.'key';
    $ruta_iv = 'C:/wamp/www/Trunk/Colombia/CVE/CVE_PPAL'.DIRECTORY_SEPARATOR.'iv';
    
    $file = fopen($ruta_key, 'r');
    $key256 = fread($file, 32);
    fclose($file);
    
    $file = fopen($ruta_iv, 'r');
    $iv = fread($file, 16);
    fclose($file);

    $decipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
    mcrypt_generic_init($decipher, $key256, $iv);

    $texto = mdecrypt_generic($decipher, hex2bin($string));
    mcrypt_generic_deinit($decipher);
    mcrypt_module_close($decipher);
    return $texto;
}

function hex2bin($h){
    if (!is_string($h)) return null;
    $r='';
    for ($a=0; $a<strlen($h); $a+=2) { $r.=chr(hexdec($h{$a}.$h{($a+1)})); }
    return $r;
}

?>
