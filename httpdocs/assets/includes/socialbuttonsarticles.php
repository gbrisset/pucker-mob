<div class="row social-media-container social-cont-1" style="margin-bottom: 0rem; display:block !important;">
	<a id="facebook-button" class="sm_facebook social_button" data-url="<?php echo $mpHelpers->curPageURL();?>" data-api-url="http://www.facebook.com/sharer/sharer.php?u={url}">
		<img src="<?php echo $config['this_url'].'assets/img/FacebookIconCircle3.png'; ?>" alt="Facebook" />
	</a> 
	<a id="twitter-button" class="sm_twitter social_button" data-url="<?php echo $mpHelpers->curPageURL();?>" data-api-url="" data-title=""  data-desc="">
		<img src="<?php echo $config['this_url'].'assets/img/TwitterIconCircle.png'; ?>" alt="Twitter" />
	</a> 
	<a id="pinterest-button" class="sm_pinterest_share social_button" data-url="<?php echo $mpHelpers->curPageURL();?>" data-api-url="http://api.pinterest.com/v1/urls/count.json?callback=?&url={url}" data-image="" data-desc="">
		<img src="<?php echo $config['this_url'].'assets/img/Pinterest-Icon-Circle.png'; ?>" alt="Pinterest" />
	</a>
	<a id="google-plus-button" class="sm_googleplus social_button" data-url="<?php echo $mpHelpers->curPageURL();?>" data-api-url="https://plusone.google.com/_/+1/fastbutton?url={url}">
		<img src="<?php echo $config['this_url'].'assets/img/GooglePlusIconCircle.png'; ?>" alt="Google Plus" />
	</a>
	<a href="#disqus-container" class="disqus_container">
		<img src="<?php echo $config['this_url'].'assets/img/CommentsIconCircle.png'; ?>" alt="Comments" />
	</a>

	<div class="fb-like show-on-large-up" data-href="http://www.puckermob.com/lifestyle/8-things-homebodies-say-and-what-they-actually-mean" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
	<div id="shares_count" class="at4-jumboshare">
		<div class="at4-count" style="color: rgb(119, 119, 119);">
			<span id="shares_counter">0</span>
		</div>
		<div class="at4-title" style="color: rgb(119, 119, 119);">SHARES</div>
	</div>
</div>