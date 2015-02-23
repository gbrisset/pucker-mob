<?php
require_once dirname(__FILE__).'/Connector.php';

class SocialMediaManage{
	
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

	public function getSocialMediaResult($social_network, $apiUrl){

		$counts = false;

		if(empty($social_network) ||  empty($apiUrl)) return false;

		$content = file_get_contents($apiUrl);
 
		if($content){
			switch ($social_network){
				case 'pinterest':
					$content = str_replace("receiveCount(", "", $content);
		 			$content = substr($content, 0, -1);
		 		break;

		 		case 'linkedin':
					$content = str_replace("IN.Tags.Share.handleCount(", "", $content);
 					$content = str_replace(");", "", $content);
		 		break;

		 		case'delicious':
		 			if ($content == '[]') {
			            $content = '[{"total_posts": 0}]';
			        }
		 		break;

		 		case 'googleplus':
		 		  	$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
					curl_setopt($curl, CURLOPT_POST, 1);
					curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $apiUrl . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
					$curl_results = curl_exec ($curl);
					$content = $curl_results;
					
			  	break;

				default: break;
			}

			$counts = json_decode($content, true);	
			//var_dump($counts);
			//if(isset($curl)) curl_close ($curl);
		} 

		return $counts;
	}
	public function formatSocialMediaResult( $social_network, $data ){
		$result = 0;
		
		if(!$social_network || empty($social_network)) return false;

		switch ($social_network){
			case 'facebook':
				if ($data && isset($data[0]['total_count'])) $result = intval($data[0]['total_count']);
	     	break;

	     	case 'facebook_shares':
	     		if ($data && isset($data[0]['share_count'])) $result = intval($data[0]['share_count']);
	     	break;

	     	case 'facebook_likes':
	     		if ($data && isset($data[0]['like_count'])) $result = intval($data[0]['like_count']);
	     	break;

	     	case 'facebook_comments':
	     		if ($data && isset($data[0]['comment_count'])) $result = intval($data[0]['comment_count']);
	     	break;

			case 'twitter':
				if ($data && isset($data['count'])) $result = intval($data['count']);
         	break;

			case 'pinterest':
				if ($data && isset($data['count'])) $result = intval($data['count']);
			break;

			case 'googleplus':
				if (isset($data[0]['result']['metadata']['globalCounts']['count'])) {
                    $result = intval($data[0]['result']['metadata']['globalCounts']['count']);
                }
			break;

			case 'delicious':
				if ($data && isset($data[0]['total_posts'])) $result = intval($data[0]['total_posts']);
            break;

			case 'stumbleupon':
				if ($data && isset($data['result']['views'])) $result = intval($data['result']['views']);
           	break;

			case 'linkedin':
				if ($data && isset($data['count'])) $result = intval($data['count']);
	      	break;

	      	default: break;

		}

		return $result;
	}

	public function extractDataFromSocialMediaNetworks($url){
		$total_shares = 0;
		$counts = [];
	 	try{
	 	
	 		/*FACEBOOK*/
	 		$fbCountsShares = $this->getSocialMediaResult('facebook_shares', 'http://api.facebook.com/restserver.php?method=links.getStats&format=json&urls='.$url);
			$fbShares = $this->formatSocialMediaResult('facebook_shares', $fbCountsShares);

			$fbCountsLikes = $this->getSocialMediaResult('facebook_likes', 'http://api.facebook.com/restserver.php?method=links.getStats&format=json&urls='.$url);
			$fbTotalLikes = $this->formatSocialMediaResult('facebook_likes', $fbCountsLikes);

			$fbCountsComments = $this->getSocialMediaResult('facebook_comments', 'http://api.facebook.com/restserver.php?method=links.getStats&format=json&urls='.$url);
			$fbTotalComments = $this->formatSocialMediaResult('facebook_comments', $fbCountsComments);
	 		
	 		/*TWITTER*/
	 		$tweetCounts = $this->getSocialMediaResult('twitter', 'http://cdn.api.twitter.com/1/urls/count.json?url='.$url);
	 		$tweetsTotal = $this->formatSocialMediaResult('twitter', $tweetCounts);
	 		
	 		/*PINTEREST*/
	 		$pinCounts = $this->getSocialMediaResult('pinterest', 'http://widgets.pinterest.com/v1/urls/count.json?source=6&url='.$url);
	 		$pinterestTotal = $this->formatSocialMediaResult('pinterest', $pinCounts);
	 		
	 		/*GOOGLE PLUS*/
	 		$googleCounts = $this->getSocialMediaResult('googleplus', $url);
	 		$googleTotal = $this->formatSocialMediaResult('googleplus', $googleCounts);
	 		
	 		/*LINKEDIN*/
	 		$linCounts = $this->getSocialMediaResult('linkedin', 'http://www.linkedin.com/countserv/count/share?url='.$url);
	 		$linkedinTotal = $this->formatSocialMediaResult('linkedin', $linCounts);
	 		
	 		/*DELICIOUS*/
	 		$delCounts = $this->getSocialMediaResult('delicious', 'http://feeds.delicious.com/v2/json/urlinfo/data?url='.$url);
			$deliciousTotal = $this->formatSocialMediaResult('delicious', $delCounts);
	 		
	 		/*STUMBLEUPON*/
	 		$stCounts = $this->getSocialMediaResult('stumbleupon', 'http://www.stumbleupon.com/services/1.01/badge.getinfo?url='.$url);
	 		$stumbleuponTotal = $this->formatSocialMediaResult('stumbleupon', $stCounts);
	 		
	 		$counts['Facebook']['share_count'] = $fbShares;
	 		$counts['Facebook']['like_count'] = $fbTotalLikes;
	 		$counts['Facebook']['comment_count'] = $fbTotalComments;
	 		$counts['Twitter'] = $tweetsTotal;
	 		$counts['Pinterest'] = $pinterestTotal;
			$counts['GooglePlusOne'] = $googleTotal;
			$counts['Delicious'] = $deliciousTotal;
			$counts['StumbleUpon'] = $stumbleuponTotal;
			$counts['LinkedIn']	= $linkedinTotal;
			
			return $counts;	
	 		//var_dump($fbShares, $fbTotalLikes, $fbTotalComments, $tweetsTotal, $pinterestTotal, $linkedinTotal, $deliciousTotal, $stumbleuponTotal, $googleTotal );
	 		

		 }catch (Exception $e) {
		    echo 'Caught exception: ',  $e->getMessage(), "\n";
		 }
	}
}
?>