<?php

    function list_events()
    {
        $Event = new Event(); //create a news object
        $EventList = $Event->GetList(array(array("eventid", ">", 0))); // returns a list of news objects ordered by date in descending order
        
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
                </tr>
            <?php } ?>
            </tbody>
        </table>
<?php   }
    }
    
?>