<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'MolyJam - Account Creation';
    $pageHeader = 'Account Creation';
    $pageStyles = array();
    $activeTab = '0';

    $pageScripts = array();
    $PageScriptsRaw = '';

    include_once('./templates/header.php');
    include_once('classes/class.signup.php');
?>
<div class="row-fluid">
    <div class="span4">
	<form class="form-stacked" method="post" action="sign_up.php" id="sign-up-form">
	    <fieldset>
		<div class="control-group">
		    <div class="controls">
			<input type="text" class="input-xlarge" id="name" name="name" value="<?php echo $signUp->getPost('name'); ?>" placeholder="<?php _e('Full name'); ?>">
		    </div>
		</div>
		<div class="control-group" id="usrCheck">
		    <div class="controls">
			<input type="text" class="input-xlarge" id="username" name="username" maxlength="11" value="<?php echo $signUp->getPost('username'); ?>" placeholder="<?php _e('Choose your username'); ?>">
		    </div>
		</div>
		<div class="control-group">
		    <div class="controls">
			<input type="password" class="input-xlarge" id="password" name="password" placeholder="<?php _e('Create a password'); ?>">
		    </div>
		</div>
		<div class="control-group">
		    <div class="controls">
			<input type="password" class="input-xlarge" id="password_confirm" name="password_confirm" placeholder="<?php _e('Confirm your password'); ?>">
		    </div>
		</div>
		<div class="control-group">
		    <div class="controls">
			<input type="text" class="input-xlarge" id="email" name="email" value="<?php echo $signUp->getPost('email'); ?>" placeholder="<?php _e('Email'); ?>">
		    </div>
		</div>
		<div class="control-group">
		    <div class="controls">
			<input type="text" class="input-xlarge" id="validation" name="validation" maxlength="1" value="<?php echo $signUp->getPost('validation'); ?>" placeholder="<?php _e('Are you human? 4 + 5 ='); ?>">
		    </div>
		</div>
	    </fieldset>
	    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"/>
	    <button type="submit" class="btn btn-primary"><?php _e('Create my account'); ?></button>
	</form>
    </div>
    <div class="span6">
	<h1><?php _e('Create a new account'); ?></h1>
	<p><?php _e('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris cursus rhoncus tristique. Mauris ornare ipsum a leo molestie id porttitor justo bibendum. Pellentesque magna augue, sollicitudin ut ornare pretium, mattis imperdiet augue. Morbi semper sapien sit amet velit interdum eu commodo erat fringilla. Nulla et ipsum orci, ac varius nulla. Nam vehicula, mi quis euismod consectetur, magna dui porttitor sem, vel venenatis felis nunc eu diam. Integer vitae est at nunc varius viverra sit amet at magna. Vestibulum mi diam, pharetra id malesuada ac, venenatis nec turpis. Vestibulum metus nisl, pharetra non laoreet eu, laoreet a eros. Suspendisse ut arcu in mauris dapibus sodales. Vestibulum commodo congue elit at mollis. Fusce semper auctor odio, ut pharetra justo faucibus blandit. Fusce in pellentesque elit. Nunc adipiscing neque eu odio tincidunt ac mollis erat porta.'); ?></p>
	<h2><?php _e('Features'); ?></h2>
	<p><?php _e('Cras placerat scelerisque vehicula. Fusce eu ipsum vel mi convallis dapibus. Cras ut nibh metus, quis malesuada augue. Aenean a nisi nec sem accumsan gravida in in turpis. Nulla euismod lorem non sem imperdiet vestibulum. Donec blandit aliquet turpis sed dapibus. Duis fermentum facilisis diam, sit amet ultrices neque dictum eget.'); ?></p>
    </div>
</div>
<?php
    include_once('./templates/footer.php');
?>