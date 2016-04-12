<?php
$categoryInfo = null;
$category_page = true;

$current_url = isset($_SERVER['SCRIPT_URI']) ? $_SERVER['SCRIPT_URI'] : '';
	if($current_url == "http://www.puckermob.com/relationships/" || $current_url == "http://www.puckermob.com/relationships" 
		|| $current_url == "http://www.puckermob.com/fun" || $current_url == "http://www.puckermob.com/fun/"  
		|| $current_url == "http://www.puckermob.com/lifestyle" || $current_url == "http://www.puckermob.com/lifestyle/"
		|| $current_url == "http://www.puckermob.com/money" || $current_url == "http://www.puckermob.com/money/" 
		|| $current_url == "http://www.puckermob.com/entertainment" || $current_url == "http://www.puckermob.com/entertainment/" ){
		header('Location: http://www.puckermob.com');
		die;
	}

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
	$cat_name = $categoryInfo['cat_dir_name'];
	$pageName = $categoryInfo['cat_name'].' | '.$mpArticle->data['article_page_name'];
	
	$articlesList = $mpArticle->getArticles(['count' => 24]);

	//$articlesList = $mpArticle->getMostRecentByCatId(['pageId' => $categoryInfo['cat_id']]);
	$articlesList = $mpArticle->getArticlesList(['pageId' => 9, 'limit' => 60 ]);

	//var_dump(count($articlesList)); die;

	$recentArticles = $articlesList;
}else $mpShared->get404();
if ( $detect->isMobile() ) { ?>
<!DOCTYPE html>
<html class="no-js" lang="en">
	<?php include_once($config['include_path'].'head.php');?>
	<body id="category" class="mobile background-eee">
		<?php include_once($config['include_path'].'header.php');?>
		<?php include_once($config['include_path'].'header_ad.php');?>
		<div id="ros_adoop"></div>
		<!-- MOBILE LEFT TAP -->
		<?php //include_once($config['include_path'].'mobiletapsection.php'); ?>
		
		<main id="main" class="row panel sidebar-on-right" role="main">
			<section id="puc-articles" class="sidebar-right small-12 columns translate-fix sidebar-main-left">
			<input type="hidden" id="cat_id" value="<?php echo  $categoryInfo['cat_id']; ?>" />
			<?php include_once($config['include_path'].'articlelistmobile.php');?>

			<section class="sidebar-right small-12 columns">
				<hr>
			</section>

			<div id="bottom-ad" class="ad-unit hide-for-print"></div>

			<section class="sidebar-right small-12 columns">
				<hr>
			</section>
			</section>
		</main>
		<?php include_once($config['include_path'].'footer.php');?>
		<?php include_once($config['include_path'].'bottomscripts.php');?>

		<!-- MODAL BOX POPUP -->
		<?php //include_once($config['include_path'].'modalbox.php'); ?>
	</body>
</html>
	
<?php } else { ?>
	
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
	<body id="category">
		<?php include_once($config['include_path'].'header.php');?>
		<?php include_once($config['include_path'].'header_ad.php');?>
		<div id="ros_adoop"></div>
		<main id="main" class="row panel sidebar-on-right" role="main">
		
			<section id="puc-articles" class="sidebar-right small-12 medium-12 large-11 columns translate-fix sidebar-main-left">
					<h1 id="category-name" class="h1-large-article"><?php echo $categoryInfo['cat_name']; ?></h1>
					<?php include_once($config['include_path'].'categoryresults.php');?>
					<hr>
			</section>
			<?php 
				include_once($config['include_path'].'rightsidebar.php');
			?>
		</main>
		<?php include_once($config['include_path'].'footer.php');?>
		<?php include_once($config['include_path'].'bottomscripts.php');?>


	</body>
</html>
		<?php } ?>