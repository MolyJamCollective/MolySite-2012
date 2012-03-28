<?php

include_once( 'class.generic.php' );

class Forgot extends Generic {

	// Form vars
	private $key;
	private $password;
	private $password2;

	// Misc vars
	private $error;
	private $name;
	private $email;
	private $user;

	function __construct() {

		// Are they clicking from an email?
		if(isset($_GET['key']) && strlen($_GET['key']) == 32) {
			$this->key = parent::secure($_GET['key']);

			// Has the form been submitted?
			if(isset($_POST['reset'])) {
				$this->password = parent::secure($_POST['password']);
				$this->password2 = parent::secure($_POST['password2']);
			}
		  // Redirect if not clicking from email, and modal form hasn't been submitted
		} else if (!isset($_GET['key']) && !isset($_POST['usernamemail'])) header('Location: index.php');
	}

	private function validate() {

		// Further security check right here
		if(isset($_POST['reset']) && isset($this->key)) {

			// Just some input validation
			if($this->password != $this->password2) {
				$this->error = '<div class="alert alert-error">'._('Your passwords did not match, try again.').'</div>';
			} else if(strlen($this->password) < 5) {
				$this->error = '<div class="alert alert-error">'._('Your password must be at least 5 characters.').'</div>';
			}

			// No errors, then lets double check the key
			if(empty($this->error) && isset($this->key)) {

				$sql = "
						SELECT login_forgot.email, login_forgot.code, login_users.email, login_users.name, login_users.username
						FROM login_forgot, login_users
						WHERE code ='$this->key'
						AND login_users.email = login_forgot.email;
						";

				$row = mysql_fetch_array(parent::query($sql));

				// Key is invalid !
				if(!$row) {
					$this->error = '<div class="alert alert-error">'._('Verification failed.').'</div>';
				} else {
					$this->email = $row['email'];
					$this->name  = $row['name'];
					$this->user  = $row['username'];
				}
			}

		}
	}

	private function resetpw() {

		// Further security
		if(empty($this->error) && isset($_POST['reset']) && isset($this->key)) {

			// Delete the recovery key so it can't be reused
			$sql = "DELETE FROM login_forgot WHERE email = '$this->email'";
			parent::query($sql);

			// Resets their password
			$sql = sprintf("UPDATE login_users SET password = '%s' WHERE email='%s'", parent::hashPassword($this->password), $this->email);
			parent::query($sql);

			$shortcodes = array(
				'site_address'	=>	SITE_PATH,
				'full_name'		=>	$this->name,
				'username'		=>	$this->user
			);

			$subj = parent::getOption('email-forgot-success-subj');
			$msg = parent::getOption('email-forgot-success-msg');

			// Send an email confirming their password reset
			if(!parent::sendEmail($this->email, $subj, $msg, $shortcodes))
				$this->error = "ERROR. Mail not sent";

			echo "<div class='alert alert-success'>"._('Successfully reset your password')."</div>";
			echo "<h2>"._('Account Recovery')."</h2>";
			echo "<p>"._('If you need any further assistance please contact the website administrator:')." " . address . "</p>";
			include_once('templates/footer.php');
			exit();

		} else echo $this->error;

	}

	private function reset_form() {

		if(isset($this->key)) { ?>
			<div class="row-fluid">
				<div class="span6">
					<form class="form-horizontal" method="post">
						<fieldset>
							<legend><?php _e('Account Recovery'); ?></legend>
							<div class="control-group">
								<label class="control-label" for="password"><?php _e('New password'); ?></label>
								<div class="controls">
									<input type="password" class="input-xlarge" id="password" name="password">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="password2"><?php _e('Confirm password'); ?></label>
								<div class="controls">
									<input type="password" class="input-xlarge" id="password2" name="password2">
								</div>
							</div>
						</fieldset>
						<div class="form-actions">
							<button type="submit" class="btn btn-primary" name="reset"><?php _e('Reset Password'); ?></button>
						</div>
					</form>
				</div>
			</div>
<?php	}
	}

	public function modal_process() {

		if(isset($_POST['usernamemail'])) {

			$usernamemail = parent::secure($_POST['usernamemail']);

			// The input field wasn't filled out
			if (empty($usernamemail)) {
				$this->error = '<div class="alert alert-error">'._('Please enter your username or email address.').'</div>';
			} else {

				$sql = "SELECT * FROM login_users WHERE username='$usernamemail' or email ='$usernamemail'";
				$result = parent::query($sql);

				// Check that at least one row was returned
				$rowCheck = mysql_num_rows($result);

				if($rowCheck > 0) {
					while($row = mysql_fetch_array($result)) {

						// Reuse the email variable
						$email = $row['email'];

						// Check that a recovery key doesn't already exist, if it does, remove it
						$sql = "SELECT * FROM login_forgot WHERE email = '$email'";
						$rowCheck = parent::numRows($sql);
						if ($rowCheck > 0) {
							$sql = "DELETE FROM login_forgot WHERE email = '$email'";
							parent::query($sql);
						}

						// Generate a new recovery key
						$code = md5(uniqid(mt_rand(),true));
						$sql = "INSERT INTO login_forgot (email, code) VALUES ('$email', '$code')";
						parent::query($sql);

						$shortcodes = array(
							'site_address'	=>	SITE_PATH,
							'full_name'		=>	$row['name'],
							'username'		=>	$row['username'],
							'reset'			=>	SITE_PATH . "forgot.php?key=$code"
						);

						$subj = parent::getOption('email-forgot-subj');
						$msg = parent::getOption('email-forgot-msg');

						// Send an email confirming their password reset
						if(!parent::sendEmail($email, $subj, $msg, $shortcodes))
							$this->error = '<div class="alert alert-error">'._('ERROR. Mail not sent').'</div>';
						else
							$this->error = "<div class='alert alert-success'>"._('We\'ve emailed you password reset instructions. Check your email.')."</div>";
					}

				} else { $this->error = '<div class="alert alert-error">'._('I searched for you high and low but couldn\'t find you :(').'</div>'; }
			}

			echo $this->error;

		}

	}

	public function process() {

		// Only allow guests to view this page
		parent::guestOnly();

		// Check for correct and complete values
		$this->validate();

		// If there are no errors, let's reset the password
		$this->resetpw();

		// Show the form if $_GET key is set
		$this->reset_form();

	}

}