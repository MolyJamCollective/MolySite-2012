<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'Page Title';
    $pageHeader = 'Page Header';
    $pageStyles = array();

    $pageScripts = array();
    $PageScriptsRaw = '';

    include_once('./templates/header.php');
	
	include_once('classes/class.edit_user.php');
	$edituser = new Edit_user;
?>

<h2><?php _e('User Control:'); ?> <?php echo $edituser->getField('username'); ?></h2><br>

<div class="tabs-left">

	<ul class="nav nav-tabs">
		<li class="active"><a href="#usr-control" data-toggle="tab"><i class="icon-cog"></i> <?php _e('General'); ?></a></li>
		<li><a href="#usr-profile" data-toggle="tab"><i class="icon-user"></i> <?php _e('Profile'); ?></a></li>
	</ul>

	<form method="post" class="form-horizontal">
		<div class="tab-content">
			<div class="tab-pane fade in active" id="usr-control">
					<fieldset>
						<legend><?php _e('General'); ?></legend>
						<div class="control-group">
							<label class="control-label" for="name"><?php _e('Name'); ?></label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="name" name="name" value="<?php echo $edituser->getField('name'); ?>">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="password"><?php _e('Password'); ?></label>
							<div class="controls">
								<input type="password" class="input-xlarge" id="password" name="password">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="password2"><?php _e('Password again'); ?></label>
							<div class="controls">
								<input type="password" class="input-xlarge" id="password2" name="password2">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="email"><?php _e('Email'); ?></label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="email" name="email" value="<?php echo $edituser->getField('email'); ?>">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="user_level"><?php _e('User levels'); ?></label>
							<div class="controls">
								<?php $edituser->getLevels(); ?>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<label class="checkbox">
									<input type="checkbox" class="input-xlarge" id="restricted" name="restricted" <?php if($edituser->getField('restricted') > 0) echo 'checked="checked"'; ?>>
									<?php _e('Restrict user?'); ?>
								</label>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<label class="checkbox">
									<input type="checkbox" class="input-xlarge" id="delete" name="delete">
									<?php _e('Delete user? (Can not be undone)'); ?>
								</label>
							</div>
						</div>
					</fieldset>
			</div>
			<div class="tab-pane fade" id="usr-profile">
				<fieldset>
					<legend><?php _e('User Profile'); ?></legend>
						<?php $edituser->generateProfile(); ?>
				</fieldset>
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary" /><?php _e('Update user'); ?></button>
		</div>
	</form>
</div>
<?php
    include_once('./templates/footer.php');
?>