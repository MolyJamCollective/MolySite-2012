<?php include_once('../../classes/class.generic.php');

// Make sure that a value was sent.
if (!empty($_GET['search'])) {

	// Add slashes / escape string to avoid SQL problems / injections.
	$search = mysql_real_escape_string(trim(addslashes($_GET['search'])));

	$sql = "SELECT distinct username as suggest, user_id, name FROM login_users WHERE username LIKE '" . $search . "%' or name LIKE '" . $search . "%' ORDER BY username LIMIT 0, 5";

	$suggest_query = mysql_query($sql);

	$count = mysql_num_rows($suggest_query);

	if($count == 0){

		echo "<h2>"._('No suggestions')."</h2>\n";

	} else { // Display suggestions found.

		echo "<h2>"._('Suggestions')."</h2>\n";

		while($suggest = mysql_fetch_array($suggest_query)) {
			//Return each page title seperated by a newline.
			echo "<p><a href='users.php?uid=" . $suggest['user_id'] . "'>" . $suggest['suggest'] . "</a></p>\n";
		}

	}
}

?>