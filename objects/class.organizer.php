<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `organizer` (
	`organizerid` int(11) NOT NULL auto_increment,
	`locationid` VARCHAR(255) NOT NULL,
	`twitter` VARCHAR(255) NOT NULL, PRIMARY KEY  (`organizerid`)) ENGINE=MyISAM;
*/

/**
* <b>Organizer</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0f / PHP5
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5&wrapper=pog&objectName=Organizer&attributeList=array+%28%0A++0+%3D%3E+%27LocationID%27%2C%0A++1+%3D%3E+%27Twitter%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++1+%3D%3E+%27VARCHAR%28255%29%27%2C%0A%29
*/
include_once('class.pog_base.php');
class Organizer extends POG_Base
{
	public $organizerId = '';

	/**
	 * @var VARCHAR(255)
	 */
	public $LocationID;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $Twitter;
	
	public $pog_attribute_type = array(
		"organizerId" => array('db_attributes' => array("NUMERIC", "INT")),
		"LocationID" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"Twitter" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
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
	
	function Organizer($LocationID='', $Twitter='')
	{
		$this->LocationID = $LocationID;
		$this->Twitter = $Twitter;
	}
	
	
	/**
	* Gets object from database
	* @param integer $organizerId 
	* @return object $Organizer
	*/
	function Get($organizerId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `organizer` where `organizerid`='".intval($organizerId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->organizerId = $row['organizerid'];
			$this->LocationID = $this->Unescape($row['locationid']);
			$this->Twitter = $this->Unescape($row['twitter']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $organizerList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `organizer` ";
		$organizerList = Array();
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
			$sortBy = "organizerid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$organizer = new $thisObjectName();
			$organizer->organizerId = $row['organizerid'];
			$organizer->LocationID = $this->Unescape($row['locationid']);
			$organizer->Twitter = $this->Unescape($row['twitter']);
			$organizerList[] = $organizer;
		}
		return $organizerList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $organizerId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `organizerid` from `organizer` where `organizerid`='".$this->organizerId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `organizer` set 
			`locationid`='".$this->Escape($this->LocationID)."', 
			`twitter`='".$this->Escape($this->Twitter)."' where `organizerid`='".$this->organizerId."'";
		}
		else
		{
			$this->pog_query = "insert into `organizer` (`locationid`, `twitter` ) values (
			'".$this->Escape($this->LocationID)."', 
			'".$this->Escape($this->Twitter)."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->organizerId == "")
		{
			$this->organizerId = $insertId;
		}
		return $this->organizerId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $organizerId
	*/
	function SaveNew()
	{
		$this->organizerId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `organizer` where `organizerid`='".$this->organizerId."'";
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
			$pog_query = "delete from `organizer` where ";
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