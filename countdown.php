<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'MolyJam - Countdown';
    $pageHeader = '';
    $pageStyles = array();
    $activeTab = '0';

    $pageScripts = array();
    $PageScriptsRaw = '<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">
<!--

dateFuture = new Date(2012,3,1,19,00,00); // Uses base 0 data, unless days uses base 1

function GetCount(){

        dateNow = new Date();                                                                        //grab current date
        amount = dateFuture.getTime() - dateNow.getTime();                //calc milliseconds between dates
        delete dateNow;

        // time is already past
        if(amount < 0){
                document.getElementById(\'countdown\').innerHTML="Now!";
        }
        // date is still good
        else{
                days=0;hours=0;mins=0;secs=0;out="";

                amount = Math.floor(amount/1000);//kill the "milliseconds" so just secs

                days=Math.floor(amount/86400);//days
                amount=amount%86400;

                hours=Math.floor(amount/3600);//hours
                amount=amount%3600;

                mins=Math.floor(amount/60);//minutes
                amount=amount%60;

                secs=Math.floor(amount);//seconds

                if(days != 0){out += days +" day"+((days!=1)?"s":"")+", ";}
                if(days != 0 || hours != 0){out += hours +" hour"+((hours!=1)?"s":"")+", ";}
                if(days != 0 || hours != 0 || mins != 0){out += mins +" minute"+((mins!=1)?"s":"")+", ";}
                out += secs +" seconds";
                document.getElementById(\'countdown\').innerHTML=out;

                setTimeout("GetCount()", 1000);
        }
}

window.onload=function(){GetCount();}//call when everything has loaded

//-->
</script>';

    //include_once('./templates/header.php');
    ?>
<?php include_once( 'classes/class.translate.php' ); ?>
<?php if (!isset($_SESSION)) session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $metaTags['charset'] ?>" />
    <title><?php echo $pageTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="keywords" content="<?php echo $metaTags['keywords'] ?>" />
    <meta name="description" content="<?php echo $metaTags['description'] ?>" />
    <meta name="author" content="<?php echo $metaTags['author'] ?>" />
    <meta name="copyright" content="<?php echo $metaTags['copyright'] ?>" />
    <meta name="robots" content="FOLLOW,INDEX" />

    <!-- Le styles -->
    <link href="./css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px toZ make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="./css/bootstrap-responsive.css" rel="stylesheet">
    
    
    <link rel="stylesheet/less" href="./less/bootstrap.less">
    <link href="./css/additive.css" rel="stylesheet">
    <script src="./js/less-1.3.0.min.js"></script>
    
    

<?php
  for($i = 0; $i < sizeof($pageStyles); $i++)
  {
  echo "    <link href=\"".$pageStyles[$i]."\" rel=\"stylesheet\">\n";
  }
?>
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="./ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="./ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="./ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="./ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body style="height: 73%">

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="./index.php">MolyJam</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li <?php if($activeTab == 1) { echo 'class="active"';} ?>><a href="./index.php">Home</a></li>
              <li <?php if($activeTab == 2) { echo 'class="active"';} ?>><a href="./news.php">News</a></li>
              <li <?php if($activeTab == 3) { echo 'class="active"';} ?>><a href="./faq.php">FAQs</a></li>
              <li class="dropdown <?php if($activeTab == 4 || $activeTab == 5) { echo 'active';} ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Games<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li class="nav-header">Archive</li>
                  <li <?php if($activeTab == 4) { echo 'class="active"';} ?>><a href="./archive.php">MolyJam2012</a></li>
                  <li class="divider"></li>
                  <li <?php if($activeTab == 5) { echo 'class="active"';} ?>><a href="./submit.php">Submissions</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" <?php if($activeTab == 6 || $activeTab == 7) { echo 'class="active"';} ?> class="dropdown-toggle" data-toggle="dropdown">Live<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li <?php if($activeTab == 6) { echo 'class="active"';} ?>><a href="./webchat.php">Web Chat</a></li>
                  <li <?php if($activeTab == 7) { echo 'class="active"';} ?>><a href="./livestream.php">Video Stream</a></li>
                </ul>
              </li>
            </ul>
            <?php if(isset($_SESSION['username'])) { ?>
		<ul class="nav pull-right">
			<li class="dropdown">
				<p class="navbar-text dropdown-toggle" data-toggle="dropdown" id="userDrop"><?php _e('Logged in as'); ?> <a href="#"><?php echo $_SESSION['username']; ?></a><b class="caret"></b></p>
				<ul class="dropdown-menu">
		<?php if(in_array(1, $_SESSION['user_level'])) { ?>
					<li><a href="./admin/index.php"><i class="icon-home"></i> <?php _e('Control Panel'); ?></a></li>
                                        <li><a href="./admin/users.php"><i class="icon-cog"></i> <?php _e('User Settings'); ?></a></li>
					<li><a href="./admin/settings.php"><i class="icon-cog"></i> <?php _e('Site Settings'); ?></a></li> <?php } ?>
					<li><a href="./my-account.php"><i class="icon-user"></i> <?php _e('My Account'); ?></a></li>
					<li class="divider"></li>
					<li><a href="./logout.php"><?php _e('Sign out'); ?></a></li>
				</ul>
			</li>
		</ul>
		<?php } else { ?>
		<ul class="nav pull-right">
			<li><a href="./login.php" class="signup-link"><strong><?php _e('Sign in'); ?></strong></a></li>
		</ul>
		<?php } ?>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
    <div class="container-fluid" style="min-height: 73%">
        <br />
        <br />
        <br />
        <br />
        <br />
        <center><div id="countdown" style="font-size: 600%; color: #00AA00;"></div></center>
        <br />
        <br />
        <br />
        <br />
        <br />
    </div>
   
<?php
    include_once('./templates/footer.php');
?>