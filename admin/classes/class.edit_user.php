<?php

include_once('../classes/class.generic.php');

class Edit_user extends Generic {

	private $options = array();

	function __construct() {

		// Make sure a user has been selected
		if(!empty($_GET['uid'])) $this->grabCurrentUser(); else parent::displayErrors("<div class='alert alert-error'>"._('No user selected!')."</div>");

		// Once the form has been processed
		if(!empty($_POST)) {

			// Save all values
			foreach ($_POST as $key => $value)
				$this->options[$key] = $value;

			// Validate fields
			$this->validate();

			// Process the form
			echo empty($this->error) ? $this->process() : $this->error;

		}

	}

	private function grabCurrentUser() {

		$this->id = parent::secure($_GET['uid']);

		$sql = sprintf("SELECT user_id, user_level, restricted, username, name, email FROM login_users WHERE user_id = '%s'", $this->id);
		$count = parent::numRows($sql);

		if(!$count) parent::displayErrors("<div class='alert alert-error'>"._('No such user!')."</div>");

		foreach (mysql_fetch_assoc(parent::query($sql)) as $field => $value) :
			$this->options[$field] = $value;
		endforeach;

	}

	public function getLevels() {

		$ids = empty($_POST) ? join(',',unserialize($this->options['user_level'])) : join(',',$this->options['user_level']);
		$sql2 = "SELECT level_name, level_level FROM login_levels WHERE level_disabled != 1 AND level_level NOT IN ($ids)";
		$this->result2 = parent::query($sql2);

		$sql3 = "SELECT level_name, level_level FROM login_levels WHERE level_level IN ($ids)";
		$this->result3 = parent::query($sql3);

		?>
		<select class="medium" multiple="multiple" id="user_level" name="user_level[]">
			<?php while($level = mysql_fetch_assoc($this->result3)) { ?>
			<?php echo $level['level_level'];  ?>
			<option selected="selected" value="<?php echo $level['level_level']; ?>"><?php echo $level['level_name']; ?></option> <?php }
			while($level = mysql_fetch_array($this->result2)) { echo '<option value="'.stripslashes($level['level_level']).'">'.stripslashes($level['level_name']).'</option>'; } ?>
		</select>
		<?php

	}

	private function validate() {

		$this->options['restricted'] = !empty($_POST['restricted']) ? 1 : 0;

		// Checkbox handling
		$fields = parent::getOption('profile-fields');
		if ($fields) :
			foreach(unserialize($fields) as $type => $label) :
				$name = 'p-'.parent::sanitize_title($label);
				if(strstr($type, "checkbox"))
					$this->options[$name] = !empty($this->options[$name]) ? 1 :0;
			endforeach;
		endif;

		// Setting a default user_level if one wasn't selected
		if (empty($this->options['user_level']))
			$this->options['user_level'] = array(0 => '3');

		if(empty($this->options['name'])) {
			$this->error = '<div class="alert alert-error">'._('You must enter name.').'</div>';
		} else if(!parent::isEmail($this->options['email'])) {
			$this->error = '<div class="alert alert-error">'._('You have entered an invalid e-mail address, try again.').'</div>';
		} else if(!isset($this->options['user_level'])) {
			$this->error = '<div class="alert alert-error">'._('No user level has been selected.').'</div>';
		}

		// Password been entered? If so, validate
		if(!empty($this->options['password'])) :
			if($this->options['password'] != $this->options['password2'])
				$this->error = '<div class="alert alert-error">'._('Your passwords did not match.').'</div>';
			if(strlen($this->options['password']) < 5)
				$this->error = '<div class="alert alert-error">'._('Your password must be at least 5 characters.').'</div>';
		endif;
	}

	private function process() {

		if(!empty($this->error))
			return false;

		// Ticked the 'delete user' box?
		if(!empty($this->options['delete'])) {
			$sql = "DELETE FROM login_users WHERE user_id='$this->id'";
			parent::query($sql);

			$result = sprintf("<div class='alert alert-success'>"._('User removed from the database:')." <b>%s</b> (%s).</div>",$this->options['name'], $this->options['username']);
			parent::displayErrors($result);
		}

		if(!empty($this->options['password'])) {
			$sql = sprintf("UPDATE login_users SET restricted='%s', name='%s', email='%s', user_level='%s', password = '%s' WHERE user_id = '$this->id'",
							$this->options['restricted'], $this->options['name'], $this->options['email'], serialize($this->options['user_level']), parent::hashPassword($this->options['password']));

			parent::query($sql);
			$result = sprintf("<div class='alert alert-success'>"._('User information (and password) updated for')." <b>%s</b> (%s).</div>",$this->options['name'], $this->options['username']);
		}

		// Password has not been entered don't update password fields.
		else {
			$sql = sprintf("UPDATE login_users SET restricted='%s', name='%s', email='%s', user_level='%s' WHERE user_id = '$this->id'",
							$this->options['restricted'], $this->options['name'], $this->options['email'], serialize($this->options['user_level']));
			parent::query($sql);
			$result = sprintf("<div class='alert alert-success'>"._('User information updated for')." <b>%s</b> (%s).</div>",$this->options['name'], $this->options['username']);
		}

		// Update profile fields
		foreach($this->options as $field => $value) :
			if(strstr($field,"p-")) {
				parent::updateOption($field, $value, true, $this->options['user_id']);
			}
		endforeach;

		return $result;
	}

	// Return a form field
	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];

	}

}