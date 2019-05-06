<?php

class ini {
	
	private $_iniFilename = '';
	private $_iniParsedArray = array();
	

    function __construct($filename) 
	{
		$this->_iniFilename = $filename;
		if($this->_iniParsedArray = parse_ini_file( $filename, true ) ) {
			return true;
		} else {
			return false;
		} 
	}
	
	/**
	* retorna la seleccion completa
	**/
	function getSection($key)
	{
	
		return $this->_iniParsedArray[$key];
	}
	
	/**
	*  retorna un valor de una sección  
	**/
	function getValue( $section, $key )
	{
		if(!isset($this->_iniParsedArray[$section])) return false;
		return $this->_iniParsedArray[$section][$key];
	}
	
	/**
	*  Retorna el valor de una sección o la sección entera  
	**/
	function get( $section, $key=NULL )
	{
		if(is_null($key)) return $this->getSection($section);
		return $this->getValue($section, $key);
	}
	
	/**
	* Setea un valor de acuerdo con la llave especificada 
	**/
	function setSection( $section, $array )
	{
		if(!is_array($array)) return false;
		return $this->_iniParsedArray[$section] = $array;
	}
	
	/**
	* fija un nuevo valor en una sección 
	**/
	function setValue( $section, $key, $value )
	{
		if( $this->_iniParsedArray[$section][$key] = $value ) return true;
	}
	
	/**
	* fija un nuevo valor en una sección o una sección entera 
	**/
	function set( $section, $key, $value=NULL )
	{
		if(is_array($key) && is_null($value)) return $this->setSection($section, $key);
		return $this->setValue($section, $key, $value);
	}
	
	/**
	* guarda el archivo Ini
	**/
	function save( $filename = null )
	{
		if( $filename == null ) $filename = $this->_iniFilename;
		if( is_writeable( $filename ) ) {
			$SFfdescriptor = fopen( $filename, "w" );
			foreach($this->_iniParsedArray as $section => $array){
				fwrite( $SFfdescriptor, "[" . $section . "]\n" );
				foreach( $array as $key => $value ) {
					fwrite( $SFfdescriptor, "$key = $value\n" );
				}
				fwrite( $SFfdescriptor, "\n" );
			}
			fclose( $SFfdescriptor );
			return true;
		} else {
			return false;
		}
	}
}
?>