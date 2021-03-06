<?php
require_once dirname(__FILE__).'/Connector.php';


class ManageAdminDashboard{
	
	protected $config;
	protected $con;


	public function __construct($c){
		$this->config = $c;
		$this->con = new Connector($this->config);
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

	public function getWarningsMessages(){
		$s = "SELECT *  
			  FROM notification_center 
			  WHERE notification_type = 0 ";

		$q = $this->performQuery(['queryString' => $s]);

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

	public function saveWarningsMessages($data){
		$msg = $data['notification_msg'];
		$status = $data['notification_live'];

		if($msg === 'START WRITING HERE.') $msg = "";
		
		if($this->getWarningsMessages()) $action = "UPDATE";
		else $action = "INSERT";

		if($action == "UPDATE"){
			$s = "UPDATE notification_center SET notification_msg = '".$msg."', notification_live = $status
			WHERE notification_type = 0 ";
		}else{
			$s = "INSERT INTO notification_center ( notification_id, notification_type, notification_msg, notification_live)
			VALUES ( NULL , 0, '".$msg."', $status); ";
		}

		$pdo = $this->con->openCon();
		$q = $pdo->prepare($s);

		$row = $q->execute($queryParams);
		return $row; 
	}

	public function getTopSharedMoblogs($month, $year){
		if($month === 'all'){ $month = 0;}
		
		$month = filter_var($month,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);	
		$s = "SELECT articles.article_id, articles.article_title, articles.article_seo_title, social_media_records.date_updated, articles.creation_date, social_media_records.category, (
				SUM( facebook_shares ) + SUM( twitter_shares ) + SUM( pinterest_shares ) + SUM( google_shares ) + SUM( linkedin_shares ) + SUM( delicious_shares ) + SUM( stumbleupon_shares )
				) AS 'total_shares'
				FROM social_media_records
			    INNER JOIN articles ON social_media_records.article_id = articles.article_id

				WHERE articles.article_status = 1 ";
		if( $month != 0 ){
			$s.= " AND social_media_records.month = ".$month." AND social_media_records.year = ".$year;
		}
		$s.= " GROUP BY social_media_records.id ORDER BY total_shares DESC LIMIT 10";

		$q = $this->performQuery(['queryString' => $s]);

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

	public function getTopShareWritesRankWithIncentives($month, $incentives ){
		$author_list = $this->getTopShareWritesRank($month, 50, false);
		$writers = [];
		if($incentives){

			foreach($incentives as $inc){

				for($i = $inc->start; $i < $inc->end; $i++){
					//$author_list[$i]['bonus'] = $inc->bonus;
					$writers[$author_list[$i]['contributor_id']] = $inc->bonus;
					
				}
			}

			return $writers;
		}

	}


	public function getTopShareWritesRank($year = false, $month, $limit = '', $user_type = false ){
//$user_type = "30, 3, 8" 
		$month = filter_var($month,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		if ($year) {
			$year = filter_var($year,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		}else{
			$year = date('Y'); //This function used to be set for the current year only -- GB 2017-01-17
		}//end if

		$s_limit = ($limit =='')? '' : 'LIMIT $limit';
		$s = "
			SELECT DISTINCT( c.contributor_id), c.total_article_rate,c.total_shares, c.share_rate,
			c.total_us_pageviews, c.total_share_rev, c.total_earnings, c.paid,c.to_be_pay,c.updated_date, 
			a.*, users.user_type 
			FROM contributor_earnings c  
			INNER JOIN ( article_contributors a, users) 
			ON (c.contributor_id = a.contributor_id) 
			AND ( a.contributor_email_address = users.user_email) 	  
			WHERE month = $month AND year = $year  AND users.user_type IN ( $user_type)
			ORDER BY total_us_pageviews DESC $s_limit ";
		
// echo "<br/><br/>$s";
		$q = $this->performQuery(['queryString' => $s]);

		return $q;
	}	

	public function getIncentivesRank($year, $month, $tier = '', $user_type = "30, 3, 8" , $inc_options){

		$month = filter_var($month,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$year = filter_var($year,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$s_limit = ($tier =='')? '' : "LIMIT $tier";
		$s = "
				SELECT DISTINCT( c.contributor_id), c.total_us_pageviews, 
				a.contributor_id, a.contributor_seo_name, a.contributor_name, 
				users.user_type, 
				user_type.label

				FROM contributor_earnings c 
				INNER JOIN ( article_contributors a, users, user_type)
				ON (c.contributor_id = a.contributor_id) 
				AND ( a.contributor_email_address = users.user_email) 
				AND (users.user_type = user_type.user_type)

				WHERE month = $month AND year = $year  AND users.user_type IN ( $user_type) $inc_options
				ORDER BY total_us_pageviews DESC $s_limit 
				";
		
// echo "<br/><br/>$s";
		$q = $this->performQuery(['queryString' => $s]);

		return $q;
	}	



	public function  smf_getContributorRank($contributor_id = 0, $month = 0, $year = 0){
		// based on getTopShareWritesRankHeader

		$contributor_id = filter_var($contributor_id,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$month = filter_var($month,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$year = filter_var($year,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		 
		if($month == 0) $month = date('Y');
		if($year == 0) $year = date('Y');

		$s = "
			SELECT distinct(t2.contributor_id), t2.rownum 
			FROM(
			SELECT t1.contributor_id, (@rownum := @rownum + 1) as rownum 
			FROM contributor_earnings t1
			JOIN  (SELECT @rownum := 0) r
			WHERE  t1.month = $month AND t1.year = $year
			ORDER BY total_us_pageviews DESC) t2
			WHERE t2.contributor_id = $contributor_id
			";

		$q = $this->performQuery(['queryString' => $s]);
		$r = $q ['rownum'];


		 // $ddd = new debug($s,3); $ddd->show();exit;

		return $r;
	}//end public function smf_getContributorRank ... 


	public function getTopShareWritesRankHeader($month = 0, $year = 0){

		$month = filter_var($month,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$year = filter_var($year,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		 
		if($month == 0) $month = date('Y');
		if($year == 0) $year = date('Y');

		$s = "SELECT contributor_id, (@rownum := @rownum + 1) as rownum 
			FROM `contributor_earnings` 
			JOIN  (SELECT @rownum := 0) r
			WHERE  month = $month AND year = $year 
			ORDER BY total_us_pageviews DESC ";

		$q = $this->performQuery(['queryString' => $s]);
		
		return $q;
	}

	public function getTopSharedMoblogsBU(){
		$s = "SELECT articles.article_id, articles.article_title, articles.article_seo_title, article_contributors.contributor_id,  article_contributors.contributor_name,  article_contributors.contributor_image,  social_media_records.date_updated, articles.creation_date, social_media_records.category, (SUM(facebook_shares) + SUM(twitter_shares) + SUM(pinterest_shares) + SUM(google_shares) + SUM(linkedin_shares) + SUM(delicious_shares) + SUM(stumbleupon_shares)) as 'total_shares'  
			  FROM social_media_records 
			   INNER JOIN ( articles, article_contributors, article_contributor_articles ) 
				ON social_media_records.article_id = articles.article_id AND article_contributor_articles.article_id = articles.article_id AND article_contributor_articles.contributor_id = article_contributors.contributor_id 

				WHERE articles.article_status = 1 
				GROUP BY social_media_records.article_id
				ORDER BY total_shares DESC LIMIT 5";

		$q = $this->performQuery(['queryString' => $s]);

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
	
	public function getLastMonthEarnings($contributor_id, $month, $year){

		$month = filter_var($month,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$contributor_id = filter_var($contributor_id,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		//$year = date('Y');

		$s = "SELECT DISTINCT( total_earnings), FROM contributor_earnings WHERE contributor_id = $contributor_id ";

		if($year != 0 ) $s .= " AND year = $year ";
		if($month != 0 ) $s.= " AND month = $month ";

		$q = $this->performQuery(['queryString' => $s]);

		return $q;
	}

	public function getLastMonthEarningsInfo($contributor_id, $month, $year){

		$month = filter_var($month,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$contributor_id = filter_var($contributor_id,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$year = filter_var($year,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);;

		$s = "SELECT DISTINCT( total_earnings), total_us_pageviews, contributor_id, to_be_pay
		FROM contributor_earnings 
		WHERE  year = $year AND month = $month ";

		if( $contributor_id != 0 ) $s .= " AND contributor_id = $contributor_id ";
		$s .= " ORDER BY total_earnings DESC";

		$q = $this->performQuery(['queryString' => $s]);

		return $q;
	}

	public function smf_getContributorEarningsInfo( $contributor_id = 0){
		$contributor_id = filter_var($contributor_id,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$year = date('Y');
		$month = date('n');

		$s = "SELECT DISTINCT( total_earnings), total_us_pageviews, contributor_id
		FROM contributor_earnings 
		WHERE  year = $year AND month = $month ";

		if( $contributor_id > 0 ) $s .= " AND contributor_id = $contributor_id ";
		
// var_dump($contributor_id, $year, $month, $s); die;
		$q = $this->performQuery(['queryString' => $s]);
		return $q;	
	}

	public function smf_getContributorBalanceDue( $contributor_id = 0){


		$contributor_id = filter_var($contributor_id,  FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT);
		$year = date('Y');
		$month = date('n');

		$s = "
			SELECT SUM(`total_earnings`) AS balance_due
			FROM `contributor_earnings`
			WHERE payday_date = 0 AND `contributor_id` = $contributor_id
		";

		$q = $this->performQuery(['queryString' => $s]);
		return $q;	
	}

	public function get_bestArticle( $contributor_id, $month, $year ){

		$s = "SELECT * FROM  google_analytics_data_new 
				INNER JOIN ( article_contributor_articles, articles, article_categories, categories ) 
				ON ( article_contributor_articles.article_id = google_analytics_data_new.article_id )
				AND ( articles.article_id = google_analytics_data_new.article_id )
				AND ( article_categories.article_id = google_analytics_data_new.article_id )
				AND (categories.cat_id = article_categories.cat_id )
				WHERE google_analytics_data_new.month = ".$month." AND  google_analytics_data_new.year = ".$year;

			if( isset($contributor_id) && $contributor_id != 0){
				$s.= " AND article_contributor_articles.contributor_id = ".$contributor_id;
			}

			$s.= " ORDER BY google_analytics_data_new.usa_pageviews DESC LIMIT 1 ";
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
	
	public function getAnnouncements(){
		$s = "SELECT *  
			  FROM notification_center 
			  WHERE notification_type = 1 ";

		$q = $this->performQuery(['queryString' => $s]);

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

	public function saveAnnouncements($data){
		$msg = $data['notification_annoucement_msg'];
		$status = $data['notification_annoucement_live'];

		if($msg === 'START WRITING HERE.') $msg = "";
		
		if($this->getAnnouncements()) $action = "UPDATE";
		else $action = "INSERT";

		if($action == "UPDATE"){
			$s = "UPDATE notification_center SET notification_msg = '".$msg."', notification_live = $status
			WHERE notification_type = 1 ";
		}else{
			$s = "INSERT INTO notification_center ( notification_id, notification_type, notification_msg, notification_live)
			VALUES ( NULL , 1, '".$msg."', $status); ";
		}

		$pdo = $this->con->openCon();
		$q = $pdo->prepare($s);

		$row = $q->execute($queryParams);
		
		return $row; 
	}

	public function getTrendingTopics(){

	}

	public function getRecentArticlesByContributor(){

	}

	public function bd_nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",","",$n));
        
        // is this a number?
        if(!is_numeric($n)) return false;
        
        // now filter it;
        if($n>1000000000000) return round(($n/1000000000000),1).'T';
        else if($n>1000000000) return round(($n/1000000000),1).'B';
        else if($n>1000000) return round(($n/1000000),1).'M';
        else if($n>1000) return round(($n/1000),1).'K';
        
        return number_format($n);
    }
}
?>