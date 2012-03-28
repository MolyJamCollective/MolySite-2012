<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'MolyJam - Admin';
    $pageHeader = 'Administrator Settings';
    $pageStyles = array();

    $pageScripts = array();
    $PageScriptsRaw = '';

    include_once('./templates/header.php');
	
	include_once('classes/class.settings.php');
	$settings = new Settings();
	$newUpdate = $settings->newUpdate();
?>

	<div class="tab-pane active" id="message"></div>

	  <div class="tabbable tabs-left">

		<ul class="nav nav-tabs span2">
			<li><a href="#general-options" data-toggle="tab"><i class="icon-cog"></i> <?php _e('General'); ?></a></li>
			<li><a href="#denied-messages" data-toggle="tab"><i class="icon-exclamation-sign"></i> <?php _e('Denied messages'); ?></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-envelope"></i> <?php _e('Emails'); ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#emails-welcome" data-toggle="tab"><?php _e('Welcome'); ?></a></li>
                <li><a href="#emails-activate" data-toggle="tab"><?php _e('Activate'); ?></a></li>
                <li><a href="#emails-forgot" data-toggle="tab"><?php _e('Forgot'); ?></a></li>
                <li><a href="#emails-add-user" data-toggle="tab"><?php _e('Add user'); ?></a></li>
              </ul>
            </li>
			<li><a href="#user-profiles" data-toggle="tab"><i class="icon-user"></i> <?php _e('Profiles'); ?></a></li>
			<li><a href="#update" data-toggle="tab"><i class="icon-flag"></i> <?php _e('Update'); ?> <?php if($newUpdate) : ?><span class="label label-info"><?php _e('new'); ?></span><?php endif; ?></a></li>
		</ul>

		<form class="form-horizontal" method="post" action="settings.php" id="settings-form">

			<div class="tab-content span8">

				<!-- - - - - - - - - - - - - - - - -

						General

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade active in" id="general-options">
					<fieldset>
						<legend><?php _e('General'); ?></legend>
						<div class="control-group">
							<label class="control-label" for="admin_email"><?php _e('Admin email'); ?></label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="admin_email" name="admin_email" value="<?php echo $settings->getOption('admin_email'); ?>">
								<p class="help-block"><?php _e('This email will be used to send all emails'); ?></p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="site_address"><?php _e('Site address'); ?></label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="site_address" name="site_address" value="<?php echo $settings->getOption('site_address'); ?>">
								<p class="help-block"><?php _e('This path should be set to where activate.php is located (must end with a trailing slash)'); ?></p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="default_session"><?php _e('Default session'); ?></label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="default_session" name="default_session" value="<?php echo $settings->getOption('default_session'); ?>" placeholder="0">
								<p class="help-block"><?php _e('Default time in minutes a user can be logged in'); ?></p>
								<p class="help-block"><?php _e('Enter 0 to log the user out when they close their browser'); ?></p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="pw-encrypt-force-enable"><?php _e('Password encryption'); ?></label>
							<div class="controls">
							<label class="checkbox">
								<input type="checkbox" class="input-xlarge" id="pw-encrypt-force-enable" name="pw-encrypt-force-enable" <?php echo $settings->getOption('pw-encrypt-force-enable', true); ?>>
								<?php _e('Force user to update password if not using selected encryption method'); ?>
							</label>
							<?php $pw_encryption = $settings->getOption('pw-encryption'); ?>
							<?php $e = array('MD5', 'SHA256'); ?>
							<?php foreach ($e as $value) : ?>
								<label class="radio">
									<input type="radio" name="pw-encryption" id="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($pw_encryption == $value) echo 'checked'; ?> > <?php echo $value; ?>
								</label>
							<?php endforeach; ?>
							</div>
						</div>
					</fieldset>
				</div>

				<!-- - - - - - - - - - - - - - - - -

						Denied messages

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="denied-messages">
				<fieldset>
					<legend><?php _e('Denied messages'); ?></legend>
					<div class="control-group">
						<label class="control-label" for="block-msg-enable"><?php _e('Logged in'); ?></label>
						<div class="controls">
							<label class="checkbox">
								<input type="checkbox" class="input-xlarge" id="block-msg-enable" name="block-msg-enable" <?php echo $settings->getOption('block-msg-enable', true); ?>>
								<?php _e('Display message'); ?>
							</label>
							<label class="textarea">
								<textarea class="input-xlarge" id="block-msg" name="block-msg" rows="5"><?php echo $settings->getOption('block-msg'); ?></textarea>
							</label>
							<p class="help-block"><?php _e('This controls the message a <strong>signed in</strong> user sees when accessing a protected page'); ?></p>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="block-msg-out-enable"><?php _e('Logged out'); ?></label>
						<div class="controls">
							<label class="checkbox">
								<input type="checkbox" class="input-xlarge" id="block-msg-out-enable" name="block-msg-out-enable" <?php echo $settings->getOption('block-msg-out-enable', true); ?>>
								<?php _e('Display message'); ?>
							</label>
							<label class="textarea">
								<textarea class="input-xlarge" id="block-msg-out" name="block-msg-out" rows="5"><?php echo $settings->getOption('block-msg-out'); ?></textarea>
							</label>
							<p class="help-block"><?php _e('Show this error after a user is redirected to the login page (user is <strong>logged out</strong>)'); ?></p>
						</div>
					</div>
				</fieldset>
				</div>

				<!-- - - - - - - - - - - - - - - - -

						Emails - Welcome

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="emails-welcome">
					<fieldset>
						<legend><?php _e('Welcome email'); ?></legend>
						<div class="control-group">
							<label class="control-label" for="email-welcome-subj"><?php _e('Welcome'); ?></label>
							<div class="controls">
								<label>
									<input type="text" class="input-xlarge" id="email-welcome-subj" name="email-welcome-subj" value="<?php echo $settings->getOption('email-welcome-subj'); ?>">
									<p class="help-inline"><?php _e('Subject'); ?></p>
								</label>
								<textarea class="input-xlarge" id="email-welcome-msg" name="email-welcome-msg" rows="10"><?php echo $settings->getOption('email-welcome-msg'); ?></textarea>
								<div class="help-inline">
									<p><?php _e('Message body'); ?></p><br>
									<p><strong><?php _e('Shortcodes:'); ?></strong></p>
									<p><?php _e('Site address:'); ?> <code>{{site_address}}</code></p>
									<p><?php _e('Full name:'); ?> <code>{{full_name}}</code></p>
									<p><?php _e('Username:'); ?> <code>{{username}}</code></p>
									<p><?php _e('Email:'); ?> <code>{{email}}</code></p>
									<p><?php _e('Activation link:'); ?> <code>{{activate}}</code></p>
								</div>
								<p class="help-block"><?php _e('The email a user receives after signing up'); ?></p>
							</div>
						</div>
					</fieldset>
				</div>

				<!-- - - - - - - - - - - - - - - - -

						Emails - Activate

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="emails-activate">
					<fieldset>
						<legend><?php _e('Activation emails'); ?></legend>
						<div class="control-group">
							<label class="control-label" for="email-activate-subj"><?php _e('Successfully activated'); ?></label>
							<div class="controls">
								<label>
									<input type="text" class="input-xlarge" id="email-activate-subj" name="email-activate-subj" value="<?php echo $settings->getOption('email-activate-subj'); ?>">
									<p class="help-inline"><?php _e('Subject'); ?></p>
								</label>
								<textarea class="input-xlarge" id="email-activate-msg" name="email-activate-msg" rows="10"><?php echo $settings->getOption('email-activate-msg'); ?></textarea>
								<div class="help-inline">
									<p><?php _e('Message body'); ?></p><br>
									<p><strong><?php _e('Shortcodes:'); ?></strong></p>
									<p><?php _e('Site address:'); ?> <code>{{site_address}}</code></p>
									<p><?php _e('Full name:')?> <code>{{full_name}}</code></p>
									<p><?php _e('Username:'); ?> <code>{{username}}</code></p>
								</div>
								<p class="help-block"><?php _e('The email a user receives after activating their account'); ?></p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="email-activate-resend-subj"><?php _e('Resend activation link'); ?></label>
							<div class="controls">
								<label>
									<input type="text" class="input-xlarge" id="email-activate-resend-subj" name="email-activate-resend-subj" value="<?php echo $settings->getOption('email-activate-resend-subj'); ?>">
									<p class="help-inline"><?php _e('Subject'); ?></p>
								</label>
								<textarea class="input-xlarge" id="email-activate-resend-msg" name="email-activate-resend-msg" rows="10"><?php echo $settings->getOption('email-activate-resend-msg'); ?></textarea>
								<div class="help-inline">
									<p><?php _e('Message body'); ?></p><br>
									<p><strong><?php _e('Shortcodes:'); ?></strong></p>
									<p><?php _e('Site address:'); ?> <code>{{site_address}}</code></p>
									<p><?php _e('Full name:'); ?> <code>{{full_name}}</code></p>
									<p><?php _e('Username:'); ?> <code>{{username}}</code></p>
									<p><?php _e('Activation link:'); ?> <code>{{activate}}</code></p>
								</div>
								<p class="help-block"><?php _e('The email a user receives when requesting an activation link'); ?></p>
							</div>
						</div>
					</fieldset>
				</div>

				<!-- - - - - - - - - - - - - - - - -

						Emails - Forgot

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="emails-forgot">
					<fieldset>
						<legend><?php _e('Account recovery emails'); ?></legend>
						<div class="control-group">
							<label class="control-label" for="email-forgot-success-subj"><?php _e('Successfully recovered'); ?></label>
							<div class="controls">
								<label>
									<input type="text" class="input-xlarge" id="email-forgot-success-subj" name="email-forgot-success-subj" value="<?php echo $settings->getOption('email-forgot-success-subj'); ?>">
									<p class="help-inline"><?php _e('Subject'); ?></p>
								</label>
								<textarea class="input-xlarge" id="email-forgot-success-msg" name="email-forgot-success-msg" rows="10"><?php echo $settings->getOption('email-forgot-success-msg'); ?></textarea>
								<div class="help-inline">
									<p><?php _e('Message body'); ?></p><br>
									<p><strong><?php _e('Shortcodes:'); ?></strong></p>
									<p><?php _e('Site address:'); ?> <code>{{site_address}}</code></p>
									<p><?php _e('Full name:'); ?> <code>{{full_name}}</code></p>
									<p><?php _e('Username:'); ?> <code>{{username}}</code></p>
								</div>
								<p class="help-block"><?php _e('The email a user receives after successfully resetting their password'); ?></p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="email-forgot-subj"><?php _e('Recover account'); ?></label>
							<div class="controls">
								<label>
									<input type="text" class="input-xlarge" id="email-forgot-subj" name="email-forgot-subj" value="<?php echo $settings->getOption('email-forgot-subj'); ?>">
									<p class="help-inline"><?php _e('Subject'); ?></p>
								</label>
								<textarea class="input-xlarge" id="email-forgot-msg" name="email-forgot-msg" rows="10"><?php echo $settings->getOption('email-forgot-msg'); ?></textarea>
								<div class="help-inline">
									<p><?php _e('Message body'); ?></p><br>
									<p><strong><?php _e('Shortcodes:'); ?></strong></p>
									<p><?php _e('Site address:'); ?> <code>{{site_address}}</code></p>
									<p><?php _e('Full name:'); ?> <code>{{full_name}}</code></p>
									<p><?php _e('Username:'); ?> <code>{{username}}</code></p>
									<p><?php _e('Reset link:'); ?> <code>{{reset}}</code></p>
								</div>
								<p class="help-block"><?php _e('The email a user receives when requesting their username / password'); ?></p>
							</div>
						</div>
					</fieldset>
				</div>

				<!-- - - - - - - - - - - - - - - - -

						Emails - Add User

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="emails-add-user">
					<fieldset>
						<legend><?php _e('Add user'); ?></legend>
						<div class="control-group">
							<label class="control-label" for="email-add-user-subj"><?php _e('Add user'); ?></label>
							<div class="controls">
								<label>
									<input type="text" class="input-xlarge" id="email-add-user-subj" name="email-add-user-subj" value="<?php echo $settings->getOption('email-add-user-subj'); ?>">
									<p class="help-inline"><?php _e('Subject'); ?></p>
								</label>
								<textarea class="input-xlarge" id="email-add-user-msg" name="email-add-user-msg" rows="10"><?php echo $settings->getOption('email-add-user-msg'); ?></textarea>
								<div class="help-inline">
									<p><?php _e('Message body'); ?></p><br>
									<p><strong><?php _e('Shortcodes:'); ?></strong></p>
									<p><?php _e('Site address:'); ?> <code>{{site_address}}</code></p>
									<p><?php _e('Full name:'); ?> <code>{{full_name}}</code></p>
									<p><?php _e('Username:'); ?> <code>{{username}}</code></p>
									<p><?php _e('Password:'); ?> <code>{{password}}</code></p>
								</div>
								<p class="help-block"><?php _e('When the admin creates a new user through the admin panel, the user will receive this email'); ?></p>
								<p class="help-block"><strong><?php _e('Note:'); ?></strong> <?php _e('The password is randomly generated and should be included in the email'); ?></p>
							</div>
						</div>
					</fieldset>
				</div>

				<!-- - - - - - - - - - - - - - - - -

						Profiles

				- - - - - - - - - - - - - - - - - -->
				<div class="modal hide fade" id="profileModal">
					<div class="modal-header">
						<a class="close" data-dismiss="modal">&times;</a>
						<h3><?php _e('Confirm delete'); ?></h3>
					</div>
					<div class="modal-body">
						<p><?php _e('You are about to delete a profile field, are you sure you want to do this?'); ?></p>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn btn-danger delete-field"><?php _e('Delete'); ?></a>
						<a href="#" class="btn" data-dismiss="modal">Close</a>
					</div>
				</div>

				<div class="tab-pane fade" id="user-profiles">

				<fieldset>
					<legend><?php _e('User profiles'); ?></legend>

					<div class="control-group">
						<label class="control-label" for="profile-public-enable"><?php _e('Profile Control'); ?></label>
						<div class="controls">
							<label class="checkbox disabled">
								<input type="checkbox" disabled id="profile-public-enable" name="profile-public-enable" <?php echo $settings->getOption('profile-public-enable', true); ?>>
								<?php _e('Make all profiles public'); ?>
							</label>
							<label class="checkbox">
								<input type="checkbox" disabled id="profile-display-email-enable" name="profile-display-email-enable" <?php echo $settings->getOption('profile-display-email-enable', true); ?>>
								<?php _e('Display user\'s email'); ?>
							</label>
							<label class="checkbox">
								<input type="checkbox" disabled id="profile-display-name-enable" name="profile-display-name-enable" <?php echo $settings->getOption('profile-display-name-enable', true); ?>>
								<?php _e('Display user\'s full name'); ?>
							</label>
							<p class="help-block"><?php _e('Above controls coming soon in a future release!'); ?></p>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="profile-timestamps-enable"><?php _e('Access logs'); ?></label>
						<div class="controls">
							<label class="checkbox">
								<input type="checkbox" id="profile-timestamps-enable" name="profile-timestamps-enable" <?php echo $settings->getOption('profile-timestamps-enable', true); ?>>
								<?php _e('Enable logging'); ?>
							</label>
							<label class="checkbox">
								<input type="checkbox" id="profile-timestamps-admin-enable" name="profile-timestamps-admin-enable" <?php echo $settings->getOption('profile-timestamps-admin-enable', true); ?>>
								<?php _e('Viewable to admin only'); ?>
							</label>
							<p class="help-block"><?php _e('Log a timestamp + IP address for when a user signs in'); ?></p>
						</div>
					</div>

					<table class="table profile-field-rows span6">
					<thead>
						<tr>
							<th></th>
							<th><?php _e('Input type'); ?></th>
							<th><?php _e('Label'); ?></th>
						</tr>
					</thead>
					<?php echo $settings->profile_fields(); ?>
					</table>
				</fieldset>
				</div>

				<!-- - - - - - - - - - - - - - - - -

						Update

				- - - - - - - - - - - - - - - - - -->
				<div class="tab-pane fade" id="update">
					<fieldset>
						<legend><?php _e('Update'); ?></legend>
							<br><div class="row">
								<?php if (!$settings->newChangelog()) : ?>
									<div class="span8 alert alert-block alert-warning fade in"><a class="close" data-dismiss="alert" href="#">&times;</a><h4 class="alert-warning"><?php _e('Updates disabled'); ?></h4>
									<p><?php _e('Two thing may have happened:'); ?></p>
									<ol>
										<li><?php _e('Update checking is disabled'); ?></li>
										<li><?php _e('Could not connect to server to fetch latest update details. Please make sure the PHP setting `allow_url_fopen` is enabled.'); ?></li>
									</ol>
									</div>
									<?php elseif($newUpdate) : ?>
									<div class="span8 alert alert-block alert-info fade in"><a class="close" data-dismiss="alert" href="#">&times;</a><h4 class="alert-info"><?php _e('Update available!'); ?></h4>
									<?php _e('There\'s a new update available! Please visit your CodeCanyon profile to download the new version.'); ?></div>
									<?php else : ?>
									<div class="span8 alert alert-block alert-success fade in"><a class="close" data-dismiss="alert" href="#">&times;</a><h4 class="alert-success"><?php _e('You\'re up to date!'); ?></h4>
									<?php _e('There are no new updates available. When a new update is released this message will change accordingly.'); ?></div>
								<?php endif; ?>
							</div>

						<div class="control-group">
							<label class="control-label" for="update-check-enable"><?php _e('Check for updates'); ?></label>
							<div class="controls">
								<label class="checkbox">
									<input type="checkbox" id="update-check-enable" name="update-check-enable" <?php echo $settings->getOption('update-check-enable', true); ?>>
									<?php _e('Enable to automatically check for updates each time you load this page'); ?>
								</label>
								<p class="help-block"><?php _e('Disabling this may improve speed on the Settings page'); ?></p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label"><?php _e('Current version'); ?></label>
							<div class="controls">
								<span class="uneditable-input"><?php echo phplogin_version ?></span>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label"><?php _e('Latest version'); ?></label>
							<div class="controls">
								<span class="uneditable-input"><?php echo $newUpdate ? $settings->newVersion() : phplogin_version; ?></span>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label"><?php _e('Latest changelog'); ?></label>
							<div class="controls">
								<textarea rows="10" class="span5" disabled><?php echo $settings->newChangelog(); ?></textarea>
							</div>
						</div>
					</fieldset>
				</div>

			</div>
			<div class="span12">
				<div class="form-actions">
					<button type="submit" data-loading-text="<?php _e('saving...'); ?>" data-complete-text="<?php _e('Changes saved'); ?>" name="save-settings" class="btn btn-primary" id="save-settings"><?php _e('Save changes'); ?></button>
				</div>
			</div>
		</form>
	  </div>
<?php
    include_once('./templates/footer.php');
?>