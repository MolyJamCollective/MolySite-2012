<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'MolyJam - Admin';
    $pageHeader = 'User Settings';
    $pageStyles = array();
    $activeTab = '0';

    $pageScripts = array();
    $PageScriptsRaw = '';

    include_once('./templates/header.php');
?>
<?php if(!isset($_POST['add_user']) && !isset($_POST['add_level'])) : ?>
<?php 	include_once('templates/header.php'); ?>
<?php endif; ?>

<?php include_once('classes/class.add_level.php'); ?>
<?php include_once('classes/class.add_user.php'); ?>

<div class="tabbable tabs-left">
    <ul class="nav nav-tabs span2">
	<li class="dropdown">
	    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?php _e('Users'); ?> <b class="caret"></b></a>
	    <ul class="dropdown-menu">
		<li><a href="#user-control" data-toggle="tab"><?php _e('View users'); ?></a></li>
		<li><a href="#user-add" data-toggle="tab"><i class="icon-plus"></i> <?php _e('Add user'); ?></a></li>
	    </ul>
	</li>
	<li class="dropdown">
	    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-list"></i> <?php _e('Levels'); ?> <b class="caret"></b></a>
	    <ul class="dropdown-menu">
		<li><a href="#level-control" data-toggle="tab"><?php _e('View levels'); ?></a></li>
		<li><a href="#level-create" data-toggle="tab"><i class="icon-plus"></i> <?php _e('Create level'); ?></a></li>
	    </ul>
	</li>
	<li><a href="settings.php"><i class="icon-cog"></i> <?php _e('Settings'); ?></a></li>
    </ul>
<div class="tab-content span8">
				<!-- - - - - - - - - - - - - - - - -

						Control users

				- - - - - - - - - - - - - - - - - -->
    <div class="tab-pane fade in active" id="user-control">
	<fieldset>
	    <legend><?php _e('Control users'); ?>
		<form method="post" class="pull-right">
		    <div class="control-group">
			<div class="controls">
			    <div class="input-prepend">
				<span class="add-on"><label for="username-search"><i class="icon-search"></i></span></label><input class="span2" style="margin:0" id="username-search" type="text" name="username" onkeyup="searchSuggest();" placeholder="<?php _e('User search'); ?>">
			    </div>
			</div>
		    </div>
		</form>
	    </legend>
	    <div id="search_suggest"></div>
	    <?php list_registered(); ?>
	</fieldset>
    </div>
				<!-- - - - - - - - - - - - - - - - -

						Add user

				- - - - - - - - - - - - - - - - - -->
    <div class="tab-pane fade" id="user-add">
	<fieldset>
	    <form method="post" class="form form-horizontal" action="index.php" id="user-add-form">
		<legend><?php _e('Add user'); ?></legend>
		    <div id="message"></div>
			<fieldset>
			    <div class="control-group">
				<label class="control-label" for="name"><?php _e('Name'); ?></label>
				<div class="controls">
				    <input type="text" class="input-xlarge" id="name" name="name" value="<?php echo $addUser->getPost("name"); ?>">
				</div>
			    </div>
			    <div class="control-group" id="usrCheck">
				<label class="control-label" for="username"><?php _e('Username'); ?></label>
				    <div class="controls">
					<input type="text" class="input-xlarge" id="username" name="username" value="<?php echo $addUser->getPost("username"); ?>">
				    </div>
				</div>
			    <div class="control-group">
				<label class="control-label" for="email"><?php _e('Email'); ?></label>
				<div class="controls">
				    <input type="text" class="input-xlarge" id="email" name="email" value="<?php  echo $addUser->getPost("email"); ?>">
				</div>
			    </div>
			    <p><span class="label label-info"><?php _e('Note'); ?></span> <?php _e('A random password will be generated and emailed to the user'); ?></p>
			</fieldset>
			<div class="form-actions">
			    <input type="hidden" name="add_user">
			    <button type="submit" name="add_user" class="btn btn-primary" id="user-add-submit"><?php _e('Add user'); ?></button>
			</div>
		    </form>
		</fieldset>
	    </div>
				<!-- - - - - - - - - - - - - - - - -

						Modify levels

				- - - - - - - - - - - - - - - - - -->

				<div class="tab-pane fade" id="level-control">
					<fieldset>
						<legend><?php _e('Modify levels'); ?>
							<form method="post" class="pull-right" action="levels.php">
								<div class="control-group">
								  <div class="controls">
									<div class="input-prepend">
									  <span class="add-on"><label for="level"><i class="icon-search"></i></span></label><input style="margin:0;" class="span2" type="text" placeholder="<?php _e('Level search'); ?>" name="level" id="level">
									  <input type="hidden" class="btn btn-primary" value="Search" name="edit_level"/>
									</div>
								  </div>
								</div>
							</form>
						</legend>
						<?php user_levels(); ?>
					</fieldset>
				</div>

				<!-- - - - - - - - - - - - - - - - -

						Create level

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="level-create">
					<fieldset>
						<form method="post" class="form form-horizontal" id="level-add-form" action="index.php">
							<legend><?php _e('Create level'); ?></legend>
							<div id="level-message"></div>
							<fieldset>
								<div class="control-group">
									<label class="control-label" for="level"><?php _e('Level name'); ?></label>
									<div class="controls">
										<input type="text" class="input-xlarge" id="level" name="level" value="<?php echo $addLevel->getPost('level'); ?>">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="auth"><?php _e('Auth level'); ?></label>
									<div class="controls">
										<input type="text" class="input-xlarge" id="auth" name="auth" value="<?php echo $addLevel->getPost('auth'); ?>">
									</div>
								</div>
							<div class="form-actions">
								<input type="hidden" name="add_level">
								<button type="submit" class="btn btn-primary" id="level-add-submit"><?php _e('Create level'); ?></button>
							</div>
							</fieldset>
						</form>
					</fieldset>
				</div>

			</div>

		</div>
<?php
    include_once('./templates/footer.php');
?>