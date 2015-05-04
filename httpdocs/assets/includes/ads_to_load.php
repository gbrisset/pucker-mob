<?php if($detect->isMobile()){ ?>
	<div id="mobile-header-ad-loader" class="hide">
		<div id="get-content" style="text-align:center;">
		<?php if(isset($isArticle) && $isArticle ){?>
	        <!-- puckermob.com/ros -->
	        <script type="text/javascript">
	          var ord = window.ord || Math.floor(Math.random() * 1e16);
	          document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/ros;sect=ros;sz=320x150,320x100,320x50;dc_ref='+encodeURIComponent(location.href)+';dcopt=ist;type=pop;type=int;ord=' + ord + '?"><\/script>');
	        </script>
	        <noscript>
	        <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/ros;sect=ros;sz=320x150,320x100,320x50;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?">
	        <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/ros;sect=ros;sz=320x150,320x100,320x50;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?" />
	        </a>
	        </noscript>
	    <?php }else{?>
	        <!-- puckermob.com/home -->
	        <script type="text/javascript">
	          var ord = window.ord || Math.floor(Math.random() * 1e16);
	          document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/home;sect=home;sz=320x150,320x100,320x50;dc_ref='+encodeURIComponent(location.href)+';dcopt=ist;type=pop;type=int;ord=' + ord + '?"><\/script>');
	        </script>
	        <noscript>
	        <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/home;sect=home;sz=320x150,320x100,320x50;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?">
	        <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/home;sect=home;sz=320x150,320x100,320x50;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?" />
	        </a>
	        </noscript>
	    <?php }?>
		</div>
	</div>
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

