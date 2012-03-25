<?php
    // TODO:: Hover over game for image popup
    // TODO:: Click Row for Display

    include_once("./configuration.php");
    include_once("./objects/class.database.php");
    include_once("./objects/class.gameobject.php");

    $Game = new GameObject(); //create a book object
    
    
    $sortBy = "";
    if( !empty( $_GET[ "sortBy" ] ) )
    {
    	$sortBy = $_GET[ "sortBy" ];
   	}
   	
   	$sortOrder = true;
   	if( !empty( $_GET[ "sortOrder" ] ) && $_GET[ "sortOrder" ] == "desc" )
    {
    	$sortOrder = false;
   	}
    
    $GameList = $Game->GetList(array(array("gameobjectId", ">", 0)), $sortBy, $sortOrder);
    
    include('./templates/globals.php');
    
    $pageTitle = 'MolyJam Game Archive System';
    $pageHeader = 'MolyJam Game Archive System';
    $pageStyles = array();

    $pageScripts = array();
    $PageScriptsRaw = '';
    
    $PageScriptsRaw ='
  <script>
    var lastMouseOverId = -1;
    var proceedHidingThumbnail = true;
    function hideThumbnail()
    {
      if( proceedHidingThumbnail == true )
      {
        $("#gameThumbnail").hide();
        lastMouseOverId = -1;
      }
   	}
    $(document).bind("mousemove", function(e){
      $("#gameThumbnail").css({
        left:  e.pageX+10,
        top:   e.pageY+10
      });
    });

    $(document).ready(function(){
   	  $("#gameThumbnail").hide();
      $("table tbody tr").mouseover(function() {
      	proceedHidingThumbnail = false;
	    if( lastMouseOverId != $(this).attr("id") )
	    {
    	  lastMouseOverId = $(this).attr("id");
          $("#gameThumbnail").html( "Loading Thumbnail..." );
      	  $("#gameThumbnail").show();
          $.ajax({
            url: "getThumbnail.php?id=" + $(this).attr("id"),
            type: "GET",	
            success: function (text) {
              $("#gameThumbnail").html( text );
              
              if( text == "" )
              {
              	$("#gameThumbnail").hide();
           	  }
            }
            });
        }
      }).mouseout(function() {
      	proceedHidingThumbnail = true;
      	setTimeout("hideThumbnail()", 50);
      });
    });
  </script>
  ';
  
	function getSortLinkString( $field )
	{
		$order = "asc";
		
		if( !empty( $_GET[ "sortBy" ] ) )
		{
			if( $_GET[ "sortBy" ] == $field )
			{
				if( $_GET[ "sortOrder" ] == "asc" )
				{
					$order = "desc";
				}
			}
		}
		
		return "?sortBy=" . $field . "&sortOrder=" . $order;
	}

    include('./templates/header.php');
    
?>
	<div id="gameThumbnail" style="position:absolute;border:1px solid #ccc;padding:10px;background-color:#fff;">
		Loading Thumbnail...
	</div>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th><a href="<?php echo getSortLinkString( "gameobjectId" )?>">#</a></th>
                <th><a href="<?php echo getSortLinkString( "gamename" )?>">Name</a></th>
                <th><a href="<?php echo getSortLinkString( "molyjamlocation" )?>">Location</a></th>
                <th>Popularity</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach ($GameList as $Game)
    {
        $Popularity = ($Game->PageViews * 0.01) + ($Game->Downloads * 1);
?>
            <tr class="gameRow" id="<?php echo $Game->gameobjectId ?>">
                <td><?php echo $Game->gameobjectId ?></td>
                <td><a href="display.php?GameObjectID=<?php echo $Game->gameobjectId ?>"><?php echo $Game->GameName ?></a></td>
                <td><?php echo $Game->MolyJamLocation ?></td>
                <td><?php echo $Popularity ?></td>
                <td><?php echo $Game->CreatedDateTime ?></td>
            </tr>
<?php
    }
?>
        </tbody>
    </table>

<?php
    include('./templates/footer.php');
?>