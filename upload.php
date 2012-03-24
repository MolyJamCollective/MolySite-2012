<?php
    include('./objects/class.game.php');
    
    if($_POST["GamePictureURL"] == "")
        $_POST["GamePictureURL"] = "#";
        
    if($_POST["GameFilesURL"] == "")
        $_POST["GameFilesURL"] = "#";
        
    if($_POST["TeamPictureURL"] == "")
        $_POST["TeamPictureURL"] = "#";
        
    if($_POST["GameVideoURL"] == "")
        $_POST["GameVideoURL"] = "#";
    
    $Game = new Game($_POST["GameName"], $_POST["GamePictureURL"], $_POST["GameTweet"], $_POST["GameDescription"], $_POST["GameFilesURL"], $_POST["GameVideoURL"], $_POST["MolyJamLocation"], $_POST["TeamPictureURL"], $_POST["TeamMember"], $_POST["GameLicense"], "0", "0", "0", "0", "0");
    
    include('./templates/globals.php'); 
    
    $pageTitle = 'MolyJam Game Submission System';
    $pageHeader = 'MolyJam Game Submission System';

    include('./templates/header.php');
?>
    <section id="Game" class="well">
      <div class="page-header">
          <h1><?php echo $Game->GameName; ?></h1>
        </div>
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
                <a href="<?php echo $Game->GameVideo; ?>" class="btn btn-large btn-primary">Gameplay Video</a> <a href="<?php echo $Game->GameFile; ?>" class="btn btn-large btn-primary">Download Game</a>
              </div>
            </div>
            
            <div class="span5 offset1">
              <a href="http://placehold.it/800x600" class="thumbnail">
                <img src="http://placehold.it/800x600" alt="Game Photo">
              </a>
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
              <a href="http://placehold.it/800x600" class="thumbnail">
                <img src="http://placehold.it/800x600" alt="Team Photo">
              </a>
            </div>
          </div>
    </section>
    <div align="center" class="span12">
      <a href="./display.php" class="btn btn-large btn-success">Confirm</a> <a href="./Edit.php" class="btn btn-large btn-primary">Edit</a>
    </div>
    <br />
    
<?php
    include('./templates/footer.php');
?>