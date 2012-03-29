<?php

    function remove_event()
    {
        $Event = new Event();
        $Event->Get($_GET['EventDeleteID']);
        $Event->Delete();
    }


    function add_event()
    {
        $Event = new Event($_POST['title'], $_POST['start'], $_POST['stop'], $_POST['description']);
        $Event->Save();
        
    }
    
    function edit_event()
    {
        $Event = new Event();
        $Event->Get($_POST['edit_eventid']);
        
        $Event->Title = $_POST['title'];
        $Event->Start = $_POST['start'];
        $Event->Stop = $_POST['stop'];
        $Event->Description = $_POST['description'];
        
        $Event->Save();
        
    }

    function list_events()
    {
        $Event = new Event(); //create a news object
        $EventList = $Event->GetList(array(array("eventid", ">", 0)));
        
        if(empty($EventList))
        {
            echo 'No Events Exists';
        }
        else
        { ?>
        <table class="table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Start</th>
                    <th>Stop</th>
                    <th>Description</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($EventList as $Event) { ?>
                <tr class="eventRow" id="<?php echo $Event->eventId ?>">
                    <td><?php echo $Event->eventId ?></td>
                    <td><?php echo $Event->Title ?></td>
                    <td><?php echo $Event->Start ?></td>
                    <td><?php echo $Event->Stop ?></td>
                    <td><?php echo $Event->Description ?></td>
                    <td><a class="btn" href="<?php echo '?EventEditID='.$Event->eventId ?>">Edit</a> <a class="btn btn-danger" href="<?php echo '?EventDeleteID='.$Event->eventId ?>">x</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
<?php   }
    }
    
?>