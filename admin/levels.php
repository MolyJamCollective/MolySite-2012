<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'Page Title';
    $pageHeader = 'Page Header';
    $pageStyles = array();
    $activeTab = '0';

    $pageScripts = array();
    $PageScriptsRaw = '';

    include_once('./templates/header.php');
	
	include_once('classes/class.edit_level.php');
	$Edit_level = new Edit_level;
?>
    <div class="row">
<?php include_once('classes/class.add_level.php'); ?>

<?php if(isset($_POST['edit_level']))
	$Edit_level->searchResults(); ?>
<?php if($Edit_level->level_id && !$Edit_level->search_q && !isset($_POST['edit_level'])) { ?>
	<div class='span4'>
<?php 	// Show messages
		if($Edit_level->results) echo $Edit_level->results;
			else echo $Edit_level->error;  ?>

		<h2>Level: <?php echo $Edit_level->level_name; ?></h2>
			<form method="post" class="form-stacked">
				<div class="clearfix">
				<label for="level"><?php _e('Level name'); ?></label>
					<div class="input">
						<input id="level" name="level" size="30" type="text" value="<?php echo $Edit_level->level_name; ?>"/>
					</div>
				</div><!-- /clearfix -->

				<div class="clearfix">
				<label for="auth"><?php _e('Auth level'); ?></label>
					<div class="input">
						<input id="auth" name="auth" size="30" type="text" value="<?php echo $Edit_level->level_auth; ?>"/>
					</div>
				</div><!-- /clearfix -->

			  <div class="clearfix">
				<label for="disable2"><?php _e('Disable level? Type "disable" and tick the checkbox'); ?></label>
				<div class="input">
				  <div class="input-prepend">
					<label class="add-on"><input type="checkbox" name="disable" id="disable" <?php echo $Edit_level->disabled; ?>/></label>
					<input class="mini" id="disable2" name="disable2" size="16" type="text" <?php echo $Edit_level->disabled2; ?>/>
				  </div>
				</div>
			  </div><!-- /clearfix -->

			<input type="submit" value="Update" name="do_edit" class="btn btn-primary" />
			</form>
	</div>
<?php } ?>

</div>
<div class="row">
	<div class="span12">
		<?php if(!empty($_GET['lid'])) :?>
		<h2><?php _e('Users in level:'); ?> <?php echo $Edit_level->level_name; ?></h2>
		<?php in_level(); ?>
		<?php endif; ?>
	</div>
</div>
<?php
    include_once('./templates/footer.php');
?>