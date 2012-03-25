<?php
    include_once("./configuration.php");
    include_once("./objects/class.database.php");
    
    $connection = Database::Connect();
	$cursor = Database::Reader( "select `gamepictureurl` from `gameobject` where `gameobjectid`='".intval($_GET["id"])."' LIMIT 1", $connection);
	while ($row = Database::Read($cursor))
	{
		if( $row[ "gamepictureurl" ] != "" )
		{
			echo "<img src='" . $row[ "gamepictureurl" ] . "' width='320' height='240' />";
		}
		
		die();
	}
	
	echo "Project Id not found! Id: " . $_GET["id"];
?>