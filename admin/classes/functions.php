<?php

function in_level() {

	if(!empty($_GET['lid'])) :

		$lid = $_GET['lid'];
		$page = isset($_GET['page'])?(int)$_GET['page']:1;
		$limit = 10;
		$StartIndex = $limit*($page-1);

		$sql = "SELECT * FROM login_users";
		$result = mysql_query($sql);

		$count = 0;
		while($row = mysql_fetch_array($result))
			if( array_intersect(array($lid),unserialize($row['user_level'])) ) $count++;

		if ($count > 0) {

			echo "<table class='table'>";
			echo "<thead><tr><th>"._('Username')."</th><th>"._('Real Name')."</th><th>"._('E-Mail Address')."</th><th>"._('Registered Date')."</th></tr></thead><tbody>";

			$sql = "SELECT * FROM login_users WHERE user_level LIKE '%:\"$lid\";%' ORDER BY timestamp DESC LIMIT $StartIndex,$limit";
			$result = mysql_query($sql);
			$i = 0;
			while ($row = mysql_fetch_array($result)) {

						if(in_array(1, unserialize($row['user_level']))) { $admin = " <span class='label label-important'>"._('admin')."</span>"; } else $admin = '';
						if($row['restricted'] == 1) { $restrict = " <span class='label label-warning'>"._('restricted')."</span>"; } else $restrict = '';

						$timestamp = strtotime($row['timestamp']);
						$reg_date = date('d M y @ H:i' ,$timestamp);

						$email = $row['email'];
						echo '<tr><td><a href="users.php?uid='.$row['user_id'].'">'. $row['username'].'</a>' . $admin . $restrict .'</td><td>'.$row['name'].'</td><td>'.$email.'</td><td>'.$reg_date.'</td></tr>';
				}

			echo "</tbody></table>";
			echo pagination('login_users','ORDER BY timestamp DESC',"$count");
		} else {
			echo "<p>"._('No users found!')."</p>";
		}

	endif;

}

function user_levels() {

	$pagination = pagination('login_levels');

	global $sql;
	global $query;

	// Check that at least one row was returned
	$result = mysql_query($sql);
	$rowCheck = mysql_num_rows($result);
	//echo "<div class='page-header'><h2>Levels</h2></div>";

	if($rowCheck > 0) {

	// Manage levels
	echo "<div class='row'>
		  <table class='table span8'>";
		echo "<thead><tr><th>"._('User Level')."</th><th>"._('Authority Level')."</th><th>"._('Active Users')."</th><th>"._('Status')."</th></tr></thead><tbody>";

		while($row = mysql_fetch_array($result)) {

			// Clear the variables
			$count = 0;
			$level = "";
			$admin = "";

			// Find the current amount of active users in the group.
			$sql2 = "SELECT user_level FROM login_users";
			$result2 = mysql_query($sql2);

			$lid = $row['id'];
			$query = "SELECT COUNT(user_level) as num FROM login_users WHERE user_level LIKE '%:\"$lid\";%' ";
			$count = mysql_fetch_array(mysql_query($query));
			$count = $count['num'];

			// If buts and maybes for the list
			if($row['level_level'] == 1) { $admin = " <span class='label label-important'>*</span>"; }
			if($row['level_disabled'] == 0) { $status = "<span class='label label-success'>"._('Active')."</span>"; } else { $status = "<span class='label label-warning'>"._('Disabled')."</span>"; }

			echo '<tr><td><a href="levels.php?lid='.$row['id'].'">'.$row['level_name'].'</a>'. $admin .'</td><td width="15%">'.$row['level_level'].'</td><td width="15%">'.$count.'</td><td width="15%">'.$status.'</td></tr>';
		}
	echo "</tbody></table></div>";

	echo $pagination;

	}

}

function list_registered() {

	$pagination = pagination('login_users','ORDER BY timestamp DESC');
	global $sql;
	global $query;

	// Check that at least one row was returned
	$result = mysql_query($sql);
	$rowCheck = mysql_num_rows($result);
	if($rowCheck > 0) {

	// Show recently registered users
	// echo "<div class='page-header'><h2>Registered Users</h2></div>";

	echo "<div class='row'><table class='table span8'>";
		echo "<thead><tr><th>"._('Username')."</th><th>"._('Real Name')."</th><th>"._('E-Mail Address')."</th><th>"._('Registered Date')."</th></tr></thead><tbody>";

		while($row = mysql_fetch_array($result)) {

			if(in_array(1, unserialize($row['user_level']))) { $admin = " <span class='label label-important'>"._('admin')."</span>"; } else $admin = '';
			if($row['restricted'] == 1) { $restrict = " <span class='label label-warning'>"._('restricted')."</span>"; } else $restrict = '';

			$timestamp = strtotime($row['timestamp']);
			$reg_date = date('d M y @ H:i' ,$timestamp);

			$email = $row['email'];
			echo '<tr><td><a href="users.php?uid='.$row['user_id'].'">'. $row['username'].'</a>' . $admin . $restrict .'</td><td>'.$row['name'].'</td><td>'.$email.'</td><td>'.$reg_date.'</td></tr>';

		}

	echo "</tbody></table></div>";
	echo $pagination;
	} else { echo _('Sorry, there are no recently registered users.'); }

}

function pagination($table, $args = '',$total_pages = '') {

	global $sql;
	global $query;

	$page = isset($_GET['page'])?(int)$_GET['page']:1;
	$limit = 10;	// set the desired rows per page
	$StartIndex = $limit*($page-1);
	$stages = 3;

	$sql = "SELECT * FROM $table $args LIMIT $StartIndex,$limit";
	$query = "SELECT COUNT(*) as num FROM $table $args";

	$next = $page + 1; $previous = ($page - 1 != 0) ? $page - 1 : $page;

	if (empty($total_pages)) :
		$total_pages = mysql_fetch_array(mysql_query($query));
		$total_pages = $total_pages['num'];
	endif;
	$lastPage = ceil($total_pages/$limit);
	$lastPage1 = $lastPage - 1;

	$paginate = '';
	if($lastPage > 0) :

		$paginate = '<div class="pagination"><ul>';

		// Previous
		$paginate .= ($page > 1) ? '<li class="prev"><a href="?' . http_build_query(array_merge($_GET, array("page" => "$previous"))) . '">&larr; '._('Previous').'</a></li>' : '<li class="prev disabled"><a href="#">&larr; '._('Previous').'</a></li>';

		if($lastPage < 7 + ($stages * 2)) {
			for ($counter = 1; $counter <= $lastPage; $counter++)
				$paginate .= ($counter == $page) ? "<li class='active'><a href='#'>$counter</a></li>" : "<li><a href='?" . http_build_query(array_merge($_GET, array("page" => "$counter"))) . "'>$counter</a></li>";
		}
		elseif($lastPage > 5 + ($stages * 2)) {

			// Hide end pages
			if($page < 1 + ($stages * 2)) {
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
					$paginate .= ($counter == $page) ? "<li class='active'><a href='#'>$counter</a></li>" : "<li><a href='?" . http_build_query(array_merge($_GET, array("page" => "$counter"))) . "'>$counter</a></li>";

				$paginate .= "
							<li><a href='#'>&hellip;</a></li>
							<li><a href='?" . http_build_query(array_merge($_GET, array("page" => "$lastPage1"))) . "'>$lastPage1</a></li>
							<li><a href='?" . http_build_query(array_merge($_GET, array("page" => "$lastPage"))) . "'>$lastPage</a></li>
							";
			}

			// Hide start & end pages
			elseif($lastPage - ($stages * 2) > $page && $page > ($stages * 2)) {

				$paginate .= "
							<li><a href='?" . http_build_query(array_merge($_GET, array("page" => "1"))) . "'>1</a></li>
							<li><a href='?" . http_build_query(array_merge($_GET, array("page" => "2"))) . "'>2</a></li>
							<li><a href='#'>&hellip;</a></li>
							";

				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
					$paginate .= ($counter == $page) ? "<li class='active'><a href='#'>$counter</a></li>" : "<li><a href='?" . http_build_query(array_merge($_GET, array("page" => "$counter"))) . "'>$counter</a></li>";

				$paginate .= "
							<li><a href='#'>&hellip;</a></li>
							<li><a href='?" . http_build_query(array_merge($_GET, array("page" => "$lastPage1"))) . "'>$lastPage1</a></li>
							<li><a href='?" . http_build_query(array_merge($_GET, array("page" => "$lastPage1"))) . "'>$lastPage</a></li>
							";
			}

			// Hide start pages
			else {

				$paginate .= "
							<li><a href='?" . http_build_query(array_merge($_GET, array("page" => "1"))) . "'>1</a></li>
							<li><a href='?" . http_build_query(array_merge($_GET, array("page" => "2"))) . "'>2</a></li>
							<li><a href='#'>&hellip;</a></li>
							";
				for ($counter = $lastPage - (2 + ($stages * 2)); $counter <= $lastPage; $counter++)
					$paginate .= ($counter == $page) ? "<li class='active'><a href='#'>$counter</a></li>" : "<li><a href='?" . http_build_query(array_merge($_GET, array("page" => "$counter"))) . "'>$counter</a></li>";

			}
		}

		// Next
		$paginate .= ($lastPage != $page) ? '<li class="next"><a href="?' . http_build_query(array_merge($_GET, array("page" => "$next"))) . '">'._('Next').' &rarr;</a></li>' : '<li class="next disabled"><a href="#">'._('Next').' &rarr;</a></li>';
		$paginate .= '</ul></div>';

	endif;

	return $paginate;

}