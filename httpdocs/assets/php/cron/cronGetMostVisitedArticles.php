<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require '../config.php';
require '../class.GoogleAnalyticsApi.php';
require '../class.GoogleAnalyticsData.php';

$GoogleAnalyticsApi = new GoogleAnalyticsApi($config);
$GoogleAnalyticsData = new GoogleAnalyticsData($config);

$client = $GoogleAnalyticsApi->connect_to_client();

// Create Google Service Analytics object with our preconfigured Google_Client
$analytics = new Google_Service_Analytics($client);

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$prev_date = date('Y-m-d', strtotime($date .' -1 day'));
$params = [
			'startDate' => $prev_date,
			'endDate' => $prev_date,
			'metrics' => 'ga:pageviews',
			'dimensions' => 'ga:pagePath,ga:pageTitle',
			'sort' => '-ga:pageviews'
			'maxresults' => '7'
			];
?>
<html>

<head>
	<title>GOOGLE API </title>
</head>
	<body>
		<!--<table>
			<thead>
				<td>TITLE</td>
				<td>URL</td>
				<td>PAGEVIEWS</td>
			</thead>
			<tbody>-->
			<?php
			
				$articles = $GoogleAnalyticsData->queryGoogleAnalyticsInformation($analytics, $params);
				
				var_dump($articles);

				?>
			<!--<tr>
				<td style="min-width: 40rem">><?php echo $path; ?></td>
				<td style="min-width: 12rem"><?php echo $pageviews; ?></td>
				<td style="min-width: 12rem"><?php echo $usa_pageviews; ?></td>
				<td style="min-width: 12rem"><?php echo $pctValue; ?></td>
			</tr>
			
			</tbody>
		</table>-->
	</body>
</html>