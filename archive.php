<?php
    // TODO:: Hover over game for image popup
    // TODO:: Click Row for Display

    include_once("./templates/include.php");
    include_once("./objects/class.game.php");

    $Game = new Game(); //create a book object
    
    
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
   	
   	function createSearchArray()
   	{
   		$searchValues = array();
   		
   		if( getSearchString() != "" )
   		{
   			$words = explode( " ", getSearchString() );
   			
   			foreach( $words as $word )
   			{
   				$newSearchValue = array( "gamename", "LIKE", "%".$word."%" );
   				$searchValues[] = $newSearchValue;
   				
   				$newSearchValue = array( "gametweet", "LIKE", "%".$word."%" );
   				$searchValues[] = $newSearchValue;
   				
   				$newSearchValue = array( "gamedescription", "LIKE", "%".$word."%" );
   				$searchValues[] = $newSearchValue;
   				
   				$newSearchValue = array( "molyjamlocation", "=", $word );
   				$searchValues[] = $newSearchValue;
			}
		}
		
   		return $searchValues;
	}
    
    $GameList = $Game->GetList(createSearchArray(), $sortBy, $sortOrder);
    
    include_once('./templates/globals.php');
    
    $pageTitle = 'MolyJam Game Archive System';
    $pageHeader = 'MolyJam Game Archive System';
    $pageStyles = array();
    $activeTab = '4';

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
      $("table tbody tr").mouseover(function(e) {
      	proceedHidingThumbnail = false;
	    if( lastMouseOverId != $(this).attr("id") )
	    {
    	  lastMouseOverId = $(this).attr("id");
          $("#gameThumbnail").html( "Loading Thumbnail..." );
      	  $("#gameThumbnail").show();
      	  $("#gameThumbnail").css({
            left:  e.pageX+10,
            top:   e.pageY+10
          });
          $.ajax({
            url: "./utility/getThumbnail.php?id=" + $(this).attr("id"),
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
  
	function getSortLinkString( $field, $startWithDesc = false )
	{
		$order = ( $startWithDesc ) ? "desc" : "asc";
		
		if( !empty( $_GET[ "sortBy" ] ) )
		{
			if( $_GET[ "sortBy" ] == $field )
			{
				if( $_GET[ "sortOrder" ] == "asc" )
				{
					$order = "desc";
				}
				else
				{
					$order = "asc";
				}
			}
		}
		
		$searchString = "";
		if( getSearchString() != "" )
		{
			$searchString = "&search=" . urlencode( getSearchString() );
		}
		
		return "?sortBy=" . $field . "&sortOrder=" . $order . $searchString;
	}
	
	function getSearchString()
	{
		if( !empty( $_POST[ "searchString" ] ) )
		{
			return $_POST[ "searchString" ];
		}
		
		if( !empty( $_GET[ "search" ] ) )
		{
			return urldecode( $_GET[ "search" ] );
		}
		
		return "";
	}
	
	function getSortImage( $field )
	{
		if( !empty( $_GET[ "sortBy" ] ) )
		{
			if( $_GET[ "sortBy" ] == $field )
			{
				if( $_GET[ "sortOrder" ] == "asc" )
				{
					return "<img src='img/sortAsc.png' alt='Sort Ascending' />";
				}
				else
				{
					return "<img src='img/sortDesc.png' alt='Sort Descending' />";
				}
			}
		}
		
		return "";
	}

    include_once('./templates/header.php');
?>
<div class="row-fluid">
    <div class="span12">
        <div id="gameThumbnail" style="position:absolute;border:1px solid #ccc;padding:10px;background-color:#fff;display:none;color:#000;">
            Loading Thumbnail...
        </div>
        <form action="?" method="POST">
            <input type="text" name="searchString" style="position:relative;top:5px;" /> <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <?php if( getSearchString() != "" ): ?>
            <h2>Searching for <i><?php echo getSearchString(); ?></i></h2>
        <?php endif; ?>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="50"><a href="<?php echo getSortLinkString( "gameId" )?>"># <?php echo getSortImage( "gameId" ); ?></a></th>
                <th><a href="<?php echo getSortLinkString( "gamename" )?>">Name <?php echo getSortImage( "gamename" ); ?></a></th>
                <th width="150"><a href="<?php echo getSortLinkString( "molyjamlocation" )?>">Location <?php echo getSortImage( "molyjamlocation" ); ?></a></th>
                <th width="300"><a href="<?php echo getSortLinkString( "createddatetime" )?>">Created <?php echo getSortImage( "createddatetime" ); ?></a></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($GameList as $Game) { $Popularity = ($Game->PageViews * 0.01) + ($Game->Downloads * 1); ?>
            <tr class="gameRow" id="<?php echo $Game->gameId ?>">
                <td><?php echo $Game->gameId ?></td>
                <td><a href="display.php?GameID=<?php echo $Game->gameId ?>"><?php echo $Game->GameName ?></a></td>
                <td><a href="?search=<?php echo $Game->MolyJamLocation ?>"><?php echo $Game->MolyJamLocation ?></a></td>
                <td><?php echo $Game->CreatedDateTime ?></td>
            </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</div>

    

<?php
    include_once('./templates/footer.php');
?>