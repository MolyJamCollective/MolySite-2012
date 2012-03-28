<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'Page Title';
    $pageHeader = 'Page Header';
    $pageStyles = array();
    $activeTab = '0';

    $pageScripts = array();
    $PageScriptsRaw = '';

    include_once('classes/class.forgot.php');
    $forgot = new Forgot;

	// This is for the modal forgotten password form on login.php
	// This must be called before the header
	if(isset($_POST['usernamemail']))
	{
		$forgot->modal_process();
		exit();
	}

    include_once('./templates/header.php');
?>

$forgot->process();
<?php
    include_once('./templates/footer.php');
?>