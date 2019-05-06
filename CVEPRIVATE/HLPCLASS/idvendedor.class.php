<?php
class idvendedor {

    /*** variables de clase ***/

	private $VENDE = NULL;
	

	/*** constructor ***/

	public function __construct($nomgrupo = null){

		if ($nomgrupo)

			$mgrup = $nomgrupo;

		else

			$mgrup = 'VENJUR';

		

        $this->VENDE     = $_SESSION["CONFIG"]->getValue($mgrup,'VENDE');
        

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