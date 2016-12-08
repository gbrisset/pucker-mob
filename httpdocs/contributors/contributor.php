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

if($contributorInfo['contributors']){
	$omits = [];
	
	$contributorInfoObj = $contributorInfo['contributors'][0];
	$contributor_image = 'http://images.puckermob.com/articlesites/contributors_redesign/'.$contributorInfoObj['contributor_image'];
	$fromFB = preg_match("/facebook/", $contributorInfoObj['contributor_image']);
	if($fromFB){
		$contributor_image = $contributorInfoObj['contributor_image'].'?type=large';
	}
	
	$pageName = $contributorInfoObj['contributor_name'].' | '.$mpArticle->data['article_page_name'];
	$articleList = $mpArticle->getContributorsArticleList($contributorInfoObj['contributor_id']);
	$articlesPerPage = 20;
	$contributorInfo['articles']['articles'] = $articleList;

	$totalPages = ceil(count($articleList) / $articlesPerPage);
	if($totalPages > 1){
		$currentPage = (isset($_GET['p'])) ? preg_replace('/[^0-9]/', '', $_GET['p']) : 1;
		if($currentPage > $totalPages) $currentPage = 1;
		$offset = ($currentPage - 1) * $articlesPerPage;
		$contributorInfo['articles']['articles'] = array_slice($articleList, $offset, $articlesPerPage);
		$pagesArray['url'] = $config['this_url'].'contributors/'.$contributorInfoObj['contributor_seo_name'];
		$pagesArray['pages'] = $mpHelpers->getPages($currentPage, $totalPages);
	}

}else $mpShared->get404();
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="contributor" class="public-profile">
	<?php if($detect->isMobile()){
		include_once($config['include_path'].'header.php'); 
	}else{
		include_once($config['include_path'].'new_header.php'); 
	}
	?>
	<?php include_once($config['include_path'].'header_ad.php'); ?>
	
	<main id="main" class="row panel" role="main">
		<div  class="contributor_page sidebar-right small-12 large-8 columns sidebar-main-left no-padding">
			<!-- ABOUT THIS AUTHOR -->
			<div class="small-12 xxlarge-12 columns no-padding">	
				<div class="small-12 columns padding-bottom no-padding">
					<div class="small-4 large-2 columns no-padding">
						<img id="img-profile" src="<?php echo $contributor_image; ?>" alt="User Image" />
					</div>
					<div class="small-8 large-10 columns no-padding-right cont-info valign-middle" style="">
						<div class="small-12 large-6 columns" >
							<div class="small-12 large-6 columns">
								<p style="margin-top: 11px;"><?php echo $contributorInfoObj['contributor_name']; ?></p>
								<p class=""><?php echo $contributorInfoObj['contributor_location']; ?></p>
								<p class="">Joined: <?php echo date('F d, Y', strtotime($contributorInfoObj['creation_date'])); ?></p>
							</div>
						</div>
						<?php if( !$detect->isMobile() ){?>
						<div class="small-12  large-6 columns">
							<div id="author-links" class="small-12 large-12 columns inline-block no-padding-right">
							<?php if(isset($contributorInfoObj['contributor_facebook_link']) && strlen($contributorInfoObj['contributor_facebook_link'])){ ?>
							<a href="<?php echo $contributorInfoObj['contributor_facebook_link']; ?>" class="small" target="_blank" >
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
							</a>
							<?php } ?>
							<a class="small" href="<?php echo $config['this_url'].'contributors';?>">
								<i class="fa fa-users"></i>
								More Contributors
							</a>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>

			<div class="small-12 columns no-padding padding-top">
				<h2 class="bold">ABOUT ME</h2>
				<p><?php echo $contributorInfoObj['contributor_bio']; ?></p>
			</div>
		</div>

		<!--  ARTICLE LIST -->
		<div class="small-12 columns no-padding margin-bottom margin-top">
			<h2 class="bold"><?php echo $contributorInfoObj['contributor_name']; ?>'s Articles</h2>
			<table class="small-12">
			<?php if(isset($articleList) && $articleList){ 
				$articleIndex = 1; 
				foreach ($contributorInfo['articles']['articles'] as $article) {
					$link = $config['this_url'].'/'.$article['cat_dir_name'].'/'.$article['article_seo_title'];
					$linkToImage = 'http://images.puckermob.com/articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article['article_id'].'_tall.jpg';
					$date = date("M d, Y", strtotime($article['creation_date']));
					$article_title = $article['article_title'];
					$article_id = $article['article_id'];
				?>
				
				<tr id="article_<?php echo $article_id;?>">
					<td width="160" class="show-for-large-up">
						<img src="<?php echo $linkToImage; ?>" alt="Article Image"/>
					</td>
					<td class="no-padding-right">
						<a href="<?php echo $link; ?>" ><?php echo  $article_title;?></a>
					</td>
				</tr>
			<?php } 
		}else{ ?>
			<p>No Articles Found!</p>
		<?php } ?>
		</table>

		<?php include_once($config['include_path'].'pagination.php'); ?>
	</div>

	</div>
		<?php if (!$detect->isMobile()) { 
			include_once($config['include_path_admin'].'myprofile_sidebar_public.php');
		} ?>
</main>
<?php //include_once($config['include_path'].'footer.php'); ?>
<?php include_once($config['include_path'].'bottomscripts.php'); ?>
</body>
</html>