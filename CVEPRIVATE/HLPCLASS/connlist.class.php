<?
class connlist {
    /*** variables de clase ***/
	private $first = NULL;
	private $last = NULL;
	private $act = NULL;
	
	/*** m?todos p?blicos ***/
    /*** constructor ***/
	public function __construct($elem = null){
		$this->first = NULL;
		$this->last = NULL;
		$this->act = NULL;
		if ($elem)
			$this->addfirst($elem);
	}

    /*** setters***/
    protected function __set($name, $value) {
        $this->$name = $value;
    }
    /*** getters ***/
    protected function __get($name) {
        return $this->$name;
    }
	public function addfirst($DTOgeneric){
		$firstttemp = $this->first;
		$this->first = new elementconnlist($DTOgeneric);
		if ($this->isnotnull($firstttemp))
			$firstttemp->prev = $this->first; 
		$this->first->next = $firstttemp;
		$this->first->prev = NULL;
		if (!$this->isnotnull($this->last))
			$this->last = $this->first; 
		$firstttemp = NULL;
	}

	public function addlast($DTOgeneric){
		$lasttemp = $this->last;
		$this->last = new elementconnlist($DTOgeneric);
		if ($this->isnotnull($lasttemp))
			$lasttemp->next = $this->last; 
		$this->last->prev = $lasttemp;
		$this->last->next = NULL;
		if (!$this->isnotnull($this->first))
			$this->first = $this->last; 
		$lasttemp = NULL;
	}

	public function remfirst(){
		$firsttemp = NULL;
		if ($this->isnotnull($this->first)) {
			$firsttemp = $this->first->next;
			if ($this->act == $this->first)
				$this->act = $firsttemp; 
			$this->first->next = NULL;
			$firsttemp->prev = NULL;
			$this->first->elem = NULL;
			$this->first = $firsttemp;
			$firsttemp = NULL;
		}
	}

	public function remlast(){
		$lasttemp = NULL;
		if ($this->isnotnull($this->last)) {
			$lasttemp = $this->last->prev;
			if ($this->act == $this->last)
				$this->act = $lasttemp; 
			$this->last->prev = NULL;
			$lasttemp->next = NULL;
			$this->last->elem = NULL;
			$this->last = $lasttemp;
			$lasttemp = NULL;
		}
	}

	public function remact(){
		if ($this->isnotnull($this->act)) {
			if ($this->isfirst($this->act))
				$this->remfirst();
			elseif ($this->islast($this->act))
				$this->remlast();
			else {
				$this->act->prev->next = $this->act->next;
				$this->act->next->prev = $this->act->prev;				
				$this->act->next = NULL;				
				$this->act->prev = NULL;				
				$this->act->elem = NULL;				
				$this->act = NULL;				
			}
		}
	}

	public function clearlist(){
		$this->first = NULL;
		$this->last = NULL;
		$this->act = NULL;
	}

	public function gonext(){
		if ($this->isnotnull($this->act))
			$this->act = $this->act->next;

		if ($this->isnotnull($this->act))
			return true;
		else 
			return false;
	}

	public function goprev(){
		if ($this->isnotnull($this->act))
			$this->act = $this->act->prev;

		if ($this->isnotnull($this->act))
			return true;
		else 
			return false;
	}

	public function gofirst(){
		$this->act = $this->first;

		if ($this->isnotnull($this->act))
			return true;
		else 
			return false;
	}

	public function golast(){
		$this->act = $this->last;

		if ($this->isnotnull($this->act))
			return true;
		else 
			return false;
	}

	public function getelem(){
		if ($this->isnotnull($this->act)){
			return $this->act->elem;
		}
		//else
		//	echo "No es objeto";
	}

	public function setelem($el){
		if ($this->isnotnull($this->act)){
			$this->act->elem = $el;
		}
	}

	public function numelem(){
		$counter = 0; 
		if (isset($this->first)) {
			$counter = 1; 
			$inicio = $this->first;
		}
		while ($counter>0 && isset($inicio->next)){
			$inicio = $inicio->next;
			++$counter; 
		}
		return $counter;
	}

	public function isvoid(){
		if ($this->isnotnull($this->act)){
			return false;
		}
		else
			return true;
	}

	public function isnotnull($nodo){
		if (isset($nodo))
			return true;
		else
			return false;
	}
	/*** metodos privados ***/
	private function isfirst($nodo){
		if ($this->isnotnull($nodo) && !$this->isnotnull($nodo->prev))
			return true;
		else
			return false;
	}

	private function islast($nodo){
		if ($this->isnotnull($nodo) && !$this->isnotnull($nodo->next))
			return true;
		else
			return false;
	}
	
		public function listar(){
				$this -> gofirst();
				do { 
					$this -> mostrar_elemento(); 
					$this -> gonext();
					if ($this -> actual -> getnext() == null)
						$this -> mostrar_elemento(); 

				} while ($this -> actual -> getnext());
		}
}
?>
