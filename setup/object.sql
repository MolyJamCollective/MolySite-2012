	CREATE TABLE `location` (
	`locationid` int(11) NOT NULL auto_increment,
	`title` VARCHAR(255) NOT NULL,
	`address` VARCHAR(255) NOT NULL,
	`city` VARCHAR(255) NOT NULL,
	`region` VARCHAR(255) NOT NULL,
	`country` VARCHAR(255) NOT NULL,
	`eventurl` VARCHAR(255) NOT NULL,
	`eventemail` VARCHAR(255) NOT NULL,
	`eventid` INT NOT NULL, PRIMARY KEY  (`locationid`)) ENGINE=MyISAM;
	
	CREATE TABLE `game` (
	`gameid` int(11) NOT NULL auto_increment,
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
	`editid` VARCHAR(255) NOT NULL, PRIMARY KEY  (`gameid`)) ENGINE=MyISAM;
	
	CREATE TABLE `organizer` (
	`organizerid` int(11) NOT NULL auto_increment,
	`name` VARCHAR(255) NOT NULL,
	`locationid` VARCHAR(255) NOT NULL,
	`twitter` VARCHAR(255) NOT NULL, PRIMARY KEY  (`organizerid`)) ENGINE=MyISAM;
	
	CREATE TABLE `event` (
	`eventid` int(11) NOT NULL auto_increment,
	`title` VARCHAR(255) NOT NULL,
	`start` DATETIME NOT NULL,
	`stop` DATETIME NOT NULL,
	`description` TEXT NOT NULL, PRIMARY KEY  (`eventid`)) ENGINE=MyISAM;