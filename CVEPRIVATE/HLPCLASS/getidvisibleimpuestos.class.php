<?
class getidvisibleimpuestos {
    /*** variables de clase ***/
	private $FLETES = NULL;
	private $IMPUESTO_RETEIVA = NULL;
	private $IMPUESTO_RENTA = NULL;
	private $IMPUESTO_ICA = NULL;
	

	/*** constructor ***/
	public function __construct($nomgrupo = null){
		if ($nomgrupo)
			$mgrup = $nomgrupo;
		else
			$mgrup = 'VISIBLE_IMPUESTOS';
		
        $this->FLETES		     = $_SESSION["CONFIG"]->getValue($mgrup,'FLETES');
        $this->IMPUESTO_RETEIVA  = $_SESSION["CONFIG"]->getValue($mgrup,'IMPUESTO_RETEIVA');
        $this->IMPUESTO_RENTA    = $_SESSION["CONFIG"]->getValue($mgrup,'IMPUESTO_RENTA');
        $this->IMPUESTO_ICA      = $_SESSION["CONFIG"]->getValue($mgrup,'IMPUESTO_ICA');
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