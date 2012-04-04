<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `greenpixel` (
	`greenpixelid` int(11) NOT NULL auto_increment,
	`gameid` INT NOT NULL,
	`text` VARCHAR(255) NOT NULL, PRIMARY KEY  (`greenpixelid`)) ENGINE=MyISAM;
*/

/**
* <b>GreenPixel</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0f / PHP5
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5&wrapper=pog&objectName=GreenPixel&attributeList=array+%28%0A++0+%3D%3E+%27GameId%27%2C%0A++1+%3D%3E+%27Text%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27INT%27%2C%0A++1+%3D%3E+%27VARCHAR%28255%29%27%2C%0A%29
*/
include_once('class.pog_base.php');
class GreenPixel extends POG_Base
{
	public $greenpixelId = '';

	/**
	 * @var INT
	 */
	public $GameId;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $Text;
	
	public $pog_attribute_type = array(
		"greenpixelId" => array('db_attributes' => array("NUMERIC", "INT")),
		"GameId" => array('db_attributes' => array("NUMERIC", "INT")),
		"Text" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
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
	
	function GreenPixel($GameId='', $Text='')
	{
		$this->GameId = $GameId;
		$this->Text = $Text;
	}
	
	
	/**
	* Gets object from database
	* @param integer $greenpixelId 
	* @return object $GreenPixel
	*/
	function Get($greenpixelId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `greenpixel` where `greenpixelid`='".intval($greenpixelId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->greenpixelId = $row['greenpixelid'];
			$this->GameId = $this->Unescape($row['gameid']);
			$this->Text = $this->Unescape($row['text']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $greenpixelList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `greenpixel` ";
		$greenpixelList = Array();
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
			$sortBy = "greenpixelid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$greenpixel = new $thisObjectName();
			$greenpixel->greenpixelId = $row['greenpixelid'];
			$greenpixel->GameId = $this->Unescape($row['gameid']);
			$greenpixel->Text = $this->Unescape($row['text']);
			$greenpixelList[] = $greenpixel;
		}
		return $greenpixelList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $greenpixelId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `greenpixelid` from `greenpixel` where `greenpixelid`='".$this->greenpixelId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `greenpixel` set 
			`gameid`='".$this->Escape($this->GameId)."', 
			`text`='".$this->Escape($this->Text)."' where `greenpixelid`='".$this->greenpixelId."'";
		}
		else
		{
			$this->pog_query = "insert into `greenpixel` (`gameid`, `text` ) values (
			'".$this->Escape($this->GameId)."', 
			'".$this->Escape($this->Text)."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->greenpixelId == "")
		{
			$this->greenpixelId = $insertId;
		}
		return $this->greenpixelId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $greenpixelId
	*/
	function SaveNew()
	{
		$this->greenpixelId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `greenpixel` where `greenpixelid`='".$this->greenpixelId."'";
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
			$pog_query = "delete from `greenpixel` where ";
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