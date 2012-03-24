<?php
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
          <h1><?php echo $_POST["GameName"]; ?></h1>
        </div>
          <div class="thumbnails">
            <div class="span5">
              <h3>Description</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ornare, lacus eget congue mattis, nisi purus luctus est, in dapibus neque risus at eros. Suspendisse rutrum pellentesque hendrerit. Integer quis mauris dui. Vestibulum ut convallis ipsum. Curabit</p>
              
              <br />
              <br />
              <br />
              
              <h3>Moly*eux Inspirational Tweet</h3>
              <div class="well">
                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ornare, lacus eget congue mattis, nisi purus luctus est, in dapibus neque risus."</p>
              </div>
              
              <br />
              
              <div align="center">
                <a href="http://www.YouTube.com" target="_blank" class="btn btn-large btn-primary">Gameplay Video</a> <a href="http://www.YouTube.com" class="btn btn-large btn-primary">Download Game</a>
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
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ornare, lacus eget congue mattis, nisi purus luctus est, in dapibus neque risus at eros. Suspendisse rutrum pellentesque hendrerit. Integer quis mauris dui. Vestibulum ut convallis ipsum. Curabit</p>
  
              <br />
              <br />
              
              <div class="footer">
                <p><strong>Jam Location:</strong> <?php echo $_POST['MolyJamLocation']; ?></p>
                <p><strong>Game License:</strong> <?php echo $_POST['GameLicense']; ?></p>
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