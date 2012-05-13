<?php 
include_once( 'classes/class.translate.php' );
include_once( 'classes/class.cache.php' );

/*$cache = new Cache();

if( $cache->cachedFileExists() )
{
	$cache->renderCachedFile();
	die();
}

$cache->start();*/

?>
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
    <style>
      body {
        padding-top: 60px; /* 60px toZ make the container go all the way to the bottom of the topbar */
      }
    </style>
    
    <link rel="stylesheet/less" href="./less/bootstrap.less">
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
      
  <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-30482482-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
  </head>

  <body>
  
<?php 
include( './templates/nav.php' );
?>
	
  <div class="container-fluid">

  <?php if(!empty($pageHeader)) { ?>
    <div class="page-header">
        <h1><?php echo $pageHeader; ?></h1>
    </div>
  <?php } ?>
    