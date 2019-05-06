<?
class SYSException extends Exception
{
    public function __construct($clase, $funcion, $error='', $query='', $code = 0) {
		general::writelog ("ERROR SYSExcepcion: Clase $clase, metodo $funcion, Descripcion: $error [$query]");
    	parent::__construct(MSG_ERR_APP, $code);
    }
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
?>