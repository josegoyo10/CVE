<?php
    class Syslog
    {
        public static function info($msg=""){
            define_syslog_variables();
            return syslog(LOG_INFO, $msg);
        }
        
        public static function warning($msg=""){
            define_syslog_variables();
            return syslog(LOG_WARNING, $msg);
        }
        
        public static function error($msg=""){
            define_syslog_variables();
            return syslog(LOG_CRIT, $msg);
        }        
    }

?>