<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'What Would Molydeux?';
    $pageHeader = '';
    $pageStyles = array();
    $activeTab = '1';

    $pageScripts = array();
    $PageScriptsRaw = '';

    include_once('./templates/header.php');
    
    include_once('./configuration.php');
    include_once('./objects/class.database.php');
    include_once('./objects/class.location.php');
    include_once('./objects/class.organizer.php');
?>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span6">
        <img class="auto-size" src="./img/title.png" alt="What Would Molydeux?"/>
    </div>
    <div class="span3">&nbsp;</div>
</div>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span6">
        <img class="auto-size" src="./img/moly.png" />
    </div>
    <div class="span3">&nbsp;</div>
</div>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span6" style="background-color:#00CC00; text-align: center; max-width: 780px">
        <h2 class="allcaps cream">AN INTERNATIONAL 48-HOUR GAME JAM</h2>
    </div>
    <div class="span3">&nbsp;</div>
</div>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span6" style="background-color:#00AA00; text-align: center; max-width: 780px">
        <h2>EXPLORING THE WORKS OF <a href="http://www.twitter.com/petermolydeux" style="color: #EEEEEE">@PeterMolydeux</a></h2>
    </div>
    <div class="span3">&nbsp;</div>
</div>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span6" style="background-color:#008800; text-align: center;max-width: 780px">
        <h2>MARCH 30TH - APRIL 1ST, 2012
    </div>
    <div class="span3">&nbsp;</div>
</div>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span6" style="background-color:#333333; text-align: center; max-width: 780px">
        <h3>Check out the <a href="http://batchgeo.com/map/MolyJam2012">map</a> for locations, <a href="./webchat.php">chat</a> with participants, or watch <a href="http://www.twitch.tv/event/molyjam">livestream</a> of the events</h3>
    </div>
    <div class="span3">&nbsp;</div>
</div>
<br />
<br />
<?php
    $Location = new Location();
    $LocationList = $Location->GetList(array(array("locationid", ">", 0)));
    $i = 0;
    foreach ($LocationList as $Location)
    {
        
        $Organizer = new Organizer();
        $OrganizerList = $Organizer->GetList(array(array("locationid", "=", $Location->locationId)));

        if($i % 2 == 0)
        {
?>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    
<?php   } ?>

    <div class="span3">
        <h3><a href="<?php echo $Location->EventURL ?>"><?php echo $Location->Title ?></a></h3>
        <dl class="dl-horizontal">

<?php
        foreach ($OrganizerList as $Organizer)
        {
?>
            <dt><?php echo $Organizer->Name ?></dt>
         <?php if(!empty($Organizer->Twitter)) { ?> <dd><a href="http://www.twitter.com/#!/<?php echo $Organizer->Twitter ?>">@<?php echo $Organizer->Twitter ?></a></dd><?php } ?>
<?php   } ?>
            <dt></dt>
            <dd><a href="mailto:<?php echo $Location->EventEmail ?>"><?php echo $Location->EventEmail ?></a></dd>
        </dl>
    </div>
<?php
        if($i % 2 == 1)
        {
?>
</div>
<?php
        }
    $i++;
    }
    if($i % 1 == 0)
    {
?>
</div>
<?php } ?>
<?php
    include_once('./templates/footer.php');
?>