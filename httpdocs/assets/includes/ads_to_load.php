<?php if($detect->isMobile()){ ?>
	<div id="mobile-instream-native-ad-loader" class="hide">
		<div id="get-content" style="text-align:center;">
		<?php if(isset($isArticle) && $isArticle ){?>
			<script type="text/javascript" src="//cpanel.nativeads.com/js/nativeads-104835-deeab8461c3725af1723048fac0d2127cc855db6.js" async></script>		
		<?php } ?>
		</div>
	<div>
	<?php if(isset($articleInfoObj) && isset($articleInfoObj['article_id'])){ ?>
	<div id="mobile-instream-sprocketster-ad-loader" class="hide">
		<div id="get-content" style="text-align:center;">
		<?php if(isset($isArticle) && $isArticle ){?>
			<!-- Javascript Ad Tag: 9 -->
			<div id="119xpg9Y78YnB"></div>
			<script src="http://119xpg.go2cloud.org/aff_ad?campaign_id=9&aff_id=1044&format=js&divid=119xpg9Y78YnB" type="text/javascript"></script>
			<noscript><iframe src="http://119xpg.go2cloud.org/aff_ad?campaign_id=9&aff_id=1044&format=iframe" scrolling="no" frameborder="0" marginheight="0" marginwidth="0" width="300" height="250"></iframe></noscript>
			<!-- End Ad Tag -->
		<?php } ?>
		</div>
	</div>
	<?php }?>
<?php }else { ?>
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

