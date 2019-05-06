<?

class daomargen{
    /*     * * atributos ** */

    private $bd = NULL;

    /*     * * constructor ** */

    public function __construct(){
        $this->bd    = $_SESSION["DBACESS"];
        $conf        = new getdbconfig("DATABASE_CPE");
        $this->bdcpe = new DBAccess2($conf->DBSERVER, $conf->DBUSER,
                                     $conf->DBPASS, $conf->DBDATABASE);
        if(!$this->bdcpe->isconnected()){
            throw new DAOException(__CLASS__, __FUNCTION__,
                                   "No se ha podido conectar a Base de Datos [DBSERVER:" . $conf->DBSERVER . ", USER:" . $conf->DBUSER . ", PASS:********, DB:" . $conf->DBDATABASE . "]",
                                   0, 1);
        }
    }

    public function __destruct(){
        //$this->bd->close();
    }

    function escribe_log($cadena2){
        $log = "test.txt";
        $f2  = fopen($log, "a+");
        fwrite($f2, $cadena2 . "\r\n");
        fclose($f2);
        return;
    }

    public function getDatosMargen($cat){
        $queryCPE = "SELECT nivel2.id_catprod AS rubro "
                . "FROM catprod nivel3 JOIN catprod nivel2 "
                . "ON nivel3.id_catpadre = nivel2.id_catprod "
                . "WHERE nivel3.id_catprod = $cat";
        $rescpe   = $this->bdcpe->query($queryCPE);
        if(!$rescpe){
            throw new DAOException(__CLASS__, __FUNCTION__,
                                   $this->bdcpe->error(), $queryCPE, 1);
        }
        $rowcpe = $rescpe->fetch_assoc();
        $query  = "SELECT id_margen, id_seccion, desc_seccion, id_rubro, desc_rubro, margen "
                . "FROM margenxrubro "
                . "WHERE id_rubro  = " . $rowcpe['rubro'];
        //general::writeevent($query);
        $res    = $this->bd->query($query);
        if(!$res){
            throw new DAOException(__CLASS__, __FUNCTION__, $this->bd->error(),
                                   $query, 1);
        }
        $row = $res->fetch_assoc();
        return $row;
    }

    public function getMargenProd($prod){
        $query = "SELECT margen "
                . "FROM margenxproducto "
                . "WHERE producto = $prod;";
        $res   = $this->bd->query($query);
        if(!$res){
            throw new DAOException(__CLASS__, __FUNCTION__, $this->bd->error(),
                                   $query, 1);
        }
        return $res->fetch_assoc();
    }

}

?>
