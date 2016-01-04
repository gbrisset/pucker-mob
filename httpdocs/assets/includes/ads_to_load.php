<?php if($detect->isMobile()){ 
	if(isset($isArticle) && $isArticle ){?>
		
		<div id="mobile-instream-branovate-ad-loader" class="hide">
			<div id="get-content" style="text-align:center; display: inline-block;">
				
					<?php if( $detect->is('iOS') ){?>
						<div id="branovate-ad "class="columns small-12 margin-top margin-bottom IOS">
						<!-- BEGIN JS TAG - puckermob.com 300x250 IOS < - DO NOT MODIFY -->
						<SCRIPT SRC="http://ib.adnxs.com/ttj?id=5839932&cb=[CACHEBUSTER]" TYPE="text/javascript"></SCRIPT>
						<!-- END TAG -->
						</div>
					<?php }else{?>
					<div id="branovate-ad "class="columns small-12 margin-top margin-bottom">
					<!-- BEGIN JS TAG - puckermob.com Mobile 300x250 < - DO NOT MODIFY -->
					<SCRIPT SRC="http://ib.adnxs.com/ttj?id=4408970&cb=[CACHEBUSTER]" TYPE="text/javascript"></SCRIPT>
					<!-- END TAG -->
					</div>
					<?php }?>
				
			</div>
		</div>
		<?php if($articleInfoObj && $articleInfoObj['article_id'] == 10157 ){ ?>
			<div id="mobile-instream-adsnative-ad-loader" class="hide">
			<div id="get-content" style="text-align:center; display: inline-block;">
				<div id="adsnative-ad "class="columns small-12 margin-top margin-bottom">
					<script>

					(function() 

					{ 

					   var tagqa = '';

					   var playerId = '';

					   var playerContainerId = '';

					   var playerWidth = '';

					   var playerHeight = '';

					   var tracki = '';

					   var trackc = '';

					   var custom1 = '';

					   var custom2 = '';

					   var custom3 = '';

					   var videourl = '';

					   var viewMode = 'normal';

					   var companionId = '';

					   var pubMacros = '';

					 

					   var lkqdVPAID;

					   var lkqdId = new Date().getTime().toString() + Math.round(Math.random()*1000000000).toString();

					   var environmentVars = { slot: document.getElementById(playerContainerId), videoSlot: document.getElementById(playerId), videoSlotCanAutoPlay: true };

					   var creativeData = '';

					 

					   function onVPAIDLoad()

					   {

					        lkqdVPAID.subscribe(function() { lkqdVPAID.startAd(); }, 'AdLoaded');

					   }

					 

					  var vpaidFrame = document.createElement('iframe');

					   vpaidFrame.id = lkqdId;

					   vpaidFrame.name = lkqdId;

					   vpaidFrame.style.display = 'none';

					   vpaidFrame.onload = function() {

					        vpaidLoader = vpaidFrame.contentWindow.document.createElement('script');

					        vpaidLoader.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//ad.lkqd.net/serve/pure.js?format=2&vpaid=true&apt=auto&ear=0&pid=16&sid=12057&tagqa=' + tagqa + '&elementid=' + encodeURIComponent(playerId) + '&containerid=' + encodeURIComponent(playerContainerId) + '&width=' + playerWidth + '&height=' + playerHeight + '&mode=' + viewMode + '&companionid=' + encodeURIComponent(companionId) + '&tracki=' + encodeURIComponent(tracki) + '&trackc=' + encodeURIComponent(trackc) + '&c1=' + encodeURIComponent(custom1) + '&c2=' + encodeURIComponent(custom2) + '&c3=' + encodeURIComponent(custom3) + '&videourl=' + encodeURIComponent(videourl) + '&rnd=' + Math.floor(Math.random() * 100000000) + '&m=' + encodeURIComponent(pubMacros);

					        vpaidLoader.onload = function() {

					              lkqdVPAID = vpaidFrame.contentWindow.getVPAIDAd();

					              lkqdVPAID.handshakeVersion('2.0');

					              onVPAIDLoad();

					              lkqdVPAID.initAd(playerWidth, playerHeight, viewMode, 600, creativeData, environmentVars);

					        };

					        vpaidFrame.contentWindow.document.body.appendChild(vpaidLoader);

					   };

					   document.documentElement.appendChild(vpaidFrame);

					})();

					</script>				
				</div>
				</div>
			</div>
		<?php } ?>
		
	<?php  

	}

} ?>

