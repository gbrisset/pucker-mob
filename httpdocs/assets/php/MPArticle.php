<?php
require_once dirname(__FILE__).'/Connector.php';
//require 'MPMemcache.php';

class MPArticle{
	protected $config;
	protected $con;
	private $memcache;

	public $data;
	public $categories;
	public $navigationLinks;
	public $othersites;
	public $mainCategories;

	public function __construct($c){
		$this->config = $c;
		$this->con = new Connector($this->config);
		$this->data = $this->getArticlePageInfo();
		//$this->memcache = new MPMemcache($this->config);
	}

//public function getAllArticles($limit){

//}
private function getArticlePageInfo($id = 1){
		$pdo = $this->con->openCon();
		$id = (is_null($id)) ? $this->config['articlepageid'] : $id;
		$pageQueryString = "SELECT * FROM article_pages "; 

		$pageQueryString .= "INNER JOIN (article_page_ads, article_page_images, article_page_styling, article_page_social_settings )";
		$pageQueryString .= "ON (article_pages.article_page_id = article_page_ads.article_page_id ";
			$pageQueryString .= "AND article_pages.article_page_id = article_page_images.article_page_id "; 
			$pageQueryString .= "AND article_pages.article_page_id = article_page_styling.article_page_id "; 
			$pageQueryString .= "AND article_pages.article_page_id = article_page_social_settings.article_page_id) "; 

			$pageQueryString .= "WHERE article_pages.article_page_id = 1 ";

			$pageQueryString .= "LIMIT 0, 1 ";
			$q = $pdo->query($pageQueryString);
			if($q && $q->rowCount()){
				$q->setFetchMode(PDO::FETCH_ASSOC); 
				$row = $q->fetch();
				$r = $row;
				$q->closeCursor();
			}else $r = false;
			$this->con->closeCon();

		return $r;
}

public function getSearchResultsByNamesArray($args = []){
	$options = array_merge([
		'pageId' => 1, 
			'sortType' =>1, //1 == Most Recent, 2 == Most Popular, 3 == Most Visited, 4 == A-Z, 5 == Z-A
			'articleCount' => -1, 
			'featured'=> false, 
			'featureType' =>2, //2 == sidebar (Dish of the Day), 3 == Slideshow 
			'contributorId' => null, 
			'omit'=> [],
			'articleId' => null, 
			'articleTitles' => [],
			'articleSEOTitle' => '',
			'articleSEOTitles' =>[],
			'articleStatus' => 1
			], $args);

	$s = "SELECT article.*, parent.cat_id as parent_id, parent.cat_name as parent_name, parent.cat_dir_name as parent_dir_name 

	FROM categories AS cat, categories AS parent 

	INNER JOIN ( 
		SELECT articles.*, nc.cat_id, nc.cat_name, nc.cat_dir_name, nc.lft, nc.rgt, article_pages.article_page_assets_directory, article_pages.article_page_full_url  
		FROM articles 

		INNER JOIN (article_pages, article_categories, categories as nc, articles_featured as featured) 
		ON articles.article_id = article_categories.article_id 
		AND article_categories.cat_id = nc.cat_id 

		WHERE articles.article_status = 1
		AND article_seo_title IN ({articleTitles})
		GROUP BY articles.article_id 

		ORDER BY articles.article_id DESC 
		) as article 

	WHERE (parent.lft > 1
		AND article.lft BETWEEN (parent.lft+1) 
		AND (parent.rgt -1))

	OR (article.cat_id IN (115, 3, 4)) 

	AND cat.cat_id = article.cat_id 

	GROUP BY article.article_id 

	ORDER BY article.article_id DESC";

	$articleTitles = '';
	foreach($options['articleSEOTitles'] as $title){
		if(!empty($articleTitles)) $articleTitles .= ", ";
		$articleTitles .= "'$title'";
	}
	$s = preg_replace('/{articleTitles}/', $articleTitles, $s);

	$queryParams = [];
	$pdo = $this->con->openCon();
	$q = $pdo->prepare($s);
	$row = $q->execute($queryParams);		

	if($row){
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$r = ['ids' => [],'articles' => []];
		while($row = $q->fetch()){
			if(!in_array($row['article_id'], $r['ids'])){
				//$rating = $pdo->query("SELECT avg(article_ratings.rating) AS rating, count(article_ratings.rating) AS reviews FROM article_ratings INNER JOIN (articles) ON (articles.article_id = article_ratings.article_id) WHERE articles.article_id = ".$row['article_id']);
				$ratingArray = [];
				//if($rating && $rating->rowCount()) $ratingArray = $rating->fetch(PDO::FETCH_ASSOC);
				$r['ids'][] =$row['article_id'];
				$r['articles'][] = array_merge($row, $ratingArray);
			}
		}
	}else $r = false;
	$this->con->closeCon();
			// var_dump($s);		
	return $r;
}


public function verifyArticleInCategory( $article_id, $cat_id ){

	$s = " SELECT * FROM article_categories INNER JOIN ( categories ) ON ( article_categories.cat_id = categories.cat_id ) 
		  WHERE article_categories.article_id = $article_id AND categories.cat_id = $cat_id ";


	$q = $this->performQuery(['queryString' => $s]);
	return $q;
}

public function getAllLiveArticles(){
	$s = "SELECT articles.article_id, article_title, article_seo_title, cat_dir_name  
	FROM articles 
	INNER JOIN (categories, article_categories) 
	ON ( articles.article_id = article_categories.article_id )
	AND (article_categories.cat_id = categories.cat_id )
	WHERE articles.article_status = 1 
	ORDER BY articles.article_id DESC ";

	$q = $this->performQuery(['queryString' => $s]);
	return $q;

}

public function getAllLiveArticlesPerContributor( $contributor_id ){
	$s = "SELECT articles.article_id, article_title, article_seo_title, cat_dir_name  
	FROM articles 
	INNER JOIN (categories, article_categories, article_contributor_articles) 
	ON ( articles.article_id = article_categories.article_id )
	AND (article_categories.cat_id = categories.cat_id )
	AND (articles.article_id = article_contributor_articles.article_id )
	WHERE articles.article_status = 1 AND article_contributor_articles.contributor_id = $contributor_id
	ORDER BY articles.article_id DESC ";

	$q = $this->performQuery(['queryString' => $s]);
	return $q;

}

public function getRelatedToArticle( $article_id ){
	$article_id = filter_var($article_id, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
	$s = "SELECT related_article_id_1, related_article_id_2, related_article_id_3 
	FROM related_articles 
	WHERE main_article_id = $article_id LIMIT 1 ";
	
	$q = $this->performQuery(['queryString' => $s]);
	return $q;
}

public function getRelatedToArticleInfo( $article_id ){
	$article_id = filter_var($article_id, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
	$s = "SELECT articles.article_id, article_title, article_seo_title, categories.cat_id, categories.cat_dir_name  
	FROM articles 
	INNER JOIN ( categories, article_categories )
	ON( articles.article_id = article_categories.article_id )
	AND ( article_categories.cat_id = categories.cat_id ) 
	WHERE articles.article_id = $article_id LIMIT 1 ";
	 
	$q = $this->performQuery(['queryString' => $s]);
	return $q;
}

public function getMoBlogsArticles( $current_article_id = 0){

	if( $current_article_id != 0 ) 
		$current_article_id = filter_var($current_article_id, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
	
	$s = "SELECT * FROM articles 
		INNER JOIN (article_categories) 
		ON ( articles.article_id = article_categories.article_id ) 
		WHERE articles.article_status = 1 AND article_categories.cat_id = 9 ";

	if( $current_article_id != 0 ) {
		$s .= " AND articles.article_id != $current_article_id ";
	}
	 
	$s .= " ORDER BY articles.date_updated DESC LIMIT 12 ";

	$q = $this->performQuery(['queryString' => $s]);
		
	return $q;

}

public function getMoBlogsArticlesFB( $current_article_id = 0){

	$s = "SELECT * FROM articles 
		INNER JOIN (article_categories) 
		ON ( articles.article_id = article_categories.article_id ) 
		WHERE articles.article_status = 1 AND article_categories.cat_id = 9 ";

	$s .= " ORDER BY articles.date_updated DESC ";

	$q = $this->performQuery(['queryString' => $s]);
		
	return $q;

}

public function getMobileArticleList( $args = [], $attempts = 0 ){
	$options = array_merge([
		'pageId' => null, 
		'omit'=> false,
		'articleId' => null, 
		'limit' => '',
		'offset' => '',
		'withMobLogs' => false
	], $args);

	$s = " SELECT *, articles.creation_date, articles.article_id ";

	if( $options['withMobLogs'] == true ){
		$s .= ", article_moblogs_featured.article_featured_hp ";
	}

	$s .= " FROM articles ";
	$s .= " INNER JOIN ( article_categories, categories ) 
		   ON ( articles.article_id = article_categories.article_id AND article_categories.cat_id = categories.cat_id ) ";
	
	if( $options['withMobLogs'] == true ){
		$s .= " LEFT JOIN article_moblogs_featured ON ( article_moblogs_featured.article_id = articles.article_id ) ";
	}

	$s .= " WHERE  articles.article_status = 1 ";


	if( isset( $options['omit'] )  &&  $options['omit']) {
		$s .= " AND articles.article_id != ". $options['omit'] ;
	}

	if( isset( $options['pageId'] )  &&  $options['pageId']) {
		$s .= " AND categories.cat_id = ". $options['pageId'] ;
	}else{
		$s .= " AND ( categories.cat_id != 9 OR article_moblogs_featured.article_featured_hp = 1 ) ";
	}
	
	$s .= " ORDER BY articles.date_updated DESC, articles.article_id DESC 
		   LIMIT ".$options['limit']." OFFSET ".$options['offset'];

	$q = $this->performQuery(['queryString' => $s]);
		
	return $q;	   
}

public function getArticlesList( $args = [] ){
	$options = array_merge([
		'pageId' => null, 
		'contributorId' => null, 
		'omit'=> [],
		'articleId' => null, 
		'articleTitles' => [],
		'articleSEOTitle' => '',
		'articleSEOTitles' =>[],
		'limit' => '',
		'offset' => 0,
		'withMobLogs' => false
	], $args);

	$s = " SELECT articles.article_id, articles.creation_date, articles.date_updated, articles.article_title, articles.article_seo_title, categories.cat_id, categories.cat_name, categories.cat_dir_name, 
	article_contributors.contributor_id, article_contributors.contributor_seo_name, article_contributors.contributor_name, article_contributors.contributor_image ";

	if( $options['withMobLogs'] == true ){
		$s .= ", article_moblogs_featured.article_featured_hp ";
	}
	
	$s .= " FROM articles 
		   INNER JOIN ( article_categories, categories, article_contributor_articles, article_contributors ) 
		   	ON ( articles.article_id = article_categories.article_id AND article_categories.cat_id = categories.cat_id 
		   	AND article_contributor_articles.article_id = articles.article_id AND article_contributors.contributor_id = article_contributor_articles.contributor_id ) ";
		   
	if( $options['withMobLogs'] == true ){
		$s .= " LEFT JOIN article_moblogs_featured ON ( article_moblogs_featured.article_id = articles.article_id ) ";
	}
	
	$s .= " WHERE  articles.article_status = 1 ";

	if( isset( $options['omit'] )  &&  $options['omit']) {
		$s .= " AND articles.article_id != ". $options['omit'] ;
	}

	if( isset( $options['pageId'] )  &&  $options['pageId']) {
		$s .= " AND categories.cat_id = ". $options['pageId'] ;
	}else{
		$s .= " AND categories.cat_id != 9 OR article_moblogs_featured.article_featured_hp = 1 ";
	}

	$s .= " ORDER BY articles.date_updated DESC, articles.article_id DESC ";

	if( isset( $options['limit'] )  &&  $options['limit']) {
		$s .= "  LIMIT ". $options['limit'] ." OFFSET ".$options['offset'];
	}

	$q = $this->performQuery(['queryString' => $s]);
		
	return $q;	   
}

public function getArticlesListView( $args = [] ){
	$options = array_merge([
		'pageId' => null, 
		'contributorId' => null, 
		'omit'=> [],
		'articleId' => null, 
		'articleSEOTitle' => '',
		'limit' => '',
		'offset' => 0,
		'withMobLogs' => false,
		'user_type' => ''
	], $args);

	$s = " SELECT * FROM articles_list WHERE  article_status = 1 ";		  


	if( isset( $options['omit'] )  &&  $options['omit']) {
		$s .= " AND article_id != ". $options['omit'] ;
	}

	if( isset( $options['pageId'] )  &&  $options['pageId']) {
		$s .= " AND cat_id = ". $options['pageId'] ;
	}

	if( isset( $options['user_type'] )  &&  $options['user_type']) {
		$s .= " AND user_type IN ( ".$options['user_type']." )";
	}

	$s .= " ORDER BY date_updated DESC, article_id DESC ";

	if( isset( $options['limit'] )  &&  $options['limit']) {
		$s .= " LIMIT ". $options['limit'] ." OFFSET ".$options['offset'];
	}

	$q = $this->performQuery(['queryString' => $s]);
		
	return $q;	   
}

public function getArticlesListForFacebook( ){
	

	$s = " SELECT articles.article_id, articles.creation_date, articles.date_updated, articles.article_title, articles.article_seo_title, categories.cat_id, categories.cat_name, categories.cat_dir_name, 
	article_contributors.contributor_id, article_contributors.contributor_seo_name, article_contributors.contributor_name, article_contributors.contributor_image ";

	$s .= " FROM articles 
		   INNER JOIN ( article_categories, categories, article_contributor_articles, article_contributors ) 
		   	ON ( articles.article_id = article_categories.article_id AND article_categories.cat_id = categories.cat_id 
		   	AND article_contributor_articles.article_id = articles.article_id AND article_contributors.contributor_id = article_contributor_articles.contributor_id ) ";
	
	
	$s .= " WHERE  articles.article_status = 1 ";

	
	$s .= " ORDER BY articles.date_updated DESC, articles.article_id DESC ";

	
	$q = $this->performQuery(['queryString' => $s]);
		
	return $q;	   
}

public function getSingleArticleInfo(  $args = [] ){
	$options = array_merge([
		'pageId' => null, 
		'articleId' => null, 
		'articleTitles' => [],
		'articleSEOTitle' => ''
	], $args);
	
	$s = "SELECT * FROM articles  
		INNER JOIN ( article_contributor_articles, article_contributors ) 
		ON (article_contributor_articles.article_id = articles.article_id ) AND ( article_contributors.contributor_id = article_contributor_articles.contributor_id )
		WHERE articles.article_status = 1 AND (articles.article_id = :articleId OR articles.article_seo_title = :articleSEOTitle ) LIMIT 1 ";
	$queryParams = [
		':articleId' => filter_var($options['articleId'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
		':articleSEOTitle' => filter_var($options['articleSEOTitle'], FILTER_SANITIZE_STRING, PDO::PARAM_STR)
	];

	$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);
	return $q;
}

public function getArticles($args = [], $attempts = 0){
	$options = array_merge([
		'pageId' => null, 
		'count' => 12, 
		'sortType' =>1, //1 == Most Recent, 2 == Most Popular, 3 == Most Visited, 4 == A-Z, 5 == Z-A
		'featured'=> false, 
		'featureType' =>1, //1 == Sidebar, 2 == On-Page
		'contributorId' => null, 
		'omit'=> [],
		'articleId' => null, 
		'articleTitles' => [],
		'articleSEOTitle' => '',
		'articleSEOTitles' =>[],
		'articleStatus' => 1
	], $args);
	$innerJoinTables = [
	'article_images',
	'article_categories',
	'categories',
	'article_page_categories',
	'article_pages',
	'article_contributor_articles', 
	'article_contributors'

	];
	$innerJoinRelations = [
	'articles.article_id = article_images.article_id',
	'articles.article_id = article_categories.article_id',
	'article_categories.cat_id = categories.cat_id',
	'categories.cat_id = article_page_categories.category_page_id',
	'article_page_categories.article_page_id = article_pages.article_page_id',
	'articles.article_id = article_contributor_articles.article_id', 
	'article_contributor_articles.contributor_id = article_contributors.contributor_id'
	];
	$leftJoinTables = [
	'article_videos',
			'mypod_network.syndication_videos'//'syndication_videos'
			];
			$leftJoinRelations = [
			'articles.article_id = article_videos.article_id',
			'article_videos.syn_video_id = syndication_videos.syn_video_id'
			];

			$categoryJoinTables = [
			'article_page_main_categories'
			];
			$categoryJoinRelations = [
			'categories.cat_id = article_page_main_categories.child_category_id'
			];

			$whereClause = '';


			switch(true){

				case (!is_null($options['articleId']) || strlen($options['articleSEOTitle'])):
				$options['count'] = 1;

				$whereClause = " WHERE (articles.article_id = :articleId OR articles.article_seo_title = :articleSEOTitle)";
				$groupByClause = "";
				$orderClause = " ORDER BY articles.creation_date DESC";
				$queryParams = [
				':articleId' => filter_var($options['articleId'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
				':articleSEOTitle' => filter_var($options['articleSEOTitle'], FILTER_SANITIZE_STRING, PDO::PARAM_STR)
				];
				break;
				case (!is_null($options['contributorId'])):
				$leftJoinTables = ['article_videos', 'syndication_videos'];
				$leftJoinRelations = ['articles.article_id = article_videos.article_id', 'article_videos.syn_video_id = syndication_videos.syn_video_id'];

				$innerJoinTables = [ 'article_images', 'article_categories', 'categories', 'article_page_categories', 'article_pages'];
				$innerJoinTables[] = 'article_contributor_articles';
				$innerJoinTables[] = 'article_contributors';

				$innerJoinRelations = ['articles.article_id = article_images.article_id', 'articles.article_id = article_categories.article_id', 'article_categories.cat_id = categories.cat_id',
				'categories.cat_id = article_page_categories.category_page_id', 'article_page_categories.article_page_id = article_pages.article_page_id'];
				$innerJoinRelations[] = 'articles.article_id = article_contributor_articles.article_id';
				$innerJoinRelations[] = 'article_contributor_articles.contributor_id = article_contributors.contributor_id';

				$categoryJoinTables = ['article_page_main_categories'];				
				$categoryJoinRelations = ['categories.cat_id = article_page_main_categories.child_category_id'];

				$groupByClause = "";

				$whereClause = " WHERE article_contributors.contributor_id = :contributorId";
				$orderClause = [
					" ORDER BY articles.date_updated DESC, articles.article_id DESC",//Most Recent
					" ORDER BY articles.creation_date DESC, articles.article_id DESC",//Most Popular
					" ORDER BY articles.creation_date DESC, articles.article_id DESC",//Most Visited
					" ORDER BY articles.article_title ASC, articles.article_id DESC",//Alpha A-Z
					" ORDER BY articles.article_title DESC, articles.article_id DESC"//Alpha Z-A
					];
					$queryParams = [':contributorId' => filter_var($options['contributorId'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)];
					break;
					case (count($options['articleSEOTitles'])):
					$options['count'] = count($options['articleSEOTitles']);
					$groupByClause = "";
					$whereClause = " WHERE articles.article_seo_title IN ({articleTitles})";
					$orderClause = " ORDER BY articles.date_updated DESC";
					$articleTitles = '';
					foreach($options['articleSEOTitles'] as $title){
						if(!empty($articleTitles)) $articleTitles .= ", ";
						$articleTitles .= "'$title'";
					}
					$whereClause = preg_replace('/{articleTitles}/', $articleTitles, $whereClause);
					$queryParams = [];
					break;
					default:
					$groupByClause = "";
					if($options['featured']){
						if($options['featureType'] == 2 || $options['featureType'] == 4) $options['count'] = 1;
						if(is_null($options['pageId'])){
							$innerJoinTables[] = 'article_page_featured_articles';
							$innerJoinRelations[] = 'articles.article_id = article_page_featured_articles.article_id';
							$whereClause = " WHERE article_page_featured_articles.article_page_id = :pageId AND article_page_featured_articles.feature_type = :featureType";
							$orderClause = " ORDER BY article_page_featured_articles.feature_position DESC, article_page_featured_articles.featured_id DESC";
						}else{
							$innerJoinTables[] = 'article_page_featured_articles';
							$innerJoinRelations[] = 'articles.article_id = article_page_featured_articles.article_id';
							$whereClause = " WHERE article_page_featured_articles.category_page_id = :pageId AND article_page_featured_articles.feature_type = :featureType";
							$orderClause = " ORDER BY article_page_featured_articles.feature_position DESC, article_page_featured_articles.featured_id DESC";
						}
						$queryParams = [
						':pageId' => filter_var((is_null($options['pageId'])) ? $this->config['articlepageid'] : $options['pageId'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
						':featureType' => filter_var($options['featureType'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)
						];
					}else{
						$whereClause = (is_null($options['pageId'])) ? " WHERE article_pages.article_page_id = :pageId" : " WHERE categories.cat_id = :pageId";
						$queryParams = [':pageId' => filter_var((is_null($options['pageId'])) ? $this->config['articlepageid'] : $options['pageId'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)];
						$orderClause = [
						" ORDER BY articles.date_updated DESC, articles.article_id DESC",//Most Recent
						" ORDER BY articles.creation_date DESC, articles.article_id DESC",//Most Popular
						" ORDER BY articles.creation_date DESC, articles.article_id DESC",//Most Visited
						" ORDER BY articles.article_title ASC, articles.article_id DESC",//Alpha A-Z
						" ORDER BY articles.article_title DESC, articles.article_id DESC"//Alpha Z-A
						];
					}
					break;
				}

				$s = "SELECT *, articles.creation_date, articles.article_id FROM articles INNER JOIN (:joinedTables) ON (:joinRelations)";
				$i = 0;
				$t = '';
				foreach($innerJoinRelations as $relationShip){
					$t .= $relationShip;
					if($i++ < count($innerJoinRelations) - 1) $t .= " AND ";
				}
				$s = str_replace(':joinedTables', implode(', ', $innerJoinTables), $s);
				$s = str_replace(':joinRelations', $t, $s);
				if(count($leftJoinTables) && count($leftJoinRelations)){
					$s .= " LEFT JOIN (:joinedTables) ON (:joinRelations)";
					$i = 0;
					$t = '';
					foreach($leftJoinRelations as $relationShip){
						$t .= $relationShip;
						if($i++ < count($leftJoinRelations) - 1) $t .= " AND ";
					}
					$s = str_replace(':joinedTables', implode(', ', $leftJoinTables), $s);
					$s = str_replace(':joinRelations', $t, $s);
				}

				if(count($categoryJoinTables) && count($categoryJoinRelations)){
					$s .= " LEFT JOIN (:joinedTables) ON (:joinRelations)";
					$i = 0;
					$t = '';
					foreach($categoryJoinRelations as $relationShip){
						$t .= $relationShip;
						if($i++ < count($categoryJoinRelations) - 1) $t .= " AND ";
					}
					$s = str_replace(':joinedTables', implode(', ', $categoryJoinTables), $s);
					$s = str_replace(':joinRelations', $t, $s);
				}




				if(count($options['omit'])){
					$i = 0;
					$c = count($options['omit']);
					$whereClause .= " AND articles.article_id NOT IN (";
						foreach($options['omit'] as $articleId){
							$whereClause .= $articleId;
							if($i++ < count($options['omit']) - 1) $whereClause .= ", ";
						}
						$whereClause .= ")";
	}
	if($options['articleStatus'] !== -1) $whereClause .= " AND articles.article_status = ".$options['articleStatus'];

	$s .= $whereClause;
	$s .= $groupByClause;
	$s .= is_array($orderClause) ? isset($orderClause[$options['sortType'] - 1]) ? $orderClause[$options['sortType'] - 1] : $orderClause[0] : $orderClause;
	if($options['sortType'] !== 2 && $options['count'] !== -1) $s .= " LIMIT 0, ".$options['count'];

	//var_dump($s);
	$pdo = $this->con->openCon();

	$q = $pdo->prepare($s);
	$q->execute($queryParams);

	if($q){
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$r = ['ids' => [],'articles' => []];

		while($row = $q->fetch()){
			if(!in_array($row['article_id'], $r['ids'])){
				//$rating = $pdo->query("SELECT avg(article_ratings.rating) AS rating, count(article_ratings.rating) AS reviews FROM article_ratings INNER JOIN (articles) ON (articles.article_id = article_ratings.article_id) WHERE articles.article_id = ".$row['article_id']);
				//$parent_category = $pdo->query("SELECT cat_name as parent_category_name, cat_dir_name as parent_category_page_directory FROM categories WHERE cat_id = ".$row['parent_category_id']);

				$parentArray = [];
				$ratingArray = [];
				//if($rating && $rating->rowCount()) $ratingArray = $rating->fetch(PDO::FETCH_ASSOC);
				//if($parent_category && $parent_category->rowCount()) $parentArray = $parent_category->fetch(PDO::FETCH_ASSOC);

				//$row = array_merge($row, $parentArray);

				//var_dump($row);
				$r['ids'][] =$row['article_id'];
				$r['articles'][] = array_merge($row, $ratingArray);
			}
		}

		if($options['sortType'] == 2){
			$r['articles'] = array_slice($this->subValSort($r['articles']), 0, $options['count']);
			$r['ids'] = [];
			foreach($r['articles'] as $article){
				$r['ids'][] = $article['article_id'];	
			}
		}

		if(count($r['articles']) < $options['count'] && $attempts < 3){
			$options['omit'] = array_merge($options['omit'], $r['ids']);
			$options['count'] = $options['count'] - count($r['articles']);
			if($options['featured'] == true) $options['pageId'] = null;
			$recursive = $this->getArticles($options, ++$attempts);
			if(is_array($recursive)){
				$r['articles'] = array_merge($r['articles'], $recursive['articles']);
				$r['ids'] = array_merge($r['ids'], $recursive['ids']);
			}
		}
	}else $r = false;
	$this->con->closeCon();
	return $r;
}

public function getArticlesImages($id = null){
	$pdo = $this->con->openCon();
	$id = (is_null($id)) ? 1 : $id;
	$q = $pdo->query("	SELECT * FROM article_additional_images 
		WHERE article_additional_images.article_id = $id
		ORDER BY article_additional_images.article_img_name DESC");

	if($q && $q->rowCount()){
		$q->setFetchMode(PDO::FETCH_ASSOC);
		while($row = $q->fetch()){
			$r[] = $row;
		}
		$q->closeCursor();
	}else $r = false;
	$this->con->closeCon();
	return $r;
}

public function getContributorUserType( $email ){
	$pdo = $this->con->openCon();
	//$id = (is_null($id)) ? 1 : $id;
	$q = $pdo->query("	SELECT user_type FROM users 
		WHERE user_email = '".$email."' ");

	if($q && $q->rowCount()){
		$q->setFetchMode(PDO::FETCH_ASSOC);
		while($row = $q->fetch()){
			$r = $row["user_type"];
		}
		$q->closeCursor();
	}else $r = '4';
	$this->con->closeCon();
	return $r;
}

public function getContributorInfo( $seo_name ){
	$pdo = $this->con->openCon();
	$q = $pdo->query("	SELECT * FROM article_contributors 
		WHERE contributor_seo_name = '".$seo_name."' ");

	if($q && $q->rowCount()){
		$q->setFetchMode(PDO::FETCH_ASSOC);
		while($row = $q->fetch()){
			$r = $row;
		}
		$q->closeCursor();
	}else $r = false;
	$this->con->closeCon();

	return $r;
}

	public function getContributorsArticleList( $contributor_id){

		$contributor_id = $contributor_id;

		$s = "SELECT * FROM article_contributor_articles
		 INNER JOIN ( articles, article_categories, categories)
		 ON ( article_contributor_articles.article_id = articles.article_id 
		 	AND articles.article_id = article_categories.article_id 
		 	AND article_categories.cat_id = categories.cat_id
		 ) 
		WHERE article_contributor_articles.contributor_id = $contributor_id 
		AND articles.article_status = 1 
		ORDER BY articles.article_id DESC";

		$pdo = $this->con->openCon();
		$q = $pdo->query($s);
		if($q && $q->rowCount()){
			$q->setFetchMode(PDO::FETCH_ASSOC);
			while($row = $q->fetch()){
				$r[] = $row;
			}
			$q->closeCursor();
		}else $r = false;
		$this->con->closeCon();
		return $r;

	}


public function getContributors($args = [], $attempts = 0){
	$options = array_merge([
		'pageId' => null,
		'count' => 1,
			'sortType' => 1, //1 == Most Recent, 2 == Most Popular, 3 == Most Visited, 4 == A-Z, 5 == Z-A
			'featured' => false,
			'omit' => [],
			'contributorId' => null,
			'contributorSEOName' => '',
			'contributorEmail' => ''
			], $args);
	$innerJoinTables = [];
	$innerJoinRelations = [];
		$leftJoinTables = [];//'article_videos', 'syndication_videos'];
		$leftJoinRelations = [];//'articles.article_id = article_videos.article_id', 'article_videos.syn_video_id = syndication_videos.syn_video_id'];
		$whereClause = '';
		
		switch(true){
			
				case(!is_null($options['contributorId']) || strlen($options['contributorSEOName']) ):
			
					$whereClause = ' WHERE ( article_contributors.contributor_id = :contributorId OR article_contributors.contributor_seo_name = :contributorSEOName )';
					$queryParams = [
					':contributorId' => filter_var($options['contributorId'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
					':contributorSEOName' => filter_var($options['contributorSEOName'], FILTER_SANITIZE_STRING, PDO::PARAM_STR),
					];

					$orderClause = " ORDER BY article_contributors.creation_date DESC, article_contributors.contributor_id DESC";
					$articlesType = 'single';
					break;

				case( strlen($options['contributorEmail']) ):
					$whereClause = ' WHERE (article_contributors.contributor_email_address = :contributorEmail)';
					$queryParams = [
						':contributorEmail' => filter_var($options['contributorEmail'], FILTER_SANITIZE_STRING, PDO::PARAM_STR)
					];

					$orderClause = " ORDER BY article_contributors.creation_date DESC, article_contributors.contributor_id DESC";
					$articlesType = 'single';
					break;
				default:
					$innerJoinTables[] = 'article_contributor_articles';
					$innerJoinTables[] = 'articles';
					$innerJoinTables[] = 'article_categories';
					$innerJoinTables[] = 'categories';
					$innerJoinTables[] = 'article_page_categories';
					$innerJoinTables[] = 'article_pages';
					$innerJoinTables[] = 'users';
					$innerJoinRelations[] = 'article_contributors.contributor_id = article_contributor_articles.contributor_id';
					$innerJoinRelations[] = 'article_contributor_articles.article_id = articles.article_id';
					$innerJoinRelations[] = 'articles.article_id = article_categories.article_id';
					$innerJoinRelations[] = 'article_categories.cat_id = categories.cat_id';
					$innerJoinRelations[] = 'categories.cat_id = article_page_categories.category_page_id';
					$innerJoinRelations[] = 'article_page_categories.article_page_id = article_pages.article_page_id';
					$innerJoinRelations[] = 'article_contributors.contributor_email_address = users.user_email';
					$whereClause = ' WHERE article_contributors.contributor_bio != "" AND article_contributors.contributor_bio IS NOT NULL AND article_contributors.contributor_image != "" AND users.user_type IN ( 1, 2, 6, 7, 8)';
					$queryParams = [':pageId' => filter_var($this->config['articlepageid'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)];
					$orderClause = [
						" ORDER BY article_contributors.creation_date DESC, article_contributors.contributor_id DESC",//Most Recent
						" ORDER BY article_contributors.creation_date DESC, article_contributors.contributor_id DESC",//Most Popular
						" ORDER BY article_contributors.creation_date DESC, article_contributors.contributor_id DESC",//Most Visited
						" ORDER BY article_contributors.contributor_name ASC, article_contributors.contributor_id DESC",//Alpha A-Z
						" ORDER BY article_contributors.contributor_name DESC, article_contributors.contributor_id DESC"//Alpha Z-A
						];
						$articlesType = 'all';
						break;
				}
				$s = "SELECT *, article_contributors.contributor_id FROM article_contributors";
				if($innerJoinTables) $s.= " INNER JOIN  (:joinedTables) ON (:joinRelations)";

				$i = 0;
				$t = '';
				foreach($innerJoinRelations as $relationShip){
					$t .= $relationShip;
					if($i++ < count($innerJoinRelations) - 1) $t .= " AND ";
				}
				$s = str_replace(':joinedTables', implode(', ', $innerJoinTables), $s);
				$s = str_replace(':joinRelations', $t, $s);
				if(count($leftJoinTables) && count($leftJoinRelations)){
					$s .= " LEFT JOIN (:joinedTables) ON (:joinRelations)";
					$i = 0;
					$t = '';
					foreach($leftJoinRelations as $relationShip){
						$t .= $relationShip;
						if($i++ < count($leftJoinRelations) - 1) $t .= " AND ";
					}
					$s = str_replace(':joinedTables', implode(', ', $leftJoinTables), $s);
					$s = str_replace(':joinRelations', $t, $s);
				}
				if(count($options['omit'])){
					$i = 0;
					$c = count($options['omit']);
					$whereClause .= " AND article_contributors.contributor_id NOT IN (";
						foreach($options['omit'] as $articleId){
							$whereClause .= $articleId;
							if($i++ < count($options['omit']) - 1) $whereClause .= ", ";
						}
						$whereClause .= ")";
		}
		$s .= $whereClause;
		$s .= is_array($orderClause) ? isset($orderClause[$options['sortType'] - 1]) ? $orderClause[$options['sortType'] - 1] : $orderClause[0] : $orderClause;
		if($options['count'] !== -1) $s .= " LIMIT 0, ".$options['count'];
		$pdo = $this->con->openCon();
		$q = $pdo->prepare($s);

		$q->execute($queryParams); 
			if($q){
				$q->setFetchMode(PDO::FETCH_ASSOC);
				$r = ['ids' => [], 'contributors' => [], 'articles' => []];
				while($row = $q->fetch()){
					if(!in_array($row['contributor_id'], $r['ids'])){
						$rating = $pdo->query("SELECT avg(article_ratings.rating) AS rating FROM article_contributor_articles INNER JOIN(articles, article_ratings) ON (article_contributor_articles.article_id = articles.article_id AND articles.article_id = article_ratings.article_id) WHERE article_contributor_articles.contributor_id = ".$row['contributor_id']);
						$ratingArray = [];
						if($rating && $rating->rowCount()) $ratingArray = $rating->fetch(PDO::FETCH_ASSOC);
					$r['ids'][] =$row['contributor_id'];
					$r['contributors'][] = array_merge($row, $ratingArray);

					switch($articlesType){
						case 'featured':
						$r['articles'] = $this->getArticles(['count' => 3, 'contributorId' =>$row['contributor_id']]);
						break;
						case 'single':
						$r['articles'] = $this->getArticles(['count' => -1, 'sortType' => $options['sortType'], 'contributorId' =>$row['contributor_id']]);
						break;
						default:
						$r['articles'] = false;
						break;
					}
				}
			}
			if($options['sortType'] == 2){
				$r['contributors'] = $this->subValSort($r['contributors']);
				$r['ids'] = [];
				foreach($r['contributors'] as $contributor){
					$r['ids'][] = $contributor['contributor_id'];	
				}
			}
			if(count($r['contributors']) < $options['count'] && $attempts < 3 && $options['featured']){
				$options['count'] = $options['count'] - count($r['contributors']);
				$options['pageId'] = null;
				$recursive = $this->getContributors($options, ++$attempts);
				if(is_array($recursive)){
					$r['contributors'] = array_merge($r['contributors'], $recursive['contributors']);
					$r['articles'] = array_merge($r['articles'], $recursive['articles']);
					$r['ids'] = array_merge($r['ids'], $recursive['ids']);
				}
			}
			$this->con->closeCon();
		}else $r = false;

		return $r;
}

//NOT IN USE 
public function getSyndicationVideos($args = []){
	$options = array_merge([
		'videoFileName' => ''
		], $args); 
	$pdo = $this->con->openCon();
	$q = $pdo->query("SELECT * FROM syndication_videos WHERE syndication_videos.syn_video_filename=".$options['videoFileName']);
	if($q && $q->rowCount()){
		$q->setFetchMode(PDO::FETCH_ASSOC);
		while($row = $q->fetch()){
			$r[] = $row;
		}
		$q->closeCursor();
	}else $r = false;
	$this->con->closeCon();
	return $r;
}

public function recordArticleRating($id = null, $vote = null){
	if(is_null($id) || is_null($vote)) return false;
	$pdo = $this->con->openCon();
	$q = $pdo->prepare("INSERT INTO article_ratings (article_id, rating) VALUES (:articleid, :vote)");
	$params = array(
		':articleid' => filter_var($id, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
		':vote' => filter_var($vote, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)
		);
	$q->execute($params);
	if($q){
		$r = true;
	}else{
		$r = false;
	}
	$this->con->closeCon();
	return $r;
}

private function subValSort($a, $type = 'high', $value = 'rating'){
	$b = [];
	foreach($a as $k=>$v){
		$b[$k] = strtolower($v[$value]);
	}
	if($type == "high") arsort($b);
	else asort($b);
	$c = [];
	foreach($b as $k=>$v) {
		$c[] = $a[$k];
	}
	return $c;
}

public function reloadSiteData(){
	$this->data = $this->getArticlePageInfo();
	$this->categories = $MPNavigation->categories;
}

public function getLast10Articles( $articleID, $offset = 0 ){

	$articleID = filter_var($articleID, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
	
	$s = "SELECT articles.article_id, articles.article_title, articles.article_seo_title, categories.cat_dir_name, articles.date_updated 
	FROM articles INNER JOIN ( categories, article_categories ) 
	ON ( articles.article_id = article_categories.article_id )
	AND ( article_categories.cat_id = categories.cat_id )
	WHERE articles.article_status = 1 AND articles.article_id != $articleID AND article_categories.cat_id != 9 
	ORDER BY articles.article_id DESC 
	LIMIT 10 ";

	if( isset($offset) && $offset ){
		$s .= " OFFSET $offset ";
	}

	//var_dump($s);


	$q = $this->performQuery(['queryString' => $s]);
	
	return $q;
}

public function getMostRecentArticleList( $articleID = null ){
	
	$queryString = " SELECT google_analytics_most_viewed_articles.*, articles.article_id  
		from google_analytics_most_viewed_articles 
		INNER JOIN articles 
		ON (article_seo_title = seo_title)  
		ORDER BY pageviews DESC LIMIT 7; ";
	
	$q = $this->performQuery(['queryString' => $queryString]);
	return $q;
}

public function getMostRecentArticleListMobile( ){
	
	$queryString = " SELECT google_analytics_most_viewed_articles.*, articles.*  
	from google_analytics_most_viewed_articles 
	INNER JOIN articles ON (article_seo_title = seo_title)  ORDER BY pageviews DESC LIMIT 20; ";

	$q = $this->performQuery(['queryString' => $queryString]);
	return $q;
}

public function getMostRecentArticleListTrending( ){
	
	$queryString = " SELECT google_analytics_most_viewed_articles.*, articles.article_id, 
	articles.article_seo_title, articles.article_title, articles.date_updated, article_contributors.contributor_name, 
	  article_contributors.contributor_seo_name, categories.cat_name, categories.cat_dir_name
	from google_analytics_most_viewed_articles 
	INNER JOIN (articles, article_categories, categories, article_contributors, article_contributor_articles) 
	ON (article_seo_title = seo_title)
	AND ( articles.article_id = article_categories.article_id)
	AND ( article_categories.cat_id = categories.cat_id)
	AND ( article_contributor_articles.article_id = articles.article_id)
	AND (article_contributors.contributor_id = article_contributor_articles.contributor_id)  
	ORDER BY pageviews DESC; ";

	$q = $this->performQuery(['queryString' => $queryString]);
	return $q;
}

public function getMostRecentArticleListMostPopular( ){
	
	$queryString = " SELECT google_analytics_most_viewed_articles_always.*, articles.article_id, 
	articles.article_seo_title, articles.article_title, articles.date_updated, article_contributors.contributor_name, 
	  article_contributors.contributor_seo_name, categories.cat_name, categories.cat_dir_name
	from google_analytics_most_viewed_articles_always 
	INNER JOIN (articles, article_categories, categories, article_contributors, article_contributor_articles) 
	ON (article_seo_title = seo_title)
	AND ( articles.article_id = article_categories.article_id)
	AND ( article_categories.cat_id = categories.cat_id)
	AND ( article_contributor_articles.article_id = articles.article_id)
	AND (article_contributors.contributor_id = article_contributor_articles.contributor_id)  
	GROUP BY article_seo_title ORDER BY pageviews DESC; ";

	$q = $this->performQuery(['queryString' => $queryString]);
	return $q;
}




//NOT IN USER 
/*
public function getTodaysFavorites(){
	$queryString = "SELECT article.*, parent.cat_id as parent_id, parent.cat_name as parent_name, parent.cat_dir_name as parent_dir_name 

	FROM categories AS cat, categories AS parent 

	INNER JOIN ( SELECT articles.article_id as a_id, articles.article_title as article_title, articles.article_seo_title, articles.article_status, categories.*, article_images.*, article_todays_favorites.slot 
		FROM articles
		INNER JOIN (article_todays_favorites, article_images) 
		ON articles.article_id = article_todays_favorites.article_id 
		AND articles.article_id = article_images.article_id 

		LEFT JOIN (article_categories, categories) 
		ON articles.article_id=article_categories.article_id 
		AND article_categories.cat_id=categories.cat_id 

		WHERE (
			(article_categories.cat_id = 9 AND slot = 1 ) OR
			(article_categories.cat_id = 8 AND slot = 2 ) OR 
			(article_categories.cat_id = 11 AND slot = 3 ) OR
			(article_categories.cat_id = 3 AND slot = 4 ) OR
			(article_categories.cat_id IN (13, 14, 15, 17, 18) AND slot = 5 ) OR
			(article_categories.cat_id = 4 AND slot = 6 ) 
			)
			AND articles.article_status = 1
			GROUP BY slot 
			ORDER BY slot ASC 
			LIMIT 6 
			) as article  

			WHERE (parent.lft > 1
				AND article.lft BETWEEN (parent.lft+1) 
				AND (parent.rgt -1))

			OR (article.cat_id IN (115, 3))

			AND cat.cat_id = article.cat_id 
			GROUP BY article.a_id 
			ORDER BY article.slot ASC ";

	$q = $this->performQuery(['queryString' => $queryString]);
	return $q;
}

public function getCollections( ){

	$queryString = "SELECT * FROM collections;";

	$q = $this->performQuery(['queryString' => $queryString]);

	return $q;
}

public function getCollectionInfo( $keyword ){

	$queryString = "SELECT * FROM collections WHERE collections_seoname = '".$keyword."' LIMIT 1";

	$q = $this->performQuery(['queryString' => $queryString]);

	return $q;
}

public function getRecipeCollections( $keyword ){
	$queryString = "SELECT article.*, parent.cat_id as parent_id, parent.cat_name as parent_name, parent.cat_dir_name as parent_dir_name 

	FROM categories AS cat, categories AS parent 

	INNER JOIN ( 
		SELECT articles.article_id, articles.article_title, articles.article_tags, articles.article_seo_title, articles.article_desc, nc.cat_id, nc.cat_name, nc.cat_dir_name, nc.lft, nc.rgt  
		FROM articles  

		INNER JOIN (article_categories, categories as nc ) 
		ON articles.article_id = article_categories.article_id  
		AND article_categories.cat_id = nc.cat_id 

		WHERE articles.article_status = 1 
		AND articles.article_tags LIKE '%".$keyword."%' 
		GROUP BY articles.article_id 

		ORDER BY articles.article_id DESC 
		) as article  

		WHERE article.lft BETWEEN (parent.lft+1) 
		AND (parent.rgt -1)
		AND cat.cat_id = article.cat_id 
		AND parent.lft > 1
		OR (article.cat_id IN (115, 3))

		GROUP BY article.article_id 

		ORDER BY article.article_id DESC";

	$pdo = $this->con->openCon();

	$q = $this->performQuery(['queryString' => $queryString]);


	if($q){
		foreach( $q as $row ){
			if($row['article_id']){
				$rating = $pdo->query("SELECT avg(article_ratings.rating) AS rating, count(article_ratings.rating) AS reviews FROM article_ratings INNER JOIN (articles) ON (articles.article_id = article_ratings.article_id) WHERE articles.article_id = ".$row['article_id']);
				$ratingArray = [];
				if($rating && $rating->rowCount()) $ratingArray = $rating->fetch(PDO::FETCH_ASSOC);

						//$r['ids'][] =$row['article_id'];
				$r['articles'][] = array_merge($row, $ratingArray);
			}
		}

	}else $r = false;
	$this->con->closeCon();

	return $r;	
}

public function getAllBodyTags(){
	$queryString = "SELECT articles.article_id, articles.article_body ";
	$queryString .="FROM articles ";

	$queryString .="ORDER BY article_id DESC";

	$q = $this->performQuery(['queryString' => $queryString]);
	return $q;
}

public function extractRecipeBodyDataToDBField($fieldName, $pattern){
	$bodyFieldSet = $this->getAllBodyTags();
	$qString = "UPDATE articles SET {$fieldName} = CASE ";
	foreach ($bodyFieldSet as $bodyField){
		$subject =  $bodyField['article_body'];
		$subject = str_replace("'", "", $subject);
		$id = $bodyField['article_id'];
		preg_match($pattern, $subject, $matches);
		$matches = array_shift($matches);
		$id = $bodyField['article_id'];

		$qString .= "WHEN article_id = {$id} THEN '{$matches}' ";

	}
	$qString .= "ELSE {$fieldName} ";
	$qString .= "END;";

	$qString = strip_tags($qString, '<li>, </li>');
	$qString =  (($qString));

	echo htmlspecialchars($qString);
}
private function parseStringCommasIntoArray($dataset){
	foreach ($dataset as $row) {
		$id = $row['article_id'];

		$categoryArray = explode(',', $row['category_id']);
			// var_dump($categoryArray);
		$sql = "";
		for ($i=0; $i<count($categoryArray); $i++){
				// echo" <br />".$i.count($categoryArray)."<br />";
			$sql .= "INSERT INTO article_categories_from_csv_migrated VALUES ({$id}, {$categoryArray[$i]});";
		}
		$qInsert = $this->performQuery(['queryString' => $sql]);
		if ($qInsert){
			return true;
		}

	}
}

public function extractIdAndCommaSeparatedCategories(){
	$qString = "SELECT * FROM article_categories_from_csv";
	$q = $this->performQuery(['queryString' => $qString]);
	if ($q){
		$parsedSet = $this->parseStringCommasIntoArray($q);
	}
}

public function getMostViewed($args = []){
	$options = array_merge([
		'pageId' => 1, 
		'articleCount' => 12, 
			'sortType' =>1, //1 == Most Recent, 2 == Most Popular, 3 == Most Visited, 4 == A-Z, 5 == Z-A
			'featured'=> false, 
			'featureType' =>2, //2 == sidebar (Dish of the Day), 3 == Slideshow 
			'contributorId' => null, 
			'omit'=> [],
			'articleId' => null, 
			'articleTitles' => [],
			'articleSEOTitle' => '',
			'articleSEOTitles' =>[],
			'articleStatus' => 1
			], $args);


	$s = 'SELECT article.*, ';
	$s .= 'parent.cat_id as parent_id, parent.cat_name as parent_name, parent.cat_dir_name as parent_dir_name ';

	$s .= 'FROM categories AS cat, categories AS parent ';

	$s .= 'INNER JOIN ( ';
		$s .= 'SELECT articles.*, ';
		$s .= 'i.article_post_img, i.article_preview_img, nc.cat_id, nc.cat_name, nc.cat_dir_name, nc.lft, nc.rgt, featured.article_id as featured_id, featured.feature_type as feature_type, article_contributors.contributor_id, article_contributors.contributor_name, article_contributors.contributor_image ';
		$s .= 'FROM articles ';


		$s .= 'INNER JOIN (article_images as i, article_categories, categories as nc, articles_featured as featured, article_contributor_articles, article_contributors) ';
		$s .= 'ON articles.article_id = i.article_id ';
		$s .= 'AND articles.article_id = article_categories.article_id ';
		$s .= 'AND article_categories.cat_id = nc.cat_id ';
		$s .= 'AND articles.article_id = featured.article_id ';
		$s .= 'AND articles.article_id = article_contributor_articles.article_id ';
		$s .= 'AND article_contributor_articles.contributor_id = article_contributors.contributor_id ';
		$s .= 'WHERE featured.feature_type = :featureType ';
		$s .= 'AND featured.cat_id = :pageId ';
		$s .= ') as article ';

		$s .= 'WHERE cat.lft BETWEEN parent.lft ';
		$s .= 'AND parent.rgt ';
		$s .= 'AND cat.cat_id = article.cat_id ';
		$s .= 'AND parent.lft > 1 ';
		$s .= 'GROUP BY featured_id ';

		$s .= 'ORDER BY article.article_id DESC ';
				//$s .= 'LIMIT '.$options['articleCount'] ;

		$queryParams = [
		':featureType' => filter_var($options['featureType'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
		':pageId' => filter_var($options['pageId'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)
		];
		$pdo = $this->con->openCon();
		$q = $pdo->prepare($s);
		$row = $q->execute($queryParams);
		// if ($options['featureType'] == 3){var_dump($s); }

	if($row){
			// $q->setFetchMode(PDO::FETCH_ASSOC);
			// $row = $q->fetchAll();
			// $r = ['ids' => [],'articles' => []];
			// $r['articles'] = $row;
			// $q->closeCursor();
	while($row = $q->fetch()){
		if(!in_array($row['article_id'], $r['ids'])){
			$rating = $pdo->query("SELECT avg(article_ratings.rating) AS rating, count(article_ratings.rating) AS reviews FROM article_ratings INNER JOIN (articles) ON (articles.article_id = article_ratings.article_id) WHERE articles.article_id = ".$row['article_id']);
			$ratingArray = [];
			if($rating && $rating->rowCount()) $ratingArray = $rating->fetch(PDO::FETCH_ASSOC);

			$r['ids'][] =$row['article_id'];
			$r['articles'][] = array_merge($row, $ratingArray);
		}
	}
	}else $r = false;
	$this->con->closeCon();
	return $r;		
}
*/
//NOT SURE OF THIS ONE
public function getFeatured($args = []){
	$options = array_merge([
		'pageId' => 1, 
		'articleCount' => -1, 
			'sortType' =>1, //1 == Most Recent, 2 == Most Popular, 3 == Most Visited, 4 == A-Z, 5 == Z-A
			'featured'=> false, 
			'featureType' =>2, //2 == sidebar (Dish of the Day), 3 == Slideshow 
			'contributorId' => null, 
			'omit'=> [],
			'articleId' => null, 
			'articleTitles' => [],
			'articleSEOTitle' => '',
			'articleSEOTitles' =>[],
			'articleStatus' => 1
			], $args);

	$s = 'SELECT article.*, ';
	$s .= 'parent.cat_id as parent_id, parent.cat_name as parent_name, parent.cat_dir_name as parent_dir_name ';

	$s .= 'FROM categories AS cat, categories AS parent ';

	$s .= 'INNER JOIN ( ';
		$s .= 'SELECT articles.*, ';
				//$s .= 'i.article_post_img, i.article_preview_img, nc.cat_id, nc.cat_name, nc.cat_dir_name, nc.lft, nc.rgt, featured.feature_position as position, featured.article_id as featured_id, featured.feature_type as feature_type, article_contributors.contributor_id, article_contributors.contributor_name, article_contributors.contributor_image ';
		$s .= 'i.article_post_img, i.article_preview_img, nc.cat_id, nc.cat_name, nc.cat_dir_name, nc.lft, nc.rgt, featured.feature_position as position, featured.article_id as featured_id, featured.feature_type as feature_type ';
		$s .= ' FROM articles ';


				//$s .= 'INNER JOIN (article_images as i, article_categories, categories as nc, articles_featured as featured, article_contributor_articles, article_contributors) ';
		$s .= 'INNER JOIN (article_images as i, article_categories, categories as nc, articles_featured as featured) ';
		$s .= 'ON articles.article_id = i.article_id ';
		$s .= 'AND articles.article_id = article_categories.article_id ';
		$s .= 'AND article_categories.cat_id = nc.cat_id ';
		$s .= 'AND articles.article_id = featured.article_id ';
				//$s .= 'AND articles.article_id = article_contributor_articles.article_id ';
				//$s .= 'AND article_contributor_articles.contributor_id = article_contributors.contributor_id ';
		$s .= 'WHERE featured.feature_type = :featureType ';

		if ($options['featureType'] == 4 || $options['pageId'] == 115){
			$s .= 'AND featured.cat_id = :pageId ';
			$s .= 'AND articles.article_status = 1 ';
			$s .= ') as article ';
			$s .= 'WHERE cat.lft BETWEEN parent.lft ';
			$s .= 'AND parent.rgt ';				
			} else {
				$s .= 'AND featured.cat_id = :pageId ';
				$s .= 'AND articles.article_status = 1 ';
				$s .= ') as article ';				
				$s .= 'WHERE ';//cat.lft > parent.lft AND cat.rgt < parent.rgt 
				//$s .= 'AND cat.lft < parent.rgt ';
			}
			//$s .= 'AND cat.cat_id = article.cat_id ';
			$s .= 'cat.cat_id = article.cat_id ';
			$s .= 'AND parent.lft > 1 ';
			$s .= 'GROUP BY featured_id ';

			$s .= 'ORDER BY position DESC ';
			if ($options['articleCount'] != -1) {$s .= 'LIMIT '.$options['articleCount']; };

			$queryParams = [
			':featureType' => filter_var($options['featureType'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
			':pageId' => filter_var($options['pageId'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)
			];

			$pdo = $this->con->openCon();
			$q = $pdo->prepare($s);
			$row = $q->execute($queryParams);
			//	 if ($options['featureType'] == 3){var_dump($s); }


			if($row){
				$q->setFetchMode(PDO::FETCH_ASSOC);
				$row = $q->fetchAll();
				$r = ['ids' => [],'articles' => []];
				$r['articles'] = $row;
				$q->closeCursor();
			}else $r = false;
			$this->con->closeCon();
			return $r;		
		}

		public function getAllArticleNames(){
			$s = "SELECT a.article_id, a.article_title, a.article_seo_title, 
			nc.cat_id

			FROM articles as a

			INNER JOIN (article_categories as a_c, categories as nc)
			ON a_c.article_id = a.article_id
			AND a_c.cat_id = nc.cat_id

			WHERE a.article_status = 1
			GROUP BY a.article_id
			ORDER BY a.article_title ";
			$q = $this->performQuery(['queryString' => $s]);
			return $q;
		}


		public function getByName($args = []){
			$options = array_merge([
				'pageId' => 1, 
			'sortType' =>1, //1 == Most Recent, 2 == Most Popular, 3 == Most Visited, 4 == A-Z, 5 == Z-A
			'articleCount' => -1, 
			'featured'=> false, 
			'featureType' =>2, //2 == sidebar (Dish of the Day), 3 == Slideshow 
			'contributorId' => null, 
			'omit'=> [],
			'articleId' => null, 
			'articleTitles' => [],
			'articleSEOTitle' => '',
			'articleSEOTitles' =>[],
			'articleStatus' => 1
			], $args);

			$s = 'SELECT articles.*, article_contributors.contributor_id, article_contributors.contributor_name, article_contributors.contributor_email_address, article_contributors.contributor_image, 
			article_images.article_preview_img, article_images.article_post_img, article_moblogs_featured.article_cat,  article_moblogs_featured.article_featured_hp  
			
			FROM articles 

			LEFT JOIN ( article_contributor_articles, article_contributors) 
			ON articles.article_id = article_contributor_articles.article_id 
			AND article_contributor_articles.contributor_id = article_contributors.contributor_id 

			LEFT JOIN article_moblogs_featured
			ON articles.article_id = article_moblogs_featured.article_id

			LEFT JOIN article_images
			ON articles.article_id = article_images.article_id

			WHERE articles.article_seo_title = :articleSEOTitle
			GROUP BY articles.article_id 
			ORDER BY articles.article_id DESC LIMIT 1';

			$queryParams = [
			':articleSEOTitle' => filter_var($options['articleSEOTitle'], FILTER_SANITIZE_STRING, PDO::PARAM_STR)
			];
			$pdo = $this->con->openCon();
			$q = $pdo->prepare($s);
			$articleRow = $q->execute($queryParams);		

			if($articleRow){
				$q->setFetchMode(PDO::FETCH_ASSOC);
				$articleRow = $q->fetchAll();
				$article = ['ids' => [],'articles' => [], 'categories' => []];
				$article['articles'] = array_shift($articleRow);
				$article['categories'] = $this->performQuery(array(
					'queryString' => 'SELECT * 
					FROM article_categories as a_c 

					INNER JOIN (categories as nc) 
					ON (a_c.cat_id = nc.cat_id) 

					WHERE a_c.article_id = '.$article['articles']['article_id'],
					'returnRowAsSingleArray' => false
					));
				$q->closeCursor();
			}else $article = false;
			$this->con->closeCon();

			return $article;

		}

	// public function getMostViewed(){

	// }

		
		public function insertSubscribers($articleId, $email){

			$s = "INSERT INTO subscribers
			(article_id, email_address)
			VALUES
			(:articleId, '".$email."' )";

			$queryParams = [
			':articleId' => filter_var($articleId, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)
			];

			$pdo = $this->con->openCon();
			
			$q = $pdo->prepare($s);
			$row = $q->execute($queryParams);

			$this->con->closeCon();
			return $row ; 
		}

		//NOT IN USE ON PUCKERMOB
		public function updateViewCount($articleId){

			$s = "INSERT INTO count
			(view_count, article_id)
			VALUES
			(1, :articleId)
			ON DUPLICATE KEY UPDATE
			article_id = article_id, view_count = view_count + 1 ";

			$queryParams = [
			':articleId' => filter_var($articleId, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)
			];

			$pdo = $this->con->openCon();
			$q = $pdo->prepare($s);
			$row = $q->execute($queryParams);

			$this->con->closeCon();
			
			return $s; 
		}

		//NOT IN USE ON PUCKERMOB
		public function updateFBShares($count, $article_id){
			if( $count == 0 ) $count = 1;

			if( $count > 0 ){
				$current_date = date('Y-m-d H:i:s', time());
				$s = "UPDATE articles 
					  SET fb_shares = :fbShares, fb_shares_update = :fbSharesUpdate
					  WHERE article_id = :articleId";

				
				$queryParams = [
				':articleId' => filter_var($article_id, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
				':fbShares' => filter_var($count, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
				':fbSharesUpdate' => $current_date
				];
				
				$pdo = $this->con->openCon();
				$q = $pdo->prepare($s);

				$row = $q->execute($queryParams);

				$this->con->closeCon();

				return $row; 
			}else{
				return false;
			}
		}

		private function verifyArticleidonSocial( $articleId, $month ){
			$s="SELECT article_id FROM social_media_records WHERE article_id = :articleID AND month = :month";

			$queryParams = [':articleID' => filter_var($articleId, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
							':month' => filter_var($month, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT) ];

			$pdo = $this->con->openCon();
			
			$q = $pdo->prepare($s);

			$row = $q->execute($queryParams);

			$this->con->closeCon();

			return $row; 

		}

		/* INSERT OR UPDATE RECORDS TO THE SOCIAL MEDIA TABLE */
		public function updateSocialMediaShares($counts, $articleId, $month ){
	
			if( $articleId ){
				$current_date = date('Y-m-d H:i:s', time());

				if(!isset($counts)) return false;

				$idExist = $this->verifyArticleidonSocial( $articleId , $month );
				$facebook_shares = $counts['Facebook']['share_count'];
				$twitter_shares = $counts['Twitter'];
				$pinterest_shares = $counts['Pinterest'];
				$google_shares = $counts['GooglePlusOne'];
				$delicious_shares = $counts['Delicious'];
				$stumbleupon_shares = $counts['StumbleUpon'];
				$linkedin_shares = $counts['LinkedIn'];


				if(!isset($counts)) return false;
				if($idExist){
					$s = " UPDATE articles 
					  	   SET facebook_shares = :facebook_shares, twitter_shares = :twitter_shares, 
					           pinterest_shares = :pinterest_shares, google_shares = :google_shares, 
					           delicious_shares = :delicious_shares, stumbleupon_shares = : stumbleupon_shares,
					           linkedin_shares = :linkedin_shares 
					        WHERE article_id = :articleId ";
				}else{
					$s = " INSERT INTO social_media_records
						   (`id`, `article_id`, `facebook_shares`, `twitter_shares`, `pinterest_shares`, `google_shares`,
						    `linkedin_shares`, `delicious_shares`, `stumbleupon_shares`, `month`) 
						   VALUES (NULL, ':articleId', ':facebook_shares', ':twitter_shares', ':pinterest_shares', ':google_shares',
						    ':linkedin_shares', ':delicious_shares', ':stumbleupon_shares', ':month') ";
				}
		

				$queryParams = [
					':articleId' => filter_var($articleId, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
					':facebook_shares' => filter_var($facebook_shares, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
					':twitter_shares' => filter_var($twitter_shares, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT), 
					':pinterest_shares' => filter_var($pinterest_shares, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
					':google_shares' => filter_var($google_shares, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
					':delicious_shares' => filter_var($delicious_shares, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
					':stumbleupon_shares' => filter_var($stumbleupon_shares, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
					':linkedin_shares' => filter_var($linkedin_shares, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
					':month' => filter_var($month, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)
				];

				$pdo = $this->con->openCon();
				$q = $pdo->prepare($s);

				$row = $q->execute($queryParams);

				$this->con->closeCon();

				return $row; 
			}else{
				return false;
			}
		}

	public function getMostRecentByCatId($args = []){
			$options = array_merge([
				'pageId' => 1, 
			'sortType' =>1, //1 == Most Recent, 2 == Most Popular, 3 == Most Visited, 4 == A-Z, 5 == Z-A
			'articleCount' => -1, 
			'featured'=> false, 
			'featureType' =>2, //2 == sidebar (Dish of the Day), 3 == Slideshow 
			'contributorId' => null, 
			'omit'=> [],
			'articleId' => null, 
			'articleTitles' => [],
			'articleSEOTitle' => '',
			'articleSEOTitles' =>[],
			'articleStatus' => 1
			], $args);
			$catId = $options['pageId'];
			$s = "SELECT articles.*, nc.cat_id, nc.cat_name, nc.cat_dir_name, article_contributors.contributor_name, article_contributors.contributor_seo_name
			FROM articles  

			INNER JOIN (article_categories, categories as nc) 
			ON articles.article_id = article_categories.article_id  
			AND article_categories.cat_id = nc.cat_id 
			
			LEFT JOIN (article_contributor_articles, article_contributors)
			ON article_contributor_articles.article_id = articles.article_id 
			AND article_contributors.contributor_id = article_contributor_articles.contributor_id

			WHERE articles.article_status = 1 
			AND nc.cat_id = {$catId} 
			GROUP BY articles.article_id 

			ORDER BY articles.date_updated DESC 
			";
			//	ORDER BY articles.article_id DESC 
			$queryParams = [ ];
			$pdo = $this->con->openCon();
			$q = $pdo->prepare($s);
			$row = $q->execute($queryParams);		

			if($row){
				$q->setFetchMode(PDO::FETCH_ASSOC);
				$r = ['ids' => [],'articles' => []];
				while($row = $q->fetch()){
					if(!in_array($row['article_id'], $r['ids'])){
						$rating = $pdo->query("SELECT avg(article_ratings.rating) AS rating, count(article_ratings.rating) AS reviews FROM article_ratings INNER JOIN (articles) ON (articles.article_id = article_ratings.article_id) WHERE articles.article_id = ".$row['article_id']);
						$ratingArray = [];
						if($rating && $rating->rowCount()) $ratingArray = $rating->fetch(PDO::FETCH_ASSOC);
						$r['ids'][] =$row['article_id'];
						$r['articles'][] = array_merge($row, $ratingArray);
					}
				}
			}else $r = false;
			$this->con->closeCon();
			return $r;
	}


	public function getArticleRSS($args = []){
			$options = array_merge([
				'pageId' => 1, 
			'sortType' =>1, //1 == Most Recent, 2 == Most Popular, 3 == Most Visited, 4 == A-Z, 5 == Z-A
			'articleCount' => -1, 
			'featured'=> false, 
			'featureType' =>2, //2 == sidebar (Dish of the Day), 3 == Slideshow 
			'contributorId' => null, 
			'omit'=> [],
			'articleId' => null, 
			'articleTitles' => [],
			'articleSEOTitle' => '',
			'articleSEOTitles' =>[],
			'articleStatus' => 1
			], $args);

			$s = "SELECT articles.*, nc.cat_id, nc.cat_name, nc.cat_dir_name, nc.lft, nc.rgt  
			FROM articles  

			INNER JOIN (article_categories, categories as nc ) 
			ON articles.article_id = article_categories.article_id  
			AND article_categories.cat_id = nc.cat_id 

			WHERE articles.article_status = 1 
			GROUP BY articles.article_id 

			ORDER BY articles.article_id DESC 
			LIMIT 25
			";

			$queryParams = [ ];
			$pdo = $this->con->openCon();
			$q = $pdo->prepare($s);
			$row = $q->execute($queryParams);		

			if($row){
				$q->setFetchMode(PDO::FETCH_ASSOC);
				$r = ['ids' => [],'articles' => []];
				while($row = $q->fetch()){
					if(!in_array($row['article_id'], $r['ids'])){
						$rating = $pdo->query("SELECT avg(article_ratings.rating) AS rating, count(article_ratings.rating) AS reviews FROM article_ratings INNER JOIN (articles) ON (articles.article_id = article_ratings.article_id) WHERE articles.article_id = ".$row['article_id']);
						$ratingArray = [];
						if($rating && $rating->rowCount()) $ratingArray = $rating->fetch(PDO::FETCH_ASSOC);
						$r['ids'][] =$row['article_id'];
						$r['articles'][] = array_merge($row, $ratingArray);
					}
				}
			}else $r = false;
			$this->con->closeCon();
		
			return $r;
	}

	public function getArticlesByParams($args = []){
			$options = array_merge([
				'pageId' => 1, 
			'sortType' =>1, //1 == Most Recent, 2 == Most Popular, 3 == Most Visited, 4 == A-Z, 5 == Z-A
			'articleCount' => -1, 
			'featured'=> false, 
			'featureType' =>2, //2 == sidebar (Dish of the Day), 3 == Slideshow 
			'contributorId' => null, 
			'omit'=> [],
			'articleId' => null, 
			'articleTitles' => [],
			'articleSEOTitle' => '',
			'articleSEOTitles' =>[],
			'articleStatus' => 1
			], $args);


			$s = 'SELECT article.*, parent.cat_id as parent_id, parent.cat_name as parent_name, parent.cat_dir_name as parent_dir_name '; 

			$s .= 'FROM categories AS cat, categories AS parent ';

			$s .= 'INNER JOIN ( ';
				$s .= 'SELECT articles.*, i.article_post_img, i.article_preview_img, nc.cat_id, nc.cat_name, nc.cat_dir_name, nc.lft, nc.rgt, article_contributors.contributor_id, article_contributors.contributor_name, article_contributors.contributor_image '; 
				$s .= 'FROM articles '; 

				$s .= 'INNER JOIN (article_images as i, article_categories, categories as nc, articles_featured as featured, article_contributor_articles, article_contributors) '; 
				$s .= 'ON articles.article_id = i.article_id '; 
				$s .= 'AND articles.article_id = article_categories.article_id '; 
				$s .= 'AND article_categories.cat_id = nc.cat_id ';
				$s .= 'AND articles.article_id = article_contributor_articles.article_id '; 
				$s .= 'AND article_contributor_articles.contributor_id = article_contributors.contributor_id ';
				if ($options['pageId'] != 1){
					$s .= 'WHERE nc.cat_id = :pageId ';
					$s .= 'AND articles.article_status = 1 ';
				} else {
					$s .= 'WHERE articles.article_status = 1 ';					
				}
				$s .= 'GROUP BY articles.article_id ';

				$s .= 'ORDER BY articles.article_id DESC ';
				if ($options['articleCount'] != -1){
					$s .= 'LIMIT '. $options['articleCount']; 
				}
				$s .= ') as article '; 

			if ( $options['pageId'] == 3 || $options['pageId'] == 4 || $options['pageId'] == 115 ){
				$s .= 'WHERE cat.lft BETWEEN parent.lft AND parent.rgt ';
				$s .= 'AND cat.cat_id = article.cat_id '; 
				$s .= 'AND parent.lft > 1 ';
			} else {

				$s .= 'WHERE cat.lft > parent.lft AND cat.rgt < parent.rgt ';
				$s .= 'AND cat.lft < parent.rgt ';
			}

			$s .= 'GROUP BY article.article_id ';
			$s .= 'ORDER BY article.date_updated DESC';
			//$s .= 'ORDER BY article.article_id DESC';
			$queryParams = [
			':pageId' => filter_var($options['pageId'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)
			];
			$pdo = $this->con->openCon();
			$q = $pdo->prepare($s);
			$row = $q->execute($queryParams);		

			if($row){
				$q->setFetchMode(PDO::FETCH_ASSOC);
				$r = ['ids' => [],'articles' => []];
				while($row = $q->fetch()){
					if(!in_array($row['article_id'], $r['ids'])){
						$rating = $pdo->query("SELECT avg(article_ratings.rating) AS rating, count(article_ratings.rating) AS reviews FROM article_ratings INNER JOIN (articles) ON (articles.article_id = article_ratings.article_id) WHERE articles.article_id = ".$row['article_id']);
						$ratingArray = [];
						if($rating && $rating->rowCount()) $ratingArray = $rating->fetch(PDO::FETCH_ASSOC);
						$r['ids'][] =$row['article_id'];
						$r['articles'][] = array_merge($row, $ratingArray);
					}
				}
			}else $r = false;
			$this->con->closeCon();
					// var_dump($s);		
			return $r;
}

protected function performQuery($opts){
	$options = array_merge(array(
		'queryString' => '',
		'queryParams' => array(),
		'returnRowAsSingleArray' => true,
		'bypassCache' => false,
			'returnCount' => false  //	true: performQuery will only return a count of rows
			), $opts);
		$cachedData = false;
	if($cachedData === false || $options['bypassCache'] === true){
		$pdo = $this->con->openCon();
		$q = $pdo->prepare($options['queryString']);
		$q->execute($options['queryParams']);
		if($q && $q->rowCount()){
			$r = array();
			while($row = $q->fetch(PDO::FETCH_ASSOC)){
				$r[] = $row;
			}
		}else $r = false;
		if($options['returnRowAsSingleArray'] === true && $r && count($r) == 1) $r = $r[0];
		$this->con->closeCon();

		if($options['returnCount'] === true){
			return $q->rowCount();
		}

		return $r;
	}else return $cachedData;
}

public function countFiltered($order, $articleStatus = '1, 2, 3', $userArticlesFilter, $articleType = 'all') {
	$status_sql = " WHERE article_status = $articleStatus";

	$s = "SELECT count( DISTINCT a.article_id) as simpledish_article_count 
	FROM articles AS a
	INNER JOIN ( article_categories AS a_c, categories AS nc, article_contributors, article_contributor_articles) 
		ON a_c.article_id = a.article_id
		AND a_c.cat_id = nc.cat_id
		AND a.article_id = article_contributor_articles.article_id
		AND article_contributors.contributor_id = article_contributor_articles.contributor_id ";
	$s .= $status_sql;		
	if ($userArticlesFilter != 'all'){
		$s .=	" AND article_contributors.contributor_email_address =  '".$userArticlesFilter."' ";
	}

	if ($articleType != 'all'){
		if($articleType == 'bloggers') 	$s .=	" AND a_c.cat_id =  9 ";
		if($articleType == 'writers' ) 	$s .=	" AND a_c.cat_id !=  9 ";
	}
	$queryParams = [
			':userArticlesFilter' => filter_var($userArticlesFilter, FILTER_SANITIZE_STRING, PDO::PARAM_STR)
	];				
	$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);
	if ($q){
		return array_shift($q);
	}
}


public  function get_filtered($limit = 10, $order = '', $articleStatus = '1, 2, 3', $userArticlesFilter, $offset, $articleType = 'all' ) {
	
	switch ($order) {
		case 'az':
		$order_sql = " ORDER BY a.article_title ASC ";
		break;
		case 'za':
		$order_sql = " ORDER BY a.article_title DESC ";
		break;
		//default:
		//$order_sql = " ORDER BY a.article_id DESC ";
		//break;
	}
	switch($articleStatus) {
		case '1':
		$order_sql = " ORDER BY a.article_status = 1 DESC, a.creation_date DESC ";
		break;
		case '2':
		$order_sql = " ORDER BY a.article_status = 2 DESC, a.creation_date DESC ";
		break;
		case '3':
		$order_sql = " ORDER BY a.article_status = 3 DESC, a.creation_date DESC ";
		break;
		default:
		$order_sql = " ORDER BY a.article_status = 1 DESC, a.creation_date DESC ";
		break;
	}

	//var_dump($articleStatus); die;
	
	$status_sql = " WHERE article_status IN ( $articleStatus )";
	$limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
	$offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
	
	$s = "SELECT a.article_id, a.article_title, a.article_seo_title, a.article_desc, a.article_body, a.article_status, a.creation_date, a.date_updated, 
	 a.article_agree_edits, nc.cat_id, nc.cat_dir_name, '0' as us_traffic, article_contributors.contributor_name, article_contributors.contributor_seo_name, users.user_email, users.user_type, users.user_id 
	FROM articles as a
	INNER JOIN (article_categories as a_c, categories as nc, article_contributors, article_contributor_articles, users)
	ON a_c.article_id = a.article_id
	AND a_c.cat_id = nc.cat_id
	AND a.article_id = article_contributor_articles.article_id
	AND article_contributors.contributor_id = article_contributor_articles.contributor_id 
	AND users.user_email = article_contributors.contributor_email_address ";
	$s .= $status_sql;

	if ($userArticlesFilter != 'all'){
		$s .=	"AND article_contributors.contributor_email_address = :userArticlesFilter ";
	}

	if ($articleType != 'all'){
		if($articleType == 'bloggers') 	$s .=	" AND a_c.cat_id = 9 ";
		if($articleType == 'writers' ) 	$s .=	" AND a_c.cat_id != 9 ";
	}
	$s .= " GROUP BY a.article_id ";
	$s .= $order_sql;
	$s .= 	"LIMIT {$limit} 
	OFFSET {$offset}";	

var_dump($s);

	$queryParams = [':userArticlesFilter' => filter_var($userArticlesFilter, FILTER_SANITIZE_STRING, PDO::PARAM_STR)];			

	$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);
	
	if ($q && isset($q[0])){
			// If $q is an array of only one row (The set only contains one article), return it inside an array
		return $q;
	} else if ($q && !isset($q[0])){
			// If $q is an array of rows, return it as normal
		$q = array($q);
		return $q;
	} else {
		return false;
	}
}

//I THINK IS NOT IN USE RIGHT NOW
public function get_dashboardArticles($limit = 10, $order = '', $articleStatus = '1, 2, 3', $userArticlesFilter, $offset, $month) {

	switch ($order) {
		case 'az':
		$order_sql = " ORDER BY a.article_title ASC ";
		break;
		case 'za':
		$order_sql = " ORDER BY a.article_title DESC ";
		break;
		default:
		$order_sql = " ORDER BY a.article_id DESC ";
		break;
	}
	switch($articleStatus) {
		case '2':
		$order_sql = " ORDER BY a.article_status = 2 DESC, a.article_id ASC ";
		break;
		case '3':
		$order_sql = " ORDER BY a.article_status = 3 DESC, a.article_id ASC ";
		break;
	}

	$status_sql = " WHERE article_status = 1 AND social_media_records.month = ".$month ." ";
	$limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
	$offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
	$s = "SELECT a.article_id, a.article_title, a.article_seo_title, a.article_desc, a.article_status, 
	a.article_type, a.creation_date, nc.cat_id, article_rates.rate_by_article, article_rates.rate_by_share, 
	facebook_shares, twitter_shares, pinterest_shares, google_shares, linkedin_shares, delicious_shares, 
	stumbleupon_shares, month, year
	FROM articles as a
	INNER JOIN (article_categories as a_c, categories as nc, article_contributors, article_contributor_articles, 
			article_rates, social_media_records ) 
	ON a_c.article_id = a.article_id 
	AND a_c.cat_id = nc.cat_id 
	AND a.article_id = article_contributor_articles.article_id 
	AND article_contributors.contributor_id = article_contributor_articles.contributor_id
	AND a.article_type = article_rates.rate_id

	AND a.article_id = social_media_records.article_id ";

	$s .= $status_sql;
	if ($userArticlesFilter != 'all'){
		$s .=	"AND article_contributors.contributor_email_address = :userArticlesFilter ";
	}
	$s .= " GROUP BY a.article_id ";
	$s .= $order_sql;
	$s .= 	"LIMIT {$limit} OFFSET {$offset}";	

	$queryParams = [':userArticlesFilter' => filter_var($userArticlesFilter, FILTER_SANITIZE_STRING, PDO::PARAM_STR)];			
	$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);
	if ($q && isset($q[0])){
			// If $q is an array of only one row (The set only contains one article), return it inside an array
		return $q;
	} else if ($q && !isset($q[0])){
			// If $q is an array of rows, return it as normal
		$q = array($q);
		return $q;
	} else {
		return false;
	}
}

public function getTotalUsPageviews( $ids = null ){
	/// $ids = filter_var($article_id, FILTER_SANITIZE_STRING, PDO::PARAM_STR);
	 $s = " SELECT sum(usa_pageviews) as total_usa_pv, article_id  FROM `google_analytics_data_daily` ";

	 if($ids != null ) $s.= ' WHERE article_id IN ( '.$ids.' ) ';

	 $s.= " group by article_id  LIMIT 1000 ";
	$q = $this->performQuery(['queryString' => $s]);


	return $q;
 
}

/**
 *	
 *	Returns the next LIVE article that has a page list associated with it
 *	
 *	@param 	int 		$current_article_id 	The current article_id
 *	@return array 		The dataset
 */	
public function get_next_with_list($current_article_id){
	
	$s = "SELECT articles.article_id, articles.article_title, 
	articles.article_seo_title, articles.creation_date, articles.article_status, 
	articles.page_list_id, categories.cat_name, categories.cat_dir_name
	FROM articles
	INNER JOIN ( article_categories, categories )
	ON articles.article_id=article_categories.article_id 
		AND article_categories.cat_id=categories.cat_id 

	WHERE articles.article_id < {$current_article_id}
	AND articles.page_list_id >0
	AND articles.article_status = 1

	ORDER BY articles.article_id DESC

	LIMIT 1 ";
	
	$q = $this->performQuery(['queryString' => $s]);
	return ($q);

}

public function count_all_contributors() {

	$s = "SELECT count( DISTINCT contributor_id) as simpledish_contributor_count
	FROM article_contributors";
	$q = $this->performQuery(['queryString' => $s]);

	return array_shift($q);
}

public function getUserList(){
	$options = array(
		'queryString' => "SELECT * FROM users WHERE user_type = 3",
		'queryParams' => array(),
		'returnRowAsSingleArray' => true,
		'bypassCache' => true
	);
	return $this->performQuery($options);
}

public function getUserInfo(){
	if(!isset($_SESSION['user_id'])) return false;
	$options = array(
		'queryString' => "SELECT * FROM users as u 
		INNER JOIN (user_logins as ul, user_types as ut, user_permissions as up, article_contributors as c) 

		ON (u.user_id = ul.user_id 
			AND c.contributor_email_address = u.user_email
			AND u.user_type = ut.user_type 
			AND ut.user_type = up.user_type) 

	WHERE u.user_id = :userId 
	AND ul.user_login_valid = 1",
	'queryParams' => array(':userId' => $_SESSION['user_id']),
	'returnRowAsSingleArray' => true,
	'bypassCache' => true
	);
	return $this->performQuery($options);
}


/***** Article Page ( Get prev. and next article from the current article in the same category ) ********/
/*public function getPrevArticle( $article_id = null, $cat_id = 1){
	$article_id = filter_var($article_id, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
	$cat_id = filter_var($cat_id, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);

	$s = "
		SELECT articles.article_id, articles.article_title, articles.article_seo_title, categories.cat_dir_name
		FROM articles
		INNER JOIN (categories, article_categories)
   			ON (articles.article_id = article_categories.article_id
   			AND article_categories.cat_id = categories.cat_id)
		WHERE articles.article_id < ".$article_id."  && articles.article_status = 1 && categories.cat_id = ".$cat_id."
		 ORDER BY articles.article_id DESC 
		LIMIT 1
	";

	$q = $this->performQuery(['queryString' => $s]);

	return $q;

}

public function getNextArticle( $article_id = null, $cat_id = 1){
	$article_id = filter_var($article_id, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
	$cat_id = filter_var($cat_id, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);

	$s = "
		SELECT articles.article_id, articles.article_title, articles.article_seo_title, categories.cat_dir_name
		FROM articles
		INNER JOIN (categories, article_categories)
   			ON (articles.article_id = article_categories.article_id
   			AND article_categories.cat_id = categories.cat_id)
		WHERE articles.article_id > ".$article_id."  && articles.article_status = 1 && categories.cat_id = ".$cat_id."
		 ORDER BY articles.article_id ASC 
		LIMIT 1
	";

	$q = $this->performQuery(['queryString' => $s]);

	return $q;

}*/

public function redirectTo($location = ''){
		header('Location: '.$this->config['this_url'].$location);
}

public function getFeaturedArticles(){
		
		$s = " SELECT articles_featured.article_id, articles.article_title, articles.article_seo_title, articles.article_desc, categories.cat_dir_name, article_contributors.contributor_name, article_contributors.contributor_seo_name  
			FROM articles_featured 
			INNER JOIN ( articles, article_categories, categories, article_contributors, article_contributor_articles )
			ON articles_featured.article_id=articles.article_id 
			AND articles.article_id=article_categories.article_id 
			AND article_categories.cat_id=categories.cat_id 
			AND articles_featured.article_id = article_contributor_articles.article_id
			AND article_contributor_articles.contributor_id = article_contributors.contributor_id ORDER BY articles_featured.featured_id DESC";
		
			$q = $this->performQuery(['queryString' => $s]);

			return $q;
	}

}
?>