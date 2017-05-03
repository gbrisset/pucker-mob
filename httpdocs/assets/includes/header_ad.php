<?php if(!$detect->isMobile()){ ?>
	<div id="header-ad" class="ad-unit hide-for-print padding-top" style="background: #fff !important; margin-top:90px !important">
		<!-- ARTICLES -->
		<?php if(isset($articleInfoObj) && $articleInfoObj){

				echo $smf_adManager->display_tags("dsk_banner", $article_id);

		 }// end if(isset($articleInfoObj) && $articleInfoObj)



		 ?> 
	</div>
<?php } //end if(!$detect->isMobile() ?>
