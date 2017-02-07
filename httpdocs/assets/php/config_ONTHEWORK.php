<?php
$version = "";

///all that stuff needs to be revised
//-------------------------------------


// // Add local detection for MAMP or other WAMP configuration
// switch ($_SERVER['DOCUMENT_ROOT']) {
// 	case "C:/wamp64/www":
// 		$local = true; 
// 		$local_platform = "WAMP64";
// 		$directory = 'pucker-mob'; //that should be the directory created when cloning Git repo locally
// 		break;
// /*
// 	case "Set this option for MAMP":
// 		$local = true; 
// 		$local_platform = "MAMP";
// 		$this_site_folder = "pucker-mob"; 
// 		$directory = 'pucker-mob'; //that should be the directory created when cloning Git repo locally
// 		break;
// */
// 	case "/var/www/vhosts/puckermob.com/httpdocs":
// 		$local = false; 
// 		$local_platform = "";
// 		$directory = "puckermob.com";
// 		break;

// 	default:
// 		$local = false; 
// 		$local_platform = "";
// 		$directory = "puckermob.com";
// }//end switch $_SERVER['DOCUMENT_ROOT'] 


// if(isset($_GET['error']) && $_GET['error'] == true){error_reporting(E_ALL);	ini_set('display_errors', '1');} 


// //--------------------------------------------------------------------------------------------
// if($local){

// 	switch ($local_platform) {
// 	 	case 'MAMP':
// 			$localIp = 'localhost';//Change to 127.0.0.1 if necessary
// 			$port = ':8888';
// 	 		break;
	 	
// 	 	case 'WAMP64':
// 			$localIp = 'localhost';//Change to 127.0.0.1 if necessary
// 			$port = '';
// 	 		break;

// 	 	default:
// 	 		//TBD
// 	 		//TBD
// 	 		//TBD
// 	 		//TBD
// 	}//end switch

// 	$config['this_url'] = "http://$localIp$port/$directory/httpdocs/";
// 	$config['this_admin_url'] = "http://$localIp$port/$directory/httpdocs/admin/";
// 	$config['shared_url'] = "http://$localIp$port/$directory/";
// 	$config['image_url'] = "http://$localIp$port/$directory/subdomains/images/httpdocs/";

// 	define("PROJECT_HTTPDOCS", $config['this_url']);// e.g.: pucker-mob/httpsdocs
// 	define("PATH_ASSETS_PHP", PROJECT_HTTPDOCS.'/assets/php');// e.g.: pucker-mob/httpsdocs/assets/php


// 	define("MAIL_HOST", "smtp.gmail.com");
// 	define("MAIL_USER", "info@sequelmediainternational.com");
// 	define("MAIL_PASSWORD", "sequel4bria");
// 	define("MAIL_ENCRYPTION", "tls");
// 	define("MAIL_PORT", 25);
// 	define("IMAGE_UPLOAD_DIR", dirname(dirname(dirname(dirname(__FILE__))))."/subdomains/images/httpdocs/articlesites/puckermob/");

// 	define("DB_SERVER", "localhost");
// 	define("DB_USER", "root");
// 	define("DB_PASS", "root");
// 	define("DB_NAME", "pucker_mob");

// 	/*MAIL CHIMP SETTINGS*/
// 	define("MAIL_CHIMP_API", "9c1095ef61908ad4eab064e7e2c88e24-us10");
// 	define("MAIL_CHIMP_SUBS_LIST", "c4b5f70bb0ΩA	vcq3g4fgsfzdsexzw");	

// 	$config['page_id'] = 1;
// 	$config['articlepageid'] = 1;
// 	$config['catid'] = 0;
// 	$config['networkid'] = 0;
// 	$config['legacypodurl'] = 1;

// 	$config['host'] = 'localhost';
// 	$config['user'] = 'root';
// 	$config['pass'] = 'root';
// 	$config['main_db'] = 'pucker_mob';

// 	$config['assets_php_path'] = 	PROJECT_HTTPDOCS.'/assets/php/'; // AS IN LIVE SITE CODE - GB 2017-01-05
// 	$config['assets_path'] = 		PROJECT_HTTPDOCS.'/assets/php/'; // AS IN GIT REPO - GB 2017-01-05

// 	$config['include_path'] = 		PROJECT_HTTPDOCS.'/assets/includes/';
// 	$config['include_path_admin'] = PROJECT_HTTPDOCS.'/admin/assets/includes/';
// 	$config['template_path'] = 		PROJECT_HTTPDOCS.'/assets/templates/';


// 	$config['image_path_admin'] = 	PROJECT_HTTPDOCS.'/admin/assets/img/';
// 	$config['shared_include'] = 	PROJECT_HTTPDOCS.'/assets/includes/';//same as $config['include_path'] ??? - GB 2017-01-03
// 	$config['shared_css'] = 		PROJECT_HTTPDOCS.'/assets/css/';
// 	$config['shared_scss'] =		 PROJECT_HTTPDOCS.'/assets/scss/'; //Does not exist. - is that dynamically generated ?? - GB 2017-01-03

// 	$config['image_upload_dir'] = '/subdomains/images/httpdocs/';
		
	
// 	$config['memcacheprefix'] = 'puckermob_'.$config['articlepageid'];



// 	require_once PATH_ASSETS_PHP.'/MPShared.php';
// 	require_once PATH_ASSETS_PHP.'/class.Connector.php';
// 	require_once PATH_ASSETS_PHP.'/class.DatabaseObject.php';
	
// 	require_once PATH_ASSETS_PHP.'/MCAPI.class.php';
// 	require_once PATH_ASSETS_PHP.'/MPHelpers.php';
// 	require_once PATH_ASSETS_PHP.'/MPArticle.php';

// 	require_once PATH_ASSETS_PHP.'/MPNavigation.php';
// 	require_once PATH_ASSETS_PHP.'/MPUriHelper.php';

// 	require_once PATH_ASSETS_PHP.'/class.pagination.php';

// 	require_once PATH_ASSETS_PHP.'/class.PageList.php';	
// 	require_once PATH_ASSETS_PHP.'/class.PageListItem.php';
// 	require_once PATH_ASSETS_PHP.'/class.ArticleList.php';

// 	require_once PATH_ASSETS_PHP.'/PHPMailerAutoload.php';
// 	require_once PATH_ASSETS_PHP.'/class.phpmailer.php';	
// 	require_once PATH_ASSETS_PHP.'/class.pop3.php';	
// 	require_once PATH_ASSETS_PHP.'/class.smtp.php';	
// 	require_once PATH_ASSETS_PHP.'/mobile-detect.php';

// 	/*MAIL CHIMP CLASSES*/
// 	require_once PATH_ASSETS_PHP.'/MailChimp.php';
// 	require_once PATH_ASSETS_PHP.'/Mailchimp/Lists.php';

// 	require_once PATH_ASSETS_PHP.'/MPArticleAdmin.php';
// 	require_once PATH_ASSETS_PHP.'/MPArticleAdminController.php';
// 	require_once PATH_ASSETS_PHP.'/class.recaptchalib.php';
// 	require_once PATH_ASSETS_PHP.'/class.FollowAuthor.php';

// 	require_once PATH_ASSETS_PHP.'/class.FacebookDebugger.php';
// 	require_once PATH_ASSETS_PHP.'/class.Helpers.php';

// 	if(isset($admin) && $admin){
// 		require_once PATH_ASSETS_PHP.'/class.User.php';
// 		require_once PATH_ASSETS_PHP.'/class.Contributor.php';
// 		require_once PATH_ASSETS_PHP.'/class.ContributorEarnings.php';

// 		require_once PATH_ASSETS_PHP.'/class.Dashboard.php';
// 		require_once PATH_ASSETS_PHP.'/class.ManageAdminDashboard.php';
// 		require_once PATH_ASSETS_PHP.'/class.PromoteArticles.php';

// 		require_once PATH_ASSETS_PHP.'/class.Incentives.php';
// 		require_once PATH_ASSETS_PHP.'/class.AdMatching.php';
// 		require_once PATH_ASSETS_PHP.'/class.OrderAds.php';
// 		require_once PATH_ASSETS_PHP.'/class.AdMatchingTransactions.php';
// 	}// end if

//above is local
//--------------------------------------------------------------------------------------------
}else{
//--------------------------------------------------------------------------------------------
// Below is Remote/Live


/* ************************************************* */
/* ************************************************* */
/* ************************************************* */
/* ************************************************* */
// the below was taken from the functioning CONFIG file from live site
// and cleaned up

// 1 - it will be tested as is
// 2 - then compiled with the local
/* ************************************************* */
/* ************************************************* */
/* ************************************************* */
/* ************************************************* */

	define("MAIL_HOST", "ssl://smtp.gmail.com");
	define("MAIL_USER", "info@sequelmediainternational.com");
	define("MAIL_PASSWORD", "sequel4bria");
	define("MAIL_ENCRYPTION", "tls");		
	define("MAIL_PORT", 465);
	define("IMAGE_UPLOAD_DIR", "/var/www/storage/images/mypodnetwork/articlesites/puckermob/");

	define("DB_SERVER", "192.168.0.4");
	define("DB_USER", "seq_db_user");
	define("DB_PASS", "#!14sd2dbFgMr#");
	define("DB_NAME", "pucker_mob");		
	

$config['ispod'] = 0;
$config['networkid'] = 0;
$config['catid'] = 0;
$config['articlepageid'] = 1;
$config['legacypodurl'] = 1;

$config['host'] = '192.168.0.4';
$config['user'] = 'seq_db_user';
$config['pass'] = '#!14sd2dbFgMr#';
$config['main_db'] = 'pucker_mob';

$config['assets_php_path'] = 	PROJECT_HTTPDOCS.'/assets/php/'; // AS IN LIVE SITE CODE - GB 2017-01-05
//$config['assets_path'] = 		PROJECT_HTTPDOCS.'/assets/php/'; // AS IN GIT REPO - GB 2017-01-05

$config['include_path'] = 		PROJECT_HTTPDOCS.'/assets/includes/';
$config['include_path_admin'] = PROJECT_HTTPDOCS.'/admin/assets/includes/';
$config['template_path'] = 		PROJECT_HTTPDOCS.'/assets/templates/';


$config['image_path_admin'] = 	PROJECT_HTTPDOCS.'/admin/assets/img/';
$config['shared_include'] = 	PROJECT_HTTPDOCS.'/assets/includes/';//same as $config['include_path'] ??? - GB 2017-01-03
$config['shared_css'] = 		PROJECT_HTTPDOCS.'/assets/css/';
$config['shared_scss'] =		 PROJECT_HTTPDOCS.'/assets/scss/'; //Does not exist. - is that dynamically generated ?? - GB 2017-01-03

$config['this_url'] = 'http://www.puckermob.com/';
$config['this_admin_url'] = 'http://www.puckermob.com/admin/';
$config['image_url'] = 'http://images.puckermob.com/';
$config['image_upload_dir'] = '/var/www/storage/images/mypodnetwork/';
$config['shared_url'] = $config['this_url'];
$config['cp_url'] = $config['this_url'].'admin/';


$config['memcacheprefix'] = '_'.$config['articlepageid'];



$config['main_url'] = 'http://www.sequelmediainternational.com/';
$config['category_url'] = '';
$config['pod_url'] = '';
$config['mininetwork_url'] = '';

	
	require_once PATH_ASSETS_PHP.'/MPShared.php';
	require_once PATH_ASSETS_PHP.'/MCAPI.class.php';
	require_once PATH_ASSETS_PHP.'/class.pagination.php';
	require_once PATH_ASSETS_PHP.'/class.askTheChef.php';//any use????

	require_once PATH_ASSETS_PHP.'/class.Connector.php';
	require_once PATH_ASSETS_PHP.'/class.DatabaseObject.php';	
	require_once PATH_ASSETS_PHP.'/class.PageList.php';	
	require_once PATH_ASSETS_PHP.'/class.PageListItem.php';
	require_once PATH_ASSETS_PHP.'/class.Bug.php';
	require_once PATH_ASSETS_PHP.'/class.ArticleList.php';
	require_once PATH_ASSETS_PHP.'/class.SlideShow.php';

	require_once PATH_ASSETS_PHP.'/PHPMailerAutoload.php';
	require_once PATH_ASSETS_PHP.'/class.phpmailer.php';	
	require_once PATH_ASSETS_PHP.'/class.pop3.php';	
	require_once PATH_ASSETS_PHP.'/class.smtp.php';	

	require_once PATH_ASSETS_PHP.'/MPHelpers.php';
	require_once PATH_ASSETS_PHP.'/MPArticle.php';
	require_once PATH_ASSETS_PHP.'/MPNavigation.php';
	require_once PATH_ASSETS_PHP.'/MPUriHelper.php';
	require_once PATH_ASSETS_PHP.'/MPVideoShows.php';

	require_once PATH_ASSETS_PHP.'/mobile-detect.php';

	require_once PATH_ASSETS_PHP.'/class.Search.php';

	/*MAIL CHIMP CLASSES*/
	require_once PATH_ASSETS_PHP.'/MailChimp.php';
	require_once PATH_ASSETS_PHP.'/Mailchimp/Lists.php';

	require_once PATH_ASSETS_PHP.'/MPArticleAdmin.php';
	require_once PATH_ASSETS_PHP.'/MPArticleAdminController.php';
	require_once PATH_ASSETS_PHP.'/class.FollowAuthor.php';
	require_once PATH_ASSETS_PHP.'/class.recaptchalib.php';
	require_once PATH_ASSETS_PHP.'/class.Dashboard.php';
	
	//require_once PATH_ASSETS_PHP.'/class.GoogleAnalyticsApi.php';
	//if(isset($admin) && $admin){
		require_once PATH_ASSETS_PHP.'/class.ManageAdminDashboard.php';
	//}

	require_once PATH_ASSETS_PHP.'/class.Helpers.php';

	if($admin){
		require_once PATH_ASSETS_PHP.'/class.User.php';
		require_once PATH_ASSETS_PHP.'/class.Notification.php';
		require_once PATH_ASSETS_PHP.'/class.Contributor.php';
		require_once PATH_ASSETS_PHP.'/class.ContributorEarnings.php';
		require_once PATH_ASSETS_PHP.'/class.HotTopics.php';
		require_once PATH_ASSETS_PHP.'/class.PromoteArticles.php';
		require_once PATH_ASSETS_PHP.'/class.Incentives.php';
		require_once PATH_ASSETS_PHP.'/class.AdMatching.php';
		require_once PATH_ASSETS_PHP.'/class.OrderAds.php';
		require_once PATH_ASSETS_PHP.'/class.AdMatchingTransactions.php';
	}//end if admin


}//end if $local

//--------------------------------------------------------------------------------------------


	date_default_timezone_set('America/New_York');


setlocale(LC_MONETARY, 'en_US');

$MPNavigation = new MPNavigation($config);
//$askTheChef = new AskTheChef($config);
$mpArticle = new MPArticle($config);
$config['catid'] = $mpArticle->data['cat_id'];
$mpShared = new MPShared($config);
$mpHelpers = new MPHelpers();
$uriHelper = new MPUriHelper( $config['this_url'] );

if ($local){
//	$mpArticleAdmin = new MPArticleAdmin($config, $mpArticle, $adminController);
}else{
	$mpVideoShows = new MPVideoShows($config);
	$MailChimp = new Mailchimp( MAIL_CHIMP_API );
	$mpArticleAdmin = new MPArticleAdmin($config, $mpArticle, $mpVideoShows, $adminController);
}//end if

$adminController = new MPArticleAdminController(array('config' => $config, 'mpArticle' => $mpArticle));

//if(isset($admin) && $admin){

$dashboard = new Dashboard($config);
//}
$follow = new FollowAuthor($config);

$mpHelpers->start_session();
//$mpHelpers->geotargeting();
$detect = new Mobile_Detect;

//recaptcha public key
define("RECAPTCHAPUBLICKEY", "6LeHLQETAAAAAM6vFkge8SKZotD_1bkDcUQhbr_b");
define("RECAPTCHASECRETKEY", "6LeHLQETAAAAACFwIDyF4J6H929qbmGiYS6E6ATo");



session_cache_limiter(false);
header("Access-Control-Allow-Origin: *");

/*
echo "<pre>";
$ccc = get_defined_constants(true); /////TEST print_r(get_defined_constants(true)); /////TEST print_r(get_defined_constants(true)); /////TEST print_r(get_defined_constants(true)); /////TEST print_r(get_defined_constants(true)); /////TEST print_r(get_defined_constants(true)); /////TEST 
print_r($ccc['user']);
print_r($config);
echo $_SERVER['DOCUMENT_ROOT'];
echo "</pre>";

*/
/*
Begin Dependancies/Soft Links:

	Taken care of in build script:
		
	To be added to build script:
		
		
End Dependancies/Soft Links 
*/
?>
