<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `gameobject` (
	`gameobjectid` int(11) NOT NULL auto_increment,
	`gamename` VARCHAR(255) NOT NULL,
	`gamepictureurl` VARCHAR(255) NOT NULL,
	`gametweet` VARCHAR(255) NOT NULL,
	`gamedescription` TEXT NOT NULL,
	`gamefileurl` VARCHAR(255) NOT NULL,
	`gamevideourl` VARCHAR(255) NOT NULL,
	`molyjamlocation` VARCHAR(255) NOT NULL,
	`teampictureurl` VARCHAR(255) NOT NULL,
	`teammembers` TEXT NOT NULL,
	`gamelicense` VARCHAR(255) NOT NULL,
	`pageviews` INT NOT NULL,
	`downloads` INT NOT NULL,
	`createddatetime` DATETIME NOT NULL,
	`lastediteddatetime` DATETIME NOT NULL,
	`editid` VARCHAR(255) NOT NULL, PRIMARY KEY  (`gameobjectid`)) ENGINE=MyISAM;
*/

/**
* <b>GameObject</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0f / PHP5
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5&wrapper=pog&objectName=GameObject&attributeList=array+%28%0A++0+%3D%3E+%27GameName%27%2C%0A++1+%3D%3E+%27GamePictureURL%27%2C%0A++2+%3D%3E+%27GameTweet%27%2C%0A++3+%3D%3E+%27GameDescription%27%2C%0A++4+%3D%3E+%27GameFileURL%27%2C%0A++5+%3D%3E+%27GameVideoURL%27%2C%0A++6+%3D%3E+%27MolyJamLocation%27%2C%0A++7+%3D%3E+%27TeamPictureURL%27%2C%0A++8+%3D%3E+%27TeamMembers%27%2C%0A++9+%3D%3E+%27GameLicense%27%2C%0A++10+%3D%3E+%27PageViews%27%2C%0A++11+%3D%3E+%27Downloads%27%2C%0A++12+%3D%3E+%27CreatedDateTime%27%2C%0A++13+%3D%3E+%27lastEditedDateTime%27%2C%0A++14+%3D%3E+%27EditID%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++1+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++2+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++3+%3D%3E+%27TEXT%27%2C%0A++4+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++5+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++6+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++7+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++8+%3D%3E+%27TEXT%27%2C%0A++9+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++10+%3D%3E+%27INT%27%2C%0A++11+%3D%3E+%27INT%27%2C%0A++12+%3D%3E+%27DATETIME%27%2C%0A++13+%3D%3E+%27DATETIME%27%2C%0A++14+%3D%3E+%27VARCHAR%28255%29%27%2C%0A%29
*/
include_once('class.pog_base.php');
class GameObject extends POG_Base
{
	public $gameobjectId = '';

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
	public $GameFileURL;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $GameVideoURL;
	
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
	public $CreatedDateTime;
	
	/**
	 * @var DATETIME
	 */
	public $lastEditedDateTime;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $EditID;
	
	public $pog_attribute_type = array(
		"gameobjectId" => array('db_attributes' => array("NUMERIC", "INT")),
		"GameName" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"GamePictureURL" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"GameTweet" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"GameDescription" => array('db_attributes' => array("TEXT", "TEXT")),
		"GameFileURL" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"GameVideoURL" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"MolyJamLocation" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"TeamPictureURL" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"TeamMembers" => array('db_attributes' => array("TEXT", "TEXT")),
		"GameLicense" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"PageViews" => array('db_attributes' => array("NUMERIC", "INT")),
		"Downloads" => array('db_attributes' => array("NUMERIC", "INT")),
		"CreatedDateTime" => array('db_attributes' => array("TEXT", "DATETIME")),
		"lastEditedDateTime" => array('db_attributes' => array("TEXT", "DATETIME")),
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
	
	function GameObject($GameName='', $GamePictureURL='', $GameTweet='', $GameDescription='', $GameFileURL='', $GameVideoURL='', $MolyJamLocation='', $TeamPictureURL='', $TeamMembers='', $GameLicense='', $PageViews='', $Downloads='', $CreatedDateTime='', $lastEditedDateTime='')
	{
		$this->GameName = $GameName;
		$this->GamePictureURL = $GamePictureURL;
		$this->GameTweet = $GameTweet;
		$this->GameDescription = $GameDescription;
		$this->GameFileURL = $GameFileURL;
		$this->GameVideoURL = $GameVideoURL;
		$this->MolyJamLocation = $MolyJamLocation;
		$this->TeamPictureURL = $TeamPictureURL;
		$this->TeamMembers = $TeamMembers;
		$this->GameLicense = $GameLicense;
		$this->PageViews = $PageViews;
		$this->Downloads = $Downloads;
		$this->CreatedDateTime = $CreatedDateTime;
		$this->lastEditedDateTime = $lastEditedDateTime;
	}
	
	
	/**
	* Gets object from database
	* @param integer $gameobjectId 
	* @return object $GameObject
	*/
	function Get($gameobjectId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `gameobject` where `gameobjectid`='".intval($gameobjectId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->gameobjectId = $row['gameobjectid'];
			$this->GameName = $this->Unescape($row['gamename']);
			$this->GamePictureURL = $this->Unescape($row['gamepictureurl']);
			$this->GameTweet = $this->Unescape($row['gametweet']);
			$this->GameDescription = $this->Unescape($row['gamedescription']);
			$this->GameFileURL = $this->Unescape($row['gamefileurl']);
			$this->GameVideoURL = $this->Unescape($row['gamevideourl']);
			$this->MolyJamLocation = $this->Unescape($row['molyjamlocation']);
			$this->TeamPictureURL = $this->Unescape($row['teampictureurl']);
			$this->TeamMembers = $this->Unescape($row['teammembers']);
			$this->GameLicense = $this->Unescape($row['gamelicense']);
			$this->PageViews = $this->Unescape($row['pageviews']);
			$this->Downloads = $this->Unescape($row['downloads']);
			$this->CreatedDateTime = $row['createddatetime'];
			$this->lastEditedDateTime = $row['lastediteddatetime'];
			$this->EditID = $this->Unescape($row['editid']);
		}
		return $this;
	}
	
	/**
	* Gets object from database
	* @param string $editId 
	* @return object $GameObject
	*/
	function GetFromEditId($editId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `gameobject` where `editid`='".$editId."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->gameobjectId = $row['gameobjectid'];
			$this->GameName = $this->Unescape($row['gamename']);
			$this->GamePictureURL = $this->Unescape($row['gamepictureurl']);
			$this->GameTweet = $this->Unescape($row['gametweet']);
			$this->GameDescription = $this->Unescape($row['gamedescription']);
			$this->GameFileURL = $this->Unescape($row['gamefileurl']);
			$this->GameVideoURL = $this->Unescape($row['gamevideourl']);
			$this->MolyJamLocation = $this->Unescape($row['molyjamlocation']);
			$this->TeamPictureURL = $this->Unescape($row['teampictureurl']);
			$this->TeamMembers = $this->Unescape($row['teammembers']);
			$this->GameLicense = $this->Unescape($row['gamelicense']);
			$this->PageViews = $this->Unescape($row['pageviews']);
			$this->Downloads = $this->Unescape($row['downloads']);
			$this->CreatedDateTime = $row['createddatetime'];
			$this->lastEditedDateTime = $row['lastediteddatetime'];
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
	* @return array $gameobjectList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `gameobject` ";
		$gameobjectList = Array();
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
		
		if ($sortBy == 'popularity')
		{
			$sortBy = "( `pageviews` + `downloads` * 100 )";
		}
		else if ($sortBy != '')
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
			$sortBy = "gameobjectid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$gameobject = new $thisObjectName();
			$gameobject->gameobjectId = $row['gameobjectid'];
			$gameobject->GameName = $this->Unescape($row['gamename']);
			$gameobject->GamePictureURL = $this->Unescape($row['gamepictureurl']);
			$gameobject->GameTweet = $this->Unescape($row['gametweet']);
			$gameobject->GameDescription = $this->Unescape($row['gamedescription']);
			$gameobject->GameFileURL = $this->Unescape($row['gamefileurl']);
			$gameobject->GameVideoURL = $this->Unescape($row['gamevideourl']);
			$gameobject->MolyJamLocation = $this->Unescape($row['molyjamlocation']);
			$gameobject->TeamPictureURL = $this->Unescape($row['teampictureurl']);
			$gameobject->TeamMembers = $this->Unescape($row['teammembers']);
			$gameobject->GameLicense = $this->Unescape($row['gamelicense']);
			$gameobject->PageViews = $this->Unescape($row['pageviews']);
			$gameobject->Downloads = $this->Unescape($row['downloads']);
			$gameobject->CreatedDateTime = $row['createddatetime'];
			$gameobject->lastEditedDateTime = $row['lastediteddatetime'];
			$gameobject->EditID = $this->Unescape($row['editid']);
			$gameobjectList[] = $gameobject;
		}
		return $gameobjectList;
	}
	
	/**
	* Creates the objects editID
	* @returns EditID
	*/
	function GenerateEditID($email='')
	{
		$connection = Database::Connect();
		$this->EditID = md5( $email . $this->gameobjectId );
		return $this->EditID;
	}
	
	/**
	* Saves the object to the database
	* @return integer $gameobjectId
	*/
	function Save($email='')
	{
		$connection = Database::Connect();
		$this->pog_query = "select `gameobjectid` from `gameobject` where `gameobjectid`='".$this->gameobjectId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			// Update Entry
			$this->pog_query = "update `gameobject` set 
			`gamename`='".$this->Escape($this->GameName)."', 
			`gamepictureurl`='".$this->Escape($this->GamePictureURL)."', 
			`gametweet`='".$this->Escape($this->GameTweet)."', 
			`gamedescription`='".$this->Escape($this->GameDescription)."', 
			`gamefileurl`='".$this->Escape($this->GameFileURL)."', 
			`gamevideourl`='".$this->Escape($this->GameVideoURL)."', 
			`molyjamlocation`='".$this->Escape($this->MolyJamLocation)."', 
			`teampictureurl`='".$this->Escape($this->TeamPictureURL)."', 
			`teammembers`='".$this->Escape($this->TeamMembers)."', 
			`gamelicense`='".$this->Escape($this->GameLicense)."', 
			`pageviews`='".$this->Escape($this->PageViews)."', 
			`downloads`='".$this->Escape($this->Downloads)."', 
			`createddatetime`='".$this->CreatedDateTime."', 
			`lastediteddatetime`= NOW(), 
			`editid`='".$this->Escape($this->EditID)."' where `gameobjectid`='".$this->gameobjectId."'";
		}
		else
		{
			// Insert New Entry
			$this->pog_query = "insert into `gameobject` (`gamename`, `gamepictureurl`, `gametweet`, `gamedescription`, `gamefileurl`, `gamevideourl`, `molyjamlocation`, `teampictureurl`, `teammembers`, `gamelicense`, `pageviews`, `downloads`, `createddatetime`, `lastediteddatetime`, `editid` ) values (
			'".$this->Escape($this->GameName)."', 
			'".$this->Escape($this->GamePictureURL)."', 
			'".$this->Escape($this->GameTweet)."', 
			'".$this->Escape($this->GameDescription)."', 
			'".$this->Escape($this->GameFileURL)."', 
			'".$this->Escape($this->GameVideoURL)."', 
			'".$this->Escape($this->MolyJamLocation)."', 
			'".$this->Escape($this->TeamPictureURL)."', 
			'".$this->Escape($this->TeamMembers)."', 
			'".$this->Escape($this->GameLicense)."', 
			'".$this->Escape($this->PageViews)."', 
			'".$this->Escape($this->Downloads)."', 
			NOW(), 
			'".$this->lastEditedDateTime."', 
			'".$this->Escape($this->EditID)."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		
		if ($this->gameobjectId == "")
		{
			$this->Get($insertId);
			
			if( !empty($email) )
			{
				$this->EditID = $this->GenerateEditID($email);
				$this->Save("");
				$this->Get($insertId);
			}
		}
		return $this->gameobjectId;
	}
	
	/**
	* Clones the object and saves it to the database
	* @return integer $gameobjectId
	*/
	function SaveNew()
	{
		$this->gameobjectId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `gameobject` where `gameobjectid`='".$this->gameobjectId."'";
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
			$pog_query = "delete from `gameobject` where ";
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