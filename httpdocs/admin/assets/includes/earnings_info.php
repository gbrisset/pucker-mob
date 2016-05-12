	<?php if(isset($earnings) && $earnings){?>
		<div class="small-12 columns radius right-side-box margin-bottom">
			<div class="">
					<label class="uppercase light-green">U.S. VISITS: 
					<span style="color: #222;"><?php echo $earnings['total_us_pageviews']; ?></span></label>
			</div>
		</div>
	<?php }?>
	<?php if(isset($best_article) && $best_article[0]){?>
	<div class="small-12 columns radius right-side-box half-margin-top">
		<div class="">
				<label class="uppercase light-green">BEST performing article:</label>
				<label >
					<a style="color: #222; " href="http://www.puckermob.com/<?php echo $best_article[0]['cat_dir_name'].'/'.$best_article[0]['article_seo_title']; ?>" target="_blank">
						<?php echo $best_article[0]['article_title']; ?>
					</a>
				</label>
		</div>
	</div>
	<?php }?>