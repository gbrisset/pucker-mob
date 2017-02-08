<?php

// ***********************************************************************************************************
// ***********************************************************************************************************
// ******************** GENERIC SETTINGS     *****************************************************************
// ***********************************************************************************************************
// ***********************************************************************************************************

// as of 2017-02-08, both local and live portions contains duplicates and redundant code
// Legacy files were not compatible. 
// Live config could not function on a WAMP server and the Local in GIT repo was not functional on the live site


if(isset($_GET['error']) && $_GET['error'] == true){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

// LOCAL IS SET MANUALLY  - SET TO FALSE BEFORE PUSHING TO PRODUCTION
//$local = true; // LOCAL

$local = false; // LIVE 

$version = "";


// ***********************************************************************************************************
// ***********************************************************************************************************
// **************************   LOCAL WAMP  LOCAL WAMP  LOCAL WAMP *******************************************
// ***********************************************************************************************************
// ***********************************************************************************************************

if($local){
		//error_reporting(E_ALL);
	//	ini_set('display_errors', '1');


	define("DB_SERVER", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "root");
	define("DB_NAME", "pucker_mob");

	define("MAIL_HOST", "smtp.gmail.com");
	define("MAIL_USER", "info@sequelmediainternational.com");
	define("MAIL_PASSWORD", "sequel4bria");
	define("MAIL_ENCRYPTION", "tls");
	define("MAIL_PORT", 25);
	define("IMAGE_UPLOAD_DIR", dirname(dirname(dirname(dirname(__FILE__))))."/subdomains/images/httpdocs/articlesites/puckermob/");

	/*MAIL CHIMP SETTINGS*/
	define("MAIL_CHIMP_API", "9c1095ef61908ad4eab064e7e2c88e24-us10");
	define("MAIL_CHIMP_SUBS_LIST", "c4b5f70bb0ΩA	vcq3g4fgsfzdsexzw");	

	$localIp = 'localhost';
	$directory = 'pucker-mob';
	// $root_directory =   '' . $localIp . '/' . $directory . '/';

	//this does work because a virtual host has been set on WAMP
	$root_directory =  $_SERVER['DOCUMENT_ROOT'] . '/';
	//$root_directory =   '/';
	
	
	$config = array(
		'page_id' => 1,
		'articlepageid' => 1,

		'host' => 'localhost',
		'user' => 'root',
		'pass' => 'root',
		'main_db' => 'pucker_mob',	


		'this_url' => '/httpdocs/', //HACK VERSION
		'this_admin_url' => '/httpdocs/admin/', //HACK VERSION
		'shared_url' => $root_directory ,
		'image_url' => $root_directory .'subdomains/images/httpdocs/',	

		'include_path' => $root_directory .'httpdocs/assets/includes/',
		
		'include_path_admin' => $root_directory .'httpdocs/admin/assets/includes/',
		'image_path_admin' => $root_directory .'httpdocs/admin/assets/img/',
		
		'template_path' => $root_directory .'httpdocs/assets/templates/',
		
		'shared_include' => $root_directory .'httpdocs/assets/includes/',
		'shared_css' => $root_directory .'httpdocs/assets/css/',
		'shared_scss' => $root_directory .'httpdocs/assets/scss/',
		'assets_path' => $root_directory .'httpdocs/assets/php/',
		
		'image_upload_dir' => $root_directory .'httpdocs/subdomains/images/httpdocs/'
		
	);


	
	$config['memcacheprefix'] = 'puckermob_'.$config['articlepageid'];
	$config['cp_url'] = 'http://'.$localIp.'/'.$directory.'/subdomains/cp/httpdocs/';

// var_dump($config);


	require_once  'MPShared.php';
	require_once  'class.Connector.php';
	require_once  'class.DatabaseObject.php'; 
	
	require_once  'MCAPI.class.php';
	require_once  'MPHelpers.php';
	require_once  'MPArticle.php';

	require_once  'MPNavigation.php';
	require_once  'MPUriHelper.php';

	require_once  'class.pagination.php';

	require_once  'class.PageList.php';	
	require_once  'class.PageListItem.php';
	require_once  'class.ArticleList.php';

	require_once  'PHPMailerAutoload.php';
	require_once  'class.phpmailer.php';	
	require_once  'class.pop3.php';	
	require_once  'class.smtp.php';	
	require_once  'mobile-detect.php';

	/*MAIL CHIMP CLASSES*/
	require_once  'MailChimp.php';
	require_once  'Mailchimp/Lists.php';

	require_once  'MPArticleAdmin.php';
	require_once  'MPArticleAdminController.php';
	require_once  'class.recaptchalib.php';
	require_once  'class.FollowAuthor.php';

	require_once  'class.FacebookDebugger.php';
	require_once  'class.Helpers.php'; 

	if(isset($admin) && $admin){
		require_once  'class.User.php';
		require_once  'class.Contributor.php';
		require_once  'class.ContributorEarnings.php';
		require_once  'class.Dashboard.php';
		require_once  'class.ManageAdminDashboard.php';
		require_once  'class.PromoteArticles.php';
		
		require_once  'class.Incentives.php';
		require_once  'class.Incentives.php';
		
		require_once  'class.AdMatching.php';
		require_once  'class.OrderAds.php';
		require_once  'class.AdMatchingTransactions.php';
	}//if(isset($admin)

// This part below was supposed to be common to both local and live but has discrepencies
setlocale(LC_MONETARY, 'en_US');

$MPNavigation = new MPNavigation($config); 
$mpArticle = new MPArticle($config);
$config['catid'] = $mpArticle->data['cat_id'];
$mpShared = new MPShared($config);
$mpHelpers = new MPHelpers();
$uriHelper = new MPUriHelper( $config['this_url'] );
$MailChimp = new Mailchimp( MAIL_CHIMP_API );
$adminController = new MPArticleAdminController(array('config' => $config, 'mpArticle' => $mpArticle));
$mpArticleAdmin = new MPArticleAdmin($config, $mpArticle, null, $adminController);
$dashboard = new Dashboard($config);

$follow = new FollowAuthor($config);

$mpHelpers->start_session();
$detect = new Mobile_Detect;
//$mpHelpers->geotargeting();


//recaptcha public key
define("RECAPTCHAPUBLICKEY", "6LeHLQETAAAAAM6vFkge8SKZotD_1bkDcUQhbr_b");
define("RECAPTCHASECRETKEY", "6LeHLQETAAAAACFwIDyF4J6H929qbmGiYS6E6ATo");

	
}else{


// ***********************************************************************************************************
// ***********************************************************************************************************
// **************************   LIVE PRODUCTION SITE  LIVE PRODUCTION SITE  **********************************
// ***********************************************************************************************************
// ***********************************************************************************************************


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
	}//end if($admin)

	date_default_timezone_set('America/New_York');


// This part below was supposed to be common to both local and live but has discrepencies
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


}// end if($local)


// ***********************************************************************************************************
// ***********************************************************************************************************
// ************************* END OF CONFIG END OF CONFIG END OF CONFIG END OF CONFIG *************************
// ***********************************************************************************************************
// ***********************************************************************************************************


/* ---------------------------------------------------------------------------------- */
/* ---------------------------------------------------------------------------------- */
/* -------- GB DEBUG FUNCTIONS 2017-02-03 ------------------------------------------- */
/* ---------------------------------------------------------------------------------- */
/* ---------------------------------------------------------------------------------- */

/* ---------------------------------------------------------------------------------- */
/* -------- CLASS - DEV DEBUG TOOL -------------------------------------------------- */
/* ---------------------------------------------------------------------------------- */

// This is a temporary import  during the transition period - will be integrated or suppressed in the future

//$ddd = new debug($var,0); $ddd->show();exit;

class debug{

 public $s;
 public $k;
 public $i;
 public $o;
 
    function __construct($string,$skin=3) {
						 $this->s = $string;
						 $this->k = $skin;
		}//end function __construct

    function show(){
						 switch($this->k){
    						 case 0:
    						 $this->i = "color:#ffffff;background-color:#009900; ";//Green
    						 break;
    						 case 1:
    						 $this->i = "color:#ffffff;background-color:#ff0000; "; //Red
    						 break;
    						 case 2:
    						 $this->i = "color:#dddddd;background-color:#888888; "; //Dark
    						 break;
    						 default:
    						 $this->i = "color:#ff0000;background-color:#ffff00; ";//Yellow
						 }//end switch...
						 
       
			 if(is_array($this->s)===true){
            echo "<div style=\"" . $this->i. " padding-left:20px;\"><pre>";
            echo print_r($this->s);
            echo "</pre></div>";
			 }else{
    			  $this->o= "<br /><span style=\"" . $this->i. " padding:5px;\">DEBUG :: ".strtotime("now") . " :: " . $this->s . "</span><br />";
            echo  $this->o;
			 }//end if
	 
						 
		}//end function show()

}// end class debug
// -------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------


/* ---------------------------------------------------------------------------------- */
/* ------- FUNCTION -  DEBUG MESSAGES FOR LIVE DIES --------------------------------- */
/* ---------------------------------------------------------------------------------- */


function die_msg($msg){

    $a = date("m");
    $b = date("d");
    $c = "1625";
    $q = $_SERVER["QUERY_STRING"];
    $s  = strpos($q, "$c$a$b");

    if (DEV_SITE) {
        return $msg;
        }else{
        if ($s === false) return "NOPE"; else  return $msg; 
		}//end if
}//end function
// -------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------



?>