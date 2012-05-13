<?php
function str_insert($insertstring, $intostring, $offset) {
   $offset = strlen($intostring) - $offset;
   $part1 = substr($intostring, 0, $offset);
   $part2 = substr($intostring, $offset);
  
   $part1 = $part1 . $insertstring;
   $whole = $part1 . $part2;
   return $whole;
}

  include_once("./templates/include.php");
  include_once("./objects/class.game.php");
  include_once("./objects/class.greenPixel.php");
  
  if( is_numeric( $_GET['GameID'] ) == false )
  {
  	die( "Do you think that is what Moly would deux?" );
  }
 	
  $gameId = mysql_escape_string( $_GET['GameID'] );
  $Game = new Game();
  $Game->Get($gameId);

  include_once('./templates/globals.php');
    
  $pageTitle = $Game->GameName;
  $pageHeader = $Game->GameName;
  $activeTab = '4';
  
  $pageStyles = array('./css/validationEngine.jquery.css');
    
    $pageScripts = array('./js/jquery.validationEngine.js','./js/jquery.validationEngine-en.js','./js/other-validations.js');
    $PageScriptsRaw ='
  <script>
    $(document).ready(function(){
      $("#SendGreenPixel").validationEngine();
      $("#GreenPixelMessage").keydown(function() {
		  $("#pixelChars").html( 140 - $(this).val().length - 1 );
		});
    });
    
    function checkGreenPixel(field, rules, i, options)
	  {
        if ( field.val().length > 140 ) 
		{
          return "Please only use 140 characters";
        }
      }
  </script>';
  
  if( !empty( $_GET[ "download" ] ) && $Game->GameFileURL != "" )
  {
  	echo "<meta http-equiv='refresh' content='0; url=". $Game->GameFileURL . "' />"; 
  	
  	if( empty( $_SESSION[ "download" ][ $Game->gameId ] ) )
  	{
	  	$connection = Database::Connect();
	    $query = "UPDATE `game` SET `downloads`=`downloads` + 1 WHERE `gameid`='".$Game->gameId."'";
	    Database::InsertOrUpdate($query, $connection);
	    
	    $_SESSION[ "download" ][ $Game->gameId ] = true;
    }
  }
  else
  {
  	if( empty( $_SESSION[ "view" ][ $Game->gameId ] ) )
  	{
	  	$connection = Database::Connect();
	    $query = "UPDATE `game` SET `pageviews`=`pageviews` + 1 WHERE `gameid`='".$Game->gameId."'";
	    Database::InsertOrUpdate($query, $connection);
	    
	    $_SESSION[ "view" ][ $Game->gameId ] = true;
    }
  }
  
  if( !empty( $_GET[ "sendPixel" ] ) )
  {
	$pixel = new GreenPixel( $Game->gameId, mysql_escape_string( $_POST["GreenPixelMessage" ] ) );
	$pixel->Save();
  }

  include_once('./templates/header.php');
  
  
  
  if($Game->GameName != "")
  {
  	$updateDownloadCounter = "";
 	
?>
<div class="row-fluid">
      <div class="span1">&nbsp;</div>
      <div class="span10">
            <p class="pull-right"><a href="archive.php">Back to Games</a></p>
      </div>
</div>
<div class="row-fluid">
      <div class="span1">&nbsp;</div>
      <div class="span10">
            <section id="Game">
                  <div class="thumbnails">
                        <div class="span5">
                              <h3>Description</h3>
                              <p><?php echo nl2br( $Game->GameDescription ); ?></p>
                              
                              <br />
                              <br />
                              <br />
                              
                              <h3>Moly*eux Inspirational Tweet</h3>
                              <div class="well">
                                    <p>"<?php echo nl2br( $Game->GameTweet ); ?>"</p>
                              </div>
                              
                              <br />
                              
                              <div align="center">
				<?php if($Game->GameVideoURL == "") { ?>
				  <button class="btn btn-large btn-primary disabled">Gameplay Video</button>
				<?php } else { ?>
				  <a href="<?php echo $Game->GameVideoURL; ?>" target="_blank" class="btn btn-large btn-primary">Gameplay Video</a>
				<?php } ?>
				
				<?php if($Game->GameFileURL == "") { ?>
				  <button class="btn btn-large btn-primary disabled">Download Game</button>
                  <?php if($Game->Downloads > 0) { ?>
                    <br /><span style="text-align:left;color:#c22e2e">The game files for this entry are still lost. If you know the developer, please send him to this <a href="http://www.whatwouldmolydeux.com/?p=25" target="_blank">blog post</a>.</span>
                  <?php } ?>
				<?php } else { ?>
				  <a href="./display.php?GameID=<?php echo $_GET[ "GameID" ]; ?>&download=true" class="btn btn-large btn-primary">Download Game</a>
				<?php } ?>
                
                              </div>
                        </div>
                        <div class="span5 offset1">
                              <?php if($Game->GamePictureURL != "")echo '<a href="' . $Game->GamePictureURL . '" class="thumbnail"><img src="' . str_insert('_thumb',$Game->GamePictureURL,4) . '" alt="Game Photo"></a> '; ?>
                        </div>
                        
                        <br />
                        <br />
                  </div>
                  
                  <br />
                  <br />
            
                  <div class="thumbnails">
                        <div class="span5">
                              <h3>Team Members</h3>
                              <p><?php echo nl2br( $Game->TeamMembers ); ?></p>
        <br />
                  <br />
        						<h3>Send a Green Pixel to the devs</h3>
        						<?php if( empty( $_GET[ "sendPixel" ] ) ): ?>
                              <form id="SendGreenPixel" class="form-horizontal" action="?GameID=<?php echo $Game->gameId; ?>&sendPixel=true" method="POST">
                              <textarea class="input-xlarge validate[required,funcCall[checkGreenPixel]]" id="GreenPixelMessage" name="GreenPixelMessage" rows="3" style="width:370px;" maxlength="250" ></textarea>
                              <button type="submit" class="btn btn-primary">Send</button> <div id="pixelChars" style="display:inline-block;font-weight:bold;font-size:16px;position:relative;top:2px;margin-left:10px;">140</div>
                              </form>
                              <?php else: ?>
                              	<img src="img/greenPixel.jpg" alt="Green Pixel" /> <b>Your message has been sent.</b>
                              <?php endif; ?>
                              <div class="footer">
                                    <p><strong>Jam Location:</strong> <?php echo $Game->MolyJamLocation; ?></p>
                                    <p><strong>Game License:</strong> <?php echo $Game->GameLicense; ?></p>
				    <p><strong>Game Engine:</strong> <?php echo $Game->GameEngine; ?></p>
                              </div>
                        </div>
                        <div class="span5 offset1">
                              <?php if($Game->TeamPictureURL != "") echo '<a href="' . $Game->TeamPictureURL . '" class="thumbnail"><img src="' . str_insert('_thumb',$Game->TeamPictureURL,4) . '" alt="Team Photo"></a> '; ?>
                        </div>
                  </div>
            </section>
      </div>
</div>
<div class="row-fluid">
      <div class="span1">&nbsp;</div>
      <div class="span10">
            <p class="pull-right"><a href="archive.php">Back to Games</a></p>
      </div>
</div>
<?php } else { ?>
      <div class="row-fluid">
      <div class="span1">&nbsp;</div>
      <div class="span10">
            <center><h1>Game Not Found...</h1></center>
      </div>
</div>
<?php } include_once('./templates/footer.php'); ?>