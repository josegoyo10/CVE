<?
class getidcontribuyente {
    /*** variables de clase ***/
	private $JURIDICO = NULL;
	private $EMPRESARIAL = NULL;
	private $NATURAL = NULL;
	private $SOCIOE = NULL;
	private $PROY_ESPECIALES = NULL;
	

	/*** constructor ***/
	public function __construct($nomgrupo = null){
		if ($nomgrupo)
			$mgrup = $nomgrupo;
		else
			$mgrup = 'CONTRIBUYENTE';
		
        $this->JURIDICO               = $_SESSION["CONFIG"]->getValue($mgrup,'JURIDICO');
        $this->EMPRESARIAL            = $_SESSION["CONFIG"]->getValue($mgrup,'EMPRESARIAL');
        $this->NATURAL                = $_SESSION["CONFIG"]->getValue($mgrup,'NATURAL');
        $this->SOCIOE                 = $_SESSION["CONFIG"]->getValue($mgrup,'SOCIOE');
        $this->PROY_ESPECIALES        = $_SESSION["CONFIG"]->getValue($mgrup,'PROY_ESPECIALES');
        
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
