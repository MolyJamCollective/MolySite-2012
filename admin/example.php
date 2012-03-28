<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'Page Title';
    $pageHeader = 'Page Header';
    $pageStyles = array();

    $pageScripts = array();
    $PageScriptsRaw = '';

    include_once('./templates/header.php');
?>
    <h3>Content Here</h3>
<?php
    include_once('./templates/footer.php');
?>