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
	$contributor_image = 'http://images.puckermob.com/articlesites/contributors_redesign/'.$contributorInfoObj['contributor_image'];
	//'http://images.puckermob.com/articlesites/contributors_redesign/1103_contributor.png';
	$fromFB = preg_match("/facebook/", $contributorInfoObj['contributor_image']);
	if($fromFB){
		$contributor_image = $contributorInfoObj['contributor_image'].'?type=large';
	}
	
	$pageName = $contributorInfoObj['contributor_name'].' | '.$mpArticle->data['article_page_name'];

	$articlesPerPage = 15;

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
		<!-- LEFT SIDE BAR -->
		<?php include_once($config['include_path'].'left_side_bar.php'); ?>
		
		<section id="puc-articles" class="contributor_page sidebar-right small-12 large-11 columns translate-fix sidebar-main-left">
			<h1 class="contributor-title">Contributors</h1>
			<section id="contributor-intro" class="small-12 left">
				<?php if($detect->isMobile()){?>
				<div class="contributor-img small-12 left">
					<img class="contrib-image" src="<?php echo $contributor_image; ?>" alt="<?php echo $contributorInfoObj['contributor_name']; ?>" />
					<h2><?php echo $contributorInfoObj['contributor_name']; ?></h2>
				</div>
				<div class="small-12 left" id="contributor-bio">
					
					<p class="contributor-bio-text">
						<?php echo trim(strip_tags($contributorInfoObj['contributor_bio'])); ?>
					</p>
				</div>
				
				<?php }else{?>
				<div class="contributor-img small-12 large-2 left inline-block">
					<img class="contrib-image" src="<?php echo $contributor_image; ?>" alt="<?php echo $contributorInfoObj['contributor_name']; ?>" />
				</div>
				<div class="left inline-block" id="contributor-bio">
					<h2><?php echo $contributorInfoObj['contributor_name']; ?></h2>
					<p class="contributor-bio-text">
						<?php echo trim(strip_tags($contributorInfoObj['contributor_bio'])); ?>
					</p>
				</div>
				<div id="author-links" class="small-12 large-3 left inline-block show-on-large-up">
					<?php if(isset($contributorInfoObj['contributor_facebook_link']) && strlen($contributorInfoObj['contributor_facebook_link'])){ ?>
					<a href="<?php echo $contributorInfoObj['contributor_facebook_link']; ?>" class="small" target="_blank">
						<i class="fa fa-facebook"></i>
						<?php 
						$facebookObj = explode('/', $contributorInfoObj['contributor_facebook_link']);
						
						if(isset($facebookObj) && $facebookObj ){

							echo '/'.$facebookObj[count($facebookObj)-1];
						}?>
					</a>
					<?php } ?>
					
					<?php if(isset($contributorInfoObj['contributor_twitter_handle']) && strlen($contributorInfoObj['contributor_twitter_handle'])){ ?>
					<a href="http://www.twitter.com/<?php echo $contributorInfoObj['contributor_twitter_handle']; ?>" class="small " target="_blank">
						<i class="fa fa-twitter"></i>
						<?php  echo $contributorInfoObj['contributor_twitter_handle']; ?>
					</a>
					<?php } ?>
					
					<?php if(isset($contributorInfoObj['contributor_blog_link']) && strlen($contributorInfoObj['contributor_blog_link'])){ ?>
					<a href="<?php echo $contributorInfoObj['contributor_blog_link']; ?>" class="small" target="_blank">
						<i class="fa fa-desktop"></i>
						<?php echo substr($contributorInfoObj['contributor_blog_link'], 0, 20).'...'; ?>
						<?php //echo $contributorInfoObj['contributor_blog_link']; ?>
					</a>
					<?php } ?>
					<a class="small" href="<?php echo $config['this_url'].'contributors';?>">
						<i class="fa fa-users"></i>
						More Contributors
					</a>
				</div>
				<?php }?>
			</section>
			<?php if(isset($contributorInfo['articles']['articles']) && $contributorInfo['articles']['articles']){ ?>
			<section id="results" class="clear">
				<h2 class="padding-top clear"><?php echo $contributorInfoObj['contributor_name']; ?>'s Articles</h2>
				<?php
				$articleIndex = 1; 
				foreach ($contributorInfo['articles']['articles'] as $article) {
					if (isset($article['parent_category_page_directory']) && $article['parent_category_page_directory'] != 'categories-root/'){ 
						$link = $config['this_url'].$mpHelpers::linkToArticle($article['cat_dir_name'], $article['parent_category_page_directory']).$article['article_seo_title'];
					} else {
						$link = $config['this_url'].$mpHelpers::linkToArticle($article['cat_dir_name']).$article['article_seo_title'];
					}

					$articleDesc = (isset($article['article_desc']) && strlen($article['article_desc'])) ? $article['article_desc'] : $article['article_body'];
					$linkToImage = 'http://images.puckermob.com/articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article['article_id'].'_tall.jpg';
					$date = date("M d, Y", strtotime($article['creation_date']));
					$linkToContributor = $config['this_url'].'contributors/'.$article['contributor_seo_name'];
					?>

					<article class="row" id="<?php echo 'article-'.$articleIndex;?>">
						<div class="columns mobile-12 small-12 medium-12 large-12 xlarge-12">
							<?php if ( $detect->isMobile() ) {  $articleIndex++;?>
							<a class="mobile-12 small-12 large-5 xlarge-5 no-padding left" href="<?php echo $link; ?>">
								<img src="<?php echo $linkToImage; ?>" >
							</a>
							<div class="mobile-12 small-12 large-7 xlarge-7 no-padding" style="padding:0 !important;">
								<p style="margin:0;">
									<span class="span-category"><?php echo $article['cat_name']?></span>
									<small><?php echo $date; ?></small>
								</p>
								<a href="<?php echo $link; ?>">
									<h1 style="margin-bottom:0;"><?php echo $article['article_title']?></h1>
								</a>
								<!--<p><small>By <a href="<?php echo $linkToContributor; ?>" ><?php echo $article['contributor_name']; ?></a></small></p>-->
							</div>
							<?php }else{?>
							<?php $articleIndex++; ?>
							<a class="mobile-5 small-5 medium-5 large-6 xlarge-6 half-padding-right left" href="<?php echo $link; ?>">
								<img src="<?php echo $linkToImage; ?>" style="height: 165px; width: 301px;">
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

		include_once($config['include_path'].'left_side_bar.php');
	} ?>
</main>
<?php include_once($config['include_path'].'footer.php'); ?>
<?php include_once($config['include_path'].'bottomscripts.php'); ?>
</body>
</html>