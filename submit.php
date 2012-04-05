<?php
    include_once("./templates/include.php");
    
    include_once("./objects/class.game.php");
    include_once("./objects/class.greenPixel.php");
    include_once("./objects/class.ftp.php");
    include_once("./objects/class.location.php");
    
    $pageTitle = 'MolyJam Game Submission System';
    $pageHeader = 'MolyJam Game Submission System';
    $activeTab = '5';
    
    $pageStyles = array('./css/validationEngine.jquery.css');
    
    $pageScripts = array('./js/jquery.validationEngine.js','./js/jquery.validationEngine-en.js','./js/other-validations.js');
    $PageScriptsRaw ='
  <script>
    $(document).ready(function(){
      $("#GameSubmission").validationEngine();
    });
  </script>
  
    <script>
      function checkImage(field, rules, i, options)
	  {
	  	var fileExt = field.val().substring( field.val().length - 4 ).toLowerCase();

        if ( fileExt != ".png" && fileExt != ".jpg" && fileExt != "jpeg" ) 
		{
          return "Please select a PNG or JPG file";
        }
      }
      
      function checkArchive(field, rules, i, options)
	  {
	  	var fileExt = field.val().substring( field.val().length - 3 ).toLowerCase();
	  	
        if ( fileExt != "zip" ) 
		{
          return "Please select a ZIP file";
        }
      }
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
    $(".uploadType").hide();
    $("#fileType").change(function(){
      $(".uploadType").hide();
      $("#" + $(this).val()).show();    
    });
    });
    </script>
  ';
    
    include_once('./templates/header.php');
    
    $Game = new Game();
   
    
    $Error = false;
    
    if( !empty( $_GET[ "EditID" ] ) )
    {
    	$Game->GetFromEditId( $_GET[ "EditID" ] );
		if($Game->GameName == "") // Game Was Not Found
		{
		    Echo '<h2 style="color: red">EditID was not found</h2>';
		    $Error = true;
		}
    }
    if(!$Error)
    {
	
?>

<?php 

if( !empty( $_GET[ "EditID" ] ) ):

$GreenPixel = new GreenPixel();
$greenPixels = $GreenPixel->GetList( array( array("gameid", "=", $Game->gameId) ) ); 
?>

<h3>Page Views: <?php echo $Game->PageViews; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Downloads: <?php echo $Game->Downloads; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Green Pixels: <?php echo count($greenPixels); ?> (<a href="#greenPixels">view</a>)</h3>


<div class="page-header">
    <h1>Edit your entry</h1>
</div>
<?php endif; ?>

<div class="row-fluid">
    <div class="span10 offset1">
    <?php if( !empty( $_GET[ "EditID" ] ) ): ?>
	<form id="GameSubmission" class="form-horizontal" action="./upload.php?EditID=<?php echo $_GET[ "EditID" ]; ?>" method="post" enctype="multipart/form-data">
    <?php else: ?>
	<form id="GameSubmission" class="form-horizontal" action="./upload.php" method="post" enctype="multipart/form-data">
    <?php endif; ?>
        <fieldset>
	    <div class="control-group">
		<label class="control-label" for="GameName">Name*</label>
		    <div class="controls">
			<input type="text" class="input-xlarge validate[required]" id="GameName" name="GameName" maxlength="250" value="<?php echo $Game->GameName; ?>" />
			<p class="help-block">The Name of your Game</p>
		    </div>
		</div>
	    <div class="control-group">
		<label class="control-label" for="GamePicture">Picture</label>
		<div class="controls">
		    <input type="file" value="" accept="image/*" class="input-xlarge validate[funcCall[checkImage]]" id="GamePicture" name="GamePicture" maxlength="250" />
		    <input type="hidden" id="GamePictureURL" name="GamePictureURL" value="">
		    <p class="help-block">Upload a picture which represents your game. Could be gameplay or title screen.
		    <?php if( !empty( $_GET[ "EditID" ] ) && $Game->GamePictureURL != "" ): ?>
			<br />Leave this empty if you don't want to upload a new picture. Old picture will be overridden.
		    <?php endif; ?>
		    </p>
		</div>
	    </div>
	    <div class="control-group">
		<label class="control-label" for="GameTweet">Moly*eux Inspirational Tweet*</label>
		<div class="controls">
		    <textarea class="input-xlarge validate[required]" id="GameTweet" name="GameTweet" rows="3" maxlength="250" ><?php echo $Game->GameTweet; ?></textarea>
		    <p class="help-block">Copy & Pasta that inspirational tweet here.</p>
		</div>
	    </div>
	    <div class="control-group">
		<label class="control-label" for="GameDescription">Description*</label>
		<div class="controls">
		    <textarea class="input-xlarge validate[required]" id="GameDescription" name="GameDescription" rows="3" maxlength="500" ><?php echo $Game->GameDescription; ?></textarea>
		    <p class="help-block">Describe your game, if your game is a web-based game include a link to it here.</p>
		</div>
	    </div>
	    <div class="control-group">
		<label class="control-label" for="GameFiles">Files</label>
		<div class="controls">
		    <select id="fileType">
			<option value="">Selected a File Type</option>
			<option value="File">Upload a File</option>
			<option value="Link">Submit a Link</option>
		    </select>
		    <div id="File" class="uploadType well">
			<input type="file" class="input-xlarge validate[funcCall[checkArchive]]" id="GameFiles" name="GameFiles" maxlength="250" />
			<input type="hidden" id="GameFilesURL" name="GameFilesURL" value="">
			<p class="help-block">Upload a zip the necessary files to play your game and a README.txt file explaining how to install your game.
			<?php if( !empty( $_GET[ "EditID" ] ) && $Game->GamePictureURL != "" ): ?>
			    <br />Leave this empty if you don't want to upload new game files. Old files will be overridden.
			<?php endif; ?>
			</p>
		    </div>
		    <div id="Link" class="uploadType well">
			<br />
			<input type="text" class="input-xlarge validate[optional,custom[url]]" id="GameFilesLink" name="GameFilesLink" maxlength="250" value="" />
			<p class="help-block">Submit a link to your web based game</p>
		    </div>
		</div>

	    </div>
	    <div class="control-group">
		<label class="control-label" for="GameVideoURL">Video</label>
		<div class="controls">
		    <input type="text" class="input-xlarge validate[optional,custom[url]]" id="GameVideoURL" name="GameVideoURL" maxlength="250" value="<?php echo $Game->GameVideoURL; ?>" />
		    <p class="help-block">Link to a youtube video displaying gameplay. Suggested YouTube naming format: "MolyJam 2012 - GameName - Location"</p>
		</div>
	    </div>
	    <div class="control-group">
		<label class="control-label" for="MolyJamLocation">MolyJam Location*</label>
		<div class="controls">
		    <select id="MolyJamLocation" class="validate[required]" name="MolyJamLocation">
			<option value="">Select a location</option>
<?php
                  $Location = new Location();
		  $LocationList = $Location->GetList(array(array("locationid", ">", 0)),"title",true);
                
                  foreach ($LocationList as $Location)
                  {
                  	$selected = "";
                  	if( $Location->Title == $Game->MolyJamLocation )
                  	{
                  		$selected = "selected";
              		}
              		echo "			<option value=\"".$Location->Title."\" ".$selected.">".$Location->Title."</option>\n";
                  }
?>			<option value="Internet">Other/Internet</option>
		    </select>
		</div>
	    </div>
	    <div class="control-group">
		<label class="control-label" for="TeamPicture">Team Picture</label>
		<div class="controls">
		    <input type="file" class="input-xlarge validate[funcCall[checkImage]]" accept="image/*" id="TeamPicture" name="TeamPicture" maxlength="250" />
		    <input type="hidden" id="TeamPictureURL" name="TeamPictureURL" value="">
		    <p class="help-block">Upload a picture of your team members.
			<?php if( !empty( $_GET[ "EditID" ] ) && $Game->GamePictureURL != "" ): ?>
			<br />Leave this empty if you don't want to upload a new picture. Old picture will be overridden.
			<?php endif; ?>
		    </p>
		</div>
	    </div>
          
	    <div class="control-group">
		<label class="control-label" for="TeamMember">Team Members*</label>
		<div class="controls">
		    <textarea class="input-xlarge validate[required]" id="TeamMember" name="TeamMember" rows="3" maxlength="500"><?php echo $Game->TeamMembers; ?></textarea>
		    <p class="help-block">Give credit to all those people who helped make it happen.</p>
		</div>
	    </div>
          <!-- Formating stopped Here -->
	  <div class="control-group">
            <label class="control-label" for="GameLicense">License</label>
            <div class="controls">
              <label class="radio">
                <input type="radio" name="GameLicense" id="LicenseRadios1" value="CC BY" <?php if( $Game->GameLicense == "" || $Game->GameLicense == "CC BY" ) { echo 'checked=""'; } ?>>
                <img src="http://i.creativecommons.org/l/by/3.0/88x31.png" />
		<strong>Attribution (CC BY)</strong>
              </label>
              <label class="radio">
                <input type="radio" name="GameLicense" id="LicenseRadios2" value="CC BY-SA" <?php if( $Game->GameLicense == "CC BY-SA" ) { echo 'checked=""'; } ?> >
                <img src="http://i.creativecommons.org/l/by-sa/3.0/88x31.png" />
		<strong>Attribution-ShareAlike (CC BY-SA)</strong>
              </label>
	      <label class="radio">
                <input type="radio" name="GameLicense" id="LicenseRadios3" value="CC BY-ND" <?php if( $Game->GameLicense == "CC BY-ND" ) { echo 'checked=""'; } ?>>
                <img src="http://i.creativecommons.org/l/by-nd/3.0/88x31.png" />
		<strong>Attribution-NoDerivs (CC BY-ND)</strong>
              </label>
	      <label class="radio">
                <input type="radio" name="GameLicense" id="LicenseRadios4" value="CC BY-NC" <?php if( $Game->GameLicense == "CC BY-NC" ) { echo 'checked=""'; } ?>>
                <img src="http://i.creativecommons.org/l/by-nc/3.0/88x31.png" />
		<strong>Attribution-NonCommercial (CC BY-NC)</strong>
              </label>
	      <label class="radio">
                <input type="radio" name="GameLicense" id="LicenseRadios5" value="CC BY-NC-SA" <?php if( $Game->GameLicense == "CC BY-NC-SA" ) { echo 'checked=""'; } ?>>
                <img src="http://i.creativecommons.org/l/by-nc-sa/3.0/88x31.png" />
		<strong>Attribution-NonCommercial-ShareAlike (CC BY-NC-SA)</strong>
              </label>
	      <label class="radio">
                <input type="radio" name="GameLicense" id="LicenseRadios6" value="CC BY-NC-ND" <?php if( $Game->GameLicense == "CC BY-NC-ND" ) { echo 'checked=""'; } ?>>
                <img src="http://i.creativecommons.org/l/by-nc-nd/3.0/88x31.png" />
		<strong>Attribution-NonCommercial-NoDerivs (CC BY-NC-ND)</strong>
              </label>
	      <p class="help-block">This is the license type under which you wish to share your game in. If not sure what to put here consult <a href="http://www.creativecommons.org/choose/" target="_blank">CreativeCommons.org/Choose/</a></p>
            </div>
          </div>
	  
	  <div class="control-group">
		<label class="control-label" for="GameEngine">Engine*</label>
		<div class="controls">
		    <select id="GameEngine" class="validate[required]" name="GameEngine">
			<option <?php if($Game->GameEngine == "") { echo 'selected'; } ?> value="">Select a Engine</option>
			<option <?php if($Game->GameEngine == "Construct 2") { echo 'selected'; } ?> value="Construct 2">Construct 2</option>
			<option <?php if($Game->GameEngine == "CryEngine 3") { echo 'selected'; } ?> value="CryEngine 3">CryEngine 3</option>
			<option <?php if($Game->GameEngine == "GameMaker") { echo 'selected'; } ?> value="GameMaker">GameMaker</option>
			<option <?php if($Game->GameEngine == "GameSalad") { echo 'selected'; } ?> value="GameSalad">GameSalad</option>
			<option <?php if($Game->GameEngine == "Unity3D") { echo 'selected'; } ?> value="Unity3D">Unity3D</option>
			<option <?php if($Game->GameEngine == "Unreal") { echo 'selected'; } ?> value="Unreal">Unreal</option>
			<option <?php if($Game->GameEngine == "XNA") { echo 'selected'; } ?> value="XNA">XNA</option>
			<option <?php if($Game->GameEngine == "Other") { echo 'selected'; } ?> value="Other">Other</option>
			<option <?php if($Game->GameEngine == "None") { echo 'selected'; } ?> value="None">None</option>
		    </select>
		</div>
	    </div>
	  
          <div class="control-group">
            <label class="control-label" for="Email">Email<?php if( empty( $_GET[ "EditID" ] ) ) { echo '*';} ?></label>
            <div class="controls">
	<?php if( !empty( $_GET[ "EditID" ] ) ): ?>
	    <input type="text" class="input-xlarge disabled" id="Email" name="Email" maxlength="250" value="" disabled>
	<?php else: ?>
	    <input type="text" class="input-xlarge validate[required,custom[email]]" id="Email" name="Email" maxlength="250" />
	<?php endif; ?>
              <p class="help-block">Must be a valid email address to allow you to edit the entry for 24 hours after creation.</p>
            </div>
          </div>

          <div class="form-actions">
          	<?php if( !empty( $_GET[ "EditID" ] ) ): ?>
          	<button type="submit" class="btn btn-primary">Edit Game!</button>
          	<?php else: ?>
            <button type="submit" class="btn btn-primary">Submit Game!</button>
            <?php endif; ?>
            <button class="btn">Cancel</button>
          </div>
          
        </fieldset>
      </form>
      </div>
</div>


<?php if( !empty( $_GET[ "EditID" ] ) ): ?>
<a name="greenPixels"></a>
<div class="page-header">
    <h1>Green Pixels</h1>
</div>

<?php for( $i = count( $greenPixels ) - 1; $i >= 0; $i-- ): ?>

<img src="img/greenPixel.jpg" alt="Green Pixel" style="float:left;margin-right:10px;" /><div><?php echo $greenPixels[ $i ]->Text; ?></div>
<div style="clear:both;"></div><br />

<?php endfor; ?>

<?php endif; ?>
<?php
    } include_once('./templates/footer.php');
?>
