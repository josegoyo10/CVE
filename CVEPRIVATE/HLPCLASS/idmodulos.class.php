<?php
class idmodulos {

    /*** variables de clase ***/

	private $ID_MODULO_REIMPRESION = NULL;
	private $ID_MODULO_GDREIMPRESION = NULL;

	



	/*** constructor ***/

	public function __construct($nomgrupo = null){

		if ($nomgrupo)

			$mgrup = $nomgrupo;

		else

			$mgrup = 'ID_MODULO';

		

        $this->ID_MODULO_REIMPRESION     = $_SESSION["CONFIG"]->getValue($mgrup,'ID_MODULO_REIMPRESION');
        $this->ID_MODULO_GDREIMPRESION   = $_SESSION["CONFIG"]->getValue($mgrup,'ID_MODULO_GDREIMPRESION');

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