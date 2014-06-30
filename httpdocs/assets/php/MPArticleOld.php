<?php
require_once dirname(__FILE__).'/Connector.php';
require 'MPMemcache.php';

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
		$this->memcache = new MPMemcache($this->config);
	}

	private function getArticlePageInfo($id = 1){
		$pdo = $this->con->openCon();
		$id = (is_null($id)) ? $this->config['articlepageid'] : $id;
		$pageQueryString = "SELECT * FROM article_pages "; 

		$pageQueryString .= "INNER JOIN (article_page_ads, article_page_images, article_page_styling, article_page_social_settings, categories, old_categories) ";
		$pageQueryString .= "ON (article_pages.article_page_id = article_page_ads.article_page_id ";
		$pageQueryString .= "AND article_pages.article_page_id = article_page_images.article_page_id "; 
		$pageQueryString .= "AND article_pages.article_page_id = article_page_styling.article_page_id "; 
		$pageQueryString .= "AND article_pages.article_page_id = article_page_social_settings.article_page_id "; 
		$pageQueryString .= "AND article_pages.cat_id = old_categories.cat_id) ";
		$pageQueryString .= "LEFT JOIN(article_page_player_settings) ";
		$pageQueryString .= "ON (article_pages.article_page_id = article_page_player_settings.article_page_id) ";

		$pageQueryString .= "LEFT JOIN (syndication_sites) ";
		$pageQueryString .= "ON (syndication_sites.syn_api_key = article_page_player_settings.player_setting_api_key) ";

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
			'article_categories',
			'article_pages',
			'article_page_categories',
			'categories', 
			'article_images', 
			'article_contributor_articles', 
			'contributors',
			'articles_featured'
	
		];
		$innerJoinRelations = [
			'articles.article_id = article_categories.article_id',
			'article_pages.article_page_id = article_page_categories = article_page_id',
			'article_page_categories.category_id = categories.cat_id',
			'article_categories.cat_id = categories.cat_id',
			'article_images.article_id = articles.article_id',
			'articles.article_id = article_contributor_articles.article_id',
			'article_contributor_articles.contributor_id = contributors.contributor_id',
			'articles_featured.article_id = articles.article_id'
		];
		$leftJoinTables = [
			'article_videos',
			'syndication_videos'
		];
		$leftJoinRelations = [
			'articles.article_id = article_videos.article_id', 
			'article_videos.syn_video_id = syndication_videos.syn_video_id'
		];

		$categoryJoinTables = [
			'parents, parents_categories'
		];
		$categoryJoinRelations = [
			'categories.cat_id = parents_categories.cat_id',
			'parents_categories.parent_id = parents.parent_id'
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
				$innerJoinTables = [ 'article_images', 'article_categories', 'article_category_pages', 'article_page_categories', 'article_pages'];
				$innerJoinTables[] = 'article_contributor_articles';
				$innerJoinTables[] = 'article_contributors';
				
				$innerJoinRelations = ['articles.article_id = article_images.article_id', 'articles.article_id = article_categories.article_id', 'article_categories.category_page_id = article_category_pages.category_page_id',
				'article_category_pages.category_page_id = article_page_categories.category_page_id', 'article_page_categories.article_page_id = article_pages.article_page_id'];
				$innerJoinRelations[] = 'articles.article_id = article_contributor_articles.article_id';
				$innerJoinRelations[] = 'article_contributor_articles.contributor_id = article_contributors.contributor_id';

				$categoryJoinTables = ['article_page_main_categories'];				
				$categoryJoinRelations = ['article_category_pages.category_page_id = article_page_main_categories.child_category_id'];

				$groupByClause = "";
				
				$whereClause = " WHERE article_contributors.contributor_id = :contributorId";
				$orderClause = [
					" ORDER BY articles.creation_date DESC, articles.article_id DESC",//Most Recent
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
				$orderClause = " ORDER BY articles.creation_date DESC";
				$articleTitles = '';
				foreach($options['articleSEOTitles'] as $title){
					if(!empty($articleTitles)) $articleTitles .= ", ";
					$articleTitles .= "'$title'";
				}
				$whereClause = preg_replace('/{articleTitles}/', $articleTitles, $whereClause);
				$queryParams = [];
				break;
			default:
// FEATURED
				$groupByClause = "";
				if($options['featured']){
					if($options['featureType'] == 2 || $options['featureType'] == 4) $options['count'] = 1;
					if(is_null($options['pageId'])){
						$innerJoinTables = ['article_categories', 'nested_category', 'article_images', 'article_contributor_articles', 'contributors', 'articles_featured'];
						$innerJoinRelations = [
						 'articles.article_id = article_categories.article_id', 
						 'article_categories.cat_id = nested_category.cat_id', 
						 'article_images.article_id = articles.article_id', 
						 'articles.article_id = article_contributor_articles.article_id', 
						 'article_contributor_articles.contributor_id = contributors.contributor_id', 
						 'articles_featured.article_id = articles.article_id'
						];
						$whereClause = " WHERE articles_featured.cat_id = :pageId ";
						$whereClause .= " AND articles_featured.feature_type = :featureType "; 
						$whereClause .= " AND articles.article_status = 1";
						$groupByClause = " GROUP BY articles.article_id";
						
						$orderClause = "";

					}else{
						$innerJoinTables = ['article_categories', 'nested_category', 'article_images', 'article_contributor_articles', 'contributors', 'articles_featured'];
						$innerJoinRelations = [
						 'articles.article_id = article_categories.article_id', 
						 'article_categories.cat_id = nested_category.cat_id', 
						 'article_images.article_id = articles.article_id', 
						 'articles.article_id = article_contributor_articles.article_id', 
						 'article_contributor_articles.contributor_id = contributors.contributor_id', 
						 'articles_featured.article_id = articles.article_id'
						];
						$whereClause = " WHERE articles_featured.cat_id = :pageId ";
						$whereClause .= " AND articles_featured.feature_type = :featureType "; 
						$whereClause .= " AND articles.article_status = 1";
						$groupByClause = " GROUP BY articles.article_id";
						$orderClause = "";
					}
					$queryParams = [
						':pageId' => filter_var((is_null($options['pageId'])) ? $this->config['articlepageid'] : $options['pageId'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
						':featureType' => filter_var($options['featureType'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)
					];

				}else{
					$whereClause = (is_null($options['pageId'])) ? " WHERE article_pages.article_page_id = :pageId" : " WHERE article_category_pages.category_page_id = :pageId";
					$queryParams = [':pageId' => filter_var((is_null($options['pageId'])) ? $this->config['articlepageid'] : $options['pageId'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)];
					$orderClause = [
						" ORDER BY articles.creation_date DESC, articles.article_id DESC",//Most Recent
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
		// $s .= is_array($orderClause) ? isset($orderClause[$options['sortType'] - 1]) ? $orderClause[$options['sortType'] - 1] : $orderClause[0] : $orderClause;
		// if($options['sortType'] !== 2 && $options['count'] !== -1) $s .= " LIMIT 0, ".$options['count'];
		$pdo = $this->con->openCon();

		$q = $pdo->prepare($s);
		$row = $q->execute($queryParams);
		if($row){
			$q->setFetchMode(PDO::FETCH_ASSOC);
			$r = ['ids' => [],'articles' => []];

			while($row = $q->fetch()){
				if(!in_array($row['article_id'], $r['ids'])){
					$rating = $pdo->query("SELECT avg(article_ratings.rating) AS rating, count(article_ratings.rating) AS reviews FROM article_ratings INNER JOIN (articles) ON (articles.article_id = article_ratings.article_id) WHERE articles.article_id = ".$row['article_id']);
					// $parent_category = $pdo->query("SELECT category_page_name as parent_category_name, category_page_directory as parent_category_page_directory FROM article_category_pages WHERE category_page_id = ".$row['parent_category_id']);

					// $parentArray = [];
					$ratingArray = [];
					if($rating && $rating->rowCount()) $ratingArray = $rating->fetch(PDO::FETCH_ASSOC);
					// if($parent_category && $parent_category->rowCount()) $parentArray = $parent_category->fetch(PDO::FETCH_ASSOC);

					// $row = array_merge($row, $parentArray);
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
		$q = $pdo->query("	SELECT * FROM article_images 
							WHERE article_images.article_id = $id
							ORDER BY article_images.article_main_img DESC");
		
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



	// public function getContributors($args = [], $attempts = 0){
	// 	$options = array_merge([
	// 		'pageId' => null,
	// 		'count' => 1,
	// 		'sortType' => 1, //1 == Most Recent, 2 == Most Popular, 3 == Most Visited, 4 == A-Z, 5 == Z-A
	// 		'featured' => false,
	// 		'omit' => [],
	// 		'contributorId' => null,
	// 		'contributorSEOName' => ''
	// 	], $args);
	// 	$innerJoinTables = [];
	// 	$innerJoinRelations = [];			
	// 	$leftJoinTables = [];//'article_videos', 'syndication_videos'];
	// 	$leftJoinRelations = [];//'articles.article_id = article_videos.article_id', 'article_videos.syn_video_id = syndication_videos.syn_video_id'];
	// 	$whereClause = '';
	// 	switch(true){
	// 		case($options['featured']):
	// 			if(!is_null($options['pageId'])){
	// 				$innerJoinTables[] = 'article_category_page_featured_contributors';
	// 				$innerJoinRelations[] = 'article_contributors.contributor_id = article_category_page_featured_contributors.contributor_id';
	// 				$whereClause = ' WHERE article_category_page_featured_contributors.category_page_id = :pageId';
	// 				$orderClause = " ORDER BY article_category_page_featured_contributors.featured_id DESC, article_contributors.contributor_id DESC";
	// 			}else{
	// 				$innerJoinTables[] = 'article_page_featured_contributors';
	// 				$innerJoinRelations[] = 'article_contributors.contributor_id = article_page_featured_contributors.contributor_id';
	// 				$whereClause = ' WHERE article_page_featured_contributors.article_page_id = :pageId';
	// 				$orderClause = " ORDER BY article_page_featured_contributors.featured_id DESC, article_contributors.contributor_id DESC";
	// 			}
	// 			$whereClause .= "";
	// 			$queryParams = [':pageId' => filter_var((is_null($options['pageId'])) ? $this->config['articlepageid'] : $options['pageId'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)];
	// 			$articlesType = 'featured';
	// 			break;
	// 		case(!is_null($options['contributorId']) || strlen($options['contributorSEOName'])):
	// 			$whereClause = ' WHERE (article_contributors.contributor_id = :contributorId OR article_contributors.contributor_seo_name = :contributorSEOName)';
	// 			$queryParams = [
	// 				':contributorId' => filter_var($options['contributorId'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
	// 				':contributorSEOName' => filter_var($options['contributorSEOName'], FILTER_SANITIZE_STRING, PDO::PARAM_STR)
	// 			];
	// 			$orderClause = " ORDER BY article_contributors.creation_date DESC, article_contributors.contributor_id DESC";
	// 			$articlesType = 'single';
	// 			break;
	// 		default:
	// 			$innerJoinTables[] = 'article_contributor_articles';
	// 			$innerJoinTables[] = 'articles';
	// 			$innerJoinTables[] = 'article_categories';
	// 			$innerJoinTables[] = 'article_category_pages';
	// 			$innerJoinTables[] = 'article_page_categories';
	// 			$innerJoinTables[] = 'article_pages';
	// 			$innerJoinRelations[] = 'article_contributors.contributor_id = article_contributor_articles.contributor_id';
	// 			$innerJoinRelations[] = 'article_contributor_articles.article_id = articles.article_id';
	// 			$innerJoinRelations[] = 'articles.article_id = article_categories.article_id';
	// 			$innerJoinRelations[] = 'article_categories.category_page_id = article_category_pages.category_page_id';
	// 			$innerJoinRelations[] = 'article_category_pages.category_page_id = article_page_categories.category_page_id';
	// 			$innerJoinRelations[] = 'article_page_categories.article_page_id = article_pages.article_page_id';
	// 			$whereClause = " WHERE article_contributors.contributor_bio IS NOT NULL AND article_pages.article_page_id = :pageId";
	// 			$queryParams = [':pageId' => filter_var($this->config['articlepageid'], FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)];
	// 			$orderClause = [
	// 				" ORDER BY article_contributors.creation_date DESC, article_contributors.contributor_id DESC",//Most Recent
	// 				" ORDER BY article_contributors.creation_date DESC, article_contributors.contributor_id DESC",//Most Popular
	// 				" ORDER BY article_contributors.creation_date DESC, article_contributors.contributor_id DESC",//Most Visited
	// 				" ORDER BY article_contributors.contributor_name ASC, article_contributors.contributor_id DESC",//Alpha A-Z
	// 				" ORDER BY article_contributors.contributor_name DESC, article_contributors.contributor_id DESC"//Alpha Z-A
	// 			];
	// 			$articlesType = 'all';
	// 			break;
	// 	}
	// 	$s = "SELECT *, article_contributors.contributor_id FROM article_contributors INNER JOIN (:joinedTables) ON (:joinRelations)";
	// 	$i = 0;
	// 	$t = '';
	// 	foreach($innerJoinRelations as $relationShip){
	// 		$t .= $relationShip;
	// 		if($i++ < count($innerJoinRelations) - 1) $t .= " AND ";
	// 	}
	// 	$s = str_replace(':joinedTables', implode(', ', $innerJoinTables), $s);
	// 	$s = str_replace(':joinRelations', $t, $s);
	// 	if(count($leftJoinTables) && count($leftJoinRelations)){
	// 		$s .= " LEFT JOIN (:joinedTables) ON (:joinRelations)";
	// 		$i = 0;
	// 		$t = '';
	// 		foreach($leftJoinRelations as $relationShip){
	// 			$t .= $relationShip;
	// 			if($i++ < count($leftJoinRelations) - 1) $t .= " AND ";
	// 		}
	// 		$s = str_replace(':joinedTables', implode(', ', $leftJoinTables), $s);
	// 		$s = str_replace(':joinRelations', $t, $s);
	// 	}
	// 	if(count($options['omit'])){
	// 		$i = 0;
	// 		$c = count($options['omit']);
	// 		$whereClause .= " AND article_contributors.contributor_id NOT IN (";
	// 		foreach($options['omit'] as $articleId){
	// 			$whereClause .= $articleId;
	// 			if($i++ < count($options['omit']) - 1) $whereClause .= ", ";
	// 		}
	// 		$whereClause .= ")";
	// 	}
	// 	$s .= $whereClause;
	// 	$s .= is_array($orderClause) ? isset($orderClause[$options['sortType'] - 1]) ? $orderClause[$options['sortType'] - 1] : $orderClause[0] : $orderClause;
	// 	if($options['count'] !== -1) $s .= " LIMIT 0, ".$options['count'];
	// 	$pdo = $this->con->openCon();
	// 	$q = $pdo->prepare($s);
		
	// 	$q->execute($queryParams);
	// 	if($q){
	// 		$q->setFetchMode(PDO::FETCH_ASSOC);
	// 		$r = ['ids' => [], 'contributors' => [], 'articles' => []];
	// 		while($row = $q->fetch()){
	// 			if(!in_array($row['contributor_id'], $r['ids'])){
	// 				$rating = $pdo->query("SELECT avg(article_ratings.rating) AS rating FROM article_contributor_articles INNER JOIN(articles, article_ratings) ON (article_contributor_articles.article_id = articles.article_id AND articles.article_id = article_ratings.article_id) WHERE article_contributor_articles.contributor_id = ".$row['contributor_id']);
	// 				$ratingArray = [];
	// 				if($rating && $rating->rowCount()) $ratingArray = $rating->fetch(PDO::FETCH_ASSOC);
	// 				$r['ids'][] =$row['contributor_id'];
	// 				$r['contributors'][] = array_merge($row, $ratingArray);
	// 				switch($articlesType){
	// 					case 'featured':
	// 						$r['articles'] = $this->getArticles(['count' => 3, 'contributorId' =>$row['contributor_id']]);
	// 						break;
	// 					case 'single':
	// 						$r['articles'] = $this->getArticles(['count' => -1, 'sortType' => $options['sortType'], 'contributorId' =>$row['contributor_id']]);
	// 						break;
	// 					default:
	// 						$r['articles'] = false;
	// 						break;
	// 				}
	// 			}
	// 		}
	// 		if($options['sortType'] == 2){
	// 			$r['contributors'] = $this->subValSort($r['contributors']);
	// 			$r['ids'] = [];
	// 			foreach($r['contributors'] as $contributor){
	// 				$r['ids'][] = $contributor['contributor_id'];	
	// 			}
	// 		}
	// 		if(count($r['contributors']) < $options['count'] && $attempts < 3 && $options['featured']){
	// 			$options['count'] = $options['count'] - count($r['contributors']);
	// 			$options['pageId'] = null;
	// 			$recursive = $this->getContributors($options, ++$attempts);
	// 			if(is_array($recursive)){
	// 				$r['contributors'] = array_merge($r['contributors'], $recursive['contributors']);
	// 				$r['articles'] = array_merge($r['articles'], $recursive['articles']);
	// 				$r['ids'] = array_merge($r['ids'], $recursive['ids']);
	// 			}
	// 		}
	// 		$this->con->closeCon();
	// 	}else $r = false;
	// 	return $r;
	// }



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

	public function getTodaysFavorites(){
		$queryString = "SELECT * FROM article_todays_favorites ";
		$queryString .= "INNER JOIN (articles, article_images) ";
		$queryString .= "ON articles.article_id = article_todays_favorites.article_id ";
		$queryString .= "AND articles.article_id = article_images.article_id ";

		$queryString .= "LEFT JOIN (article_categories, article_category_pages) ";
		$queryString .= "ON articles.article_id=article_categories.article_id ";
		$queryString .= "AND article_categories.category_page_id=article_category_pages.category_page_id ";

		$queryString .= "LEFT JOIN article_page_main_categories ";
		$queryString .= "ON article_page_main_categories.child_category_id=article_category_pages.category_page_id ";

		$queryString .= "GROUP BY slot ";
		$queryString .= "ORDER BY slot ASC ";
		$queryString .= "LIMIT 3 ";

		$q = $this->performQuery(['queryString' => $queryString]);
		return $q;
	}

	public function getAllBodyTags(){
		$queryString = "SELECT articles.article_id, articles.article_body ";
		$queryString .="FROM articles ";

		$queryString .= "LEFT JOIN (article_categories, article_category_pages) ";
		$queryString .= "ON articles.article_id=article_categories.article_id ";
		$queryString .= "AND article_categories.category_page_id=article_category_pages.category_page_id ";

		$queryString .= "WHERE article_category_pages.category_page_id < 19 ";
		$queryString .= "GROUP BY article_categories.article_id ";

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
//	Echo to see query string, for testing and debugging (comment out the performQuery call below to test)
//		echo htmlspecialchars($qString);
		$q = $this->performQuery(['queryString' => $qString]);
		if ($q){
			return true;
		}

	}


	private function parseStringCommasIntoArray($dataset){
		foreach ($dataset as $row) {
			$id = $row['article_id'];
			// $deleteSql = "DELETE FROM article_categories_from_csv ";
			// $deleteSql .= "WHERE article_id = {$id};";

			$categoryArray = explode(',', $row['category_id']);
			// var_dump($categoryArray);
			$sql = "";
			for ($i=0; $i<count($categoryArray); $i++){
				// echo" <br />".$i.count($categoryArray)."<br />";
					$sql .= "INSERT INTO article_categories_from_csv_migrated VALUES ({$id}, {$categoryArray[$i]});";
			}
			// echo($deleteSql);
			// echo "<br />";
			// $qDelete = $this->performQuery(['queryString' => $deleteSql]);
			// if ($qDelete){
			// 	return true;
			// }

			// echo($sql);			
			// echo "<br />";
			$qInsert = $this->performQuery(['queryString' => $sql]);
			if ($qInsert){
				return true;
			}

		}
	}

	public function extractIdAndCommaSeparatedCategories(){
		$qString = "SELECT * FROM article_categories_from_csv";
//	Echo to see query string, for testing and debugging (comment out the performQuery call below to test)
//		echo htmlspecialchars($qString);
		$q = $this->performQuery(['queryString' => $qString]);
		if ($q){
			$parsedSet = $this->parseStringCommasIntoArray($q);
			//return $parsedSet;
		}
	}

	public function getFeatured($featureType = 2, $limit = 1){
			$queryString = 'SELECT article.*, ';
				$queryString .= 'parent.cat_id as parent_id, parent.cat_name as parent_name, parent.cat_dir_name as parent_dir_name ';

				$queryString .= 'FROM nested_category AS cat, nested_category AS parent ';

				$queryString .= 'INNER JOIN ( ';
					$queryString .= 'SELECT articles.*, ';
					$queryString .= 'i.article_post_img, i.article_preview_img, nc.cat_id, nc.cat_name, nc.cat_dir_name, nc.lft, nc.rgt, featured.article_id as featured_id, featured.feature_type as feature_type ';
					$queryString .= 'FROM articles ';

					$queryString .= 'INNER JOIN (article_images as i, article_categories, nested_category as nc, articles_featured as featured) ';
					$queryString .= 'ON articles.article_id = i.article_id ';
					$queryString .= 'AND articles.article_id = article_categories.article_id ';
					$queryString .= 'AND article_categories.cat_id = nc.cat_id ';
					$queryString .= 'AND articles.article_id = featured.article_id ';
					$queryString .= 'WHERE featured.feature_type = '.$featureType["featureType"];
					$queryString .= ') as article ';

				$queryString .= 'WHERE cat.lft BETWEEN parent.lft ';
				$queryString .= 'AND parent.rgt ';
				$queryString .= 'AND cat.cat_id = article.cat_id  ';
				$queryString .= 'AND parent.lft > 1 ';

				$queryString .= 'ORDER BY article.article_id DESC ';
				$queryString .= 'LIMIT '.$limit ;

		$q = $this->performQuery(['queryString' => $queryString]);
		return $q;
	}

	protected function performQuery($opts){
		$options = array_merge(array(
			'queryString' => '',
			'queryParams' => array(),
			'returnRowAsSingleArray' => true,
			'bypassCache' => false
		), $opts);
		//$cachedData = $this->memcache->getData($options['queryString']);
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
			//if($r !== false) $storedData = $this->memcache->setData($options['queryString'], $r);
			$this->con->closeCon();
			return $r;
		}else return $cachedData;
	}
















}
?>