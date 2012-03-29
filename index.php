<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'What Would Molydeux?';
    $pageHeader = '';
    $pageStyles = array();
    $activeTab = '1';

    $pageScripts = array();
    $PageScriptsRaw = '';

    include_once('./templates/header.php');
?>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span6"> <img class="auto-size" src="./img/title.png" alt="What Would Molydeux?"/> </div>
</div>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span6"> <img class="auto-size" src="./img/moly.png" /> </div>
</div>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span6" style="background-color:#56D34C; text-align: center;">
        <h2 class="allcaps cream">AN INTERNATIONAL 48-HOUR GAME JAM</h2>
    </div>
</div>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span6" style="background-color:#40B239; text-align: center;">
        <h2>EXPLORING THE WORKS OF <a href="http://www.twitter.com/petermolydeux" style="color: #EEEEEE">@PeterMolydeux</a></h2>
    </div>
</div>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span6" style="background-color:#2C8C2E; text-align: center;">
        <h2>MARCH 30TH - APRIL 1ST, 2012</h2>
    </div>
</div>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span6" style="background-color:#006600; text-align: center;">
        <div id="countdown"></div>
    </div>
</div>

<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span3">
        <h3><a href="#">Location #1</a></h3>
            <dl class="dl-horizontal">
            <dt>Person #1</dt>
                <dd><a href="http://www.twitter.com/">@Twitter</a></dd>
            <dt></dt>
                <dd><a href="mailto:">Email the team</a></dd>
        </dl>
    </div>
    <div class="span3">
        <h3><a href="#">Location #2</a></h3>
            <dl class="dl-horizontal">
            <dt>Person #1</dt>
                <dd><a href="http://www.twitter.com/">@Twitter</a></dd>
            <dt></dt>
                <dd><a href="mailto:">Email the team</a></dd>
        </dl>
    </div>
</div>
<?php
    include_once('./templates/footer.php');
?>