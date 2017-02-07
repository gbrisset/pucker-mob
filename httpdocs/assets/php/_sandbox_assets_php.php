

<?php 
//include ('config.php');

	$localIp = 'localhost';
	$directory = 'pucker-mob';
	//$root_directory =   $localIp . '/' . $directory . '/';
	$root_directory =  $_SERVER['DOCUMENT_ROOT'] . '/';
	


	$config = array(
		'page_id' => 1,
		'articlepageid' => 1,

		'host' => 'localhost',
		'user' => 'root',
		'pass' => 'root',
		'main_db' => 'pucker_mob',	

		'this_url' => $root_directory .'httpdocs/',
		'this_admin_url' => $root_directory .'httpdocs/admin/',
		'shared_url' => $root_directory ,
		'image_url' => $root_directory .'subdomains/images/httpdocs/',	

		'include_path' => $root_directory .'httpdocs/assets/includes/',
		
		'include_path_admin' => $root_directory .'httpdocs/admin/assets/includes/',
		'image_path_admin' => $root_directory .'httpdocs/admin/assets/img/',
		
		'template_path' => $root_directory .'httpdocs/templates/',
		
		'shared_include' => $root_directory .'httpdocs/assets/includes/',
		'shared_css' => $root_directory .'httpdocs/assets/css/',
		'shared_scss' => $root_directory .'httpdocs/assets/scss/',
		'assets_path' => $root_directory .'httpdocs/assets/php/',
	
		'image_upload_dir' => $root_directory .'subdomains/images/httpdocs/'
		
	);




echo "<br/>" . $_SERVER['DOCUMENT_ROOT'] ;
echo "<br/>";
echo "<br/>". $config['assets_path'].'MPShared.php';
echo "<br/>";
echo "<br/>". $config['assets_path'].'MPNavigation.php';
echo "<br/>";
echo "<pre>";
print_r($config);
echo "</pre>";

 ?>


