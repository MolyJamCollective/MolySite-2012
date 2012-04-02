<?php

class Cache 
{
	//protected $includedFiles = array( "
	function getCacheFilename()
	{
	    return $GLOBALS['configuration']['cache_dir'] . pathinfo( $_SERVER["SCRIPT_NAME"], PATHINFO_FILENAME ) . ".html";
	}
	
	function cachedFileExists()
	{
		return file_exists( $this->getCacheFilename() );
	}
	
	function renderCachedFile()
	{
		echo file_get_contents( $this->getCacheFilename() );
	}
	
	function start()
	{
		ob_start();
	}
	
	function save()
	{
		file_put_contents( $this->getCacheFilename(), ob_get_contents() );
	}
	
	function push()
	{
		ob_end_flush(); 
	}
}

?>