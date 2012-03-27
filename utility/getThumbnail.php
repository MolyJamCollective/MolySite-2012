<?php
    include_once("../configuration.php");
    include_once("../objects/class.database.php");
    
    function GetThumbnailFilename( $file )
    {
    	return pathinfo( $file, PATHINFO_DIRNAME ) . "/" . pathinfo( $file, PATHINFO_FILENAME ) . "_thumb." . pathinfo( $file, PATHINFO_EXTENSION );
   	}
   	
    $connection = Database::Connect();
	$cursor = Database::Reader( "select `gamepictureurl` from `game` where `gameid`='".intval($_GET["id"])."' LIMIT 1", $connection);
	while ($row = Database::Read($cursor))
	{
		if( $row[ "gamepictureurl" ] != "" )
		{
			if( file_exists( GetThumbnailFilename( $row[ "gamepictureurl" ] ) ) )
			{
				echo "<img src='" .  GetThumbnailFilename( $row[ "gamepictureurl" ] ) . "' width='320' height='240' />";				
			}
			else
			{
				echo "<img src='" . $row[ "gamepictureurl" ] . "' width='320' height='240' />";				
			}						
		}	
		
		die();	
	}
	
	echo "Project Id not found! Id: " . $_GET["id"];
?>