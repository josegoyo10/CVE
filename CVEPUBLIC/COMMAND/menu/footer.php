<?
$MiTemplate = new template;
// Agregamos el footer
$MiTemplate->set_file("footer","../../TEMPLATE/presentacion/footer.htm");

$MiTemplate->set_var('login', $ses_usr_login);
$MiTemplate->set_var('nom_local', ($ses_usr_nomlocal)?$ses_usr_nomlocal:'- No Asignado -');
$MiTemplate->set_var('fecha', $ses_usr_fecha);
//Mantis 26826 Inicio
$MiTemplate->set_var('version', VERSION);
$MiTemplate->set_var('fechaversion', FECHA_VERSION);
//Mantis 26826 Fin
$MiTemplate->pparse("OUT_H", array("footer"), false);
$MiTemplate->p("OUT_M");


