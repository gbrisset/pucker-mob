<?php if(isset($seriesInfo) && $seriesInfo){ ?>
	<section id="coocking-shows">
		<h1>Cooking shows</h1>

		<section class="videos-shows">
			<?php 
			$count = 0;

			foreach($seriesInfo as $showInfo){

				if($showInfo["article_page_series_visible_hp"]){
					$class = 'right';
					if( ($count%2) != 0 ) $class = 'left'; 
				?>
				<div class="<?php echo $class ?>" id="article-serie-<?php echo $showInfo['article_page_series_id']?>">
					<a href="<?php echo $config['this_url'].'videos/'.$showInfo['article_page_series_seo'] ?>">
						<img src="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/series/'.$showInfo['article_page_series_image'];?>" alt='<?php echo $showInfo['article_page_series_title']?> Image' />
					</a>
					<h2><a href="<?php echo $config['this_url'].'showInfo/'.$showInfo['article_page_series_seo'] ?>"><?php echo $showInfo['article_page_series_title']?></a></h2>
					<p><?php echo $showInfo['article_page_series_prev_desc']?></p>
				</div>
				
				<?php 
					$count++;
				}
			}?>
		</section>
	</section>
<?php } ?>