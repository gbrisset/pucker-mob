<?php if(isset($featuredVideos) && $featuredVideos){ ?>
<section id="favorites-cat-dishes" class="favorites-dishes-videos">
	<h1>Popular Videos</h1>

	<section class="top-articles">
		<?php foreach($featuredVideos as $videoInfo){?>
		<div class="single-article" id="article-video-<?php echo $videoInfo['article_page_series_id']; ?>">
			<div class="article-img">
				<a href="<?php echo $config['this_url'].'videos/'.$videoInfo['article_page_series_seo'].'/'.$videoInfo['syn_video_filename'];?>">
					<img src="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/series/'.$videoInfo['article_page_series_video_prev_img'];?>" alt='<?php echo $videoInfo['syn_video_title']?> Image' />
					<span id="video-icon-span" class="has-video">
						<img src="<?php echo $config['image_url']; ?>sharedimages/simple_dish_play_button.png" alt="Video Image"/>
					</span>
				</a>
			</div>
			<h2>
				<a href="<?php echo $config['this_url'].'videos/'.$videoInfo['article_page_series_seo'].'/'.$videoInfo['syn_video_filename'];?>">
					<?php echo $videoInfo['syn_video_title']?>
				</a>
			</h2>
		</div>
		<?php }?>
	</section>
</section>
<?php }?>