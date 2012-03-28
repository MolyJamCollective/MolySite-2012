<?php

include_once('../classes/class.generic.php');

class Settings extends Generic {

	private $error;
	private $options = array();

	function __construct() {

		// Once the form has been processed
		if(!empty($_POST)) {

			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

			// Validate fields
			$this->validate();

			// Process form
			echo empty($this->error) ? $this->process() : $this->error;

			exit();

		}

	}

	// Validate the submitted information
	private function validate() {

		if(!is_numeric($this->options['default_session']))
			$this->error = _('You must enter a default session (numeric value only).');

		if(!parent::isEmail($this->options['admin_email']))
			$this->error = _('You have entered an invalid e-mail address, try again.');

		if(empty($this->options['site_address']))
			$this->error = _('Please enter your site address.');

		if(!empty($this->error)) $this->error = '<div class="alert alert-error fade in"><a class="close" data-dismiss="alert" href="#">&times;</a>' . $this->error . '</div>';

		/** @todo: Find a better method for checkbox validation */
		$this->options['block-msg-enable'] = !empty($this->options['block-msg-enable']) ? 1 : 0;
		$this->options['block-msg-out-enable'] = !empty($this->options['block-msg-out-enable']) ? 1 : 0;
		$this->options['profile-public-enable'] = !empty($this->options['profile-public-enable']) ? 1 : 0;
		$this->options['profile-display-email-enable'] = !empty($this->options['profile-display-email-enable']) ? 1 : 0;
		$this->options['profile-display-name-enable'] = !empty($this->options['profile-display-name-enable']) ? 1 : 0;
		$this->options['pw-encrypt-force-enable'] = !empty($this->options['pw-encrypt-force-enable']) ? 1 : 0;
		$this->options['profile-timestamps-admin-enable'] = !empty($this->options['profile-timestamps-admin-enable']) ? 1 : 0;
		$this->options['profile-timestamps-enable'] = !empty($this->options['profile-timestamps-enable']) ? 1 : 0;
		$this->options['update-check-enable'] = !empty($this->options['update-check-enable']) ? 1 : 0;

		if(empty($this->options['profile-field_type']) && empty($this->options['profile-field_name'])) :
			$this->options['profile-fields'] = '';
		else :
			$profile_fields = array_combine ($this->options['profile-field_type'], $this->options['profile-field_name']);
			$this->options['profile-fields'] = serialize(array_filter($profile_fields));
		endif;

	}

	// Insert setting values into the database
	private function process() {

		if(!empty($this->error))
			return false;

		foreach ( $this->options as $option => $newvalue )
		if ( ! is_array($option) )
			parent::updateOption( $option, $newvalue );

		return "<div class='alert alert-success fade in'><a class='close' data-dismiss='alert' href='#'>&times;</a>"._('Settings updated.')."</div>";

	}

	public function profile_fields(){

		$field_types = array(
			'text_input' => 'Text Input',
			'textarea' => 'Textarea',
			'checkbox' => 'Checkbox'
		);

		$profile_fields = parent::getOption('profile-fields');
		if(!empty($profile_fields)) :
			$i = 0;
			$profile_fields = unserialize($profile_fields);
			if(!is_array($profile_fields)) return false;
			$return = '<tbody>';
			foreach ($profile_fields as $type => $name) :
				$return .= '<tr class="profile-field-row"><td><a href="#profileModal" class="btn btn-danger remove-button" data-toggle="modal"><i class="icon-trash icon-white"></i></a></td>';

				$return .= '<td><select name="profile-field_type[' . $i . ']">';
				foreach ($field_types as $field_type => $field_label) :
					$selected = (strstr($type, $field_type)) ? 'selected="selected"' : '';
					$return .= '<option value="' . $field_type . '['. $i . ']' . '" ' . $selected . '>' . $field_label . '</option>';
				endforeach;
				$return .= '</select></td>';

				$return .= '<td><input type="text" value="'.$name.'" name="profile-field_name[' . $i . ']" placeholder="'._('Field name').'" class="input-xlarge"></td></tr>';
				$i++;
			endforeach;
			$return .= '<tr><td colspan="3"><button class="add-field btn"><i class="icon-plus-sign"></i> ' . _('Add field') . '</button></td></tr>';
			$return .= '</tbody>';
		else :
			$return = '';
		endif;

		return $return;

	}

	// Checks for updates
	// Used in admin settings page
	private function grabUpdate() {

		if( !ini_get('allow_url_fopen') || !parent::getOption('update-check-enable') )
			return false;

		if ( !$t = file_get_contents('http://pastebin.com/raw.php?i=fJc8SDns') )
			return false;

		$t = explode(';',$t);

		return $t;

	}

	public function newUpdate() {

		$t = $this->grabUpdate();
		return ($t[0] > phplogin_version);

	}

	public function newVersion() {

		$version = $this->grabUpdate();
		return $version[0];

	}

	public function newChangelog() {

		$changelog = $this->grabUpdate();
		return $changelog[1];

	}


}