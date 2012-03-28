<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'MolyJam - My Account';
    $pageHeader = 'Account Settings';
    $pageStyles = array();
    $activeTab = '0';

    $pageScripts = array();
    $PageScriptsRaw = '';

    include_once('./templates/header.php');
    include_once('classes/class.myaccount.php');
    $myAccount = new myAccount;
 ?>

<div class="row">
<div class="tabs-left">

	<ul class="nav nav-tabs span2">
		<li class="active"><a href="#usr-control" data-toggle="tab"><i class="icon-cog"></i> <?php _e('General'); ?></a></li>
		<li><a href="#usr-profile" data-toggle="tab"><i class="icon-user"></i> <?php _e('Profile'); ?></a></li>
	</ul>

	<form class="form-horizontal" method="post" action="my-account.php">
		<div class="tab-content span8">
			<div class="tab-pane fade in active" id="usr-control">
				<fieldset>
					<legend><?php _e('General'); ?></legend>
					<div class="control-group">
						<label class="control-label" for="CurrentPass"><?php _e('Current password'); ?></label>
						<div class="controls">
							<input type="password" class="input-xlarge" id="CurrentPass" name="CurrentPass">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="name"><?php _e('Name'); ?></label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="name" name="name" value="<?php echo $myAccount->getField('name'); ?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="email"><?php _e('Email'); ?></label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="email" name="email" value="<?php echo $myAccount->getField('email'); ?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="password"><?php _e('New password'); ?></label>
						<div class="controls">
							<input type="password" class="input-xlarge" id="password" name="password" placeholder="<?php _e('Leave blank for no change'); ?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="confirm"><?php _e('New password again'); ?></label>
						<div class="controls">
							<input type="password" class="input-xlarge" id="confirm" name="confirm">
						</div>
					</div>
				</fieldset>
			</div>

			<div class="tab-pane fade" id="usr-profile">
				<fieldset>
					<legend><?php _e('User Profile'); ?></legend>
					<?php $myAccount->generateProfile(); ?>
				</fieldset>
			</div>

			<div class="form-actions">
				<button type="submit" class="btn btn-primary"><?php _e('Save changes'); ?></button>
			</div>
		</div>
	</form>
</div>
</div>
<?php
    include_once('./templates/footer.php');
?>