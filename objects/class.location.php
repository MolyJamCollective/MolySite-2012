<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `location` (
	`locationid` int(11) NOT NULL auto_increment,
	`title` VARCHAR(255) NOT NULL,
	`address` VARCHAR(255) NOT NULL,
	`city` VARCHAR(255) NOT NULL,
	`region` VARCHAR(255) NOT NULL,
	`country` VARCHAR(255) NOT NULL,
	`eventlink` VARCHAR(255) NOT NULL,
	`eventemail` VARCHAR(255) NOT NULL, PRIMARY KEY  (`locationid`)) ENGINE=MyISAM;
*/

/**
* <b>Location</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0f / PHP5
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5&wrapper=pog&objectName=Location&attributeList=array+%28%0A++0+%3D%3E+%27Title%27%2C%0A++1+%3D%3E+%27Address%27%2C%0A++2+%3D%3E+%27City%27%2C%0A++3+%3D%3E+%27Region%27%2C%0A++4+%3D%3E+%27Country%27%2C%0A++5+%3D%3E+%27EventLink%27%2C%0A++6+%3D%3E+%27EventEmail%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++1+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++2+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++3+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++4+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++5+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++6+%3D%3E+%27VARCHAR%28255%29%27%2C%0A%29
*/
include_once('class.pog_base.php');
class Location extends POG_Base
{
	public $locationId = '';

	/**
	 * @var VARCHAR(255)
	 */
	public $Title;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $Address;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $City;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $Region;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $Country;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $EventLink;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $EventEmail;
	
	public $pog_attribute_type = array(
		"locationId" => array('db_attributes' => array("NUMERIC", "INT")),
		"Title" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"Address" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"City" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"Region" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"Country" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"EventLink" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"EventEmail" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
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
	
	function Location($Title='', $Address='', $City='', $Region='', $Country='', $EventLink='', $EventEmail='')
	{
		$this->Title = $Title;
		$this->Address = $Address;
		$this->City = $City;
		$this->Region = $Region;
		$this->Country = $Country;
		$this->EventLink = $EventLink;
		$this->EventEmail = $EventEmail;
	}
	
	
	/**
	* Gets object from database
	* @param integer $locationId 
	* @return object $Location
	*/
	function Get($locationId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `location` where `locationid`='".intval($locationId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->locationId = $row['locationid'];
			$this->Title = $this->Unescape($row['title']);
			$this->Address = $this->Unescape($row['address']);
			$this->City = $this->Unescape($row['city']);
			$this->Region = $this->Unescape($row['region']);
			$this->Country = $this->Unescape($row['country']);
			$this->EventLink = $this->Unescape($row['eventlink']);
			$this->EventEmail = $this->Unescape($row['eventemail']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $locationList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `location` ";
		$locationList = Array();
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
			$sortBy = "locationid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$location = new $thisObjectName();
			$location->locationId = $row['locationid'];
			$location->Title = $this->Unescape($row['title']);
			$location->Address = $this->Unescape($row['address']);
			$location->City = $this->Unescape($row['city']);
			$location->Region = $this->Unescape($row['region']);
			$location->Country = $this->Unescape($row['country']);
			$location->EventLink = $this->Unescape($row['eventlink']);
			$location->EventEmail = $this->Unescape($row['eventemail']);
			$locationList[] = $location;
		}
		return $locationList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $locationId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `locationid` from `location` where `locationid`='".$this->locationId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `location` set 
			`title`='".$this->Escape($this->Title)."', 
			`address`='".$this->Escape($this->Address)."', 
			`city`='".$this->Escape($this->City)."', 
			`region`='".$this->Escape($this->Region)."', 
			`country`='".$this->Escape($this->Country)."', 
			`eventlink`='".$this->Escape($this->EventLink)."', 
			`eventemail`='".$this->Escape($this->EventEmail)."' where `locationid`='".$this->locationId."'";
		}
		else
		{
			$this->pog_query = "insert into `location` (`title`, `address`, `city`, `region`, `country`, `eventlink`, `eventemail` ) values (
			'".$this->Escape($this->Title)."', 
			'".$this->Escape($this->Address)."', 
			'".$this->Escape($this->City)."', 
			'".$this->Escape($this->Region)."', 
			'".$this->Escape($this->Country)."', 
			'".$this->Escape($this->EventLink)."', 
			'".$this->Escape($this->EventEmail)."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->locationId == "")
		{
			$this->locationId = $insertId;
		}
		return $this->locationId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $locationId
	*/
	function SaveNew()
	{
		$this->locationId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `location` where `locationid`='".$this->locationId."'";
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
			$pog_query = "delete from `location` where ";
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