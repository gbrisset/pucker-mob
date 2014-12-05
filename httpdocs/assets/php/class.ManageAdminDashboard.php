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

	}

	public function saveWarningsMessages(){

	}

	public function getTopSharedMoblogs(){
		$s = "SELECT 'flor', articles.article_id, articles.article_title, articles.article_seo_title, article_contributors.contributor_id,  article_contributors.contributor_name,  article_contributors.contributor_image,  social_media_records.date_updated, articles.creation_date, social_media_records.category, (SUM(facebook_shares) + SUM(twitter_shares) + SUM(pinterest_shares) + SUM(google_shares) + SUM(linkedin_shares) + SUM(delicious_shares) + SUM(stumbleupon_shares)) as 'total_shares'  
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
	

	public function getAnnouncements(){

	}

	public function saveAnnouncements(){

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