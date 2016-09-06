<?php 


$admin = true;

require_once('../../../assets/php/config.php');


$action = isset($_POST['action']) ? $_POST['action'] : 'new';
$fileName = '';
if($action === "new" && $_POST['articleId'] != '0'){
	 $dirName = $config['image_upload_dir'].'articlesites/puckermob/large/';
	 $fileName = $_POST['articleId'].'_tall.jpg';
}else{
	$dirName =  $config['image_upload_dir'].'articlesites/puckermob/temp/';
	$fileName = 'temp_u_'.$_POST['u_i'].'_tall.jpg';	
}

var_dump($dirName.$fileName, $_POST);

	//Get the file
	$content = file_get_contents($_POST['url']);

	//Store in the filesystem.
	$fp = fopen($dirName.$fileName, "w");
	if(fwrite($fp, $content)){
		fclose($fp);
		return array('statusCode'=> 200, 'message'=> 'Image successfuly saved!');
	}else{
		fclose($fp);
		return array('statusCode'=> 500, 'message'=> 'Image Error. Please Try again!');
	}	
?>