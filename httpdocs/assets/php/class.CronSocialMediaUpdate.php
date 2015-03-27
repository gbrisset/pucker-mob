<?php
require_once dirname(__FILE__).'/Connector.php';

class CronSocialMediaInformation{
	
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


	public function getArticles(){
		$s = "SELECT articles.article_id, article_seo_title, cat_dir_name 
			  FROM articles 
			  INNER JOIN ( categories, article_categories )
			  ON articles.article_id = article_categories.article_id AND article_categories.cat_id = categories.cat_id
			  WHERE article_status = 1 ";

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

	public function updateSponsoredByAds( $value ){
		$s='UPDATE article_page_ads SET has_sponsored_by = '.$value.' WHERE article_page_ads.article_page_id = 1 ';

		$q = $this->performQuery(['queryString' => $s]);
	}
}
?>