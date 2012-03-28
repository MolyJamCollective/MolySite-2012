<?php

include_once( 'class.generic.php' );

class Login extends Generic {

	// Post vars
	private $user;
	private $pass;

	// Misc vars
	private $token;
	private $valid;
	private $result;
	private $error;
	private $msg;

	function __construct() {

		// Are they attempting to access a secure page?
		$this->isSecure();

		// Only allow guests to view this page
		parent::guestOnly();

		// Generate a unique token for security purposes
		parent::generateToken();

		// Login form post data
		if(isset($_POST['login'])) :
			$this->user = parent::secure($_POST['username']);
			$this->pass = parent::secure($_POST['password']);

			$this->token = $_POST['token'];
			$this->process();
		endif;

		// Display the errors and do not exit the page
		$this->error ? parent::displayErrors($this->error, false) : parent::displayErrors($this->msg, false);

	}

	private function isSecure() {

		if(isset($_GET['e'])) :
			if (parent::getOption('block-msg-out-enable'))
				$this->msg = '<div class="alert alert-error">'.parent::getOption('block-msg-out').'</div>';
		endif;
	}

	private function process() {

		// Check that the token is valid, prevents exploits
		if(!parent::valid_token($this->token))
			$this->error = '<div class="alert alert-error">'._('Invalid login attempt').'</div>';

		// Confirm all details are correct
		$this->validate();

		// Log the user in
		$this->login();
	}

	private function validate() {

		if(empty($this->user)) {
			$this->error = "<div class=\"alert alert-error\">"._('You must enter a username.')."</div>";
		} else if(empty($this->pass)) {
			$this->error = "<div class=\"alert alert-error\">"._('What\'s your password?')."</div>";
		}

		if(empty($this->error)) {
			$sql = "SELECT * FROM login_users WHERE username='$this->user'";
			$this->result = mysql_fetch_assoc(parent::query($sql));

			var_dump($this->pass);
			var_dump($this->result['password']);
			if(!parent::validatePassword($this->pass, $this->result['password']))
				$this->error = "<div class=\"alert alert-error\">"._('Incorrect username or password.')."</div>";

		}

	}

	// Once everything's filled out
	private function login() {

		// Just double check there are no errors first
		if(empty($this->error)) {

				// Session expiration
				$minutes = parent::getOption('default_session');
				if($minutes == 0) ini_set('sesion.cookie_lifetime', 0);
				else ini_set('session.cookie_lifetime', 60 * $minutes);

				session_regenerate_id();

				// Check if user still requires activation
				$sql = "SELECT * FROM login_activate WHERE username='$this->user'";
				$count = parent::numRows($sql);

				if ($count > 0) $_SESSION['activate'] = 1;

				// Save if user is restricted
				if ( !empty($this->result['restricted']) ) $_SESSION['restricted'] = 1;

				// Is the admin forcing a password update if encryption is not the desired method?
				if (parent::getOption('pw-encrypt-force-enable')) :

					$type = $this->getOption('pw-encryption');

					if (strlen($this->result['password']) == 32 && $type == 'SHA256')
						$_SESSION['forcePwUpdate'] = 1;

					if (strlen($this->result['password']) != 32 && $type == 'MD5')
						$_SESSION['forcePwUpdate'] = 1;

				endif;

				// Save user's current level
				$user_level = unserialize($this->result['user_level']);
				$_SESSION['user_level'] = $user_level;

				// Save whether their user level is disabled
				$sql = "SELECT level_disabled FROM login_levels WHERE level_level = '$user_level'";
				$disRow =  mysql_fetch_array(parent::query($sql));
				if ( !empty($disRow['level_disabled']) ) $_SESSION['level_disabled'] = 1;

				// Stay signed via checkbox?
				if(isset($_POST['remember'])) {
					ini_set('session.cookie_lifetime', 60*60*24*100); // Set to expire in 3 months & 10 days
					session_regenerate_id();
				}

				// Store a timestamp
				if( parent::getOption('profile-timestamps-enable') ) {
					$accessLog = unserialize(parent::getOption('p-timestamp', false, true, $this->result['user_id']));
					$accessLog[strtotime('now')] = $this->getIPAddress();
					parent::updateOption('p-timestamp', serialize($accessLog), true, $this->result['user_id']);
				}

				// And our magic happens here ! Let's sign them in
				$_SESSION['username'] = $this->result['username'];

				unset($_SESSION['token']);

				// Redirect after it's all said and done
				$referer = (!empty($_SESSION['referer'])) ? $_SESSION['referer'] : "home.php";
				unset($_SESSION['referer']);

				header("Location: " . $referer);
				exit();


		}

	}

}