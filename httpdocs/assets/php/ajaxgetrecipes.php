<?php
	require_once('config.php');

	$recipe_id = 1;
	if((isset($_POST['id']))) {
	    $video_id = $_POST['id'];
	   
	    $article_id = $mpVideoShows->getArticleInfoPerVideo($video_id);

	    if($article_id){

		    $article_id = $article_id[0]["article_id"];

		   	$articleInfo = $mpArticle->getArticles(['articleId' => $article_id]);
			$articleInfo = $articleInfo["articles"][0];
			//$parent_category = $MPNavigation->getCategoryById($articleInfo['category_parent_id']);
			$parent_cat_page_directory = isset($articleInfo['parent_category_page_directory']) ? $articleInfo['parent_category_page_directory'].'/' : '';
			//isset($parent_category['cat_dir_name']) ? $parent_category['cat_dir_name'].'/' : ''; 
		  //var_dump($parent_cat_page_directory);
		   	if($parent_cat_page_directory != 'categories-root/')
				$article_url = $config['this_url'].$parent_cat_page_directory.$articleInfo['cat_dir_name'].'/'.$articleInfo['article_seo_title'];
			else
				$article_url = $config['this_url'].$articleInfo['cat_dir_name'].'/'.$articleInfo['article_seo_title'];
			
			$articleInfoObj = [
				'valid' => true,
				'article_id' => $articleInfo['article_id'],
				'article_url' => $article_url,
				'article_title' => $articleInfo['article_title'],
				'article_desc' => $articleInfo['article_desc']
			];
			
		}
		else{
			$articleInfoObj = [
				'valid' => false
			];
		}

		 echo json_encode( $articleInfoObj );
	}
?>



