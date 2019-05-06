<?
class getidcontribuyente {
    /*** variables de clase ***/
	private $ID_NATURAL = NULL;
	private $ID_EMPRESARIAL = NULL;
	
	

	/*** constructor ***/
	public function __construct($nomgrupo = null){
		if ($nomgrupo)
			$mgrup = $nomgrupo;
		else
			$mgrup = 'CONTRIBUYENTE';
		
        $this->ID_NATURAL     = $_SESSION["CONFIG"]->getValue($mgrup,'ID_NATURAL');
        $this->ID_EMPRESARIAL     = $_SESSION["CONFIG"]->getValue($mgrup,'ID_EMPRESARIAL');
        
        
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