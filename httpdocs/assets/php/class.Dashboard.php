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
	private function verifyArticleidonSocial( $articleId, $month, $cat, $year ){
			$s="SELECT article_id FROM social_media_records WHERE article_id = $articleId AND category = '".$cat."' AND month = $month AND year = $year ";

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
// This table has not been updated since 206-04-28  and pu on hold -- GB 2017-02-15

	public function updateSocialMediaShares( $counts, $articleId, $month, $cat ){
	
			if( $articleId ){

				$current_date = date('Y-m-d H:i:s', time());
				$year = date('Y');

				if(!isset($counts)) return false;
				
				$prev_month = $month-1;
				$prev_year = $year;
				if($month == 1 ){
					$prev_month = 12;
					$prev_year = $year -1;
				} 

				$prevData = $this->get_dashboardArticlesPrevMonth( $articleId , $prev_month, $cat, $prev_year );
				$idExist = $this->verifyArticleidonSocial( $articleId , $month, $cat, $year );

				/*Original DATA from SharedCount*/
				$facebook_shares_org =$counts['Facebook']['share_count'];
				$facebook_likes_org = $counts['Facebook']['like_count'];
				$facebook_comments_org = $counts['Facebook']['comment_count'];
				$twitter_shares_org = $counts['Twitter'];
				$pinterest_shares_org = $counts['Pinterest'] ;
				$google_shares_org = $counts['GooglePlusOne'];
				$delicious_shares_org = $counts['Delicious'];
				$stumbleupon_shares_org = $counts['StumbleUpon'];
				$linkedin_shares_org = $counts['LinkedIn'];

				$facebook_shares =$counts['Facebook']['share_count'];
				$facebook_likes = $counts['Facebook']['like_count'];
				$facebook_comments = $counts['Facebook']['comment_count'];
				$twitter_shares = $counts['Twitter'];
				$pinterest_shares = $counts['Pinterest'] ;
				$google_shares = $counts['GooglePlusOne'];
				$delicious_shares = $counts['Delicious'];
				$stumbleupon_shares = $counts['StumbleUpon'];
				$linkedin_shares = $counts['LinkedIn'];
				//var_dump($facebook_comments_org );
				if($prevData){

					foreach($prevData as $prev ){
						$facebook_shares = abs($facebook_shares - $prev['facebook_shares_org']);
						$facebook_likes = abs($facebook_likes - $prev['facebook_likes_org']);
						$facebook_comments = abs($facebook_comments - $prev['facebook_comments_org']);
						$twitter_shares = abs($twitter_shares - $prev['twitter_shares_org']);
						$pinterest_shares = abs($pinterest_shares - $prev['pinterest_shares_org']);
						$google_shares = abs($google_shares - $prev['google_shares_org']);
						$delicious_shares = abs($delicious_shares - $prev['delicious_shares_org']);
						$stumbleupon_shares = abs($stumbleupon_shares - $prev['stumbleupon_shares_org']);
						$linkedin_shares = abs($linkedin_shares - $prev['linkedin_shares_org']);
					}
				
				}
				
				$year = date('Y');

				if($idExist){

					$s = " UPDATE social_media_records 
					  	   SET facebook_shares = $facebook_shares, 
					  	   	   facebook_likes = $facebook_likes, 
					  	   	   facebook_comments = $facebook_comments, 
					  	   	   twitter_shares = $twitter_shares, 
					           pinterest_shares = $pinterest_shares,
					           google_shares = $google_shares, 
					           delicious_shares = $delicious_shares,
					           stumbleupon_shares = $stumbleupon_shares,
					           facebook_shares_org = $facebook_shares_org, 
					  	   	   facebook_likes_org = $facebook_likes_org, 
					  	   	   facebook_comments_org = $facebook_comments_org, 
					  	   	   twitter_shares_org = $twitter_shares_org, 
					           pinterest_shares_org = $pinterest_shares_org,
					           google_shares_org = $google_shares_org, 
					           delicious_shares_org = $delicious_shares_org,
					           stumbleupon_shares_org = $stumbleupon_shares_org,
					           linkedin_shares_org = $linkedin_shares_org, 
					           date_updated = '".$current_date."'  
					        WHERE article_id = $articleId AND category = '".$cat."' AND month = '".$month."' AND year = '".$year."' ";
				}else{
					$s = " INSERT INTO social_media_records
						   (`id`, `article_id`, `category`, `facebook_shares`, `facebook_likes`, `facebook_comments`, `twitter_shares`, `pinterest_shares`, `google_shares`,
						    `linkedin_shares`, `delicious_shares`, `stumbleupon_shares`, `facebook_shares_org`, `facebook_likes_org`, `facebook_comments_org`, `twitter_shares_org`, 
						    `pinterest_shares_org`, `google_shares_org`, `delicious_shares_org`, `stumbleupon_shares_org`, `linkedin_shares_org`,  `month`, `year`, `date_updated`) 
						   VALUES (NULL, $articleId, '".$cat."', $facebook_shares, $facebook_likes, $facebook_comments, $twitter_shares, $pinterest_shares, $google_shares, 
						   	$linkedin_shares, $delicious_shares, $stumbleupon_shares, $facebook_shares_org, $facebook_likes_org, $facebook_comments_org, $twitter_shares_org, $pinterest_shares_org, $google_shares_org, 
						   	$delicious_shares_org, $stumbleupon_shares_org, $linkedin_shares_org,  $month, $year, now()) ";
					
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

				$this->con->closeCon();

				return $row; 
			}else{
				return false;
		}
	}

	public function get_current_rate( $month = 0, $user_type = 0, $year = 0 ){
		if($month == 0 ) $month = date('n');
		if($year == 0 ) $year =  date('Y');

		//$year = date('Y');
		$s=" SELECT * FROM user_rate WHERE month = $month AND year = $year ";
		if( $user_type != 8  && $user_type != 9  && $user_type != 6 && $user_type != 7  && $user_type != 30 ){ $user_type = 0; }
			$s .= " AND user_type =  ".$user_type;
		
		$s .= " LIMIT 1 ";

		$queryParams = [];			
		$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);
		
		if($q) return $q;
		else return false;
	}

	public function get_monthly_rate( $month, $year ){
		$s=" SELECT * FROM shares_rate WHERE month = $month AND year = $year LIMIT 1";
		$queryParams = [];			
		$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);
		
		if($q) return $q['rate'];
		else return false;
	}

	public function get_articlesbypageviews( $contributor_id, $month, $year ){

		//$month = 2;
		$s = "SELECT * FROM  google_analytics_data 
				INNER JOIN ( article_contributor_articles, articles, article_categories, categories ) 
				ON ( article_contributor_articles.article_id = google_analytics_data.article_id )
				AND ( articles.article_id = google_analytics_data.article_id )
				AND ( article_categories.article_id = google_analytics_data.article_id )
				AND (categories.cat_id = article_categories.cat_id )
				WHERE google_analytics_data.month = ".$month." AND  google_analytics_data.year = ".$year;

			if( isset($contributor_id) && $contributor_id != 0){
				$s.= " AND article_contributor_articles.contributor_id = ".$contributor_id;
			}
		$queryParams = [];			
		$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);
		//var_dump($q);
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

	

	public function get_articlesbypageviews_daily( $start_date, $end_date ){

		$s = "SELECT article_id, sum(usa_pageviews) as usa_pageviews, month, year, updated_date FROM  google_analytics_data_daily
			  WHERE  google_analytics_data_daily.updated_date between '".$start_date."' AND  '".$end_date." ' 
			  GROUP BY article_id ORDER BY google_analytics_data_daily.usa_pageviews DESC";

		$queryParams = [];			
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

	public function get_articlesbypageviews_new( $contributor_id, $month, $year ){
			$s = " SELECT google_analytics_data_daily.*, articles.article_title, articles.article_seo_title, categories.cat_id, categories.cat_name, article_contributor_articles.contributor_id  
				  	FROM  google_analytics_data_daily 
					INNER JOIN ( article_contributor_articles, articles, article_categories, categories ) 
					ON ( article_contributor_articles.article_id = google_analytics_data_daily.article_id )
					AND ( articles.article_id = google_analytics_data_daily.article_id )
					AND ( article_categories.article_id = google_analytics_data_daily.article_id )
					AND (categories.cat_id = article_categories.cat_id )
					WHERE google_analytics_data_daily.month = ".$month." AND  google_analytics_data_daily.year = ".$year;

			if( isset($contributor_id) && $contributor_id != 0){
				$s.= " AND article_contributor_articles.contributor_id = ".$contributor_id;
			}
			$s.= " ORDER BY google_analytics_data_daily.usa_pageviews DESC ";
		$queryParams = [];			
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

	public function get_articlesbypageviews_new_2( $contributor_id, $month, $year ){

			$s = " SELECT *, sum(usa_pageviews) as pvs 
					FROM `article_daily_earnings` 
					WHERE month = $month AND year = $year AND contributor_id = $contributor_id GROUP BY month ";

			$queryParams = [];			
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


	//Return All Articles per month for each contributor
	public function get_dashboardArticles( $limit = 10, $order = '', $articleStatus = '1, 2, 3', $userArticlesFilter, $offset, $month, $year) {

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

		$status_sql = " WHERE article_status = 1 AND social_media_records.month = ".$month ." AND social_media_records.year = ".$year ." ";
		$limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);


		$s = "SELECT a.article_id, a.article_title, a.article_seo_title, a.article_desc, a.article_status, 
		a.article_type, a.creation_date,  article_rates.rate_by_article, ";
		//FROM SOCIAL SHARES TABLE
		$s .= " facebook_shares, facebook_likes, facebook_comments, twitter_shares, pinterest_shares, google_shares, linkedin_shares, delicious_shares, 
		stumbleupon_shares, social_media_records.month, social_media_records.year, social_media_records.date_updated, category, ";
		//FROM SHARE RATE TABLE
		$s .="  ( SELECT rate FROM shares_rate WHERE shares_rate.month = ".$month." AND shares_rate.year = ".$year." ) AS rate_by_share, ";
		//FROM GOOGLE ANALYTICS DATA TABLE
		$s .=" ga.pageviews, ga.usa_pageviews, ga.pct_pageviews ";		
		
		$s .=" FROM articles as a
		INNER JOIN ( article_contributors, article_contributor_articles, 
				article_rates, social_media_records ) 
		ON a.article_id = article_contributor_articles.article_id 
		AND article_contributors.contributor_id = article_contributor_articles.contributor_id
		AND a.article_type = article_rates.rate_id
		AND a.article_id = social_media_records.article_id ";

		//LEFT JOIN WITH GOOGLE ANALYTICS DATA
		$s .=" LEFT JOIN (select * from google_analytics_data 
						where google_analytics_data.month = ".$month." and google_analytics_data.year = ".$year.") 
						as ga 
				ON(a.article_id = ga.article_id) ";
		
		$s .= $status_sql;
		if ($userArticlesFilter != 'all'){
			$s .=	"AND article_contributors.contributor_email_address = :userArticlesFilter ";
		}

		$s .= $order_sql;

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

	public function get_dateUpdated( $limit = 10, $order = '', $articleStatus = '1, 2, 3', $userArticlesFilter, $offset, $month, $year) {
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

		$status_sql = " WHERE article_status = 1 AND social_media_records.month = ".$month ." AND social_media_records.year = ".$year ." ";
		$limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$offset = filter_var($offset, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);


		$s = "SELECT social_media_records.date_updated
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
		$s .= " ORDER BY social_media_records.date_updated DESC LIMIT 1 ";
		//$s .= 	"LIMIT {$limit} OFFSET {$offset}";	

		$queryParams = [':userArticlesFilter' => filter_var($userArticlesFilter, FILTER_SANITIZE_STRING, PDO::PARAM_STR)];			
		$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);
		//var_dump($s);
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
	public function get_dashboardArticlesPrevMonth( $article_id, $month, $cat, $year ){
		
		$s = "SELECT * FROM social_media_records where article_id = $article_id AND category = '".$cat."' AND month = $month AND year = $year ";

		$pdo = $this->con->openCon();
		$queryParams = [];
		$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);

		if ($q && isset($q[0])){
			return $q;
		} else if ($q && !isset($q[0])){
			$q = array($q);
			return $q;
		}else return false;

		return $row; 
	}

	

	public function getPageViewsUSReport($data){
		$month = filter_var($data['month'], FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$year = filter_var($data['year'], FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$contributor_id = $data['contributor'];

		$s = "SELECT contributor_earnings.*, article_contributors.contributor_name, 
		     article_contributors.contributor_seo_name, user_billing_info.paypal_email,
		     user_billing_info.w9_live,
		     users.user_type FROM contributor_earnings
		INNER JOIN (article_contributors, users) 
		ON contributor_earnings.contributor_id = article_contributors.contributor_id 
		AND article_contributors.contributor_email_address = users.user_email 
		LEFT JOIN (user_billing_info)
		ON( users.user_id = user_billing_info.user_id)
		WHERE contributor_earnings.month = $month AND contributor_earnings.year = $year AND to_be_pay > 0.00 ";

		if(isset($contributor_id) && $contributor_id != 0) {
		$s .= "AND article_contributors.contributor_id = '".$contributor_id."' ";
		}

		$s .=" ORDER BY to_be_pay DESC ";

		$queryParams = [ ];
		$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);

		if ($q && isset($q[0])){
		return $q;
		} else if ($q && !isset($q[0])){
		$q = array($q);
		return $q;
		}else return false;

	}

	//DEPRECATED
	public function socialMediaSharesReport($data){

		$month = filter_var($data['month'], FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$year = filter_var($data['year'], FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$contributor_id = $data['contributor'];
		$share_rate = $this->get_monthly_rate( $month, $year);
		$s = "
			SELECT
			      article_contributor_articles.contributor_id, 
			      article_contributors.contributor_name, 
			      article_contributors.contributor_seo_name, 
			     
			      users.user_type,
			      SUM(social_media_info.rate) as 'total_rate',
			      SUM(social_media_info.total_shares) as 'total_shares', 
			      $share_rate AS share_rate ,
			      (SUM(social_media_info.US_traffic) * $share_rate ) as 'share_revenue', 
			      SUM(social_media_info.US_traffic) as 'US_Traffic',
			      ((SUM(social_media_info.US_traffic) * $share_rate ) + SUM(social_media_info.rate)) as 'total_to_pay'
			      
			FROM  article_contributor_articles 

			INNER JOIN ( article_contributors, users) 
				ON ( article_contributor_articles.contributor_id = article_contributors.contributor_id )
				AND ( users.user_email = article_contributors.contributor_email_address)
			
			INNER JOIN ( 
				SELECT 
				social_media_records.article_id, social_media_records.category,  
				social_media_records.month,  social_media_records.year,  
				(   SUM(facebook_shares) + ";
					
				if( $month == 1 && $year ==  2015 ){
				$s .= "SUM(facebook_likes) + 
					SUM(facebook_comments) + ";
				}

				$s .= "	SUM(twitter_shares) + 
					SUM(pinterest_shares) + 
					SUM(google_shares) +  
					SUM(linkedin_shares)  +  
					SUM(delicious_shares) + 
					SUM(stumbleupon_shares)
				)  as 'total_shares', 
				IF( DATE_FORMAT(articles.creation_date, '%m') !=  social_media_records.month, 0, article_rates.rate_by_article) as 'rate', ";
				if( $month > 1 && $year >=  2015 ){
					$s .= "( ( SUM(facebook_shares) + SUM(twitter_shares) + SUM(pinterest_shares) + SUM(google_shares) + SUM(linkedin_shares) + SUM(delicious_shares) + SUM(stumbleupon_shares) ) * (ga.pct_pageviews/100)) as US_traffic, 
					ga.pageviews, ga.usa_pageviews, ga.pct_pageviews ";
				}else{
					$s .= "( SUM(facebook_shares) +  SUM(facebook_likes) + 
					SUM(facebook_comments) + SUM(twitter_shares) + SUM(pinterest_shares) + SUM(google_shares) + SUM(linkedin_shares) + SUM(delicious_shares) + SUM(stumbleupon_shares) ) as US_traffic ";
				}        
				$s .= " FROM social_media_records 

				INNER JOIN ( articles, article_rates) 
				ON (articles.article_id = social_media_records.article_id) 
				AND ( articles.article_type = article_rates.rate_id) 
				";

				if( $month > 1 && $year ==  2015 ){
					$s .= "LEFT JOIN (SELECT * FROM google_analytics_data WHERE google_analytics_data.year = ".$year." and google_analytics_data.month = ".$month." ) as ga ON ga.article_id = social_media_records.article_id ";
				}
				$s .= "WHERE social_media_records.month = '".$month."' and social_media_records.year = '".$year."'
				GROUP BY social_media_records.article_id ) as social_media_info  

			ON( article_contributor_articles.article_id = social_media_info.article_id ) 
			";
			//LEFT JOIN ( user_billing_info ) ON (users.user_id = user_billing_info.user_id) 
			if(isset($contributor_id) && $contributor_id != 0) {
				$s .= "	WHERE article_contributor_articles.contributor_id = '".$contributor_id."' ";
			}

			$s .=" GROUP BY article_contributor_articles.contributor_id 
				   ORDER BY share_revenue DESC ";



		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);

		if ($q && isset($q[0])){
			return $q;
		} else if ($q && !isset($q[0])){
			$q = array($q);
			return $q;
		}else return false;
	}

	public function ON_HOLD_UNTIL_TESTING_IS_FINISH_AT_BOTTOM_OF_PAGE_pageviewsReport( $month, $year ){
		$month = filter_var($month, FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$year =  filter_var($year, FILTER_SANITIZE_STRING, PDO::PARAM_STR);
	
		$ddd = new debug("$month $year",0); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	


		$prev_month = $month;
		$prev_year = $year;
		if($prev_month == 1){
			$prev_month = 12;
			$prev_year = $year - 1;
		}else $prev_month = $month - 1;

		//CONTRIBUTOR LIST ACTIVE
		$contributors = $this->getContributorsList(); 

		if($contributors){
			foreach($contributors as $contributor){
				$id = $contributor['contributor_id'];

				$current_month = false;
				$prev_month_data = false;
				
				//CONTRIBUTOR EARNINGS
				$update_data = $this->getContributorEarnings($id, $prev_month.', '.$month, $year);

				
				if( $update_data ){
					if(count($update_data) > 1){
						$current_month = isset($update_data[0]) ? $update_data[0] : false;
						$prev_month_data = isset($update_data[1]) ? $update_data[1] : false;
					}else{
						if($update_data[0]['month'] == $month ){
							$current_month = isset($update_data[0]) ? $update_data[0] : false;
							$prev_month_data = false;
						}else{
							$current_month =  false;
							$prev_month_data = isset($update_data[0]) ? $update_data[0] : false;
						}
					}
					
				}

				//GET PAGEVIEWS TOTAL PER MONTH
				$earnings_info = $this->get_articlesbypageviews_new_2( $id, $month, $year);

				$total_article_rate = 0;
				$total_shares = 0;
				$total_share_rev = 0;
				$total_us_pageviews = 0;
				$total_earnings = 0;
	            $total_to_be_pay = 0;

	            if($earnings_info) $total_us_pageviews = $earnings_info[0]['pvs'];
				$share_rate = $this->get_current_rate($month, $contributor['user_type']);	
			
				if($share_rate) $share_rate  = $share_rate['rate'];

				//Calc Total Earnings
				if( $total_us_pageviews > 0 ){
					$total_earnings = ($total_us_pageviews / 1000 ) * $share_rate;
				}

				$total_to_be_pay = $total_earnings;
				//Verify if the previews Month this contributor was paid, if not you will carry the pending amount to next month.
				if( isset($prev_month_data) && $prev_month_data ){
					if($prev_month_data['paid'] == 0){
						$total_to_be_pay = $total_to_be_pay + $prev_month_data['to_be_pay'];
					}
				}

				//IF CURRENT MONTH DATA EXIST UPDATE THE RECORD
				if($current_month){ 
					$s = "UPDATE contributor_earnings 
							SET total_article_rate = $total_article_rate,
							    total_shares = $total_shares,
							    share_rate = $share_rate,
							    total_share_rev = $total_share_rev,
							    total_earnings = $total_earnings,
							    total_us_pageviews = $total_us_pageviews,
							    to_be_pay = $total_to_be_pay,
							    updated_date = now()
						WHERE contributor_id = $id AND month = $month AND year = $year ";

					$queryParams = [ ];			
					$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);
				}else{
					//INSERT NEW RECORD
					$data[] = [
						'id' => NULL,
						'contributor_id' => $id,
						'month' => $month,
						'year' =>  $year,
						'total_article_rate' => $total_article_rate,
						'total_shares' => $total_shares,
						'share_rate' => $total_shares,
						'total_us_pageviews' => $total_us_pageviews,
						'total_share_rev' => $total_share_rev,
						'total_earnings' => $total_earnings,
						'paid' => 0,
						'to_be_pay' =>  $total_to_be_pay,
						'updated_date' => date('Y-m-d H:i:s', time())
					];

				}
				
			} 

			if(isset($data) && $data) $this->saveContributorsEarningsInformationDaily($data, $month, $year);
		}	
	}

	public function saveContributorsEarningsInformationDaily( $data, $month, $year ){
		if(!empty($data) && $data){
				$numItems = count($data);
				$i = 0;
				$s = " INSERT INTO contributor_earnings (`contributor_id`, `month`, `year`,  `total_article_rate`, `total_shares`, `share_rate`, `total_us_pageviews`,  
						  	`total_share_rev`, `total_earnings`, `paid`, `to_be_pay`,  `updated_date` ) VALUES ";
				
				foreach($data as $row ){
					$id = $row['id'];
					$contributor_id= $row['contributor_id'];
					$month =  $row['month'];
					$year= $row['year'];
					$total_article_rate= $row['total_article_rate'];
					$total_shares= $row['total_shares'];
					$share_rate= $row['share_rate'];
					$total_us_pageviews= $row['total_us_pageviews'];
					$total_share_rev= $row['total_share_rev'];
					$total_earnings= $row['total_earnings'];
					$paid= $row['paid'];
					$to_be_pay= $row['to_be_pay'];
					$updated_date = date('Y-m-d H:i:s', time());
					
					$s .= "( ".$contributor_id.", ".$month.", ".$year.", ".$total_article_rate.", ".$total_shares.", ".$share_rate.", ".$total_us_pageviews.", ".$total_share_rev.", "
					.$total_earnings.", ".$paid.", ".$to_be_pay.", '".$updated_date."' ) ";
					
					if(++$i < $numItems) {
						$s .= ", ";
					}
					
				}

				$queryParams = [
					//':articleId' => filter_var($articleId, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)
				];

				$pdo = $this->con->openCon();
				$q = $pdo->prepare($s);

				$row = $q->execute($queryParams);

				$this->con->closeCon();
				
				return true;//$row; 
			}else{
				return false;
		}
	}

	// //OLD ONE REPLACED BY pageviewsReport()
	// public function updateContributorsEarnings( $month, $year){
	// 	$month = filter_var($month, FILTER_SANITIZE_STRING, PDO::PARAM_STR);
	// 	$year = filter_var($year, FILTER_SANITIZE_STRING, PDO::PARAM_STR);

	// 	$contributors = $this->getContributorsList();
	// 	$data['month'] = $month;
	// 	$data['year'] = $year;

	// 	if($contributors){
	// 		foreach($contributors as $contributor){

	// 			$id = $contributor['contributor_id'];
	// 			$data['contributor'] = $id;
	// 			$update_data = $this->getContributorEarnings($id, $month, $year);

	// 			$earnings_info = $this->socialMediaSharesReport($data);

	// 			$total_article_rate = 0;
	// 			$total_shares = 0;

	// 			$share_rate = 0.01;				
	// 			$total_share_rev = 0;
	// 			$total_earnings = 0;
				
	// 			if($earnings_info && $earnings_info[0]){

	// 				$earnings_info = $earnings_info[0];
	// 				$total_article_rate = $earnings_info["total_rate"]; //RATE PER ARTICLE 25/10
	// 				$total_shares = $earnings_info["total_shares"]; //NUMBER OF SHARES
	// 				$share_rate = $earnings_info['share_rate']; 
	// 				$total_share_rev = $earnings_info["share_revenue"]; 
	// 				$total_earnings = $earnings_info["total_to_pay"]; //TOTAL RATE PER ARTICLE + NUMBER OF SHARES * 0.02
	// 			}

	// 			if($contributor['user_type'] != 4){
	// 				$total_earnings = $total_earnings - $total_article_rate;
	// 			}

	// 			if($month >= 2 && $year >=2015){
	// 				$total_earnings = $total_earnings - $total_article_rate;
	// 			}

	// 			if($update_data){
	// 				$s = "UPDATE contributor_earnings 
	// 						SET total_article_rate = $total_article_rate,
	// 						    total_shares = $total_shares,
	// 						    share_rate = $share_rate,
	// 						    total_share_rev = $total_share_rev,
	// 						    total_earnings = $total_earnings 
	// 					WHERE contributor_id = $id AND month = $month AND year = $year ";
	// 			}else{
	// 				$s = "INSERT INTO contributor_earnings
	// 					  (`id`, `contributor_id`, `month`, `year`, `total_article_rate`, `total_shares`, `share_rate`, 
	// 					  	`total_share_rev`, `total_earnings`, `paid`, `to_be_pay`)
	// 					  VALUES (NULL, '".$id."', '".$month."', '".$year."', '".$total_article_rate."', '".$total_shares."', 
	// 					  	'".$share_rate."', '".$total_share_rev."', '".$total_earnings."', '0', '".$total_earnings."') ";
	// 			}
	// 			$queryParams = [ ];			
	// 			$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);

	// 		}
	// 	}
	// }


	public function getContributorsList(){
		$s = " SELECT contributor_id, user_type from active_user_contributors ORDER BY user_login_count DESC";

		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s]);

		return $q;
	}

	//ONLY FOR TESTING WITH 2 CONTRIBUTORS
	public function getContributorsListTEST(){
		//$s = "SELECT contributor_id, user_type from article_contributors 
		//INNER JOIN users ON users.user_email = article_contributors.contributor_email_address where contributor_id IN (4317, 5112, 3675, 3612, 1459)";
		$s  = " SELECT contributor_id, user_type FROM active_user_contributors where contributor_id IN (3612, 5264, 5112, 6371) ";
		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s]);

		return $q;
	}

	public function getContributorEarnings( $id, $month, $year){
		$s = "SELECT * from contributor_earnings where contributor_id = $id AND month IN ( $month ) AND year = $year ORDER BY updated_date DESC ";
		$queryParams = [ ];			
		$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);

		
		if ($q && isset($q[0])){
			return $q;
		} else if ($q && !isset($q[0])){
			$q = array($q);
			return $q;
		}else return false;
	}

	//DEPRECATED
	public function getSocialSharesAndContributors(){
		$s=" SELECT social_media_records.*, article_contributors.contributor_id, article_contributors.contributor_name, article_contributors.contributor_seo_name FROM social_media_records 
			 INNER JOIN ( article_contributors, article_contributor_articles) 
			 ON ( article_contributor_articles.article_id = social_media_records.article_id) 
			 AND ( article_contributors.contributor_id = article_contributor_articles.contributor_id ) ";
	}



// ****************************************************************************************************
// ************************ TESTING BELOW TESTING BELOW TESTING BELOW TESTING BELOW *******************
// ****************************************************************************************************
// ****************************************************************************************************

	public function pageviewsReport( $month, $year ){
		$month = filter_var($month, FILTER_SANITIZE_STRING, PDO::PARAM_STR);
		$year =  filter_var($year, FILTER_SANITIZE_STRING, PDO::PARAM_STR);
	
		$ddd = new debug("\$month \$year = $month $year",2); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	


		$prev_month = $month;
		$prev_year = $year;
		if($prev_month == 1){
			$prev_month = 12;
			$prev_year = $year - 1;
		}else $prev_month = $month - 1;


		$ddd = new debug("\$prev_month \$prev_year = $prev_month $prev_year",2); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
		$ddd = new debug(str_repeat("=====", 20),2); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

		//CONTRIBUTOR LIST ACTIVE
		$contributors = $this->getContributorsList(); 

		// $ddd = new debug($contributors,3); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	

/*
Array
(
    [0] => Array
        (
            [contributor_id] => 102
            [user_type] => 1
        )

*/

		if($contributors){
			foreach($contributors as $contributor){

				$id = $contributor['contributor_id'];


if (
	$id ==3612 ||
	$id ==1570 ||
	$id ==2409 ||
	$id ==3173 
	){

				$current_month_data = false;
				$prev_month_data = false;
				
				//CONTRIBUTOR EARNINGS
				$update_data = $this->getContributorEarnings($id, $prev_month.', '.$month, $year);

$ddd = new debug(str_repeat("$id - ", 6),3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
$ddd = new debug("update_data",3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
$ddd = new debug($update_data,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
				
				if( $update_data ){
					if(count($update_data) > 1){
						$current_month_data = isset($update_data[0]) ? $update_data[0] : false;
						$prev_month_data = isset($update_data[1]) ? $update_data[1] : false;
					}else{
						if($update_data[0]['month'] == $month ){
							$current_month_data = isset($update_data[0]) ? $update_data[0] : false;
							$prev_month_data = false;
						}else{
							$current_month_data =  false;
							$prev_month_data = isset($update_data[0]) ? $update_data[0] : false;
						}// end if($update_data[0]
					}// end if(count($update_data) > 1)
				}// end if( $update_data )


$ddd = new debug("current_month_data",2); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
$ddd = new debug($current_month_data,2); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
$ddd = new debug("prev_month_data",2); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
$ddd = new debug($prev_month_data,2); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

				//GET PAGEVIEWS TOTAL PER MONTH
				$earnings_info = $this->get_articlesbypageviews_new_2( $id, $month, $year);


				$total_article_rate = 0;
				$total_shares = 0;
				$total_share_rev = 0;
				$total_us_pageviews = 0;
				$total_earnings = 0;
	            $total_to_be_pay = 0;

	            if($earnings_info) $total_us_pageviews = $earnings_info[0]['pvs'];
				$share_rate = $this->get_current_rate($month, $contributor['user_type']);	
			
				if($share_rate) $share_rate  = $share_rate['rate'];

				//Calc Total Earnings
				if( $total_us_pageviews > 0 ){
					$total_earnings = ($total_us_pageviews / 1000 ) * $share_rate;
				}

				$total_to_be_pay = $total_earnings;
				//Verify if the previews Month this contributor was paid, if not you will carry the pending amount to next month.
				if( isset($prev_month_data) && $prev_month_data ){
					if($prev_month_data['paid'] == 0){
						$total_to_be_pay = $total_to_be_pay + $prev_month_data['to_be_pay'];
					}
				}//end if


$ddd = new debug("earnings_info",3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
$ddd = new debug($earnings_info,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
$ddd = new debug("$id user_type ==>". $contributor['user_type'],1); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
$ddd = new debug("\$total_us_pageviews ==>$total_us_pageviews",2); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
$ddd = new debug("\$total_earnings ==> $total_earnings",2); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
$ddd = new debug("\$total_to_be_pay ==> $total_to_be_pay",2); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	



				// //IF CURRENT MONTH DATA EXIST UPDATE THE RECORD
				// if($current_month_data){ 
				// 	$s = "UPDATE contributor_earnings 
				// 			SET total_article_rate = $total_article_rate,
				// 			    total_shares = $total_shares,
				// 			    share_rate = $share_rate,
				// 			    total_share_rev = $total_share_rev,
				// 			    total_earnings = $total_earnings,
				// 			    total_us_pageviews = $total_us_pageviews,
				// 			    to_be_pay = $total_to_be_pay,
				// 			    updated_date = now()
				// 		WHERE contributor_id = $id AND month = $month AND year = $year ";

				// 	$queryParams = [ ];			
				// 	$q = $this->performQuery(['queryString' => $s, 'queryParams' => $queryParams]);
				// }else{
				// 	//INSERT NEW RECORD
				// 	$data[] = [
				// 		'id' => NULL,
				// 		'contributor_id' => $id,
				// 		'month' => $month,
				// 		'year' =>  $year,
				// 		'total_article_rate' => $total_article_rate,
				// 		'total_shares' => $total_shares,
				// 		'share_rate' => $total_shares,
				// 		'total_us_pageviews' => $total_us_pageviews,
				// 		'total_share_rev' => $total_share_rev,
				// 		'total_earnings' => $total_earnings,
				// 		'paid' => 0,
				// 		'to_be_pay' =>  $total_to_be_pay,
				// 		'updated_date' => date('Y-m-d H:i:s', time())
				// 	];

				// }//end if($current_month_data)


}//end if ($id ==3612 || $id ==1570 || $id ==2409 || $id ==3173 )

				
			} //end foreach($contributors as $contributor)

			//   if(isset($data) && $data) $this->saveContributorsEarningsInformationDaily($data, $month, $year);

		}	// end if($contributors)
	}//end public function pageviewsReport

// ****************************************************************************************************
// ************************ TESTING ABOVE TESTING ABOVE TESTING ABOVE TESTING ABOVE *******************
// ****************************************************************************************************
// ****************************************************************************************************

}//end class


?>