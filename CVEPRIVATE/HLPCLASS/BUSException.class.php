<?
class BUSException extends Exception
{
    public function __construct($error='', $code = 0) {
    	parent::__construct($error, $code);
    }
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
?>