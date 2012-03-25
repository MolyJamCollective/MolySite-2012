<?php

//-----------------------------\\
// class.ftp.php               \\
// 31.10.2005 - Oliver Eberlei \\
//-----------------------------\\

/*
Purpose:	Offers FTP/SFTP functionality
*/

if(! class_exists("ftp") ) :

class ftp
{
    var $conn;
    var $connected;
    
    //Constructor
    //Purpose:	Setup variables
    function ftp() 
	{
        $this->connected = false;
        $this->connect();
	}
	
	//login
	//Purpose:	Connect to FTP
	function connect()
	{
        $this->conn=ftp_connect( $GLOBALS['configuration']['ftp_host'] );
        
        if( !$this->conn )
        {
        	$this->connected = false;
       	}
        else
        {
	        $login_result = ftp_login( $this->conn, $GLOBALS['configuration']['ftp_user'], $GLOBALS['configuration']['ftp_pass'] );
	        
			if ( $this->conn && $login_result ) 
			{
	            $this->connected = true;
	        }
			else
			{
	            $this->connected = false;
   			}
		}

		if( !$this->connected )
		{
			return el()->error( "FTP connection failed!" );
		}
		
		if( $GLOBALS['configuration']['ftp_root'] != "" )
		{
			ftp_chdir( $this->conn, $GLOBALS['configuration']['ftp_root'] );
		}
	}
	
	//isConnected
	//Returns:	Is the ftp connection active?
	function isConnected() 
	{
        return $this->connected;
    }
    
    //getFilename
    //Purpose:	Extracts the filename from a path
    //Params:	$filename	path
    //Returns:	filename
    function getFilename($filename) 
	{
        $e = explode("\\", $filename);
        $file = $e[(count($e)-1)];
        return $file;
    }
	
	//getExt
    //Purpose:	Extracts the extention from a path
    //Params:	$filename	path
    //Returns:	extention
	function getExt($filename) 
	{
        $e = explode(".", $filename);
        $ext = $e[(count($e)-1)];
        return $ext;
    }
	
	//upload
	//Purpose:	Upload specified file
	//Params:	$local_file		Path to locally stored file
	//			$remote_file	Destination for the file
	//Returns:	bool	Successful?
	//-Upload to temp location and rename afterwards
	function upload($local_file,$remote_file) 
	{
	 	if(!$this->connected)
	 		$this->login();
	 	
        return ftp_put( $this->conn, $remote_file, $local_file, FTP_BINARY );
    }
    
    //nlist
    //Purpose:	Get folder structure
    //Returns:	Array of filenames or FALSE
    function nlist($folder) 
	{
		return ftp_nlist( $this->conn, $folder );
    }
    
	//mkdir
	//Purpose:	Create a directory
	//Params:	$dir	name of directory
	function mkdir( $dir )
	{
		return ftp_mkdir( $this->conn, $dir );
	}
	
    //rename
    //Purpose:	Rename a file
    //Params:	$old	old filename
    //			$new	new filename
    function rename($old, $new) 
    {
        ftp_rename( $this->conn, $old, $new );
    }
    
    //delete
    //Purpose:	Delete a file
    //Params:	$file	File to be deleted
    function delete( $file ) 
    {
	if( !file_exists( $file ) )
	{
	    echo "FTP delete: File not found (".$file.")";
	}
			
	return ftp_delete( $this->conn, $file );
    }
    
    function rmdir( $dir )
    {
   	return ftp_rmdir( $this->conn, $dir );
    }
    
    function chmod( $file, $mode )
    {
    	return ftp_chmod( $this->conn, $mode, $file );
    }
	
    //close
    //Purpose:	Close FTP connection
    function close() 
    {
		ftp_close($this->conn);
    }
}

endif;

?>