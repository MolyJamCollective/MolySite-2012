<?php
    include_once('./templates/globals.php');
    
    $pageTitle = 'MolyJam - Live Stream';
    $pageHeader = 'Live Stream';
    $pageStyles = array();
    $activeTab = '7';

    $pageScripts = array();
    $PageScriptsRaw = '
        <script type="text/javascript">

 var streamingProfiles = $(\'.origin.live\');
 var videoIndex = 0;
 var autoRotate = true;
 var validStreams = [];
 var updateLiveStreamsInterval = null;
 var updateEmbedCodeTimeout = null;
 var liveOnly = document.getElementById(\'liveStreamOnly\').checked;

 function updateEmbedCode() {
 	streamingProfiles = $(\'.origin.live\');

 	if(window.autoRotate === false) {
 		/*
 		 * If someone stops the auto rotate we\'ll still poll
 		 * at a regular rate, but only update the embed if
 		 * it\'s currently set to auto-rotate
 		 */
 	} else if(streamingProfiles.length > 0) {
 		if(videoIndex > streamingProfiles.length) {
 			/*
 			 * If we\'ve exceeded the number of videos
 			 * or lost a stream between this update and the last update,
 			 * then start back at the first stream
 			 */
 			videoIndex = 0;
 		}
		var accountUrl = streamingProfiles[videoIndex].getAttribute(\'href\');
		var urlSubStrings = accountUrl.split(\'/\');
		var userName = urlSubStrings[urlSubStrings.length - 1];
		var domain = urlSubStrings[urlSubStrings.length - 2];
		var embedcode = \'\';
		if (domain === \'www.justin.tv\') {
		  embedcode = \'<object type="application/x-shockwave-flash" height="480" width="853" id="live_embed_player_flash" data="http://www.justin.tv/widgets/live_embed_player.swf?channel=\' + userName + \' bgcolor="#000000"><param name="allowFullScreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="allownetworking" value="all" /><param name="movie" value="http://www.justin.tv/widgets/live_embed_player.swf" /><param name="flashvars" value="channel=\' + userName + \'&auto_play=true&start_volume=25" /></object>\';
		} else if (domain === \'www.twitch.tv\') {
		  embedcode = \'<object type="application/x-shockwave-flash" height="480" width="853" id="live_embed_player_flash" data="http://www.twitch.tv/widgets/live_embed_player.swf?channel=\'+ userName +\'" bgcolor="#000000"><param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="all" /><param name="movie" value="http://www.twitch.tv/widgets/live_embed_player.swf" /><param name="flashvars" value="hostname=www.twitch.tv&channel=\' + userName + \'&auto_play=true&start_volume=25" /></object>\';
		}

		//update embed code for new video feed
		$(\'#videofeed\').html(embedcode);
		$(\'#locationinfo\').text(\'Now displaying \' + streamingProfiles[videoIndex].innerHTML);
		videoIndex++;

		//replacing with check above, since the new streamingProfiles length is constantly changing
		//videoIndex = videoIndex % streamingProfiles.length;
    }

	clearTimeout(window.updateEmbedCodeTimeout);
    window.updateEmbedCodeTimeout = setTimeout(updateEmbedCode, $(\'#delay\').val() * $(\'#rotateMultiplier\').val());
   }


   function setRotate(boxEl) {
   	window.autoRotate = (boxEl.checked);
   }

   function setLiveStreamOnly(boxEl) {
   	window.liveOnly = (boxEl.checked);
   	refreshStreamStates();
   }

   function updateValidStreams() {
   	$(\'.origin\').each(function(i, linkEl) {
   		//console.log(linkEl.id);
   		if(window.liveOnly === false) {
   		 $(linkEl).addClass(\'live\');
   		} else {
			var channelURL = linkEl.href;
			/*If the stream is hosted on twitch or justin.tv, use their API to verify it is live */
			if(channelURL.match(/(twitch.tv|justin.tv)/)) {
				var channelId = channelURL.substring(channelURL.lastIndexOf(\'/\')+1);

				//Useful for debugging, if you want all channels to be live, then just steal an id from the front page of twitch.tv
				//channelId = \'day9tv\';

				$(linkEl).removeClass(\'live\');
				$.getJSON("http://api.justin.tv/api/stream/list.json?channel="+channelId+"&jsonp=?",
					function(r){
						var live = (r.length > 0);
						$(linkEl).addClass(\'live\');
					}).error(function(r, errType) {
						//This fails for two reasons, the stream isn\'t live, or you\'ve exceeded the justin.tv API limit
						//TODO determine the response failure reason, and if it\'s because of polling limits, then stop the filtering
						//console.log(r);
						//console.log(errType);
					});


			} else {
				$(linkEl).addClass(\'live\');
			}
   		}
   	});
   }

   function refreshStreamStates() {
	window.clearInterval(window.updateLiveStreamsInterval);
   	updateValidStreams();
   	window.updateLiveStreamsInterval = setInterval(updateValidStreams, $(\'#streamUpdate\').val() * 1000 * 60);
   };


   /*
    * On page ready
    */

   refreshStreamStates();
   updateEmbedCode();


 </script>

    ';

    include_once('./templates/header.php');
?>
<div class="row-fluid">
    <div class="span2">&nbsp;</div>
    <div class="span8">
        

  <a class="origin btn" id="Guadalajara" href="http://www.twitch.tv/molyjamguadalajara">Guadalajara</a>
  <a class="origin btn" id="Lisbon" href="http://www.twitch.tv/4orbidd3n">Lisbon</a>
  <a class="origin btn" id="LA" href="http://www.twitch.tv/molyjamla">Los Angeles</a>
  <a class="origin btn" id="London" href="http://www.twitch.tv/metzopaino">London</a>
  <a class="origin btn" id="Monterrey" href="http://www.twitch.tv/mikealebrije">Monterrey</a>
  <a class="origin btn" id="Montreal" href="http://www.justin.tv/molyjammtl">Montreal</a>
  <a class="origin btn" id="Munich" href="http://www.twitch.tv/codesurgeon">Munich</a>
  <a class="origin btn" id="Sydney" href="http://www.justin.tv/molyjamsydney">Sydney</a>
  <a class="origin btn" id="Toronto" href="http://www.justin.tv/molyjamto">Toronto</a>
  <a class="origin btn" id="Melbourne"  href="http://www.justin.tv/molyjammelbourne">Melbourne</a>
  <div id="videofeed">
    <!-- updated via JavaScript code, see below -->
  </div>

  <div id="locationinfo"></div>
  <input id="rotate" type="checkbox" name="rotate" checked onchange="setRotate(this);" /><label for="rotate">Auto-cycle</label>
  every <input id="delay" type="text" name="delay" value="60" />
  <select id="rotateMultiplier"><option value="1000" selected>seconds</option><option value="60000">minutes</option></select>
  <br />
  Refresh streams every <input id="streamUpdate" type="text" name="streamUpdate" value="5" /> minutes <input type="button" onclick="refreshStreamStates();" value="Refresh Now" />

    </div>
</div>
<?php
    include_once('./templates/footer.php');
?>