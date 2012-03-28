<?php
include_once('classes/class.check.php'); protect("*");

include_once ('./templates/globals.php');
include_once ('./templates/header.php');

class myAccount extends Generic {

	private $settings = array();
	private $error;

	function __construct() {

		if(!empty($_SESSION['forcePwUpdate'])) {
			$this->forcePwUpdate = 1;
			echo "<div class='alert alert-warning'><strong>"._('Alert')."</strong>:" ._('The administrator has requested all users to update their passwords.')."</div>";
		}

		// Save the username
		$this->username = $_SESSION['username'];

		if (!empty($_POST)) :
			$this->retrieveFields();

			foreach ($_POST as $field => $value)
				$this->settings[$field] = parent::secure($value);

			// Validate fields
			$this->validate();

			// Process form
			if(empty($this->error)) $this->process();

			parent::displayErrors($this->error, false);

		endif;

		$this->retrieveFields();


	}

	// Retrieve name, email, user_id
	private function retrieveFields() {

		$sql = "SELECT user_id,name,email FROM login_users WHERE username='$this->username'";
		foreach (mysql_fetch_assoc(parent::query($sql)) as $field => $value) :
			$this->settings[$field] = parent::secure($value);
		endforeach;

	}

	// Return a form field
	public function getField($field) {

		if (!empty($this->settings[$field]))
			return $this->settings[$field];

	}

	// Validate form inputs
	private function validate() {

		if(empty($this->settings['CurrentPass'])) {
			$this->error = '<div class="alert alert-error">'._('You must enter the current password to make changes.').'</div>';
			return false;
		}

		$sql = "SELECT password FROM login_users WHERE username='$this->username'";
		$row =  mysql_fetch_array(parent::query($sql));

		if ( !parent::validatePassword($this->settings['CurrentPass'], $row['password']) ) {
			$this->error = '<div class="alert alert-error">'._('You entered the wrong current password.').'</div>';
			return false;
		}

		if (empty($this->settings['name']))
				$this->error .= '<div class="alert alert-error">'._('You must enter a name.').'</div>';

		if (!parent::isEmail($this->settings['email']))
				$this->error .= '<div class="alert alert-error">'._('You have entered an invalid e-mail address, try again.').'</div>';

		if (!empty($this->settings['password'])) {

			if ($this->settings['password'] != $this->settings['confirm'])
				$this->error .= '<div class="alert alert-error">'._('Your passwords did not match.').'</div>';

			if (strlen($this->settings['password']) < 5)
				$this->error = '<div class="alert alert-error">'._('Your password must be at least 5 characters.').'</div>';

		}

		// Checkbox handling
		$fields = parent::getOption('profile-fields');
		if ($fields) :
			foreach(unserialize($fields) as $type => $label) :
				$name = 'p-'.parent::sanitize_title($label);
				if(strstr($type, "checkbox"))
					$this->settings[$name] = !empty($this->settings[$name]) ? 1 :0;
			endforeach;
		endif;

	}

	private function process() {

		if (!empty($this->settings['password'])) {
			// Update password fields too
			$sql = sprintf("UPDATE login_users SET name='%s', email='%s', password = '%s' WHERE username = '%s'", $this->settings['name'], $this->settings['email'], parent::hashPassword($this->settings['password']), $this->username);
			parent::query($sql);
			$this->error = "<div class='alert alert-success'>"._('User information (and password) updated for')." <b>".$this->settings['name']."</b> ($this->username).</div>";
			if(!empty($_SESSION['forcePwUpdate'])) unset($_SESSION['forcePwUpdate']);
		} else if (empty($this->settings['password'])) {
			// Password has not been entered so don't update password fields.
			$sql = sprintf("UPDATE login_users SET name='%s', email='%s' WHERE username = '%s'", $this->settings['name'], $this->settings['email'], $this->username);
			parent::query($sql);
			$this->error = "<div class='alert alert-success'>"._('User information updated for')." <b>".$this->settings['name']."</b> ($this->username).</div>";
		}

		// Update profile fields
		foreach($this->settings as $field => $value) :
			if(strstr($field,"p-"))
				parent::updateOption($field, $value, true, $this->settings['user_id']);
		endforeach;

	}


}