<?php
require_once dirname(__FILE__).'/Connector.php';

class Dashboard{
	protected $config;
	protected $con;


	public function __construct($c){
		$this->config = $c;
		$this->con = new Connector($this->config);
	}

	//Execute Query
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
					//	Return a count of the rows returned by the query
				return $q->rowCount();
			}

			return $r;
		}else return $cachedData;
	}

	//Verify if an article exist on the DB then decide if Update or Insert a new record on the social_media_records table
	private function verifyArticleidonSocial( $articleId, $month ){
			$s="SELECT article_id FROM social_media_records WHERE article_id = $articleId AND month = $month";

			$queryParams = [':articleID' => filter_var($articleId, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
							':month' => filter_var($month, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT) ];

			$pdo = $this->con->openCon();
			
			$q = $pdo->prepare($s);

			$row = $q->execute($queryParams);


			if($q && $q->rowCount()){
				$q->setFetchMode(PDO::FETCH_ASSOC); 
				$row = $q->fetch();
				$q->closeCursor();
			}else $row = false;

			$this->con->closeCon();

			return $row;

	}

	/* INSERT OR UPDATE RECORDS TO THE SOCIAL MEDIA TABLE */
	public function updateSocialMediaShares( $counts, $articleId, $month ){
	
			if( $articleId ){
				$current_date = date('Y-m-d H:i:s', time());

				if(!isset($counts)) return false;
				$prevData = $this->get_dashboardArticlesPrevMonth( $articleId , $month - 1 );
				$idExist = $this->verifyArticleidonSocial( $articleId , $month );
			var_dump($prevData);
				$facebook_shares = $counts['Facebook']['share_count'] - $prevData['facebook_shares'];
				$twitter_shares = $counts['Twitter'] - $prevData['twitter_shares'];
				$pinterest_shares = $counts['Pinterest'] - $prevData['pinterest_shares'];
				$google_shares = $counts['GooglePlusOne'] - $prevData['google_shares'];
				$delicious_shares = $counts['Delicious'] - $prevData['delicious_shares'];
				$stumbleupon_shares = $counts['StumbleUpon'] - $prevData['stumbleupon_shares'];
				$linkedin_shares = $counts['LinkedIn'] - $prevData['linkedin_shares'];
				$year = date('Y');
		var_dump($counts['Facebook']['share_count'],$prevData['facebook_shares'], $facebook_shares ); die;
				if($idExist){
					$s = " UPDATE articles 
					  	   SET facebook_shares = $facebook_shares, twitter_shares = $twitter_shares, 
					           pinterest_shares = $pinterest_shares, google_shares = $google_shares, 
					           delicious_shares = $delicious_shares, stumbleupon_shares = $stumbleupon_shares,
					           linkedin_shares = $linkedin_shares 
					        WHERE article_id = $articleId AND month = $month";
				}else{
					$s = " INSERT INTO social_media_records
						   (`id`, `article_id`, `facebook_shares`, `twitter_shares`, `pinterest_shares`, `google_shares`,
						    `linkedin_shares`, `delicious_shares`, `stumbleupon_shares`, `month`, `year`) 
						   VALUES (NULL, $articleId, $facebook_shares, $twitter_shares, $pinterest_shares, $google_shares, $linkedin_shares, $delicious_shares, $stumbleupon_shares, $month, $year) ";
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
					':month' => filter_var($month, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
					':year' => filter_var($year, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)
				];

				$pdo = $this->con->openCon();
				$q = $pdo->prepare($s);

				$row = $q->execute($queryParams);

				return $row; 
			}else{
				return false;
		}
	}

	//Return All Articles per month for each contributor
	public function get_dashboardArticles( $limit = 10, $order = '', $articleStatus = '1, 2, 3', $userArticlesFilter, $offset, $month ) {

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

	// Get  Preview Month Article Social Media Information
	public function get_dashboardArticlesPrevMonth( $article_id, $month ){
		
		$s = "SELECT * FROM social_media_records where article_id = $article_id AND month = $month";

		$pdo = $this->con->openCon();
		
		$q = $pdo->query($s);
		

		if($q && $q->rowCount()){
			$q->setFetchMode(PDO::FETCH_ASSOC); 
			$row = $q->fetch();
			$q->closeCursor();
		}else $row = false;

		$this->con->closeCon();

		return $row; 

	}

}
?>