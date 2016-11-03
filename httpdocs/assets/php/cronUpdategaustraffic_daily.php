<?php
require 'config.php';
require 'class.GoogleAnalyticsApi.php';
require 'class.GoogleAnalyticsData.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');

$GoogleAnalyticsApi = new GoogleAnalyticsApi($config);
$GoogleAnalyticsData = new GoogleAnalyticsData($config);
$client = $GoogleAnalyticsApi->connect_to_client();

// Create Google Service Analytics object with our preconfigured Google_Client
$analytics = new Google_Service_Analytics($client);
$startDate = $endDate =  date('Y-m-d');
//$endDate = date('Y-m-d');


$arrArticle = $GoogleAnalyticsData->getArticlesNew();

$articles_pageviews_from_ga_USA = $analytics->data_ga->get('ga:88041867', $startDate, $endDate, 'ga:pageviews', array(
	'dimensions'=> 'ga:pagePath,ga:pageTitle',
	'filters'=>'ga:country==United States',
	'max-results' => 10000,
	'samplingLevel' => 'HIGHER_PRECISION',
	'sort'=> '-ga:pageviews'
));

$fromUSA  = array();


/*GET USA PAGE VIEWS TRAFFIC*/
if(count($articles_pageviews_from_ga_USA->getRows()) > 0 ){
	foreach($articles_pageviews_from_ga_USA->getRows() as $articles_ga_us){
		$usapageviews = 0;
		$pageviews = 0;
		$arr = array();
		$arr['path'] = $articles_ga_us[0];
		$arr['title'] = $articles_ga_us[1];
		$arr['all_pageviews'] = 0;
		$arr['usa_pageviews'] = 0;
							
		$seo = explode('/', $articles_ga_us[0]);
		
		$arr['seo'] = explode('?', $seo[count($seo) -1 ])[0];
		$seo = $arr['seo'];

		if($articles_ga_us[2] < 2 ) continue;

		if(array_key_exists($seo, $fromUSA)){
			$arr['usa_pageviews'] = $fromUSA[$seo]['usa_pageviews'] + $articles_ga_us[2];
		}else $arr['usa_pageviews'] = $articles_ga_us[2];
						
		$fromUSA[$seo] = $arr;					
	}
}

//var_dump(count($fromUSA)); 

/*MATCH GA RESULTS WITH ARTICLES FROM DB AND UPDATE GADATA DATABASE*/

$month= date('n');
$year = date('Y');
$data = null;
foreach( $arrArticle as $article ){		
	$article_id = $article['article_id'];
	$article_seo = $article['article_seo'];
	
	if(array_key_exists($article_seo, $fromUSA)){

		$info = $fromUSA[$article_seo];
		$pageviews = $info['all_pageviews'];
		$usa_pageviews = $info['usa_pageviews'] + 1;

		$data[] = [
			'article_id' => $article_id,
			'pageviews' => $usa_pageviews,
			'usa_pageviews' => $usa_pageviews,
			'pct_pageviews' =>  100
		];

	}
}

//var_dump($data, "<br>");
$GoogleAnalyticsData->saveGoogleAnalyticsInformationDaily($data, $month, $year);




?>
		
