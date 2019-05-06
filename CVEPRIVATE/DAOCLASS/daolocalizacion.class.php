<? 
class daolocalizacion{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   
   
	public function getlocalizacion($List) {

      file_put_contents('getLocaliz.txt', print_r($List,true));
         

		$List->gofirst();

		((strlen($List->getelem()->id_localizacion)<14)?$localizacioncli='0'.$List->getelem()->id_localizacion : $localizacioncli=$List->getelem()->id_localizacion);

		$localizaciondepto=substr($localizacioncli, 0, -12);
        //file_put_contents('query.txt',$localizaciondepto);
		$localizacionprovin=substr($localizacioncli, 2, -9);
		$localizacionciudad=substr($localizacioncli, 5, -6);
		$localizacionlocalidad=substr($localizacioncli, 8, -3);
		$localizacionbarrio=substr($localizacioncli, 11);

		$query = "SELECT e.ID as id_barrio, e.ID_DEPARTMENT as id_departamento, e.ID_PROVINCE as id_provincia, e.ID_CITY as id_ciudad, e.ID_LOCALITY as id_localidad, a.DESCRIPTION as departamento,b.DESCRIPTION as provincia,c.DESCRIPTION as ciudad,d.DESCRIPTION as localidad,e.DESCRIPTION as barrio FROM cu_department a inner join cu_province b
on (a.ID=b.ID_DEPARTMENT) inner join cu_city c on (b.ID=c.ID_PROVINCE and b.ID_DEPARTMENT=c.ID_DEPARTMENT) inner join  cu_locality d
on (d.ID_DEPARTMENT=c.ID_DEPARTMENT and c.ID_PROVINCE=d.ID_PROVINCE and c.ID=d.ID_CITY) inner join cu_neighborhood e
on (d.ID_DEPARTMENT=e.ID_DEPARTMENT and d.ID_PROVINCE=e.ID_PROVINCE and d.ID_CITY=e.ID_CITY and d.ID=e.ID_LOCALITY)
where e.ID=".$localizacionbarrio." and e.ID_DEPARTMENT=".$localizaciondepto." and e.ID_PROVINCE=".$localizacionprovin." and e.ID_CITY=".$localizacionciudad."  and e.ID_LOCALITY=".$localizacionlocalidad."";
      
         file_put_contents('queryFletes.txt', $query); 
         file_put_contents('queryFletes2.txt', $query); 


        $res = $this->bd->query($query);
        //general::writeevent($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $User = new dtolocalizacion;
            $User->departamento = $row['departamento'];
            $User->id_departamento = $localizaciondepto;                
            $User->provincia= $row['provincia'];  
            $User->id_provincia = $localizacionprovin;
            $User->ciudad= $row['ciudad'];
            $User->id_ciudad = $localizacionciudad;
            $User->localidad= $row['localidad'];
            $User->id_localidad = $localizacionlocalidad;
            $User->barrio= $row['barrio'];             
            $User->id_barrio= $localizacionbarrio;                                    
            $List->addlast($User);
        }
        $res->free();
        return true;
    }

}
?>
