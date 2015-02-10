<?php
// api dependencies
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
require '../vendor/autoload.php';

// create client object and set app name
$client = new Google_Client();
$client->setApplicationName('Puckermob'); // name of your app

// set assertion credentials
$client->setAssertionCredentials(
    new Google_Auth_AssertionCredentials(
        '381980412538-miirrrqn778q2qtmrp1fr20japvh3c8e@developer.gserviceaccount.com',
        array('https://www.googleapis.com/auth/analytics.readonly'),
       	file_get_contents('keys.txt') // keyfile you downloaded
     
    )
);
// other settings
$client->setClientId('381980412538-miirrrqn778q2qtmrp1fr20japvh3c8e.apps.googleusercontent.com'); // from API console

// create service and get data
$service = new Google_Service_Analytics($client);
var_dump($service->management_accounts->listManagementAccounts()); die;
var_dump($service->management_accounts->listManagementAccounts());
?>