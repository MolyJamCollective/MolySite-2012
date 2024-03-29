<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'MolyJam - Admin';
    $pageHeader = 'MolyJam Settings';
    $pageStyles = array('../css/anytime.css');
    $activeTab = '0';

    $pageScripts = array('./js/anytime.js');
    $PageScriptsRaw = '
<script>
  AnyTime.picker( "start", { format: "%Y-%m-%d %T", firstDOW: 1 } );
  AnyTime.picker( "stop", { format: "%Y-%m-%d %T", firstDOW: 1 } );
</script>
    ';

    include_once('./templates/header.php');
    
    include_once('../objects/class.database.php');
    include_once('../objects/class.event.php');
    include_once('../objects/class.location.php');
    include_once('../objects/class.organizer.php');
    
    include_once('./classes/class.events.php');
    include_once('./classes/class.locations.php');
    include_once('./classes/class.organizers.php');
    
    if(isset($_POST['add_event'])){add_event();header('Location: index.php');}
    if(isset($_POST['add_location'])){add_location();header('Location: index.php');}
    if(isset($_POST['add_organizer'])){add_organizer();header('Location: index.php');}
    
    if(isset($_POST['edit_event'])){edit_event();header('Location: index.php');}
    if(isset($_POST['edit_location'])){edit_location();header('Location: index.php');}
    if(isset($_POST['edit_organizer'])){edit_organizer();header('Location: index.php');}
    
    if(isset($_GET['EventDeleteID'])){remove_event();header('Location: index.php');}
    if(isset($_GET['LocationDeleteID'])){remove_location();header('Location: index.php');}
    if(isset($_GET['OrganizerDeleteID'])){remove_organizer();header('Location: index.php');}
    
?>

<div class="row-fluid">
    <div class="tabbable tabs-left span2">
	<ul class="nav nav-tabs">
	    <li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Events<b class="caret"></b></a>
		<ul class="dropdown-menu">
		    <li><a href="#event-control" data-toggle="tab">View Events</a></li>
		    <li><a href="#event-add" data-toggle="tab"><i class="icon-plus"></i> Add Event</a></li>
		</ul>
	    </li>
	    <li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Locations<b class="caret"></b></a>
		<ul class="dropdown-menu">
		    <li><a href="#location-control" data-toggle="tab">View Locations</a></li>
		    <li><a href="#location-add" data-toggle="tab"><i class="icon-plus"></i> Add Location</a></li>
		</ul>
	    </li>
	    <li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Organizers<b class="caret"></b></a>
		<ul class="dropdown-menu">
		    <li><a href="#organizer-control" data-toggle="tab">View Organizers</a></li>
		    <li><a href="#organizer-add" data-toggle="tab"><i class="icon-plus"></i> Add Organizer</a></li>
		</ul>
	    </li>
	    <!-- li><a href="#News" data-toggle="tab">News</a></li -->
	    <!-- li><a href="#InTheNews" data-toggle="tab">'In The News'</a></li -->
	    <!-- li><a href="#FAQ" data-toggle="tab">FAQ</a></li -->
	    <!-- li><a href="#Games" data-toggle="tab">Games</a></li -->
	</ul>
    </div>
    <div class="tab-content span8">
    <!-- - - - - - - - - - - - - - - - - Edit Event  - - - - - - - - - - - - - - - - - - -->
	<?php if(isset($_GET['EventEditID']))
	{
	    $Event = new Event();
	    $Event->Get($_GET['EventEditID']);
	?>
	<div class="" id="event-edit">
	    <fieldset>
		<form method="post" class="form form-horizontal" action="index.php" id="event-edit-form">
		    <legend>Edit Event</legend>
		    <div id="message"></div>
		    <fieldset>
		    <div class="control-group">
			<label class="control-label" for="title">Title</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="title" name="title" value="<?php echo $Event->Title; ?>">
			</div>
		    </div>
		    <div class="control-group" id="usrCheck">
			<label class="control-label" for="start">Start</label>
			<div class="controls"> <!-- http://www.ama3.com/anytime/ -->
			    <input type="text" id="start" name="start" size="50" value="<?php echo $Event->Start; ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="stop">Stop</label>
			<div class="controls">
			    <input type="text" id="stop" name="stop" size="50" value="<?php  echo $Event->Stop; ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="description">Description</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="description" name="description" value="<?php  echo $Event->Description; ?>">
			</div>
		    </div>
		</fieldset>
		<div class="form-actions">
		    <input type="hidden" name="edit_event">
		    <input type="hidden" name="edit_eventid" value="<?php echo $_GET['EventEditID']; ?>">
		    <button type="submit" name="edit_event" class="btn btn-primary" id="event-edit-submit">Edit Event</button>
		</div>
	    </form>
	</fieldset>
    </div>
    
    <!-- - - - - - - - - - - - - - - - - Edit Location  - - - - - - - - - - - - - - - - - - -->
	<?php } elseif(isset($_GET['LocationEditID']))
	{
	    $Location = new Location();
	    $Location->Get($_GET['LocationEditID']);
	?>
    <div class="" id="location-edit">
	<fieldset>
	    <form method="post" class="form form-horizontal" action="index.php" id="location-edit-form">
		<legend>Edit Location</legend>
		<div id="message"></div>
		<fieldset>
		    <div class="control-group">
			<label class="control-label" for="title">Title</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="title" name="title" value="<?php echo $Location->Title; ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="address">Address</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="address" name="address" value="<?php echo $Location->Address; ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="city">City</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="city" name="city" value="<?php echo $Location->City; ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="region">Region/State</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="region" name="region" value="<?php echo $Location->Region; ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="country">Country</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="country" name="country" value="<?php echo $Location->Country; ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="eventurl">Link</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="eventurl" name="eventurl" value="<?php echo $Location->EventURL; ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="eventemail">Email</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="eventemail" name="eventemail" value="<?php echo $Location->EventEmail; ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="eventid">Event</label>
			<div class="controls">
			    <select id="eventid" class="" name="eventid">
				<option value="">Select an Event</option>
    <?php
		    $Event = new Event();
		    $EventList = $Event->GetList(array(array("eventid", ">", 0)));
		    
		    foreach($EventList as $Event)
		    {
			$selected = '';
			if($Location->EventID == $Event->eventId)
			    $selected = 'selected=""';
			echo "			    <option value=\"".$Event->eventId."\" ".$selected." >".$Event->Title."</option>\n";
		    }
    ?>
			    </select>
			</div>
		    </div>
		</fieldset>
		<div class="form-actions">
		    <input type="hidden" name="edit_location">
		    <input type="hidden" name="edit_locationid" value="<?php echo $_GET['LocationEditID']; ?>">
		    <button type="submit" name="edit_location" class="btn btn-primary" id="location-edit-submit">Edit Location</button>
		</div>
	    </form>
	</fieldset>
    </div>
     <!-- - - - - - - - - - - - - - - - - Edit Organizer  - - - - - - - - - - - - - - - - - - -->
	<?php } elseif(isset($_GET['OrganizerEditID']))
	{
	    $Organizer = new Organizer();
	    $Organizer->Get($_GET['OrganizerEditID']);
	?>
    <div class="" id="organizer-edit">
	<fieldset>
	    <form method="post" class="form form-horizontal" action="index.php" id="organizer-edit-form">
		<legend>Edit Organizer</legend>
		<div id="message"></div>
		<fieldset>
		    <div class="control-group">
			<label class="control-label" for="name">Name</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="name" name="name" value="<?php echo $Organizer->Name; ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="twitter">Twitter</label>
			<div class="controls">
			    <div class="input-prepend">
				<span class="add-on">@</span><input type="text" class="input-xlarge" id="twitter" name="twitter" value="<?php echo $Organizer->Twitter; ?>">
			    </div>
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="locationid">Location</label>
			<div class="controls">
			    <select id="locationid" class="" name="locationid">
				<option value="">Select a Location</option>
    <?php
		    $Location = new Location();
		    $LocationList = $Location->GetList(array(array("locationid", ">", 0)));
    
		    foreach($LocationList as $Location)
		    {
			$selected = '';
			if($Organizer->LocationID == $Location->locationId)
			    $selected = 'selected=""';
			echo "			    <option value=\"".$Location->locationId."\" ".$selected." >".$Location->Title."</option>\n";
		    }
    ?>
			    </select>
			</div>
		    </div>
		</fieldset>
		<div class="form-actions">
		    <input type="hidden" name="edit_organizer">
		    <input type="hidden" name="edit_organizerid" value="<?php echo $_GET['OrganizerEditID']; ?>">
		    <button type="submit" name="edit_organizer" class="btn btn-primary" id="organizer-edit-submit">Edit Organizer</button>
		</div>
	    </form>
	</fieldset>
    </div>
	    
	<?php } else { ?>
    <!-- - - - - - - - - - - - - - - - - Control Events - - - - - - - - - - - - - - - - -->
	<div class="tab-pane fade in active" id="event-control">
	    <fieldset>
		<legend>Events</legend>
		<?php list_events(); ?>
	    </fieldset>
	</div>
    <!-- - - - - - - - - - - - - - - - - Add Event  - - - - - - - - - - - - - - - - - - -->
	<div class="tab-pane fade" id="event-add">
	    <fieldset>
		<form method="post" class="form form-horizontal" action="index.php" id="event-add-form">
		    <legend>Add Event</legend>
		    <div id="message"></div>
		    <fieldset>
		    <div class="control-group">
			<label class="control-label" for="title">Title</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="title" name="title" value="<?php //echo $addUser->getPost("name"); ?>">
			</div>
		    </div>
		    <div class="control-group" id="usrCheck">
			<label class="control-label" for="start">Start</label>
			<div class="controls"> <!-- http://www.ama3.com/anytime/ -->
			    <input type="text" id="start" name="start" size="50" value="<?php //echo $addUser->getPost("username"); ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="stop">Stop</label>
			<div class="controls">
			    <input type="text" id="stop" name="stop" size="50" value="<?php  //echo $addUser->getPost("email"); ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="description">Description</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="description" name="description" value="<?php  //echo $addUser->getPost("email"); ?>">
			</div>
		    </div>
		</fieldset>
		<div class="form-actions">
		    <input type="hidden" name="add_event">
		    <button type="submit" name="add_event" class="btn btn-primary" id="event-add-submit">Add Event</button>
		</div>
	    </form>
	</fieldset>
    </div>
    <!-- - - - - - - - - - - - - - - - - Control Locations - - - - - - - - - - - - - - - - -->
	<div class="tab-pane fade in active" id="location-control">
	    <fieldset>
		<legend>Locations</legend>
		<?php list_locations(); ?>
	    </fieldset>
	</div>
    <!-- - - - - - - - - - - - - - - - - Add Location  - - - - - - - - - - - - - - - - - - -->
    <div class="tab-pane fade" id="location-add">
	<fieldset>
	    <form method="post" class="form form-horizontal" action="index.php" id="location-add-form">
		<legend>Add Location</legend>
		<div id="message"></div>
		<fieldset>
		    <div class="control-group">
			<label class="control-label" for="title">Title</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="title" name="title" value="<?php //echo $addUser->getPost("name"); ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="address">Address</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="address" name="address" value="<?php //echo $addUser->getPost("name"); ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="city">City</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="city" name="city" value="<?php //echo $addUser->getPost("name"); ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="region">Region/State</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="region" name="region" value="<?php //echo $addUser->getPost("name"); ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="country">Country</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="country" name="country" value="<?php //echo $addUser->getPost("name"); ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="eventurl">Link</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="eventurl" name="eventurl" value="<?php //echo $addUser->getPost("name"); ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="eventemail">Email</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="eventemail" name="eventemail" value="<?php //echo $addUser->getPost("name"); ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="eventid">Event</label>
			<div class="controls">
			    <select id="eventid" class="" name="eventid">
				<option value="">Select an Event</option>
    <?php
		    $Event = new Event();
		    $EventList = $Event->GetList(array(array("eventid", ">", 0)));
    
		    foreach($EventList as $Event)
		    {
			echo "			    <option value=\"".$Event->eventId."\" >".$Event->Title."</option>\n";
		    }
    ?>
			    </select>
			</div>
		    </div>
		</fieldset>
		<div class="form-actions">
		    <input type="hidden" name="add_location">
		    <button type="submit" name="add_location" class="btn btn-primary" id="location-add-submit">Add Location</button>
		</div>
	    </form>
	</fieldset>
    </div>
    <!-- - - - - - - - - - - - - - - - - Control Organizer - - - - - - - - - - - - - - - - -->
	<div class="tab-pane fade in active" id="organizer-control">
	    <fieldset>
		<legend>Organizers</legend>
		<?php list_organizer(); ?>
	    </fieldset>
	</div>
    <!-- - - - - - - - - - - - - - - - - Add Organizer  - - - - - - - - - - - - - - - - - - -->
    <div class="tab-pane fade" id="organizer-add">
	<fieldset>
	    <form method="post" class="form form-horizontal" action="index.php" id="organizer-add-form">
		<legend>Add Organizer</legend>
		<div id="message"></div>
		<fieldset>
		    <div class="control-group">
			<label class="control-label" for="name">Name</label>
			<div class="controls">
			    <input type="text" class="input-xlarge" id="name" name="name" value="<?php //echo $addUser->getPost("name"); ?>">
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="twitter">Twitter</label>
			<div class="controls">
			    <div class="input-prepend">
				<span class="add-on">@</span><input type="text" class="input-xlarge" id="twitter" name="twitter" value="">
			    </div>
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="locationid">Location</label>
			<div class="controls">
			    <select id="locationid" class="" name="locationid">
				<option value="">Select an Location</option>
    <?php
		    $Location = new Location();
		    $LocationList = $Location->GetList(array(array("locationid", ">", 0)));
    
		    foreach($LocationList as $Location)
		    {
			echo "			    <option value=\"".$Location->locationId."\" >".$Location->Title."</option>\n";
		    }
    ?>
			    </select>
			</div>
		    </div>
		</fieldset>
		<div class="form-actions">
		    <input type="hidden" name="add_organizer">
		    <button type="submit" name="add_organizer" class="btn btn-primary" id="organizer-add-submit">Add Organizer</button>
		</div>
	    </form>
	</fieldset>
    </div>
    <!-- - - - - - - - - - - - - - - - - News - - - - - - - - - - - - - - - - - - - - - -->
    <!-- - - - - - - - - - - - - - - - - In The News  - - - - - - - - - - - - - - - - - -->
    <!-- - - - - - - - - - - - - - - - - FAQ  - - - - - - - - - - - - - - - - - - - - - -->
    <!-- - - - - - - - - - - - - - - - - Games  - - - - - - - - - - - - - - - - - - - - -->
	<?php } ?>
	</div>
    </div>
</div>
<?php
    include_once('./templates/footer.php');
?>