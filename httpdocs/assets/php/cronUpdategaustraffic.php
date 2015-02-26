<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require 'config.php';
require 'class.GoogleAnalyticsApi.php';
require 'class.GoogleAnalyticsData.php';

$GoogleAnalyticsApi = new GoogleAnalyticsApi($config);
$GoogleAnalyticsData = new GoogleAnalyticsData($config);

$client = $GoogleAnalyticsApi->connect_to_client();

// Create Google Service Analytics object with our preconfigured Google_Client
$analytics = new Google_Service_Analytics($client);
$endDate = date('Y-m-d');
$startDate = date('Y-m').'-01';
$month= date('n');
$year = date('Y');
$arrArticle = $GoogleAnalyticsData->getArticles();
//var_dump(count($arrArticle), $year, $month); die;
?>
<html>

<head>
	<title>GOOGLE API </title>
</head>
	<body>
		<table>
			<thead>
				<td>TITLE</td>
				<td>TOTAL PAGEVIEWS</td>
				<td>USA PAGEVIEWS</td>
				<td>%US</td>
			</thead>
			<tbody>
			<?php
			foreach( $arrArticle as $article ){


				$path = $article['article_seo'];

				$filter = ['ga:pagePath' => $path];
				$pageviews = $GoogleAnalyticsData->getTotalPageView($analytics, $startDate, $endDate, $filter, $path);
				
				$filterUSA = ['ga:country' => 'United States',
							  'ga:pagePath' => $path];
				$usa_pageviews = $GoogleAnalyticsData->getTotalPageView($analytics, $startDate, $endDate, $filterUSA, $path);
				if(!$usa_pageviews) $usa_pageviews = 0;
				
				$pctValue = $GoogleAnalyticsData->getPercentageValue( $usa_pageviews, $pageviews );

				$data = [
					'article_id' => $article['article_id'],
					'pageviews' => $pageviews,
					'usa_pageviews' => $usa_pageviews,
					'pct_pageviews' =>  $pctValue
				];

				//var_dump($data);
 
				$GoogleAnalyticsData->saveGoogleAnalyticsInformation($data, $month, $year);

				?>
			<tr>
				<td style="min-width: 40rem">><?php echo $path; ?></td>
				<td style="min-width: 12rem"><?php echo $pageviews; ?></td>
				<td style="min-width: 12rem"><?php echo $usa_pageviews; ?></td>
				<td style="min-width: 12rem"><?php echo $pctValue; ?></td>
			</tr>
			<?php }?>
			</tbody>
		</table>
	</body>
</html>