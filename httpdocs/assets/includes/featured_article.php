<?php 
	
	$date = date("M d, Y", strtotime($featuredArticle['date_updated']));
	$linkToArticle = 'http://www.puckermob.com/'.$featuredArticle['cat_dir_name'].'/'.$featuredArticle["article_seo_title"];
	$linkToImage = 'http://cdn.puckermob.com/articlesites/puckermob/large/'.$featuredArticle['article_id'].'_tall.jpg';
	$linkToContributor = $config['this_url'].'contributors/'.$featuredArticle['contributor_seo_name'];
	$linkToACategory = $config['this_url'].$featuredArticle['cat_dir_name'];
	if ( $detect->isMobile() ) { ?>

		<div class="columns small-12 second-popular-articles-cont article-id" id="<?php echo 'article-'.$articleIndex; ?>" data-info-url="<?php echo $linkToArticle; ?>">
			<div class="row imageContainer" id="<?php echo 'article-'.$articleIndex; ?>">
				<div class="small-12 columns imageCenterer">
					<a  class="" href="<?php echo $linkToArticle; ?>" >
						<img src="<?php echo $linkToImage; ?>" alt="<?php echo  $featuredArticle['article_title']; ?>" />
					</a>
				</div>
			</div>				
			<div class="small-12 columns second-popular-article-title">
				<h2 class="left small-12 padding-top">
					<a  class="" href="<?php echo $linkToArticle; ?>" >
					<?php echo $featuredArticle['article_title']; ?>
				    </a>
				</h2>
			</div>
			<div class="second-article-date small-12 clear">
				<label class="small-6 left" ><?php echo $date; ?></label>
				<label class="small-6 span-holder-shares"></label>
			</div>
		</div>

<?php } else {?>
<div class="columns mobile-12 small-12 medium-12 large-12 xlarge-12 no-padding featured" id="article-featured-1">
	<a class="mobile-12 small-12 medium-12 large-12 xlarge-12" href="<?php echo $linkToArticle; ?>">
		<img src="<?php echo $linkToImage; ?>" alt='<?php echo $featuredArticle['article_title']?>'>
	</a>
	<div class="mobile-12 small-12 medium-12 large-12 xlarge-12 mobile-vertical-center padding-top">
		<p class="left uppercase" >
			<!--<span class="span-category <?php //echo $featuredArticle['cat_dir_name']?>"><a href="<?php //echo $linkToACategory; ?>" ><?php //echo $featuredArticle['cat_name']?></a></span>-->
			<span class="span-date"><?php echo $date; ?></span>
        </p>
		<p class="right uppercase">
			<span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $featuredArticle['contributor_name']; ?></a></span>
		</p>
		<a class="left clear-left" href="<?php echo $linkToArticle; ?>">
			<h1 class="h1-large-article"><?php echo $featuredArticle['article_title']?></h1>
		</a>
	</div>
</div>
<hr class="padding-top">
<?php } ?>