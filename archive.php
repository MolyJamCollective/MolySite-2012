<?php
    include_once("./configuration.php");
    include_once("./objects/class.database.php");
    include_once("./objects/class.gameobject.php");

    $Game = new GameObject(); //create a book object
    $GameList = $Game->GetList(array(array("gameobjectId", ">", 0)));
    
    include('./templates/globals.php');
    
    $pageTitle = 'MolyJam Game Archive System';
    $pageHeader = 'MolyJam Game Archive System';
    $pageStyles = array();

    $pageScripts = array();
    $PageScriptsRaw = '';

    include('./templates/header.php');
    
?>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Location</th>
                <th>Popularity</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach ($GameList as $Game)
    {
        $Popularity = ($Game->pageviews * 0.01) + ($Game->downloads * 1);
?>
            <tr>
                <td><?php echo $Game->gameobjectid ?></td>
                <td><?php echo $Game->gamename ?></td>
                <td><?php echo $Game->molyjamlocation ?></td>
                <td><?php echo $Popularity ?></td>
                <td><?php echo $Game->createddatetime ?></td>
            </tr>
<?php
    }
?>
        </tbody>
    </table>

<?php
    include('./templates/footer.php');
?>