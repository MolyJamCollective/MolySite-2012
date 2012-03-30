<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'MolyJam - WebChat';
    $pageHeader = '';
    $pageStyles = array();
    $activeTab = '6';

    $pageScripts = array();
    $PageScriptsRaw = '';

    include_once('./templates/header.php');
?>
    <iframe width="100%" height="100%" src="http://webchat.freenode.net/?channels=#molyjam"></iframe>
<?php
    include_once('./templates/footer.php');
?>