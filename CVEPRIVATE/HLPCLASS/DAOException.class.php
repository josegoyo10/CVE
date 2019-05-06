<?
class DAOException extends Exception
{

    public function __construct($clase, $funcion, $error='', $query='', $code = 0) {
		
        		

		general::writelog ("ERROR DAOExcepcion: Clase $clase, metodo $funcion, Descripcion: $error [$query]");
        


       //Añadido por J.G 07-03-2019
        $url 		= $_SERVER['REQUEST_URI'];
        $usuario_id = $_SESSION["ses_usr_id"];
       // file_put_contents('url.txt',$_SESSION["ses_usr_id"]);
        
        bizcve::LogErrors($clase, $funcion, $error, $query, $code, $url,$usuario_id);

    	parent::__construct("Error $clase funcion $funcion", $code);
    }
    

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }





}
?>