<?php

include_once(dirname(dirname(dirname(__FILE__))) . '/classes/class.generic.php');

class Add_level extends Generic {

	private $error;

	private $auth;
	private $level;

	function __construct() {

		// jQuery form validation
		parent::checkExists();

		if(isset($_POST['add_level'])) {
			$this->auth = parent::secure($_POST['auth']);
			$this->level = parent::secure($_POST['level']);

			// Confirm all details are correct
			$this->verify();

			// Create the level
			$this->addlevel();

		}

	}

	// Return a value if it exists
	public function getPost($var) {

		if(!empty($this->$var)) {
			return $this->$var;
		} else return false;

	}

	private function verify() {

		if(empty($this->level)) {
			$this->error = '<div class="alert alert-error">'._('You must enter a level name.').'</div>';
		} else if(!is_numeric($this->auth)) {
			$this->error = '<div class="alert alert-error">'._('Auth level has to be a number.').'</div>';
		}

	}

	private function addlevel() {

		if(isset($_POST['add_level']) && empty($this->error)) {

			$sql = "SELECT * FROM login_levels WHERE level_level = '$this->auth'";
			$count = parent::numRows($sql);

			if($count != 0) {
				$this->error = '<div class="alert alert-error">'._('Auth level').' <b>'.$this->auth.'</b> '._('already exists').'</b>.</div>';
			}

			if(empty($this->error)) {

				$sql = "INSERT INTO login_levels (level_name, level_level, level_disabled)
						VALUES ('$this->level', '$this->auth', '0')";

				parent::query($sql);

				$this->error = 	"<div class='alert alert-success'>"._('Successfully added level')." <b>$this->level</b> "._('to the database.')."</div>";

				$this->level = '';
				$this->auth = '';

			}

		}

		echo $this->error;
		exit();

	}

}

$addLevel = new Add_level();