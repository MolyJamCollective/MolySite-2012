<?php
  include_once("./configuration.php");
  include_once("./objects/class.database.php");
  include_once("./objects/class.gameobject.php");

  $Game = new GameObject();
  $Game->Get($_GET['GameObjectID']);
  
  include('./templates/globals.php');
    
  $pageTitle = $Game->GameName;
  $pageHeader = $Game->GameName;

  include('./templates/header.php');
  
  
  
  if($Game->GameName != "")
  {
?>
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
                <a href="<?php echo $Game->GameVideoURL; ?>" class="btn btn-large btn-primary <?php if($Game->GameVideoURL == "#"){echo "disabled";}?>">Gameplay Video</a> <a href="<?php echo $Game->GameFileURL; ?>" class="btn btn-large btn-primary <?php if($Game->GameFileURL == "#"){echo "disabled";}?>">Download Game</a>
              </div>
            </div>
            
            <div class="span5 offset1">
             <?php if($Game->GamePictureURL != "#")
                echo '
              <a href="<?php echo $Game->GamePictureURL; ?>" class="thumbnail">
                <img src="<?php echo $Game->GamePictureURL; ?>" alt="Game Photo">
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
            <?php if($Game->TeamPictureURL != "#")
                echo '
              <a href="<?php echo $Game->TeamPictureURL; ?>" class="thumbnail">
                <img src="<?php echo $Game->TeamPictureURL; ?>" alt="Team Photo">
              </a> '; ?>
            </div>
          </div>
    </section>
    
<?php
  }
  else
  {
?>
      <h2>Game Not Found</h2>
<?php
  }

  include('./templates/footer.php');
?>