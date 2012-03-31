<?php
  include_once("./configuration.php");
  include_once("./objects/class.database.php");
  include_once("./objects/class.game.php");

  $Game = new Game();
  $Game->Get($_GET['GameID']);

  include_once('./templates/globals.php');
    
  $pageTitle = $Game->GameName;
  $pageHeader = $Game->GameName;
  $activeTab = '2';
  
  if( !empty( $_GET[ "download" ] ) && $Game->GameFileURL != "" )
  {
  	echo "<meta http-equiv='refresh' content='0; url=". $Game->GameFileURL . "' />"; 
  }

  include_once('./templates/header.php');
  
  
  
  if($Game->GameName != "")
  {
  	$updateDownloadCounter = "";
  	
  	if( !empty( $_GET[ "download" ] ) && ($Game->GameFileURL != "" && $Game->GameFileURL != "#" ))
  	{
  		$updateDownloadCounter = ", `downloads`=`downloads` + 1";
	}
    
    $connection = Database::Connect();
    $query = "UPDATE `game` SET `pageviews`=`pageviews` + 1" . $updateDownloadCounter . " WHERE `gameid`='".$Game->gameId."'";
    Database::InsertOrUpdate($query, $connection);
    
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
                              <p><?php echo $Game->GameDescription; ?></p>
                              
                              <br />
                              <br />
                              <br />
                              
                              <h3>Moly*eux Inspirational Tweet</h3>
                              <div class="well">
                                    <p>"<?php echo $Game->GameTweet; ?>"</p>
                              </div>
                              
                              <br />
                              
                              <div align="center">
				<?php if($Game->GameVideoURL == "") { ?>
				  <button class="btn btn-large btn-primary disabled">Gameplay Video</button>
				<?php } else { ?>
				  <a href="<?php echo $Game->GameVideoURL; ?>" target="_blank" class="btn btn-large btn-primary">Gameplay Video</a>
				<?php } ?>
				
				<?php if($Game->GameVideoURL == "") { ?>
				  <button class="btn btn-large btn-primary disabled">Download Game</button>
				<?php } else { ?>
				  <a href="./display.php?GameID=<?php echo $_GET[ "GameID" ]; ?>&download=true" class="btn btn-large btn-primary">Gameplay Video</a>
				<?php } ?>
                              </div>
                        </div>
                        <div class="span5 offset1">
                              <?php if($Game->GamePictureURL != "")echo '<a href="' . $Game->GamePictureURL . '" class="thumbnail"><img src="' . $Game->GamePictureURL . '" alt="Game Photo"></a> '; ?>
                        </div>
                        
                        <br />
                        <br />
                  </div>
                  
                  <br />
                  <br />
            
                  <div class="thumbnails">
                        <div class="span5">
                              <h3>Team Members</h3>
                              <p><?php echo $Game->TeamMembers; ?></p>
        
                              <br />
                              <br />
                              <div class="footer">
                                    <p><strong>Jam Location:</strong> <?php echo $Game->MolyJamLocation; ?></p>
                                    <p><strong>Game License:</strong> <?php echo $Game->GameLicense; ?></p>
				    <p><strong>Game Engine:</strong> <?php echo $Game->GameEngine; ?></p>
                              </div>
                        </div>
                        <div class="span5 offset1">
                              <?php if($Game->TeamPictureURL != "") echo '<a href="' . $Game->TeamPictureURL . '" class="thumbnail"><img src="' . $Game->TeamPictureURL . '" alt="Team Photo"></a> '; ?>
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