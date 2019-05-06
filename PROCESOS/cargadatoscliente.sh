#!/bin/sh
SHELL=/bin/sh
gunzip -q /var/www/bin/cve/archivos/arch_in/*
/usr/local/bin/php /var/www/bin/cve/cargadatoscliente.php SYSTEM

