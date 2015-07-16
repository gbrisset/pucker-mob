<?php

require_once dirname(__FILE__).'/Connector.php';

class GoogleAnalyticsData{


	protected $config;
	protected $con;
	protected $viewId;
	protected $metrics;
	protected $dimensions;

	public function __construct($c){
		$this->config = $c;
		$this->con = new Connector($this->config);
		$this->viewId = 'ga:88041867'; //View for PuckerMob Application
		$this->metrics = 'ga:pageviews';
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


	public function getArticles(){
		$month = date('n');
		$year = date('Y');
		
		$arr = [];
		$s = "SELECT social_media_records.*, articles.article_seo_title, articles.article_title  
			  FROM  social_media_records
			  INNER JOIN ( articles )
			  ON articles.article_id = social_media_records.article_id 
			  WHERE  social_media_records.month = ".$month." AND social_media_records.year = ".$year."  
			   AND articles.article_status = 1  GROUP BY articles.article_id ORDER BY id DESC ";

		$q = $this->performQuery(['queryString' => $s]);
		
		if ($q && isset($q[0])){
				// If $q is an array of only one row (The set only contains one article), return it inside an array
			$q = $q;
		} else if ($q && !isset($q[0])){
				// If $q is an array of rows, return it as normal
			$q = array($q);
			//return $q;
		} else {
			$q = false;
		}
		
		if($q){
			foreach($q as $article){
				$arr[] = [	'article_id' => $article['article_id'], 
							'article_title' => $article['article_title'],
							'article_seo' => '/'.$article['category'].'/'.$article['article_seo_title'],
							'category' => $article['category']
						 ];
			}
		}

		return $arr;
	}

	public function getArticlesNew(){
		$month = date('n');
		$year = date('Y');
		
		$arr = [];
		$s = "SELECT article_id, article_seo_title, article_title  
			  FROM  articles
			  WHERE article_status = 1 ORDER BY article_id DESC ";

		$q = $this->performQuery(['queryString' => $s]);
		
		if ($q && isset($q[0])){
				// If $q is an array of only one row (The set only contains one article), return it inside an array
			$q = $q;
		} else if ($q && !isset($q[0])){
				// If $q is an array of rows, return it as normal
			$q = array($q);
			//return $q;
		} else {
			$q = false;
		}
		
		if($q){
			foreach($q as $article){
				$arr[] = [	'article_id' => $article['article_id'], 
							'article_title' => $article['article_title'],
							'article_seo' => $article['article_seo_title']//,
							//'category' => $article['category']
						 ];
			}
		}

		return $arr;
	}

	public function verifyArticleid( $articleId , $month, $year ){
			$s="SELECT article_id FROM google_analytics_data WHERE article_id = $articleId AND month = $month AND year = $year LIMIT 1";

			$queryParams = [':articleID' => filter_var($articleId, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
							':month' => filter_var($month, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
							':year' => filter_var($year, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT) ];

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

	public function verifyArticleidNew( $articleId , $month, $year ){
			$s="SELECT article_id FROM google_analytics_data_new WHERE article_id = $articleId AND month = $month AND year = $year LIMIT 1";

			$queryParams = [':articleID' => filter_var($articleId, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
							':month' => filter_var($month, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT),
							':year' => filter_var($year, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT) ];

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
	
	public function removeGoogleAnalyticsMostViewArticles(){

		$remove = "DELETE  FROM google_analytics_most_viewed_articles;";
		$queryParams = [];

		$pdo = $this->con->openCon();
				
		$rem = $pdo->prepare($remove);
		$wasremoved = $rem->execute($queryParams);

		$this->con->closeCon();

		return $wasremoved; 
	}

	public function removeGoogleAnalyticsMostViewArticlesAlways(){

		$remove = "DELETE  FROM google_analytics_most_viewed_articles_always;";
		$queryParams = [];

		$pdo = $this->con->openCon();
				
		$rem = $pdo->prepare($remove);
		$wasremoved = $rem->execute($queryParams);

		$this->con->closeCon();

		return $wasremoved; 
	}

	public function saveGoogleAnalyticsMostViewArticles( $data ){
		if(!empty($data) && $data){
			foreach($data as $article){
				$pageviews =  $article['pageviews'];
				$title= $article['title'];

				$url= $article['url'];
				$seo = $article['seo_title'];
				$insert = " INSERT INTO google_analytics_most_viewed_articles
							   (`pageviews`, `title`, `url`, `seo_title`) 
							   VALUES ( $pageviews, '".addslashes($title)."', '".$url."', '".$seo."') ";
				$queryParams = [];

				$pdo = $this->con->openCon();
				//var_dump($insert);	
				$ins = $pdo->prepare($insert);

				$row = $ins->execute($queryParams);

				$this->con->closeCon();
			}
			return true; 
		}else{
			return false;
		}
	}

	public function saveGoogleAnalyticsMostViewArticlesAlways( $data ){
		if(!empty($data) && $data){
			foreach($data as $article){
				$pageviews =  $article['pageviews'];
				$title= $article['title'];

				$url= $article['url'];
				$seo = $article['seo_title'];
				$insert = " INSERT INTO google_analytics_most_viewed_articles_always
							   (`pageviews`, `title`, `url`, `seo_title`) 
							   VALUES ( $pageviews, '".addslashes($title)."', '".$url."', '".$seo."') ";
				$queryParams = [];

				$pdo = $this->con->openCon();
				//var_dump($insert);	
				$ins = $pdo->prepare($insert);

				$row = $ins->execute($queryParams);

				$this->con->closeCon();
			}
			return true; 
		}else{
			return false;
		}
	}

	public function saveGoogleAnalyticsInformation( $data, $month, $year ){
		if(!empty($data) && $data){
				
				$articleId = $data['article_id'];
				$pageviews =  $data['pageviews'];
				$usa_pageviews= $data['usa_pageviews'];
				$pct_pageviews= $data['pct_pageviews'];
				$current_date = date('Y-m-d H:i:s', time());
				$idExist = $this->verifyArticleid( $articleId , $month, $year );

				if($idExist){
					$s = " UPDATE  google_analytics_data 
					  	   SET pageviews = $pageviews, 
					  	   	   usa_pageviews = $usa_pageviews, 
					  	   	   pct_pageviews = $pct_pageviews ,
					  	   	   updated_date = '".$current_date ."'  
					        WHERE article_id = $articleId AND month = '".$month."' AND year = '".$year."' ";
				}else{
					$s = " INSERT INTO google_analytics_data
						   (`article_id`, `pageviews`, `usa_pageviews`, `pct_pageviews`,  `month`, `year`) 
						   VALUES (:articleId, $pageviews, $usa_pageviews, $pct_pageviews,  $month, $year) ";
					}

				$queryParams = [
					':articleId' => filter_var($articleId, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)
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

	public function saveGoogleAnalyticsInformationNew( $data, $month, $year ){
		if(!empty($data) && $data){
				
				$articleId = $data['article_id'];
				$pageviews =  $data['pageviews'];
				$usa_pageviews= $data['usa_pageviews'];
				$pct_pageviews= $data['pct_pageviews'];
				$current_date = date('Y-m-d H:i:s', time());
				$idExist = $this->verifyArticleidNew( $articleId , $month, $year );

				if($idExist){
					$s = " UPDATE  google_analytics_data_new 
					  	   SET pageviews = $pageviews, 
					  	   	   usa_pageviews = $usa_pageviews, 
					  	   	   pct_pageviews = $pct_pageviews ,
					  	   	   updated_date = '".$current_date ."'  
					        WHERE article_id = $articleId AND month = '".$month."' AND year = '".$year."' ";
				}else{
					$s = " INSERT INTO google_analytics_data_new 
						   (`article_id`, `pageviews`, `usa_pageviews`, `pct_pageviews`,  `month`, `year`) 
						   VALUES ( $articleId, $pageviews, $usa_pageviews, $pct_pageviews,  $month, $year) ";
					}

				$queryParams = [
					':articleId' => filter_var($articleId, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)
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

	public function saveGoogleAnalyticsInformationDaily( $data, $month, $year ){
		if(!empty($data) && $data){
				
				$articleId = $data['article_id'];
				$pageviews =  $data['pageviews'];
				$usa_pageviews= $data['usa_pageviews'];
				$pct_pageviews= $data['pct_pageviews'];
				$current_date = date('Y-m-d H:i:s', time());
				
				$s = " INSERT INTO google_analytics_data_daily 
					   (`article_id`, `pageviews`, `usa_pageviews`, `pct_pageviews`,  `month`, `year`) 
					   VALUES ( $articleId, $pageviews, $usa_pageviews, $pct_pageviews,  $month, $year) ";
				
				$queryParams = [
					':articleId' => filter_var($articleId, FILTER_SANITIZE_NUMBER_INT, PDO::PARAM_INT)
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


	public function getPreviewMonthArticles($month, $year, $id, $category){

		$s = "SELECT social_media_records.facebook_shares_org, social_media_records.twitter_shares_org, 
		social_media_records.pinterest_shares_org, social_media_records.google_shares_org, 
		social_media_records.delicious_shares_org, social_media_records.stumbleupon_shares_org, 
		social_media_records.linkedin_shares_org
			  FROM  social_media_records
			  WHERE  social_media_records.month = '".$month."' AND social_media_records.year = '".$year."' 
			  AND social_media_records.article_id = '".$id."'  
			  AND social_media_records.category = '".$category."'";
		$q = $this->performQuery(['queryString' => $s]);

		if ($q && isset($q[0])){
				// If $q is an array of only one row (The set only contains one article), return it inside an array
			return $q;
		} else if ($q && !isset($q[0])){
				// If $q is an array of rows, return it as normal
			$q = array($q);
			return $q;
		} else {
			return '';
		}
	}
	public function getTotalPageView($analyticsObj, $startDate, $endDate, $filter, $path){

		$filter_s = ''; 			
		if(!empty($filter) && count($filter) > 0){
			$index = count($filter);
				foreach($filter as $key => $value){
				$prefix = '';
				if($index > 1 ) $prefix = ';';
				$filter_s .= $key.'=='.$value.$prefix;
				$index --;
			}
		}			
		try{
		$analytics = $analyticsObj->data_ga->get($this->viewId, $startDate, $endDate, $this->metrics, array(
				  		'filters'=> $filter_s
					  )
		);
		}catch (apiServiceException $e) {
		    // Handle API service exceptions.
		    $error = $e->getMessage();
		  }

		if($analytics){
			$result = $analytics->getRows()[0];
				
			if(isset($result[0]) && $result[0]) $result = $result[0];

			return $result;
		}
		return false;
	}	
	public function queryGoogleAnalyticsInformation( $analyticsObj, $startDate, $endDate, $optParams=[] ){
		$params = array_merge([
			'filters' => '',
			'dimensions' => '',
			'segment' => '',
			'sort' => '',
			'max-results' => '10000'
			], $optParams);
		
		try{
			$analytics = $analyticsObj->data_ga->get($this->viewId, $startDate, $endDate,  $this->metrics, array(
				'dimensions'=> 'ga:pagePath,ga:pageTitle',
				'sort' => '-ga:pageviews',
				'max-results' => $params['max-results'],
				'start-index' => 1
				) );
		}catch (apiServiceException $e) {
		    // Handle API service exceptions.
		    $error = $e->getMessage();
		  }

		if($analytics){ 
			$result = $analytics->getRows();
			
			return $result;
		}
		return false;
	}

	public function getPercentageValue($val1, $val2){
		
		if( $val1 <= 0 || $val2 <= 0 ) return '0';
		
		$total = ( $val1 / $val2 );
		if($total > 1 ) $total = 1;

		$total = $total * 100;

		return $total;
	}


}
?>