<?php
// api dependencies
error_reporting(E_ALL);
ini_set('display_errors', '1');

require '../vendor/autoload.php';
require_once('../vendor/google/apiclient/src/Google/Client.php');
require_once('../vendor/google/apiclient/src/Google/Service/Analytics.php');


// set assertion credentials
$serviceClientId = '381980412538-c1qc3h4dh2chs14fu639pkfptppkvjd1.apps.googleusercontent.com';
$serviceAccountName = '381980412538-c1qc3h4dh2chs14fu639pkfptppkvjd1@developer.gserviceaccount.com';
$scopes = array('https://www.googleapis.com/auth/analytics.readonly');
$p12FilePath = '../puckermob-c7106c003a34.p12';


$client = new Google_Client();
//$client->setAssertionCredentials($googleAssertionCredentials);
$client->setClientId($serviceClientId);
$client->setApplicationName("puckermob");
$client->setAccessType('offline');

if (isset($_SESSION['service_token'])) {
  $client->setAccessToken($_SESSION['service_token']);
}
$key = file_get_contents($p12FilePath);

$googleAssertionCredentials = new Google_Auth_AssertionCredentials( $serviceAccountName,  $scopes, $key );

$client->setAssertionCredentials($googleAssertionCredentials);



// Create Google Service Analytics object with our preconfigured Google_Client
$analytics = new Google_Service_Analytics($client);

// Add Analytics View ID, prefixed with "ga:"
$analyticsViewId    = 'ga:88041867';

$startDate          = '2015-02-01';
$endDate            = '2015-02-15';
$metrics            = 'ga:pageviews';

$data = $analytics->data_ga->get($analyticsViewId, $startDate, $endDate, $metrics, array(
    'dimensions'    => 'ga:pageviews',
    'filters'       => '',
    'sort'          => '-ga:pageviews'
));
var_dump($analytics->data_ga);
//ga:pagePath==/lifestyle/14-things-only-overthinkers-will-understand*/
var_dump($data);
// Data 
$items = $data->getRows();
var_dump($items);

?>