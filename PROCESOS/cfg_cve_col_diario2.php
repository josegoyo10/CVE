<?php
// Datos de Conexion
$hostname = "localhost";
$database = "cvecolprod";
$username = "root";
$password = "3des*.";
$dias = 1;            // dias de pasada del log
$dias_limpieza = 3; // dias de limpieza de tabla teradata
$carpeta_info = "/var/www/html/cvecolombia/PROCESOS/archivos/arch_out_temp2/";  // Carpeta de almacenamiento interfase para las pruebas;
$log_dir   = "/var/www/html/cvecolombia/log/";     //  Carpeta almacenamiento log;
$file_log  = "cve_co_interfaces.log"   ;                    // archivo log
// FEchas para correr la rutina manual para correrlo con el Cron se deben // comentar las lineas $dia_ayer  y $dia_hoy.

$dia_ayer  = '2014-04-12';
$dia_hoy = '2014-04-13';
?>
