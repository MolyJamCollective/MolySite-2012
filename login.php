<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'MolyJam - Login';
    $pageHeader = 'Sign in to MolyJam';
    $pageStyles = array();
    $activeTab = '0';

    $pageScripts = array();
    $PageScriptsRaw = '';

    include_once('./templates/header.php');
	include_once('classes/class.login.php');
	$login = new Login(); 
?>

<div id="forgot-form" class="modal hide fade">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3><?php _e('Account Recovery'); ?></h3>
	</div>
	<div class="modal-body">
		<div id="message"></div>
		<form action="forgot.php" method="post" name="forgotform" id="forgotform" class="form-stacked forgotform normal-label">
			<div class="controlgroup forgotcenter">
			<label for="usernamemail"><?php _e('Username or Email Address'); ?></label>
				<div class="control">
					<input id="usernamemail" name="usernamemail" size="30" type="text"/>
				</div>
			</div>
			<button type="submit" data-loading-text="<?php _e('loading...'); ?>" data-complete-text="<?php _e('Done'); ?>" name="forgotten" class="btn btn-primary modal-btn" id="forgotsubmit"><?php _e('Submit'); ?></button>
		</form>
	</div>
	<div class="modal-footer"><p><?php _e('It\'ll be easy, I promise.'); ?></p></div>
</div>

<div class="row-fluid">
	<div class="main login">
		<form method="post" class="form normal-label" action="login.php">
		<fieldset>
			<div class="control-group">
			<label for="username" class="login-label"><?php _e('Username'); ?></label>
				<div class="controls">
					<input class="xlarge" id="username" name="username" size="30" type="text"/>
					<span class="forgot"><a data-toggle="modal" href="#forgot-form" id="forgotlink" tabindex=-1><?php _e('Trouble signing in'); ?></a>?</span>
				</div>
			</div>

			<div class="control-group">
			<label for="password" class="login-label"><?php _e('Password'); ?></label>
				<div class="controls">
					<input class="xlarge" id="password" name="password" size="30" type="password"/>
				</div>
			</div>
		</fieldset>

		<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"/>
		<input type="submit" value="<?php _e('Sign in'); ?>" class="btn login-submit" id="login-submit" name="login"/>
		<br /><br />

		<label class="remember" for="remember"><input type="checkbox" id="remember" name="remember"/>Stay signed in</label>
		</form>
	</div>

</div>
<?php
    include_once('./templates/footer.php');
?>