<?php
//var_dump($_SERVER);


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
$endDate = date('Y-m-d');
$startDate = date('Y-m').'-01';
$month= date('n');
$year = date('Y');
$arrArticle = $GoogleAnalyticsData->getArticlesNew();

				$articles_pageviews_from_ga = $analytics->data_ga->get('ga:88041867', $startDate, $endDate, 'ga:pageviews', array(
				  		'dimensions'=> 'ga:pagePath,ga:pageTitle',
				  		'filters'=>'ga:country!=United States',
				  		'max-results' => 10000,
				  		'sort'=> '-ga:pageviews'
				));

				$articles_pageviews_from_ga_USA = $analytics->data_ga->get('ga:88041867', $startDate, $endDate, 'ga:pageviews', array(
				  		'dimensions'=> 'ga:pagePath,ga:pageTitle',
				  		'filters'=>'ga:country==United States',
				  		'max-results' => 10000,
				  		'sort'=> '-ga:pageviews'
				));

				$fromUSA  = array();
				$fromEveryWhere = array();

				/*GET ALL PAGEVIEWS TRAFFIC*/
				foreach($articles_pageviews_from_ga->getRows() as $articles_ga){
				
					$usapageviews = 0;
					$pageviews = 0;
					$arr = array();

					$arr['path'] = $articles_ga[0];
					$arr['title'] = $articles_ga[1];
					$arr['all_pageviews'] = 0;
							
					$seo = explode('/', $articles_ga[0]);
					$arr['seo'] = explode('?', $seo[count($seo) -1 ])[0];
					$seo = $arr['seo'];

					if(array_key_exists($seo, $fromEveryWhere)){
						$arr['all_pageviews'] = $fromEveryWhere[$seo]['all_pageviews'] + $articles_ga[2];
					}else $arr['all_pageviews'] = $articles_ga[2];
					
					$fromEveryWhere[$seo] = $arr;
						
				}
				
				/*GET USA PAGE VIEWS TRAFFIC*/
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
					if(array_key_exists($seo, $fromUSA)){
						$arr['usa_pageviews'] = $fromUSA[$seo]['usa_pageviews'] + $articles_ga_us[2];
					}else $arr['usa_pageviews'] = $articles_ga_us[2];

					if(isset($fromEveryWhere[$seo])) $arr['all_pageviews'] = $arr['usa_pageviews'] + $fromEveryWhere[$seo]['all_pageviews'];
					//else $arr['all_pageviews'] = $arr['usa_pageviews'];
					
					$fromUSA[$seo] = $arr;
						
				}

				/*MATCH GA RESULTS WITH ARTICLES FROM DB AND UPDATE GADATA DATABASE*/
				foreach( $arrArticle as $article ){
						
					$article_id = $article['article_id'];
					$article_seo = $article['article_seo'];
					if(array_key_exists($article_seo, $fromUSA)){
						$info = $fromUSA[$article_seo];
						$pageviews = $info['all_pageviews'];
						$usa_pageviews = $info['usa_pageviews'];

						$pctValue = $GoogleAnalyticsData->getPercentageValue( $usa_pageviews, $pageviews );
							
						$data = [
							'article_id' => $article_id,
							'pageviews' => $pageviews,
							'usa_pageviews' => $usa_pageviews,
							'pct_pageviews' =>  $pctValue
						];

						$GoogleAnalyticsData->saveGoogleAnalyticsInformationNew($data, $month, $year);
					}
				}

		//UPDATE CONTRIBUTOR EARNINGS TABLE
	  // $dashboard->pageviewsReport( $month, $year );
	?>
		
