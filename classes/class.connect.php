<?php

/**
 * Establish a mySQL connection and select a database.
 *
 * LICENSE:
 *
 * This source file is subject to the licensing terms that
 * is available through the world-wide-web at the following URI:
 * http://codecanyon.net/wiki/support/legal-terms/licensing-terms/.
 *
 * @author       Jigowatt <info@jigowatt.co.uk>
 * @author       Matt Gates <matt.gates@jigoshop.com>
 * @copyright    Copyright (c) 2009-2012 Jigowatt Ltd.
 * @license      http://codecanyon.net/wiki/support/legal-terms/licensing-terms/
 * @link         http://codecanyon.net/item/php-login-user-management/49008
 */

class Connect {

	private $error;

	/**
	 * Checks if installation is complete by seeing if config.php exists.
	 *
	 * The user will be prompted to visit index.php and click "Begin Install" if
	 * there is no config.php yet setup. This prompt will be persistent and won't
	 * allow any pages to load until config.php is created.
	 *
	 * @return    string    The error message if an install does not exist.
	 */
	public function checkInstall() {

		if(!file_exists(dirname(__FILE__) . '/../configuration.php')) :

			return "<div class='alert alert-warning'>"._('Installation has not yet been ran!')."</div>
					<h1>"._('Woops!')."</h1>
					<p>"._('You\'re missing a config.php file preventing a database connection from being made.')."</p>
					<p>"._('Please click')." <a href='index.php'>"._('Begin Install')."</a> " ._('on the home page to create a configuration file.')."</p>
					";

		endif;

	}

	/**
	 * Connect to mySQL and select a database.
	 *
	 * The credentials used to connect to the database are pulled from /classes/config.php.
	 *
	 * @return    string    Error message for any incorrect database connection attempts.
	 */
	public function dbConn() {

		include(dirname(__FILE__) . '/../configuration.php');

		// Suppressing these because we want to show our own error.
		$link = @mysql_connect($configuration['host'], $configuration['user'], $configuration['pass']);
		$dbSelect = @mysql_select_db($configuration['db'], $link);

		if(!$link) :
			return '<div class="alert alert-error">'._('Your database login details are incorrect.').'</div>';
		endif;

		if (!$dbSelect) :
			return '<div class="alert alert-error">'._('Your database name is incorrect.').'</div>';
		endif;

	}

}

// Instantiate the Connect class
$connect = new Connect();