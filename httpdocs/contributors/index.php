<?php
require_once('../assets/php/config.php');
$pageName = 'Contributors | '.$mpArticle->data['article_page_name'];
$sortId = 1;
$articleContributors = $mpArticle->getContributors(['count' => -1, 'sortType' => $sortId]);

$contributorsPerPage = 2500;
$totalPages = ceil(count($articleContributors['contributors']) / $contributorsPerPage);
if($totalPages > 1){
	$currentPage = (isset($_GET['p'])) ? preg_replace('/[^0-9]/', '', $_GET['p']) : 1;
	if($currentPage > $totalPages) $currentPage = 1;
	$offset = ($currentPage - 1) * $contributorsPerPage;
	$articleContributors['contributors'] = array_slice($articleContributors['contributors'], $offset, $contributorsPerPage);
	$pagesArray['url'] = $config['this_url'].'contributors/';
	$pagesArray['pages'] = $mpHelpers->getPages($currentPage, $totalPages);
}

	$writers = [];
	$probloggers = [];

	foreach($articleContributors['contributors'] as $data){
		if($data['contributor_id'] == '1878' || $data['contributor_id'] == '2437' || $data['contributor_id'] == '121' || $data['contributor_id'] == '2313') continue;
		if($data['user_type'] != '8'){
			$writers[] = $data;
		}else $probloggers[] = $data;
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
					<!-- IN HOUSE WRITERS -->
					<div class="writers">
					<h1 class="contributor-title">In-House Writers</h1>
					
					<?php
					foreach($writers as $contributor){
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
								if(isset($facebookObj) && $facebookObj ){

									echo '/'.substr($facebookObj[count($facebookObj)-1], 0, 10).'...';
								}?>
							</a>
							<?php } ?>
							<?php if(isset($contributor['contributor_twitter_handle']) && strlen($contributor['contributor_twitter_handle'])){ ?>
							<a href="http://www.twitter.com/<?php echo $contributor['contributor_twitter_handle']; ?>" class=" small" target="_blank">
								<i class="fa fa-twitter"></i>
								<?php echo substr($contributor['contributor_twitter_handle'], 0, 10).'...'; ?>
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
					</div>
					<!-- PRO BLOGGERS -->
					<?php if($probloggers && count($probloggers) > 0 ){?>
					<div class="probloggers left margin-bottom">
						<h1 class="contributor-title clear" style="padding-top: 2rem;">PRO Bloggers</h1>
				
						<?php
						foreach($probloggers as $contributor){
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
									if(isset($facebookObj) && $facebookObj ){

										echo '/'.substr($facebookObj[count($facebookObj)-1], 0, 10).'...';
									}?>
								</a>
								<?php } ?>
								<?php if(isset($contributor['contributor_twitter_handle']) && strlen($contributor['contributor_twitter_handle'])){ ?>
								<a href="http://www.twitter.com/<?php echo $contributor['contributor_twitter_handle']; ?>" class=" small" target="_blank">
									<i class="fa fa-twitter"></i>
									<?php echo substr($contributor['contributor_twitter_handle'], 0, 10).'...'; ?>
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
					
						<?php } ?>
					</div>
					<?php } ?>
				<?php //include_once($config['shared_include'].'pagination.php');?>
				<?php if (!$detect->isMobile()) { ?>
				<!--<div id="medianet-ad" class="ad-unit hide-for-print padding-right show-for-xxlarge-only"></div>-->
				<?php //include_once($config['include_path'].'fromourpartners.php'); ?>
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