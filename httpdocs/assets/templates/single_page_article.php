<?php
// Initialize variables - fixes undefined index error
if (isset($articleInfoObj)) {
	$article_title = $articleInfoObj['article_title'];;
	$article_id = $articleInfoObj['article_id'];
	$article_body = $articleInfoObj['article_body'];
	$article_category = $articleInfoObj['cat_name'];
	$date = date("M d, Y", strtotime($articleInfoObj['creation_date']));
	$contributor_name = $articleInfoObj['contributor_name'];
	$linkToContributor = $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name'];
	
}
?>

<article id="article-<?php echo $article_id; ?>" class="columns small-12 <?php if($detect->isMobile()) echo " no-padding "; ?>">

	<section id="article-summary" class="small-12 column">
		<h1><?php echo $article_title; ?></h1>
		<div class="row">
			<section id="social-buttons" class="small-12 xxlarge-7 columns  hide-for-print">
				<button id="facebook-button" class="columns small-3 button small facebook">
					<i class="fa fa-facebook fa-fw"></i><div id="facebook-count" class="social-fade-in">0</div>
				</button>
				<button id="twitter-button" class="columns small-3 button small twitter">
					<i class="fa fa-twitter fa-fw"></i><div id="twitter-count" class="social-fade-in">0</div>
				</button>
				<button id="pinterest-button" class="columns small-3 button small pinterest">
					<i class="fa fa-pinterest fa-fw"></i><div id="pinterest-count" class="social-fade-in">0</div>
				</button>
				<button id="google-plus-button" class="columns small-3 button small google-plus">                
					<i class="fa fa-google-plus fa-fw"></i><div id="google-plus-count" class="social-fade-in">0</div>
				</button>
			</section>
			<div id ="email-comment" class="small-3 xxlarge-3 columns hide-for-print no-padding show-for-large-up" style="text-align: right;">
				<a href="#disqus-container" ><i class="fa fa-comment-o fa-25x no-margin"></i></a>
				<a href="mailto:?subject=Hey,%20check%20out%20this%20article&body=Hi%20there,%0D%0D%20I%20saw%20this%20great%20article%20on%20Pucker%20Mob%20(http://www.puckermob.com/).%0D%0D%20Check%20it%20out:%20<?php echo $articleInfoObj['article_title']; ?>%20(<?php echo urlencode($mpHelpers->curPageURL()); ?>)%0D%0DCheers!">
					<i class="fa fa-envelope-o fa-25x no-margin"></i>
				</a>
			</div>
		</div>
		<div class="row">
			<div id="article-image" class="small-12 columns half-padding-right-on-lg">
				<meta property="" itemprop="photo" content="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article_id.'_tall.jpg'; ?>" />
				<img src="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Post Image">
			</div>
		</div>
		<div class="row">
			<div class="columns mobile-12 small-7 medium-7 large-12 xlarge-12 padding-top half-padding-right-on-lg">
				<p class="left uppercase">
					<span class="span-category"><?php echo $article_category; ?></span>
					<span class="span-date"><?php echo $date; ?></span>
				</p>
				<p class="right uppercase"><span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $contributor_name; ?></a></span></p>
			</div>
		</div>
		<div class="row">
			<section id="article-content" class="small-12 column">
				<p><?php echo $article_body; ?></p>
			</section>
		</div>
		<?php include_once($config['include_path'].'sharedicons.php');?>
	</section>
</article>

