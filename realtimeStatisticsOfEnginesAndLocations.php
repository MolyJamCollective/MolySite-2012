<?php
// ------------- Start Functions

include_once("./templates/include.php");

$connection = Database::Connect();

$lostGames = 0;
$cursor = Database::Reader( "SELECT `gameId` FROM `game` WHERE `gamefileurl`='' and `downloads` > 0", $connection);
while ($row = Database::Read($cursor))
{
	$lostGames++;
}

$collectedMails = 0;
$cursor = Database::Reader( "SELECT `gameId` FROM `game` WHERE `email` != ''", $connection);
while ($row = Database::Read($cursor))
{
	$collectedMails++;
}

echo "Lost: " . $lostGames . "<br />";
echo "Mails: " . $collectedMails;
echo "<br /><br />";

$totalCount = 0;

$cursor = Database::Reader( "SELECT `molyjamlocation`, COUNT(*) FROM `game` GROUP BY `molyjamlocation` ORDER BY COUNT(*) DESC", $connection);
while ($row = Database::Read($cursor))
{
	echo $row[ "molyjamlocation" ] . ": " . $row[ "COUNT(*)" ] . "<br />";
	
	$totalCount += $row[ "COUNT(*)" ];
}

echo "<br /><b>Total: " . $totalCount;
echo "</b><br /><br />";

$cursor = Database::Reader( "SELECT `gameengine`, COUNT(*) FROM `game` GROUP BY `gameengine` ORDER BY COUNT(*) DESC", $connection);
while ($row = Database::Read($cursor))
{
	echo $row[ "gameengine" ] . ": " . $row[ "COUNT(*)" ] . "<br />";
}

echo "<br /><br />";

$cursor = Database::Reader( "SELECT SUM(downloads) FROM `game`", $connection);
while ($row = Database::Read($cursor))
{
	print_r( $row );
}
?>
