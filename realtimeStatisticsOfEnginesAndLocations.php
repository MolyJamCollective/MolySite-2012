<?php
// ------------- Start Functions

include_once("./templates/include.php");

$totalCount = 0;
$connection = Database::Connect();
$cursor = Database::Reader( "SELECT `molyjamlocation`, COUNT(*) FROM `game` GROUP BY `molyjamlocation` ORDER BY COUNT(*) DESC", $connection);
while ($row = Database::Read($cursor))
{
	echo $row[ "molyjamlocation" ] . ": " . $row[ "COUNT(*)" ] . "<br />";
	
	$totalCount += $row[ "COUNT(*)" ];
}

echo "<br /><b>Total: " . $totalCount;
echo "</b><br /><br />";

$connection = Database::Connect();
$cursor = Database::Reader( "SELECT `gameengine`, COUNT(*) FROM `game` GROUP BY `gameengine` ORDER BY COUNT(*) DESC", $connection);
while ($row = Database::Read($cursor))
{
	echo $row[ "gameengine" ] . ": " . $row[ "COUNT(*)" ] . "<br />";
}

echo "<br /><br />";

$connection = Database::Connect();
$cursor = Database::Reader( "SELECT SUM(downloads) FROM `game`", $connection);
while ($row = Database::Read($cursor))
{
	print_r( $row );
}

?>
