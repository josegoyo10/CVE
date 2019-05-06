<?
$MiTemplate = new template;
// Agregamos el footer
$MiTemplate->set_file("footer","../../TEMPLATE/presentacion/footer_operaciones.htm");

$MiTemplate->set_var('login', $ses_usr_login);
$MiTemplate->set_var('fecha', $ses_usr_fecha);

$MiTemplate->pparse("OUT_H", array("footer"), false);
$MiTemplate->p("OUT_M");

?>
