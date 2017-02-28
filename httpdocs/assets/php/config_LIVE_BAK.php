<?php
$local = 0;
$version = "";


if(isset($_GET['error']) && $_GET['error'] == true){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

//if(isset($_GET['server']) && $_GET['server'] == true){
//	var_dump($_SERVER);

//}

if($local)
{
	define("DB_SERVER", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "6Radames9");
	define("DB_NAME", "simpledish");

	define("MAIL_HOST", "smtp.gmail.com");
	define("MAIL_USER", "info@sequelmediainternational.com");
	define("MAIL_PASSWORD", "sequel4bria");
	define("MAIL_ENCRYPTION", "tls");
	define("MAIL_PORT", 25);
	define("IMAGE_UPLOAD_DIR", dirname(dirname(dirname(dirname(__FILE__))))."/subdomains/images/httpdocs/articlesites/puckermob/");

	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	$localIp = '192.168.1.22';
	$localIp = 'localhost';
	
	$config = array(
		'ispod' => 0,
		'networkid' => 0,
		'catid' => 0,
		'articlepageid' => 1,
		'legacypodurl' => 1,
		
		'host' => '192.168.100.195',
		'user' => 'msost',
		'pass' => 'Gn3cG&P,13myp0d!#',
		'main_db' => 'mypod_network',

		 /*Syndication DB Connection*/
        'syn_host' => 'localhost',
		'syn_user' => 'root',
        'syn_pass' => 'root',
        'syn_main_db' => 'mypod_network',
        /*End of Syndication DB Connection*/
		
		'include_path' => dirname(dirname(__FILE__)).'/includes/',
		'include_path_admin' => dirname(dirname(dirname(__FILE__))).'/admin/assets/includes/',
		'image_path_admin' => dirname(dirname(dirname(__FILE__))).'/admin/assets/img/',
		'shared_include' => dirname(dirname(dirname(dirname(__FILE__)))).'/sharedassets/assets/includes/',
		'shared_css' => dirname(dirname(dirname(dirname(__FILE__)))).'/sharedassets/assets/css/',
		'shared_scss' => dirname(dirname(dirname(dirname(__FILE__)))).'/sharedassets/assets/scss/',

		'image_upload_dir' => dirname(dirname(dirname(dirname(__FILE__)))).'/subdomains/images/httpdocs/',

		
		'this_url' => 'http://www.puckermob.com/',
		'this_admin_url' => 'http://www.puckermob.com/admin/',
		'syndication_url' => 'http://'.$localIp.':8888/mypodnetwork/httpdocs-syndication/',
		'shared_url' => 'http://'.$localIp.':8888/mypodnetwork/sharedassets/',
		'image_url' => 'http://images.puckermob.com/',
		
		'main_url' => 'http://www.mypodstudios.com/',
		'category_url' => 'http://'.$localIp.':8888/mypodnetwork/httpdocs-categories/',
		'pod_url' => 'http://'.$localIp.':8888/mypodnetwork/httpdocs-pods/',
		'mininetwork_url' => 'http://'.$localIp.':8888/mypodnetwork/httpdocs-mininetworks/',
				
	);

	$config['cp_url'] = 'http://'.$localIp.':8888/mypodnetwork/subdomains/cp/httpdocs/';
	require_once dirname($config['shared_include']).'/php/MPShared.php';
	require_once dirname($config['shared_include']).'/php/MCAPI.class.php';
	require_once dirname($config['shared_include']).'/php/MPHelpers.php';
	require_once dirname($config['shared_include']).'/php/MPArticle.php';
	require_once dirname($config['shared_include']).'/php/MPUriHelper.php';
	if(isset($admin) && $admin){
		require_once dirname($config['shared_include']).'/php/MPArticleAdmin.php';
		require_once dirname($config['shared_include']).'/php/MPArticleAdminController.php';
		require_once $config['assets_path'].'/class.recaptchalib.php';
	}
}else{

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
	
	/*MAIL CHIMP SETTINGS*/
	define("MAIL_CHIMP_API", "9c1095ef61908ad4eab064e7e2c88e24-us10");
	define("MAIL_CHIMP_SUBS_LIST", "c4b5f70bb0");	

	$config = array(
		'ispod' => 0,
		'networkid' => 0,
		'catid' => 0,
		'articlepageid' => 1,
		'legacypodurl' => 1,
		
		'host' => '192.168.0.4',
		'user' => 'seq_db_user',
		'pass' => '#!14sd2dbFgMr#',
		'main_db' => 'pucker_mob',	

		/*Syndication DB Connection*/
        'syn_host' => '192.168.0.4',
		'syn_user' => 'seq_db_user',
        'syn_pass' => '#!14sd2dbFgMr#',
        'syn_main_db' => 'mypod_network',
        /*End of Syndication DB Connection*/
		
		'include_path' => dirname(dirname(__FILE__)).'/includes/',
		'include_path_admin' => dirname(dirname(dirname(__FILE__))).'/admin/assets/includes/',
		'image_path_admin' => dirname(dirname(dirname(__FILE__))).'/admin/assets/img/',
		'template_path' => dirname(dirname(__FILE__)).'/templates/',
		'shared_include' => dirname(dirname(__FILE__)).'/includes/',
		'shared_css' => dirname(dirname(__FILE__)).'/css/',
		'shared_scss' => dirname(dirname(__FILE__)).'/scss/',
		
		'image_upload_dir' => '/var/www/storage/images/mypodnetwork/',
		
		'this_url' => 'http://www.puckermob.com/',
		'this_admin_url' => 'http://www.puckermob.com/admin/',
		'image_url' => 'http://images.puckermob.com/',
		
		'main_url' => 'http://www.sequelmediainternational.com/',
		'category_url' => '',
		'pod_url' => '',
		'mininetwork_url' => '',
		
	);
	$config['memcacheprefix'] = '_'.$config['articlepageid'];

	$config['shared_url'] = $config['this_url'];
	$config['cp_url'] = $config['this_url'].'admin/';
	
	require_once dirname(__FILE__).'/MPShared.php';
	require_once dirname(__FILE__).'/MCAPI.class.php';
	require_once dirname(__FILE__).'/class.pagination.php';
	require_once dirname(__FILE__).'/class.askTheChef.php';

	require_once dirname(__FILE__).'/class.Connector.php';
	require_once dirname(__FILE__).'/class.DatabaseObject.php';	
	require_once dirname(__FILE__).'/class.PageList.php';	
	require_once dirname(__FILE__).'/class.PageListItem.php';
	require_once dirname(__FILE__).'/class.Bug.php';
	require_once dirname(__FILE__).'/class.ArticleList.php';
	require_once dirname(__FILE__).'/class.SlideShow.php';

	require_once dirname(__FILE__).'/PHPMailerAutoload.php';
	require_once dirname(__FILE__).'/class.phpmailer.php';	
	require_once dirname(__FILE__).'/class.pop3.php';	
	require_once dirname(__FILE__).'/class.smtp.php';	

	require_once dirname(__FILE__).'/MPHelpers.php';
	require_once dirname(__FILE__).'/MPArticle.php';
	require_once dirname(__FILE__).'/MPNavigation.php';
	require_once dirname(__FILE__).'/MPUriHelper.php';
	require_once dirname(__FILE__).'/MPVideoShows.php';

	require_once dirname(__FILE__).'/mobile-detect.php';

	require_once dirname(__FILE__).'/class.Search.php';

	/*MAIL CHIMP CLASSES*/
	require_once dirname(__FILE__).'/MailChimp.php';
	require_once dirname(__FILE__).'/Mailchimp/Lists.php';

	require_once dirname(__FILE__).'/MPArticleAdmin.php';
	require_once dirname(__FILE__).'/MPArticleAdminController.php';
	require_once dirname(__FILE__).'/class.FollowAuthor.php';
	require_once dirname(__FILE__).'/class.recaptchalib.php';
	require_once dirname(__FILE__).'/class.Dashboard.php';
	
	//require_once dirname(__FILE__).'/class.GoogleAnalyticsApi.php';
	//if(isset($admin) && $admin){
		require_once dirname(__FILE__).'/class.ManageAdminDashboard.php';
	//}

	require_once dirname(__FILE__).'/class.Helpers.php';
	if($admin){
		require_once dirname(__FILE__).'/class.User.php';
		require_once dirname(__FILE__).'/class.Notification.php';
		require_once dirname(__FILE__).'/class.Contributor.php';
		require_once dirname(__FILE__).'/class.ContributorEarnings.php';
		require_once dirname(__FILE__).'/class.HotTopics.php';
		require_once dirname(__FILE__).'/class.PromoteArticles.php';
		require_once dirname(__FILE__).'/class.Incentives.php';
		require_once dirname(__FILE__).'/class.AdMatching.php';
		require_once dirname(__FILE__).'/class.OrderAds.php';
		require_once dirname(__FILE__).'/class.AdMatchingTransactions.php';



	}

	date_default_timezone_set('America/New_York');
}

setlocale(LC_MONETARY, 'en_US');

$MPNavigation = new MPNavigation($config);
$askTheChef = new AskTheChef($config);
$mpArticle = new MPArticle($config);
$config['catid'] = $mpArticle->data['cat_id'];
$mpShared = new MPShared($config);
$mpHelpers = new MPHelpers();
$uriHelper = new MPUriHelper( $config['this_url'] );
$mpVideoShows = new MPVideoShows($config);
$MailChimp = new Mailchimp( MAIL_CHIMP_API );
$adminController = new MPArticleAdminController(array('config' => $config, 'mpArticle' => $mpArticle));
$mpArticleAdmin = new MPArticleAdmin($config, $mpArticle, $mpVideoShows, $adminController);
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
Begin Dependancies/Soft Links:

	Taken care of in build script:
		
	To be added to build script:
		
		
End Dependancies/Soft Links 
*/
?>
