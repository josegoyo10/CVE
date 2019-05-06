<?
class getdbconfig {
    /*** variables de clase ***/
	private $DBSERVER = NULL;
	private $DBUSER = NULL;
	private $DBPASS = NULL;
	private $DBDATABASE = NULL;	

	/*** constructor ***/
	public function __construct($nomgrupo = null){
		if ($nomgrupo)
			$mgrup = $nomgrupo;
		else
			$mgrup = 'DATABASE';
		
        $this->DBSERVER     = $_SESSION["CONFIG"]->getValue($mgrup,'DBSERVER');        
        $this->DBUSER       = $_SESSION["CONFIG"]->getValue($mgrup,'DBUSER');
        $this->DBPASS       = $_SESSION["CONFIG"]->getValue($mgrup,'DBPASS');
        $this->DBDATABASE   = $_SESSION["CONFIG"]->getValue($mgrup,'DBDATABASE');
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
