<?php
require_once('../assets/php/config.php');
$pageName = 'Contributors | '.$mpArticle->data['article_page_name'];
$sortId = 1;
$articleContributors = $mpArticle->getContributors(['count' => -1, 'sortType' => $sortId]);


$contributorsPerPage = 15;
$totalPages = ceil(count($articleContributors['contributors']) / $contributorsPerPage);
if($totalPages > 1){
	$currentPage = (isset($_GET['p'])) ? preg_replace('/[^0-9]/', '', $_GET['p']) : 1;
	if($currentPage > $totalPages) $currentPage = 1;
	$offset = ($currentPage - 1) * $contributorsPerPage;
	$articleContributors['contributors'] = array_slice($articleContributors['contributors'], $offset, $contributorsPerPage);
	$pagesArray['url'] = $config['this_url'].'contributors/';
	$pagesArray['pages'] = $mpHelpers->getPages($currentPage, $totalPages);
}

?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="contributors">
	<?php include_once($config['include_path'].'header.php'); ?>
	<?php include_once($config['include_path'].'header_ad.php');?>
	<main id="main" class="row panel sidebar-on-right" role="main">
		<section id="puc-articles" class="sidebar-right shadow-on-large-up small-11 columns translate-fix sidebar-main-left">
	<section id="contributors-list" class="small-12 columns sidebar-right">
					<h1>Contributors</h1>
					<?php
					foreach($articleContributors['contributors'] as $contributor){
						$contributor_img = $mpHelpers->stripUrls($contributor['article_page_full_url'], 'images').'articlesites/contributors_redesign/'.$contributor['contributor_image'];
						$fromFB = preg_match("/facebook/", $contributor['contributor_image']);
						if($fromFB){
							$contributor_img = $contributor['contributor_image'].'?type=large';
						}
					?>
					<div class="row">
						<div class="columns small-4 medium-3 large-4 xlarge-3 half-padding-right">
							<a href="<?php echo $config['this_url'].'contributors/'.$contributor['contributor_seo_name']; ?>"> 
								<img class="shadow" alt="<?php echo $contributor['contributor_name']; ?>" src="<?php  echo $contributor_img;?>">
							</a>
						</div>
						<div class="columns small-8 medium-9 large-8 xlarge-9 half-padding-left">
							<a href="<?php echo $config['this_url'].'contributors/'.$contributor['contributor_seo_name']; ?>">
								<h3><?php echo $contributor['contributor_name']; ?></h3>
							</a>
							<p><?php echo $mpHelpers->truncate(trim(strip_tags($contributor['contributor_bio'])), 200); ?> <a href="<?php echo $config['this_url'].'contributors/'.$contributor['contributor_seo_name']; ?>" >MORE</a></p>
						</div>
						<div id="author-links" class="small-12 column">
							<?php if(isset($contributor['contributor_facebook_link']) && strlen($contributor['contributor_facebook_link'])){ ?>
							<a href="<?php echo $contributor['contributor_facebook_link']; ?>" class="button small facebook" target="_blank">
								<i class="fa fa-facebook"></i>Facebook
							</a>
							<?php } ?>
							<?php if(isset($contributor['contributor_twitter_handle']) && strlen($contributor['contributor_twitter_handle'])){ ?>
							<a href="http://www.twitter.com/<?php echo $contributor['contributor_twitter_handle']; ?>" class="button small twitter" target="_blank">
								<i class="fa fa-twitter"></i>Twitter
							</a>
							<?php } ?>
							<?php if(isset($contributor['contributor_blog_link']) && strlen($contributor['contributor_blog_link'])){ ?>
							<a href="<?php echo $contributor['contributor_blog_link']; ?>" class="button small" target="_blank">
								<i class="fa fa-external-link"></i><?php echo explode(' ', $contributor['contributor_name'])[0]; ?>'s Website
							</a>
							<?php } ?>
						</div>
					</div>
					<hr>
					<?php }?>
				</section>
				<?php include_once($config['shared_include'].'pagination.php');?>
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