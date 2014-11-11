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
	private function verifyArticleidonSocial( $articleId, $month, $cat ){
			$s="SELECT article_id FROM social_media_records WHERE article_id = $articleId AND category = '".$cat."' AND month = $month";

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
	public function updateSocialMediaShares( $counts, $articleId, $month, $cat ){
	//var_dump($counts);
			if( $articleId ){

				$current_date = date('Y-m-d H:i:s', time());

				if(!isset($counts)) return false;
				
				$prevData = $this->get_dashboardArticlesPrevMonth( $articleId , $month - 1, $cat );
				$idExist = $this->verifyArticleidonSocial( $articleId , $month, $cat );

				$facebook_shares = abs($counts['Facebook']['share_count'] - $prevData['facebook_shares']);
				$twitter_shares = abs($counts['Twitter'] - $prevData['twitter_shares']);
				$pinterest_shares = abs($counts['Pinterest'] - $prevData['pinterest_shares']);
				$google_shares = abs($counts['GooglePlusOne'] - $prevData['google_shares']);
				$delicious_shares = abs($counts['Delicious'] - $prevData['delicious_shares']);
				$stumbleupon_shares = abs($counts['StumbleUpon'] - $prevData['stumbleupon_shares']);
				$linkedin_shares = abs($counts['LinkedIn'] - $prevData['linkedin_shares']);
				$year = date('Y');

				if($idExist){

					$s = " UPDATE social_media_records 
					  	   SET facebook_shares = $facebook_shares, twitter_shares = $twitter_shares, 
					           pinterest_shares = $pinterest_shares, google_shares = $google_shares, 
					           delicious_shares = $delicious_shares, stumbleupon_shares = $stumbleupon_shares,
					           linkedin_shares = $linkedin_shares, date_updated = '".$current_date."'  
					        WHERE article_id = $articleId AND category = '".$cat."' AND month = '".$month."' ";
				}else{
					$s = " INSERT INTO social_media_records
						   (`id`, `article_id`, `category`, `facebook_shares`, `twitter_shares`, `pinterest_shares`, `google_shares`,
						    `linkedin_shares`, `delicious_shares`, `stumbleupon_shares`, `month`, `year`, `date_updated`) 
						   VALUES (NULL, $articleId, '".$cat."', $facebook_shares, $twitter_shares, $pinterest_shares, $google_shares, 
						   	$linkedin_shares, $delicious_shares, $stumbleupon_shares, $month, $year, now()) ";
					
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
		a.article_type, a.creation_date,  article_rates.rate_by_article, article_rates.rate_by_share, 
		facebook_shares, twitter_shares, pinterest_shares, google_shares, linkedin_shares, delicious_shares, 
		stumbleupon_shares, month, year, date_updated, category
		FROM articles as a
		INNER JOIN ( article_contributors, article_contributor_articles, 
				article_rates, social_media_records ) 
		ON a.article_id = article_contributor_articles.article_id 
		AND article_contributors.contributor_id = article_contributor_articles.contributor_id
		AND a.article_type = article_rates.rate_id
		AND a.article_id = social_media_records.article_id ";

		$s .= $status_sql;
		if ($userArticlesFilter != 'all'){
			$s .=	"AND article_contributors.contributor_email_address = :userArticlesFilter ";
		}
		//$s .= " GROUP BY a.article_id ";
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
	public function get_dashboardArticlesPrevMonth( $article_id, $month, $cat ){
		
		$s = "SELECT * FROM social_media_records where article_id = $article_id AND category = '".$cat."' AND month = $month";

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

	public function socialMediaSharesReport($data){

		$month = filter_var($data['month'], FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$year = filter_var($data['year'], FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$contributor_id = $data['contributor'];


		$s = "
			SELECT
			      article_contributor_articles.contributor_id, 
			      article_contributors.contributor_name, 
			      article_contributors.contributor_seo_name, 
			      SUM(social_media_info.rate) as 'total_rate',
			      SUM(social_media_info.total_shares) as 'total_shares', 
			      '0.04' as 'share_rate',
			      (SUM(social_media_info.total_shares)*0.04) as 'share_revenue',
			      ((SUM(social_media_info.total_shares)*0.04) + SUM(social_media_info.rate)) as 'total_to_pay'
			      
			FROM  article_contributor_articles 

			INNER JOIN ( article_contributors ) ON ( article_contributor_articles.contributor_id = article_contributors.contributor_id )
			INNER JOIN ( 

				SELECT 
				social_media_records.article_id, social_media_records.category,  
				social_media_records.month,  social_media_records.year,  
				(SUM(facebook_shares) + SUM(twitter_shares) + SUM(pinterest_shares) + SUM(google_shares) +  SUM(linkedin_shares)  +  SUM(delicious_shares) + SUM(stumbleupon_shares))  as 'total_shares', IF( DATE_FORMAT(articles.creation_date, '%m') !=  social_media_records.month, 0, article_rates.rate_by_article) as 'rate'
				            
				FROM social_media_records 

				INNER JOIN ( articles, article_rates) 
				ON (articles.article_id = social_media_records.article_id) 
				AND ( articles.article_type = article_rates.rate_id)

				WHERE social_media_records.month = '".$month."' and year = '".$year." '

				GROUP BY social_media_records.article_id ) as social_media_info  

			ON( article_contributor_articles.article_id = social_media_info.article_id ) ";

			if(isset($contributor_id) && $contributor_id != 0) {
				$s .= "	WHERE article_contributor_articles.contributor_id = '".$contributor_id."' ";
			}

			$s .=" GROUP BY article_contributor_articles.contributor_id 
				   ORDER BY total_to_pay DESC ";

		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);

		//var_dump($month, $year, $contributor_id, $s, $q);
		if ($q && isset($q[0])){
			return $q;
		} else if ($q && !isset($q[0])){
			$q = array($q);
			return $q;
		}else return false;

	}

	public function getSocialSharesAndContributors(){
		$s=" SELECT social_media_records.*, article_contributors.contributor_id, article_contributors.contributor_name, article_contributors.contributor_seo_name FROM social_media_records 
			 INNER JOIN ( article_contributors, article_contributor_articles) 
			 ON ( article_contributor_articles.article_id = social_media_records.article_id) 
			 AND ( article_contributors.contributor_id = article_contributor_articles.contributor_id ) ";
	}

}
?>