<?php
    include_once("./configuration.php");
    include_once("./objects/class.database.php");
    include_once("./objects/class.gameobject.php");
    
    if($_POST["GamePictureURL"] == "")
        $_POST["GamePictureURL"] = "#";
        
    if($_POST["GameFilesURL"] == "")
        $_POST["GameFilesURL"] = "#";
        
    if($_POST["TeamPictureURL"] == "")
        $_POST["TeamPictureURL"] = "#";
        
    if($_POST["GameVideoURL"] == "")
        $_POST["GameVideoURL"] = "#";
    
    $Game = new GameObject($_POST["GameName"], $_POST["GamePictureURL"], $_POST["GameTweet"], $_POST["GameDescription"], $_POST["GameFilesURL"], $_POST["GameVideoURL"], $_POST["MolyJamLocation"], $_POST["TeamPictureURL"], $_POST["TeamMember"], $_POST["GameLicense"], "0", "0", "0", "0", "0");
    $Game->Save();
    
    include('./templates/globals.php'); 
    
    $pageTitle = 'MolyJam Game Submission System';
    $pageHeader = 'MolyJam Game Submission System';

    include('./templates/header.php');
    
    if( !empty( $_POST[ "GameName" ] ) )
    {
    	//Submit Project
    	
    	if( !empty( $_FILES[ "GameFiles" ][ "name" ] ) ) //Save file
    	{
			$target_path = "/path/to/dir/" . basename( $_FILES[ "GameFiles" ][ "name" ] ); 

			if( move_uploaded_file( $_FILES[ "GameFiles" ][ "tmp_name" ], $target_path ) ) 
			{
			    //success
			} 
			else
			{
			    //fail
			}
   		}
   	}
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
                <a href="<?php echo $Game->GameVideoURL; ?>" class="btn btn-large btn-primary <?php if($Game->GameVideoURL == "#"){echo "disabled";}?>">Gameplay Video</a> <a href="<?php echo $Game->GameFilesURL; ?>" class="btn btn-large btn-primary <?php if($Game->GameFilesURL == "#"){echo "disabled";}?>">Download Game</a>
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
    <div align="center" class="span12">
      <a href="./display.php?GameObjectID=<?php echo $Game->gameobjectId; ?>" class="btn btn-large btn-success">Confirm</a> <a href="./edit.php?EditID=<?php echo $Game->EditID; ?>" class="btn btn-large btn-primary">Edit</a>
    </div>
    <br />
    
<?php
    include('./templates/footer.php');
?>