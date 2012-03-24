<?php
    include('./templates/globals.php');
    
    $pageTitle = 'MolyJam Game Submission System';
    $pageHeader = 'MolyJam Game Submission System';
    
    $pageScripts = array();

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

      <form id="GameSubmission" class="form-horizontal" action="./upload.php" method="post" enctype="multipart/form-data">
        <fieldset>
          
          <div class="control-group error">
            <label class="control-label" for="GameName">Name*</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="GameName" name="GameName" maxlength="250" />
              <p class="help-block">The Name of your Game</p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="GamePicture">Picture</label>
            <div class="controls">
              <input type="file" class="input-xlarge" id="GamePicture" name="GamePicture" maxlength="250" />
              <p class="help-block">Upload a picture is represent your game, Could be gameplay or title screen.</p>
            </div>
          </div>
          
          <div class="control-group error">
            <label class="control-label" for="GameTweet">Moly*eux Inspirational Tweet*</label>
            <div class="controls">
              <textarea class="input-xlarge" id="GameTweet" name="GameTweet" rows="3" maxlength="250" ></textarea>
              <p class="help-block">Copy & Pasta that inspirational tweet here.</p>
            </div>
          </div>
          
          <div class="control-group error">
            <label class="control-label" for="GameDescription">Description*</label>
            <div class="controls">
              <textarea class="input-xlarge" id="GameDescription" name="GameDescription" rows="3" maxlength="500" ></textarea>
              <p class="help-block">Describe your game, if your game is a web-based game include a link to it here.</p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="GameFiles">Files</label>
            <div class="controls">
              <input type="file" class="input-xlarge" id="GameFiles" name="GameFiles" maxlength="250" />
              <p class="help-block">Upload a zip the necessary files to play your game and a README.txt file explaining how to install your game.</p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="GameVideo">Video</label>
            <div class="controls">
              <input type="url" class="input-xlarge" id="GameVideo" name="GameVideo" maxlength="250" />
              <p class="help-block">Link to a youtube video displaying gameplay. Suggested YouTube naming format: "MolyJam 2012 - GameName - Location"</p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="MolyJamLocation">MolyJam Location*</label>
            <div class="controls">
              <select id="MolyJamLocation" class="validate[required]" name="MolyJamLocation">
                <option value="">Select a location</option>
<?php
                  include("./data.php");
                
                  for($i = 0; $i < sizeof($Locations); $i++)
                  {
                    echo "                <option value=\"".$Locations[$i]."\">".$Locations[$i]."</option>\n";
                  }
?>
              </select>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="TeamPicture">Team Picture</label>
            <div class="controls">
              <input type="file" class="input-xlarge" id="TeamPicture" name="TeamPicture" maxlength="250" />
              <p class="help-block">Upload a picture of your team members.</p>
            </div>
          </div>
          
          <div class="control-group error">
            <label class="control-label" for="TeamMember">Team Members*</label>
            <div class="controls">
              <textarea class="input-xlarge" id="TeamMember" name="TeamMember" rows="3" maxlength="500"></textarea>
              <p class="help-block">Give credit to all those people who helped make it happen.</p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="GameLicense">License</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="GameLicense" name="GameLicense" maxlength="250" value="Creative Commons Attribution 3.0 Unported License" />
              <p class="help-block">This is the license type under which you wish to share your game in. If not sure what to put here consult <a href="http://www.creativecommons.org/choose/" target="_blank">CreativeCommons.org/Choose/</a></p>
            </div>
          </div>
          
          <div class="control-group error">
            <label class="control-label" for="Email">Email*</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="Email" name="Email" maxlength="250" />
              <p class="help-block">Must be a valid email address to allow you to edit the entry for 24 hours after creation.</p>
            </div>
          </div>
          
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Submit Game!</button>
            <button class="btn">Cancel</button>
          </div>
          
        </fieldset>
      </form>

<?php
    include('./templates/footer.php');
?>
