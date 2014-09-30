<?php
require_once('../assets/php/config.php');
$sortId = 1;
if(isset($_GET['sort'])){
	switch($_GET['sort']){
		case $_GET['sort'] == 'mp':
		$sortId = 2;
		break;
		case $_GET['sort'] == 'mv':
		$sortId = 3;
		break;
		case $_GET['sort'] == 'az':
		$sortId = 4;
		break;
		case $_GET['sort'] == 'za':
		$sortId = 5;
		break;
	}
}
$contributorInfo = $mpArticle->getContributors(['contributorSEOName' => $_GET['c'], 'sortType' => $sortId]);
$mostReadArticles = $mpArticle->getArticles(['count' => 5, 'sortType' => 2]);

	// Dish of the Day the same on every page
$featuredArticle = $mpArticle->getFeatured(['featureType' => 2, 'articleCount' => 1, 'pageId' => 1]);

if($contributorInfo['contributors']){
	$omits = [];
	
	$contributorInfoObj = $contributorInfo['contributors'][0];
	$pageName = $contributorInfoObj['contributor_name'].' | '.$mpArticle->data['article_page_name'];

	$articlesPerPage = 9;

	$totalPages = ceil(count($contributorInfo['articles']['articles']) / $articlesPerPage);
	if($totalPages > 1){
		$currentPage = (isset($_GET['p'])) ? preg_replace('/[^0-9]/', '', $_GET['p']) : 1;
		if($currentPage > $totalPages) $currentPage = 1;
		$offset = ($currentPage - 1) * $articlesPerPage;
		$contributorInfo['articles']['articles'] = array_slice($contributorInfo['articles']['articles'], $offset, $articlesPerPage);
		$pagesArray['url'] = $config['this_url'].'contributors/'.$contributorInfoObj['contributor_seo_name'];
		$pagesArray['pages'] = $mpHelpers->getPages($currentPage, $totalPages);
	}

}else $mpShared->get404();
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="contributor">
	<?php include_once($config['include_path'].'header.php'); ?>
	<?php include_once($config['include_path'].'header_ad.php');?>
	<main id="main" class="row panel sidebar-on-right" role="main">
		<section id="puc-articles" class="sidebar-right shadow-on-large-up small-11 columns translate-fix sidebar-main-left">

			<section id="contributor-intro" class="small-12 columns sidebar-right">
				<h1>About <?php echo $contributorInfoObj['contributor_name']; ?></h1>
				<p><img class="shadow contrib-image" src="<?php echo $config['image_url'].'articlesites/contributors_redesign/'.$contributorInfoObj['contributor_image'];?>" alt="<?php echo $contributorInfoObj['contributor_name']; ?>" style="float: left;" /><?php echo trim(strip_tags($contributorInfoObj['contributor_bio'])); ?></p>
				<div id="author-links">
					<?php if(isset($contributorInfoObj['contributor_facebook_link']) && strlen($contributorInfoObj['contributor_facebook_link'])){ ?>
					<a href="<?php echo $contributorInfoObj['contributor_facebook_link']; ?>" class="small button facebook" target="_blank">
						<i class="fa fa-facebook"></i>Facebook
					</a>
					<?php } ?>
					<?php if(isset($contributorInfoObj['contributor_twitter_handle']) && strlen($contributorInfoObj['contributor_twitter_handle'])){ ?>
					<a href="http://www.twitter.com/<?php echo $contributorInfoObj['contributor_twitter_handle']; ?>" class="small button twitter" target="_blank">
						<i class="fa fa-twitter"></i>Twitter
					</a>
					<?php } ?>
					<?php if(isset($contributorInfoObj['contributor_blog_link']) && strlen($contributorInfoObj['contributor_blog_link'])){ ?>
					<a href="<?php echo $contributorInfoObj['contributor_blog_link']; ?>" class="small button" target="_blank">
						<i class="fa fa-external-link"></i><?php echo explode(' ', $contributorInfoObj['contributor_name'])[0]; ?>'s Website
					</a>
					<?php } ?>
					<a class="button small" href="<?php echo $config['this_url'].'contributors';?>"><i class="fa fa-users"></i>More Contributors</a>
				</div>
			</section>
			<?php if(isset($contributorInfo['articles']['articles']) && $contributorInfo['articles']['articles']){ ?>
			<section id="results" class="small-12 columns sidebar-right">
				<h2><?php echo $contributorInfoObj['contributor_name']; ?>'s Articles</h2>
				<?php
				$articleIndex = 1; 
				foreach ($contributorInfo['articles']['articles'] as $article) {
					if (isset($article['parent_category_page_directory']) && $article['parent_category_page_directory'] != 'categories-root/'){ 
						$link = $config['this_url'].$mpHelpers::linkToArticle($article['cat_dir_name'], $article['parent_category_page_directory']).$article['article_seo_title'];
					} else {
						$link = $config['this_url'].$mpHelpers::linkToArticle($article['cat_dir_name']).$article['article_seo_title'];
					}

					$articleDesc = (isset($article['article_desc']) && strlen($article['article_desc'])) ? $article['article_desc'] : $article['article_body'];
					$linkToImage = $config['image_url'].'articlesites/puckermob/large/'.$article['article_id'].'_tall.jpg';
					$date = date("M d, Y", strtotime($article['creation_date']));
					$linkToContributor = $config['this_url'].'contributors/'.$article['contributor_seo_name'];
					?>

					<article class="row" id="<?php echo 'article-'.$articleIndex;?>">

						<div class="columns mobile-12 small-12 medium-12 large-12 xlarge-12">
							<?php if ( $detect->isMobile() ) {  $articleIndex++;?>
							<a class="mobile-5 small-5 medium-5 large-5 xlarge-5 half-padding-right left" href="<?php echo $link; ?>">
								<img src="<?php echo $linkToImage; ?>" alt=''>
							</a>
							<div class="mobile-7 small-7 medium-7 large-7 xlarge-7 half-padding-left mobile-vertical-center vertical-align-center">
								<p class="vertical-center">
									<span class="span-category"><?php echo $article['cat_name']?></span>
									<small><?php echo $date; ?></small>
								</p>
								<a href="<?php echo $link; ?>">
									<h5><?php echo $article['article_title']?></h5>
								</a>
								<p><small>By <a href="<?php echo $linkToContributor; ?>" ><?php echo $article['contributor_name']; ?></a></small></p>
							</div>
							<?php }else{?>
							<?php $articleIndex++; ?>
							<a class="mobile-5 small-5 medium-5 large-6 xlarge-6 half-padding-right left" href="<?php echo $link; ?>">
								<img src="<?php echo $linkToImage; ?>" alt=''>
							</a>
							<div class="mobile-7 small-7 medium-7 large-6 xlarge-6 mobile-vertical-center vertical-align-center half-padding-left half-padding-right">
								<p class="uppercase">
									<span class="span-category"><?php echo $article['cat_name']?></span>
									<span class="span-date"><?php echo $date; ?></span>
								</p>
								<a href="<?php echo $link; ?>">
									<h1><?php echo $article['article_title']?></h1>
								</a>
								<p class="uppercase"><span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $article['contributor_name']; ?></a></span></p>
							</div>
							<?php } ?>
						</div>
					</div>
				</article>
				<hr />
				<?php } ?>
			</section>
			<?php } ?>
			<?php include_once($config['include_path'].'pagination.php');?>
			<?php if (!$detect->isMobile()) { ?>
			<div id="medianet-ad" class="ad-unit hide-for-print padding-right show-for-xxlarge-only"></div>
			<?php include_once($config['include_path'].'fromourpartners.php'); ?>
			<?php include_once($config['include_path'].'aroundtheweb.php'); 
		}?>
	</section>
	<?php if (!$detect->isMobile()) { 
		include_once($config['include_path'].'rightsidebar.php');
	} ?>
</main>
<?php include_once($config['include_path'].'footer.php'); ?>
<?php include_once($config['include_path'].'bottomscripts.php'); ?>
</body>
</html>