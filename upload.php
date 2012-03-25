<?php
    include_once("./configuration.php");
    include_once("./objects/class.database.php");
    include_once("./objects/class.gameobject.php");
    include_once("./objects/class.ftp.php");
    
    $Game = new GameObject();
   	
    if( !empty( $_GET[ "EditID" ] ) )
    {
    	$Game->GetFromEditId( $_GET[ "EditID" ] );
        if($Game->gameobjectId == "")
        {
            // Edit ID not Found
        }
    }
        
    $Game->GameName         = $_POST["GameName"];
    $Game->GameTweet        = $_POST["GameTweet"];
    $Game->GameDescription  = $_POST["GameDescription"];
    $Game->GameVideoURL     = $_POST["GameVideoURL"];
    $Game->MolyJamLocation  = $_POST["MolyJamLocation"];
    $Game->TeamMembers      = $_POST["TeamMember"];
    $Game->GameLicense      = $_POST["GameLicense"];
    
    if(!empty($_POST[ "Email" ]))
    {
        $Game->Save($_POST[ "Email" ]);
    }
    else
    {
        $Game->Save();
    }
    
    $ftp = new ftp();
    if( empty( $_GET[ "EditID" ] ) )
    {
	$ftp->mkdir( $GLOBALS['configuration']['upload_dir'].$Game->gameobjectId );
	//$ftp->chmod( $GLOBALS['configuration']['upload_dir'].$Game->gameobjectId, 0777);
    }
    
    $uploadedFile = false;
    
    if( !empty( $_FILES[ "GameFiles" ][ "name" ] ) ) //Save file
    {
	if( $Game->GameFileURL != "" )
	{
	    $ftp->delete( $Game->GameFileURL );
	}
		
	$target_path = $GLOBALS['configuration']['upload_dir'] . $Game->gameobjectId . "/game.zip"; 

	if( move_uploaded_file( $_FILES[ "GameFiles" ][ "tmp_name" ], $target_path ) ) 
	{
	    //success
	    $uploadedFile = true;
	    $Game->GameFileURL = $target_path;
	} 
	else
	{
	    //fail
	}
    }
	
    if( !empty( $_FILES[ "GamePicture" ][ "name" ] ) ) //Save file
    {
        if( $Game->GamePictureURL != "" )
        {
                $ftp->delete( $Game->GamePictureURL );
        }
        
        $target_path = $GLOBALS['configuration']['upload_dir'] . $Game->gameobjectId . "/game." . strtolower( pathinfo( $_FILES[ "GamePicture" ][ "name" ], PATHINFO_EXTENSION ) );

        if( move_uploaded_file( $_FILES[ "GamePicture" ][ "tmp_name" ], $target_path ) ) 
        {
            //success
            $uploadedFile = true;
            $Game->GamePictureURL = $target_path;
        } 
        else
        {
            //fail
        }
    }	
	
    if( !empty( $_FILES[ "TeamPicture" ][ "name" ] ) ) //Save file
    {
        if( $Game->TeamPictureURL != "" )
        {
                $ftp->delete( $Game->TeamPictureURL );
        }
        
        $target_path = $GLOBALS['configuration']['upload_dir'] . $Game->gameobjectId . "/team." . strtolower( pathinfo( $_FILES[ "TeamPicture" ][ "name" ], PATHINFO_EXTENSION ) );

        if( move_uploaded_file( $_FILES[ "TeamPicture" ][ "tmp_name" ], $target_path ) ) 
        {
            //success
            $uploadedFile = true;
            $Game->TeamPictureURL = $target_path;
        } 
        else
        {
            //fail
        }
    }
    
     $Game->Save();
    
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
      <?php if(empty($Game->GameVideoURL))  { ?>
            <button href="#" target="_blank" class="btn btn-large btn-primary disabled">Gameplay Video</button>
      <?php } else { ?>
            <a href="<?php echo $Game->GameVideoURL; ?>" target="_blank" class="btn btn-large btn-primary">Gameplay Video</a>
      <?php } ?>
      
      <?php if(empty($Game->GameFileURL))  { ?>
            <button href="#" target="_blank" class="btn btn-large btn-primary disabled">Download Game</button>
      <?php } else { ?>
            <a href="<?php echo $Game->GameFileURL; ?>" target="_blank" class="btn btn-large btn-primary">Download Game</a>
      <?php } ?>
      </div>
    </div>
    <div class="span5 offset1">
      <?php if($Game->GamePictureURL != "")
                echo '
              <a href="' . $Game->GamePictureURL . '" class="thumbnail">
                <img src="' .$Game->GamePictureURL . '" alt="Game Photo">
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
<div align="center" class="span12"> <a href="./display.php?GameObjectID=<?php echo $Game->gameobjectId; ?>" class="btn btn-large btn-success">Confirm</a> <a href="./submit.php?EditID=<?php echo $Game->EditID; ?>" class="btn btn-large btn-primary">Edit</a> </div>
<br />
<?php
    include('./templates/footer.php');
?>
