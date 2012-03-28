<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'Page Title';
    $pageHeader = 'Page Header';
    $pageStyles = array();

    $pageScripts = array();
    $PageScriptsRaw = '';

    include_once('./templates/header.php');
	include_once ('classes/class.generic.php');

class Activate extends Generic {

	private $key;
	private $user;
	private $error;

	function __construct() {

		// Assign their username to a variable
		if(isset($_SESSION['username']))
			$this->user = $_SESSION['username'];

		// Are they clicking from an email?
		if(isset($_GET['key'])) {
			$this->key = parent::secure($_GET['key']);
			$this->getKey();

		// Do they want the key resent?
		} else if(isset($_GET['resend']) && $_GET['resend'] == '1') {
			$this->resendKey();

		// Are they already signed in without a key?
		} else if(isset($this->user) && !isset($this->key)) {
			$this->signedIn();
		} else header('location: index.php');

		// Display any errors
		parent::displayErrors($this->error, false);

	}

	private function getKey() {

		$result = parent::query("SELECT login_activate.email,login_activate.username, login_users.name
								FROM login_activate, login_users
								WHERE login_activate.code='$this->key'
								AND login_activate.username = login_users.username");
		$rowCheck = mysql_num_rows($result);

		if ($rowCheck != 0) {

			$row = mysql_fetch_array($result);
			$username = $row['username'];
			$to = $row['email'];

			// Activate by deleting the activation code
			parent::query("DELETE FROM login_activate WHERE username='$username'");

			// Set user's activate session to false
			if(!empty($_SESSION['activate'])) unset($_SESSION['activate']);

			echo "<div class=\"alert alert-success\">"._('Your account has been activated!')."</div>" ._('You can now see the default access granted to new users.')."
				 <p>"._('If you require more access please contact the site admin at')." " . address . "</p>
				 <h5>"._('What to do now?')."</h5>
				 <p>" . sprintf(_('Go to the <a href="%s"> homepage</a>'), 'index.php') . "</p>";

			$shortcodes = array(
				'site_address'	=>	SITE_PATH,
				'full_name'		=>	$row['name'],
				'username'		=>	$username
			);

			$msg = parent::getOption('email-activate-msg');
			$subj = parent::getOption('email-activate-subj');


			if(!parent::sendEmail($to, $subj, $msg, $shortcodes))
				$this->error = "ERROR. Mail not sent";

		} else {
			$this->error = "<div class=\"alert alert-error\">"._('Your activation link is incorrect.')."</div>
					  <h5>"._('What to do now?')."</h5>
					  <p>" . sprintf(_('Go to the <a href="%s"> homepage</a>'), 'index.php') . "</p>";
		}
	}

	private function resendKey() {

			$result = parent::query("SELECT login_activate.email,login_activate.username, login_activate.code, login_users.name
									FROM login_activate, login_users
									WHERE login_activate.username='$this->user'
									AND login_users.username ='$this->user'");

			$row = mysql_fetch_array($result);
			$code = $row['code'];

			if (!empty($code)) {

				$shortcodes = array(
					'site_address'	=>	SITE_PATH,
					'full_name'		=>	$row['name'],
					'username'		=>	$this->user,
					'activate'		=>	SITE_PATH . "activate.php?key=$code"
				);

				$subj = parent::getOption('email-activate-resend-subj');
				$msg = parent::getOption('email-activate-resend-msg');
				$to = $row['email'];

				if(parent::sendEmail($to, $subj, $msg, $shortcodes)) {
					$this->error = "<div class=\"alert alert-success\">"._('Activation link resent to email.')."</div>
							  <h5>"._('What to do now?')."</h5>"
							  ._('Click the link in your email to activate your account.')." ";
				} else $this->error = _('ERROR. Mail not sent');
			} else {
				$this->error = "<div class=\"alert alert-error\">"._('You do not have an activation code!')."</div>
						  <p>"._('Please contact an admin:')." " . address . "</p>";
			}
	}

	private function signedIn() {

		// Check if user needs activation
		$sql = "SELECT * FROM login_activate WHERE username='$this->user'";
		$rowCheck = parent::numRows($sql);

		if ($rowCheck < 1) {
			$this->error = "<div class=\"alert alert-error\">"._('Your account has already been activated.')."</div>
					  <h5>"._('What to do now?')."</h5>
					  <p>" . sprintf(_('Go to the <a href="%s"> homepage</a>'), 'index.php') . "</p>";
		} else {
			$this->error = "<div class=\"alert alert-error\">"._('You have not activated your account yet.')."</div>
					  <h5>"._('What to do now?')."</h5>"
					 ._('Please follow the link in your email to activate your account.')."<br/><br/>"
					 ._('Would you like us to')." <a href='activate.php?resend=1'>"._('resend')."</a>" ._('the link?');
		}
	}

}

	$activate = new Activate;
    include_once('./templates/footer.php');
?>