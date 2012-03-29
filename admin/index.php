<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'MolyJam - Admin';
    $pageHeader = 'MolyJam Settings';
    $pageStyles = array();
    $activeTab = '0';

    $pageScripts = array();
    $PageScriptsRaw = '';

    include_once('./templates/header.php');
    
    include_once('../objects/class.database.php');
    include_once('../objects/class.event.php');
    include_once('./classes/class.events.php');
?>

<div class="tabbable tabs-left">
    <ul class="nav nav-tabs span2">
	<li class="dropdown">
	    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Events<b class="caret"></b></a>
	    <ul class="dropdown-menu">
		<li><a href="#event-control" data-toggle="tab">View Events</a></li>
		<li><a href="#event-add" data-toggle="tab"><i class="icon-plus"></i> Add Event</a></li>
	    </ul>
	</li>
	<li><a href="#News" data-toggle="tab">News</a></li>
	<li><a href="#InTheNews" data-toggle="tab">'In The News'</a></li>
	<li><a href="#FAQ" data-toggle="tab">FAQ</a></li>
	<li><a href="#Games" data-toggle="tab">Games</a></li>
    </ul>
    <div class="tab-content span8">
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
		    <div class="controls"> <!-- TODO: http://www.ama3.com/anytime/ -->
			<input type="text" class="input-xlarge" id="start" name="start" value="<?php //echo $addUser->getPost("username"); ?>">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="stop">Stop</label>
		    <div class="controls">
			<input type="text" class="input-xlarge" id="stop" name="stop" value="<?php  //echo $addUser->getPost("email"); ?>">
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
<!-- - - - - - - - - - - - - - - - - News - - - - - - - - - - - - - - - - - - - - - -->
<!-- - - - - - - - - - - - - - - - - In The News  - - - - - - - - - - - - - - - - - -->
<!-- - - - - - - - - - - - - - - - - FAQ  - - - - - - - - - - - - - - - - - - - - - -->
<!-- - - - - - - - - - - - - - - - - Games  - - - - - - - - - - - - - - - - - - - - -->
    
    </div>
</div>


<?php
    include_once('./templates/footer.php');
?>