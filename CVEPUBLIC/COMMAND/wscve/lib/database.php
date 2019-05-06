<?

class database{

	function writeevent( $texto_in ) { 
	    global $ses_usr_login; 
	    $dir_log = $_SESSION["CONFIG"]->getValue('APPLICATION','PATH_LOG'); 
	    if( $dir_log && is_dir($dir_log)) { 
	        error_log( date("dmY His", time() ) . " " . $_SERVER["REMOTE_ADDR"] . " $ses_usr_login => " . $texto_in  . sprintf("%c%c",0x0D, 0x0A) , 3, $dir_log.date("Ymd", time() )."_event.log"); 
	    	return true; 
	    } 
	    else { 
	    	return false; 
	    } 
	}


// **********************
// MYSQL
// **********************



  function tep_db_connect() {
    global $db_link;
	$bd = $_SESSION["DBACESS"];	
    general::writeevent("Conectando a MYSQL server=".DB_SERVER." user=".DB_SERVER_USERNAME." pass=".DB_SERVER_PASSWORD."db=".DB_DATABASE);
    /*if (USE_PCONNECT) 
        @$db_link = mysql_pconnect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);
    else 
        @$db_link = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);

    if ($db_link) @mysql_select_db(DB_DATABASE);
        return $db_link;*/
  }

  function tep_db_close() {
    global $db_link;

    $result = mysql_close($db_link);
    
    return $result;
  }

  function tep_db_query($db_query) {
    global $db_link, $pag_ini, $REQUEST_URI;

    if (STORE_DB_TRANSACTIONS == 1) {
       general::writeevent("QUERY " . $db_query );
    }

    $result = mysql_query($db_query, $db_link);

    if (STORE_DB_TRANSACTIONS == 1) {
       $result_error = mysql_error();
       general::writeevent("RESULT | " . $result . " | " . $result_error);
    }
    else if(STORE_DB_TRANSACTIONS == 2) {
        if( $result == FALSE ) {
            $result_error = mysql_error();
            general::writeevent( "P?g: $pag_ini $REQUEST_URI" );
            general::writeevent("QUERY " . $db_query );
            general::writeevent("RESULT | " . $result . " | " . $result_error);
        }
    }

    return $result;
  }

  function tep_db_fetch_array($db_query) {

    $result = mysql_fetch_array($db_query);
    return $result;
  }

  function tep_db_num_rows($db_query) {

    $result = mysql_num_rows($db_query);

    return $result;
  }

  function tep_db_data_seek($db_query, $row_number) {

    $result = mysql_data_seek($db_query, $row_number);

    return $result;
  }

  function tep_db_insert_id( $nada ) {

    $result = mysql_insert_id();

    return $result;
  }

  function tep_db_free_result($db_query) {

    $result = mysql_free_result($db_query);

    return $result;
  } 
}
?>
