<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'What Would Molydeux?';
    $pageHeader = '';
    $pageStyles = array();
    $activeTab = '1';

    $pageScripts = array();
    $PageScriptsRaw = '
<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">
<!--

dateFuture = new Date(2012,2,30,19,00,00); // Uses base 0 data, unless days uses base 1

function GetCount(){

        dateNow = new Date();                                                                        //grab current date
        amount = dateFuture.getTime() - dateNow.getTime();                //calc milliseconds between dates
        delete dateNow;

        // time is already past
        if(amount < 0){
                document.getElementById(\'countdown\').innerHTML="Now!";
        }
        // date is still good
        else{
                days=0;hours=0;mins=0;secs=0;out="";

                amount = Math.floor(amount/1000);//kill the "milliseconds" so just secs

                days=Math.floor(amount/86400);//days
                amount=amount%86400;

                hours=Math.floor(amount/3600);//hours
                amount=amount%3600;

                mins=Math.floor(amount/60);//minutes
                amount=amount%60;

                secs=Math.floor(amount);//seconds

                if(days != 0){out += days +" day"+((days!=1)?"s":"")+", ";}
                if(days != 0 || hours != 0){out += hours +" hour"+((hours!=1)?"s":"")+", ";}
                if(days != 0 || hours != 0 || mins != 0){out += mins +" minute"+((mins!=1)?"s":"")+", ";}
                out += secs +" seconds";
                document.getElementById(\'countdown\').innerHTML=out;

                setTimeout("GetCount()", 1000);
        }
}

window.onload=function(){GetCount();}//call when everything has loaded

//-->
</script>';

    include_once('./templates/header.php');
    
    include_once('./configuration.php');
    include_once('./objects/class.database.php');
    include_once('./objects/class.location.php');
    include_once('./objects/class.organizer.php');
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
    <div class="span6" style="background-color:#00CC00; text-align: center;">
        <h2 class="allcaps cream">AN INTERNATIONAL 48-HOUR GAME JAM</h2>
    </div>
</div>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span6" style="background-color:#00AA00; text-align: center;">
        <h2>EXPLORING THE WORKS OF <a href="http://www.twitter.com/petermolydeux" style="color: #EEEEEE">@PeterMolydeux</a></h2>
    </div>
</div>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span6" style="background-color:#008800; text-align: center;">
        <h2>MARCH 30TH - APRIL 1ST, 2012
    </div>
</div>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span6" style="background-color:#006600; text-align: center;">
        <h2><div id="countdown"></div></h2>
    </div>
</div>
<div class="row-fluid">
    <div class="span3">&nbsp;</div>
    <div class="span6" style="background-color:#004400; text-align: center;">
        <h2><a href="http://batchgeo.com/map/MolyJam2012">Global Location Map</a></h2>
    </div>
</div>

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
        <h3><a href="#"><?php echo $Location->Title ?></a></h3>
        <dl class="dl-horizontal">

<?php
        foreach ($OrganizerList as $Organizer)
        {
?>
            <dt><?php echo $Organizer->Name ?></dt>
            <dd><a href="http://www.twitter.com/#!/<?php echo $Organizer->Twitter ?>">@<?php echo $Organizer->Twitter ?></a></dd>
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