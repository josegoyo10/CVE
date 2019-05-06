#!/bin/sh
DIA=`date +%d`

#Para el backup de la BD
rm -f /backup/cve/cve_$DIA.dump.gz
mysqldump --opt -u operador -poarcano CVE > /backup/cve/cve_$DIA.dump
gzip /backup/cve/cve_$DIA.dump

#Para el backup de la WEB
rm -f /backup/cve/cvepub_$DIA.tar.gz
rm -f /backup/cve/cvepri_$DIA.tar.gz
rm -f /backup/cve/cvepro_$DIA.tar.gz
tar -zcf /backup/cve/cvepub_$DIA.tar.gz /var/www/html/cve/
tar -zcf /backup/cve/cvepri_$DIA.tar.gz /var/www/class/cve/
tar -zcf /backup/cve/cvepro_$DIA.tar.gz /var/www/bin/cve/

