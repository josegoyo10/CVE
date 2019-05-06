<?php

class daoperfiles{

	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   

    public function getperfiles($List, $reporte = false) {
    	try {
            if($reporte){
                $res = $this->bd->query("SELECT PER_ID as id, PER_NOMBRE as nombre, PER_DESCRIPCION, PER_PADRE, PER_USR_CREA,"
                        . "PER_FEC_CREA, PER_USR_MOD, PER_FEC_MOD, solo_lectura FROM perfiles");
            }else{
                $res = $this->bd->query("select per_id as id, per_nombre as nombre from perfiles");
            }
        if (!$res) 
      	{
      		throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
      	}
        $List->clearlist();            
        while ($row = $res->fetch_assoc())
        {
            $Perfil = new dtoperfiles;
            $Perfil->id	= $row['id'];
            $Perfil->nombre	= $row['nombre'];
            if($reporte){
                $Perfil->descripcion = $row['PER_DESCRIPCION'];
                $Perfil->padre_id = $row['PER_PADRE'];
                $Perfil->usr_crea = $row['PER_USR_CREA'];
                $Perfil->fec_crea = $row['PER_FEC_CREA'];
                $Perfil->usr_mod = $row['PER_USR_MOD'];
                $Perfil->fec_mod = $row['PER_FEC_MOD'];
                $Perfil->solo_lectura = $row['solo_lectura'];
            }
            $List->addlast($Perfil);
        }
        $res->free();
    	}
    	catch(CTRLException $e) {throw new BUSException($e->getMessage(), $e->getCode());}
    	catch(DAOException $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    	catch(Exception $e) 	{throw new SYSException(__CLASS__ , __FUNCTION__ , $e->getMessage(), $e->getCode(), 3);}
    }
}
	
