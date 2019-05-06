<?php
/******************************************************************************************************************
//Descripcion : Esta clase representa un elemento de la estructura de lista.
******************************************************************************************************************/

class elemento{
	public $anterior  = NULL;
	public $siguiente = NULL;
	public $data	  = NULL;

	public function set_data($data){
		$this -> data = $data;
	}
	public function set_anterior($anterior){
		$this -> anterior = $anterior;
	}
	public function set_siguiente($siguiente){
		$this -> siguiente = $siguiente;
	}
	public function get_data(){
		return $this -> data;
	}
	public function get_anterior(){
		return $this -> anterior;
	}
	public function get_siguiente(){
		return $this -> siguiente;
	}
}
?>