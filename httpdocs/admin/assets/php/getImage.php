<?php 


$admin = true;

require_once('../../../assets/php/config.php');


$action = isset($_POST['action']) ? $_POST['action'] : 'new';
$fileName = '';
$width = $height = 0;
if($action === "new" && $_POST['articleId'] != '0'){
	 $dirName = $config['image_upload_dir'].'articlesites/puckermob/large/';
	 $fileName = $_POST['articleId'].'_tall.jpg';
}else{
	$dirName =  $config['image_upload_dir'].'articlesites/puckermob/temp/';
	$fileName = 'temp_u_'.$_POST['u_i'].'_tall.jpg';	
}

	$size = getimagesize($_POST['url']);
	if($size){
		$width = $size[0];
		$height = $size[1];
	}

	if($width == 784 && $height == 431){
		//Get the file
		$content = file_get_contents($_POST['url']);

		//Store in the filesystem.
		$fp = fopen($dirName.$fileName, "w");
		if(fwrite($fp, $content)){
			fclose($fp);

			$result = array('statusCode'=> 200, 'message'=> 'Image successfuly saved!');
		}else{
			fclose($fp);
			$result =  array('statusCode'=> 500, 'message'=> 'There was an error creating the image. Please Try again!');
		}	
	}else{
		$result =  array('statusCode'=> 500, 'field'=>'article_image', 'message' => 'Image dimensions must be 784x431px');
	}

	echo json_encode($result);
	
?>