<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `game` (
	`gameid` int(11) NOT NULL auto_increment,
	`gamename` VARCHAR(255) NOT NULL,
	`gamepictureurl` VARCHAR(255) NOT NULL,
	`gametweet` VARCHAR(255) NOT NULL,
	`gamedescription` TEXT NOT NULL,
	`gamefile` VARCHAR(255) NOT NULL,
	`gamevideo` VARCHAR(255) NOT NULL,
	`molyjamlocation` VARCHAR(255) NOT NULL,
	`teampictureurl` VARCHAR(255) NOT NULL,
	`teammembers` TEXT NOT NULL,
	`gamelicense` VARCHAR(255) NOT NULL,
	`pageviews` INT NOT NULL,
	`downloads` INT NOT NULL,
	`created` DATETIME NOT NULL,
	`lastedited` DATETIME NOT NULL,
	`editid` VARCHAR(255) NOT NULL, PRIMARY KEY  (`gameid`)) ENGINE=MyISAM;
*/

/**
* <b>Game</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0f / PHP5.1 MYSQL
* @see http://www.phpobjectgenerator.com/plog/tutorials/45/pdo-mysql
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5.1&wrapper=pdo&pdoDriver=mysql&objectName=Game&attributeList=array+%28%0A++0+%3D%3E+%27GameName%27%2C%0A++1+%3D%3E+%27GamePictureURL%27%2C%0A++2+%3D%3E+%27GameTweet%27%2C%0A++3+%3D%3E+%27GameDescription%27%2C%0A++4+%3D%3E+%27GameFile%27%2C%0A++5+%3D%3E+%27GameVideo%27%2C%0A++6+%3D%3E+%27MolyJamLocation%27%2C%0A++7+%3D%3E+%27TeamPictureURL%27%2C%0A++8+%3D%3E+%27TeamMembers%27%2C%0A++9+%3D%3E+%27GameLicense%27%2C%0A++10+%3D%3E+%27PageViews%27%2C%0A++11+%3D%3E+%27Downloads%27%2C%0A++12+%3D%3E+%27Created%27%2C%0A++13+%3D%3E+%27LastEdited%27%2C%0A++14+%3D%3E+%27EditID%27%2C%0A%29&typeList=array%2B%2528%250A%2B%2B0%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B1%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B2%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B3%2B%253D%253E%2B%2527TEXT%2527%252C%250A%2B%2B4%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B5%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B6%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B7%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B8%2B%253D%253E%2B%2527TEXT%2527%252C%250A%2B%2B9%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B10%2B%253D%253E%2B%2527INT%2527%252C%250A%2B%2B11%2B%253D%253E%2B%2527INT%2527%252C%250A%2B%2B12%2B%253D%253E%2B%2527DATETIME%2527%252C%250A%2B%2B13%2B%253D%253E%2B%2527DATETIME%2527%252C%250A%2B%2B14%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2529
*/
include_once('class.pog_base.php');
class Game extends POG_Base
{
	public $gameId = '';

	/**
	 * @var VARCHAR(255)
	 */
	public $GameName;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $GamePictureURL;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $GameTweet;
	
	/**
	 * @var TEXT
	 */
	public $GameDescription;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $GameFile;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $GameVideo;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $MolyJamLocation;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $TeamPictureURL;
	
	/**
	 * @var TEXT
	 */
	public $TeamMembers;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $GameLicense;
	
	/**
	 * @var INT
	 */
	public $PageViews;
	
	/**
	 * @var INT
	 */
	public $Downloads;
	
	/**
	 * @var DATETIME
	 */
	public $Created;
	
	/**
	 * @var DATETIME
	 */
	public $LastEdited;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $EditID;
	
	public $pog_attribute_type = array(
		"gameId" => array('db_attributes' => array("NUMERIC", "INT")),
		"GameName" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"GamePictureURL" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"GameTweet" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"GameDescription" => array('db_attributes' => array("TEXT", "TEXT")),
		"GameFile" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"GameVideo" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"MolyJamLocation" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"TeamPictureURL" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"TeamMembers" => array('db_attributes' => array("TEXT", "TEXT")),
		"GameLicense" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"PageViews" => array('db_attributes' => array("NUMERIC", "INT")),
		"Downloads" => array('db_attributes' => array("NUMERIC", "INT")),
		"Created" => array('db_attributes' => array("TEXT", "DATETIME")),
		"LastEdited" => array('db_attributes' => array("TEXT", "DATETIME")),
		"EditID" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		);
	public $pog_query;
	
	
	/**
	* Getter for some private attributes
	* @return mixed $attribute
	*/
	public function __get($attribute)
	{
		if (isset($this->{"_".$attribute}))
		{
			return $this->{"_".$attribute};
		}
		else
		{
			return false;
		}
	}
	
	function Game($GameName='', $GamePictureURL='', $GameTweet='', $GameDescription='', $GameFile='', $GameVideo='', $MolyJamLocation='', $TeamPictureURL='', $TeamMembers='', $GameLicense='', $PageViews='', $Downloads='', $Created='', $LastEdited='', $EditID='')
	{
		$this->GameName = $GameName;
		$this->GamePictureURL = $GamePictureURL;
		$this->GameTweet = $GameTweet;
		$this->GameDescription = $GameDescription;
		$this->GameFile = $GameFile;
		$this->GameVideo = $GameVideo;
		$this->MolyJamLocation = $MolyJamLocation;
		$this->TeamPictureURL = $TeamPictureURL;
		$this->TeamMembers = $TeamMembers;
		$this->GameLicense = $GameLicense;
		$this->PageViews = $PageViews;
		$this->Downloads = $Downloads;
		$this->Created = $Created;
		$this->LastEdited = $LastEdited;
		$this->EditID = $EditID;
	}
	
	
	/**
	* Gets object from database
	* @param integer $gameId 
	* @return object $Game
	*/
	function Get($gameId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `game` where `gameid`='".intval($gameId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->gameId = $row['gameid'];
			$this->GameName = $this->Unescape($row['gamename']);
			$this->GamePictureURL = $this->Unescape($row['gamepictureurl']);
			$this->GameTweet = $this->Unescape($row['gametweet']);
			$this->GameDescription = $this->Unescape($row['gamedescription']);
			$this->GameFile = $this->Unescape($row['gamefile']);
			$this->GameVideo = $this->Unescape($row['gamevideo']);
			$this->MolyJamLocation = $this->Unescape($row['molyjamlocation']);
			$this->TeamPictureURL = $this->Unescape($row['teampictureurl']);
			$this->TeamMembers = $this->Unescape($row['teammembers']);
			$this->GameLicense = $this->Unescape($row['gamelicense']);
			$this->PageViews = $this->Unescape($row['pageviews']);
			$this->Downloads = $this->Unescape($row['downloads']);
			$this->Created = $row['created'];
			$this->LastEdited = $row['lastedited'];
			$this->EditID = $this->Unescape($row['editid']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $gameList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `game` ";
		$gameList = Array();
		if (sizeof($fcv_array) > 0)
		{
			$this->pog_query .= " where ";
			for ($i=0, $c=sizeof($fcv_array); $i<$c; $i++)
			{
				if (sizeof($fcv_array[$i]) == 1)
				{
					$this->pog_query .= " ".$fcv_array[$i][0]." ";
					continue;
				}
				else
				{
					if ($i > 0 && sizeof($fcv_array[$i-1]) != 1)
					{
						$this->pog_query .= " AND ";
					}
					if (isset($this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes']) && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'SET')
					{
						if ($GLOBALS['configuration']['db_encoding'] == 1)
						{
							$value = POG_Base::IsColumn($fcv_array[$i][2]) ? "BASE64_DECODE(".$fcv_array[$i][2].")" : "'".$fcv_array[$i][2]."'";
							$this->pog_query .= "BASE64_DECODE(`".$fcv_array[$i][0]."`) ".$fcv_array[$i][1]." ".$value;
						}
						else
						{
							$value =  POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : "'".$this->Escape($fcv_array[$i][2])."'";
							$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
						}
					}
					else
					{
						$value = POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : "'".$fcv_array[$i][2]."'";
						$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
					}
				}
			}
		}
		if ($sortBy != '')
		{
			if (isset($this->pog_attribute_type[$sortBy]['db_attributes']) && $this->pog_attribute_type[$sortBy]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$sortBy]['db_attributes'][0] != 'SET')
			{
				if ($GLOBALS['configuration']['db_encoding'] == 1)
				{
					$sortBy = "BASE64_DECODE($sortBy) ";
				}
				else
				{
					$sortBy = "$sortBy ";
				}
			}
			else
			{
				$sortBy = "$sortBy ";
			}
		}
		else
		{
			$sortBy = "gameid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$game = new $thisObjectName();
			$game->gameId = $row['gameid'];
			$game->GameName = $this->Unescape($row['gamename']);
			$game->GamePictureURL = $this->Unescape($row['gamepictureurl']);
			$game->GameTweet = $this->Unescape($row['gametweet']);
			$game->GameDescription = $this->Unescape($row['gamedescription']);
			$game->GameFile = $this->Unescape($row['gamefile']);
			$game->GameVideo = $this->Unescape($row['gamevideo']);
			$game->MolyJamLocation = $this->Unescape($row['molyjamlocation']);
			$game->TeamPictureURL = $this->Unescape($row['teampictureurl']);
			$game->TeamMembers = $this->Unescape($row['teammembers']);
			$game->GameLicense = $this->Unescape($row['gamelicense']);
			$game->PageViews = $this->Unescape($row['pageviews']);
			$game->Downloads = $this->Unescape($row['downloads']);
			$game->Created = $row['created'];
			$game->LastEdited = $row['lastedited'];
			$game->EditID = $this->Unescape($row['editid']);
			$gameList[] = $game;
		}
		return $gameList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $gameId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `gameid` from `game` where `gameid`='".$this->gameId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `game` set 
			`gamename`='".$this->Escape($this->GameName)."', 
			`gamepictureurl`='".$this->Escape($this->GamePictureURL)."', 
			`gametweet`='".$this->Escape($this->GameTweet)."', 
			`gamedescription`='".$this->Escape($this->GameDescription)."', 
			`gamefile`='".$this->Escape($this->GameFile)."', 
			`gamevideo`='".$this->Escape($this->GameVideo)."', 
			`molyjamlocation`='".$this->Escape($this->MolyJamLocation)."', 
			`teampictureurl`='".$this->Escape($this->TeamPictureURL)."', 
			`teammembers`='".$this->Escape($this->TeamMembers)."', 
			`gamelicense`='".$this->Escape($this->GameLicense)."', 
			`pageviews`='".$this->Escape($this->PageViews)."', 
			`downloads`='".$this->Escape($this->Downloads)."', 
			`created`='".$this->Created."', 
			`lastedited`='".$this->LastEdited."', 
			`editid`='".$this->Escape($this->EditID)."' where `gameid`='".$this->gameId."'";
		}
		else
		{
			$this->pog_query = "insert into `game` (`gamename`, `gamepictureurl`, `gametweet`, `gamedescription`, `gamefile`, `gamevideo`, `molyjamlocation`, `teampictureurl`, `teammembers`, `gamelicense`, `pageviews`, `downloads`, `created`, `lastedited`, `editid` ) values (
			'".$this->Escape($this->GameName)."', 
			'".$this->Escape($this->GamePictureURL)."', 
			'".$this->Escape($this->GameTweet)."', 
			'".$this->Escape($this->GameDescription)."', 
			'".$this->Escape($this->GameFile)."', 
			'".$this->Escape($this->GameVideo)."', 
			'".$this->Escape($this->MolyJamLocation)."', 
			'".$this->Escape($this->TeamPictureURL)."', 
			'".$this->Escape($this->TeamMembers)."', 
			'".$this->Escape($this->GameLicense)."', 
			'".$this->Escape($this->PageViews)."', 
			'".$this->Escape($this->Downloads)."', 
			'".$this->Created."', 
			'".$this->LastEdited."', 
			'".$this->Escape($this->EditID)."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->gameId == "")
		{
			$this->gameId = $insertId;
		}
		return $this->gameId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $gameId
	*/
	function SaveNew()
	{
		$this->gameId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `game` where `gameid`='".$this->gameId."'";
		return Database::NonQuery($this->pog_query, $connection);
	}
	
	
	/**
	* Deletes a list of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param bool $deep 
	* @return 
	*/
	function DeleteList($fcv_array)
	{
		if (sizeof($fcv_array) > 0)
		{
			$connection = Database::Connect();
			$pog_query = "delete from `game` where ";
			for ($i=0, $c=sizeof($fcv_array); $i<$c; $i++)
			{
				if (sizeof($fcv_array[$i]) == 1)
				{
					$pog_query .= " ".$fcv_array[$i][0]." ";
					continue;
				}
				else
				{
					if ($i > 0 && sizeof($fcv_array[$i-1]) !== 1)
					{
						$pog_query .= " AND ";
					}
					if (isset($this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes']) && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'SET')
					{
						$pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." '".$this->Escape($fcv_array[$i][2])."'";
					}
					else
					{
						$pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." '".$fcv_array[$i][2]."'";
					}
				}
			}
			return Database::NonQuery($pog_query, $connection);
		}
	}
}
?>