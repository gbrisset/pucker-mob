<?php
$categoryInfo = null;
foreach($MPNavigation->categories as $category){
	if( isset($category['cat_dir_name'])&& !(isset($uri[1])) && isset($uri[0]) && ($category['cat_dir_name'] == $uri[0])  ){
		$categoryInfo = $category;
		$hasParent = false;
		break;
	} else if(isset($category['cat_dir_name'])&& isset($uri[1]) && ($category['cat_dir_name'] == $uri[1]) ){
		$categoryInfo = $category;
		$hasParent = true;
		break;
	}
}
if(!is_null($categoryInfo)){
	$pageName = $categoryInfo['cat_name'].' | '.$mpArticle->data['article_page_name'];
	$parentCategorySEOName = ($categoryInfo['parent_dir_name']);

	$recentArticles = $mpArticle->getMostRecentByCatId(['pageId' => $categoryInfo['cat_id']]);
	$articlesPerPage = 8;
	$totalPages = ceil(count($recentArticles['articles']) / $articlesPerPage);
	if($totalPages > 1){
		$currentPage = (isset($_GET['p'])) ? preg_replace('/[^0-9]/', '', $_GET['p']) : 1;
		if($currentPage > $totalPages) $currentPage = 1;
		$offset = ($currentPage - 1) * $articlesPerPage;
		$recentArticles['articles'] = array_slice($recentArticles['articles'], $offset, $articlesPerPage);
		if ($hasParent){
			$parentCategorySEOName = $categoryInfo['parent_dir_name'];
			$parentCategoryVisibleName = $categoryInfo['parent_name'];
			$pagesArray['url'] = $config['this_url'].$parentCategorySEOName.'/'.$categoryInfo['cat_dir_name'];
		} else {
			$pagesArray['url'] = $config['this_url'].$categoryInfo['cat_dir_name'];
		}
		$pagesArray['pages'] = $mpHelpers->getPages($currentPage, $totalPages);
	}
}else $mpShared->get404();
if ( $detect->isMobile() ) {
	?>
	<!DOCTYPE html>
	<html class="no-js" lang="en">
	<?php include_once($config['include_path'].'head.php');?>
	<body id="category" class="mobile">
		<?php include_once($config['include_path'].'header.php');?>
		<?php include_once($config['include_path'].'header_ad.php');?>
		<main id="main" class="row panel sidebar-on-right" role="main">

			<?php include_once($config['include_path'].'categoryresults.php');?>
			<?php include_once($config['shared_include'].'pagination.php');?>
			<section class="sidebar-right small-12 columns">
				<hr>
			</section>

			<div id="bottom-ad" class="ad-unit hide-for-print"></div>

			<section class="sidebar-right small-12 columns">
				<hr>
			</section>
		</main>
		<?php include_once($config['include_path'].'footer.php');?>
		<?php include_once($config['include_path'].'bottomscripts.php');?>
	</body>
	</html>
	<?php } else { ?>
	<!DOCTYPE html>
	<html class="no-js" lang="en">
	<?php include_once($config['include_path'].'head.php');?>
	<body id="category">
		<?php include_once($config['include_path'].'header.php');?>
		<?php include_once($config['include_path'].'header_ad.php');?>
		<main id="main" class="row panel sidebar-on-right" role="main">
			<section id="puc-articles" class="sidebar-right shadow-on-large-up small-11 columns translate-fix sidebar-main-left">
				<section id="category-intro" class="small-12 columns sidebar-right">
					<h1><?php echo $categoryInfo['cat_name']; ?></h1>
					<hr>
				</section>
					<?php include_once($config['include_path'].'categoryresults.php');?>
					<?php include_once($config['shared_include'].'pagination.php');?>
					<div id="medianet-ad" class="ad-unit hide-for-print padding-right show-for-xxlarge-only"></div>
					<div id="ingageunit" class="hide-for-print"></div>
					<?php include_once($config['include_path'].'fromourpartners.php'); ?>
					<?php include_once($config['include_path'].'aroundtheweb.php'); ?>
			</section>
			<?php include_once($config['include_path'].'rightsidebar.php');?>
		</main>
			<?php include_once($config['include_path'].'footer.php');?>
			<?php include_once($config['include_path'].'bottomscripts.php');?>
		</body>
		</html>
		<?php } ?>