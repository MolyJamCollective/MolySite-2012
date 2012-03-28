<?php

/**
 * Generic functions used throughout the script.
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

include_once( 'class.translate.php' );
include_once( 'class.connect.php' );

class Generic extends Connect {

	private $error;

	function __construct() {

		// Check to make sure install is complete
		$this->error = parent::checkInstall();

		// Call the connection
		if(empty($this->error)) $this->error = parent::dbConn();

		$this->definePaths();

		// Start the session. Important.
		if (!isset($_SESSION)) session_start();

		// Check if an upgrade is required
		if(empty($this->error)) include_once( 'class.upgrade.php' );

		// Check for any errors and quit if there are
		$this->displayErrors($this->error);

	}

	/**
	 * Returns a mySQL query.
	 *
	 * An error will be echoed if one exists.
	 *
	 * @param     string      $query    An SQL statement.
	 * @param     bool        $exit     Whether to fail silently or not.
	 * @return    resource    Returns mysql_query()'s return.
	 */
	public function query($query, $exit = true) {

		$result = mysql_query($query);

		if (!$result) {
			if($exit) {
				echo _('Could not run query: ') . mysql_error();
				include_once(cINC . 'templates/globals.php');
				include_once(cINC . 'templates/footer.php');
				exit;
			}
		}

		return $result;

	}

	/**
	 * Returns rows from an SQL query.
	 *
	 * @param     string    $query    An SQL statement.
	 * @return    int       The amount of rows found for this query.
	 */
	public function numRows($query) {

		$result = $this->query($query);
		$count = mysql_num_rows($result);

		return $count;

	}

	/**
	 * Retrieves an option value based on option name.
	 *
	 * @param     string    $option    Name of option to retrieve.
	 * @param     bool      $check     Whether the option is a checkbox.
	 * @param     bool      $profile   Whether to return a profile field, or an admin setting.
	 * @param     int       $id        Required if profile is true; the user_id of a user.
	 * @return    string    The option value.
	 */
	public function getOption($option, $check = false, $profile = false, $id = '') {

		if (empty($option))
			return false;

		$option = trim($option);
		$sql = !$profile ? "SELECT option_value FROM login_settings WHERE option_name = '$option' LIMIT 1"
						: "SELECT profile_value FROM login_profiles WHERE profile_label = '$option' AND user_id = '$id' LIMIT 1";
		$result = $this->query($sql, false);

		if(!$result)
			return false;

		$result = @mysql_result($result, 0);

		if($check)
			$result = !empty($result) ? 'checked="checked"' : '';

		return $result;

	}

	/**
	 * Updates an option in the database.
	 *
	 * If an option exists in the database, it will be updated. If it does not exist,
	 * the option will be created.
	 *
	 * @param     string    $option      Name of option to retrieve.
	 * @param     bool      $newvalue    Option's new value to set.
	 * @param     bool      $profile     Whether to update a profile field, or an admin setting.
	 * @param     int       $id          Required if profile is true; the user_id of a user.
	 * @return    bool      Whether the update was successful or not.
	 */
	public function updateOption($option, $newvalue, $profile = false, $id = '') {

		$option = trim($option);
		if ( empty($option) || !isset($newvalue) )
			return false;


		$oldvalue = $profile ? $this->getOption($option, false, true, $id)
							 : $this->getOption($option);

		if ( $newvalue === $oldvalue )
			return false;

		if ( false === $oldvalue ) :
			$sql = $profile ? "INSERT INTO `login_profiles` (`user_id`, `profile_label`, `profile_value`) VALUES ('$id', '$option', '$newvalue')"
							: "INSERT INTO `login_settings` (`option_name`, `option_value`) VALUES ('$option', '$newvalue')";
			return $this->query($sql);
		endif;

		$sql = $profile ? "UPDATE `login_profiles` SET `profile_value` = '$newvalue' WHERE `profile_label` = '$option' AND `user_id` = '$id'"
						: "UPDATE `login_settings` SET `option_value` = '$newvalue' WHERE `option_name` = '$option'";

		return $this->query($sql);

	}

	/**
	 * Sanitizes titles intended for SQL queries.
	 *
	 * Specifically, HTML and PHP tag are stripped. The return value
	 * is not intended as a human-readable title.
	 *
	 * @param     string    $title    The string to be sanitized.
	 * @return    string    The sanitized title.
	 */
	public function sanitize_title($title) {

		$title = strtolower($title);
		$title = preg_replace('/&.+?;/', '', $title); // kill entities
		$title = str_replace('.', '-', $title);
		$title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
		$title = preg_replace('/\s+/', '-', $title);
		$title = preg_replace('|-+|', '-', $title);
		$title = trim($title, '-');

		return $title;

	}

	/**
	 * Sends HTML emails with optional shortcodes.
	 *
	 * @param     string    $to            Receiver of the mail.
	 * @param     string    $subj          Subject of the email.
	 * @param     string    $msg           Message to be sent.
	 * @param     array     $shortcodes    Shortcode values to replace.
	 * @return    bool      Whether the mail was sent or not.
	 */
	public function sendEmail($to, $subj, $msg, $shortcodes = '') {

		if ( is_array($shortcodes) ) :

			foreach ($shortcodes as $code => $value)
				$msg = str_replace('{{'.$code.'}}', $value, $msg);

		endif;

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: ' . address . "\r\n";
		$headers .= 'Reply-To: ' . address . "\r\n";
		$headers .= 'Return-Path: ' . address . "\r\n";

		return mail($to, $subj, nl2br($msg), $headers);

	}

	/**
	 * Generate profile fields.
	 *
	 * Will populate the returned fields with data from the current user.
	 */
	public function generateProfile() {

		$fields = $this->getOption('profile-fields');
		$user_id = $this->getField('user_id');
		if ($fields) :
			foreach(unserialize($fields) as $type => $label) : ?>
			<?php $name = 'p-'.$this->sanitize_title($label); ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $name; ?>"><?php echo $label; ?></label>
				<div class="controls">
				<?php if (strstr($type, 'text_input')) : ?>
					<input type="text" class="input-xlarge" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $this->getOption("$name", false, true, $user_id); ?>">
				<?php elseif (strstr($type, 'checkbox')) : ?>
					<input type="checkbox" class="input-xlarge" id="<?php echo $name; ?>" name="<?php echo $name; ?>" <?php echo $this->getOption("$name", true, true, $user_id); ?>>
				<?php elseif (strstr($type, 'textarea')) : ?>
					<textarea class="input-xlarge" id="<?php echo $name; ?>" name="<?php echo $name; ?>" rows="5"><?php echo $this->getOption("$name", false, true, $user_id); ?></textarea>
				<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>

		<?php if( ($this->getOption('profile-timestamps-admin-enable') && !in_array(1, $_SESSION['user_level'])) || !$this->getOption('profile-timestamps-enable') ) return; ?>
		<?php
			if($this->getOption("p-timestamp", false, true, $user_id))
				$timestamps = unserialize($this->getOption("p-timestamp", false, true, $user_id));
			else $timestamps = array();
		?>
		<legend><?php _e('Access Logs'); ?></legend>
		<table class="table table-condensed span6">
			<thead>
				<tr>
					<th><?php _e('Last Accessed'); ?></th>
					<th><?php _e('Location'); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php if(!empty($timestamps)) : ?>
			<?php foreach($timestamps as $time => $location) : ?>
				<tr>
					<td><?php echo date('M d, Y', $time) . ' ' . _('at') . ' ' . date('h:i a', $time); ?></td>
					<td><?php echo $location; ?></td>
				</tr>
			<?php endforeach; ?>
			<?php else : ?>
			<tr><td><?php _e('Has not logged in yet'); ?></td></tr>
			<?php endif; ?>
			</tbody>
		</table>
		<?php endif;
	}

	/**
	 * Only allows guests to view page.
	 *
	 * A logged in user will be shown an error and denied from viewing the page.
	 */
	public function guestOnly() {

		if(isset($_SESSION['username'])) {
			$this->error =	"
							<div class='alert alert-error'>"._('You\'re already logged in.')."</div>
							<h5>"._('What to do now?')."</h5>
							<p>" . sprintf(_('Go <a href="%s">back</a> to the page you were viewing before this.'), 'javascript:history.go(-1)') . "</p>
							";
		}

		$this->displayErrors($this->error);

	}

	/**
	 * Generates a unique token.
	 *
	 * Intended for form validation to prevent exploit attempts.
	 */
	public function generateToken() {

		if(empty($_SESSION['token']))
			$_SESSION['token'] = md5(uniqid(mt_rand(),true));

	}

	/**
	 * Prevents invalid form submission attempts.
	 *
	 * @param     string    $token    The POST token with a form.
	 * @return    bool      Whether the token is valid.
	 */
	public function valid_token($token) {

		return (isset($_SESSION['token']) || $token == $_SESSION['token']);

	}

	/**
	 * Secures any string intended for SQL execution.
	 *
	 * @param     string    $string
	 * @return    string    The secured value string.
	 */
	public function secure($string) {

		// This really is deprecated but some servers still use magic quotes
		$escape = get_magic_quotes_gpc() ? "stripslashes" : "mysql_real_escape_string";

		if ( ! is_array($string) ) :
			$string = $escape(trim($string));
		else :
			foreach ($string as $key => $value) :
				$string[$key] = $escape(trim($value));
			endforeach;
		endif;

		return $string;

	}

	/**
	 * Validates an email address.
	 *
	 * @param     string    $email    The email address.
	 * @return    bool      Whether the email address is valid or not.
	 */
	public function isEmail($email) {
		return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
	}

	/**
	 * Defines variables used throughout the script.
	 *
	 * Definitions:
	 * cINC                   The current directory, whether /admin/ or root.
	 * address                Administrator's email address.
	 * SITE_PATH              Should be set with a trailing slash, where activate.php is located.
	 * phplogin_db_version    The current script's database version.
	 *                        Used for keeping track of necessary db updates.
	 *                        Follows format - Year : Month : Day : Revision.
	 * phplogin_version       Core version of the script.
	 */
	public function definePaths() {

		if (!defined('cINC'))                   define( "cINC", dirname($_SERVER['SCRIPT_FILENAME']) . '/' );
		if (!defined("address"))                define( 'address', $this->getOption('admin_email') );
		if (!defined("SITE_PATH"))              define( 'SITE_PATH', $this->getOption('site_address') );
		if (!defined("phplogin_db_version"))    define("phplogin_db_version", 1203090);
		if (!defined("phplogin_version"))       define("phplogin_version", 2.54);

	}

	/**
	 * Hashes a password for either MD5 or SHA256.
	 *
	 * If hashing SHA256, a unique salt will be hashed with it.
	 *
	 * @param     string    $password    A plain-text password.
	 * @return    string    Hashed password.
	 */
	public function hashPassword($password) {

		$type = $this->getOption('pw-encryption');

		// Checks if the pw should be MD5, if so, don't continue
		if($type == 'MD5') return md5($password);

		$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
		$hash = hash($type, $salt . $password);
		$final = $salt . $hash;

		return $final;

	}

	/**
	 * Validates a password.
	 *
	 * A plain-text password is compared against the hashed version.
	 *
	 * @param     string    $password       A plain-text password.
	 * @param     string    $correctHash    The hashed version of a correct password.
	 * @return    bool      Whether or not the plain-text matches the correct hash.
	 */
	public function validatePassword($password, $correctHash) {

		$type = $this->getOption('pw-encryption');

		// Checks if the password is MD5 and return
		if(strlen($correctHash) == 32)
			return md5($password) === $correctHash;
		else $type = 'SHA256';

		// Continue testing the hash against the salt
		$salt = substr($correctHash, 0, 64);
		$validHash = substr($correctHash, 64, 64);

		$testHash = hash($type, $salt . $password);

		return $testHash === $validHash;

	}

	/**
	 * Displays an error and optionally quits the script.
	 *
	 * @param     string    $error    The error message to display.
	 * @param     bool      $exit     Whether to exit after the error and prevent the
	 *                                page from loading any further.
	 */
	public function displayErrors($error, $exit = true) {

		if(!empty($error)) :

			// Current headers
			include_once(cINC . 'templates/globals.php');
			include_once(cINC . 'templates/header.php');

			// The error itself
			echo $error;

			// Shall we exit or not?
			if($exit) {
				include_once(cINC . 'templates/footer.php');
				exit();
			}

		endif;

	}

	/** Checks if the $_POST value exists in the database already or not. **/
	public function checkExists() {

		if(!empty($_POST['email']) && !empty($_POST['checkemail']))
			$sql = sprintf("SELECT `%s` FROM `login_users` WHERE %s = '%s'", 'email', 'email', $this->secure($_POST['email']));

		else if(!empty($_POST['username']) && !empty($_POST['checkusername']))
			$sql = sprintf("SELECT `%s` FROM `login_users` WHERE %s = '%s'", 'username', 'username', $this->secure($_POST['username']));

		else if(!empty($_POST['auth']) && !empty($_POST['checklevel']))
			$sql = sprintf("SELECT `%s` FROM `login_levels` WHERE %s = '%s'", 'level_level', 'level_level', $this->secure($_POST['auth']));

		else return false;

		echo ( $this->numRows($sql) > 0 ) ? "false" : "true";
		exit();

	}

	/**
	 * Finds the current IP address of a visiting user.
	 *
	 * @return    string    The IP address
	 */
	public function getIPAddress() {

		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) :
			$ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
		else :
			$ipAddress = isset($_SERVER["HTTP_CLIENT_IP"]) ? $_SERVER["HTTP_CLIENT_IP"] : $_SERVER["REMOTE_ADDR"];
		endif;

		return $ipAddress;
	}

}

// This class Generic must be instantiated for the session to start
$generic = new Generic();