<?php 
/***


***/

class Search {
	
	public $totalResults;
	public $value;
	
	public function __construct( $c ){
		$this->config = $c;
		$this->con = new Connector( $this->config );
	}
	
	public function getArticles( $value ){
		$this->value = $value;
		$pdo = $this->con->openCon();

		$queryString = "SELECT articles.article_title, articles.creation_date, articles.article_seo_title, articles.article_id, contributor_name, 
						contributor_seo_name, article_contributors.contributor_id, categories.cat_id, cat_dir_name, cat_name
						FROM articles 
						INNER JOIN ( article_categories, categories, article_contributor_articles, article_contributors ) 
						ON (articles.article_id =  article_categories.article_id 
							AND article_categories.cat_id = categories.cat_id 
							AND article_contributor_articles.article_id = articles.article_id 
							AND article_contributors.contributor_id = article_contributor_articles.contributor_id) 
						WHERE articles.article_status = 1 AND ( articles.article_title LIKE '%".$value."%' OR articles.article_tags LIKE '%".$value."%' ) 
						GROUP BY articles.article_id ORDER BY articles.creation_date DESC";

		$q = $pdo->query( $queryString );
		$q->setFetchMode(PDO::FETCH_ASSOC);

		$r = null;
		while($row = $q->fetch()) {
		
			if($row['article_id']){
				$rating = $pdo->query("SELECT avg(article_ratings.rating) AS rating, count(article_ratings.rating) AS reviews FROM article_ratings INNER JOIN (articles) ON (articles.article_id = article_ratings.article_id) WHERE articles.article_id = ".$row['article_id']);
				$ratingArray = [];
				if($rating && $rating->rowCount()) $ratingArray = $rating->fetch(PDO::FETCH_ASSOC);

				$r['articles'][] = array_merge($row, $ratingArray);
			}
		}

		$this->con->closeCon();
	
		if( isset($r) && $r ) $this->totalResults = count( $r['articles'] );
		else $this->totalResults = 0;
		
		return $r;	
	}

	public function count_article_filtered($order, $articleStatus = '1, 2, 3', $userArticlesFilter, $title ) {

		$pdo = $this->con->openCon();
		
		$queryString = "SELECT count( DISTINCT articles.article_id) as simpledish_article_count 
				FROM articles WHERE article_status IN (".$articleStatus.") AND  article_title LIKE '%".$title."%'";
	
		if ($userArticlesFilter != 'all'){
			$queryString .=	" AND article_contributors.contributor_email_address =  '".$userArticlesFilter."'' ";
		}

		$q = $pdo->query( $queryString );

		if($q){
			$q->setFetchMode(PDO::FETCH_ASSOC);

			if( $row = $q->fetch() ){
				return array_shift($row);
			}
		}
		$this->con->closeCon();
	}

	public  function get_article_filtered( $limit = 10, $order = '', $articleStatus = '1, 2, 3', $userArticlesFilter, $offset, $title ) {
		$title = filter_var($title, FILTER_SANITIZE_STRING, PDO::PARAM_STR);

		$pdo = $this->con->openCon();

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

		$status_sql = " WHERE article_status IN (".$articleStatus.") AND  article_title LIKE '%".$title."%'";
		$limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$s = "SELECT a.article_id, a.article_title, a.article_seo_title, a.article_desc, a.article_body, 
					nc.cat_id, article_contributors.contributor_name, article_contributors.contributor_seo_name, a.creation_date, a.article_status

				FROM articles as a

				LEFT JOIN (article_categories as a_c, categories as nc, article_contributors, article_contributor_articles)
				ON a_c.article_id = a.article_id
				AND a_c.cat_id = nc.cat_id
				AND a.article_id = article_contributor_articles.article_id
				AND article_contributors.contributor_id = article_contributor_articles.contributor_id ";
		$s .= $status_sql;
		if ($userArticlesFilter != 'all'){
			$s .=	"AND article_contributors.contributor_email_address = '".filter_var($userArticlesFilter, FILTER_SANITIZE_STRING, PDO::PARAM_STR)."'";
		}
		$s .= " GROUP BY a.article_id ";
		$s .= $order_sql;
		$s .= 	"LIMIT {$limit} 
				OFFSET {$offset}";	

		$q = $pdo->query( $s );

		if($q){
			$q->setFetchMode(PDO::FETCH_ASSOC);

			$r = null;
			while($row = $q->fetch()) {
				$r['articles'][] = $row;
			}
		}
			
		$this->con->closeCon();
		
		return $r;
	}	
}


?>