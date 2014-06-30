<?php 
	if (!isset($categoryInfo['cat_id'])){
		$categoryInfo = $MPNavigation->getCategoryInfoById(1);
	}

	$slideshowArticleSet = $mpArticle->getFeatured(['count' => -1,'featureType' => 3, 'pageId' => $categoryInfo['cat_id']]);

	if(isset($slideshowArticleSet["articles"]) && $slideshowArticleSet["articles"]){
?>
			<?php $slideshowArticleSet = $slideshowArticleSet['articles']; ?>

	<section id="slide-show-cont" style="">

		<h1>
			<?php echo $categoryInfo['category_header_slider_title']; 	?>
		</h1>
		<section id="slide-show">
			 <div id="slider" class="flexslider">
			<ul class="bx-slider slides">
				<?php foreach($slideshowArticleSet as $slideNumber => $slideshowArticle){ 
					if ($slideshowArticle['parent_dir_name'] != $slideshowArticle['cat_dir_name']){ 
						$link = $config['this_url'].$slideshowArticle['parent_dir_name'].'/'.$slideshowArticle['cat_dir_name'].'/'.$slideshowArticle['article_seo_title'];
					} else {
						$link = $config['this_url'].$slideshowArticle['cat_dir_name'].'/'.$slideshowArticle['article_seo_title'];
					}
				?>
				<li class="slide">
				  	<div class="left">
					<?php 
						echo '<a href="'.$link.'" >';
							echo '<img src="'.$config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/tall/'.$slideshowArticle['article_id'].'_tall.jpg" alt="'.$slideshowArticle['article_title'].' Preview Image" />';
						echo '</a>';
					?>
				  	</div>
				  	<div class="right">
				  		<section class="pager">
							<p><a href="#" class="right-prev-arrow">&lt;</a> <?php echo $slideNumber+1 . " of " . count($slideshowArticleSet); ?> <a href="" class="right-next-arrow">&gt;</a></p>
						</section>
				  		<h2><a href="<?php echo $link; ?>" ><?php echo $slideshowArticle['article_title']; ?></a></h2>
				  		<p><?php echo $slideshowArticle['article_desc']; ?></p>
				  		<label class="get-recipe"><a href="<?php echo $link; ?>" title="Get this recipe!">Get Recipe</a></label>
				  	</div>
				  </li>
				<?php } ?>

			</ul></div>
			
			<div id="carousel" class="flexslider">
				<ul class="thumbs slides">
				<?php foreach ($slideshowArticleSet as $slideshowLink){ ?>
					  <li class="thumbs-div">
						<?php 
							echo '<img src="'.$config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/preview/'.$slideshowLink['article_preview_img'].'" alt="'.$slideshowLink['article_title'].' Preview Image" />';
						?>
					  </li>
				<?php } ?>
				</ul>
		</div>
		</seciton>
	</section>
</section>
<?php }?>
