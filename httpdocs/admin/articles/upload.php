<?php

$admin = true;

require_once('../../assets/php/config.php');

$ds = DIRECTORY_SEPARATOR;  //1
$storeFolder = 'uploads';   //2

$user_id = 0;
if(isset($_POST['u_i'])) $user_id = $_POST['u_i'];

$action = "edit";
$isLib =  isset($_POST['isLib']) ? true : false;
$is_second_img = isset($_POST['is_second_img']) ? true : false;

if(isset($_POST) && empty($_POST['a_i'] ) ){
	$_POST['a_i'] = 'temp_u_'.$user_id.'_'. substr($_POST['c_t'], 0, 7);
	$action = "new";
}

var_dump($_FILES); die;

if($action === "new"){
	if($isLib){
		$updateStatus = array_merge($mpArticleAdmin->uploadTempImageFromLib([
			'allowedExtensions' => 'png,jpg,jpeg,gif',
			'imgType' => 'article',
			'uploadDirectory' => $config['image_upload_dir'].'articlesites/puckermob/temp/',
			'libraryDirectory' => $config['image_path_admin'].'articles/',
			'articleId' => $_POST['a_i'],
			'imgName' => $_POST['image'],
			'desWidth' => 784,
			'desHeight' => 431
		], false), ['arrayId' => 'article-tall-image-upload-form']);
		echo json_encode($updateStatus) ;
	}else{
	if (!empty($_FILES)) { 
	    $updateStatus = array_merge($mpArticleAdmin->uploadTempImage($_FILES, [
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
	}
}else{

	if($isLib){
		$updateStatus = array_merge($mpArticleAdmin->uploadTempImageFromLib([
			'allowedExtensions' => 'png,jpg,jpeg,gif',
			'imgType' => 'article',
			'uploadDirectory' => $config['image_upload_dir'].'articlesites/puckermob/large/',
			'libraryDirectory' => $config['image_path_admin'].'articles/',
			'articleId' => $_POST['a_i'],
			'imgName' => $_POST['image'],
			'desWidth' => 784,
			'desHeight' => 431
		], true), ['arrayId' => 'article-tall-image-upload-form']);
		echo json_encode($updateStatus) ;
	}elseif($is_second_img){
		if (!empty($_FILES)) { 
			$updateStatus = array_merge($mpArticleAdmin->uploadBasicImage($_FILES, [
				'allowedExtensions' => 'png,jpg,jpeg,gif',
				'uploadDirectory' => $config['image_upload_dir'].'articlesites/puckermob/second_image/',
				'articleId' => $_POST['a_i'],
				'imgData' => $_POST,
				'desWidth' => 300,
				'desHeight' => 250
			]), ['arrayId' => 'second-article-image']);
		}
	}else{
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
		}
	}
}
?>     