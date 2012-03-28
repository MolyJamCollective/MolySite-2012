<?php

include_once('../classes/class.generic.php');

class Edit_level extends Generic {

	public $error;
	public $results;

	// Search or Edit level
	public $level_id;
	public $search_q;
	public $level_name;
	public $level_auth;
	public $disabled;
	public $disabled2;
	private $level_auth2;

	function __construct() {

		// Save level and auth
		if(isset($_GET['lid'])) {

			$this->level_id = (int) parent::secure($_GET['lid']);
			$sql = "SELECT * FROM login_levels WHERE id = '$this->level_id'";
			$row = mysql_fetch_array(parent::query($sql));

			$this->level_name = $row['level_name'];
			$this->level_auth = $row['level_level'];
			$this->level_auth2 = $row['level_level'];

			if($row['level_disabled'] == '1') {
				$this->disabled = "checked";
				$this->disabled2 = 'value="disable"';
			}
		}

		if(isset($_POST['do_edit'])) {

			$this->level_name = parent::secure($_POST['level']);
			$this->level_auth = parent::secure($_POST['auth']);
			if(isset($_POST['disable']) && isset($_POST['disable2']) && $_POST['disable2'] == 'disable') {
				$this->disabled = "checked";
				$this->disabled2 = 'value="disable"';
			} else {
				$this->disabled = '';
				$this->disabled2 = '';
			}

			// Validate fields
			$this->validate();

			// Process form
			if(empty($this->error))
				$this->process();

		}

	}

	private function validate() {

		// Validate the submitted information
		if($this->level_auth == 1 || $this->level_auth2 == 1 || $this->level_id == 1) {
			$this->error = '<div class="alert alert-error">'._('You can not edit this level.').'</div>';
		} else {

			if(empty($this->level_name)) {
				$this->error = '<div class="alert alert-error">'._('You must enter a level name.').'</div>';
			} else if (empty($this->level_auth)) {
				$this->error = '<div class="alert alert-error">'._('You must enter an auth level.').'</div>';
			}

			$sql = "SELECT * FROM login_levels WHERE level_level = '$this->level_auth'";
			$count = parent::numRows($sql);

			if($count != 0 && $this->level_auth != $this->level_auth2) {
				$this->error = "<div class='alert alert-error'>"._('Auth level')." $this->level_auth "._('already exists').".</div>";
			}
		}
	}

	private function process() {
		if(empty($this->error)) {

		// Ticked the 'disable user level' box? If so, disable the level
		if($this->disabled2) {

			$sql = "UPDATE login_levels SET level_name='$this->level_name', level_level='$this->level_auth', level_disabled='1' WHERE id='$this->level_id'";
			parent::query($sql);
			$this->results = "<div class='alert alert-success'>"._('User level')." <b>$this->level_name</b> "._('has been updated disabled').".</div>";
		} else {

			$sql = "UPDATE login_levels SET level_name='$this->level_name', level_level='$this->level_auth', level_disabled='0' WHERE id = '$this->level_id'";
			parent::query($sql);
		}

		if(!$this->results)
			$this->results = "<div class='alert alert-success'>"._('Information updated for user level')." <b>$this->level_name</b>.</div>";
		}

	}

	public function searchResults() {

		$this->search_q = parent::secure($_POST['level']);
		$sql = "SELECT * FROM login_levels WHERE level_name LIKE '$this->search_q%' ORDER BY level_name LIMIT 0, 10";

		$result = parent::query($sql);
		$count = mysql_num_rows($result);

		if(strlen($this->search_q) <= 2) {

			$this->error = '<div class="alert alert-error">'._('Please be more specific in your search, at least 3 characters.').'</div>';

		} else {

			$this->results  = "<h2>"._('Top 10 Search Results')."</h2>";
			$this->results .= "<p>"._('You have searched for')." <b>$this->search_q</b>, "._('found')." <b>$count</b> "._('results that match this criteria').".</p>";

			$this->results .= "<table class='table'>";
			$this->results .= "<thead><tr><th>"._('User Level')."</th><th>"._('Authority Level')."</th><th>"._('Active Users')."</th><th>"._('Status')."</th></tr></thead><tbody>";

			while($row = mysql_fetch_array($result)) {

				// Clear count variable
				$count = 0;

				// Find the current amount of active users in the group.
				$sql2 = "SELECT user_level FROM login_users";
				$result2 = parent::query($sql2);

				// Count the amount of users in the level
				while($row2 = mysql_fetch_array($result2)) {
					if(in_array($row['level_level'], unserialize($row2['user_level']))) {
						$count++;
					}
				}

				// Show correct status ( Admin | Active | Disabled )
				if($row['level_level'] == 1) { $admin = " <span class='label label-important'>*</span>"; } else $admin = '';
				if($row['level_disabled'] == 0) { $status = "<span class='label label-success'>"._('Active')."</span>"; } else { $status = "<span class='label label-warning'>"._('Disabled')."</span>"; }

				$this->results .= '<tr><td><a href="levels.php?lid='.$row['id'].'">'.$row['level_name'].'</a>'. $admin .'</td><td>'.$row['level_level'].'</td><td>'.$count.'</td><td>'.$status.'</td></tr>';
			}

			$this->results .= "</tbody></table>";

		}

		// Show messages
		if($this->results) echo $this->results;
			else echo $this->error;

	}

}
?>