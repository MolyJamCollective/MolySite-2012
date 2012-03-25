<?php
    include_once("./configuration.php");
    include_once("./objects/class.database.php");
    
    $connection = Database::Connect();
	$cursor = Database::Reader( "select `gamepictureurl` from `gameobject` where `gameobjectid`='".intval($_GET["id"])."' LIMIT 1", $connection);
	while ($row = Database::Read($cursor))
	{
		echo "<img src='" . $row[ "gamepictureurl" ] . "' width='320' height='240' />";
		die();
	}
	
	echo "Thumbnail not found! " . $_GET["id"];
?>