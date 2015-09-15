<?php if($detect->isMobile()){ 
 if(isset($isArticle) && $isArticle ){?>
	<div id="mobile-instream-toksnn-ad-loader" class="hide">
		<div id="get-content" style="text-align:center; display: inline-block;">
			<script src="http://www.toksnn.com/ads/pkm_ent1_mob_us.js?player=av&amp;adTag=avpkm&amp;pub=sqmpkmusm"></script>
		</div>
	</div>
	
	<div id="mobile-instream-branovate-ad-loader" class="hide">
		<div id="get-content" style="text-align:center; display: inline-block;">
			<div id="branovate-ad "class="columns small-12 margin-top margin-bottom">
				<!-- BEGIN JS TAG - puckermob.com 300x250 < - DO NOT MODIFY -->
				<SCRIPT SRC="http://ib.adnxs.com/ttj?id=4408970&cb=[CACHEBUSTER]&referrer=[REFERRER_URL]" TYPE="text/javascript"></SCRIPT>
				<!-- END TAG -->
			</div>
		</div>
	</div>
 <?php } 
 }else { ?>
	
<?php }  ?>

