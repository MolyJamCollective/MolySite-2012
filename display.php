<?php
  include_once("./configuration.php");
  include_once("./objects/class.database.php");
  include_once("./objects/class.game.php");

  $Game = new GameObject();
  $Game->Get($_GET['GameObjectID']);

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
  	
  	if( !empty( $_GET[ "download" ] ) && $Game->GameFileURL != "" )
  	{
  		$updateDownloadCounter = ", `downloads`=`downloads` + 1";
    }
    
    $connection = Database::Connect();
    $query = "UPDATE `game` SET `pageviews`=`pageviews` + 1" . $updateDownloadCounter . " WHERE `gameid`='".$Game->gameId."'";
    Database::InsertOrUpdate($query, $connection);
  		
?>
	<p><a href="archive.php">Back to Games</a></p>
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
                <a href="<?php echo $Game->GameVideoURL; ?>" target="_blank" class="btn btn-large btn-primary <?php if($Game->GameVideoURL == ""){echo "disabled";}?>">Gameplay Video</a> <a href="display.php?GameObjectID=<?php echo $_GET[ "GameObjectID" ]; ?>&download=true" class="btn btn-large btn-primary <?php if($Game->GameFileURL == ""){echo "disabled";}?>">Download Game</a>
              </div>
            </div>
            
            <div class="span5 offset1">
             <?php if($Game->GamePictureURL != "")
                echo '
              <a href="' . $Game->GamePictureURL . '" class="thumbnail">
                <img src="' . $Game->GamePictureURL . '" alt="Game Photo">
              </a> '; ?>
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
              </div>
            </div>
            
            <div class="span5 offset1">
            <?php if($Game->TeamPictureURL != "")
                echo '
              <a href="' . $Game->TeamPictureURL . '" class="thumbnail">
                <img src="' . $Game->TeamPictureURL . '" alt="Team Photo">
              </a> '; ?>
            </div>
          </div>
    </section>
    <p><a href="archive.php">Back to Games</a></p>
<?php
  }
  else
  {
?>
      <h2>Game Not Found</h2>
<?php
  }

  include_once('./templates/footer.php');
?>