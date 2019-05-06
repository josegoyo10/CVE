<?
class getrespuestaws {
    /*** variables de clase ***/
	private $RESPUESTABUSCARCU = NULL;
	/*** constructor ***/
	public function __construct($nomgrupo = null){
		if ($nomgrupo)
			$mgrup = $nomgrupo;
		else
			$mgrup = 'RESPUESTAWS';
		
    file_put_contents('responseClientWS.txt',$_SESSION["CONFIG"]);

       $this->RESPUESTABUSCARCU = $_SESSION["CONFIG"]->getValue($mgrup,'RESPUESTABUSCARCU');

          
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
