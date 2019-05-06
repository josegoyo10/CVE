<?
class elementconnlist {
    /*** variables de clase ***/
	public $prev = NULL;
	public $next = NULL;
	public $elem = NULL;
    public $elemName = NULL;
	
	/*** constructor ***/
	public function __construct($DTOgeneric){
		$this->elem = $DTOgeneric;
	}
    /*** setters***/
    protected function __set($name, $value) {
        $this->$name = $value;
    }
    /*** getters ***/
    protected function __get($name) {
        return $this->$name;
    }
}
?>
