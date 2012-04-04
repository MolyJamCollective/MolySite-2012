<?php
// ------------- Start Functions

    include_once("./configuration.php");
    include_once("./objects/class.database.php");
           
           
           $connection = Database::Connect();
           
    if( !empty( $_GET[ "edit" ] ) )
    {
    	$newFile = 'uploads/' . $_GET[ "edit" ] . '/game.zip';
    	Database::InsertOrUpdate( "update `game` SET `gamefileurl`='".$newFile."' WHERE `gameid`='" . $_GET[ "edit" ] . "'", $connection);
   	}

		$cursor = Database::Reader("select * from `game`", $connection);
		while ($row = Database::Read($cursor))
		{
			if( $row['gamefileurl'] != "" 
			 && substr( $row['gamefileurl'], 0, strlen( "uploads" ) ) != "uploads" )
			{
				echo "Id: " . $row['gameid'] . " - Name: " . $row[ 'gamename' ] . " - <a href='" . $row['gamefileurl'] . "'>" . $row['gamefileurl'] . "</a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='?edit=" . $row['gameid'] . "'>I am done uploading, update file entry to 'uploads/" . $row['gameid'] . "/game.zip'</a><br />";
			}
		}
?>
