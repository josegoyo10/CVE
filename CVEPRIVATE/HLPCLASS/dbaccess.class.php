<?
class DBAccess {
    /*** variables de clase ***/
    private $arrayValidTypes  = array("d"=>1 ,"f"=>2,"n"=>3,"s"=>4);
    private  $link  = null;
    private  $res   = null;  

    /*** constructor ***/
    function __construct($server='', $username='', $password='', $database=''){
    	if($this->link = mysqli_connect($server, $username,$password,$database)){
            return true;
        }else{
            return false;
        } 
    }

    /*** m�todos p�blicos ***/
    public function errno() 
    { 
        return mysqli_errno($this->link); 
    } 

    public function error() 
    { 
        return mysqli_error($this->link); 
    } 

    public static function escape_string($string) 
    { 
        return mysqli_real_escape_string($string); 
    } 
    
    private function validateDateTime(){
    	//
    }
    
    private function validateType($type,$value){
        if ($this->arrayValidTypes[$type] == 1){//date falata validar formato de fecha
            return true;    
        }else{
            if ($this->arrayValidTypes[$type] == 2){
                if(is_float($value)){
                    return true;
                }else{
                    return false;
                }   
            }else{
                if ($this->arrayValidTypes[$type] == 3){
                    if(is_numeric($value)){
                        return true;
                    }else{
                        return false;
                    }     
                }else{
                    if ($this->arrayValidTypes[$type] == 4){
                        if(is_string($value)){
                            return true;
                        }else{
                            return false;
                        }     
                    }else{
                        return false;                        
                    }                    
                }                
            }           
        }
    }

    public function query($query,$arrayValues="",$arrayTypes=""){
        $error = false;     
        if (!$arrayTypes && !$arrayValues){
            if ($this->res = mysqli_query($this->link,$query)){
                return $this->res;
            }
        }else{//validar query
            if (is_array($arrayTypes) && is_array($arrayValues))   {
                $i = 0;
                foreach( $arrayTypes as $key => $type ) {
                    if (!$this->validateType($type,$arrayValues[$i])){
                        $error = true;
                        break;
                    }else{
                        $pos = strpos($query, "?");
                        $query_tmp1 = substr($query, 0, ($pos+1));  
                        $query_tmp2 = substr($query, ($pos+1));
                        $query = str_replace("?", $arrayValues[$i], $query_tmp1).$query_tmp2;
                    }
                    $i++; 
                                        
                }
                if (!$error){
                    if ($this->res = mysqli_query($this->link,$query)){
                        return $this->res;
                    }else{
                        return false;
                    }                   
                }else{
                    return false;
                }
            }else{
                return false;
            }           
        }   
    }          
          
    public function querynoselect($query){
		return mysqli_query($this->link,$query);
    }          
          
    public function fetch_array($result, $array_type = MYSQL_BOTH) 
    { 
        return mysqli_fetch_array($result, $array_type); 
    } 

    public function fetch_row($result) 
    { 
        return mysqli_fetch_row($result); 
    } 
     
    public function fetch_assoc($result) 
    { 
        return mysqli_fetch_assoc($result); 
    } 
     
    public function fetch_object($result) 
    { 
        return mysqli_fetch_object($result); 
    } 
     
    public function close() 
    { 
        return mysqli_close($this->link); 
    }  
    
    public function affected_rows(){

    	if (mysqli_affected_rows( $this->link )){
            return mysqli_affected_rows( $this->link );
        }else{
            return false;
        }
    }

    public function num_rows(){
        if (mysqli_num_rows( $this->res )){
            return mysqli_num_rows( $this->res );
        }else{
            return false;
        }
    }

    public function query_array($name_query){
    	
    }

    public function last_insert_id(){
    	//return $mysqli->insert_id;
    	return mysqli_insert_id($this->link);
    }
}
?>
