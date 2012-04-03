<?php
// ------------- Start Functions

function str_insert($insertstring, $intostring, $offset) {
   $offset = strlen($intostring) - $offset;
   $part1 = substr($intostring, 0, $offset);
   $part2 = substr($intostring, $offset);
  
   $part1 = $part1 . $insertstring;
   $whole = $part1 . $part2;
   return $whole;
}

function GetThumbnailFilename( $file )
{
    return pathinfo( $file, PATHINFO_DIRNAME ) . "/" . pathinfo( $file, PATHINFO_FILENAME ) . "_thumb." . pathinfo( $file, PATHINFO_EXTENSION );
}

function CreateThumbnail( $tmpName, $targetPath )
{
    $tsize = getImageSize( $tmpName );
    $twidth = "320";
    $theight = (($tsize[1] / $tsize[0]) * $twidth);
    
    //resize thumb image
    $tsrc = "";
    
    if( pathinfo( $targetPath, PATHINFO_EXTENSION ) == "png" )
    {
        $tsrc = imagecreatefrompng( $tmpName );
    }
    else
    {
        $tsrc = imagecreatefromjpeg( $tmpName );
    }		
    
    $tdst = imagecreatetruecolor($twidth,$theight);
    imagecopyresampled($tdst, $tsrc, 0, 0, 0, 0, $twidth, $theight, $tsize[0], $tsize[1]);
    
    //save resized thumb image
    $tfinfile = $targetPath;
    echo $targetPath;
    
    if( pathinfo( $targetPath, PATHINFO_EXTENSION ) == "png" )
    {
            imagepng($tdst, $tfinfile, 5);
    }
    else
    {
            imagejpeg($tdst, $tfinfile, 95);
    }
}

// ------------- End Functions

    include_once("./configuration.php");
    include_once("./objects/class.database.php");
    include_once("./objects/class.game.php");
    include_once("./objects/class.ftp.php");
    include_once("./objects/class.phpmailer.php");
    include_once("./utility/sendConfirmationEmail.php");    
    
    $Game = new Game();
    
    if($_POST['GameName'] != "" || !empty($_GET['EditID']) ) // If the game has valid data
    {
        if(!empty($_GET['EditID'])) // Edited Game
        {
            //Echo '<h2 style="color: red;">Trying to edit the game?</h2>';
            
            $Game = $Game->GetFromEditId($_GET[ "EditID" ]);

            if($Game->gameId != "") // If Game Was Found
            {
                $UploadedFile = false;
                $FTP = new ftp();
                
                if(!empty($_POST["GameName"]))
                {
                    $Game->GameName         = $_POST["GameName"];
                }
                    
                if(!empty($_POST["GameTweet"]))
                {
                    $Game->GameTweet        = $_POST["GameTweet"];
                }
                if(!empty($_POST["GameDescription"]))
                {
                    $Game->GameDescription  = $_POST["GameDescription"];
                }
                if(!empty($_POST["GameVideoURL"]))
                {
                    $Game->GameVideoURL     = $_POST["GameVideoURL"];
                }
                if(!empty($_POST["MolyJamLocation"]))
                {
                    $Game->MolyJamLocation  = $_POST["MolyJamLocation"];
                }
                if(!empty($_POST["TeamMember"]))
                {
                    $Game->TeamMembers      = $_POST["TeamMember"];
                }
                if(!empty($_POST["GameLicense"]))
                {
                    $Game->GameLicense      = $_POST["GameLicense"];
                }
                if(!empty($_POST["GameEngine"]))
                {
                    $Game->GameEngine       = $_POST["GameEngine"];
                }
                
                
// -------- Start Upload Game Files                
                if($_FILES[ "GameFiles" ][ "name" ] != "") // Posted Game File
                {
                    //$FTP->delete( $Game->GameFileURL );
                    
                    $target_path = $GLOBALS['configuration']['upload_dir'] . $Game->gameId . "/game.zip"; 
                
                    if( move_uploaded_file( $_FILES[ "GameFiles" ][ "tmp_name" ], $target_path ) ) // Temp Upload Success
                    {
                        $UploadedFile = true;
                        $Game->GameFileURL = $target_path;
                        Echo '<h2 style="color: green;">Game file uploading has succeeded.</h2>';
                    } 
                    else // Else Upload Failed
                    {
                        Echo '<h2 style="color: red;">Game file uploading has failed.</h2>';
                    }
                }
                elseif( $_POST['GameFilesLink'] != "") // Posted Game Link
                {
                    $Game->GameFileURL = $_POST['GameFilesLink']; 
                }
// -------- End Upload Game Files
// -------- Start Upload Game Picture
                if( !empty( $_FILES[ "GamePicture" ][ "name" ] ) )
                {
                    //$FTP->delete( $Game->GamePictureURL );

                    $target_path = $GLOBALS['configuration']['upload_dir'] . $Game->gameId . "/game." . strtolower( pathinfo( $_FILES[ "GamePicture" ][ "name" ], PATHINFO_EXTENSION ) );
            
                    CreateThumbnail( $_FILES[ "GamePicture" ][ "tmp_name" ], GetThumbnailFilename( $target_path ) );   
                    if( move_uploaded_file( $_FILES[ "GamePicture" ][ "tmp_name" ], $target_path ) )  // Temp Upload Success
                    {
                        $UploadedFile = true;
                        $Game->GamePictureURL = $target_path;
                        Echo '<h2 style="color: green;">Game picture uploading has succeeded.</h2>';
                    } 
                    else
                    {
                        Echo '<h2 style="color: red;">Game picture uploading has failed.</h2>';
                    }
                }	
// -------- End Upload Game Picture
// -------- Start Upload Game Picture
                if( !empty( $_FILES[ "TeamPicture" ][ "name" ] ) )
                {
                    //$FTP->delete( $Game->GamePictureURL );
                    
                    $target_path = $GLOBALS['configuration']['upload_dir'] . $Game->gameId . "/team." . strtolower( pathinfo( $_FILES[ "TeamPicture" ][ "name" ], PATHINFO_EXTENSION ) );
            
                    CreateThumbnail( $_FILES[ "TeamPicture" ][ "tmp_name" ], GetThumbnailFilename( $target_path ) );
                    if( move_uploaded_file( $_FILES[ "TeamPicture" ][ "tmp_name" ], $target_path ) ) 
                    {
                        $UploadedFile = true;
                        $Game->TeamPictureURL = $target_path;
                        Echo '<h2 style="color: green;">Team picture uploading has succeeded.</h2>';
                    } 
                    else
                    {
                        Echo '<h2 style="color: red;">Team picture uploading has failed.</h2>';
                    }
                }	
// -------- End Upload Game Picture

                if($UploadedFile == true)
                {
                    Echo '<h2 style="color: green;">Uploaded file may take several minutes to be reflected on the website.</h2>';
                }
                $Game->Save();
            }
            else // Else EditID/Game was not found
            {
                Echo '<h2 style="color: red;">Edit ID was not found.</h2>';
            }
        }
        elseif($_POST['GameName'] != "") // New Submitted Game
        {
            $UploadedFile = false;
            $FTP = new ftp();
            
            $Game->GameName         = $_POST["GameName"];
            $Game->GameTweet        = $_POST["GameTweet"];
            $Game->GameDescription  = $_POST["GameDescription"];
            $Game->GameVideoURL     = $_POST["GameVideoURL"];
            $Game->MolyJamLocation  = $_POST["MolyJamLocation"];
            $Game->TeamMembers      = $_POST["TeamMember"];
            $Game->GameLicense      = $_POST["GameLicense"];
            $Game->GameEngine       = $_POST["GameEngine"];
            
            if(!$Game->Duplicate()) // If Game is a new Game
            {
                if(!empty($_POST[ "Email" ]))
                {
                    $Game->Save($_POST[ "Email" ]);
                    SendConfirmationEmail( $_POST[ "Email" ], $Game );
                }
                else
                {
                    $Game->Save();
                }
                
                $FTP->mkdir( $GLOBALS['configuration']['upload_dir'].$Game->gameId );
                
// -------- Start Upload Game Files                
                if( $_POST['GameFilesLink'] != "") // Posted Game Link
                {
                    $Game->GameFileURL = $_POST['GameFilesLink']; 
                }
                elseif($_FILES[ "GameFiles" ][ "name" ] != "") // Posted Game File
                {    
                    $target_path = $GLOBALS['configuration']['upload_dir'] . $Game->gameId . "/game.zip"; 
                
                    if( move_uploaded_file( $_FILES[ "GameFiles" ][ "tmp_name" ], $target_path ) ) // Temp Upload Success
                    {
                        $UploadedFile = true;
                        $Game->GameFileURL = $target_path;
                    } 
                    else // Else Upload Failed
                    {
                        Echo '<h2 style="color: red;">Game file uploading has failed.</h2>';
                    }
                }
// -------- End Upload Game Files
// -------- Start Upload Game Picture
                if( !empty( $_FILES[ "GamePicture" ][ "name" ] ) )
                {
                    
                    $target_path = $GLOBALS['configuration']['upload_dir'] . $Game->gameId . "/game." . strtolower( pathinfo( $_FILES[ "GamePicture" ][ "name" ], PATHINFO_EXTENSION ) );
            
                    CreateThumbnail( $_FILES[ "GamePicture" ][ "tmp_name" ], GetThumbnailFilename( $target_path ) );   
                    if( move_uploaded_file( $_FILES[ "GamePicture" ][ "tmp_name" ], $target_path ) )  // Temp Upload Success
                    {
                        $UploadedFile = true;
                        $Game->GamePictureURL = $target_path;         
                    } 
                    else
                    {
                        Echo '<h2 style="color: red;">Game picture uploading has failed.</h2>';
                    }
                }	
// -------- End Upload Game Picture
// -------- Start Upload Game Picture
                if( !empty( $_FILES[ "TeamPicture" ][ "name" ] ) )
                {
                    $target_path = $GLOBALS['configuration']['upload_dir'] . $Game->gameId . "/team." . strtolower( pathinfo( $_FILES[ "TeamPicture" ][ "name" ], PATHINFO_EXTENSION ) );
            
                    CreateThumbnail( $_FILES[ "TeamPicture" ][ "tmp_name" ], GetThumbnailFilename( $target_path ) );   
                    if( move_uploaded_file( $_FILES[ "TeamPicture" ][ "tmp_name" ], $target_path ) ) 
                    {
                        $UploadedFile = true;
                        $Game->TeamPictureURL = $target_path;
                    } 
                    else
                    {
                        Echo '<h2 style="color: red;">Team picture uploading has failed.</h2>';
                    }
                }	
// -------- End Upload Game Picture
                
                $Game->Save();
            }
            else // Else page might have been refreshed
            {
                //Echo '<h2 style="color: red;">Was the page refreshed?</h2>';
                $Game = $Game->GetDuplicate();
            }
        }
    }
    else // Invalied data
    {
        Echo '<h2 style="color: red;">Invalid Data</h2>';
    }
    
    include_once('./templates/globals.php'); 
    
    $pageTitle = 'MolyJam Game Submission System';
    $pageHeader = 'MolyJam Game Submission System';
    $activeTab = '5';

    include_once('./templates/header.php');
    
    if( $Game->gameId != "" ) // If the game was created/edited correctly
    {
    	$cache->deleteCachedFile( "archive", true );
   		$cache->deleteCachedFile( "display.GameID." . $Game->gameId, true );
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
                <img src="' . str_insert('_thumb',$Game->GamePictureURL,4) . '" alt="Game Photo">
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
        <p><strong>Game License:</strong> <?php echo $Game->GameEngine; ?></p>
      </div>
    </div>
    <div class="span5 offset1">
      <?php if($Game->TeamPictureURL != "")
                echo '
              <a href="' . $Game->TeamPictureURL . '" class="thumbnail">
                <img src="' . str_insert('_thumb',$Game->TeamPictureURL,4) . '" alt="Team Photo">
              </a> '; ?>
    </div>
  </div>
</section>
<div align="center" class="span12"> <a href="./display.php?GameID=<?php echo $Game->gameId; ?>" class="btn btn-large btn-success">Confirm</a> <a href="./submit.php?EditID=<?php echo $Game->EditID; ?>" class="btn btn-large btn-primary">Edit</a> </div>
<br />
<?php
    include_once('./templates/footer.php');
?>
