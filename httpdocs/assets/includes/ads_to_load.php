<?php if($detect->isMobile()){ ?>
	<!--<div id="mobile-header-ad-loader" class="hide">
		<div id="get-content" style="text-align:center;">-->
		<?php //if(isset($isArticle) && $isArticle ){?>
	        <!-- puckermob.com/ros 
	        <script type="text/javascript">
	          var ord = window.ord || Math.floor(Math.random() * 1e16);
	          document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/ros;sect=ros;sz=320x150,320x100,320x50;dc_ref='+encodeURIComponent(location.href)+';dcopt=ist;type=pop;type=int;ord=' + ord + '?"><\/script>');
	        </script>
	        <noscript>
	        <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/ros;sect=ros;sz=320x150,320x100,320x50;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?">
	        <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/ros;sect=ros;sz=320x150,320x100,320x50;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?" />
	        </a>
	        </noscript>-->
	    <?php //}else{?>
	        <!-- puckermob.com/home 
	        <script type="text/javascript">
	          var ord = window.ord || Math.floor(Math.random() * 1e16);
	          document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N4403/adj/puckermob.com/home;sect=home;sz=320x150,320x100,320x50;dc_ref='+encodeURIComponent(location.href)+';dcopt=ist;type=pop;type=int;ord=' + ord + '?"><\/script>');
	        </script>
	        <noscript>
	        <a href="http://ad.doubleclick.net/N4403/jump/puckermob.com/home;sect=home;sz=320x150,320x100,320x50;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?">
	        <img src="http://ad.doubleclick.net/N4403/ad/puckermob.com/home;sect=home;sz=320x150,320x100,320x50;dc_ref='+encodeURIComponent(location.href)+';ord=[timestamp]?" />
	        </a>
	        </noscript>-->
	    <?php //}?>
		<!--</div>
	</div>-->

	<!--<div id="mobile-instream-criteo-ad-loader" class="hide">
		<div id="get-content" style="text-align:center;">
		<?php //if(isset($isArticle) && $isArticle ){?>
			<script type='text/javascript'>-->
			<!--//<![CDATA[
			   document.MAX_ct0 ='';
			   var m3_u = (location.protocol=='https:'?'https://cas.criteo.com/delivery/ajs.php?':'http://cas.criteo.com/delivery/ajs.php?');
			   var m3_r = Math.floor(Math.random()*99999999999);
			   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
			   document.write ("zoneid=235635");document.write("&amp;nodis=1");
			   document.write ('&amp;cb=' + m3_r);
			   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
			   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
			   document.write ("&amp;loc=" + escape(window.location).substring(0,1600));
			   if (document.context) document.write ("&context=" + escape(document.context));
			   if ((typeof(document.MAX_ct0) != 'undefined') && (document.MAX_ct0.substring(0,4) == 'http')) {
			       document.write ("&amp;ct0=" + escape(document.MAX_ct0));
			   }
			   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
			   document.write ("'></scr"+"ipt>");
			//]]>--><!--</script>
		<?php //} ?>
		</div>
	</div>
	
	<div id="mobile-instream-cpi-ad-loader" class="hide">
		<div id="get-content" style="text-align:center;">
		<?php //if(isset($isArticle) && $isArticle ){?>
			<div id="119xpg9hxIAEu"></div>
			<script src="http://119xpg.go2cloud.org/aff_ad?campaign_id=9&aff_id=1044&format=js&divid=119xpg9hxIAEu" type="text/javascript"></script>
			<noscript><iframe src="http://119xpg.go2cloud.org/aff_ad?campaign_id=9&aff_id=1044&format=iframe" scrolling="no" frameborder="0" marginheight="0" marginwidth="0" width="300" height="250"></iframe></noscript>
		<?php //} ?>
		</div>
	<div>-->
	<div id="mobile-instream-native-ad-loader" class="hide">
		<div id="get-content" style="text-align:center;">
		<?php if(isset($isArticle) && $isArticle ){?>
			<script type="text/javascript" src="//cpanel.nativeads.com/js/nativeads-104835-deeab8461c3725af1723048fac0d2127cc855db6.js" async></script>		
		<?php } ?>
		</div>
	<div>
	<!--
	<div id="mobile-instream-connatix-ad-loader" class="hide">
		<div id="get-content" style="text-align:center;">
		<?php //if(isset($isArticle) && $isArticle ){?>
		
		<div id='div-gpt-ad-1431974009855-0' style='height:250px; width:300px;'>
		<script type='text/javascript'>
		googletag.cmd.push(function() { googletag.display('div-gpt-ad-1431974009855-0'); });
		</script>
		</div>
		<?php //} ?>
		</div>
	</div>-->
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

