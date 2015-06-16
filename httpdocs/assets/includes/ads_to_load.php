<?php if($detect->isMobile()){ 

 if(isset($isArticle) && $isArticle ){?>
	<div id="mobile-instream-smart-ad-loader" class="hide">
		<div id="get-content" style="text-align:center; display: inline-block;">
			<script type='text/javascript'>var adParams = {a: '62112490', size: '300x250',serverdomain: 'adk2ads.tictacti.com', context:'c64851001'  };</script>
			<script type='text/javascript' src='http://cdnads.tictacti.com/tictacti/scripts/smart/smart.js'></script>
		</div>
	</div>
	<!--<div id="mobile-bottom-sprocketster-ad-loader" >
		<div id="get-content" style="text-align:center;">
			<script id="airpushScript" type="text/javascript" 
			src="http://ab.airpush.com/apportal/client/airpush.js?siteid=269236&testmode=0&banner360=1&banner=0&placementid=0&tp=0" >
			</script>
		</div>
	</div>	-->
	<?php if($articleInfoObj['article_id'] == 7160){?>
	<div id="mobile-instream-3lift-ad-loader" class="hide">
		<div id="get-content" style="text-align:center;">
			<script src="http://ib.3lift.com/ttj?inv_code=puckermob_article_sub"></script>
		</div>
	</div>
	<?php } ?>
	<div id="mobile-instream-branovate-ad-loader" >
		<div id="get-content" style="text-align:center;">
			<iframe id='ani_passback' border='0' width='0' height='0'></iframe> 
			<div id="aniplayer"></div> 
			<script type="text/javascript" id="aniviewJS"> var adConfig = { publisherID :'100976', channelID :'778254', width :300, height :250, HD :false, loop :true, vastRetry :3,	passBackUrl	:'http://rnwsrv.vo.llnwd.net/u/html/pans.js', backgroundColor :'#000000', position :'aniplayer' }; var PlayerUrl = 'http://eu.ani-view.com/Script/4/aniview.js'; var myPlayer; function downloadScript(src,adData) { var scp = document.createElement('script'); scp.src = src; scp.onload = function() { myPlayer= new aniviewPlayer; myPlayer.play(adConfig); }; document.getElementsByTagName('head')[0].appendChild(scp); }; downloadScript(PlayerUrl,adConfig); </script>
		</div>
	</div>
	<?php //if($articleInfoObj['article_id'] == 5295){?>
		<div id="mobile-instream-komoona-ad-loader" class="">
			<div id="get-content" style="text-align:center;">
				<script type="text/javascript">kmn_iframe = true; kmn_placement = 'cb04f88a1ff0727dc9881e3cfe5d8acc'; </script>
				<script type="text/javascript" src="//cdn.komoona.com/scripts/kmn_sa.js"></script>
			</div>	
		</div>
	<?php //} ?>
	<?php } 
 }else { ?>
	<div id="header-ad-loader" class="hide">
      	<div id="get-content">
		<?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
			<!-- puckermob.com/ros -->
			<script type="text/javascript">
			  var ord = window.ord || Math.floor(Math.random() * 1e16);
			  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/ros;sect=ros;sz=728x90,970x90;dcopt=ist;type=pop;type=int;dc_ref='+encodeURIComponent(location.href)+';ord=' + ord + '?"><\/script>');
			</script>

			<noscript>
				<a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/ros;sect=ros;sz=728x90,970x90;ord=[timestamp]?">
					<img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/ros;sect=ros;sz=728x90,970x90;ord=[timestamp]?" />
				</a>
			</noscript>
		<?php }else{?>
		<!-- puckermob.com/home -->
		<script type="text/javascript">
		  var ord = window.ord || Math.floor(Math.random() * 1e16);
		  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/home;sect=home;sz=728x90,970x90;dc_ref='+encodeURIComponent(location.href)+';dcopt=ist;type=pop;type=int;ord=' + ord + '?"><\/script>');
		</script>
		<noscript>
			<a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/home;sect=home;sz=728x90,970x90;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?">
				<img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/home;sect=home;sz=728x90,970x90;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?" />
			</a>
		</noscript>
		<?php }?>
		</div>
	</div>
	<?php if(isset($articleInfoObj) && $articleInfoObj){ ?>
	 <div id="atf-ad-loaded" class="hide" >
	 	<div id="get-content">
	 		<!-- puckermob.com/ros -->
	        <script type="text/javascript">
	          var ord = window.ord || Math.floor(Math.random() * 1e16);
	          document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/ros;sect=ros;sz=300x250;dc_ref='+encodeURIComponent(location.href)+';ord=' + ord + '?"><\/script>');
	        </script>

	        <noscript>
	          <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/ros;sect=ros;sz=300x250;ord=[timestamp]?">
	            <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/ros;sect=ros;sz=300x250;ord=[timestamp]?" width="300" height="250" />
	          </a>
	        </noscript>
	 	</div>
	 </div>
	 <?php }?>
<?php }  ?>

