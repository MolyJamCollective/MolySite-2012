<?php

include_once("./objects/class.ftp.php");

class Cache 
{
	protected $includedFiles = array( "display", "archive" );
	
	function getCacheFilename()
	{
		$getString = "";
		
		foreach( $_GET as $key => $value )
		{
			$getString .= "." . $key . "." . $value;
		}
		
	    return $GLOBALS['configuration']['cache_dir'] . pathinfo( $_SERVER["SCRIPT_NAME"], PATHINFO_FILENAME ) . $getString . ".html";
	}
	
	function cachedFileExists()
	{
		return file_exists( $this->getCacheFilename() ) && filesize( $this->getCacheFilename() ) > 1;
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
		if( in_array( pathinfo( $_SERVER["SCRIPT_NAME"], PATHINFO_FILENAME ), $this->includedFiles ) )
		{
			file_put_contents( $this->getCacheFilename(), ob_get_contents() );
		}
	}
	
	function push()
	{
		ob_end_flush(); 
	}
	
	function deleteCachedFile( $filename, $deleteSimilar = false )
	{
		$FTP = new ftp();
		
		if( $deleteSimilar == true )
		{
			$list = $FTP->nlist( $GLOBALS['configuration']['cache_dir'] );
			
			foreach( $list as $value )
			{
				if( substr( $value, strlen( $GLOBALS['configuration']['cache_dir'] ), strlen( $filename ) ) == $filename )
				{
					$FTP->delete( $value );
				}
			}
		}
		
		$FTP->delete( $GLOBALS['configuration']['cache_dir'] . $filename . ".html" );
	}
}

?>