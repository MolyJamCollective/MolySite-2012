<?php
// ------------- Start Functions

    include_once("./configuration.php");
    include_once("./objects/class.database.php");
           
           
           $connection = Database::Connect();

		$cursor = Database::Reader("select * from `game`", $connection);
		while ($row = Database::Read($cursor))
		{
			if( $row['gamefileurl'] != "" 
			 && substr( $row['gamefileurl'], 0, strlen( "uploads" ) ) != "uploads" )
			{
				echo "<a href='" . $row['gamefileurl'] . "'>" . $row['gamefileurl'] . "</a><br />";
			}
		}
?>
