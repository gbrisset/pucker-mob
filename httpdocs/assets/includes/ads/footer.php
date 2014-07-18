<?php
	$omits = [];
	$categoryInfo = null;
	$isNillaWaferCategory = false;
	$isMultiPage = true;
	$articleInfoObj = array();
	foreach($MPNavigation->categories as $category){
		if( isset($category['cat_dir_name'])  && !(isset($uri[2])) && ($category['cat_dir_name'] == $uri[0])  ){
			// uri[2] not set, cat has no parent
			$categoryInfo = $category;
			$articleTitle = explode('&', preg_replace('/[?]/', '&', $uri[1]))[0];
			$hasParent = false;
			break;
		} else if(isset($category['cat_dir_name']) && (isset($uri[2])) && ($category['cat_dir_name'] == $uri[1]) ){
			// uri[2] set! cat has parent!
			$categoryInfo = $category;
			$articleTitle = explode('&', preg_replace('/[?]/', '&', $uri[2]))[0];
			$hasParent = true;
			break;
		}
	}
	if ($categoryInfo['cat_id'] == 900) $isNillaWaferCategory = true;

	$featuredArticle = $mpArticle->getFeatured(['featureType' => 2, 'articleCount' => 1, 'pageId' => 1]);
	if(!is_null($categoryInfo)){
		//$mostReadArticles = $mpArticle->getArticles(['count' => 5, 'sortType' => 2, 'pageId' => $categoryInfo['cat_id']]); //Most Viewed
		$featuredVideos = $mpVideoShows->getFeaturedVideos(3, 3); //Popular Videos
		$articleInfo = $mpArticle->getArticles(['articleSEOTitle' => $articleTitle]);
		// Dish of the Day the same on every page
		$featuredArticle = $mpArticle->getFeatured(['featureType' => 2, 'articleCount' => 1, 'pageId' => 1]);

		if(isset($articleInfo['articles']) &&  $articleInfo['articles']){
			$articleInfoObj = $articleInfo['articles'][0];
			$pageName = $articleInfoObj['article_title'].' | '.$mpArticle->data['article_page_name'];
			$relatedArticles = $mpArticle->getArticles(['count' => 6, 'pageId' => $categoryInfo['cat_id'], 'omit' => $articleInfo['ids']]);
			$articleImages = $mpArticle->getArticlesImages($articleInfoObj['article_id']);
			//$mpArticle->updateViewCount($articleInfoObj['article_id']);
		}else {
			$mpShared->get404();
		}
	}else {
		$mpShared->get404();
	}
	if (isset($hasParent) && $hasParent){
		$parentCategorySEOName = $categoryInfo['parent_dir_name'];
		$parentCategoryVisibleName = $categoryInfo['parent_name'];
		$article_link = $config['this_url'].$parentCategorySEOName.'/'.$categoryInfo['cat_dir_name'].'/'.$articleInfoObj['article_seo_title'];
		$pagesArray['url'] = $config['this_url'].$parentCategorySEOName.'/'.$categoryInfo['cat_dir_name'];
	} else {
		$pagesArray['url'] = $config['this_url'].$categoryInfo['cat_dir_name'];
		$article_link = $config['this_url'].$categoryInfo['cat_dir_name'].'/'.$articleInfoObj['article_seo_title'];
	}

?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="recipe">
<?php include_once($config['include_path'].'header.php');?>
<main id="main" class="row panel sidebar-on-right shadow-on-large-up" role="main">
				<?php //include_once($config['include_path'].'breadcrumb.php');?>
				<?php 
//	ARTICLE TEMPLATE				
					//	Get the Article Template Type if article_template_type == 1 => Is a Recipe and load template_recipes.php template otherwise is an Article and load template_articles.php template
					if(isset($articleInfoObj['article_template_type']) && $articleInfoObj['article_template_type'] == 1){
						include_once($config['template_path'].'template_recipes.php');
					}else{
						if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] != 0){
							include_once($config['template_path'].'template_article_with_page_list.php');
						} else {
							include_once($config['template_path'].'template_articles.php');
						}
						
					}
				?>
<?php include_once($config['include_path'].'similarrecipes.php');?>
<iframe id="media-net" class="ad-frame ad250 hide-for-print padding-right show-for-xxlarge-only" scrolling="no"></iframe>
<?php 
	if(isset($categoryInfo) && !$categoryInfo['cat_partner_banner_recipe_page'] && !$articleInfoObj['isTopic']){
	include_once($config['include_path'].'abouttheauthor.php');
}?>
<?php include_once($config['include_path'].'rightsidebar.php');?>
</main>
<?php include_once($config['include_path'].'footer.php');?>
<?php include_once($config['include_path'].'bottomscripts.php');?>
</body>
</html>