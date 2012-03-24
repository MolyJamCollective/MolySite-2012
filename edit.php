<?php
    include('./templates/globals.php');
    
    $pageTitle = 'MolyJam Game Submission System';
    $pageHeader = 'MolyJam Game Submission System';

    $Game = $_GET['Game'];
    
    include('./templates/header.php');
?>

      <form class="form-horizontal" action="./upload.php" method="post">
        <fieldset>
          
          <div class="control-group">
            <label class="control-label" for="GameName">Name</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="GameName" name="GameName" />
              <p class="help-block">The Name of your Game</p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="GamePicture">Picture</label>
            <div class="controls">
              <input type="file" class="input-xlarge" id="GamePicture" name="GamePicture" />
              <p class="help-block">Upload a picture is represent your game, Could be gameplay or title screen.</p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="GameTweet">Moly*eux Inspirational Tweet</label>
            <div class="controls">
              <textarea class="input-xlarge" id="GameTweet" name="GameTweet" rows="3"></textarea>
              <p class="help-block">Copy & Pasta that inspirational tweet here.</p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="GameDescription">Description</label>
            <div class="controls">
              <textarea class="input-xlarge" id="GameDescription" name="GameDescription" rows="3"></textarea>
              <p class="help-block">Describe your game, if your game is a web-based game include a link to it here.</p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="GameFiles">Files</label>
            <div class="controls">
              <input type="file" class="input-xlarge" id="GameFiles" name="GameFiles" />
              <p class="help-block">Upload a zip the necessary files to play your game and a README.txt file explaining how to install your game.</p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="GameVideo">Video</label>
            <div class="controls">
              <input type="url" class="input-xlarge" id="GameVideo" name="GameVideo" />
              <p class="help-block">Link to a youtube video displaying gameplay. Suggested YouTube naming format: "MolyJam 2012 - GameName - Location"</p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="MolyJamLocation">MolyJam Location</label>
            <div class="controls">
              <select id="MolyJamLocation" name="MolyJamLocation">
<?php
                  include("./data.php");
                
                  for($i = 0; $i < sizeof($Locations); $i++)
                  {
                    echo "                <option>".$Locations[$i]."</option>\n";
                  }
?>
              </select>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="TeamPicture">Team Picture</label>
            <div class="controls">
              <input type="file" class="input-xlarge" id="TeamPicture" name="TeamPicture" />
              <p class="help-block">Upload a picture of your team members.</p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="TeamMember">Team Members</label>
            <div class="controls">
              <textarea class="input-xlarge" id="TeamMember" name="TeamMember" rows="3"></textarea>
              <p class="help-block">Give credit to all those people who helped make it happen.</p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="GameLicense">License</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="GameLicense" name="GameLicense" value="Creative Commons Attribution 3.0 Unported License" />
              <p class="help-block">This is the license type under which you wish to share your game in. If not sure what to put here consult http://creativecommons.org/choose/</p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="Email">Email</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="Email" name="Email" />
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