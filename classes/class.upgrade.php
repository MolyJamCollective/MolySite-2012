<?php

/**
 * Runs database updates if required.
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

include_once ( 'class.generic.php' );

class phplogin_upgrade extends Generic {

	function __construct() {

		// Begin !
		$this->jigowatt_upgrade();

		// Message shown to user
		if(!empty($this->result)) echo $this->result;

	}

	/**
	 * Checks if an update is required.
	 *
	 * First grabs the db version from the database. If that
	 * version equals the latest db version, then do nothing.
	 * Otherwise, run the respective update.
	 */
	private function jigowatt_upgrade() {

		$phplogin_db_version = parent::getOption('phplogin_db_version');

		// Nothing to do here...Move along.
		if( $phplogin_db_version == phplogin_db_version )
			return false;

		if ( $phplogin_db_version < 1203040 )
			$this->upgrade_250();

		if ( $phplogin_db_version < 1203080 )
			$this->upgrade_251();

		if ( $phplogin_db_version < 1203090 )
			$this->upgrade_252();

		$this->result = "<div class='alert alert-success'>Your database has been successfully updated !</div>";

	}

	private function upgrade_250() {

		// Settings table
		parent::query("
			CREATE TABLE IF NOT EXISTS `login_settings` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `option_name` varchar(255) NOT NULL,
			  `option_value` longtext NOT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `id` (`id`)
			)
		");

		// Profiles table
		parent::query("
			CREATE TABLE IF NOT EXISTS `login_profiles` (
			  `p_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
			  `profile_label` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
			  `profile_value` longtext CHARACTER SET utf8,
			  PRIMARY KEY (`p_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;
		");

		// Attempt to insert current config settings to the database
		@include('config.php');

		parent::query("
			INSERT INTO `login_settings` (`option_name`, `option_value`) VALUES
			('site_address', '".SITE_PATH."'),
			('default_session', '$minutes'),
			('admin_email', '$address'),
			('block-msg-enable', '1'),
			('block-msg', '<h1>Sorry, Hank.</h1>\r\n\r\n<p>We have detected that your user level does not entitle you to view the page requested.</p>\r\n\r\n<p>Please contact the website administrator if you feel this is in error.</p>\r\n\r\n<h5>What to do now?</h5>\r\n<p>To see this page you must <a href=''logout.php''>logout</a> and login with sufficiant privileges.</p>'),
			('block-msg-out', 'You need to login to do that.'),
			('block-msg-out-enable', '1'),
			('email-welcome-msg', 'Hello {{full_name}} !\r\n\r\nThanks for registering at {{site_address}}. Here are your account details:\r\n\r\nName: {{full_name}}\r\nUsername: {{username}}\r\nEmail: {{email}}\r\nPassword: *hidden*\r\n\r\nYou will first have to activate your account by clicking on the following link:\r\n\r\n{{activate}}'),
			('email-activate-msg', 'Hi there {{full_name}} !\r\n\r\nYour account at {{site_address}} has been successfully activated :). \r\n\r\nFor your reference, your username is <strong>{{username}}</strong>. \r\n\r\nSee you soon!'),
			('email-activate-subj', 'You''ve activated your account at Jigowatt !'),
			('email-activate-resend-subj', 'Here''s your activation link again for Jigowatt'),
			('email-activate-resend-msg', 'Why hello, {{full_name}}. \r\n\r\nI believe you requested this:\r\n{{activate}}\r\n\r\nClick the link above to activate your account :)'),
			('email-welcome-subj', 'Thanks for signing up with Jigowatt :)'),
			('email-forgot-success-subj', 'Your password has been reset at Jigowatt'),
			('email-forgot-success-msg', 'Welcome back, {{full_name}} !\r\n\r\nI''m just letting you know your password at {{site_address}} has been successfully changed. \r\n\r\nHopefully you were the one that requested this password reset !\r\n\r\nCheers'),
			('email-forgot-subj', 'Lost your password at Jigowatt?'),
			('email-forgot-msg', 'Hi {{full_name}},\r\n\r\nYour username is <strong>{{username}}</strong>.\r\n\r\nTo reset your password at Jigowatt, please click the following password reset link:\r\n{{reset}}\r\n\r\nSee you soon!'),
			('email-add-user-subj', 'You''re registered with Jigowatt !'),
			('email-add-user-msg', 'Hello {{full_name}} !\r\n\r\nYou''re now registered at {{site_address}}. Here are your account details:\r\n\r\nName: {{full_name}}\r\nUsername: {{username}}\r\nEmail: {{email}}\r\nPassword: {{password}}'),
			('profile-fields', 'a:1:{s:11:\"textarea[0]\";s:3:\"Bio\";}'),
			('phplogin_version', '2.50'),
			('phplogin_db_version', '1203040');
		");

	}

	private function upgrade_251() {

		parent::updateOption('phplogin_db_version', 1203080);
		parent::updateOption('phplogin_version', 2.51);
		parent::updateOption('pw-encrypt-force-enable', 0);
		parent::updateOption('pw-encryption', 'MD5');

	}

	private function upgrade_252() {

		parent::updateOption('phplogin_db_version', 1203090);
		parent::query("ALTER IGNORE TABLE  `login_users` CHANGE  `password`  `password` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
		parent::query("ALTER TABLE `login_settings` ADD UNIQUE (`option_name`)");

	}

}

$upgrade = new phplogin_upgrade();