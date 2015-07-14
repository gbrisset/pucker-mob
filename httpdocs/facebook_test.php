<?php 
// Configurations
$access_token = 'CAACEdEose0cBACr91WRUjSikUUwrkdxN3xhVZCoYbZCmLy361QIqT2nfd6V1azqKpM3jIoJeaQTekMgZA0iJY9jsidZCYIt6UmWyZAUsNtrwXogKii14AfOzKM1jH948Tkbh44iCL6KcCUHgFOGIkaxZBquXdAJPUUdz6fUjud1qGOfJYxVA7LaxMWJoruZBr467woNQ7uJ2a6DcooSJCZAY';
$app_id = '781998645209691';
$app_secret = 'b6e49247747c6c667c6dfb167dc0ea70';
// should begin with "act_" (eg: $account_id = 'act_1234567890';)
$account_id = 'act_10153089858892936';

define('SDK_DIR', __DIR__ ); // Path to the SDK directory
$loader = include SDK_DIR.'/vendor/autoload.php';


if (is_null($access_token) || is_null($app_id) || is_null($app_secret)) {
  throw new \Exception(
    'You must set your access token, app id and app secret before executing'
  );
}

if (is_null($account_id)) {
  throw new \Exception(
    'You must set your account id before executing');
}

use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;

Api::init($app_id, $app_secret, $access_token);

// Create the CurlLogger
$logger = new CurlLogger();

// To write to a file pass in a file handler
// $logger = new CurlLogger(fopen('test','w'));

// If you need to escape double quotes, use the following - useful for docs
$logger->setEscapeLevels(1);

// Hide target ids and tokens
$logger->setShowSensitiveData(false);

// Attach the logger to the Api instance
Api::instance()->setLogger($logger);

use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Fields\AdAccountFields;

$account = (new AdAccount($account_id))->read(array(
  AdAccountFields::ID,
  AdAccountFields::NAME,
  AdAccountFields::ACCOUNT_STATUS
));

?>