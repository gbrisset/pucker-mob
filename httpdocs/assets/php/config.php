<?php
$local = 1;
$version = "";

if($local)
{
	define("DB_SERVER", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "root");
	define("DB_NAME", "pucker_mob_con_2");

	define("MAIL_HOST", "smtp.gmail.com");
	define("MAIL_USER", "info@sequelmediagroup.com");
	define("MAIL_PASSWORD", "sequel4bria");
	define("MAIL_ENCRYPTION", "tls");
	define("MAIL_PORT", 25);
	define("IMAGE_UPLOAD_DIR", dirname(dirname(dirname(dirname(__FILE__))))."/subdomains/images/httpdocs/articlesites/puckermob/");

	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');

	$localIp = 'localhost';
	$directory = 'projects/pucker-mob/';
	
	$config = array(
		//'ispod' => 0,
		//'networkid' => 0,
		//'catid' => 0,
		'articlepageid' => 1,
		//'legacypodurl' => 1,
		
		'host' => 'localhost',
		'user' => 'root',
		'pass' => 'root',
		'main_db' => 'pucker_mob',

		 /*Syndication DB Connection*/
        //'syn_host' => 'localhost',
		//'syn_user' => 'root',
       // 'syn_pass' => 'root',
       // 'syn_main_db' => 'pucker_mob',
        /*End of Syndication DB Connection*/

		'include_path' => dirname(dirname(__FILE__)).'/includes/',
		'include_path_admin' => dirname(dirname(dirname(__FILE__))).'/admin/assets/includes/',
		'image_path_admin' => dirname(dirname(dirname(__FILE__))).'/admin/assets/img/',
		'template_path' => dirname(dirname(__FILE__)).'/templates/',
		'shared_include' => dirname(dirname(dirname(__FILE__))).'/assets/includes/',
		'shared_css' => dirname(dirname(dirname(dirname(__FILE__)))).'/assets/css/',
		'shared_scss' => dirname(dirname(dirname(dirname(__FILE__)))).'/assets/scss/',
		'assets_path' =>  dirname(dirname(__FILE__)).'/php/',
	
		'image_upload_dir' => dirname(dirname(dirname(dirname(__FILE__)))).'/subdomains/images/httpdocs/',
		
		'this_url' => 'http://'.$localIp.':8888/'.$directory.'/httpdocs/',
		'this_admin_url' => 'http://'.$localIp.':8888/'.$directory.'/httpdocs/admin/',
	//	'syndication_url' => 'http://'.$localIp.':8888/'.$directory.'/httpdocs-syndication/',
		'shared_url' => 'http://'.$localIp.':8888/'.$directory.'/',
		'image_url' => 'http://'.$localIp.':8888/'.$directory.'/subdomains/images/httpdocs/',
		//'http://images.puckermob.com/',//
		//'main_url' => 'http://'.$localIp.':8888/'.$directory.'/httpdocs-html/',
		//'category_url' => 'http://'.$localIp.':8888/'.$directory.'/httpdocs-categories/',
		//'pod_url' => 'http://'.$localIp.':8888/'.$directory.'/httpdocs-pods/',
		//'mininetwork_url' => 'http://'.$localIp.':8888/'.$directory.'/httpdocs-mininetworks/'		
				
	);

	
	$config['memcacheprefix'] = 'puckermob_'.$config['articlepageid'];


	$config['cp_url'] = 'http://'.$localIp.'/'.$directory.'/subdomains/cp/httpdocs/';
	require_once $config['assets_path'].'/MPShared.php';
	require_once $config['assets_path'].'/class.Connector.php';
	require_once $config['assets_path'].'/class.DatabaseObject.php';
	require_once $config['assets_path'].'/class.Bug.php';
	require_once $config['assets_path'].'/class.SlideShow.php';
	
	require_once $config['assets_path'].'/MCAPI.class.php';
	require_once $config['assets_path'].'/MPHelpers.php';
	require_once $config['assets_path'].'/MPArticle.php';
	require_once $config['assets_path'].'/MPVideoShows.php';
	require_once $config['assets_path'].'/MPNavigation.php';
	require_once $config['assets_path'].'/MPUriHelper.php';

	require_once $config['assets_path'].'/class.pagination.php';
	//require_once dirname($config['shared_include']).'/php/class.Search.php';
	require_once $config['assets_path'].'/class.askTheChef.php';

	require_once $config['assets_path'].'/class.PageList.php';	
	require_once $config['assets_path'].'/class.PageListItem.php';
	require_once $config['assets_path'].'/class.ArticleList.php';

	require_once $config['assets_path'].'/PHPMailerAutoload.php';
	require_once $config['assets_path'].'/class.phpmailer.php';	
	require_once $config['assets_path'].'/class.pop3.php';	
	require_once $config['assets_path'].'/class.smtp.php';	



	require_once $config['assets_path'].'/mobile-detect.php';


	//if(isset($admin) && $admin) require_once $config['assets_path'].'/MPArticleAdmin.php';

	if(isset($admin) && $admin){
		require_once $config['assets_path'].'/MPArticleAdmin.php';
		require_once $config['assets_path'].'/class.ManageAdminDashboard.php';
		require_once $config['assets_path'].'/MPArticleAdminController.php';
		require_once $config['assets_path'].'/class.recaptchalib.php';
	}
	
}else{

	define("MAIL_HOST", "ssl://smtp.gmail.com");
	define("MAIL_USER", "info@sequelmediagroup.com");
	define("MAIL_PASSWORD", "sequel4bria");
	define("MAIL_ENCRYPTION", "tls");		
	define("MAIL_PORT", 465);
	define("IMAGE_UPLOAD_DIR", "/var/www/storage/images/mypodnetwork/articlesites/simpledish/");

	define("DB_SERVER", "192.168.0.1");
	define("DB_USER", "seq_db_user");
	define("DB_PASS", "#!14sd2dbFgMr#");
	define("DB_NAME", "simpledish");		

	$config = array(
		'ispod' => 0,
		'networkid' => 0,
		'catid' => 0,
		'articlepageid' => 1,
		'legacypodurl' => 1,
		
		'host' => '192.168.0.1',
		'user' => 'seq_db_user',
		'pass' => '#!14sd2dbFgMr#',
		'main_db' => 'simpledish_network',	

		/*Syndication DB Connection*/
        'syn_host' => '192.168.0.1',
		'syn_user' => 'seq_db_user',
        'syn_pass' => '#!13sd2dbFgMr#',
        'syn_main_db' => 'mypod_network',
        /*End of Syndication DB Connection*/
		
		'include_path' => dirname(dirname(__FILE__)).'/includes/',
		'include_path_admin' => dirname(dirname(dirname(__FILE__))).'/admin/assets/includes/',
		'template_path' => dirname(dirname(__FILE__)).'/templates/',
		'shared_include' => dirname(dirname(__FILE__)).'/includes/',
		'shared_css' => dirname(dirname(__FILE__)).'/css/',
		'shared_scss' => dirname(dirname(__FILE__)).'/scss/',
		
		'image_upload_dir' => '/var/www/storage/images/mypodnetwork/',
		
		'this_url' => 'http://www.puckermob.com/',
		'this_admin_url' => 'http://www.puckermob.com/admin/',
		'image_url' => 'http://images.puckermob.com/',
		
		//'main_url' => 'http://www.mypodstudios.com/',
		////'category_url' => '',
		//'pod_url' => '',
		//'mininetwork_url' => '',
		
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

	if(isset($admin) && $admin){
		require_once dirname(__FILE__).'/MPArticleAdmin.php';
		require_once dirname(__FILE__).'/MPArticleAdminController.php';
		require_once dirname(__FILE__).'/class.Dashboard.php';
		require_once dirname(__FILE__).'/class.ManageAdminDashboard.php';
		require_once $config['assets_path'].'/class.recaptchalib.php';

	}

	date_default_timezone_set('America/New_York');
}

$MPNavigation = new MPNavigation($config);
$askTheChef = new AskTheChef($config);
$mpArticle = new MPArticle($config);
$config['catid'] = $mpArticle->data['cat_id'];
$mpShared = new MPShared($config);
$mpHelpers = new MPHelpers();
$uriHelper = new MPUriHelper( $config['this_url'] );
//$mpVideoShows = new MPVideoShows($config);

if(isset($admin) && $admin){
	$adminController = new MPArticleAdminController(array('config' => $config, 'mpArticle' => $mpArticle));
	$mpArticleAdmin = new MPArticleAdmin($config, $mpArticle, null, $adminController);
	$dashboard = new Dashboard($config);
}


$mpHelpers->start_session();
$detect = new Mobile_Detect;
//recaptcha public key
$publickey = "6LeHLQETAAAAAM6vFkge8SKZotD_1bkDcUQhbr_b";

/*
Begin Dependancies/Soft Links:

	Taken care of in build script:
		
	To be added to build script:
		
		
End Dependancies/Soft Links 
*/
?>