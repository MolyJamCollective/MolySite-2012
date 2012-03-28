<?php

include_once( 'class.generic.php' );

class SignUp extends Generic {

	private $token;
	private $error;
	private $settings = array();

	function __construct() {

		// Only allow guests to view this page
		parent::guestOnly();

		// jQuery form validation
		parent::checkExists();

		// Generate a unique token for security purposes
		parent::generateToken();

		// Has the form been submitted?
		if(!empty($_POST)) {

			// Sign up form post data
			foreach ($_POST as $field => $value)
				$this->settings[$field] = parent::secure($value);

			$this->process();

		}

		parent::displayErrors($this->error, false);

	}

	private function process() {

		// Check that the token is valid, prevents exploits
		if(!parent::valid_token($this->settings['token']))
			$this->error = '<div class="alert alert-error">'._('Invalid signup attempt').'</div>';

		// See if all the values are correct
		$this->validate();

		// Sign um up!
		$this->register();

	}

	private function validate() {

		if(empty($this->settings['username'])) {
			$this->error .= '<li>'._('You must enter a username.').'</li>';
		} else {
			$userCount = mysql_num_rows(parent::query("SELECT * FROM login_users WHERE username='".$this->settings['username']."'"));
			if ($userCount > 0) $this->error .= '<li>Sorry, username already taken.</li>';
		}
		if(strlen($this->settings['username']) > 11) {
			$this->error .= '<li>'._('Your username must be under 11 characters').'</li>';
		}
		if(empty($this->settings['name'])) {
			$this->error .= '<li>'._('You must enter your name.').'</li>';
		}
		if (!empty($this->settings['email'])) {
			$emailCount = mysql_num_rows(parent::query("SELECT * FROM login_users WHERE email='".$this->settings['email']."'"));
			if ($emailCount > 0)
			$this->error .= '<li>'._('That email address has already been taken.').'</li>';
		}
		if (!parent::isEmail($this->settings['email'])) {
			$this->error .= '<li>'._('You have entered an invalid e-mail address, try again.').'</li>';
		}
		if($this->settings['password'] != $this->settings['password_confirm']) {
			$this->error .= '<li>'._('Your passwords did not match.').'</li>';
		}
		if(strlen($this->settings['password']) < 5) {
			$this->error .= '<li>'._('Your password must be at least 5 characters.').'</li>';
		}
		if($this->settings['validation'] != '9') {
			$this->error .= '<li>'._('Are you not human?').'</li>';
		}

		// Output the errors in a pretty format :]
		if(isset($this->error)) {
		$this->error = "<div class='alert alert-error alert-block'><h4 class='alert-heading'>"._('Attention!')."</h4>$this->error</div>";
		} else $this->error = '';
	}

	// Return a value if it exists
	public function getPost($var) {

		return empty($this->settings[$var]) ? '' : $this->settings[$var];

	}

	// Once everything's filled out
	private function register() {

		if(empty($this->error)) {

			// Log user in when they register
			$_SESSION['username'] = $this->settings['username'];

			// Apply default user_level 3, "User"
			$_SESSION['user_level'] = unserialize("a:1:{i:0;s:1:\"3\";}");

			// Force them to activate their account
			$_SESSION['activate'] = 1;

			// Create their account
			$sql = sprintf("INSERT INTO login_users (user_level, name, email, username, password)
						VALUES ('a:1:{i:0;s:1:\"3\";}', '%s', '%s', '%s', '%s')", $this->settings['name'], $this->settings['email'], $this->settings['username'], parent::hashPassword($this->settings['password']));


			$query = parent::query($sql);

			// Create the activation key
			$code = md5(uniqid(mt_rand(),true));
			$sql = "INSERT INTO login_activate (username, code, email)
								VALUES ('".$this->settings['username']."', '$code', '".$this->settings['email']."')";

			$query = parent::query($sql);

?>
			<div class="row-fluid">
				<div class="span12">
					<div class='alert alert-success'><?php _e('You are now logged in. Thank you for registering!'); ?></div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span4">
					<h2><?php _e('Your login details'); ?></h2>

					<p><b><?php _e('Name'); ?></b>: <?php echo $this->settings['name']; ?></p>
					<p><b><?php _e('Username'); ?></b>: <code><?php echo $this->settings['username']; ?></code></p>
					<p><b><?php _e('E-Mail'); ?></b>: <?php echo $this->settings['email']; ?></p>
					<p><b><?php _e('Password'); ?></b>: <em>*hidden*</em></p>
				</div>

				<div class="span4">
					<h5><?php _e('What to do now?'); ?></h5>
					<p><?php _e('Check your email to activate your account.'); ?></p>
					<p><?php sprintf(_('Or go to the <a href="%s"> homepage</a>'), 'home.php'); ?></p>
				</div>
			</div>
<?php

			$msg = parent::getOption('email-welcome-msg');
			$subj = parent::getOption('email-welcome-subj');

			$shortcodes = array(
				'site_address'	=>	SITE_PATH,
				'full_name'		=>	$this->settings['name'],
				'username'		=>	$this->settings['username'],
				'email'			=>	$this->settings['email'],
				'activate'		=>	SITE_PATH . "activate.php?key=$code"
			);

			if(!parent::sendEmail($this->settings['email'], $subj, $msg, $shortcodes))
				$this->error = _('ERROR. Mail not sent');

			unset($_SESSION['token']);
			include(cINC . 'templates/footer.php');
			exit();
		}

	}

}

$signUp = new SignUp();