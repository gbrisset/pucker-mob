<?php
require_once('../php/config.php');
require_once('../php/class.SocialMediaManage.php');

$socialMediaManage = new SocialMediaManage($config);

$featuredArticle = $mpArticle->getFeaturedArticle( $cat_id );
if( $featuredArticle && $featuredArticle['article_status'] == 1){
	$omitThis =  $featuredArticle['article_id'];
}

$cat_id = is_numeric($_POST['pageid']) ? $_POST['pageid'] : 1;
$offset = is_numeric($_POST['offset']) ? $_POST['offset'] : 0;
$postnumbers = is_numeric($_POST['number']) ? $_POST['number'] : 10;

if( $cat_id == 1){
	$articlesList = $mpArticle->getMobileArticleList(['limit' => $postnumbers, 'offset' => $offset, 'omit' => $omitThis ] );
}else{
	$articlesList = $mpArticle->getMobileArticleList(['limit' => $postnumbers, 'offset'=>$offset, 'omit' => $omitThis , 'pageId' => $cat_id]);
}

foreach( $articlesList as $articles ){
	$linkToArticle = 'http://www.puckermob.com/'.$articles['cat_dir_name'].'/'.$articles["article_seo_title"];
	$date = date("M d, Y", strtotime($articles['date_updated']));
	$article_id = $articles['article_id'];
	$linkToImage = 'http://cdn.puckermob.com/articlesites/puckermob/large/'.$articles['article_id'].'_tall.jpg';
	
	$content =  '<div class="small-12 second-popular-articles-cont article-id" id="article-'.$article_id.'" data-info-url="'.$linkToArticle.'">';
	$content .=  '<div class="row imageContainer">';
	$content .=  	'<div class="small-12 columns imageCenterer">';
	$content .=  		'<a class="" href="'.$linkToArticle.'">';
	$content .=  			'<img src="'.$linkToImage.'" alt="'.$articles['article_title'].'">';
	$content .=  		'</a>';
	$content .=  	'</div>';
	$content .=  '</div>';			
	$content .=  '<div class="small-12 columns second-popular-article-title">';
	$content .=  	'<h2 class="left small-12 padding-top">';
	$content .=  		'<a class="" href="'.$linkToArticle.'">'.$articles['article_title'].'</a>';
	$content .=  	'</h2>';
	$content .=  '</div>';
	$content .=  '<div class="second-article-date small-12 clear">';
	$content .=  	'<label class="small-6">'.$date.'</label>';
	$content .=  	'<label class="small-6 span-shares-holder"></label>';
	$content .=  '</div>';
	$content .=  '</div>';
	

	echo $content;
}

?>
