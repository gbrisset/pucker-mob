<?php
require_once('../assets/php/config.php');
$pageName = 'Contributors | '.$mpArticle->data['article_page_name'];
$sortId = 1;
$articleContributors = $mpArticle->getContributors(['count' => -1, 'sortType' => $sortId]);


$contributorsPerPage = 25;
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
		<!-- LEFT SIDE BAR -->
		<?php include_once($config['include_path'].'left_side_bar.php'); ?>
		
		<section id="puc-articles" class="contributor_page sidebar-right small-12 large-11 columns translate-fix sidebar-main-left">
			<h1 class="contributor-title">Contributors</h1>

			
					<?php
					foreach($articleContributors['contributors'] as $contributor){
						$contributor_img = $mpHelpers->stripUrls($contributor['article_page_full_url'], 'images').'articlesites/contributors_redesign/'.$contributor['contributor_image'];
						$fromFB = preg_match("/facebook/", $contributor['contributor_image']);
						if($fromFB){
							$contributor_img = $contributor['contributor_image'].'?type=large';
						}


					?>
					<section id="contributor-intro" class="small-12 left">
						<?php if($detect->isMobile()){?>
						<div class="contributor-img small-12 left">
							<img class="contrib-image" src="<?php echo $contributor_img; ?>" alt="<?php echo $contributor['contributor_name']; ?>" />
							<a href="<?php echo $config['this_url'].'contributors/'.$contributor['contributor_seo_name']; ?>" >
							<h2><?php echo $contributor['contributor_name']; ?></h2>
							</a>
						</div>
						<div class="small-12 left" id="contributor-bio">
							
							<p class="contributor-bio-text">
								<?php echo $mpHelpers->truncate(trim(strip_tags($contributor['contributor_bio'])), 120); ?> 
								<a href="<?php echo $config['this_url'].'contributors/'.$contributor['contributor_seo_name']; ?>" >MORE</a>
							</p>
						</div>
						
						<?php }else{?>
						<div class="contributor-img small-12 large-2 left inline-block">
							<a href="<?php echo $config['this_url'].'contributors/'.$contributor['contributor_seo_name']; ?>"> 
								<img class="contrib-image" alt="<?php echo $contributor['contributor_name']; ?>" src="<?php  echo $contributor_img;?>">
							</a>
						</div>
							<div class="small-12 left" id="contributor-bio">
							<a href="<?php echo $config['this_url'].'contributors/'.$contributor['contributor_seo_name']; ?>">
								<h2><?php echo $contributor['contributor_name']; ?></h2>
							</a>
							<p><?php echo $mpHelpers->truncate(trim(strip_tags($contributor['contributor_bio'])), 75); ?> 
							<a href="<?php echo $config['this_url'].'contributors/'.$contributor['contributor_seo_name']; ?>" >MORE</a></p>
						</div>
						<div id="author-links" class="small-12 large-3 left inline-block show-on-large-up">
							<?php if(isset($contributor['contributor_facebook_link']) && strlen($contributor['contributor_facebook_link'])){ ?>
							<a href="<?php echo $contributor['contributor_facebook_link']; ?>" class="small" target="_blank">
								<i class="fa fa-facebook"></i>
								<?php 
								$facebookObj = explode('/', $contributor['contributor_facebook_link']);
								//var_dump($facebookObj);
								if(isset($facebookObj) && $facebookObj ){

									echo '/'.$facebookObj[count($facebookObj)-1];
								}?>
							</a>
							<?php } ?>
							<?php if(isset($contributor['contributor_twitter_handle']) && strlen($contributor['contributor_twitter_handle'])){ ?>
							<a href="http://www.twitter.com/<?php echo $contributor['contributor_twitter_handle']; ?>" class=" small" target="_blank">
								<i class="fa fa-twitter"></i><?php  echo $contributor['contributor_twitter_handle']; ?>
							</a>
							<?php } ?>
							<?php if(isset($contributor['contributor_blog_link']) && strlen($contributor['contributor_blog_link'])){ ?>
							<a href="<?php echo $contributor['contributor_blog_link']; ?>" class=" small" target="_blank">
								<i class="fa fa-desktop"></i>
								<?php echo substr($contributor['contributor_blog_link'], 0, 15).'...'; ?>
							</a>
							<?php } ?>
						</div>
						<?php }?>
					</section>
				
					<?php }?>
				
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