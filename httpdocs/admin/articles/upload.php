<?php

$admin = true;

require_once('../../assets/php/config.php');

$ds = DIRECTORY_SEPARATOR;  //DIRECTORY

$user_id = 0;
if(isset($_POST['u_i'])) $user_id = $_POST['u_i'];

$action = "edit"; 
//IF is from the new article page
if(isset($_POST) && empty($_POST['a_i'] ) ){
	$_POST['a_i'] = 'temp_u_'.$user_id;
	$action = "new";
}

//New article
if($action === "new"){
	if (!empty($_FILES)) { 
	    $updateStatus = 
	    	array_merge($mpArticleAdmin->uploadTempImage($_FILES, [
				'allowedExtensions' => 'png,jpg,jpeg,gif',
				'imgType' => 'article',
				'uploadDirectory' => $config['image_upload_dir'].'articlesites/puckermob/temp/',
				'articleId' => $_POST['a_i'],
				'imgData' => $_POST,
				'whereClause' => '',
				'desWidth' => 784,
				'desHeight' => 431
			]), ['arrayId' => 'article-tall-image-upload-form']);
		}
}else{
//Edit article
	if (!empty($_FILES)) { 
	    $updateStatus = array_merge($mpArticleAdmin->uploadNewImage($_FILES, [
			'allowedExtensions' => 'png,jpg,jpeg,gif',
			'imgType' => 'article',
			'uploadDirectory' => $config['image_upload_dir'].'articlesites/puckermob/large/',
			'articleId' => $_POST['a_i'],
			'imgData' => $_POST,
			'whereClause' => 'article_id = '.$_POST['a_i'],
			'desWidth' => 784,
			'desHeight' => 431
		]), ['arrayId' => 'article-tall-image-upload-form']);
    	echo json_encode($updateStatus) ;

	}
}
?>     