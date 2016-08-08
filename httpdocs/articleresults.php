<?php
require_once('assets/php/config.php');
$pageName = $mpArticle->data['article_page_name'];
$isHomepage = false;
$has_sponsored = true;//$mpArticle->data['has_sponsored_by'];

if (empty($_GET['per_page'])) {
	$quantity = 46;
} else {
	$quantity = $_GET['per_page'];
}


if (empty($_GET['page'])) {
	$page = 0;
} else {
	$page = $_GET['page'];
}
$has_sponsored = 0;
$omitThis = 0;
$offset = $quantity * $page;
$cat_id = $mpArticle->data['cat_id'];

if(isset($uri[0]) && $uri[0]){
	if($uri[0] == 'trending') $articlesList = $mpArticle->getMostRecentArticleListTrending();
	elseif(  $uri[0] == 'moblog'  )  $articlesList = $mpArticle->getArticlesListView(['limit' => $quantity, 'omit' => $omitThis, 'offset' => $offset, 'user_type' => "3, 8" ]);
	elseif(  $uri[0] == 'most-recent' ) $articlesList = $mpArticle->getArticlesListView(['limit' => $quantity, 'omit' => $omitThis, 'offset' => $offset, 'user_type' => "1, 3, 6, 7, 8" ]);
	elseif(  $uri[0] == 'most-popular'  )  $articlesList = $mpArticle->getMostRecentArticleListMostPopular();
}

if ( $detect->isMobile() && !$detect->isTablet()) {?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="home" class="mobile background-eee">
	<?php include_once($config['include_path'].'header.php'); ?>
	<?php include_once($config['include_path'].'header_ad.php'); ?>

	<!-- MOBILE LEFT TAP -->
	<?php include_once($config['include_path'].'mobiletapsection.php'); ?>
		
	<main id="main" class="row panel sidebar-on-right" role="main">
		<section id="puc-articles" class="sidebar-right  mobile-12 small-12 medium-11 columns translate-fix sidebar-main-left">
			<?php 
			//$articlesList = $mpArticle->getArticles(['count' => 24]);
			include_once($config['include_path'].'articlelistmobile.php'); ?>
		</section>
	</main>

	<?php include_once($config['include_path'].'footer.php'); ?>
	<?php include_once($config['include_path'].'bottomscripts.php'); ?>
	<!-- MODAL BOX POPUP -->
</body>

</html>

<?php }elseif($detect->isTablet()){?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="home" class="">
	<!-- Sponsored By Totally Her -->
	<input type="hidden" value="<?php echo $has_sponsored; ?>"  id="has-sponsored-by">

	<?php include_once($config['include_path'].'header.php'); ?>
	<?php include_once($config['include_path'].'header_ad.php');?>
		
	<main id="main" class="row panel sidebar-on-right" role="main">
		<section id="puc-articles" class="sidebar-right  mobile-11 tablet-11 small-12 medium-12 large-11 columns translate-fix sidebar-main-left articlelist-wrapper">
			<?php include_once($config['include_path'].'articleslist.php'); ?>
		</section>
		<?php include_once($config['include_path'].'rightsidebar.php'); ?>
	</main>
	
	<?php include_once($config['include_path'].'footer.php'); ?>
	<?php include_once($config['include_path'].'bottomscripts.php'); ?>

</body>
</html>

<?php }else { ?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="home" class="">
	<!-- Sponsored By Totally Her -->
	<input type="hidden" value="<?php echo $has_sponsored; ?>"  id="has-sponsored-by">

	<?php include_once($config['include_path'].'header.php'); ?>
	<?php include_once($config['include_path'].'header_ad.php');?>
	<main id="main" class="row panel sidebar-on-right" role="main">
		
		<section id="puc-articles" class="sidebar-right  mobile-12 small-12 medium-12 large-11 columns translate-fix sidebar-main-left articlelist-wrapper main-div">
			<?php include_once($config['include_path'].'articleslist.php'); ?>
		</section>
		<?php include_once($config['include_path'].'rightsidebar.php'); ?>

	</main>
	
	<?php 
	include_once($config['include_path'].'ads_to_load.php');
	include_once($config['include_path'].'bottomscripts.php'); ?>
	
</body>
</html>
<?php }?>