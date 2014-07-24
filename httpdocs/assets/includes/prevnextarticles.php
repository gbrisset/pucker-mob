<?php
if(isset($articleInfoObj) && $articleInfoObj){
	if( !isset($article_id) ) $article_id = $articleInfoObj['article_id'];
	$cat_id = $category['cat_id'];;

	$nextArticle = $mpArticle->getPrevArticle( $article_id, $cat_id );
	$prevArticle = $mpArticle->getNextArticle( $article_id, $cat_id );
	$borderClassContainer = 'add-border add-shadow';
	$borderClass = 'remove-border';
	$rightBorder = 'right-border';

	if( !$nextArticle ){
		$borderClassContainer = 'remove-border';
		$borderClass = 'add-border add-shadow';
		$rightBorder = '';
	}
	if( !$prevArticle ){
		$borderClassContainer = 'remove-border';
		$borderClass = 'add-border right add-shadow';
	}

	if ( $detect->isMobile() ) { ?>
	<div id="prev-next-articles" class="row  hide-for-print clear <?php echo $borderClassContainer; ?>">
		<?php
		if( isset($prevArticle) && $prevArticle){

			$prev_article_title = $prevArticle['article_title'];
			$prev_article_url = $config['this_url'].$prevArticle['cat_dir_name'].'/'.$prevArticle["article_seo_title"];
			?>
			<!-- PREV ARTICLE -->
			<div id="prev-article" class="columns mobile-6 small-6 medium-6 <?php echo $borderClass.' '.$rightBorder; ?>">
				<div class="columns mobile-12 small-12 half-padding">
					<div class="direction previous left">
						<a href="<?php echo $prev_article_url; ?>">
							<i class="fa fa-2x fa-caret-left left"></i>
							<p class="left">Previous</p>
						</a>
					</div>
					<p class="small-title align-right clear center-small-title"><a href="<?php echo $prev_article_url; ?>" class="prefetch"><?php echo $mpHelpers->truncate($prev_article_title, 60); ?></a></p>
				</div>
			</div>
			<?php } ?>


			<?php
			if( isset($nextArticle) && $nextArticle){

				$next_article_img = $config['image_url'].'articlesites/puckermob/large/'.$nextArticle['article_id'].'_tall.jpg';;
				$next_article_title = $nextArticle['article_title'];
				$next_article_url = $config['this_url'].$nextArticle['cat_dir_name'].'/'.$nextArticle["article_seo_title"];
				?>
				<!-- NEXT ARTICLE -->
				<div id="next-article" class="columns mobile-6 small-6 medium-6 <?php echo $borderClass; ?>">
					<div class="columns mobile-12 small-12 half-padding">
						<div class="direction next right">
							<a href="<?php echo $next_article_url; ?>">
								<i class="fa fa-2x fa-caret-right right"></i>
								<p class="right">Next</p>
							</a>
						</div>
						<p class="small-title align-lef clear center-small-title"><a href="<?php echo $next_article_url; ?>" class="prefetch"><?php echo $mpHelpers->truncate($next_article_title, 60); ?></a></p>
					</div>
				</div>
				<?php } ?>

			</div>
			<?php }else{ ?>

			<div id="prev-next-articles" class="row  hide-for-print clear <?php echo $borderClassContainer; ?>">
				<?php
				if( isset($prevArticle) && $prevArticle){

					$prev_article_img = $config['image_url'].'articlesites/puckermob/large/'.$prevArticle['article_id'].'_tall.jpg';;
					$prev_article_title = $prevArticle['article_title'];
					$prev_article_url = $config['this_url'].$prevArticle['cat_dir_name'].'/'.$prevArticle["article_seo_title"];
					?>
					<!-- PREV ARTICLE -->
					<div id="prev-article" class="columns mobile-6 small-6 medium-6 <?php echo $borderClass.' '.$rightBorder; ?>">
						<div class="columns small-12  large-5 half-padding">
							<div class="direction previous">
								<a href="<?php echo $prev_article_url; ?>">
									<i class="fa fa-2x fa-caret-left left"></i>
									<p class="left">Previous</p>
								</a>
							</div>
							<p class="small-title align-right clear center-small-title"><a href="<?php echo $prev_article_url; ?>" class="prefetch"><?php echo $mpHelpers->truncate($prev_article_title, 60); ?></a></p>
						</div>
						<div class="columns small-7 half-padding show-on-large-up">
							<a href="<?php echo $prev_article_url; ?>"><img src="<?php echo $prev_article_img; ?>" alt="<?php echo $prev_article_title.' Image'; ?>" /></a>
						</div>
					</div>
					<?php } ?>


					<?php
					if( isset($nextArticle) && $nextArticle){

						$next_article_img = $config['image_url'].'articlesites/puckermob/large/'.$nextArticle['article_id'].'_tall.jpg';;
						$next_article_title = $nextArticle['article_title'];
						$next_article_url = $config['this_url'].$nextArticle['cat_dir_name'].'/'.$nextArticle["article_seo_title"];
						?>
						<!-- NEXT ARTICLE -->
						<div id="next-article" class="columns mobile-6 small-6 medium-6 <?php echo $borderClass; ?>">

							<div class="columns small-7 half-padding show-on-large-up">
								<a href="<?php echo $next_article_url; ?>"><img src="<?php echo $next_article_img; ?>" alt="<?php echo $next_article_title.' Image'; ?>" /></a>
							</div>
							<div class="columns small-12  large-5 half-padding">
								<div class="direction next">
									<a href="<?php echo $next_article_url; ?>">
										<i class="fa fa-2x fa-caret-right right"></i>
										<p class="right">Next</p>
									</a>
								</div>
								<p class="small-title align-lef clear center-small-title"><a href="<?php echo $next_article_url; ?>" class="prefetch"><?php echo $mpHelpers->truncate($next_article_title, 60); ?></a></p>
							</div>

						</div>
						<?php } ?>

					</div>

					<?php 
				}
			} ?>