<?php

    function remove_organizer()
    {
        $Organizer = new Organizer();
        $Organizer->Get($_GET['OrganizerDeleteID']);
        $Organizer->Delete();
    }


    function add_organizer()
    {
        $Organizer = new Organizer($_POST['name'],$_POST['locationid'], $_POST['twitter']);
        $Organizer->Save();
        
    }
    
    function edit_organizer()
    {
        $Organizer = new Organizer();
        $Organizer->Get($_POST['edit_organizerid']);
        
        $Organizer->Name = $_POST['name'];
        $Organizer->Twitter = $_POST['twitter'];
        $Organizer->LocationID = $_POST['locationid'];
        
        $Organizer->Save();
    }

    function list_organizer()
    {
        $Organizer = new Organizer(); //create a news object
        $OrganizerList = $Organizer->GetList(array(array("organizerid", ">", 0)));
        
        if(empty($OrganizerList))
        {
            echo 'No Organizers Exists';
        }
        else
        { ?>
        <table class="table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th width="5">#</th>
                    <th>Name</th>
                    <th>Twitter</th>
                    <th>Location</th>
                    <th>Event</th>
                    <th width="80"></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($OrganizerList as $Organizer)
            {
                $Location = new Location();
                $Location->Get($Organizer->LocationID);
                
                $Event = new Event();
                $Event->Get($Location->EventID);
            ?>
                <tr class="eventRow" id="<?php echo $Organizer->eventId ?>">
                    <td><?php echo $Organizer->organizerId ?></td>
                    <td><?php echo $Organizer->Name ?></td>
                    <td><?php echo $Organizer->Twitter ?></td>
                    <td><?php echo $Location->Title ?></td>
                    <td><?php echo $Event->Title ?></td>
                    <td><a class="btn" href="<?php echo '?OrganizerEditID='.$Organizer->organizerId ?>">Edit</a> <a class="btn btn-danger" href="<?php echo '?OrganizerDeleteID='.$Organizer->organizerId ?>">X</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
<?php   }
    }
    
?>