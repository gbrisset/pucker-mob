<?php
	require_once('assets/php/config.php');

	$pageName = $mpArticle->data['article_page_name'];
	$omits = [];
	//$mostReadArticles = $mpArticle->getArticles(['count' => 5, 'sortType' => 2]);
	$featuredContributor = $mpArticle->getContributors(['featured' => true]);

	// Dish of the Day the same on every page
	$featuredArticle = $mpArticle->getFeatured(['featureType' => 2, 'articleCount' => 1, 'pageId' => 1]);

	if(is_array($featuredArticle) && isset($featuredArticle['ids'])) $omits = array_merge($omits, $featuredArticle['ids']);
	
	$recentArticles = $mpArticle->getArticles(['count' =>3, 'omit' => $omits]);
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path'].'head.php');?>
<style>
	.return-policy-bold { font-weight: bold; font-size: 1.1em; text-decoration: underline; }
</style>
<body>
	<?php include_once($config['include_path'].'header.php');?>

	<?php include_once($config['include_path'].'sidebarsearch.php'); ?>

	<?php include_once($config['include_path'].'superbanner.php'); ?>

	<section id="maint-cont" role="content">
		
		<section class="top-content">
			<div class="left-content">
				<section class="terms-conditions">

				<h2>Return Policy</h2>

				<p>
					We have selected these products for their outstanding quality and are sure that you will be delighted with your purchase. If for any reason your order does not arrive in perfect condition or you are not satisfied with the goods please contact us within 5 days of receipt of the products and we will substitute the unopened items. 
				</p>

				<p>
					We respect your privacy. Please take a moment to read our <a href="policy.php#privacy">Privacy Policy</a>.
				</p>
				<p>
					Shipping and/or handling charges on the original order will not be refunded. Customer is responsible for shipping costs to return unopened items for a refund. If you receive damaged goods please notify us immediately and keep the goods in the original packaging.
				</p>

				<p class="return-policy-bold">
					FINAL SALE ON PERISHABLE ITEMS
				</p>

				</section>
			</div>

			<div class="right-content">
				<?php include_once($config['include_path'].'sidebarconnect.php');?>
				
				<?php include_once($config['include_path'].'featuredarticle.php');?>

				<?php include_once($config['include_path'].'contest_display_ads.php');?>

				<?php if( isset($mpArticle->data["has_sponsored_by"]) && !$mpArticle->data["has_sponsored_by"] ){ ?>
					<div class="ad-300" id="ad-300-btf1"></div>
				<?php } ?>

				<?php include_once($config['include_path'].'sidebarmostread.php');?>

				<?php include_once($config['include_path'].'ask.php');?>


				<?php include_once($config['include_path'].'recipebox.php');?>
				
				<?php if( isset($mpArticle->data["has_sponsored_by"]) && !$mpArticle->data["has_sponsored_by"] ){ ?>
					<div class="ad-300" id="ad-300-btf2"></div>
				<?php } ?>
				
				<?php include_once($config['include_path'].'sidebarpromotedarticles.php');?>
				<?php include_once($config['include_path'].'toppinspinterest.php');?>
			</div>
		</section>

		<section class="bottom-content">
			<div class="left-content"></div>
			<div class="right-content">
				<section id="featured-article-ph" data-set="featured-article-append-around"></section>
				<section id="featured-ask-ph" data-set="featured-ask-append-around"></section>
				<section id="recipe-box-ph" data-set="recipe-box-append-around"></section>	
				<section id="sidebar-most-viewed-ph" data-set="most-viewed-append-around"></section>
			</div>
		</section>
	</section>
	<?php include_once($config['include_path'].'superbannerbottom.php'); ?>
	
	<?php include_once($config['include_path'].'footer.php');?>
	
	<?php include_once($config['include_path'].'bottomscripts.php');?>
</body>
</html>