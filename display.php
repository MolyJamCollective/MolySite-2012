<?php
  // TODO:: $Game = $_GET['Game'];
  // TODO:: Display Game
  
  include('./templates/globals.php');
    
  $pageTitle = 'GameName';
  $pageHeader = 'GameName';

  include('./templates/header.php');
?>
    <section id="Game">
          <div class="thumbnails">
            <div class="span5">
              <h3>Description</h3>
              <p><?php echo 'GameDescription'; ?></p>
              
              <br />
              <br />
              <br />
              
              <h3>Moly*eux Inspirational Tweet</h3>
              <div class="well">
                <p>"<?php echo 'Moly*eux Inspirational Tweet'; ?>"</p>
              </div>
              
              <br />
              
              <div align="center">
                <a href="<?php echo '#'; ?>" class="btn btn-large btn-primary">Gameplay Video</a> <a href="<?php echo '#'; ?>" class="btn btn-large btn-primary">Download Game</a>
              </div>
            </div>
            
            <div class="span5 offset1">
              <a href="<?php echo '#'; ?>" class="thumbnail">
                <img src="<?php echo ''; ?>" alt="">
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
              <p><?php echo 'TeamMember'; ?>"</p>
  
              <br />
              <br />
              
              <div class="footer">
                <p><strong>Jam Location:</strong> <?php echo'MolyJamLocation'; ?></p>
                <p><strong>Game License:</strong> <?php echo 'GameLicense'; ?></p>
              </div>
            </div>
            
            <div class="span5 offset1">
              <a href="<?php echo '#'; ?>" class="thumbnail">
                <img src="<?php echo ''; ?>" alt="">
              </a>
            </div>
          </div>
    </section>
    
<?php
  include('./templates/footer.php');
?>