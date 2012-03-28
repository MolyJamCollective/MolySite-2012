<?php

include_once(dirname(dirname(dirname(__FILE__))) . '/classes/class.generic.php');

class Add_user extends Generic {

	private $result;
	private $error;

	private $username;
	private $name;
	private $email;
	private $password;

	function __construct() {

		// jQuery form validation
		parent::checkExists();

		if(isset($_POST['add_user'])) {
			$this->name = parent::secure($_POST['name']);
			$this->username = parent::secure($_POST['username']);
			$this->email = parent::secure($_POST['email']);
			$this->password = $this->gen_password();

			// Confirm all details are correct
			$this->verify();

			// Create the user
			$this->adduser();

		}

	}

	// Return a value if it exists
	public function getPost($var) {

		if(!empty($this->$var)) {
			return $this->$var;
		} else return false;

	}

	private function verify() {

		if(empty($this->name)) {
			$this->error = '<div class="alert alert-error">'._('You must enter a name.').'</div>';
		} else if(empty($this->username)) {
			$this->error = '<div class="alert alert-error">'._('You must enter a username.').'</div>';
		} else if (!parent::isEmail($this->email)) {
			$this->error = '<div class="alert alert-error">'._('You have entered an invalid e-mail address, try again.').'</div>';
		}

		if (!empty($this->email)) {
			$emailCount = mysql_num_rows(mysql_query("SELECT * FROM login_users WHERE email='$this->email'"));
			if ($emailCount > 0)
				$this->error = '<div class="alert alert-error">'._('That email address has already been taken.').'</div>';
		}
		if (!empty($this->username)) {
			$userCount = mysql_num_rows(mysql_query("SELECT * FROM login_users WHERE username='$this->username'"));
			if($userCount > 0)
				$this->error = '<div class="alert alert-error">'._('Sorry, username already taken.').'</div>';
		}

	}

	// Password generator
	private function gen_password($len = 6) {
		return substr(md5(rand().rand()), 0, $len);
	}

	private function adduser() {

		if(isset($_POST['add_user']) && empty($this->error)) {

			$sql = sprintf("INSERT INTO login_users (user_level, name, email, username, password)
						VALUES ('a:1:{i:0;s:1:\"3\";}', '%s', '%s', '%s', '%s')", $this->name, $this->email, $this->username, parent::hashPassword($this->password));

			parent::query($sql);

			$shortcodes = array(
				'site_address'	=>	SITE_PATH,
				'full_name'		=>	$this->name,
				'username'		=>	$this->username,
				'email'			=>	$this->email,
				'password'		=>	$this->password
			);

			$subj = parent::getOption('email-add-user-subj');
			$msg = parent::getOption('email-add-user-msg');

			if(!parent::sendEmail($this->email, $subj, $msg, $shortcodes))
				$this->error = _('ERROR. Mail not sent');

			$this->result = "<div class='alert alert-success'>"._('Successfully added user')." <b>$this->username</b> "._('to the database. Credentials sent to user.')."</div>";

			// Unset the variables
			$this->name = '';
			$this->username = '';
			$this->email = '';
		}

		if($this->error) echo $this->error;
			else echo $this->result;

		exit();

	}

}

$addUser = new Add_user();