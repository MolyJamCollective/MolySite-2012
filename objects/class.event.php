<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `event` (
	`eventid` int(11) NOT NULL auto_increment,
	`title` VARCHAR(255) NOT NULL,
	`start` DATETIME NOT NULL,
	`stop` DATETIME NOT NULL,
	`description` TEXT NOT NULL, PRIMARY KEY  (`eventid`)) ENGINE=MyISAM;
*/

/**
* <b>Event</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0f / PHP5
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5&wrapper=pog&objectName=Event&attributeList=array+%28%0A++0+%3D%3E+%27Title%27%2C%0A++1+%3D%3E+%27Start%27%2C%0A++2+%3D%3E+%27Stop%27%2C%0A++3+%3D%3E+%27Description%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++1+%3D%3E+%27DATETIME%27%2C%0A++2+%3D%3E+%27DATETIME%27%2C%0A++3+%3D%3E+%27TEXT%27%2C%0A%29
*/
include_once('class.pog_base.php');
class Event extends POG_Base
{
	public $eventId = '';

	/**
	 * @var VARCHAR(255)
	 */
	public $Title;
	
	/**
	 * @var DATETIME
	 */
	public $Start;
	
	/**
	 * @var DATETIME
	 */
	public $Stop;
	
	/**
	 * @var TEXT
	 */
	public $Description;
	
	public $pog_attribute_type = array(
		"eventId" => array('db_attributes' => array("NUMERIC", "INT")),
		"Title" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"Start" => array('db_attributes' => array("TEXT", "DATETIME")),
		"Stop" => array('db_attributes' => array("TEXT", "DATETIME")),
		"Description" => array('db_attributes' => array("TEXT", "TEXT")),
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
	
	function Event($Title='', $Start='', $Stop='', $Description='')
	{
		$this->Title = $Title;
		$this->Start = $Start;
		$this->Stop = $Stop;
		$this->Description = $Description;
	}
	
	
	/**
	* Gets object from database
	* @param integer $eventId 
	* @return object $Event
	*/
	function Get($eventId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `event` where `eventid`='".intval($eventId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->eventId = $row['eventid'];
			$this->Title = $this->Unescape($row['title']);
			$this->Start = $row['start'];
			$this->Stop = $row['stop'];
			$this->Description = $this->Unescape($row['description']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $eventList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `event` ";
		$eventList = Array();
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
			$sortBy = "eventid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$event = new $thisObjectName();
			$event->eventId = $row['eventid'];
			$event->Title = $this->Unescape($row['title']);
			$event->Start = $row['start'];
			$event->Stop = $row['stop'];
			$event->Description = $this->Unescape($row['description']);
			$eventList[] = $event;
		}
		return $eventList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $eventId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `eventid` from `event` where `eventid`='".$this->eventId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `event` set 
			`title`='".$this->Escape($this->Title)."', 
			`start`='".$this->Start."', 
			`stop`='".$this->Stop."', 
			`description`='".$this->Escape($this->Description)."' where `eventid`='".$this->eventId."'";
		}
		else
		{
			$this->pog_query = "insert into `event` (`title`, `start`, `stop`, `description` ) values (
			'".$this->Escape($this->Title)."', 
			'".$this->Start."', 
			'".$this->Stop."', 
			'".$this->Escape($this->Description)."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->eventId == "")
		{
			$this->eventId = $insertId;
		}
		return $this->eventId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $eventId
	*/
	function SaveNew()
	{
		$this->eventId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `event` where `eventid`='".$this->eventId."'";
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
			$pog_query = "delete from `event` where ";
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