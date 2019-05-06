<?
class getidaplicacion {
    /*** variables de clase ***/
	private $COD_CVE = NULL;
	private $OE_ID_WILLIAM = NULL;
	
	/*** constructor ***/
	public function __construct($nomgrupo = null){
		if ($nomgrupo)
			$mgrup = $nomgrupo;
		else
			$mgrup = 'IDENTIFICACION_DE_LA_APLICACION';
		
        $this->COD_CVE     = $_SESSION["CONFIG"]->getValue($mgrup,'COD_CVE');
        $this->OE_ID_WILLIAM     = $_SESSION["CONFIG"]->getValue($mgrup,'OE_ID_WILLIAM');
                
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
