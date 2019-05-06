<?
class getidmensaje {
    /*** variables de clase ***/
	private $ID_MENSAJE_MA = NULL;
	private $ID_MENSAJE_MB = NULL;
	private $ID_MENSAJE_MC = NULL;
	private $ID_MENSAJE_MD = NULL;
	private $ID_MENSAJE_ME = NULL;
	

    /*** constructor ***/
    public function __construct($nomgrupo = NULL, $noini = FALSE){
        if($noini){
            if($nomgrupo === NULL){
                return;
            }
            $db = $_SESSION["DBACESS"];
            $query = "SELECT VAR_ID, VAR_LLAVE "
                    . "FROM glo_variables "
                    . "WHERE VAR_LLAVE LIKE '${nomgrupo}_%' "
                    . "ORDER BY VAR_LLAVE";
            if($res = $db->query($query)){
                $l = 'A';
                while($row = $res->fetch_assoc()){
                    //se esperan 5 valores: A, B, C, D, E.
                    //Como son menos de 10, se asumen correctamente ordenador por clausula order by
                    $this->{'ID_MENSAJE_M' . $l} = $row['VAR_ID'];
                    $l++;
                }
            }else{
                throw new DAOException(__CLASS__, __FUNCTION__, $db->error(), $query, 1);
            }
        }else{
            if($nomgrupo){
                $mgrup = $nomgrupo;
            }else{
                $mgrup = 'MENSAJES';
            }

            $this->ID_MENSAJE_MA = $_SESSION["CONFIG"]->getValue($mgrup, 'ID_MENSAJE_MA');
            $this->ID_MENSAJE_MB = $_SESSION["CONFIG"]->getValue($mgrup, 'ID_MENSAJE_MB');
            $this->ID_MENSAJE_MC = $_SESSION["CONFIG"]->getValue($mgrup, 'ID_MENSAJE_MC');
            $this->ID_MENSAJE_MD = $_SESSION["CONFIG"]->getValue($mgrup, 'ID_MENSAJE_MD');
            $this->ID_MENSAJE_ME = $_SESSION["CONFIG"]->getValue($mgrup, 'ID_MENSAJE_ME');
        }
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
