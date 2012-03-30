<?php
    
    function shorten_text($text = '')
    {
        $len = strlen($text);
        if($len > 24)
            $len = 24;
        
        return substr($text, 0, $len);
    }
    
    function remove_location()
    {
        $Location = new Location();
        $Location->Get($_GET['LocationDeleteID']);
        $Location->Delete();
    }

    function add_location()
    {
        $Location = new Location($_POST['title'], $_POST['address'], $_POST['city'], $_POST['region'], $_POST['country'], $_POST['eventurl'], $_POST['eventemail'], $_POST['eventid']);
        $Location->Save();
    }
    
    function edit_location()
    {
        $Location = new Location();
        $Location->Get($_POST['edit_locationid']);

        $Location->Title = $_POST['title'];
        $Location->Address = $_POST['address'];
        $Location->City = $_POST['city'];
        $Location->Region = $_POST['region'];
        $Location->Country = $_POST['country'];
        $Location->EventURL = $_POST['eventurl'];
        $Location->EventEmail = $_POST['eventemail'];
        $Location->EventID = $_POST['eventid'];
        
        $Location->Save();
    }

    function list_locations($eventID = '')
    {
        //TODO:: List/Filter By Event
        
        $Location = new Location(); //create a news object
        $LocationList = $Location->GetList(array(array("locationid", ">", 0)));
        
        if(empty($LocationList))
        {
            echo 'No Locations Exists';
        }
        else
        { ?>
        <table class="table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th width="5">#</th>
                    <th>Title</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Region/State</th>
                    <th>Country</th>
                    <th>Link</th>
                    <th>Email</th>
                    <th>Event</th>
                    <th width="80"></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($LocationList as $Location)
            {
                $Event = new Event();
                $Event->Get($Location->EventID);
                $URLText = shorten_text($Location->EventURL);
                
                ?>
                <tr class="eventRow" id="<?php echo $Location->eventId ?>">
                    <td><?php echo $Location->locationId;  ?></td>
                    <td><?php echo $Location->Title;  ?></td>
                    <td><?php echo $Location->Address; ?></td>
                    <td><?php echo $Location->City; ?></td>
                    <td><?php echo $Location->Region; ?></td>
                    <td><?php echo $Location->Country; ?></td>
                    <td><?php if(!empty($Location->EventURL)){?><a href="<?php echo $Location->EventURL; ?>" target="_blank">Link</a><?php } ?></td>
                    <td><?php if(!empty($Location->EventEmail)){?><a href="mailto:<?php echo $Location->EventEmail; ?>">Email</a><?php } ?></td>
                    <td><?php echo $Event->Title; ?></td>
                    <td><a class="btn" href="<?php echo '?LocationEditID='.$Location->locationId ?>">Edit</a> <a class="btn btn-danger" href="<?php echo '?LocationDeleteID='.$Location->locationId ?>">X</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
<?php   }
    }
    
?>